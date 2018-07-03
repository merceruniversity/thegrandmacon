<?php
/**
 * Empty Space Shortcode
 */

if( !function_exists( 'movedo_ext_vce_empty_space_shortcode' ) ) {

	function movedo_ext_vce_empty_space_shortcode( $atts, $content ) {

		$output = $style = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'height' => '32px',
					'height_multiplier' => '1x',
					'el_class' => '',
				),
				$atts
			)
		);

		$style = '';

		$empty_space_classes = array( 'grve-empty-space' );
		if ( 'custom' == $height_multiplier ) {
			$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
			$regexr = preg_match( $pattern, $height, $matches );
			$value = isset( $matches[1] ) ? (float) $matches[1] : 30;
			$unit = isset( $matches[2] ) ? $matches[2] : 'px';
			$height = $value . $unit;
			$style = 'height: ' . esc_attr( $height ) . ';';
		} else {
			$empty_space_classes[] = 'grve-height-' . $height_multiplier;
		}

		if ( !empty ( $el_class ) ) {
			$empty_space_classes[] = $el_class;
		}
		$empty_space_class = implode( ' ', $empty_space_classes );

		$output .= '<div class="' . esc_attr( $empty_space_class ).'" style="' . esc_attr( $style ) . '"></div>';

		return $output;
	}
	add_shortcode( 'movedo_empty_space', 'movedo_ext_vce_empty_space_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_empty_space_shortcode_params' ) ) {
	function movedo_ext_vce_empty_space_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Empty Space", "movedo-extension" ),
			"description" => esc_html__( "Blank space with custom height", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-empty-space",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Height", 'movedo-extension' ),
					"param_name" => "height_multiplier",
					"value" => array(
						esc_html__( "1x", 'movedo-extension' ) => '1x',
						esc_html__( "2x", 'movedo-extension' ) => '2x',
						esc_html__( "3x", 'movedo-extension' ) => '3x',
						esc_html__( "4x", 'movedo-extension' ) => '4x',
						esc_html__( "5x", 'movedo-extension' ) => '5x',
						esc_html__( "6x", 'movedo-extension' ) => '6x',
						esc_html__( "Custom", 'movedo-extension' ) => 'custom',
					),
					"std" => '1x',
					"description" => esc_html__( "Select empty space height.", 'movedo-extension' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Height', 'movedo-extension' ),
					'param_name' => 'height',
					'value' => '32px',
					'description' => __( 'Enter empty space height (Note: CSS measurement units allowed).', 'movedo-extension' ),
					"dependency" => array(
						'element' => 'height_multiplier',
						'value' => array( 'custom' )
					),
				),
				movedo_ext_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_empty_space', 'movedo_ext_vce_empty_space_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_empty_space_shortcode_params( 'movedo_empty_space' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.