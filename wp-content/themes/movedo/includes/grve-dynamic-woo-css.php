<?php
/**
 *  Dynamic css style for WooCommerce
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */

$css = "";


/* Container Size
============================================================================= */
$css .= "

.grve-woo-error,
.grve-woo-info,
.grve-woo-message,
.grve-woo-tabs #tab-reviews.panel,
.grve-woo-tabs #tab-additional_information.panel {
	max-width: " . movedo_grve_option( 'container_size', 1170 ) . "px;
}

";

/* Default Header Shopping Cart
============================================================================= */
$grve_header_mode = movedo_grve_option( 'header_mode', 'default' );
if ( 'default' == $grve_header_mode ) {

	$css .= "
	#grve-header .grve-shoppin-cart-content {
		background-color: " . movedo_grve_option( 'default_header_submenu_bg_color' ) . ";
	}

	#grve-header .grve-shoppin-cart-content ul li,
	#grve-header .grve-shoppin-cart-content ul li a,
	#grve-header .grve-shoppin-cart-content .total {
		color: " . movedo_grve_option( 'default_header_submenu_text_color' ) . ";
	}

	#grve-header .grve-shoppin-cart-content ul li a:hover {
		color: " . movedo_grve_option( 'default_header_submenu_text_hover_color' ) . ";
	}

	#grve-header .grve-shoppin-cart-content ul li {
		border-color: " . movedo_grve_option( 'default_header_submenu_border_color' ) . ";
	}

	";

/* Logo On Top Header Shopping Cart
============================================================================= */
} else if ( 'logo-top' == $grve_header_mode ) {

	$css .= "
	#grve-header .grve-shoppin-cart-content {
		background-color: " . movedo_grve_option( 'logo_top_header_submenu_bg_color' ) . ";
	}

	#grve-header .grve-shoppin-cart-content ul li,
	#grve-header .grve-shoppin-cart-content ul li a,
	#grve-header .grve-shoppin-cart-content .total {
		color: " . movedo_grve_option( 'logo_top_header_submenu_text_color' ) . ";
	}

	#grve-header .grve-shoppin-cart-content ul li a:hover {
		color: " . movedo_grve_option( 'logo_top_header_submenu_text_bg_hover_color' ) . ";
	}

	#grve-header .grve-shoppin-cart-content ul li {
		border-color: " . movedo_grve_option( 'logo_top_header_submenu_border_color' ) . ";
	}

	";

}


/* Cart Area Colors
============================================================================= */
$grve_sliding_area_overflow_background_color = movedo_grve_option( 'sliding_area_overflow_background_color', '#000000' );
$css .= "
#grve-cart-area {
	background-color: " . movedo_grve_option( 'sliding_area_background_color' ) . ";
	color: " . movedo_grve_option( 'sliding_area_text_color' ) . ";
}

.grve-cart-total {
	color: " . movedo_grve_option( 'sliding_area_title_color' ) . ";
}

#grve-cart-area .cart-item-content a,
#grve-cart-area .grve-empty-cart .grve-h6 {
	color: " . movedo_grve_option( 'sliding_area_title_color' ) . ";
}

#grve-cart-area .grve-empty-cart a {
	color: " . movedo_grve_option( 'sliding_area_link_color' ) . ";
}

#grve-cart-area .cart-item-content a:hover,
#grve-cart-area .grve-empty-cart a:hover {
	color: " . movedo_grve_option( 'sliding_area_link_hover_color' ) . ";
}

#grve-cart-area .grve-close-btn:after,
#grve-cart-area .grve-close-btn:before,
#grve-cart-area .grve-close-btn span {
	background-color: " . movedo_grve_option( 'sliding_area_close_btn_color' ) . ";
}

#grve-cart-area .grve-border {
	border-color: " . movedo_grve_option( 'sliding_area_border_color' ) . ";
}

