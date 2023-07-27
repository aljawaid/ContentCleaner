<?php $check_tables = $this->helper->defaultTableHelper->checkTablesViaPlugin($this->helper->defaultTableHelper->checkTables()); ?>

<div class="c-cleaner-page-margin">
    <div class="c-cleaner-page-header">
        <h2 class="">
            <span class="content-cleaner-icon"></span> <?= t('Deep Cleaning') ?>
        </h2>
    </div>
    <p class="cleaner-intro">
        <?= t('Temporary files can accumulate data which can affect your database and functionality of your application. Plugins which alter the database do not (by default) remove any database tables after uninstalling causing potential issues. Cleaning jobs are segments of processes to optimize your database and cleanup your data. This tool lists cleaning jobs that can deep clean useless data easily.') ?>
    </p>
    <section class="message warning cleaner-warning">
        <header></header>
        <i class=""></i>
        <h3 class="">
            <span class="message-title"><?= t('Warning') ?></span>
            <span class="message-text"><?= t('Using this tool deletes data from the database permanently') ?></span>
        </h3>
    </section>
    <section id="DBSummary" class="db-summary">
        <fieldset class="">
            <legend class="section-title"><span class="db-database-icon"></span> <?= t('Database Summary') ?></legend>
            <table id="DBSummaryTable" class="summary-table">
                <tr class="">
                    <th class=""><?= t('Database Name') ?></th>
                    <td class="">
                        <span class="db-name">
                            <span class="db-database-icon"></span> <?= DB_NAME ?>
                        </span>
                    </td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Database Type') ?></th>
                    <?php if (DB_DRIVER === 'sqlite'): ?>
                        <td class="">SQLite v<?= $this->text->e($db_version) ?></td>
                    <?php elseif (DB_DRIVER === 'mysql'): ?>
                        <td class="">MySQL v<?= $this->text->e($db_version) ?></td>
                    <?php elseif (DB_DRIVER === 'postgres'): ?>
                        <td class="">PostgreSQL v<?= $this->text->e($db_version) ?></td>
                    <?php elseif (DB_DRIVER === 'mssql'): ?>
                        <td class="">Microsoft SQL Server v<?= $this->text->e($db_version) ?></td>
                    <?php else: ?>
                        <td class=""><i><?= t('Unknown') ?></i> v<?= $this->text->e($db_version) ?></td>
                    <?php endif ?>
                </tr>
                <tr class="">
                    <th class=""><?= t('Database Size') ?></th>
                    <?php if (DB_DRIVER === 'sqlite'): ?>
                        <td class=""><?= $this->text->bytes($db_size) ?></td>
                    <?php else: ?>
                        <td class="" title="<?= $this->helper->cleaningHelper->dbSize() ?> MB">
                            <?= round($this->helper->cleaningHelper->dbSize(), 1, PHP_ROUND_HALF_UP) ?> MB
                        </td>
                    <?php endif ?>
                </tr>
                <tr class="">
                    <th class=""><?= t('Total Tables') ?></th>
                    <td class=""><?= $this->helper->cleaningHelper->countTablesDB() ?></td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Default Tables') ?></th>
                    <td class=""><?= count($this->helper->defaultTableHelper->getDefaultTables()) ?></td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Tables Created by Plugins') ?></th>
                    <td class="">
                        <span class="table-count-badge"><?= $this->helper->cleaningHelper->getTableDifference() ?></span>
                    </td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Extra Tables') ?></th>
                    <td class="">
                        <ul class="extra-table-list fa-ul">
                            <?php foreach ($this->helper->defaultTableHelper->checkTables() as $table): ?>
                                <li class="extra-table-item">
                                    <i class="fa fa-table fa-li" aria-hidden="true"></i>
                                    <div class="extra-table-item-wrapper table-name">
                                        <span class="list-item-table"><?= $table . ' ' ?></span>
                                    </div>
                                    <div class="extra-table-item-wrapper">
                                        <span class="table-plugin-name">
                                            <span class="plugin-icon"></span><?= $check_tables[$table] ?>
                                        </span>
                                    </div>
                                    <div class="extra-table-item-wrapper">
                                        <button href="<?= $this->url->href('CleaningController', 'confirm', array('table' => $table, 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn js-modal-confirm delete-extra-table-btn" title="<?= t('Delete extra table') ?>">
                                            <span class="cc-delete-icon"></span>
                                        </button>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </fieldset>
    </section>
    <details class="accordion-section auto-cleaning-section">
        <summary class="accordion-title">
            <span class="automatic-icon"></span> <?= t('1 - Automatic Cleaning Jobs') ?>
        </summary>
        <div class="accordion-content">
            <p class="section-intro">
                <?= t('Clean your database automatically by processing any of the jobs in this section (in any order).') ?>
            </p>
            <?= $this->render('ContentCleaner:cleaning-jobs/automatic-clean') ?>
        </div>
    </details>
    <details class="accordion-section db-cleaning-section">
        <summary class="accordion-title">
            <span class="application-icon"></span> <?= t('2 - Application Cleaning Jobs') ?>
        </summary>
        <div class="accordion-content">
            <p class="section-intro">
                <?= t('Jobs in this section affect only the default database tables. Process any of the jobs below to clean your database.') ?>
            </p>
            <?= $this->render('ContentCleaner:cleaning-jobs/core-clean') ?>
        </div>
    </details>
    <details class="accordion-section plugin-cleaning-section">
        <summary class="accordion-title">
            <span class="plugin-icon"></span> <?= t('3 - Plugin Cleaning Jobs') ?>
        </summary>
        <div class="accordion-content">
             <section class="message error cleaner-warning">
                <header></header>
                <i class=""></i>
                <h3 class="">
                    <span class="message-title"><?= t('Warning') ?></span>
                    <span class="message-text"><?= t('Run any job only if you have previously installed the relevant plugin') ?></span>
                </h3>
            </section>
            <p class="section-intro">
                <?= t('Jobs in this section affect leftover tables which were created by plugins.') ?>
                <strong><?= t('Once a plugin is uninstalled, all leftover tables for the uninstalled plugin are marked as unknown.') ?></strong>
                <?= t('Deleting plugin related database tables before uninstalling the plugin will prompt the plugin to recreate the tables, not uninstall the plugin.') ?>
            </p>
            <div class="alert alert-info process-info">
                <h3 class="">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><?= t('Understanding the process') ?>
                </h3>
                <dl class="">
                    <dt class="term"><?= t('Uninstall Plugin') ?></dt>
                    <dd class="definition">
                        <?= t('A plugin is uninstalled manually by the user. If the plugin is detected as currently installed, some features from this plugin may not work.') ?>
                    </dd>
                    <dt class="term"><?= t('Delete Plugin') ?></dt>
                    <dd class="definition">
                        <?= t('This process will complete all the steps to totally remove any traces of the plugin including any content it created.') ?>
                    </dd>
                    <dt class="term"><?= t('Deep Cleaning') ?></dt>
                    <dd class="definition">
                        <?= e('This process breaks down the %s process into finer segments.', '<i>Delete Plugin</i>') ?>
                    </dd>
                </dl>
            </div>
            <?= $this->render('ContentCleaner:cleaning-jobs/plugin-clean', array('deletable_plugins' => $deletable_plugins)) ?>
        </div>
    </details>
    <section id="DefaultTables" class="default-table-section">
        <fieldset class="default-tables">
            <legend class="section-title"><span class="db-settings-icon"></span> <?= t('Default Database Information') ?></legend>
            <p class="section-intro">
                <?= t('This section lists all the default database tables with their total number of columns highlighting any additional columns related to plugins. Click on the extra columns to delete them.') ?>
            </p>
            <ul class="default-table-list fa-ul">
                <?php foreach ($this->helper->defaultTableHelper->getDefaultTables() as $table): ?>
                    <li class="list-item">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><span class="list-item-table" title="<?= t('Table name') ?>"><?= $table ?></span>
                        <ul class="list-item-columns">
                            <li class="default-columns-count">
                                <?= count($this->helper->defaultTableHelper->getDefaultColumnsForTable($table)) ?> <?= t('columns') ?>
                                <?php if (count($this->helper->defaultTableHelper->checkTableColumns($table))): ?>
                                    <button href="<?= $this->url->href('CleaningController', 'viewColumns', array('table' => $table, 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn js-modal-confirm extra-columns-count" title="<?= t('View extra columns in the "%s" table', $table) ?>">
                                        <?= t('+ %s from plugins', count($this->helper->defaultTableHelper->checkTableColumns($table))) ?>
                                    </button>
                                <?php endif ?>
                            </li>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>
        </fieldset>
    </section>
</div>
