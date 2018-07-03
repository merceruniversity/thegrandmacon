<?php
/*
*	Helper Functions for meta options ( Post / Page / Portfolio / Product )
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


/**
 * Functions to print global metaboxes
 */
add_action( 'add_meta_boxes', 'movedo_grve_generic_options_add_custom_boxes' );
add_action( 'save_post', 'movedo_grve_generic_options_save_postdata', 10, 2 );

function movedo_grve_generic_options_add_custom_boxes() {

	if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
		return;
	}

	//General Page Options
	add_meta_box(
		'grve-page-options',
		esc_html__( 'Page Options', 'movedo' ),
		'movedo_grve_page_options_box',
		'page'
	);
	add_meta_box(
		'grve-page-options',
		esc_html__( 'Post Options', 'movedo' ),
		'movedo_grve_page_options_box',
		'post'
	);

	add_meta_box(
		'grve-page-options',
		esc_html__( 'Portfolio Options', 'movedo' ),
		'movedo_grve_page_options_box',
		'portfolio'
	);

	add_meta_box(
		'grve-page-options',
		esc_html__( 'Product Options', 'movedo' ),
		'movedo_grve_page_options_box',
		'product'
	);

	add_meta_box(
		'grve-page-options',
		esc_html__( 'Events Options', 'movedo' ),
		'movedo_grve_page_options_box',
		'tribe_events'
	);

	$feature_section_post_types = movedo_grve_option( 'feature_section_post_types');

	if ( !empty( $feature_section_post_types ) ) {

		foreach ( $feature_section_post_types as $key => $value ) {

			if ( 'attachment' != $value ) {

				add_meta_box(
					'_movedo_grve_page_feature_section',
					esc_html__( 'Feature Section', 'movedo' ),
					'movedo_grve_page_feature_section_box',
					$value,
					'advanced',
					'low'
				);

			}

		}
	}

}

/**
 * Page Options Metabox
 */
