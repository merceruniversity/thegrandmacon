<?php
/**
 * Message Box Shortcode
 */

if( !function_exists( 'movedo_ext_vce_message_box_shortcode' ) ) {

	function movedo_ext_vce_message_box_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'add_icon' => '',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-info-circle',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_etlineicons' => 'et-icon-mobile',
					'bg_color' => 'green',
					'bg_hover_color' => 'green',
					'remove_close' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$message_box_classes = array( 'grve-element', 'grve-message' );

		array_push( $message_box_classes, 'grve-bg-' . $bg_color );
		array_push( $message_box_classes, 'grve-bg-hover-' . $bg_hover_color );

		if ( !empty( $animation ) ) {
			array_push( $message_box_classes, 'grve-animated-item' );
			array_push( $message_box_classes, $animation);
			array_push( $message_box_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $message_box_classes, $el_class);
		}

		$message_box_class_string = implode( ' ', $message_box_classes );

		if( 'yes' == $add_icon ) {
			$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $icon_library );
			}
		}

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $message_box_class_string ) . '" style="' . $style . '"' . $data . '>';
		if( 'yes' == $add_icon ) {
			$output .= '  <i class="grve-message-icon '. esc_attr( $icon_class ) . '"></i>';
		}
		$output .= '  <p>' . do_shortcode( $content ) . '</p>';
		if ( 'yes' != $remove_close ) {
			$output .= '  <i class="grve-close"></i>';
		}
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_message_box', 'movedo_ext_vce_message_box_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_message_box_shortcode_params' ) ) {
	function movedo_ext_vce_message_box_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Message Box", "movedo-extension" ),
			"description" => esc_html__( "Info text with icons", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-message-box",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Add icon?", "movedo-extension" ),
					"param_name" => "add_icon",
					"value" => array( esc_html__( "Select if you want to show an icon", "movedo-extension" ) => 'yes' ),
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
					"dependency" => array( 'element' => "add_icon", 'value' => array( 'yes' ) ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_fontawesome',
					'value' => 'fa fa-info-circle',
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
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Enter your content.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background Color", "movedo-extension" ),
					"param_name" => "bg_color",
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
					"description" => esc_html__( "Background color of the box.", "movedo-extension" ),
					'std' => 'green',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background Hover Color", "movedo-extension" ),
					"param_name" => "bg_hover_color",
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
					"description" => esc_html__( "Background hover color of the box.", "movedo-extension" ),
					'std' => 'green',
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Remove Close Button", "movedo-extension" ),
					"param_name" => "remove_close",
					"value" => array( esc_html__( "If selected, close button will be removed", "movedo-extension" ) => 'yes' ),
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
	vc_lean_map( 'movedo_message_box', 'movedo_ext_vce_message_box_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_message_box_shortcode_params( 'movedo_message_box' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
