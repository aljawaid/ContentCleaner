<?php

/**
 * ContentCleaner authorisation, request and SQL safety contract.
 *
 * Related files: Plugin.php, Controller/ContentCleanerController.php,
 * Controller/CleaningController.php, Controller/PluginCleaningController.php,
 * Model/ApplicationCleaningModel.php and Template/config/modals/*.php.
 */

$pluginRoot = dirname(__DIR__);
$plugin = file_get_contents($pluginRoot . '/Plugin.php');
$contentController = file_get_contents($pluginRoot . '/Controller/ContentCleanerController.php');
$cleaningController = file_get_contents($pluginRoot . '/Controller/CleaningController.php');
$pluginController = file_get_contents($pluginRoot . '/Controller/PluginCleaningController.php');
$applicationModel = file_get_contents($pluginRoot . '/Model/ApplicationCleaningModel.php');
$cleanupPlan = file_get_contents($pluginRoot . '/Model/CleanupPlanModel.php');
$cleanerTemplate = file_get_contents($pluginRoot . '/Template/config/cleaner.php');
$failures = array();

foreach (array('ContentCleanerController', 'CleaningController', 'PluginCleaningController') as $controller) {
    $accessMap = "applicationAccessMap->add('" . $controller . "', '*', Role::APP_ADMIN)";
    if (strpos($plugin, $accessMap) === false) {
        $failures[] = 'The administrator access map is missing: ' . $controller;
    }
}

foreach (array(
    'plugins/ContentCleaner/Assets/css/content-cleaner.css',
    'plugins/ContentCleaner/Assets/css/content-cleaner-icons.css',
    'plugins/ContentCleaner/Assets/css/messages.css',
) as $asset) {
    if (strpos($plugin, $asset) === false) {
        $failures[] = 'The administrator stylesheet is missing: ' . $asset;
    }
}

foreach (array(
    "request->getStringParam('controller')",
    "router->getPath() === 'settings/cleaner'",
    'userSession->isAdmin() && $isCleanerPage',
) as $assetBoundary) {
    if (strpos($plugin, $assetBoundary) === false) {
        $failures[] = 'The administrator-only asset boundary is missing: ' . $assetBoundary;
    }
}

if (strpos($contentController, 'extends BaseController') === false || strpos($contentController, 'PluginController') !== false) {
    $failures[] = 'ContentCleanerController must not inherit core plugin-management actions.';
}

foreach (array($contentController, $cleaningController, $pluginController) as $controllerSource) {
    if (strpos($controllerSource, 'userSession->isAdmin()') === false) {
        $failures[] = 'A controller is missing its defence-in-depth administrator check.';
    }
}

foreach (array($cleaningController, $pluginController) as $mutationController) {
    foreach (array('requirePostRequest()', 'checkCSRFForm()') as $boundary) {
        if (strpos($mutationController, $boundary) === false) {
            $failures[] = 'A mutation controller is missing: ' . $boundary;
        }
    }
}

foreach (array($cleaningController, $pluginController) as $controllerSource) {
    if (strpos($controllerSource, "getStringParam('job')") !== false) {
        $failures[] = 'A confirmation controller still accepts a reflected job label.';
    }
}

$escapedModalPaths = array(
    '/Template/config/modals/auto_purge_clean.php',
    '/Template/config/modals/plugin_delete.php',
    '/Template/config/modals/purge_plugin_schemas.php',
    '/Template/config/modals/reset.php',
);
foreach ($escapedModalPaths as $escapedModalPath) {
    $escapedModal = file_get_contents($pluginRoot . $escapedModalPath);
    if (strpos($escapedModal, 'text->e(') === false) {
        $failures[] = basename($escapedModalPath) . ' is missing explicit output escaping.';
    }
}

foreach (array('isPost()', 'checkCSRFForm()', "array('normal', 'advanced')") as $modeBoundary) {
    if (strpos($contentController, $modeBoundary) === false) {
        $failures[] = 'The display-mode boundary is missing: ' . $modeBoundary;
    }
}

foreach (array("saveDisplayMode", 'method="post"', 'form->csrf()') as $modeFormBoundary) {
    if (strpos($cleanerTemplate, $modeFormBoundary) === false) {
        $failures[] = 'The display-mode form boundary is missing: ' . $modeFormBoundary;
    }
}

$modalFiles = glob($pluginRoot . '/Template/config/modals/*.php');
foreach ($modalFiles as $modalFile) {
    $modal = file_get_contents($modalFile);
    if (strpos($modal, 'confirmButtons(') !== false) {
        $failures[] = basename($modalFile) . ' still exposes a state-changing GET confirmation.';
    }

    if (strpos($modal, 'method="post"') !== false && strpos($modal, 'form->csrf()') === false) {
        $failures[] = basename($modalFile) . ' has a POST form without a CSRF token.';
    }
}

foreach (array('assertIdentifier(', 'quoteIdentifier(', 'Invalid database identifier') as $identifierBoundary) {
    if (strpos($applicationModel, $identifierBoundary) === false) {
        $failures[] = 'The SQL identifier boundary is missing: ' . $identifierBoundary;
    }
}

foreach (array('buildPlan(', 'getCandidate(', 'executeSelection(', 'executePluginCleanup(', 'getDefaultTables(', 'getIncompatiblePlugins(', 'DirectoryIterator(', "['installed']") as $planBoundary) {
    if (strpos($cleanupPlan, $planBoundary) === false) {
        $failures[] = 'The reviewed cleanup-plan boundary is missing: ' . $planBoundary;
    }
}

foreach (array($cleaningController, $pluginController) as $mutationController) {
    if (strpos($mutationController, 'getRawFormValues(') !== false) {
        $failures[] = 'A mutation controller still accepts an unbounded raw form payload.';
    }
}

foreach (array('SHOW WARNINGS', ' CASCADE;', 'DELETE FROM TABLE') as $unsafeSql) {
    if (strpos($applicationModel, $unsafeSql) !== false) {
        $failures[] = 'Unsafe or non-portable SQL remains: ' . $unsafeSql;
    }
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo 'Security contract passed.' . PHP_EOL;
