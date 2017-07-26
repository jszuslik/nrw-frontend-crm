<?php

class NrwScriptsStyles {

	public function __construct() {
		add_action('admin_enqueue_scripts', array( $this, 'nrw_enqueue_scripts_styles'));
	}

	public function nrw_enqueue_scripts_styles($hook) {
		global $post;
		global $nrw_crm_main_menu;

		if ( is_admin() ){
			if($post) {
				$post_type = $post->post_type;
				$post_type_prefix = substr($post_type, 0, 4);
				if($post_type_prefix === NRW_PLUGIN_PREFIX) {
					$this->load_scripts_styles();
				}
			}

			if ($hook === $nrw_crm_main_menu) {
				$this->load_scripts_styles();
			}
		}
	}

	public function load_scripts_styles() {
		wp_register_style( 'nrw-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
		wp_enqueue_style('nrw-bootstrap');
		wp_register_style('nrw-form-styles', plugins_url() . '/nrw-frontend-crm/styles/forms/forms.css');
		wp_enqueue_style('nrw-form-styles');
		wp_register_script('nrw-form-scripts', plugins_url() . '/nrw-frontend-crm/scripts/forms/forms.js');
		wp_enqueue_script('nrw-form-scripts');

		wp_register_script(
			'nrw-form-masked-scripts', plugins_url() . '/nrw-frontend-crm/scripts/forms/masked-inputs.min.js'
		);
		wp_enqueue_script('nrw-form-masked-scripts');
		wp_register_script(
			'nrw-form-currency-scripts', plugins_url() . '/nrw-frontend-crm/scripts/forms/autoNumeric.min.js'
		);
		wp_enqueue_script('nrw-form-currency-scripts');

		wp_register_script(
			'nrw-jquery-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery')
		);
		wp_enqueue_script('nrw-jquery-bootstrap');
		wp_register_script(
			'nrw-jquery-tablesorter',
			plugins_url() . '/nrw-frontend-crm/scripts/widgets/jquery.tablesorter.min.js', array('jquery')
		);
		wp_enqueue_script('nrw-jquery-tablesorter');
		wp_enqueue_script('jquery-form');
		wp_register_script(
			'nrw-jquery-packery', plugins_url() . '/nrw-frontend-crm/scripts/widgets/packery.pkgd.min.js',
			array('jquery')
		);
		wp_enqueue_script('nrw-jquery-packery');
		wp_register_script(
			'nrw-jquery-draggabilly',
			plugins_url() . '/nrw-frontend-crm/scripts/widgets/draggabilly.pkgd.min.js', array('jquery')
		);
		wp_enqueue_script('nrw-jquery-draggabilly');


		wp_register_style('nrw-widget-styles', plugins_url() . '/nrw-frontend-crm/styles/widgets/widgets.css');
		wp_enqueue_style('nrw-widget-styles');
		wp_register_script(
			'nrw-widget-scripts', plugins_url() . '/nrw-frontend-crm/scripts/widgets/widgets.js',
			array('jquery')
		);
		wp_enqueue_script('nrw-widget-scripts');
		wp_register_style('nrw-modal-styles', plugins_url() . '/nrw-frontend-crm/styles/modals/modals.css');
		wp_enqueue_style('nrw-modal-styles');
		wp_register_script(
			'nrw-modal-scripts', plugins_url() . '/nrw-frontend-crm/scripts/modals/modals.js',
			array('jquery')
		);
		wp_enqueue_script('nrw-modal-scripts');
	}

}
$nrw_script_styles = new NrwScriptsStyles();