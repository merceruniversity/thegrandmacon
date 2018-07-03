<?php
/*
Template Name: Header and Feature Only
*/
?>
<?php get_header(); ?>

<?php the_post(); ?>

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