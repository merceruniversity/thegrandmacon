<?php get_header(); ?>

<?php the_post(); ?>

<?php movedo_grve_print_header_title( 'post' ); ?>
<?php movedo_grve_print_header_breadcrumbs( 'post' ); ?>
<?php movedo_grve_print_anchor_menu( 'post' ); ?>

<?php $navbar_layout = movedo_grve_option( 'post_nav_bar_layout', 'layout-1' ); ?>

<div class="grve-single-wrapper">
	<!-- CONTENT -->
	<div id="grve-content" class="clearfix <?php echo movedo_grve_sidebar_class(); ?>">
		<div class="grve-content-wrapper">
			<!-- MAIN CONTENT -->
			<div id="grve-main-content">
				<div class="grve-main-content-wrapper clearfix">
					<?php
						get_template_part( 'content', get_post_format() );
						//Post Pagination
						wp_link_pages();
					?>
					<div class="grve-container">
						<?php
							// Print Tags & Categories
							movedo_grve_print_post_tags();

							// Print About Author
							movedo_grve_print_post_about_author( 'overview' );

							//Print Comments
							if ( movedo_grve_visibility( 'post_comments_visibility' ) ) {
								comments_template();
							}

							if ( movedo_grve_visibility( 'post_related_visibility' ) ) {
								if ( 'layout-1' == $navbar_layout || 'layout-3' == $navbar_layout ) {
									$related_query = movedo_grve_get_related_posts();
									if ( !empty( $related_query ) ) {
										movedo_grve_print_related_posts( $related_query );
									}
								}
							}
						?>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<?php movedo_grve_set_current_view( 'post' ); ?>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<!-- END CONTENT -->

	<?php
		//Posts Bar
		movedo_grve_print_post_bar();
	?>
</div>

<?php get_footer();

//Omit closing PHP tag to avoid accidental whitespace output errors.
