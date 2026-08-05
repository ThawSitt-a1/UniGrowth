<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Core\Assets\Models\Habit;

DB::beginTransaction();

$user = \App\Auth\Models\User::first();
if (!$user) {
    echo "NO USER\n";
    exit(1);
}

Auth::login($user);

// Create a habit with realistic data
$habit = Habit::query()->create([
    'user_id'    => $user->id,
    'name'       => 'Drink 8 glasses of water',
    'description' => 'Morning routine',
    'icon'       => 'bi-droplet',
    'color'      => '#3b82f6',
]);

$request = Request::create('/core-assets', 'GET');
$response = $kernel->handle($request);

$content = $response->getContent();
echo 'HTTP status: '.$response->getStatusCode()."\n";
echo 'Bytes: '.strlen($content)."\n";

// Extract just the habits tab section around the delete form
$pos = strpos($content, 'Delete this habit');
echo "Delete confirm found at: ".($pos === false ? 'NO' : $pos)."\n";

// Find all form tags and their onsubmit
preg_match_all('/<form\b[^>]*>|<\/form>/i', $content, $forms, PREG_OFFSET_CAPTURE);
echo "Forms: ".count($forms[0])."\n";
foreach ($forms[0] as $f) {
    $tag = substr($content, $f[1], 120);
    echo "  ".$f[1].": ".preg_replace('/\s+/', ' ', $tag)."\n";
}

// Find all submit buttons
preg_match_all('/<button\b[^>]*type="submit"[^>]*>/i', $content, $subs, PREG_OFFSET_CAPTURE);
echo "\nSubmit buttons: ".count($subs[0])."\n";
foreach ($subs[0] as $b) {
    $before = substr($content, 0, $b[1]);
    $lastOpen = strrpos($before, '<form');
    $lastClose = strrpos($before, '</form>');
    $inForm = ($lastOpen !== false) && ($lastClose === false || $lastOpen > $lastClose);
    // Extract which form (get onsubmit from form open tag)
    $formTag = $lastOpen !== false ? substr($content, $lastOpen, 200) : '';
    $confirmMatch = preg_match('/onsubmit="([^"]*)"/', $formTag, $os);
    echo "  submit at ".$b[1]." => enclosing form onsubmit=".($confirmMatch ? $os[1] : 'NONE')."\n";
}

file_put_contents(__DIR__.'/storage/app/goals_with_habit.html', $content);

DB::rollBack();
echo "Done.\n";

