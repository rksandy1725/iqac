<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('aqar.index') }}" class="text-decoration-none">AQAR Reports</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Edit AQAR {{ $report->academic_year }}</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-list-check me-2 text-primary"></i>Criteria Progress (Auto-generated from activities)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th style="font-size:0.8rem;padding:12px 16px;">#</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Criterion</th>
                                    <th style="font-size:0.8rem;padding:12px 16px;">Total</th>
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
                                        <td style="padding:12px 16px;">{{ $c->criterion_number }}</td>
                                        <td style="padding:12px 16px;" class="fw-semibold">{{ $c->name }}</td>
                                        <td style="padding:12px 16px;">{{ $c->total_activities }}</td>
                                        <td style="padding:12px 16px;">{{ $c->completed_activities }}</td>
                                        <td style="padding:12px 16px;width:200px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height:8px;border-radius:10px;">
                                                    <div class="progress-bar" style="width:{{ $pct }}%;border-radius:10px;background:{{ $pct >= 80 ? '#22c55e' : ($pct >= 50 ? '#f59e0b' : '#ef4444') }};"></div>
                                                </div>
                                                <small class="text-muted">{{ $pct }}%</small>
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
            <div class="card">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-gear me-2 text-primary"></i>Update Report</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('aqar.update', $report) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft" {{ $report->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ $report->status == 'submitted' ? 'selected' : '' }}>Submitted to NAAC</option>
                                <option value="approved" {{ $report->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="4">{{ $report->remarks }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                            <i class="bi bi-check-circle me-1"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
