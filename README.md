<h1 name="user-content-readme-top">ContentCleaner</h1>
<p align="center">
    <a href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/v/release/aljawaid/ContentCleaner?style=for-the-badge&color=brightgreen" alt="GitHub Latest Release (by date)" title="GitHub Latest Release (by date)">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/downloads/aljawaid/ContentCleaner/total?style=for-the-badge&color=orange" alt="GitHub All Releases" title="GitHub All Downloads">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/directory-file-count/aljawaid/ContentCleaner?style=for-the-badge&color=orange" alt="GitHub Repository File Count" title="GitHub Repository File Count">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/repo-size/aljawaid/ContentCleaner?style=for-the-badge&color=orange" alt="GitHub Repository Size" title="GitHub Repository Size">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/releases">
        <img src="https://img.shields.io/github/languages/code-size/aljawaid/ContentCleaner?style=for-the-badge&color=orange" alt="GitHub Code Size" title="GitHub Code Size">
    </a>
</p>
<p align="center">
    <a href="https://github.com/aljawaid/ContentCleaner/discussions">
        <img src="https://img.shields.io/github/discussions/aljawaid/ContentCleaner?style=for-the-badge&color=blue" alt="GitHub Discussions" title="Read Discussions">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/compare">
        <img src="https://img.shields.io/github/commits-since/aljawaid/ContentCleaner/latest?include_prereleases&style=for-the-badge&color=blue" alt="GitHub Commits Since Last Release" title="GitHub Commits Since Last Release">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/compare">
        <img src="https://img.shields.io/github/commit-activity/m/aljawaid/ContentCleaner?style=for-the-badge&color=blue" alt="GitHub Commit Monthly Activity" title="GitHub Commit Monthly Activity">
    </a>
    <a href="https://github.com/kanboard/kanboard" title="Kanboard - Kanban Project Management Software">
        <img src="https://img.shields.io/badge/Plugin%20for-kanboard-D40000?style=for-the-badge&labelColor=000000" alt="Kanboard">
    </a>
</p>

This tool allows admins to cleanup their Kanboard database by selectively deleting useless data saved by Kanboard and leftover data after uninstalling plugins. Keep your database clean and free from cluttered and expired data using cleaning jobs to solve specific application issues.

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#screenshots">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Features

- Show a detailed database summary of your application
  - Display extra tables which are created by plugins
  - Delete extra tables directly from the database
  - Easily identify plugin ownership of each extra table
- Show default database information
  - Highlight extra columns within tables and delete columns directly from the database
- Numbered cleaning jobs for easy reference
  - Each cleaning job is specific to a plugin or a default application setting
- Deep clean the database from all plugins and plugin related data

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
            <td align="center">Purge Unused Plugin Registration Entries</td>
            <td align="center">Purge User Sessions</td>
            <td align="center">Remove <a href="https://github.com/creecros/MetaMagik" title="A Kanboard plugin">MetaMagik</a> data</td>
        </tr>
        <tr>
            <td align="center">Clean All Unknown Tables and Column</td>
            <td align="center">Restore Calendar Settings</td>
            <td align="center">Remove <a href="https://github.com/aljawaid/CostControl" title="A Kanboard plugin" target="_blank">CostControl</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center">Delete `Remember Me` Login Sessions</td>
            <td align="center">Remove <a href="https://github.com/BlueTeck/kanboard_plugin_bigboard" title="A Kanboard plugin" target="_blank">Bigboard</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center">Delete Duplicate `Remember Me` Login Sessions</td>
            <td align="center">Remove <a href="https://github.com/creecros/Group_assign" title="A Kanboard plugin" target="_blank">Group_assign</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a href="https://github.com/eSkiSo/Subtaskdate" title="A Kanboard plugin" target="_blank">SubtaskDueDate</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a href="https://github.com/funktechno/kanboard-plugin-wiki" title="A Kanboard plugin" target="_blank">Wiki</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a href="https://github.com/aljawaid/TemplateManager" title="A Kanboard plugin" target="_blank">TemplateManager</a> data</td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">Remove <a href="https://github.com/aljawaid/AddressBook" title="A Kanboard plugin" target="_blank">AddressBook</a> data</td>
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

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#screenshots">&#8592; Previous</a>] [<a href="#authors--contributors">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Installation & Compatibility

<p align="left">
    <a href="https://github.com/aljawaid/ContentCleaner/actions/workflows/linter.yml">
        <img src="https://github.com/aljawaid/ContentCleaner/actions/workflows/linter.yml/badge.svg?branch=master&event=push" alt="Code Scanning" title="View Test">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility-7.4.yaml">
        <img src="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility-7.4.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility-8.0.yaml">
        <img src="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility-8.0.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility-8.2.yaml">
        <img src="https://github.com/aljawaid/ContentCleaner/actions/workflows/php-compatibility-8.2.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
</p>

<details>
    <summary><strong>Installation</strong></summary>

- Install via the **[Kanboard](https://github.com/kanboard/kanboard "Kanboard - Kanban Project Management Software") Plugin Directory** or see [INSTALL.md](../master/INSTALL.md)
- Read the full [**Changelog**](../master/changelog.md "See changes") to see the latest updates

</details>
<details>
    <summary><strong>Compatibility</strong></summary>

- Requires [Kanboard](https://github.com/kanboard/kanboard "Kanboard - Kanban Project Management Software") ≥`1.2.20`
- **Other Plugins & Action Plugins**
  - _No known issues_
  - Compatible with [PluginManager](https://github.com/aljawaid/PluginManager)
- **Core Files & Templates**
  - _No template overrides_
  - No database changes are made by this plugin other than the deletion of database content
  - MS SQL databases are not supported

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
    <a href="https://github.com/aljawaid/ContentCleaner/stargazers" title="View Stargazers">
        <img src="https://img.shields.io/github/stars/aljawaid/ContentCleaner?logo=github&style=flat-square" alt="ContentCleaner">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/forks" title="See Forks">
        <img src="https://img.shields.io/github/forks/aljawaid/ContentCleaner?logo=github&style=flat-square" alt="ContentCleaner">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/blob/master/LICENSE" title="Read License">
        <img src="https://img.shields.io/github/license/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/issues" title="Open Issues">
        <img src="https://img.shields.io/github/issues-raw/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/issues?q=is%3Aissue+is%3Aclosed" title="Closed Issues">
        <img src="https://img.shields.io/github/issues-closed/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/discussions" title="Read Discussions">
        <img src="https://img.shields.io/github/discussions/aljawaid/ContentCleaner?style=flat-square" alt="ContentCleaner">
    </a>
    <a href="https://github.com/aljawaid/ContentCleaner/compare/" title="Latest Commits">
        <img alt="GitHub commits since latest release (by date)" src="https://img.shields.io/github/commits-since/aljawaid/ContentCleaner/latest?style=flat-square">
    </a>
</p>
<p align="right">[<a href="#user-content-readme-top">&#8593; Top</a>]</p>
<a name="user-content-readme-bottom"></a>
