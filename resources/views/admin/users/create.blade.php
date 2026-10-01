<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                <li class="breadcrumb-item active">Create New</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Add New User</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-person me-2 text-primary"></i>User Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Full Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email *</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Password *</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Confirm Password *</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Designation</label>
                                <input type="text" class="form-control" name="designation" value="{{ old('designation') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-shield me-2 text-primary"></i>Role & Department</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Role *</label>
                            <select class="form-select" name="role" required>
                                <option value="faculty" {{ old('role') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                <option value="hod" {{ old('role') == 'hod' ? 'selected' : '' }}>HOD</option>
                                <option value="coordinator" {{ old('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Department</label>
                            <select class="form-select" name="department_id">
                                <option value="">None</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                    <i class="bi bi-check-circle me-1"></i>Create User
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
