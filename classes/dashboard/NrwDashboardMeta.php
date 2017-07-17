<?php

class NrwDashboardMeta {

	public function __construct($data) {
		$this->nrw_crm_dashboard_setup($data);
	}

	public function nrw_crm_dashboard_setup($data) {
		NrwDashboardMeta::add_dashboard_widgets($data);
	}

	public static function add_dashboard_widgets($data) {
		$widgets = $data['widgets'];
		$meta_box_count = 1;
		function cmp($a, $b)
		{
			return strcmp($a->position, $b->position);
		}
		usort($widgets, "cmp");

		?>
        <div class="grid">
			<?php foreach($widgets as $widget) { ?>
                <?php if($widget->left == '0px' && $widget->top == '0px') : ?>
				<div id="metabox-<?php echo $widget->position; ?>" class="portlet portlet--width<?php echo
                $widget->width; ?>">
                <?php else : ?>
                <div id="metabox-<?php echo $widget->position; ?>" class="portlet portlet--width<?php echo
		        $widget->width; ?>" style="position: absolute; left: <?php echo $widget->left; ?>; top: <?php echo
                $widget->top; ?>">
                <?php endif; ?>
                    <input type="hidden" id="nrw_dashboard_options[<?php echo strtolower($widget->header);
                    ?>_position]" name="nrw_dashboard_options[<?php echo
                    strtolower($widget->header); ?>_position]" value="<?php echo $widget->position; ?>">
                    <input type="hidden" id="nrw_dashboard_options[<?php echo strtolower($widget->header);
					?>_left]" name="nrw_dashboard_options[<?php echo
					strtolower($widget->header); ?>_left]" value="<?php echo $widget->left; ?>">
                    <input type="hidden" id="nrw_dashboard_options[<?php echo strtolower($widget->header);
					?>_top]" name="nrw_dashboard_options[<?php echo
					strtolower($widget->header); ?>_top]" value="<?php echo $widget->top; ?>">
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
