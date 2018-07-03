<?php
/**
 *  Dynamic typography css style
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */

$typo_css = "";

/**
 * Typography
 * ----------------------------------------------------------------------------
 */

$typo_css .= "

body {
	font-size: " . movedo_grve_option( 'body_font', '14px', 'font-size'  ) . ";
	font-family: " . movedo_grve_option( 'body_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'body_font', 'normal', 'font-weight'  ) . ";
	line-height: " . movedo_grve_option( 'body_font', '36px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'body_font', '0px', 'letter-spacing'  ) . "
}

";

/* Logo as text */
$typo_css .= "

#grve-header .grve-logo.grve-logo-text a {
	font-family: " . movedo_grve_option( 'logo_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'logo_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'logo_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'logo_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'logo_font', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'logo_font', '0px', 'letter-spacing'  ) . "
}

";


/* Main Menu  */
$typo_css .= "

.grve-main-menu .grve-wrapper > ul > li > a,
.grve-main-menu .grve-wrapper > ul > li.megamenu > ul > li > a,
.grve-toggle-hiddenarea .grve-label,
.grve-main-menu .grve-wrapper > ul > li ul li.grve-goback a {
	font-family: " . movedo_grve_option( 'main_menu_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'main_menu_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'main_menu_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'main_menu_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'main_menu_font', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'main_menu_font', '0px', 'letter-spacing'  ) . "
}

.grve-slide-menu .grve-main-menu .grve-wrapper ul li.megamenu ul li:not(.grve-goback) > a,
.grve-main-menu .grve-wrapper > ul > li ul li a,
#grve-header .grve-shoppin-cart-content {
	font-family: " . movedo_grve_option( 'sub_menu_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'sub_menu_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'sub_menu_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'sub_menu_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'sub_menu_font', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'sub_menu_font', '0px', 'letter-spacing'  ) . "
}

.grve-main-menu .grve-menu-description {
	font-family: " . movedo_grve_option( 'description_menu_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'description_menu_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'description_menu_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'description_menu_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'description_menu_font', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'description_menu_font', '0px', 'letter-spacing'  ) . "
}

";

/* Hidden Menu  */
$typo_css .= "
#grve-hidden-menu .grve-hiddenarea-content .grve-menu > li > a,
#grve-responsive-anchor .grve-hiddenarea-content .grve-menu > li > a,
#grve-hidden-menu ul.grve-menu > li.megamenu > ul > li > a,
#grve-hidden-menu ul.grve-menu > li ul li.grve-goback a {
	font-family: " . movedo_grve_option( 'hidden_menu_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'hidden_menu_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'hidden_menu_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'hidden_menu_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'hidden_menu_font', 'uppercase', 'text-transform'  ) . ";
}


#grve-hidden-menu.grve-slide-menu ul li.megamenu ul li:not(.grve-goback) > a,
#grve-hidden-menu.grve-slide-menu ul li ul li:not(.grve-goback) > a,
#grve-hidden-menu.grve-toggle-menu ul li.megamenu ul li > a,
#grve-hidden-menu.grve-toggle-menu ul li ul li > a,
#grve-responsive-anchor ul li ul li > a {
	font-family: " . movedo_grve_option( 'sub_hidden_menu_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'sub_hidden_menu_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'sub_hidden_menu_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'sub_hidden_menu_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'sub_hidden_menu_font', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'sub_hidden_menu_font', '0px', 'letter-spacing'  ) . "
}

#grve-hidden-menu .grve-menu-description {
	font-family: " . movedo_grve_option( 'description_hidden_menu_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'description_hidden_menu_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'description_hidden_menu_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'description_hidden_menu_font', '11px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'description_hidden_menu_font', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'description_hidden_menu_font', '0px', 'letter-spacing'  ) . "
}

";

/* Headings */
$typo_css .= "

h1,
.grve-h1,
#grve-theme-wrapper .grve-modal .grve-search input[type='text'],
.grve-dropcap span,
p.grve-dropcap:first-letter {
	font-family: " . movedo_grve_option( 'h1_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h1_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h1_font', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'h1_font', ' none', 'text-transform'  ) . ";
	font-size: " . movedo_grve_option( 'h1_font', '56px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'h1_font', '60px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h1_font', '0px', 'letter-spacing'  ) . "
}

h2,
.grve-h2 {
	font-family: " . movedo_grve_option( 'h2_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h2_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h2_font', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'h2_font', ' none', 'text-transform'  ) . ";
	font-size: " . movedo_grve_option( 'h2_font', '36px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'h2_font', '40px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h2_font', '0px', 'letter-spacing'  ) . "
}

