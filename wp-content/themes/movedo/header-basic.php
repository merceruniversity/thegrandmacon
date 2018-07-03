<!doctype html>
<!--[if lt IE 10]>
<html class="ie9 no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

	<head>
		<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
		<!-- allow pinned sites -->
		<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
		<?php } ?>
		<?php wp_head(); ?>
	</head>
<?php
		// Theme Layout
		$movedo_grve_theme_layout = movedo_grve_option( 'theme_layout', 'stretched' );
		$movedo_grve_frame_size = movedo_grve_option( 'frame_size', 30 );
?>
	<body id="grve-body" <?php body_class(); ?>>
		<?php do_action( 'movedo_grve_body_top' ); ?>
		<?php if ( 'framed' == $movedo_grve_theme_layout ) { ?>
		<div id="grve-frames" data-frame-size="<?php echo esc_attr( $movedo_grve_frame_size ); ?>">
			<div class="grve-frame grve-top"></div>
			<div class="grve-frame grve-left"></div>
			<div class="grve-frame grve-right"></div>
			<div class="grve-frame grve-bottom"></div>
		</div>
		<?php } ?>
		<?php if ( movedo_grve_check_theme_loader_visibility() ) { ?>

		<!-- LOADER -->
		<div id="grve-loader-overflow">
			<div class="grve-loader"></div>
		</div>
		<?php } ?>

		<!-- Theme Wrapper -->
		<div id="grve-theme-wrapper">
			<div id="grve-theme-content">
