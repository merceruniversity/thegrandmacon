<?php
/**
 * Progress Bar Shortcode
 */

if( !function_exists( 'movedo_ext_vce_progress_bar_shortcode' ) ) {

	function movedo_ext_vce_progress_bar_shortcode( $atts, $content ) {

		$output = $style = $bar_height_style = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'bar_style' => 'style-1',
					'values' => '',
					'bar_line_style' => 'square',
					'bar_height' => '6',
					'color' => 'primary-1',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$bars_classes = array( 'grve-element', 'grve-progress-bars' );
		array_push( $bars_classes, 'grve-' . $bar_style );
		array_push( $bars_classes, 'grve-line-' . $bar_line_style );

		$bars_class_string = implode( ' ', $bars_classes );

		if( !empty( $bar_height ) && 'style-2' == $bar_style ) {
			$bar_height_style .= 'height: '.(preg_match('/(px|em|\%|pt|cm)$/', $bar_height) ? $bar_height : $bar_height.'px').';';
		}

		$style .= movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$graph_lines = explode(",", $values);

		$graph_lines_data = array();
		foreach ($graph_lines as $line) {
			$new_line = array();
			$data = explode("|", $line);
			$new_line['value'] = isset( $data[0] ) && !empty( $data[0] ) ? $data[0] : 0;
			$new_line['percentage_value'] = isset( $data[1] ) && !empty( $data[1] ) ? $data[1] : '';
			$new_line['color'] = isset( $data[2] ) && !empty( $data[2] ) ? $data[2] : $color;

			if( (float)$new_line['value'] < 0 ) {
				$new_line['value'] = 0;
			} else if ( (float)$new_line['value'] > 100 ) {
				$new_line['value'] = 100;
			}

			$new_line['label'] = $new_line['percentage_value'];

			$graph_lines_data[] = $new_line;
		}

		$output .= '<div class="' . esc_attr( $bars_class_string ) . '" style="' . $style . '">';

		foreach($graph_lines_data as $line) {

			$color_class = 'grve-primary';
			if ( 'primary' != $line['color'] ) {
				$color_class = 'grve-bg-' . $line['color'];
			}

			$output .= '<div class="grve-element grve-progress-bar grve-margin-10" data-value="' .  esc_attr( $line['value'] ) . '">';
			$output .= '  <div class="grve-small-text grve-bar-title">' .  $line['label'] . '</div>';
			$output .= '  <div class="grve-bar">';
			$output .= '    <div class="grve-bar-line ' .  esc_attr( $color_class ) . '" style="' . $bar_height_style . '"></div>';
			$output .= '  </div>';
			$output .= '</div>';

		}

		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_progress_bar', 'movedo_ext_vce_progress_bar_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_progress_bar_shortcode_params' ) ) {
	function movedo_ext_vce_progress_bar_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Progress Bar", "movedo-extension" ),
			"description" => esc_html__( "Create horizontal progress bar", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-progress-bar",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Progress Bar Style", "movedo-extension" ),
					"param_name" => "bar_style",
					"value" => array(
						esc_html__( "Style 1", "movedo-extension" ) => 'style-1',
						esc_html__( "Style 2", "movedo-extension" ) => 'style-2',
					),
					"description" => esc_html__( "Style of the bar line.", "movedo-extension" ),
				),
				array(
					"type" => "exploded_textarea",
					"heading" => __("Bar values", "movedo-extension"),
					"param_name" => "values",
					"description" => esc_html__( "Input bar values here. Divide values with linebreaks (Enter). Example: 90|Development|black.", "movedo-extension" ) . '<br/>' .
									esc_html__( "Available colors: primary-1, green, orange, red, blue, aqua, purple, black, white.", "movedo-extension" ),
					"value" => "90|Development,80|Design,70|Marketing",
					"save_always" => true,
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Bars Color", "movedo-extension" ),
					"param_name" => "color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Primary 1", "movedo-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "movedo-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "movedo-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "movedo-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "movedo-extension" ) => 'primary-5',
						esc_html__( "Primary 6", "movedo-extension" ) => 'primary-6',
						esc_html__( "Green", "movedo-extension" ) => 'green',
						esc_html__( "Orange", "movedo-extension" ) => 'orange',
						esc_html__( "Red", "movedo-extension" ) => 'red',
						esc_html__( "Blue", "movedo-extension" ) => 'blue',
						esc_html__( "Aqua", "movedo-extension" ) => 'aqua',
						esc_html__( "Purple", "movedo-extension" ) => 'purple',
						esc_html__( "Black", "movedo-extension" ) => 'black',
						esc_html__( "Grey", "movedo-extension" ) => 'grey',
					),
					"description" => esc_html__( "Use single color for all bars ( If not specified in Bar values )", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Progress Bar Height", "movedo-extension" ),
					"param_name" => "bar_height",
					"value" => "6",
					"description" => esc_html__( "Enter progress bar height.", "movedo-extension" ),
					"dependency" => array( 'element' => "bar_style", 'value' => array( 'style-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Bars Line Style", "movedo-extension" ),
					"param_name" => "bar_line_style",
					"value" => array(
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'round',
					),
					"description" => esc_html__( "Style of the bar line.", "movedo-extension" ),
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_progress_bar', 'movedo_ext_vce_progress_bar_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_progress_bar_shortcode_params( 'movedo_progress_bar' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
