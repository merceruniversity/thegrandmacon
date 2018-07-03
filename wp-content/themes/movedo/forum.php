<?php get_header(); ?>
<?php the_post(); ?>
<?php movedo_grve_print_header_title( 'forum' ); ?>

		<!-- CONTENT -->
		<div id="grve-content" class="clearfix <?php echo movedo_grve_sidebar_class( 'forum' ); ?>">
			<div class="grve-content-wrapper">
				<!-- MAIN CONTENT -->
				<div id="grve-main-content">
					<div class="grve-main-content-wrapper clearfix">

						<!-- PAGE CONTENT -->
						<div id="grve-forum-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="grve-container">
								<?php the_content(); ?>
							</div>
						</div>
						<!-- END PAGE CONTENT -->

					</div>
				</div>
				<!-- END MAIN CONTENT -->

				<?php movedo_grve_set_current_view( 'forum' ); ?>
				<?php get_sidebar(); ?>

			</div>
		</div>
		<!-- END CONTENT -->
<?php get_footer(); ?>