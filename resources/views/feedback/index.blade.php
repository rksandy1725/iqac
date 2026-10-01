<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Feedback Surveys</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Manage stakeholder feedback collection and analysis</p>
        </div>
        <a href="{{ route('feedback.create') }}" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-plus-circle me-1"></i>Create Survey
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#3b82f6;">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Total Surveys</div>
                        <div class="fw-bold" style="font-size:1.4rem;">{{ $surveys->total() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);color:#16a34a;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Total Responses</div>
                        <div class="fw-bold" style="font-size:1.4rem;">{{ $totalResponses }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#fffbeb,#fef3c7);color:#d97706;">
                        <i class="bi bi-play-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Active</div>
                        <div class="fw-bold" style="font-size:1.4rem;">{{ $surveys->where('status', 'active')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($surveys->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-chat-dots text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">No feedback surveys found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th style="font-size:0.8rem;padding:12px 16px;">Title</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Target Group</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Criteria</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Status</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Responses</th>
                                <th style="font-size:0.8rem;padding:12px 16px;text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surveys as $survey)
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <a href="{{ route('feedback.show', $survey) }}" class="text-decoration-none fw-semibold text-dark">{{ $survey->title }}</a>
                                    </td>
                                    <td style="padding:12px 16px;">
                                        <span class="badge bg-light text-dark">{{ ucfirst($survey->target_group) }}</span>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $survey->criterion->name ?? '-' }}</td>
                                    <td style="padding:12px 16px;">
                                        @php
                                            $statusConfig = match($survey->status) {
                                                'active' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Active'],
                                                'closed' => ['class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle', 'label' => 'Closed'],
                                                default => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'Draft'],
                                            };
                                        @endphp
                                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                                    </td>
                                    <td style="padding:12px 16px;"><span class="badge bg-light text-dark">{{ $survey->responses_count }}</span></td>
                                    <td style="padding:12px 16px;text-align:right;">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('feedback.show', $survey) }}" class="btn btn-sm btn-outline-primary py-0"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('feedback.edit', $survey) }}" class="btn btn-sm btn-outline-secondary py-0"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('feedback.destroy', $survey) }}" method="POST" onsubmit="return confirm('Delete?')">
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
        @if($surveys->hasPages())
            <div class="card-footer bg-white">{{ $surveys->links() }}</div>
        @endif
    </div>
</x-app-layout>
