<?php
/**
 *  Dynamic css style for Events Calendar
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */

$css = "";

/* Single Event Content Width
============================================================================= */
if ( is_singular( 'tribe_events' ) ) {
	$movedo_grve_post_content_width = movedo_grve_post_meta( '_movedo_grve_post_content_width', movedo_grve_option( 'event_content_width', 1170 ) );

	if ( !is_numeric( $movedo_grve_post_content_width ) ) {
		$movedo_grve_post_content_width = movedo_grve_option( 'container_size', 1170 );
	}
$css .= "

#grve-content:not(.grve-right-sidebar):not(.grve-left-sidebar) .grve-container {
	max-width: " . esc_attr( $movedo_grve_post_content_width ) . "px;
}

";

}

// Event Anchor Size
$css .= "

#grve-event-anchor {
	height: " . intval( movedo_grve_option( 'event_anchor_menu_height', 120 ) + 2 ) . "px;
}

#grve-event-anchor .grve-anchor-wrapper {
	line-height: " . movedo_grve_option( 'event_anchor_menu_height' ) . "px;
}

";

/* Tribe Events
============================================================================= */
$css .= "
.events-list.tribe-bar-is-disabled #tribe-events-content-wrapper {
    max-width: " . esc_attr( movedo_grve_option( 'container_size', 1170 ) ) . "px;
}

.tribe-events-day {
    padding: 0;
}

";

/* Featured Event
============================================================================= */
$css .= "
#grve-tribe-events-list .tribe-event-featured,
#grve-tribe-events-day .tribe-event-featured,
#grve-tribe-events-map .tribe-event-featured {
    color: inherit;
    background-color: #fafafa;
}

#grve-tribe-events-list .tribe-event-featured .grve-post-content-wrapper,
#grve-tribe-events-day .tribe-event-featured .grve-post-content-wrapper,
#grve-tribe-events-map .tribe-event-featured .grve-post-content-wrapper {
	padding-left: 30px;
	padding-right: 30px;
}

.tribe-event-featured .event-is-recurring {
    color: inherit;
}

.tribe-event-featured .event-is-recurring:hover {
	color: inherit;
}

#grve-tribe-events-list .type-tribe_events,
#grve-tribe-events-day .type-tribe_events,
#grve-tribe-events-map .type-tribe_events {
	padding-top: 0;
}

.tribe-events-divider,
.tribe-events-organizer .tribe-events-divider {
	margin: 0 8px;
}
.tribe-events-loop .tribe-events-photo-event .recurringinfo .tribe-events-divider {
    display: inline;
}

.grve-tribe-events-divider,
#grve-event-title .tribe-events-divider {
	margin: 0 5px;
}

.tribe-events-photo .grve-media img {
	height: auto;
	width: 100%;
}

#grve-event-title .grve-event-cost {
	margin-left: 10px;
	font-style: italic;
}
.grve-event-item .tribe-events-tooltip {
	display: none;
}

";

/* Event Page Title
============================================================================= */
$css .= "

.grve-tribe-events-list-event-title {
	margin-bottom: 6px;
}

.grve-tribe-events-event-meta.grve-post-meta {
	line-height: 24px;
	margin-bottom: 20px;
	opacity: .8;
}

";

/* Event Page Title
============================================================================= */
$css .= "

#grve-event-title .event-is-recurring,
#grve-event-title .grve-description a,
#grve-event-tax-title .grve-description a {
	color: inherit;
}

#grve-event-title .grve-description a:hover,
#grve-event-tax-title .grve-description a:hover {
	opacity: 0.5;
}

";

/* Event Single
============================================================================= */
$css .= "
#tribe-events-content {
	margin-bottom: 0;
	padding: 0;
}

.single-tribe_events .tribe-events-event-meta:last-child {
	margin-bottom: 0;
}

.single-tribe_events .tribe-events-cal-links {
	margin-bottom: 60px;
}

a.tribe-events-gcal,
a.tribe-events-ical {
	margin-top: 40px;
}

";


/* Event Bar Form
============================================================================= */
$css .= "

#tribe-events-bar {
	margin-bottom: 60px;
}

#tribe-bar-form {
	background: transparent;
	margin: 0;
	position: relative;
	width: 100%;
}

