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
    <span class="database-icon"></span>
    <?= $this->helper->cleaningHelper->countTablesDB() ?>
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
</div>
