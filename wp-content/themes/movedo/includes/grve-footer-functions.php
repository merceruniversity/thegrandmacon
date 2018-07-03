<?php

/*
*	Footer Helper functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


/**
 * Prints Footer Background Image
 */
if ( !function_exists('movedo_grve_print_footer_bg_image') ) {
	function movedo_grve_print_footer_bg_image() {
		if ( 'custom' == movedo_grve_option( 'footer_bg_mode' ) ) {
			$movedo_grve_footer_custom_bg = array(
				'bg_mode' => 'custom',
				'bg_image_id' => movedo_grve_option( 'footer_bg_image', '', 'id' ),
				'bg_position' => movedo_grve_option( 'footer_bg_position', 'center-center' ),
				'pattern_overlay' => movedo_grve_option( 'footer_pattern_overlay' ),
				'color_overlay' => movedo_grve_option( 'footer_color_overlay' ),
				'opacity_overlay' => movedo_grve_option( 'footer_opacity_overlay' ),
			);
			movedo_grve_print_title_bg_image( $movedo_grve_footer_custom_bg );
		}
	}
}

/**
 * Prints Footer Widgets
 */
if ( !function_exists('movedo_grve_print_footer_widgets') ) {
	function movedo_grve_print_footer_widgets() {
		$movedo_section_visibility = 'no';
		if ( movedo_grve_visibility( 'footer_widgets_visibility' ) ) {
			$movedo_section_visibility = 'yes';
		}
		if ( is_singular() ) {
			$movedo_section_visibility = movedo_grve_post_meta( '_movedo_grve_footer_widgets_visibility', $movedo_section_visibility );
		} else if( movedo_grve_is_woo_shop() ) {
			$movedo_section_visibility = movedo_grve_post_meta_shop( '_movedo_grve_footer_widgets_visibility', $movedo_section_visibility );
		}

		if ( 'yes' == $movedo_section_visibility ) {

			$movedo_grve_footer_columns = movedo_grve_option('footer_widgets_layout');

			switch( $movedo_grve_footer_columns ) {
				case 'footer-1':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-3-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-4-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
					);
				break;
				case 'footer-2':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-2',
							'tablet-column' => '1',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-3-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
					);
				break;
				case 'footer-3':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-3-sidebar',
							'column' => '1-2',
							'tablet-column' => '1',
						),
					);
				break;
				case 'footer-4':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-2',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-2',
							'tablet-column' => '1-2',
						),
					);
				break;
				case 'footer-5':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-3',
							'tablet-column' => '1-3',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-3',
							'tablet-column' => '1-3',
						),
						array(
							'sidebar-id' => 'grve-footer-3-sidebar',
							'column' => '1-3',
							'tablet-column' => '1-3',
						),
					);
				break;
				case 'footer-6':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '2-3',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-3',
							'tablet-column' => '1-2',
						),
					);
				break;
				case 'footer-7':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-3',
							'tablet-column' => '1-2',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '2-3',
							'tablet-column' => '1-2',
						),
					);
				break;
				case 'footer-8':
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-3',
						),
						array(
							'sidebar-id' => 'grve-footer-2-sidebar',
							'column' => '1-2',
							'tablet-column' => '1-3',
						),
						array(
							'sidebar-id' => 'grve-footer-3-sidebar',
							'column' => '1-4',
							'tablet-column' => '1-3',
						),
					);
				break;
				case 'footer-9':
				default:
					$footer_sidebars = array(
						array(
							'sidebar-id' => 'grve-footer-1-sidebar',
							'column' => '1',
							'tablet-column' => '1',
						),
					);
				break;
			}

			$section_type = movedo_grve_option( 'footer_section_type', 'fullwidth-background' );

			$movedo_grve_footer_class = array( 'grve-widget-area' );

			if( 'fullwidth-element' == $section_type ) {
				$movedo_grve_footer_class[] = 'grve-fullwidth';
			}
			$movedo_grve_footer_class_string = implode( ' ', $movedo_grve_footer_class );

			$footer_padding_top = movedo_grve_option( 'footer_padding_top_multiplier', '3x' );
			$footer_padding_bottom = movedo_grve_option( 'footer_padding_bottom_multiplier', '3x' );

	?>
			<!-- Footer -->
			<div class="<?php echo esc_attr( $movedo_grve_footer_class_string ); ?>">
				<div class="grve-container grve-padding-top-<?php echo esc_attr( $footer_padding_top ); ?> grve-padding-bottom-<?php echo esc_attr( $footer_padding_bottom ); ?> ">
					<div class="grve-row grve-columns-gap-30">
		<?php

					foreach ( $footer_sidebars as $footer_sidebar ) {
						echo '<div class="wpb_column grve-column grve-column-' . $footer_sidebar['column'] . ' grve-tablet-column-' . $footer_sidebar['tablet-column'] . '">';
						echo '<div class="grve-column-wrapper">';
						dynamic_sidebar( $footer_sidebar['sidebar-id'] );
						echo '</div>';
						echo '</div>';
					}
		?>
					</div>
				</div>
			</div>
	<?php

		}
	}
}