h3,
.grve-h3 {
	font-family: " . movedo_grve_option( 'h3_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h3_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h3_font', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'h3_font', ' none', 'text-transform'  ) . ";
	font-size: " . movedo_grve_option( 'h3_font', '30px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'h3_font', '33px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h3_font', '0px', 'letter-spacing'  ) . "
}

h4,
.grve-h4 {
	font-family: " . movedo_grve_option( 'h4_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h4_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h4_font', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'h4_font', ' none', 'text-transform'  ) . ";
	font-size: " . movedo_grve_option( 'h4_font', '23px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'h4_font', '26px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h4_font', '0px', 'letter-spacing'  ) . "
}

h5,
.grve-h5 {
	font-family: " . movedo_grve_option( 'h5_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h5_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h5_font', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'h5_font', ' none', 'text-transform'  ) . ";
	font-size: " . movedo_grve_option( 'h5_font', '18px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'h5_font', '20px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h5_font', '0px', 'letter-spacing'  ) . "
}

h6,
.grve-h6,
.vc_tta.vc_general .vc_tta-panel-title,
#grve-main-content .vc_tta.vc_general .vc_tta-tab > a {
	font-family: " . movedo_grve_option( 'h6_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'h6_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'h6_font', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'h6_font', ' none', 'text-transform'  ) . ";
	font-size: " . movedo_grve_option( 'h6_font', '16px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'h6_font', '18px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'h6_font', '0px', 'letter-spacing'  ) . "
}

";

/* Page Title */
$typo_css .= "

#grve-page-title .grve-title,
#grve-blog-title .grve-title,
#grve-search-page-title .grve-title {
	font-family: " . movedo_grve_option( 'page_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'page_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'page_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'page_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'page_title', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'page_title', '60px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'page_title', '0px', 'letter-spacing'  ) . "
}

#grve-page-title .grve-description,
#grve-blog-title .grve-description,
#grve-blog-title .grve-description p,
#grve-search-page-title .grve-description {
	font-family: " . movedo_grve_option( 'page_description', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'page_description', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'page_description', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'page_description', '24px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'page_description', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'page_description', '60px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'page_description', '0px', 'letter-spacing'  ) . "
}

";


/* Post Title */
$typo_css .= "

#grve-post-title .grve-title-categories {
	font-family: " . movedo_grve_option( 'post_title_meta', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'post_title_meta', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'post_title_meta', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'post_title_meta', '16px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'post_title_meta', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'post_title_meta', '24px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'post_title_meta', '0px', 'letter-spacing'  ) . "
}

#grve-post-title .grve-post-meta,
#grve-post-title .grve-post-meta li {
	font-family: " . movedo_grve_option( 'post_title_extra_meta', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'post_title_extra_meta', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'post_title_extra_meta', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'post_title_extra_meta', '16px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'post_title_extra_meta', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'post_title_extra_meta', '24px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'post_title_extra_meta', '0px', 'letter-spacing'  ) . "
}

.grve-single-simple-title {
	font-family: " . movedo_grve_option( 'post_simple_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'post_simple_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'post_simple_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'post_simple_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'post_simple_title', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'post_simple_title', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'post_simple_title', '0px', 'letter-spacing'  ) . "
}

#grve-post-title .grve-title {
	font-family: " . movedo_grve_option( 'post_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'post_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'post_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'post_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'post_title', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'post_title', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'post_title', '0px', 'letter-spacing'  ) . "
}

#grve-post-title .grve-description {
	font-family: " . movedo_grve_option( 'post_title_desc', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'post_title_desc', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'post_title_desc', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'post_title_desc', '26px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'post_title_desc', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'post_title_desc', '32px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'post_title_desc', '0px', 'letter-spacing'  ) . "
}

";

/* Portfolio Title */
$typo_css .= "

#grve-portfolio-title .grve-title {
	font-family: " . movedo_grve_option( 'portfolio_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'portfolio_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'portfolio_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'portfolio_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'portfolio_title', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'portfolio_title', '72px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'portfolio_title', '0px', 'letter-spacing'  ) . "
}

#grve-portfolio-title .grve-description {
	font-family: " . movedo_grve_option( 'portfolio_description', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'portfolio_description', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'portfolio_description', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'portfolio_description', '18px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'portfolio_description', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'portfolio_description', '30px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'portfolio_description', '0px', 'letter-spacing'  ) . "
}


";

/* Forum Title */
$typo_css .= "

