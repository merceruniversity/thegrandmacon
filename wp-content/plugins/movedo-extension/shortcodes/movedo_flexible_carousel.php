<?php
/**
 * Flexible Carousel Shortcode
 */

if( !function_exists( 'movedo_ext_vce_flexible_carousel_shortcode' ) ) {

	function movedo_ext_vce_flexible_carousel_shortcode( $attr, $content ) {

		$allow_filter = $class_fullwidth = $slider_data = $output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'items_per_page' => '4',
					'items_tablet_landscape' => '4',
					'items_tablet_portrait' => '2',
					'items_mobile' => '1',
					'margin_bottom' => '',
					'slideshow_speed' => '3000',
					'pagination' => 'no',
					'pagination_type' => '1',
					'pagination_speed' => '400',
					'auto_play' => 'yes',
					'pause_hover' => 'no',
					'auto_height' => 'no',
					'item_gutter' => 'yes',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'el_class' => '',
				),
				$attr
			)
		);

		$data_string = '';
		$data_string .= ' data-items="' . esc_attr( $items_per_page ) . '"';
		$data_string .= ' data-items-tablet-landscape="' . esc_attr( $items_tablet_landscape ) . '"';
		$data_string .= ' data-items-tablet-portrait="' . esc_attr( $items_tablet_portrait ) . '"';
		$data_string .= ' data-items-mobile="' . esc_attr( $items_mobile ) . '"';
		$data_string .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
		$data_string .= ' data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
		$data_string .= ' data-slider-pause="' . esc_attr( $pause_hover ) . '"';
		$data_string .= ' data-pagination-speed="' . esc_attr( $pagination_speed ) . '"';
		$data_string .= ' data-pagination="' . esc_attr( $pagination ) . '"';
		$data_string .= ' data-slider-autoheight="' . esc_attr( $auto_height ) . '"';

		//Carousel Element
		$flexible_carousel_classes = array( 'grve-element', 'grve-flexible-carousel', 'grve-carousel', 'grve-layout-1' );
		if ( 'yes' == $item_gutter ) {
			array_push( $flexible_carousel_classes, 'grve-with-gap' );
		}
		if ( 'yes' == $pagination ) {
			array_push( $flexible_carousel_classes, 'grve-carousel-pagination-' . $pagination_type  );
		}
		$flexible_carousel_class_string = implode( ' ', $flexible_carousel_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output = "";

		$output .= '<div class="' . esc_attr( $flexible_carousel_class_string ) . '" style="' . $style . '">';
		$output .= '<div class="grve-carousel-wrapper">';
		$output .=   movedo_ext_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
		$output .= '	<div class="grve-flexible-carousel-element ' . esc_attr( $el_class ) . '"' . $data_string . '>';
		if ( !empty( $content ) ) {
			$output .= do_shortcode( $content );
		}
		$output .= '	</div>';
		$output .= '  </div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode( 'movedo_flexible_carousel', 'movedo_ext_vce_flexible_carousel_shortcode' );

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_movedo_flexible_carousel extends WPBakeryShortCodesContainer {
    }
}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_flexible_carousel_shortcode_params' ) ) {
	function movedo_ext_vce_flexible_carousel_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Flexible Carousel", "movedo-extension" ),
			"description" => esc_html__( "Add a flexible carousel with elements", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon" => "icon-wpb-grve-flexible-carousel",
			"category" => esc_html__( "Content", "js_composer" ),
			"content_element" => true,
			"controls" => "full",
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'vc_row,vc_column,vc_row_inner,vc_column_inner,vc_column_text,vc_custom_heading,vc_empty_space,movedo_single_image,movedo_button,movedo_image_text,movedo_team,movedo_divider,movedo_icon,movedo_icon_box,movedo_social,movedo_callout,movedo_slogan,movedo_title'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "movedo-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page", "movedo-extension" ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Items per page", "movedo-extension" ),
					"param_name" => "items_tablet_landscape",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page on tablet devices, landscape orientation.", "movedo-extension" ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Items per page", "movedo-extension" ),
					"param_name" => "items_tablet_portrait",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page on tablet devices, landscape portrait.", "movedo-extension" ),
					"std" => "2",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Items per page", "movedo-extension" ),
					"param_name" => "items_mobile",
					"value" => array( '1', '2' ),
					"description" => esc_html__( "Number of items per page on mobile devices.", "movedo-extension" ),
					"std" => "1",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gutter between items", "movedo-extension" ),
					"param_name" => "item_gutter",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"description" => esc_html__( "Add gutter among items.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
				),
				movedo_ext_vce_add_slideshow_speed(),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "movedo-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pagination", "movedo-extension" ),
					"param_name" => "pagination",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => 'no',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"std" => "no",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pagination Type", "movedo-extension" ),
					"param_name" => "pagination_type",
					'value' => array(
						esc_html__( 'Bullet' , 'movedo-extension' ) => '1',
						esc_html__( 'Dashed' , 'movedo-extension' ) => '2',
					),
					"description" => esc_html__( "Select your pagination type.", "movedo-extension" ),
					"dependency" => array( 'element' => "pagination", 'value' => array( 'yes' ) ),
				),
				movedo_ext_vce_add_pagination_speed(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Type", "movedo-extension" ),
					"param_name" => "navigation_type",
					'value' => array(
						esc_html__( 'Style 1' , 'movedo-extension' ) => '1',
						esc_html__( 'No Navigation' , 'movedo-extension' ) => '0',
					),
					"description" => esc_html__( "Select your Navigation type.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Color", "movedo-extension" ),
					"param_name" => "navigation_color",
					'value' => array(
						esc_html__( 'Dark' , 'movedo-extension' ) => 'dark',
						esc_html__( 'Light' , 'movedo-extension' ) => 'light',
					),
					"description" => esc_html__( "Select the background Navigation color.", "movedo-extension" ),
				),
				movedo_ext_vce_add_auto_height(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
			"js_view" => 'VcColumnView',
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_flexible_carousel', 'movedo_ext_vce_flexible_carousel_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_flexible_carousel_shortcode_params( 'movedo_flexible_carousel' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
