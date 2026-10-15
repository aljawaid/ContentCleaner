<?php

/**
 * Allowlisted cleanup-plan integration tests for ContentCleaner.
 *
 * Related files: Model/CleanupPlanModel.php, Controller/CleaningController.php
 * and Template/config/modals/auto_purge_clean.php.
 */

$kanboardRoot = getenv('KANBOARD_ROOT');
if ($kanboardRoot === false || !is_file($kanboardRoot . '/app/common.php')) {
    fwrite(STDERR, 'Set KANBOARD_ROOT to a Kanboard 1.2.54 checkout.' . PHP_EOL);
    exit(1);
}

define('PLUGINS_DIR', $kanboardRoot . '/plugins');
define('DB_FILENAME', $kanboardRoot . '/data/content-cleaner-plan-integration.sqlite');

require $kanboardRoot . '/app/common.php';

$failures = array();
$db = $container['db'];
$planModel = $container['cleanupPlanModel'];

$db->execute('CREATE TABLE IF NOT EXISTS "metadata_types" ("id" INTEGER PRIMARY KEY)');
if (!$db->table('plugin_schema_versions')->eq('plugin', 'metamagik')->exists()) {
    $db->table('plugin_schema_versions')->insert(array('plugin' => 'metamagik', 'version' => 7));
}

$subtaskColumns = $container['applicationCleaningModel']->getColumns('subtasks');
if (!in_array('due_date', $subtaskColumns, true)) {
    $db->execute('ALTER TABLE "subtasks" ADD COLUMN "due_date" INTEGER');
}

$plan = $planModel->buildPlan();
$tokensByArtefact = array();
foreach ($plan as $token => $candidate) {
    if ($candidate['type'] === 'table') {
        $tokensByArtefact['table:' . $candidate['table']] = $token;
    } elseif ($candidate['type'] === 'column') {
        $tokensByArtefact['column:' . $candidate['table'] . '.' . $candidate['column']] = $token;
    } else {
        $tokensByArtefact['schema:' . $candidate['plugin_name']] = $token;
    }

    if (isset($candidate['table']) && $candidate['table'] === 'sessions') {
        $failures[] = 'The Kanboard sessions table entered the cleanup plan.';
    }
}

foreach (array('table:metadata_types', 'column:subtasks.due_date', 'schema:metamagik') as $expected) {
    if (!isset($tokensByArtefact[$expected])) {
        $failures[] = 'The expected reviewed candidate is missing: ' . $expected;
    }
}

try {
    $planModel->executeSelection(array(hash('sha256', 'forged')), array('table'));
    $failures[] = 'A forged cleanup token was accepted.';
} catch (InvalidArgumentException $exception) {
    // Forged and stale selections must fail before any database operation.
}

if (isset($tokensByArtefact['table:metadata_types'])) {
    $result = $planModel->executeSelection(array($tokensByArtefact['table:metadata_types']), array('table'));
    if ($result['completed'] !== 1 || in_array('metadata_types', $container['applicationCleaningModel']->getTables(), true)) {
        $failures[] = 'The reviewed table candidate was not deleted.';
    }
}

if (!in_array('sessions', $container['applicationCleaningModel']->getTables(), true)) {
    $failures[] = 'Executing an allowlisted cleanup removed the sessions table.';
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo 'Cleanup plan integration tests passed.' . PHP_EOL;
