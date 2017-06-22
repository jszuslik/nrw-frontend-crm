<?php
/*
	Plugin Name: NRW FrontEnd Modular CRM
	Plugin URI: https://joshuaszuslik.us
	Description: Modualr CRM to be customized Depending on Needs.
	Version: 0.1
	Author: Joshua Szuslik
	Author URI: https://joshuaszuslik.us
	License: GPL2
*/
define('NRW_PLUGIN_PREFIX', 'nrw_');
define('NRW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('NRW_TEXT_DOMAIN', 'nrw-frontend-crm');
define('NRW_ACTIVATION_DIR', NRW_PLUGIN_DIR . 'activation/');
define('NRW_CLASSES_DIR', NRW_PLUGIN_DIR . 'classes/');

function nrw_require_file( $path ) {
    if ( file_exists($path) ) {
        require $path;
    }
}
if ( function_exists(NRW_PLUGIN_PREFIX . 'require_file') ) {
    $plugin_dir = plugin_dir_path(__FILE__);
    nrw_require_file( NRW_CLASSES_DIR . 'nrw-pages.php');
}

register_activation_hook(__FILE__, array('NrwPages', 'nrw_add_private_page'));