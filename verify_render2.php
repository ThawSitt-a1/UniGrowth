<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Auth\Models\User;
use App\Profile\UseCases\ManageProfileUseCase;

$user = User::query()->first();
echo "User ID: {$user->id}\n";
echo "DB preferences: ".json_encode($user->preferences)."\n";

$uc = app(ManageProfileUseCase::class);
$profile = $uc->getProfile($user->id);
$arr = $profile->toArray();
echo "ProfileDTO preferences: ".json_encode($arr['preferences'])."\n";
echo "privacy_hide_leaderboards from DTO: ".var_export($arr['preferences']['privacy_hide_leaderboards'] ?? null, true)."\n";
