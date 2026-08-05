@extends('editor.layout')

@section('title', 'Questions')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1f2937;">
                <i class="bi bi-question-circle me-2" style="color: #6366f1;"></i>Questions Management
            </h2>
            <p class="small text-muted mb-0">Manage assessment questions and options</p>
        </div>
        <a href="{{ route('editor.questions.create') }}" class="btn-editor-action create px-3 py-2">
            <i class="bi bi-plus-lg"></i> Create New Question
        </a>
    </div>

    @if(count($questions) > 0)
        <div class="content-card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-editor">
                    <thead>
                        <tr>
                            <th class="px-4">ID</th>
                            <th class="px-4">Question</th>
                            <th class="px-4 d-none d-md-table-cell">Skill</th>
                            <th class="px-4 d-none d-sm-table-cell">Type</th>
                            <th class="px-4 d-none d-sm-table-cell">Difficulty</th>
                            <th class="px-4 d-none d-sm-table-cell">Marks</th>
                            <th class="px-4 d-none d-sm-table-cell">Options</th>
                            <th class="px-4 d-none d-sm-table-cell">Locked</th>
                            <th class="px-4 d-none d-lg-table-cell">Created</th>
                            <th class="px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td class="px-4 text-secondary font-monospace">{{ $question->id }}</td>
                                <td class="px-4 fw-medium" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $question->question_text }}">
                                    {{ $question->question_text }}
                                </td>
                                <td class="px-4 d-none d-md-table-cell">{{ $question->skill->title ?? '—' }}</td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="badge" style="background: #eef2ff; color: #4338ca; font-size: 0.7rem; padding: 3px 8px; border-radius: 6px;">
                                        {{ $question->question_type === 'true_false' ? 'T/F' : 'MCQ' }}
                                    </span>
                                </td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="badge-difficulty {{ $question->difficulty }}">{{ $question->difficulty }}</span>
                                </td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="fw-bold" style="color: #d97706;">
                                        <i class="bi bi-star-fill me-1"></i>{{ number_format((float) $question->marks, 1) }}
                                    </span>
                                </td>
                                <td class="px-4 d-none d-sm-table-cell">
                                    <span class="fw-semibold">{{ $question->options->count() }}</span>
                                </td>
                                <td class="px-4 d-none d-sm-table-cell text-center">
                                    @if($question->locked_by_admin)
                                        <span class="text-danger"><i class="bi bi-lock-fill"></i></span>
                                    @else
                                        <span class="text-success"><i class="bi bi-unlock-fill"></i></span>
                                    @endif
                                </td>
                                <td class="px-4 d-none d-lg-table-cell text-secondary">
                                    {{ $question->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-4">
                                    <div class="actions-cell">
                                        <a href="{{ route('editor.questions.edit', $question->id) }}" class="btn-editor-action edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('editor.questions.delete', $question->id) }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn-editor-action delete" {{ $question->locked_by_admin ? 'disabled' : '' }}>
                                                <i class="bi bi-trash"></i>
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
        @if(method_exists($questions, 'links'))
            <div class="mt-3">{{ $questions->links() }}</div>
        @endif
    @else
        <div class="content-card p-5 text-center">
            <div class="py-4">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                <p class="fw-medium mt-3 mb-1" style="color: #6b7280;">No questions created yet</p>
                <p class="small text-muted mb-3">Create questions to assess your skills.</p>
                <a href="{{ route('editor.questions.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Create Your First Question
                </a>
            </div>
        </div>
    @endif
@endsection
