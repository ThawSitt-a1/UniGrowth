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
@endsection
