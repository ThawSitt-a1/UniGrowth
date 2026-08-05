@extends('admin.layout')

@section('title', 'System Settings')

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-gear me-2"></i>System Settings</h5>
        </div>
        <div class="card-body-custom">
            <!-- Site Identity -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-building me-2"></i>Site Identity
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="d-flex align-items-end gap-2">
                        @csrf
                        <div class="flex-grow-1">
                            <label class="form-label-admin" for="site_platform_name">Platform Name</label>
                            <input type="text" name="setting_value" id="site_platform_name"
                                   class="form-control form-control-admin"
                                   value="{{ $settings['site_platform_name'] ?? 'UniGrowth' }}"
                                   placeholder="UniGrowth">
                            <input type="hidden" name="setting_key" value="site_platform_name">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="d-flex align-items-end gap-2">
                        @csrf
                        <div class="flex-grow-1">
                            <label class="form-label-admin" for="support_email">Support Email</label>
                            <input type="email" name="setting_value" id="support_email"
                                   class="form-control form-control-admin"
                                   value="{{ $settings['support_email'] ?? '' }}"
                                   placeholder="support@example.com">
                            <input type="hidden" name="setting_key" value="support_email">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </form>
                </div>
            </div>

            <hr class="my-4">

            <!-- Registration & Access -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-person-plus me-2"></i>Registration & Access
            </h6>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Allow User Registration</div>
                                <div class="small text-muted">Enable or disable public sign-ups.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox" type="checkbox" role="switch"
                                       id="allow_user_registration"
                                       {{ ($settings['allow_user_registration'] ?? 'true') === 'true' ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ ($settings['allow_user_registration'] ?? 'true') === 'true' ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="allow_user_registration">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Require Email Verification</div>
                                <div class="small text-muted">Force email verification before access.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox" type="checkbox" role="switch"
                                       id="require_email_verification"
                                       {{ ($settings['require_email_verification'] ?? 'false') === 'true' ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ ($settings['require_email_verification'] ?? 'false') === 'true' ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="require_email_verification">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="d-flex align-items-end gap-2">
                        @csrf
                        <div class="flex-grow-1">
                            <label class="form-label-admin" for="max_login_attempts">Max Login Attempts</label>
                            <input type="number" name="setting_value" id="max_login_attempts"
                                   class="form-control form-control-admin"
                                   value="{{ $settings['max_login_attempts'] ?? '5' }}" min="1" max="20">
                            <input type="hidden" name="setting_key" value="max_login_attempts">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="d-flex align-items-end gap-2">
                        @csrf
                        <div class="flex-grow-1">
                            <label class="form-label-admin" for="system_sender_email">System Sender Email</label>
                            <input type="email" name="setting_value" id="system_sender_email"
                                   class="form-control form-control-admin"
                                   value="{{ $settings['system_sender_email'] ?? '' }}"
                                   placeholder="noreply@example.com">
                            <input type="hidden" name="setting_key" value="system_sender_email">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </form>
                </div>
            </div>

            <hr class="my-4">

            <!-- Feature Rollouts -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-toggles me-2"></i>Feature Rollouts
            </h6>
<div class="row g-4 mb-4">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        @php $skillsKilled = ($settings['feature_kill_skills'] ?? 'false') === 'true'; @endphp
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Skills Enabled</div>
                                <div class="small text-muted">Toggle skill management features.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox toggle-kill-switch" type="checkbox" role="switch"
                                       id="skills_enabled" {{ !$skillsKilled ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ $skillsKilled ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="feature_kill_skills">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        @php $goalsHabitsKilled = ($settings['feature_kill_goals_habits'] ?? 'false') === 'true'; @endphp
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Goals & Habits Enabled</div>
                                <div class="small text-muted">Toggle goal and habit tracking features.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox toggle-kill-switch" type="checkbox" role="switch"
                                       id="goals_habits_enabled" {{ !$goalsHabitsKilled ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ $goalsHabitsKilled ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="feature_kill_goals_habits">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        @php $quizKilled = ($settings['feature_kill_quiz'] ?? 'false') === 'true'; @endphp
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Quizzes Enabled</div>
                                <div class="small text-muted">Toggle quiz/assessment features.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox toggle-kill-switch" type="checkbox" role="switch"
                                       id="quizzes_enabled" {{ !$quizKilled ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ $quizKilled ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="feature_kill_quiz">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

<hr class="my-4">

            <!-- Maintenance Mode -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-exclamation-triangle me-2"></i>Maintenance
            </h6>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Maintenance Mode</div>
                                <div class="small text-muted">
                                    Blocks standard user access. Admins & editors can still access.
                                </div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox" type="checkbox" role="switch"
                                       id="maintenance_mode"
                                       {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="maintenance_mode">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="my-4">

            <!-- Season Activation -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-calendar-event me-2"></i>Season Activation
            </h6>
            <div class="row">
                <div class="col-md-6">
                    @if(!empty($seasonStatus['has_active_season']))
                        <div class="p-3 bg-light rounded-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="season-badge active"><i class="bi bi-fire"></i>Active</span>
                                <span class="fw-semibold">{{ $seasonStatus['name'] }}</span>
                            </div>
                            <div class="small text-muted mb-3">
                                Started: {{ $seasonStatus['started_at'] ? \Carbon\Carbon::parse($seasonStatus['started_at'])->format('M j, Y') : 'N/A' }}<br>
                                Ends: {{ $seasonStatus['ends_at'] ? \Carbon\Carbon::parse($seasonStatus['ends_at'])->format('M j, Y g:i A') : 'N/A' }}
                            </div>
                            <form method="POST" action="{{ route('admin.seasons.end') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-stop-circle me-1"></i>End Season
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded-3">
                            <p class="small text-muted mb-3">No active season running. Start a new season to enable competition features.</p>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#startSeasonSettingsModal">
                                <i class="bi bi-play-fill me-1"></i>Start New Season
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Start Season Modal -->
    <div class="modal fade modal-admin" id="startSeasonSettingsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="{{ route('admin.seasons.start') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Start New Season</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-admin" for="seasonNameSettings">Season Name</label>
                        <input type="text" name="name" id="seasonNameSettings" class="form-control form-control-admin" required placeholder="e.g. Fall 2026">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-admin" for="seasonEndsAtSettings">Ends At</label>
                        <input type="datetime-local" name="ends_at" id="seasonEndsAtSettings" class="form-control form-control-admin" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-play-fill me-1"></i>Start Season
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle switch handler: sync hidden input value before form submission
    document.querySelectorAll('.toggle-form').forEach(function(form) {
        const checkbox = form.querySelector('.toggle-checkbox');
        const hiddenInput = form.querySelector('input[type="hidden"][name="setting_value"]');
        const keyInput = form.querySelector('input[type="hidden"][name="setting_key"]');

        if (checkbox && hiddenInput) {
            checkbox.addEventListener('change', function() {
                const key = keyInput ? keyInput.value : '';
                const isKillSwitch = key.startsWith('feature_kill_');

                // Kill switches: checked = enabled = 'false' (not killed)
                // Regular toggles: checked = enabled = 'true'
                if (isKillSwitch) {
                    hiddenInput.value = this.checked ? 'false' : 'true';
                } else {
                    hiddenInput.value = this.checked ? 'true' : 'false';
                }

                // Submit the form immediately
                form.submit();
            });
        }
    });
</script>
@endpush
