<?php
/**
 * Title Shortcode
 */

if( !function_exists( 'movedo_ext_vce_title_shortcode' ) ) {

	function movedo_ext_vce_title_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'gradient_color' => '',
					'gradient_color_1' => 'primary-1',
					'gradient_color_2' => 'primary-2',
					'increase_heading' => '100',
					'line_type' => 'no-line',
					'line_width' => '50',
					'line_height' => '2',
					'line_color' => 'primary-1',
					'align' => 'left',
					'animation' => '',
					'clipping_animation' => 'grve-clipping-up',
					'clipping_animation_colors' => 'dark',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$title_classes = array( 'grve-element' , 'grve-title' );

		array_push( $title_classes, 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			if( 'grve-clipping-animation' == $animation ) {
				array_push( $title_classes, $clipping_animation);
				if( 'grve-colored-clipping-up' == $clipping_animation || 'grve-colored-clipping-down' == $clipping_animation || 'grve-colored-clipping-left' == $clipping_animation || 'grve-colored-clipping-right' == $clipping_animation ) {
					array_push( $title_classes, 'grve-colored-clipping');
					$data .= ' data-clipping-color="' . esc_attr( $clipping_animation_colors ) . '"';
				}
			} else {
				array_push( $title_classes, 'grve-animated-item' );
				array_push( $title_classes, 'grve-duration-' . $animation_duration );
			}
			array_push( $title_classes, $animation);
			$data .= ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty( $heading ) ) {
			array_push( $title_classes, 'grve-' . $heading );
		}

		if ( !empty( $custom_font_family ) ) {
			array_push( $title_classes, 'grve-' . $custom_font_family );
		}

		if ( !empty( $el_class ) ) {
			array_push( $title_classes, $el_class );
		}

		if( '100' != $increase_heading ){
			array_push( $title_classes, 'grve-increase-heading' );
			array_push( $title_classes, 'grve-heading-' . $increase_heading );
		}

		if ( !empty( $gradient_color ) ) {
			$uid = uniqid();
			array_push( $title_classes, 'grve-title-gradient' );
			array_push( $title_classes, 'grve-title-' . $uid );

			$colors = array();
			if ( function_exists( 'movedo_grve_get_color_array' ) ) {
				$colors = movedo_grve_get_color_array();
			}

			$gradient_color_1 = movedo_ext_vce_array_value( $colors, $gradient_color_1, '#000000');
			$gradient_color_2 = movedo_ext_vce_array_value( $colors, $gradient_color_2, '#000000');

			$gradient_css = array();
			$gradient_css[] = 'color: ' . esc_attr( $gradient_color_1 );
			$gradient_css[] = 'background-image: -moz-linear-gradient(-45deg, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
			$gradient_css[] = 'background-image: -webkit-linear-gradient(-45deg, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
			$gradient_css[] = 'background-image: linear-gradient(135deg, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';

			$output .= '<style type="text/css">';
			$output .= '.grve-title-gradient.grve-title-' . $uid . ' > span {';
			$output .= implode( ';', $gradient_css ) . ';';
			$output .= '}';
			$output .= '</style>';
		}

		$title_class_string = implode( ' ', $title_classes );

		$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= '<span>';
		$output .= movedo_ext_vce_auto_br( $content );
		if( 'line' == $line_type ) {
			$line_style = '';
			$line_style .= 'width: '.(preg_match('/(px|em|\%|pt|cm)$/', $line_width) ? $line_width : $line_width.'px').';';
			$line_style .= 'height: '. $line_height. 'px;';
			$output .= '<span class="grve-title-line grve-bg-' . esc_attr( $line_color ) . '" style="' . esc_attr( $line_style ) . '"></span>';
		}
		$output .= '</span>';
		$output .= '</' . tag_escape( $heading_tag ) . '>';

		return $output;
	}
	add_shortcode( 'movedo_title', 'movedo_ext_vce_title_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_title_shortcode_params' ) ) {
	function movedo_ext_vce_title_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Title", "movedo-extension" ),
			"description" => esc_html__( "Add a title in many and diverse ways", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-title",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => esc_html__( "Title Content", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title here.", "movedo-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_heading_increase(),
				movedo_ext_vce_get_custom_font_family(),
				movedo_ext_vce_get_gradient_color(),
				movedo_ext_vce_get_gradient_color_1(),
				movedo_ext_vce_get_gradient_color_2(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line type", "movedo-extension" ),
					"param_name" => "line_type",
					"value" => array(
						esc_html__( "No Line", "movedo-extension" ) => 'no-line',
						esc_html__( "With Line", "movedo-extension" ) => 'line',
					),
					"description" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Line Width", "movedo-extension" ),
					"param_name" => "line_width",
					"value" => "50",
					"description" => esc_html__( "Enter the width for your line (Note: CSS measurement units allowed).", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line Height", "movedo-extension" ),
					"param_name" => "line_height",
					"value" => "2",
					"std" => "2",
					"value" => array( '1', '2', '3', '4' , '5', '6', '7', '8', '9' , '10' ),
					"description" => esc_html__( "Enter the hight for your line in px.", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'line' ) ),
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
					),
					"description" => esc_html__( "Color for the line.", "movedo-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'line' ) ),
				),
				movedo_ext_vce_add_align(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "animation",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Fade In", "movedo-extension" ) => "grve-fade-in",
						esc_html__( "Fade In Up", "movedo-extension" ) => "grve-fade-in-up",
						esc_html__( "Fade In Up Big", "movedo-extension" ) => "grve-fade-in-up-big",
						esc_html__( "Fade In Down", "movedo-extension" ) => "grve-fade-in-down",
						esc_html__( "Fade In Down Big", "movedo-extension" ) => "grve-fade-in-down-big",
						esc_html__( "Fade In Left", "movedo-extension" ) => "grve-fade-in-left",
						esc_html__( "Fade In Left Big", "movedo-extension" ) => "grve-fade-in-left-big",
						esc_html__( "Fade In Right", "movedo-extension" ) => "grve-fade-in-right",
						esc_html__( "Fade In Right Big", "movedo-extension" ) => "grve-fade-in-right-big",
						esc_html__( "Zoom In", "movedo-extension" ) => "grve-zoom-in",
						esc_html__( "Clipping Animation", "movedo-extension" ) => "grve-clipping-animation",
					),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "clipping_animation",
					"value" => array(
						esc_html__( "Clipping Up", "movedo-extension" ) => "grve-clipping-up",
						esc_html__( "Clipping Down", "movedo-extension" ) => "grve-clipping-down",
						esc_html__( "Clipping Left", "movedo-extension" ) => "grve-clipping-left",
						esc_html__( "Clipping Right", "movedo-extension" ) => "grve-clipping-right",
						esc_html__( "Colored Clipping Up", "movedo-extension" ) => "grve-colored-clipping-up",
						esc_html__( "Colored Clipping Down", "movedo-extension" ) => "grve-colored-clipping-down",
						esc_html__( "Colored Clipping Left", "movedo-extension" ) => "grve-colored-clipping-left",
						esc_html__( "Colored Clipping Right", "movedo-extension" ) => "grve-colored-clipping-right",
					),
					"dependency" => array( 'element' => "animation", 'value' => array( 'grve-clipping-animation' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Clipping Color", "movedo-extension" ),
					"param_name" => "clipping_animation_colors",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Dark", "movedo-extension" ) => 'dark',
						esc_html__( "Light", "movedo-extension" ) => 'light',
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
						esc_html__( "Grey", "movedo-extension" ) => 'grey',
					),
					"description" => esc_html__( "Select clipping color", "movedo-extension" ),
					"dependency" => array( 'element' => "clipping_animation", 'value' => array( 'grve-colored-clipping-up', 'grve-colored-clipping-down', 'grve-colored-clipping-left', 'grve-colored-clipping-right' ) ),
				),
				movedo_ext_vce_add_animation_delay(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation Duration", "movedo-extension"),
					"param_name" => "animation_duration",
					"value" => array(
						esc_html__( "Very Fast", "movedo-extension" ) => "very-fast",
						esc_html__( "Fast", "movedo-extension" ) => "fast",
						esc_html__( "Normal", "movedo-extension" ) => "normal",
						esc_html__( "Slow", "movedo-extension" ) => "slow",
						esc_html__( "Very Slow", "movedo-extension" ) => "very-slow",
					),
					"std" => 'normal',
					"description" => esc_html__("Select the duration for your animated element.", 'movedo-extension' ),
					"dependency" => array( 'element' => "animation", 'value_not_equal_to' => array( 'grve-clipping-animation' ) ),
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_title', 'movedo_ext_vce_title_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_title_shortcode_params( 'movedo_title' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
