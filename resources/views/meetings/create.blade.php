<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('meetings.index') }}" class="text-decoration-none">Meetings</a></li>
                <li class="breadcrumb-item active">Schedule New</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Schedule Meeting</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <form action="{{ route('meetings.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-calendar-event me-2 text-primary"></i>Meeting Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Type *</label>
                                <select class="form-select" name="meeting_type" required>
                                    <option value="iqac" {{ old('meeting_type') == 'iqac' ? 'selected' : '' }}>IQAC Meeting</option>
                                    <option value="department" {{ old('meeting_type') == 'department' ? 'selected' : '' }}>Department Meeting</option>
                                    <option value="other" {{ old('meeting_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Date *</label>
                                <input type="date" class="form-control" name="meeting_date" value="{{ old('meeting_date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Time</label>
                                <input type="text" class="form-control" name="meeting_time" value="{{ old('meeting_time') }}" placeholder="e.g. 10:00 AM">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label small fw-semibold">Venue</label>
                            <input type="text" class="form-control" name="venue" value="{{ old('venue') }}" placeholder="e.g. Conference Hall">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Agenda</label>
                            <textarea class="form-control" name="agenda" rows="4">{{ old('agenda') }}</textarea>
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
                                    <input class="form-check-input" type="checkbox" name="attendees[]" value="{{ $user->id }}" id="user{{ $user->id }}">
                                    <label class="form-check-label" for="user{{ $user->id }}">
                                        <span class="fw-semibold" style="font-size:0.88rem;">{{ $user->name }}</span>
                                        <br><small class="text-muted">{{ $user->email }}</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                    <i class="bi bi-calendar-check me-1"></i>Schedule Meeting
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
