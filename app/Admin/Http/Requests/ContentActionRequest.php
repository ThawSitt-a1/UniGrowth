<?php

declare(strict_types=1);

namespace App\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ContentActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'target_id' => ['required', 'integer', 'min:1'],
            'target_type' => ['required', 'string', 'in:QUESTION,SKILL'],
            'action' => ['required', 'string', 'in:SUSPEND,RESTORE,DELETE'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

