<?php

namespace ZT\Core\Classes;

use ZT\Core\ACF\Local_Json;
use ZT\Core\Traits\Singleton;
use ZT\Includes\Elementor\Elementor;

if (!defined('ABSPATH')) {
    exit;
}

final class Theme
{

    use Singleton;

    protected function __construct()
    {

        //ACF
        Local_Json::init();

        //Assets
        Assets::get_instance();

        //Elementor
        Elementor::get_instance();

        $this->setup_hooks();
        $this->load_helpers();
        $this->load_includes();
    }

    protected function setup_hooks()
    {

        /**
         * Actions.
         */
        add_action('after_setup_theme', [$this, 'setup_theme']);

    }

    protected function load_includes(){
    }

    protected function load_helpers(){

        require_once ZT_THEME_PATH . '/core/Helpers/utilities.php';

        zt_include('/core/Helpers/functions.php');

    }

    	/**
	 * Get the theme url.
	 *
	 * @return string
	 */
	public function theme_url()
	{
		return ZT_THEME_URL;
	}

	/**
	 * Get the theme path.
	 *
	 * @return string
	 */
	public function theme_path()
	{
		return ZT_THEME_PATH;
	}

    public function setup_theme()
    {

        /**
         * Load Tranlations for zero theme
         *
         * @link https://developer.wordpress.org/themes/functionality/internationalization/
         */
        load_theme_textdomain('zero-theme', get_template_directory() . '/languages');

        /**
         * Let WordPress manage the document title.
         *
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * Adding this will allow you to select the featured image on posts and pages.
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');


        /**
         * Register navigation menu
         * @link https://developer.wordpress.org/themes/functionality/navigation-menus/
         */
        register_nav_menus(['menu-header' => __('Header', 'zero-theme')]);

        /**
         * Custom logo.
         *
         * @see Adding custom logo
         * @link https://developer.wordpress.org/themes/functionality/custom-logo/#adding-custom-logo-support-to-your-theme
         */
        add_theme_support(
            'custom-logo',
            [
                'height' => 100,
                'width' => 350,
                'flex-height' => true,
                'flex-width' => true,
            ]
        );

        /**
         * Add default posts and comments RSS feed links to head.
         */
        add_theme_support('automatic-feed-links');

        /**
         * Switch default core markup for search form, comment form, comment-list, gallery, caption, script and style
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
            ]
        );

        /**
         * Editor Style.
         */
        add_editor_style('classic-editor.css');

    }
}