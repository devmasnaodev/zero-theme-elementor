<?php

namespace ZT\Core\ACF;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Local JSON
 *
 * Handles the local JSON save and load points for Advanced Custom Fields (ACF).
 *
 * @package Zero_Theme
 */
class Local_Json {

	/**
	 * @var string $localpath The relative path to the local JSON directory.
	 */
	public static string $localpath = '/core/ACF/local-json';

	/**
	 * Initializes the class by adding the necessary filters for ACF JSON save and load points.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'acf/settings/save_json', array( __CLASS__, 'acf_json_save_point' ) );
		add_filter( 'acf/settings/load_json', array( __CLASS__, 'acf_json_load_point' ) );
	}

	/**
	 * Returns the path where ACF JSON files should be saved.
	 *
	 * @return string The path to the local JSON save directory.
	 */
	public static function acf_json_save_point(): string {
		return ZT_THEME_PATH . self::$localpath;
	}

	/**
	 * Modifies the paths where ACF JSON files should be loaded from.
	 *
	 * @param array $paths The existing paths where ACF JSON files are loaded from.
	 * @return array The modified paths including the local JSON load directory.
	 */
	public static function acf_json_load_point( $paths ) {
		unset( $paths[0] );
		$paths[] = ZT_THEME_PATH . self::$localpath;
		return $paths;
	}
}
