<?php

/**
 * ContentCleaner icon, colour, scope and responsive-style contract.
 *
 * Related files: Assets/css/content-cleaner.css,
 * Assets/css/content-cleaner-icons.css, Assets/css/messages.css and
 * Template/config/cleaner.php.
 */

$pluginRoot = dirname(__DIR__);
$mainCss = file_get_contents($pluginRoot . '/Assets/css/content-cleaner.css');
$iconCss = file_get_contents($pluginRoot . '/Assets/css/content-cleaner-icons.css');
$messageCss = file_get_contents($pluginRoot . '/Assets/css/messages.css');
$template = file_get_contents($pluginRoot . '/Template/config/cleaner.php');
$failures = array();

preg_match_all('/data:image\/svg\+xml,[^"\r\n]+/', $iconCss, $iconMatches);
$iconHash = hash('sha256', implode("\n", $iconMatches[0]));
if (count($iconMatches[0]) !== 13 || $iconHash !== '835f9bacc397bc757805c1fa922717d62cbb1a38295534aa559b4bfcc49fe6c9') {
    $failures[] = 'The established SVG icon payloads changed.';
}

foreach (array('#007AC9', '#00ADFF', '#B71234', '#DA004C', '#AE003D', '#2EA02E', '#FF6500', '#F4290E') as $color) {
    if (strpos($mainCss, $color) === false) {
        $failures[] = 'An established interface colour is missing: ' . $color;
    }
}

foreach (array('.content-cleaner-page', '.content-cleaner-modal', '@media (max-width: 768px)') as $styleBoundary) {
    if (strpos($mainCss, $styleBoundary) === false) {
        $failures[] = 'A scoped responsive-style boundary is missing: ' . $styleBoundary;
    }
}

if (strpos($template, 'content-cleaner-page') === false) {
    $failures[] = 'The settings page is missing its stylesheet scope.';
}

if (strpos($messageCss, '*::before') !== false || strpos($messageCss, '*::after') !== false) {
    $failures[] = 'The message stylesheet still applies global pseudo-element rules.';
}

foreach (glob($pluginRoot . '/Template/config/modals/*.php') as $modalTemplate) {
    if (strpos(file_get_contents($modalTemplate), '<style') !== false) {
        $failures[] = basename($modalTemplate) . ' still duplicates modal CSS inline.';
    }
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo 'Style contract passed.' . PHP_EOL;
