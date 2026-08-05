<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Auth\Models\User;

$user = User::query()->first();
if (!$user) {
    echo "No users found\n";
    exit;
}

echo "User ID: {$user->id}\n";
echo "Before: ".json_encode($user->preferences)."\n";

$user->forceFill(['preferences' => array_merge($user->preferences ?? [], ['privacy_hide_leaderboards' => true])])->save();

$fresh = User::query()->find($user->id);
echo "After save: ".json_encode($fresh->preferences)."\n";
echo "privacy_hide_leaderboards = ".var_export($fresh->preferences['privacy_hide_leaderboards'] ?? null, true)."\n";
