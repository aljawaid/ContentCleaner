<h1 name="user-content-readme-top">ContentCleaner</h1>
<p align="center">
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/v/release/aljawaid/ContentCleaner?style=for-the-badge&color=brightgreen" alt="GitHub Latest Release (by date)" title="GitHub Latest Release (by date)">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/downloads/aljawaid/ContentCleaner/total?style=for-the-badge&color=orange" alt="GitHub All Releases" title="GitHub All Downloads">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/directory-file-count/aljawaid/ContentCleaner?style=for-the-badge&color=orange" alt="GitHub Repository File Count" title="GitHub Repository File Count">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/repo-size/aljawaid/ContentCleaner?style=for-the-badge&color=orange" alt="GitHub Repository Size" title="GitHub Repository Size">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/languages/code-size/aljawaid/ContentCleaner?style=for-the-badge&color=orange" alt="GitHub Code Size" title="GitHub Code Size">
    </a>
</p>
<p align="center">
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/discussions">
        <img src="https://img.shields.io/github/discussions/aljawaid/ContentCleaner?style=for-the-badge&color=blue" alt="GitHub Discussions" title="Read Discussions">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/compare">
        <img src="https://img.shields.io/github/commits-since/aljawaid/ContentCleaner/latest?include_prereleases&style=for-the-badge&color=blue" alt="GitHub Commits Since Last Release" title="GitHub Commits Since Last Release">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/compare">
        <img src="https://img.shields.io/github/commit-activity/m/aljawaid/ContentCleaner?style=for-the-badge&color=blue" alt="GitHub Commit Monthly Activity" title="GitHub Commit Monthly Activity">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/kanboard/kanboard" title="Kanboard - Kanban Project Management Software">
        <img src="https://img.shields.io/badge/Plugin%20for-kanboard-D40000?style=for-the-badge&labelColor=000000" alt="Kanboard">
    </a>
</p>

ContentCleaner gives Kanboard administrators a reviewed, preview-first way to remove obsolete session data and allowlisted database artefacts left by uninstalled plugins.

> **Important:** database cleanup is permanent. Create and verify a current database backup before confirming any cleaning job. Unknown tables and columns are reported but never deleted automatically.

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#screenshots">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Features

- Restrict database inspection and cleaning to Kanboard administrators
- Show a detailed database summary
  - Display extra tables and identify likely plugin ownership
  - Lock unknown tables until they are added to the reviewed cleanup catalogue
- Preview exact allowlisted tables, columns, entries and registrations before deletion
- Revalidate every opaque selection token immediately before database execution
- Numbered cleaning jobs for easy reference
  - Each job is specific to a reviewed plugin or a fixed Kanboard maintenance task
- Clean all detected database artefacts for one uninstalled plugin or select an individual artefact type
- Choose Normal controls for whole-plugin cleaning or Advanced controls for individual artefact actions
- Purge session rows without dropping the `sessions` or `remember_me` tables
- Stop on the first failed step and report partial completion where cross-database DDL cannot be atomic

## Cleaning Jobs

<table align="center">
    <thead>
        <tr>
            <th align="center" scope="col">Automatic Cleaning Jobs</th>
            <th align="center" scope="col">Application Cleaning Jobs</th>
            <th align="center" scope="col">Plugin Cleaning Jobs</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td align="center">Preview Unused Plugin Registration Entries</td>
            <td align="center">Purge User Sessions</td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/creecros/MetaMagik" title="A Kanboard plugin">MetaMagik</a> data</td>
        </tr>
        <tr>
            <td align="center">Preview Reviewed Plugin Artefacts</td>
            <td align="center">Restore Calendar Settings</td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/aljawaid/CostControl" title="A Kanboard plugin" target="_blank">CostControl</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center">Delete `Remember Me` Login Sessions</td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/BlueTeck/kanboard_plugin_bigboard" title="A Kanboard plugin" target="_blank">Bigboard</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center">Delete Duplicate `Remember Me` Login Sessions</td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/creecros/Group_assign" title="A Kanboard plugin" target="_blank">Group_assign</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/eSkiSo/Subtaskdate" title="A Kanboard plugin" target="_blank">SubtaskDueDate</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/funktechno/kanboard-plugin-wiki" title="A Kanboard plugin" target="_blank">Wiki</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/aljawaid/TemplateManager" title="A Kanboard plugin" target="_blank">TemplateManager</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/aljawaid/AddressBook" title="A Kanboard plugin" target="_blank">AddressBook</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a rel="noopener noreferrer" href="https://github.com/Chaosmeister/DefinitionOfDone" title="A Kanboard plugin" target="_blank">DefinitionOfDone</a> data</td>
        </tr>
    </tbody>
</table>

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#features">&#8592; Previous</a>] [<a href="#usage">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Screenshots

