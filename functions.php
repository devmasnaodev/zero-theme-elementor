<?php
/**
 * Theme Functions
 *
 * @package Zero_Theme
 */

use ZT\Core\Classes\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

if ( ! defined( 'ZT_THEME_VERSION' ) ) {
	define( 'ZT_THEME_VERSION', '1.0.1' );
}

if ( ! defined( 'ZT_THEME_FILE' ) ) {
	define( 'ZT_THEME_FILE', __FILE__ );
}

if ( ! defined( 'ZT_THEME_PATH' ) ) {
	define( 'ZT_THEME_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'ZT_THEME_URI' ) ) {
	define( 'ZT_THEME_URL', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! class_exists( 'Theme', false ) ) {

	/**
	 * Initializes the theme.
	 *
	 * @return object Theme
	 */
	function zt_init_theme(): object {
		return Theme::get_instance();
	}

	zt_init_theme();

}