#grve-forum-title .grve-title {
	font-family: " . movedo_grve_option( 'forum_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'forum_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'forum_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'forum_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'forum_title', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'forum_title', '72px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'forum_title', '0px', 'letter-spacing'  ) . "
}


";

/* Product Title
============================================================================= */
$typo_css .= "

.grve-product-area .product_title {
	font-family: " . movedo_grve_option( 'product_simple_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'product_simple_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'product_simple_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'product_simple_title', '36px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'product_simple_title', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'product_simple_title', '48px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'product_simple_title', '0px', 'letter-spacing'  ) . "
}

#grve-entry-summary .grve-short-description p {
	font-family: " . movedo_grve_option( 'product_short_description', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'product_short_description', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'product_short_description', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'product_short_description', '24px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'product_short_description', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'product_short_description', '30px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'product_short_description', '0px', 'letter-spacing'  ) . "
}

#grve-product-title .grve-title,
#grve-product-tax-title .grve-title,
.woocommerce-page #grve-page-title .grve-title {
	font-family: " . movedo_grve_option( 'product_tax_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'product_tax_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'product_tax_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'product_tax_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'product_tax_title', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'product_tax_title', '72px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'product_tax_title', '0px', 'letter-spacing'  ) . "
}

#grve-product-title .grve-description,
#grve-product-tax-title .grve-description,
#grve-product-tax-title .grve-description p,
.woocommerce-page #grve-page-title .grve-description {
	font-family: " . movedo_grve_option( 'product_tax_description', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'product_tax_description', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'product_tax_description', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'product_tax_description', '24px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'product_tax_description', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'product_tax_description', '30px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'product_tax_description', '0px', 'letter-spacing'  ) . "
}

";


/* Events Title
============================================================================= */
$typo_css .= "

.grve-event-simple-title {
	font-family: " . movedo_grve_option( 'event_simple_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'event_simple_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'event_simple_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'event_simple_title', '36px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'event_simple_title', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'event_simple_title', '48px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'event_simple_title', '0px', 'letter-spacing'  ) . "
}

#grve-event-title .grve-title,
#grve-event-tax-title .grve-title {
	font-family: " . movedo_grve_option( 'event_tax_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'event_tax_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'event_tax_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'event_tax_title', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'event_tax_title', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'event_tax_title', '72px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'event_tax_title', '0px', 'letter-spacing'  ) . "
}

#grve-event-title .grve-description,
#grve-event-tax-title .grve-description,
#grve-event-tax-title .grve-description p {
	font-family: " . movedo_grve_option( 'event_tax_description', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'event_tax_description', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'event_tax_description', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'event_tax_description', '24px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'event_tax_description', 'normal', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'event_tax_description', '30px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'event_tax_description', '0px', 'letter-spacing'  ) . "
}

";

/* Feature Section Custom */
$typo_css .= "

#grve-feature-section .grve-subheading {
	font-family: " . movedo_grve_option( 'feature_subheading_custom_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'feature_subheading_custom_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'feature_subheading_custom_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'feature_subheading_custom_font', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'feature_subheading_custom_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'feature_subheading_custom_font', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'feature_subheading_custom_font', '0px', 'letter-spacing'  ) . "
}

#grve-feature-section .grve-title {
	font-family: " . movedo_grve_option( 'feature_title_custom_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'feature_title_custom_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'feature_title_custom_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'feature_title_custom_font', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'feature_title_custom_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'feature_title_custom_font', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'feature_title_custom_font', '0px', 'letter-spacing'  ) . "
}

#grve-feature-section .grve-description {
	font-family: " . movedo_grve_option( 'feature_desc_custom_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'feature_desc_custom_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'feature_desc_custom_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'feature_desc_custom_font', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'feature_desc_custom_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'feature_desc_custom_font', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'feature_desc_custom_font', '0px', 'letter-spacing'  ) . "
}


";

/* Feature Section Fullscreen */
$typo_css .= "

#grve-feature-section.grve-fullscreen .grve-subheading {
	font-family: " . movedo_grve_option( 'feature_subheading_full_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'feature_subheading_full_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'feature_subheading_full_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'feature_subheading_full_font', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'feature_subheading_full_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'feature_subheading_full_font', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'feature_subheading_full_font', '0px', 'letter-spacing'  ) . "
}

#grve-feature-section.grve-fullscreen .grve-title {
	font-family: " . movedo_grve_option( 'feature_title_full_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'feature_title_full_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'feature_title_full_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'feature_title_full_font', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'feature_title_full_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'feature_title_full_font', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'feature_title_full_font', '0px', 'letter-spacing'  ) . "
}

";

$typo_css .= "

