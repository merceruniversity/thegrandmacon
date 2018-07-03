<?php
/**
 * Icon Shortcode
 */

if( !function_exists( 'movedo_ext_vce_icon_shortcode' ) ) {

	function movedo_ext_vce_icon_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $text_style_class = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'icon_type' => 'icon',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-adjust',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_etlineicons' => 'et-icon-mobile',
					'icon_size' => 'medium',
					'icon_shape' => 'no-shape',
					'shape_type' => 'simple',
					'icon_svg' => '',
					'icon_svg_animation_duration' => '100',
					'icon_color' => 'primary-1',
					'icon_color_custom' => '#000000',
					'icon_shape_color' => 'grey',
					'icon_shape_color_custom' => '#e1e1e1',
					'icon_animation' => 'no',
					'align' => 'left',
					'icon_hover_effect' => 'no',
					'link' => '',
					'link_class' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$icon_element_classes = array( 'grve-element' );

		array_push( $icon_element_classes, 'grve-single-icon' );
		array_push( $icon_element_classes, 'grve-align-' . $align );
		array_push( $icon_element_classes, 'grve-' . $icon_size );

		if ( !empty( $animation ) ) {
			array_push( $icon_element_classes, 'grve-animated-item' );
			array_push( $icon_element_classes, $animation);
			array_push( $icon_element_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $icon_element_classes, $el_class);
		}

		if( 'yes' == $icon_hover_effect && 'no-shape' != $icon_shape ) {
			array_push( $icon_element_classes, 'grve-hover-effect' );
		}

		$icon_wrapper_classes = array( 'grve-wrapper-icon' );
		$icon_classes = array();

		if ( 'no-shape' != $icon_shape ) {
			array_push( $icon_wrapper_classes, 'grve-' . $shape_type );
			array_push( $icon_element_classes, 'grve-with-shape' );
		}
		array_push( $icon_wrapper_classes, 'grve-' . $icon_shape );

		if ( 'no-shape' != $icon_shape ) {
			if ( 'outline' != $shape_type ) {
				array_push( $icon_wrapper_classes, 'grve-bg-' . $icon_shape_color );
			} else {
				array_push( $icon_wrapper_classes, 'grve-text-' . $icon_shape_color );
			}
		}
		//Icon Wrapper Style
		$icon_wrapper_style = '';
		if( 'custom' == $icon_color ) {
			$icon_wrapper_style .= ' color: ' . esc_attr( $icon_color_custom ) . ';';
		}
		if( 'custom' == $icon_shape_color ) {
			if ( 'no-shape' != $icon_shape && 'outline' != $shape_type ) {
				if ( 'outline' != $shape_type ) {
					$icon_wrapper_style .= ' background-color: ' . esc_attr( $icon_shape_color_custom ) . ';';
				} else {
					$icon_wrapper_style .= ' border-color: ' . esc_attr( $icon_shape_color_custom ) . ';';
				}
			}
		}

		$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
		if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
			vc_icon_element_fonts_enqueue( $icon_library );
		}
		array_push( $icon_classes, $icon_class );
		array_push( $icon_classes, 'grve-text-' . $icon_color );

		$icon_element_class_string = implode( ' ', $icon_element_classes );
		$icon_wrapper_class_string = implode( ' ', $icon_wrapper_classes );
		$icon_class_string = implode( ' ', $icon_classes );


		if ( movedo_ext_vce_has_link( $link ) ) {
			$link_attributes = movedo_ext_vce_get_link_attributes( $link, $link_class );
			$link_start = '<a ' . implode( ' ', $link_attributes ) . '>';
			$link_end = '</a>';
		}

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $icon_element_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= $link_start;
		if( 'icon_svg' == $icon_type ) {
			if ( !empty( $icon_svg ) ) {
				$img_id = preg_replace('/[^\d]/', '', $icon_svg);
				$img_src = wp_get_attachment_image_src( $img_id, 'full' );
				$output .= '<div class="' . esc_attr( $icon_wrapper_class_string ) . '" style="' . $icon_wrapper_style . '">';
				$output .= '<div id="' . uniqid('grve-svg-') . '" data-file="' . esc_url( $img_src[0] ) . '" data-duration="' . esc_attr( $icon_svg_animation_duration ) . '" class="grve-svg-icon grve-text-' . esc_attr( $icon_color ) . '"></div>';
				$output .= '</div>';
			}
		} else {
			$output .= '  <div class="' . esc_attr( $icon_wrapper_class_string ) . '" style="' . $icon_wrapper_style . '"><i class="'. esc_attr( $icon_class_string ) . '"></i></div>';
		}
		$output .= $link_end;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_icon', 'movedo_ext_vce_icon_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_icon_shortcode_params' ) ) {
	function movedo_ext_vce_icon_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Icon", "movedo-extension" ),
			"description" => esc_html__( "Add an icon", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-icon",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Type", "movedo-extension" ),
					"param_name" => "icon_type",
					"value" => array(
						esc_html__( "Icon", "movedo-extension" ) => 'icon',
						esc_html__( "Animated SVG", "movedo-extension" ) => 'icon_svg',
					),
					"description" => '',
					"admin_label" => true,
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
				),
				movedo_ext_vce_add_align(),
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
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon' ) ),
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
					"type" => "attach_image",
					"heading" => esc_html__( "Icon SVG", "movedo-extension" ),
					"param_name" => "icon_svg",
					"value" => '',
					"description" => esc_html__( "Select an svg icon. Note: SVG mime type must be enabled in WordPress", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon_svg' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__('SVG Animation Duration', 'movedo-extension'),
					"param_name" => "icon_svg_animation_duration",
					"value" => '100',
					"description" => esc_html__( "Add delay in milliseconds.", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon_svg' ) ),
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
						esc_html__( "Custom", "movedo-extension" ) => 'custom',
					),
					"description" => esc_html__( "Color of the icon.", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon', 'icon_svg' ) ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( "Custom Icon Color", "movedo-extension" ),
					'param_name' => 'icon_color_custom',
					'description' => esc_html__( "Select a custom color for your icon", "movedo-extension" ),
					'std' => '#000000',
					"dependency" => array( 'element' => "icon_color", 'value' => array( 'custom' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon shape", "movedo-extension" ),
					"param_name" => "icon_shape",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'no-shape',
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'round',
						esc_html__( "Circle", "movedo-extension" ) => 'circle',
					),
					"description" => '',
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon', 'icon_svg' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shape type", "movedo-extension" ),
					"param_name" => "shape_type",
					"value" => array(
						esc_html__( "Simple", "movedo-extension" ) => 'simple',
						esc_html__( "Outline", "movedo-extension" ) => 'outline',
					),
					"description" => esc_html__( "Select shape type.", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Shape Color", "movedo-extension" ),
					"param_name" => "icon_shape_color",
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
						esc_html__( "Custom", "movedo-extension" ) => 'custom',
					),
					'std' => 'grey',
					"description" => esc_html__( "This affects to the Background of the simple shape type. Alternatively, affects to the line shape type.", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( "Custom Icon Shape Color", "movedo-extension" ),
					'param_name' => 'icon_shape_color_custom',
					'description' => esc_html__( "Select a custom color for your shape", "movedo-extension" ),
					'std' => '#e1e1e1',
					"dependency" => array( 'element' => "icon_shape_color", 'value' => array( 'custom' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Hover Effect", "movedo-extension" ),
					"param_name" => "icon_hover_effect",
					"value" => array( esc_html__( "If selected, you will have hover effect.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "movedo-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Link Class", "movedo-extension" ),
					"param_name" => "link_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "movedo-extension" ),
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
	vc_lean_map( 'movedo_icon', 'movedo_ext_vce_icon_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_icon_shortcode_params( 'movedo_icon' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
