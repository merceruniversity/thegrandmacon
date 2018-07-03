<?php
/**
 * Button Shortcode
 */

if( !function_exists( 'movedo_ext_vce_button_shortcode' ) ) {

	function movedo_ext_vce_button_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'button_text' => 'Button',
					'button_link' => '',
					'button_type' => 'simple',
					'button_size' => 'medium',
					'button_color' => 'primary-1',
					'button_hover_color' => 'black',
					'button_line_color' => 'primary-1',
					'button_gradient_color_1' => 'primary-1',
					'button_gradient_color_2' => 'primary-2',
					'button_shape' => 'square',
					'button_shadow' => '',
					'button_class' => '',
					'btn_add_icon' => '',
					'btn_icon_library' => 'fontawesome',
					'btn_icon_fontawesome' => 'fa fa-adjust',
					'btn_icon_openiconic' => 'vc-oi vc-oi-dial',
					'btn_icon_typicons' => 'typcn typcn-adjust-brightness',
					'btn_icon_entypo' => 'entypo-icon entypo-icon-note',
					'btn_icon_linecons' => 'vc_li vc_li-heart',
					'btn_icon_simplelineicons' => 'smp-icon-user',
					'btn_icon_etlineicons' => 'et-icon-mobile',
					'btn_fluid' => '',
					'btn_fluid_height' => 'medium',
					'btn_custom_width' => '250',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'align' => 'left',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$button_classes = array( 'grve-element', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $button_classes, 'grve-animated-item' );
			array_push( $button_classes, $animation);
			array_push( $button_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $button_classes, $el_class);
		}
		if ( 'custom' == $btn_fluid ) {
			array_push( $button_classes, 'grve-fluid-button' );
		}
		$button_class_string = implode( ' ', $button_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );
		if ( 'custom' == $btn_fluid ) {
			$style .= movedo_ext_vce_build_dimension( 'max-width', $btn_custom_width );
		}

		$button_options = array(
			'button_text'  => $button_text,
			'button_link'  => $button_link,
			'button_type'  => $button_type,
			'button_size'  => $button_size,
			'button_color' => $button_color,
			'button_hover_color' => $button_hover_color,
			'button_line_color' => $button_line_color,
			'button_gradient_color_1' => $button_gradient_color_1,
			'button_gradient_color_2' => $button_gradient_color_2,
			'button_shape' => $button_shape,
			'button_shadow' => $button_shadow,
			'button_class' => $button_class,
			'btn_add_icon' => $btn_add_icon,
			'btn_icon_library' => $btn_icon_library,
			'btn_icon_fontawesome' => $btn_icon_fontawesome,
			'btn_icon_openiconic' => $btn_icon_openiconic,
			'btn_icon_typicons' => $btn_icon_typicons,
			'btn_icon_entypo' => $btn_icon_entypo,
			'btn_icon_linecons' => $btn_icon_linecons,
			'btn_icon_simplelineicons' => $btn_icon_simplelineicons,
			'btn_icon_etlineicons' => $btn_icon_etlineicons,
			'btn_fluid' => $btn_fluid,
			'btn_fluid_height' => $btn_fluid_height,
			'style' => $style,
		);
		$button = movedo_ext_vce_get_button( $button_options );

		$output .= '<div class="' . $button_class_string . '"' . $data . '>';
		$output .= $button;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_button', 'movedo_ext_vce_button_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_button_shortcode_params' ) ) {
	function movedo_ext_vce_button_shortcode_params( $tag ) {

		$movedo_ext_vce_button_shortcode_btn_params = movedo_ext_vce_get_button_params();
		$movedo_ext_vce_button_shortcode_params = array_merge(
			array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Button Dimensions", "movedo-extension" ),
					"param_name" => "btn_fluid",
					'value' => array(
						esc_html__( 'Auto' , 'movedo-extension' ) => '',
						esc_html__( 'Fluid ( Full Width )' , 'movedo-extension' ) => 'yes',
						esc_html__( 'Custom' , 'movedo-extension' ) => 'custom',
					),
					"std" => '',
					"description" => esc_html__( "Select dimensions for your button.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Button Height", "movedo-extension" ),
					"param_name" => "btn_fluid_height",
					'value' => array(
						esc_html__( 'Short' , 'movedo-extension' ) => 'short',
						esc_html__( 'Medium' , 'movedo-extension' ) => 'medium',
						esc_html__( 'Tall' , 'movedo-extension' ) => 'tall',
					),
					"std" => 'medium',
					"description" => esc_html__( "Select height for your fluid button.", "movedo-extension" ),
					"dependency" => array( 'element' => "btn_fluid", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Button Width", "movedo-extension" ),
					"param_name" => "btn_custom_width",
					"value" => "250",
					"description" => esc_html__( "Enter the width for your button (Note: CSS measurement units allowed).", "movedo-extension" ),
					"dependency" => array( 'element' => "btn_fluid", 'value' => array( 'custom' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Alignment", "movedo-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "btn_fluid", 'value_not_equal_to' => array( 'yes' ) ),
				),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
			$movedo_ext_vce_button_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Button", "movedo-extension" ),
			"description" => esc_html__( "Several styles, sizes and colors for your buttons", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-button",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $movedo_ext_vce_button_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_button', 'movedo_ext_vce_button_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_button_shortcode_params( 'movedo_button' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