#grve-feature-section.grve-fullscreen .grve-description {
	font-family: " . movedo_grve_option( 'feature_desc_full_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'feature_desc_full_font', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'feature_desc_full_font', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'feature_desc_full_font', '60px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'feature_desc_full_font', 'uppercase', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'feature_desc_full_font', '112px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'feature_desc_full_font', '0px', 'letter-spacing'  ) . "
}

";


/* Special Text */
$typo_css .= "

.grve-leader-text,
.grve-leader-text p,
p.grve-leader-text {
	font-family: " . movedo_grve_option( 'leader_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'leader_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'leader_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'leader_text', '34px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'leader_text', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'leader_text', '36px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'leader_text', '0px', 'letter-spacing'  ) . "
}

.grve-subtitle,
.grve-subtitle p,
.grve-subtitle-text {
	font-family: " . movedo_grve_option( 'subtitle_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'subtitle_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'subtitle_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'subtitle_text', '34px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'subtitle_text', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'subtitle_text', '36px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'subtitle_text', '0px', 'letter-spacing'  ) . "
}

.grve-small-text,
span.wpcf7-not-valid-tip,
div.wpcf7-mail-sent-ok,
div.wpcf7-validation-errors,
.grve-post-meta-wrapper .grve-categories li {
	font-family: " . movedo_grve_option( 'small_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'small_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'small_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'small_text', '34px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'small_text', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'small_text', '0px', 'letter-spacing'  ) . "
}

.grve-quote-text,
blockquote p {
	font-family: " . movedo_grve_option( 'quote_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'quote_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'quote_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'quote_text', '24px', 'font-size'  ) . ";
	line-height: " . movedo_grve_option( 'quote_text', '36px', 'line-height'  ) . ";
	text-transform: " . movedo_grve_option( 'quote_text', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'quote_text', '0px', 'letter-spacing'  ) . "
}

";

/* Link Text */
$movedo_grve_btn_size = movedo_grve_option( 'link_text', '13px', 'font-size'  );
$movedo_grve_btn_size = filter_var( $movedo_grve_btn_size, FILTER_SANITIZE_NUMBER_INT );

$movedo_grve_btn_size_xsm = $movedo_grve_btn_size * 0.7;
$movedo_grve_btn_size_sm = $movedo_grve_btn_size * 0.85;
$movedo_grve_btn_size_lg = $movedo_grve_btn_size * 1.2;
$movedo_grve_btn_size_xlg = $movedo_grve_btn_size * 1.35;

$typo_css .= "

.grve-link-text,
.grve-btn,
input[type='submit'],
input[type='reset'],
input[type='button'],
button:not(.mfp-arrow):not(.grve-search-btn),
#grve-header .grve-shoppin-cart-content .total,
#grve-header .grve-shoppin-cart-content .button,
#cancel-comment-reply-link,
.grve-anchor-menu .grve-anchor-wrapper .grve-container > ul > li > a,
.grve-anchor-menu .grve-anchor-wrapper .grve-container ul.sub-menu li a,
h3#reply-title {
	font-family: " . movedo_grve_option( 'link_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . " !important;
	font-weight: " . movedo_grve_option( 'link_text', 'normal', 'font-weight'  ) . " !important;
	font-style: " . movedo_grve_option( 'link_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'link_text', '13px', 'font-size'  ) . " !important;
	text-transform: " . movedo_grve_option( 'link_text', 'uppercase', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'link_text', '0px', 'letter-spacing'  ) . "
}

.grve-btn.grve-btn-extrasmall,
.widget.woocommerce button[type='submit'] {
	font-size: " . round( $movedo_grve_btn_size_xsm, 0 ) . "px !important;
}

.grve-btn.grve-btn-small {
	font-size: " . round( $movedo_grve_btn_size_sm, 0 ) . "px !important;
}

.grve-btn.grve-btn-large {
	font-size: " . round( $movedo_grve_btn_size_lg, 0 ) . "px !important;
}

.grve-btn.grve-btn-extralarge {
	font-size: " . round( $movedo_grve_btn_size_xlg, 0 ) . "px !important;
}


";

/* Widget Text */
$typo_css .= "

.grve-widget-title {
	font-family: " . movedo_grve_option( 'widget_title', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'widget_title', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'widget_title', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'widget_title', '34px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'widget_title', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'widget_title', '36px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'widget_title', '0px', 'letter-spacing'  ) . "
}

