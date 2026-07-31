@extends('editor.layout')

@section('title', 'History')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1f2937;">
                <i class="bi bi-clock-history me-2" style="color: #6366f1;"></i>Skill Creation History
            </h2>
            <p class="small text-muted mb-0">Audit log of all skills you've created</p>
        </div>
        <form method="GET" action="{{ route('editor.history.index') }}" class="search-input-group d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search by title, slug, or ID..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
        </form>
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
                            <th class="px-4">Created</th>
                            <th class="px-4 d-none d-lg-table-cell">Updated</th>
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
                                    @elseif($skill->is_active)
                                        <span class="badge-status active"><i class="bi bi-unlock me-1"></i>Active</span>
                                    @else
                                        <span class="badge-status inactive">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="fw-semibold">{{ number_format($skill->enrollments_count) }}</span>
                                </td>
                                <td class="px-4 text-secondary">{{ $skill->created_at->format('M j, Y g:i A') }}</td>
                                <td class="px-4 d-none d-lg-table-cell text-secondary">{{ $skill->updated_at->format('M j, Y g:i A') }}</td>
                                <td class="px-4">
                                    <div class="actions-cell">
                                        <a href="{{ route('editor.skills.edit', $skill->id) }}" class="btn-editor-action view">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($skills, 'links'))
            <div class="mt-3 d-flex justify-content-center">{{ $skills->appends(['search' => $search])->links() }}</div>
        @endif
    @else
        <div class="content-card p-5 text-center">
            <div class="py-4">
                <i class="bi bi-clock-history" style="font-size: 3rem; color: #d1d5db;"></i>
                <p class="fw-medium mt-3 mb-1" style="color: #6b7280;">No history found</p>
                <p class="small text-muted mb-0">
                    @if($search)
                        No skills match your search. <a href="{{ route('editor.history.index') }}" class="text-decoration-none">Clear search</a>
                    @else
                        Start creating skills to see your history here.
                    @endif
                </p>
            </div>
        </div>
    @endif
@endsection
