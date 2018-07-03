<?php
/**
 *  Dynamic css style
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */

$css = "";


/* =========================================================================== */

/* Body
/* Container Size
/* Boxed Size
/* Single Post Content Width
/* Top Bar

/* Default Header
	/* - Default Header Colors
	/* - Default Header Menu Colors
	/* - Default Header Sub Menu Colors
	/* - Default Header Layout
	/* - Default Header Overlaping

/* Logo On Top Header
	/* - Logo On Top Header Colors
	/* - Logo On Top Header Menu Colors
	/* - Logo On Top Header Sub Menu Colors
	/* - Logo On Top Header Layout
	/* - Logo On Top Header Overlaping

/* Light Header
/* Dark Header

/* Sticky Header
	/* - Sticky Default Header
	/* - Sticky Logo On Top Header
	/* - Sticky Header Colors
	/* - Movedo Sticky Header

/* Side Area Colors
/* Modals Colors

/* Responsive Header
	/* - Header Layout
	/* - Responsive Menu
	/* - Responsive Header Elements

/* Spinner
/* Box Item
/* Primary Text Color
/* Primary Bg Color
/* Primary - Predefined Colors
/* Anchor Menu
/* Breadcrumbs
/* Main Content
	/* - Main Content Borders
	/* - Widget Colors

/* Bottom Bar Colors
/* Post Navigation Bar
/* Portfolio Navigation Bar
/* Single Post Tags & Categories
/* Footer
	/* - Widget Area
	/* - Footer Widget Colors
	/* - Footer Bar Colors




/* =========================================================================== */


/* Body
============================================================================= */
$css .= "
a {
	color: " . movedo_grve_option( 'body_text_link_color' ) . ";
}

a:hover {
	color: " . movedo_grve_option( 'body_text_link_hover_color' ) . ";
}
";

$movedo_grve_container_size_threshold = movedo_grve_option( 'container_size', '1170' );
$movedo_grve_container_size_threshold = filter_var( $movedo_grve_container_size_threshold, FILTER_SANITIZE_NUMBER_INT );

$movedo_grve_responsive_header_threshold = movedo_grve_option( 'responsive_header_threshold', '1024' );
$movedo_grve_responsive_header_threshold = filter_var( $movedo_grve_responsive_header_threshold, FILTER_SANITIZE_NUMBER_INT );

/* Container Size
============================================================================= */
$css .= "

.grve-container,
#disqus_thread,
#grve-content.grve-left-sidebar .grve-content-wrapper,
#grve-content.grve-right-sidebar .grve-content-wrapper {
	max-width: " . movedo_grve_option( 'container_size', 1170 ) . "px;
}


@media only screen and (max-width: " . esc_attr( $movedo_grve_container_size_threshold + 60 ) . "px) {
	.grve-container,
	#disqus_thread,
	#grve-content.grve-left-sidebar .grve-content-wrapper,
	#grve-content.grve-right-sidebar .grve-content-wrapper {
		width: 90%;
		max-width: " . movedo_grve_option( 'container_size', 1170 ) . "px;
	}
}

@media only screen and (min-width: 960px) {

	#grve-theme-wrapper.grve-header-side .grve-container,
	#grve-theme-wrapper.grve-header-side #grve-content.grve-left-sidebar .grve-content-wrapper,
	#grve-theme-wrapper.grve-header-side #grve-content.grve-right-sidebar .grve-content-wrapper {
		width: 90%;
		max-width: " . movedo_grve_option( 'container_size', 1170 ) . "px;
	}
}

";



/* Boxed Size
============================================================================= */
$css .= "

body.grve-boxed #grve-theme-wrapper {
	width: 100%;
	max-width: " . movedo_grve_option( 'boxed_size', 1220 ) . "px;
}

#grve-body.grve-boxed #grve-header.grve-fixed #grve-main-header,
#grve-body.grve-boxed #grve-movedo-sticky-header,
#grve-body.grve-boxed .grve-anchor-menu .grve-anchor-wrapper.grve-sticky,
#grve-body.grve-boxed #grve-footer.grve-fixed-footer,
#grve-body.grve-boxed #grve-top-bar.grve-fixed .grve-wrapper {
	max-width: " . movedo_grve_option( 'boxed_size', 1220 ) . "px;
}

@media only screen and (max-width: 1200px) {
	#grve-body.grve-boxed #grve-header.grve-sticky-header #grve-main-header.grve-header-default,
	#grve-body.grve-boxed #grve-header.grve-sticky-header #grve-main-header #grve-bottom-header,
	#grve-body.grve-boxed #grve-header.grve-fixed #grve-main-header {
		max-width: 90%;
	}

	#grve-body.grve-boxed #grve-top-bar.grve-fixed .grve-wrapper {
		max-width: 90%;
	}
}

";

/* Framed Size
============================================================================= */
$movedo_grve_theme_layout = movedo_grve_option( 'theme_layout', 'stretched' );
$movedo_grve_frame_size = movedo_grve_option( 'frame_size', 30 );
if ( 'framed' == $movedo_grve_theme_layout ) {
	$css .= "

	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		body.grve-framed {
			margin: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}
		.grve-frame {
			background-color: " . movedo_grve_option( 'frame_color' ) . ";
		}
		.grve-frame.grve-top {
			top: 0;
			left: 0;
			width: 100%;
			height: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}
		.grve-frame.grve-left {
			top: 0;
			left: 0;
			width: " . esc_attr( $movedo_grve_frame_size ) . "px;
			height: 100%;
		}
		.grve-frame.grve-right {
			top: 0;
			right: 0;
			width: " . esc_attr( $movedo_grve_frame_size ) . "px;
			height: 100%;
		}
		.grve-frame.grve-bottom {
			bottom: 0;
			left: 0;
			width: 100%;
			height: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#grve-body.admin-bar .grve-frame.grve-top {
			top: 32px;
		}

		#grve-header.grve-fixed #grve-main-header,
		#grve-movedo-sticky-header,
		#grve-top-bar.grve-sticky-topbar.grve-fixed .grve-wrapper,
		#grve-theme-wrapper:not(.grve-header-side) .grve-anchor-menu .grve-anchor-wrapper.grve-sticky {
			width: auto;
			left: " . esc_attr( $movedo_grve_frame_size ) . "px;
			right: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#grve-main-header.grve-header-side {
			top: " . esc_attr( $movedo_grve_frame_size ) . "px;
			left: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#grve-main-header.grve-header-side .grve-header-elements-wrapper {
			bottom: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#grve-safebutton-area .grve-logo {
			top: " . esc_attr( $movedo_grve_frame_size ) . "px;
			left: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#grve-safebutton-area .grve-close-button-wrapper {
			top: " . esc_attr( $movedo_grve_frame_size ) . "px;
			right: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		.grve-back-top {
			bottom: -" . esc_attr( $movedo_grve_frame_size ) . "px;
			right: " . ( esc_attr( $movedo_grve_frame_size ) + 20 ) . "px;
		}

		.grve-close-modal {
			top: " . ( esc_attr( $movedo_grve_frame_size ) + 20 ) . "px;
			right: " . ( esc_attr( $movedo_grve_frame_size ) + 20 ) . "px;
		}

		.grve-hiddenarea-wrapper {
			top: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#fp-nav.right,
		#pp-nav.right {
			right: " . ( esc_attr( $movedo_grve_frame_size ) + 20 ) . "px;
		}

		.grve-navigation-bar.grve-layout-3 {
			left: calc(100% - " . esc_attr( $movedo_grve_frame_size ) . "px);
		}

		#grve-body:not(.grve-open-safebutton-area) #grve-footer.grve-fixed-footer {
			bottom: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}

		#grve-top-bar.grve-sticky-topbar.grve-fixed .grve-wrapper {
			top: " . esc_attr( $movedo_grve_frame_size ) . "px;
		}
	}
	";
}

/* Single Post Content Width
============================================================================= */
if ( is_singular( 'post' ) ) {
	$movedo_grve_post_content_width = movedo_grve_post_meta( '_movedo_grve_post_content_width', movedo_grve_option( 'post_content_width', 990 ) );

	if ( !is_numeric( $movedo_grve_post_content_width ) ) {
		$movedo_grve_post_content_width = movedo_grve_option( 'container_size', 1170 );
	}


$css .= "

.single-post #grve-content:not(.grve-right-sidebar):not(.grve-left-sidebar) .grve-container {
	max-width: " . esc_attr( $movedo_grve_post_content_width ) . "px;
}

";

}


/* Top Bar
============================================================================= */
$css .= "
#grve-top-bar .grve-wrapper {
	padding-top: " . movedo_grve_option( 'top_bar_spacing', '', 'padding-top' ) . ";
	padding-bottom: " . movedo_grve_option( 'top_bar_spacing', '', 'padding-bottom'  ) . ";
}

#grve-top-bar .grve-wrapper,
#grve-top-bar .grve-language > li > ul,
#grve-top-bar .grve-top-bar-menu ul.sub-menu {
	background-color: " . movedo_grve_option( 'top_bar_bg_color' ) . ";
	color: " . movedo_grve_option( 'top_bar_font_color' ) . ";
}

#grve-top-bar a {
	color: " . movedo_grve_option( 'top_bar_link_color' ) . ";
}

#grve-top-bar a:hover {
	color: " . movedo_grve_option( 'top_bar_hover_color' ) . ";
}

";

