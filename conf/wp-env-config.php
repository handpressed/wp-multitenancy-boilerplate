<?php
/**
 * Credential-free wp-config.php.
 *
 * @package WordPress
 */

/**
 * Load .env file (see: https://github.com/vlucas/phpdotenv).
 */
if ( ! defined( 'WP_ROOT' ) ) {
	define( 'WP_ROOT', getenv( 'DOCUMENT_ROOT' ) );
}

if ( file_exists( dirname( WP_ROOT ) . '/conf/.env' ) ) {
	$dotenv = new Dotenv\Dotenv( dirname( WP_ROOT ) . '/conf' );
	$dotenv->load();
	$dotenv->required( [ 'WP_HOME', 'DB_NAME', 'DB_USER', 'DB_PASSWORD' ] );
}

/**
 * Database.
 */
define( 'DB_NAME', getenv( 'DB_NAME' ) );
define( 'DB_USER', getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'DB_HOST' ) ? getenv( 'DATABASE_SERVER' ) : 'localhost' );
define( 'DB_CHARSET', getenv( 'DB_CHARSET' ) );
define( 'DB_COLLATE', getenv( 'DB_COLLATE' ) );

$table_prefix = getenv( '$table_prefix' ) ?: 'wp_';

/**
 * URLs.
 */
define( 'WP_HOME', rtrim( getenv( 'WP_HOME' ), '/' ) );
define( 'WP_SITEURL', WP_HOME . '/wp' );

/**
 * Custom content folder.
 */
define( 'WP_CONTENT_FOLDER', '/app' );
define( 'WP_CONTENT_URL', WP_HOME . WP_CONTENT_FOLDER );
define( 'WP_CONTENT_DIR', WP_ROOT . WP_CONTENT_FOLDER );

/**
 * Check for https.
 */
$is_ssl   = (boolean) getenv( 'HTTPS' ) || 443 === getenv( 'SERVER_PORT' ) || 'https' === getenv( 'HTTP_X_FORWARDED_PROTO' );
$protocol = $is_ssl ? 'https' : 'http';

/**
 * Constants.
 */
if ( 'https' === $protocol ) {
	define( 'FORCE_SSL_LOGIN', true );
	define( 'FORCE_SSL_ADMIN', true );
}

define( 'WP_CACHE_KEY_SALT', getenv( 'SERVER_NAME' ) . '_' );
define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

if ( file_exists( dirname( WP_ROOT ) . '/conf/wp-constants.php' ) ) {
	require_once dirname( WP_ROOT ) . '/conf/wp-constants.php';
}

/**
 * Authentication unique keys and salts.
 */
if ( file_exists( dirname( WP_ROOT ) . '/conf/wp-salts.php' ) ) {
	require_once dirname( WP_ROOT ) . '/conf/wp-salts.php';
}

/**
 * Bootstrap WordPress.
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', WP_ROOT . '/wp' );
}