.tribe-bar-submit,
.tribe-events-uses-geolocation .tribe-bar-submit {
	padding-top: 28px;
}

.tribe-bar-views-inner {
	padding: 15px 0 53px;
	background: transparent;
}

#tribe-events-content table.tribe-events-calendar {
	margin-bottom: 30px;
}

#tribe-bar-views li.tribe-bar-views-option {
	line-height: 41px;
}

.tribe-bar-collapse #tribe-bar-collapse-toggle {
	margin-top: 26px;
	padding: 13px;
}

#tribe-bar-form.tribe-bar-collapse .tribe-bar-views-inner label {
	margin-bottom: 5px;
	padding: 0;
}


";


/* Event Cost
============================================================================= */
$css .= "

.grve-event-grid .tribe-events-event-cost,
.grve-tribe-events-event-cost {
	background-color: #f7f7f7;
	color: #999999;
	font-size: 12px;
	line-height: 2;
	padding: 4px 12px;
	display: inline-block;
	-webkit-border-radius: 50px;
	border-radius: 50px;
	-webkit-transition : all .3s;
	-moz-transition    : all .3s;
	-ms-transition     : all .3s;
	-o-transition      : all .3s;
	transition         : all .3s;
}

.grve-event-grid .grve-event-item-inner:hover .tribe-events-event-cost,
.grve-blog-item-inner:hover .grve-tribe-events-event-cost,
.tribe-event-featured .grve-tribe-events-event-cost {
	background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	color: #ffffff;
	font-size: 12px;
	line-height: 2;
	padding: 4px 12px;
	display: inline-block;
	-webkit-border-radius: 50px;
	border-radius: 50px;
}

.grve-tribe-events-event-cost {
	margin-bottom: 15px;
}


";

/* Event Tooltip
============================================================================= */
$css .= "

.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-shortcode.view-week .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip {
	padding: 30px;
	text-align: left;
}

.tribe-events-tooltip .tribe-events-event-thumb {
	float: none;
	margin-bottom: 10px;
}

.tribe-events-tooltip .tribe-events-event-body .tribe-events-event-thumb img {
	width: 100%;
	max-width: none;
	max-height: none;
}

.tribe-events-tooltip.tribe-event-featured .tribe-event-description {
	margin-top: 10px;
}
";

/* Event Navigation Bar
============================================================================= */

if ( 'layout-1' == movedo_grve_option( 'event_nav_bar_layout', 'layout-1' ) ) {
	$css .= "
	#grve-event-bar .grve-post-bar-item:not(.grve-post-navigation),
	#grve-event-bar .grve-post-bar-item .grve-nav-item {
		padding-top: " . movedo_grve_option( 'event_nav_spacing', '', 'padding-top' ) . ";
		padding-bottom: " . movedo_grve_option( 'event_nav_spacing', '', 'padding-bottom'  ) . ";
	}
	";
}

$css .= "
#grve-event-bar,
#grve-event-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon,
#grve-event-bar.grve-layout-3 .grve-post-bar-item {
	background-color: " . movedo_grve_option( 'event_bar_background_color' ) . ";
	border-color: " . movedo_grve_option( 'event_bar_border_color' ) . ";
}

#grve-event-bar .grve-post-bar-item,
#grve-event-bar.grve-layout-1 .grve-post-bar-item .grve-nav-item,
#grve-event-bar.grve-layout-2:not(.grve-nav-columns-1) .grve-post-bar-item .grve-next,
#grve-event-bar.grve-layout-2.grve-nav-columns-1 .grve-post-bar-item .grve-prev + .grve-next  {
	border-color: " . movedo_grve_option( 'event_bar_border_color' ) . ";
}

#grve-event-bar .grve-nav-item .grve-title {
	color: " . movedo_grve_option( 'event_bar_nav_title_color' ) . ";
}

#grve-event-bar .grve-bar-socials li {
	border-color: " . movedo_grve_option( 'event_bar_border_color' ) . ";
}

#grve-event-bar .grve-bar-socials li a:not(.active) {
	color: " . movedo_grve_option( 'event_bar_socials_color' ) . ";
}

#grve-event-bar .grve-bar-socials li a.active {
	color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}