.widget,
.widgets,
.widget p {
	font-family: " . movedo_grve_option( 'widget_text', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'widget_text', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'widget_text', 'normal', 'font-style'  ) . ";
	font-size: " . movedo_grve_option( 'widget_text', '34px', 'font-size'  ) . ";
	text-transform: " . movedo_grve_option( 'widget_text', 'none', 'text-transform'  ) . ";
	line-height: " . movedo_grve_option( 'widget_text', '36px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'widget_text', '0px', 'letter-spacing'  ) . "
}


";

/* Single Post */
$typo_css .= "

.single-post #grve-single-content,
.single-product #tab-description,
.single-tribe_events #grve-single-content {
	font-size: " . movedo_grve_option( 'single_post_font', '18px', 'font-size'  ) . ";
	font-family: " . movedo_grve_option( 'single_post_font', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'single_post_font', 'normal', 'font-weight'  ) . ";
	line-height: " . movedo_grve_option( 'single_post_font', '36px', 'line-height'  ) . ";
	" . movedo_grve_css_option( 'single_post_font', '0px', 'letter-spacing'  ) . "
}

";


/* Custom Font Family */
$typo_css .= "
.grve-custom-font-1,
#grve-feature-section .grve-subheading.grve-custom-font-1,
#grve-feature-section.grve-fullscreen .grve-subheading.grve-custom-font-1,
#grve-feature-section .grve-title.grve-custom-font-1,
#grve-feature-section.grve-fullscreen .grve-title.grve-custom-font-1,
#grve-feature-section .grve-description.grve-custom-font-1,
#grve-feature-section.grve-fullscreen .grve-description.grve-custom-font-1 {
	font-family: " . movedo_grve_option( 'custom_font_family_1', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'custom_font_family_1', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'custom_font_family_1', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'custom_font_family_1', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'custom_font_family_1', '0px', 'letter-spacing'  ) . "
}
.grve-custom-font-2,
#grve-feature-section .grve-subheading.grve-custom-font-2,
#grve-feature-section.grve-fullscreen .grve-subheading.grve-custom-font-2,
#grve-feature-section .grve-title.grve-custom-font-2,
#grve-feature-section.grve-fullscreen .grve-title.grve-custom-font-2,
#grve-feature-section .grve-description.grve-custom-font-2,
#grve-feature-section.grve-fullscreen .grve-description.grve-custom-font-2 {
	font-family: " . movedo_grve_option( 'custom_font_family_2', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'custom_font_family_2', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'custom_font_family_2', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'custom_font_family_2', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'custom_font_family_2', '0px', 'letter-spacing'  ) . "
}
.grve-custom-font-3,
#grve-feature-section .grve-subheading.grve-custom-font-3,
#grve-feature-section.grve-fullscreen .grve-subheading.grve-custom-font-3,
#grve-feature-section .grve-title.grve-custom-font-3,
#grve-feature-section.grve-fullscreen .grve-title.grve-custom-font-3,
#grve-feature-section .grve-description.grve-custom-font-3,
#grve-feature-section.grve-fullscreen .grve-description.grve-custom-font-3 {
	font-family: " . movedo_grve_option( 'custom_font_family_3', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'custom_font_family_3', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'custom_font_family_3', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'custom_font_family_3', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'custom_font_family_3', '0px', 'letter-spacing'  ) . "
}
.grve-custom-font-4,
#grve-feature-section .grve-subheading.grve-custom-font-4,
#grve-feature-section.grve-fullscreen .grve-subheading.grve-custom-font-4,
#grve-feature-section .grve-title.grve-custom-font-4,
#grve-feature-section.grve-fullscreen .grve-title.grve-custom-font-4,
#grve-feature-section .grve-description.grve-custom-font-4,
#grve-feature-section.grve-fullscreen .grve-description.grve-custom-font-4 {
	font-family: " . movedo_grve_option( 'custom_font_family_4', 'Arial, Helvetica, sans-serif', 'font-family'  ) . ";
	font-weight: " . movedo_grve_option( 'custom_font_family_4', 'normal', 'font-weight'  ) . ";
	font-style: " . movedo_grve_option( 'custom_font_family_4', 'normal', 'font-style'  ) . ";
	text-transform: " . movedo_grve_option( 'custom_font_family_4', 'none', 'text-transform'  ) . ";
	" . movedo_grve_css_option( 'custom_font_family_4', '0px', 'letter-spacing'  ) . "
}

";

/* Blog Leader
============================================================================= */
$body_lineheight = movedo_grve_option( 'body_font', '36px', 'line-height'  );
$body_lineheight = filter_var( $body_lineheight, FILTER_SANITIZE_NUMBER_INT );
$typo_css .= "
.grve-blog-leader .grve-post-list .grve-post-content p {
	max-height: " . ( esc_attr( $body_lineheight ) * 2 ) . "px;
}

