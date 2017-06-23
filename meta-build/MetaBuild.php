<?php

class MetaBuild {

	public static function nrw_do_meta_fields($field_array, $meta) {

		$fields = '';

		$half_field = 0;

		foreach($field_array as $field_group) {

			$fields = '<h2 style="font-weight: bold">' . $field_group['name'] . '</h2>';

			$field_count = count($field_group['fields']);
			if($field_group['split_columns']) {
				$half_field = intdiv($field_count, 2);
				$fields .= '<div class="hlf_column">';
				p($half_field);
			} else {
				$fields .= '<div>';
			}

			$count = 0;
			foreach($field_group['fields'] as $field) {
				if($field_group['split_columns'] && $count == $half_field) {
					$fields .= '</div><div class="hlf_column">';
				}
				$value = null;
				$type = $field['type'];
				$name = $field['name'];
				$id = $field['id'];
				$label = $field['label'];
				$btn_id = null;
				if(isset($field['btn_id']))
					$btn_id = $field['btn_id'];

				if(isset($meta[$id]))
					$value = $meta[$id];

//				p($value);

				$description = $field['description'];

				switch($type) {
					case 'text':
						$fields .= '<div>';
						$fields .= '<label>' . $label . '</label>';
						$fields .= '&nbsp;&nbsp;&nbsp;<input type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . $value[0] . '" />';
						$fields .= '</div>';
						break;
					case 'textarea':

						break;
					case 'image':

						break;
				}
				$count++;
			}
			$fields .= '</div>';

			echo $fields;
		}

	}

	public static function create_field_array( $array ) {

		$type = 'text';
		$name = 'Please Enter a Name';
		$id = null;
		$meta = null;
		$label = __('Please Enter a Label', NRW_TEXT_DOMAIN);
		$description = '';

		if(isset($array['type'])) {
			$type = $array['type'];
		}

		if(isset($array['name'])) {
			$name = $array['name'];
		}

		if(isset($array['id'])) {
			$id = $array['id'];
		}

		if(isset($array['meta_id'])) {
			$meta = $array['meta_id'];
		}

		if(isset($array['label'])) {
			$label = $array['label'];
		}

		if(isset($array['description'])) {
			$description = $array['description'];
		}

		$meta_array = array(
				'type' => $type,
				'name' => $name,
				'id' => $id,
				'meta_id' => $meta,
				'label' => $label,
				'description' => $description
		);

		return $meta_array;
	}

}