/**
 * Prints Footer Bar Area
 */

if ( !function_exists('movedo_grve_print_footer_bar') ) {
	function movedo_grve_print_footer_bar() {

		$movedo_section_visibility = 'no';
		if ( movedo_grve_visibility( 'footer_bar_visibility' ) ) {
			$movedo_section_visibility = 'yes';
		}
		if ( is_singular() ) {
			$movedo_section_visibility = movedo_grve_post_meta( '_movedo_grve_footer_bar_visibility', $movedo_section_visibility );
		} else if( movedo_grve_is_woo_shop() ) {
			$movedo_section_visibility = movedo_grve_post_meta_shop( '_movedo_grve_footer_bar_visibility', $movedo_section_visibility );
		}

		if ( 'yes' == $movedo_section_visibility ) {

			$section_type = movedo_grve_option( 'footer_bar_section_type', 'fullwidth-background' );

			$movedo_grve_footer_bar_class = array( 'grve-footer-bar', 'grve-padding-top-1x', 'grve-padding-bottom-1x' );

			if( 'fullwidth-element' == $section_type ) {
				$movedo_grve_footer_bar_class[] = 'grve-fullwidth';
			}
			$movedo_grve_footer_bar_class_string = implode( ' ', $movedo_grve_footer_bar_class );

			$align_center = movedo_grve_option( 'footer_bar_align_center', 'no' );
			$second_area = movedo_grve_option( 'second_area_visibility', '1' );
	?>

			<div class="<?php echo esc_attr( $movedo_grve_footer_bar_class_string ); ?>" data-align-center="<?php echo esc_attr( $align_center ); ?>">
				<div class="grve-container">
					<?php if ( movedo_grve_visibility( 'footer_copyright_visibility' ) ) { ?>
					<div class="grve-bar-content grve-left-side">
						<div class="grve-copyright">
							<?php echo do_shortcode( movedo_grve_option( 'footer_copyright_text' ) ); ?>
						</div>
					</div>
					<?php } ?>
					<?php if ( '2' == $second_area ) { ?>
					<div class="grve-bar-content grve-right-side">
						<nav class="grve-footer-menu">
							<?php movedo_grve_footer_nav(); ?>
						</nav>
					</div>
					<?php
					} else if ( '3' == $second_area ) { ?>
					<div class="grve-bar-content grve-right-side">
						<?php
						global $movedo_grve_social_list;
						$options = movedo_grve_option('footer_social_options');
						$social_display = movedo_grve_option('footer_social_display', 'text');
						$social_options = movedo_grve_option('social_options');

						if ( !empty( $options ) && !empty( $social_options ) ) {
							if ( 'text' == $social_display ) {
								echo '<ul class="grve-social">';
								foreach ( $social_options as $key => $value ) {
									if ( isset( $options[$key] ) && 1 == $options[$key] && $value ) {
										if ( 'skype' == $key ) {
											echo '<li><a href="' . esc_url( $value, array( 'skype', 'http', 'https' ) ) . '">' . $movedo_grve_social_list[$key] . '</a></li>';
										} else {
											echo '<li><a href="' . esc_url( $value ) . '" target="_blank">' . $movedo_grve_social_list[$key] . '</a></li>';
										}
									}
								}
								echo '</ul>';
							} else {
								echo '<ul class="grve-social grve-social-icons">';
								foreach ( $social_options as $key => $value ) {
									if ( isset( $options[$key] ) && 1 == $options[$key] && $value ) {
										if ( 'skype' == $key ) {
											echo '<li><a href="' . esc_url( $value, array( 'skype', 'http', 'https' ) ) . '" class="fa fa-' . esc_attr( $key ) . '"></a></li>';
										} else {
											echo '<li><a href="' . esc_url( $value ) . '" target="_blank" class="fa fa-' . esc_attr( $key ) . '"></a></li>';
										}
									}
								}
								echo '</ul>';
							}
						}
						?>
					</div>
					<?php
					} else if ( '4' == $second_area ) { ?>
					<div class="grve-bar-content grve-right-side">
						<div class="grve-copyright">
							<?php echo do_shortcode( movedo_grve_option( 'footer_second_copyright_text' ) ); ?>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>

	<?php
		}
	}
}

/**
 * Prints Back To Top Link
 */
if ( !function_exists('movedo_grve_print_back_top') ) {
	function movedo_grve_print_back_top() {

		if ( ( is_singular() && 'yes' == movedo_grve_post_meta( '_movedo_grve_disable_back_to_top' ) ) || ( movedo_grve_is_woo_shop() && 'yes' == movedo_grve_post_meta_shop( '_movedo_grve_disable_back_to_top' ) ) ) {
			return;
		}

		if ( movedo_grve_visibility( 'back_to_top_enabled' )  ) {

			$movedo_grve_back_to_top_shape = movedo_grve_option( 'back_to_top_shape', 'none' );

			$movedo_grve_back_to_top_icon_wrapper_classes = array('grve-arrow-wrapper');
			if( 'none' != $movedo_grve_back_to_top_shape ){
				$movedo_grve_back_to_top_icon_wrapper_classes[] = 'grve-' . $movedo_grve_back_to_top_shape;
				$movedo_grve_back_to_top_icon_wrapper_classes[] = 'grve-wrapper-color';
			}
			$movedo_grve_back_to_top_icon_wrapper_class_string = implode( ' ', $movedo_grve_back_to_top_icon_wrapper_classes );

		?>
			<div class="grve-back-top">
				<div class="<?php echo esc_attr( $movedo_grve_back_to_top_icon_wrapper_class_string ); ?>">
					<i class="grve-icon-nav-up-small grve-back-top-icon"></i>
				</div>
			</div>
		<?php
		}
	}
}

 /**
 * Prints Bottom Bar
 */
if ( !function_exists('movedo_grve_print_bottom_bar') ) {
	function movedo_grve_print_bottom_bar() {

		$movedo_area_id = movedo_grve_option('bottom_bar_area');
		if ( is_singular() ) {
			$movedo_area_id = movedo_grve_post_meta( '_movedo_grve_bottom_bar_area', $movedo_area_id );
		}
		if( movedo_grve_is_woo_shop() ) {
			$movedo_area_id = movedo_grve_post_meta_shop( '_movedo_grve_bottom_bar_area', $movedo_area_id );
		}
		if ( !empty( $movedo_area_id ) && 'none' != $movedo_area_id ) {
			$movedo_content = get_post_field( 'post_content', $movedo_area_id );
	?>
			<!-- BOTTOM BAR -->
			<div id="grve-bottom-bar" class="grve-bookmark">
				<?php echo apply_filters( 'movedo_grve_the_content', $movedo_content ); ?>
			</div>
			<!-- END BOTTOM BAR -->
	<?php
		}
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
