<?php

class NrwAccountsList extends WP_Posts_List_Table {

	public $post_type;

	public function __construct( $args = array() ) {
		$this->post_type = $args['post_type'];

		parent::__construct(array(
			'plural' => 'nrw_accounts',
			'screen' => isset($args['screen']) ? $args['screen'] : null,
		));
	}

	public function get_columns() {
		$columns = array(
			'account_name' => 'Account Name',
			'account_phone' => 'Phone',
			'account_website' => 'Website',
			'account_owner' => 'Account Owner'
		);
		return $columns;
	}

	protected function get_default_primary_column_name() {
		return 'account_name';
	}

	public function column_cb( $post ) {
	}

	public function get_sortable_columns() {
		$sortable = array(
			'account_name' => array('account_name', false)
		);
		return $sortable;
	}

	public function extra_tablenav( $which ) {
		if ( $which == "top" ){
			$link = 'post-new.php?post_type=' . $this->post_type;
			$button = '<div class="alignleft">';
			$button .= '<a href="'.$link.'" id="add_new" class="button action" >Add New</a>';
			$button .= '</div>';

			echo $button;
		}
		if ( $which == "bottom" ){
			$link = 'post-new.php?post_type=' . $this->post_type;
			$button = '<div class="alignleft">';
			$button .= '<a href="'.$link.'" id="add_new" class="button action" >Add New</a>';
			$button .= '</div>';

			echo $button;
		}
	}

	public function column_default($item, $column_name) {
		$owner = get_user_by( 'ID', $item->post_author);

		switch($column_name) {
			case 'account_name':
				return $item->post_title;
			case 'account_phone':
				return get_post_meta($item->ID, 'nrw_phone', true);
			case 'account_website':
			case 'account_owner':
				return $owner->display_name;
			default:
				return print_r($item, true);
		}
	}

	public function column_account_website($item) {
		$website = get_post_meta($item->ID, 'nrw_account_website', true);
		return sprintf('<a href="%s" target="_blank">%s</a>', $website, $website);
	}

	function get_bulk_actions() {

	}

	public function prepare_items() {
		global $avail_post_stati, $wp_query, $per_page, $mode;

		// is going to call wp()
		$args = array(
			'post_type' => $this->post_type,
			'post_status' => 'private'
		);
		$avail_post_stati = wp_edit_posts_query($args);

		$this->set_hierarchical_display( is_post_type_hierarchical( $this->screen->post_type ) && 'menu_order title' === $wp_query->query['orderby'] );

		$post_type = $this->screen->post_type;
		$per_page = $this->get_items_per_page( 'edit_' . $post_type . '_per_page' );

		/** This filter is documented in wp-admin/includes/post.php */
		$per_page = apply_filters( 'edit_posts_per_page', $per_page, $post_type );

		if ( $this->hierarchical_display ) {
			$total_items = $wp_query->post_count;
		} elseif ( $wp_query->found_posts || $this->get_pagenum() === 1 ) {
			$total_items = $wp_query->found_posts;
		} else {
			$post_counts = (array) wp_count_posts( $post_type, 'readable' );

			if ( isset( $_REQUEST['post_status'] ) && in_array( $_REQUEST['post_status'] , $avail_post_stati ) ) {
				$total_items = $post_counts[ $_REQUEST['post_status'] ];
			} elseif ( isset( $_REQUEST['show_sticky'] ) && $_REQUEST['show_sticky'] ) {
				$total_items = $this->sticky_posts_count;
			} elseif ( isset( $_GET['author'] ) && $_GET['author'] == get_current_user_id() ) {
				$total_items = $this->user_posts_count;
			} else {
				$total_items = array_sum( $post_counts );

				// Subtract post types that are not included in the admin all list.
				foreach ( get_post_stati( array( 'show_in_admin_all_list' => false ) ) as $state ) {
					$total_items -= $post_counts[ $state ];
				}
			}
		}

		if ( ! empty( $_REQUEST['mode'] ) ) {
			$mode = $_REQUEST['mode'] === 'excerpt' ? 'excerpt' : 'list';
			set_user_setting( 'posts_list_mode', $mode );
		} else {
			$mode = get_user_setting( 'posts_list_mode', 'list' );
		}

		$this->is_trash = isset( $_REQUEST['post_status'] ) && $_REQUEST['post_status'] === 'trash';

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page' => $per_page
		) );
	}

	protected function handle_row_actions( $post, $column_name, $primary ) {
		if ( $primary !== $column_name ) {
			return '';
		}

		$post_type_object = get_post_type_object( $post->post_type );
		$can_edit_post = current_user_can( 'edit_post', $post->ID );
		$actions = array();
		$title = _draft_or_post_title();

		if ( $can_edit_post && 'trash' != $post->post_status ) {
			$actions['edit'] = sprintf(
				'<a href="%s" aria-label="%s">%s</a>',
				get_edit_post_link( $post->ID ),
				/* translators: %s: post title */
				esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $title ) ),
				__( 'Edit' )
			);
		}

		if ( current_user_can( 'delete_post', $post->ID ) ) {
			if ( 'trash' === $post->post_status ) {
				$actions['untrash'] = sprintf(
					'<a href="%s" aria-label="%s">%s</a>',
					wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-post_' . $post->ID ),
					/* translators: %s: post title */
					esc_attr( sprintf( __( 'Restore &#8220;%s&#8221; from the Trash' ), $title ) ),
					__( 'Restore' )
				);
			} elseif ( EMPTY_TRASH_DAYS ) {
				$actions['trash'] = sprintf(
					'<a href="%s" class="submitdelete" aria-label="%s">%s</a>',
					get_delete_post_link( $post->ID ),
					/* translators: %s: post title */
					esc_attr( sprintf( __( 'Move &#8220;%s&#8221; to the Trash' ), $title ) ),
					_x( 'Trash', 'verb' )
				);
			}
			if ( 'trash' === $post->post_status || ! EMPTY_TRASH_DAYS ) {
				$actions['delete'] = sprintf(
					'<a href="%s" class="submitdelete" aria-label="%s">%s</a>',
					get_delete_post_link( $post->ID, '', true ),
					/* translators: %s: post title */
					esc_attr( sprintf( __( 'Delete &#8220;%s&#8221; permanently' ), $title ) ),
					__( 'Delete Permanently' )
				);
			}
		}

		if ( is_post_type_hierarchical( $post->post_type ) ) {

			/**
			 * Filters the array of row action links on the Pages list table.
			 *
			 * The filter is evaluated only for hierarchical post types.
			 *
			 * @since 2.8.0
			 *
			 * @param array $actions An array of row action links. Defaults are
			 *                         'Edit', 'Quick Edit', 'Restore, 'Trash',
			 *                         'Delete Permanently', 'Preview', and 'View'.
			 * @param WP_Post $post The post object.
			 */
			$actions = apply_filters( 'page_row_actions', $actions, $post );
		} else {

			/**
			 * Filters the array of row action links on the Posts list table.
			 *
			 * The filter is evaluated only for non-hierarchical post types.
			 *
			 * @since 2.8.0
			 *
			 * @param array $actions An array of row action links. Defaults are
			 *                         'Edit', 'Quick Edit', 'Restore, 'Trash',
			 *                         'Delete Permanently', 'Preview', and 'View'.
			 * @param WP_Post $post The post object.
			 */
			$actions = apply_filters( 'post_row_actions', $actions, $post );
		}

		return $this->row_actions( $actions );
	}

}