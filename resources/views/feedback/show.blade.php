<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('feedback.index') }}" class="text-decoration-none">Feedback</a></li>
                <li class="breadcrumb-item active">{{ $survey->title }}</li>
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
                    <h6 class="section-title mb-0">{{ $survey->title }}</h6>
                    <div class="d-flex gap-2">
                        @php
                            $statusConfig = match($survey->status) {
                                'active' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Active'],
                                'closed' => ['class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle', 'label' => 'Closed'],
                                default => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'Draft'],
                            };
                        @endphp
                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                        @if($survey->responses_count > 0)
                            <a href="{{ route('feedback.export', $survey) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-download me-1"></i>Export CSV</a>
                        @endif
                        <a href="{{ route('feedback.edit', $survey) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($survey->description)
                        <p class="text-muted mb-4">{{ $survey->description }}</p>
                    @endif

                    <div class="row g-4">
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Target Group</small>
                            <p class="fw-semibold text-dark mb-0">{{ ucfirst($survey->target_group) }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Criteria</small>
                            <p class="text-dark mb-0">{{ $survey->criterion->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Responses</small>
                            <p class="fw-bold text-dark mb-0" style="font-size:1.3rem;">{{ $survey->responses_count }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($survey->responses_count > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-bar-chart me-2 text-primary"></i>Rating Distribution</h6>
                    </div>
                    <div class="card-body">
                        @for($i = 5; $i >= 1; $i--)
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="text-muted" style="width:20px;font-size:0.85rem;">{{ $i }}<i class="bi bi-star-fill text-warning ms-1" style="font-size:0.7rem;"></i></span>
                                <div class="progress flex-grow-1" style="height:8px;border-radius:10px;">
                                    <div class="progress-bar bg-warning" style="width:{{ $survey->responses_count > 0 ? (($ratingDistribution[$i] ?? 0) / $survey->responses_count * 100) : 0 }}%;border-radius:10px;"></div>
                                </div>
                                <span class="text-muted" style="width:30px;font-size:0.82rem;">{{ $ratingDistribution[$i] ?? 0 }}</span>
                            </div>
                        @endfor
                        <div class="mt-3 pt-3" style="border-top:1px solid #f1f5f9;">
                            <small class="text-muted">Average Rating: </small>
                            <span class="fw-bold text-dark">{{ number_format($avgRating, 1) }} / 5.0</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-chat-left-text me-2 text-primary"></i>Recent Responses</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($survey->responses->take(10) as $response)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size:0.9rem;">{{ $response->respondent_name ?? 'Anonymous' }}</div>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $response->rating ? '-fill text-warning' : ' text-muted' }}" style="font-size:0.75rem;"></i>
                                                @endfor
                                                <small class="text-muted">{{ $response->created_at->format('d M Y') }}</small>
                                            </div>
                                            @if($response->comments)
                                                <p class="text-muted mt-2 mb-0" style="font-size:0.88rem;">{{ $response->comments }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center py-4">
                    <i class="bi bi-link-45deg text-primary" style="font-size:2rem;"></i>
                    <h6 class="fw-bold mt-2 mb-1">Share Survey</h6>
                    <p class="text-muted" style="font-size:0.82rem;">Send this link to collect feedback</p>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="surveyLink" value="{{ url('/iqac/survey/' . $survey->id . '/respond') }}" readonly>
                        <button class="btn btn-sm btn-primary" onclick="document.getElementById('surveyLink').select(); document.execCommand('copy');"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="section-title mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Quick Stats</h6>
                    <div class="mb-2 d-flex justify-content-between">
                        <small class="text-muted">Total Responses</small>
                        <span class="fw-semibold">{{ $survey->responses_count }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <small class="text-muted">Average Rating</small>
                        <span class="fw-semibold">{{ number_format($avgRating, 1) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Status</small>
                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
