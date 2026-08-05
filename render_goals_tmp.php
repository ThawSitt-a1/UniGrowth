<?php

// Bootstrap Laravel app manually
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;

$user = App\Auth\Models\User::first();
if ($user) {
    Auth::login($user);
}

$profile = [
    'goals' => [
        ['id' => 1, 'text' => 'First goal', 'status' => 'active', 'created_at' => now()->toDateTimeString(), 'completed_at' => null],
    ],
    'habits' => [
        [
            'id' => 1,
            'name' => 'Drink water',
            'description' => '8 glasses',
            'color' => '#6366f1',
            'icon' => 'bi-droplet-fill',
            'current_streak' => 2,
            'longest_streak' => 5,
            'total_completions' => 10,
            'completed_today' => false,
            'completion_dates' => [],
        ],
        [
            'id' => 2,
            'name' => 'Read 30 min',
            'description' => '',
            'color' => '#059669',
            'icon' => 'bi-book-fill',
            'current_streak' => 1,
            'longest_streak' => 3,
            'total_completions' => 4,
            'completed_today' => true,
            'completion_dates' => [],
        ],
    ],
];

$html = view('goals', ['profile' => $profile])->render();
file_put_contents(__DIR__.'/storage/app/goals_render_test.html', $html);

echo 'Rendered bytes: '.strlen($html)."\n";
echo 'Form open tags: '.substr_count($html, '<form')."\n";
echo 'Form close tags: '.substr_count($html, '</form>')."\n";
echo 'Completed Today text count: '.substr_count($html, 'Done Today')."\n";
echo "written to storage/app/goals_render_test.html\n";

