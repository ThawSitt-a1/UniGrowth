<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();
$app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$user = \App\Auth\Models\User::first();
if ($user) {
    Auth::login($user);
    echo 'Logged in as: '.$user->email."\n";
} else {
    echo "NO USER FOUND - skipping auth\n";
}

$request = Request::create('/core-assets', 'GET');
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request);

$content = $response->getContent();
echo 'HTTP status: '.$response->getStatusCode()."\n";
echo 'Bytes: '.strlen($content)."\n";

file_put_contents(__DIR__.'/storage/app/goals_http_response.html', $content);

preg_match_all('/<form[\s>]|<\/form>/i', $content, $matches, PREG_OFFSET_CAPTURE);
echo 'Form tags: '.count($matches[0])."\n";

preg_match_all('/confirm\([^)]*\)/i', $content, $confirms, PREG_OFFSET_CAPTURE);
echo 'confirm() calls: '.count($confirms[0])."\n";

// If this is a redirect, print it
if ($response->isRedirect()) {
    echo 'REDIRECT to: '.$response->headers->get('Location')."\n";
    exit;
}

