<?php
/**
 * Greatives List View Single Event
 * This file contains one event in the list view
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();
// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';
// Organizer
$organizer = tribe_get_organizer();

$event_overview_heading = movedo_grve_option( 'event_overview_heading', 'h2' );

?>

<div class="grve-blog-item-inner">

<?php
if ( has_post_thumbnail() ) {


	$event_image_size = movedo_grve_option( 'event_overview_image_size' );
	$image_size = 'medium';
	if( 'default' != $event_image_size ) {
		$image_size = movedo_grve_get_image_size( $event_image_size );
	}

?>
	<!-- Event Image -->
	<div class="grve-media clearfix">
		<a class="url" href="<?php echo tribe_get_event_link() ?>" title="<?php the_title() ?>" rel="bookmark">
			<?php the_post_thumbnail( $image_size  ); ?>
		</a>
	</div>
<?php
}
?>

	<div class="grve-post-content-wrapper">
		<div class="grve-post-header">

			<!-- Event Cost -->
			<?php if ( tribe_get_cost() ) : ?>
				<div class="grve-tribe-events-event-cost">
					<span><?php echo tribe_get_cost( null, true ); ?></span>
				</div>
			<?php endif; ?>

			<!-- Event Title -->
			<?php do_action( 'tribe_events_before_the_event_title' ) ?>
			<h2 class="grve-tribe-events-list-event-title grve-<?php echo esc_attr( $event_overview_heading ); ?>">
				<a class="grve-tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
					<?php the_title() ?>
				</a>
			</h2>
			<?php do_action( 'tribe_events_after_the_event_title' ) ?>

			<!-- Event Meta -->
			<?php do_action( 'tribe_events_before_the_meta' ) ?>
			<div class="grve-tribe-events-event-meta grve-post-meta">
				<div class="author <?php echo esc_attr( $has_venue_address ); ?>">

					<!-- Schedule & Recurrence Details -->
					<div class="grve-tribe-event-schedule-details">
						<?php echo tribe_events_event_schedule_details() ?>
					</div>

					<?php if ( $venue_details ) : ?>
						<!-- Venue Display Info -->
						<div class="grve-tribe-events-venue-details">
							<?php echo implode( ', ', $venue_details ); ?>
							<?php
							if ( tribe_get_map_link() ) {
								echo tribe_get_map_link_html();
							}
							?>
						</div> <!-- .tribe-events-venue-details -->
					<?php endif; ?>

				</div>
			</div><!-- .tribe-events-event-meta -->
			<?php do_action( 'tribe_events_after_the_meta' ) ?>
		</div>
		<div class="grve-tribe-events-content" itemprop="articleBody">
			<!-- Event Content -->
			<?php do_action( 'tribe_events_before_the_content' ) ?>
			<?php echo tribe_events_get_the_excerpt( null, wp_kses_allowed_html( 'post' ) ); ?>
			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="grve-link-text grve-tribe-events-read-more" rel="bookmark"><?php esc_html_e( 'Find out more', 'the-events-calendar' ) ?></a>
			<?php do_action( 'tribe_events_after_the_content' ); ?>
		</div>
	</div>

</div>
