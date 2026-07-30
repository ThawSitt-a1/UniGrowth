<?php

declare(strict_types=1);

namespace App\Editor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'skill_id' => ['nullable', 'integer', 'exists:skills,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:skills,slug,' . $this->input('skill_id')],
            'description' => ['nullable', 'string'],
        ];
    }
}
