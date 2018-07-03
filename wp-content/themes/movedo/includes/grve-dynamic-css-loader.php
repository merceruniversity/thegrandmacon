<?php
/**
 *  Add Dynamic css to header
 *  @version	1.0
 *  @author		Greatives Team
 *  @URI		http://greatives.eu
 */

if ( !function_exists( 'movedo_grve_load_dynamic_css' ) ) {

	function movedo_grve_load_dynamic_css() {
		include_once get_template_directory() . '/includes/grve-dynamic-typography-css.php';
		include_once get_template_directory() . '/includes/grve-dynamic-css.php';
		if ( movedo_grve_woocommerce_enabled() ) {
			include_once get_template_directory() . '/includes/grve-dynamic-woo-css.php';
		}
		if ( movedo_grve_events_calendar_enabled() ) {
			include_once get_template_directory() . '/includes/grve-dynamic-event-css.php';
		}
		if ( movedo_grve_bbpress_enabled() ) {
			include_once get_template_directory() . '/includes/grve-dynamic-bbpress-css.php';
		}

		$custom_css_code = movedo_grve_option( 'css_code' );
		if ( !empty( $custom_css_code ) ) {
			wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $custom_css_code ) );
		}

		movedo_grve_add_custom_page_css();
		movedo_grve_get_global_button_style();
		movedo_grve_get_global_shape_style();
	}
}

function movedo_grve_add_custom_page_css( $id = null ) {

	$movedo_grve_custom_css = '';
	$movedo_grve_woo_shop = movedo_grve_is_woo_shop();

	if ( is_front_page() && is_home() ) {
		// Default homepage
		$mode = 'blog';
	} else if ( is_front_page() ) {
		// static homepage
		$mode = 'page';
	} else if ( is_home() ) {
		// blog page
		$mode = 'blog';
	} else if( is_search() ) {
		$mode = 'search_page';
	} else if( movedo_grve_is_bbpress() ) {
		$mode = 'forum';
	} else if ( is_singular() || $movedo_grve_woo_shop ) {
		if ( is_singular( 'post' ) ) {
			$mode = 'post';
		} else if ( is_singular( 'portfolio' ) ) {
			$mode = 'portfolio';
		} else if ( is_singular( 'product' ) ) {
			$mode = 'product';
		} else if ( is_singular( 'tribe_events' ) ) {
			$mode = 'event';
		} else if ( is_singular( 'tribe_organizer' ) || is_singular( 'tribe_venue' ) ) {
			$mode = 'event_tax';
		} else {
			$mode = 'page';
		}
	} else if ( is_archive() ) {
		if( movedo_grve_is_woo_tax() ) {
			$mode = 'product_tax';
		} else if ( movedo_grve_events_calendar_is_overview() || is_post_type_archive( 'tribe_events' ) ) {
			$mode = 'event_tax';
		} else {
			$mode = 'blog';
		}

	} else {
		$mode = 'page';
	}

	$movedo_grve_page_title = array(
		'bg_color' => movedo_grve_option( $mode . '_title_bg_color', 'dark' ),
		'bg_color_custom' => movedo_grve_option( $mode . '_title_bg_color_custom', '#000000' ),
		'content_bg_color' => movedo_grve_option( $mode . '_title_content_bg_color', 'none' ),
		'content_bg_color_custom' => movedo_grve_option( $mode . '_title_content_bg_color_custom', '#ffffff' ),
		'title_color' => movedo_grve_option( $mode . '_title_color', 'light' ),
		'title_color_custom' => movedo_grve_option( $mode . '_title_color_custom', '#ffffff' ),
		'caption_color' => movedo_grve_option( $mode . '_description_color', 'light' ),
		'caption_color_custom' => movedo_grve_option( $mode . '_description_color_custom', '#ffffff' ),
	);

	if ( is_tag() || is_category() || movedo_grve_is_woo_category() || movedo_grve_is_woo_tag() ) {
		$category_id = get_queried_object_id();
		$movedo_grve_custom_title_options = movedo_grve_get_term_meta( $category_id, '_movedo_grve_custom_title_options' );
		$movedo_grve_page_title_custom = movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom' );
		if ( 'custom' == $movedo_grve_page_title_custom ) {
			$movedo_grve_page_title = $movedo_grve_custom_title_options;
		}
	}


	if ( is_singular() || $movedo_grve_woo_shop ) {

		if ( ! $id ) {
			if ( $movedo_grve_woo_shop ) {
				$id = wc_get_page_id( 'shop' );
			} else {
				$id = get_the_ID();
			}
		}
		if ( $id ) {

			//Custom Title
			$movedo_grve_custom_title_options = get_post_meta( $id, '_movedo_grve_custom_title_options', true );
			$movedo_grve_page_title_custom = movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom' );
			if ( !empty( $movedo_grve_page_title_custom ) ) {
				$movedo_grve_page_title = $movedo_grve_custom_title_options;
			}

			//Feature Section
			$feature_section = get_post_meta( $id, '_movedo_grve_feature_section', true );
			$feature_settings = movedo_grve_array_value( $feature_section, 'feature_settings' );
			$feature_element = movedo_grve_array_value( $feature_settings, 'element' );

			if ( !empty( $feature_element ) ) {

				switch( $feature_element ) {

					case 'title':
					case 'image':
					case 'video':
					case 'youtube':
						$single_item = movedo_grve_array_value( $feature_section, 'single_item' );
						if ( !empty( $single_item ) ) {
							$movedo_grve_custom_css .= movedo_grve_get_feature_title_css( $single_item );
						}
						break;
					case 'slider':
						$slider_items = movedo_grve_array_value( $feature_section, 'slider_items' );
						if ( !empty( $slider_items ) ) {
							foreach ( $slider_items as $item ) {
								$movedo_grve_custom_css .= movedo_grve_get_feature_title_css( $item, 'slider' );
							}
						}
						break;
					default:
						break;

				}
			}
		}
	}

	$movedo_grve_custom_css .= movedo_grve_get_title_css( $movedo_grve_page_title );

	if ( ! empty( $movedo_grve_custom_css ) ) {
		wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $movedo_grve_custom_css ) );
	}
}