#grve-cart-area-overlay {
	background-color: rgba(" . movedo_grve_hex2rgb( $grve_sliding_area_overflow_background_color ) . "," . movedo_grve_option( 'sliding_area_overflow_background_color_opacity', '0.9') . ");
}

";


/* Primary Background */
$css .= "

.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {
	background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	color: #ffffff;
}

.grve-widget.woocommerce.widget_product_tag_cloud a:hover {
	background-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	border-color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
	color: #ffffff !important;
}

";


/* Primary Color */
$css .= "

.woocommerce nav.woocommerce-pagination ul li span.current,
nav.woocommerce-pagination ul li a:hover,
.woocommerce-MyAccount-navigation ul li a:hover,
.woocommerce .widget_layered_nav ul li.chosen a:before,
.woocommerce .widget_layered_nav_filters ul li a:before {
	color: " . movedo_grve_option( 'body_primary_1_color' ) . "!important;
}

";


/* Content Color
============================================================================= */
$css .= "

nav.woocommerce-pagination ul li a {
	color: " . movedo_grve_option( 'body_text_color' ) . ";
}

";


/* Headers Color
============================================================================= */
$css .= "

.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta,
.grve-product-item .grve-add-to-cart-btn a.add_to_cart_button:before,
.woocommerce form .form-row label {
	color: " . movedo_grve_option( 'body_heading_color' ) . ";
}

";

// Product Anchor Size
$css .= "

#grve-product-anchor {
	height: " . intval( movedo_grve_option( 'product_anchor_menu_height', 120 ) + 2 ) . "px;
}

#grve-product-anchor .grve-anchor-wrapper {
	line-height: " . movedo_grve_option( 'product_anchor_menu_height' ) . "px;
}

";


/* Borders
============================================================================= */
$css .= "

.woocommerce-tabs,
.woocommerce #reviews #review_form_wrapper,
.woocommerce-page #reviews #review_form_wrapper,
.woocommerce-MyAccount-navigation ul li,
#grve-theme-wrapper .widget.woocommerce li,
#grve-theme-wrapper .woocommerce table,
#grve-theme-wrapper .woocommerce table tr,
#grve-theme-wrapper .woocommerce table th,
#grve-theme-wrapper .woocommerce table td,
.woocommerce table.shop_attributes,
.woocommerce table.shop_attributes tr,
.woocommerce table.shop_attributes th,
.woocommerce table.shop_attributes td {
	border-color: " . movedo_grve_option( 'body_border_color' ) . ";
}

";

/* H6 */
$css .= "

.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta {
	font-family: " . movedo_grve_option( 'h6_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h6_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h6_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'h6_font', '56px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'h6_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'h6_font', '60px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h6_font', '0px', 'letter-spacing'  ) . "
}

";


/* Special Text */
$css .= "



";


/* Small Text */
$css .= "

.woocommerce span.onsale,
.widget.woocommerce .chosen,
.widget.woocommerce .price_label  {
	font-family: " . movedo_grve_option( 'small_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'small_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'small_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'small_text', '34px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'small_text', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'small_text', '0px', 'letter-spacing'  ) . "
}


";

/* Link Text */
$css .= "

.woocommerce-pagination,
.woocommerce form .grve-billing-content .form-row label,
.grve-woo-error a.button,
.grve-woo-info a.button,
.grve-woo-message a.button,
.woocommerce-review-link,
.woocommerce #grve-theme-wrapper #respond input#submit,
.woocommerce #grve-theme-wrapper a.button,
.woocommerce #grve-theme-wrapper button.button,
.woocommerce #grve-theme-wrapper input.button,
.grve-add-cart-wrapper a,
.woocommerce-MyAccount-content a.button,
.woocommerce .woocommerce-error a.button,
.woocommerce .woocommerce-info a.button,
.woocommerce .woocommerce-message a.button {
	font-family: " . movedo_grve_option( 'link_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'link_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'link_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'link_text', '13px', 'font-size'  ) . " !important;
	text-transform: " . movedo_grve_option( 'link_text', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'link_text', '0px', 'letter-spacing'  ) . "
}

