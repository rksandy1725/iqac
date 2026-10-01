<x-app-layout>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('aqar.index') }}" class="text-decoration-none">AQAR Reports</a></li>
                <li class="breadcrumb-item active">Create New</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1">Create AQAR Report</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('aqar.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h6 class="section-title mb-0"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Report Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Academic Year *</label>
                            <select class="form-select" name="academic_year" required>
                                <option value="">Select Academic Year</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select the academic year for which you want to generate the AQAR.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="3" placeholder="Any additional notes about this report..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary" style="border-radius:8px;background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                            <i class="bi bi-magic me-1"></i>Generate AQAR Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
