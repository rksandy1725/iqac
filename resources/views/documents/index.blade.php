<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Document Repository</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Manage and organize quality-related documents</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-cloud-upload me-1"></i>Upload Document
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('documents.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Criteria</label>
                    <select class="form-select form-select-sm" name="criterion_id">
                        <option value="">All Criteria</option>
                        @foreach($criteria as $c)
                            <option value="{{ $c->id }}" {{ request('criterion_id') == $c->id ? 'selected' : '' }}>{{ $c->criterion_number }}. {{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Search</label>
                    <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Search documents...">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
                    <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($documents->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-folder text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">No documents found.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($documents as $doc)
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $iconClass = match(true) {
                                        str_contains($doc->file_type ?? '', 'pdf') => 'bi-file-earmark-pdf text-danger',
                                        str_contains($doc->file_type ?? '', 'image') => 'bi-file-earmark-image text-success',
                                        str_contains($doc->file_type ?? '', 'word') || str_contains($doc->file_type ?? '', 'document') => 'bi-file-earmark-word text-primary',
                                        default => 'bi-file-earmark text-secondary',
                                    };
                                @endphp
                                <i class="bi {{ $iconClass }}" style="font-size:1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size:0.92rem;">{{ $doc->title }}</div>
                                    <small class="text-muted">
                                        {{ $doc->criterion->name ?? 'Uncategorized' }}
                                        @if($doc->activity) - {{ $doc->activity->title }} @endif
                                        <span class="mx-1">|</span>{{ $doc->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-download"></i></a>
                                <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @if($documents->hasPages())
            <div class="card-footer bg-white">{{ $documents->links() }}</div>
        @endif
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:12px;border:none;">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom-0">
                        <h6 class="modal-title fw-bold">Upload Document</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Title *</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">File *</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Criteria</label>
                            <select class="form-select" name="criterion_id">
                                <option value="">None</option>
                                @foreach($criteria as $c)
                                    <option value="{{ $c->id }}">{{ $c->criterion_number }}. {{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Document Type</label>
                            <input type="text" class="form-control" name="document_type" placeholder="e.g. Policy, Report, Minutes">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
