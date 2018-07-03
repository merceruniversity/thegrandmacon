<?php

/*
 *	Helper functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */



 /**
 * Generic Parameters to reuse
 * Used in vc shortcodes
 */

if( !function_exists( 'movedo_ext_vce_add_animation' ) ) {
	function movedo_ext_vce_add_animation() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "CSS Animation", "movedo-extension"),
			"param_name" => "animation",
			"value" => array(
				esc_html__( "No", "movedo-extension" ) => '',
				esc_html__( "Fade In", "movedo-extension" ) => "grve-fade-in",
				esc_html__( "Fade In Up", "movedo-extension" ) => "grve-fade-in-up",
				esc_html__( "Fade In Up Big", "movedo-extension" ) => "grve-fade-in-up-big",
				esc_html__( "Fade In Down", "movedo-extension" ) => "grve-fade-in-down",
				esc_html__( "Fade In Down Big", "movedo-extension" ) => "grve-fade-in-down-big",
				esc_html__( "Fade In Left", "movedo-extension" ) => "grve-fade-in-left",
				esc_html__( "Fade In Left Big", "movedo-extension" ) => "grve-fade-in-left-big",
				esc_html__( "Fade In Right", "movedo-extension" ) => "grve-fade-in-right",
				esc_html__( "Fade In Right Big", "movedo-extension" ) => "grve-fade-in-right-big",
				esc_html__( "Zoom In", "movedo-extension" ) => "grve-zoom-in",
			),
			"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_animation_delay' ) ) {
	function movedo_ext_vce_add_animation_delay() {
		return array(
			"type" => "textfield",
			'edit_field_class' => 'vc_col-sm-6',
			"heading" => esc_html__('Css Animation Delay', 'movedo-extension'),
			"param_name" => "animation_delay",
			"value" => '200',
			"description" => esc_html__( "Add delay in milliseconds.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_animation_duration' ) ) {
	function movedo_ext_vce_add_animation_duration() {
		return array(
			"type" => "dropdown",
			'edit_field_class' => 'vc_col-sm-6',
			"heading" => esc_html__( "CSS Animation Duration", "movedo-extension"),
			"param_name" => "animation_duration",
			"value" => array(
				esc_html__( "Very Fast", "movedo-extension" ) => "very-fast",
				esc_html__( "Fast", "movedo-extension" ) => "fast",
				esc_html__( "Normal", "movedo-extension" ) => "normal",
				esc_html__( "Slow", "movedo-extension" ) => "slow",
				esc_html__( "Very Slow", "movedo-extension" ) => "very-slow",
			),
			"std" => 'normal',
			"description" => esc_html__("Select the duration for your animated element.", 'movedo-extension' ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_margin_bottom' ) ) {
	function movedo_ext_vce_add_margin_bottom() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__('Bottom margin', 'movedo-extension'),
			"param_name" => "margin_bottom",
			"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_el_class' ) ) {
	function movedo_ext_vce_add_el_class() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__( "Extra class name", "movedo-extension" ),
			"param_name" => "el_class",
			"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_align' ) ) {
	function movedo_ext_vce_add_align() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Alignment", "movedo-extension" ),
			"param_name" => "align",
			"value" => array(
				esc_html__( "Left", "movedo-extension" ) => 'left',
				esc_html__( "Right", "movedo-extension" ) => 'right',
				esc_html__( "Center", "movedo-extension" ) => 'center',
			),
			"description" => '',
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_order_by' ) ) {
	function movedo_ext_vce_add_order_by() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Order By", "movedo-extension" ),
			"param_name" => "order_by",
			"value" => array(
				esc_html__( "Date", "movedo-extension" ) => 'date',
				esc_html__( "Last modified date", "movedo-extension" ) => 'modified',
				esc_html__( "Number of comments", "movedo-extension" ) => 'comment_count',
				esc_html__( "Title", "movedo-extension" ) => 'title',
				esc_html__( "Author", "movedo-extension" ) => 'author',
				esc_html__( "Random", "movedo-extension" ) => 'rand',
			),
			"description" => '',
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_order' ) ) {
	function movedo_ext_vce_add_order() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Order", "movedo-extension" ),
			"param_name" => "order",
			"value" => array(
				esc_html__( "Descending", "movedo-extension" ) => 'DESC',
				esc_html__( "Ascending", "movedo-extension" ) => 'ASC'
			),
			"dependency" => array( 'element' => "order_by", 'value' => array( 'date', 'modified', 'comment_count', 'name', 'author', 'title' ) ),
			"description" => '',
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_slideshow_speed' ) ) {
	function movedo_ext_vce_add_slideshow_speed() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__( "Slideshow Speed", "movedo-extension" ),
			"param_name" => "slideshow_speed",
			"value" => '3000',
			"description" => esc_html__( "Slideshow Speed in ms.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_pagination_speed' ) ) {
	function movedo_ext_vce_add_pagination_speed() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__( "Pagination Speed", "movedo-extension" ),
			"param_name" => "pagination_speed",
			"value" => '400',
			"description" => esc_html__( "Pagination Speed in ms.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_navigation_type' ) ) {
	function movedo_ext_vce_add_navigation_type() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Navigation Type", "movedo-extension" ),
			"param_name" => "navigation_type",
			'value' => array(
				esc_html__( 'Style 1' , 'movedo-extension' ) => '1',
				esc_html__( 'No Navigation' , 'movedo-extension' ) => '0',
			),
			"description" => esc_html__( "Select your Navigation type.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_navigation_color' ) ) {
	function movedo_ext_vce_add_navigation_color() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Navigation Color", "movedo-extension" ),
			"param_name" => "navigation_color",
			'value' => array(
				esc_html__( 'Dark' , 'movedo-extension' ) => 'dark',
				esc_html__( 'Light' , 'movedo-extension' ) => 'light',
			),
			"description" => esc_html__( "Select the background Navigation color.", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_add_auto_height' ) ) {
	function movedo_ext_vce_add_auto_height() {
		return array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Auto Height", "movedo-extension" ),
			"param_name" => "auto_height",
			"value" => array( esc_html__( "Select if you want smooth auto height", "movedo-extension" ) => 'yes' ),
		);
	}
}


//Title Headings/Tags
if( !function_exists( 'movedo_ext_vce_get_heading_tag' ) ) {
	function movedo_ext_vce_get_heading_tag( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Title Tag", "movedo-extension" ),
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
			"description" => esc_html__( "Title Tag for SEO", "movedo-extension" ),
			"std" => $std,
		);
	}
}

if( !function_exists( 'movedo_ext_vce_get_heading' ) ) {
	function movedo_ext_vce_get_heading( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Title Size/Typography", "movedo-extension" ),
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
			"description" => esc_html__( "Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
			"std" => $std,
		);
	}
}

// Heading Increase
if( !function_exists( 'movedo_ext_vce_get_heading_increase' ) ) {
	function movedo_ext_vce_get_heading_increase() {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Increase Heading Size", "movedo-extension" ),
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
		);
	}
}


if( !function_exists( 'movedo_ext_vce_get_heading_blog' ) ) {
	function movedo_ext_vce_get_heading_blog( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Title Size", "movedo-extension" ),
			"param_name" => "heading",
			"value" => array(
				esc_html__( "Auto", "movedo-extension" ) => 'auto',
				esc_html__( "h1", "movedo-extension" ) => 'h1',
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
			"description" => esc_html__( "Title size and typography", "movedo-extension" ),
			"std" => $std,
		);
	}
}

if( !function_exists( 'movedo_ext_vce_get_custom_font_family' ) ) {
	function movedo_ext_vce_get_custom_font_family( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Custom Font Family", "movedo-extension" ),
			"param_name" => "custom_font_family",
			"value" => array(
				esc_html__( "Same as Typography", "movedo-extension" ) => '',
				esc_html__( "Custom Font Family 1", "movedo-extension" ) => 'custom-font-1',
				esc_html__( "Custom Font Family 2", "movedo-extension" ) => 'custom-font-2',
				esc_html__( "Custom Font Family 3", "movedo-extension" ) => 'custom-font-3',
				esc_html__( "Custom Font Family 4", "movedo-extension" ) => 'custom-font-4',

			),
			"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo-extension" ),
			"std" => $std,
		);
	}
}

//Split Title
if( !function_exists( 'movedo_ext_vce_get_split_title' ) ) {
	function movedo_ext_vce_get_split_title() {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Split Title", "movedo-extension" ),
			"param_name" => "split_title",
			"value" => array(
				esc_html__( "No", "movedo-extension" ) => '',
				esc_html__( "Yes", "movedo-extension" ) => 'yes',
			),
			"description" => esc_html__( "Split Title", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_get_split_title_space' ) ) {
	function movedo_ext_vce_get_split_title_space() {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Split Title Space", "movedo-extension" ),
			"param_name" => "split_title_space",
			"value" => array(
				esc_html__( "Small", "movedo-extension" ) => 'small',
				esc_html__( "Medium", "movedo-extension" ) => 'medium',
				esc_html__( "Large", "movedo-extension" ) => 'large',
			),
			"description" => esc_html__( "Split Title Space", "movedo-extension" ),
			"dependency" => array( 'element' => "split_title", 'value' => array( 'yes' ) ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_get_gradient_color' ) ) {
	function movedo_ext_vce_get_gradient_color( ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Gradient Color", "movedo-extension" ),
			"param_name" => "gradient_color",
			"value" => array(
				esc_html__( "No", "movedo-extension" ) => '',
				esc_html__( "Yes", "movedo-extension" ) => 'yes',

			),
			"description" => esc_html__( "Select if you want gradient color", "movedo-extension" ),
		);
	}
}

if( !function_exists( 'movedo_ext_vce_get_gradient_color_1' ) ) {
	function movedo_ext_vce_get_gradient_color_1( ) {
		return	array(
				"type" => "dropdown",
				"heading" => esc_html__( "Gradient Color 1 ", "movedo-extension" ),
				"param_name" => "gradient_color_1",
				"param_holder_class" => "grve-colored-dropdown",
				'edit_field_class' => 'vc_col-sm-6',
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
				"description" => esc_html__( "Select first color for gradient.", "movedo-extension" ),
				"dependency" => array( 'element' => "gradient_color", 'value' => array( 'yes' ) ),
				"std" => 'primary-1',
		);
	}
}

if( !function_exists( 'movedo_ext_vce_get_gradient_color_2' ) ) {
	function movedo_ext_vce_get_gradient_color_2( ) {
		return	array(
				"type" => "dropdown",
				"heading" => esc_html__( "Gradient Color 2 ", "movedo-extension" ),
				"param_name" => "gradient_color_2",
				"param_holder_class" => "grve-colored-dropdown",
				'edit_field_class' => 'vc_col-sm-6',
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
				"description" => esc_html__( "Select second color for gradient.", "movedo-extension" ),
				"dependency" => array( 'element' => "gradient_color", 'value' => array( 'yes' ) ),
				"std" => 'primary-2',
		);
	}
}


function movedo_ext_vce_get_social_links_params() {
	global $movedo_grve_social_list_extended;

	$social_params = array();
	if ( isset( $movedo_grve_social_list_extended ) ) {

		foreach ( $movedo_grve_social_list_extended as $social_item ) {

			$social_params[] = array(
				"type" => "textfield",
				"heading" => esc_html( $social_item['title'] ),
				"param_name" => $social_item['url'],
				"value" => "",
				"group" => esc_html__( "Social Links", "movedo-extension" ),
			);
		}
	}

	return $social_params;
}


//Button Parameters

function movedo_ext_vce_get_button_params( $group = 'button', $index = '' ) {


	if ( 'first' == $group ) {
		$group_string = esc_html__( "First Button", "movedo-extension" );
	} elseif ( 'second' == $group ) {
		$group_string = esc_html__( "Second Button", "movedo-extension" );
	} else {
		$group_string = esc_html__( "Button", "movedo-extension" );
	}

	$btn_params = array(
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Button Text", "movedo-extension" ),
			"param_name" => "button" . $index . "_text",
			"save_always" => true,
			"admin_label" => true,
			"value" => "Button",
			"description" => esc_html__( "Text of the button.", "movedo-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Type", "movedo-extension" ),
			"param_name" => "button" . $index . "_type",
			"value" => array(
				esc_html__( "Simple", "movedo-extension" ) => 'simple',
				esc_html__( "Outline", "movedo-extension" ) => 'outline',
				esc_html__( "Underline", "movedo-extension" ) => 'underline',
				esc_html__( "Gradient", "movedo-extension" ) => 'gradient',
			),
			"description" => esc_html__( "Select button type.", "movedo-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Color", "movedo-extension" ),
			"param_name" => "button" . $index . "_color",
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
			"description" => esc_html__( "Color of the button.", "movedo-extension" ),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'simple', 'outline', 'underline' ) ),
			"group" => $group_string,
			"std" => 'primary-1',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Line Color", "movedo-extension" ),
			"param_name" => "button" . $index . "_line_color",
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
			"description" => esc_html__( "Color of the button line.", "movedo-extension" ),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'underline' ) ),
			"group" => $group_string,
			"std" => 'primary-1',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Gradient Color 1", "movedo-extension" ),
			"param_name" => "button" . $index . "_gradient_color_1",
			"param_holder_class" => "grve-colored-dropdown",
			'edit_field_class' => 'vc_col-sm-6',
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
			"description" => esc_html__( "Select first color for gradient.", "movedo-extension" ),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'gradient' ) ),
			"group" => $group_string,
			"std" => 'primary-1',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Gradient Color 2", "movedo-extension" ),
			"param_name" => "button" . $index . "_gradient_color_2",
			"param_holder_class" => "grve-colored-dropdown",
			'edit_field_class' => 'vc_col-sm-6',
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
			"description" => esc_html__( "Select second color for gradient.", "movedo-extension" ),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'gradient' ) ),
			"group" => $group_string,
			"std" => 'primary-2',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Hover Color", "movedo-extension" ),
			"param_name" => "button" . $index . "_hover_color",
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
			"description" => esc_html__( "Color of the button.", "movedo-extension" ),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'simple', 'outline', 'gradient' ) ),
			"group" => $group_string,
			"std" => 'black',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Size", "movedo-extension" ),
			"param_name" => "button" . $index . "_size",
			"value" => array(
				esc_html__( "Extra Small", "movedo-extension" ) => 'extrasmall',
				esc_html__( "Small", "movedo-extension" ) => 'small',
				esc_html__( "Medium", "movedo-extension" ) => 'medium',
				esc_html__( "Large", "movedo-extension" ) => 'large',
				esc_html__( "Extra Large", "movedo-extension" ) => 'extralarge',
			),
			"description" => '',
			"std" => 'medium',
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Shape", "movedo-extension" ),
			"param_name" => "button" . $index . "_shape",
			"value" => array(
				esc_html__( "Square", "movedo-extension" ) => 'square',
				esc_html__( "Round", "movedo-extension" ) => 'round',
				esc_html__( "Extra Round", "movedo-extension" ) => 'extra-round',
			),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'simple', 'outline', 'gradient' ) ),
			"description" => '',
			"std" => 'square',
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Shadow", "movedo-extension" ),
			"param_name" => "button" . $index . "_shadow",
			"value" => array(
				esc_html__( "None", "movedo-extension" ) => '',
				esc_html__( "Small", "movedo-extension" ) => 'small',
				esc_html__( "Medium", "movedo-extension" ) => 'medium',
				esc_html__( "Large", "movedo-extension" ) => 'large',
			),
			"dependency" => array( 'element' => "button" . $index . "_type", 'value' => array( 'simple', 'gradient' ) ),
			"description" => '',
			"std" => '',
			"group" => $group_string,
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( "Button Link", "movedo-extension" ),
			"param_name" => "button" . $index . "_link",
			"value" => "",
			"description" => esc_html__( "Enter link.", "movedo-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Add icon?", "movedo-extension" ),
			"param_name" => "btn" . $index . "_add_icon",
			"value" => array( esc_html__( "Select if you want to show an icon next to button", "movedo-extension" ) => 'yes' ),
			"group" => $group_string
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
			'param_name' => 'btn' . $index . '_icon_library',
			'description' => esc_html__( 'Select icon library.', 'movedo-extension' ),
			"dependency" => array( 'element' => "btn" . $index . "_add_icon", 'value' => array( 'yes' ) ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_fontawesome',
			'value' => 'fa fa-adjust',
			'settings' => array(
				'emptyIcon' => false,
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_openiconic',
			'value' => 'vc-oi vc-oi-dial',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'openiconic',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_typicons',
			'value' => 'typcn typcn-adjust-brightness',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'typicons',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_entypo',
			'value' => 'entypo-icon entypo-icon-note',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'entypo',
				'iconsPerPage' => 300,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'entypo',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_linecons',
			'value' => 'vc_li vc_li-heart',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'linecons',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_simplelineicons',
			'value' => 'smp-icon-user',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'simplelineicons',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'simplelineicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'movedo-extension' ),
			'param_name' => 'btn' . $index . '_icon_etlineicons',
			'value' => 'et-icon-mobile',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'etlineicons',
				'iconsPerPage' => 100,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'etlineicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
			"group" => $group_string,
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Button class name", "movedo-extension" ),
			"param_name" => "button" . $index . "_class",
			"description" => esc_html__( "If you wish to style your button differently, then use this field to add a class name and then refer to it in your css file.", "movedo-extension" ),
			"group" => $group_string,
		),
	);
	return $btn_params;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
