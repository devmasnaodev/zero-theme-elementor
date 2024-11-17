<?php

namespace ZT\Core\Classes;

use ZT\Core\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Assets
 *
 * Handles the registration and enqueueing of styles and scripts for the theme.
 */
class Assets {

	use Singleton;

	/**
	 * Assets constructor.
	 *
	 * Initializes the class and sets up the necessary hooks.
	 */
	protected function __construct() {
		$this->setup_hooks();
		$this->remove_hooks();
	}

	/**
	 * Sets up WordPress hooks for enqueueing and dequeueing styles and scripts.
	 */
	protected function setup_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_block_styles' ), 100 );
		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'register_scripts' ), 10 );
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'register_scripts' ), 10 );
	}

	/**
	 * Removes the default WordPress global styles.
	 *
	 * @return void
	 */
	public function remove_hooks(){
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	}

	/**
	 * Registers and enqueues theme styles.
	 *
	 * @return void
	 */
	public function register_styles() {
		wp_enqueue_style( 'zero-theme-tailwind', get_template_directory_uri() . '/dist/css/tailwind.css', false, ZT_THEME_VERSION );
		wp_enqueue_style( 'zero-theme', get_template_directory_uri() . '/dist/css/theme.css', false, ZT_THEME_VERSION );
	}

	/**
	 * Registers and enqueues theme scripts.
	 *
	 * @return void
	 */
	public function register_scripts() {
		wp_register_script( 'zero-theme-components', get_template_directory_uri() . '/dist/js/components.js', array( 'elementor-frontend' ), ZT_THEME_VERSION, true );
		wp_register_script( 'zero-theme-main', get_template_directory_uri() . '/dist/js/main.js', array( 'jquery' ), ZT_THEME_VERSION, true );

		wp_enqueue_script( 'zero-theme-components' );
		wp_enqueue_script( 'zero-theme-main' );
	}

	/**
	 * Dequeues default WordPress block styles.
	 *
	 * @return void
	 */
	public function dequeue_block_styles() {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wp-block-style' );
	}
}
