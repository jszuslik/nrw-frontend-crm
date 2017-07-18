<?php

class NrwHelpers {

	public static function create_dashboard_widget_table( $array ) {

		$type = $array['type'];
		$headers = $array['headers'];
		$data_sets = $array['data_sets'];

		$content = '<input type="search" class="light-table-filter" data-table="' . $type . '_sorter" 
		placeholder="Filter">';
		$content .= '<div class="table-wrapper">';
		$content .= '<table id="' . $type . 'Table" class="tablesorter ' . $type . '_sorter">';
		$content .= '<thead>';
		$content .= '<tr class="row">';
		foreach ($headers as $header) {
			$content .= '<th class="cell">' . $header . '</th>';
		}
		$content .= '</tr>';
		$content .= '</thead>';
		$content .= '<tbody>';
		foreach ($data_sets as $data_set) {
			$content .= '<tr class="row">';
			foreach($data_set as $key => $value) {
				if($key === 'id') {
					$id = $value;
				} else {
					if(isset($id)) {
						$post_link = get_edit_post_link( $id );
						$cell_data = sprintf(
							'<td class="cell"><a href="%s">%s</a></td>',
							get_edit_post_link( $id ), $value);
						$content .= $cell_data;
					}
				}
			}


			$content .= '</tr>';
		}
		$content .= '</tbody>';
		$content .= '</table>';
		$content .= '</div>';

		return $content;

	}

	public static function create_standard_wp_post_list($list_object) {


		$content = '<div id="poststuff">';
		$content .= '<div id="post-body" class="metabox-holder columns-2">';
		$content .= '<div id="post-body-content">';
		$content .= '<div class="meta-box-sortables ui-sortable">';
		$content .= '<form method="post">';
		$content .= $list_object->prepare_items();
		$content .= $list_object->display();
		$content .= '</form></div></div></div><br class="clear"></div>';

		return $content;
	}

}