<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('feedback.index') }}" class="text-decoration-none">Feedback</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Edit Survey</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('feedback.update', $survey) }}" method="POST">
                @csrf @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-chat-dots me-2 text-primary"></i>Survey Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $survey->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description', $survey->description) }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Target Group *</label>
                                <select class="form-select" name="target_group" required>
                                    <option value="student" {{ old('target_group', $survey->target_group) == 'student' ? 'selected' : '' }}>Students</option>
                                    <option value="parent" {{ old('target_group', $survey->target_group) == 'parent' ? 'selected' : '' }}>Parents</option>
                                    <option value="employer" {{ old('target_group', $survey->target_group) == 'employer' ? 'selected' : '' }}>Employers</option>
                                    <option value="alumni" {{ old('target_group', $survey->target_group) == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                    <option value="faculty" {{ old('target_group', $survey->target_group) == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Related Criteria</label>
                                <select class="form-select" name="criterion_id">
                                    <option value="">None</option>
                                    @foreach($criteria as $c)
                                        <option value="{{ $c->id }}" {{ old('criterion_id', $survey->criterion_id) == $c->id ? 'selected' : '' }}>{{ $c->criterion_number }}. {{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Status *</label>
                                <select class="form-select" name="status" required>
                                    <option value="draft" {{ old('status', $survey->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status', $survey->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="closed" {{ old('status', $survey->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $survey->start_date?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $survey->end_date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                            <i class="bi bi-check-circle me-1"></i>Update Survey
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
