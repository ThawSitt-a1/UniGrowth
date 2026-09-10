<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

use App\Admin\Controllers\AdminConsoleController;
use App\Assessment\Controllers\TestAssessmentController;
use App\Auth\Controllers\AuthController;
use App\Auth\Models\User;
use App\Core\Assets\Controllers\CoreAssetsController;
use App\Core\Http\Controllers\CoreTestAssetsController;
use App\Core\Http\Controllers\CoreTestRecommendationsController;
use App\Editor\Controllers\EditorConsoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ThemeController;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsEditor;
use App\Overview\Controllers\StudentOverviewWebController;
use App\Profile\Controllers\ProfileWebController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Landing Page (Unauthenticated Users)
|--------------------------------------------------------------------------
|
| GET / — Public landing page for guests. Authenticated users are
| redirected to /dashboard by the LandingController.
|
*/
Route::get('/', LandingController::class)->name('home');

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
|
| Two-step password reset flow:
|   1. GET  /reset-password         — Show email input form
|   2. POST /request-reset          — Generate & return reset token
|   3. GET  /reset-password/{token} — Show new password form (with token & email)
|   4. POST /reset-password         — Validate token & update password
|
*/

// Step 1: Show the "Forgot Password" email input form
Route::get('/reset-password', function () {
    return view('forgot-password-request');
})->name('password.request');

// Step 2: Handle email submission — generate reset token
Route::post('/request-reset', [AuthController::class, 'requestReset'])
    ->middleware('throttle:5,1')
    ->name('password.email');

// Step 3: Show the "Set New Password" form with pre-filled token & email
Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
})->middleware('guest')->name('password.reset');

// Step 4: Handle password reset form submission — update password, no auto-login
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1');

