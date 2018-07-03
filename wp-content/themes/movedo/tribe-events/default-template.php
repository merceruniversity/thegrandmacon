<?php get_header(); ?>

<?php
if ( is_singular( 'tribe_events' ) ) {
	movedo_grve_print_header_title( 'event' );
	movedo_grve_print_header_breadcrumbs( 'event' );
	movedo_grve_print_anchor_menu( 'event' );
} else {
	if ( is_singular( 'tribe_organizer' ) || is_singular( 'tribe_venue' )  ) {
		// No advanced title
	} else {
		movedo_grve_print_header_title( 'event_tax' );
		movedo_grve_print_header_breadcrumbs( 'event_tax' );
	}
}
?>

	<!-- CONTENT -->
	<div id="grve-content" class="clearfix <?php echo movedo_grve_sidebar_class( 'event' ); ?>">
		<div class="grve-content-wrapper">
			<!-- MAIN CONTENT -->
			<div id="grve-main-content">
				<div class="grve-main-content-wrapper clearfix">
					<div class="grve-container">
						<?php tribe_events_before_html(); ?>
						<?php tribe_get_view(); ?>
						<?php tribe_events_after_html(); ?>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->

			<?php movedo_grve_set_current_view( 'event' ); ?>
			<?php get_sidebar(); ?>

		</div>
	</div>
	<!-- END CONTENT -->

<?php
	if ( is_singular( 'tribe_events' ) ) {
		movedo_grve_print_event_bar();
	}
	get_footer();

//Omit closing PHP tag to avoid accidental whitespace output errors.