/* Default Header
============================================================================= */
$movedo_grve_header_mode = movedo_grve_option( 'header_mode', 'default' );
if ( 'default' == $movedo_grve_header_mode ) {

	/* - Default Header Colors
	============================================================================= */

	$movedo_grve_default_header_background_color = movedo_grve_option( 'default_header_background_color', '#ffffff' );
	$movedo_grve_default_header_border_color = movedo_grve_option( 'default_header_border_color', '#000000' );
	$css .= "

	#grve-main-header {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_default_header_background_color ) . "," . movedo_grve_option( 'default_header_background_color_opacity', '1') . ");
	}

	#grve-main-header.grve-transparent,
	#grve-main-header.grve-light,
	#grve-main-header.grve-dark {
		background-color: transparent;
	}

	#grve-main-header.grve-header-default,
	.grve-header-elements {
		border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_default_header_border_color ) . "," . movedo_grve_option( 'default_header_border_color_opacity', '1') . ");
	}

	";

	/* - Default Header Menu Colors
	========================================================================= */
	$css .= "
	.grve-logo-text a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li > a,
	.grve-header-element > a,
	.grve-header-element .grve-purchased-items,
	.grve-header-text-element {
		color: " . movedo_grve_option( 'default_header_menu_text_color' ) . ";
	}

	.grve-safe-btn-icon {
		fill: " . movedo_grve_option( 'default_header_menu_text_color' ) . ";
	}
	.grve-logo-text a:hover,
	#grve-header .grve-main-menu .grve-wrapper > ul > li.grve-current > a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li:hover > a,
	.grve-header-element > a:hover {
		color: " . movedo_grve_option( 'default_header_menu_text_hover_color' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-item > a span,
	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-ancestor > a span {
		border-color: " . movedo_grve_option( 'default_header_menu_type_color' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li:hover > a span,
	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.active > a span {
		border-color: " . movedo_grve_option( 'default_header_menu_type_color_hover' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li > a .grve-item:after {
		background-color: " . movedo_grve_option( 'default_header_menu_type_color' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li:hover > a .grve-item:after,
	#grve-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li.active > a .grve-item:after {
		background-color: " . movedo_grve_option( 'default_header_menu_type_color_hover' ) . ";
	}

	";


	/* - Default Header Sub Menu Colors
	========================================================================= */
	$css .= "
	#grve-header .grve-main-menu .grve-wrapper > ul > li ul  {
		background-color: " . movedo_grve_option( 'default_header_submenu_bg_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li a {
		color: " . movedo_grve_option( 'default_header_submenu_text_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li a:hover,
	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li.current-menu-item > a,
	#grve-header .grve-main-menu .grve-wrapper > ul li li.current-menu-ancestor > a {
		color: " . movedo_grve_option( 'default_header_submenu_text_hover_color' ) . ";
		background-color: " . movedo_grve_option( 'default_header_submenu_text_bg_hover_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li.megamenu > ul > li > a {
		color: " . movedo_grve_option( 'default_header_submenu_column_text_color' ) . ";
		background-color: transparent;
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li.megamenu > ul > li:hover > a {
		color: " . movedo_grve_option( 'default_header_submenu_column_text_hover_color' ) . ";
	}

	#grve-header .grve-horizontal-menu ul.grve-menu li.megamenu > .sub-menu > li {
		border-color: " . movedo_grve_option( 'default_header_submenu_border_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li.grve-menu-type-button a {
		background-color: transparent;
	}

	";

	/* - Sub Menu Position
	========================================================================= */
	$movedo_grve_submenu_top_position = movedo_grve_option( 'submenu_top_position', '0' );
	if( 0 != $movedo_grve_submenu_top_position ) {
		$css .= "
		#grve-header:not(.grve-sticky-header) .grve-horizontal-menu ul.grve-menu ul,
		#grve-header.grve-sticky-header[data-sticky='simple'] .grve-horizontal-menu ul.grve-menu ul  {
			margin-top: -" . movedo_grve_option( 'submenu_top_position' ) . "px;
		}
		";
	}

	/* - Default Header Layout
	========================================================================= */
	$css .= "
	#grve-main-header,
	.grve-logo,
	.grve-header-text-element {
		height: " . movedo_grve_option( 'header_height', 120 ) . "px;
	}

	.grve-logo a {
		height: " . movedo_grve_option( 'logo_height', 20 ) . "px;
	}

	.grve-logo.grve-logo-text a {
		line-height: " . movedo_grve_option( 'header_height', 120 ) . "px;
	}

	#grve-main-menu .grve-wrapper > ul > li > a,
	.grve-header-element > a,
	.grve-no-assigned-menu {
		line-height: " . movedo_grve_option( 'header_height', 120 ) . "px;
	}

	.grve-logo .grve-wrapper img {
		padding-top: 0;
		padding-bottom: 0;
	}

	";

	/* Go to section Position */
	$css .= "
	#grve-theme-wrapper.grve-feature-below #grve-goto-section-wrapper {
		margin-bottom: " . movedo_grve_option( 'header_height', 120 ) . "px;
	}
	";

	/* - Default Header Overlaping
	========================================================================= */
	$css .= "
	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		#grve-header.grve-overlapping + .grve-page-title,
		#grve-header.grve-overlapping + #grve-feature-section,
		#grve-header.grve-overlapping + #grve-content,
		#grve-header.grve-overlapping + .grve-single-wrapper,
		#grve-header.grve-overlapping + .grve-product-area {
			top: -" . movedo_grve_option( 'header_height', 120 ) . "px;
			margin-bottom: -" . movedo_grve_option( 'header_height', 120 ) . "px;
		}

		#grve-header.grve-overlapping:not(.grve-header-below) + .grve-page-title .grve-wrapper,
		#grve-header.grve-overlapping:not(.grve-header-below) + #grve-feature-section .grve-wrapper:not(.grve-map) {
			padding-top: " . movedo_grve_option( 'header_height', 120 ) . "px;
		}

		#grve-feature-section + #grve-header.grve-overlapping {
			top: -" . movedo_grve_option( 'header_height', 120 ) . "px;
		}

		#grve-header {
			height: " . movedo_grve_option( 'header_height', 120 ) . "px;
		}
	}

	";
	/* Sticky Sidebar with header overlaping */
	$css .= "
	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		#grve-header.grve-overlapping + #grve-content .grve-sidebar.grve-fixed-sidebar,
		#grve-header.grve-overlapping + .grve-single-wrapper .grve-sidebar.grve-fixed-sidebar {
			top: " . movedo_grve_option( 'header_height', 120 ) . "px;
		}
	}
	";

/* Logo On Top Header
============================================================================= */
} else if ( 'logo-top' == $movedo_grve_header_mode ) {


	/* - Logo On Top Header Colors
	============================================================================= */
	$movedo_grve_logo_top_logo_area_background_color = movedo_grve_option( 'logo_top_header_logo_area_background_color', '#ffffff' );
	$movedo_grve_logo_top_menu_area_background_color = movedo_grve_option( 'logo_top_header_menu_area_background_color', '#ffffff' );
	$movedo_grve_logo_top_border_color = movedo_grve_option( 'logo_top_header_border_color', '#000000' );
	$css .= "

	#grve-main-header #grve-top-header {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_logo_top_logo_area_background_color ) . "," . movedo_grve_option( 'logo_top_header_logo_area_background_color_opacity', '1') . ");
	}

	#grve-main-header #grve-bottom-header {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_logo_top_menu_area_background_color ) . "," . movedo_grve_option( 'logo_top_header_menu_area_background_color_opacity', '1') . ");
		border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_logo_top_border_color ) . "," . movedo_grve_option( 'logo_top_header_border_color_opacity', '1') . ");
	}
	#grve-main-header {
		border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_logo_top_border_color ) . "," . movedo_grve_option( 'logo_top_header_border_color_opacity', '1') . ");
	}

	.grve-header-elements {
		border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_logo_top_border_color ) . "," . movedo_grve_option( 'logo_top_header_border_color_opacity', '1') . ");
	}

	#grve-main-header.grve-transparent #grve-top-header,
	#grve-main-header.grve-light #grve-top-header,
	#grve-main-header.grve-dark #grve-top-header,
	#grve-main-header.grve-transparent #grve-bottom-header,
	#grve-main-header.grve-light #grve-bottom-header,
	#grve-main-header.grve-dark #grve-bottom-header {
		background-color: transparent;
	}

	";

	/* - Logo On Top Header Menu Colors
	========================================================================= */
	$css .= "
	.grve-logo-text a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li > a,
	.grve-header-element > a,
	.grve-header-element .grve-purchased-items,
	.grve-header-text-element {
		color: " . movedo_grve_option( 'logo_top_header_menu_text_color' ) . ";
	}

	.grve-safe-btn-icon {
		fill: " . movedo_grve_option( 'logo_top_header_menu_text_color' ) . ";
	}

	.grve-logo-text a:hover,
	#grve-header .grve-main-menu .grve-wrapper > ul > li.grve-current > a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
	#grve-header .grve-main-menu .grve-wrapper > ul > li:hover > a,
	.grve-header-element > a:hover {
		color: " . movedo_grve_option( 'logo_top_header_menu_text_hover_color' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-item > a span,
	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-ancestor > a span {
		border-color: " . movedo_grve_option( 'logo_top_header_menu_type_color' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li:hover > a span,
	#grve-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.active > a span {
		border-color: " . movedo_grve_option( 'logo_top_header_menu_type_color_hover' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li > a .grve-item:after {
		background-color: " . movedo_grve_option( 'logo_top_header_menu_type_color' ) . ";
	}

	#grve-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li:hover > a .grve-item:after,
	#grve-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li.active > a .grve-item:after {
		background-color: " . movedo_grve_option( 'logo_top_header_menu_type_color_hover' ) . ";
	}


	";


	/* - Logo On Top Header Sub Menu Colors
	========================================================================= */
	$css .= "
	#grve-header .grve-main-menu .grve-wrapper > ul > li ul  {
		background-color: " . movedo_grve_option( 'logo_top_header_submenu_bg_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li a {
		color: " . movedo_grve_option( 'logo_top_header_submenu_text_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li a:hover,
	#grve-header .grve-main-menu .grve-wrapper > ul > li ul li.current-menu-item > a,
	#grve-header .grve-main-menu .grve-wrapper > ul li li.current-menu-ancestor > a {
		color: " . movedo_grve_option( 'logo_top_header_submenu_text_hover_color' ) . ";
		background-color: " . movedo_grve_option( 'logo_top_header_submenu_text_bg_hover_color' ) . ";
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li.megamenu > ul > li > a {
		color: " . movedo_grve_option( 'logo_top_header_submenu_column_text_color' ) . ";
		background-color: transparent;
	}

	#grve-header .grve-main-menu .grve-wrapper > ul > li.megamenu > ul > li:hover > a {
		color: " . movedo_grve_option( 'logo_top_header_submenu_column_text_hover_color' ) . ";
	}

	#grve-header .grve-horizontal-menu ul.grve-menu li.megamenu > .sub-menu > li {
		border-color: " . movedo_grve_option( 'logo_top_header_submenu_border_color' ) . ";
	}

	";

	/* - Logo On Top Header Layout
	========================================================================= */
	$movedo_grve_header_height = intval( movedo_grve_option( 'header_top_height', 120 ) ) + intval( movedo_grve_option( 'header_bottom_height', 50 ) + 1 );
	$css .= "

	#grve-top-header,
	.grve-logo {
		height: " . movedo_grve_option( 'header_top_height', 120 ) . "px;
	}

	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		#grve-header {
			height: " . esc_attr( $movedo_grve_header_height ) . "px;
		}
	}

	.grve-logo a {
		height: " . movedo_grve_option( 'header_top_logo_height', 30 ) . "px;
	}

	.grve-logo.grve-logo-text a {
		line-height: " . movedo_grve_option( 'header_top_height', 120 ) . "px;
	}

	#grve-bottom-header,
	#grve-main-menu,
	.grve-header-text-element {
		height: " . ( movedo_grve_option( 'header_bottom_height', 50 ) + 1 ) . "px;
	}

	#grve-main-menu .grve-wrapper > ul > li > a,
	.grve-header-element > a,
	.grve-no-assigned-menu {
		line-height: " . movedo_grve_option( 'header_bottom_height', 50 ) . "px;
	}

	";

	/* Go to section Position */
	$css .= "
	#grve-theme-wrapper.grve-feature-below #grve-goto-section-wrapper {
		margin-bottom: " . esc_attr( $movedo_grve_header_height ) . "px;
	}
	";

	/* - Logo On Top Header Overlaping
	========================================================================= */
	$css .= "

	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		#grve-header.grve-overlapping + .grve-page-title,
		#grve-header.grve-overlapping + #grve-feature-section,
		#grve-header.grve-overlapping + #grve-content,
		#grve-header.grve-overlapping + .grve-single-wrapper,
		#grve-header.grve-overlapping + .grve-product-area {
			top: -" . esc_attr( $movedo_grve_header_height ) . "px;
			margin-bottom: -" . esc_attr( $movedo_grve_header_height ) . "px;
		}

		#grve-header.grve-overlapping:not(.grve-header-below) + .grve-page-title .grve-wrapper,
		#grve-header.grve-overlapping:not(.grve-header-below) + #grve-feature-section .grve-wrapper:not(.grve-map) {
			padding-top: " . movedo_grve_option( 'header_top_height', 120 ) . "px;
		}

		#grve-feature-section + #grve-header.grve-overlapping {
			top: -" . esc_attr( $movedo_grve_header_height ) . "px;
		}

		.grve-feature-below #grve-feature-section:not(.grve-with-map) .grve-wrapper {
			margin-bottom: " . movedo_grve_option( 'header_top_height', 120 ) . "px;
		}
	}

	";

	/* Sticky Sidebar with header overlaping */
	$css .= "
	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		#grve-header.grve-overlapping + #grve-content .grve-sidebar.grve-fixed-sidebar,
		#grve-header.grve-overlapping + .grve-single-wrapper .grve-sidebar.grve-fixed-sidebar {
			top: " . movedo_grve_option( 'header_height', 120 ) . "px;
		}
	}
	";


} else {

	/* - Side Header Colors
	============================================================================= */
	$movedo_grve_side_header_background_color = movedo_grve_option( 'side_header_background_color', '#ffffff' );
	$css .= "
	#grve-main-header {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_side_header_background_color ) . "," . movedo_grve_option( 'side_header_background_color_opacity', '1') . ");
	}

	#grve-main-header.grve-transparent,
	#grve-main-header.grve-light,
	#grve-main-header.grve-dark {
		background-color: transparent;
	}

	";

	/* - Side Header Menu Colors
	========================================================================= */
	$css .= "
	.grve-logo-text a,
	#grve-main-menu .grve-wrapper > ul > li > a,
	.grve-header-element > a,
	.grve-header-element .grve-purchased-items,
	.grve-header-text-element {
		color: " . movedo_grve_option( 'side_header_menu_text_color' ) . ";

	}

	.grve-safe-btn-icon {
		fill: " . movedo_grve_option( 'side_header_menu_text_color' ) . ";
	}

	.grve-logo-text a:hover,
	#grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
	#grve-main-menu .grve-wrapper > ul > li:hover > a,
	.grve-header-element > a:hover ,
	#grve-main-menu .grve-wrapper > ul > li ul li.grve-goback a {
		color: " . movedo_grve_option( 'side_header_menu_text_hover_color' ) . ";
	}

	";


	/* - Side Header Sub Menu Colors
	========================================================================= */
	$movedo_grve_side_header_border_color = movedo_grve_option( 'side_header_border_color', '#ffffff' );
	$css .= "

	#grve-main-menu .grve-wrapper > ul > li ul li a {
		color: " . movedo_grve_option( 'side_header_submenu_text_color' ) . ";
	}

	#grve-main-menu .grve-wrapper > ul > li ul li a:hover,
	#grve-main-menu .grve-wrapper > ul > li ul li.current-menu-item > a {
		color: " . movedo_grve_option( 'side_header_submenu_text_hover_color' ) . ";
	}

	#grve-main-menu.grve-vertical-menu  ul li a,
	#grve-main-header.grve-header-side .grve-header-elements {
		border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_side_header_border_color ) . "," . movedo_grve_option( 'side_header_border_opacity', '1') . ");
	}

	";

	/* - Side Header Layout
	========================================================================= */
	$css .= "
	.grve-logo a {
		height: " . movedo_grve_option( 'header_side_logo_height', 30 ) . "px;
	}
	#grve-main-header.grve-header-side .grve-logo {
		padding-top: " . movedo_grve_option( 'header_side_logo_spacing', '', 'padding-top' ) . ";
		padding-bottom: " . movedo_grve_option( 'header_side_logo_spacing', '', 'padding-bottom'  ) . ";
	}
	#grve-main-header.grve-header-side .grve-content,
	#grve-main-header.grve-header-side .grve-header-elements-wrapper {
		padding-left: " . movedo_grve_option( 'header_side_spacing', '', 'padding-left' ) . ";
		padding-right: " . movedo_grve_option( 'header_side_spacing', '', 'padding-right'  ) . ";
	}

	@media only screen and (min-width: " . esc_attr( $movedo_grve_responsive_header_threshold ) . "px) {
		#grve-theme-wrapper.grve-header-side,
		#grve-footer.grve-fixed-footer {
			padding-left: " . movedo_grve_option( 'header_side_width', 300 ) . "px;
		}

		.grve-body.rtl #grve-theme-wrapper.grve-header-side,
		.grve-body.rtl #grve-footer.grve-fixed-footer {
			padding-left: 0;
			padding-right: " . movedo_grve_option( 'header_side_width', 120 ) . "px;
		}

		#grve-main-header.grve-header-side,
		#grve-main-header.grve-header-side .grve-content {
			width: " . movedo_grve_option( 'header_side_width', 300 ) . "px;
		}

		.grve-body.grve-boxed #grve-theme-wrapper.grve-header-side #grve-main-header.grve-header-side,
		#grve-footer.grve-fixed-footer {
			margin-left: -" . movedo_grve_option( 'header_side_width', 300 ) . "px;
		}
		.grve-body.grve-boxed.rtl #grve-theme-wrapper.grve-header-side #grve-main-header.grve-header-side,
		.grve-body.rtl #grve-footer.grve-fixed-footer {
			margin-left: 0;
			margin-right: -" . movedo_grve_option( 'header_side_width', 120 ) . "px;
		}
		#grve-main-header.grve-header-side .grve-main-header-wrapper {
			width: " . intval( movedo_grve_option( 'header_side_width', 300 ) + 30 ) . "px;
		}

		.grve-anchor-menu .grve-anchor-wrapper.grve-sticky {
			width: calc(100% - " . movedo_grve_option( 'header_side_width', 120 ) . "px);
		}

		body.grve-boxed .grve-anchor-menu .grve-anchor-wrapper.grve-sticky {
			max-width: calc(" . movedo_grve_option( 'boxed_size', 1220 ) . "px - " . movedo_grve_option( 'header_side_width', 120 ) . "px);
		}
	}

	";
}


