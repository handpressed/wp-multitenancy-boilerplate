<?php
/**
 * Credential-free wp-config.php.
 *
 * @package WordPress
 */

/**
 * @var string Directory containing all of the site's files.
 */
$root_dir = dirname( __DIR__ );

/**
 * @var string Document root.
 */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function (see: https://github.com/oscarotero/env).
 */
Env::init();

/**
 * Load .env file (see: https://github.com/vlucas/phpdotenv).
 */
$dotenv = new Dotenv\Dotenv( $root_dir );

if ( file_exists( $root_dir . '/.env' ) ) {
	$dotenv->load();
	$dotenv->required( [ 'WP_HOME', 'DB_NAME', 'DB_USER', 'DB_PASSWORD' ] );
}

/**
 * Database.
 */
define( 'DB_NAME', env( 'DB_NAME' ) );
define( 'DB_USER', env( 'DB_USER' ) );
define( 'DB_PASSWORD', env( 'DB_PASSWORD' ) );
define( 'DB_HOST', env( 'DB_HOST' ) ? env( 'DATABASE_SERVER' ) : 'localhost' );
define( 'DB_CHARSET', env( 'DB_CHARSET' ) );
define( 'DB_COLLATE', env( 'DB_COLLATE' ) );

$table_prefix = env( '$table_prefix' ) ?: 'wp_';

/**
 * URLs.
 */
define( 'WP_HOME', rtrim( env( 'WP_HOME' ), '/' ) );
define( 'WP_SITEURL', WP_HOME . '/wp' );

/**
 * Custom content folder.
 */
define( 'CONTENT_DIR', '/app' );
define( 'WP_CONTENT_URL', WP_HOME . CONTENT_DIR );
define( 'WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR );

/**
 * Check for https.
 */
$is_ssl   = (boolean) env( 'HTTPS' ) || 443 === env( 'SERVER_PORT' ) || 'https' === env( 'HTTP_X_FORWARDED_PROTO' );
$protocol = $is_ssl ? 'https' : 'http';

/**
 * Constants.
 */
if ( 'https' === $protocol ) {
	define( 'FORCE_SSL_LOGIN', true );
	define( 'FORCE_SSL_ADMIN', true );
}

define( 'WP_CACHE_KEY_SALT', WP_HOME . '_' );
define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/**
 * Disable all file modifications including updates and update notifications.
 */
define( 'DISALLOW_FILE_MODS', true );

if ( file_exists( $root_dir . '/conf/wp-constants.php' ) ) {
	require_once $root_dir . '/conf/wp-constants.php';
}

/**
 * Authentication unique keys and salts.
 */
if ( file_exists( $root_dir . '/conf/wp-salts.php' ) ) {
	require_once $root_dir . '/conf/wp-salts.php';
}

/**
 * Bootstrap WordPress.
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', $webroot_dir . '/wp' );
}
