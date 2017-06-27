<?php

class NrwScriptsStyles {

	public function __construct() {
		add_action('admin_print_styles', array( $this, 'nrw_enqueue_form_styles'));
	}

	public function nrw_enqueue_form_styles() {
		wp_register_style('nrw-form-styles', plugins_url() . '/nrw-frontend-crm/styles/forms/forms.css');
		wp_enqueue_style('nrw-form-styles');
		wp_register_script('nrw-form-masked-scripts', plugins_url() . '/nrw-frontend-crm/scripts/forms/masked-inputs.min.js');
		wp_enqueue_script('nrw-form-masked-scripts');
		wp_register_script('nrw-form-scripts', plugins_url() . '/nrw-frontend-crm/scripts/forms/forms.js');
		wp_enqueue_script('nrw-form-scripts');
		wp_register_script('nrw-form-currency-scripts', plugins_url() . '/nrw-frontend-crm/scripts/forms/autoNumeric.min.js');
		wp_enqueue_script('nrw-form-currency-scripts');
	}

}
$nrw_script_styles = new NrwScriptsStyles();