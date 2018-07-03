<?php

/*
*	Theme update functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

/**
 * Envato Upgrader Check for updates
 */
function movedo_grve_envato_toolkit_update_check() {

	if ( is_super_admin() && 1 == movedo_grve_option('update_enabled') ) {

		$envato_username = movedo_grve_option('update_user_name');
		$envato_api_key = movedo_grve_option('update_api_key');
		$show_admin_notice = false;

		if ( empty( $envato_username ) || empty( $envato_api_key ) ) {
			$message = esc_html__( "To enable theme update notifications, please enter your Envato Marketplace credentials via:", 'movedo' ) . " " . esc_html__( "Theme Options - Theme Update", 'movedo' );
			$message_id = 'theme_update_error';
			$message_type = 'error';
			$show_admin_notice = true;
		} else {

			$current_screen = get_current_screen();

			if ( 'themes' == $current_screen->id || 'toplevel_page_movedo_grve_options' == $current_screen->id ) {

				// Check for updates
				$upgrader = new Envato_WordPress_Theme_Upgrader( $envato_username, $envato_api_key );
				$updates = $upgrader->check_for_theme_update( 'Movedo' );

				$current_theme = wp_get_theme( 'movedo' );
				$update_needed = false;

				//check is current theme up to date
				if ( isset($updates->updated_themes) ) {
					foreach ( $updates->updated_themes as $updated_theme ) {

						if ( $updated_theme->version == $current_theme->version && $updated_theme->name == $current_theme->name ) {
							$update_needed = true;
						}
					}
				}

				if ( !empty( $updates->errors ) ) {
					$message = esc_html__( "Theme Updater Error:", 'movedo' ) . implode( '<br \>', $updates->errors );
					$message_id = 'theme_update_error';
					$message_type = 'error';
					$show_admin_notice = true;
				} else if ( $update_needed ) {
					$change_log_url = "http://greatives.eu/themes/updates/movedo/";

					$message = esc_html__( "New version of theme is available!", 'movedo' ) . " " .
						esc_html__( "View", 'movedo' ) . " " .
						"<a href='" . esc_url( $change_log_url ) . "' target='_blank'>" .
						esc_html__( "changelog", 'movedo' ) .
						"</a>.<br/>" . esc_html__( "It is recommended to make a backup before performing an update.", 'movedo' ) . "<br/>" .
						esc_html__( "To update click", 'movedo' ) . " " .
						"<a href='" . esc_url( admin_url() ) . "themes.php?theme=movedo&grve-theme-update=update'>" .
						esc_html__( "here", 'movedo' ) .
						"</a>.";
					$message_id = 'theme_update_available';
					$message_type = 'updated';
					$show_admin_notice = true;
				}
			}
		}

		if ( $show_admin_notice ) {
			add_settings_error(
				'grve-theme-update-message',
				esc_attr( $message_id ),
				$message,
				$message_type
			);
		}
	}

}
add_action( 'admin_head', 'movedo_grve_envato_toolkit_update_check' );

/**
 * Envato Upgrader Theme Update
 */
function movedo_grve_envato_toolkit_update() {

	if ( isset($_GET['grve-theme-update']) && 'update' == $_GET['grve-theme-update'] ) {
		if ( is_super_admin() && 1 == movedo_grve_option('update_enabled') ) {

			$envato_username = movedo_grve_option('update_user_name');
			$envato_api_key = movedo_grve_option('update_api_key');

			if ( empty( $envato_username ) || empty( $envato_api_key ) ) {
				return;
			} else {
				$upgrader = new Envato_WordPress_Theme_Upgrader( $envato_username, $envato_api_key );
				$update_response = $upgrader->upgrade_theme( 'Movedo' );
			}
			wp_safe_redirect( esc_url( remove_query_arg('grve-theme-update') ) );
		}
	}

}
add_action( 'admin_init', 'movedo_grve_envato_toolkit_update' );

/**
 * Display theme update notices in the admin area
 */
function movedo_grve_theme_update_admin_notices() {
     settings_errors( 'grve-theme-update-message' );
}
add_action( 'admin_notices', 'movedo_grve_theme_update_admin_notices' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
