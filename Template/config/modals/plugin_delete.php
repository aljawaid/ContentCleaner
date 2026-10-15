<div id="DeletePluginModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
                <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $this->text->e($job) ?></span>
            </span>
            <span class="modal-subtitle">
                <span class="plugin-icon"></span> <?= t('Clean Plugin Data') ?>
            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm warning-confirm">
            <?php if ($cleanup['installed']): ?>
                <section class="content-cleaner-message error cleaner-warning">
                    <header></header>
                    <i class=""></i>
                    <h3 class="">
                        <span class="message-title"><?= t('Warning') ?></span>
                        <span class="message-text"><?= t('%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database table entries related to the plugin.', $this->text->e($plugin_job_name), $this->text->e($plugin_job_name)) ?></span>
                    </h3>
                </section>
            <?php endif ?>
            <p class="confirm-notice">
                <?= t('This job will remove the currently detected, reviewed database artefacts for %s:', $this->text->e($plugin_job_name)) ?>
            </p>
            <ul class="plugin-job-delete fa-ul">
                <?php foreach ($cleanup['candidates'] as $candidate): ?>
                    <li class="plugin-job-delete-item">
                        <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                        <?php if ($candidate['type'] === 'table'): ?>
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <?= t('Table') ?>: <code><?= $this->text->e($candidate['table']) ?></code>
                        <?php elseif ($candidate['type'] === 'column'): ?>
                            <i class="fa fa-columns" aria-hidden="true"></i>
                            <?= t('Column') ?>: <code><?= $this->text->e($candidate['table'] . '.' . $candidate['column']) ?></code>
                        <?php elseif ($candidate['type'] === 'entry'): ?>
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <?= t('Entry') ?>: <code><?= $this->text->e($candidate['table'] . '.' . $candidate['column']) ?></code>
                        <?php else: ?>
                            <span class="db-database-icon"></span>
                            <?= t('Plugin registration') ?>: <code><?= $this->text->e($candidate['plugin_name']) ?></code>
                        <?php endif ?>
                    </li>
                <?php endforeach ?>
            </ul>
            <span id="JobType">
                <span class="plugin-icon"></span> <?= t('Plugin Cleaning Jobs') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">
        <form method="post" action="<?= $this->url->href('PluginCleaningController', 'deletePlugin', array('plugin' => 'ContentCleaner')) ?>">
            <?= $this->form->hidden('plugin_name', array('plugin_name' => $plugin_name)) ?>
            <?= $this->form->csrf() ?>
            <?php if (!$cleanup['installed'] && $cleanup['candidates'] !== array()): ?>
                <label class="backup-confirmation">
                    <input type="checkbox" name="backup_confirmed" value="1" required>
                    <?= t('I confirm that a current database backup is available.') ?>
                </label>
                <?= $this->modal->submitButtons(array('submitLabel' => t('Clean Plugin Data'))) ?>
            <?php endif ?>
        </form>
    </div>
</div>
