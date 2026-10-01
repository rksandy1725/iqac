<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('meetings.index') }}" class="text-decoration-none">Meetings</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Edit Meeting</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <form action="{{ route('meetings.update', $meeting) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-calendar-event me-2 text-primary"></i>Meeting Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $meeting->title) }}" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Type *</label>
                                <select class="form-select" name="meeting_type" required>
                                    <option value="iqac" {{ old('meeting_type', $meeting->meeting_type) == 'iqac' ? 'selected' : '' }}>IQAC Meeting</option>
                                    <option value="department" {{ old('meeting_type', $meeting->meeting_type) == 'department' ? 'selected' : '' }}>Department Meeting</option>
                                    <option value="other" {{ old('meeting_type', $meeting->meeting_type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Date *</label>
                                <input type="date" class="form-control" name="meeting_date" value="{{ old('meeting_date', $meeting->meeting_date->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Time</label>
                                <input type="text" class="form-control" name="meeting_time" value="{{ old('meeting_time', $meeting->meeting_time) }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label small fw-semibold">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="scheduled" {{ old('status', $meeting->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="ongoing" {{ old('status', $meeting->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status', $meeting->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $meeting->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Venue</label>
                            <input type="text" class="form-control" name="venue" value="{{ old('venue', $meeting->venue) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Agenda</label>
                            <textarea class="form-control" name="agenda" rows="3">{{ old('agenda', $meeting->agenda) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Minutes</label>
                            <textarea class="form-control" name="minutes" rows="4">{{ old('minutes', $meeting->minutes) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Action Items</label>
                            <textarea class="form-control" name="action_items" rows="3">{{ old('action_items', $meeting->action_items) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-people me-2 text-primary"></i>Attendees</h6>
                    </div>
                    <div class="card-body">
                        <div style="max-height:300px;overflow-y:auto;">
                            @foreach($users as $user)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="attendees[]" value="{{ $user->id }}" id="user{{ $user->id }}" {{ in_array($user->id, $selectedAttendees) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user{{ $user->id }}">
                                        <span style="font-size:0.88rem;">{{ $user->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                    <i class="bi bi-check-circle me-1"></i>Update Meeting
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
