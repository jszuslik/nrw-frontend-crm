<?php
/*
	Plugin Name: NRW FrontEnd Modular CRM
	Plugin URI: https://joshuaszuslik.us
	Description: Modular CRM to be customized Depending on Needs.
	Version: 0.1
	Author: Joshua Szuslik
	Author URI: https://joshuaszuslik.us
	License: GPL2
*/
define('NRW_PLUGIN_PREFIX', 'nrw_');
define('NRW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('NRW_TEXT_DOMAIN', 'nrw-frontend-crm');
define('NRW_CLASSES_DIR', NRW_PLUGIN_DIR . 'classes/');
define('NRW_META_BUILD_DIR', NRW_PLUGIN_DIR . 'meta-build/');
define('NRW_PAGE_NONCE', 'nrw_accounts_meta_box_nonce');

function nrw_require_file( $path ) {
    if ( file_exists($path) ) {
        require $path;
    }
}
if ( function_exists(NRW_PLUGIN_PREFIX . 'require_file') ) {
    $plugin_dir = plugin_dir_path(__FILE__);
	nrw_require_file( NRW_CLASSES_DIR . 'NrwActions.php');
	nrw_require_file( NRW_META_BUILD_DIR . 'MetaBuild.php');

    nrw_require_file( NRW_CLASSES_DIR . 'NrwPages.php');

	nrw_require_file( NRW_CLASSES_DIR . 'NrwScriptsStyles.php');

	nrw_require_file( NRW_CLASSES_DIR . 'options/NrwOption.php');
    nrw_require_file( NRW_CLASSES_DIR . 'accounts/NrwAccountsPostType.php');
	nrw_require_file( NRW_CLASSES_DIR . 'accounts/NrwAccountsMeta.php');
	nrw_require_file( NRW_CLASSES_DIR . 'contacts/NrwContactsPostType.php');
	nrw_require_file( NRW_CLASSES_DIR . 'contacts/NrwContactsMeta.php');


}
register_activation_hook(__FILE__, array('NrwPages', 'nrw_add_private_page'));


/**
 * Used as a debugging tool
 * @param $var
 */
function p($var) {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}


