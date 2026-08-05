@extends('admin.layout')

@section('title', 'Content Management')

@section('content')
    <!-- Editor Content Table -->
    <div class="content-card mb-4">
        <div class="card-header-custom">
            <h5><i class="bi bi-file-earmark-text me-2"></i>Editor-Created Skills</h5>
            <span class="badge bg-secondary">{{ count($allContent ?? []) }} total</span>
        </div>
        <div class="card-body-custom p-0">
            @if(empty($allContent))
                <div class="empty-state">
                    <i class="bi bi-file-earmark-text"></i>
                    <p>No editor-created content found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-admin table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Editor</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Admin Comment</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allContent as $skill)
                                <tr>
                                    <td class="fw-semibold">{{ $skill['id'] }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $skill['title'] ?? 'Untitled' }}</span>
                                    </td>
                                    <td class="small">
                                        @if(!empty($skill['editor_name']))
                                            <span class="fw-medium">{{ $skill['editor_name'] }}</span>
                                            <span class="text-muted d-block" style="font-size: 0.7rem;">
                                                {{ $skill['editor_email'] ?? '' }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">
                                        {{ isset($skill['created_at']) ? \Carbon\Carbon::parse($skill['created_at'])->format('M j, Y g:i A') : 'N/A' }}
                                    </td>
                                    <td>
                                        @php
                                            $isActive = $skill['is_active'] ?? true;
                                        @endphp
                                        @if($isActive)
                                            <span class="badge badge-status allowed">Active</span>
                                        @else
                                            <span class="badge badge-status suspended">Suspended</span>
                                        @endif
                                    </td>
                                    <td class="small" style="max-width: 200px; word-break: break-word;">
                                        @if(!empty($skill['admin_comment']))
                                            <span class="text-muted fst-italic">"{{ $skill['admin_comment'] }}"</span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.7rem;">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="actions-cell justify-content-end">
                                            @if($isActive)
                                                <button type="button" class="btn-admin-action suspend"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#contentActionModal"
                                                        data-target-id="{{ $skill['id'] }}"
                                                        data-target-type="SKILL"
                                                        data-action="SUSPEND"
                                                        data-title="{{ $skill['title'] ?? 'Untitled' }}">
                                                    <i class="bi bi-pause-circle"></i>Suspend
                                                </button>
                                            @else
                                                <button type="button" class="btn-admin-action restore"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#contentActionModal"
                                                        data-target-id="{{ $skill['id'] }}"
                                                        data-target-type="SKILL"
                                                        data-action="RESTORE"
                                                        data-title="{{ $skill['title'] ?? 'Untitled' }}">
                                                    <i class="bi bi-arrow-counterclockwise"></i>Restore
                                                </button>
                                            @endif

                                            <button type="button" class="btn-admin-action delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#contentActionModal"
                                                    data-target-id="{{ $skill['id'] }}"
                                                    data-target-type="SKILL"
                                                    data-action="DELETE"
                                                    data-title="{{ $skill['title'] ?? 'Untitled' }}">
                                                <i class="bi bi-trash"></i>Delete
                                            </button>

                                            <button type="button" class="btn-admin-action edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#commentModal"
                                                    data-target-id="{{ $skill['id'] }}"
                                                    data-title="{{ $skill['title'] ?? 'Untitled' }}">
                                                <i class="bi bi-chat"></i>Comment
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Suspended Content Section -->
    @if(!empty($suspendedContent))
        <div class="content-card">
            <div class="card-header-custom">
                <h5><i class="bi bi-eye-slash me-2 text-warning"></i>Suspended Content</h5>
                <span class="badge bg-warning text-dark">{{ count($suspendedContent) }} suspended</span>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-admin table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Suspended At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suspendedContent as $suspended)
                                @php
                                    $suspendedType = strtoupper($suspended['type'] ?? 'SKILL');
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $suspended['id'] }}</td>
                                    <td>{{ $suspended['title'] ?? 'Untitled' }}</td>
                                    <td>
                                        <span class="badge badge-role {{ $suspendedType === 'SKILL' ? 'editor' : 'user' }}">
                                            {{ $suspendedType }}
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        {{ isset($suspended['created_at']) ? \Carbon\Carbon::parse($suspended['created_at'])->format('M j, Y g:i A') : 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        <div class="actions-cell justify-content-end">
                                            <button type="button" class="btn-admin-action restore"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#contentActionModal"
                                                    data-target-id="{{ $suspended['id'] }}"
                                                    data-target-type="{{ $suspendedType }}"
                                                    data-action="RESTORE"
                                                    data-title="{{ $suspended['title'] ?? 'Untitled' }}">
                                                <i class="bi bi-arrow-counterclockwise"></i>Restore
                                            </button>
                                            <button type="button" class="btn-admin-action delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#contentActionModal"
                                                    data-target-id="{{ $suspended['id'] }}"
                                                    data-target-type="{{ $suspendedType }}"
                                                    data-action="DELETE"
                                                    data-title="{{ $suspended['title'] ?? 'Untitled' }}">
                                                <i class="bi bi-trash"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Content Action Modal -->
    <div class="modal fade modal-admin" id="contentActionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="{{ route('admin.content.action') }}">
                @csrf
                <input type="hidden" name="target_id" id="contentTargetId">
                <input type="hidden" name="target_type" id="contentTargetType" value="SKILL">
                <input type="hidden" name="action" id="contentAction">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="contentActionTitle">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
<div class="modal-body">
                    <p class="small text-muted mb-3" id="contentActionDescription">
                        Are you sure you want to perform this action?
                    </p>
                    <div class="mb-3">
                        <label class="form-label-admin" for="contentActionReason">
                            Reason
                            <span id="reasonRequiredBadge" class="badge bg-danger ms-1" style="display: none; font-size: 0.6rem; vertical-align: middle;">Required</span>
                        </label>
                        <textarea name="reason" id="contentActionReason" class="form-control form-control-admin" rows="2" placeholder="Explain your moderation decision..."></textarea>
                        <div id="reasonHelpText" class="form-text small text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            <span id="reasonHelpMessage">Optional for non-suspension actions.</span>
                        </div>
                        <div id="reasonError" class="invalid-feedback" style="display: none;">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            A reason is required when suspending content. Please explain why this content is being suspended.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="contentActionSubmit">
                        <i class="bi bi-check-circle me-1"></i>Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Comment Modal -->
    <div class="modal fade modal-admin" id="commentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="" id="commentForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-chat me-2"></i>Add Admin Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Add a comment to <strong id="commentSkillTitle" class="text-dark"></strong>.
                    </p>
                    <div class="mb-3">
                        <label class="form-label-admin" for="commentText">Comment</label>
                        <textarea name="comment" id="commentText" class="form-control form-control-admin" rows="3" required placeholder="Enter your admin comment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-chat-dots me-1"></i>Add Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Content Action Modal
    document.getElementById('contentActionModal')?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const targetId = button.getAttribute('data-target-id');
        const targetType = button.getAttribute('data-target-type');
        const action = button.getAttribute('data-action');
        const title = button.getAttribute('data-title');

        document.getElementById('contentTargetId').value = targetId;
        document.getElementById('contentTargetType').value = targetType;
        document.getElementById('contentAction').value = action;

        const actionLabels = {
            'SUSPEND': 'Suspend',
            'RESTORE': 'Restore',
            'DELETE': 'Delete'
        };
        const actionLabel = actionLabels[action] || action;

        document.getElementById('contentActionTitle').textContent = actionLabel + ' Content';
        document.getElementById('contentActionDescription').textContent =
            'Are you sure you want to ' + action.toLowerCase() + ' "' + title + '"?';

        const submitBtn = document.getElementById('contentActionSubmit');
        const actionColors = {
            'SUSPEND': 'btn-warning',
            'RESTORE': 'btn-success',
            'DELETE': 'btn-danger'
        };
        submitBtn.className = 'btn btn-sm ' + (actionColors[action] || 'btn-primary');
        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>' + actionLabel;

        // Show/hide required badge and help text based on action
        const reasonBadge = document.getElementById('reasonRequiredBadge');
        const reasonHelp = document.getElementById('reasonHelpMessage');
        const reasonError = document.getElementById('reasonError');
        const reasonInput = document.getElementById('contentActionReason');

        // Reset validation state
        reasonInput.classList.remove('is-invalid');
        reasonError.style.display = 'none';

        if (action === 'SUSPEND') {
            reasonBadge.style.display = 'inline';
            reasonHelp.textContent = 'Required. Please explain why this content is being suspended.';
            reasonInput.placeholder = 'Explain why this content is being suspended...';
            reasonInput.setAttribute('required', 'required');
        } else {
            reasonBadge.style.display = 'none';
            reasonHelp.textContent = 'Optional for non-suspension actions.';
            reasonInput.placeholder = 'Explain your moderation decision...';
            reasonInput.removeAttribute('required');
        }
    });

    // Client-side validation for suspend action
    document.getElementById('contentActionModal')?.querySelector('form')?.addEventListener('submit', function (event) {
        const action = document.getElementById('contentAction').value;
        const reasonInput = document.getElementById('contentActionReason');
        const reasonError = document.getElementById('reasonError');

        if (action === 'SUSPEND' && !reasonInput.value.trim()) {
            event.preventDefault();
            reasonInput.classList.add('is-invalid');
            reasonError.style.display = 'block';
            reasonInput.focus();
        }
    });

    // Clear validation error on input
    document.getElementById('contentActionReason')?.addEventListener('input', function () {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            document.getElementById('reasonError').style.display = 'none';
        }
    });

    // Comment Modal
    document.getElementById('commentModal')?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const skillId = button.getAttribute('data-target-id');
        const title = button.getAttribute('data-title');
        document.getElementById('commentSkillTitle').textContent = title;
        document.getElementById('commentForm').action = '{{ url('admin/content') }}/' + skillId + '/comment';
    });
</script>
@endpush
