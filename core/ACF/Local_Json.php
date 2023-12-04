<?php

namespace ZT\Core\ACF;

defined( 'ABSPATH' ) || exit;

class Local_Json {

    public static string $localpath = "/core/ACF/local-json";

    public static function init() {

        add_filter('acf/settings/save_json', [__CLASS__,'acf_json_save_point']);
        add_filter('acf/settings/load_json', [__CLASS__,'acf_json_load_point']);

    }

    public static function acf_json_save_point(): string {
        // Update path
        return ZT_THEME_PATH . self::$localpath;
    }

    public static function acf_json_load_point($paths){
        // Remove original path
        unset( $paths[0] );
        // Append our new path
        $paths[] = ZT_THEME_PATH . self::$localpath;

        return $paths;
    }
}