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
            <legend class="section-title"><span class="database-icon"></span> <?= t('Database Summary') ?></legend>
            <table id="DBSummaryTable" class="summary-table">
                <tr class="">
                    <th class=""><?= t('Database Name') ?></th>
                    <td class=""><?= DB_NAME ?></td>
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
            </table>
        </fieldset>
    </section>
    <section id="DeepCleaningApp" class="">
        <fieldset class="app-cleaning">
            <legend class="section-title"><span class="db-settings-icon"></span> <?= t('Application Cleaning Jobs') ?></legend>
            <p class=""><?= t('Jobs in this section affect only the default database tables') ?></p>
            <div class="job-section-wrapper">
                <fieldset class="job-wrapper">
                    <legend class="job-title">
                        <span class="content-cleaner-icon"></span> <?= t('Reset Calendar Settings') ?>
                    </legend>
                    <p class="job-desc">
                        <?= t('Some calendar plugins alter default settings which affect the project and user views') ?>
                    </p>
                    <ul class="job-tables fa-ul">
                        <li class="job-tables-title">
                            <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                        </li>
                        <li class="job-tables-table">settings</li>
                    </ul>
                    <ul class="job-result fa-ul">
                        <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                        <li class="job-result-text"><?= t('The settings for') ?> <code>calendar_project_tasks</code> <?= t('and') ?> <code>calendar_user_tasks</code> <?= t('will be reset to the value') ?> <code>date_started</code></li>
                    </ul>
                    <a href="<?= $this->url->href('CleaningController', 'confirmReset', array('table' => 'settings', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Reset Settings') ?></a>
                </fieldset>
            </div>
        </fieldset>
    </section>
    <section id="DeepCleaningPlugins" class="">
        <fieldset class="plugin-cleaning">
            <legend class="section-title"><span class="db-settings-icon"></span> <?= t('Plugin Cleaning Jobs') ?></legend>
            <p class=""><?= t('Jobs in this section affect leftover tables which were created by plugins') ?></p>
            <a href="<?= $this->url->href('CleaningController', 'confirm', array('table' => 'test', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn js-modal-confirm" title="<?=t('Delete') ?>">
                <span class="db-delete-icon"></span> <?= t('Delete Test Table') ?>
            </a>
        </fieldset>
    </section>
    <section id="DefaultTables" class="">
        <fieldset class="default-tables">
            <legend class="section-title"><span class="database-icon"></span> <?= t('Default Database Tables') ?></legend>
            <ul class="default-table-list fa-ul">
                <?php foreach ($this->helper->defaultTableHelper->getDefaultTables() as $table): ?>
                    <li class="list-item"><i class="fa fa-table fa-li" aria-hidden="true"></i><?= $table ?></li>
                <?php endforeach ?>
            </ul>
        </fieldset>
    </section>
</div>