/* Menu Label
============================================================================= */
$css .= "
#grve-header .grve-main-menu .grve-item .label.grve-bg-default,
#grve-hidden-menu .grve-item .label.grve-bg-default {
	background-color: " . movedo_grve_option( 'default_header_label_bg_color' ) . ";
	color: " . movedo_grve_option( 'default_header_label_text_color' ) . ";
}
";

/* Light Header
============================================================================= */
$movedo_grve_light_header_border_color = movedo_grve_option( 'light_header_border_color', '#ffffff' );
$css .= "
#grve-main-header.grve-light .grve-logo-text a,
#grve-main-header.grve-light #grve-main-menu .grve-wrapper > ul > li > a,
#grve-main-header.grve-light .grve-header-element > a,
#grve-main-header.grve-light .grve-header-element .grve-purchased-items,
#grve-main-header.grve-light .grve-header-text-element {
	color: #ffffff;
	color: rgba(255,255,255,0.7);
}

#grve-main-header.grve-light .grve-safe-btn-icon {
	fill: #ffffff;
}

#grve-main-header.grve-light .grve-logo-text a:hover,
#grve-main-header.grve-light #grve-main-menu .grve-wrapper > ul > li.grve-current > a,
#grve-main-header.grve-light #grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
#grve-main-header.grve-light #grve-main-menu .grve-wrapper > ul > li:hover > a,
#grve-main-header.grve-light #grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
#grve-main-header.grve-light #grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
#grve-main-header.grve-light .grve-header-element > a:hover {
	color: " . movedo_grve_option( 'light_menu_text_hover_color' ) . ";
}

#grve-main-header.grve-light #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-item > a span,
#grve-main-header.grve-light #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-ancestor > a span,
#grve-main-header.grve-light #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li:hover > a span {
	border-color: " . movedo_grve_option( 'light_menu_type_color_hover' ) . ";
}

#grve-main-header.grve-light #grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li > a .grve-item:after,
#grve-main-header.grve-light #grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li:hover > a .grve-item:after {
	background-color: " . movedo_grve_option( 'light_menu_type_color_hover' ) . ";
}

#grve-main-header.grve-light,
#grve-main-header.grve-light .grve-header-elements,
#grve-main-header.grve-header-default.grve-light,
#grve-main-header.grve-light #grve-bottom-header {
	border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_light_header_border_color ) . "," . movedo_grve_option( 'light_header_border_color_opacity', '1') . ");
}

";

/* Dark Header
============================================================================= */
$movedo_grve_dark_header_border_color = movedo_grve_option( 'dark_header_border_color', '#ffffff' );
$css .= "
#grve-main-header.grve-dark .grve-logo-text a,
#grve-main-header.grve-dark #grve-main-menu .grve-wrapper > ul > li > a,
#grve-main-header.grve-dark .grve-header-element > a,
#grve-main-header.grve-dark .grve-header-element .grve-purchased-items,
#grve-main-header.grve-dark .grve-header-text-element {
	color: #000000;
	color: rgba(0,0,0,0.5);
}

#grve-main-header.grve-dark .grve-safe-btn-icon {
	fill: #000000;
}

#grve-main-header.grve-dark .grve-logo-text a:hover,
#grve-main-header.grve-dark #grve-main-menu .grve-wrapper > ul > li.grve-current > a,
#grve-main-header.grve-dark #grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
#grve-main-header.grve-dark #grve-main-menu .grve-wrapper > ul > li:hover > a,
#grve-main-header.grve-dark #grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
#grve-main-header.grve-dark #grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
#grve-main-header.grve-dark .grve-header-element > a:hover {
	color: " . movedo_grve_option( 'dark_menu_text_hover_color' ) . ";
}

#grve-main-header.grve-dark #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-item > a span,
#grve-main-header.grve-dark #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-ancestor > a span,
#grve-main-header.grve-dark #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li:hover > a span {
	border-color: " . movedo_grve_option( 'dark_menu_type_color_hover' ) . ";
}

#grve-main-header.grve-dark #grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li > a .grve-item:after,
#grve-main-header.grve-dark #grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li:hover > a .grve-item:after {
	background-color: " . movedo_grve_option( 'dark_menu_type_color_hover' ) . ";
}

#grve-main-header.grve-dark,
#grve-main-header.grve-dark .grve-header-elements,
#grve-main-header.grve-header-default.grve-dark,
#grve-main-header.grve-dark #grve-bottom-header {
	border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_dark_header_border_color ) . "," . movedo_grve_option( 'dark_header_border_color_opacity', '1') . ");
}

";


