<?php

class NrwAccountsMeta {

	private $nrw_account_meta_info = '';

	private $nrw_account_meta_address = '';

	private $stored_meta_data = null;

	public function __construct() {
		if(isset($_GET['post'])) {
			$post_id = $_GET['post'];
			$this->stored_meta_data = get_post_meta( $post_id );
		}
		add_action('add_meta_boxes', array($this, 'nrw_add_account_meta_boxes'));
		add_action('add_meta_boxes', array($this, 'nrw_add_account_address_meta_boxes'));
		add_action('save_post', array( $this, 'nrw_save_accounts_meta_data' ) );

		$this->nrw_account_meta_address = array(
			array(
				'name' => '',
				'split_columns' => true,
				'fields' => array(
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_billing_street',
							'id' => 'nrw_billing_street',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Billing Street', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_billing_city',
							'id' => 'nrw_billing_city',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Billing City', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_billing_state',
							'id' => 'nrw_billing_state',
							'options' => MetaBuild::list_of_states(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Billing State', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_billing_zip',
							'id' => 'nrw_billing_zip',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Billing Postal Code', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_billing_country',
							'id' => 'nrw_billing_country',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Billing Country', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_shipping_street',
							'id' => 'nrw_shipping_street',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Shipping Street', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_shipping_city',
							'id' => 'nrw_shipping_city',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Shipping City', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_shipping_state',
							'id' => 'nrw_shipping_state',
							'meta_id' => $this->stored_meta_data,
							'options' => MetaBuild::list_of_states(),
							'label' => __('Shipping State', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_shipping_zip',
							'id' => 'nrw_shipping_zip',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Shipping Postal Code', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_shipping_country',
							'id' => 'nrw_shipping_country',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Shipping Country', NRW_TEXT_DOMAIN)
						)
					)
				)
			)
		);

		$this->nrw_account_meta_info = array(
			array(
				'name' => '',
				'split_columns' => true,
				'fields' => array(
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_name',
							'id' => 'nrw_account_name',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Account Name', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_site',
							'id' => 'nrw_account_site',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Account Site', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_account_parent',
							'id' => 'nrw_account_parent',
							'options' => MetaBuild::get_posts_by_post_type('nrw_accounts'),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Parent Account', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_number',
							'id' => 'nrw_account_number',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Account Number', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_account_type',
							'id' => 'nrw_account_type',
							'options' => MetaBuild::account_types(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Account Type', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_industry',
							'id' => 'nrw_account_industry',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Industry', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'currency',
							'name' => 'nrw_account_revenue',
							'id' => 'nrw_account_revenue',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Annual Revenue', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_account_rating',
							'id' => 'nrw_account_rating',
							'options' => MetaBuild::ratings(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Rating', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'phone',
							'name' => 'nrw_phone',
							'id' => 'nrw_phone',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Phone', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'phone',
							'name' => 'nrw_fax',
							'id' => 'nrw_fax',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Fax', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_website',
							'id' => 'nrw_account_website',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Website', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_ticker',
							'id' => 'nrw_account_ticker',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Ticker Symbol', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_account_ownership',
							'id' => 'nrw_account_ownership',
							'options' => MetaBuild::types_of_ownership(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Ownership', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_account_employees',
							'id' => 'nrw_account_employees',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Employees', NRW_TEXT_DOMAIN)
						)
					)
				)
			)
		);
	}
	public function nrw_add_account_address_meta_boxes( $post ) {
		add_meta_box( 'nrw_account_address_meta_box', __('Account Address', NRW_TEXT_DOMAIN), array($this, 'nrw_account_address_build_meta_box'), 'nrw_accounts', 'normal', 'high');
	}
	public function nrw_add_account_meta_boxes( $post ) {
		add_meta_box( 'nrw_account_info_meta_box', __('Account Information', NRW_TEXT_DOMAIN), array($this, 'nrw_account_info_build_meta_box'), 'nrw_accounts', 'normal', 'high');
	}


	public function nrw_account_address_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), NRW_PAGE_NONCE );

		$this->stored_meta_data = get_post_meta( $post->ID );

		MetaBuild::nrw_do_meta_fields($this->nrw_account_meta_address, $this->stored_meta_data);
	}

	public function nrw_account_info_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), NRW_PAGE_NONCE );

		$this->stored_meta_data = get_post_meta( $post->ID );

		MetaBuild::nrw_do_meta_fields($this->nrw_account_meta_info, $this->stored_meta_data);
	}

	public function nrw_save_accounts_meta_data( $post_id ) {
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[NRW_PAGE_NONCE] ) && wp_verify_nonce( $_POST[NRW_PAGE_NONCE], basename(__FILE__) ) ) ? 'true' : 'false';

		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		foreach ($this->nrw_account_meta_info as $field_group) {
			foreach($field_group['fields'] as $field) {
				if (isset($_POST[$field['id']])) {
					update_post_meta( $post_id, $field['id'], sanitize_text_field($_POST[$field['id']] ) );
				}
			}
		}

		foreach ($this->nrw_account_meta_address as $field_group) {
			foreach($field_group['fields'] as $field) {
				if (isset($_POST[$field['id']])) {
					update_post_meta( $post_id, $field['id'], sanitize_text_field($_POST[$field['id']] ) );
				}
			}
		}
	}
}
$nrw_accounts_meta = new NrwAccountsMeta();