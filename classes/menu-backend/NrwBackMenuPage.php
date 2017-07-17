<?php

class NrwBackMenuPage {

	private $options;

	public function __construct() {
		add_action('admin_menu', array($this, 'nrw_add_back_menu_page'));
		add_action('admin_init', array($this, 'register_dashboard_options'));
		add_action('admin_init', array($this, 'register_account_options'));
		add_action('admin_init', array($this, 'register_contact_options'));
		add_action('admin_menu', array($this, 'add_main_links_into_menu'));

	}

	public function nrw_add_back_menu_page() {
	    global $nrw_crm_main_menu;
		$nrw_crm_main_menu = add_menu_page(
			'NRW CRM',
			'NRW CRM',
			'manage_options',
			NRW_BACKEND_MENU_SLUG,
			array( $this, 'nrw_add_menu_options')
		);

	}

	public function add_main_links_into_menu() {
		global $submenu;
		$dashboard_link = 'admin.php?page=nrw_backend_main_menu&tab=dashboard';
		$contacts_link = 'admin.php?page=nrw_backend_main_menu&tab=contacts';
		$accounts_link = 'admin.php?page=nrw_backend_main_menu&tab=accounts';
		$submenu[NRW_BACKEND_MENU_SLUG][] = array( 'Dashboard', 'manage_options', $dashboard_link );
		$submenu[NRW_BACKEND_MENU_SLUG][] = array( 'Accounts', 'manage_options', $accounts_link );
		$submenu[NRW_BACKEND_MENU_SLUG][] = array( 'Contacts', 'manage_options', $contacts_link );
	}

	public function nrw_add_menu_options() {
	    global $nrw_dashboard_tabs;

	    $this->options = get_option('nrw_dashboard_options');

	    $nrw_dashboard_tabs['1'] = array('dashboard' => 'Dashboard');
		$nrw_dashboard_tabs['2'] = array('accounts' => 'Accounts');
		$nrw_dashboard_tabs['3'] = array('contacts' => 'Contacts');

		// p($this->options);

	    ?>

		<div class="wrap">
			<h2>Welcome to NRW CRM App</h2>
			<?php settings_errors(); ?>

			<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard'; ?>

			<h2 class="nav-tab-wrapper">
                <?php

                ksort($nrw_dashboard_tabs);
                foreach($nrw_dashboard_tabs as $dashboard_tab) :
	                foreach($dashboard_tab as $key => $value) :?>
				    <a href="?page=nrw_backend_main_menu&tab=<?php echo $key; ?>" class="nav-tab <?php echo $active_tab == $key ? 'nav-tab-active' : ''; ?>"><?php echo $value; ?></a>
				<?php endforeach; endforeach; ?>
			</h2>

			<form method="post" action="options.php" id="nrw-dashboard-options">

                <?php

                ?>

				<?php settings_fields('nrw_' . $active_tab . '_group'); ?>
				<?php do_settings_sections('nrw_' . $active_tab . '_group'); ?>
                <?php // submit_button(); ?>

			</form>
		</div>

		<?php
	}

	public function register_dashboard_options() {
		register_setting(
			'nrw_dashboard_group',
			'nrw_dashboard_options',
			array( $this, 'sanitize')
		);
		add_settings_section(
			'logged_in_user',
			'User Info',
			array($this, 'print_dashboard_widgets'),
			'nrw_dashboard_group'
		);
		add_settings_field(
            'accounts_position',
            '',
            array($this, 'hidden_accounts_position'),
            'nrw_dashboard_group',
            'logged_in_user'
        );
		add_settings_field(
			'accounts_left',
			'',
			array($this, 'hidden_accounts_left'),
			'nrw_dashboard_group',
			'logged_in_user'
		);
		add_settings_field(
			'accounts_top',
			'',
			array($this, 'hidden_accounts_top'),
			'nrw_dashboard_group',
			'logged_in_user'
		);
		add_settings_field(
			'contacts_position',
			'',
			array($this, 'hidden_contacts_position'),
			'nrw_dashboard_group',
			'logged_in_user'
		);
		add_settings_field(
			'contacts_left',
			'',
			array($this, 'hidden_contacts_left'),
			'nrw_dashboard_group',
			'logged_in_user'
		);
	}

	public function hidden_accounts_position() {
	    printf(
	            '<input type="hidden" id="accounts_position" name="accounts_position" value="%s" />',
                isset($this->options['accounts_position']) ? esc_attr($this->options['accounts_position']) : ''
        );
    }
	public function hidden_accounts_left() {
		printf(
			'<input type="hidden" id="accounts_left" name="accounts_left" value="%s" />',
			isset($this->options['accounts_left']) ? esc_attr($this->options['accounts_left']) : ''
		);
	}
	public function hidden_accounts_top() {
		printf(
			'<input type="hidden" id="accounts_top" name="accounts_top" value="%s" />',
			isset($this->options['accounts_top']) ? esc_attr($this->options['accounts_top']) : ''
		);
	}

	public function hidden_contacts_position() {
		printf(
			'<input type="hidden" id="contacts_position" name="contacts_position" value="%s" />',
			isset($this->options['contacts_position']) ? esc_attr($this->options['contacts_position']) : ''
		);
	}
	public function hidden_contacts_left() {
		printf(
			'<input type="hidden" id="contacts_left" name="contacts_left" value="%s" />',
			isset($this->options['contacts_left']) ? esc_attr($this->options['contacts_left']) : ''
		);
	}

