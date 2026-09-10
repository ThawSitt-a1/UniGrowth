<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
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

    private static int $renderDepth = 0;

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response
    {
        if (self::$renderDepth > 0) {
            Log::error('Recursive exception in handler', ['exception' => get_class($e), 'message' => $e->getMessage()]);
            return $this->renderFallback($request, $e);
        }

        self::$renderDepth++;

        try {
            return $this->doRender($request, $e);
        } finally {
            self::$renderDepth--;
        }
    }

    private function renderFallback($request, Throwable $e): Response
    {
        if ($e instanceof ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Validation failed.',
                    'messages' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return response()->json(['error' => 'An unexpected error occurred.'], 500);
    }

    private function doRender($request, Throwable $e): Response
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

        if ($e instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->route('login');
        }

        if ($e instanceof AuthorizationException) {
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
            Log::error('Unhandled exception', ['exception' => get_class($e), 'message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }

        try {
            return parent::render($request, $e);
        } catch (Throwable $inner) {
            Log::error('Exception in parent::render', ['exception' => get_class($inner), 'message' => $inner->getMessage(), 'trace' => $inner->getTraceAsString()]);
            return $this->renderFallback($request, $inner);
        }
    }
}
