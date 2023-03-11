<div class="c-cleaner-page-margin">
    <div class="c-cleaner-page-header">
        <h2 class="">
            <span class="content-cleaner-icon"></span> <?= t('Deep Cleaning') ?>
        </h2>
    </div>
    <p class="cleaner-intro">
        <?= t('Temporary files can accumulate data which can affect your database storage size. Plugins which alter the application database do not (by default) remove any database tables after uninstalling. This tool can deep clean useless data easily. Click on any of the buttons in the sections below to deep clean your database.') ?>
    </p>
    <section class="message warning cleaner-warning">
        <header></header>
        <i class=""></i>
        <h3 class="">
            <span class="message-title"><?= t('Warning') ?></span>
            <span class="message-text"><?= t('Using this tool deletes data from the database permanently') ?></span>
        </h3>
    </section>
    <section class="db-summary">
        <fieldset class="">
            <legend><span class="database-icon"></span> <?= t('Database Summary') ?></legend>
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
                    <th class=""><?= t('Total Tables') ?></th>
                    <td class=""><?= $this->helper->cleaningHelper->countTablesDB() ?></td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Default Tables') ?></th>
                    <td class=""><?= count($this->helper->defaultTableHelper->getDefaultTables()) ?></td>
                </tr>
                <tr class="">
                    <th class=""><?= t('Tables Created by Plugins') ?></th>
                    <td class=""><?= $this->helper->cleaningHelper->getTableDifference() ?></td>
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
            </table>
        </fieldset>
    </section>
    <section class="">
        <fieldset class="">
            <legend><span class="db-settings-icon"></span> <?= t('Application Cleaning') ?></legend>
        </fieldset>
        <fieldset class="">
            <legend><span class="db-settings-icon"></span> <?= t('Plugin Cleaning') ?></legend>
            <a id="" href="<?= $this->url->href('CleaningController', 'confirm', array('table' => 'test', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn  js-modal-confirm" title="<?=t('Delete') ?>">
                <span class="db-delete-icon"></span> <?= t('Delete Test Table') ?>
            </a>
        </fieldset>
    </section>
    <section id="DefaultTables">
        <fieldset class="">
            <legend><span class="database-icon"></span> <?= t('Default Database Tables') ?></legend>
            <ul class="default-table-list fa-ul">
                <?php foreach ($this->helper->defaultTableHelper->getDefaultTables($tables) as $table): ?>
                    <li class="list-item"><i class="fa fa-table fa-li" aria-hidden="true"></i><?= $table ?></li>
                <?php endforeach ?>
            </ul>
        </fieldset>
    </section>
</div>