	public function register_account_options() {
		register_setting(
			'nrw_accounts_group',
			'nrw_account_options',
			array( $this, 'sanitize')
		);
		add_settings_section(
			'list_accounts',
			'Accounts',
			array($this, 'print_accounts_list'),
			'nrw_accounts_group'
		);
	}

	public function register_contact_options() {
		register_setting(
			'nrw_contacts_group',
			'nrw_contact_options',
			array( $this, 'sanitize')
		);
		add_settings_section(
			'list_contacts',
			'Contacts',
			array($this, 'print_contacts_list'),
			'nrw_contacts_group'
		);
	}

	public function sanitize($input) {
		return $input;
	}

	public function print_dashboard_widgets() {
		global $nrw_dashboard_widgets;
		$this->add_accounts_dashboard_widget();
		$this->add_contacts_dashboard_widget();

		$nrw_dashboard = array(
            'widgets' => $nrw_dashboard_widgets
        );

		$dsh_brd_meta_box = new NrwDashboardMeta($nrw_dashboard);
	}

	public function add_accounts_dashboard_widget() {
		global $nrw_dashboard_widgets;

        $args = array(
            'post_status' => 'private',
            'post_type' => 'nrw_accounts',
	        'posts_per_page' => -1
        );
        $accounts = get_posts($args);

        $data_sets = array();
		foreach ($accounts as $account) {
		    $company = $account->post_title;
		    $phone = get_post_meta($account->ID, 'nrw_phone', true);
		    $website = get_post_meta($account->ID, 'nrw_account_website', true);

		    $data_sets[] = array( $company, $phone, $website );
		}

		$options = get_option('nrw_dashboard_options');
		$position = $options['accounts_position'];
		$left = $options['accounts_left'];
		$top = $options['accounts_top'];

		if(!$position) {
		    $options['accounts_position'] = '1';
			$position = $options['accounts_position'];
		    update_option('nrw_dashboard_options', $options);
        }

		if(!$left) {
			$options['accounts_left'] = '0px';
			$left = $options['accounts_left'];
			update_option('nrw_dashboard_options', $options);
		}

		if(!$top) {
			$options['accounts_top'] = '0px';
			$top = $options['accounts_top'];
			update_option('nrw_dashboard_options', $options);
		}

		$array = array(
			'type' => 'accounts',
			'headers' => array( 'Company', 'Phone', 'Website' ),
			'data_sets' => $data_sets
		);

		$content = NrwHelpers::create_dashboard_widget_table($array);

		$nrw_dashboard_widgets[] = new NrwDashboardMetaBox(40, __('Accounts', NRW_TEXT_DOMAIN),
                                                           $content, $position, $left, $top);
    }

	public function add_contacts_dashboard_widget() {
		global $nrw_dashboard_widgets;

		$args = array(
			'post_status' => 'private',
			'post_type' => 'nrw_contacts',
            'posts_per_page' => -1
		);
		$contacts = get_posts($args);

		$data_sets = array();
		foreach ($contacts as $contact) {
			$first_name = get_post_meta($contact->ID, 'nrw_first_name', true);
			$last_name = get_post_meta($contact->ID, 'nrw_last_name', true);
			$phone = get_post_meta($contact->ID, 'nrw_phone', true);
			$email = get_post_meta($contact->ID, 'nrw_email_address', true);

			$account_id = get_post_meta($contact->ID, 'nrw_account_name', true);
			$account = get_the_title($account_id);

			$data_sets[] = array( $first_name, $last_name, $phone, $email, $account );
		}

		$options = get_option('nrw_dashboard_options');
		$position = $options['contacts_position'];
		$left = $options['contacts_left'];
		$top = $options['contacts_top'];

		if(!$position) {
			$options['contacts_position'] = '2';
			$position = $options['contacts_position'];
			update_option('nrw_dashboard_options', $options);
		}

		if(!$left) {
			$options['contacts_left'] = '0px';
			$left = $options['contacts_left'];
			update_option('nrw_dashboard_options', $options);
		}

		if(!$top) {
			$options['contacts_top'] = '0px';
			$top = $options['contacts_top'];
			update_option('nrw_dashboard_options', $options);
		}

		$array = array(
			'type' => 'contacts',
			'headers' => array( 'First Name', 'Last Name', 'Phone', 'Email', 'Company' ),
			'data_sets' => $data_sets
		);

		$content = NrwHelpers::create_dashboard_widget_table($array);

		$nrw_dashboard_widgets[] = new NrwDashboardMetaBox(50, __('Contacts',
                                                                  NRW_TEXT_DOMAIN), $content, $position, $left, $top);
	}

	public function print_accounts_list() {

		$screen = WP_Screen::get('edit-nrw_accounts');
		$args = array(
			'plural' => 'nrw_accounts',
			'post_type' => 'nrw_accounts',
			'screen' => $screen
		);
		$accounts = new NrwAccountsList($args);

		NrwHelpers::create_standard_wp_post_list($accounts);
	}

	public function print_contacts_list() {
		$screen = WP_Screen::get('edit-nrw_contacts');
		$args = array(
			'plural' => 'nrw_contacts',
			'post_type' => 'nrw_contacts',
			'screen' => $screen
		);
		$contacts = new NrwContactsList($args);

		NrwHelpers::create_standard_wp_post_list($contacts);
	}

}
$nrw_backend_menu = new NrwBackMenuPage();