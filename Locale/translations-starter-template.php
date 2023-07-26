<!-- REMOVE THIS SECTION -->
<!-- ------------------- -->
<!-- TEMPLATE FILE FOR LOCAL TRANSLATIONS - KEEP FILENAME IN LOWERCASE AS translations.php UNDER LANGUAGE CODE -->
<!-- EXAMPLE FILE: /Locale/en_GB/translations.php -->
<!-- EXAMPLE FILE: /Locale/en_US/translations.php -->
<!-- EXAMPLE FILE: /Locale/fr_FR/translations.php -->
<!-- EXAMPLE FILE: /Locale/de_DE/translations.php -->
<!-- ------------------- -->
<!-- REMOVE THIS SECTION -->
<?php

return array(
    //
    // GENERAL
    //
    'Content Cleaner' => '',
    'This tool allows admins to cleanup their Kanboard database by selectively deleting useless data saved by Kanboard and leftover data after uninstalling plugins. Keep your database clean and free from cluttered and expired data using cleaning jobs to solve specific application issues.' => '',
    //
    // CORE OVERRIDES OR 3RD PARTY PLUGIN TRANSLATIONS AFFECTING THIS PLUGIN
    //
    'Settings' => '',
    //
    // Controller/CleaningController.php
    //
    'Confirm Cleaning Job' => '',
    'Confirm Cleaning' => '',
    'Cleaning Complete: Database table deleted successfully' => '',
    'Cleaning Failed' => '',
    'Purge Complete - Plugin registration data successfully removed' => '',
    'Purge Failed: There may not be anything to purge' => '',
    'Cleaning Complete: Database column deleted successfully' => '',
    'No columns were selected' => '',
    'Cleaning Complete: Reset successfully' => '',
    'Cleaning Complete: Purged successfully' => '',
    'Cleaning Complete: Duplicates deleted successfully' => '',
    //
    // Controller/PluginCleaningController.php
    //
    'Deep Cleaning Complete: %s deleted successfully' => '',
    'Deep Cleaning Failed: Unable to delete %s' => '',
    'Delete Plugin Database Tables' => '',
    'Deep Cleaning Complete: Database tables created by %s were deleted successfully' => '',
    'Deep Cleaning Failed: Database tables created by %s could not be deleted' => '',
    'Delete Core Table Columns' => '',
    'Deep Cleaning Complete: Core table columns created by %s were deleted' => '',
    'Deep Cleaning Failed: Core table columns created by %s were not deleted' => '',
    'Delete Core Table Entries' => '',
    'Deep Cleaning Complete: Core table entries created by %s were deleted' => '',
    'Deep Cleaning Failed: Core table entries created by %s were not deleted' => '',
    'Delete Plugin Registration Entry' => '',
    'Deep Cleaning Complete: Plugin registration entry for %s was deleted successfully' => '',
    'Deep Cleaning Failed: Plugin registration entry was not deleted for %s' => '',
    //
    // Model/ApplicationCleaningModel.php
    //
    'This cleaning job is not compatible with your database type' => '',
    //
    // Template/cleaning-jobs/tooltips/core-columns.php
    //
    'These columns are located inside core tables and will be deleted if created by a plugin' => '',
    //
    // Template/cleaning-jobs/tooltips/core-tables.php
    //
    'Core tables are created by only the application. Plugins can only alter these types of tables but not delete them.' => '',
    //
    // Template/cleaning-jobs/tooltips/plugin-tables.php
    //
    'The tables listed here are created by the plugin itself' => '',
    //
    // Template/cleaning-jobs/tooltips/plugin-version.php
    //
    'This cleaning job is compatible with all versions of this plugin up to v%s' => '',
    //
    // Template/cleaning-jobs/automatic-clean.php
    //
    'Purge Unused Plugin Registration Entries' => '',
    'Cleaning Job Number' => '',
    'Plugins which have altered the database also register themselves in the database. Use this job if you are having issues reinstalling a plugin.' => '',
    'Table Affected' => '',
    'Job Result' => '',
    'The table is checked for all unknown entries compared to your installed plugins.' => '',
    'Purge Unused Entries' => '',
    'Clean All Unknown Tables and Columns' => '',
    'This job is an all-in-one process to deep clean your database. Any data inside unknown tables and columns will also be deleted.' => '',
    '+ more' => '',
    'First all unknown tables are identified and deleted followed by all unknown columns in each table. Finally the plugin registration entries are purged.' => '',
    'Deep Clean Database' => '',
    //
    // Template/cleaning-jobs/core-clean.php
    //
    'Purge User Sessions' => '',
    'User sessions can build up needlessly over time. It is safe to clear this table from time to time for expired entries.' => '',
    'Table Contents' => '',
    'Entries' => '',
    'Entry' => '',
    'The table will be emptied leaving the current single session entry in the table.' => '',
    'Purge Sessions' => '',
    'Restore Calendar Settings' => '',
    'Calendar plugins can alter the default settings project and user views affecting how tasks are displayed based on start and due dates.' => '',
    'The settings for %s and %s will be reset to the default value' => '',
    'Reset Calendar Settings' => '',
    'Delete Remember Me Login Sessions' => '',
    'By default, login sessions are automatically deleted after 60 days. This job will delete all entries for all users.' => '',
    'Empty' => '',
    'The table will be completely emptied.' => '',
    'Delete Login Sessions' => '',
    'Delete Duplicate Remember Me Login Sessions' => '',
    'Duplicate login sessions can cause session conflicts for regular users who log in from different locations and devices.' => '',
    'No duplicates found' => '',
    'Duplicates' => '',
    'Duplicate' => '',
    'The table will be checked and any duplicate records found for a user will be deleted leaving the single latest entry for that user.' => '',
    'Delete Duplicate Sessions    ' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
);
