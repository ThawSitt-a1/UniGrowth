@extends('editor.layout')

@section('title', $skill ? 'Edit Skill' : 'Create Skill')

@section('content')
    <div class="mb-4">
        <a href="{{ route('editor.skills.index') }}" class="text-decoration-none small mb-2 d-inline-flex align-items-center" style="color: #6b7280;">
            <i class="bi bi-arrow-left me-1"></i>Back to Skills
        </a>
        <h2 class="fw-bold mt-2" style="color: #1f2937;">
            <i class="bi bi-{{ $skill ? 'pencil' : 'plus-circle' }} me-2" style="color: #6366f1;"></i>
            {{ $skill ? 'Edit Skill' : 'Create New Skill' }}
        </h2>
    </div>

    <div class="content-card">
        <div class="card-body-custom">
            <form method="POST" action="{{ route('editor.skills.save') }}">
                @csrf

                @if($skill)
                    <input type="hidden" name="skill_id" value="{{ $skill->id }}">
                @endif

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-12 col-md-6">
                        <label class="form-label-editor" for="title">Skill Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title"
                               class="form-control form-control-editor @error('title') is-invalid @enderror"
                               value="{{ old('title', $skill->title ?? '') }}"
                               placeholder="e.g. Introduction to Algebra" required maxlength="255">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-12 col-md-6">
                        <label class="form-label-editor" for="slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" id="slug" name="slug"
                               class="form-control form-control-editor @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $skill->slug ?? '') }}"
                               placeholder="e.g. intro-to-algebra" required maxlength="255">
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text small text-muted">URL-friendly identifier. Auto-generated from title.</div>
                    </div>

                    <!-- Tags -->
                    <div class="col-12">
                        <label class="form-label-editor" for="tags">Category Tags</label>
                        <input type="text" id="tags" name="tags"
                               class="form-control form-control-editor @error('tags') is-invalid @enderror"
                               value="{{ old('tags', $skill && $skill->tags ? (is_array($skill->tags) ? implode(', ', $skill->tags) : $skill->tags) : '') }}"
                               placeholder="e.g. php, laravel, backend, api">
                        @error('tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text small text-muted">Comma-separated tags for filtering and recommendations.</div>
                    </div>

                    <!-- Short Description -->
                    <div class="col-12">
                        <label class="form-label-editor" for="description">Short Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="form-control form-control-editor @error('description') is-invalid @enderror"
                                  placeholder="A concise summary explaining the skill's value proposition...">{{ old('description', $skill->description ?? '') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text small text-muted">This is shown in the skill catalog before enrollment.</div>
                    </div>

                    <!-- Full Content (hidden until enrollment) -->
                    <div class="col-12">
                        <label class="form-label-editor" for="content">Full Curriculum Content</label>
                        <textarea id="content" name="content" rows="12"
                                  class="form-control form-control-editor @error('content') is-invalid @enderror"
                                  placeholder="Write the full lesson content here. Supports paragraphs, code snippets, and structured text. This content is only visible to enrolled users.">{{ old('content', $skill->content ?? '') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text small text-muted">
                            <i class="bi bi-lock me-1"></i> Hidden from non-enrolled users. Use clear headings and structured text for the best reading experience.
                        </div>
                    </div>

                    <!-- External Resource Links -->
                    <div class="col-12">
                        <label class="form-label-editor">External Resource Links</label>
                        <div id="resource-links-container">
                            @php
                                $links = [];
                                // Legacy single link
                                if (!empty($skill->resource_link)) {
                                    $links[] = ['url' => $skill->resource_link, 'label' => ''];
                                }
                                // Multiple links
                                if (!empty($skill->resource_links) && is_array($skill->resource_links)) {
                                    foreach ($skill->resource_links as $link) {
                                        if (!empty($link['url'])) {
                                            $links[] = $link;
                                        }
                                    }
                                }
                                // Default empty link if none exist
                                if (empty($links)) {
                                    $links[] = ['url' => '', 'label' => ''];
                                }
                            @endphp

                            @foreach($links as $index => $link)
                                <div class="resource-link-item mb-2">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-5">
                                            <input type="text"
                                                   name="resource_links[{{ $index }}][label]"
                                                   class="form-control form-control-editor"
                                                   value="{{ old('resource_links.' . $index . '.label', $link['label'] ?? '') }}"
                                                   placeholder="Link label (e.g. Official Docs)">
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <input type="url"
                                                   name="resource_links[{{ $index }}][url]"
                                                   class="form-control form-control-editor"
                                                   value="{{ old('resource_links.' . $index . '.url', $link['url'] ?? '') }}"
                                                   placeholder="https://example.com">
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger w-100 remove-link-btn" {{ count($links) === 1 ? 'disabled' : '' }}>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-link-btn">
                            <i class="bi bi-plus-circle me-1"></i>Add Another Link
                        </button>
                        <div class="form-text small text-muted mt-2">Add multiple resource links. Leave blank to remove.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('editor.skills.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg me-1"></i>{{ $skill ? 'Update Skill' : 'Create Skill' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from title
    document.getElementById('title')?.addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        if (!slugField.dataset.modified) {
            slugField.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        }
    });
    document.getElementById('slug')?.addEventListener('input', function() {
        this.dataset.modified = 'true';
    });

    // Dynamic resource links
    let linkIndex = {{ count($links ?? []) }};
    const container = document.getElementById('resource-links-container');
    const addBtn = document.getElementById('add-link-btn');

    function createLinkItem(index) {
        return `
            <div class="resource-link-item mb-2">
                <div class="row g-2">
                    <div class="col-12 col-md-5">
                        <input type="text"
                               name="resource_links[${index}][label]"
                               class="form-control form-control-editor"
                               placeholder="Link label (e.g. Official Docs)">
                    </div>
                    <div class="col-12 col-md-5">
                        <input type="url"
                               name="resource_links[${index}][url]"
                               class="form-control form-control-editor"
                               placeholder="https://example.com">
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="button" class="btn btn-sm btn-danger w-100 remove-link-btn">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    addBtn?.addEventListener('click', function() {
        container.insertAdjacentHTML('beforeend', createLinkItem(linkIndex));
        linkIndex++;
        updateRemoveButtons();
    });

    container?.addEventListener('click', function(e) {
        if (e.target.closest('.remove-link-btn')) {
            const items = container.querySelectorAll('.resource-link-item');
            if (items.length > 1) {
                e.target.closest('.resource-link-item').remove();
                updateRemoveButtons();
            }
        }
    });

    function updateRemoveButtons() {
        const items = container.querySelectorAll('.resource-link-item');
        const removeButtons = container.querySelectorAll('.remove-link-btn');
        removeButtons.forEach(btn => {
            btn.disabled = items.length === 1;
        });
    }
</script>
@endpush
