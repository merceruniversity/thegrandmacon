<?php get_header(); ?>

<?php the_post(); ?>

<?php movedo_grve_print_header_title( 'page' ); ?>
<?php movedo_grve_print_header_breadcrumbs( 'page' ); ?>
<?php movedo_grve_print_anchor_menu( 'page' ); ?>

<?php
	if ( 'yes' == movedo_grve_post_meta( '_movedo_grve_disable_content' ) ) {
		get_footer();
	} else {
?>
		<!-- CONTENT -->
		<div id="grve-content" class="clearfix <?php echo movedo_grve_sidebar_class( 'page' ); ?>">
			<div class="grve-content-wrapper">
				<!-- MAIN CONTENT -->
				<div id="grve-main-content">
					<div class="grve-main-content-wrapper clearfix">

						<!-- PAGE CONTENT -->
						<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php the_content(); ?>
						</div>
						<!-- END PAGE CONTENT -->

						<?php if ( movedo_grve_visibility( 'page_comments_visibility' ) ) { ?>
						<div class="grve-container">
							<?php comments_template(); ?>
						</div>
						<?php } ?>

					</div>
				</div>
				<!-- END MAIN CONTENT -->

				<?php movedo_grve_set_current_view( 'page' ); ?>
				<?php get_sidebar(); ?>

			</div>
		</div>
		<!-- END CONTENT -->

	<?php get_footer(); ?>

<?php
	}

//Omit closing PHP tag to avoid accidental whitespace output errors.
