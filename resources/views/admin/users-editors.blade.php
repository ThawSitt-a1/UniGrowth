@extends('admin.layout')

@section('title', 'Users & Editors')

@section('content')
    <!-- Search & Filter Toolbar -->
    <div class="content-card mb-4">
        <div class="card-body-custom">
            <form method="GET" action="{{ route('admin.users') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label-admin" for="search">Search</label>
                    <div class="input-group search-input-group">
                        <input type="text" name="search" id="search" class="form-control form-control-admin"
                               placeholder="Search by ID, username, or email..."
                               value="{{ $search ?? '' }}">
                        <button class="btn btn-search" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-admin" for="role">Role Filter</label>
                    <select name="role" id="role" class="form-select form-control-admin" onchange="this.form.submit()">
                        <option value="all" {{ ($roleFilter ?? 'all') === 'all' ? 'selected' : '' }}>All Roles</option>
                        <option value="user" {{ ($roleFilter ?? 'all') === 'user' ? 'selected' : '' }}>Users Only</option>
                        <option value="editor" {{ ($roleFilter ?? 'all') === 'editor' ? 'selected' : '' }}>Editors Only</option>
                    </select>
                </div>
                <div class="col-md-2">
                    @if(($search ?? '') || ($roleFilter ?? 'all') !== 'all')
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i>Clear
                        </a>
                    @endif
                </div>
                <div class="col-md-2 text-end">
                    <span class="small text-muted">
                        {{ count($allUsersAndEditors ?? []) }} result(s)
                    </span>
                </div>
            </form>
        </div>
    </div>

