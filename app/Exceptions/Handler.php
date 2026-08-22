<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Validation failed.',
                    'messages' => $e->errors(),
                ], 422);
            }

            return parent::render($request, $e);
        }

        if ($e instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Resource not found.',
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        }

        if ($e instanceof ThrottleRequestsException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Too many requests. Please try again later.',
                ], 429);
            }

            return response()->view('errors.429', [], 429);
        }

        if ($e instanceof PostTooLargeException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'The uploaded file exceeds the maximum allowed size.',
                ], 413);
            }

            return redirect()->back()->with('error', 'The uploaded file exceeds the maximum allowed size.');
        }

        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->route('login');
        }

        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Forbidden. You do not have permission to perform this action.',
                ], 403);
            }

            return abort(403, 'Forbidden. You do not have permission to perform this action.');
        }

        if ($e instanceof \RuntimeException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 400);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($e instanceof \InvalidArgumentException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }

        return parent::render($request, $e);
    }
}
