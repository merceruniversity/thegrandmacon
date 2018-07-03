<?php
/**
 * Dropcap Shortcode
 */

if( !function_exists( 'movedo_ext_vce_dropcap_shortcode' ) ) {

	function movedo_ext_vce_dropcap_shortcode( $atts, $content ) {

		$output = $style = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'dropcap_style' => '1',
					'color' => 'primary-1',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);


		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$dropcap_classes = array( 'grve-element', 'grve-dropcap' );

		if ( !empty( $animation ) ) {
			array_push( $dropcap_classes, 'grve-animated-item' );
			array_push( $dropcap_classes, $animation);
			array_push( $dropcap_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $dropcap_classes, $el_class);
		}
		$dropcap_class_string = implode( ' ', $dropcap_classes );

		if ( !empty( $content ) ) {

			$dropcap_char = mb_substr( $content, 0, 1, 'UTF8' );
			$dropcap_content = mb_substr( $content, 1, mb_strlen( $content ) , 'UTF8' );
			$output .= '<div class="' . esc_attr( $dropcap_class_string ) . '" style="' . $style . '"' . $data .'>';
			if ( '1' == $dropcap_style ) {
			$output .= '  <p><span class="grve-style-' . esc_attr( $dropcap_style ) . ' grve-text-' . esc_attr( $color ) . '">' . $dropcap_char . '</span>' . $dropcap_content . '</p>';
			} else {
			$output .= '  <p><span class="grve-style-' . esc_attr( $dropcap_style ) . ' grve-bg-' . esc_attr( $color ) . '">' . $dropcap_char . '</span>' . $dropcap_content . '</p>';
			}
			$output .= '</div>';

		}


		return $output;
	}
	add_shortcode( 'movedo_dropcap', 'movedo_ext_vce_dropcap_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_dropcap_shortcode_params' ) ) {
	function movedo_ext_vce_dropcap_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Dropcap", "movedo-extension" ),
			"description" => esc_html__( "Two separate styles for your dropcaps", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-dropcap",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Style", "movedo-extension" ),
					"param_name" => "dropcap_style",
					"value" => array(
						esc_html__( "Style 1", "movedo-extension" ) => '1',
						esc_html__( "Style 2", "movedo-extension" ) => '2',
					),
					"description" => esc_html__( "Style of the dropcap.", "movedo-extension" ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Type your dropcap text.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Dropcap Color", "movedo-extension" ),
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
					"description" => esc_html__( "First character background color", "movedo-extension" ),
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
	vc_lean_map( 'movedo_dropcap', 'movedo_ext_vce_dropcap_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_dropcap_shortcode_params( 'movedo_dropcap' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
