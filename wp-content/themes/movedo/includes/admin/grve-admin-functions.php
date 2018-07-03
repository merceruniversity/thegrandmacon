<?php

/*
*	Admin functions and definitions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

/**
 * Default hidden metaboxes for portfolio
 */
function movedo_grve_change_default_hidden( $hidden, $screen ) {
    if ( 'portfolio' == $screen->id ) {
        $hidden = array_flip( $hidden );
        unset( $hidden['portfolio_categorydiv'] ); //show portfolio category box
        $hidden = array_flip( $hidden );
        $hidden[] = 'postexcerpt';
		$hidden[] = 'postcustom';
		$hidden[] = 'commentstatusdiv';
		$hidden[] = 'commentsdiv';
		$hidden[] = 'authordiv';
    }
    return $hidden;
}
add_filter( 'default_hidden_meta_boxes', 'movedo_grve_change_default_hidden', 10, 2 );

/**
 * Enqueue scripts and styles for the back end.
 */
function movedo_grve_backend_scripts( $hook ) {
	global $post, $pagenow;

	wp_register_style( 'movedo-grve-page-feature-section', get_template_directory_uri() . '/includes/css/grve-page-feature-section.css', array(), '1.0.0' );
	wp_register_style( 'movedo-grve-admin-meta', get_template_directory_uri() . '/includes/css/grve-admin-meta.css', array(), '1.0' );
	wp_register_style( 'movedo-grve-custom-sidebars', get_template_directory_uri() . '/includes/css/grve-custom-sidebars.css', array(), '1.0'  );
	wp_register_style( 'movedo-grve-custom-nav-menu', get_template_directory_uri() . '/includes/css/grve-custom-nav-menu.css', array(), '1.0'  );
	wp_register_style( 'select2-css', get_template_directory_uri() . '/includes/admin/extensions/vendor_support/vendor/select2/select2.css', array(), time() );

	$movedo_grve_upload_slider_texts = array(
		'modal_title' => esc_html__( 'Insert Images', 'movedo' ),
		'modal_button_title' => esc_html__( 'Insert Images', 'movedo' ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	);

	$movedo_grve_upload_image_replace_texts = array(
		'modal_title' => esc_html__( 'Replace Image', 'movedo' ),
		'modal_button_title' => esc_html__( 'Replace Image', 'movedo' ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	);

	$movedo_grve_upload_media_texts = array(
		'modal_title' => esc_html__( 'Insert Media', 'movedo' ),
		'modal_button_title' => esc_html__( 'Insert Media', 'movedo' ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	);

	$movedo_grve_upload_image_texts = array(
		'modal_title' => esc_html__( 'Insert Image', 'movedo' ),
		'modal_button_title' => esc_html__( 'Insert Image', 'movedo' ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	);

	$movedo_grve_feature_section_texts = array(
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	);

	$movedo_grve_custom_sidebar_texts = array(
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	);

	wp_register_script( 'movedo-grve-custom-sidebars', get_template_directory_uri() . '/includes/js/grve-custom-sidebars.js', array( 'jquery'), false, '1.0.0' );
	wp_localize_script( 'movedo-grve-custom-sidebars', 'movedo_grve_custom_sidebar_texts', $movedo_grve_custom_sidebar_texts );

	wp_register_script( 'movedo-grve-upload-slider-script', get_template_directory_uri() . '/includes/js/grve-upload-slider.js', array( 'jquery'), false, '1.0.0' );
	wp_localize_script( 'movedo-grve-upload-slider-script', 'movedo_grve_upload_slider_texts', $movedo_grve_upload_slider_texts );

	wp_register_script( 'movedo-grve-upload-feature-slider-script', get_template_directory_uri() . '/includes/js/grve-upload-feature-slider.js', array( 'jquery'), false, '1.2.2' );
	wp_localize_script( 'movedo-grve-upload-feature-slider-script', 'movedo_grve_upload_feature_slider_texts', $movedo_grve_upload_slider_texts );

	wp_register_script( 'movedo-grve-upload-image-replace-script', get_template_directory_uri() . '/includes/js/grve-upload-image-replace.js', array( 'jquery'), false, '2.2.1' );
	wp_localize_script( 'movedo-grve-upload-image-replace-script', 'movedo_grve_upload_image_replace_texts', $movedo_grve_upload_image_replace_texts );

	wp_register_script( 'movedo-grve-upload-simple-media-script', get_template_directory_uri() . '/includes/js/grve-upload-simple.js', array( 'jquery'), false, '1.0.0' );
	wp_localize_script( 'movedo-grve-upload-simple-media-script', 'movedo_grve_upload_media_texts', $movedo_grve_upload_media_texts );

	wp_register_script( 'movedo-grve-upload-image-script', get_template_directory_uri() . '/includes/js/grve-upload-image.js', array( 'jquery'), false, '1.0.0' );
	wp_localize_script( 'movedo-grve-upload-image-script', 'movedo_grve_upload_image_texts', $movedo_grve_upload_image_texts );

	wp_register_script( 'movedo-grve-page-feature-section-script', get_template_directory_uri() . '/includes/js/grve-page-feature-section.js', array( 'jquery', 'wp-color-picker' ), false, '1.5.6' );
	wp_localize_script( 'movedo-grve-page-feature-section-script', 'movedo_grve_feature_section_texts', $movedo_grve_feature_section_texts );

	wp_register_script( 'movedo-grve-post-options-script', get_template_directory_uri() . '/includes/js/grve-post-options.js', array( 'jquery'), false, '1.0.0' );
	wp_register_script( 'movedo-grve-portfolio-options-script', get_template_directory_uri() . '/includes/js/grve-portfolio-options.js', array( 'jquery'), false, '1.4.8' );

	wp_register_script( 'movedo-grve-custom-nav-menu-script', get_template_directory_uri().'/includes/js/grve-custom-nav-menu.js', array( 'jquery'), false, '1.0.0' );

	wp_register_script( 'select2-js', get_template_directory_uri().'/includes/admin/extensions/vendor_support/vendor/select2/select2.js', array( 'jquery'), false, time() );


	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {

		$enable_select2 = false;
		if ( 'product' != $post->post_type && 'tribe_events' != $post->post_type ) {
			$enable_select2 = true;
		}

		$feature_section_post_types = movedo_grve_option( 'feature_section_post_types' );

		if ( !empty( $feature_section_post_types ) && in_array( $post->post_type, $feature_section_post_types ) && 'attachment' != $post->post_type ) {

			wp_enqueue_style( 'movedo-grve-admin-meta' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'movedo-grve-page-feature-section' );
			if ( $enable_select2 ) {
				wp_enqueue_style( 'select2-css' );
			}

			wp_enqueue_script( 'movedo-grve-upload-simple-media-script' );
			wp_enqueue_script( 'movedo-grve-upload-image-script' );
			wp_enqueue_script( 'movedo-grve-upload-slider-script' );
			wp_enqueue_script( 'movedo-grve-upload-feature-slider-script' );
			wp_enqueue_script( 'movedo-grve-upload-image-replace-script' );

			wp_enqueue_script( 'movedo-grve-page-feature-section-script' );
			if ( $enable_select2 ) {
				wp_enqueue_script( 'select2-js' );
			}
		}


        if ( 'post' === $post->post_type ) {

			wp_enqueue_style( 'movedo-grve-admin-meta' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'movedo-grve-page-feature-section' );
			wp_enqueue_style( 'select2-css' );

			wp_enqueue_script( 'movedo-grve-upload-simple-media-script' );
			wp_enqueue_script( 'movedo-grve-upload-image-script' );
			wp_enqueue_script( 'movedo-grve-upload-slider-script' );
			wp_enqueue_script( 'movedo-grve-upload-feature-slider-script' );
			wp_enqueue_script( 'movedo-grve-upload-image-replace-script' );
			wp_enqueue_script( 'movedo-grve-page-feature-section-script' );
			wp_enqueue_script( 'select2-js' );
			wp_enqueue_script( 'movedo-grve-post-options-script' );

        } else if ( 'page' === $post->post_type || 'portfolio' === $post->post_type || 'product' === $post->post_type || 'tribe_events' === $post->post_type ) {

			wp_enqueue_style( 'movedo-grve-admin-meta' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'movedo-grve-page-feature-section' );
			if ( $enable_select2 ) {
				wp_enqueue_style( 'select2-css' );
			}

			wp_enqueue_script( 'movedo-grve-upload-simple-media-script' );
			wp_enqueue_script( 'movedo-grve-upload-image-script' );
			wp_enqueue_script( 'movedo-grve-upload-slider-script' );
			wp_enqueue_script( 'movedo-grve-upload-feature-slider-script' );
			wp_enqueue_script( 'movedo-grve-upload-image-replace-script' );
			if ( $enable_select2 ) {
				wp_enqueue_script( 'select2-js' );
			}
			wp_enqueue_script( 'movedo-grve-page-feature-section-script' );

			wp_enqueue_script( 'movedo-grve-portfolio-options-script' );

        } else if ( 'testimonial' === $post->post_type ) {

			wp_enqueue_style( 'movedo-grve-admin-meta' );

        }
    }

	if ( $hook == 'edit-tags.php' || $hook == 'term.php') {
		wp_enqueue_style( 'movedo-grve-admin-meta' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'movedo-grve-page-feature-section' );


		wp_enqueue_media();
		wp_enqueue_script( 'movedo-grve-page-feature-section-script' );
		wp_enqueue_script( 'movedo-grve-upload-image-script' );
		wp_enqueue_script( 'movedo-grve-upload-image-replace-script' );

	}

	if ( $hook == 'nav-menus.php' ) {
		wp_enqueue_style( 'movedo-grve-custom-nav-menu' );

		wp_enqueue_media();
		wp_enqueue_script( 'movedo-grve-upload-simple-media-script' );
		wp_enqueue_script( 'movedo-grve-custom-nav-menu-script' );
	}

	if ( isset( $_GET['page'] ) && ( 'movedo-grve-custom-sidebar-settings' == $_GET['page'] ) ) {

		wp_enqueue_style( 'movedo-grve-custom-sidebars' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'movedo-grve-custom-sidebars' );
	}

	wp_register_style(
		'redux-custom-css',
		get_template_directory_uri() . '/includes/css/grve-redux-panel.css',
		array(),
		time(),
		'all'
	);
	wp_enqueue_style( 'redux-custom-css' );



}
add_action( 'admin_enqueue_scripts', 'movedo_grve_backend_scripts', 10, 1 );

/**
 * Helper function to get custom fields with fallback
 */
function movedo_grve_post_meta( $id, $fallback = false ) {
	global $post;
	$post_id = $post->ID;
	if ( $fallback == false ) $fallback = '';
	$post_meta = get_post_meta( $post_id, $id, true );
	$output = ( $post_meta !== '' ) ? $post_meta : $fallback;
	return $output;
}

function movedo_grve_admin_post_meta( $post_id, $id, $fallback = false ) {
	if ( $fallback == false ) $fallback = '';
	$post_meta = get_post_meta( $post_id, $id, true );
	$output = ( $post_meta !== '' ) ? $post_meta : $fallback;
	return $output;
}

function movedo_grve_get_term_meta( $term_id, $meta_key ) {
	$movedo_grve_term_meta  = '';

	if ( function_exists( 'get_term_meta' ) ) {
		$movedo_grve_term_meta = get_term_meta( $term_id, $meta_key, true );
	}
	if( empty ( $movedo_grve_term_meta ) ) {
		$movedo_grve_term_meta = array();
	}
	return $movedo_grve_term_meta;
}

function movedo_grve_update_term_meta( $term_id , $meta_key, $meta_value ) {

	if ( function_exists( 'update_term_meta' ) ) {
		update_term_meta( $term_id, $meta_key, $meta_value );
	}
}

/**
 * Helper function to get theme options with fallback
 */
function movedo_grve_option( $id, $fallback = false, $param = false ) {
	global $movedo_grve_options;
	$grve_theme_options = $movedo_grve_options;

	if ( $fallback == false ) $fallback = '';
	$output = ( isset($grve_theme_options[$id]) && $grve_theme_options[$id] !== '' ) ? $grve_theme_options[$id] : $fallback;
	if ( !empty($grve_theme_options[$id]) && $param ) {
		$output = ( isset($grve_theme_options[$id][$param]) && $grve_theme_options[$id][$param] !== '' ) ? $grve_theme_options[$id][$param] : $fallback;
		if ( 'font-family' == $param ) {
			$output = urldecode( $output );
			if ( strpos($output, ' ') && !strpos($output, ',') ) {
				$output = '"' . $output . '"';
			}
		}
	}
	return $output;
}

/**
 * Helper function to print css code if not empty
 */
function movedo_grve_css_option( $id, $fallback = false, $param = false ) {
	$option = movedo_grve_option( $id, $fallback, $param );
	if ( !empty( $option ) && 0 !== $option && $param ) {
		return $param . ': ' . $option . ';';
	}
}

/**
 * Helper function to get array value with fallback
 */
function movedo_grve_array_value( $input_array, $id, $fallback = false, $param = false ) {

	if ( $fallback == false ) $fallback = '';
	$output = ( isset($input_array[$id]) && $input_array[$id] !== '' ) ? $input_array[$id] : $fallback;
	if ( !empty($input_array[$id]) && $param ) {
		$output = ( isset($input_array[$id][$param]) && $input_array[$id][$param] !== '' ) ? $input_array[$id][$param] : $fallback;
	}
	return $output;
}

/**
 * Helper function to return trimmed css code
 */
if ( ! function_exists( 'movedo_grve_compress_css' ) ) {
	function movedo_grve_compress_css( $css ) {
		$css_trim =  preg_replace( '/\s+/', ' ', $css );
		return $css_trim;
	}
}

/**
 * Helper functions to set/get current template
 */
function movedo_grve_set_current_view( $id ) {
	global $movedo_grve_options;
	$movedo_grve_options['current_view'] = $id;
}
function movedo_grve_get_current_view( $fallback = '' ) {
	global $movedo_grve_options;
	$movedo_grve_theme_options = $movedo_grve_options;

	if ( $fallback == false ) $fallback = '';
	$output = ( isset($movedo_grve_theme_options['current_view']) && $movedo_grve_theme_options['current_view'] !== '' ) ? $movedo_grve_theme_options['current_view'] : $fallback;
	return $output;
}

/**
 * Helper function convert hex to rgb
 */
function movedo_grve_hex2rgb( $hex ) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1) );
		$g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1) );
		$b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1) );
	} else {
		$r = hexdec( substr( $hex, 0, 2) );
		$g = hexdec( substr( $hex, 2, 2) );
		$b = hexdec( substr( $hex, 4, 2) );
	}
	$rgb = array($r, $g, $b);
	return implode(",", $rgb);
}

