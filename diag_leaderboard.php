<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Auth\Models\User;
use App\Overview\Models\Season;
use App\Overview\Models\SeasonScore;

echo "=== USERS ===\n";
foreach (User::query()->get(['id','username','role','platform_score']) as $u) {
    echo "{$u->id} | {$u->username} | {$u->role} | platform={$u->platform_score}\n";
}

echo "\n=== SEASONS ===\n";
foreach (Season::query()->get() as $s) {
    echo "{$s->id} | {$s->name} | active=".var_export((bool)$s->is_active, true)."\n";
}

echo "\n=== SEASON SCORES ===\n";
foreach (SeasonScore::query()->with('user:id,username,role')->get() as $sc) {
    $uname = $sc->user->username ?? '?';
    $urole = $sc->user->role ?? '?';
    echo "season={$sc->season_id} | user={$sc->user_id} ($uname/$urole) | score={$sc->total_score} | skills={$sc->skill_count}\n";
}

echo "\n=== PREFERENCES ===\n";
foreach (User::query()->get(['id','username','preferences']) as $u) {
    echo "{$u->id} | {$u->username} | ".json_encode($u->preferences)."\n";
}
