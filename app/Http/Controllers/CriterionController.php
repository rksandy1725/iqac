<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Criterion;
use App\Models\KeyIndicator;
use App\Models\Metric;
use App\Models\Activity;
use App\Models\Document;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = Criterion::with(['keyIndicators.activities', 'keyIndicators.metrics'])
            ->withCount('activities')
            ->get();

        foreach ($criteria as $criterion) {
            $criterion->completed_activities = $criterion->activities()->where('status', 'completed')->count();
            $criterion->completion_percentage = $criterion->activities_count > 0
                ? round(($criterion->completed_activities / $criterion->activities_count) * 100)
                : 0;
        }

        return view('criteria.index', compact('criteria'));
    }

    public function show(Criterion $criterion)
    {
        $criterion->load(['keyIndicators.metrics.documents', 'activities.department', 'activities' => function($q) {
            $q->withCount('documents');
        }]);

        $keyIndicators = $criterion->keyIndicators;

        $activitiesByKI = $criterion->activities->groupBy('key_indicator_id');

        return view('criteria.show', compact('criterion', 'keyIndicators', 'activitiesByKI'));
    }

    public function storeKeyIndicator(Request $request, Criterion $criterion)
    {
        $validated = $request->validate([
            'ki_code' => 'required|string|max:10',
            'ki_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $criterion->keyIndicators()->create($validated);

        return redirect()->back()->with('success', 'Key Indicator added successfully.');
    }

    public function updateKeyIndicator(Request $request, Criterion $criterion, KeyIndicator $keyIndicator)
    {
        $validated = $request->validate([
            'ki_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $keyIndicator->update($validated);

        return redirect()->back()->with('success', 'Key Indicator updated successfully.');
    }

    public function destroyKeyIndicator(Criterion $criterion, KeyIndicator $keyIndicator)
    {
        $keyIndicator->delete();
        return redirect()->back()->with('success', 'Key Indicator deleted successfully.');
    }

    public function storeMetric(Request $request, Criterion $criterion, KeyIndicator $keyIndicator)
    {
        $validated = $request->validate([
            'metric_code' => 'required|string|max:10',
            'metric_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'data_template_type' => 'nullable|string|max:100',
        ]);

        $keyIndicator->metrics()->create($validated);

        return redirect()->back()->with('success', 'Metric added successfully.');
    }

    public function updateMetric(Request $request, Criterion $criterion, KeyIndicator $keyIndicator, Metric $metric)
    {
        $validated = $request->validate([
            'metric_code' => 'required|string|max:10',
            'metric_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'data_template_type' => 'nullable|string|max:100',
        ]);

        $metric->update($validated);

        return redirect()->back()->with('success', 'Metric updated successfully.');
    }

    public function storeMetricDocument(Request $request, Criterion $criterion, KeyIndicator $keyIndicator, Metric $metric)
    {
        $request->validate([
            'document' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
            'link_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('metrics/' . $metric->id, 'public');
            Document::create([
                'metric_id' => $metric->id,
                'criterion_id' => $criterion->id,
                'title' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'uploaded_by' => auth()->id(),
            ]);
        }

        if ($request->filled('link_url')) {
            Document::create([
                'metric_id' => $metric->id,
                'criterion_id' => $criterion->id,
                'title' => $request->link_url,
                'file_path' => '',
                'link_url' => $request->link_url,
                'document_type' => 'link',
                'uploaded_by' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Document/Link added successfully.');
    }

    public function destroyMetricDocument(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function destroyMetric(Criterion $criterion, KeyIndicator $keyIndicator, Metric $metric)
    {
        $metric->delete();
        return redirect()->back()->with('success', 'Metric deleted successfully.');
    }
}