/**
 * Helper function to get theme visibility options
 */
function movedo_grve_visibility( $id, $fallback = '' ) {
	$visibility = movedo_grve_option( $id, $fallback  );
	if ( '1' == $visibility ) {
		return true;
	}
	return false;
}

/**
 * Get Color
 */
function movedo_grve_get_color( $color = 'dark', $color_custom = '#000000' ) {

	switch( $color ) {

		case 'dark':
			$color_custom = '#000000';
			break;
		case 'light':
			$color_custom = '#ffffff';
			break;
		case 'primary-1':
			$color_custom = movedo_grve_option( 'body_primary_1_color' );
			break;
		case 'primary-2':
			$color_custom = movedo_grve_option( 'body_primary_2_color' );
			break;
		case 'primary-3':
			$color_custom = movedo_grve_option( 'body_primary_3_color' );
			break;
		case 'primary-4':
			$color_custom = movedo_grve_option( 'body_primary_4_color' );
			break;
		case 'primary-5':
			$color_custom = movedo_grve_option( 'body_primary_5_color' );
			break;
		case 'primary-6':
			$color_custom = movedo_grve_option( 'body_primary_6_color' );
			break;
	}

	return $color_custom;
}

/**
 * Backend Theme Activation Actions
 */
function movedo_grve_backend_theme_activation() {
	global $pagenow;

	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {

		$catalog = array(
			'width'   => '500',    // px
			'height'  => '500',    // px
			'crop'	  => 1,        // true
		);

		$single = array(
			'width'   => '800',    // px
			'height'  => '800',    // px
			'crop'    => 1,        // true
		);

		$thumbnail = array(
			'width'   => '120',    // px
			'height'  => '120',    // px
			'crop'    => 1,        // true
		);

		update_option( 'shop_catalog_image_size', $catalog );
		update_option( 'shop_single_image_size', $single );
		update_option( 'shop_thumbnail_image_size', $thumbnail );
		update_option( 'woocommerce_enable_lightbox', false );

		//Redirect to Theme Options
		header( 'Location: ' . admin_url() . 'admin.php?page=movedo_grve_options&tab=0' ) ;
	}
}

