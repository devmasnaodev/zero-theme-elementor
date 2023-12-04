<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Wrapper function to deal with backwards compatibility.
 */
if (!function_exists('zt_body_open')) {
    function zt_body_open()
    {
        if (function_exists('wp_body_open')) {
            wp_body_open();
        } else {
            do_action('wp_body_open');
        }
    }
}

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