#grve-event-bar .grve-bar-socials li a:hover {
	color: " . movedo_grve_option( 'event_bar_socials_color_hover' ) . ";
}

#grve-event-bar .grve-arrow,
#grve-event-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon {
	color: " . movedo_grve_option( 'event_bar_arrow_color' ) . ";
}
";


/* Event Photo Layout
============================================================================= */
$css .= "

.type-tribe_events.tribe-events-photo-event .tribe-events-photo-event-wrap {
	background-color: #ffffff;
	-webkit-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.1);
	-moz-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.1);
	box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.1);
}

.tribe-events-list .tribe-events-photo-event .tribe-events-event-details {
	padding: 36px;
}

.tribe-events-list .tribe-events-loop .tribe-event-featured,
.tribe-events-list #tribe-events-day.tribe-events-loop .tribe-event-featured,
.type-tribe_events.tribe-events-photo-event.tribe-event-featured .tribe-events-photo-event-wrap,
.type-tribe_events.tribe-events-photo-event.tribe-event-featured .tribe-events-photo-event-wrap:hover {
	background-color: #101215 !important;
}

";

/* Event Grid
============================================================================= */
$css .= "
.grve-event-item {
	-webkit-backface-visibility : hidden;
	-moz-backface-visibility    : hidden;
	-ms-backface-visibility     : hidden;
}

.grve-event-grid .grve-event-item .grve-event-item-inner {
	background-color: #ffffff;
	-webkit-backface-visibility : hidden;
	-moz-backface-visibility    : hidden;
	-ms-backface-visibility     : hidden;
	-webkit-transition : all .3s;
	-moz-transition    : all .3s;
	-ms-transition     : all .3s;
	-o-transition      : all .3s;
	transition         : all .3s;
	-webkit-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.1);
	-moz-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.1);
	box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.1);
}

.grve-event-grid .grve-event-item:hover .grve-blog-item-inner {
	-webkit-box-shadow: 0px 8px 35px 0px rgba(0,0,0,0.13);
	-moz-box-shadow: 0px 8px 35px 0px rgba(0,0,0,0.13);
	box-shadow: 0px 8px 35px 0px rgba(0,0,0,0.13);
}

.grve-event-grid .grve-event-item .grve-media {
	margin-bottom: 0;
}

.grve-event-grid .grve-event-item .grve-event-content-wrapper {
	padding: 36px;
}

.grve-event-grid .tribe-events-event-cost {
	margin-top: 15px;
}

";


/**
* Header Colors
* ----------------------------------------------------------------------------
*/

$css .= "
.tribe-events-day .tribe-event-featured a,
.tribe-events-day .tribe-event-featured a:hover,
.grve-tribe-events-meta-group ul li span,
#tribe-events-content .tribe-events-calendar div[id*=tribe-events-event-] h3.tribe-events-month-event-title a {
	color: " . movedo_grve_option( 'body_heading_color' ) . ";
}

";


/**
* Borders
* ----------------------------------------------------------------------------
*/
$css .= "

.grve-tribe-events-meta-group ul li,
.grve-list-separator:after,
.grve-post-content .grve-tribe-events-venue-details,
#tribe-events-content .tribe-events-calendar td,
.tribe-grid-allday .type-tribe_events>div,
.tribe-grid-allday .type-tribe_events>div:hover,
.tribe-grid-body .type-tribe_events .tribe-events-week-hourly-single,
.tribe-grid-body .type-tribe_events .tribe-events-week-hourly-single:hover {
	border-color: " . movedo_grve_option( 'body_border_color' ) . ";
}

";

/**
* Primary Text
* ----------------------------------------------------------------------------
*/

$css .= "

#tribe-events-content .tribe-events-calendar div[id*=tribe-events-event-] h3.tribe-events-month-event-title a:hover,
#tribe_events_filters_wrapper .tribe_events_slider_val,
.single-tribe_events a.tribe-events-gcal,
.single-tribe_events a.tribe-events-ical {
	color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}

";

/**
* Primary Bg
* ----------------------------------------------------------------------------
*/

$css .= "

