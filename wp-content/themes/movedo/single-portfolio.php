<?php get_header(); ?>

<?php the_post(); ?>
<?php movedo_grve_print_header_title( 'portfolio' ); ?>
<?php movedo_grve_print_header_breadcrumbs( 'portfolio' ); ?>
<?php movedo_grve_print_anchor_menu( 'portfolio' ); ?>

<?php
	$grve_disable_portfolio_recent = movedo_grve_post_meta( '_movedo_grve_disable_recent_entries' );
	$grve_disable_comments = movedo_grve_post_meta( '_movedo_grve_disable_comments' );
	$grve_portfolio_media = movedo_grve_post_meta( '_movedo_grve_portfolio_media_selection' );
	$portfolio_media_fullwidth = movedo_grve_post_meta( '_movedo_grve_portfolio_media_fullwidth', 'no' );
	$grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'portfolio_layout', 'none' ) );
	$grve_sidebar_extra_content = movedo_grve_check_portfolio_details();
	$grve_portfolio_details_sidebar = false;
	if( $grve_sidebar_extra_content && 'none' == $grve_sidebar_layout ) {
		$grve_portfolio_details_sidebar = true;
	}


	$portfolio_media_classes = array( 'grve-portfolio-media' );
	if( 'yes' == $portfolio_media_fullwidth ){
		array_push( $portfolio_media_classes, 'grve-section', 'grve-fullwidth');
	}
	if ( $grve_portfolio_details_sidebar ) {
		array_push( $portfolio_media_classes, 'grve-without-sidebar' );
	} else {
		array_push( $portfolio_media_classes, 'grve-with-sidebar' );
	}

	$portfolio_media_class_string = implode( ' ', $portfolio_media_classes );
?>

<div class="grve-single-wrapper">
	<?php
		if ( $grve_portfolio_details_sidebar && 'none' != $grve_portfolio_media ) {
	?>
		<div id="grve-single-media" class="<?php echo esc_attr( $portfolio_media_class_string ); ?>">
			<div class="grve-container">
				<?php movedo_grve_print_portfolio_media(); ?>
			</div>
		</div>
	<?php
		}
	?>
	<!-- CONTENT -->
	<div id="grve-content" class="clearfix <?php echo movedo_grve_sidebar_class( 'portfolio' ); ?>">
		<div class="grve-content-wrapper">
			<!-- MAIN CONTENT -->
			<div id="grve-main-content">
				<div class="grve-main-content-wrapper clearfix">

					<article id="post-<?php the_ID(); ?>" <?php post_class('grve-single-porfolio'); ?>>
						<?php
							if ( !$grve_portfolio_details_sidebar && 'none' != $grve_portfolio_media ) {
						?>
							<div id="grve-single-media" class="<?php echo esc_attr( $portfolio_media_class_string ); ?>">
								<div class="grve-container">
									<?php movedo_grve_print_portfolio_media(); ?>
								</div>
							</div>
						<?php
							}
						?>
						<div id="grve-post-content">
							<?php the_content(); ?>
						</div>

						<?php if ( movedo_grve_visibility( 'portfolio_comments_visibility' ) && 'yes' != $grve_disable_comments ) { ?>
						<div class="grve-container">
							<?php comments_template(); ?>
						</div>
						<?php } ?>
					</article>

				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<?php
				if ( $grve_portfolio_details_sidebar ) {
			?>
				<aside id="grve-sidebar">
					<?php movedo_grve_print_portfolio_details(); ?>
				</aside>
			<?php
				} else {
					movedo_grve_set_current_view( 'portfolio' );
					get_sidebar();
				}
			?>
		</div>

	</div>
	<!-- End CONTENT -->

	<?php movedo_grve_print_portfolio_bar(); ?>

</div>
<?php get_footer();

//Omit closing PHP tag to avoid accidental whitespace output errors.
