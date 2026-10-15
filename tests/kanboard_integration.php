<?php

/**
 * Kanboard 1.2.54 integration tests for ContentCleaner.
 *
 * Related files: Plugin.php, Controller/ContentCleanerController.php,
 * Controller/CleaningController.php, Controller/PluginCleaningController.php
 * and Model/ApplicationCleaningModel.php.
 */

$kanboardRoot = getenv('KANBOARD_ROOT');
if ($kanboardRoot === false || !is_file($kanboardRoot . '/app/common.php')) {
    fwrite(STDERR, 'Set KANBOARD_ROOT to a Kanboard 1.2.54 checkout.' . PHP_EOL);
    exit(1);
}

define('PLUGINS_DIR', $kanboardRoot . '/plugins');
define('DB_FILENAME', $kanboardRoot . '/data/content-cleaner-integration.sqlite');

require $kanboardRoot . '/app/common.php';

$failures = array();
$plugins = $container['pluginLoader']->getPlugins();

if (!isset($plugins['ContentCleaner'])) {
    $failures[] = 'ContentCleaner did not load.';
}

$authorization = $container['applicationAuthorization'];
foreach (array('ContentCleanerController', 'CleaningController', 'PluginCleaningController') as $controller) {
    if (!$authorization->isAllowed($controller, 'show', Kanboard\Core\Security\Role::APP_ADMIN)) {
        $failures[] = 'Administrators cannot access ' . $controller . '.';
    }

    if ($authorization->isAllowed($controller, 'show', Kanboard\Core\Security\Role::APP_USER)) {
        $failures[] = 'Ordinary application users can access ' . $controller . '.';
    }
}

foreach (array('install', 'uninstall', 'upgrade', 'upload') as $inheritedAction) {
    if (method_exists(Kanboard\Plugin\ContentCleaner\Controller\ContentCleanerController::class, $inheritedAction)) {
        $failures[] = 'An inherited plugin-management action remains reachable: ' . $inheritedAction;
    }
}

$model = $container['applicationCleaningModel'];
foreach (array('sessions; DROP TABLE users', 'schema.table', 'bad-name', '') as $identifier) {
    try {
        $model->getColumns($identifier);
        $failures[] = 'A hostile SQL identifier was accepted: ' . $identifier;
    } catch (InvalidArgumentException $exception) {
        // The model must reject the identifier before it reaches the database driver.
    }
}

$container['db']->execute('CREATE TABLE IF NOT EXISTS "content_cleaner_test" ("id" INTEGER PRIMARY KEY)');
$container['db']->execute('INSERT INTO "content_cleaner_test" ("id") VALUES (1)');
if ($model->getColumns('content_cleaner_test') !== array('id')) {
    $failures[] = 'A legitimate quoted identifier could not be inspected.';
}

if (!$model->delete('content_cleaner_test')) {
    $failures[] = 'A legitimate table could not be deleted.';
}

$model->flushSessionsAll();
if (!in_array('sessions', $model->getTables(), true)) {
    $failures[] = 'Purging session rows removed the sessions table.';
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo 'Kanboard integration tests passed.' . PHP_EOL;