#tribe-bar-form .tribe-bar-submit input[type=submit],
#tribe-events .tribe-events-button,
#tribe-events .tribe-events-button:hover,
#tribe_events_filters_wrapper input[type=submit],
.tribe-events-button,
.tribe-events-button.tribe-active:hover,
.tribe-events-button.tribe-inactive,
.tribe-events-button:hover, .tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-],
.tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-]>a,
.tribe-grid-allday .type-tribe_events>div,
.tribe-grid-allday .type-tribe_events>div:hover,
.tribe-grid-body .type-tribe_events .tribe-events-week-hourly-single,
.tribe-grid-body .type-tribe_events .tribe-events-week-hourly-single:hover {
	background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	color: #ffffff;
}

#tribe-bar-form .tribe-bar-submit input[type=submit]:hover {
	background-color: " . movedo_grve_option( 'body_primary_1_hover_color' ) . ";
	border-color: " . movedo_grve_option( 'body_primary_1_hover_color' ) . ";
	color: #ffffff;
}


";

/**
* Widgets
* ----------------------------------------------------------------------------
*/

$css .= "

#grve-main-content .grve-widget .entry-title a,
#grve-main-content .widget .tribe-countdown-text a,
#tribe-events-content .tribe-events-tooltip h4 {
	color: " . movedo_grve_option( 'body_heading_color' ) . ";
}

#grve-main-content .widget .tribe-mini-calendar .tribe-events-has-events a,
#grve-main-content .widget .tribe-countdown-number,
#grve-main-content .widget .tribe-mini-calendar-no-event {
	color: " . movedo_grve_option( 'body_text_color' ) . ";
}

#grve-main-content .grve-widget .entry-title a:hover,
.widget .tribe-countdown-text a:hover,
.widget .tribe-mini-calendar-event .list-date .list-dayname,
.widget .tribe-countdown-under,
.widget .tribe-mini-calendar td.tribe-events-has-events a {
	color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}

#grve-main-content .tribe-mini-calendar-event {
	border-color: " . movedo_grve_option( 'body_border_color' ) . ";
}

.widget .tribe-mini-calendar-nav td,
.widget .tribe-mini-calendar td.tribe-events-has-events.tribe-events-present,
.widget .tribe-mini-calendar td.tribe-events-has-events.tribe-events-present a:hover,
.widget .tribe-mini-calendar td.tribe-events-has-events a:hover,
.widget .tribe-mini-calendar td.tribe-events-has-events.tribe-mini-calendar-today {
	background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	color: #ffffff;
}

";

/* Footer */
$css .= "

#grve-footer .grve-widget .entry-title a,
#grve-footer .widget .tribe-countdown-text a {
	color: " . movedo_grve_option( 'footer_widgets_headings_color' ) . ";
}

#grve-footer .widget .tribe-countdown-number,
#grve-footer .widget .tribe-mini-calendar-no-event {
	color: " . movedo_grve_option( 'footer_widgets_font_color' ) . ";
}

#grve-footer .widget .tribe-mini-calendar-event,
#grve-footer table,
#grve-footer td,
#grve-footer th {
	border-color: " . movedo_grve_option( 'footer_widgets_border_color' ) . ";
}

#grve-footer .widget .tribe-mini-calendar-event .list-date,
#grve-footer .widget .tribe-mini-calendar th {
	background-color: " . movedo_grve_option( 'footer_widgets_border_color' ) . ";
}

";

/**
* Typography
* ----------------------------------------------------------------------------
*/

$css .= "

.widget .tribe-mini-calendar-event .list-info {
	font-size: " . movedo_grve_option( 'body_font', '14px', 'font-size'  ) . ";
	font-family: " . movedo_grve_option( 'body_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'body_font', 'normal', 'font-weight'  ) . ";
}

#tribe-bar-form .tribe-bar-submit input[type=submit],
.grve-widget .entry-title,
.widget .tribe-mini-calendar-nav td,
.widget .tribe-countdown-text,
#tribe-events-content .tribe-events-calendar div[id*=tribe-events-event-] h3.tribe-events-month-event-title {
	font-family: " . movedo_grve_option( 'link_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'link_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'link_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'link_text', '11px', 'font-size'  ) . " !important;
	text-transform: " . movedo_grve_option( 'link_text', 'uppercase', 'text-transform'  ) . ";
}

";

wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $css ) );

//Omit closing PHP tag to avoid accidental whitespace output errors.
