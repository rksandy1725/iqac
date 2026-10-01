<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Meetings</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Manage IQAC and departmental meetings</p>
        </div>
        <a href="{{ route('meetings.create') }}" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-plus-circle me-1"></i>Schedule Meeting
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
            @if($meetings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">No meetings found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th style="font-size:0.8rem;padding:12px 16px;">Title</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Type</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Date</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Time</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Status</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Attendees</th>
                                <th style="font-size:0.8rem;padding:12px 16px;text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <a href="{{ route('meetings.show', $meeting) }}" class="text-decoration-none fw-semibold text-dark">{{ $meeting->title }}</a>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;"><span class="badge bg-light text-dark">{{ ucfirst($meeting->meeting_type) }}</span></td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $meeting->meeting_date->format('d M Y') }}</td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $meeting->meeting_time ?? '-' }}</td>
                                    <td style="padding:12px 16px;">
                                        @php
                                            $statusConfig = match($meeting->status) {
                                                'completed' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Completed'],
                                                'ongoing' => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'Ongoing'],
                                                'cancelled' => ['class' => 'bg-danger-subtle text-danger border border-danger-subtle', 'label' => 'Cancelled'],
                                                default => ['class' => 'bg-primary-subtle text-primary border border-primary-subtle', 'label' => 'Scheduled'],
                                            };
                                        @endphp
                                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $meeting->attendees->count() }}</td>
                                    <td style="padding:12px 16px;text-align:right;">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-sm btn-outline-primary py-0"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-sm btn-outline-secondary py-0"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" onsubmit="return confirm('Delete?')">
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
        @if($meetings->hasPages())
            <div class="card-footer bg-white">{{ $meetings->links() }}</div>
        @endif
    </div>
</x-app-layout>
