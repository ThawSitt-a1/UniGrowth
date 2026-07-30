<?php

namespace App\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrivacySocialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'visibility' => ['required', 'string', 'in:public,private'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['required_with:social_links', 'string', 'max:50', 'in:github,linkedin,portfolio,twitter,dribbble,other'],
            'social_links.*.url' => ['required_with:social_links', 'string', 'url', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'visibility.required' => 'Profile visibility setting is required.',
            'visibility.in' => 'Visibility must be either public or private.',
            'social_links.*.platform.in' => 'Platform must be one of: github, linkedin, portfolio, twitter, dribbble, other.',
            'social_links.*.url.url' => 'Please enter a valid URL for the social link.',
            'social_links.*.url.max' => 'Social link URL cannot exceed 500 characters.',
        ];
    }
}

