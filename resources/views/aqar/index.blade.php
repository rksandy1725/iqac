<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">AQAR Reports</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Annual Quality Assurance Report management</p>
        </div>
        <a href="{{ route('aqar.create') }}" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-plus-circle me-1"></i>Create Report
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if($reports->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-bar-graph text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">No AQAR reports found.</p>
                    <a href="{{ route('aqar.create') }}" class="btn btn-sm btn-primary mt-3" style="border-radius:8px;">Create First Report</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th style="font-size:0.8rem;padding:12px 16px;">Academic Year</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Prepared By</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Status</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Submitted On</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Created</th>
                                <th style="font-size:0.8rem;padding:12px 16px;text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <a href="{{ route('aqar.show', $report) }}" class="text-decoration-none fw-semibold text-dark">{{ $report->academic_year }}</a>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $report->preparer->name ?? '-' }}</td>
                                    <td style="padding:12px 16px;">
                                        @php
                                            $statusConfig = match($report->status) {
                                                'submitted' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Submitted'],
                                                'approved' => ['class' => 'bg-primary-subtle text-primary border border-primary-subtle', 'label' => 'Approved'],
                                                default => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'Draft'],
                                            };
                                        @endphp
                                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $report->submitted_to_naac_on?->format('d M Y') ?? '-' }}</td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $report->created_at->format('d M Y') }}</td>
                                    <td style="padding:12px 16px;text-align:right;">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('aqar.show', $report) }}" class="btn btn-sm btn-outline-primary py-0"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('aqar.edit', $report) }}" class="btn btn-sm btn-outline-secondary py-0"><i class="bi bi-pencil"></i></a>
                                            <a href="{{ route('aqar.pdf', $report) }}" class="btn btn-sm btn-outline-success py-0"><i class="bi bi-download"></i></a>
                                            <form action="{{ route('aqar.destroy', $report) }}" method="POST" onsubmit="return confirm('Delete?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger py-0"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if($reports->hasPages())
            <div class="card-footer bg-white">{{ $reports->links() }}</div>
        @endif
    </div>
</x-app-layout>
