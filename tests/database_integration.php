<?php

/**
 * SQLite, MySQL and PostgreSQL integration tests for ContentCleaner DDL.
 *
 * Related file: Model/ApplicationCleaningModel.php.
 */

$kanboardRoot = getenv('KANBOARD_ROOT');
if ($kanboardRoot === false || !is_file($kanboardRoot . '/app/common.php')) {
    fwrite(STDERR, 'Set KANBOARD_ROOT to a Kanboard 1.2.54 checkout.' . PHP_EOL);
    exit(1);
}

define('PLUGINS_DIR', $kanboardRoot . '/plugins');
if ((getenv('DB_DRIVER') ?: 'sqlite') === 'sqlite') {
    define('DB_FILENAME', $kanboardRoot . '/data/content-cleaner-database-integration.sqlite');
}

require $kanboardRoot . '/app/common.php';

$failures = array();
$model = $container['applicationCleaningModel'];
$db = $container['db'];
$quote = function ($identifier) {
    return DB_DRIVER === 'mysql' ? '`' . $identifier . '`' : '"' . $identifier . '"';
};

foreach (array('invalid-name', 'schema.table', 'table; DROP TABLE users', 'white space') as $identifier) {
    try {
        $model->getColumns($identifier);
        $failures[] = DB_DRIVER . ' accepted a hostile identifier: ' . $identifier;
    } catch (InvalidArgumentException $exception) {
        // Invalid identifiers must fail before the driver receives SQL.
    }
}

$table = 'content_cleaner_driver_test';
$db->execute('DROP TABLE IF EXISTS ' . $quote($table));
$db->execute('CREATE TABLE ' . $quote($table) . ' (' . $quote('id') . ' INTEGER PRIMARY KEY)');
$db->execute('ALTER TABLE ' . $quote($table) . ' ADD COLUMN ' . $quote('reviewed_value') . ' VARCHAR(50)');

if ($model->getColumns($table) !== array('id', 'reviewed_value')) {
    $failures[] = DB_DRIVER . ' could not inspect validated identifiers.';
}

if (!$model->deleteColumn($table, 'reviewed_value') || in_array('reviewed_value', $model->getColumns($table), true)) {
    $failures[] = DB_DRIVER . ' could not delete a validated column without CASCADE.';
}

$model->flushSessionsAll();
$model->flushRememberMeAll();
$tablesAfterPurge = $model->getTables();
foreach (array('sessions', 'remember_me') as $protectedTable) {
    if (!in_array($protectedTable, $tablesAfterPurge, true)) {
        $failures[] = DB_DRIVER . ' removed a table while purging its rows: ' . $protectedTable;
    }
}

if (!$model->delete($table) || in_array($table, $model->getTables(), true)) {
    $failures[] = DB_DRIVER . ' could not delete a validated table.';
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo DB_DRIVER . ' database integration tests passed.' . PHP_EOL;
