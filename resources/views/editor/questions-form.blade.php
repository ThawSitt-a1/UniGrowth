@extends('editor.layout')

@section('title', $question ? 'Edit Question' : 'Create Question')

@section('content')
    <div class="mb-4">
        <a href="{{ route('editor.questions.index') }}" class="text-decoration-none small mb-2 d-inline-flex align-items-center" style="color: #6b7280;">
            <i class="bi bi-arrow-left me-1"></i>Back to Questions
        </a>
        <h2 class="fw-bold mt-2" style="color: #1f2937;">
            <i class="bi bi-{{ $question ? 'pencil' : 'plus-circle' }} me-2" style="color: #6366f1;"></i>
            {{ $question ? 'Edit Question' : 'Create New Question' }}
        </h2>
    </div>

    <div class="content-card">
        <div class="card-body-custom">
            <form method="POST" action="{{ route('editor.questions.save') }}">
                @csrf

                @if($question)
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                @endif

                <div class="row g-3">
                    <!-- Skill Select -->
                    <div class="col-12 col-md-6">
                        <label class="form-label-editor" for="skill_id">Target Skill <span class="text-danger">*</span></label>
                        <select id="skill_id" name="skill_id" class="form-select form-control-editor @error('skill_id') is-invalid @enderror" required>
                            <option value="">— Select Skill —</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ old('skill_id', $question->skill_id ?? '') == $skill->id ? 'selected' : '' }}>
                                    {{ $skill->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('skill_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Question Type Selector -->
                    <div class="col-12 col-md-3">
                        <label class="form-label-editor" for="question_type">Question Type <span class="text-danger">*</span></label>
                        <select id="question_type" name="question_type" class="form-select form-control-editor @error('question_type') is-invalid @enderror" required>
                            <option value="multiple_choice" {{ old('question_type', $question->question_type ?? 'multiple_choice') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                            <option value="true_false" {{ old('question_type', $question->question_type ?? 'multiple_choice') == 'true_false' ? 'selected' : '' }}>True / False</option>
                        </select>
                        <div class="form-text small text-muted">
                            <i class="bi bi-info-circle"></i> True/False is worth fewer marks
                        </div>
                        @error('question_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Difficulty Selector -->
                    <div class="col-12 col-md-3">
                        <label class="form-label-editor" for="difficulty">Difficulty <span class="text-danger">*</span></label>
                        <select id="difficulty" name="difficulty" class="form-select form-control-editor @error('difficulty') is-invalid @enderror" required>
                            <option value="easy" {{ old('difficulty', $question->difficulty ?? '') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $question->difficulty ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $question->difficulty ?? '') == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Marks Display (auto-calculated) -->
                    <div class="col-12 col-md-6">
                        <label class="form-label-editor">Marks (Auto-calculated)</label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="form-control-editor bg-light d-flex align-items-center" style="cursor: not-allowed;">
                                <i class="bi bi-star-fill me-2 text-warning"></i>
                                <span id="marks-display" class="fw-bold fs-5" style="color: #6366f1;">{{ old('marks', $question->marks ?? 10) }}</span>
                                <span class="text-muted ms-1 small">marks</span>
                            </div>
                            <input type="hidden" name="marks" id="marks-input" value="{{ old('marks', $question->marks ?? 10) }}">
                        </div>
                        <div class="form-text small text-muted">
                            Marks are determined by type + difficulty (see table below)
                        </div>
                    </div>

                    <!-- Marks Matrix Reference -->
                    <div class="col-12 col-md-6">
                        <label class="form-label-editor">Marks Reference Table</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" style="font-size: 0.8rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Easy</th>
                                        <th class="text-center">Medium</th>
                                        <th class="text-center">Hard</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">Multiple Choice</td>
                                        <td class="text-center">{{ $marksMatrix['multiple_choice']['easy'] }}</td>
                                        <td class="text-center">{{ $marksMatrix['multiple_choice']['medium'] }}</td>
                                        <td class="text-center">{{ $marksMatrix['multiple_choice']['hard'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">True / False</td>
                                        <td class="text-center">{{ $marksMatrix['true_false']['easy'] }}</td>
                                        <td class="text-center">{{ $marksMatrix['true_false']['medium'] }}</td>
                                        <td class="text-center">{{ $marksMatrix['true_false']['hard'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div class="col-12">
                        <label class="form-label-editor" for="question_text">Question Text <span class="text-danger">*</span></label>
                        <textarea id="question_text" name="question_text" rows="4"
                                  class="form-control form-control-editor @error('question_text') is-invalid @enderror"
                                  placeholder="Enter the question text..." required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
                        @error('question_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('editor.questions.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg me-1"></i>{{ $question ? 'Update Question' : 'Create Question' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Options Management Section -->
    @if($question)
    <div class="content-card mt-4">
        <div class="card-header-custom">
            <h5><i class="bi bi-list-check me-2"></i>Options for Question #{{ $question->id }}</h5>
        </div>
        <div class="card-body-custom">
            @if($question->options->count() > 0)
                <div class="table-responsive mb-3">
                    <table class="table table-editor">
                        <thead>
                            <tr>
                                <th class="px-4">ID</th>
                                <th class="px-4">Option Text</th>
                                <th class="px-4 d-none d-sm-table-cell">Correct</th>
                                <th class="px-4 d-none d-sm-table-cell">Locked</th>
                                <th class="px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($question->options as $option)
                                <tr>
                                    <td class="px-4 text-secondary font-monospace">{{ $option->id }}</td>
                                    <td class="px-4 fw-medium">{{ $option->option_text }}</td>
                                    <td class="px-4 d-none d-sm-table-cell">
                                        @if($option->is_correct)
                                            <span class="badge-status active"><i class="bi bi-check-circle me-1"></i>Correct</span>
                                        @else
                                            <span class="badge-status inactive">Incorrect</span>
                                        @endif
                                    </td>
                                    <td class="px-4 d-none d-sm-table-cell text-center">
                                        @if($option->locked_by_admin)
                                            <span class="text-danger"><i class="bi bi-lock-fill"></i></span>
                                        @else
                                            <span class="text-success"><i class="bi bi-unlock-fill"></i></span>
                                        @endif
                                    </td>
                                    <td class="px-4">
                                        <div class="actions-cell">
                                            <button type="button" class="btn-editor-action edit" onclick="editOption({{ $option->id }}, '{{ addslashes($option->option_text) }}', {{ $option->is_correct ? 'true' : 'false' }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('editor.options.delete', $option->id) }}" class="m-0" onsubmit="return confirm('Delete this option?')">
                                                @csrf
                                                <button type="submit" class="btn-editor-action delete" {{ $option->locked_by_admin ? 'disabled' : '' }}>
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
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No options for this question yet. Add at least one correct option.</p>
                </div>
            @endif

            <!-- Add/Edit Option Form -->
            <div class="mt-3 pt-3 border-top">
                <h6 class="fw-bold mb-3" id="optionFormTitle" style="color: #1a1a2e;">
                    <i class="bi bi-plus-circle me-1"></i>Add New Option
                </h6>
                <form method="POST" action="{{ route('editor.options.save') }}" class="row g-2 align-items-end">
                    @csrf
                    <input type="hidden" name="option_id" id="option_id" value="">
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="col-12 col-md-6">
                        <label class="form-label-editor" for="option_text">Option Text <span class="text-danger">*</span></label>
                        <input type="text" id="option_text" name="option_text" class="form-control form-control-editor" placeholder="Enter option text..." required maxlength="500">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label-editor" for="is_correct">Correct Answer</label>
                        <select id="is_correct" name="is_correct" class="form-select form-control-editor">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i>Save Option
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" id="cancelEditOption" style="display:none;" onclick="cancelEditOption()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
    // ===== Marks auto-calculation based on type + difficulty =====
    const marksMatrix = @json($marksMatrix);
    const typeSelect = document.getElementById('question_type');
    const difficultySelect = document.getElementById('difficulty');
    const marksDisplay = document.getElementById('marks-display');
    const marksInput = document.getElementById('marks-input');

    function updateMarks() {
        const type = typeSelect.value;
        const difficulty = difficultySelect.value;
        const marks = marksMatrix[type]?.[difficulty] ?? 10;
        marksDisplay.textContent = marks;
        marksInput.value = marks;
    }

    if (typeSelect && difficultySelect) {
        typeSelect.addEventListener('change', updateMarks);
        difficultySelect.addEventListener('change', updateMarks);
        // Calculate on page load
        updateMarks();
    }

    function editOption(id, text, isCorrect) {
        document.getElementById('option_id').value = id;
        document.getElementById('option_text').value = text;
        document.getElementById('is_correct').value = isCorrect ? '1' : '0';
        document.getElementById('optionFormTitle').innerHTML = '<i class="bi bi-pencil me-1"></i>Edit Option';
        document.getElementById('cancelEditOption').style.display = 'inline-block';
    }

    function cancelEditOption() {
        document.getElementById('option_id').value = '';
        document.getElementById('option_text').value = '';
        document.getElementById('is_correct').value = '0';
        document.getElementById('optionFormTitle').innerHTML = '<i class="bi bi-plus-circle me-1"></i>Add New Option';
        document.getElementById('cancelEditOption').style.display = 'none';
    }
</script>
@endpush