function movedo_grve_get_feature_title_css( $item, $type = 'single' ) {

	$movedo_grve_custom_css = '';
	$custom_class = '';

	if( 'slider' == $type ) {
		$id = movedo_grve_array_value( $item, 'id' );
		if ( !empty( $id ) ) {
			$custom_class = ' .grve-slider-item-id-' . $id ;
		}
	}

	$content_bg_color = movedo_grve_array_value( $item, 'content_bg_color', 'none' );
	if ( 'custom' == $content_bg_color ) {
		$content_bg_color_custom = movedo_grve_array_value( $item, 'content_bg_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '#grve-feature-section' . esc_attr( $custom_class ) . ' .grve-title-content-wrapper {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'background-color', $content_bg_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$subheading_color = movedo_grve_array_value( $item, 'subheading_color', 'light' );
	if ( 'custom' == $subheading_color ) {
		$subheading_color_custom = movedo_grve_array_value( $item, 'subheading_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '#grve-feature-section' . esc_attr( $custom_class ) . ' .grve-subheading, #grve-feature-section' . esc_attr( $custom_class ) . ' .grve-title-meta {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'color', $subheading_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$title_color = movedo_grve_array_value( $item, 'title_color', 'light' );
	if ( 'custom' == $title_color ) {
		$title_color_custom = movedo_grve_array_value( $item, 'title_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '#grve-feature-section' . esc_attr( $custom_class ) . ' .grve-title {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'color', $title_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$caption_color = movedo_grve_array_value( $item, 'caption_color', 'light' );
	if ( 'custom' == $caption_color ) {
		$caption_color_custom = movedo_grve_array_value( $item, 'caption_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '#grve-feature-section' . esc_attr( $custom_class ) . ' .grve-description {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'color', $caption_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$media_id = movedo_grve_array_value( $item, 'content_image_id', '0' );
	$media_max_height = movedo_grve_array_value( $item, 'content_image_max_height', '150' );
	$media_responsive_max_height = movedo_grve_array_value( $item, 'content_image_responsive_max_height', '50' );

	if( '0' != $media_id ) {
		$movedo_grve_custom_css .= '#grve-feature-section' . esc_attr( $custom_class ) . ' .grve-content .grve-graphic img  {';
		$movedo_grve_custom_css .= 'max-height:' . esc_attr( $media_max_height ) .'px';
		$movedo_grve_custom_css .= '}';

		$movedo_grve_custom_css .= '@media only screen and (max-width: 768px) {';
		$movedo_grve_custom_css .= '#grve-feature-section' . esc_attr( $custom_class ) . ' .grve-content .grve-graphic img  {';
		$movedo_grve_custom_css .= 'max-height:' . esc_attr( $media_responsive_max_height ) .'px';
		$movedo_grve_custom_css .= '}';
		$movedo_grve_custom_css .= '}';
	}

	return $movedo_grve_custom_css;

}

function movedo_grve_get_title_css( $title ) {
	$movedo_grve_custom_css = '';

	$bg_color = movedo_grve_array_value( $title, 'bg_color', 'dark' );
	if ( 'custom' == $bg_color ) {
		$bg_color_custom = movedo_grve_array_value( $title, 'bg_color_custom', '#000000' );
		$movedo_grve_custom_css .= '.grve-page-title {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'background-color', $bg_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$content_bg_color = movedo_grve_array_value( $title, 'content_bg_color', 'none' );
	if ( 'custom' == $content_bg_color ) {
		$content_bg_color_custom = movedo_grve_array_value( $title, 'content_bg_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '.grve-page-title .grve-title-content-wrapper {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'background-color', $content_bg_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$subheading_color = movedo_grve_array_value( $title, 'subheading_color', 'light' );
	if ( 'custom' == $subheading_color ) {
		$subheading_color_custom = movedo_grve_array_value( $title, 'subheading_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '.grve-page-title .grve-title-categories, .grve-page-title .grve-title-meta {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'color', $subheading_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$title_color = movedo_grve_array_value( $title, 'title_color', 'light' );
	if ( 'custom' == $title_color ) {
		$title_color_custom = movedo_grve_array_value( $title, 'title_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '.grve-page-title .grve-title, .grve-page-title .grve-title-meta {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'color', $title_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	$caption_color = movedo_grve_array_value( $title, 'caption_color', 'light' );
	if ( 'custom' == $caption_color ) {
		$caption_color_custom = movedo_grve_array_value( $title, 'caption_color_custom', '#ffffff' );
		$movedo_grve_custom_css .= '.grve-page-title .grve-description {';
		$movedo_grve_custom_css .= movedo_grve_get_css_color( 'color', $caption_color_custom );
		$movedo_grve_custom_css .= '}';
	}

	return $movedo_grve_custom_css;
}

function movedo_grve_get_global_button_style() {

	$movedo_grve_custom_css = "";

	$button_type = movedo_grve_option( 'button_type', 'simple' );
	$button_shape = movedo_grve_option( 'button_shape', 'square' );
	$button_color = movedo_grve_option( 'button_color', 'primary-1' );
	$button_hover_color = movedo_grve_option( 'button_hover_color', 'black' );

	$movedo_grve_colors = movedo_grve_get_color_array();

		$movedo_grve_custom_css .= ".grve-modal input[type='submit']:not(.grve-custom-btn), #grve-theme-wrapper input[type='submit']:not(.grve-custom-btn), #grve-theme-wrapper input[type='reset']:not(.grve-custom-btn), #grve-theme-wrapper input[type='button']:not(.grve-custom-btn), #grve-theme-wrapper button:not(.grve-custom-btn):not(.vc_general), #grve-theme-wrapper .grve-search button[type='submit'], .grve-portfolio-details-btn.grve-btn:not(.grve-custom-btn) {";
			switch( $button_shape ) {
				case "round":
					$movedo_grve_custom_css .= "-webkit-border-radius: 3px;";
					$movedo_grve_custom_css .= "border-radius: 3px;";
				break;
				case "extra-round":
					$movedo_grve_custom_css .= "-webkit-border-radius: 50px;";
					$movedo_grve_custom_css .= "border-radius: 50px;";
				break;
				case "square":
				default:
				break;
			}

			$default_color = movedo_grve_option( 'body_primary_1_color' );
			$color = movedo_grve_array_value( $movedo_grve_colors, $button_color, $default_color );

			if ( "outline" == $button_type ) {

				$movedo_grve_custom_css .= "border: 2px solid;";
				$movedo_grve_custom_css .= "background-color: transparent;";
				//$movedo_grve_custom_css .= "background-image: none;";
				$movedo_grve_custom_css .= "border-color: " . esc_attr( $color ) . ";";
				$movedo_grve_custom_css .= "color: " . esc_attr( $color ) . ";";

			} else {
				$movedo_grve_custom_css .= "background-color: " . esc_attr( $color ) . ";";
				if ( 'white' == $button_color ) {
					$movedo_grve_custom_css .= "color: #bababa;";
				} else {
					$movedo_grve_custom_css .= "color: #ffffff;";
				}
			}


		$movedo_grve_custom_css .= "}";

		$movedo_grve_custom_css .= ".grve-modal input[type='submit']:not(.grve-custom-btn):hover, #grve-theme-wrapper input[type='submit']:not(.grve-custom-btn):hover, #grve-theme-wrapper input[type='reset']:not(.grve-custom-btn):hover, #grve-theme-wrapper input[type='button']:not(.grve-custom-btn):hover, #grve-theme-wrapper button:not(.grve-custom-btn):not(.vc_general):hover,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, #grve-theme-wrapper .grve-search button[type='submit']:hover, .grve-portfolio-details-btn.grve-btn:not(.grve-custom-btn):hover {";

		$hover_color = movedo_grve_array_value( $movedo_grve_colors, $button_hover_color, "#bababa" );

		if ( "outline" == $button_type ) {

			$movedo_grve_custom_css .= "background-color: " . esc_attr( $hover_color ) . ";";
			$movedo_grve_custom_css .= "border-color: " . esc_attr( $hover_color ) . ";";
			if ( 'white' == $button_hover_color ) {
				$movedo_grve_custom_css .= "color: #bababa;";
			} else {
				$movedo_grve_custom_css .= "color: #ffffff;";
			}

		} else {
			$movedo_grve_custom_css .= "background-color: " . esc_attr( $hover_color ) . ";";
			if ( 'white' == $button_hover_color ) {
				$movedo_grve_custom_css .= "color: #bababa;";
			} else {
				$movedo_grve_custom_css .= "color: #ffffff;";
			}
		}

		$movedo_grve_custom_css .= "}";

	wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $movedo_grve_custom_css ) );
}


function movedo_grve_get_global_shape_style() {
	$movedo_grve_custom_css = "";

	$global_shape = movedo_grve_option( 'button_shape', 'square' );

	$movedo_grve_custom_css .= "#grve-related-post .grve-related-title, .grve-nav-btn a, .grve-bar-socials li a, #grve-single-post-tags .grve-tags li a, #grve-single-post-categories .grve-categories li a, .widget.widget_tag_cloud a, #grve-body #grve-theme-wrapper .grve-newsletter input[type='email'], #grve-theme-wrapper .grve-search:not(.grve-search-modal) input[type='text'], #grve-socials-modal .grve-social li a, .grve-pagination ul li, .grve-dropcap span.grve-style-2 {";
	switch( $global_shape ) {
		case "round":
			$movedo_grve_custom_css .= "-webkit-border-radius: 3px !important;";
			$movedo_grve_custom_css .= "border-radius: 3px !important;";
		break;
		case "extra-round":
			$movedo_grve_custom_css .= "-webkit-border-radius: 50px !important;";
			$movedo_grve_custom_css .= "border-radius: 50px !important;";
		break;
		case "square":
		default:
		break;
	}
	$movedo_grve_custom_css .= "}";

	wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $movedo_grve_custom_css ) );
}

function movedo_grve_get_background_css( $value = array() ) {

	$css = '';

	if ( ! empty( $value ) && is_array( $value ) ) {
		foreach ( $value as $key => $value ) {
			if ( ! empty( $value ) && $key != "media" && $key != "skin" && $key != "heading_color" && $key != "text_color"  ) {
				if ( $key == "background-image" ) {
					$css .= $key . ":url('" . $value . "');";
				} else {
					$css .= $key . ":" . $value . ";";
				}
			}
		}
	}

	return $css;
}

 /**
 * Get color array used in theme from theme options and predefined colors
 */
function movedo_grve_get_color_array() {
	return array(
		'primary-1' => movedo_grve_option( 'body_primary_1_color' ),
		'primary-2' => movedo_grve_option( 'body_primary_2_color' ),
		'primary-3' => movedo_grve_option( 'body_primary_3_color' ),
		'primary-4' => movedo_grve_option( 'body_primary_4_color' ),
		'primary-5' => movedo_grve_option( 'body_primary_5_color' ),
		'primary-6' => movedo_grve_option( 'body_primary_6_color' ),
		'light' => '#ffffff',
		'white' => '#ffffff',
		'dark' => '#000000',
		'black' => '#000000',
		'green' => '#6ECA09',
		'red' => '#D0021B',
		'orange' => '#FAB901',
		'aqua' => '#28d2dc',
		'blue' => '#15c7ff',
		'purple' => '#7639e2',
		'grey' => '#e2e2e2',
	);
}

 /**
 * Add dynamic CSS for Page Builder
 */
function movedo_grve_load_dynamic_selector_css() {

	$colors = movedo_grve_get_color_array();
	$css = '';
	foreach ( $colors as $key => $value ) {
		$font_color = '#ffffff';
		if( 'white' == $key || 'light' == $key ) {
			$font_color = '#000000';
		}
		$css .= "
			.grve-colored-dropdown ." . esc_attr( $key ) . " {
				background-color: " . esc_attr( $value ) . ";
				color: " . esc_attr( $font_color ) . ";
			}
		";
	}
	wp_add_inline_style( 'movedo-ext-vc-elements', movedo_grve_compress_css( $css ) );

}
add_action( 'admin_enqueue_scripts' , 'movedo_grve_load_dynamic_selector_css', 11 );


//Omit closing PHP tag to avoid accidental whitespace output errors.
