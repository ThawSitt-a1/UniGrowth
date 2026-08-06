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
                        <div class="form-text small text-muted" id="questionTypeNote">
                            <i class="bi bi-info-circle"></i> True/False is worth fewer marks.
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

</div>
    </div>

<!-- Inline Options Section -->
    @php
        $isTrueFalse = $question && $question->question_type === 'true_false';
        $maxOptions = $isTrueFalse ? 2 : 5;
        $optionLabels = ['A', 'B', 'C', 'D', 'E'];
        $existingOptions = $question ? $question->options->keyBy('id') : collect();
    @endphp
    <div class="content-card mt-4">
        <div class="card-header-custom">
            <h5><i class="bi bi-list-check me-2"></i>Options / Answers</h5>
            <span class="badge bg-secondary" id="option-count-badge">{{ $question ? $existingOptions->count() : 0 }} / <span id="max-options-display">{{ $maxOptions }}</span></span>
        </div>
        <div class="card-body-custom">
            <div class="alert alert-info py-2 mb-4" role="alert" style="font-size: 0.9rem;">
                <i class="bi bi-info-circle me-1"></i>
                <strong id="option-type-label">
                    @if($question && $question->question_type === 'true_false')
                        True/False question:
                    @elseif(!$question)
                        Multiple Choice:
                    @else
                        Multiple Choice:
                    @endif
                </strong>
                <span id="option-instruction-text">
                    @if($question && $question->question_type === 'true_false')
                        Provide exactly two options (True and False). Mark the single correct answer.
                    @else
                        Provide exactly {{ $maxOptions }} options. Mark the single correct answer.
                    @endif
                </span>
                The correct answer determines which option gives the student the marks.
            </div>

            <div id="options-container">
                @for($i = 0; $i < 5; $i++)
                    @php
                        $label = $optionLabels[$i] ?? chr(65 + $i);
                        $oldOptions = old('options', []);
                        $oldOpt = $oldOptions[$i] ?? null;
                        $optId = null;
                        $optText = '';
                        $isCorrect = false;

                        if ($oldOpt) {
                            $optText = $oldOpt['option_text'] ?? '';
                            $isCorrect = !empty($oldOpt['is_correct']);
                            $optId = $oldOpt['option_id'] ?? null;
                        } elseif ($existingOptions->isNotEmpty()) {
                            $opt = $existingOptions->values()[$i] ?? null;
                            if ($opt) {
                                $optText = $opt->option_text;
                                $isCorrect = $opt->is_correct;
                                $optId = $opt->id;
                            }
                        } elseif (!$question && $isTrueFalse && $i < 2) {
                            // Pre-fill for true/false on create
                            $optText = $i === 0 ? 'True' : 'False';
                        }
                    @endphp
                    <div class="option-row mb-3 p-3 border rounded" style="background: #f9fafb; {{ $isTrueFalse && $i >= 2 ? 'display: none;' : '' }}" id="option-row-{{ $i }}">
                        <div class="row g-2 align-items-center">
                            <input type="hidden" name="options[{{ $i }}][option_id]" value="{{ $optId }}">
                            <div class="col-12 col-md-1 text-center mb-2 mb-md-0">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 32px; height: 32px; background: #eef2ff; color: #4f46e5; font-size: 0.85rem;">
                                    {{ $label }}
                                </span>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="text" name="options[{{ $i }}][option_text]"
                                       class="form-control form-control-editor option-text-input"
                                       placeholder="Enter option {{ $label }} text..."
                                       value="{{ $optText }}"
                                       maxlength="500" required>
                            </div>
                            <div class="col-8 col-md-2">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input correct-radio" type="radio"
                                           name="correct_option"
                                           id="correct_{{ $i }}"
                                           value="{{ $i }}"
                                           {{ $isCorrect ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="correct_{{ $i }}">
                                        <span class="text-success fw-medium">Correct</span>
                                    </label>
                                    <input type="hidden" name="options[{{ $i }}][is_correct]" value="{{ $isCorrect ? '1' : '0' }}">
                                </div>
                            </div>
                            @if($optId && $question)
                            <div class="col-4 col-md-1 text-end">
                                @php
                                    $opt = $existingOptions->get($optId);
                                @endphp
                                @if($opt && !$opt->locked_by_admin)
                                <button type="button" class="btn btn-sm btn-outline-danger remove-option"
                                        data-option-id="{{ $optId }}"
                                        data-question-id="{{ $question->id }}"
                                        style="font-size: 0.75rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>

@error('options')
                <div class="alert alert-danger py-2 mt-2">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                </div>
            @enderror

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('editor.questions.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-check-lg me-1"></i>{{ $question ? 'Update Question' : 'Create Question' }}
                </button>
            </div>
        </div>
    </div>
    </form>
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

    function updateTypeNote() {
        const note = document.getElementById('questionTypeNote');
        if (!note || !typeSelect) return;

        if (typeSelect.value === 'true_false') {
            note.innerHTML = '<i class="bi bi-info-circle"></i> True/False questions are worth fewer marks. Options will be pre-filled.';
        } else {
            note.innerHTML = '<i class="bi bi-info-circle"></i> Multiple choice questions can have up to 5 options; mark one answer as correct.';
        }
    }

    function updateOptionsVisibility() {
        if (!typeSelect) return;
        const isTrueFalse = typeSelect.value === 'true_false';

        // Update all option rows
        const tfPrefill = ['True', 'False'];
        for (let i = 0; i < 5; i++) {
            const row = document.getElementById('option-row-' + i);
            if (!row) continue;
            const input = row.querySelector('.option-text-input');

            if (isTrueFalse && i >= 2) {
                row.style.display = 'none';
                if (input) input.removeAttribute('required');
            } else {
                row.style.display = '';
                if (input) input.setAttribute('required', 'required');

                // On create page (no question), pre-fill True/False
                @if(!$question)
                if (isTrueFalse && i < 2 && input && !input.value) {
                    input.value = tfPrefill[i];
                }
                @endif
            }
        }

        // Update the info box
        const typeLabel = document.getElementById('option-type-label');
        const instructionText = document.getElementById('option-instruction-text');
        const maxDisplay = document.getElementById('max-options-display');
        const badge = document.getElementById('option-count-badge');

        if (typeLabel) {
            typeLabel.textContent = isTrueFalse ? 'True/False question:' : 'Multiple Choice:';
        }
        if (instructionText) {
            instructionText.textContent = isTrueFalse
                ? 'Provide exactly two options (True and False). Mark the single correct answer.'
                : 'Provide exactly 5 options. Mark the single correct answer.';
        }
        if (maxDisplay) {
            maxDisplay.textContent = isTrueFalse ? '2' : '5';
        }
        if (badge) {
            const visibleCount = document.querySelectorAll('#options-container .option-row:not([style*="display: none"])').length;
            const filled = document.querySelectorAll('#options-container .option-row:not([style*="display: none"]) .option-text-input').length;
            badge.textContent = filled + ' / ' + (isTrueFalse ? '2' : '5');
        }
    }

    if (typeSelect && difficultySelect) {
        typeSelect.addEventListener('change', function () {
            updateMarks();
            updateTypeNote();
            updateOptionsVisibility();
        });
        difficultySelect.addEventListener('change', updateMarks);
        updateMarks();
        updateTypeNote();
        updateOptionsVisibility();
    }

    // ===== Sync hidden is_correct fields with radio buttons =====
    document.querySelectorAll('.correct-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset all hidden is_correct fields to 0
            document.querySelectorAll('input[name^="options"][name$="[is_correct]"]').forEach(hidden => {
                hidden.value = '0';
            });
            // Set the selected one to 1
            const index = this.value;
            const hiddenInput = document.querySelector(`input[name="options[${index}][is_correct]"]`);
            if (hiddenInput) {
                hiddenInput.value = '1';
            }
        });
    });

    // ===== Delete option via form submission =====
    document.querySelectorAll('.remove-option').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Delete this option? This cannot be undone.')) {
                const optionId = this.dataset.optionId;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url('editor/options') }}/' + optionId + '/delete';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@endpush
