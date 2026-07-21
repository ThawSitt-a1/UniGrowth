<?php

namespace App\Auth\Controllers;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\DTOs\ResetPasswordDTO;
use App\Auth\Http\Requests\RegisterRequest;
use App\Auth\Http\Requests\LoginRequest;
use App\Auth\Http\Requests\RequestResetRequest;
use App\Auth\Http\Requests\ResetPasswordRequest;
use App\Auth\UseCases\AuthenticateUserUseCase;
use App\Auth\UseCases\RegisterUserUseCase;
use App\Auth\UseCases\ResetPasswordUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AuthController
{
    //Constructor Property Promotion
    public function __construct(
        private readonly AuthenticateUserUseCase $authenticateUserUseCase,
        private readonly RegisterUserUseCase $registerUserUseCase,
        private readonly ResetPasswordUseCase $resetPasswordUseCase,
    ) {
    }


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
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            return redirect()->back()
                ->withErrors(['email' => 'Invalid credentials.'])
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
        );

        $user = $this->registerUserUseCase->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
               'message' => 'User registered successfully. Please verify your email.',
               'user' => $user,
            ], 201); // 201 Created
        }

        // Web flow: auto-login and redirect to dashboard with verification message
        return redirect()->intended('/dashboard')
            ->with('status', 'Registration successful! Please check your email to verify your account.');
    }

    public function requestReset(RequestResetRequest $request): JsonResponse|RedirectResponse
    {
        $email = $request->string('email')->toString();
        $token = $this->resetPasswordUseCase->requestReset($email);

        // If the request expects JSON (API client), return token
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Reset token generated successfully. Use it to reset your password.',
                'token' => $token,
            ]);
        }

        // Web flow: redirect to the password reset form with token & email
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse|RedirectResponse
    {
        $dto = new ResetPasswordDTO(
            token: $request->string('token')->toString(),
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        $result = $this->resetPasswordUseCase->execute($dto);

        // If the request expects JSON (API client), return structured response
        if ($request->expectsJson()) {
            $statusCode = $result['success'] ? 200 : 400;
            return response()->json([
                'message' => $result['message'],
            ], $statusCode);
        }

        // Web flow: redirect with flash messages
        if ($result['success']) {
            return redirect()->intended('/dashboard')
                ->with('status', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput($request->only('email'));
    }
}