";

//Responsive Typography

$movedo_grve_responsive_fonts_group_headings =  array (
	array(
		'id'   => 'h1_font',
		'selector'  => 'h1,.grve-h1,#grve-theme-wrapper .grve-modal .grve-search input[type="text"],.grve-dropcap span,p.grve-dropcap:first-letter',
		'custom_selector'  => '.grve-h1',
	),
	array(
		'id'   => 'h2_font',
		'selector'  => 'h2,.grve-h2',
		'custom_selector'  => '.grve-h2',
	),
	array(
		'id'   => 'h3_font',
		'selector'  => 'h3,.grve-h3',
		'custom_selector'  => '.grve-h3',
	),
	array(
		'id'   => 'h4_font',
		'selector'  => 'h4,.grve-h4',
		'custom_selector'  => '.grve-h4',
	),
	array(
		'id'   => 'h5_font',
		'selector'  => 'h5,.grve-h5',
		'custom_selector'  => '.grve-h5',
	),
	array(
		'id'   => 'h6_font',
		'selector'  => 'h6,.grve-h6',
		'custom_selector'  => '.grve-h6',
	),
);


$movedo_grve_responsive_fonts_group_1 =  array (
	array(
		'id'   => 'page_title',
		'selector'  => '#grve-page-title .grve-title,#grve-blog-title .grve-title,#grve-search-page-title .grve-title',
	),
	array(
		'id'   => 'post_title',
		'selector'  => '#grve-post-title .grve-title',
	),
	array(
		'id'   => 'post_simple_title',
		'selector'  => '.grve-single-simple-title',
	),
	array(
		'id'   => 'portfolio_title',
		'selector'  => '#grve-portfolio-title .grve-title',
	),
	array(
		'id'   => 'forum_title',
		'selector'  => '#grve-forum-title .grve-title',
	),
	array(
		'id'   => 'product_simple_title',
		'selector'  => '.grve-product-area .product_title',
	),
	array(
		'id'   => 'product_tax_title',
		'selector'  => '#grve-product-title .grve-title,#grve-product-tax-title .grve-title,.woocommerce-page #grve-page-title .grve-title',
	),
	array(
		'id'   => 'event_simple_title',
		'selector'  => '.grve-event-simple-title',
	),
	array(
		'id'   => 'event_tax_title',
		'selector'  => '#grve-event-title .grve-title,#grve-event-tax-title .grve-title',
	),
	array(
		'id'   => 'feature_title_custom_font',
		'selector'  => '#grve-feature-section .grve-title',
	),
	array(
		'id'   => 'feature_title_full_font',
		'selector'  => '#grve-feature-section.grve-fullscreen .grve-title',
	),
	array(
		'id'   => 'feature_desc_full_font',
		'selector'  => '#grve-feature-section.grve-fullscreen .grve-description',
	),
);