/* Sticky Header
============================================================================= */

	/* - Sticky Default Header
	========================================================================= */
	if ( 'default' == $movedo_grve_header_mode ) {
		$css .= "
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky {
				height: " . movedo_grve_option( 'header_sticky_shrink_height', 60 ) . "px;
			}

			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-logo,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-logo,
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-header-text-element,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-header-text-element {
				height: " . movedo_grve_option( 'header_sticky_shrink_height', 60 ) . "px;
			}

			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-logo a,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-logo a {
				height: " . movedo_grve_option( 'header_sticky_shrink_logo_height', 20 ) . "px;
			}

			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-logo.grve-logo-text a,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-logo.grve-logo-text a {
				line-height: " . movedo_grve_option( 'header_sticky_shrink_height', 60 ) . "px;
			}

			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky #grve-main-menu .grve-wrapper > ul > li > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-header-element > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-no-assigned-menu,

			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky #grve-main-menu .grve-wrapper > ul > li > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-header-element > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-no-assigned-menu {
				line-height: " . movedo_grve_option( 'header_sticky_shrink_height', 60 ) . "px;
			}

			#grve-header.grve-sticky-header.grve-scroll-up #grve-main-header.grve-advanced-sticky {
				-webkit-transform: translateY(" . movedo_grve_option( 'header_height', 120 ) . "px);
				-moz-transform:    translateY(" . movedo_grve_option( 'header_height', 120 ) . "px);
				-ms-transform:     translateY(" . movedo_grve_option( 'header_height', 120 ) . "px);
				-o-transform:      translateY(" . movedo_grve_option( 'header_height', 120 ) . "px);
				transform:         translateY(" . movedo_grve_option( 'header_height', 120 ) . "px);
			}

		";

	/* - Sticky Logo On Top Header
	========================================================================= */
	} else if ( 'logo-top' == $movedo_grve_header_mode ) {
		$movedo_grve_header_height = intval( movedo_grve_option( 'header_sticky_shrink_height', 120 ) ) + intval( movedo_grve_option( 'header_bottom_height', 50 ) );
		$css .= "

			#grve-header.grve-sticky-header #grve-main-header.grve-simple-sticky,
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky {
				-webkit-transform: translateY(-" . movedo_grve_option( 'header_top_height', 120 ) . "px);
				-moz-transform:    translateY(-" . movedo_grve_option( 'header_top_height', 120 ) . "px);
				-ms-transform:     translateY(-" . movedo_grve_option( 'header_top_height', 120 ) . "px);
				-o-transform:      translateY(-" . movedo_grve_option( 'header_top_height', 120 ) . "px);
				transform:         translateY(-" . movedo_grve_option( 'header_top_height', 120 ) . "px);
			}

			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky #grve-bottom-header,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky #grve-bottom-header {
				height: " . movedo_grve_option( 'header_sticky_shrink_height', 60 ) . "px;
			}

			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky #grve-main-menu .grve-wrapper > ul > li > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-header-element > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-shrink-sticky .grve-no-assigned-menu,

			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky #grve-main-menu .grve-wrapper > ul > li > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-header-element > a,
			#grve-header.grve-sticky-header #grve-main-header.grve-advanced-sticky .grve-no-assigned-menu {
				line-height: " . movedo_grve_option( 'header_sticky_shrink_height', 60 ) . "px;
			}


			#grve-header.grve-sticky-header.grve-scroll-up #grve-main-header.grve-advanced-sticky {
				-webkit-transform: translateY(" . movedo_grve_option( 'header_bottom_height', 50 ) . "px);
				-moz-transform:    translateY(" . movedo_grve_option( 'header_bottom_height', 50 ) . "px);
				-ms-transform:     translateY(" . movedo_grve_option( 'header_bottom_height', 50 ) . "px);
				-o-transform:      translateY(" . movedo_grve_option( 'header_bottom_height', 50 ) . "px);
				transform:         translateY(" . movedo_grve_option( 'header_bottom_height', 50 ) . "px);
			}

		";
	}


	/* - Sticky Header Colors
	========================================================================= */
	$movedo_grve_header_sticky_border_color = movedo_grve_option( 'header_sticky_border_color', '#ffffff' );
	$movedo_grve_header_sticky_background_color = movedo_grve_option( 'header_sticky_background_color', '#ffffff' );
	$css .= "

	#grve-header.grve-sticky-header #grve-main-header:not(.grve-header-logo-top),
	#grve-header.grve-sticky-header #grve-main-header #grve-bottom-header {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_header_sticky_background_color ) . "," . movedo_grve_option( 'header_sticky_background_color_opacity', '1') . ");
	}

	#grve-header.grve-header-logo-top.grve-sticky-header #grve-main-header {
		background-color: transparent;
	}

	#grve-header.grve-sticky-header .grve-logo-text a,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li > a,
	#grve-header.grve-sticky-header #grve-main-header .grve-header-element > a,
	#grve-header.grve-sticky-header .grve-header-element .grve-purchased-items,
	#grve-header.grve-sticky-header .grve-header-text-element {
		color: " . movedo_grve_option( 'sticky_menu_text_color' ) . ";
	}

	#grve-header.grve-sticky-header .grve-logo-text a:hover,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li.grve-current > a,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li:hover > a,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
	#grve-header.grve-sticky-header #grve-main-header #grve-main-menu .grve-wrapper > ul > li.active > a,
	#grve-header.grve-sticky-header #grve-main-header .grve-header-element > a:hover {
		color: " . movedo_grve_option( 'sticky_menu_text_hover_color' ) . ";
	}

	#grve-header.grve-sticky-header #grve-main-header .grve-safe-btn-icon {
		fill: " . movedo_grve_option( 'sticky_menu_text_hover_color' ) . ";
	}

	#grve-header.grve-sticky-header #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-item > a span,
	#grve-header.grve-sticky-header #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li.current-menu-ancestor > a span {
		border-color: " . movedo_grve_option( 'header_sticky_menu_type_color' ) . ";
	}

	#grve-header.grve-sticky-header #grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li:hover > a span {
		border-color: " . movedo_grve_option( 'header_sticky_menu_type_color_hover' ) . ";
	}

	#grve-header.grve-sticky-header #grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li > a .grve-item:after {
		background-color: " . movedo_grve_option( 'header_sticky_menu_type_color' ) . ";
	}

	#grve-header.grve-sticky-header #grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li:hover > a .grve-item:after {
		background-color: " . movedo_grve_option( 'header_sticky_menu_type_color_hover' ) . ";
	}

	#grve-header.grve-sticky-header #grve-main-header.grve-header-default,
	#grve-header.grve-sticky-header #grve-main-header .grve-header-elements {
		border-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_header_sticky_border_color ) . "," . movedo_grve_option( 'header_sticky_border_color_opacity', '1') . ");
	}

	";

	/* - Movedo Sticky Header
	========================================================================= */
	$css .= "

	#grve-movedo-sticky-header,
	#grve-movedo-sticky-header .grve-logo,
	#grve-movedo-sticky-header:before {
		height: " . movedo_grve_option( 'header_sticky_shrink_height', 120 ) . "px;
	}

	#grve-movedo-sticky-header .grve-logo a {
		height: " . movedo_grve_option( 'header_sticky_shrink_logo_height', 20 ) . "px;
	}

	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li > a,
	#grve-movedo-sticky-header .grve-header-element > a,
	#grve-movedo-sticky-header .grve-no-assigned-menu {
		line-height: " . movedo_grve_option( 'header_sticky_shrink_height', 120 ) . "px;
	}

	#grve-movedo-sticky-header:before,
	#grve-movedo-sticky-header .grve-logo,
	#grve-movedo-sticky-header .grve-header-element > a.grve-safe-button {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_header_sticky_background_color ) . "," . movedo_grve_option( 'header_sticky_background_color_opacity', '1') . ");
	}

	#grve-movedo-sticky-header .grve-logo,
	#grve-movedo-sticky-header .grve-header-element > a.grve-safe-button {
		min-width: " . movedo_grve_option( 'header_sticky_shrink_height', 120 ) . "px;
	}

	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li > a,
	#grve-movedo-sticky-header .grve-header-element > a {
		color: " . movedo_grve_option( 'sticky_menu_text_color' ) . ";
	}

	#grve-movedo-sticky-header .grve-safe-btn-icon {
		fill: " . movedo_grve_option( 'sticky_menu_text_hover_color' ) . ";
	}

	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li.grve-current > a,
	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li:hover > a,
	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li.current-menu-item > a,
	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li.current-menu-ancestor > a,
	#grve-movedo-sticky-header .grve-main-menu .grve-wrapper > ul > li.active > a,
	#grve-movedo-sticky-header .grve-header-element > a:hover {
		color: " . movedo_grve_option( 'sticky_menu_text_hover_color' ) . ";
	}

	#grve-movedo-sticky-header .grve-main-menu.grve-menu-type-button .grve-wrapper > ul > li:hover > a span {
		border-color: " . movedo_grve_option( 'header_sticky_menu_type_color_hover' ) . ";
	}

	#grve-movedo-sticky-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li > a .grve-item:after {
		background-color: " . movedo_grve_option( 'header_sticky_menu_type_color' ) . ";
	}

	#grve-movedo-sticky-header .grve-main-menu.grve-menu-type-underline .grve-wrapper > ul > li:hover > a .grve-item:after {
		background-color: " . movedo_grve_option( 'header_sticky_menu_type_color_hover' ) . ";
	}

	";

/* Side Area Colors
============================================================================= */
$movedo_grve_sliding_area_overflow_background_color = movedo_grve_option( 'sliding_area_overflow_background_color', '#000000' );
$css .= "
#grve-sidearea {
	background-color: " . movedo_grve_option( 'sliding_area_background_color' ) . ";
	color: " . movedo_grve_option( 'sliding_area_text_color' ) . ";
}

#grve-sidearea .widget,
#grve-sidearea form,
#grve-sidearea form p,
#grve-sidearea form div,
#grve-sidearea form span {
	color: " . movedo_grve_option( 'sliding_area_text_color' ) . ";
}

#grve-sidearea h1,
#grve-sidearea h2,
#grve-sidearea h3,
#grve-sidearea h4,
#grve-sidearea h5,
#grve-sidearea h6,
#grve-sidearea .widget .grve-widget-title {
	color: " . movedo_grve_option( 'sliding_area_title_color' ) . ";
}

#grve-sidearea a {
	color: " . movedo_grve_option( 'sliding_area_link_color' ) . ";
}

#grve-sidearea .widget li a .grve-arrow:after,
#grve-sidearea .widget li a .grve-arrow:before {
	color: " . movedo_grve_option( 'sliding_area_link_color' ) . ";
}

#grve-sidearea a:hover {
	color: " . movedo_grve_option( 'sliding_area_link_hover_color' ) . ";
}

#grve-sidearea .grve-close-btn:after,
#grve-sidearea .grve-close-btn:before,
#grve-sidearea .grve-close-btn span {
	background-color: " . movedo_grve_option( 'sliding_area_close_btn_color' ) . ";
}

#grve-sidearea .grve-border,
#grve-sidearea form,
#grve-sidearea form p,
#grve-sidearea form div,
#grve-sidearea form span,
#grve-sidearea .widget a,
#grve-sidearea .widget ul,
#grve-sidearea .widget li,
#grve-sidearea .widget table,
#grve-sidearea .widget table td,
#grve-sidearea .widget table th,
#grve-sidearea .widget table tr,
#grve-sidearea table,
#grve-sidearea tr,
#grve-sidearea td,
#grve-sidearea th,
#grve-sidearea .widget,
#grve-sidearea .widget ul,
#grve-sidearea .widget li,
#grve-sidearea .widget div,
#grve-theme-wrapper #grve-sidearea form,
#grve-theme-wrapper #grve-sidearea .wpcf7-form-control-wrap {
	border-color: " . movedo_grve_option( 'sliding_area_border_color' ) . ";
}

#grve-sidearea-overlay {
	background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_sliding_area_overflow_background_color ) . "," . movedo_grve_option( 'sliding_area_overflow_background_color_opacity', '0.9') . ");
}
";


/* Modals Colors
============================================================================= */
$movedo_grve_modal_overflow_background_color = movedo_grve_option( 'modal_overflow_background_color', '#000000' );
$css .= "

#grve-modal-overlay,
.mfp-bg,
#grve-loader-overflow {
	background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_modal_overflow_background_color ) . "," . movedo_grve_option( 'modal_overflow_background_color_opacity', '0.9') . ");
}

.grve-page-curtain {
	background-color: #18252a;
}

#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) h1,
#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) h2,
#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) h3,
#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) h4,
#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) h5,
#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) h6,
#grve-theme-wrapper .grve-modal-content .grve-form-style-1:not(.grve-white-bg) .grve-modal-title,
.mfp-title,
.mfp-counter,
#grve-theme-wrapper .grve-modal-content .grve-heading-color {
	color: " . movedo_grve_option( 'modal_title_color' ) . ";
}

";

$movedo_grve_close_cursor_color = movedo_grve_option( 'modal_cursor_color_color', 'dark' );
if ( 'dark' == $movedo_grve_close_cursor_color ) {
	$css .= "
	.grve-close-modal,
	button.mfp-arrow {
		color: #000000;
	}
	";
} else {
	$css .= "
	.grve-close-modal,
	button.mfp-arrow {
		color: #ffffff;
	}
	";
}

$css .= "
#grve-theme-wrapper .grve-modal form,
#grve-theme-wrapper .grve-modal form p,
#grve-theme-wrapper .grve-modal form div,
#grve-theme-wrapper .grve-modal form span,
#grve-theme-wrapper .grve-login-modal-footer,
#grve-socials-modal .grve-social li a,
#grve-language-modal ul li a {
	color: " . movedo_grve_option( 'modal_text_color' ) . ";
	border-color: " . movedo_grve_option( 'modal_border_color' ) . ";
}

#grve-safebutton-area .grve-logo {
	background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_header_sticky_background_color ) . "," . movedo_grve_option( 'header_sticky_background_color_opacity', '1') . ");
	min-width: " . movedo_grve_option( 'header_sticky_shrink_height', 120 ) . "px;
	height: " . movedo_grve_option( 'header_sticky_shrink_height', 20 ) . "px;
}

#grve-safebutton-area .grve-logo a {
	height: " . movedo_grve_option( 'header_sticky_shrink_logo_height', 20 ) . "px;
}

