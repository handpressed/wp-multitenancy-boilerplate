# WordPress Multitenancy Boilerplate

Use Composer to configure and manage a WordPress instance (including themes and plugins) that's shared with multiple sites.

- [Features](#features)
- [Requirements](#requirements)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
	- [Themes](#themes)
	- [Plugins](#plugins)
	- [Constants](#constants)
- [Directory structure](#directory-structure)
- [Adding sites](#adding-sites)
- [See also](#see-also)
- [Credit](#credit)

## Features

- Improved directory structure
- Dependency management with [Composer](https://getcomposer.org)
- Easy WordPress configuration with constants and environment files
- Environment variables with [PHP dotenv](https://github.com/vlucas/phpdotenv)
- Enhanced security (separated web root and secure passwords with [roots/wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))
- WordPress [multitenancy](https://en.wikipedia.org/wiki/Multitenancy) (a single instance of WordPress core, themes and plugins serving multiple sites)

## Requirements

- PHP 5.6+
- Composer

## Prerequisites

[Install Composer](https://getcomposer.org/doc/00-intro.md):

```bash
$ curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
```

## Installation

```bash
$ composer create-project handpressed/wp-multitenancy-boilerplate {directory}
```

Replace `{directory}` with the name of your new project, e.g. its domain name.

Composer will download WordPress, move it to `/var/opt/wp` and then symlink `/var/opt/wp` to `{directory}/web/wp`.

Composer will also symlink `/var/opt/wp/wp-content/themes` to `web/app/themes`, `/var/opt/wp/wp-content/plugins` to `web/app/plugins` and `/var/opt/wp/wp-content/mu-plugins` to `web/app/mu-plugins`.

Sites can now share this single instance of WordPress core, themes and plugins.

## Configuration

Open the `{directory}/conf/.env` file and add your new site's database credentials (`DB_NAME`, `DB_USER`, `DB_PASSWORD`) and define a database `$table_prefix` (default is `wp_`).

Set your site's vhost document root to `/path/to/{directory}/web`.

### Themes

Add themes in `{directory}/web/app/themes` as you would for a normal WordPress install.

### Plugins

[WordPress Packagist](https://wpackagist.org) is already registered in the `composer.json` file so any plugins from the [WordPress Plugin Directory](https://wordpress.org/plugins/) can easily be required.

To add a plugin, use `composer require <namespace>/<packagename>` from the command-line. If it's from WordPress Packagist then the namespace is always `wpackagist-plugin`, e.g.:

```bash
$ composer require wpackagist-plugin/jetpack:*
```

Whenever you add a new plugin or update WordPress core, run `composer update` to install your new packages.

You can continue to use the WordPress admin to update themes and plugins (you don’t have to worry about breaking your install or being out-of-sync with your `composer.json` file).

Note: Some plugins may make modifications to the core `wp-config.php` file and other files in the `app` directory. Any modifications to `wp-config.php` that are required should be moved to an individual site's `config/wp-constants.php` file.

### Constants

Put custom core, theme and plugin constants in `{directory}/conf/wp-constants.php`.

## Directory structure

    ├── composer.json             → Manage versions of WordPress, plugins and dependencies
    ├── config                    → WordPress configuration files
    │   ├── .env       	      → WordPress environment variables (DB_NAME, DB_USER, DB_PASSWORD required)
    │   ├── wp-constants.php      → Custom core, theme and plugin constants
    │   ├── wp-env-config.php     → Primary WordPress config file (wp-config.php equivalent)
    │   └── wp-salts.php          → Authentication unique keys and salts (auto generated)
    ├── vendor                    → Composer packages (never edit)
    └── web                       → Web root (vhost document root)
        ├── app                   → wp-content equivalent
        │   ├── mu-plugins        ↔ Must-use plugins symlinked to /var/opt/wp/wp-content/mu-plugins
        │   ├── plugins           ↔ Plugins Must-use plugins symlinked to /var/opt/wp/wp-content/plugins
        │   ├── themes            ↔ Themes Must-use plugins symlinked to /var/opt/wp/wp-content/themes
        │   └── uploads           → Uploads
        ├── index.php             → Loads the WordPress environment and template (never edit)
        └── wp                    ↔ WordPress core symlinked to /var/opt/wp (never edit)
	    	└── wp-config.php     → Required by WordPress - loads conf/wp-env-config.php (never edit)

`↔` denotes a symlink.

## Adding sites

Coming soon...

## See also

[WordPress Dotenv Boilerplate](https://github.com/handpressed/wp-env-boilerplate)

## Credit

Based on [handpressed/wp-env-boilerplate](https://github.com/handpressed/wp-env-boilerplate). Inspired by [roots/bedrock](https://github.com/roots/bedrock) and [wpscholar/wp-skeleton](https://github.com/wpscholar/wp-skeleton).