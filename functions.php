<?php

/**
 * Theme Functions
 */

use ZT\Core\Classes\Theme;

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

if (!defined('ZT_THEME_VERSION')) {
    define('ZT_THEME_VERSION', '1.0.0');
}

if (!defined('ZT_THEME_FILE')) {
    define('ZT_THEME_FILE', __FILE__);
}

if (!defined('ZT_THEME_PATH')) {
    define('ZT_THEME_PATH', untrailingslashit(get_template_directory()));
}

if (!defined('ZT_THEME_URI')) {
    define('ZT_THEME_URL', untrailingslashit(get_template_directory_uri()));
}

if (!class_exists('Theme', false)) {

    function zt_init_theme(): object
    { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
        return Theme::get_instance();
    }

    zt_init_theme();

}


