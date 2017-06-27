<?php
class NrwAccountsPostType {

    public function __construct() {
        add_action( 'init', array($this, 'nrw_accounts_post_type'), 0 );
    }

    // Register Custom Post Type
    function nrw_accounts_post_type() {

        $labels = array(
            'name'                  => _x( 'Accounts', 'Post Type General Name', 'nrw-frontend-crm' ),
            'singular_name'         => _x( 'Account', 'Post Type Singular Name', 'nrw-frontend-crm' ),
            'menu_name'             => __( 'Accounts', 'nrw-frontend-crm' ),
            'name_admin_bar'        => __( 'Account', 'nrw-frontend-crm' ),
            'archives'              => __( 'Account Archives', 'nrw-frontend-crm' ),
            'attributes'            => __( 'Account Attributes', 'nrw-frontend-crm' ),
            'parent_item_colon'     => __( 'Parent Item:', 'nrw-frontend-crm' ),
            'all_items'             => __( 'All Accounts', 'nrw-frontend-crm' ),
            'add_new_item'          => __( 'Add New Account', 'nrw-frontend-crm' ),
            'add_new'               => __( 'Add New Account', 'nrw-frontend-crm' ),
            'new_item'              => __( 'New Account', 'nrw-frontend-crm' ),
            'edit_item'             => __( 'Edit Account', 'nrw-frontend-crm' ),
            'update_item'           => __( 'Update Account', 'nrw-frontend-crm' ),
            'view_item'             => __( 'View Account', 'nrw-frontend-crm' ),
            'view_items'            => __( 'View Accounts', 'nrw-frontend-crm' ),
            'search_items'          => __( 'Search Account', 'nrw-frontend-crm' ),
            'not_found'             => __( 'Not found', 'nrw-frontend-crm' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'nrw-frontend-crm' ),
            'featured_image'        => __( 'Featured Image', 'nrw-frontend-crm' ),
            'set_featured_image'    => __( 'Set featured image', 'nrw-frontend-crm' ),
            'remove_featured_image' => __( 'Remove featured image', 'nrw-frontend-crm' ),
            'use_featured_image'    => __( 'Use as featured image', 'nrw-frontend-crm' ),
            'insert_into_item'      => __( 'Insert into item', 'nrw-frontend-crm' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'nrw-frontend-crm' ),
            'items_list'            => __( 'Items list', 'nrw-frontend-crm' ),
            'items_list_navigation' => __( 'Items list navigation', 'nrw-frontend-crm' ),
            'filter_items_list'     => __( 'Filter items list', 'nrw-frontend-crm' ),
        );
        $args = array(
            'label'                 => __( 'Account', 'nrw-frontend-crm' ),
            'description'           => __( 'Client Account', 'nrw-frontend-crm' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'author', 'thumbnail', ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => false,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( 'nrw_accounts', $args );

    }
}
$mrw_accounts = new NrwAccountsPostType();