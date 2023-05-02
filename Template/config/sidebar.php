<li <?= $this->app->checkMenuSelection('ContentCleanerController', 'show', 'ContentCleaner') ?>>
    <?= $this->url->link(t('Content Cleaner'), 'ContentCleanerController', 'show', ['plugin' => 'ContentCleaner']) ?>
</li>
