<?php

namespace ZT\Core\Classes;

use ZT\Core\Traits\Singleton;

class Assets
{

    use Singleton;

    protected function __construct()
    {
        $this->setup_hooks();
    }

    protected function setup_hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_styles']);
        add_action('wp_enqueue_scripts', [$this, 'dequeue_block_styles'],100);
        add_action('elementor/frontend/after_enqueue_scripts',[$this, 'register_scripts'],10);
        add_action('elementor/preview/enqueue_scripts',[$this, 'register_scripts'],10);
    }

    public function register_styles()
    {
        wp_enqueue_style('zero-theme-tailwind', get_template_directory_uri() . '/dist/css/tailwind.css', false, ZT_THEME_VERSION);
        wp_enqueue_style('zero-theme', get_template_directory_uri() . '/dist/css/theme.css', false, ZT_THEME_VERSION); }

    public function register_scripts(){

        wp_register_script( 'zero-theme-components', get_template_directory_uri() . '/dist/js/components.js', ['elementor-frontend'], ZT_THEME_VERSION,  true );
        wp_register_script( 'zero-theme-main', get_template_directory_uri() . '/dist/js/main.js', ['jquery'], ZT_THEME_VERSION,  true);

        wp_enqueue_script( 'zero-theme-components' );
        wp_enqueue_script( 'zero-theme-main' );
    }

    public function dequeue_block_styles()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wp-block-style');
    }

}