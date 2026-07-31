@extends('editor.layout')

@section('title', 'Settings')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #1f2937;">
            <i class="bi bi-gear me-2" style="color: #6366f1;"></i>Editor Settings
        </h2>
        <p class="small text-muted mb-0">Manage your editor profile and preferences</p>
    </div>

    <div class="row g-4">
        <!-- Profile Settings -->
        <div class="col-12 col-lg-6">
            <div class="content-card">
                <div class="card-header-custom">
                    <h5><i class="bi bi-person me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body-custom">
                    <div class="mb-3">
                        <label class="form-label-editor">Name</label>
                        <p class="fw-medium mb-0" style="color: #1a1a2e;">{{ $user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-editor">Email</label>
                        <p class="fw-medium mb-0" style="color: #1a1a2e;">{{ $user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="form-label-editor">Role</label>
                        <p class="mb-0">
                            <span class="badge-role editor">Editor</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Actions -->
        <div class="col-12 col-lg-6">
            <div class="content-card">
                <div class="card-header-custom">
                    <h5><i class="bi bi-shield-check me-2"></i>Account</h5>
                </div>
                <div class="card-body-custom">
                    <p class="small text-muted mb-3">Manage your main account settings from your profile page.</p>
                    <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-person-gear me-1"></i>Go to Profile Settings
                    </a>
                </div>
            </div>

            <div class="content-card mt-3">
                <div class="card-header-custom">
                    <h5><i class="bi bi-info-circle me-2"></i>Editor Guidelines</h5>
                </div>
                <div class="card-body-custom">
                    <ul class="small text-muted mb-0 ps-3" style="line-height: 1.8;">
                        <li>You can only manage skills, questions, and options that you created.</li>
                        <li>Skills locked by an admin cannot be edited or deleted.</li>
                        <li>Questions and options locked by an admin cannot be modified.</li>
                        <li>Deleting a skill removes all associated questions and options.</li>
                        <li>Difficulty levels (Easy, Medium, Hard) have fixed marks assigned by the system.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
