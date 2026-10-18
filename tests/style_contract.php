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

foreach (array('#007AC9', '#00ADFF', '#B71234', '#DA004C', '#AE003D', '#2EA02E', '#FF6500', '#D9270C') as $color) {
    if (strpos($mainCss, $color) === false) {
        $failures[] = 'An established interface colour is missing: ' . $color;
    }
}

foreach (array(
    '--pp-surface: var(--color-background, #FFFFFF)',
    '--pp-white: #FFFFFF',
    '--pp-green-action: #167316',
    'background: var(--pp-green-action)',
    'color: var(--pp-grey)',
    'color: #FFFFFF',
) as $contrastBoundary) {
    if (strpos($mainCss, $contrastBoundary) === false) {
        $failures[] = 'An accessible theme or contrast boundary is missing: ' . $contrastBoundary;
    }
}

foreach (array('#963B00', '#0759B8', '#1B5E20', '#8A3E00') as $messageColor) {
    if (strpos($messageCss, $messageColor) === false) {
        $failures[] = 'An accessible message-title colour is missing: ' . $messageColor;
    }
}

$relativeLuminance = static function ($hex) {
    $channels = array_map('hexdec', str_split(ltrim($hex, '#'), 2));
    $channels = array_map(static function ($channel) {
        $value = $channel / 255;

        return $value <= 0.03928
            ? $value / 12.92
            : (($value + 0.055) / 1.055) ** 2.4;
    }, $channels);

    return (0.2126 * $channels[0]) + (0.7152 * $channels[1]) + (0.0722 * $channels[2]);
};

$contrastRatio = static function ($foreground, $background) use ($relativeLuminance) {
    $foregroundLuminance = $relativeLuminance($foreground);
    $backgroundLuminance = $relativeLuminance($background);

    return (max($foregroundLuminance, $backgroundLuminance) + 0.05)
        / (min($foregroundLuminance, $backgroundLuminance) + 0.05);
};

foreach (array(
    'plugin action' => array('#FFFFFF', '#167316'),
    'job badge' => array('#FFFFFF', '#D9270C'),
    'process guidance' => array('#FFFFFF', '#6C757D'),
    'allowlist lock' => array('#4D4D4D', '#FFFFFF'),
    'warning title' => array('#963B00', '#EEEEEE'),
    'neutral title' => array('#0759B8', '#EEEEEE'),
    'success title' => array('#1B5E20', '#EEEEEE'),
    'uncertain-state title' => array('#8A3E00', '#EEEEEE'),
) as $label => $colors) {
    if ($contrastRatio($colors[0], $colors[1]) < 4.5) {
        $failures[] = 'WCAG AA contrast is below 4.5:1 for ' . $label . '.';
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