<!-- Bulk Delete Unverified Users Card -->
    <div class="content-card mb-4">
        <div class="card-body-custom d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h6 class="fw-semibold mb-1" style="color: #1a1a2e;">
                    <i class="bi bi-envelope-exclamation me-2 text-warning"></i>Unverified Users
                </h6>
                <p class="small text-muted mb-0">
                    {{ $unverifiedUsersCount ?? 0 }} user(s) with unverified email.
                    These users registered but never verified their email address.
                </p>
            </div>
            @if(($unverifiedUsersCount ?? 0) > 0)
                <button type="button" class="btn-admin-action delete" data-bs-toggle="modal" data-bs-target="#deleteUnverifiedModal">
                    <i class="bi bi-trash3 me-1"></i>Delete All Unverified
                </button>
            @else
                <span class="small text-muted fst-italic"><i class="bi bi-check-circle text-success me-1"></i>All users verified</span>
            @endif
        </div>
    </div>

    <!-- Users & Editors Table -->
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-people me-2"></i>All Users & Editors</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.editors') }}" class="btn-admin-action view">
                    <i class="bi bi-pencil-square"></i>Manage Editors
                </a>
            </div>
        </div>
        <div class="card-body-custom p-0">
            @if(empty($allUsersAndEditors))
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <p>No users or editors found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-admin table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Score</th>
                                <th>Verified</th>
                                <th>Joined</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allUsersAndEditors as $user)
                                <tr>
                                    <td class="fw-semibold">{{ $user['id'] }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $user['username'] }}</span>
                                        @if(($user['skills_count'] ?? 0) > 0)
                                            <span class="badge badge-role editor ms-1">{{ $user['skills_count'] }} skills</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $user['email'] }}</td>
                                    <td>
                                        <span class="badge badge-role {{ $user['role'] }}">
                                            {{ ucfirst($user['role']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-status {{ $user['account_status'] ?? 'allowed' }}">
                                            {{ $user['account_status'] ?? 'allowed' }}
                                        </span>
                                        @if(!empty($user['suspended_until']))
                                            <br><small class="text-muted" style="font-size: 0.65rem;">
                                                until {{ \Carbon\Carbon::parse($user['suspended_until'])->format('M j, Y') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ number_format($user['platform_score'] ?? 0) }}</td>
                                    <td>
                                        @if(!empty($user['email_verified_at']))
                                            <span class="text-success"><i class="bi bi-check-circle-fill"></i></span>
                                        @else
                                            <span class="text-muted"><i class="bi bi-x-circle"></i></span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">
                                        {{ isset($user['created_at']) ? \Carbon\Carbon::parse($user['created_at'])->format('M j, Y') : 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        <div class="actions-cell justify-content-end">
                                            <!-- Status actions -->
                                            @if(($user['account_status'] ?? 'allowed') !== 'banned')
                                                <button type="button" class="btn-admin-action ban"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#banModal"
                                                        data-user-id="{{ $user['id'] }}"
                                                        data-username="{{ $user['username'] }}">
                                                    <i class="bi bi-shield-exclamation"></i>Ban
                                                </button>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.status', $user['id']) }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="allowed">
                                                    <button type="submit" class="btn-admin-action restore">
                                                        <i class="bi bi-arrow-counterclockwise"></i>Restore
                                                    </button>
                                                </form>
                                            @endif

<!-- Role toggle -->
                                            @if($user['role'] === 'editor')
                                                <form method="POST" action="{{ route('admin.users.role', $user['id']) }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="role" value="user">
                                                    <button type="submit" class="btn-admin-action demote">
                                                        <i class="bi bi-arrow-down-circle"></i>Demote
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.role', $user['id']) }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="role" value="editor">
                                                    <button type="submit" class="btn-admin-action promote">
                                                        <i class="bi bi-arrow-up-circle"></i>Promote
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete -->
                                            <button type="button" class="btn-admin-action delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal"
                                                    data-user-id="{{ $user['id'] }}"
                                                    data-username="{{ $user['username'] }}">
                                                <i class="bi bi-trash"></i>Delete
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

<!-- Ban Modal -->
    <div class="modal fade modal-admin" id="banModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="" id="banForm">
                @csrf
                <input type="hidden" name="status" value="banned">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-shield-exclamation me-2 text-danger"></i>Ban User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        You are about to ban <strong id="banUsername" class="text-dark"></strong>.
                        Banned users will see a policy violation message and cannot access the platform.
                    </p>
                    <div class="mb-3">
                        <label class="form-label-admin" for="banReason">Reason (optional)</label>
                        <textarea name="reason" id="banReason" class="form-control form-control-admin" rows="2" placeholder="Why is this user being banned?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-shield-exclamation me-1"></i>Ban User
                    </button>
                </div>
            </form>
        </div>
    </div>

<!-- Delete User Confirmation Modal -->
    <div class="modal fade modal-admin" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="" id="deleteUserForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                        <span class="small">This action cannot be undone.</span>
                    </div>
                    <p class="small text-muted mb-3">
                        You are about to permanently delete <strong id="deleteUsername" class="text-dark"></strong>.
                        All associated data (enrollments, goals, habits, quiz attempts, scores, bug reports) will also be removed.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Permanently
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Unverified Users Confirmation Modal -->
    <div class="modal fade modal-admin" id="deleteUnverifiedModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="{{ route('admin.users.delete-unverified') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-envelope-exclamation me-2 text-warning"></i>Delete Unverified Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center gap-2 mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                        <span class="small">This action cannot be undone.</span>
                    </div>
                    <p class="small text-muted mb-3">
                        You are about to permanently delete <strong>{{ $unverifiedUsersCount ?? 0 }}</strong> user(s) who have <strong>not verified their email</strong>.
                        These users registered but never completed email verification.
                    </p>
                    <p class="small text-muted mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Admin accounts are excluded. Your own account is also excluded.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete {{ $unverifiedUsersCount ?? 0 }} Unverified User(s)
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Ban Modal — set the form action dynamically
    document.getElementById('banModal')?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const username = button.getAttribute('data-username');
        document.getElementById('banUsername').textContent = username;
        document.getElementById('banForm').action = '{{ url('admin/users') }}/' + userId + '/status';
    });

    // Delete User Modal — set the form action dynamically
    document.getElementById('deleteUserModal')?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const username = button.getAttribute('data-username');
        document.getElementById('deleteUsername').textContent = username;
        document.getElementById('deleteUserForm').action = '{{ url('admin/users') }}/' + userId + '/delete';
    });
</script>
@endpush
