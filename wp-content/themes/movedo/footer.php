			<?php
				$grve_sticky_footer = movedo_grve_visibility( 'sticky_footer' ) ? 'yes' : 'no';
			?>
				<footer id="grve-footer" data-sticky-footer="<?php echo esc_attr( $grve_sticky_footer ); ?>" class="grve-border grve-bookmark">
					<?php movedo_grve_print_bottom_bar(); ?>
					<div class="grve-footer-wrapper">
					<?php movedo_grve_print_footer_widgets(); ?>
					<?php movedo_grve_print_footer_bar(); ?>
					<?php movedo_grve_print_footer_bg_image(); ?>
					</div>

				</footer>
			<!-- SIDE AREA -->
			<?php
				$movedo_grve_sidearea_data = movedo_grve_get_sidearea_data();
				movedo_grve_print_side_area( $movedo_grve_sidearea_data );
				movedo_grve_print_cart_area();
			?>
			<!-- END SIDE AREA -->

			<!-- HIDDEN MENU -->
			<?php movedo_grve_print_hidden_menu(); ?>
			<?php movedo_grve_print_responsive_anchor_menu(); ?>
			<!-- END HIDDEN MENU -->

			<?php movedo_grve_print_search_modal(); ?>
			<?php movedo_grve_print_form_modals(); ?>
			<?php movedo_grve_print_language_modal(); ?>
			<?php movedo_grve_print_login_modal(); ?>
			<?php movedo_grve_print_social_modal(); ?>

			<?php do_action( 'movedo_grve_footer_modal_container' ); ?>

			<?php movedo_grve_print_back_top(); ?>
			</div> <!-- end #grve-theme-content -->
			<?php movedo_grve_print_safebutton_area(); ?>
		</div> <!-- end #grve-theme-wrapper -->

		<?php wp_footer(); // js scripts are inserted using this function ?>

	</body>

</html>