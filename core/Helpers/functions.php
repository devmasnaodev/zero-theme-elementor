<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'zt_body_open' ) ) {

	/**
	 * Wrapper function to deal with backwards compatibility.
	 */
	function zt_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}

if ( ! function_exists( 'verify_elementor_template_type' ) ) {

	/**
	 * Check if the template is a header or footer
	 *
	 * @author Rodrigo Gomes <rodrigo.dev.ux@outlook.com>
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $location_manager An instance of locations manager.

	 */
	function verify_elementor_template_type( $location_manager ) {

		$reflection = new ReflectionClass( $location_manager );
		$property   = $reflection->getProperty( 'locations_queue' );
		$property->setAccessible( true );
		$locations_queue = $property->getValue( $location_manager );

		if ( isset( $locations_queue['header'] ) ) {
			unset( $locations_queue['header'] );
			$property->setValue( $location_manager, $locations_queue );
			remove_action( 'elementor/theme/header', array( $location_manager, 'do_location' ) );
		}

		if ( isset( $locations_queue['footer'] ) ) {
			unset( $locations_queue['footer'] );
			$property->setValue( $location_manager, $locations_queue );
			remove_action( 'elementor/theme/footer', array( $location_manager, 'do_location' ) );
		}
	}
}

if ( ! function_exists( 'hide_header_footer_on_elementor_special_templates' ) ) {

	/**
	 * Remove header and footer on Elementor special templates
	 *
	 * @author Rodrigo Gomes <rodrigo.dev.ux@outlook.com>
	 * @return void
	 */
	function hide_header_footer_on_elementor_special_templates() {

		$template_type = get_post_meta( get_the_ID(), '_elementor_template_type', true );

		if ( 'container' === $template_type || 'section' === $template_type ) {
			add_action( 'elementor/theme/before_do_header', 'verify_elementor_template_type' );
			add_action( 'elementor/theme/before_do_footer', 'verify_elementor_template_type' );
		}
	}
}

if ( ZT_ELEMENTOR_HIDE_HEADER_AND_FOOTER_ON_EDITOR ) {
	add_action( 'wp', 'hide_header_footer_on_elementor_special_templates' );
}
