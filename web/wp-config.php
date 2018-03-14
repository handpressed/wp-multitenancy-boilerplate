<?php
/**
 * Default wp-config.php.
 *
 * @package WordPress
 */

/**
 * Load wp-env-config.php.
 */
if ( file_exists( dirname( __DIR__ ) . '/conf/wp-env-config.php' ) ) {
	require_once dirname( __DIR__ ) . '/vendor/autoload.php';
	require_once dirname( __DIR__ ) . '/conf/wp-env-config.php';
	require_once ABSPATH . 'wp-settings.php';
} else {
	die( 'wp-env-config.php not found' );
}