#grve-safebutton-area .grve-close-button-wrapper {
	background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_header_sticky_background_color ) . "," . movedo_grve_option( 'header_sticky_background_color_opacity', '1') . ");
	min-width: " . movedo_grve_option( 'header_sticky_shrink_height', 120 ) . "px;
	line-height: " . movedo_grve_option( 'header_sticky_shrink_height', 120 ) . "px;
}

#grve-safebutton-area .grve-close-button-wrapper a {
	color: " . movedo_grve_option( 'sticky_menu_text_color' ) . ";
}

#grve-safebutton-area .grve-close-button-wrapper a:hover {
	color: " . movedo_grve_option( 'sticky_menu_text_hover_color' ) . ";
}


";

/* Responsive Header
============================================================================= */
$movedo_grve_responsive_header_background_color = movedo_grve_option( 'responsive_header_background_color', '#000000' );
$css .= "
#grve-responsive-header #grve-main-responsive-header {
	background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_responsive_header_background_color ) . "," . movedo_grve_option( 'responsive_header_background_opacity', '1') . ");
}
";
	/* - Header Layout
	========================================================================= */
	$css .= "
	#grve-responsive-header {
		height: " . movedo_grve_option( 'responsive_header_height' ) . "px;
	}

	#grve-responsive-header .grve-logo {
		height: " . movedo_grve_option( 'responsive_header_height' ) . "px;
	}

	#grve-responsive-header .grve-header-element > a {
		line-height: " . movedo_grve_option( 'responsive_header_height' ) . "px;
	}

	#grve-responsive-header .grve-logo a {
		height: " . movedo_grve_option( 'responsive_logo_height' ) . "px;
	}

	#grve-responsive-header .grve-logo.grve-logo-text a {
		line-height: " . movedo_grve_option( 'responsive_header_height' ) . "px;
	}

	#grve-responsive-header .grve-logo .grve-wrapper img {
		padding-top: 0;
		padding-bottom: 0;
	}
	";

	/* - Responsive Header / Responsive Menu
	========================================================================= */
	$css .= "

	@media only screen and (max-width: " . esc_attr( $movedo_grve_responsive_header_threshold - 1 ) . "px) {
		#grve-main-header,
		#grve-bottom-header {
			display: none;
		}

		#grve-main-menu,
		#grve-responsive-hidden-menu-wrapper {
			display: none;
		}

		#grve-responsive-header {
			display: block;
		}
		.grve-header-responsive-elements {
			display: block;
		}

		#grve-logo.grve-position-center,
		#grve-logo.grve-position-center .grve-wrapper {
			position: relative;
			left: 0;
		}

		#grve-responsive-menu-wrapper {
			display: block;
		}
	}
	";

	/* - Responsive Header Overlaping
	========================================================================= */
	$css .= "

	@media only screen and (max-width: " . esc_attr( $movedo_grve_responsive_header_threshold - 1 ) . "px) {
		#grve-header.grve-responsive-overlapping + * {
			top: -" . movedo_grve_option( 'responsive_header_height' ) . "px;
			margin-bottom: -" . movedo_grve_option( 'responsive_header_height' ) . "px;
		}

		#grve-header.grve-responsive-overlapping + #grve-page-anchor {
			top: 0px;
			margin-bottom: 0px;
		}

		#grve-feature-section + #grve-header.grve-responsive-overlapping {
			top: -" . movedo_grve_option( 'responsive_header_height' ) . "px;
		}

		#grve-header.grve-responsive-overlapping + .grve-page-title .grve-wrapper,
		#grve-header.grve-responsive-overlapping + #grve-feature-section .grve-wrapper {
			padding-top: " . movedo_grve_option( 'responsive_header_height' ) . "px;
		}

	}
	";

	/* - Responsive Menu
	========================================================================= */
	$movedo_grve_responsive_menu_overflow_background_color = movedo_grve_option( 'responsive_menu_overflow_background_color', '#000000' );
	$css .= "

	#grve-hidden-menu {
		background-color: " . movedo_grve_option( 'responsive_menu_background_color' ) . ";
	}

	#grve-hidden-menu a {
		color: " . movedo_grve_option( 'responsive_menu_link_color' ) . ";
	}

	#grve-hidden-menu:not(.grve-slide-menu) ul.grve-menu li a .grve-arrow:after,
	#grve-hidden-menu:not(.grve-slide-menu) ul.grve-menu li a .grve-arrow:before {
		background-color: " . movedo_grve_option( 'responsive_menu_link_color' ) . ";
	}

	#grve-hidden-menu ul.grve-menu li.open > a .grve-arrow:after,
	#grve-hidden-menu ul.grve-menu li.open > a .grve-arrow:before {
		background-color: " . movedo_grve_option( 'responsive_menu_link_hover_color' ) . ";
	}

	#grve-hidden-menu.grve-slide-menu ul.grve-menu li > .grve-arrow:hover {
		color: " . movedo_grve_option( 'responsive_menu_link_hover_color' ) . ";
	}

	#grve-theme-wrapper .grve-header-responsive-elements form,
	#grve-theme-wrapper .grve-header-responsive-elements form p,
	#grve-theme-wrapper .grve-header-responsive-elements form div,
	#grve-theme-wrapper .grve-header-responsive-elements form span {
		color: " . movedo_grve_option( 'responsive_menu_link_color' ) . ";
	}

	#grve-hidden-menu a:hover,
	#grve-hidden-menu ul.grve-menu > li.current-menu-item > a,
	#grve-hidden-menu ul.grve-menu > li.current-menu-ancestor > a,
	#grve-hidden-menu ul.grve-menu li.current-menu-item > a,
	#grve-hidden-menu ul.grve-menu li.open > a {
		color: " . movedo_grve_option( 'responsive_menu_link_hover_color' ) . ";
	}

	#grve-hidden-menu .grve-close-btn {
		color: " . movedo_grve_option( 'responsive_menu_close_btn_color' ) . ";
	}

	#grve-hidden-menu ul.grve-menu li a,
	#grve-theme-wrapper .grve-header-responsive-elements form,
	#grve-theme-wrapper .grve-header-responsive-elements form p,
	#grve-theme-wrapper .grve-header-responsive-elements form div,
	#grve-theme-wrapper .grve-header-responsive-elements form span {
		border-color: " . movedo_grve_option( 'responsive_menu_border_color' ) . ";
	}

	#grve-hidden-menu-overlay {
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_responsive_menu_overflow_background_color ) . "," . movedo_grve_option( 'responsive_menu_overflow_background_color_opacity', '0.9') . ");
	}

	";

	/* - Responsive Header Elements
	========================================================================= */
	$css .= "
	#grve-responsive-header .grve-header-element > a,
	#grve-responsive-header .grve-header-element .grve-purchased-items {
		color: " . movedo_grve_option( 'responsive_header_elements_color' ) . ";
	}

	#grve-responsive-header .grve-header-element > a:hover {
		color: " . movedo_grve_option( 'responsive_header_elements_hover_color' ) . ";
	}

	#grve-responsive-header .grve-safe-btn-icon {
		fill: " . movedo_grve_option( 'responsive_header_elements_color' ) . ";
	}

	#grve-responsive-header .grve-safe-btn-icon:hover {
		fill: " . movedo_grve_option( 'responsive_header_elements_hover_color' ) . ";
	}

	";


/* Spinner
============================================================================= */


$spinner_image_id = movedo_grve_option( 'spinner_image', '', 'id' );
$spinner_style = movedo_grve_option( 'spinner_style', 'ring' );
if ( empty( $spinner_image_id ) ) {

	if ( 'dual-ring' == $spinner_style ) {
		$css .= "
		.grve-spinner:not(.custom):before {
			content: '';
			box-sizing: border-box;
			position: absolute;
			top: 50%;
			left: 50%;
			width: 36px;
			height: 36px;
			margin-top: -18px;
			margin-left: -18px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #07d;
			border-bottom-color: #07d;
			-webkit-animation: spinnerAnim 1.1s infinite linear;
			animation: spinnerAnim 1.1s infinite linear;
		}
		.grve-spinner:not(.custom):before {
			border-top-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
			border-bottom-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		}
		";
	} else if ( 'bullets' == $spinner_style ) {
		$css .="
		.grve-spinner:not(.custom),
		.grve-spinner:not(.custom):before,
		.grve-spinner:not(.custom):after {
			border-radius: 50%;
			width: 8px;
			height: 8px;
			background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both;
			-webkit-animation: spinnerBulletAnim 1.8s infinite ease-in-out;
			animation: spinnerBulletAnim 1.8s infinite ease-in-out;
		}
		.grve-spinner:not(.custom) {
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -4px;
			margin-left: -4px;
			-webkit-animation-delay: -0.16s;
			animation-delay: -0.16s;
		}
		.grve-spinner:not(.custom):before,
		.grve-spinner:not(.custom):after {
			content: '';
			position: absolute;
			top: 0;
		}
		.grve-spinner:not(.custom):before {
			left: -16px;
			-webkit-animation-delay: -0.32s;
			animation-delay: -0.32s;
		}
		.grve-spinner:not(.custom):after {
			left: 16px
		}

		@-webkit-keyframes spinnerBulletAnim {
			0%,
			80%,
			100% { opacity: 1; }
			40% { opacity: 0; }
		}
		@keyframes spinnerBulletAnim {
			0%,
			80%,
			100% { opacity: 1; }
			40% { opacity: 0; }
		}

		";
	} else if ( 'roller' == $spinner_style ) {
		$css .= "
		.grve-spinner:not(.custom):before {
			content: '';
			box-sizing: border-box;
			position: absolute;
			top: 50%;
			left: 50%;
			width: 60px;
			height: 60px;
			margin-top: -30px;
			margin-left: -30px;
			border-radius: 50%;
			border-top: 2px solid #07d;
			border-right: 2px solid transparent;
			-webkit-animation: spinnerAnim 1.1s infinite linear;
			animation: spinnerAnim 1.1s infinite linear;
		}
		.grve-spinner:not(.custom):before {
			border-top-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		}
		";
	} else {
		$css .= "
		.grve-spinner:not(.custom):before {
			content: '';
			box-sizing: border-box;
			position: absolute;
			top: 50%;
			left: 50%;
			width: 42px;
			height: 42px;
			margin-top: -21px;
			margin-left: -21px;
			border-radius: 50%;
			border: 2px solid rgba(127, 127, 127, 0.3);
			border-top-color: #333;
			-webkit-animation: spinnerAnim 1.1s infinite linear;
			animation: spinnerAnim 1.1s infinite linear;
		}

		.grve-spinner:not(.custom):before {
			border-top-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		}
		";
	}
	$css .= "
	.grve-isotope .grve-spinner:before {
		top: 50px;
	}
	@-webkit-keyframes spinnerAnim {
		0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
	}
	@keyframes spinnerAnim {
		0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
	}
	";
} else {

	$spinner_src = wp_get_attachment_image_src( $spinner_image_id, 'full' );
	$spinner_image_url = $spinner_src[0];
	$spinner_width = $spinner_src[1];
	$spinner_height = $spinner_src[2];

	$css .= "

	.grve-spinner:not(.custom) {
		width: " . intval( $spinner_width ) . "px;
		height: " . intval( $spinner_height ) . "px;
		background-image: url(" . esc_url( $spinner_image_url ) . ");
		background-position: center center;
		display: inline-block;
		position: absolute;
		top: 50%;
		left: 50%;
		margin-top: -" . intval( $spinner_height / 2 ) . "px;
		margin-left: -" . intval( $spinner_width / 2 ) . "px;
	}

	.grve-isotope .grve-spinner {
		top: 50px;
	}

	";
}

/* Box Item
============================================================================= */
$css .= "
#grve-theme-wrapper .grve-box-item.grve-bg-white {
	color: #000000;
	color: rgba(0,0,0,0.30);
	background-color: #ffffff;
	-webkit-box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.25);
	-moz-box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.25);
	box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.25);
}

