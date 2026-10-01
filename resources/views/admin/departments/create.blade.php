<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}" class="text-decoration-none">Departments</a></li>
                <li class="breadcrumb-item active">Create New</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Add Department</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('admin.departments.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-building me-2 text-primary"></i>Department Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Name *</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Code *</label>
                            <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="e.g. CSE, ECE" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">HOD</label>
                            <select class="form-select" name="hod_id">
                                <option value="">Select HOD</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('hod_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                            <i class="bi bi-check-circle me-1"></i>Create Department
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
