<?php
/**
 * Typed Text Shortcode
 */

if( !function_exists( 'movedo_ext_vce_typed_text_shortcode' ) ) {

	function movedo_ext_vce_typed_text_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'typed_prefix' => '',
					'typed_suffix' => '',
					'typed_values' => '',
					'textspeed' => '100',
					'backspeed' => '80',
					'startdelay' => '0',
					'backdelay' => '500',
					'loop' => '',
					'show_cursor' => 'yes',
					'cursor_text' => '|',
					'text_color' => 'primary-1',
					'text_bg_color' => 'none',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'increase_heading' => '100',
					'custom_font_family' => '',
					'align' => 'left',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$typed_classes = array( 'grve-element' );

		array_push( $typed_classes, 'grve-typed-text' );
		array_push( $typed_classes, 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $typed_classes, 'grve-animated-item' );
			array_push( $typed_classes, $animation);
			array_push( $typed_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		array_push( $typed_classes, 'grve-' . $heading );

		if ( !empty( $custom_font_family ) ) {
			array_push( $typed_classes, 'grve-' . $custom_font_family );
		}

		if ( !empty ( $el_class ) ) {
			array_push( $typed_classes, $el_class);
		}

		if( '100' != $increase_heading ){
			array_push( $typed_classes, 'grve-increase-heading' );
			array_push( $typed_classes, 'grve-heading-' . $increase_heading );
		}

		$typed_class_string = implode( ' ', $typed_classes );

		$typed_colors = array( 'grve-animated-text' );

		array_push( $typed_colors, 'grve-text-' . $text_color );
		if ( 'none' != $text_bg_color ) {
			array_push( $typed_colors, 'grve-with-bg grve-bg-' . $text_bg_color );
		}

		$typed_colors_string = implode( ' ', $typed_colors );


		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$typed_id = uniqid('grve-typed-item-');

		$typed_string_values = '';

		if( !empty( $typed_values ) ) {


			$typed_values_array = explode(",", $typed_values);
			$typed_values_count= count( $typed_values_array );

			$typed_string_values = '[';

			foreach( $typed_values_array as $key => $value ) {
				$typed_string_values .= '"'. trim( htmlspecialchars_decode( strip_tags( $value ) ) ) . '"';
				if( $key != ( $typed_values_count-1 ) ) {
					$typed_string_values .= ',';
				}
			}

			$typed_string_values .= ']';
		}


		$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $typed_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= '    <span class="grve-typed-text-prefix"> ' . $typed_prefix . '</span>';
		$output .= '    <span class="' . esc_attr( $typed_colors_string ) . '">';
		$output .= '    	<span id="' . $typed_id . '"></span>';
		$output .= '    </span>';
		$output .= '    <span class="grve-typed-text-suffix"> ' . $typed_suffix . '</span>';

		$loop = movedo_ext_vce_text_to_bool( $loop );

		$show_cursor = movedo_ext_vce_text_to_bool( $show_cursor );

		$output .= '<script type="text/javascript">
				jQuery(function($){ $("#' . $typed_id . '").appear(function() {
					$("#' . $typed_id . '").typed({
						strings: ' . $typed_string_values . ',
						typeSpeed: ' . $textspeed . ',
						backSpeed: ' . $backspeed . ',
						startDelay: ' . $startdelay . ',
						backDelay: ' . $backdelay . ',
						loop: ' . $loop . ',
						loopCount: false,
						showCursor: ' . $show_cursor . ',
						cursorChar: "' . $cursor_text . '",
						contentType: null,
						attr: null
					});
				});
			});
		</script>';

		$output .= '</' . tag_escape( $heading_tag ) . '>';

		return $output;
	}
	add_shortcode( 'movedo_typed_text', 'movedo_ext_vce_typed_text_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_typed_text_shortcode_params' ) ) {
	function movedo_ext_vce_typed_text_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Typed text", "movedo-extension" ),
			"description" => esc_html__( "Add a typed text", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-typed-text",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Prefix", "movedo-extension" ),
					"param_name" => "typed_prefix",
					"value" => "",
					"description" => esc_html__( "Enter prefix text.", "movedo-extension" ),
				),
				array(
					"type" => "exploded_textarea",
					"heading" => __("Typed Text", "movedo-extension"),
					"param_name" => "typed_values",
					"description" => esc_html__( "Input Typed Text here. Divide values with linebreaks (Enter).", "movedo-extension" ),
					"value" => "These are the default values...,Use your own values!",
					"save_always" => true,
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Suffix", "movedo-extension" ),
					"param_name" => "typed_suffix",
					"value" => "",
					"description" => esc_html__( "Enter suffix text.", "movedo-extension" ),
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_heading_increase(),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Typed Text Color", "movedo-extension" ),
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
					'std' => 'primary-1',
					"description" => esc_html__( "Color of the typed text.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background Color", "movedo-extension" ),
					"param_name" => "text_bg_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
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
					'std' => 'none',
					"description" => esc_html__( "Background color for the typed text.", "movedo-extension" ),
				),
				movedo_ext_vce_add_align(),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Text Speed", "movedo-extension" ),
					"param_name" => "textspeed",
					"value" => 100,
					"description" => esc_html__( "Enter text speed in ms.", "movedo-extension" ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Backspeed", "movedo-extension" ),
					"param_name" => "backspeed",
					"value" => 80,
					"description" => esc_html__( "Enter speed of delete in ms.", "movedo-extension" ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Start Delay", "movedo-extension" ),
					"param_name" => "startdelay",
					"value" => 0,
					"description" => esc_html__( "Enter start delay in ms.", "movedo-extension" ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Back Delay", "movedo-extension" ),
					"param_name" => "backdelay",
					"value" => 500,
					"description" => esc_html__( "Enter back delay in ms.", "movedo-extension" ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Loop", "movedo-extension" ),
					"param_name" => "loop",
					"value" => array( esc_html__( "Enable loop", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Show Cursor", "movedo-extension" ),
					"param_name" => "show_cursor",
					"value" => array( esc_html__( "Show Cursor", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
					"std" => 'yes',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Cursor Text", "movedo-extension" ),
					"param_name" => "cursor_text",
					"value" => "|",
					"description" => esc_html__( "Enter cursor text.", "movedo-extension" ),
					"group" => esc_html__( "Extra Settings", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_typed_text', 'movedo_ext_vce_typed_text_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_typed_text_shortcode_params( 'movedo_typed_text' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