**Database Summary**  

![Summary](../master/Screenshots/screenshot-summary.png "Database Summary")

**Default Tables**  

![Summary](../master/Screenshots/screenshot-default-tables.png "Default Tables")

**Automatic Cleaning Jobs**  

![Summary](../master/Screenshots/screenshot-auto-cleaning-jobs.png "Automatic Cleaning Jobs")

**Application Cleaning Jobs**  

![Summary](../master/Screenshots/screenshot-app-cleaning-jobs.png "Application Cleaning Jobs")

**Plugin Cleaning Jobs**  

![Summary](../master/Screenshots/screenshot-plugin-cleaning-jobs.png "Plugin Cleaning Jobs")

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#features">&#8592; Previous</a>] [<a href="#installation--compatibility">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Usage

Go to `Settings` &#10562; Content Cleaner

1. Create and verify a current database backup.
2. Review the detected artefacts and their attributed plugin.
3. Keep Normal controls for one whole-plugin action, or select Advanced controls to target individual tables, columns, entries or registrations.
4. Confirm that the backup is available, then run the job.
5. If a partial-failure message appears, stop and review the database before retrying; successful DDL may not be reversible on MySQL.

Installed plugins cannot be cleaned. Uninstall the relevant plugin first so it cannot recreate data during the operation. ContentCleaner removes reviewed database artefacts; it does not delete plugin files.

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#screenshots">&#8592; Previous</a>] [<a href="#authors--contributors">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Installation & Compatibility

<p align="left">
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/actions/workflows/linter.yml">
        <img src="https://github.com/aljawaid/ContentCleaner/actions/workflows/linter.yml/badge.svg?branch=master&event=push" alt="Code Scanning" title="View Test">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility.yaml">
        <img src="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
</p>

<details>
    <summary><strong>Installation</strong></summary>

- Install via the **[Kanboard](https://github.com/kanboard/kanboard "Kanboard - Kanban Project Management Software") Plugin Directory** or see [INSTALL.md](../master/INSTALL.md)
- Read the full [**Changelog**](../master/changelog.md "See changes") to see the latest updates

</details>
<details>
    <summary><strong>Compatibility</strong></summary>

- ContentCleaner `2.0.6` requires [Kanboard](https://github.com/kanboard/kanboard "Kanboard - Kanban Project Management Software") ≥`1.2.54`
- Tested with PHP `8.2`–`8.5`
- SQLite is exercised locally and in CI; MySQL `8.4` and PostgreSQL `17` have dedicated CI service tests
- **Other Plugins & Action Plugins**
  - _No known issues_
  - Compatible with [PluginManager](https://github.com/aljawaid/PluginManager)
- **Core Files & Templates**
  - _No template overrides_
  - No database schema is added by ContentCleaner
  - Selected plugin tables or columns can be removed, so a verified backup is mandatory
  - SQLite, MySQL and PostgreSQL are supported; Microsoft SQL Server is not supported

</details>
<details>
    <summary><strong>Translations</strong></summary>

- _Starter template available_

</details>

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#usage">&#8592; Previous</a>] [<a href="#license">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Authors & Contributors

- [@aljawaid](https://github.com/aljawaid) - Author
- [Craig Crosby](https://github.com/creecros) - Contributor
- [Alfred Bühler](https://github.com/alfredbuehler) - Contributor
- _Contributors welcome_

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#installation--compatibility">&#8592; Previous</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## License

- This project is distributed under the [MIT License](../master/LICENSE "Read The MIT license")

---

<p align="center">
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/stargazers" title="View Stargazers">
        <img src="https://img.shields.io/github/stars/aljawaid/ContentCleaner?logo=github&style=flat-square" alt="ContentCleaner">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/forks" title="See Forks">
        <img src="https://img.shields.io/github/forks/aljawaid/ContentCleaner?logo=github&style=flat-square" alt="ContentCleaner">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/blob/master/LICENSE" title="Read License">
        <img src="https://img.shields.io/github/license/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/issues" title="Open Issues">
        <img src="https://img.shields.io/github/issues-raw/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/issues?q=is%3Aissue+is%3Aclosed" title="Closed Issues">
        <img src="https://img.shields.io/github/issues-closed/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/discussions" title="Read Discussions">
        <img src="https://img.shields.io/github/discussions/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a rel="noopener noreferrer" href="https://github.com/aljawaid/ContentCleaner/compare/" title="Latest Commits">
        <img alt="GitHub commits since latest release (by date)" src="https://img.shields.io/github/commits-since/aljawaid/ContentCleaner/latest?style=flat-square">
    </a>
</p>
<p align="right">[<a href="#user-content-readme-top">&#8593; Top</a>]</p>
<a name="user-content-readme-bottom"></a>
