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
                    <td class=""><span class="table-count-badge"><?= $this->helper->cleaningHelper->getTableDifference() ?></span></td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Extra Tables') ?></th>
                    <td class="">
                        <ul class="extra-table-list fa-ul">
                            <?php foreach ($this->helper->defaultTableHelper->checkTables() as $table): ?>
                                <li class="extra-table-item" title="<?= t('Created by') .' '. $check_tables[$table] . ' '. t('plugin') ?>">
                                    <i class="fa fa-table fa-li" aria-hidden="true"></i>
                                    <a href="<?= $this->url->href('CleaningController', 'confirm', array('table' => $table, 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="js-modal-confirm list-item-table" title="<?= t('Delete extra table') ?>">
                                        <?= $table . ' ' ?>
                                    </a>
                                    <span class="table-plugin-name">
                                        <span class="plugin-icon"></span><?= $check_tables[$table] ?>
                                    </span>
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
            <span class="content-cleaner-icon"></span> <?= t('Automatic Deep Cleaning') ?>
        </summary>
        <div class="accordion-content">
            <p class="section-intro"><?= t('Clean your database automatically choosing one or both of the options below.') ?></p>
            <a href="<?= $this->url->href('CleaningController', 'confirmAutoPurgeAndClean', array('plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn js-modal-confirm" title="<?=t('Delete') ?>">
                <span class="db-delete-icon"></span> <?= t('Auto Purge & Clean Unknown Tables and Columns') ?>
            </a>
            <div class="job-section-wrapper">
                <fieldset class="job-wrapper">
                    <legend class="job-title">
                        <span class="content-cleaner-icon"></span> <?= t('Unused Plugin Registration Entries') ?>
                    </legend>
                    <p class="job-desc">
                        <?= t('Plugins which have altered the database also register themselves in the database.') ?>
                    </p>
                    <ul class="job-tables fa-ul">
                        <li class="job-tables-title">
                            <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                        </li>
                        <li class="job-tables-table">plugin_schema_versions</li>
                    </ul>
                    <ul class="job-result fa-ul">
                        <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                        <li class="job-result-text"><?= t('The table is checked for all unknown entries compared to your installed plugins. Use this job if you are having issues reinstalling a plugin.') ?></li>
                    </ul>
                    <a href="<?= $this->url->href('CleaningController', 'confirmPluginSchemaPurge', array('plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm" title="<?=t('Delete') ?>">
                        <span class="db-delete-icon"></span> <?= t('Purge Unused Plugin Entries') ?>
                    </a>
                </fieldset>
            </div>
        </div>
    </details>
    <details class="accordion-section db-cleaning-section">
        <summary class="accordion-title">
            <span class="content-cleaner-icon"></span> <?= t('Application Cleaning Jobs') ?>
        </summary>
        <div class="accordion-content">
            <p class="section-intro"><?= t('Jobs in this section affect only the default database tables. Choose any of the jobs below to clean your database based on specific criteria.') ?></p>
            <?= $this->render('ContentCleaner:cleaning/core-clean') ?>
        </div>
    </details>
    <details class="accordion-section plugin-cleaning-section">
        <summary class="accordion-title">
            <span class="content-cleaner-icon"></span> <?= t('Plugin Cleaning Jobs') ?>
        </summary>
        <div class="accordion-content">
            <p class="section-intro"><?= t('Jobs in this section affect leftover tables which were created by plugins. Choose any of the jobs below to clean your database based on specific criteria.') ?></p>
            <?= $this->render('ContentCleaner:cleaning/plugin-clean') ?>
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
                        <ul class="">
                            <li class="default-columns-count">
                                <?= count($this->helper->defaultTableHelper->getDefaultColumnsForTable($table)) ?> <?= t('columns') ?>
                                <?php if(count($this->helper->defaultTableHelper->checkTableColumns($table))): ?>
                                    <a href="<?= $this->url->href('CleaningController', 'viewColumns', array('table' => $table, 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="js-modal-confirm extra-columns-count" title="<?= t('Delete columns from this table') ?>">
                                        <?= t('+') ?> <?= count($this->helper->defaultTableHelper->checkTableColumns($table)) ?> <?= t('columns from plugins') ?>
                                    </a>
                                <?php endif ?>
                            </li>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>
        </fieldset>
    </section>
</div>
