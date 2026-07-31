@extends('editor.layout')

@section('title', 'Skills')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1f2937;">
                <i class="bi bi-book me-2" style="color: #6366f1;"></i>Skills Management
            </h2>
            <p class="small text-muted mb-0">Manage your assessment skills</p>
        </div>
        <a href="{{ route('editor.skills.create') }}" class="btn-editor-action create px-3 py-2">
            <i class="bi bi-plus-lg"></i> Create New Skill
        </a>
    </div>

    @if(count($skills) > 0)
        <div class="content-card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-editor">
                    <thead>
                        <tr>
                            <th class="px-4">ID</th>
                            <th class="px-4">Title</th>
                            <th class="px-4 d-none d-md-table-cell">Slug</th>
                            <th class="px-4 d-none d-sm-table-cell">Status</th>
                            <th class="px-4 d-none d-sm-table-cell">Enrollments</th>
                            <th class="px-4 d-none d-lg-table-cell">Created</th>
                            <th class="px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skills as $skill)
                            <tr>
                                <td class="px-4 text-secondary font-monospace">{{ $skill->id }}</td>
                                <td class="px-4 fw-medium">{{ $skill->title }}</td>
                                <td class="px-4 d-none d-md-table-cell text-secondary">{{ $skill->slug }}</td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    @if($skill->locked_by_admin)
                                        <span class="badge-status locked"><i class="bi bi-lock me-1"></i>Locked</span>
                                    @else
                                        <span class="badge-status active"><i class="bi bi-unlock me-1"></i>Active</span>
                                    @endif
                                </td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="fw-semibold">{{ number_format($skill->enrollments_count) }}</span>
                                </td>
                                <td class="px-4 d-none d-lg-table-cell text-secondary">
                                    {{ $skill->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-4">
                                    <div class="actions-cell">
                                        <a href="{{ route('editor.skills.edit', $skill->id) }}" class="btn-editor-action edit">
                                            <i class="bi bi-pencil"></i>Edit
                                        </a>
                                        <form method="POST" action="{{ route('editor.skills.delete', $skill->id) }}" class="m-0" onsubmit="return confirm('Delete skill "{{ $skill->title }}"? This will also delete all associated questions and options.')">
                                            @csrf
                                            <button type="submit" class="btn-editor-action delete" {{ $skill->locked_by_admin ? 'disabled' : '' }}>
                                                <i class="bi bi-trash"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($skills, 'links'))
            <div class="mt-3">{{ $skills->links() }}</div>
        @endif
    @else
        <div class="content-card p-5 text-center">
            <div class="py-4">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                <p class="fw-medium mt-3 mb-1" style="color: #6b7280;">No skills created yet</p>
                <p class="small text-muted mb-3">Start building your assessment content.</p>
                <a href="{{ route('editor.skills.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Create Your First Skill
                </a>
            </div>
        </div>
    @endif
@endsection
