<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\Criterion;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['activity', 'criterion', 'uploader']);

        if ($request->filled('criterion_id')) {
            $query->where('criterion_id', $request->criterion_id);
        }
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents = $query->latest()->paginate(20)->withQueryString();
        $criteria = Criterion::orderBy('criterion_number')->get();
        $documentTypes = Document::distinct()->pluck('document_type')->filter();

        return view('documents.index', compact('documents', 'criteria', 'documentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:10240',
            'criterion_id' => 'nullable|exists:criteria,id',
            'document_type' => 'nullable|string|max:100',
            'activity_id' => 'nullable|exists:activities,id',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        $document = Document::create([
            ...$validated,
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function download(Document $document)
    {
        return Storage::disk('public')->download($document->file_path, $document->title);
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return redirect()->back()->with('success', 'Document deleted successfully.');
    }
}
