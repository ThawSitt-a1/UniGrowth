<?php

$html = file_get_contents(__DIR__.'/storage/app/goals_with_habit.html');

// Show the raw HTML region around the habit card buttons
$anchor = strpos($html, 'Complete Today');
$region = substr($html, $anchor - 200, 900);

echo "===== RAW HTML AROUND 'Complete Today' =====\n";
echo $region . "\n\n";

// Now parse with DOMDocument (HTML4 parser - but good enough for tag structure)
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);
libxml_clear_errors();

// Walk the habit card area and output form/button nesting
echo "===== FORM / BUTTON / INPUT TREE (browser DOM perspective) =====\n";
$xpath = new DOMXPath($doc);
$forms = $xpath->query('//form');
echo "Total <form> in DOM: " . $forms->length . "\n";

foreach ($forms as $i => $form) {
    $attrs = [];
    foreach ($form->attributes as $a) {
        $attrs[$a->name] = $a->value;
    }
    $onsubmit = $attrs['onsubmit'] ?? 'NONE';
    // Find all submit buttons within this form
    $submits = $xpath->query('.//button[contains(translate(@type,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"submit") or not(@type)]', $form);
    $btnTexts = [];
    foreach ($submits as $btn) {
        $btnTexts[] = trim($btn->textContent);
    }
    echo "  Form #$i onsubmit=" . $onsubmit . " submit-buttons=[" . implode(' | ', $btnTexts) . "]\n";
}