function movedo_grve_page_options_box( $post ) {

	global $movedo_grve_button_color_selection;

	$post_type = get_post_type( $post->ID );
	$movedo_grve_page_title_selection = array(
		'' => esc_html__( '-- Inherit --', 'movedo' ),
		'custom' => esc_html__( 'Custom Advanced Title', 'movedo' ),
	);
	$movedo_grve_area_colors_info = esc_html__( 'Inherit : Appearance - Customize', 'movedo' );

	$movedo_grve_theme_options_info_text_empty = $movedo_grve_desc_info = "";

	switch( $post_type ) {
		case 'tribe_events':
			$movedo_grve_theme_options_info = esc_html__( 'Inherit : Theme Options - Events Calendar Options - Single Event Settings.', 'movedo' );
		break;
		case 'portfolio':
			$movedo_grve_theme_options_info = esc_html__( 'Inherit : Theme Options - Portfolio Options.', 'movedo' );
			$movedo_grve_theme_options_info_text_empty =  esc_html__('If empty, text is configured from: Theme Options - Portfolio Options.', 'movedo' );
			$movedo_grve_desc_info = esc_html__( 'Enter your portfolio description.', 'movedo' );
		break;
		case 'post':
			$movedo_grve_theme_options_info = esc_html__( 'Inherit : Theme Options - Blog Options - Single Post.', 'movedo' );
			$movedo_grve_theme_options_info_text_empty =  esc_html__('If empty, text is configured from: Theme Options - Blog Options - Single Post.', 'movedo' );
			$movedo_grve_desc_info = esc_html__( 'Enter your post description( Not available in Simple Title ).', 'movedo' );
			$movedo_grve_page_title_selection = array(
				'' => esc_html__( '-- Inherit --', 'movedo' ),
				'custom' => esc_html__( 'Custom Advanced Title', 'movedo' ),
				'simple' => esc_html__( 'Simple Title', 'movedo' ),
			);
		break;
		case 'product':
			$movedo_grve_area_colors_info = esc_html__( 'Inherit : Appearance - Customize - Colors - Shop/Product - Colors - Product Area.', 'movedo' );
			$movedo_grve_theme_options_info = esc_html__( 'Inherit : Theme Options - WooCommerce Options - Single Product.', 'movedo' );
			$movedo_grve_theme_options_info_text_empty =  esc_html__('If empty, text is configured from: Theme Options - WooCommerce Options - Single Product.', 'movedo' );
			$movedo_grve_desc_info = esc_html__( 'Enter your product description( Not available in Simple Title ).', 'movedo' );
			$movedo_grve_page_title_selection = array(
				'' => esc_html__( '-- Inherit --', 'movedo' ),
				'custom' => esc_html__( 'Custom Advanced Title', 'movedo' ),
				'simple' => esc_html__( 'Simple Title', 'movedo' ),
			);
		break;
		case 'page':
		default:
			$movedo_grve_theme_options_info = esc_html__( 'Inherit : Theme Options - Page Options.', 'movedo' );
			$movedo_grve_theme_options_info_text_empty =  esc_html__('If empty, text is configured from: Theme Options - Page Options.', 'movedo' );
			$movedo_grve_desc_info = esc_html__( 'Enter your page description.', 'movedo' );
		break;
	}

	$movedo_grve_page_padding_selection = array(
		'' => esc_html__( '-- Inherit --', 'movedo' ),
		'none' => esc_html__( 'None', 'movedo' ),
		'1x' => esc_html__( '1x', 'movedo' ),
		'2x' => esc_html__( '2x', 'movedo' ),
		'3x' => esc_html__( '3x', 'movedo' ),
		'4x' => esc_html__( '4x', 'movedo' ),
		'5x' => esc_html__( '5x', 'movedo' ),
		'6x' => esc_html__( '6x', 'movedo' ),
	);

	wp_nonce_field( 'movedo_grve_nonce_page_save', '_movedo_grve_nonce_page_save' );


	$movedo_grve_custom_title_options = get_post_meta( $post->ID, '_movedo_grve_custom_title_options', true );
	$movedo_grve_description = get_post_meta( $post->ID, '_movedo_grve_description', true );


	//Product Area
	$movedo_grve_area_colors = get_post_meta( $post->ID, '_movedo_grve_area_colors', true );
	$movedo_grve_area_section_type = get_post_meta( $post->ID, '_movedo_grve_area_section_type', true );
	$movedo_grve_area_padding_top_multiplier = get_post_meta( $post->ID, '_movedo_grve_area_padding_top_multiplier', true );
	$movedo_grve_area_padding_bottom_multiplier = get_post_meta( $post->ID, '_movedo_grve_area_padding_bottom_multiplier', true );
	$movedo_grve_area_image_id = get_post_meta( $post->ID, '_movedo_grve_area_image_id', true );


	//Layout Fields
	$movedo_grve_padding_top = get_post_meta( $post->ID, '_movedo_grve_padding_top', true );
	$movedo_grve_padding_bottom = get_post_meta( $post->ID, '_movedo_grve_padding_bottom', true );
	$movedo_grve_layout = get_post_meta( $post->ID, '_movedo_grve_layout', true );
	$movedo_grve_sidebar = get_post_meta( $post->ID, '_movedo_grve_sidebar', true );
	$movedo_grve_fixed_sidebar = get_post_meta( $post->ID, '_movedo_grve_fixed_sidebar', true );
	$movedo_grve_post_content_width = get_post_meta( $post->ID, '_movedo_grve_post_content_width', true ); //Post/Product/Event Only

	//Sliding Area
	$movedo_grve_sidearea_visibility = get_post_meta( $post->ID, '_movedo_grve_sidearea_visibility', true );
	$movedo_grve_sidearea_sidebar = get_post_meta( $post->ID, '_movedo_grve_sidearea_sidebar', true );

	//Scrolling Page
	$movedo_grve_scrolling_page = get_post_meta( $post->ID, '_movedo_grve_scrolling_page', true );
	$movedo_grve_responsive_scrolling = get_post_meta( $post->ID, '_movedo_grve_responsive_scrolling', true );
	$movedo_grve_scrolling_lock_anchors = get_post_meta( $post->ID, '_movedo_grve_scrolling_lock_anchors', true );
	$movedo_grve_scrolling_direction = get_post_meta( $post->ID, '_movedo_grve_scrolling_direction', true );
	$movedo_grve_scrolling_loop = get_post_meta( $post->ID, '_movedo_grve_scrolling_loop', true );
	$movedo_grve_scrolling_speed = get_post_meta( $post->ID, '_movedo_grve_scrolling_speed', true );

	//Header - Main Menu Fields
	$movedo_grve_header_overlapping = get_post_meta( $post->ID, '_movedo_grve_header_overlapping', true );
	$movedo_grve_header_style = get_post_meta( $post->ID, '_movedo_grve_header_style', true );
	$movedo_grve_main_navigation_menu = get_post_meta( $post->ID, '_movedo_grve_main_navigation_menu', true );
	$movedo_grve_responsive_navigation_menu = get_post_meta( $post->ID, '_movedo_grve_responsive_navigation_menu', true );
	$movedo_grve_sticky_header_type = get_post_meta( $post->ID, '_movedo_grve_sticky_header_type', true );
	$movedo_grve_menu_type = get_post_meta( $post->ID, '_movedo_grve_menu_type', true );
	$movedo_grve_safe_button_area = get_post_meta( $post->ID, '_movedo_grve_safe_button_area', true );
	$movedo_grve_responsive_header_overlapping = get_post_meta( $post->ID, '_movedo_grve_responsive_header_overlapping', true );

	//Extras
	$movedo_grve_details_title = get_post_meta( $post->ID, '_movedo_grve_details_title', true ); //Portfolio Only
	$movedo_grve_details = get_post_meta( $post->ID, '_movedo_grve_details', true ); //Portfolio Only
	$movedo_grve_details_link_text = get_post_meta( $post->ID, '_movedo_grve_details_link_text', true ); //Portfolio Only
	$movedo_grve_details_link_url = get_post_meta( $post->ID, '_movedo_grve_details_link_url', true ); //Portfolio Only
	$movedo_grve_details_link_new_window = get_post_meta( $post->ID, '_movedo_grve_details_link_new_window', true ); //Portfolio Only
	$movedo_grve_details_link_extra_class = get_post_meta( $post->ID, '_movedo_grve_details_link_extra_class', true ); //Portfolio Only
	$movedo_grve_backlink_id = get_post_meta( $post->ID, '_movedo_grve_backlink_id', true ); //Portfolio Only
	$movedo_grve_anchor_navigation_menu = get_post_meta( $post->ID, '_movedo_grve_anchor_navigation_menu', true );
	$movedo_grve_theme_loader = get_post_meta( $post->ID, '_movedo_grve_theme_loader', true );

	//Visibility Fields
	$movedo_grve_disable_top_bar = get_post_meta( $post->ID, '_movedo_grve_disable_top_bar', true );
	$movedo_grve_disable_logo = get_post_meta( $post->ID, '_movedo_grve_disable_logo', true );
	$movedo_grve_disable_menu = get_post_meta( $post->ID, '_movedo_grve_disable_menu', true );
	$movedo_grve_disable_menu_items = get_post_meta( $post->ID, '_movedo_grve_disable_menu_items', true );
	$movedo_grve_disable_header_text = get_post_meta( $post->ID, '_movedo_grve_disable_header_text', true );
	$movedo_grve_disable_breadcrumbs = get_post_meta( $post->ID, '_movedo_grve_disable_breadcrumbs', true );
	$movedo_grve_disable_title = get_post_meta( $post->ID, '_movedo_grve_disable_title', true );
	$movedo_grve_disable_media = get_post_meta( $post->ID, '_movedo_grve_disable_media', true ); //Post Only
	$movedo_grve_disable_content = get_post_meta( $post->ID, '_movedo_grve_disable_content', true ); //Page Only
	$movedo_grve_disable_recent_entries = get_post_meta( $post->ID, '_movedo_grve_disable_recent_entries', true );//Portfolio Only
	$movedo_grve_disable_back_to_top = get_post_meta( $post->ID, '_movedo_grve_disable_back_to_top', true );

	$movedo_grve_bottom_bar_area = get_post_meta( $post->ID, '_movedo_grve_bottom_bar_area', true );
	$movedo_grve_footer_widgets_visibility = get_post_meta( $post->ID, '_movedo_grve_footer_widgets_visibility', true );
	$movedo_grve_footer_bar_visibility = get_post_meta( $post->ID, '_movedo_grve_footer_bar_visibility', true );

?>

	<!--  METABOXES -->
	<div class="grve-metabox-content">

		<!-- TABS -->
		<div class="grve-tabs">

			<ul class="grve-tab-links">
				<li class="active"><a href="#grve-page-option-tab-header"><?php esc_html_e( 'Header / Main Menu', 'movedo' ); ?></a></li>
				<li><a href="#grve-page-option-tab-title"><?php esc_html_e( 'Title / Description', 'movedo' ); ?></a></li>
				<?php if( 'product' == $post_type ) { ?>
				<li><a href="#grve-page-option-tab-section-area"><?php esc_html_e( 'Product Area', 'movedo' ); ?></a></li>
				<?php } ?>
				<li><a href="#grve-page-option-tab-layout"><?php esc_html_e( 'Content / Sidebars', 'movedo' ); ?></a></li>
				<li><a href="#grve-page-option-tab-sliding-area"><?php esc_html_e( 'Sliding Area', 'movedo' ); ?></a></li>
				<?php if( 'page' == $post_type ) { ?>
				<li><a href="#grve-page-option-tab-scrolling-sections"><?php esc_html_e( 'Scrolling Sections', 'movedo' ); ?></a></li>
				<?php } ?>
				<li><a href="#grve-page-option-tab-bottom-footer-areas"><?php esc_html_e( 'Bottom / Footer Areas', 'movedo' ); ?></a></li>
				<li><a href="#grve-page-option-tab-extras"><?php esc_html_e( 'Extras', 'movedo' ); ?></a></li>
				<li><a href="#grve-page-option-tab-visibility"><?php esc_html_e( 'Visibility', 'movedo' ); ?></a></li>
			</ul>
			<div class="grve-tab-content">

				<div id="grve-page-option-tab-header" class="grve-tab-item active">
					<?php

						//Header Overlapping Option
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_header_overlapping',
								'id' => '_movedo_grve_header_overlapping',
								'value' => $movedo_grve_header_overlapping,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Header Overlapping', 'movedo' ),
									"desc" => esc_html__( 'Select if you want to overlap your page header', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);

						//Header Style Option
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_header_style',
								'id' => '_movedo_grve_header_style',
								'value' => $movedo_grve_header_style,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'default' => esc_html__( 'Default', 'movedo' ),
									'dark' => esc_html__( 'Dark', 'movedo' ),
									'light' => esc_html__( 'Light', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Header Style', 'movedo' ),
									"desc" => esc_html__( 'With this option you can change the coloring of your header. In case that you use Slider in Feature Section, select the header style per slide/image.', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);

						//Main Navigation Menu Option
						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Main Navigation Menu', 'movedo' ),
									"desc" => esc_html__( 'Select alternative main navigation menu.', 'movedo' ),
									"info" => esc_html__( 'Inherit : Menus - Theme Locations - Header Menu.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_menu_selection( $movedo_grve_main_navigation_menu, 'grve-main-navigation-menu', '_movedo_grve_main_navigation_menu', 'default' );
						movedo_grve_print_admin_option_wrapper_end();


						//Responsive Navigation Menu Option
						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Responsive Navigation Menu', 'movedo' ),
									"desc" => esc_html__( 'Select alternative responsive navigation menu.', 'movedo' ),
									"info" => esc_html__( 'Inherit : Menus - Theme Locations - Responsive Menu.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_menu_selection( $movedo_grve_responsive_navigation_menu, 'grve-responsive-navigation-menu', '_movedo_grve_responsive_navigation_menu', 'default' );
						movedo_grve_print_admin_option_wrapper_end();

						//Menu Type
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_menu_type',
								'id' => '_movedo_grve_menu_type',
								'value' => $movedo_grve_menu_type,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'classic' => esc_html__( 'Classic', 'movedo' ),
									'button' => esc_html__( 'Button Style', 'movedo' ),
									'underline' => esc_html__( 'Underline', 'movedo' ),
									'hidden' => esc_html__( 'Hidden', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Menu Type', 'movedo' ),
									"desc" => esc_html__( 'With this option you can select the type of the menu ( Not available for Side Header Mode ).', 'movedo' ),
									"info" => esc_html__( 'Inherit : Theme Options - Header Options.', 'movedo' ),
								),
							)
						);

						//Sticky Header Type
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_sticky_header_type',
								'id' => '_movedo_grve_sticky_header_type',
								'value' => $movedo_grve_sticky_header_type,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'none' => esc_html__( '-- None --', 'movedo' ),
									'simple' => esc_html__( 'Simple', 'movedo' ),
									'shrink' => esc_html__( 'Shrink', 'movedo' ),
									'advanced' => esc_html__( 'Scroll Up', 'movedo' ),
									'movedo' => esc_html__( 'Movedo', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Sticky Header Type', 'movedo' ),
									"desc" => esc_html__( 'With this option you can select the type of sticky header.', 'movedo' ),
									"info" => esc_html__( 'Inherit : Theme Options - Header Options - Sticky Header Options.', 'movedo' ),
								),
							)
						);


						//Safe Button Area
						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Safe Button Area', 'movedo' ),
									"desc" => esc_html__( 'Select an area item for your Safe Button Area.', 'movedo' ),
									"info" => esc_html__( 'Inherit : Theme Options - Header Options - Safe Button Area.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_area_selection( $movedo_grve_safe_button_area, 'grve-safe-button-area', '_movedo_grve_safe_button_area' );
						movedo_grve_print_admin_option_wrapper_end();

						//Responsive Header Overlapping Option
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_responsive_header_overlapping',
								'id' => '_movedo_grve_responsive_header_overlapping',
								'value' => $movedo_grve_responsive_header_overlapping,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Responsive Header Overlapping', 'movedo' ),
									"desc" => esc_html__( 'Select if you want to overlap your responsive header', 'movedo' ),
									"info" => esc_html__( 'Inherit : Theme Options - Header Options - Responsive Header Options.', 'movedo' ),
								),
							)
						);
					?>
				</div>
				<div id="grve-page-option-tab-title" class="grve-tab-item">
					<?php

						echo '<div id="_movedo_grve_page_title">';

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_disable_title',
								'id' => '_movedo_grve_disable_title',
								'value' => $movedo_grve_disable_title,
								'options' => array(
									'' => esc_html__( 'Visible', 'movedo' ),
									'yes' => esc_html__( 'Hidden', 'movedo' ),

								),
								'label' => array(
									"title" => esc_html__( 'Title/Description Visibility', 'movedo' ),
									"desc" => esc_html__( 'Select if you want to hide your title and decription .', 'movedo' ),
								),
								'group_id' => '_movedo_grve_page_title',
							)
						);

						//Description Option

						if( 'tribe_events' != $post_type ) {

							movedo_grve_print_admin_option(
								array(
									'type' => 'textarea',
									'name' => '_movedo_grve_description',
									'id' => '_movedo_grve_description',
									'value' => $movedo_grve_description,
									'label' => array(
										'title' => esc_html__( 'Description', 'movedo' ),
										'desc' => $movedo_grve_desc_info,
									),
									'width' => 'fullwidth',
									'rows' => 2,
									'dependency' =>
									'[
										{ "id" : "_movedo_grve_disable_title", "values" : [""] }
									]',
								)
							);
						}

						//Custom Title Option

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_page_title_custom',
								'id' => '_movedo_grve_page_title_custom',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom' ),
								'options' => $movedo_grve_page_title_selection,
								'label' => array(
									"title" => esc_html__( 'Title Options', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
								'group_id' => '_movedo_grve_page_title',
								'highlight' => 'highlight',
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);



						global $movedo_grve_area_height;
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'options' => $movedo_grve_area_height,
								'name' => '_movedo_grve_page_title_height',
								'id' => '_movedo_grve_page_title_height',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'height', '40' ),
								'label' => array(
									"title" => esc_html__( 'Title Area Height', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'textfield',
								'name' => '_movedo_grve_page_title_min_height',
								'id' => '_movedo_grve_page_title_min_height',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'min_height', '200' ),
								'label' => array(
									"title" => esc_html__( 'Title Area Minimum Height in px', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_page_title_container_size',
								'id' => '_movedo_grve_page_title_container_size',
								'options' => array(
									'' => esc_html__( 'Default', 'movedo' ),
									'large' => esc_html__( 'Large', 'movedo' ),
								),
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'container_size' ),
								'label' => array(
									"title" => esc_html__( 'Container Size', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-colorpicker',
								'name' => '_movedo_grve_page_title_bg_color',
								'id' => '_movedo_grve_page_title_bg_color',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_color', 'dark' ),
								'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_color_custom', '#000000' ),
								'label' => array(
									"title" => esc_html__( 'Background Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
								'multiple' => 'multi',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-colorpicker',
								'name' => '_movedo_grve_page_title_content_bg_color',
								'id' => '_movedo_grve_page_title_content_bg_color',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_bg_color', 'none' ),
								'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_bg_color_custom', '#ffffff' ),
								'label' => array(
									"title" => esc_html__( 'Content Background Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
								'multiple' => 'multi',
								'type_usage' => 'title-content-bg',
							)
						);

						if( 'post' == $post_type ) {
							movedo_grve_print_admin_option(
								array(
									'type' => 'select-colorpicker',
									'name' => '_movedo_grve_page_title_subheading_color',
									'id' => '_movedo_grve_page_title_subheading_color',
									'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'subheading_color', 'light' ),
									'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'subheading_color_custom', '#ffffff' ),
									'label' => array(
										"title" => esc_html__( 'Categories/Meta Color', 'movedo' ),
									),
									'dependency' =>
									'[
										{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
										{ "id" : "_movedo_grve_disable_title", "values" : [""] }
									]',
									'multiple' => 'multi',
								)
							);
						}

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-colorpicker',
								'name' => '_movedo_grve_page_title_title_color',
								'id' => '_movedo_grve_page_title_title_color',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'title_color', 'light' ),
								'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'title_color_custom', '#ffffff' ),
								'label' => array(
									"title" => esc_html__( 'Title Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
								'multiple' => 'multi',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-colorpicker',
								'name' => '_movedo_grve_page_title_caption_color',
								'id' => '_movedo_grve_page_title_caption_color',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'caption_color', 'light' ),
								'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'caption_color_custom', '#ffffff' ),
								'label' => array(
									"title" => esc_html__( 'Description Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
								'multiple' => 'multi',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_page_title_content_size',
								'id' => '_movedo_grve_page_title_content_size',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_size', 'large' ),
								'options' => array(
									'large' => esc_html__( 'Large', 'movedo' ),
									'medium' => esc_html__( 'Medium', 'movedo' ),
									'small' => esc_html__( 'Small', 'movedo' ),
								),
								'label' => esc_html__( 'Content Size', 'movedo' ),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-align',
								'name' => '_movedo_grve_page_title_content_alignment',
								'id' => '_movedo_grve_page_title_content_alignment',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_alignment', 'center' ),
								'label' => esc_html__( 'Content Alignment', 'movedo' ),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);


						global $movedo_grve_media_bg_position_selection;
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_page_title_content_position',
								'id' => '_movedo_grve_page_title_content_position',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_position', 'center-center' ),
								'options' => $movedo_grve_media_bg_position_selection,
								'label' => array(
									"title" => esc_html__( 'Content Position', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-text-animation',
								'name' => '_movedo_grve_page_title_content_animation',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_animation', 'fade-in' ),
								'label' => esc_html__( 'Content Animation', 'movedo' ),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);


						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_page_title_bg_mode',
								'id' => '_movedo_grve_page_title_bg_mode',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_mode'),
								'options' => array(
									'' => esc_html__( 'Color Only', 'movedo' ),
									'featured' => esc_html__( 'Featured Image', 'movedo' ),
									'custom' => esc_html__( 'Custom Image', 'movedo' ),

								),
								'label' => array(
									"title" => esc_html__( 'Background', 'movedo' ),
								),
								'group_id' => '_movedo_grve_page_title',
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }

								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select-image',
								'name' => '_movedo_grve_page_title_bg_image_id',
								'id' => '_movedo_grve_page_title_bg_image_id',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_image_id'),
								'label' => array(
									"title" => esc_html__( 'Background Image', 'movedo' ),
								),
								'width' => 'fullwidth',
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_page_title_bg_mode", "values" : ["custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }

								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select-bg-position',
								'name' => '_movedo_grve_page_title_bg_position',
								'id' => '_movedo_grve_page_title_bg_position',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_position', 'center-center'),
								'label' => array(
									"title" => esc_html__( 'Background Position', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_page_title_bg_mode", "values" : ["featured","custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-pattern-overlay',
								'name' => '_movedo_grve_page_title_pattern_overlay',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'pattern_overlay'),
								'label' => esc_html__( 'Pattern Overlay', 'movedo' ),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_page_title_bg_mode", "values" : ["featured","custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select-colorpicker',
								'name' => '_movedo_grve_page_title_color_overlay',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'color_overlay', 'dark' ),
								'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'color_overlay_custom', '#000000' ),
								'label' => esc_html__( 'Color Overlay', 'movedo' ),
								'multiple' => 'multi',
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_page_title_bg_mode", "values" : ["featured","custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select-opacity',
								'name' => '_movedo_grve_page_title_opacity_overlay',
								'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'opacity_overlay', '0' ),
								'label' => esc_html__( 'Opacity Overlay', 'movedo' ),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_page_title_custom", "values" : ["custom"] },
									{ "id" : "_movedo_grve_page_title_bg_mode", "values" : ["featured","custom"] },
									{ "id" : "_movedo_grve_disable_title", "values" : [""] }
								]',
							)
						);

						echo '</div>';
					?>
				</div>

				<?php if( 'product' == $post_type ) { ?>
				<div id="grve-page-option-tab-section-area" class="grve-tab-item">
					<?php

						echo '<div id="_movedo_grve_page_section_area">';

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_area_section_type',
								'id' => '_movedo_grve_area_section_type',
								'value' => $movedo_grve_area_section_type,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'fullwidth-background' => esc_html__( 'No', 'movedo' ),
									'fullwidth-element' => esc_html__( 'Yes', 'movedo' ),
								),
								'label' => array(
									'title' => esc_html__( 'Area Full Width', 'movedo' ),
									'desc' => esc_html__( "Select if you prefer a full-width Area.", 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_area_padding_top_multiplier',
								'id' => '_movedo_grve_area_padding_top_multiplier',
								'value' => $movedo_grve_area_padding_top_multiplier,
								'options' => $movedo_grve_page_padding_selection,
								'label' => array(
									'title' => esc_html__( 'Top Padding', 'movedo' ),
									'desc' => esc_html__( "Select the space above the area.", 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_area_padding_bottom_multiplier',
								'id' => '_movedo_grve_area_padding_bottom_multiplier',
								'value' => $movedo_grve_area_padding_bottom_multiplier,
								'options' => $movedo_grve_page_padding_selection,
								'label' => array(
									'title' => esc_html__( 'Bottom Padding', 'movedo' ),
									'desc' => esc_html__( "Select the space below the area.", 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select-image',
								'name' => '_movedo_grve_area_image_id',
								'id' => '_movedo_grve_area_image_id',
								'value' => $movedo_grve_area_image_id,
								'label' => array(
									"title" => esc_html__( 'Custom Image', 'movedo' ),
									"desc" => esc_html__( 'If selected this image will replace the Feature Image of this area.', 'movedo' ),
								),
								'width' => 'fullwidth',
							)
						);

						//Custom colors

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_area_colors_custom',
								'id' => '_movedo_grve_area_colors_custom',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'custom' ),
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'custom' => esc_html__( 'Custom', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Area Color Options', 'movedo' ),
									"info" => $movedo_grve_area_colors_info,
								),
								'group_id' => '_movedo_grve_page_section_area',
								'highlight' => 'highlight',
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'colorpicker',
								'name' => '_movedo_grve_area_bg_color',
								'id' => '_movedo_grve_area_bg_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'bg_color', '#eeeeee' ),
								'label' => array(
									"title" => esc_html__( 'Background Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'colorpicker',
								'name' => '_movedo_grve_area_headings_color',
								'id' => '_movedo_grve_area_headings_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'headings_color', '#000000' ),
								'label' => array(
									"title" => esc_html__( 'Headings Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'colorpicker',
								'name' => '_movedo_grve_area_font_color',
								'id' => '_movedo_grve_area_font_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'font_color', '#999999' ),
								'label' => array(
									"title" => esc_html__( 'Font Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'colorpicker',
								'name' => '_movedo_grve_area_link_color',
								'id' => '_movedo_grve_area_link_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'link_color', '#FF7D88' ),
								'label' => array(
									"title" => esc_html__( 'Link Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'colorpicker',
								'name' => '_movedo_grve_area_hover_color',
								'id' => '_movedo_grve_area_hover_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'hover_color', '#000000' ),
								'label' => array(
									"title" => esc_html__( 'Hover Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'colorpicker',
								'name' => '_movedo_grve_area_border_color',
								'id' => '_movedo_grve_area_border_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'border_color', '#e0e0e0' ),
								'label' => array(
									"title" => esc_html__( 'Border Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_area_button_color',
								'id' => '_movedo_grve_area_button_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'button_color', 'primary-1' ),
								'options' => $movedo_grve_button_color_selection,
								'label' => array(
									"title" => esc_html__( 'Button Color', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_button_hover_color',
								'id' => '_movedo_grve_button_hover_color',
								'value' => movedo_grve_array_value( $movedo_grve_area_colors, 'button_hover_color', 'black' ),
								'options' => $movedo_grve_button_color_selection,
								'label' => array(
									"title" => esc_html__( 'Button HoverColor', 'movedo' ),
								),
								'dependency' =>
								'[
									{ "id" : "_movedo_grve_area_colors_custom", "values" : ["custom"] }
								]',
							)
						);

						echo '</div>';
					?>
				</div>
				<?php } ?>

				<div id="grve-page-option-tab-layout" class="grve-tab-item">
					<?php

						movedo_grve_print_admin_option(
							array(
								'type' => 'textfield',
								'name' => '_movedo_grve_padding_top',
								'id' => '_movedo_grve_padding_top',
								'value' => $movedo_grve_padding_top,
								'label' => array(
									'title' => esc_html__( 'Top Padding', 'movedo' ),
									'desc' => esc_html__( "Define the space above the content area.", 'movedo' ) . " " . esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", 'movedo' ),
									'info' => esc_html__( "Enter 0 to eliminate the space. Leave this empty for the default value ( default vaule is 90px )", 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'textfield',
								'name' => '_movedo_grve_padding_bottom',
								'id' => '_movedo_grve_padding_bottom',
								'value' => $movedo_grve_padding_bottom,
								'label' => array(
									'title' => esc_html__( 'Bottom Padding', 'movedo' ),
									'desc' => esc_html__( "Define the space below the content area.", 'movedo' ) . " " . esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", 'movedo' ),
									'info' => esc_html__( "Enter 0 to eliminate the space. Leave this empty for the default value ( default vaule is 90px )", 'movedo' ),
								),
							)
						);


						//Layout Option
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_layout',
								'id' => '_movedo_grve_layout',
								'value' => $movedo_grve_layout,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'none' => esc_html__( 'Full Width', 'movedo' ),
									'left' => esc_html__( 'Left Sidebar', 'movedo' ),
									'right' => esc_html__( 'Right Sidebar', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Layout', 'movedo' ),
									"desc" => esc_html__( 'Select page content and sidebar alignment.', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);

						//Sidebar Option
						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Sidebar', 'movedo' ),
									"desc" => esc_html__( 'Select page sidebar.', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);
						movedo_grve_print_sidebar_selection( $movedo_grve_sidebar, '_movedo_grve_sidebar', '_movedo_grve_sidebar' );
						movedo_grve_print_admin_option_wrapper_end();

						//Fixed Sidebar Option
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_fixed_sidebar',
								'id' => '_movedo_grve_fixed_sidebar',
								'value' => $movedo_grve_fixed_sidebar,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Fixed Sidebar', 'movedo' ),
									"desc" => esc_html__( 'If selected, sidebar will be fixed.', 'movedo' ),
								),
							)
						);

						//Posts Content Width
						if ( 'post' == $post_type || 'product' == $post_type || 'tribe_events' == $post_type ) {

							movedo_grve_print_admin_option(
								array(
									'type' => 'select',
									'name' => '_movedo_grve_post_content_width',
									'id' => '_movedo_grve_post_content_width',
									'value' => $movedo_grve_post_content_width,
									'options' => array(
										'' => esc_html__( '-- Inherit --', 'movedo' ),
										'container' => esc_html__( 'Container Size' , 'movedo' ),
										'1170' => esc_html__( 'Large' , 'movedo' ),
										'990' => esc_html__( 'Medium' , 'movedo' ),
										'770' => esc_html__( 'Small' , 'movedo' ),
									),
									'label' => array(
										"title" => esc_html__( 'Content Width', 'movedo' ),
										"desc" => esc_html__( 'Select the Content Width (only for Full Width Layout)', 'movedo' ),
										"info" => $movedo_grve_theme_options_info,
									),
								)
							);
						}

					?>
				</div>
				<div id="grve-page-option-tab-sliding-area" class="grve-tab-item">
					<?php
						//Sidearea Visibility
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_sidearea_visibility',
								'id' => '_movedo_grve_sidearea_visibility',
								'value' => $movedo_grve_sidearea_visibility,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Sliding Area Visibility', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);

						//Sidearea Sidebar Option
						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Sliding Area Sidebar', 'movedo' ),
									"desc" => esc_html__( 'Select sliding area sidebar.', 'movedo' ),
									"info" => $movedo_grve_theme_options_info,
								),
							)
						);
						movedo_grve_print_sidebar_selection( $movedo_grve_sidearea_sidebar, '_movedo_grve_sidearea_sidebar', '_movedo_grve_sidearea_sidebar' );
						movedo_grve_print_admin_option_wrapper_end();
					?>
				</div>
				<div id="grve-page-option-tab-bottom-footer-areas" class="grve-tab-item">
					<?php
						//Bottom / Footer Areas Visibility

						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Bottom Bar Area', 'movedo' ),
									"desc" => esc_html__( 'Select an area item for your Bottom Bar Area.', 'movedo' ),
									"info" => esc_html__( 'Inherit : Theme Options - Bottom / Footer Areas - Bottom Bar Area Item.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_area_selection( $movedo_grve_bottom_bar_area, 'grve-bottom-bar-area-item', '_movedo_grve_bottom_bar_area' );
						movedo_grve_print_admin_option_wrapper_end();

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_footer_widgets_visibility',
								'id' => '_movedo_grve_footer_widgets_visibility',
								'value' => $movedo_grve_footer_widgets_visibility,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Footer Widgets Visibility', 'movedo' ),
									"desc" => esc_html__( 'Inherit : Theme Options - Bottom / Footer Areas - Footer Widgets Settings.', 'movedo' ),
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_footer_bar_visibility',
								'id' => '_movedo_grve_footer_bar_visibility',
								'value' => $movedo_grve_footer_bar_visibility,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Footer Bar Visibility', 'movedo' ),
									"desc" => esc_html__( 'Inherit : Theme Options - Bottom / Footer Areas - Footer Bar Settings.', 'movedo' ),
								),
							)
						);
					?>
				</div>
				<div id="grve-page-option-tab-extras" class="grve-tab-item">
					<?php

						//Details Option
						if ( 'portfolio' == $post_type) {
							movedo_grve_print_admin_option(
								array(
									'type' => 'textfield',
									'name' => '_movedo_grve_details_title',
									'id' => '_movedo_grve_details_title',
									'value' => $movedo_grve_details_title,
									'label' => array(
										'title' => esc_html__( 'Details Title', 'movedo' ),
										'desc' => esc_html__( 'Enter your details title.', 'movedo' ),
										'info' => $movedo_grve_theme_options_info_text_empty,
									),
									'width' => 'fullwidth',
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'textarea',
									'name' => '_movedo_grve_details',
									'id' => '_movedo_grve_details',
									'value' => $movedo_grve_details,
									'label' => array(
										'title' => esc_html__( 'Details Area', 'movedo' ),
										'desc' => esc_html__( 'Enter your details area.', 'movedo' ),
									),
									'width' => 'fullwidth',
								)
							);

							movedo_grve_print_admin_option(
								array(
									'type' => 'textfield',
									'name' => '_movedo_grve_details_link_text',
									'id' => '_movedo_grve_details_link_text',
									'value' => $movedo_grve_details_link_text,
									'label' => array(
										'title' => esc_html__( 'Link Text', 'movedo' ),
										'desc' => esc_html__( 'Enter your details link text.', 'movedo' ),
										'info' => $movedo_grve_theme_options_info_text_empty,
									),
									'width' => 'fullwidth',
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'textfield',
									'name' => '_movedo_grve_details_link_url',
									'value' => $movedo_grve_details_link_url,
									'label' => array(
										'title' => esc_html__( 'Link URL', 'movedo' ),
										'desc' => esc_html__( 'Enter the full URL of your link.', 'movedo' ),
									),
									'width' => 'fullwidth',
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'checkbox',
									'name' => '_movedo_grve_details_link_new_window',
									'value' => $movedo_grve_details_link_new_window,
									'label' => array(
										'title' => esc_html__( 'Open Link in new window', 'movedo' ),
										'desc' => esc_html__( 'If selected, link will open in a new window.', 'movedo' ),
									),
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'textfield',
									'name' => '_movedo_grve_details_link_extra_class',
									'value' => $movedo_grve_details_link_extra_class,
									'label' => array(
										'title' => esc_html__( 'Link extra class name', 'movedo' ),
									),
								)
							);

							//Backlink page
							movedo_grve_print_admin_option_wrapper_start(
								array(
									'type' => 'select',
									'label' => array(
										"title" => esc_html__( 'Backlink', 'movedo' ),
										"desc" => esc_html__( 'Select your backlink page.', 'movedo' ),
										"info" => $movedo_grve_theme_options_info,
									),
								)
							);
							movedo_grve_print_page_selection( $movedo_grve_backlink_id, 'grve-backlink-id', '_movedo_grve_backlink_id' );
							movedo_grve_print_admin_option_wrapper_end();


						}

						//Anchor Navigation Menu Option

						movedo_grve_print_admin_option_wrapper_start(
							array(
								'type' => 'select',
								'label' => array(
									"title" => esc_html__( 'Anchor Navigation Menu', 'movedo' ),
									"desc" => esc_html__( 'Select page anchor navigation menu.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_menu_selection( $movedo_grve_anchor_navigation_menu, 'grve-page-navigation-menu', '_movedo_grve_anchor_navigation_menu' );
						movedo_grve_print_admin_option_wrapper_end();

						//Theme Loader
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_theme_loader',
								'id' => '_movedo_grve_theme_loader',
								'value' => $movedo_grve_theme_loader,
								'options' => array(
									'' => esc_html__( '-- Inherit --', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
								),
								'label' => array(
									"title" => esc_html__( 'Theme Loader Visibility', 'movedo' ),
									"info" => esc_html__( 'Inherit : Theme Options - General Settings.', 'movedo' ),
								),
							)
						);
					?>
				</div>
				<div id="grve-page-option-tab-scrolling-sections" class="grve-tab-item">
					<?php

						//Responsive Scrolling Option
						if ( 'page' == $post_type) {

							echo '<div id="_movedo_grve_page_scrolling_section">';

							movedo_grve_print_admin_option(
								array(
									'type' => 'select',
									'name' => '_movedo_grve_scrolling_page',
									'id' => '_movedo_grve_scrolling_page',
									'value' => $movedo_grve_scrolling_page,
									'options' => array(
										'' => esc_html__( 'Full Page', 'movedo' ),
										'pilling' => esc_html__( 'Page Pilling', 'movedo' ),
									),
									'label' => array(
										'title' => esc_html__( 'Scrolling Sections Plugin', 'movedo' ),
										'desc' => esc_html__( 'Select the scrolling sections plugin you want to use.', 'movedo' ),
										'info' => esc_html__( 'Note: The following options are available only for Scrolling Full Screen Sections Template.', 'movedo' ),
									),
									'highlight' => 'highlight',
									'group_id' => '_movedo_grve_page_scrolling_section',
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'select',
									'name' => '_movedo_grve_scrolling_lock_anchors',
									'id' => '_movedo_grve_scrolling_lock_anchors',
									'value' => $movedo_grve_scrolling_lock_anchors,
									'options' => array(
										'' => esc_html__( 'URL without /#', 'movedo' ),
										'no' => esc_html__( 'Allow Anchor Links in URL', 'movedo' ),
									),
									'label' => array(
										'title' => esc_html__( 'Anchor Links', 'movedo' ),
										'desc' => esc_html__( 'Select if you want to allow anchor links.', 'movedo' ),
									),
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'select',
									'name' => '_movedo_grve_scrolling_loop',
									'id' => '_movedo_grve_scrolling_loop',
									'value' => $movedo_grve_scrolling_loop,
									'options' => array(
										'' => esc_html__( 'None', 'movedo' ),
										'top' => esc_html__( 'Loop Top', 'movedo' ),
										'bottom' => esc_html__( 'Loop Bottom', 'movedo' ),
										'both' => esc_html__( 'Loop Top/Bottom', 'movedo' ),
									),
									'label' => array(
										'title' => esc_html__( 'Loop', 'movedo' ),
										'desc' => esc_html__( 'Select if you want to loop.', 'movedo' ),
									),
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'select',
									'name' => '_movedo_grve_scrolling_direction',
									'id' => '_movedo_grve_scrolling_direction',
									'value' => $movedo_grve_scrolling_direction,
									'options' => array(
										'' => esc_html__( 'Vertical', 'movedo' ),
										'horizontal' => esc_html__( 'Horizontal', 'movedo' ),
									),
									'label' => array(
										'title' => esc_html__( 'Direction', 'movedo' ),
										'desc' => esc_html__( 'Select scrolling direction.', 'movedo' ),
									),
									'dependency' =>
									'[
										{ "id" : "_movedo_grve_scrolling_page", "values" : ["pilling"] }
									]',
								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'textfield',
									'name' => '_movedo_grve_scrolling_speed',
									'id' => '_movedo_grve_scrolling_speed',
									'value' => $movedo_grve_scrolling_speed,
									'label' => array(
										'title' => esc_html__( 'Speed (ms)', 'movedo' ),
										'desc' => esc_html__( 'Enter scrolling speed.', 'movedo' ),
									),
									'default_value' => '1000',

								)
							);
							movedo_grve_print_admin_option(
								array(
									'type' => 'select',
									'name' => '_movedo_grve_responsive_scrolling',
									'id' => '_movedo_grve_responsive_scrolling',
									'value' => $movedo_grve_responsive_scrolling,
									'options' => array(
										'' => esc_html__( 'Yes', 'movedo' ),
										'no' => esc_html__( 'No', 'movedo' ),
									),
									'label' => array(
										'title' => esc_html__( 'Responsive Scrolling Full Sections', 'movedo' ),
										'desc' => esc_html__( 'Select if you want to maintain the scrolling feature on devices.', 'movedo' ),
									),
								)
							);

							echo '</div>';
						}

					?>
				</div>
				<div id="grve-page-option-tab-visibility" class="grve-tab-item">
					<?php

						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_top_bar',
								'id' => '_movedo_grve_disable_top_bar',
								'value' => $movedo_grve_disable_top_bar,
								'label' => array(
									"title" => esc_html__( 'Disable Top Bar', 'movedo' ),
									"desc" => esc_html__( 'If selected, top bar will be hidden.', 'movedo' ),
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_logo',
								'id' => '_movedo_grve_disable_logo',
								'value' => $movedo_grve_disable_logo,
								'label' => array(
									"title" => esc_html__( 'Disable Logo', 'movedo' ),
									"desc" => esc_html__( 'If selected, logo will be disabled.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu',
								'id' => '_movedo_grve_disable_menu',
								'value' => $movedo_grve_disable_menu,
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu will be hidden.', 'movedo' ),
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu_item_search',
								'id' => '_movedo_grve_disable_menu_item_search',
								'value' => movedo_grve_array_value( $movedo_grve_disable_menu_items, 'search'),
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu Item Search', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu item will be hidden.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu_item_form',
								'id' => '_movedo_grve_disable_menu_item_form',
								'value' => movedo_grve_array_value( $movedo_grve_disable_menu_items, 'form'),
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu Item Contact Form', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu item will be hidden.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu_item_language',
								'id' => '_movedo_grve_disable_menu_item_language',
								'value' => movedo_grve_array_value( $movedo_grve_disable_menu_items, 'language'),
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu Item Language Selector', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu item will be hidden.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu_item_cart',
								'id' => '_movedo_grve_disable_menu_item_cart',
								'value' => movedo_grve_array_value( $movedo_grve_disable_menu_items, 'cart'),
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu Item Shopping Cart', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu item will be hidden.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu_item_login',
								'id' => '_movedo_grve_disable_menu_item_login',
								'value' => movedo_grve_array_value( $movedo_grve_disable_menu_items, 'login'),
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu Item Login', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu item will be hidden.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_menu_item_social',
								'id' => '_movedo_grve_disable_menu_item_social',
								'value' => movedo_grve_array_value( $movedo_grve_disable_menu_items, 'social'),
								'label' => array(
									"title" => esc_html__( 'Disable Main Menu Item Social Icons', 'movedo' ),
									"desc" => esc_html__( 'If selected, main menu item will be hidden.', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_header_text',
								'id' => '_movedo_grve_disable_header_text',
								'value' => $movedo_grve_disable_header_text,
								'label' => array(
									"title" => esc_html__( 'Disable Header Text', 'movedo' ),
									"desc" => esc_html__( 'If selected, header text will be hidden.', 'movedo' ),
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_breadcrumbs',
								'id' => '_movedo_grve_disable_breadcrumbs',
								'value' => $movedo_grve_disable_breadcrumbs,
								'label' => array(
									"title" => esc_html__( 'Disable Breadcrumbs', 'movedo' ),
									"desc" => esc_html__( 'If selected, breadcrumbs items will be hidden.', 'movedo' ),
								),
							)
						);

						if ( 'page' == $post_type ) {
							if ( movedo_grve_woocommerce_enabled() && $post->ID == wc_get_page_id( 'shop' ) ) {
								//Skip
							} else {
								movedo_grve_print_admin_option(
									array(
										'type' => 'checkbox',
										'name' => '_movedo_grve_disable_content',
										'id' => '_movedo_grve_disable_content',
										'value' => $movedo_grve_disable_content,
										'label' => array(
											"title" => esc_html__( 'Disable Content Area', 'movedo' ),
											"desc" => esc_html__( 'If selected, content area will be hidden (including sidebar and comments).', 'movedo' ),
										),
									)
								);
							}
						}

						if ( 'post' == $post_type ) {
							movedo_grve_print_admin_option(
								array(
									'type' => 'checkbox',
									'name' => '_movedo_grve_disable_media',
									'id' => '_movedo_grve_disable_media',
									'value' => $movedo_grve_disable_media,
									'label' => array(
										"title" => esc_html__( 'Disable Media Area', 'movedo' ),
										"desc" => esc_html__( 'If selected, media area will be hidden.', 'movedo' ),
									),
								)
							);
						}
						if ( 'portfolio' == $post_type ) {
							movedo_grve_print_admin_option(
								array(
									'type' => 'checkbox',
									'name' => '_movedo_grve_disable_recent_entries',
									'id' => '_movedo_grve_disable_recent_entries',
									'value' => $movedo_grve_disable_recent_entries,
									'label' => array(
										"title" => esc_html__( 'Disable Recent Entries', 'movedo' ),
										"desc" => esc_html__( 'If selected, recent entries area will be hidden.', 'movedo' ),
									),
								)
							);
						}

						movedo_grve_print_admin_option(
							array(
								'type' => 'checkbox',
								'name' => '_movedo_grve_disable_back_to_top',
								'id' => '_movedo_grve_disable_back_to_top',
								'value' => $movedo_grve_disable_back_to_top,
								'label' => array(
									"title" => esc_html__( 'Disable Back to Top', 'movedo' ),
									"desc" => esc_html__( 'If selected, Back to Top button will be hidden.', 'movedo' ),
								),
							)
						);

					?>
				</div>
			</div>
		</div>
	</div>

<?php
}

function movedo_grve_page_feature_section_box( $post ) {

	wp_nonce_field( 'movedo_grve_nonce_feature_save', '_movedo_grve_nonce_feature_save' );

	$post_id = $post->ID;
	movedo_grve_admin_get_feature_section( $post_id );

}

function movedo_grve_generic_options_save_postdata( $post_id , $post ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['_movedo_grve_nonce_feature_save'] ) && wp_verify_nonce( $_POST['_movedo_grve_nonce_feature_save'], 'movedo_grve_nonce_feature_save' ) ) {

		if ( movedo_grve_check_permissions( $post_id ) ) {
			movedo_grve_admin_save_feature_section( $post_id );
		}

	}

	if ( isset( $_POST['_movedo_grve_nonce_page_save'] ) && wp_verify_nonce( $_POST['_movedo_grve_nonce_page_save'], 'movedo_grve_nonce_page_save' ) ) {

		if ( movedo_grve_check_permissions( $post_id ) ) {

			$movedo_grve_page_options = array (
				array(
					'name' => 'Description',
					'id' => '_movedo_grve_description',
				),
				array(
					'name' => 'Details Title',
					'id' => '_movedo_grve_details_title',
				),
				array(
					'name' => 'Details',
					'id' => '_movedo_grve_details',
				),
				array(
					'name' => 'Details Link Text',
					'id' => '_movedo_grve_details_link_text',
				),
				array(
					'name' => 'Details Link URL',
					'id' => '_movedo_grve_details_link_url',
				),
				array(
					'name' => 'Details Link New Window',
					'id' => '_movedo_grve_details_link_new_window',
				),
				array(
					'name' => 'Details Link Extra Class',
					'id' => '_movedo_grve_details_link_extra_class',
				),
				array(
					'name' => 'Backlink',
					'id' => '_movedo_grve_backlink_id',
				),
				array(
					'name' => 'Area Section Type',
					'id' => '_movedo_grve_area_section_type',
				),
				array(
					'name' => 'Area Top Padding Multiplier',
					'id' => '_movedo_grve_area_padding_top_multiplier',
				),
				array(
					'name' => 'Area Bottom Padding Multiplier',
					'id' => '_movedo_grve_area_padding_bottom_multiplier',
				),
				array(
					'name' => 'Area Image ID',
					'id' => '_movedo_grve_area_image_id',
				),
				array(
					'name' => 'Top Padding',
					'id' => '_movedo_grve_padding_top',
				),
				array(
					'name' => 'Bottom Padding',
					'id' => '_movedo_grve_padding_bottom',
				),
				array(
					'name' => 'Layout',
					'id' => '_movedo_grve_layout',
				),
				array(
					'name' => 'Sidebar',
					'id' => '_movedo_grve_sidebar',
				),
				array(
					'name' => 'Post Content width',
					'id' => '_movedo_grve_post_content_width',
				),
				array(
					'name' => 'Sidearea Area Visibility',
					'id' => '_movedo_grve_sidearea_visibility',
				),
				array(
					'name' => 'Sidearea Sidebar',
					'id' => '_movedo_grve_sidearea_sidebar',
				),
				array(
					'name' => 'Fixed Sidebar',
					'id' => '_movedo_grve_fixed_sidebar',
				),
				array(
					'name' => 'Header Overlapping',
					'id' => '_movedo_grve_header_overlapping',
				),
				array(
					'name' => 'Header Style',
					'id' => '_movedo_grve_header_style',
				),
				array(
					'name' => 'Navigation Anchor Menu',
					'id' => '_movedo_grve_anchor_navigation_menu',
				),
				array(
					'name' => 'Theme Loader',
					'id' => '_movedo_grve_theme_loader',
				),
				array(
					'name' => 'Scrolling Page',
					'id' => '_movedo_grve_scrolling_page',
				),
				array(
					'name' => 'Responsive Scrolling',
					'id' => '_movedo_grve_responsive_scrolling',
				),
				array(
					'name' => 'Scrolling Lock Anchors',
					'id' => '_movedo_grve_scrolling_lock_anchors',
				),
				array(
					'name' => 'Scrolling Direction',
					'id' => '_movedo_grve_scrolling_direction',
				),
				array(
					'name' => 'Scrolling Loop',
					'id' => '_movedo_grve_scrolling_loop',
				),
				array(
					'name' => 'Scrolling Speed',
					'id' => '_movedo_grve_scrolling_speed',
				),
				array(
					'name' => 'Main Navigation Menu',
					'id' => '_movedo_grve_main_navigation_menu',
				),
				array(
					'name' => 'Responsive Navigation Menu',
					'id' => '_movedo_grve_responsive_navigation_menu',
				),
				array(
					'name' => 'Menu Type',
					'id' => '_movedo_grve_menu_type',
				),
				array(
					'name' => 'Safe Button Area Item',
					'id' => '_movedo_grve_safe_button_area',
				),
				array(
					'name' => 'Responsive Header Overlapping',
					'id' => '_movedo_grve_responsive_header_overlapping',
				),
				array(
					'name' => 'Sticky Header Type',
					'id' => '_movedo_grve_sticky_header_type',
				),
				array(
					'name' => 'Bottom Bar',
					'id' => '_movedo_grve_bottom_bar_area',
				),
				array(
					'name' => 'Footer Widgets',
					'id' => '_movedo_grve_footer_widgets_visibility',
				),
				array(
					'name' => 'Footer Bar',
					'id' => '_movedo_grve_footer_bar_visibility',
				),
				array(
					'name' => 'Disable Top Bar',
					'id' => '_movedo_grve_disable_top_bar',
				),
				array(
					'name' => 'Disable Logo',
					'id' => '_movedo_grve_disable_logo',
				),
				array(
					'name' => 'Disable Menu',
					'id' => '_movedo_grve_disable_menu',
				),
				array(
					'name' => 'Disable Menu Items',
					'id' => '_movedo_grve_disable_menu_items',
				),
				array(
					'name' => 'Disable Header Text',
					'id' => '_movedo_grve_disable_header_text',
				),
				array(
					'name' => 'Disable Breadcrumbs',
					'id' => '_movedo_grve_disable_breadcrumbs',
				),
				array(
					'name' => 'Disable Title',
					'id' => '_movedo_grve_disable_title',
				),
				array(
					'name' => 'Disable Media',
					'id' => '_movedo_grve_disable_media',
				),
				array(
					'name' => 'Disable Content',
					'id' => '_movedo_grve_disable_content',
				),
				array(
					'name' => 'Disable Recent Entries',
					'id' => '_movedo_grve_disable_recent_entries',
				),
				array(
					'name' => 'Disable Back to Top',
					'id' => '_movedo_grve_disable_back_to_top',
				),
			);

			$movedo_grve_disable_menu_items_options = array (
				array(
					'param_id' => 'search',
					'id' => '_movedo_grve_disable_menu_item_search',
					'default' => '',
				),
				array(
					'param_id' => 'form',
					'id' => '_movedo_grve_disable_menu_item_form',
					'default' => '',
				),
				array(
					'param_id' => 'language',
					'id' => '_movedo_grve_disable_menu_item_language',
					'default' => '',
				),
				array(
					'param_id' => 'cart',
					'id' => '_movedo_grve_disable_menu_item_cart',
					'default' => '',
				),
				array(
					'param_id' => 'login',
					'id' => '_movedo_grve_disable_menu_item_login',
					'default' => '',
				),
				array(
					'param_id' => 'social',
					'id' => '_movedo_grve_disable_menu_item_social',
					'default' => '',
				),
				array(
					'param_id' => 'text',
					'id' => '_movedo_grve_disable_menu_item_text',
					'default' => '',
				),
			);

			//Title Options
			$movedo_grve_page_title_options = array (
				array(
					'param_id' => 'custom',
					'id' => '_movedo_grve_page_title_custom',
					'default' => '',
				),
				array(
					'param_id' => 'height',
					'id' => '_movedo_grve_page_title_height',
					'default' => '40',
				),
				array(
					'param_id' => 'min_height',
					'id' => '_movedo_grve_page_title_min_height',
					'default' => '200',
				),
				array(
					'param_id' => 'bg_color',
					'id' => '_movedo_grve_page_title_bg_color',
					'default' => 'light',
				),
				array(
					'param_id' => 'bg_color_custom',
					'id' => '_movedo_grve_page_title_bg_color_custom',
					'default' => '#ffffff',
				),
				array(
					'param_id' => 'subheading_color',
					'id' => '_movedo_grve_page_title_subheading_color',
					'default' => 'light',
				),
				array(
					'param_id' => 'subheading_color_custom',
					'id' => '_movedo_grve_page_title_subheading_color_custom',
					'default' => '#ffffff',
				),
				array(
					'param_id' => 'title_color',
					'id' => '_movedo_grve_page_title_title_color',
					'default' => 'dark',
				),
				array(
					'param_id' => 'title_color_custom',
					'id' => '_movedo_grve_page_title_title_color_custom',
					'default' => '#000000',
				),
				array(
					'param_id' => 'caption_color',
					'id' => '_movedo_grve_page_title_caption_color',
					'default' => 'dark',
				),
				array(
					'param_id' => 'caption_color_custom',
					'id' => '_movedo_grve_page_title_caption_color_custom',
					'default' => '#000000',
				),
				array(
					'param_id' => 'content_bg_color',
					'id' => '_movedo_grve_page_title_content_bg_color',
					'default' => 'none',
				),
				array(
					'param_id' => 'content_bg_color_custom',
					'id' => '_movedo_grve_page_title_content_bg_color_custom',
					'default' => '#000000',
				),
				array(
					'param_id' => 'container_size',
					'id' => '_movedo_grve_page_title_container_size',
					'default' => '',
				),
				array(
					'param_id' => 'content_size',
					'id' => '_movedo_grve_page_title_content_size',
					'default' => 'large',
				),
				array(
					'param_id' => 'content_alignment',
					'id' => '_movedo_grve_page_title_content_alignment',
					'default' => 'center',
				),
				array(
					'param_id' => 'content_position',
					'id' => '_movedo_grve_page_title_content_position',
					'default' => 'center-center',
				),
				array(
					'param_id' => 'content_animation',
					'id' => '_movedo_grve_page_title_content_animation',
					'default' => 'fade-in',
				),
				array(
					'param_id' => 'bg_mode',
					'id' => '_movedo_grve_page_title_bg_mode',
					'default' => '',
				),
				array(
					'param_id' => 'bg_image_id',
					'id' => '_movedo_grve_page_title_bg_image_id',
					'default' => '0',
				),
				array(
					'param_id' => 'bg_position',
					'id' => '_movedo_grve_page_title_bg_position',
					'default' => 'center-center',
				),
				array(
					'param_id' => 'pattern_overlay',
					'id' => '_movedo_grve_page_title_pattern_overlay',
					'default' => '',
				),
				array(
					'param_id' => 'color_overlay',
					'id' => '_movedo_grve_page_title_color_overlay',
					'default' => 'dark',
				),
				array(
					'param_id' => 'color_overlay_custom',
					'id' => '_movedo_grve_page_title_color_overlay_custom',
					'default' => '#000000',
				),
				array(
					'param_id' => 'opacity_overlay',
					'id' => '_movedo_grve_page_title_opacity_overlay',
					'default' => '0',
				),
			);

			//Area Colors
			$movedo_grve_area_colors = array (
				array(
					'param_id' => 'custom',
					'id' => '_movedo_grve_area_colors_custom',
					'default' => '',
				),
				array(
					'param_id'    => 'bg_color',
					'id'          => '_movedo_grve_area_bg_color',
					'default'     => '#eeeeee',
				),
				array(
					'param_id'    => 'headings_color',
					'id'          => '_movedo_grve_area_headings_color',
					'default'     => '#000000',
				),
				array(
					'param_id'    => 'font_color',
					'id'          => '_movedo_grve_area_font_color',
					'default'     => '#999999',
				),
				array(
					'param_id'    => 'link_color',
					'id'          => '_movedo_grve_area_link_color',
					'default'     => '#FF7D88',
				),
				array(
					'param_id'    => 'hover_color',
					'id'          => '_movedo_grve_area_hover_color',
					'default'     => '#000000',
				),
				array(
					'param_id'    => 'border_color',
					'id'          => '_movedo_grve_area_border_color',
					'default'     => '#e0e0e0',
				),
				array(
					'param_id'    => 'button_color',
					'id'          =>'_movedo_grve_area_button_color',
					'default'     => 'primary-1',
				),
				array(
					'param_id'    => 'button_hover_color',
					'id'          =>'_movedo_grve_button_hover_color',
					'default'     => 'black',
				),
			);

			//Update Single custom fields
			foreach ( $movedo_grve_page_options as $value ) {
				$new_meta_value = ( isset( $_POST[$value['id']] ) ? $_POST[$value['id']] : '' );
				$meta_key = $value['id'];


				$meta_value = get_post_meta( $post_id, $meta_key, true );

				if ( '' != $new_meta_value  && '' == $meta_value ) {
					if ( !add_post_meta( $post_id, $meta_key, $new_meta_value, true ) ) {
						update_post_meta( $post_id, $meta_key, $new_meta_value );
					}
				} elseif ( '' != $new_meta_value && $new_meta_value != $meta_value ) {
					update_post_meta( $post_id, $meta_key, $new_meta_value );
				} elseif ( '' == $new_meta_value && '' != $meta_value ) {
					delete_post_meta( $post_id, $meta_key );
				}
			}

			//Update Menu Items Visibility array
			movedo_grve_update_meta_array( $post_id, '_movedo_grve_disable_menu_items', $movedo_grve_disable_menu_items_options );
			//Update Title Options array
			movedo_grve_update_meta_array( $post_id, '_movedo_grve_custom_title_options', $movedo_grve_page_title_options );
			//Update Area Colors array
			movedo_grve_update_meta_array( $post_id, '_movedo_grve_area_colors', $movedo_grve_area_colors );
		}
	}

}

/**
 * Function update meta array
 */
function movedo_grve_update_meta_array( $post_id, $param_id, $param_array_options ) {

	$array_options = array();

	if( !empty( $param_array_options ) ) {

		foreach ( $param_array_options as $value ) {

			$meta_key = $value['param_id'];
			$meta_default = $value['default'];

			$new_meta_value = ( isset( $_POST[$value['id']] ) ? $_POST[$value['id']] : $meta_default );

			if( !empty( $new_meta_value ) ) {
				$array_options[$meta_key] = $new_meta_value;
			}
		}

	}

	if( !empty( $array_options ) ) {
		update_post_meta( $post_id, $param_id, $array_options );
	} else {
		delete_post_meta( $post_id, $param_id );
	}
}

/**
 * Function to check post type permissions
 */

function movedo_grve_check_permissions( $post_id ) {

	if ( 'post' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}
	} else {
		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return false;
		}
	}
	return true;
}

/**
 * Function to print menu selector
 */
function movedo_grve_print_menu_selection( $menu_id, $id, $name, $default = 'none' ) {

	?>
	<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
		<option value="" <?php selected( '', $menu_id ); ?>>
			<?php
				if ( 'none' == $default ){
					esc_html_e( 'None', 'movedo' );
				} else {
					esc_html_e( '-- Inherit --', 'movedo' );
				}
			?>
		</option>
	<?php
		$menus = wp_get_nav_menus();
		if ( ! empty( $menus ) ) {
			foreach ( $menus as $item ) {
	?>
				<option value="<?php echo esc_attr( $item->term_id ); ?>" <?php selected( $item->term_id, $menu_id ); ?>>
					<?php echo esc_html( $item->name ); ?>
				</option>
	<?php
			}
		}
	?>
	</select>
	<?php
}

/**
 * Function to print layout selector
 */
function movedo_grve_print_layout_selection( $layout, $id, $name ) {

	$layouts = array(
		'' => esc_html__( '-- Inherit --', 'movedo' ),
		'none' => esc_html__( 'Full Width', 'movedo' ),
		'left' => esc_html__( 'Left Sidebar', 'movedo' ),
		'right' => esc_html__( 'Right Sidebar', 'movedo' ),
	);

	?>
	<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
	<?php
		foreach ( $layouts as $key => $value ) {
			if ( $value ) {
	?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $layout ); ?>><?php echo esc_html( $value ); ?></option>
	<?php
			}
		}
	?>
	</select>
	<?php
}

/**
 * Function to print sidebar selector
 */
function movedo_grve_print_sidebar_selection( $sidebar, $id, $name ) {
	global $wp_registered_sidebars;

	?>
	<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
		<option value="" <?php selected( '', $sidebar ); ?>><?php echo esc_html__( '-- Inherit --', 'movedo' ); ?></option>
	<?php
	foreach ( $wp_registered_sidebars as $key => $value ) {
		?>
		<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $sidebar ); ?>><?php echo esc_html( $value['name'] ); ?></option>
		<?php
	}
	?>
	</select>
	<?php
}

/**
 * Function to print page selector
 */
function movedo_grve_print_page_selection( $page_id, $id, $name ) {

?>
	<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
		<option value="" <?php selected( '', $page_id ); ?>>
			<?php esc_html_e( '-- Inherit --', 'movedo' ); ?>
		</option>
<?php
		$pages = get_pages();
		foreach ( $pages as $page ) {
?>
			<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, $page_id ); ?>>
				<?php echo esc_html( $page->post_title ); ?>
			</option>
<?php
		}
?>
	</select>
<?php

}


/**
 * Function to print page selector
 */
function movedo_grve_print_area_selection( $area_id, $id, $name ) {

?>
	<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
		<option value="" <?php selected( '', $area_id ); ?>>
			<?php esc_html_e( '-- Inherit --', 'movedo' ); ?>
		</option>
		<option value="none" <?php selected( 'none', $area_id ); ?>>
			<?php esc_html_e( '-- None --', 'movedo' ); ?>
		</option>
<?php
		$args = array( 'post_type' => 'area-item', 'numberposts' => -1 );
		$posts = get_posts( $args );
		if ( ! empty ( $posts ) ) {
			foreach ( $posts as $post ) {
?>
			<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( $post->ID, $area_id ); ?>>
				<?php echo esc_html( $post->post_title ); ?>
			</option>
<?php
			}
		}
		wp_reset_postdata();
?>
	</select>
<?php

}

//Omit closing PHP tag to avoid accidental whitespace output errors.
