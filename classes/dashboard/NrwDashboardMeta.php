<?php

class NrwDashboardMeta {

	public function __construct($columns) {
		$this->nrw_crm_dashboard_setup($columns);
	}

	public function nrw_crm_dashboard_setup($columns) {
		NrwDashboardMeta::add_dashboard_widgets($columns);
	}

	public static function add_dashboard_widgets($data) {
		$widgets = $data['widgets'];
		$meta_box_count = 1;
		?>
        <div class="grid">
			<?php foreach($widgets as $widget) { ?>
				<div id="metabox-<?php echo $meta_box_count; ?>" class="portlet portlet--width<?php echo $widget->width; ?>">
					<button type="button" class="handlediv portlet-toggle">
						<span class="screen-reader-text">Toggle panel: <?php echo $widget->header; ?></span>
						<span class="toggle-indicator"></span>
					</button>
					<h2 class="portlet-header"><span><?php echo $widget->header; ?></span></h2>
					<div class="portlet-content"><?php echo $widget->content; ?></div>
				</div>
			<?php $meta_box_count++; } ?>
        </div>
<?php
	}

}
