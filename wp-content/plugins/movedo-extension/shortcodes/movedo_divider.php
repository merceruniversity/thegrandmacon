<?php
/**
 * Divider Shortcode
 */

if( !function_exists( 'movedo_ext_vce_divider_shortcode' ) ) {

	function movedo_ext_vce_divider_shortcode( $atts, $content ) {

		$output = $class_fullwidth = $style = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'line_type' => 'line',
					'line_width' => '50',
					'line_height' => '2',
					'line_color' => 'primary-1',
					'line_color_custom' => '#000000',
					'backtotop_title' => 'Back to top',
					'align' => 'left',
					'padding_top' => '',
					'padding_bottom' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'el_class' => '',
				),
				$atts
			)
		);

		$style .= movedo_ext_vce_build_padding_top_style( $padding_top );
		$style .= movedo_ext_vce_build_padding_bottom_style( $padding_bottom );

		$divider_classes = array( 'grve-element', 'grve-divider' );

		if ( !empty ( $el_class ) ) {
			array_push( $divider_classes, $el_class);
		}

		if ( !empty( $animation ) ) {
			array_push( $divider_classes, 'grve-animated-item' );
			array_push( $divider_classes, $animation);
			array_push( $divider_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		$divider_string = implode( ' ', $divider_classes );

		$output .= '<div class="' . esc_attr( $divider_string ) . '" style="' . $style . '"' . $data . '>';
		if( 'custom-line' == $line_type ) {
			$line_style = '';
			$line_style .= 'width: '.(preg_match('/(px|em|\%|pt|cm)$/', $line_width) ? $line_width : $line_width.'px').';';
			$line_style .= 'height: '. $line_height. 'px;';
			if( 'custom' == $line_color ) {
				$line_style .= 'background-color: ' . esc_attr( $line_color_custom ) . ';';
			}
			$output .=   '<span class="grve-custom-divider grve-bg-' . esc_attr( $line_color ) . ' grve-align-' . esc_attr( $align ) . '" style="' . esc_attr( $line_style ) . '"></span>';
		} else {
			$output .= '<div class="grve-' . $line_type . '-divider grve-border">';
			if ( !empty( $backtotop_title ) && 'top-line' == $line_type ) {
				$output .= '    <span class="grve-divider-backtotop grve-border grve-small-text grve-text-hover-primary-1">' . $backtotop_title. '</span>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_divider', 'movedo_ext_vce_divider_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_divider_shortcode_params' ) ) {
	function movedo_ext_vce_divider_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Divider", "movedo-extension" ),
			"description" => esc_html__( "Insert dividers, just spaces or different lines", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-divider",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line type", "movedo-extension" ),
					"param_name" => "line_type",
					"value" => array(
						esc_html__( "Line", "movedo-extension" ) => 'line',
						esc_html__( "Double Line", "movedo-extension" ) => 'double-line',
						esc_html__( "Dashed Line", "movedo-extension" ) => 'dashed-line',
						esc_html__( "Back to Top", "movedo-extension" ) => 'top-line',
						esc_html__( "Custom Line", "movedo-extension" ) => 'custom-line',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Line Width", "movedo-extension" ),
					"param_name" => "line_width",
					"value" => "50",
					"description" => esc_html__( "Enter the width for your line (Note: CSS measurement units allowed).", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line Height", "movedo-extension" ),
					"param_name" => "line_height",
					"value" => array( '1', '2', '3', '4' , '5', '6', '7', '8', '9' , '10' ),
					"std" => "2",
					"description" => esc_html__( "Enter the hight for your line in px.", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line Color", "movedo-extension" ),
					"param_name" => "line_color",
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
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Custom", "movedo-extension" ) => 'custom',
					),
					"description" => esc_html__( "Color for the line.", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( "Custom Line Color", "movedo-extension" ),
					'param_name' => 'line_color_custom',
					'description' => esc_html__( "Select a custom color for your line", "movedo-extension" ),
					'std' => '#000000',
					"dependency" => array( 'element' => "line_color", 'value' => array( 'custom' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Divider Alignment", "movedo-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Back to Top Title", "movedo-extension" ),
					"param_name" => "backtotop_title",
					"value" => "Back to top",
					"description" => esc_html__( "Set Back to top title.", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'top-line' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Top padding", "movedo-extension" ),
					"param_name" => "padding_top",
					"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Bottom padding", "movedo-extension" ),
					"param_name" => "padding_bottom",
					"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", "movedo-extension" ),
				),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_divider', 'movedo_ext_vce_divider_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_divider_shortcode_params( 'movedo_divider' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.