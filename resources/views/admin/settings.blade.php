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

            <!-- Localization & Formatting -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-globe me-2"></i>Localization & Formatting
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <label class="form-label-admin" for="default_language">Default Language</label>
                        <div class="d-flex gap-2">
                            <select name="setting_value" id="default_language" class="form-select form-control-admin flex-grow-1">
                                <option value="en" {{ ($settings['default_language'] ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ ($settings['default_language'] ?? '') === 'es' ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ ($settings['default_language'] ?? '') === 'fr' ? 'selected' : '' }}>French</option>
                                <option value="de" {{ ($settings['default_language'] ?? '') === 'de' ? 'selected' : '' }}>German</option>
                                <option value="ja" {{ ($settings['default_language'] ?? '') === 'ja' ? 'selected' : '' }}>Japanese</option>
                            </select>
                            <input type="hidden" name="setting_key" value="default_language">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <label class="form-label-admin" for="app_timezone">Timezone</label>
                        <div class="d-flex gap-2">
                            <select name="setting_value" id="app_timezone" class="form-select form-control-admin flex-grow-1">
                                <option value="UTC" {{ ($settings['app_timezone'] ?? 'UTC') === 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ ($settings['app_timezone'] ?? '') === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                <option value="America/Chicago" {{ ($settings['app_timezone'] ?? '') === 'America/Chicago' ? 'selected' : '' }}>America/Chicago</option>
                                <option value="America/Denver" {{ ($settings['app_timezone'] ?? '') === 'America/Denver' ? 'selected' : '' }}>America/Denver</option>
                                <option value="America/Los_Angeles" {{ ($settings['app_timezone'] ?? '') === 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles</option>
                                <option value="Europe/London" {{ ($settings['app_timezone'] ?? '') === 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                <option value="Europe/Berlin" {{ ($settings['app_timezone'] ?? '') === 'Europe/Berlin' ? 'selected' : '' }}>Europe/Berlin</option>
                                <option value="Asia/Tokyo" {{ ($settings['app_timezone'] ?? '') === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                                <option value="Asia/Rangoon" {{ ($settings['app_timezone'] ?? '') === 'Asia/Rangoon' ? 'selected' : '' }}>Asia/Rangoon</option>
                            </select>
                            <input type="hidden" name="setting_key" value="app_timezone">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <label class="form-label-admin" for="date_display_format">Date Format</label>
                        <div class="d-flex gap-2">
                            <select name="setting_value" id="date_display_format" class="form-select form-control-admin flex-grow-1">
                                <option value="Y-m-d" {{ ($settings['date_display_format'] ?? 'Y-m-d') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="m/d/Y" {{ ($settings['date_display_format'] ?? '') === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="d/m/Y" {{ ($settings['date_display_format'] ?? '') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="M j, Y" {{ ($settings['date_display_format'] ?? '') === 'M j, Y' ? 'selected' : '' }}>Mon DD, YYYY</option>
                            </select>
                            <input type="hidden" name="setting_key" value="date_display_format">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </div>
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
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        @php $seasonKilled = ($settings['feature_kill_season'] ?? 'false') === 'true'; @endphp
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Seasons Enabled</div>
                                <div class="small text-muted">Toggle season/competition features.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox toggle-kill-switch" type="checkbox" role="switch"
                                       id="seasons_enabled" {{ !$seasonKilled ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ $seasonKilled ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="feature_kill_season">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="my-4">

            <!-- Content & Notifications -->
            <h6 class="fw-semibold mb-3" style="color: #1a1a2e;">
                <i class="bi bi-bell me-2"></i>Content & Notifications
            </h6>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Content Approval Required</div>
                                <div class="small text-muted">Edits by editors require admin approval.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox" type="checkbox" role="switch"
                                       id="content_approval_required"
                                       {{ ($settings['content_approval_required'] ?? 'false') === 'true' ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ ($settings['content_approval_required'] ?? 'false') === 'true' ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="content_approval_required">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="toggle-form">
                        @csrf
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div>
                                <div class="fw-semibold small">Notifications Enabled</div>
                                <div class="small text-muted">Global master switch for email/SMS alerts.</div>
                            </div>
                            <div class="form-check form-switch form-switch-admin">
                                <input class="form-check-input toggle-checkbox" type="checkbox" role="switch"
                                       id="notifications_enabled"
                                       {{ ($settings['notifications_enabled'] ?? 'true') === 'true' ? 'checked' : '' }}>
                                <input type="hidden" name="setting_value" value="{{ ($settings['notifications_enabled'] ?? 'true') === 'true' ? 'true' : 'false' }}">
                                <input type="hidden" name="setting_key" value="notifications_enabled">
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
                            <form method="POST" action="{{ route('admin.seasons.end') }}" onsubmit="return confirm('End current season and start a new one?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-arrow-repeat me-1"></i>End & Start New Season
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