#grve-theme-wrapper .grve-box-item.grve-bg-black {
	color: #ffffff;
	color: rgba(255,255,255,0.60);
	background-color: #000000;
	-webkit-box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.25);
	-moz-box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.25);
	box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.25);
}

#grve-theme-wrapper .grve-box-item.grve-bg-white .grve-heading-color {
	color: #000000;
}

#grve-theme-wrapper .grve-box-item.grve-bg-black .grve-heading-color {
	color: #ffffff;
}

";


/* Primary Text Color
============================================================================= */
$css .= "
::-moz-selection {
    color: #ffffff;
    background: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}

::selection {
    color: #ffffff;
    background: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}
";

/* Headings Colors */
$css .= "

h1,h2,h3,h4,h5,h6,
.grve-h1,
.grve-h2,
.grve-h3,
.grve-h4,
.grve-h5,
.grve-h6,
.grve-heading-color,
.grve-heading-hover-color:hover,
p.grve-dropcap:first-letter,
h3#reply-title:hover {
	color: " . movedo_grve_option( 'body_heading_color' ) . ";
}
";

/* Primary Colors */
$css .= "
.grve-blog .grve-blog-item:not(.grve-style-2) .grve-post-title.grve-post-title-hover:hover,
.grve-blog-leader .grve-post-list .grve-post-title.grve-post-title-hover:hover,
.grve-blog .grve-post-meta-wrapper li a:hover,
.grve-blog ul.grve-post-meta a:hover,
.grve-search button[type='submit']:hover,
#grve-content .widget.widget_nav_menu li.current-menu-item a,
#grve-content .widget.widget_nav_menu li a:hover,
.widget.widget_calendar table tbody a,
blockquote > p:before,
.grve-filter.grve-filter-style-classic ul li:hover,
.grve-filter.grve-filter-style-classic ul li.selected {
	color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}
";

/* Primary Bg Color
============================================================================= */
$css .= "
#grve-theme-wrapper .grve-widget.grve-social li a.grve-outline:hover,
#grve-theme-wrapper .grve-with-line:after,
#grve-single-post-tags .grve-tags li a:hover,
#grve-single-post-categories .grve-categories li a:hover,
#grve-socials-modal .grve-social li a:hover,
.grve-hover-underline:after,
.grve-language-element ul li a:hover,
.grve-language-element ul li a.active,
#grve-language-modal ul li a:hover,
#grve-language-modal ul li a.active,
.grve-tabs-title .grve-tab-title.active .grve-title:after,
.wpcf7-form input[type='radio']:checked + .wpcf7-list-item-label:after,
.wpcf7-form input[type='radio']:not(:checked) + .wpcf7-list-item-label:after,
.wpcf7-form input[type='checkbox']:checked + .wpcf7-list-item-label:after,
.wpcf7-form input[type='checkbox']:not(:checked) + .wpcf7-list-item-label:after {
	background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	border-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	color: #ffffff;
}
";


/* Dark */
$css .= "
a.grve-text-dark,
.grve-blog.grve-with-shadow .grve-blog-item:not(.grve-style-2) .grve-post-title,
.grve-blog.grve-with-shadow .grve-blog-item:not(.grve-style-2) .grve-read-more {
	color: #000000;
}
";

/* Light */
$css .= "
a.grve-text-light,
.grve-carousel-style-2 .grve-blog-carousel .grve-post-title {
	color: #ffffff;
}

";

/* Primary - Predefined Colors
============================================================================= */
function movedo_grve_print_css_colors() {

	$movedo_grve_colors = movedo_grve_get_color_array();

	$css = '';

	foreach ( $movedo_grve_colors as $key => $value ) {

		$font_color = '#ffffff';
		if( 'white' == $key || 'light' == $key ) {
			$font_color = '#000000';
		}

		// Headings Colors
		$css .= "
			.grve-headings-" . esc_attr( $key ) . " h1,
			.grve-headings-" . esc_attr( $key ) . " h2,
			.grve-headings-" . esc_attr( $key ) . " h3,
			.grve-headings-" . esc_attr( $key ) . " h4,
			.grve-headings-" . esc_attr( $key ) . " h5,
			.grve-headings-" . esc_attr( $key ) . " h6,
			.grve-headings-" . esc_attr( $key ) . " .grve-heading-color,
			.grve-column.grve-headings-" . esc_attr( $key ) . " h1,
			.grve-column.grve-headings-" . esc_attr( $key ) . " h2,
			.grve-column.grve-headings-" . esc_attr( $key ) . " h3,
			.grve-column.grve-headings-" . esc_attr( $key ) . " h4,
			.grve-column.grve-headings-" . esc_attr( $key ) . " h5,
			.grve-column.grve-headings-" . esc_attr( $key ) . " h6,
			.grve-column.grve-headings-" . esc_attr( $key ) . " .grve-heading-color,
			.grve-split-content .grve-headings-" . esc_attr( $key ) . ".grve-media-wrapper .grve-title {
				color: " . esc_attr( $value ) . ";
			}
		";

		// Text Color
		$css .= "
			.grve-text-" . esc_attr( $key ) . ",
			#grve-theme-wrapper .grve-text-hover-" . esc_attr( $key ) . ":hover,
			#grve-theme-wrapper a.grve-text-hover-" . esc_attr( $key ) . ":hover,
			#grve-theme-wrapper a .grve-text-hover-" . esc_attr( $key ) . ":hover {
				color: " . esc_attr( $value ) . ";
			}
			.grve-text-" . esc_attr( $key ) . ".grve-svg-icon {
				stroke: " . esc_attr( $value ) . ";
			}
		";

		// Background Color
		$css .= "
			#grve-theme-wrapper .grve-bg-" . esc_attr( $key ) . ",
			#grve-theme-wrapper .grve-bg-hover-" . esc_attr( $key ) . ":hover,
			#grve-theme-wrapper a.grve-bg-hover-" . esc_attr( $key ) . ":hover,
			#grve-theme-wrapper a .grve-bg-hover-" . esc_attr( $key ) . ":hover,
			#grve-theme-wrapper a:hover .grve-bg-hover-" . esc_attr( $key ) . ",
			.grve-filter.grve-filter-style-button.grve-filter-color-" . esc_attr( $key ) . " ul li.selected {
				background-color: " . esc_attr( $value ) . ";
				border-color: " . esc_attr( $value ) . ";
				color: " . esc_attr( $font_color ) . ";
			}

			#grve-theme-wrapper a.grve-btn-line.grve-bg-" . esc_attr( $key ) . " {
				background-color: transparent;
				border-color: " . esc_attr( $value ) . ";
				color: " . esc_attr( $value ) . ";
			}

			#grve-theme-wrapper a.grve-btn-line.grve-bg-hover-" . esc_attr( $key ) . ":hover {
				background-color: " . esc_attr( $value ) . ";
				border-color: " . esc_attr( $value ) . ";
				color: " . esc_attr( $font_color ) . ";
			}

			#grve-theme-wrapper .grve-menu-type-button.grve-" . esc_attr( $key ) . " > a .grve-item,
			#grve-theme-wrapper .grve-menu-type-button.grve-hover-" . esc_attr( $key ) . " > a:hover .grve-item {
				background-color: " . esc_attr( $value ) . ";
				color: " . esc_attr( $font_color ) . ";
			}
		";

	}

	return $css;
}

$css .= movedo_grve_print_css_colors();

/* Anchor Menu
============================================================================= */

// Anchor Colors
$css .= "

.grve-anchor-menu .grve-anchor-wrapper,
.grve-anchor-menu .grve-container ul,
#grve-responsive-anchor {
	background-color: " . movedo_grve_option( 'page_anchor_menu_background_color' ) . ";
}

.grve-anchor-menu .grve-anchor-wrapper,
.grve-anchor-menu .grve-container > ul > li > a,
.grve-anchor-menu .grve-container ul li a,
.grve-anchor-menu .grve-container > ul > li:last-child > a,
#grve-responsive-anchor a {
	border-color: " . movedo_grve_option( 'page_anchor_menu_border_color' ) . ";
}

.grve-anchor-menu a,
#grve-responsive-anchor a,
#grve-responsive-anchor .grve-close-btn {
	color: " . movedo_grve_option( 'page_anchor_menu_text_color' ) . ";
	background-color: transparent;
}

#grve-responsive-anchor a .grve-arrow:after,
#grve-responsive-anchor a .grve-arrow:before {
	background-color: " . movedo_grve_option( 'page_anchor_menu_text_color' ) . ";
}

.grve-anchor-menu a:hover,
.grve-anchor-menu .grve-container > ul > li.active > a {
	color: " . movedo_grve_option( 'page_anchor_menu_text_hover_color' ) . ";
	background-color: " . movedo_grve_option( 'page_anchor_menu_background_hover_color' ) . ";
}

#grve-responsive-anchor a:hover span {
	color: " . movedo_grve_option( 'page_anchor_menu_text_hover_color' ) . ";
}

.grve-anchor-menu a .grve-arrow:after,
.grve-anchor-menu a .grve-arrow:before,
#grve-responsive-anchor a .grve-arrow:hover:after,
#grve-responsive-anchor a .grve-arrow:hover:before {
	background-color: " . movedo_grve_option( 'page_anchor_menu_text_hover_color' ) . ";
}

";

// Page Anchor Size
$css .= "

#grve-page-anchor {
	height: " . intval( movedo_grve_option( 'page_anchor_menu_height', 120 ) + 2 ) . "px;
}

#grve-page-anchor .grve-anchor-wrapper {
	line-height: " . movedo_grve_option( 'page_anchor_menu_height' ) . "px;
}

";

// Post Anchor Size
$css .= "

#grve-post-anchor {
	height: " . intval( movedo_grve_option( 'post_anchor_menu_height', 120 ) + 2 ) . "px;
}

#grve-post-anchor .grve-anchor-wrapper {
	line-height: " . movedo_grve_option( 'post_anchor_menu_height' ) . "px;
}

";

// Portfolio Anchor Size
$css .= "

#grve-portfolio-anchor {
	height: " . intval( movedo_grve_option( 'portfolio_anchor_menu_height', 120 ) + 2 ) . "px;
}

#grve-portfolio-anchor .grve-anchor-wrapper {
	line-height: " . movedo_grve_option( 'portfolio_anchor_menu_height' ) . "px;
}

";

/* Breadcrumbs
============================================================================= */
$css .= "
.grve-breadcrumbs {
	background-color: " . movedo_grve_option( 'page_breadcrumbs_background_color' ) . ";
	border-color: " . movedo_grve_option( 'page_breadcrumbs_border_color' ) . ";
}

.grve-breadcrumbs ul li {
	color: " . movedo_grve_option( 'page_breadcrumbs_divider_color' ) . ";
}

.grve-breadcrumbs ul li a {
	color: " . movedo_grve_option( 'page_breadcrumbs_text_color' ) . ";
}

.grve-breadcrumbs ul li a:hover {
	color: " . movedo_grve_option( 'page_breadcrumbs_text_hover_color' ) . ";
}

";

// Page Breadcrumbs Size
$css .= "

#grve-page-breadcrumbs {
	line-height: " . movedo_grve_option( 'page_breadcrumbs_height' ) . "px;
}

";

// Post Breadcrumbs Size
$css .= "

#grve-post-breadcrumbs {
	line-height: " . movedo_grve_option( 'post_breadcrumbs_height' ) . "px;
}

";

// Portfolio Breadcrumbs Size
$css .= "

#grve-portfolio-breadcrumbs {
	line-height: " . movedo_grve_option( 'portfolio_breadcrumbs_height' ) . "px;
}

";

// Product Breadcrumbs Size
$css .= "

#grve-product-breadcrumbs {
	line-height: " . movedo_grve_option( 'product_breadcrumbs_height' ) . "px;
}

";

/* Main Content
============================================================================= */
$css .= "

