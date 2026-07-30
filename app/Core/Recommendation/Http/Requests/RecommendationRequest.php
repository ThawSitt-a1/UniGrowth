<?php

declare(strict_types=1);

namespace App\Core\Recommendation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Authenticatable;

final class RecommendationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() instanceof Authenticatable;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Get the student ID from the authenticated user.
     */
    public function getStudentId(): int
    {
        return (int) $this->user()->getAuthIdentifier();
    }

    /**
     * Get the requested limit with a default fallback of 5.
     */
    public function getLimit(): int
    {
        return (int) ($this->integer('limit') ?: 5);
    }
}
