<?php

namespace App\Auth\Controllers;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\DTOs\ResetPasswordDTO;
use App\Auth\Http\Requests\LoginRequest;
use App\Auth\Http\Requests\RegisterRequest;
use App\Auth\Http\Requests\RequestResetRequest;
use App\Auth\Http\Requests\ResetPasswordRequest;
use App\Auth\UseCases\AuthenticateUserUseCase;
use App\Auth\UseCases\RegisterUserUseCase;
use App\Auth\UseCases\ResetPasswordUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AuthController
{
    // Constructor Property Promotion
    public function __construct(
        private readonly AuthenticateUserUseCase $authenticateUserUseCase,
        private readonly RegisterUserUseCase $registerUserUseCase,
        private readonly ResetPasswordUseCase $resetPasswordUseCase,
    ) {}

    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $dto = new AuthCredentialsDTO(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
            username: $request->string('username')->toString(),
            remember: $request->boolean('remember'),
        );

        try {
            $user = $this->authenticateUserUseCase->execute($dto);
        } catch (\RuntimeException $e) {
            $message = $e->getMessage();

            if (str_contains($message, 'banned')) {
                $error = 'You are banned due to violation of our policy. Contact ourcompany@gmail.com';
            } elseif (str_contains($message, 'suspended')) {
                $error = 'Your account has been suspended due to a policy violation. Contact ourcompany@gmail.com';
            } else {
                $error = 'Invalid credentials.';
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $error,
                ], 401);
            }

            return redirect()->back()
                ->withErrors(['email' => $error])
                ->withInput($request->only('email'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
            ]);
        }

        // Web flow: redirect to dashboard
        return redirect()->intended('/dashboard');
    }

    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        $dto = new AuthCredentialsDTO(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
            username: $request->string('username')->toString(),
            remember: $request->boolean('remember'),
            academic_year: $request->string('academic_year')->toString(),
            major: $request->string('major')->toString(),
            university_name: $request->string('university_name')->toString(),
            terms_version: $request->string('terms_version')->toString(),
            privacy_policy_version: $request->string('privacy_policy_version')->toString(),
            consented: $request->boolean('agreed_to_terms'),
        );

        try {
            $user = $this->registerUserUseCase->execute($dto);
        } catch (\RuntimeException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 403);
            }

            return redirect()->back()
                ->withInput($request->except('password'))
                ->with('error', $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User registered successfully. Please verify your email.',
                'user' => $user,
            ], 201); // 201 Created
        }

        // Web flow: redirect to login page with verification message (no auto-login)
        return redirect()->route('login')
            ->with('status', 'Registration successful! Please check your email to verify your account before logging in.');
    }

    public function requestReset(RequestResetRequest $request): JsonResponse|RedirectResponse
    {
        $email = $request->string('email')->toString();
        $this->resetPasswordUseCase->requestReset($email);

        // If the request expects JSON (API client), return success message
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'If the email exists in our system, a password reset link has been sent.',
            ]);
        }

        // Web flow: redirect back with a success message (anti-enumeration)
        return redirect()->back()->with('status', 'If the email exists in our system, a password reset link has been sent.');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse|RedirectResponse
    {
        $dto = new ResetPasswordDTO(
            token: $request->string('token')->toString(),
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        try {
            $result = $this->resetPasswordUseCase->execute($dto);
        } catch (\RuntimeException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 400);
            }

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An unexpected error occurred. Please try again later.',
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again later.')
                ->withInput($request->only('email'));
        }

        if ($request->expectsJson()) {
            $statusCode = $result['success'] ? 200 : 400;

            return response()->json([
                'message' => $result['message'],
            ], $statusCode);
        }

        if ($result['success']) {
            return redirect()->intended('/dashboard')
                ->with('status', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput($request->only('email'));
    }
}
