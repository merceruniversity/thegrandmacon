<?php
/*
Template Name: Scrolling Full Screen Sections
*/
?>
<?php get_header(); ?>

<?php the_post(); ?>

<?php

	$scrolling_page = movedo_grve_post_meta( '_movedo_grve_scrolling_page' );
	$responsive_scrolling_page = movedo_grve_post_meta( '_movedo_grve_responsive_scrolling', 'yes' );
	$scrolling_lock_anchors = movedo_grve_post_meta( '_movedo_grve_scrolling_lock_anchors', 'yes' );
	$scrolling_loop = movedo_grve_post_meta( '_movedo_grve_scrolling_loop', 'none' );
	$scrolling_speed = movedo_grve_post_meta( '_movedo_grve_scrolling_speed', 1000 );

	$wrapper_attributes = array();
	if( 'pilling' == $scrolling_page ) {
		$scrolling_page_id = 'grve-pilling-page';
		$scrolling_direction = movedo_grve_post_meta( '_movedo_grve_scrolling_direction', 'vertical' );
		$wrapper_attributes[] = 'data-scroll-direction="' . esc_attr( $scrolling_direction ) . '"';
	} else {
		$scrolling_page_id = 'grve-fullpage';
	}
	$wrapper_attributes[] = 'id="' . esc_attr( $scrolling_page_id ) . '"';
	$wrapper_attributes[] = 'data-device-scrolling="' . esc_attr( $responsive_scrolling_page ) . '"';
	$wrapper_attributes[] = 'data-lock-anchors="' . esc_attr( $scrolling_lock_anchors ) . '"';
	$wrapper_attributes[] = 'data-scroll-loop="' . esc_attr( $scrolling_loop ) . '"';
	$wrapper_attributes[] = 'data-scroll-speed="' . esc_attr( $scrolling_speed ) . '"';

?>

			<!-- CONTENT -->
			<div id="grve-content" class="clearfix">
				<div class="grve-content-wrapper">
					<!-- MAIN CONTENT -->
					<div id="grve-main-content">
						<div class="grve-main-content-wrapper clearfix" style="padding: 0;">

							<!-- PAGE CONTENT -->
							<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div <?php echo implode( ' ', $wrapper_attributes ); ?>>
									<?php the_content(); ?>
								</div>
							</div>
							<!-- END PAGE CONTENT -->

						</div>
					</div>
					<!-- END MAIN CONTENT -->

				</div>
			</div>
			<!-- END CONTENT -->

			<!-- SIDE AREA -->
			<?php
				$movedo_grve_sidearea_data = movedo_grve_get_sidearea_data();
				movedo_grve_print_side_area( $movedo_grve_sidearea_data );
			?>
			<!-- END SIDE AREA -->

			<!-- HIDDEN MENU -->
			<?php movedo_grve_print_hidden_menu(); ?>
			<!-- END HIDDEN MENU -->

			<?php movedo_grve_print_search_modal(); ?>
			<?php movedo_grve_print_form_modals(); ?>
			<?php movedo_grve_print_language_modal(); ?>
			<?php movedo_grve_print_login_modal(); ?>
			<?php movedo_grve_print_social_modal(); ?>
			<?php do_action( 'movedo_grve_footer_modal_container' ); ?>
			</div> <!-- end #grve-theme-content -->
			<?php movedo_grve_print_safebutton_area(); ?>
		</div> <!-- end #grve-theme-wrapper -->

		<?php wp_footer(); // js scripts are inserted using this function ?>

	</body>

</html>