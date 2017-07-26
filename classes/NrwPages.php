<?php
/**
 * This class is used to set settings for newly created pages.
 */
class NrwPages {

    public function __construct() {
    }

    static function nrw_add_private_page() {
        $private_pages[] = array(
            'post_title' => 'Dashboard',
            'post_content' => '',
            'post_status' => 'private',
            'post_author' => get_current_user_id(),
            'post_type' => 'page',
        );

        foreach ($private_pages as $private_page) {
        	if(!get_page_by_path($private_page['post_title'])) {
		        wp_insert_post($private_page, true);
	        }
        }

    }

}
