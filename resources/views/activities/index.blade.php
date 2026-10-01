<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Activities</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Manage all quality assurance activities</p>
        </div>
        <a href="{{ route('activities.create') }}" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-plus-circle me-1"></i>Add Activity
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('activities.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Academic Year</label>
                    <select class="form-select form-select-sm" name="academic_year">
                        <option value="">All Years</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Status</label>
                    <select class="form-select form-select-sm" name="status">
                        <option value="">All Status</option>
                        <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Criteria</label>
                    <select class="form-select form-select-sm" name="criterion_id">
                        <option value="">All Criteria</option>
                        @foreach($criteria as $c)
                            <option value="{{ $c->id }}" {{ request('criterion_id') == $c->id ? 'selected' : '' }}>{{ $c->criterion_number }}. {{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Department</label>
                    <select class="form-select form-select-sm" name="department_id">
                        <option value="">All Depts</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" {{ request('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Search</label>
                    <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Search...">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary flex-grow-1"><i class="bi bi-search me-1"></i>Filter</button>
                    <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($activities->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">No activities found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th style="font-size:0.8rem;padding:12px 16px;">Title</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Criteria</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Department</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Year</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Status</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Docs</th>
                                <th style="font-size:0.8rem;padding:12px 16px;text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <a href="{{ route('activities.show', $activity) }}" class="text-decoration-none fw-semibold text-dark">{{ $activity->title }}</a>
                                    </td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $activity->criterion->name ?? '-' }}</td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $activity->department->name ?? '-' }}</td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $activity->academic_year }}</td>
                                    <td style="padding:12px 16px;">
                                        @php
                                            $statusConfig = match($activity->status) {
                                                'completed' => ['class' => 'bg-success-subtle text-success border border-success-subtle', 'label' => 'Completed'],
                                                'in_progress' => ['class' => 'bg-warning-subtle text-warning border border-warning-subtle', 'label' => 'In Progress'],
                                                default => ['class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle', 'label' => 'Planned'],
                                            };
                                        @endphp
                                        <span class="badge {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                                    </td>
                                    <td style="padding:12px 16px;"><span class="badge bg-light text-dark">{{ $activity->documents->count() }}</span></td>
                                    <td style="padding:12px 16px;text-align:right;">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('activities.show', $activity) }}" class="btn btn-sm btn-outline-primary py-0"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-outline-secondary py-0"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Delete this activity?')">
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
        @if($activities->hasPages())
            <div class="card-footer bg-white">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
