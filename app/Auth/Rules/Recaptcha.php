<?php

namespace App\Auth\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (empty($value)) {
            \Log::error('reCAPTCHA: No token received from frontend!');
            return false;
        }
        if (!is_string($value) || $value === '') {
            return false;
        }

        $secret = config('services.recaptcha.secret');
        if (!is_string($secret) || $secret === '') {
            return false;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (!$response instanceof Response) {
            return false;
        }

        $json = $response->json();

        // Capture Google error-codes to diagnose invalid secret / invalid token / etc.
        \Log::error('reCAPTCHA verification result', [
            'success' => $json['success'] ?? null,
            'hostname' => $json['hostname'] ?? null,
            'error-codes' => $json['error-codes'] ?? null,
        ]);

        return isset($json['success']) && $json['success'] === true;
    }

    public function message(): string
    {
        return 'Captcha verification failed.';
    }
}

