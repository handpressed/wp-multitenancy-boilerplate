<?php
/**
 * Default wp-config.php.
 *
 * @package WordPress
 */

/**
 * Load wp-env-config.php.
 */
if ( ! defined( 'WP_ROOT' ) ) {
	define( 'WP_ROOT', getenv( 'DOCUMENT_ROOT' ) );
}

if ( file_exists( dirname( WP_ROOT ) . '/wp-env-config.php' ) ) {
	require_once dirname( WP_ROOT ) . '/wp-env-config.php';
} else {
	die( 'wp-env-config.php not found' );
}