#grve-content,
.grve-single-wrapper,
#grve-main-content .grve-section,
.grve-anchor-menu,
#grve-safebutton-area,
#grve-bottom-bar {
	background-color: " . movedo_grve_option( 'main_content_background_color' ) . ";
	color: " . movedo_grve_option( 'body_text_color' ) . ";
}

body,
.grve-text-content,
.grve-text-content a,
#grve-content form,
#grve-content form p,
#grve-content form div,
#grve-content form span:not(.grve-heading-color),
table,
h3#reply-title,
.grve-blog.grve-with-shadow .grve-blog-item:not(.grve-style-2) .grve-post-meta,
.grve-blog.grve-with-shadow .grve-blog-item:not(.grve-style-2) p {
	color: " . movedo_grve_option( 'body_text_color' ) . ";
}

";

	/* - Main Content Borders
	========================================================================= */
	$css .= "
	#grve-theme-wrapper .grve-border,
	a.grve-border,
	#grve-content table,
	#grve-content tr,
	#grve-content td,
	#grve-content th,
	#grve-theme-wrapper form,
	#grve-theme-wrapper form p,
	#grve-theme-wrapper .wpcf7-form-control-wrap,
	#grve-theme-wrapper .wpcf7-list-item,
	#grve-theme-wrapper label,
	#grve-content form div,
	hr,
	.grve-hr.grve-element div,
	.grve-title-double-line span:before,
	.grve-title-double-line span:after,
	.grve-title-double-bottom-line span:after,
	.vc_tta.vc_general .vc_tta-panel-title,
	#grve-single-post-tags .grve-tags li a,
	#grve-single-post-categories .grve-categories li a {
		border-color: " . movedo_grve_option( 'body_border_color' ) . ";
	}

	#grve-single-post-categories .grve-categories li a {
		background-color: " . movedo_grve_option( 'body_border_color' ) . ";
	}

	";

	/* Primary Border */
	$css .= "
	.grve-border-primary-1,
	#grve-content .grve-blog-large .grve-blog-item.sticky ul.grve-post-meta,
	.grve-carousel-pagination-2 .grve-carousel .owl-controls .owl-page.active span,
	.grve-carousel-pagination-2 .grve-carousel .owl-controls.clickable .owl-page:hover span,
	.grve-carousel-pagination-2.grve-testimonial .owl-controls .owl-page.active span,
	.grve-carousel-pagination-2.grve-testimonial .owl-controls.clickable .owl-page:hover span,
	.grve-carousel-pagination-2 .grve-flexible-carousel .owl-controls .owl-page.active span,
	.grve-carousel-pagination-2 .grve-flexible-carousel .owl-controls.clickable .owl-page:hover span,
	#grve-content .grve-read-more:after,
	#grve-content .more-link:after,
	.grve-blog-large .grve-blog-item.sticky .grve-blog-item-inner:after {
		border-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	}
	";

	/* - Widget Colors
	========================================================================= */
	$css .= "
	#grve-content .widget .grve-widget-title {
		color: " . movedo_grve_option( 'widget_title_color' ) . ";
	}

	.widget {
		color: " . movedo_grve_option( 'body_text_color' ) . ";
	}

	.widget,
	.widget ul,
	.widget li,
	.widget div {
		border-color: " . movedo_grve_option( 'body_border_color' ) . ";
	}

	.grve-widget.grve-social li a.grve-outline:hover {
		border-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	}

	.widget a:not(.grve-outline):not(.grve-btn) {
		color: " . movedo_grve_option( 'body_text_color' ) . ";
	}

	.widget:not(.grve-social) a:not(.grve-outline):not(.grve-btn):hover,
	.widget.widget_nav_menu li.open > a {
		color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	}
	";

/* Bottom Bar Colors
============================================================================= */


/* Post Navigation Bar
============================================================================= */

if ( 'layout-1' == movedo_grve_option( 'post_nav_bar_layout', 'layout-1' ) ) {
	$css .= "
	#grve-post-bar .grve-post-bar-item:not(.grve-post-navigation),
	#grve-post-bar .grve-post-bar-item .grve-nav-item {
		padding-top: " . movedo_grve_option( 'post_nav_spacing', '', 'padding-top' ) . ";
		padding-bottom: " . movedo_grve_option( 'post_nav_spacing', '', 'padding-bottom'  ) . ";
	}
	";
}

$css .= "
#grve-post-bar,
#grve-post-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon,
#grve-post-bar.grve-layout-3 .grve-post-bar-item {
	background-color: " . movedo_grve_option( 'post_bar_background_color' ) . ";
	border-color: " . movedo_grve_option( 'post_bar_border_color' ) . ";
}

#grve-post-bar .grve-post-bar-item,
#grve-post-bar.grve-layout-1 .grve-post-bar-item .grve-nav-item,
#grve-post-bar.grve-layout-2:not(.grve-nav-columns-1) .grve-post-bar-item .grve-next,
#grve-post-bar.grve-layout-2.grve-nav-columns-1 .grve-post-bar-item .grve-prev + .grve-next  {
	border-color: " . movedo_grve_option( 'post_bar_border_color' ) . ";
}

#grve-post-bar .grve-nav-item .grve-title {
	color: " . movedo_grve_option( 'post_bar_nav_title_color' ) . ";
}

#grve-post-bar .grve-bar-socials li {
	border-color: " . movedo_grve_option( 'post_bar_border_color' ) . ";
}

#grve-post-bar .grve-bar-socials li a:not(.active) {
	color: " . movedo_grve_option( 'post_bar_socials_color' ) . ";
}

#grve-post-bar .grve-bar-socials li a:hover {
	color: " . movedo_grve_option( 'post_bar_socials_color_hover' ) . ";
}

#grve-post-bar .grve-arrow,
#grve-post-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon {
	color: " . movedo_grve_option( 'post_bar_arrow_color' ) . ";
}
";

/* Portfolio Navigation Bar
============================================================================= */
if ( 'layout-1' == movedo_grve_option( 'portfolio_nav_bar_layout', 'layout-1' ) ) {
	$css .= "
	#grve-portfolio-bar .grve-post-bar-item:not(.grve-post-navigation),
	#grve-portfolio-bar .grve-post-bar-item .grve-nav-item {
		padding-top: " . movedo_grve_option( 'portfolio_nav_spacing', '', 'padding-top' ) . ";
		padding-bottom: " . movedo_grve_option( 'portfolio_nav_spacing', '', 'padding-bottom'  ) . ";
	}
	";
}

$css .= "
#grve-portfolio-bar,
#grve-portfolio-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon,
#grve-portfolio-bar.grve-layout-3 .grve-post-bar-item {
	background-color: " . movedo_grve_option( 'portfolio_bar_background_color' ) . ";
	border-color: " . movedo_grve_option( 'portfolio_bar_border_color' ) . ";
}

#grve-portfolio-bar .grve-post-bar-item,
#grve-portfolio-bar.grve-layout-1 .grve-post-bar-item .grve-nav-item,
#grve-portfolio-bar.grve-layout-2:not(.grve-nav-columns-1) .grve-post-bar-item .grve-next,
#grve-portfolio-bar.grve-layout-2.grve-nav-columns-1 .grve-post-bar-item .grve-prev + .grve-next  {
	border-color: " . movedo_grve_option( 'portfolio_bar_border_color' ) . ";
}

#grve-portfolio-bar .grve-nav-item .grve-title {
	color: " . movedo_grve_option( 'portfolio_bar_nav_title_color' ) . ";
}

#grve-portfolio-bar .grve-bar-socials li {
	border-color: " . movedo_grve_option( 'portfolio_bar_border_color' ) . ";
}

#grve-portfolio-bar .grve-bar-socials li a:not(.active) {
	color: " . movedo_grve_option( 'portfolio_bar_socials_color' ) . ";
}

#grve-portfolio-bar .grve-bar-socials li a:hover {
	color: " . movedo_grve_option( 'portfolio_bar_socials_color_hover' ) . ";
}

#grve-portfolio-bar .grve-arrow,
#grve-portfolio-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon {
	color: " . movedo_grve_option( 'portfolio_bar_arrow_color' ) . ";
}
";

/* Footer
============================================================================= */

	/* - Widget Area
	========================================================================= */
	$css .= "
	#grve-footer .grve-widget-area {
		background-color: " . movedo_grve_option( 'footer_widgets_bg_color' ) . ";
	}
	";
	/* - Footer Widget Colors
	========================================================================= */
	$css .= "
	#grve-footer .grve-widget-area .widget .grve-widget-title,
	#grve-footer .grve-widget-area h1,
	#grve-footer .grve-widget-area h2,
	#grve-footer .grve-widget-area h3,
	#grve-footer .grve-widget-area h4,
	#grve-footer .grve-widget-area h5,
	#grve-footer .grve-widget-area h6 {
		color: " . movedo_grve_option( 'footer_widgets_headings_color' ) . ";
	}

	#grve-footer .grve-widget-area .widget,
	#grve-footer .grve-widget-area form,
	#grve-footer .grve-widget-area form p,
	#grve-footer .grve-widget-area form div,
	#grve-footer .grve-widget-area form span {
		color: " . movedo_grve_option( 'footer_widgets_font_color' ) . ";
	}

	#grve-footer .grve-widget-area,
	#grve-footer .grve-widget-area .grve-container,
	#grve-footer .grve-widget-area .widget,
	#grve-footer .grve-widget-area .widget a:not(.grve-outline):not(.grve-btn),
	#grve-footer .grve-widget-area .widget ul,
	#grve-footer .grve-widget-area .widget li,
	#grve-footer .grve-widget-area .widget div,
	#grve-footer .grve-widget-area table,
	#grve-footer .grve-widget-area tr,
	#grve-footer .grve-widget-area td,
	#grve-footer .grve-widget-area th,
	#grve-footer .grve-widget-area form,
	#grve-footer .grve-widget-area .wpcf7-form-control-wrap,
	#grve-footer .grve-widget-area label,
	#grve-footer .grve-widget-area .grve-border,
	#grve-footer .grve-widget-area form,
	#grve-footer .grve-widget-area form p,
	#grve-footer .grve-widget-area form div,
	#grve-footer .grve-widget-area form span,
	#grve-footer .grve-widget-area .grve-widget-area {
		border-color: " . movedo_grve_option( 'footer_widgets_border_color' ) . ";
	}

	#grve-footer .grve-widget-area .widget a:not(.grve-outline):not(.grve-btn) {
		color: " . movedo_grve_option( 'footer_widgets_link_color' ) . ";
	}

	#grve-footer .grve-widget-area .widget:not(.widget_tag_cloud) a:not(.grve-outline):not(.grve-btn):hover,
	#grve-footer .grve-widget-area .widget.widget_nav_menu li.open > a {
		color: " . movedo_grve_option( 'footer_widgets_hover_color' ) . ";
	}

	";
	/* - Footer Bar Colors
	========================================================================= */
	$movedo_grve_footer_bar_background_color = movedo_grve_option( 'footer_bar_bg_color', '#000000' );
	$css .= "
	#grve-footer .grve-footer-bar {
		color: " . movedo_grve_option( 'footer_bar_font_color' ) . ";
		background-color: rgba(" . movedo_grve_hex2rgb( $movedo_grve_footer_bar_background_color ) . "," . movedo_grve_option( 'footer_bar_bg_color_opacity', '1') . ");
	}

	#grve-footer .grve-footer-bar a {
		color: " . movedo_grve_option( 'footer_bar_link_color' ) . ";
	}

	#grve-footer .grve-footer-bar a:hover {
		color: " . movedo_grve_option( 'footer_bar_hover_color' ) . ";
	}
	";

	/* - Back To Top Colors
	========================================================================= */
	$css .= "
	.grve-back-top .grve-wrapper-color {
		background-color: " . movedo_grve_option( 'back_to_top_shape_color' ) . ";
	}

	.grve-back-top .grve-back-top-icon {
		color: " . movedo_grve_option( 'back_to_top_icon_color' ) . ";
	}
	";

