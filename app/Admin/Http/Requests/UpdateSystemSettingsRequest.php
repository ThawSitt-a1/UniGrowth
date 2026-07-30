<?php

declare(strict_types=1);

namespace App\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateSystemSettingsRequest extends FormRequest
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
            'setting_key' => ['required', 'string', 'max:100'],
            'setting_value' => ['required', 'string', 'max:65535'],
        ];
    }
}

