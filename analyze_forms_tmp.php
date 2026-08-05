<?php

$html = file_get_contents(__DIR__.'/storage/app/goals_render_test.html');

// Walk through and find all <form ...> and </form> tags with positions.
preg_match_all('/<form[\s>]|<\/form>/i', $html, $matches, PREG_OFFSET_CAPTURE);

$stack = [];
echo "Tags found: ".count($matches[0])."\n";
foreach ($matches[0] as $i => $m) {
    $tag = $m[0];
    $pos = $m[1];
    if (str_starts_with($tag, '<form')) {
        // extract onsubmit
        if (preg_match('/onsubmit="([^"]*)"/', substr($html, $pos, 300), $os)) {
            echo "OPEN  at $pos  onsubmit=".var_export($os[1], true)."\n";
        } else {
            echo "OPEN  at $pos\n";
        }
        $stack[] = $pos;
    } else {
        $from = $stack ? array_pop($stack) : -1;
        echo "CLOSE at $pos  matches open at ".($from === -1 ? 'NONE!!!' : $from)."\n";
    }
}

// Check for actual nested <form> inside <form>
$depth = 0;
$nested = 0;
$lines = explode("\n", $html);
foreach ($lines as $ln => $line) {
    $opens = preg_match_all('/<form[\s>]/i', $line);
    $closes = preg_match_all('/<\/form>/i', $line);
    if ($opens > 0) {
        // check if a close appears before this open at depth>0 meaning interleaved
        $depth += $opens;
    }
    if ($closes > 0) {
        $depth -= $closes;
    }
    if ($depth > 1) {
        $nested++;
        echo "Line $ln: depth after line = $depth\n";
    }
    if ($depth < 0) {
        echo "Line $ln: NEGATIVE DEPTH $depth\n";
    }
}
echo "Max depth observed: nested conditions: $nested\n";

