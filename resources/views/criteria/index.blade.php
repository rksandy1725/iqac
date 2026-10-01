<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">NAAC Criteria</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Track progress across all 7 NAAC accreditation criteria</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($criteria as $criterion)
            <div class="col-xl-4 col-md-6">
                <a href="{{ route('criteria.show', $criterion) }}" class="text-decoration-none">
                    <div class="card h-100" style="transition:all 0.3s ease;cursor:pointer;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="stat-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#3b82f6;width:44px;height:44px;border-radius:10px;font-size:1.1rem;">
                                    <span class="fw-bold">{{ $criterion->criterion_number }}</span>
                                </div>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $criterion->activities_count }} activities</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:1rem;">{{ $criterion->name }}</h6>
                            <p class="text-muted mb-3" style="font-size:0.82rem;line-height:1.5;">{{ Str::limit($criterion->description, 100) }}</p>

                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Completion</small>
                                    <small class="fw-semibold text-dark">{{ $criterion->completion_percentage ?? 0 }}%</small>
                                </div>
                                <div class="progress" style="height:6px;border-radius:10px;">
                                    <div class="progress-bar bg-primary" style="width:{{ $criterion->completion_percentage ?? 0 }}%;border-radius:10px;background:linear-gradient(90deg,#3b82f6,#2563eb);"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3 pt-3" style="border-top:1px solid #f1f5f9;">
                                <small class="text-muted"><i class="bi bi-list-check me-1"></i>{{ $criterion->keyIndicators->count() }} Key Indicators</small>
                                <small class="text-muted"><i class="bi bi-check-circle me-1"></i>{{ $criterion->activities_count }} Activities</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size:3rem;"></i>
                    <p class="text-muted mt-3">No criteria found.</p>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
