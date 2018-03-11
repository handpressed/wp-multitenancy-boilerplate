# WordPress Multitenancy Boilerplate

WordPress multitenancy boilerplate configured and managed with Composer and PHP dotenv.

## Features

- Improved directory structure
- Dependency management with [Composer](https://getcomposer.org)
- Easy WordPress configuration with constants and environment files
- Environment variables with [PHP dotenv](https://github.com/vlucas/phpdotenv)
- Enhanced security (separated web root and secure passwords with [roots/wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))
- WordPress [multitenancy](https://en.wikipedia.org/wiki/Multitenancy) (a single instance of WordPress core, themes and plugins serves multiple sites)

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

Composer will download and install WordPress, move it to `/var/opt/wp` and then symlink it to `{directory}/web/wp`. Composer will also symlink `/var/opt/wp/wp-content/themes` to `web/app/themes`, and `/var/opt/wp/wp-content/plugins` to `web/app/plugins`.

All sites can now share this single instance of WordPress core, themes and plugins.

## Configuration

Open the `{directory}/conf/.env` file and add your site's database credentials, including `$table_prefix` (default is `wp_`).

Set your site's vhost document root to `/path/to/{directory}/web`.

### Themes

Add themes in `{directory}/web/app/themes` as you would for a normal WordPress install.

### Plugins

[WordPress Packagist](https://wpackagist.org) is already registered in the `composer.json` file so any plugins from the [WordPress Plugin Directory](https://wordpress.org/plugins/) can easily be required.

To add a plugin, use `composer require <namespace>/<packagename>` from the command-line. If it's from WordPress Packagist then the namespace is always `wpackagist-plugin`, e.g.:

```bash
$ composer require wpackagist-plugin/jetpack:dev-trunk
```

Whenever you add a new plugin or update WordPress core, run `composer update` to install your new packages.

You can continue to use the WordPress admin to update themes and plugins (you don’t have to worry about breaking your install or being out-of-sync with your `composer.json` file).

### Constants

Put custom core, theme and plugin constants in `{directory}/wp-constants.php`.

## Adding Sites

To add sites, duplicate and rename `{directory}` and edit `{new_directory}/conf/.env` with the new site's database credentials. Add a vhost and set the document root to `/path/to/{new_directory}/web`.

New sites will share the same instance of WordPress core, themes and plugins configured by Composer.

## Credit

Based on [handpressed/wp-env-boilerplate](https://github.com/handpressed/wp-env-boilerplate). Inspired by [roots/bedrock](https://github.com/roots/bedrock) and [wpscholar/wp-skeleton](https://github.com/wpscholar/wp-skeleton).