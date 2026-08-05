<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Auth\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;

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
        'platformName' => view()->shared('platformName') ?? 'UniGrowth',
        'message' => 'The platform is temporarily unavailable while we perform system updates.',
    ]);
})->name('maintenance');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
Route::get('/email/verify/{id}/{hash}', function (Request $request, string $id, string $hash) {
    $user = \App\Auth\Models\User::query()->findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
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
Route::post('/theme', [\App\Http\Controllers\ThemeController::class, 'toggle'])
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
    Route::get('/', [\App\Core\Assets\Controllers\CoreAssetsController::class, 'index'])->name('index');
    Route::get('/skills', [\App\Core\Assets\Controllers\CoreAssetsController::class, 'skills'])->name('skills');
    Route::get('/skills/{identifier}', [\App\Core\Assets\Controllers\CoreAssetsController::class, 'skillDetail'])->name('skills.detail');
    Route::post('/action', [\App\Core\Assets\Controllers\CoreAssetsController::class, 'handleAssetAction'])->name('action');
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
    Route::get('/', [\App\Core\Http\Controllers\CoreTestAssetsController::class, 'index'])->name('index');
    Route::post('/goal/create', [\App\Core\Http\Controllers\CoreTestAssetsController::class, 'createGoal'])->name('goal.create');
    Route::post('/goal/complete', [\App\Core\Http\Controllers\CoreTestAssetsController::class, 'completeGoal'])->name('goal.complete');
    Route::post('/goal/delete', [\App\Core\Http\Controllers\CoreTestAssetsController::class, 'deleteGoal'])->name('goal.delete');
    Route::post('/skill/enroll', [\App\Core\Http\Controllers\CoreTestAssetsController::class, 'enrollSkill'])->name('skill.enroll');
    Route::post('/skill/unenroll', [\App\Core\Http\Controllers\CoreTestAssetsController::class, 'unenrollSkill'])->name('skill.unenroll');
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
    Route::get('/', [\App\Core\Http\Controllers\CoreTestRecommendationsController::class, 'index'])->name('index');
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
    Route::get('/', [\App\Overview\Controllers\StudentOverviewWebController::class, 'index'])->name('index');
    Route::post('/season/end', [\App\Overview\Controllers\StudentOverviewWebController::class, 'endSeason'])->name('season.end');
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
    Route::get('/', [\App\Assessment\Controllers\TestAssessmentController::class, 'index'])->name('index');
    Route::post('/submit', [\App\Assessment\Controllers\TestAssessmentController::class, 'submit'])->name('submit');
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
    Route::get('/', [\App\Profile\Controllers\ProfileWebController::class, 'show'])->name('show');
    Route::put('/', [\App\Profile\Controllers\ProfileWebController::class, 'update'])->name('update');
    Route::post('/avatar', [\App\Profile\Controllers\ProfileWebController::class, 'uploadAvatar'])->name('avatar.upload');
    Route::patch('/preferences', [\App\Profile\Controllers\ProfileWebController::class, 'updatePreferences'])->name('preferences.update');
    Route::put('/privacy-social', [\App\Profile\Controllers\ProfileWebController::class, 'updatePrivacySocial'])->name('privacy-social.update');
    Route::get('/report', [\App\Profile\Controllers\ProfileWebController::class, 'downloadReport'])->name('report');
    Route::post('/bug-report', [\App\Profile\Controllers\ProfileWebController::class, 'submitBugReport'])->name('bug-report.submit');
    Route::put('/account', [\App\Profile\Controllers\ProfileWebController::class, 'updateAccount'])->name('account.update');
    // Public profile route must be last so it doesn't capture static paths above.
    Route::get('/{user}', [\App\Profile\Controllers\ProfileWebController::class, 'showPublic'])->name('public');
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
Route::middleware(['auth', 'auth.ensure', \App\Http\Middleware\EnsureIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Admin\Controllers\AdminConsoleController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Admin\Controllers\AdminConsoleController::class, 'users'])->name('users');
Route::post('/users/{id}/status', [\App\Admin\Controllers\AdminConsoleController::class, 'updateAccountStatus'])->name('users.status');
    Route::post('/users/{id}/role', [\App\Admin\Controllers\AdminConsoleController::class, 'assignRole'])->name('users.role');
Route::post('/users/{id}/delete', [\App\Admin\Controllers\AdminConsoleController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/delete-unverified', [\App\Admin\Controllers\AdminConsoleController::class, 'deleteUnverifiedUsers'])->name('users.delete-unverified');
    Route::get('/content', [\App\Admin\Controllers\AdminConsoleController::class, 'content'])->name('content');
    Route::post('/content/action', [\App\Admin\Controllers\AdminConsoleController::class, 'contentAction'])->name('content.action');
    Route::post('/content/{skillId}/comment', [\App\Admin\Controllers\AdminConsoleController::class, 'addContentComment'])->name('content.comment');
    Route::get('/settings', [\App\Admin\Controllers\AdminConsoleController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [\App\Admin\Controllers\AdminConsoleController::class, 'updateSettings'])->name('settings.update');
    Route::get('/bug-reports', [\App\Admin\Controllers\AdminConsoleController::class, 'bugReports'])->name('bug-reports');
    Route::get('/bug-reports/{id}', [\App\Admin\Controllers\AdminConsoleController::class, 'showBugReport'])->name('bug-reports.show');
    Route::get('/bug-reports/{id}/screenshot', [\App\Admin\Controllers\AdminConsoleController::class, 'showBugReportScreenshot'])->name('bug-reports.screenshot');

    // Editor Management
    Route::get('/editors', [\App\Admin\Controllers\AdminConsoleController::class, 'editors'])->name('editors');
    Route::post('/editors/{id}/suspend', [\App\Admin\Controllers\AdminConsoleController::class, 'suspendEditor'])->name('editors.suspend');
    Route::post('/editors/{id}/demote', [\App\Admin\Controllers\AdminConsoleController::class, 'demoteEditor'])->name('editors.demote');
    Route::post('/editors/{id}/delete', [\App\Admin\Controllers\AdminConsoleController::class, 'deleteEditor'])->name('editors.delete');
    Route::post('/editors/{id}/clear-remember', [\App\Admin\Controllers\AdminConsoleController::class, 'clearEditorRememberToken'])->name('editors.clear-remember');

// Bug Report Status & Delete
    Route::post('/bug-reports/{id}/status', [\App\Admin\Controllers\AdminConsoleController::class, 'updateBugReport'])->name('bug-reports.status');
    Route::post('/bug-reports/{id}/delete', [\App\Admin\Controllers\AdminConsoleController::class, 'deleteBugReport'])->name('bug-reports.delete');

    // Season Management
    Route::post('/seasons/start', [\App\Admin\Controllers\AdminConsoleController::class, 'startSeason'])->name('seasons.start');
    Route::post('/seasons/end', [\App\Admin\Controllers\AdminConsoleController::class, 'endSeason'])->name('seasons.end');
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
Route::middleware(['auth', 'auth.ensure', \App\Http\Middleware\EnsureIsEditor::class])->prefix('editor')->name('editor.')->group(function () {
    Route::get('/', [\App\Editor\Controllers\EditorConsoleController::class, 'dashboard'])->name('dashboard');
    Route::get('/skills', [\App\Editor\Controllers\EditorConsoleController::class, 'skillsIndex'])->name('skills.index');
    Route::get('/skills/create', [\App\Editor\Controllers\EditorConsoleController::class, 'editSkill'])->name('skills.create');
    Route::get('/skills/{id}/edit', [\App\Editor\Controllers\EditorConsoleController::class, 'editSkill'])->name('skills.edit');
    Route::post('/skills', [\App\Editor\Controllers\EditorConsoleController::class, 'saveSkill'])->name('skills.save');
    Route::post('/skills/{id}/delete', [\App\Editor\Controllers\EditorConsoleController::class, 'deleteSkill'])->name('skills.delete');
    Route::get('/questions', [\App\Editor\Controllers\EditorConsoleController::class, 'questionsIndex'])->name('questions.index');
    Route::get('/questions/create', [\App\Editor\Controllers\EditorConsoleController::class, 'editQuestion'])->name('questions.create');
    Route::get('/questions/{id}/edit', [\App\Editor\Controllers\EditorConsoleController::class, 'editQuestion'])->name('questions.edit');
    Route::post('/questions', [\App\Editor\Controllers\EditorConsoleController::class, 'saveQuestion'])->name('questions.save');
    Route::post('/questions/{id}/delete', [\App\Editor\Controllers\EditorConsoleController::class, 'deleteQuestion'])->name('questions.delete');
    Route::post('/options', [\App\Editor\Controllers\EditorConsoleController::class, 'saveOption'])->name('options.save');
    Route::post('/options/{id}/delete', [\App\Editor\Controllers\EditorConsoleController::class, 'deleteOption'])->name('options.delete');
    Route::get('/history', [\App\Editor\Controllers\EditorConsoleController::class, 'history'])->name('history.index');
    Route::get('/settings', [\App\Editor\Controllers\EditorConsoleController::class, 'settings'])->name('settings.index');
});
