<?php
/**
 * Pricing Table Shortcode
 */

if( !function_exists( 'movedo_ext_vce_pricing_table_shortcode' ) ) {

	function movedo_ext_vce_pricing_table_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'description' => '',
					'heading_tag' => 'h3',
					'heading' => 'h2',
					'increase_heading' => '100',
					'custom_font_family' => '',
					'price' => '',
					'interval' => '',
					'values' => '',
					'price_color' => 'black',
					'shadow' => 'small',
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
					'content_bg' => 'white',
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

		$title_classes = array( 'grve-price' );

		array_push( $title_classes, 'grve-align-' . $heading );
		array_push( $title_classes, 'grve-text-' . $price_color );

		if( '100' != $increase_heading ){
			array_push( $title_classes, 'grve-increase-heading' );
			array_push( $title_classes, 'grve-heading-' . $increase_heading );
		}
		if ( !empty( $custom_font_family ) ) {
			array_push( $title_classes, 'grve-' . $custom_font_family );
		}

		$title_class_string = implode( ' ', $title_classes );

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

		//Pricing Table Classes
		$pricing_classes = array( 'grve-element', 'grve-pricing-table' );
		if ( !empty( $animation ) ) {
			array_push( $pricing_classes, 'grve-animated-item' );
			array_push( $pricing_classes, $animation);
			array_push( $pricing_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		array_push( $pricing_classes, 'grve-align-' . $align);

		if ( !empty ( $el_class ) ) {
			array_push( $pricing_classes, $el_class);
		}

		if( 'none' != $content_bg ){
			array_push( $pricing_classes, 'grve-bg-' . $content_bg );
		}

		if( !empty ( $shadow ) && 'none' != $content_bg ){
			array_push( $pricing_classes, 'grve-shadow-' . $shadow );
			array_push( $pricing_classes, 'grve-with-shadow' );
		}

		$pricing_class_string = implode( ' ', $pricing_classes );

		//Pricing Lines
		$pricing_lines = explode(",", $values);

		$pricing_lines_data = array();
		foreach ($pricing_lines as $line) {
			$new_line = array();
			$data_line = explode("|", $line);
			$new_line['value1'] = isset( $data_line[0] ) && !empty( $data_line[0] ) ? $data_line[0] : '';
			$new_line['value2'] = isset( $data_line[1] ) && !empty( $data_line[1] ) ? $data_line[1] : '';
			$pricing_lines_data[] = $new_line;
		}

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . $pricing_class_string . '" style="' . $style . '"' . $data . '>';
		$output .= '  <div class="grve-pricing-header">';
		$output .= '    <div class="grve-pricing-title grve-h6">' . $title . '</div>';
		$output .= '    <div class="grve-pricing-description grve-subtitle">' . $description . '</div>';
		$output .= '  </div>';
		$output .= '  <div class="grve-pricing-content">';
		$output .= '    <' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">';
		$output .= '<span>' . $price;
		$output .= '</span>';
		$output .= '     <div class="grve-interval grve-h6">' . $interval . '</div>';
		$output .= '   </' . tag_escape( $heading_tag ) . '>';
		$output .= '  </div>';
	    $output .= '  <ul>';
		foreach($pricing_lines_data as $line) {
			$output .= '<li><strong>' .  $line['value1'] . ' </strong>' .  $line['value2'] . '</li>';
		}
		$output .= '  </ul>';
		$output .= $button;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_pricing_table', 'movedo_ext_vce_pricing_table_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_pricing_table_shortcode_params' ) ) {
	function movedo_ext_vce_pricing_table_shortcode_params( $tag ) {

		$movedo_ext_vce_pricing_table_shortcode_btn_params = movedo_ext_vce_get_button_params();
		$movedo_ext_vce_pricing_table_shortcode_params = array_merge(
			array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "Title",
					"save_always" => true,
					"description" => esc_html__( "Enter your title here.", "movedo-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Description", "movedo-extension" ),
					"param_name" => "description",
					"value" => "",
					"save_always" => true,
					"description" => esc_html__( "Enter your description here.", "movedo-extension" ),
					"admin_label" => false,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Price", "movedo-extension" ),
					"param_name" => "price",
					"value" => "$0",
					"save_always" => true,
					"description" => esc_html__( "Enter your price here. eg $80.", "movedo-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Price Tag", "movedo-extension" ),
					"param_name" => "heading_tag",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "div", "movedo-extension" ) => 'div',
					),
					"description" => esc_html__( "Price Tag for SEO", "movedo-extension" ),
					"std" => 'h3',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Price Size/Typography", "movedo-extension" ),
					"param_name" => "heading",
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
					"description" => esc_html__( "Price size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Increase Price Heading Size", "movedo-extension" ),
					"param_name" => "increase_heading",
					"value" => array(
						esc_html__( "100%", "movedo-extension" ) => '100',
						esc_html__( "120%", "movedo-extension" ) => '120',
						esc_html__( "140%", "movedo-extension" ) => '140',
						esc_html__( "160%", "movedo-extension" ) => '160',
						esc_html__( "180%", "movedo-extension" ) => '180',
						esc_html__( "200%", "movedo-extension" ) => '200',
						esc_html__( "250%", "movedo-extension" ) => '250',
						esc_html__( "300%", "movedo-extension" ) => '300',
					),
					"description" => esc_html__( "Set the percentage you want to increase your Headings size.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Price Custom Font Family", "movedo-extension" ),
					"param_name" => "custom_font_family",
					"value" => array(
						esc_html__( "Same as Typography", "movedo-extension" ) => '',
						esc_html__( "Custom Font Family 1", "movedo-extension" ) => 'custom-font-1',
						esc_html__( "Custom Font Family 2", "movedo-extension" ) => 'custom-font-2',
						esc_html__( "Custom Font Family 3", "movedo-extension" ) => 'custom-font-3',
						esc_html__( "Custom Font Family 4", "movedo-extension" ) => 'custom-font-4',

					),
					"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo-extension" ),
					"std" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Interval", "movedo-extension" ),
					"param_name" => "interval",
					"value" => "/month",
					"save_always" => true,
					"description" => esc_html__( "Enter interval period here. e.g: /month, per month, per year.", "movedo-extension" ),
				),
				array(
					"type" => "exploded_textarea",
					"heading" => __("Attributes", "movedo-extension"),
					"param_name" => "values",
					"description" => esc_html__( "Input attribute values. Divide values with linebreaks (Enter). Example: 100|Users.", "movedo-extension" ),
					"value" => "100|Users,8 Gig|Disc Space,Unlimited|Data Transfer",
					"save_always" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Price Color", "movedo-extension" ),
					"param_name" => "price_color",
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
					'std' => 'black',
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Content Background", "movedo-extension" ),
					"param_name" => "content_bg",
					"description" => esc_html__( "Selected background color for your image text content.", "movedo-extension" ),
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Black", "movedo-extension" ) => 'black',
					),
					'std' => 'white',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shadow", "movedo-extension" ),
					"param_name" => "shadow",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => '',
						esc_html__( "Small", "movedo-extension" ) => 'small',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Large", "movedo-extension" ) => 'large',
					),
					"dependency" => array( 'element' => "content_bg", 'value' => array( 'white', 'black' ) ),
					"description" => '',
					"std" => 'small',
				),
				movedo_ext_vce_add_align(),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
			$movedo_ext_vce_pricing_table_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Pricing Table", "movedo-extension" ),
			"description" => esc_html__( "Stylish pricing tables", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-pricing-table",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $movedo_ext_vce_pricing_table_shortcode_params,
		);

	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_pricing_table', 'movedo_ext_vce_pricing_table_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_pricing_table_shortcode_params( 'movedo_pricing_table' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
