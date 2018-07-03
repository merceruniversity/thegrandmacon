<?php
/**
 * Counter Shortcode
 */

if( !function_exists( 'movedo_ext_vce_counter_shortcode' ) ) {

	function movedo_ext_vce_counter_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'counter_start_val' => '0',
					'counter_end_val' => '100',
					'counter_prefix' => '',
					'counter_suffix' => '',
					'counter_decimal_points' => '0',
					'counter_decimal_separator' => '.',
					'counter_color' => 'primary-1',
					'counter_heading' => 'h2',
					'counter_custom_font_family' => '',
					'increase_counter_heading' => '100',
					'counter_thousands_separator_vis' => '',
					'counter_thousands_separator' => ',',
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-adjust',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_etlineicons' => 'et-icon-mobile',
					'icon_type' => '',
					'icon_svg' => '',
					'icon_svg_animation_duration' => '100',
					'icon_size' => 'medium',
					'icon_color' => 'primary-1',
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

		$title_classes = array( 'grve-counter-title' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		$title_class_string = implode( ' ', $title_classes );

		$counter_classes = array( 'grve-element' );

		array_push( $counter_classes, 'grve-counter' );
		array_push( $counter_classes, 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $counter_classes, 'grve-animated-item' );
			array_push( $counter_classes, $animation);
			array_push( $counter_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $counter_classes, $el_class);
		}

		$counter_class_string = implode( ' ', $counter_classes );


		$counter_number = array( 'grve-counter-item' );

		array_push( $counter_number, 'grve-' . $counter_heading );
		array_push( $counter_number, 'grve-text-' . $counter_color );

		if ( !empty( $counter_custom_font_family ) ) {
			array_push( $counter_number, 'grve-' . $counter_custom_font_family );
		}

		if( '100' != $increase_counter_heading ){
			array_push( $counter_number, 'grve-increase-heading' );
			array_push( $counter_number, 'grve-heading-' . $increase_counter_heading );
		}

		$counter_number_class_string = implode( ' ', $counter_number );


		$icon_classes = array();

		if ( 'icon' == $icon_type ) {

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


		$output .= '<div class="' . esc_attr( $counter_class_string ) . '" style="' . $style . '"' . $data . '>';

		if ( 'icon' == $icon_type ) {
			$output .= '  <div class="grve-counter-icon">';
			$output .= '  <i class="' . esc_attr( $icon_class_string ) . '"></i>';
			$output .= '  </div>';
		} else if( 'icon_svg' == $icon_type ) {
			if ( !empty( $icon_svg ) ) {
				$img_id = preg_replace('/[^\d]/', '', $icon_svg);
				$img_src = wp_get_attachment_image_src( $img_id, 'full' );
				$output .= '<div class="grve-counter-icon grve-' . $icon_size . '">';
				$output .= '<div id="' . uniqid('grve-svg-') . '" data-file="' . esc_url( $img_src[0] ) . '" data-duration="' . esc_attr( $icon_svg_animation_duration ) . '" class="grve-svg-icon grve-text-' . esc_attr( $icon_color ) . '"></div>';
				$output .= '</div>';
			}
		}

		$output .= '  <div class="grve-counter-content">';
		$output .= '    <div class="' . esc_attr( $counter_number_class_string ) . '">';
		$output .= '      <span data-thousands-separator-vis="' . esc_attr( $counter_thousands_separator_vis ) . '" data-thousands-separator="' . esc_attr( $counter_thousands_separator ) . '" data-prefix="' . esc_attr( $counter_prefix ) . '" data-suffix="' . esc_attr( $counter_suffix ) . '" data-start-val="' . esc_attr( $counter_start_val ) . '" data-end-val="' . esc_attr( $counter_end_val ) . '" data-decimal-points="' . esc_attr( $counter_decimal_points ) . '" data-decimal-separator="' . esc_attr( $counter_decimal_separator ) . '">' . $counter_start_val. '</span>';
		$output .= '    </div>';
		$output .= '	<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
		$output .= '  </div>';

		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_counter', 'movedo_ext_vce_counter_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_counter_shortcode_params' ) ) {
	function movedo_ext_vce_counter_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Counter", "movedo-extension" ),
			"description" => esc_html__( "Add a counter with icon and title", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-counter",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Start Number", "movedo-extension" ),
					"param_name" => "counter_start_val",
					"value" => "0",
					"description" => esc_html__( "Enter counter start number.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter End Number", "movedo-extension" ),
					"param_name" => "counter_end_val",
					"value" => "100",
					"description" => esc_html__( "Enter counter end number.", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Counter Thousands Separator Visiblility", "movedo-extension" ),
					"param_name" => "counter_thousands_separator_vis",
					"description" => esc_html__( "If selected, thousands separator will not be shown.", "movedo-extension" ),
					"value" => array( esc_html__( "Disable Thousands Separator.", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Thousands Separator", "movedo-extension" ),
					"param_name" => "counter_thousands_separator",
					"value" => ",",
					"description" => esc_html__( "Enter thousands separator.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Decimal Points", "movedo-extension" ),
					"param_name" => "counter_decimal_points",
					"value" => "0",
					"description" => esc_html__( "Number of decimal points.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Decimal Separator", "movedo-extension" ),
					"param_name" => "counter_decimal_separator",
					"value" => ".",
					"description" => esc_html__( "Enter decimal separator.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Prefix", "movedo-extension" ),
					"param_name" => "counter_prefix",
					"value" => "",
					"description" => esc_html__( "Enter counter prefix.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Suffix", "movedo-extension" ),
					"param_name" => "counter_suffix",
					"value" => "",
					"description" => esc_html__( "Enter counter suffix.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Counter Color", "movedo-extension" ),
					"param_name" => "counter_color",
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
					"description" => esc_html__( "Color of the counter.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Counter Size/Typography", "movedo-extension" ),
					"param_name" => "counter_heading",
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
					"description" => esc_html__( "Select counter text size.", "movedo-extension" ),
					"std" => 'h2',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Increase Counter Size", "movedo-extension" ),
					"param_name" => "increase_counter_heading",
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
					"heading" => esc_html__( "Counter Custom Font Family", "movedo-extension" ),
					"param_name" => "counter_custom_font_family",
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
					"type" => "dropdown",
					"heading" => esc_html__( "Icon type", "movedo-extension" ),
					"param_name" => "icon_type",
					"value" => array(
						esc_html__( "No Icon", "movedo-extension" ) => '',
						esc_html__( "Icon", "movedo-extension" ) => 'icon',
						esc_html__( "Animated SVG", "movedo-extension" ) => 'icon_svg',
					),
					"description" => '',
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
					"dependency" => array( 'element' => 'icon_type', 'value_not_equal_to' => array( '' ) ),
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
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon', 'icon_svg' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter counter title.", "movedo-extension" ),
					"save_always" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_custom_font_family(),
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
	vc_lean_map( 'movedo_counter', 'movedo_ext_vce_counter_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_counter_shortcode_params( 'movedo_counter' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
