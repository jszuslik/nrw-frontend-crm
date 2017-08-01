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
			$content .= '<tr class="row" id="nrw_modal_btn_' . $data_set['id'] . '" data-toggle="modal" data-target="#nrw_modal_' . $data_set['id'] .'">';
			foreach($data_set as $key => $value) {
				if($key === 'email') {
					$cell_data = sprintf('<td class="cell"><a href="mailto:%s">%s</a></td>', $value, $value);
					$content .= $cell_data;
				} elseif ($key != 'id' && $key != 'post_meta') {
					$cell_data = sprintf('<td class="cell" id="nrw_modal_%s_%s">%s</td>',
					                     $key, $data_set['id'], $value);
					$content .= $cell_data;
				}
			}
			$content .= '</tr>';
		}
		$content .= '</tbody>';
		$content .= '</table>';
		$content .= '</div>';
		foreach ($data_sets as $data_set) {
			if($type === 'contacts') {
				$content .= self::insert_contact_modal($data_set['id'], $data_set['post_meta']);
			}
		}

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

	public static function insert_contact_modal($id, $post_meta) {
		$first_name = '';

		if(isset($post_meta['nrw_first_name'][0])) {
			$first_name = $post_meta['nrw_first_name'][0];
		}

		$content = '<div id="nrw_modal_' . $id . '" class="modal fade" role="dialog">';
		$content .= '<div class="modal-dialog modal-lg" role="document">';
		$content .= '<div class="modal-content modal-primary">';
		$content .= '<div class="modal-header">';
		$content .= '<span class="close" data-dismiss="modal">&times;</span>';
		$content .= '<h4 class="modal-title">' . $first_name . '</h4>';
		$content .= '</div>';
		$content .= '<div class="modal-body">';
		$content .= '<form>';
		$content .= '<div class="row">';
		$content .= '<div class="list-group col-md-12">';
		$form_values = self::create_form_value_array($post_meta);
		usort($form_values, function($a, $b) {
			return $a['order'] - $b['order'];
		});
		foreach($form_values as $value) {
			$content .= '<div class="list-group-item col-md-6">';
			$content .= '<label for="input1">' . $value['label'] . '</label>';
			$content .= '<input type="text" class="" id="input1" value="' . $value['value'] . '">';
			$content .= '</div>';
		}
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</form>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		return $content;

	}

	public static function create_form_value_array($post_meta) {
		//p($post_meta);
		$form_values = array();
		foreach($post_meta as $key => $value) {
			switch($key) {
				case 'nrw_first_name':
					$form_values['first_name'] = array(
						'order' => 1,
						'label' => 'First Name',
						'key' => $key,
						'value' => $value[0]
					);
					break;
				case 'nrw_last_name':
					$form_values['last_name'] = array(
						'order' => 2,
						'label' => 'Last Name',
						'key' => $key,
						'value' => $value[0]
					);
					break;
				case 'nrw_account_name':
					$form_values['account_name'] = array(
						'order' => 3,
						'label' => 'Account Name',
						'key' => $key,
						'value' => $value[0]
					);
					break;
				case 'nrw_email_address':
					$form_values['email_address'] = array(
						'order' => 4,
						'label' => 'Email',
						'key' => $key,
						'value' => $value[0]
					);
					break;
				case 'nrw_phone':
					$form_values['phone'] = array(
						'order' => 5,
						'label' => 'Phone',
						'key' => $key,
						'value' => $value[0]
					);
					break;
				case 'nrw_other_phone':
					$form_values['other_phone'] = array(
						'order' => 6,
						'label' => 'Other Phone',
						'key' => $key,
						'value' => $value[0]
					);
					break;
			}
		}
		// p($form_values);
		return $form_values;
	}
}