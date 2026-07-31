<?php

declare(strict_types=1);

namespace App\Editor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Convert the comma-separated tags string into an array
     * before validation rules are applied.
     */
    public function prepareForValidation(): void
    {
        $tags = $this->input('tags');

        if (is_string($tags)) {
            $tags = array_filter(array_map('trim', explode(',', $tags)));

            $this->merge([
                'tags' => $tags,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'skill_id' => ['nullable', 'integer', 'exists:skills,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('skills', 'slug')->ignore($this->input('skill_id'))],
            'description' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'content' => ['nullable', 'string'],
            'resource_link' => ['nullable', 'string', 'url', 'max:2048'],
            'resource_links' => ['nullable', 'array'],
            'resource_links.*.url' => ['nullable', 'url', 'max:2048'],
            'resource_links.*.label' => ['nullable', 'string', 'max:255'],
        ];
    }
}