";


/* Product Area Colors
============================================================================= */

function movedo_grve_print_product_area_css() {

$css = '';

	$movedo_grve_colors = movedo_grve_get_color_array();

	$mode = 'product';
	$movedo_grve_area_colors = array(
		'bg_color' => movedo_grve_option( $mode . '_area_bg_color', '#eeeeee' ),
		'headings_color' => movedo_grve_option( $mode . '_area_headings_color', '#000000' ),
		'font_color' => movedo_grve_option( $mode . '_area_font_color', '#999999' ),
		'link_color' => movedo_grve_option( $mode . '_area_link_color', '#FF7D88' ),
		'hover_color' => movedo_grve_option( $mode . '_area_hover_color', '#000000' ),
		'border_color' => movedo_grve_option( $mode . '_area_border_color', '#e0e0e0' ),
		'button_color' => movedo_grve_option( $mode . '_area_button_color', 'primary-1' ),
		'button_hover_color' => movedo_grve_option( $mode . '_area_button_hover_color', 'black' ),
	);

	$movedo_grve_single_area_colors = movedo_grve_post_meta( '_movedo_grve_area_colors' );
	$movedo_grve_single_area_colors_custom = movedo_grve_array_value( $movedo_grve_single_area_colors, 'custom' );

	if ( 'custom' == $movedo_grve_single_area_colors_custom ) {
		$movedo_grve_area_colors = $movedo_grve_single_area_colors;
	}


$css .= "

.grve-product-area-wrapper {
	background-color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'bg_color' ) . ";
	color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'font_color' ) . ";
	border-color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'border_color' ) . ";
}

#grve-theme-wrapper .grve-product-area-wrapper .grve-border,
#grve-theme-wrapper .grve-product-area-wrapper form,
#grve-theme-wrapper .grve-product-area-wrapper .quantity,
.grve-product-area-wrapper .grve-product-form,
#grve-entry-summary,
#grve-theme-wrapper .summary input,
#grve-theme-wrapper .summary select {
	border-color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'border_color' ) . ";
}

.grve-product-area-wrapper a {
	color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'link_color' ) . ";
}

.grve-product-area-wrapper a:hover {
	color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'hover_color' ) . ";
}

.grve-product-area-wrapper h1,
.grve-product-area-wrapper h2,
.grve-product-area-wrapper h3,
.grve-product-area-wrapper h4,
.grve-product-area-wrapper h5,
.grve-product-area-wrapper h6,
.grve-product-area-wrapper .grve-h1,
.grve-product-area-wrapper .grve-h2,
.grve-product-area-wrapper .grve-h3,
.grve-product-area-wrapper .grve-h4,
.grve-product-area-wrapper .grve-h5,
.grve-product-area-wrapper .grve-h6,
.grve-product-area-wrapper .grve-heading-color {
    color: " . movedo_grve_array_value( $movedo_grve_area_colors, 'headings_color' ) . ";
}

";

$default_button_color = movedo_grve_option( 'body_primary_1_color' );
$area_button_color = movedo_grve_array_value( $movedo_grve_area_colors, 'button_color' );
$button_color = movedo_grve_array_value( $movedo_grve_colors, $area_button_color, $default_button_color);
$area_button_hover_color = movedo_grve_array_value( $movedo_grve_area_colors, 'button_hover_color' );
$button_hover_color = movedo_grve_array_value( $movedo_grve_colors, $area_button_hover_color, '#000000');

$movedo_button_css = "";
$movedo_button_css .= "#grve-theme-wrapper .grve-product-area-wrapper #grve-entry-summary button.single_add_to_cart_button {";
$movedo_button_css .= "background-color: " . esc_attr( $button_color ) . ";";
$movedo_button_css .= "border: none;";
if ( 'white' == $area_button_color ) {
	$movedo_button_css .= "color: #bababa;";
} else {
	$movedo_button_css .= "color: #ffffff;";
}
$movedo_button_css .= "}";

