<?php

/*
*	Events Calendar helper functions and configuration
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

/**
 * Helper function to check if Events Calendar is enabled
 */
function movedo_grve_events_calendar_enabled() {

	if ( class_exists( 'Tribe__Events__Main' ) || class_exists( 'TribeEvents' ) ) {
		return true;
	}
	return false;
}

function movedo_grve_events_calendar_pro_enabled() {
	if ( class_exists( 'Tribe__Events__Pro__Main' ) || class_exists( 'TribeEventsPro' ) ) {
		return true;
	}
	return false;
}

/**
 * Helper function to check if is Events Calendar Overview Page
 */
function movedo_grve_events_calendar_is_overview() {
	if ( movedo_grve_events_calendar_enabled() ) {
		if ( tribe_is_list_view() || tribe_is_day() || tribe_is_month() ) {
			return true;
		}
	}
	if ( movedo_grve_events_calendar_pro_enabled() ) {
		if ( tribe_is_week() || tribe_is_map() || tribe_is_photo() ) {
			return true;
		}
	}
	return false;
}

//If Events Calendar plugin is not enabled return
if ( !movedo_grve_events_calendar_enabled() ) {
	return false;
}


/**
 * Prints title organizer meta
 */
function movedo_grve_event_organizer_title_meta() {
	$phone = tribe_get_organizer_phone();
	$email = tribe_get_organizer_email();
	$website = tribe_get_organizer_website_link();

	$details = array();
	if ( $tel = tribe_get_organizer_phone() ) {
		$details[] = '<span class="tel">' . esc_html( $tel ) . '</span>';
	}
	if ( $email = tribe_get_organizer_email() ) {
		$details[] = '<span class="email"> <a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a> </span>';
	}
	if ( $link = tribe_get_organizer_website_link() ) {
		$details[] = '<span class="link"> <a href="' . esc_attr( $link ) . '">' . $link . '</a> </span>';
	}

	$html = join( '<span class="grve-tribe-events-divider">|</span>', $details );

	if ( ! empty( $html ) ) {
		return $html;
	} else {
		return "";
	}
}


function movedo_grve_print_event_bar() {

	$layout =  movedo_grve_option( 'event_nav_bar_layout', 'layout-3' );

	$event_sections = 0;

	$event_nav_section = $event_social_section = false;
	if ( movedo_grve_nav_bar( 'event', 'check') ) {
		$event_nav_section = true;
		$event_sections++;
	}
	if( movedo_grve_social_bar( 'event', 'check' ) ) {
		$event_social_section = true;
		$event_sections++;
	}

	if ( $event_sections > 0 ) {
		// Navigation Bar Classes
		$navigation_bar_classes = array( 'grve-navigation-bar', 'grve-singular-section', 'grve-fullwidth' );
		if( 'layout-3' == $layout ) {
			array_push( $navigation_bar_classes, 'grve-layout-3' );
		} else {
			array_push( $navigation_bar_classes, 'grve-layout-1' );
			array_push( $navigation_bar_classes, 'clearfix' );
			array_push( $navigation_bar_classes, 'grve-nav-columns-' . $event_sections );
		}

		$navigation_bar_class_string = implode( ' ', $navigation_bar_classes );

	?>
			<!-- Navigation Bar -->
			<div id="grve-event-bar" class="<?php echo esc_attr( $navigation_bar_class_string ); ?>">
				<div class="grve-container">
					<div class="grve-bar-wrapper">
						<?php if ( $event_nav_section ) { ?>
							<?php movedo_grve_nav_bar( 'event', $layout ); ?>
						<?php } ?>
						<?php if ( $event_social_section ) { ?>
							<?php movedo_grve_social_bar( 'event', $layout ); ?>
						<?php } ?>

					</div>
				</div>
			</div>
			<!-- End Navigation Bar -->
	<?php
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.