add_action('admin_init','movedo_grve_backend_theme_activation');

/**
 * Check if Revolution slider is active
 */

/**
 * Check if to replace Backend Logo
 */
function movedo_grve_admin_login_logo() {

	$replace_logo = movedo_grve_option( 'replace_admin_logo' );
	if ( $replace_logo ) {
		$admin_logo = movedo_grve_option( 'admin_logo','','url' );
		$admin_logo_height = movedo_grve_option( 'admin_logo_height','84');
		$admin_logo_height = preg_match('/(px|em|\%|pt|cm)$/', $admin_logo_height) ? $admin_logo_height : $admin_logo_height . 'px';
		if( empty( $admin_logo ) ) {
			$admin_logo = movedo_grve_option( 'logo','','url' );
		}
		if ( !empty( $admin_logo ) ) {
			$admin_logo = str_replace( array( 'http:', 'https:' ), '', $admin_logo );
			echo "
			<style>
			.login h1 a {
				background-image: url('" . esc_url( $admin_logo ) . "');
				width: 100%;
				max-width: 300px;
				background-size: auto " . esc_attr( $admin_logo_height ) . ";
				height: " . esc_attr( $admin_logo_height ) . ";
			}
			</style>
			";
		}
	}
}
add_action( 'login_head', 'movedo_grve_admin_login_logo' );