Route::get('/maintenance', function () {
    return view('maintenance', [
        'platformName' => View::shared('platformName', 'UniGrowth'),
        'message' => 'The platform is temporarily unavailable while we perform system updates.',
    ]);
})->name('maintenance');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
Route::get('/email/verify/{id}/{hash}', function (Request $request, string $id, string $hash) {
    $user = User::query()->findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();

        $user->forceFill([
            'remember_token' => Str::random(60),
            'remember_token_expires_at' => now()->addWeek(),
        ])->save();
    }

    Auth::guard('web')->login($user, false);

    $request->session()->regenerate();
    $request->session()->save();

    return redirect('/dashboard')->with('status', 'Email verified successfully! You are now logged in.');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'auth.ensure', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Legal Pages Routes
|--------------------------------------------------------------------------
*/
Route::get('/terms-of-service', function () {
    return view('legal.terms-of-service');
})->name('terms-of-service');

Route::get('/privacy-policy', function () {
    return view('legal.privacy-policy');
})->name('privacy-policy');

/*
|--------------------------------------------------------------------------
| About Team Route
|--------------------------------------------------------------------------
*/
Route::get('/about-team', function () {
    return view('about-team');
})->name('about-team');

/*
|--------------------------------------------------------------------------
| Dashboard & Utility Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'auth.ensure'])
    ->name('dashboard');

Route::post('/logout', function () {
    auth()->guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Theme Toggle Route
|--------------------------------------------------------------------------
|
| POST /theme — Switch light / dark mode. Persists to the authenticated
| user's preferences, or stores a `theme` cookie for guests.
*/
Route::post('/theme', [ThemeController::class, 'toggle'])
    ->name('theme.toggle');

/*
|--------------------------------------------------------------------------
| Core Services Routes (Authenticated Users Only - SSR)
|--------------------------------------------------------------------------
|
| - GET  /core-assets       — View & manage goals, enrolled skills
| - GET  /core-assets/skills — Browse all available skills with tag filter & sort
| - POST /core-assets/action — Perform asset actions (goal CRUD, skill enrollment)
|
*/

Route::middleware(['auth', 'auth.ensure'])->prefix('core-assets')->name('core-assets.')->group(function () {
    Route::get('/', [CoreAssetsController::class, 'index'])->name('index');
    Route::get('/skills', [CoreAssetsController::class, 'skills'])->name('skills');
    Route::get('/skills/{identifier}', [CoreAssetsController::class, 'skillDetail'])->name('skills.detail');
    Route::post('/action', [CoreAssetsController::class, 'handleAssetAction'])->name('action');
});

/*
|--------------------------------------------------------------------------
| Core Service Testing Frontend (Authenticated Users Only)
|--------------------------------------------------------------------------
|
| Deliberately ugly/minimal testing UI for Core Assets functionality.
| Exercises ManageUserAssetsUseCase & GetUserActivityUseCase directly.
|
*/
Route::middleware(['auth', 'auth.ensure'])->prefix('core/test')->name('core.test-assets.')->group(function () {
    Route::get('/', [CoreTestAssetsController::class, 'index'])->name('index');
    Route::post('/goal/create', [CoreTestAssetsController::class, 'createGoal'])->name('goal.create');
    Route::post('/goal/complete', [CoreTestAssetsController::class, 'completeGoal'])->name('goal.complete');
    Route::post('/goal/delete', [CoreTestAssetsController::class, 'deleteGoal'])->name('goal.delete');
    Route::post('/skill/enroll', [CoreTestAssetsController::class, 'enrollSkill'])->name('skill.enroll');
    Route::post('/skill/unenroll', [CoreTestAssetsController::class, 'unenrollSkill'])->name('skill.unenroll');
});

/*
|--------------------------------------------------------------------------
| Recommendation Engine Testing Frontend (Authenticated Users Only)
|--------------------------------------------------------------------------
|
| Deliberately ugly/minimal testing UI for the Recommendation Engine.
| Exercises GenerateRecommendationsUseCase (Jaccard tag intersection).
|
*/
Route::middleware(['auth', 'auth.ensure'])->prefix('core/test/recommendations')->name('core.test-recommendations.')->group(function () {
    Route::get('/', [CoreTestRecommendationsController::class, 'index'])->name('index');
});

/*
|--------------------------------------------------------------------------
| Student Overview Service - SSR Web UI (Authenticated Users Only)
|--------------------------------------------------------------------------
|
| GET  /overview          — Full student overview dashboard
| POST /overview/season/end — End current season (admin action)
|
*/
Route::middleware(['auth', 'auth.ensure'])->prefix('overview')->name('overview.')->group(function () {
    Route::get('/', [StudentOverviewWebController::class, 'index'])->name('index');
    Route::post('/season/end', [StudentOverviewWebController::class, 'endSeason'])->name('season.end');
});

/*
|--------------------------------------------------------------------------
| Skill Assessment & Ranking System - Browser Test UI (Authenticated Users Only)
|--------------------------------------------------------------------------
|
| End-to-end testing UI for the Skill Assessment & Ranking module.
| Exercises QuizDeliveryService, EvaluateQuizUseCase, StudentDashboardService.
|
*/
Route::middleware(['auth', 'auth.ensure'])->prefix('assessment/test')->name('assessment.test.')->group(function () {
    Route::get('/', [TestAssessmentController::class, 'index'])->name('index');
    Route::post('/submit', [TestAssessmentController::class, 'submit'])->name('submit');
});

/*
|--------------------------------------------------------------------------
| Profile & Account Manager Routes (Authenticated Users Only - SSR)
|--------------------------------------------------------------------------
|
| Single-page profile management with CSS fragment scrolling.
| Sections: Account Detail, Preferences, Bug Report.
| Livewire is used for profile updates (picture, username, major, etc.).
|
*/
Route::middleware(['auth', 'auth.ensure'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileWebController::class, 'show'])->name('show');
    Route::put('/', [ProfileWebController::class, 'update'])->name('update');
    Route::post('/avatar', [ProfileWebController::class, 'uploadAvatar'])->name('avatar.upload');
    Route::patch('/preferences', [ProfileWebController::class, 'updatePreferences'])->name('preferences.update');
    Route::put('/privacy-social', [ProfileWebController::class, 'updatePrivacySocial'])->name('privacy-social.update');
    Route::get('/report', [ProfileWebController::class, 'downloadReport'])->name('report');
    Route::post('/bug-report', [ProfileWebController::class, 'submitBugReport'])->name('bug-report.submit');
    Route::put('/account', [ProfileWebController::class, 'updateAccount'])->name('account.update');
    Route::get('/security', [ProfileWebController::class, 'showSecurity'])->name('security');
    Route::get('/delete-account', [ProfileWebController::class, 'showDeleteAccount'])->name('delete-account');
    // Public profile route must be last so it doesn't capture static paths above.
    Route::get('/{user}', [ProfileWebController::class, 'showPublic'])->name('public');
});