$movedo_button_css .= "#grve-theme-wrapper .grve-product-area-wrapper #grve-entry-summary button.single_add_to_cart_button:hover {";
$movedo_button_css .= "background-color: " . esc_attr( $button_hover_color ) . ";";
if ( 'white' == $area_button_hover_color ) {
	$movedo_button_css .= "color: #bababa;";
} else {
	$movedo_button_css .= "color: #ffffff;";
}
$movedo_button_css .= "}";

$css .= $movedo_button_css;

return $css;

}

if ( is_product() ) {
	$css .= movedo_grve_print_product_area_css();
}


/* Product Navigation Bar
============================================================================= */

if ( 'layout-1' == movedo_grve_option( 'product_nav_bar_layout', 'layout-1' ) ) {
	$css .= "
	#grve-product-bar .grve-post-bar-item:not(.grve-post-navigation),
	#grve-product-bar .grve-post-bar-item .grve-nav-item {
		padding-top: " . movedo_grve_option( 'product_nav_spacing', '', 'padding-top' ) . ";
		padding-bottom: " . movedo_grve_option( 'product_nav_spacing', '', 'padding-bottom'  ) . ";
	}
	";
}

$css .= "
#grve-product-bar,
#grve-product-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon,
#grve-product-bar.grve-layout-3 .grve-post-bar-item {
	background-color: " . movedo_grve_option( 'product_bar_background_color' ) . ";
	border-color: " . movedo_grve_option( 'product_bar_border_color' ) . ";
}

#grve-product-bar .grve-post-bar-item,
#grve-product-bar.grve-layout-1 .grve-post-bar-item .grve-nav-item,
#grve-product-bar.grve-layout-2:not(.grve-nav-columns-1) .grve-post-bar-item .grve-next,
#grve-product-bar.grve-layout-2.grve-nav-columns-1 .grve-post-bar-item .grve-prev + .grve-next  {
	border-color: " . movedo_grve_option( 'product_bar_border_color' ) . ";
}

#grve-product-bar .grve-nav-item .grve-title {
	color: " . movedo_grve_option( 'product_bar_nav_title_color' ) . ";
}

#grve-product-bar .grve-bar-socials li {
	border-color: " . movedo_grve_option( 'product_bar_border_color' ) . ";
}

#grve-product-bar .grve-bar-socials li a:not(.active) {
	color: " . movedo_grve_option( 'product_bar_socials_color' ) . ";
}

#grve-product-bar .grve-bar-socials li a.active {
	color: " . movedo_grve_option( 'body_primary_1_color' ) . ";
}

#grve-product-bar .grve-bar-socials li a:hover {
	color: " . movedo_grve_option( 'product_bar_socials_color_hover' ) . ";
}

#grve-product-bar .grve-arrow,
#grve-product-bar.grve-layout-3 .grve-post-bar-item .grve-item-icon {
	color: " . movedo_grve_option( 'product_bar_arrow_color' ) . ";
}
";

/* Single Product Content Width
============================================================================= */
if ( is_singular( 'product' ) ) {
	$movedo_grve_post_content_width = movedo_grve_post_meta( '_movedo_grve_post_content_width', movedo_grve_option( 'product_content_width', 990 ) );

	if ( !is_numeric( $movedo_grve_post_content_width ) ) {
		$movedo_grve_post_content_width = movedo_grve_option( 'container_size', 1170 );
	}

$css .= "

.single-product #grve-content:not(.grve-right-sidebar):not(.grve-left-sidebar) .grve-container {
	max-width: " . esc_attr( $movedo_grve_post_content_width ) . "px;
}

";

}

wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $css ) );

//Omit closing PHP tag to avoid accidental whitespace output errors.
