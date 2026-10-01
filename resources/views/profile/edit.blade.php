<x-app-layout>
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">My Profile</h4>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Manage your account settings and personal information</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-person me-2 text-primary"></i>Profile Information</h6>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="section-title mb-0"><i class="bi bi-lock me-2 text-primary"></i>Update Password</h6>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center py-4">
                    <div class="user-avatar mx-auto mb-3" style="width:72px;height:72px;font-size:1.75rem;background:linear-gradient(135deg,#3b82f6,#2563eb);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-2" style="font-size:0.88rem;">{{ auth()->user()->email }}</p>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>

            <div class="card border-danger">
                <div class="card-header bg-danger bg-opacity-10 border-danger">
                    <h6 class="section-title mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
