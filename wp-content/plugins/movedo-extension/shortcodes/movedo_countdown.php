<?php
/**
 * Typed Text Shortcode
 */

if( !function_exists( 'movedo_ext_vce_countdown_shortcode' ) ) {

	function movedo_ext_vce_countdown_shortcode( $atts, $content ) {

		$output = $el_class = $data = '';

		extract(
			shortcode_atts(
				array(
					'final_date' => '',
					'countdown_format' => 'D|H|M|S',
					'countdown_style' => '1',
					'numbers_size' => 'h3',
					'text_size' => 'small-text',
					'numbers_color' => 'black',
					'text_color' => 'black',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$countdown_classes = array( 'grve-element' , 'grve-countdown' );

		array_push( $countdown_classes, 'grve-style-' . $countdown_style );

		if ( !empty( $animation ) ) {
			array_push( $countdown_classes, 'grve-animated-item' );
			array_push( $countdown_classes, $animation);
			array_push( $countdown_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $countdown_classes, $el_class);
		}

		$countdown_class_string = implode( ' ', $countdown_classes );


		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );


		$output .= '<div class="' . esc_attr( $countdown_class_string ) . '" style="' . $style . '" data-countdown="' . esc_attr( $final_date ) . '" data-countdown-format="' . esc_attr( $countdown_format ) . '" data-numbers-size="' . esc_attr( $numbers_size ) . '" data-text-size="' . esc_attr( $text_size ) . '" data-numbers-color="' . esc_attr( $numbers_color ) . '" data-text-color="' . esc_attr( $text_color ) . '"' . $data . '></div>';


		return $output;
	}
	add_shortcode( 'movedo_countdown', 'movedo_ext_vce_countdown_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_countdown_shortcode_params' ) ) {
	function movedo_ext_vce_countdown_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Countdown", "movedo-extension" ),
			"description" => esc_html__( "Add a countdown element", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-countdown",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Final Date", "movedo-extension" ),
					"param_name" => "final_date",
					"value" => "",
					"description" => esc_html__( "Accepted formats: YYYY/MM/DD , MM/DD/YYYY , YYYY/MM/DD hh:mm:ss , MM/DD/YYYY hh:mm:ss ( e.g: 2016/05/12 )", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Countdown Display", "movedo-extension" ),
					"param_name" => "countdown_format",
					"value" => array(
						esc_html__( "Days Hours Minutes Seconds", "movedo-extension" ) => 'D|H|M|S',
						esc_html__( "Weeks Days Hours Minutes Seconds", "movedo-extension" ) => 'w|d|H|M|S',
					),
					'std' => 'D|H|M|S',
					"description" => esc_html__( "Select the countdown display.", "movedo-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Countdown Style", "movedo-extension" ),
					"param_name" => "countdown_style",
					"value" => array(
						esc_html__( "Style 1", "movedo-extension" ) => '1',
						esc_html__( "Style 2", "movedo-extension" ) => '2',
						esc_html__( "Style 3", "movedo-extension" ) => '3',
					),
					'std' => '1',
					"description" => esc_html__( "Select the countdown style.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Numbers size", "movedo-extension" ),
					"param_name" => "numbers_size",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "Leader Text", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "movedo-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "movedo-extension" ) => 'small-text',
						esc_html__( "Link Text", "movedo-extension" ) => 'link-text',
					),
					"description" => esc_html__( "Numbers size and typography", "movedo-extension" ),
					"std" => 'h3',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text size", "movedo-extension" ),
					"param_name" => "text_size",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "Leader Text", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "movedo-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "movedo-extension" ) => 'small-text',
						esc_html__( "Link Text", "movedo-extension" ) => 'link-text',
					),
					"description" => esc_html__( "Text size and typography", "movedo-extension" ),
					"std" => 'small-text',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Numbers Color", "movedo-extension" ),
					"param_name" => "numbers_color",
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
					'std' => 'black',
					"description" => esc_html__( "Color of the numbers.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text Color", "movedo-extension" ),
					"param_name" => "text_color",
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
					'std' => 'black',
					"description" => esc_html__( "Color of the text.", "movedo-extension" ),
				),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_countdown', 'movedo_ext_vce_countdown_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_countdown_shortcode_params( 'movedo_countdown' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