/* Tag Cloud
============================================================================= */
if ( '1' != movedo_grve_option( 'wp_tagcloud', '0' ) ) {
	$css .= "
	.widget.widget_tag_cloud a {
		display: inline-block;
		margin-bottom: 4px;
		margin-right: 4px;
		font-size: 12px !important;
		border: 2px solid;
		border-color: inherit;
		-webkit-border-radius: 50px;
		border-radius: 50px;
		line-height: 30px;
		padding: 0 15px;
		color: inherit;
		-webkit-transition : all .3s;
		-moz-transition    : all .3s;
		-ms-transition     : all .3s;
		-o-transition      : all .3s;
		transition         : all .3s;
	}

	#grve-theme-wrapper .widget.widget_tag_cloud a {
		border-color: " . movedo_grve_option( 'body_border_color' ) . ";
	}

	#grve-theme-wrapper .widget.widget_tag_cloud a:hover,
	#grve-theme-wrapper #grve-sidearea .widget.widget_tag_cloud a:hover {
		background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		border-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		color: #ffffff;
	}

	#grve-theme-wrapper #grve-sidearea .widget.widget_tag_cloud a {
		border-color: " . movedo_grve_option( 'sliding_area_border_color' ) . ";
	}

	#grve-footer .grve-widget-area .widget.widget_tag_cloud a:hover {
		background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		border-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
		color: #ffffff;
	}
	";
} else {
	$css .= "
	.widget.widget_tag_cloud a {
		display: inline-block;
		vertical-align: middle;
		margin-bottom: 4px;
		margin-right: 8px;
		line-height: 1.4;
		-webkit-transition : all .3s;
		-moz-transition    : all .3s;
		-ms-transition     : all .3s;
		-o-transition      : all .3s;
		transition         : all .3s;
	}

	#grve-footer .grve-widget-area .widget.widget_tag_cloud a:hover {
		color: " . movedo_grve_option( 'footer_widgets_hover_color' ) . ";
	}
	";
}

/* Composer Front End Fix*/
$css .= "

.compose-mode .vc_element .grve-row {
    margin-top: 30px;
}

.compose-mode .vc_vc_column .wpb_column {
    width: 100% !important;
    margin-bottom: 30px;
    border: 1px dashed rgba(125, 125, 125, 0.4);
}

.compose-mode .vc_controls > .vc_controls-out-tl {
    left: 15px;
}

.compose-mode .vc_controls > .vc_controls-bc {
    bottom: 15px;
}

.compose-mode .vc_welcome .vc_buttons {
    margin-top: 60px;
}

.compose-mode .grve-image img {
    opacity: 1;
}

.compose-mode .vc_controls > div {
    z-index: 9;
}
.compose-mode .grve-bg-image {
    opacity: 1;
}

.compose-mode #grve-theme-wrapper .grve-section.grve-fullwidth-background,
.compose-mode #grve-theme-wrapper .grve-section.grve-fullwidth-element {
	visibility: visible;
}

.compose-mode .grve-animated-item {
	opacity: 1;
}

.compose-mode .grve-clipping-animation,
.compose-mode .grve-clipping-animation.grve-colored-clipping .grve-clipping-content {
	visibility: visible;
	opacity: 1;
}

.compose-mode .grve-section.grve-custom-height {
	visibility: visible;
}

";

$movedo_grve_gap_size = array (
	array(
		'gap' => '5',
	),
	array(
		'gap' => '10',
	),
	array(
		'gap' => '15',
	),
	array(
		'gap' => '20',
	),
	array(
		'gap' => '25',
	),
	array(
		'gap' => '30',
	),
	array(
		'gap' => '35',
	),
	array(
		'gap' => '40',
	),
	array(
		'gap' => '45',
	),
	array(
		'gap' => '50',
	),
	array(
		'gap' => '55',
	),
	array(
		'gap' => '60',
	),
);

function movedo_grve_print_gap_size( $movedo_grve_gap_size = array()) {

	$css = '';

	foreach ( $movedo_grve_gap_size as $size ) {

		$movedo_grve_gap_size = $size['gap'];
		$movedo_grve_gap_half_size = $size['gap'] * 0.5;

		$css .= "

			.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " {
				margin-left: -" . esc_attr( $movedo_grve_gap_half_size ) . "px;
				margin-right: -" . esc_attr( $movedo_grve_gap_half_size ) . "px;
			}
			.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-column {
				padding-left: " . esc_attr( $movedo_grve_gap_half_size ) . "px;
				padding-right: " . esc_attr( $movedo_grve_gap_half_size ) . "px;
			}

			@media only screen and (max-width: 767px) {
				.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-column .grve-column-wrapper {
					margin-bottom: 30px;
				}

				.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-column:last-child .grve-column-wrapper {
					margin-bottom: 0px;
				}
			}

			.grve-section.grve-fullwidth .grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " {
				padding-left: " . esc_attr( $movedo_grve_gap_half_size ) . "px;
				padding-right: " . esc_attr( $movedo_grve_gap_half_size ) . "px;
			}

			.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-row-inner {
				margin-left: -" . esc_attr( $movedo_grve_gap_half_size ) . "px;
				margin-right: -" . esc_attr( $movedo_grve_gap_half_size ) . "px;
			}

			@media only screen and (max-width: 767px) {
				.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-row-inner {
					margin-bottom: " . esc_attr( $movedo_grve_gap_size ) . "px;
				}

				.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-row-inner:last-child {
					margin-bottom: 0px;
				}
			}

			.grve-row.grve-columns-gap-" . esc_attr( $size['gap'] ) . " .grve-column-inner {
				padding-left: " . esc_attr( $movedo_grve_gap_half_size ) . "px;
				padding-right: " . esc_attr( $movedo_grve_gap_half_size ) . "px;
			}

		";

	}

	return $css;
}

$css .= movedo_grve_print_gap_size( $movedo_grve_gap_size );

$movedo_grve_space_size = array (
	array(
		'id' => '1x',
		'percentage' => 1,
	),
	array(
		'id' => '2x',
		'percentage' => 2,
	),
	array(
		'id' => '3x',
		'percentage' => 3,
	),
	array(
		'id' => '4x',
		'percentage' => 4,
	),
	array(
		'id' => '5x',
		'percentage' => 5,
	),
	array(
		'id' => '6x',
		'percentage' => 6,
	),
);

function movedo_grve_print_space_size( $movedo_grve_space_size = array() , $ratio = 1) {
	$default_space_size = 30;
	$min_space_size = 18;
	$css = '';

	foreach ( $movedo_grve_space_size as $size ) {

		$movedo_grve_space_size = ( $default_space_size * $size['percentage'] ) * $ratio;
		if ( $movedo_grve_space_size < $default_space_size ) {
			$movedo_grve_space_size = $min_space_size;
		}
		$css .= "
			#grve-theme-wrapper .grve-padding-top-" . esc_attr( $size['id'] ) . "{ padding-top: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-padding-bottom-" . esc_attr( $size['id'] ) . "{ padding-bottom: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-margin-top-" . esc_attr( $size['id'] ) . "{ margin-top: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-margin-bottom-" . esc_attr( $size['id'] ) . "{ margin-bottom: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-height-" . esc_attr( $size['id'] ) . "{ height: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-top-" . esc_attr( $size['id'] ) . "{ top: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-left-" . esc_attr( $size['id'] ) . "{ left: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-right-" . esc_attr( $size['id'] ) . "{ right: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-bottom-" . esc_attr( $size['id'] ) . "{ bottom: " . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-top-minus-" . esc_attr( $size['id'] ) . "{ top: -" . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-left-minus-" . esc_attr( $size['id'] ) . "{ left: -" . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-right-minus-" . esc_attr( $size['id'] ) . "{ right: -" . esc_attr( $movedo_grve_space_size ) . "px; }
			#grve-theme-wrapper .grve-bottom-minus-" . esc_attr( $size['id'] ) . "{ bottom: -" . esc_attr( $movedo_grve_space_size ) . "px; }

			#grve-theme-wrapper .grve-padding-none { padding: 0px !important; }
			#grve-theme-wrapper .grve-margin-none { margin: 0px !important; }
		";

	}

	$css .= "
	#grve-main-content .grve-main-content-wrapper,
	#grve-sidebar {
		padding-top: " . $default_space_size * 3  * $ratio . "px;
		padding-bottom: " . $default_space_size * 3  * $ratio . "px;
	}

	#grve-single-media.grve-portfolio-media.grve-without-sidebar {
		padding-top: " . $default_space_size * 3  * $ratio . "px;
	}
	#grve-single-media.grve-portfolio-media.grve-with-sidebar {
		padding-bottom: " . $default_space_size * 3  * $ratio . "px;
	}

	";

	return $css;
}

$css .= movedo_grve_print_space_size( $movedo_grve_space_size, 1 );

$css .= "
	@media only screen and (max-width: 1200px) {
		" . movedo_grve_print_space_size( $movedo_grve_space_size, 0.8 ). "
	}
	@media only screen and (max-width: 768px) {
		" . movedo_grve_print_space_size( $movedo_grve_space_size, 0.6 ). "
	}
";

if ( is_singular() ) {

	$movedo_grve_padding_top = movedo_grve_post_meta( '_movedo_grve_padding_top' );
	$movedo_grve_padding_bottom = movedo_grve_post_meta( '_movedo_grve_padding_bottom' );
	if( '' != $movedo_grve_padding_top || '' != $movedo_grve_padding_bottom ) {
		$css .= "#grve-main-content .grve-main-content-wrapper, #grve-sidebar {";
		if( '' != $movedo_grve_padding_top ) {
			$css .= 'padding-top: '. ( preg_match('/(px|em|\%|pt|cm)$/', $movedo_grve_padding_top) ? esc_attr( $movedo_grve_padding_top ) : esc_attr( $movedo_grve_padding_top ) . 'px').';';
		}
		if( '' != $movedo_grve_padding_bottom  ) {
			$css .= 'padding-bottom: '.( preg_match('/(px|em|\%|pt|cm)$/', $movedo_grve_padding_bottom) ? esc_attr( $movedo_grve_padding_bottom ) : esc_attr(  $movedo_grve_padding_bottom ) .'px').';';
		}
		$css .= "}";

		$css .= "#grve-single-media.grve-portfolio-media.grve-without-sidebar {";
		if( '' != $movedo_grve_padding_top ) {
			$css .= 'padding-top: '. ( preg_match('/(px|em|\%|pt|cm)$/', $movedo_grve_padding_top) ? esc_attr( $movedo_grve_padding_top ) : esc_attr( $movedo_grve_padding_top ) . 'px').';';
		}
		$css .= "}";

		$css .= "#grve-single-media.grve-portfolio-media.grve-with-sidebar {";
		if( '' != $movedo_grve_padding_top ) {
			$css .= 'padding-bottom: '. ( preg_match('/(px|em|\%|pt|cm)$/', $movedo_grve_padding_top) ? esc_attr( $movedo_grve_padding_top ) : esc_attr( $movedo_grve_padding_top ) . 'px').';';
		}
		$css .= "}";
	}

}
if ( is_singular( 'portfolio' ) ) {
	$movedo_grve_media_margin_bottom = movedo_grve_post_meta( '_movedo_grve_portfolio_media_margin_bottom' );
	if( '' != $movedo_grve_media_margin_bottom ) {
		$css .= "#grve-single-media.grve-portfolio-media {";
		$css .= 'margin-bottom: '. ( preg_match('/(px|em|\%|pt|cm)$/', $movedo_grve_media_margin_bottom) ? esc_attr( $movedo_grve_media_margin_bottom ) : esc_attr( $movedo_grve_media_margin_bottom ) . 'px').';';
		$css .= "}";
	}
}

wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $css ) );

//Omit closing PHP tag to avoid accidental whitespace output errors.
