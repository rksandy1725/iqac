<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('aqar.index') }}" class="text-decoration-none">AQAR Reports</a></li>
                <li class="breadcrumb-item active">{{ $report->academic_year }}</li>
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
                    <h6 class="section-title mb-0">AQAR {{ $report->academic_year }}</h6>
                    <div class="d-flex gap-2">
                        @php
                            $statusConfig = match($report->status) {
                                'submitted' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Submitted'],
                                'approved' => ['class' => 'bg-primary-subtle text-primary border border-primary-subtle', 'label' => 'Approved'],
                                default => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'Draft'],
                            };
                        @endphp
                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                        <a href="{{ route('aqar.pdf', $report) }}" class="btn btn-sm btn-success"><i class="bi bi-download me-1"></i>Download PDF</a>
                        <a href="{{ route('aqar.edit', $report) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Academic Year</small>
                            <p class="fw-semibold text-dark mb-0">{{ $report->academic_year }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Prepared By</small>
                            <p class="text-dark mb-0">{{ $report->preparer->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Submitted To NAAC</small>
                            <p class="text-dark mb-0">{{ $report->submitted_to_naac_on?->format('d M Y') ?? 'Not yet submitted' }}</p>
                        </div>
                    </div>

                    @if($report->remarks)
                        <div class="p-3 bg-light rounded mb-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Remarks</small>
                            <p class="text-dark mb-0">{{ $report->remarks }}</p>
                        </div>
                    @endif

                    <h6 class="section-title mb-3"><i class="bi bi-graph-up me-2 text-primary"></i>Summary Dashboard</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-primary" style="font-size:1.5rem;">{{ $data['summary']['total_activities'] }}</div>
                                <small class="text-muted">Total Activities</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-success" style="font-size:1.5rem;">{{ $data['summary']['completed_activities'] }}</div>
                                <small class="text-muted">Completed</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-info" style="font-size:1.5rem;">{{ $data['summary']['completion_rate'] }}%</div>
                                <small class="text-muted">Completion Rate</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-dark" style="font-size:1.5rem;">{{ $data['summary']['total_departments'] }}</div>
                                <small class="text-muted">Departments</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-dark" style="font-size:1.5rem;">{{ $data['summary']['total_faculty'] }}</div>
                                <small class="text-muted">Faculty</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-dark" style="font-size:1.5rem;">{{ $data['summary']['meetings_conducted'] }}</div>
                                <small class="text-muted">Meetings Held</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="fw-bold text-dark" style="font-size:1.5rem;">{{ $data['summary']['total_documents'] }}</div>
                                <small class="text-muted">Documents</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-list-check me-2 text-primary"></i>Criteria-wise Progress</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th style="font-size:0.8rem;padding:12px 16px;">#</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Criterion</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Key Indicators</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Total Activities</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Completed</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criteria as $c)
                                    @php
                                        $pct = $c->total_activities > 0 ? round(($c->completed_activities / $c->total_activities) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td style="padding:12px 16px;font-size:0.85rem;">{{ $c->criterion_number }}</td>
                                        <td style="padding:12px 16px;font-size:0.85rem;" class="fw-semibold">{{ $c->name }}</td>
                                        <td style="padding:12px 16px;font-size:0.85rem;">{{ $c->keyIndicators_count }}</td>
                                        <td style="padding:12px 16px;font-size:0.85rem;">{{ $c->total_activities }}</td>
                                        <td style="padding:12px 16px;font-size:0.85rem;">{{ $c->completed_activities }}</td>
                                        <td style="padding:12px 16px;width:150px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height:6px;border-radius:10px;">
                                                    <div class="progress-bar" style="width:{{ $pct }}%;border-radius:10px;background:{{ $pct >= 80 ? '#22c55e' : ($pct >= 50 ? '#f59e0b' : '#ef4444') }};"></div>
                                                </div>
                                                <small class="text-muted" style="font-size:0.75rem;">{{ $pct }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-gear me-2 text-primary"></i>Report Actions</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('aqar.update', $report) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Update Status</label>
                            <select class="form-select" name="status">
                                <option value="draft" {{ $report->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ $report->status == 'submitted' ? 'selected' : '' }}>Submitted to NAAC</option>
                                <option value="approved" {{ $report->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="3">{{ $report->remarks }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                            <i class="bi bi-check-circle me-1"></i>Update Report
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-download text-primary" style="font-size:2rem;"></i>
                    <h6 class="fw-bold mt-2 mb-1">Export Report</h6>
                    <p class="text-muted" style="font-size:0.82rem;">Download as PDF for NAAC submission</p>
                    <a href="{{ route('aqar.pdf', $report) }}" class="btn btn-success w-100" style="border-radius:8px;">
                        <i class="bi bi-file-pdf me-1"></i>Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
