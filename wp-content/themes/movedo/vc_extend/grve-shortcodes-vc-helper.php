<?php
/*
*	Greatives Visual Composer Shortcode helper functions
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

function movedo_grve_vc_social_elements_visibility() {
	$visibility = apply_filters( 'movedo_grve_vc_social_elements_visibility', false );
	return $visibility;
}
function movedo_grve_vc_wp_elements_visibility() {
	$visibility = apply_filters( 'movedo_grve_vc_wp_elements_visibility', false );
	return $visibility;
}
function movedo_grve_vc_grid_visibility() {
	$visibility = movedo_grve_visibility( 'vc_grid_visibility' );
	$visibility = apply_filters( 'movedo_grve_vc_grid_visibility', $visibility );
	return $visibility;
}
function movedo_grve_vc_charts_visibility() {
	$visibility = movedo_grve_visibility( 'vc_charts_visibility' );
	$visibility = apply_filters( 'movedo_grve_vc_charts_visibility', $visibility );
	return $visibility;
}
function movedo_grve_vc_woo_visibility() {
	$visibility = movedo_grve_visibility( 'vc_woo_visibility' );
	$visibility = apply_filters( 'movedo_grve_vc_woo_visibility', $visibility );
	// return $visibility;
	return true;
}
function movedo_grve_vc_other_elements_visibility() {
	$visibility = apply_filters( 'movedo_grve_vc_other_elements_visibility', false );
	return $visibility;
}

function movedo_grve_build_shortcode_img_style( $bg_image = '' , $bg_image_size = '' ) {

	$has_image = false;
	$style = '';

	if((int)$bg_image > 0 && ($attachment_src = wp_get_attachment_image_src( $bg_image, 'movedo-grve-fullscreen' )) !== false) {

		$image_url = $attachment_src[0];
		//Adaptive Background URL
		if ( empty ( $bg_image_size ) ) {
			$bg_image_size = movedo_grve_option( 'row_section_bg_size' );
		}
		$image_url = movedo_grve_get_adaptive_url( $bg_image, $bg_image_size );

		$has_image = true;
		$style .= "background-image: url(" . esc_url( $image_url ) . ");";
	} else {
		$image_url = movedo_grve_get_fallback_image( $bg_image_size ,'url' );
		$style .= "background-image: url(" . esc_url( $image_url ) . ");";
	}
	return ' style="'. $style . '"';

}

function movedo_grve_vc_shortcode_img_url( $bg_image = '' , $bg_image_size = '' ) {
	if((int)$bg_image > 0 && ($attachment_src = wp_get_attachment_image_src( $bg_image, 'movedo-grve-fullscreen' )) !== false) {
		$image_url = $attachment_src[0];
		if ( empty ( $bg_image_size ) ) {
			$bg_image_size = movedo_grve_option( 'row_section_bg_size' );
		}
		$image_url = movedo_grve_get_adaptive_url( $bg_image, $bg_image_size );
	} else {
		$image_url = '';
	}
	return $image_url;

}

function movedo_grve_vc_shortcode_custom_css_class( $param_value, $prefix = '' ) {
	$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';
	return $css_class;
}

function movedo_grve_build_shortcode_style( $item = array() ) {


	$bg_color = movedo_grve_array_value( $item, 'bg_color' );
	$bg_gradient_color_1 = movedo_grve_array_value( $item, 'bg_gradient_color_1' );
	$bg_gradient_color_2 = movedo_grve_array_value( $item, 'bg_gradient_color_2' );
	$bg_gradient_direction = movedo_grve_array_value( $item, 'bg_gradient_direction' );
	$font_color = movedo_grve_array_value( $item, 'font_color' );
	$padding_top = movedo_grve_array_value( $item, 'padding_top');
	$padding_bottom = movedo_grve_array_value( $item, 'padding_bottom' );
	$margin_bottom = movedo_grve_array_value( $item, 'margin_bottom' );
	$position_top = movedo_grve_array_value( $item, 'position_top' );
	$position_bottom = movedo_grve_array_value( $item, 'position_bottom' );
	$position_left = movedo_grve_array_value( $item, 'position_left' );
	$position_right = movedo_grve_array_value( $item, 'position_right' );
	$z_index = movedo_grve_array_value( $item, 'z_index' );

	$style = '';

	if(!empty($bg_color)) {
		$style .= movedo_grve_get_css_color( 'background-color', $bg_color );
	}

	if( !empty($bg_gradient_color_1) && !empty($bg_gradient_color_2) && !empty($bg_gradient_direction) ) {
		$style .= movedo_grve_get_css_color( 'background', $bg_gradient_color_1 );
		$style .= 'background: linear-gradient(' . $bg_gradient_direction. 'deg,' . $bg_gradient_color_1 . ' 0%,' . $bg_gradient_color_2 .' 100%);';
	}

	if( !empty($font_color) ) {
		$style .= movedo_grve_get_css_color( 'color', $font_color );
	}
	if( $padding_top != '' ) {
		$style .= 'padding-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_top) ? $padding_top : $padding_top.'px').';';
	}
	if( $padding_bottom != '' ) {
		$style .= 'padding-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_bottom) ? $padding_bottom : $padding_bottom.'px').';';
	}
	if( $margin_bottom != '' ) {
		$style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom.'px').';';
	}
	if( $position_top != '' ) {
		$style .= 'top: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_top) ? $position_top : $position_top.'px').';';
	}
	if( $position_bottom != '' ) {
		$style .= 'bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_bottom) ? $position_bottom : $position_bottom.'px').';';
	}
	if( $position_left != '' ) {
		$style .= 'left: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_left) ? $position_left : $position_left.'px').';';
	}
	if( $position_right != '' ) {
		$style .= 'right: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_right) ? $position_right : $position_right.'px').';';
	}
	if( $z_index != '' ) {
		$style .= 'z-index:' . $z_index;
	}

	return empty($style) ? $style : ' style="'.$style.'"';
}



if ( !movedo_grve_vc_grid_visibility() ) {

	//Remove Builder Grid Menu
	function movedo_grve_remove_vc_menu_items( ){
		remove_menu_page( 'edit.php?post_type=vc_grid_item' );
		remove_submenu_page( 'vc-general', 'edit.php?post_type=vc_grid_item' );
	}
	add_filter( 'admin_menu', 'movedo_grve_remove_vc_menu_items' );

	//Remove grid element shortcodes
	function movedo_grve_vc_remove_shortcodes_from_vc_grid_element( $shortcodes ) {
		unset( $shortcodes['vc_icon'] );
		unset( $shortcodes['vc_button2'] );
		unset( $shortcodes['vc_btn'] );
		unset( $shortcodes['vc_custom_heading'] );
		unset( $shortcodes['vc_single_image'] );
		unset( $shortcodes['vc_empty_space'] );
		unset( $shortcodes['vc_separator'] );
		unset( $shortcodes['vc_text_separator'] );
		unset( $shortcodes['vc_gitem_post_title'] );
		unset( $shortcodes['vc_gitem_post_excerpt'] );
		unset( $shortcodes['vc_gitem_post_date'] );
		unset( $shortcodes['vc_gitem_image'] );
		unset( $shortcodes['vc_gitem_post_meta'] );

	  return $shortcodes;
	}
	add_filter( 'vc_grid_item_shortcodes', 'movedo_grve_vc_remove_shortcodes_from_vc_grid_element', 100 );
}
//Remove all default templates.
add_filter( 'vc_load_default_templates', 'movedo_grve_remove_custom_template_array' );
function movedo_grve_remove_custom_template_array( $data ) {
	return array();
}

/**
 * VC Disable Updater Functions
 */