/*
|--------------------------------------------------------------------------
| Admin Console Routes (Admin Only - SSR)
|--------------------------------------------------------------------------
|
| Provides the admin management interface including dashboard metrics,
| user management, content moderation, system settings, and bug reports.
|
*/
Route::middleware(['auth', 'auth.ensure', EnsureIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminConsoleController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminConsoleController::class, 'users'])->name('users');
    Route::post('/users/{id}/status', [AdminConsoleController::class, 'updateAccountStatus'])->name('users.status');
    Route::post('/users/{id}/role', [AdminConsoleController::class, 'assignRole'])->name('users.role');
    Route::post('/users/{id}/delete', [AdminConsoleController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/delete-unverified', [AdminConsoleController::class, 'deleteUnverifiedUsers'])->name('users.delete-unverified');
    Route::get('/content', [AdminConsoleController::class, 'content'])->name('content');
    Route::post('/content/action', [AdminConsoleController::class, 'contentAction'])->name('content.action');
    Route::post('/content/{skillId}/comment', [AdminConsoleController::class, 'addContentComment'])->name('content.comment');
    Route::get('/settings', [AdminConsoleController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [AdminConsoleController::class, 'updateSettings'])->name('settings.update');
    Route::get('/bug-reports', [AdminConsoleController::class, 'bugReports'])->name('bug-reports');
    Route::get('/bug-reports/{id}', [AdminConsoleController::class, 'showBugReport'])->name('bug-reports.show');
    Route::get('/bug-reports/{id}/screenshot', [AdminConsoleController::class, 'showBugReportScreenshot'])->name('bug-reports.screenshot');

    // Editor Management
    Route::get('/editors', [AdminConsoleController::class, 'editors'])->name('editors');
    Route::post('/editors/{id}/suspend', [AdminConsoleController::class, 'suspendEditor'])->name('editors.suspend');
    Route::post('/editors/{id}/demote', [AdminConsoleController::class, 'demoteEditor'])->name('editors.demote');
    Route::post('/editors/{id}/delete', [AdminConsoleController::class, 'deleteEditor'])->name('editors.delete');
    Route::post('/editors/{id}/clear-remember', [AdminConsoleController::class, 'clearEditorRememberToken'])->name('editors.clear-remember');

    // Bug Report Status & Delete
    Route::post('/bug-reports/{id}/status', [AdminConsoleController::class, 'updateBugReport'])->name('bug-reports.status');
    Route::post('/bug-reports/{id}/delete', [AdminConsoleController::class, 'deleteBugReport'])->name('bug-reports.delete');

    // Season Management
    Route::post('/seasons/start', [AdminConsoleController::class, 'startSeason'])->name('seasons.start');
    Route::post('/seasons/end', [AdminConsoleController::class, 'endSeason'])->name('seasons.end');
    Route::post('/seasons/image', [AdminConsoleController::class, 'updateSeasonImage'])->name('seasons.image');
});

/*
|--------------------------------------------------------------------------
| Editor Console Routes (Editor/Admin Only - SSR)
|--------------------------------------------------------------------------
|
| Provides the editor management interface for creating and managing
| skills, questions, and options. Admins can also access these routes.
|
*/
Route::middleware(['auth', 'auth.ensure', EnsureIsEditor::class])->prefix('editor')->name('editor.')->group(function () {
    Route::get('/', [EditorConsoleController::class, 'dashboard'])->name('dashboard');
    Route::get('/skills', [EditorConsoleController::class, 'skillsIndex'])->name('skills.index');
    Route::get('/skills/create', [EditorConsoleController::class, 'editSkill'])->name('skills.create');
    Route::get('/skills/{id}/edit', [EditorConsoleController::class, 'editSkill'])->name('skills.edit');
    Route::post('/skills', [EditorConsoleController::class, 'saveSkill'])->name('skills.save');
    Route::post('/skills/{id}/delete', [EditorConsoleController::class, 'deleteSkill'])->name('skills.delete');
    Route::get('/questions', [EditorConsoleController::class, 'questionsIndex'])->name('questions.index');
    Route::get('/questions/create', [EditorConsoleController::class, 'editQuestion'])->name('questions.create');
    Route::get('/questions/{id}/edit', [EditorConsoleController::class, 'editQuestion'])->name('questions.edit');
    Route::post('/questions', [EditorConsoleController::class, 'saveQuestion'])->name('questions.save');
    Route::post('/questions/{id}/delete', [EditorConsoleController::class, 'deleteQuestion'])->name('questions.delete');
    Route::post('/options', [EditorConsoleController::class, 'saveOption'])->name('options.save');
    Route::post('/options/{id}/delete', [EditorConsoleController::class, 'deleteOption'])->name('options.delete');
    Route::get('/history', [EditorConsoleController::class, 'history'])->name('history.index');
    Route::get('/settings', [EditorConsoleController::class, 'settings'])->name('settings.index');
});
