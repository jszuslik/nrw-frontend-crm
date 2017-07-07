<?php

class NrwContactsMeta {

	private $nrw_contact_meta_info = '';

	private $nrw_contact_meta_address = '';

	private $stored_meta_data = null;

	public function __construct(){
		if(isset($_GET['post'])) {
			$post_id = $_GET['post'];
			$this->stored_meta_data = get_post_meta( $post_id );
		}
		add_action('add_meta_boxes', array($this, 'nrw_add_contact_meta_boxes'));
		add_action('add_meta_boxes', array($this, 'nrw_add_contact_address_meta_boxes'));
		add_action('save_post', array( $this, 'nrw_save_contacts_meta_data' ) );

		$this->nrw_contact_meta_info = array(
			array(
				'name' => '',
				'split_columns' => true,
				'fields' => array(
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_first_name',
							'id' => 'nrw_first_name',
							'meta_id' => $this->stored_meta_data,
							'label' => __('First Name', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_last_name',
							'id' => 'nrw_last_name',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Last Name', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_account_name',
							'id' => 'nrw_account_name',
							'options' => MetaBuild::get_posts_by_post_type('nrw_accounts'),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Account Name', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_email_address',
							'id' => 'nrw_email_address',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Email', NRW_TEXT_DOMAIN)
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
							'name' => 'nrw_other_phone',
							'id' => 'nrw_other_phone',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Other Phone', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'phone',
							'name' => 'nrw_mobile_phone',
							'id' => 'nrw_mobile_phone',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Mobile', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_assistant',
							'id' => 'nrw_assistant',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Assistant', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'phone',
							'name' => 'nrw_asst_phone',
							'id' => 'nrw_asst_phone',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Asst Phone', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_reports_to',
							'id' => 'nrw_reports_to',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Reports To', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_lead_source',
							'id' => 'nrw_lead_source',
							'options' => MetaBuild::lead_sources(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Lead Source', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_title',
							'id' => 'nrw_title',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Title', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_department',
							'id' => 'nrw_department',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Department', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'phone',
							'name' => 'nrw_home_phone',
							'id' => 'nrw_home_phone',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Home Phone', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'phone',
							'name' => 'nrw_home_fax',
							'id' => 'nrw_home_fax',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Fax', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'dob',
							'name' => 'nrw_date_of_birth',
							'id' => 'nrw_date_of_birth',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Date of Birth', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'checkbox',
							'name' => 'nrw_email_opt_out',
							'id' => 'nrw_email_opt_out',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Email Opt Out', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_skype_id',
							'id' => 'nrw_skype_id',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Skype ID', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_sec_email',
							'id' => 'nrw_sec_email',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Secondary Email', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_twitter_id',
							'id' => 'nrw_twitter_id',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Twitter ID', NRW_TEXT_DOMAIN)
						)
					)

				)
			)
		);
		$this->nrw_contact_meta_address = array(
			array(
				'name' => '',
				'split_columns' => true,
				'fields' => array(
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_mailing_street',
							'id' => 'nrw_mailing_street',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Mailing Street', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_mailing_city',
							'id' => 'nrw_mailing_city',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Mailing City', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_mailing_state',
							'id' => 'nrw_mailing_state',
							'options' => MetaBuild::list_of_states(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Mailing State', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_mailing_postal_code',
							'id' => 'nrw_mailing_postal_code',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Mailing Postal Code', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_mailing_country',
							'id' => 'nrw_mailing_country',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Mailing Country', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_other_street',
							'id' => 'nrw_other_street',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Other Street', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_other_city',
							'id' => 'nrw_other_city',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Other City', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'type' => 'select',
							'name' => 'nrw_other_state',
							'id' => 'nrw_other_state',
							'options' => MetaBuild::list_of_states(),
							'meta_id' => $this->stored_meta_data,
							'label' => __('Other State', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_other_postal_code',
							'id' => 'nrw_other_postal_code',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Other Postal Code', NRW_TEXT_DOMAIN)
						)
					),
					MetaBuild::create_field_array(
						array(
							'name' => 'nrw_other_country',
							'id' => 'nrw_other_country',
							'meta_id' => $this->stored_meta_data,
							'label' => __('Other Country', NRW_TEXT_DOMAIN)
						)
					)
				)
			)
		);
	}

	public function nrw_add_contact_address_meta_boxes() {
		add_meta_box( 'nrw_contact_address_meta_box', __('Contact Address', NRW_TEXT_DOMAIN), array($this, 'nrw_contact_address_build_meta_box'), 'nrw_contacts', 'normal', 'high');
	}
	public function nrw_add_contact_meta_boxes() {
		add_meta_box( 'nrw_contact_info_meta_box', __('Contact Information', NRW_TEXT_DOMAIN), array($this, 'nrw_contact_info_build_meta_box'), 'nrw_contacts', 'normal', 'high');
	}


	public function nrw_contact_address_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), NRW_PAGE_NONCE );

		$this->stored_meta_data = get_post_meta( $post->ID );

		MetaBuild::nrw_do_meta_fields($this->nrw_contact_meta_address, $this->stored_meta_data);
	}

	public function nrw_contact_info_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), NRW_PAGE_NONCE );

		$this->stored_meta_data = get_post_meta( $post->ID );

		MetaBuild::nrw_do_meta_fields($this->nrw_contact_meta_info, $this->stored_meta_data);
	}

	public function nrw_save_contacts_meta_data( $post_id ) {
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[NRW_PAGE_NONCE] ) && wp_verify_nonce( $_POST[NRW_PAGE_NONCE], basename(__FILE__) ) ) ? 'true' : 'false';

		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		foreach ($this->nrw_contact_meta_info as $field_group) {
			foreach($field_group['fields'] as $field) {
				if (isset($_POST[$field['id']])) {
					if($field['type'] == 'checkbox') {
						update_post_meta( $post_id, $field['id'], $_POST[$field['id']] );
					} else {
						update_post_meta( $post_id, $field['id'], sanitize_text_field($_POST[$field['id']] ) );
					}

				}
			}
		}

		foreach ($this->nrw_contact_meta_address as $field_group) {
			foreach($field_group['fields'] as $field) {
				if (isset($_POST[$field['id']])) {
					update_post_meta( $post_id, $field['id'], sanitize_text_field($_POST[$field['id']] ) );
				}
			}
		}
	}
}
$nrw_contacts_meta = new NrwContactsMeta();