<x-app-layout>
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#3b82f6;">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Total Activities</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $totalActivities }}</div>
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
                        <div class="text-muted" style="font-size:0.8rem;">Completed</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $completedActivities }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#fffbeb,#fef3c7);color:#d97706;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">In Progress</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $inProgressActivities }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe);color:#0284c7;">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Documents</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $totalDocuments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#faf5ff,#f3e8ff);color:#9333ea;">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Departments</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $totalDepartments }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#fef2f2,#fee2e2);color:#dc2626;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Users</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $totalUsers }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#f0fdfa,#ccfbf1);color:#0d9488;">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Active Surveys</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $activeSurveys }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);color:#059669;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">AQAR Reports</div>
                        <div class="fw-bold" style="font-size:1.6rem;line-height:1;">{{ $draftReports }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-bar-chart me-2 text-primary"></i>Criteria-wise Activity Progress</h6>
                </div>
                <div class="card-body">
                    <canvas id="criteriaChart" height="280"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-pie-chart me-2 text-primary"></i>Activity Status</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="section-title mb-0"><i class="bi bi-calendar-event me-2 text-primary"></i>Upcoming Meetings</h6>
                </div>
                <div class="card-body p-0">
                    @if($upcomingMeetings->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x" style="font-size:2rem;"></i>
                            <p class="mt-2 mb-0">No upcoming meetings</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($upcomingMeetings as $meeting)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $meeting->title }}</div>
                                            <div class="d-flex align-items-center gap-3 mt-1">
                                                <small class="text-muted d-flex align-items-center gap-1">
                                                    <i class="bi bi-calendar3"></i>{{ $meeting->meeting_date->format('d M Y') }}
                                                </small>
                                                @if($meeting->meeting_time)
                                                    <small class="text-muted d-flex align-items-center gap-1">
                                                        <i class="bi bi-clock"></i>{{ $meeting->meeting_time }}
                                                    </small>
                                                @endif
                                                @if($meeting->venue)
                                                    <small class="text-muted d-flex align-items-center gap-1">
                                                        <i class="bi bi-geo-alt"></i>{{ $meeting->venue }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Scheduled</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="section-title mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Activities</h6>
                </div>
                <div class="card-body p-0">
                    @if($recentActivities->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-clipboard-x" style="font-size:2rem;"></i>
                            <p class="mt-2 mb-0">No recent activities</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentActivities->take(5) as $activity)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $activity->title }}</div>
                                            <small class="text-muted">
                                                {{ $activity->criterion->name ?? 'N/A' }}
                                                @if($activity->department)
                                                    <span class="mx-1">-</span>{{ $activity->department->name }}
                                                @endif
                                            </small>
                                        </div>
                                        @php
                                            $statusConfig = match($activity->status) {
                                                'completed' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Completed'],
                                                'in_progress' => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'In Progress'],
                                                default => ['class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle', 'label' => 'Planned'],
                                            };
                                        @endphp
                                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const criteriaLabels = @json($criteriaProgress->pluck('name'));
        const criteriaTotal = @json($criteriaProgress->pluck('total_activities'));
        const criteriaCompleted = @json($criteriaProgress->pluck('completed_activities'));

        new Chart(document.getElementById('criteriaChart'), {
            type: 'bar',
            data: {
                labels: criteriaLabels,
                datasets: [
                    {
                        label: 'Total Activities',
                        data: criteriaTotal,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 0,
                        borderRadius: 6,
                        barPercentage: 0.6,
                    },
                    {
                        label: 'Completed',
                        data: criteriaCompleted,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 0,
                        borderRadius: 6,
                        barPercentage: 0.6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 20 } }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Planned'],
                datasets: [{
                    data: [{{ $completedActivities }}, {{ $inProgressActivities }}, {{ $plannedActivities }}],
                    backgroundColor: ['#22c55e', '#f59e0b', '#94a3b8'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 20 } }
                },
                cutout: '70%'
            }
        });
    </script>
    @endpush
</x-app-layout>
