<?php

use Illuminate\Support\Facades\Route;
use App\Assessment\Controllers\AssessmentController;
use App\Assessment\Controllers\DashboardController;
use App\Core\Recommendation\Controllers\RecommendationController;

/*
|--------------------------------------------------------------------------
| Recommendation Engine API Routes
|--------------------------------------------------------------------------
|
| GET /api/recommendations?limit=5
|
| Returns personalized skill recommendations based on tag intersection
| (Jaccard-like similarity) against the authenticated student's enrolled skills.
|
*/

Route::middleware(['auth', 'auth.ensure', 'system.settings'])->group(function () {
    Route::get('/recommendations', [RecommendationController::class, 'getPersonalizedSuggestions'])
        ->name('api.recommendations');
});

/*
|--------------------------------------------------------------------------
| Skill Assessment & Ranking System API Routes
|--------------------------------------------------------------------------
|
| GET  /api/skills/{skill_id}/quiz   — Fetch unseen quiz questions
| POST /api/skills/{skill_id}/submit — Submit quiz answers for evaluation
| GET  /api/dashboard/{student_id}   — Aggregated student metrics
| GET  /api/leaderboard              — Top 10 ranked users
|
*/

Route::middleware(['auth', 'auth.ensure', 'system.settings'])->group(function () {
    Route::get('/skills/{skill_id}/quiz', [AssessmentController::class, 'getQuiz'])
        ->name('api.skills.quiz')
        ->whereNumber('skill_id');

    Route::post('/skills/{skill_id}/submit', [AssessmentController::class, 'submitQuiz'])
        ->name('api.skills.submit')
        ->whereNumber('skill_id');

    Route::get('/dashboard/{student_id}', [DashboardController::class, 'getDashboardMetrics'])
        ->name('api.dashboard')
        ->whereNumber('student_id');

    Route::get('/leaderboard', [DashboardController::class, 'getLeaderboard'])
        ->name('api.leaderboard');
});

/*
|--------------------------------------------------------------------------
| Student Overview Service API Routes
|--------------------------------------------------------------------------
|
| GET  /api/overview                   — Full student overview dashboard
| GET  /api/seasons/current            — Current active season info
| GET  /api/seasons/history            — Past seasons history
| GET  /api/seasons/{season_id}/leaderboard — Season leaderboard
|
*/

Route::middleware(['auth', 'auth.ensure', 'system.settings'])->group(function () {
    Route::get('/overview', [\App\Overview\Controllers\StudentOverviewController::class, 'getOverview'])
        ->name('api.overview');

    Route::get('/seasons/current', [\App\Overview\Controllers\StudentOverviewController::class, 'getCurrentSeasonInfo'])
        ->name('api.seasons.current');

    Route::get('/seasons/history', [\App\Overview\Controllers\StudentOverviewController::class, 'getSeasonHistory'])
        ->name('api.seasons.history');

    Route::get('/seasons/{season_id}/leaderboard', [\App\Overview\Controllers\StudentOverviewController::class, 'getSeasonLeaderboard'])
        ->name('api.seasons.leaderboard')
        ->whereNumber('season_id');
});

/*
|--------------------------------------------------------------------------
| Season Admin Routes (Admin Only)
|--------------------------------------------------------------------------
|
| POST /api/admin/seasons           — Create a new season
| POST /api/admin/seasons/end       — End current season
|
*/

Route::middleware(['auth', 'auth.ensure', 'system.settings'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::post('/seasons', [\App\Overview\Controllers\SeasonAdminController::class, 'createSeason'])
        ->name('seasons.create');

    Route::post('/seasons/end', [\App\Overview\Controllers\SeasonAdminController::class, 'endCurrentSeason'])
        ->name('seasons.end');
});
