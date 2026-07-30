<?php

namespace App\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAvatarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Please select an image file.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'Allowed formats: JPEG, PNG.',
            'avatar.max' => 'Image size must not exceed 2MB.',
        ];
    }
}