function movedo_grve_vc_disable_updater_dialog() {

	$auto_updater = movedo_grve_visibility( 'vc_auto_updater' );
	if( !$auto_updater ) {
		global $vc_manager;

		if ( $vc_manager && method_exists( $vc_manager , 'disableUpdater' ) ) {
			$vc_manager->disableUpdater( true );
		}
	}
}
add_action( 'vc_before_init', 'movedo_grve_vc_disable_updater_dialog', 9 );

function movedo_grve_vc_disable_updater() {

	$auto_updater = movedo_grve_visibility( 'vc_auto_updater' );
	if( !$auto_updater ) {
		global $vc_manager;

		if ( $vc_manager && method_exists( $vc_manager , 'updater' ) ) {
			$updater = $vc_manager->updater();
			remove_filter( 'upgrader_pre_download', array( $updater, 'preUpgradeFilter' ), 10, 4 );
			remove_action( 'wp_ajax_nopriv_vc_check_license_key', array( $updater, 'checkLicenseKeyFromRemote' ) );

			if ( $updater && method_exists( $updater , 'updateManager' ) ) {
				$updatingManager = $updater->updateManager();
				remove_filter( 'pre_set_site_transient_update_plugins', array( $updatingManager, 'check_update' ) );
				remove_filter( 'plugins_api', array( $updatingManager, 'check_info' ), 10, 3 );
				if ( function_exists( 'vc_plugin_name' ) ) {
					remove_action( 'after_plugin_row_' . vc_plugin_name(), 'wp_plugin_update_row', 10, 2 );
					remove_action( 'in_plugin_update_message-' . vc_plugin_name(), array( $updatingManager, 'addUpgradeMessageLink' ) );
				}
			}
		}
		if ( $vc_manager && method_exists( $vc_manager , 'license' ) ) {
			$license = $vc_manager->license();
			remove_action( 'admin_notices', array( $license, 'adminNoticeLicenseActivation' ) );
		}
	}
}
add_action( 'admin_init', 'movedo_grve_vc_disable_updater', 99 );

function movedo_grve_vc_license_tab_notice() {
	$auto_updater = movedo_grve_visibility( 'vc_auto_updater' );
	if( $auto_updater ) {
		$screen = get_current_screen();
		if ( 'visual-composer_page_vc-updater' == $screen->id ) {
			echo '<div class="error"><p><strong>'. esc_html__( 'Activating Visual Composer plugin is optional and NOT required for the functionality of the Theme. In every new release of the Theme the latest compatible version of Visual Composer is included.', 'movedo' ) .'</strong></p></div>';
		}
	}
}
add_action( 'admin_notices', 'movedo_grve_vc_license_tab_notice' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
