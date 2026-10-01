<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
use App\Models\Criterion;
use App\Models\KeyIndicator;
use App\Models\Metric;
use App\Models\Department;
use App\Models\Document;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['criterion', 'keyIndicator', 'metric', 'department', 'creator', 'documents']);

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('criterion_id')) {
            $query->where('criterion_id', $request->criterion_id);
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $activities = $query->latest()->paginate(15)->withQueryString();
        $criteria = Criterion::orderBy('criterion_number')->get();
        $departments = Department::orderBy('name')->get();
        $academicYears = Activity::distinct()->pluck('academic_year')->filter()->sortDesc();

        return view('activities.index', compact('activities', 'criteria', 'departments', 'academicYears'));
    }

    public function create()
    {
        $criteria = Criterion::orderBy('criterion_number')->get();
        $departments = Department::orderBy('name')->get();

        return view('activities.create', compact('criteria', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'criterion_id' => 'required|exists:criteria,id',
            'key_indicator_id' => 'nullable|exists:key_indicators,id',
            'metric_id' => 'nullable|exists:metrics,id',
            'department_id' => 'nullable|exists:departments,id',
            'academic_year' => 'required|string|max:20',
            'status' => 'required|in:planned,in_progress,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['created_by'] = auth()->id();
        $activity = Activity::create($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('activities/' . $activity->id, 'public');
                Document::create([
                    'activity_id' => $activity->id,
                    'criterion_id' => $activity->criterion_id,
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('activities.show', $activity)->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity)
    {
        $activity->load(['criterion', 'keyIndicator', 'metric', 'department', 'creator', 'documents.uploader']);
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $criteria = Criterion::orderBy('criterion_number')->get();
        $departments = Department::orderBy('name')->get();
        $keyIndicators = KeyIndicator::where('criterion_id', $activity->criterion_id)->get();
        $metrics = Metric::whereIn('key_indicator_id', $keyIndicators->pluck('id'))->get();

        return view('activities.edit', compact('activity', 'criteria', 'departments', 'keyIndicators', 'metrics'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'criterion_id' => 'required|exists:criteria,id',
            'key_indicator_id' => 'nullable|exists:key_indicators,id',
            'metric_id' => 'nullable|exists:metrics,id',
            'department_id' => 'nullable|exists:departments,id',
            'academic_year' => 'required|string|max:20',
            'status' => 'required|in:planned,in_progress,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $activity->update($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('activities/' . $activity->id, 'public');
                Document::create([
                    'activity_id' => $activity->id,
                    'criterion_id' => $activity->criterion_id,
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('activities.show', $activity)->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        foreach ($activity->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }

    public function destroyDocument(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $activity = $document->activity;
        $document->delete();
        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function getKeyIndicators($criterionId)
    {
        $keyIndicators = KeyIndicator::where('criterion_id', $criterionId)->get();
        return response()->json($keyIndicators);
    }

    public function getMetrics($keyIndicatorId)
    {
        $metrics = Metric::where('key_indicator_id', $keyIndicatorId)->get();
        return response()->json($metrics);
    }
}
