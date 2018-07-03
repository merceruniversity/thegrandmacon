<?php
/*
*	Admin Custom Sidebars
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

	function movedo_grve_add_sidebar_settings() {
	
		if ( isset( $_POST['_movedo_grve_nonce_sidebar_save'] ) && wp_verify_nonce( $_POST['_movedo_grve_nonce_sidebar_save'], 'movedo_grve_nonce_sidebar_save' ) ) {

			$sidebars_items = array();
			if( isset( $_POST['_movedo_grve_custom_sidebar_item_id'] ) ) {
				$num_of_sidebars = sizeof( $_POST['_movedo_grve_custom_sidebar_item_id'] );
				for ( $i=0; $i < $num_of_sidebars; $i++ ) {
					$this_sidebar = array (
						'id' => $_POST['_movedo_grve_custom_sidebar_item_id'][ $i ],
						'name' => $_POST['_movedo_grve_custom_sidebar_item_name'][ $i ],
					);
					array_push( $sidebars_items, $this_sidebar );
				}
			}
			if ( empty( $sidebars_items ) ) {
				delete_option( '_movedo_grve_custom_sidebars' );
			} else {
				update_option( '_movedo_grve_custom_sidebars', $sidebars_items );
			}
			//Update Sidebar list
			wp_get_sidebars_widgets();
			wp_safe_redirect( 'themes.php?page=movedo-grve-custom-sidebar-settings&sidebar-settings=saved' );
			
		}
					
		add_theme_page(
			esc_html__( 'Sidebars', 'movedo' ),
			esc_html__( 'Sidebars', 'movedo' ),
			'manage_options',
			'movedo-grve-custom-sidebar-settings',
			'movedo_grve_show_sidebar_settings'
		);

	}

	add_action( 'admin_menu', 'movedo_grve_add_sidebar_settings' );

	function movedo_grve_show_sidebar_settings() {
		$movedo_grve_custom_sidebars = get_option( '_movedo_grve_custom_sidebars' );
?>
	<div id="grve-sidebar-wrap" class="wrap">
		<h2><?php esc_html_e( "Sidebars", 'movedo' ); ?></h2>
		
		<?php if( isset( $_GET['sidebar-settings'] ) ) { ?>
		<div class="grve-sidebar-saved grve-notice-green">
			<strong><?php esc_html_e('Settings Saved!', 'movedo' ); ?></strong>
		</div>
		<?php } ?>		
		<input type="text" id="grve-custom-sidebar-item-name-new" value=""/>
		<input type="button" id="grve-add-custom-sidebar-item" class="button button-primary" value="<?php esc_html_e('Add New', 'movedo' ); ?>"/>
		<span class="grve-sidebar-spinner"></span>
		<div class="grve-sidebar-notice grve-notice-red" style="display:none;">
			<strong><?php esc_html_e('Field must not be empty!', 'movedo' ); ?></strong>
		</div>
		<div class="grve-sidebar-notice-exists grve-notice-red" style="display:none;">
			<strong><?php esc_html_e('Sidebar with this name already exists!', 'movedo' ); ?></strong>
		</div>		
		<form method="post" action="themes.php?page=movedo-grve-custom-sidebar-settings">
			<?php wp_nonce_field( 'movedo_grve_nonce_sidebar_save', '_movedo_grve_nonce_sidebar_save' ); ?>
			<div id="grve-custom-sidebar-container">
				<?php movedo_grve_print_admin_custom_sidebars( $movedo_grve_custom_sidebars ); ?>
			</div>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
	}
	
	function  movedo_grve_print_admin_custom_sidebars( $movedo_grve_custom_sidebars ) {

		
		if ( ! empty( $movedo_grve_custom_sidebars ) ) {
			foreach ( $movedo_grve_custom_sidebars as $movedo_grve_custom_sidebar ) {
				movedo_grve_print_admin_single_custom_sidebar( $movedo_grve_custom_sidebar );
			}
		}
	}

	function  movedo_grve_print_admin_single_custom_sidebar( $sidebar_item, $mode = '' ) {

		$movedo_grve_button_class = "grve-custom-sidebar-item-delete-button";
		$sidebar_item_id = uniqid('movedo_grve_sidebar_');
		
		if( $mode = "new" ) {
			$movedo_grve_button_class = "grve-custom-sidebar-item-delete-button grve-item-new";			
		}	
?>
	
	
	<div class="grve-custom-sidebar-item">
		<input class="<?php echo esc_attr( $movedo_grve_button_class ); ?> button" type="button" value="<?php esc_attr_e('Delete', 'movedo' ); ?>">
		<h3 class="grve-custom-sidebar-title">
			<span><?php esc_html_e('Custom Sidebar', 'movedo' ); ?>: <?php echo movedo_grve_array_value( $sidebar_item, 'name' ); ?></span>
		</h3>
		<div class="grve-custom-sidebar-settings">
			<input type="hidden" name="_movedo_grve_custom_sidebar_item_id[]" value="<?php echo movedo_grve_array_value( $sidebar_item, 'id', $sidebar_item_id ); ?>">
			<input type="hidden" class="grve-custom-sidebar-item-name" name="_movedo_grve_custom_sidebar_item_name[]" value="<?php echo movedo_grve_array_value( $sidebar_item, 'name' ); ?>"/>
		</div>
	</div>
	
<?php

	}

	add_action( 'wp_ajax_movedo_grve_get_custom_sidebar', 'movedo_grve_get_custom_sidebar' );

	function movedo_grve_get_custom_sidebar() {
	
		if( isset( $_POST['sidebar_name'] ) ) {
		
			$sidebar_item_name = $_POST['sidebar_name'];
			$sidebar_item_id = uniqid('movedo_grve_sidebar_');
			if( empty( $sidebar_item_name ) ) {
				$sidebar_item_name = $sidebar_item_id;
			}
			
			$this_sidebar = array (
				'id' => $sidebar_item_id,
				'name' => $sidebar_item_name,
			);

			movedo_grve_print_admin_single_custom_sidebar( $this_sidebar, 'new' );
		}
		die();

	}

//Omit closing PHP tag to avoid accidental whitespace output errors.
