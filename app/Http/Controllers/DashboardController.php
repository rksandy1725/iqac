<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Meeting;
use App\Models\Document;
use App\Models\Criterion;
use App\Models\Department;
use App\Models\FeedbackSurvey;
use App\Models\AqarReport;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $academicYear = request('year', now()->format('Y'));

        $totalActivities = Activity::where('academic_year', $academicYear)->count();
        $completedActivities = Activity::where('academic_year', $academicYear)->where('status', 'completed')->count();
        $inProgressActivities = Activity::where('academic_year', $academicYear)->where('status', 'in_progress')->count();
        $plannedActivities = Activity::where('academic_year', $academicYear)->where('status', 'planned')->count();

        $totalDocuments = Document::count();
        $totalDepartments = Department::count();
        $totalUsers = User::count();

        $upcomingMeetings = Meeting::where('meeting_date', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('meeting_date')
            ->limit(5)
            ->get();

        $recentActivities = Activity::with(['criterion', 'department'])
            ->where('academic_year', $academicYear)
            ->latest()
            ->limit(10)
            ->get();

        $criteriaProgress = Criterion::withCount('activities as total_activities')
            ->get()
            ->map(function ($criterion) {
                $criterion->completed_activities = $criterion->activities()->where('status', 'completed')->count();
                $criterion->completion_percentage = $criterion->total_activities > 0
                    ? round(($criterion->completed_activities / $criterion->total_activities) * 100)
                    : 0;
                return $criterion;
            });

        $activeSurveys = FeedbackSurvey::where('status', 'active')->count();
        $totalSurveys = FeedbackSurvey::count();
        $draftReports = AqarReport::where('status', 'draft')->count();

        return view('dashboard', compact(
            'totalActivities',
            'completedActivities',
            'inProgressActivities',
            'plannedActivities',
            'totalDocuments',
            'totalDepartments',
            'totalUsers',
            'upcomingMeetings',
            'recentActivities',
            'criteriaProgress',
            'activeSurveys',
            'totalSurveys',
            'draftReports',
            'academicYear'
        ));
    }
}
