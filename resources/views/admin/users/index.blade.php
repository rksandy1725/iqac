<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">User Management</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Manage system users and their roles</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
            <i class="bi bi-plus-circle me-1"></i>Add User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#f0fdf4;color:#166534;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Role</label>
                    <select class="form-select form-select-sm" name="role">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="coordinator" {{ request('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                        <option value="hod" {{ request('role') == 'hod' ? 'selected' : '' }}>HOD</option>
                        <option value="faculty" {{ request('role') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Search</label>
                    <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Name or email...">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th style="font-size:0.8rem;padding:12px 16px;">User</th>
                            <th style="font-size:0.8rem;padding:12px 16px;">Role</th>
                            <th style="font-size:0.8rem;padding:12px 16px;">Department</th>
                            <th style="font-size:0.8rem;padding:12px 16px;">Phone</th>
                            <th style="font-size:0.8rem;padding:12px 16px;text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td style="padding:12px 16px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar" style="width:32px;height:32px;font-size:0.75rem;background:linear-gradient(135deg,#3b82f6,#2563eb);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size:0.9rem;">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:12px 16px;">
                                    @php
                                        $roleColor = match($user->role) {
                                            'admin' => 'danger',
                                            'coordinator' => 'primary',
                                            'hod' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $roleColor }}-subtle text-{{ $roleColor }} border border-{{ $roleColor }}-subtle">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td style="padding:12px 16px;font-size:0.85rem;">{{ $user->department->name ?? '-' }}</td>
                                <td style="padding:12px 16px;font-size:0.85rem;">{{ $user->phone ?? '-' }}</td>
                                <td style="padding:12px 16px;text-align:right;">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary py-0"><i class="bi bi-pencil"></i></a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger py-0"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white">{{ $users->links() }}</div>
        @endif
    </div>
</x-app-layout>