function movedo_grve_login_headerurl( $url ){
	$replace_logo = movedo_grve_option( 'replace_admin_logo' );
	if ( $replace_logo ) {
		return esc_url( home_url( '/' ) );
	}
	return esc_url( $url );
}
add_filter('login_headerurl', 'movedo_grve_login_headerurl');

function movedo_grve_login_headertitle( $title ) {
	$replace_logo = movedo_grve_option( 'replace_admin_logo' );
	if ( $replace_logo ) {
		return esc_attr( get_bloginfo( 'name' ) );
	}
	return esc_attr( $title );
}
add_filter('login_headertitle', 'movedo_grve_login_headertitle' );

/**
 * Disable SEO Page Analysis
 */
function movedo_grve_disable_page_analysis( $bool ) {
	if( '1' == movedo_grve_option( 'disable_seo_page_analysis', '0' ) ) {
		return false;
	}
	return $bool;
}
add_filter( 'wpseo_use_page_analysis', 'movedo_grve_disable_page_analysis' );



/**
 * Scroll Check
 */
if ( ! function_exists( 'movedo_grve_scroll_check' ) ) {
	function movedo_grve_scroll_check() {
		$scroll_mode = movedo_grve_option( 'scroll_mode', 'auto' );
		if ( 'on' == $scroll_mode ) {
			return true;
		} elseif ( 'off' == $scroll_mode ) {
			return false;
		} else {
			return movedo_grve_browser_webkit_check();
		}
	}
}