$movedo_grve_responsive_fonts_group_2 =  array (
	array(
		'id'   => 'page_description',
		'selector'  => '#grve-page-title .grve-description,#grve-blog-title .grve-description,#grve-blog-title .grve-description p,#grve-search-page-title .grve-description',
	),
	array(
		'id'   => 'post_title_meta',
		'selector'  => '#grve-post-title .grve-title-categories',
	),
	array(
		'id'   => 'post_title_extra_meta',
		'selector'  => '#grve-post-title .grve-post-meta, #grve-post-title .grve-post-meta li',
	),
	array(
		'id'   => 'post_title_desc',
		'selector'  => '#grve-post-title .grve-description',
	),
	array(
		'id'   => 'product_short_description',
		'selector'  => '#grve-entry-summary .grve-short-description p',
	),
	array(
		'id'   => 'product_tax_description',
		'selector'  => '#grve-product-title .grve-description,#grve-product-tax-title .grve-description,#grve-product-tax-title .grve-description p,.woocommerce-page #grve-page-title .grve-description',
	),
	array(
		'id'   => 'event_tax_description',
		'selector'  => '#grve-event-title .grve-description,#grve-event-tax-title .grve-description,#grve-event-tax-title .grve-description p',
	),
	array(
		'id'   => 'feature_subheading_custom_font',
		'selector'  => '#grve-feature-section .grve-subheading',
	),
	array(
		'id'   => 'feature_subheading_full_font',
		'selector'  => '#grve-feature-section.grve-fullscreen .grve-subheading',
	),
	array(
		'id'   => 'feature_desc_custom_font',
		'selector'  => '#grve-feature-section .grve-description',
	),
	array(
		'id'   => 'leader_text',
		'selector'  => '.grve-leader-text,.grve-leader-text p,p.grve-leader-text',
	),
	array(
		'id'   => 'quote_text',
		'selector'  => '.grve-quote-text,blockquote p',
	),
	array(
		'id'   => 'subtitle_text',
		'selector'  => '.grve-subtitle,.grve-subtitle-text',
	),
	array(
		'id'   => 'link_text',
		'selector'  => '#grve-theme-wrapper .grve-link-text,#grve-theme-wrapper a.grve-btn,#grve-theme-wrapper input[type="submit"],#grve-theme-wrapper input[type="reset"],#grve-theme-wrapper button:not(.mfp-arrow):not(.grve-search-btn),#cancel-comment-reply-link,h3#reply-title',
	),
	array(
		'id'   => 'main_menu_font',
		'selector'  => '.grve-main-menu .grve-wrapper > ul > li > a,.grve-main-menu .grve-wrapper > ul > li.megamenu > ul > li > a,.grve-toggle-hiddenarea .grve-label,.grve-main-menu .grve-wrapper > ul > li ul li.grve-goback a',
	),
	array(
		'id'   => 'sub_menu_font',
		'selector'  => '.grve-slide-menu .grve-main-menu .grve-wrapper ul li.megamenu ul li:not(.grve-goback) > a, .grve-main-menu .grve-wrapper > ul > li ul li a, #grve-header .grve-shoppin-cart-content',
	),
	array(
		'id'   => 'description_menu_font',
		'selector'  => '.grve-main-menu .grve-menu-description',
	),
	array(
		'id'   => 'hidden_menu_font',
		'selector'  => '#grve-hidden-menu .grve-hiddenarea-content .grve-menu > li > a,#grve-responsive-anchor .grve-hiddenarea-content .grve-menu > li > a,#grve-hidden-menu ul.grve-menu > li.megamenu > ul > li > a,#grve-hidden-menu ul.grve-menu > li ul li.grve-goback a',
	),
	array(
		'id'   => 'sub_hidden_menu_font',
		'selector'  => '#grve-hidden-menu.grve-slide-menu ul li.megamenu ul li:not(.grve-goback) > a, #grve-hidden-menu.grve-slide-menu ul li ul li:not(.grve-goback) > a, #grve-hidden-menu.grve-toggle-menu ul li.megamenu ul li > a, #grve-hidden-menu.grve-toggle-menu ul li ul li > a, #grve-responsive-anchor ul li ul li > a',
	),
	array(
		'id'   => 'description_hidden_menu_font',
		'selector'  => '#grve-hidden-menu .grve-menu-description',
	),
);

function movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts = array() , $threshold = 35, $ratio = 0.7) {

	$css = '';

	if ( !empty( $movedo_grve_responsive_fonts ) && $ratio < 1 ) {

		foreach ( $movedo_grve_responsive_fonts as $font ) {
			$movedo_grve_size = movedo_grve_option( $font['id'], '32px', 'font-size'  );
			$movedo_grve_size = filter_var( $movedo_grve_size, FILTER_SANITIZE_NUMBER_INT );
			$line_height = movedo_grve_option( $font['id'], '32px', 'line-height'  );
			$line_height = filter_var( $line_height, FILTER_SANITIZE_NUMBER_INT );

			if ( $movedo_grve_size >= $threshold ) {
				$custom_line_height = $line_height / $movedo_grve_size;
				$custom_size = $movedo_grve_size * $ratio;

				if ( 'link_text' == $font['id'] ) {
					$css .= $font['selector'] . " {
						font-size: " . round( $custom_size, 0 ) . "px !important;
						line-height: " . round( $custom_line_height, 2 ) . "em;
					}
					";
				} else {
					$css .= $font['selector'] . " {
						font-size: " . round( $custom_size, 0 ) . "px;
						line-height: " . round( $custom_line_height, 2 ) . "em;
					}
					";
				}
			}

			if ( isset( $font['custom_selector'] ) ) {
				$sizes = array( '120', '140', '160', '180', '200', '250', '300' );
				foreach ( $sizes as $size ) {
					$custom_size = $movedo_grve_size * ( $size / 100 );
					if ( $custom_size >= $threshold ) {
						if ( '250' == $size || '300' == $size ) {
							$custom_size = $movedo_grve_size * ( $ratio / 1.7 );
						} elseif ( '200' == $size ) {
							$custom_size = $movedo_grve_size * ( $ratio / 1.4 );
						} else {
							$custom_size = $movedo_grve_size * ( $ratio / 1.15 );
						}
						$css .= $font['custom_selector'] . ".grve-heading-" . esc_attr( $size ) ." {
							font-size: " . round( $custom_size, 0 ) . "px;
						}
						";
					}
				}
			}

		}

	}

	return $css;
}
$small_desktop_threshold_headings = movedo_grve_option( 'typography_small_desktop_threshold_headings', 20 );
$small_desktop_ratio_headings = movedo_grve_option( 'typography_small_desktop_ratio_headings', 1 );
$tablet_landscape_threshold_headings = movedo_grve_option( 'typography_tablet_landscape_threshold_headings', 20 );
$tablet_landscape_ratio_headings = movedo_grve_option( 'typography_tablet_landscape_ratio_headings', 1 );
$tablet_portrait_threshold_headings = movedo_grve_option( 'typography_tablet_portrait_threshold_headings', 20 );
$tablet_portrait_ratio_headings = movedo_grve_option( 'typography_tablet_portrait_ratio_headings', 1 );
$mobile_threshold_headings = movedo_grve_option( 'typography_mobile_threshold_headings', 20 );
$mobile_ratio_headings = movedo_grve_option( 'typography_mobile_ratio_headings', 1 );

