<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('meetings.index') }}" class="text-decoration-none">Meetings</a></li>
                <li class="breadcrumb-item active">{{ $meeting->title }}</li>
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
                    <h6 class="section-title mb-0">{{ $meeting->title }}</h6>
                    <div class="d-flex gap-2">
                        @php
                            $statusConfig = match($meeting->status) {
                                'completed' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Completed'],
                                'ongoing' => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'Ongoing'],
                                'cancelled' => ['class' => 'bg-danger-subtle text-danger border border-danger-subtle', 'label' => 'Cancelled'],
                                default => ['class' => 'bg-primary-subtle text-primary border border-primary-subtle', 'label' => 'Scheduled'],
                            };
                        @endphp
                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                        <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Type</small>
                            <p class="fw-semibold text-dark mb-0">{{ ucfirst($meeting->meeting_type) }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Date</small>
                            <p class="text-dark mb-0">{{ $meeting->meeting_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Time</small>
                            <p class="text-dark mb-0">{{ $meeting->meeting_time ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Venue</small>
                            <p class="text-dark mb-0">{{ $meeting->venue ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Agenda</small>
                            <p class="text-dark mb-0">{{ $meeting->agenda ?? 'No agenda specified' }}</p>
                        </div>
                    </div>

                    @if($meeting->minutes)
                        <hr>
                        <div class="mb-0">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Minutes</small>
                            <p class="text-dark mb-0">{{ $meeting->minutes }}</p>
                        </div>
                    @endif

                    @if($meeting->action_items)
                        <hr>
                        <div class="mb-0">
                            <small class="text-muted text-uppercase" style="font-size:0.72rem;">Action Items</small>
                            <p class="text-dark mb-0">{{ $meeting->action_items }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-people me-2 text-primary"></i>Attendees ({{ $meeting->attendees->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    @if($meeting->attendees->isEmpty())
                        <div class="text-center py-4 text-muted">No attendees</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($meeting->attendees as $attendee)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.88rem;">{{ $attendee->user->name }}</div>
                                        <small class="text-muted">{{ $attendee->user->email }}</small>
                                    </div>
                                    @php
                                        $attColor = match($attendee->attendance_status) {
                                            'present' => 'success',
                                            'absent' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $attColor }}-subtle text-{{ $attColor }} border border-{{ $attColor }}-subtle">{{ ucfirst($attendee->attendance_status) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
