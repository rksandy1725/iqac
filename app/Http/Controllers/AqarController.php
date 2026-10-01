<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AqarReport;
use App\Models\Activity;
use App\Models\Criterion;
use App\Models\Document;
use App\Models\Meeting;
use App\Models\FeedbackSurvey;
use App\Models\FeedbackResponse;
use App\Models\Department;
use App\Models\User;

class AqarController extends Controller
{
    public function index()
    {
        $reports = AqarReport::with('preparer')->latest()->paginate(15);
        $academicYears = Activity::distinct()->pluck('academic_year')->filter()->sortDesc();

        return view('aqar.index', compact('reports', 'academicYears'));
    }

    public function create()
    {
        $academicYears = Activity::distinct()->pluck('academic_year')->filter()->sortDesc();
        return view('aqar.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:20',
            'remarks' => 'nullable|string',
        ]);

        $validated['prepared_by'] = auth()->id();
        $validated['status'] = 'draft';

        $report = AqarReport::create($validated);

        return redirect()->route('aqar.edit', $report)->with('success', 'AQAR report created. Start adding data.');
    }

    private function getCriteriaWithCounts(string $academicYear)
    {
        $criteria = Criterion::orderBy('criterion_number')->get();
        foreach ($criteria as $criterion) {
            $criterion->total_activities = Activity::where('criterion_id', $criterion->id)
                ->where('academic_year', $academicYear)->count();
            $criterion->completed_activities = Activity::where('criterion_id', $criterion->id)
                ->where('academic_year', $academicYear)->where('status', 'completed')->count();
        }
        return $criteria;
    }

    public function edit(AqarReport $report)
    {
        $academicYear = $report->academic_year;
        $report->load('preparer');

        $data = $this->generateAqarData($academicYear);
        $report->update(['json_data' => $data]);

        $criteria = $this->getCriteriaWithCounts($academicYear);

        return view('aqar.edit', compact('report', 'data', 'criteria', 'academicYear'));
    }

    public function update(Request $request, AqarReport $report)
    {
        $validated = $request->validate([
            'remarks' => 'nullable|string',
            'status' => 'required|in:draft,submitted,approved',
        ]);

        $report->update($validated);

        if ($validated['status'] === 'submitted') {
            $report->update(['submitted_to_naac_on' => now()]);
        }

        return redirect()->route('aqar.show', $report)->with('success', 'AQAR report updated successfully.');
    }

    public function show(AqarReport $report)
    {
        $report->load('preparer');
        $academicYear = $report->academic_year;

        $data = $report->json_data ?? $this->generateAqarData($academicYear);
        $criteria = $this->getCriteriaWithCounts($academicYear);

        return view('aqar.show', compact('report', 'data', 'criteria', 'academicYear'));
    }

    public function destroy(AqarReport $report)
    {
        $report->delete();
        return redirect()->route('aqar.index')->with('success', 'AQAR report deleted.');
    }

    public function generatePdf(AqarReport $report)
    {
        $report->load('preparer');
        $academicYear = $report->academic_year;
        $data = $report->json_data ?? $this->generateAqarData($academicYear);

        $criteria = $this->getCriteriaWithCounts($academicYear);

        $institutionName = config('app.name', 'IQAC Management');
        $view = view('aqar.pdf', compact('report', 'data', 'criteria', 'academicYear', 'institutionName'));
        $html = $view->render();

        $pdf = Pdf::loadHtml($html)->setPaper('a4', 'portrait');
        $filename = 'AQAR_' . str_replace('/', '-', $academicYear) . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    private function generateAqarData(string $academicYear): array
    {
        $totalActivities = Activity::where('academic_year', $academicYear)->count();
        $completedActivities = Activity::where('academic_year', $academicYear)->where('status', 'completed')->count();
        $totalDepartments = Department::count();
        $totalUsers = User::count();
        $totalDocuments = Document::count();
        $totalMeetings = Meeting::whereYear('meeting_date', substr($academicYear, 0, 4))->count();
        $completedMeetings = Meeting::whereYear('meeting_date', substr($academicYear, 0, 4))->where('status', 'completed')->count();
        $totalSurveys = FeedbackSurvey::count();
        $totalResponses = $this->getTotalResponses($academicYear);

        $criteriaData = [];
        $criteria = Criterion::withCount('keyIndicators')->orderBy('criterion_number')->get();
        foreach ($criteria as $c) {
            $criteriaData[$c->criterion_number] = [
                'name' => $c->name,
                'key_indicators' => $c->key_indicators_count,
                'total_activities' => Activity::where('criterion_id', $c->id)->where('academic_year', $academicYear)->count(),
                'completed_activities' => Activity::where('criterion_id', $c->id)->where('academic_year', $academicYear)->where('status', 'completed')->count(),
            ];
        }

        return [
            'academic_year' => $academicYear,
            'generated_on' => now()->format('d-m-Y H:i:s'),
            'institution' => [
                'name' => config('app.name', 'IQAC Management'),
                'iqac_established' => '2005-01-01',
            ],
            'summary' => [
                'total_activities' => $totalActivities,
                'completed_activities' => $completedActivities,
                'completion_rate' => $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100, 1) : 0,
                'total_departments' => $totalDepartments,
                'total_faculty' => $totalUsers,
                'total_documents' => $totalDocuments,
                'meetings_conducted' => $completedMeetings,
                'meetings_total' => $totalMeetings,
                'feedback_surveys' => $totalSurveys,
                'feedback_responses' => $totalResponses,
            ],
            'criteria' => $criteriaData,
            'quality_indicators' => [
                'academic_excellence' => $this->calculateIndicatorScore($academicYear, [1, 2]),
                'research_innovation' => $this->calculateIndicatorScore($academicYear, [3]),
                'infrastructure' => $this->calculateIndicatorScore($academicYear, [4]),
                'student_support' => $this->calculateIndicatorScore($academicYear, [5]),
                'governance' => $this->calculateIndicatorScore($academicYear, [6]),
                'values_practices' => $this->calculateIndicatorScore($academicYear, [7]),
            ],
        ];
    }

    private function calculateIndicatorScore(string $academicYear, array $criterionNumbers): float
    {
        $total = Activity::whereHas('criterion', fn($q) => $q->whereIn('criterion_number', $criterionNumbers))
            ->where('academic_year', $academicYear)->count();

        $completed = Activity::whereHas('criterion', fn($q) => $q->whereIn('criterion_number', $criterionNumbers))
            ->where('academic_year', $academicYear)->where('status', 'completed')->count();

        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }

    private function getTotalResponses(string $academicYear): int
    {
        return FeedbackResponse::whereHas('survey', function($q) use ($academicYear) {
            $q->where('status', 'active');
        })->count();
    }
}
