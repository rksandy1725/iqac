<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackSurvey;
use App\Models\FeedbackResponse;
use App\Models\Criterion;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = FeedbackSurvey::withCount('responses');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('target_group')) {
            $query->where('target_group', $request->target_group);
        }

        $surveys = $query->latest()->paginate(15)->withQueryString();
        $totalResponses = FeedbackResponse::count();

        return view('feedback.index', compact('surveys', 'totalResponses'));
    }

    public function create()
    {
        $criteria = Criterion::orderBy('criterion_number')->get();
        return view('feedback.create', compact('criteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_group' => 'required|in:student,parent,employer,alumni,faculty',
            'criterion_id' => 'nullable|exists:criteria,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['status'] = 'active';
        FeedbackSurvey::create($validated);

        return redirect()->route('feedback.index')->with('success', 'Feedback survey created successfully.');
    }

    public function show(FeedbackSurvey $survey)
    {
        $survey->loadCount('responses');
        $survey->load(['criterion', 'responses' => function($q) {
            $q->latest();
        }]);

        $avgRating = $survey->responses->where('rating', '>', 0)->avg('rating');
        $ratingDistribution = $survey->responses->pluck('rating')->filter()->countBy()->toArray();
        ksort($ratingDistribution);

        return view('feedback.show', compact('survey', 'avgRating', 'ratingDistribution'));
    }

    public function edit(FeedbackSurvey $survey)
    {
        $criteria = Criterion::orderBy('criterion_number')->get();
        return view('feedback.edit', compact('survey', 'criteria'));
    }

    public function update(Request $request, FeedbackSurvey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_group' => 'required|in:student,parent,employer,alumni,faculty',
            'criterion_id' => 'nullable|exists:criteria,id',
            'status' => 'required|in:draft,active,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $survey->update($validated);

        return redirect()->route('feedback.show', $survey)->with('success', 'Survey updated successfully.');
    }

    public function destroy(FeedbackSurvey $survey)
    {
        $survey->delete();
        return redirect()->route('feedback.index')->with('success', 'Survey deleted successfully.');
    }

    public function respond(FeedbackSurvey $survey)
    {
        if ($survey->status !== 'active') {
            return redirect()->back()->with('error', 'This survey is not currently accepting responses.');
        }
        return view('feedback.respond', compact('survey'));
    }

    public function submitResponse(Request $request, FeedbackSurvey $survey)
    {
        $validated = $request->validate([
            'respondent_name' => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
            'answers' => 'nullable|array',
        ]);

        $survey->responses()->create($validated);

        return redirect()->route('feedback.thankyou')->with('survey_id', $survey->id);
    }

    public function thankyou()
    {
        return view('feedback.thankyou');
    }

    public function exportResponses(FeedbackSurvey $survey)
    {
        $responses = $survey->responses()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback_' . $survey->id . '_responses.csv"',
        ];

        $callback = function() use ($responses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Rating', 'Comments', 'Date']);

            foreach ($responses as $response) {
                fputcsv($file, [
                    $response->respondent_name ?? 'Anonymous',
                    $response->respondent_email ?? '',
                    $response->rating ?? '',
                    $response->comments ?? '',
                    $response->created_at->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
