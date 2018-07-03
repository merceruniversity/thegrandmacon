<?php
/**
 * Quote Shortcode
 */

if( !function_exists( 'movedo_ext_vce_quote_shortcode' ) ) {

	function movedo_ext_vce_quote_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'quote_style' => 'default',
					'line_color' => 'primary-1',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-adjust',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_etlineicons' => 'et-icon-mobile',
					'icon_size' => 'medium',
					'icon_color' => 'primary-1',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'align' => 'left',
					'el_class' => '',
				),
				$atts
			)
		);

		$quote_classes = array( 'grve-element' );

		if ( !empty( $animation ) ) {
			array_push( $quote_classes, 'grve-animated-item' );
			array_push( $quote_classes, $animation);
			array_push( $quote_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		array_push( $quote_classes, 'grve-align-' . $align );

		if ( !empty( $el_class ) ) {
			array_push( $quote_classes, $el_class);
		}

		if ( 'default' != $quote_style ) {
			array_push( $quote_classes, 'grve-with-' . $quote_style);
		}

		$quote_class_string = implode( ' ', $quote_classes );


		$icon_classes = array();

		if ( 'icon' == $quote_style ) {

			$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $icon_library );
			}
			array_push( $icon_classes, $icon_class );
			array_push( $icon_classes, 'grve-text-' . $icon_color );
			array_push( $icon_classes, 'grve-' . $icon_size );
		}

		$icon_class_string = implode( ' ', $icon_classes );


		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );


		$output .= '<blockquote class="' . esc_attr( $quote_class_string ) . '" style="' . $style . '"' . $data . '>';
		if( 'line' == $quote_style ) {
			$output .= '<div class="grve-quote-line grve-bg-' . esc_attr( $line_color ) . '"></div>';
		}
		if ( 'icon' == $quote_style ) {
			$output .= '  <div class="grve-quote-icon">';
			$output .= '  <i class="' . esc_attr( $icon_class_string ) . '"></i>';
			$output .= '  </div>';
		}
		$output .= '<p>' . $content . '</p>';
		$output .= '</blockquote>';


		return $output;
	}
	add_shortcode( 'movedo_quote', 'movedo_ext_vce_quote_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_quote_shortcode_params' ) ) {
	function movedo_ext_vce_quote_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Quote", "movedo-extension" ),
			"description" => esc_html__( "Easily create your Quote Text", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-quote",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Quote",
					"description" => esc_html__( "Type your quote.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Quote Style", "movedo-extension" ),
					"param_name" => "quote_style",
					"value" => array(
						esc_html__( "Default", "movedo-extension" ) => 'default',
						esc_html__( "With Icon", "movedo-extension" ) => 'icon',
						esc_html__( "With Line", "movedo-extension" ) => 'line',
					),
					"description" => esc_html__( "Choose the style for your Quote.", "movedo-extension" ),
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
					"dependency" => array( 'element' => "quote_style", 'value' => array( 'line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon size", "movedo-extension" ),
					"param_name" => "icon_size",
					"value" => array(
						esc_html__( "Extra Large", "movedo-extension" ) => 'extra-large',
						esc_html__( "Large", "movedo-extension" ) => 'large',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Small", "movedo-extension" ) => 'small',
					),
					"std" => 'medium',
					"description" => '',
					"dependency" => array( 'element' => "quote_style", 'value' => array( 'icon' ) ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon library', 'movedo-extension' ),
					'value' => array(
						esc_html__( 'Font Awesome', 'movedo-extension' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'movedo-extension' ) => 'openiconic',
						esc_html__( 'Typicons', 'movedo-extension' ) => 'typicons',
						esc_html__( 'Entypo', 'movedo-extension' ) => 'entypo',
						esc_html__( 'Linecons', 'movedo-extension' ) => 'linecons',
						esc_html__( 'Simple Line Icons', 'movedo-extension' ) => 'simplelineicons',
						esc_html__( 'Elegant Line Icons', 'movedo-extension' ) => 'etlineicons',
					),
					'param_name' => 'icon_library',
					'description' => esc_html__( 'Select icon library.', 'movedo-extension' ),
					"dependency" => array( 'element' => "quote_style", 'value' => array( 'icon' ) ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_fontawesome',
					'value' => 'fa fa-adjust',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_openiconic',
					'value' => 'vc-oi vc-oi-dial',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'openiconic',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_typicons',
					'value' => 'typcn typcn-adjust-brightness',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'typicons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_entypo',
					'value' => 'entypo-icon entypo-icon-note',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'entypo',
						'iconsPerPage' => 300, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'entypo',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_linecons',
					'value' => 'vc_li vc_li-heart',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'linecons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_simplelineicons',
					'value' => 'smp-icon-user',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'simplelineicons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'simplelineicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_etlineicons',
					'value' => 'et-icon-mobile',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'etlineicons',
						'iconsPerPage' => 100,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'etlineicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Color", "movedo-extension" ),
					"param_name" => "icon_color",
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
					"description" => esc_html__( "Color of the icon.", "movedo-extension" ),
					"dependency" => array( 'element' => "quote_style", 'value' => array( 'icon' ) ),
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
					"dependency" => array( 'element' => "quote_style", 'value' => array( 'default', 'icon' ) ),
					"description" => '',
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
	vc_lean_map( 'movedo_quote', 'movedo_ext_vce_quote_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_quote_shortcode_params( 'movedo_quote' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
