<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('criteria.index') }}" class="text-decoration-none">NAAC Criteria</a></li>
                <li class="breadcrumb-item active">Criterion {{ $criterion->criterion_number }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark mb-1">{{ $criterion->name }}</h4>
                <p class="text-muted mb-0" style="font-size:0.9rem;">Criterion {{ $criterion->criterion_number }} - {{ $criterion->keyIndicators->count() }} Key Indicators</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            @forelse($keyIndicators as $ki)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="section-title mb-0"><span class="badge bg-primary me-2">{{ $ki->ki_code }}</span>{{ $ki->ki_name }}</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editKI{{ $ki->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('criteria.key-indicator.destroy', [$criterion, $ki]) }}" method="POST" onsubmit="return confirm('Delete this Key Indicator and all its metrics?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($ki->description)
                            <p class="text-muted mb-3" style="font-size:0.88rem;">{{ $ki->description }}</p>
                        @endif

                        @if($ki->metrics->isNotEmpty())
                            <h6 class="text-muted mb-2" style="font-size:0.82rem;text-transform:uppercase;letter-spacing:0.5px;">Metrics</h6>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr style="background:#f8fafc;">
                                            <th style="font-size:0.8rem;border-top:none;">Code</th>
                                            <th style="font-size:0.8rem;border-top:none;">Name</th>
                                            <th style="font-size:0.8rem;border-top:none;">Template</th>
                                            <th style="font-size:0.8rem;border-top:none;width:100px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ki->metrics as $metric)
                                            <tr>
                                                <td style="font-size:0.85rem;"><code>{{ $metric->metric_code }}</code></td>
                                                <td style="font-size:0.85rem;">{{ $metric->metric_name }}</td>
                                                <td style="font-size:0.85rem;">{{ $metric->data_template_type ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button class="btn btn-sm btn-outline-info py-0 px-1" data-bs-toggle="modal" data-bs-target="#viewMetric{{ $metric->id }}" title="View"><i class="bi bi-eye"></i></button>
                                                        <button class="btn btn-sm btn-outline-primary py-0 px-1" data-bs-toggle="modal" data-bs-target="#editMetric{{ $metric->id }}" title="Edit"><i class="bi bi-pencil"></i></button>
                                                        <form action="{{ route('criteria.metric.destroy', [$criterion, $ki, $metric]) }}" method="POST" onsubmit="return confirm('Delete?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0" style="font-size:0.88rem;">No metrics added yet.</p>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top">
                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addMetric{{ $ki->id }}">
                            <i class="bi bi-plus-circle me-1"></i>Add Metric
                        </button>
                    </div>
                </div>

                <!-- Edit KI Modal -->
                <div class="modal fade" id="editKI{{ $ki->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius:12px;border:none;">
                            <form action="{{ route('criteria.key-indicator.update', [$criterion, $ki]) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header border-bottom-0">
                                    <h6 class="modal-title fw-bold">Edit Key Indicator</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Name</label>
                                        <input type="text" class="form-control" name="ki_name" value="{{ $ki->ki_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ $ki->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Metric Modal -->
                <div class="modal fade" id="addMetric{{ $ki->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius:12px;border:none;">
                            <form action="{{ route('criteria.metric.store', [$criterion, $ki]) }}" method="POST">
                                @csrf
                                <div class="modal-header border-bottom-0">
                                    <h6 class="modal-title fw-bold">Add Metric</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-semibold">Code</label>
                                            <input type="text" class="form-control" name="metric_code" placeholder="e.g. 1.1.1" required>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label small fw-semibold">Name</label>
                                            <input type="text" class="form-control" name="metric_name" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-semibold">Description</label>
                                            <textarea class="form-control" name="description" rows="2"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-semibold">Data Template Type</label>
                                            <input type="text" class="form-control" name="data_template_type" placeholder="e.g. Quantitative / Qualitative">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-success">Add Metric</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @foreach($ki->metrics as $metric)
                    <!-- View Metric Modal -->
                    <div class="modal fade" id="viewMetric{{ $metric->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="border-radius:12px;border:none;">
                                <div class="modal-header border-bottom-0">
                                    <h6 class="modal-title fw-bold"><i class="bi bi-eye me-2"></i>Metric Details</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Metric Code</small>
                                            <div class="fw-bold">{{ $metric->metric_code }}</div>
                                        </div>
                                        <div class="col-md-8">
                                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Metric Name</small>
                                            <div class="fw-bold">{{ $metric->metric_name }}</div>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Description</small>
                                            <div class="text-dark">{{ $metric->description ?? 'No description provided.' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Data Template Type</small>
                                            <div class="fw-bold">{{ $metric->data_template_type ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Total Documents</small>
                                            <div class="fw-bold">{{ $metric->documents->count() }}</div>
                                        </div>
                                    </div>

                                    @if($metric->documents->isNotEmpty())
                                        <h6 class="text-muted mb-2" style="font-size:0.82rem;text-transform:uppercase;letter-spacing:0.5px;">Uploaded Documents & Links</h6>
                                        <div class="list-group list-group-flush">
                                            @foreach($metric->documents as $doc)
                                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                    <div class="d-flex align-items-center">
                                                        @if($doc->document_type === 'link')
                                                            <i class="bi bi-link-45deg text-primary me-2"></i>
                                                            <div>
                                                                <a href="{{ $doc->link_url }}" target="_blank" class="text-decoration-none fw-semibold" style="font-size:0.88rem;">{{ $doc->link_url }}</a>
                                                                <br><small class="text-muted">Link</small>
                                                            </div>
                                                        @else
                                                            <i class="bi bi-file-earmark text-success me-2"></i>
                                                            <div>
                                                                <a href="{{ route('documents.download', $doc) }}" class="text-decoration-none fw-semibold" style="font-size:0.88rem;">{{ $doc->title }}</a>
                                                                <br><small class="text-muted">{{ $doc->file_type }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0" style="font-size:0.88rem;">No documents or links uploaded yet.</p>
                                    @endif
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editMetric{{ $metric->id }}"><i class="bi bi-pencil me-1"></i>Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Metric Modal -->
                    <div class="modal fade" id="editMetric{{ $metric->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="border-radius:12px;border:none;">
                                <form action="{{ route('criteria.metric.update', [$criterion, $ki, $metric]) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header border-bottom-0">
                                        <h6 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Edit Metric</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label small fw-semibold">Code</label>
                                                <input type="text" class="form-control" name="metric_code" value="{{ $metric->metric_code }}" required>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label small fw-semibold">Name</label>
                                                <input type="text" class="form-control" name="metric_name" value="{{ $metric->metric_name }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Description</label>
                                                <textarea class="form-control" name="description" rows="2">{{ $metric->description }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Data Template Type</label>
                                                <input type="text" class="form-control" name="data_template_type" value="{{ $metric->data_template_type }}" placeholder="e.g. Quantitative / Qualitative">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 px-0 pt-0">
                                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Update Metric</button>
                                        </div>
                                    </div>
                                </form>

                                <hr class="my-0">

                                <div class="modal-body">
                                    <h6 class="text-muted mb-3" style="font-size:0.82rem;text-transform:uppercase;letter-spacing:0.5px;">Upload Document</h6>
                                    <form action="{{ route('criteria.metric.document.store', [$criterion, $ki, $metric]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-8">
                                                <label class="form-label small fw-semibold">Choose File</label>
                                                <input type="file" class="form-control" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                <small class="text-muted">PDF, DOC, DOCX, JPG, PNG (Max 10MB)</small>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="submit" class="btn btn-sm btn-outline-success w-100"><i class="bi bi-upload me-1"></i>Upload</button>
                                            </div>
                                        </div>
                                    </form>

                                    <h6 class="text-muted mb-3 mt-3" style="font-size:0.82rem;text-transform:uppercase;letter-spacing:0.5px;">Add Link</h6>
                                    <form action="{{ route('criteria.metric.document.store', [$criterion, $ki, $metric]) }}" method="POST">
                                        @csrf
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-8">
                                                <label class="form-label small fw-semibold">URL</label>
                                                <input type="url" class="form-control" name="link_url" placeholder="https://example.com">
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="submit" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-link-45deg me-1"></i>Add Link</button>
                                            </div>
                                        </div>
                                    </form>

                                    @if($metric->documents->isNotEmpty())
                                        <hr>
                                        <h6 class="text-muted mb-2" style="font-size:0.82rem;text-transform:uppercase;letter-spacing:0.5px;">Existing Documents & Links</h6>
                                        <div class="list-group list-group-flush">
                                            @foreach($metric->documents as $doc)
                                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                    <div class="d-flex align-items-center">
                                                        @if($doc->document_type === 'link')
                                                            <i class="bi bi-link-45deg text-primary me-2"></i>
                                                            <a href="{{ $doc->link_url }}" target="_blank" class="text-decoration-none" style="font-size:0.85rem;">{{ Str::limit($doc->link_url, 50) }}</a>
                                                        @else
                                                            <i class="bi bi-file-earmark text-success me-2"></i>
                                                            <span style="font-size:0.85rem;">{{ $doc->title }}</span>
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('documents.metric.destroy', $doc) }}" method="POST" onsubmit="return confirm('Delete this document?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-list-check text-muted" style="font-size:2.5rem;"></i>
                        <p class="text-muted mt-3 mb-0">No key indicators defined for this criterion.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Criterion Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Criterion Number</small>
                        <div class="fw-bold text-dark">{{ $criterion->criterion_number }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Key Indicators</small>
                        <div class="fw-bold text-dark">{{ $criterion->keyIndicators->count() }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Total Metrics</small>
                        <div class="fw-bold text-dark">{{ $criterion->keyIndicators->sum(fn($ki) => $ki->metrics->count()) }}</div>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase" style="font-size:0.72rem;">Total Activities</small>
                        <div class="fw-bold text-dark">{{ $criterion->activities_count ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-plus-circle me-2 text-success"></i>Add Key Indicator</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('criteria.key-indicator.store', $criterion) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Code</label>
                            <input type="text" class="form-control" name="ki_code" placeholder="e.g. 1.1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Name</label>
                            <input type="text" class="form-control" name="ki_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success w-100"><i class="bi bi-plus-circle me-1"></i>Add Key Indicator</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
