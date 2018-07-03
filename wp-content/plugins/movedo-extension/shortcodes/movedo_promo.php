<?php
/**
 * Single Expandable Info Shortcode
 */

if( !function_exists( 'movedo_ext_vce_promo_shortcode' ) ) {

	function movedo_ext_vce_promo_shortcode( $atts, $content ) {

		$output = $button = $retina_data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'image' => '',
					'retina_image' => '',
					'align' => 'left',
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
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

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
		$image_string = '';

		if ( !empty( $image ) ) {

			$image_classes = array();
			$image_classes[] = 'attachment-full';
			$image_classes[] = 'size-full';
			$image_classes[] = 'grve-expandable-info-logo';
			$image_class_string = implode( ' ', $image_classes );

			$img_id = preg_replace('/[^\d]/', '', $image);
			$img_src = wp_get_attachment_image_src( $img_id, 'full' );
			$img_url = $img_src[0];
			$image_srcset = '';
			if ( !empty( $retina_image ) ) {
				$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
				$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
				$retina_url = $img_retina_src[0];
				$image_srcset = esc_attr( $img_url ) . ' 1x,' . esc_attr( $retina_url ) . ' 2x';
				$image_string = wp_get_attachment_image( $img_id, 'full' , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
			} else {
				$image_string = wp_get_attachment_image( $img_id, 'full' , "", array( 'class' => $image_class_string ) );
			}

		}

		$output .= '<div class="grve-element grve-expandable-info grve-align-' . esc_attr( $align ) . ' ' . esc_attr( $el_class ) . '">';
		$output .= $image_string;
		$output .= '  <div class="grve-expandable-info-content">';
		$output .= '  	<div class="grve-expandable-info-space"></div>';
		$output .= '    <p class="grve-leader-text">' . movedo_ext_vce_unautop( $content ) . '</p>';
		$output .= $button;
		$output .= '  </div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_promo', 'movedo_ext_vce_promo_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_promo_shortcode_params' ) ) {
	function movedo_ext_vce_promo_shortcode_params( $tag ) {

		$movedo_ext_vce_promo_shortcode_btn_params = movedo_ext_vce_get_button_params();
		$movedo_ext_vce_promo_shortcode_params = array_merge(
			array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "movedo-extension" ),
					"param_name" => "image",
					"value" => '',
					"description" => esc_html__( "Select an image.", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Retina Image", "movedo-extension" ),
					"param_name" => "retina_image",
					"value" => '',
					"description" => esc_html__( "Select a 2x image.", "movedo-extension" ),
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Enter your text.", "movedo-extension" ),
				),
				movedo_ext_vce_add_align(),
				movedo_ext_vce_add_el_class(),
			),
			$movedo_ext_vce_promo_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Advanced Promo", "movedo-extension" ),
			"description" => esc_html__( "Advanced, impressive promotion for whatever you like", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-promo",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $movedo_ext_vce_promo_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_promo', 'movedo_ext_vce_promo_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_promo_shortcode_params( 'movedo_promo' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
