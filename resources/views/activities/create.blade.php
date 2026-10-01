<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('activities.index') }}" class="text-decoration-none">Activities</a></li>
                <li class="breadcrumb-item active">Create New</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Add New Activity</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Activity Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Academic Year *</label>
                                <input type="text" class="form-control" name="academic_year" value="{{ old('academic_year', date('Y')) }}" placeholder="e.g. 2024-25" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label small fw-semibold">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-link-45deg me-2 text-primary"></i>NAAC Mapping</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Criterion *</label>
                            <select class="form-select" name="criterion_id" id="criterionSelect" required>
                                <option value="">Select Criteria</option>
                                @foreach($criteria as $c)
                                    <option value="{{ $c->id }}" {{ old('criterion_id') == $c->id ? 'selected' : '' }}>{{ $c->criterion_number }}. {{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Key Indicator</label>
                            <select class="form-select" name="key_indicator_id" id="kiSelect">
                                <option value="">Select Key Indicator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Metric</label>
                            <select class="form-select" name="metric_id" id="metricSelect">
                                <option value="">Select Metric</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-building me-2 text-primary"></i>Department</h6>
                    </div>
                    <div class="card-body">
                        <select class="form-select" name="department_id">
                            <option value="">Select Department</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</h6>
                    </div>
                    <div class="card-body">
                        <input type="file" class="form-control" name="documents[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload evidence files (PDF, DOC, Images)</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                    <i class="bi bi-check-circle me-1"></i>Create Activity
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        document.getElementById('criterionSelect').addEventListener('change', function() {
            const criterionId = this.value;
            const kiSelect = document.getElementById('kiSelect');
            const metricSelect = document.getElementById('metricSelect');
            kiSelect.innerHTML = '<option value="">Loading...</option>';
            metricSelect.innerHTML = '<option value="">Select Metric</option>';

            if (criterionId) {
                fetch(`/iqac/api/key-indicators/${criterionId}`)
                    .then(r => r.json())
                    .then(data => {
                        kiSelect.innerHTML = '<option value="">Select Key Indicator</option>';
                        data.forEach(ki => {
                            kiSelect.innerHTML += `<option value="${ki.id}">${ki.ki_code} - ${ki.ki_name}</option>`;
                        });
                    });
            } else {
                kiSelect.innerHTML = '<option value="">Select Key Indicator</option>';
            }
        });

        document.getElementById('kiSelect').addEventListener('change', function() {
            const kiId = this.value;
            const metricSelect = document.getElementById('metricSelect');
            metricSelect.innerHTML = '<option value="">Loading...</option>';

            if (kiId) {
                fetch(`/iqac/api/metrics/${kiId}`)
                    .then(r => r.json())
                    .then(data => {
                        metricSelect.innerHTML = '<option value="">Select Metric</option>';
                        data.forEach(m => {
                            metricSelect.innerHTML += `<option value="${m.id}">${m.metric_code} - ${m.metric_name}</option>`;
                        });
                    });
            } else {
                metricSelect.innerHTML = '<option value="">Select Metric</option>';
            }
        });
    </script>
    @endpush
</x-app-layout>
