<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the path to a file in the theme.
 *
 * @param string $filename The filename.
 * @return string The path to the file.
 */
function zt_get_path( $filename = '' ): string {
	return ZT_THEME_PATH . $filename;
}

/**
 * Include a file from the theme.
 *
 * @param string $filename The filename.
 */
function zt_include( $filename = '' ) {
	$file_path = zt_get_path( $filename );
	if ( file_exists( $file_path ) ) {
		include_once $file_path;
	}
}
