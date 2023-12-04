<?php

if (!defined('ABSPATH')) {
    exit;
}

function zt_get_path($filename = ''): string
{
    return ZT_THEME_PATH . $filename;
}

function zt_include($filename = '')
{
    $file_path = zt_get_path($filename);
    if (file_exists($file_path)) {
        include_once $file_path;
    }
}