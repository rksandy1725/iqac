<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Departments</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Manage academic departments</p>
        </div>
        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-plus-circle me-1"></i>Add Department
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
            @if($departments->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-building text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">No departments found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th style="font-size:0.8rem;padding:12px 16px;">Code</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Name</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">HOD</th>
                                <th style="font-size:0.8rem;padding:12px 16px;">Staff</th>
                                <th style="font-size:0.8rem;padding:12px 16px;text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $dept)
                                <tr>
                                    <td style="padding:12px 16px;"><code>{{ $dept->code }}</code></td>
                                    <td style="padding:12px 16px;"><span class="fw-semibold text-dark">{{ $dept->name }}</span></td>
                                    <td style="padding:12px 16px;font-size:0.85rem;">{{ $dept->hod->name ?? '-' }}</td>
                                    <td style="padding:12px 16px;"><span class="badge bg-light text-dark">{{ $dept->users_count }}</span></td>
                                    <td style="padding:12px 16px;text-align:right;">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-sm btn-outline-primary py-0"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Delete this department?')">
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
    </div>
</x-app-layout>
