<?php
/*
 *	Greatives Visual Composer Shortcode Extentions
 *
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */


if ( function_exists( 'vc_add_param' ) ) {

	//Generic css aniation for elements

	$movedo_grve_add_animation = array(
		"type" => "dropdown",
		"heading" => esc_html__("CSS Animation", 'movedo' ),
		"param_name" => "animation",
		"admin_label" => true,
		"value" => array(
			esc_html__( "No", "movedo" ) => '',
			esc_html__( "Fade In", "movedo" ) => "grve-fade-in",
			esc_html__( "Fade In Up", "movedo" ) => "grve-fade-in-up",
			esc_html__( "Fade In Up Big", "movedo" ) => "grve-fade-in-up-big",
			esc_html__( "Fade In Down", "movedo" ) => "grve-fade-in-down",
			esc_html__( "Fade In Down Big", "movedo" ) => "grve-fade-in-down-big",
			esc_html__( "Fade In Left", "movedo" ) => "grve-fade-in-left",
			esc_html__( "Fade In Left Big", "movedo" ) => "grve-fade-in-left-big",
			esc_html__( "Fade In Right", "movedo" ) => "grve-fade-in-right",
			esc_html__( "Fade In Right Big", "movedo" ) => "grve-fade-in-right-big",
			esc_html__( "Zoom In", "movedo" ) => "grve-zoom-in",
		),
		"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", 'movedo' ),
	);

	$movedo_grve_add_clipping_animation = array(
		"type" => "dropdown",
		"heading" => esc_html__("CSS Clipping Animation", 'movedo' ),
		"param_name" => "clipping_animation",
		"admin_label" => true,
		"value" => array(
			esc_html__( "No", "movedo" ) => '',
			esc_html__( "Clipping Up", "movedo" ) => "clipping-up",
			esc_html__( "Clipping Down", "movedo" ) => "clipping-down",
			esc_html__( "Clipping Left", "movedo" ) => "clipping-left",
			esc_html__( "Clipping Right", "movedo" ) => "clipping-right",
			esc_html__( "Colored Clipping Up", "movedo" ) => "colored-clipping-up",
			esc_html__( "Colored Clipping Down", "movedo" ) => "colored-clipping-down",
			esc_html__( "Colored Clipping Left", "movedo" ) => "colored-clipping-left",
			esc_html__( "Colored Clipping Right", "movedo" ) => "colored-clipping-right",
		),
		"description" => esc_html__("Select type of animation if you want this column to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", 'movedo' ),
	);

	$movedo_grve_add_clipping_animation_colors = array(
		"type" => "dropdown",
		"heading" => esc_html__( "Clipping Color", 'movedo' ),
		"param_name" => "clipping_animation_colors",
		"param_holder_class" => "grve-colored-dropdown",
		"value" => array(
			esc_html__( "Dark", 'movedo' ) => 'dark',
			esc_html__( "Light", 'movedo' ) => 'light',
			esc_html__( "Primary 1", 'movedo' ) => 'primary-1',
			esc_html__( "Primary 2", 'movedo' ) => 'primary-2',
			esc_html__( "Primary 3", 'movedo' ) => 'primary-3',
			esc_html__( "Primary 4", 'movedo' ) => 'primary-4',
			esc_html__( "Primary 5", 'movedo' ) => 'primary-5',
			esc_html__( "Primary 6", 'movedo' ) => 'primary-6',
			esc_html__( "Green", 'movedo' ) => 'green',
			esc_html__( "Orange", 'movedo' ) => 'orange',
			esc_html__( "Red", 'movedo' ) => 'red',
			esc_html__( "Blue", 'movedo' ) => 'blue',
			esc_html__( "Aqua", 'movedo' ) => 'aqua',
			esc_html__( "Purple", 'movedo' ) => 'purple',
			esc_html__( "Grey", 'movedo' ) => 'grey',
		),
		"description" => esc_html__( "Select clipping color", 'movedo' ),
		"dependency" => array(
			'element' => 'clipping_animation',
			'value' => array( 'colored-clipping-up', 'colored-clipping-down', 'colored-clipping-left', 'colored-clipping-right' )
		),
	);

	$movedo_grve_add_shadow = array(
		"type" => "dropdown",
		"heading" => esc_html__( "Shadow", 'movedo' ),
		"param_name" => "shadow",
		"value" => array(
			esc_html__( "None", 'movedo' ) => '',
			esc_html__( "Small", "movedo" ) => 'small',
			esc_html__( "Medium", "movedo" ) => 'medium',
			esc_html__( "Large", "movedo" ) => 'large',
		),
		"description" => esc_html__( "Add Shadow", 'movedo' ),
	);

	$movedo_grve_add_animation_delay = array(
		"type" => "textfield",
		"heading" => esc_html__( 'Css Animation Delay', 'movedo' ),
		"param_name" => "animation_delay",
		"value" => '200',
		"description" => esc_html__( "Add delay in milliseconds.", 'movedo' ),
	);

	$movedo_grve_add_animation_duration = array(
		"type" => "dropdown",
		"heading" => esc_html__("CSS Animation Duration", 'movedo' ),
		"param_name" => "animation_duration",
		"value" => array(
			esc_html__( "Very Fast", "movedo" ) => "very-fast",
			esc_html__( "Fast", "movedo" ) => "fast",
			esc_html__( "Normal", "movedo" ) => "normal",
			esc_html__( "Slow", "movedo" ) => "slow",
			esc_html__( "Very Slow", "movedo" ) => "very-slow",
		),
		"std" => 'normal',
		"description" => esc_html__("Select the duration for your animated element.", 'movedo' ),
	);


	$movedo_grve_add_margin_bottom = array(
		"type" => "textfield",
		"heading" => esc_html__( 'Bottom margin', 'movedo' ),
		"param_name" => "margin_bottom",
		"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", 'movedo' ),
	);

	$movedo_grve_add_el_class = array(
		"type" => "textfield",
		"heading" => esc_html__("Extra class name", 'movedo' ),
		"param_name" => "el_class",
		"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'movedo' ),
	);

	$movedo_grve_add_el_wrapper_class = array(
		"type" => "textfield",
		"heading" => esc_html__("Wrapper class name", 'movedo' ),
		"param_name" => "el_wrapper_class",
		"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'movedo' ),
	);

	$movedo_grve_column_width_list = array(
		esc_html__( '1 column - 1/12', 'movedo' ) => '1/12',
		esc_html__( '2 columns - 1/6', 'movedo' ) => '1/6',
		esc_html__( '3 columns - 1/4', 'movedo' ) => '1/4',
		esc_html__( '4 columns - 1/3', 'movedo' ) => '1/3',
		esc_html__( '5 columns - 5/12', 'movedo' ) => '5/12',
		esc_html__( '6 columns - 1/2', 'movedo' ) => '1/2',
		esc_html__( '7 columns - 7/12', 'movedo' ) => '7/12',
		esc_html__( '8 columns - 2/3', 'movedo' ) => '2/3',
		esc_html__( '9 columns - 3/4', 'movedo' ) => '3/4',
		esc_html__( '10 columns - 5/6', 'movedo' ) => '5/6',
		esc_html__( '11 columns - 11/12', 'movedo' ) => '11/12',
		esc_html__( '12 columns - 1/1', 'movedo' ) => '1/1'
	);

	$movedo_grve_column_desktop_hide_list = array(
		esc_html__( 'Default value from width attribute', 'movedo') => '',
		esc_html__( 'Hide', 'movedo' ) => 'hide',
	);

	$movedo_grve_column_width_tablet_list = array(
		esc_html__( 'Default value from width attribute', 'movedo') => '',
		esc_html__( 'Hide', 'movedo' ) => 'hide',
		esc_html__( '1 column - 1/12', 'movedo' ) => '1-12',
		esc_html__( '2 columns - 1/6', 'movedo' ) => '1-6',
		esc_html__( '3 columns - 1/4', 'movedo' ) => '1-4',
		esc_html__( '4 columns - 1/3', 'movedo' ) => '1-3',
		esc_html__( '5 columns - 5/12', 'movedo' ) => '5-12',
		esc_html__( '6 columns - 1/2', 'movedo' ) => '1-2',
		esc_html__( '7 columns - 7/12', 'movedo' ) => '7-12',
		esc_html__( '8 columns - 2/3', 'movedo' ) => '2-3',
		esc_html__( '9 columns - 3/4', 'movedo' ) => '3-4',
		esc_html__( '10 columns - 5/6', 'movedo' ) => '5-6',
		esc_html__( '11 columns - 11/12', 'movedo' ) => '11-12',
		esc_html__( '12 columns - 1/1', 'movedo' ) => '1',
	);

	$movedo_grve_column_width_tablet_sm_list = array(
		esc_html__( 'Inherit from Tablet Landscape', 'movedo') => '',
		esc_html__( 'Hide', 'movedo' ) => 'hide',
		esc_html__( '1 column - 1/12', 'movedo' ) => '1-12',
		esc_html__( '2 columns - 1/6', 'movedo' ) => '1-6',
		esc_html__( '3 columns - 1/4', 'movedo' ) => '1-4',
		esc_html__( '4 columns - 1/3', 'movedo' ) => '1-3',
		esc_html__( '5 columns - 5/12', 'movedo' ) => '5-12',
		esc_html__( '6 columns - 1/2', 'movedo' ) => '1-2',
		esc_html__( '7 columns - 7/12', 'movedo' ) => '7-12',
		esc_html__( '8 columns - 2/3', 'movedo' ) => '2-3',
		esc_html__( '9 columns - 3/4', 'movedo' ) => '3-4',
		esc_html__( '10 columns - 5/6', 'movedo' ) => '5-6',
		esc_html__( '11 columns - 11/12', 'movedo' ) => '11-12',
		esc_html__( '12 columns - 1/1', 'movedo' ) => '1',
	);
	$movedo_grve_column_mobile_width_list = array(
		esc_html__( 'Default value 12 columns - 1/1', 'movedo') => '',
		esc_html__( '3 columns - 1/4', 'movedo' ) => '1-4',
		esc_html__( '4 columns - 1/3', 'movedo' ) => '1-3',
		esc_html__( '6 columns - 1/2', 'movedo' ) => '1-2',
		esc_html__( '12 columns - 1/1', 'movedo' ) => '1',
		esc_html__( 'Hide', 'movedo' ) => 'hide',
	);

	$movedo_grve_column_gap_list = array(
		esc_html__( 'No Gap', 'movedo' ) => 'none',
		esc_html__( '5px', 'movedo' ) => '5',
		esc_html__( '10px', 'movedo' ) => '10',
		esc_html__( '15px', 'movedo' ) => '15',
		esc_html__( '20px', 'movedo' ) => '20',
		esc_html__( '25px', 'movedo' ) => '25',
		esc_html__( '30px', 'movedo' ) => '30',
		esc_html__( '35px', 'movedo' ) => '35',
		esc_html__( '40px', 'movedo' ) => '40',
		esc_html__( '45px', 'movedo' ) => '45',
		esc_html__( '50px', 'movedo' ) => '50',
		esc_html__( '55px', 'movedo' ) => '55',
		esc_html__( '60px', 'movedo' ) => '60',
	);

	$movedo_grve_position_list = array(
		esc_html__( "None", 'movedo' ) => '',
		esc_html__( "1x", 'movedo' ) => '1x',
		esc_html__( "2x", 'movedo' ) => '2x',
		esc_html__( "3x", 'movedo' ) => '3x',
		esc_html__( "4x", 'movedo' ) => '4x',
		esc_html__( "5x", 'movedo' ) => '5x',
		esc_html__( "6x", 'movedo' ) => '6x',
		esc_html__( "-1x", 'movedo' ) => 'minus-1x',
		esc_html__( "-2x", 'movedo' ) => 'minus-2x',
		esc_html__( "-3x", 'movedo' ) => 'minus-3x',
		esc_html__( "-4x", 'movedo' ) => 'minus-4x',
		esc_html__( "-5x", 'movedo' ) => 'minus-5x',
		esc_html__( "-6x", 'movedo' ) => 'minus-6x',
	);

	$movedo_grve_separator_list = array(
		esc_html__( "None", 'movedo' ) => '',
		esc_html__( "Triangle", 'movedo' ) => 'triangle-separator',
		esc_html__( "Large Triangle", 'movedo' ) => 'large-triangle-separator',
		esc_html__( "Curve", 'movedo' ) => 'curve-separator',
		esc_html__( "Curve Left", 'movedo' ) => 'curve-left-separator',
		esc_html__( "Curve Right", 'movedo' ) => 'curve-right-separator',
		esc_html__( "Tilt Left", 'movedo' ) => 'tilt-left-separator',
		esc_html__( "Tilt Right", 'movedo' ) => 'tilt-right-separator',
		esc_html__( "Round Split", 'movedo' ) => 'round-split-separator',
		esc_html__( "Torn Paper", 'movedo' ) => 'torn-paper-separator',
	);

	$movedo_grve_separator_size_list = array(
		esc_html__( "Small", 'movedo' ) => '30px',
		esc_html__( "Medium", 'movedo' ) => '60px',
		esc_html__( "Large", 'movedo' ) => '90px',
		esc_html__( "Extra Large", 'movedo' ) => '120px',
		esc_html__( "Section Height", 'movedo' ) => '100%',
	);

	//Title Headings/Tags
	if( !function_exists( 'movedo_grve_get_heading_tag' ) ) {
		function movedo_grve_get_heading_tag( $std = '' ) {
			return	array(
				"type" => "dropdown",
				"heading" => esc_html__( "Title Tag", "movedo" ),
				"param_name" => "heading_tag",
				"value" => array(
					esc_html__( "h1", "movedo" ) => 'h1',
					esc_html__( "h2", "movedo" ) => 'h2',
					esc_html__( "h3", "movedo" ) => 'h3',
					esc_html__( "h4", "movedo" ) => 'h4',
					esc_html__( "h5", "movedo" ) => 'h5',
					esc_html__( "h6", "movedo" ) => 'h6',
					esc_html__( "div", "movedo" ) => 'div',
				),
				"description" => esc_html__( "Title Tag for SEO", "movedo" ),
				"std" => $std,
				"group" => esc_html__( "Titles & Styles", "movedo" ),
			);
		}
	}

	if( !function_exists( 'movedo_grve_get_heading' ) ) {
		function movedo_grve_get_heading( $std = '' ) {
			return	array(
				"type" => "dropdown",
				"heading" => esc_html__( "Title Size/Typography", "movedo" ),
				"param_name" => "heading",
				"value" => array(
					esc_html__( "h1", "movedo" ) => 'h1',
					esc_html__( "h2", "movedo" ) => 'h2',
					esc_html__( "h3", "movedo" ) => 'h3',
					esc_html__( "h4", "movedo" ) => 'h4',
					esc_html__( "h5", "movedo" ) => 'h5',
					esc_html__( "h6", "movedo" ) => 'h6',
					esc_html__( "Leader Text", "movedo" ) => 'leader-text',
					esc_html__( "Subtitle Text", "movedo" ) => 'subtitle-text',
					esc_html__( "Small Text", "movedo" ) => 'small-text',
					esc_html__( "Link Text", "movedo" ) => 'link-text',
				),
				"description" => esc_html__( "Title size and typography, defined in Theme Options - Typography Options", "movedo" ),
				"std" => $std,
				"group" => esc_html__( "Titles & Styles", "movedo" ),
			);
		}
	}
	if( !function_exists( 'movedo_grve_get_custom_font_family' ) ) {
		function movedo_grve_get_custom_font_family( $std = '' ) {
			return	array(
				"type" => "dropdown",
				"heading" => esc_html__( "Custom Font Family", "movedo" ),
				"param_name" => "custom_font_family",
				"value" => array(
					esc_html__( "Same as Typography", "movedo" ) => '',
					esc_html__( "Custom Font Family 1", "movedo" ) => 'custom-font-1',
					esc_html__( "Custom Font Family 2", "movedo" ) => 'custom-font-2',
					esc_html__( "Custom Font Family 3", "movedo" ) => 'custom-font-3',
					esc_html__( "Custom Font Family 4", "movedo" ) => 'custom-font-4',

				),
				"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo" ),
				"std" => $std,
				"group" => esc_html__( "Titles & Styles", "movedo" ),
			);
		}
	}


	vc_add_param('vc_tta_tabs', movedo_grve_get_heading_tag('h3') );
	vc_add_param('vc_tta_tabs', movedo_grve_get_heading('h6') );
	vc_add_param('vc_tta_tabs', movedo_grve_get_custom_font_family() );
	vc_add_param('vc_tta_tour', movedo_grve_get_heading_tag('h3') );
	vc_add_param('vc_tta_tour', movedo_grve_get_heading('h6') );
	vc_add_param('vc_tta_tour', movedo_grve_get_custom_font_family() );

	vc_add_param( "vc_tta_accordion",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Accordion Style", 'movedo' ),
			"param_name" => "accordion_style",
			"value" => array(
				esc_html__( "Style 1", 'movedo' ) => 'style-1',
				esc_html__( "Style 2", 'movedo' ) => 'style-2',
			),
			"description" => esc_html__( "Select the style for your Accordion", 'movedo' ),
			"group" => esc_html__( "Titles & Styles", "movedo" ),
		)
	);

	vc_add_param('vc_tta_accordion', movedo_grve_get_heading_tag('h3') );
	vc_add_param('vc_tta_accordion', movedo_grve_get_heading('h6') );
	vc_add_param('vc_tta_accordion', movedo_grve_get_custom_font_family() );

	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__('Section ID', 'movedo' ),
			"param_name" => "section_id",
			"description" => esc_html__("If you wish you can type an id to use it as bookmark.", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Font Color', 'movedo' ),
			"param_name" => "font_color",
			"description" => esc_html__("Select font color", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Heading Color", 'movedo' ),
			"param_name" => "heading_color",
			"param_holder_class" => "grve-colored-dropdown",
			"value" => array(
				esc_html__( "Default", 'movedo' ) => '',
				esc_html__( "Dark", 'movedo' ) => 'dark',
				esc_html__( "Light", 'movedo' ) => 'light',
				esc_html__( "Primary 1", 'movedo' ) => 'primary-1',
				esc_html__( "Primary 2", 'movedo' ) => 'primary-2',
				esc_html__( "Primary 3", 'movedo' ) => 'primary-3',
				esc_html__( "Primary 4", 'movedo' ) => 'primary-4',
				esc_html__( "Primary 5", 'movedo' ) => 'primary-5',
				esc_html__( "Primary 6", 'movedo' ) => 'primary-6',
				esc_html__( "Green", 'movedo' ) => 'green',
				esc_html__( "Orange", 'movedo' ) => 'orange',
				esc_html__( "Red", 'movedo' ) => 'red',
				esc_html__( "Blue", 'movedo' ) => 'blue',
				esc_html__( "Aqua", 'movedo' ) => 'aqua',
				esc_html__( "Purple", 'movedo' ) => 'purple',
				esc_html__( "Grey", 'movedo' ) => 'grey',
			),
			"description" => esc_html__( "Select heading color", 'movedo' ),
		)
	);

	vc_add_param( "vc_row", $movedo_grve_add_el_class );
	vc_add_param( "vc_row", $movedo_grve_add_el_wrapper_class );


	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Section Type", 'movedo' ),
			"param_name" => "section_type",
			"value" => array(
				esc_html__( "Full Width Background", 'movedo' ) => 'fullwidth-background',
				esc_html__( "Full Width Element", 'movedo' ) => 'fullwidth',
			),
			"description" => esc_html__( "Select section type", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Section Window Height", 'movedo' ),
			"param_name" => "section_full_height",
			"value" => array(
				esc_html__( "No", 'movedo' ) => 'no',
				esc_html__( "Yes", 'movedo' ) => 'fullheight',
			),
			"description" => esc_html__( "Select if you want your section height to be equal with the window height", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => 'dropdown',
			"heading" => esc_html__( "Background Type", 'movedo' ),
			"param_name" => "bg_type",
			"description" => esc_html__( "Select Background type", 'movedo' ),
			"value" => array(
				esc_html__( "None", 'movedo' ) => '',
				esc_html__( "Color", 'movedo' ) => 'color',
				esc_html__( "Gradient Color", 'movedo' ) => 'gradient',
				esc_html__( "Image", 'movedo' ) => 'image',
				esc_html__( "Hosted Video", 'movedo' ) => 'hosted_video',
				esc_html__( "YouTube Video", 'movedo' ) => 'video',
			),
			"std" => '',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'YouTube link', 'movedo' ),
			'param_name' => 'bg_video_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			// default video url
			'description' => esc_html__( 'Add YouTube link.', 'movedo' ),
			'dependency' => array(
				'element' => 'bg_type',
				'value' => 'video',
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Video Popup Button", 'movedo' ),
			"param_name" => "bg_video_button",
			"value" => array(
				esc_html__( 'None', 'movedo' ) => '',
				esc_html__( 'Devices only', 'movedo' ) => 'device',
				esc_html__( 'Always visible', 'movedo' ) => 'all',
			),
			"description" => esc_html__( "Select video popup button behavior", 'movedo' ),
			'dependency' => array(
				'element' => 'bg_type',
				'value' => 'video',
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Video Button Position", 'movedo' ),
			"param_name" => "bg_video_button_position",
			"value" => array(
				esc_html__( 'Left Top', 'movedo' ) => 'left-top',
				esc_html__( 'Left Bottom', 'movedo' ) => 'left-bottom',
				esc_html__( 'Center Center', 'movedo' ) => 'center-center',
				esc_html__( 'Right Top', 'movedo' ) => 'right-top',
				esc_html__( 'Right Bottom', 'movedo' ) => 'right-bottom',
			),
			"description" => esc_html__( "Select position for video popup", 'movedo' ),
			'dependency' => array(
				'element' => 'bg_video_button',
				'value_not_equal_to' => array( '' )
			),
			"std" => 'center-center',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__( "Custom Background Color", 'movedo' ),
			"param_name" => "bg_color",
			"description" => esc_html__( "Select background color for your row", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'color' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__( "Custom Color 1", 'movedo' ),
			"param_name" => "bg_gradient_color_1",
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'gradient' )
			),
			"std" => 'rgba(3,78,144,0.9)',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__( "Custom Color 2", 'movedo' ),
			"param_name" => "bg_gradient_color_2",
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'gradient' )
			),
			"std" => 'rgba(25,180,215,0.9)',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Gradient Direction", 'movedo' ),
			"param_name" => "bg_gradient_direction",
			"value" => array(
				esc_html__( "Left to Right", 'movedo' ) => '90',
				esc_html__( "Left Top to Right Bottom", 'movedo' ) => '135',
				esc_html__( "Left Bottom to Right Top", 'movedo' ) => '45',
				esc_html__( "Bottom to Top", 'movedo' ) => '180',
			),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'gradient' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "attach_image",
			"heading" => esc_html__('Background Image', 'movedo' ),
			"param_name" => "bg_image",
			"value" => '',
			"description" => esc_html__("Select background image for your row. Used also as fallback for video.", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'image', 'hosted_video', 'video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Video Effect", 'movedo' ),
			"param_name" => "bg_video_effect",
			"value" => array(
				esc_html__( "Default", 'movedo' ) => '',
				esc_html__( "Parallax", 'movedo' ) => 'parallax',
			),
			"description" => esc_html__( "Select the effect of the video", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'hosted_video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Video Parallax Sensor", 'movedo' ),
			"param_name" => "bg_video_parallax_threshold",
			"value" => array(
				esc_html__( "Low", 'movedo' ) => '0.1',
				esc_html__( "Normal", 'movedo' ) => '0.3',
				esc_html__( "High", 'movedo' ) => '0.5',
				esc_html__( "Max", 'movedo' ) => '0.8',
			),
			"description" => esc_html__( "Define the appearance for the parallax effect. Note that you get greater video zoom when you increase the parallax sensor.", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_video_effect',
				'value' => array( 'parallax' )
			),
			"std" => '0.3',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Background Image Type", 'movedo' ),
			"param_name" => "bg_image_type",
			"value" => array(
				esc_html__( "Default", 'movedo' ) => '',
				esc_html__( "Parallax", 'movedo' ) => 'parallax',
				esc_html__( "Horizontal Parallax Left to Right", 'movedo' ) => 'horizontal-parallax-lr',
				esc_html__( "Horizontal Parallax Right to Left", 'movedo' ) => 'horizontal-parallax-rl',
				esc_html__( "Animated", 'movedo' ) => 'animated',
				esc_html__( "Horizontal Animation", 'movedo' ) => 'horizontal',
				esc_html__( "Fixed Image", 'movedo' ) => 'fixed',
				esc_html__( "Image usage as Pattern", 'movedo' ) => 'pattern'
			),
			"description" => esc_html__( "Select how a background image will be displayed", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'image' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Background Image Size", 'movedo' ),
			"param_name" => "bg_image_size",
			"value" => array(
				esc_html__( "--Inherit--", 'movedo' ) => '',
				esc_html__( "Responsive", 'movedo' ) => 'responsive',
				esc_html__( "Extra Extra Large", 'movedo' ) => 'extra-extra-large',
				esc_html__( "Full", 'movedo' ) => 'full',
			),
			"description" => esc_html__( "Select the size of your background image", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'image' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Background Image Vertical Position", 'movedo' ),
			"param_name" => "bg_image_vertical_position",
			"value" => array(
				esc_html__( "Top", 'movedo' ) => 'top',
				esc_html__( "Center", 'movedo' ) => 'center',
				esc_html__( "Bottom", 'movedo' ) => 'bottom',
			),
			"description" => esc_html__( "Select vertical position for background image", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_image_type',
				'value' => array( 'horizontal-parallax-lr', 'horizontal-parallax-rl', 'horizontal' )
			),
			"std" => 'center',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Background  Position", 'movedo' ),
			"param_name" => "bg_position",
			"value" => array(
				esc_html__( 'Left Top', 'movedo' ) => 'left-top',
				esc_html__( 'Left Center', 'movedo' ) => 'left-center',
				esc_html__( 'Left Bottom', 'movedo' ) => 'left-bottom',
				esc_html__( 'Center Top', 'movedo' ) => 'center-top',
				esc_html__( 'Center Center', 'movedo' ) => 'center-center',
				esc_html__( 'Center Bottom', 'movedo' ) => 'center-bottom',
				esc_html__( 'Right Top', 'movedo' ) => 'right-top',
				esc_html__( 'Right Center', 'movedo' ) => 'right-center',
				esc_html__( 'Right Bottom', 'movedo' ) => 'right-bottom',
			),
			"description" => esc_html__( "Select position for background image", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_image_type',
				'value' => array( '', 'animated' )
			),
			"std" => 'center-center',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Background Position ( Tablet Portrait )", 'movedo' ),
			"param_name" => "bg_tablet_sm_position",
			"value" => array(
				esc_html__( 'Inherit from above', 'movedo' ) => '',
				esc_html__( 'Left Top', 'movedo' ) => 'left-top',
				esc_html__( 'Left Center', 'movedo' ) => 'left-center',
				esc_html__( 'Left Bottom', 'movedo' ) => 'left-bottom',
				esc_html__( 'Center Top', 'movedo' ) => 'center-top',
				esc_html__( 'Center Center', 'movedo' ) => 'center-center',
				esc_html__( 'Center Bottom', 'movedo' ) => 'center-bottom',
				esc_html__( 'Right Top', 'movedo' ) => 'right-top',
				esc_html__( 'Right Center', 'movedo' ) => 'right-center',
				esc_html__( 'Right Bottom', 'movedo' ) => 'right-bottom',
			),
			"description" => esc_html__( "Tablet devices with portrait orientation and below.", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_image_type',
				'value' => array( '', 'animated' )
			),
			"std" => '',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Parallax Sensor", 'movedo' ),
			"param_name" => "parallax_threshold",
			"value" => array(
				esc_html__( "Low", 'movedo' ) => '0.1',
				esc_html__( "Normal", 'movedo' ) => '0.3',
				esc_html__( "High", 'movedo' ) => '0.5',
				esc_html__( "Max", 'movedo' ) => '0.8',
			),
			"description" => esc_html__( "Define the appearance for the parallax effect. Note that you get greater image zoom when you increase the parallax sensor.", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_image_type',
				'value' => array( 'parallax', 'horizontal-parallax-lr', 'horizontal-parallax-rl' )
			),
			"std" => '0.3',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__("WebM File URL", 'movedo'),
			"param_name" => "bg_video_webm",
			"description" => esc_html__( "Fill WebM and mp4 format for browser compatibility", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'hosted_video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__( "MP4 File URL", 'movedo' ),
			"param_name" => "bg_video_mp4",
			"description" => esc_html__( "Fill mp4 format URL", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'hosted_video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__( "OGV File URL", 'movedo' ),
			"param_name" => "bg_video_ogv",
			"description" => esc_html__( "Fill OGV format URL ( optional )", 'movedo' ),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'hosted_video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Loop", 'movedo' ),
			"param_name" => "bg_video_loop",
			"value" => array(
				esc_html__( "Yes", 'movedo' ) => 'yes',
				esc_html__( "No", 'movedo' ) => 'no',
			),
			"std" => 'yes',
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'hosted_video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Allow on devices", 'movedo' ),
			"param_name" => "bg_video_device",
			"value" => array(
				esc_html__( "No", 'movedo' ) => 'no',
				esc_html__( "Yes", 'movedo' ) => 'yes',

			),
			"std" => 'no',
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'hosted_video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Pattern overlay", 'movedo'),
			"param_name" => "pattern_overlay",
			"description" => esc_html__( "If selected, a pattern will be added.", 'movedo' ),
			"value" => Array(esc_html__( "Add pattern", 'movedo' ) => 'yes'),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'image', 'hosted_video', 'video' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Color overlay", 'movedo' ),
			"param_name" => "color_overlay",
			"param_holder_class" => "grve-colored-dropdown",
			"value" => array(
				esc_html__( "None", 'movedo' ) => '',
				esc_html__( "Dark", 'movedo' ) => 'dark',
				esc_html__( "Light", 'movedo' ) => 'light',
				esc_html__( "Primary 1", 'movedo' ) => 'primary-1',
				esc_html__( "Primary 2", 'movedo' ) => 'primary-2',
				esc_html__( "Primary 3", 'movedo' ) => 'primary-3',
				esc_html__( "Primary 4", 'movedo' ) => 'primary-4',
				esc_html__( "Primary 5", 'movedo' ) => 'primary-5',
				esc_html__( "Primary 6", 'movedo' ) => 'primary-6',
				esc_html__( "Custom", 'movedo' ) => 'custom',
				esc_html__( "Gradient", 'movedo' ) => 'gradient',
			),
			"dependency" => array(
				'element' => 'bg_type',
				'value' => array( 'image', 'hosted_video', 'video' )
			),
			"description" => esc_html__( "A color overlay for the media", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Custom Color Overlay', 'movedo' ),
			"param_name" => "color_overlay_custom",
			"dependency" => array(
				'element' => 'color_overlay',
				'value' => array( 'custom' )
			),
			"std" => 'rgba(255,255,255,0.1)',
			"description" => esc_html__("Select custom color overlay", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Gradient Color Overlay 1', 'movedo' ),
			"param_name" => "gradient_overlay_custom_1",
			"dependency" => array(
				'element' => 'color_overlay',
				'value' => array( 'gradient' )
			),
			"std" => 'rgba(3,78,144,0.9)',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Gradient Color Overlay 2', 'movedo' ),
			"param_name" => "gradient_overlay_custom_2",
			"dependency" => array(
				'element' => 'color_overlay',
				'value' => array( 'gradient' )
			),
			"std" => 'rgba(25,180,215,0.9)',
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Gradient Direction", 'movedo' ),
			"param_name" => "gradient_overlay_direction",
			"value" => array(
				esc_html__( "Left to Right", 'movedo' ) => '90',
				esc_html__( "Left Top to Right Bottom", 'movedo' ) => '135',
				esc_html__( "Left Bottom to Right Top", 'movedo' ) => '45',
				esc_html__( "Bottom to Top", 'movedo' ) => '180',
			),
			"dependency" => array(
				'element' => 'color_overlay',
				'value' => array( 'gradient' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Opacity overlay", 'movedo' ),
			"param_name" => "opacity_overlay",
			"value" => array( 10, 20, 30 ,40, 50, 60, 70, 80 ,90 ),
			"description" => esc_html__( "Opacity of the overlay", 'movedo' ),
			"dependency" => array(
				'element' => 'color_overlay',
				'value' => array( 'dark', 'light', 'primary-1', 'primary-2', 'primary-3', 'primary-4', 'primary-5', 'primary-6' )
			),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Top padding", 'movedo' ),
			"param_name" => "padding_top_multiplier",
			"value" => array(
				esc_html__( "None", 'movedo' ) => '',
				esc_html__( "1x", 'movedo' ) => '1x',
				esc_html__( "2x", 'movedo' ) => '2x',
				esc_html__( "3x", 'movedo' ) => '3x',
				esc_html__( "4x", 'movedo' ) => '4x',
				esc_html__( "5x", 'movedo' ) => '5x',
				esc_html__( "6x", 'movedo' ) => '6x',
				esc_html__( "Custom", 'movedo' ) => 'custom',
			),
			"std" => '1x',
			"description" => esc_html__( "Select padding top for your section.", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Custom Top padding", 'movedo' ),
			"param_name" => "padding_top",
			"dependency" => array(
				'element' => 'padding_top_multiplier',
				'value' => array( 'custom' )
			),
			"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Bottom padding", 'movedo' ),
			"param_name" => "padding_bottom_multiplier",
			"value" => array(
				esc_html__( "None", 'movedo' ) => '',
				esc_html__( "1x", 'movedo' ) => '1x',
				esc_html__( "2x", 'movedo' ) => '2x',
				esc_html__( "3x", 'movedo' ) => '3x',
				esc_html__( "4x", 'movedo' ) => '4x',
				esc_html__( "5x", 'movedo' ) => '5x',
				esc_html__( "6x", 'movedo' ) => '6x',
				esc_html__( "Custom", 'movedo' ) => 'custom',
			),
			"std" => '1x',
			"description" => esc_html__( "Select padding bottom for your section.", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Custom Bottom padding", 'movedo' ),
			"param_name" => "padding_bottom",
			"dependency" => array(
				'element' => 'padding_bottom_multiplier',
				'value' => array( 'custom' )
			),
			"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", 'movedo' ),
			"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
		"type" => "textfield",
		"heading" => esc_html__( 'Bottom margin', 'movedo' ),
		"param_name" => "margin_bottom",
		"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", 'movedo' ),
		"group" => esc_html__( "Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Columns Gap", 'movedo' ),
			"param_name" => "columns_gap",
			'value' => $movedo_grve_column_gap_list,
			"description" => esc_html__( "Select gap between columns in row.", 'movedo' ),
			"std" => '30',
			"group" => esc_html__( "Inner columns", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Equal Column Height", 'movedo' ),
			"param_name" => "equal_column_height",
			"value" => array(
				esc_html__( "None", 'movedo' ) => 'none',
				esc_html__( "Equal Height Columns", 'movedo' ) => 'equal-column',
				esc_html__( "Equal Height Columns and Middle Content", 'movedo' ) => 'middle-content',
			),
			"description" => esc_html__( "Recommended for multiple columns with different background colors. Additionally you can set your columns content in middle. If you need some paddings in your columns, please place them only in the column with the largest content.", 'movedo' ),
			"group" => esc_html__( "Inner columns", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Desktop Visibility", 'movedo'),
			"param_name" => "desktop_visibility",
			"description" => esc_html__( "If selected, row will be hidden on desktops/laptops.", 'movedo' ),
			"value" => Array(esc_html__( "Hide", 'movedo' ) => 'hide'),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Tablet Landscape Visibility", 'movedo'),
			"param_name" => "tablet_visibility",
			"description" => esc_html__( "If selected, row will be hidden on tablet devices with landscape orientation.", 'movedo' ),
			"value" => Array(esc_html__( "Hide", 'movedo' ) => 'hide'),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Tablet Portrait Visibility", 'movedo'),
			"param_name" => "tablet_sm_visibility",
			"description" => esc_html__( "If selected, row will be hidden on tablet devices with portrait orientation.", 'movedo' ),
			"value" => Array(esc_html__( "Hide", 'movedo' ) => 'hide'),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);
	vc_add_param( "vc_row",
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Mobile Visibility", 'movedo'),
			"param_name" => "mobile_visibility",
			"description" => esc_html__( "If selected, row will be hidden on mobile devices.", 'movedo' ),
			"value" => Array(esc_html__( "Hide", 'movedo' ) => 'hide'),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Landscape Equal Column Height", 'movedo' ),
			"param_name" => "tablet_landscape_equal_column_height",
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "None", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'equal_column_height',
				'value_not_equal_to' => array( 'none' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Equal Column Height.", 'movedo' ),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Portrait Equal Column Height", 'movedo' ),
			"param_name" => "tablet_portrait_equal_column_height",
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "None", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'equal_column_height',
				'value_not_equal_to' => array( 'none' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Equal Column Height.", 'movedo' ),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Mobile Equal Column Height", 'movedo' ),
			"param_name" => "mobile_equal_column_height",
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "None", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'equal_column_height',
				'value_not_equal_to' => array( 'none' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Equal Column Height.", 'movedo' ),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Landscape Window Fullheight", 'movedo' ),
			"param_name" => "tablet_landscape_full_height",
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "No", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'section_full_height',
				'value' => array( 'fullheight' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Window Fullheight.", 'movedo' ),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Portrait Window Fullheight", 'movedo' ),
			"param_name" => "tablet_portrait_full_height",
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "No", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'section_full_height',
				'value' => array( 'fullheight' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Window Fullheight.", 'movedo' ),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Mobile Window Fullheight", 'movedo' ),
			"param_name" => "mobile_full_height",
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "No", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'section_full_height',
				'value' => array( 'fullheight' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Window Fullheight.", 'movedo' ),
			'group' => esc_html__( "Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => 'dropdown',
			"heading" => esc_html__( "Top Separator", 'movedo' ),
			"param_name" => "separator_top",
			"description" => esc_html__( "Select Top Separator type", 'movedo' ),
			"value" => $movedo_grve_separator_list,
			"group" => esc_html__( "Separators", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => 'dropdown',
			"heading" => esc_html__( "Top Separator Size", 'movedo' ),
			"param_name" => "separator_top_size",
			"description" => esc_html__( "Select Top Separator size", 'movedo' ),
			"value" => $movedo_grve_separator_size_list,
			"std" => '90px',
			"dependency" => array(
				'element' => 'separator_top',
				'value_not_equal_to' => array( '' )
			),
			"group" => esc_html__( "Separators", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Top Separator Color', 'movedo' ),
			"param_name" => "separator_top_color",
			"dependency" => array(
				'element' => 'separator_top',
				'value_not_equal_to' => array( '' )
			),
			"std" => '#ffffff',
			"description" => esc_html__("Select top separator color", 'movedo' ),
			"group" => esc_html__( "Separators", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => 'dropdown',
			"heading" => esc_html__( "Bottom Separator", 'movedo' ),
			"param_name" => "separator_bottom",
			"description" => esc_html__( "Select Bottom Separator type", 'movedo' ),
			"value" => $movedo_grve_separator_list,
			"group" => esc_html__( "Separators", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => 'dropdown',
			"heading" => esc_html__( "Bottom Separator Size", 'movedo' ),
			"param_name" => "separator_bottom_size",
			"description" => esc_html__( "Select Bottom Separator size", 'movedo' ),
			"value" => $movedo_grve_separator_size_list,
			"std" => '90px',
			"dependency" => array(
				'element' => 'separator_bottom',
				'value_not_equal_to' => array( '' )
			),
			"group" => esc_html__( "Separators", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Bottom Separator Color', 'movedo' ),
			"param_name" => "separator_bottom_color",
			"dependency" => array(
				'element' => 'separator_bottom',
				'value_not_equal_to' => array( '' )
			),
			"std" => '#ffffff',
			"description" => esc_html__("Select bottom separator color", 'movedo' ),
			"group" => esc_html__( "Separators", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Header Style", 'movedo' ),
			"param_name" => "scroll_header_style",
			"value" => array(
				esc_html__( "Dark", 'movedo' ) => 'dark',
				esc_html__( "Light", 'movedo' ) => 'light',
				esc_html__( "Default", 'movedo' ) => 'default',
			),
			"std" => 'dark',
			"description" => esc_html__( "Select header style", 'movedo' ),
			"group" => esc_html__( "Scrolling Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_row",
		array(
			"type" => "textfield",
			"heading" => esc_html__('Scrolling Section Title', 'movedo' ),
			"param_name" => "scroll_section_title",
			"description" => esc_html__("If you wish you can type a title for the side dot navigation.", 'movedo' ),
			"group" => esc_html__( "Scrolling Section Options", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Vertical Content Position", 'movedo' ),
			"param_name" => "vertical_content_position",
			"value" => array(
				esc_html__( "Top", 'movedo' ) => 'top',
				esc_html__( "Middle", 'movedo' ) => 'middle',
				esc_html__( "Bottom", 'movedo' ) => 'bottom',
			),
			"description" => esc_html__( "Select the vertical position of the content. Note this setting is affected only if you have set Equal Height Columns under: Row Settings > Inner Columns > Equal Column Height.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Column Effect", 'movedo' ),
			"param_name" => "column_effect",
			"value" => array(
				esc_html__( "None", 'movedo' ) => 'none',
				esc_html__( "Vertical Parallax", 'movedo' ) => 'vertical-parallax',
				esc_html__( "Mouse Move X and Y", 'movedo' ) => 'mouse-move-x-y',
				esc_html__( "Mouse Move X", 'movedo' ) => 'mouse-move-x',
				esc_html__( "Mouse Move Y", 'movedo' ) => 'mouse-move-y',
			),
			"description" => esc_html__( "Select column effect behaviour. Notice that the Mouse Move Effect does not affect on devices.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Column Effect Sensitive", 'movedo' ),
			"param_name" => "column_effect_sensitive",
			"value" => array(
				esc_html__( "Low", 'movedo' ) => 'low',
				esc_html__( "Normal", 'movedo' ) => 'normal',
				esc_html__( "High", 'movedo' ) => 'high',
				esc_html__( "Max", 'movedo' ) => 'max',
			),
			"dependency" => array(
				'element' => 'column_effect',
				'value' => array( 'mouse-move-x-y', 'mouse-move-x', 'mouse-move-y' )
			),
			"description" => esc_html__( "Select column effect sensitive", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Column Effect Total Range", 'movedo' ),
			"param_name" => "column_effect_limit",
			"value" => array(
				esc_html__( "1x", 'movedo' ) => '1x',
				esc_html__( "2x", 'movedo' ) => '2x',
				esc_html__( "3x", 'movedo' ) => '3x',
				esc_html__( "4x", 'movedo' ) => '4x',
				esc_html__( "5x", 'movedo' ) => '5x',
				esc_html__( "6x", 'movedo' ) => '6x',
				esc_html__( "None", 'movedo' ) => 'none',
			),
			"dependency" => array(
				'element' => 'column_effect',
				'value_not_equal_to' => array( 'none' )
			),
			"description" => esc_html__( "Select column effect total range of motion. None allows column to move with complete freedom.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Column Effect Invert Motion", 'movedo' ),
			"param_name" => "column_effect_invert",
			"value" => array(
				esc_html__( "No", 'movedo' ) => 'false',
				esc_html__( "Yes", 'movedo' ) => 'true',
			),
			"dependency" => array(
				'element' => 'column_effect',
				'value_not_equal_to' => array( 'none' )
			),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Change column position", 'movedo' ),
			"param_name" => "column_custom_position",
			"value" => array(
				esc_html__( "No", 'movedo' ) => 'no',
				esc_html__( "Yes", 'movedo' ) => 'yes',
			),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( 'Top Position', 'movedo' ),
			"param_name" => "position_top",
			"value" => $movedo_grve_position_list,
			"description" => esc_html__( "Select the top position of the column.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( 'Bottom Position', 'movedo' ),
			"param_name" => "position_bottom",
			"value" => $movedo_grve_position_list,
			"description" => esc_html__( "Select the bottom position of the column.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Left Position", 'movedo' ),
			"param_name" => "position_left",
			"value" => $movedo_grve_position_list,
			"description" => esc_html__( "Select the left position of the column.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( 'Right Position', 'movedo' ),
			"param_name" => "position_right",
			"value" => $movedo_grve_position_list,
			"description" => esc_html__( "Select the right position of the column.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "textfield",
			"heading" => esc_html__( 'Z index', 'movedo' ),
			"param_name" => "z_index",
			"description" => esc_html__( "Enter a number for column's z-index. Default value is 1, recommended to be larger than this.", 'movedo' ),
			'group' => esc_html__( 'Effect & Positions', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Width", 'movedo' ),
			'param_name' => 'width',
			'value' => $movedo_grve_column_width_list,
			'description' => esc_html__( "Select column width.", 'movedo' ),
			'std' => '1/1',
			'group' => esc_html__( "Width & Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Window Height", 'movedo' ),
			'param_name' => 'column_fullheight',
			"value" => array(
				esc_html__( "No", 'movedo' ) => '',
				esc_html__( "Yes", 'movedo' ) => 'fullheight',
			),
			"description" => esc_html__( "Select if you want your Column height to be equal with the window height", 'movedo' ),
			'group' => esc_html__( "Width & Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Desktop", 'movedo' ),
			"param_name" => "desktop_hide",
			"value" => $movedo_grve_column_desktop_hide_list,
			"description" => esc_html__( "Responsive column on desktops/laptops.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);
	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Landscape", 'movedo' ),
			"param_name" => "tablet_width",
			"value" => $movedo_grve_column_width_tablet_list,
			"description" => esc_html__( "Responsive column on tablet devices with landscape orientation.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Portrait", 'movedo' ),
			"param_name" => "tablet_sm_width",
			"value" => $movedo_grve_column_width_tablet_sm_list,
			"description" => esc_html__( "Responsive column on tablet devices with portrait orientation.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Mobile", 'movedo' ),
			"param_name" => "mobile_width",
			"value" => $movedo_grve_column_mobile_width_list,
			"description" => esc_html__( "Responsive column on mobile devices.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Tablet Landscape Window Height", 'movedo' ),
			'param_name' => 'tablet_landscape_column_fullheight',
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "None", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'column_fullheight',
				'value' => array( 'fullheight' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Window Height.", 'movedo' ),
			'group' => esc_html__( "Width & Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Tablet Portrait Window Height", 'movedo' ),
			'param_name' => 'tablet_portrait_column_fullheight',
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "None", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'column_fullheight',
				'value' => array( 'fullheight' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Window Height.", 'movedo' ),
			'group' => esc_html__( "Width & Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Mobile Window Height", 'movedo' ),
			'param_name' => 'mobile_column_fullheight',
			"value" => array(
				esc_html__( "Default values", 'movedo' ) => '',
				esc_html__( "None", 'movedo' ) => 'false',
			),
			"dependency" => array(
				'element' => 'column_fullheight',
				'value' => array( 'fullheight' )
			),
			"description" => esc_html__( "Select if you wish to keep or disable the Window Height.", 'movedo' ),
			'group' => esc_html__( "Width & Responsiveness", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Landscape Effect", 'movedo' ),
			"param_name" => "tablet_landscape_column_effect",
			"value" => array(
				esc_html__( "Default values defined on column effect", 'movedo' ) => '',
				esc_html__( "Disable Effect", 'movedo' ) => 'none',
			),
			"description" => esc_html__( "Define your column effect for the Tablet Landscape.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
			"dependency" => array(
				'element' => 'column_effect',
				'value' => array( 'vertical-parallax' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Portrait Effect", 'movedo' ),
			"param_name" => "tablet_portrait_column_effect",
			"value" => array(
				esc_html__( "Default values defined on column effect", 'movedo' ) => '',
				esc_html__( "Disable Effect", 'movedo' ) => 'none',
			),
			"description" => esc_html__( "Define your column effect for the Tablet Portrait.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
			"dependency" => array(
				'element' => 'column_effect',
				'value' => array( 'vertical-parallax' )
			),
			"std" => 'none',
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Mobile Effect", 'movedo' ),
			"param_name" => "mobile_column_effect",
			"value" => array(
				esc_html__( "Default values defined on column effect", 'movedo' ) => '',
				esc_html__( "Disable Effect", 'movedo' ) => 'none',
			),
			"description" => esc_html__( "Define your column effect for the Mobile.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
			"dependency" => array(
				'element' => 'column_effect',
				'value' => array( 'vertical-parallax' )
			),
			"std" => 'none',
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Landscape Column Positions", 'movedo' ),
			"param_name" => "tablet_landscape_column_positions",
			"value" => array(
				esc_html__( "Default values defined on column positions", 'movedo' ) => '',
				esc_html__( "Reset Positions", 'movedo' ) => 'none',
			),
			"description" => esc_html__( "Define your column positions for the Tablet Landscape.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Portrait Column Positions", 'movedo' ),
			"param_name" => "tablet_portrait_column_positions",
			"value" => array(
				esc_html__( "Default values defined on column positions", 'movedo' ) => '',
				esc_html__( "Reset Positions", 'movedo' ) => 'none',
			),
			"description" => esc_html__( "Define your column positions for the Tablet Portrait.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Mobile Column Positions", 'movedo' ),
			"param_name" => "mobile_column_positions",
			"value" => array(
				esc_html__( "Default values defined on column positions", 'movedo' ) => '',
				esc_html__( "Reset Positions", 'movedo' ) => 'none',
			),
			"description" => esc_html__( "Define your column positions for the Mobile.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
			"dependency" => array(
				'element' => 'column_custom_position',
				'value' => array( 'yes' )
			),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "colorpicker",
			"heading" => esc_html__('Font Color', 'movedo' ),
			"param_name" => "font_color",
			"description" => esc_html__("Select font color", 'movedo' ),
		)
	);

	vc_add_param( "vc_column",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Heading Color", 'movedo' ),
			"param_name" => "heading_color",
			"param_holder_class" => "grve-colored-dropdown",
			"value" => array(
				esc_html__( "Default", 'movedo' ) => '',
				esc_html__( "Dark", 'movedo' ) => 'dark',
				esc_html__( "Light", 'movedo' ) => 'light',
				esc_html__( "Primary 1", 'movedo' ) => 'primary-1',
				esc_html__( "Primary 2", 'movedo' ) => 'primary-2',
				esc_html__( "Primary 3", 'movedo' ) => 'primary-3',
				esc_html__( "Primary 4", 'movedo' ) => 'primary-4',
				esc_html__( "Primary 5", 'movedo' ) => 'primary-5',
				esc_html__( "Primary 6", 'movedo' ) => 'primary-6',
				esc_html__( "Green", 'movedo' ) => 'green',
				esc_html__( "Orange", 'movedo' ) => 'orange',
				esc_html__( "Red", 'movedo' ) => 'red',
				esc_html__( "Blue", 'movedo' ) => 'blue',
				esc_html__( "Aqua", 'movedo' ) => 'aqua',
				esc_html__( "Purple", 'movedo' ) => 'purple',
				esc_html__( "Grey", 'movedo' ) => 'grey',
			),
			"description" => esc_html__( "Select heading color", 'movedo' ),
		)
	);

	vc_add_param( "vc_column", $movedo_grve_add_shadow );
	vc_add_param( "vc_column", $movedo_grve_add_clipping_animation );
	vc_add_param( "vc_column", $movedo_grve_add_clipping_animation_colors );
	vc_add_param( "vc_column", $movedo_grve_add_animation_delay );

	vc_add_param( "vc_column", $movedo_grve_add_el_class );
	vc_add_param( "vc_column", $movedo_grve_add_el_wrapper_class );


	vc_add_param( "vc_column_inner", $movedo_grve_add_el_class );
	vc_add_param( "vc_column_inner", $movedo_grve_add_el_wrapper_class );

	vc_add_param( "vc_column_inner",
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Width", 'movedo' ),
			'param_name' => 'width',
			'value' => $movedo_grve_column_width_list,
			'group' => esc_html__( "Width & Responsiveness", 'movedo' ),
			'description' => esc_html__( "Select column width.", 'movedo' ),
			'std' => '1/1'
		)
	);
	vc_add_param( "vc_column_inner",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Desktop", 'movedo' ),
			"param_name" => "desktop_hide",
			"value" => $movedo_grve_column_desktop_hide_list,
			"description" => esc_html__( "Responsive column on desktops/laptops.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);
	vc_add_param( "vc_column_inner",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Landscape", 'movedo' ),
			"param_name" => "tablet_width",
			"value" => $movedo_grve_column_width_tablet_list,
			"description" => esc_html__( "Responsive column on tablet devices with landscape orientation.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);
	vc_add_param( "vc_column_inner",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Tablet Portrait", 'movedo' ),
			"param_name" => "tablet_sm_width",
			"value" => $movedo_grve_column_width_tablet_sm_list,
			"description" => esc_html__( "Responsive column on tablet devices with portrait orientation.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);
	vc_add_param( "vc_column_inner",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Mobile", 'movedo' ),
			"param_name" => "mobile_width",
			"value" => $movedo_grve_column_mobile_width_list,
			"description" => esc_html__( "Responsive column on mobile devices.", 'movedo' ),
			'group' => esc_html__( 'Width & Responsiveness', 'movedo' ),
		)
	);

	vc_add_param( "vc_widget_sidebar",
		array(
			'type' => 'hidden',
			'param_name' => 'title',
			'value' => '',
		)
	);

	if ( defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '4.6', '>=') ) {

		vc_add_param( "vc_tta_tabs",
			array(
				'type' => 'hidden',
				'param_name' => 'no_fill_content_area',
				'value' => '',
			)
		);

		vc_add_param( "vc_tta_tabs",
			array(
				'type' => 'hidden',
				'param_name' => 'tab_position',
				'value' => 'top',
			)
		);

		vc_add_param( "vc_tta_accordion",
			array(
				'type' => 'hidden',
				'param_name' => 'no_fill',
				'value' => '',
			)
		);

		vc_add_param( "vc_tta_tour",
			array(
				'type' => 'hidden',
				'param_name' => 'no_fill_content_area',
				'value' => '',
			)
		);
	}

	vc_add_param( "vc_column_text",
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Text Style", 'movedo' ),
			"param_name" => "text_style",
			"value" => array(
				esc_html__( "None", 'movedo' ) => '',
				esc_html__( "Leader", 'movedo' ) => 'leader-text',
				esc_html__( "Subtitle", 'movedo' ) => 'subtitle',
			),
			"description" => esc_html__( "Select your text style", 'movedo' ),
		)
	);
	vc_add_param( "vc_column_text", $movedo_grve_add_animation );
	vc_add_param( "vc_column_text", $movedo_grve_add_animation_delay );
	vc_add_param( "vc_column_text", $movedo_grve_add_animation_duration );


}

//Omit closing PHP tag to avoid accidental whitespace output errors.