$small_desktop_threshold = movedo_grve_option( 'typography_small_desktop_threshold', 20 );
$small_desktop_ratio = movedo_grve_option( 'typography_small_desktop_ratio', 1 );
$tablet_landscape_threshold = movedo_grve_option( 'typography_tablet_landscape_threshold', 20 );
$tablet_landscape_ratio = movedo_grve_option( 'typography_tablet_landscape_ratio', 0.9 );
$tablet_portrait_threshold = movedo_grve_option( 'typography_tablet_portrait_threshold', 20 );
$tablet_portrait_ratio = movedo_grve_option( 'typography_tablet_portrait_ratio', 0.85 );
$mobile_threshold = movedo_grve_option( 'typography_mobile_threshold', 28 );
$mobile_ratio = movedo_grve_option( 'typography_mobile_ratio', 0.6 );

$small_desktop_threshold2 = movedo_grve_option( 'typography_small_desktop_threshold2', 14 );
$small_desktop_ratio2 = movedo_grve_option( 'typography_small_desktop_ratio2', 1 );
$tablet_landscape_threshold2 = movedo_grve_option( 'typography_tablet_landscape_threshold2', 14 );
$tablet_landscape_ratio2 = movedo_grve_option( 'typography_tablet_landscape_ratio2', 0.9 );
$tablet_portrait_threshold2 = movedo_grve_option( 'typography_tablet_portrait_threshold2', 14 );
$tablet_portrait_ratio2 = movedo_grve_option( 'typography_tablet_portrait_ratio2', 0.8 );
$mobile_threshold2 = movedo_grve_option( 'typography_mobile_threshold2', 13 );
$mobile_ratio2 = movedo_grve_option( 'typography_mobile_ratio2', 0.7 );

$typo_css .= "
	@media only screen and (min-width: 1201px) and (max-width: 1440px) {
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_headings, $small_desktop_threshold_headings, $small_desktop_ratio_headings ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_1, $small_desktop_threshold, $small_desktop_ratio ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_2, $small_desktop_threshold2, $small_desktop_ratio2 ). "
	}
	@media only screen and (min-width: 960px) and (max-width: 1200px) {
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_headings, $tablet_landscape_threshold_headings, $tablet_landscape_ratio_headings ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_1, $tablet_landscape_threshold, $tablet_landscape_ratio ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_2, $tablet_landscape_threshold2, $tablet_landscape_ratio2 ). "
	}
	@media only screen and (min-width: 768px) and (max-width: 959px) {
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_headings, $tablet_portrait_threshold_headings, $tablet_portrait_ratio_headings ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_1, $tablet_portrait_threshold, $tablet_portrait_ratio ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_2, $tablet_portrait_threshold2, $tablet_portrait_ratio2 ). "
	}
	@media only screen and (max-width: 767px) {
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_headings, $mobile_threshold_headings, $mobile_ratio_headings ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_1, $mobile_threshold, $mobile_ratio ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_2, $mobile_threshold2, $mobile_ratio2 ). "
	}
	@media print {
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_headings, $mobile_threshold_headings, $mobile_ratio_headings ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_1, $mobile_threshold, $mobile_ratio ). "
		" . movedo_grve_print_typography_responsive( $movedo_grve_responsive_fonts_group_2, $mobile_threshold2, $mobile_ratio2 ). "
	}
";

wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $typo_css ) );

//Omit closing PHP tag to avoid accidental whitespace output errors.
