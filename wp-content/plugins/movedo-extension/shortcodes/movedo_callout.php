<?php
/**
 * Callout Shortcode
 */

if( !function_exists( 'movedo_ext_vce_callout_shortcode' ) ) {

	function movedo_ext_vce_callout_shortcode( $atts, $content ) {

		$output = $button = $data = $class_leader = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'btn_position' => 'btn-right',
					'button_text' => '',
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
					'leader_text' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$title_classes = array( 'grve-callout-content' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		$title_class_string = implode( ' ', $title_classes );

		if ( 'yes' == $leader_text ) {
			$class_leader = 'grve-leader-text';
		}

		//Button
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
		);
		$button = movedo_ext_vce_get_button( $button_options );

		$callout_classes = array( 'grve-element', 'grve-callout' );

		if ( !empty( $animation ) ) {
			array_push( $callout_classes, 'grve-animated-item' );
			array_push( $callout_classes, $animation);
			array_push( $callout_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $callout_classes, $el_class);
		}

		array_push( $callout_classes, 'grve-' . $btn_position );

		$callout_class_string = implode( ' ', $callout_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $callout_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= '  <div class="grve-callout-wrapper">';
		if ( !empty( $title ) ) {
			$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . $title . '</' . tag_escape( $heading_tag ) . '>';
		}
		if ( !empty( $content ) ) {
		$output .= '    <p class="'. esc_attr( $class_leader ) . '">' . movedo_ext_vce_unautop( $content ) . '</p>';
		}
		$output .= '  </div>';
		$output .= '  <div class="grve-button-wrapper">';
		$output .= $button;
		$output .= '  </div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_callout', 'movedo_ext_vce_callout_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_callout_shortcode_params' ) ) {
	function movedo_ext_vce_callout_shortcode_params( $tag ) {
		$movedo_ext_vce_callout_shortcode_btn_params = movedo_ext_vce_get_button_params();
		$movedo_ext_vce_callout_shortcode_params = array_merge(
			array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__( "Enter your title.", "movedo-extension" ),
					"admin_label" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Enter your text.", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Leader Text", "movedo-extension" ),
					"param_name" => "leader_text",
					"description" => esc_html__( "If selected, text will be shown as leader", "movedo-extension" ),
					"value" => array( esc_html__( "Make text leader", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Button Position", "movedo-extension" ),
					"param_name" => "btn_position",
					"value" => array(
						esc_html__( "Right", "movedo-extension" ) => 'btn-right',
						esc_html__( "Bottom", "movedo-extension" ) => 'btn-bottom',
					),
					"description" => esc_html__( "Select the position of the button.", "movedo-extension" ),
					"group" => esc_html__( "Button", "movedo-extension" ),
				),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
			$movedo_ext_vce_callout_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Callout", "movedo-extension" ),
			"description" => esc_html__( "Two different styles for interesting callouts", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-callout",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $movedo_ext_vce_callout_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_callout', 'movedo_ext_vce_callout_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_callout_shortcode_params( 'movedo_callout' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
