<?php
/*
	Plugin Name: Plugin Start
	Plugin URI: https://joshuaszuslik.us
	Description: Plugin Start for Additional Projects
	Version: 0.1
	Author: Joshua Szuslik
	Author URI: https://joshuaszuslik.us
	License: GPL2
*/
define('NRW_PLUGIN_PREFIX', 'nrw_');
define('NRW_PLUGIN_PREFIX_CONSTANT', 'NRW_');
define(NRW_PLUGIN_PREFIX_CONSTANT . 'TEXT_DOMAIN', '');

function nrw_require_file( $path ) {
    if ( file_exists($path) ) {
        require $path;
    }
}
if ( function_exists(NRW_PLUGIN_PREFIX . 'require_file') ) {
    $plugin_dir = plugin_dir_path(__FILE__);
    nrw_require_file( $plugin_dir . '' );
}