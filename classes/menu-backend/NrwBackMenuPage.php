<?php

class NrwBackMenuPage {

	private $options;

	public function __construct() {
		add_action('admin_menu', array($this, 'nrw_add_back_menu_page'));
		add_action('admin_init', array($this, 'register_dashboard_options'));
		add_action('admin_init', array($this, 'register_account_options'));
		add_action('admin_init', array($this, 'register_contact_options'));
		add_action('admin_menu', array($this, 'add_custom_link_into_appearnace_menu'));

	}

	public function nrw_add_back_menu_page() {
		add_menu_page(
			'NRW CRM',
			'NRW CRM',
			'manage_options',
			NRW_BACKEND_MENU_SLUG,
			array( $this, 'nrw_add_menu_options')
		);

	}

	public function add_custom_link_into_appearnace_menu() {
		global $submenu;
		$dashboard_link = 'admin.php?page=nrw_backend_main_menu&tab=dashboard';
		$contacts_link = 'admin.php?page=nrw_backend_main_menu&tab=contacts';
		$accounts_link = 'admin.php?page=nrw_backend_main_menu&tab=accounts';
		$submenu[NRW_BACKEND_MENU_SLUG][] = array( 'Dashboard', 'manage_options', $dashboard_link );
		$submenu[NRW_BACKEND_MENU_SLUG][] = array( 'Accounts', 'manage_options', $accounts_link );
		$submenu[NRW_BACKEND_MENU_SLUG][] = array( 'Contacts', 'manage_options', $contacts_link );
	}

	public function nrw_add_menu_options() { ?>

		<div class="wrap">
			<h2>Welcome to NRW CRM App</h2>
			<?php settings_errors(); ?>

			<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard'; ?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=nrw_backend_main_menu&tab=dashboard" class="nav-tab <?php echo $active_tab == 'dashboard' ? 'nav-tab-active' : ''; ?>">Dashboard</a>
				<a href="?page=nrw_backend_main_menu&tab=accounts" class="nav-tab <?php echo $active_tab == 'accounts' ? 'nav-tab-active' : ''; ?>">Accounts</a>
				<a href="?page=nrw_backend_main_menu&tab=contacts" class="nav-tab <?php echo $active_tab == 'contacts' ? 'nav-tab-active' : ''; ?>">Contacts</a>
			</h2>

			<form method="post" action="options.php">



				<?php if ($active_tab == 'dashboard') { ?>
					<?php
					//$this->print_dashboard_widgets();
					?>
				<?php settings_fields('nrw_dashboard_group'); ?>
				<?php do_settings_sections('nrw_dashboard_group'); ?>
			<?php } elseif ($active_tab == 'accounts') { ?>
				<?php settings_fields('nrw_account_group'); ?>
				<?php do_settings_sections('nrw_account_group'); ?>
					<?php submit_button(); ?>
			<?php } elseif ($active_tab == 'contacts') { ?>
				<?php settings_fields('nrw_contact_group'); ?>
				<?php do_settings_sections('nrw_contact_group'); ?>
					<?php submit_button(); ?>
			<?php } ?>



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
	}

	public function register_account_options() {
		register_setting(
			'nrw_account_group',
			'nrw_account_options',
			array( $this, 'sanitize')
		);
		add_settings_section(
			'list_accounts',
			'Accounts',
			array($this, 'print_accounts_list'),
			'nrw_account_group'
		);
	}

	public function register_contact_options() {
		register_setting(
			'nrw_contact_group',
			'nrw_contact_options',
			array( $this, 'sanitize')
		);
		add_settings_section(
			'list_contacts',
			'Contacts',
			array($this, 'print_contacts_list'),
			'nrw_contact_group'
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
            'post_type' => 'nrw_accounts'
        );
        $accounts = get_posts($args);

        $content = '<input type="search" class="light-table-filter" data-table="accounts_sorter" placeholder="Filter">';
        $content .= '<table id="accountsTable" class="tablesorter accounts_sorter">';
        $content .= '<thead>';
        $content .= '<tr class="row">';
		$content .= '<th class="cell">Company</th>';
		$content .= '<th class="cell">Phone</th>';
		$content .= '<th class="cell">Website</th>';
		$content .= '</tr>';
		$content .= '</thead>';
		$content .= '<tbody>';
        foreach ($accounts as $account) {
            $content .= '<tr class="row">';
            $content .= '<td class="cell">' . $account->post_title . '</td>';
	        $content .= '<td class="cell">' . get_post_meta($account->ID, 'nrw_phone', true) . '</td>';
	        $content .= '<td class="cell">' . get_post_meta($account->ID, 'nrw_account_website', true) . '</td>';

	        $content .= '</tr>';
        }
		$content .= '</tbody>';
        $content .= '</table>';
        $content .= '<ul id="pagination-demo" class="pagination-sm"></ul>';
		$nrw_dashboard_widgets[] = new NrwDashboardMetaBox(40, __('Accounts', NRW_TEXT_DOMAIN), $content);
    }

	public function add_contacts_dashboard_widget() {
		global $nrw_dashboard_widgets;

		$args = array(
			'post_status' => 'private',
			'post_type' => 'nrw_contacts'
		);
		$contacts = get_posts($args);

		$content = '<input type="search" class="light-table-filter" data-table="contacts_sorter" placeholder="Filter">';
		$content .= '<div class="table-wrapper">';
		$content .= '<table id="contactsTable" class="tablesorter contacts_sorter">';
		$content .= '<thead>';
		$content .= '<tr class="row">';
		$content .= '<th class="cell">First Name</th>';
		$content .= '<th class="cell">Last Name</th>';
		$content .= '<th class="cell">Phone</th>';
		$content .= '<th class="cell">Email</th>';
		$content .= '<th class="cell">Company</th>';
		$content .= '</tr>';
		$content .= '</thead>';
		$content .= '<tbody>';
		foreach ($contacts as $contact) {
			$content .= '<tr class="row">';
			$content .= '<td class="cell">' . get_post_meta($contact->ID, 'nrw_first_name', true) . '</td>';
			$content .= '<td class="cell">' . get_post_meta($contact->ID, 'nrw_last_name', true) . '</td>';
			$content .= '<td class="cell">' . get_post_meta($contact->ID, 'nrw_phone', true) . '</td>';
			$content .= '<td class="cell">' . get_post_meta($contact->ID, 'nrw_email_address', true) . '</td>';
			$account_id = get_post_meta($contact->ID, 'nrw_account_name', true);
			$account_name = get_the_title($account_id);
			$content .= '<td class="cell">' . $account_name . '</td>';

			$content .= '</tr>';
		}
		$content .= '</tbody>';
		$content .= '</table>';
		$content .= '</div>';

		$nrw_dashboard_widgets[] = new NrwDashboardMetaBox(50, __('Contacts', NRW_TEXT_DOMAIN), $content);
	}

	public function print_accounts_list() {

		$screen = WP_Screen::get('edit-nrw_accounts');
		$args = array(
			'plural' => 'nrw_accounts',
			'post_type' => 'nrw_accounts',
			'screen' => $screen
		);
		$accounts = new NrwAccountsList($args);
		?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
							$accounts->prepare_items();
							$accounts->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>

		<?php
	}

	public function print_contacts_list() {
		$screen = WP_Screen::get('edit-nrw_contacts');
		$args = array(
			'plural' => 'nrw_contacts',
			'post_type' => 'nrw_contacts',
			'screen' => $screen
		);
		$contacts = new NrwContactsList($args);
		?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
							$contacts->prepare_items();
							$contacts->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>

		<?php
	}

}
$nrw_backend_menu = new NrwBackMenuPage();