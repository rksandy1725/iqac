<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('activities.index') }}" class="text-decoration-none">Activities</a></li>
                <li class="breadcrumb-item active">{{ $activity->title }}</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="section-title mb-0">{{ $activity->title }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
                        <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Description</small>
                            <p class="text-dark mb-0">{{ $activity->description ?? 'No description' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Academic Year</small>
                            <p class="fw-semibold text-dark mb-0">{{ $activity->academic_year }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Status</small>
                            @php
                                $statusConfig = match($activity->status) {
                                    'completed' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Completed'],
                                    'in_progress' => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'In Progress'],
                                    default => ['class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle', 'label' => 'Planned'],
                                };
                            @endphp
                            <p class="mb-0"><span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span></p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Start Date</small>
                            <p class="text-dark mb-0">{{ $activity->start_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">End Date</small>
                            <p class="text-dark mb-0">{{ $activity->end_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Created By</small>
                            <p class="text-dark mb-0">{{ $activity->creator->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Department</small>
                            <p class="text-dark mb-0">{{ $activity->department->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="section-title mb-0"><i class="bi bi-paperclip me-2 text-primary"></i>Documents ({{ $activity->documents->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    @if($activity->documents->isEmpty())
                        <div class="text-center py-4 text-muted">No documents uploaded</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($activity->documents as $doc)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-file-earmark text-primary" style="font-size:1.2rem;"></i>
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size:0.9rem;">{{ $doc->title }}</div>
                                            <small class="text-muted">{{ $doc->file_type }} - {{ $doc->created_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-success py-0"><i class="bi bi-download"></i></a>
                                        <form action="{{ route('activities.document.destroy', $doc) }}" method="POST" onsubmit="return confirm('Delete?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-link-45deg me-2 text-primary"></i>NAAC Mapping</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Criterion</small>
                        <p class="fw-semibold text-dark mb-0">{{ $activity->criterion->name ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Key Indicator</small>
                        <p class="text-dark mb-0">{{ $activity->keyIndicator?->ki_name ?? '-' }}</p>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Metric</small>
                        <p class="text-dark mb-0">{{ $activity->metric?->metric_name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
