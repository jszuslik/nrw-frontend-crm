<?php

class NrwContactsPostType {

	public function __construct() {
		add_action( 'init', array($this, 'nrw_contacts_post_type'), 0 );
	}

	// Register Custom Post Type
	function nrw_contacts_post_type() {

		$labels = array(
			'name'                  => _x( 'Contacts', 'Post Type General Name', 'nrw-frontend-crm' ),
			'singular_name'         => _x( 'Contact', 'Post Type Singular Name', 'nrw-frontend-crm' ),
			'menu_name'             => __( 'Contacts', 'nrw-frontend-crm' ),
			'name_admin_bar'        => __( 'Contact', 'nrw-frontend-crm' ),
			'archives'              => __( 'Contact Archives', 'nrw-frontend-crm' ),
			'attributes'            => __( 'Contact Attributes', 'nrw-frontend-crm' ),
			'parent_item_colon'     => __( 'Parent Item:', 'nrw-frontend-crm' ),
			'all_items'             => __( 'All Items', 'nrw-frontend-crm' ),
			'add_new_item'          => __( 'Add New Item', 'nrw-frontend-crm' ),
			'add_new'               => __( 'Add New', 'nrw-frontend-crm' ),
			'new_item'              => __( 'New Item', 'nrw-frontend-crm' ),
			'edit_item'             => __( 'Edit Item', 'nrw-frontend-crm' ),
			'update_item'           => __( 'Update Item', 'nrw-frontend-crm' ),
			'view_item'             => __( 'View Item', 'nrw-frontend-crm' ),
			'view_items'            => __( 'View Items', 'nrw-frontend-crm' ),
			'search_items'          => __( 'Search Item', 'nrw-frontend-crm' ),
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
			'label'                 => __( 'Contact', 'nrw-frontend-crm' ),
			'description'           => __( 'Contact', 'nrw-frontend-crm' ),
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
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'rewrite'               => false,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		register_post_type( 'nrw_contacts', $args );

	}
}
$nrw_contacts = new NrwContactsPostType();