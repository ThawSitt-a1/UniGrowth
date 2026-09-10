<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

View::share('errors', new ViewErrorBag);

$pages = ['landing', 'about-team', 'login', 'auth.register'];

foreach ($pages as $view) {
    $html = View::make($view)->render();

    // Find all <link rel="stylesheet" ...> and <script src> and preconnect hints
    preg_match_all('/<link[^>]*rel="stylesheet"[^>]*>/i', $html, $cssLinks);
    preg_match_all('/<script[^>]*src="([^"]+)"[^>]*>/i', $html, $scripts);
    preg_match_all('/rel="(preconnect|dns-prefetch)" href="([^"]+)"/', $html, $hints);

    $blocking = 0;
    foreach ($cssLinks[0] as $link) {
        if (!preg_match('/media="/', $link)) { $blocking++; }
        if (preg_match('/media="print"/', $link)) { $rendering++; }
    }

    echo "== {$view} ==".PHP_EOL;
    echo '  stylesheet links: '.count($cssLinks[0]).' | render-blocking (no media): '.$blocking.PHP_EOL;
    foreach ($cssLinks[0] as $link) {
        echo '    '.trim(preg_replace('/\s+/', ' ', $link)).PHP_EOL;
    }
    echo '  scripts:';
    foreach ($scripts[1] as $s) { echo ' '.$s; }
    echo PHP_EOL;
    echo '  hints: '.count($hints[0]).' (dns='.substr_count($html, 'dns-prefetch').')';
    echo PHP_EOL;

    echo '  bundle deferred: '.(preg_match('/bootstrap\.bundle\.min\.js" defer/', $html) ? 'yes' : 'no').PHP_EOL;
    echo '  recaptcha script: '.(str_contains($html, 'recaptcha/api.js') ? 'yes' : 'no').PHP_EOL;
    echo '  icons local css: '.(str_contains($html, 'css/bootstrap-icons.min.css') ? 'yes' : 'no').PHP_EOL;
    echo PHP_EOL;
}
