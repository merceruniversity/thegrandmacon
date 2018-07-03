<?php
/**
 * Language selector Shortcode
 */

if( !function_exists( 'movedo_ext_vce_language_selector_shortcode' ) ) {

	function movedo_ext_vce_language_selector_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
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


		$language_selector_classes = array( 'grve-element', 'grve-language-element', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $language_selector_classes, 'grve-animated-item' );
			array_push( $language_selector_classes, $animation);
			array_push( $language_selector_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $language_selector_classes, $el_class);
		}
		$language_selector_class_string = implode( ' ', $language_selector_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );
		ob_start();

		?>
			<div class="<?php echo esc_attr( $language_selector_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>
			<?php
				if( function_exists( 'movedo_grve_print_language_modal_selector' ) ) {
					movedo_grve_print_language_modal_selector();
				}
			?>
			</div>
		<?php

		return ob_get_clean();

	}
	add_shortcode( 'movedo_language_selector', 'movedo_ext_vce_language_selector_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_language_selector_shortcode_params' ) ) {
	function movedo_ext_vce_language_selector_shortcode_params( $tag ) {

		return array(
			"name" => esc_html__( "Language Selector", "movedo-extension" ),
			"description" => esc_html__( "Place your language selector", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-languages",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				movedo_ext_vce_add_align(),
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
	vc_lean_map( 'movedo_language_selector', 'movedo_ext_vce_language_selector_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_language_selector_shortcode_params( 'movedo_language_selector' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
