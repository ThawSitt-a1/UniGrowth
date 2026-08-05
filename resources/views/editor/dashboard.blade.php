@extends('editor.layout')

@section('title', 'Dashboard')

@section('content')
    @php $hasContent = count($content['data'] ?? []) > 0; @endphp

    <!-- Metric Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: #ede9fe; color: #6d28d9;">
                    <i class="bi bi-book"></i>
                </div>
                <div class="stat-value">{{ number_format($totalSkills ?? 0) }}</div>
                <div class="stat-label">Total Skills Created</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                    <i class="bi bi-question-circle"></i>
                </div>
                <div class="stat-value">{{ number_format($totalQuestions ?? 0) }}</div>
                <div class="stat-label">Total Questions</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value">{{ number_format($totalEnrollments ?? 0) }}</div>
                <div class="stat-label">Total Enrollments</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef3c7; color: #b45309;">
                    <i class="bi bi-star"></i>
                </div>
                <div class="stat-value" style="font-size: 1.1rem; word-break: break-word;">
                    {{ $topEnrolledSkill ? $topEnrolledSkill->title : 'N/A' }}
                </div>
                <div class="stat-label">Top Enrolled Skill</div>
                @if($topEnrolledSkill)
                    <div class="stat-trend text-muted small mt-1">
                        {{ number_format($topEnrolledSkill->enrollments_count) }} enrollments
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <a href="{{ route('editor.skills.create') }}" class="text-decoration-none">
                <div class="content-card p-4 text-center h-100" style="transition: all 0.2s;">
                    <div class="mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: #eef2ff; color: #4f46e5;">
                            <i class="bi bi-plus-circle fs-4"></i>
                        </span>
                    </div>
                    <h6 class="fw-bold mb-1" style="color: #4338ca;">Create Skill</h6>
                    <p class="small text-muted mb-0">Add a new skill for assessment</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('editor.questions.create') }}" class="text-decoration-none">
                <div class="content-card p-4 text-center h-100" style="transition: all 0.2s;">
                    <div class="mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: #ecfdf5; color: #059669;">
                            <i class="bi bi-question-circle fs-4"></i>
                        </span>
                    </div>
                    <h6 class="fw-bold mb-1" style="color: #047857;">Create Question</h6>
                    <p class="small text-muted mb-0">Add questions to skills</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('editor.skills.index') }}" class="text-decoration-none">
                <div class="content-card p-4 text-center h-100" style="transition: all 0.2s;">
                    <div class="mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: #eff6ff; color: #2563eb;">
                            <i class="bi bi-list-check fs-4"></i>
                        </span>
                    </div>
                    <h6 class="fw-bold mb-1" style="color: #1d4ed8;">Manage Skills</h6>
                    <p class="small text-muted mb-0">View and manage your skills</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Skills -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="content-card">
                <div class="card-header-custom">
                    <h5><i class="bi bi-bookmark-star me-2"></i>Recent Skills</h5>
                    <a href="{{ route('editor.skills.index') }}" class="btn-editor-action view">View All</a>
                </div>
                <div class="card-body-custom p-0">
                    @if(count($recentSkills ?? []) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentSkills as $skill)
                                <div class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('editor.skills.edit', $skill->id) }}" class="fw-medium text-decoration-none" style="color: #1a1a2e;">{{ $skill->title }}</a>
                                        <div class="small text-muted mt-1">
                                            <span class="badge-status {{ $skill->locked_by_admin ? 'locked' : 'active' }}">{{ $skill->locked_by_admin ? 'Locked' : 'Active' }}</span>
                                            <span class="ms-2">{{ number_format($skill->enrollments_count) }} enrollments</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $skill->created_at->format('M j, Y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No skills created yet. <a href="{{ route('editor.skills.create') }}" class="text-decoration-none fw-medium">Create your first skill</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Questions -->
        <div class="col-12 col-lg-6">
            <div class="content-card">
                <div class="card-header-custom">
                    <h5><i class="bi bi-question-square me-2"></i>Recent Questions</h5>
                    <a href="{{ route('editor.questions.index') }}" class="btn-editor-action view">View All</a>
                </div>
                <div class="card-body-custom p-0">
                    @if($hasContent)
                        <div class="list-group list-group-flush">
                            @foreach(array_slice($content['data'] ?? [], 0, 5) as $item)
                                <div class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium" style="color: #1a1a2e;">{{ Str::limit($item['question_text'] ?? 'N/A', 50) }}</div>
                                        <div class="small text-muted mt-1">
                                            <span class="badge-difficulty {{ $item['difficulty'] ?? 'medium' }}">{{ $item['difficulty'] ?? 'medium' }}</span>
                                            <span class="ms-2">{{ $item['skill']['title'] ?? '—' }}</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ isset($item['created_at']) ? \Carbon\Carbon::parse($item['created_at'])->format('M j') : '' }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No questions yet. <a href="{{ route('editor.questions.create') }}" class="text-decoration-none fw-medium">Create your first question</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- All Content Table -->
    <h5 class="fw-bold mb-3" style="color: #1f2937;">
        <i class="bi bi-journal-text me-2" style="color: #6366f1;"></i>All Questions
    </h5>

    @if($hasContent)
        <div class="content-card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-editor">
                    <thead>
                        <tr>
                            <th class="px-4">ID</th>
                            <th class="px-4">Question</th>
                            <th class="px-4 d-none d-md-table-cell">Skill</th>
                            <th class="px-4 d-none d-sm-table-cell">Difficulty</th>
                            <th class="px-4 d-none d-sm-table-cell">Locked</th>
                            <th class="px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($content['data'] as $item)
                            <tr>
                                <td class="px-4 text-secondary font-monospace">{{ $item['id'] }}</td>
                                <td class="px-4 fw-medium">{{ Str::limit($item['question_text'] ?? 'N/A', 60) }}</td>
                                <td class="px-4 d-none d-md-table-cell">{{ $item['skill']['title'] ?? '—' }}</td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="badge-difficulty {{ $item['difficulty'] ?? 'medium' }}">{{ $item['difficulty'] ?? 'medium' }}</span>
                                </td>
                                <td class="px-4 d-none d-sm-table-cell text-center">
                                    @if ($item['is_locked'] ?? false)
                                        <span class="text-danger"><i class="bi bi-lock-fill"></i></span>
                                    @else
                                        <span class="text-success"><i class="bi bi-unlock-fill"></i></span>
                                    @endif
                                </td>
                                <td class="px-4">
                                    <div class="actions-cell">
                                        <a href="{{ route('editor.questions.edit', $item['id']) }}" class="btn-editor-action edit"><i class="bi bi-pencil"></i>Edit</a>
                                        <form method="POST" action="{{ route('editor.questions.delete', $item['id']) }}" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-editor-action delete"><i class="bi bi-trash"></i>Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(($content['last_page'] ?? 1) > 1)
            <nav class="mt-3" aria-label="Pagination">
                <ul class="pagination pagination-sm mb-0">
                    @foreach($content['links'] ?? [] as $link)
                        <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ empty($link['url']) ? 'disabled' : '' }}">
                            @if(!empty($link['url']))
                                <a class="page-link" href="{{ $link['url'] }}">{!! $link['label'] !!}</a>
                            @else
                                <span class="page-link">{!! $link['label'] !!}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
    @else
        <div class="content-card p-5 text-center">
            <div class="py-4">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                <p class="fw-medium mt-3 mb-1" style="color: #6b7280;">No content yet</p>
                <p class="small text-muted mb-0">Start by creating a skill or question above.</p>
            </div>
        </div>
    @endif
@endsection