/**
 * Browser Webkit Check
 */
if ( ! function_exists( 'movedo_grve_browser_webkit_check' ) ) {
	function movedo_grve_browser_webkit_check() {
		if ( empty($_SERVER['HTTP_USER_AGENT'] ) ) {
			return false;
		}

		$u_agent = $_SERVER['HTTP_USER_AGENT'];

		if (
			( preg_match( '!linux!i', $u_agent ) || preg_match( '!windows|win32!i', $u_agent ) ) && preg_match( '!webkit!i', $u_agent )
		) {
			return true;
		}

		return false;
	}
}

/**
 * Add Hooks for Page Redirect ( Coming Soon )
 */
add_filter( 'template_include', 'movedo_grve_redirect_page_template', 99 );

if ( ! function_exists( 'movedo_grve_redirect_page_template' ) ) {
	function movedo_grve_redirect_page_template( $template ) {
		if ( movedo_grve_visibility('coming_soon_enabled' )  && !is_user_logged_in() ) {
			$redirect_page = movedo_grve_option( 'coming_soon_page' );
			$redirect_template = movedo_grve_option( 'coming_soon_template' );
			if ( !empty( $redirect_page ) && 'content' == $redirect_template ) {
				$new_template = locate_template( array( 'page-templates/template-content-only.php' ) );
				if ( '' != $new_template ) {
					return $new_template ;
				}
			}
		}
		return $template;
	}
}

add_filter( 'template_redirect', 'movedo_grve_redirect' );

if ( ! function_exists( 'movedo_grve_redirect' ) ) {
	function movedo_grve_redirect() {
		if ( movedo_grve_visibility('coming_soon_enabled' ) && !is_user_logged_in() ) {
			$redirect_page = movedo_grve_option( 'coming_soon_page' );
			$protocol = is_ssl() ? 'https://' : 'http://';

			if ( !empty( $redirect_page )
				&& !in_array( $GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php') )
				&& !is_admin()
				&& ( $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] != get_permalink( $redirect_page ) ) ) {

				wp_redirect( get_permalink( $redirect_page ) );
				exit();

			}
		}
		return false;
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
