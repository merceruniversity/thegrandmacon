<?php

/*
*	Main sidebar area
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


if( is_search() ) {
	return;
}

$fixed = "";
$movedo_grve_fixed_sidebar = "no";
$movedo_grve_sidebar_extra_content = false;

$sidebar_view = movedo_grve_get_current_view();

if ( 'forum' == $sidebar_view ) {
	$movedo_grve_sidebar_id = movedo_grve_option( 'forum_sidebar' );
	$movedo_grve_sidebar_layout = movedo_grve_option( 'forum_layout', 'none' );
	$movedo_grve_fixed_sidebar = movedo_grve_option( 'forum_fixed_sidebar', 'no' );
} else if ( 'shop' == $sidebar_view ) {
	if ( is_shop() ) {
		$movedo_grve_sidebar_id = movedo_grve_post_meta_shop( '_movedo_grve_sidebar', movedo_grve_option( 'page_sidebar' ) );
		$movedo_grve_sidebar_layout = movedo_grve_post_meta_shop( '_movedo_grve_layout', movedo_grve_option( 'page_layout', 'none' ) );
		$movedo_grve_fixed_sidebar =  movedo_grve_post_meta_shop( '_movedo_grve_fixed_sidebar' , movedo_grve_option( 'page_fixed_sidebar', 'no' ) );
	} else if( is_product() ) {
		$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'product_sidebar' ) );
		$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'product_layout', 'none' ) );
		$movedo_grve_fixed_sidebar =  movedo_grve_post_meta( '_movedo_grve_fixed_sidebar' , movedo_grve_option( 'product_fixed_sidebar', 'no' ) );
	} else {
		$movedo_grve_sidebar_id = movedo_grve_option( 'product_tax_sidebar' );
		$movedo_grve_sidebar_layout = movedo_grve_option( 'product_tax_layout', 'none' );
		$movedo_grve_fixed_sidebar = movedo_grve_option( 'product_tax_fixed_sidebar', 'no' );
	}
} else if ( 'event' == $sidebar_view ) {
	if ( is_singular( 'tribe_events' ) ) {
		$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'event_sidebar' ) );
		$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'event_layout', 'none' ) );
		$movedo_grve_fixed_sidebar =  movedo_grve_post_meta( '_movedo_grve_fixed_sidebar' , movedo_grve_option( 'event_fixed_sidebar', 'no' ) );
	} else {
		$movedo_grve_sidebar_id = movedo_grve_option( 'event_tax_sidebar' );
		$movedo_grve_sidebar_layout = movedo_grve_option( 'event_tax_layout', 'none' );
		$movedo_grve_fixed_sidebar = movedo_grve_option( 'event_tax_fixed_sidebar', 'no' );
	}
} else if ( is_singular() ) {
	if ( is_singular( 'post' ) ) {
		$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'post_sidebar' ) );
		$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'post_layout', 'none' ) );
		$movedo_grve_fixed_sidebar =  movedo_grve_post_meta( '_movedo_grve_fixed_sidebar' , movedo_grve_option( 'post_fixed_sidebar', 'no' ) );
	} else if ( is_singular( 'portfolio' ) ) {
		$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'portfolio_sidebar' ) );
		$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'portfolio_layout', 'none' ) );
		$movedo_grve_fixed_sidebar =  movedo_grve_post_meta( '_movedo_grve_fixed_sidebar' , movedo_grve_option( 'portfolio_fixed_sidebar', 'no' ) );
		$movedo_grve_sidebar_extra_content = movedo_grve_check_portfolio_details();
		if( $movedo_grve_sidebar_extra_content && 'none' == $movedo_grve_sidebar_layout ) {
			$movedo_grve_sidebar_layout = 'right';
		}
	} else {
		$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'page_sidebar' ) );
		$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'page_layout', 'none' ) );
		$movedo_grve_fixed_sidebar =  movedo_grve_post_meta( '_movedo_grve_fixed_sidebar' , movedo_grve_option( 'page_fixed_sidebar', 'no' ) );
	}
} else {
	$movedo_grve_sidebar_id = movedo_grve_option( 'blog_sidebar' );
	$movedo_grve_sidebar_layout = movedo_grve_option( 'blog_layout', 'none' );
	$movedo_grve_fixed_sidebar = movedo_grve_option( 'blog_fixed_sidebar', 'no' );
}

	if ( 'yes' == $movedo_grve_fixed_sidebar ) {
		$fixed = " grve-fixed-sidebar";
	}

if ( 'none' != $movedo_grve_sidebar_layout && ( is_active_sidebar( $movedo_grve_sidebar_id ) || $movedo_grve_sidebar_extra_content ) ) {
	if ( 'left' == $movedo_grve_sidebar_layout || 'right' == $movedo_grve_sidebar_layout ) {

		$movedo_grve_sidebar_class = 'grve-sidebar' . $fixed;
?>
		<!-- Sidebar -->
		<aside id="grve-sidebar" class="<?php echo esc_attr( $movedo_grve_sidebar_class ); ?>">
			<div class="grve-wrapper clearfix">
				<?php
					if ( $movedo_grve_sidebar_extra_content ) {
						movedo_grve_print_portfolio_details();
					}
				?>
				<?php dynamic_sidebar( $movedo_grve_sidebar_id ); ?>
			</div>
		</aside>
		<!-- End Sidebar -->
<?php
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
