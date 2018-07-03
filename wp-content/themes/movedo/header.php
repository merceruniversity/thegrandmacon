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
		$movedo_grve_header_mode = movedo_grve_option( 'header_mode', 'default' );
		$header_sticky_type = movedo_grve_option( 'header_sticky_type', 'simple' );
		$movedo_grve_header_fullwidth = movedo_grve_option( 'header_fullwidth', '1' );
		$movedo_grve_header_data = movedo_grve_get_feature_header_data();
		$movedo_grve_header_style = $movedo_grve_header_data['header_style'];
		$movedo_grve_header_overlapping = $movedo_grve_header_data['data_overlap'];
		$movedo_grve_responsive_header_overlapping = movedo_grve_option( 'responsive_header_overlapping', 'no' );
		$movedo_grve_header_position = $movedo_grve_header_data['data_header_position'];
		$movedo_grve_menu_open_type = movedo_grve_option( 'header_menu_open_type', 'toggle' );

		// Theme Layout
		$movedo_grve_theme_layout = movedo_grve_option( 'theme_layout', 'stretched' );
		$movedo_grve_frame_size = movedo_grve_option( 'frame_size', 30 );


		//Sticky Header
		$movedo_grve_header_sticky_type = movedo_grve_option( 'header_sticky_type', 'simple' );
		if ( is_singular() ) {
			$movedo_grve_header_sticky_type = movedo_grve_post_meta( '_movedo_grve_sticky_header_type', $movedo_grve_header_sticky_type );
			$movedo_grve_responsive_header_overlapping = movedo_grve_post_meta( '_movedo_grve_responsive_header_overlapping', $movedo_grve_responsive_header_overlapping );
		} else if ( movedo_grve_is_woo_shop() ) {
			$movedo_grve_header_sticky_type = movedo_grve_post_meta_shop( '_movedo_grve_sticky_header_type', $movedo_grve_header_sticky_type );
			$movedo_grve_responsive_header_overlapping = movedo_grve_post_meta_shop( '_movedo_grve_responsive_header_overlapping', $movedo_grve_responsive_header_overlapping );
		}
		$movedo_grve_header_sticky_type = movedo_grve_visibility( 'header_sticky_enabled' ) ? $movedo_grve_header_sticky_type : 'none';

		$movedo_grve_header_sticky_height = movedo_grve_option( 'header_sticky_shrink_height', '0' );
		if( 'simple' == $movedo_grve_header_sticky_type && 'default' == $movedo_grve_header_mode) {
			$movedo_grve_header_sticky_height = movedo_grve_option( 'header_height' );
		}
		if( 'simple' == $movedo_grve_header_sticky_type && 'logo-top' == $movedo_grve_header_mode) {
			$movedo_grve_header_sticky_height = movedo_grve_option( 'header_bottom_height' );
		}
		$movedo_grve_responsive_header_height = movedo_grve_option( 'responsive_header_height' );
		$movedo_grve_header_menu_mode = movedo_grve_option( 'header_menu_mode', 'default' );

		if ( 'default' == $movedo_grve_header_mode ) {
			$movedo_grve_logo_align = 'left';
			if ( 'split' == $movedo_grve_header_menu_mode  ) {
				$movedo_grve_menu_align = 'center';
			} else {
				$movedo_grve_menu_align = movedo_grve_option( 'menu_align', 'right' );
			}
			$movedo_grve_menu_type = movedo_grve_option( 'menu_type', 'classic' );
			if ( is_singular() ) {
				$movedo_grve_menu_type = movedo_grve_post_meta( '_movedo_grve_menu_type', $movedo_grve_menu_type );
			} else if ( movedo_grve_is_woo_shop() ) {
				$movedo_grve_menu_type = movedo_grve_post_meta_shop( '_movedo_grve_menu_type', $movedo_grve_menu_type );
			}
		} else if ( 'logo-top' == $movedo_grve_header_mode ) {
			$movedo_grve_logo_align = movedo_grve_option( 'header_top_logo_align', 'center' );
			$movedo_grve_menu_align = movedo_grve_option( 'header_top_menu_align', 'center' );
			$movedo_grve_menu_type = movedo_grve_option( 'header_top_logo_menu_type', 'classic' );
			if ( is_singular() ) {
				$movedo_grve_menu_type = movedo_grve_post_meta( '_movedo_grve_menu_type', $movedo_grve_menu_type );
			} else if ( movedo_grve_is_woo_shop() ) {
				$movedo_grve_menu_type = movedo_grve_post_meta_shop( '_movedo_grve_menu_type', $movedo_grve_menu_type );
			}
		} else {
			$movedo_grve_header_fullwidth = 0;
			$movedo_grve_header_overlapping = 'no';
			$movedo_grve_header_sticky_type = 'none';
			$movedo_grve_menu_align = movedo_grve_option( 'header_side_menu_align', 'left' );
			$movedo_grve_logo_align = movedo_grve_option( 'header_side_logo_align', 'left' );
		}
		//Header Classes
		$movedo_grve_header_classes = array();
		if ( 1 == $movedo_grve_header_fullwidth ) {
			$movedo_grve_header_classes[] = 'grve-fullwidth';
		}
		if ( 'yes' == $movedo_grve_header_overlapping ) {
			$movedo_grve_header_classes[] = 'grve-overlapping';
		}
		if ( 'yes' == $movedo_grve_responsive_header_overlapping ) {
			$movedo_grve_header_classes[] = 'grve-responsive-overlapping';
		}
		if( 'below' == $movedo_grve_header_position ) {
			$movedo_grve_header_classes[] = 'grve-header-below';
		}
		if ( 'split' == $movedo_grve_header_menu_mode  ) {
			$movedo_grve_header_classes[] = 'grve-header-split-menu';
		}
		$movedo_grve_header_class_string = implode( ' ', $movedo_grve_header_classes );


		//Main Header Classes
		$movedo_grve_main_header_classes = array();
		$movedo_grve_main_header_classes[] = 'grve-header-' . $movedo_grve_header_mode;
		if ( 'side' == $movedo_grve_header_mode ) {
			$movedo_grve_main_header_classes[] = 'grve-' . $movedo_grve_menu_open_type . '-menu';
		} else {
			$movedo_grve_main_header_classes[] = 'grve-' . $movedo_grve_header_style;
		}
		if ( 'side' != $movedo_grve_header_mode || 'none' != $movedo_grve_header_sticky_type ) {
			$movedo_grve_main_header_classes[] = 'grve-' . $movedo_grve_header_sticky_type . '-sticky';
		}
		$movedo_grve_header_main_class_string = implode( ' ', $movedo_grve_main_header_classes );

		$movedo_grve_menu_arrows = movedo_grve_option( 'submenu_pointer', 'none' );

		// Main Menu Classes
		$movedo_grve_main_menu_classes = array();


		if ( 'side' != $movedo_grve_header_mode ) {
			$movedo_grve_main_menu_classes[] = 'grve-horizontal-menu';
			if ( 'default' == $movedo_grve_header_mode && 'split' == $movedo_grve_header_menu_mode  ) {
				$movedo_grve_main_menu_classes[] = 'grve-split-menu';
			}
			$movedo_grve_main_menu_classes[] = 'grve-position-' . $movedo_grve_menu_align;
			if( 'none' != $movedo_grve_menu_arrows ) {
				$movedo_grve_main_menu_classes[] = 'grve-' . $movedo_grve_menu_arrows;
			}
			if ( 'hidden' != $movedo_grve_menu_type ){
				$movedo_grve_main_menu_classes[] = 'grve-menu-type-' . $movedo_grve_menu_type;
			}
		} else {
			$movedo_grve_main_menu_classes[] = 'grve-vertical-menu';
			$movedo_grve_main_menu_classes[] = 'grve-align-' . $movedo_grve_menu_align;
		}



		$movedo_grve_main_menu_classes[] = 'grve-main-menu';
		$movedo_grve_main_menu_class_string = implode( ' ', $movedo_grve_main_menu_classes );

		$movedo_grve_main_menu = movedo_grve_get_header_nav();
		$movedo_grve_sidearea_data = movedo_grve_get_sidearea_data();


		$movedo_grve_header_sticky_devices_enabled = movedo_grve_option( 'header_sticky_devices_enabled' );
		$movedo_grve_header_sticky_devices = 'no';
		if ( '1' == $movedo_grve_header_sticky_devices_enabled ) {
			$movedo_grve_header_sticky_devices = 'yes';
		}

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

		<?php movedo_grve_print_theme_loader(); ?>

		<?php
			// Theme Wrapper Classes
			$movedo_grve_theme_wrapper_classes = array();
			if ( 'side' == $movedo_grve_header_mode ) {
				$movedo_grve_theme_wrapper_classes[] = 'grve-header-side';
			}
			if( 'below' == $movedo_grve_header_position && 'yes' == $movedo_grve_header_overlapping ) {
				$movedo_grve_theme_wrapper_classes[] = 'grve-feature-below';
			}
			$movedo_grve_theme_wrapper_class_string = implode( ' ', $movedo_grve_theme_wrapper_classes );


			$headedr_attributes = array();
			$header_attributes[] = 'class="' . esc_attr( $movedo_grve_header_class_string ) . '"';
			$header_attributes[] = 'data-sticky="' . esc_attr( $movedo_grve_header_sticky_type ) . '"';
			$header_attributes[] = 'data-sticky-height="' . esc_attr( $movedo_grve_header_sticky_height ) . '"';
			$header_attributes[] = 'data-devices-sticky="' . esc_attr( $movedo_grve_header_sticky_devices ) . '"';
			$header_attributes[] = 'data-devices-sticky-height="' . esc_attr( $movedo_grve_responsive_header_height ) . '"';

		?>

		<!-- Theme Wrapper -->
		<div id="grve-theme-wrapper" class="<?php echo esc_attr( $movedo_grve_theme_wrapper_class_string ); ?>" data-mask-layer="2">
			<div id="grve-theme-content">
			<?php
				//Top Bar
				movedo_grve_print_header_top_bar();

				//FEATURE Header Below
				if( 'below' == $movedo_grve_header_position ) {
					movedo_grve_print_header_feature();
				}
			?>

			<!-- HEADER -->
			<header id="grve-header" <?php echo implode( ' ', $header_attributes ); ?>>
				<div class="grve-wrapper clearfix">

					<!-- Header -->
					<div id="grve-main-header" class="<?php echo esc_attr( $movedo_grve_header_main_class_string ); ?>">
					<?php
						if ( 'side' == $movedo_grve_header_mode ) {
					?>
						<div class="grve-main-header-wrapper clearfix">
							<div class="grve-content">
								<?php do_action( 'movedo_grve_side_logo_before' ); ?>
								<?php movedo_grve_print_logo( 'side', $movedo_grve_logo_align ); ?>
								<?php do_action( 'movedo_grve_side_logo_after' ); ?>
								<?php if ( $movedo_grve_main_menu != 'disabled' ) { ?>
								<!-- Main Menu -->
								<nav id="grve-main-menu" class="<?php echo esc_attr( $movedo_grve_main_menu_class_string ); ?>">
									<div class="grve-wrapper">
										<?php movedo_grve_header_nav( $movedo_grve_main_menu ); ?>
									</div>
								</nav>
								<!-- End Main Menu -->
								<?php } ?>
							</div>
						</div>
						<div class="grve-header-elements-wrapper grve-align-<?php echo esc_attr( $movedo_grve_menu_align); ?>">
							<?php
								movedo_grve_print_header_elements( $movedo_grve_sidearea_data );
								movedo_grve_print_header_text();
							?>
						</div>
						<?php movedo_grve_print_side_header_bg_image(); ?>
					<?php
						} else if ( 'logo-top' == $movedo_grve_header_mode ) {
						//Log on Top Header
					?>
						<div id="grve-top-header">
							<div class="grve-wrapper clearfix">
								<div class="grve-container">
									<?php do_action( 'movedo_grve_top_logo_before' ); ?>
									<?php movedo_grve_print_logo( 'logo-top', $movedo_grve_logo_align ); ?>
									<?php do_action( 'movedo_grve_top_logo_after' ); ?>
								</div>
							</div>
						</div>
						<div id="grve-bottom-header">
							<div class="grve-wrapper clearfix">
								<div class="grve-container">
									<div class="grve-header-elements-wrapper grve-position-right">
								<?php
									if ( 'hidden' == $movedo_grve_menu_type && 'disabled' != $movedo_grve_main_menu ) {
										movedo_grve_print_header_hiddenarea_button();
									}
									movedo_grve_print_header_elements();
									movedo_grve_print_header_text();
									movedo_grve_print_header_sidearea_button( $movedo_grve_sidearea_data );
									movedo_grve_print_header_safebutton();
								?>
									</div>
								<?php
									if ( 'hidden' != $movedo_grve_menu_type && $movedo_grve_main_menu != 'disabled' ) {
								?>
										<!-- Main Menu -->
										<nav id="grve-main-menu" class="<?php echo esc_attr( $movedo_grve_main_menu_class_string ); ?>">
											<div class="grve-wrapper">
												<?php movedo_grve_header_nav( $movedo_grve_main_menu ); ?>
											</div>
										</nav>
										<!-- End Main Menu -->
								<?php
									}
								?>
								</div>
							</div>
						</div>
					<?php
						} else {
						//Default Header
					?>
						<div class="grve-wrapper clearfix">
							<div class="grve-container">
							<?php
								if ( 'default' == $movedo_grve_header_menu_mode || 'hidden' == $movedo_grve_menu_type || 'disabled' == $movedo_grve_main_menu  ) {

							?>
								<?php do_action( 'movedo_grve_default_logo_before' ); ?>
								<?php movedo_grve_print_logo( 'default', $movedo_grve_logo_align ); ?>
								<?php do_action( 'movedo_grve_default_logo_after' ); ?>
							<?php
								}
							?>
								<div class="grve-header-elements-wrapper grve-position-right">
							<?php
								if ( 'hidden' == $movedo_grve_menu_type && 'disabled' != $movedo_grve_main_menu ) {
									movedo_grve_print_header_hiddenarea_button();
								}
								movedo_grve_print_header_elements();
								movedo_grve_print_header_text();
								movedo_grve_print_header_sidearea_button( $movedo_grve_sidearea_data );
								movedo_grve_print_header_safebutton();
							?>
								</div>
							<?php
								if ( 'hidden' != $movedo_grve_menu_type && $movedo_grve_main_menu != 'disabled' ) {
							?>
									<!-- Main Menu -->
									<nav id="grve-main-menu" class="<?php echo esc_attr( $movedo_grve_main_menu_class_string ); ?>">
										<div class="grve-wrapper">
											<?php movedo_grve_header_nav( $movedo_grve_main_menu, $movedo_grve_header_menu_mode ); ?>
										</div>
									</nav>
									<!-- End Main Menu -->
							<?php
								}
							?>
							</div>
						</div>
					<?php
						}
					?>

					</div>
					<!-- End Header -->

					<!-- Responsive Header -->
					<div id="grve-responsive-header">
						<div id="grve-main-responsive-header" class="grve-wrapper clearfix">
							<div class="grve-container">
							<?php do_action( 'movedo_grve_responsive_logo_before' ); ?>
							<?php movedo_grve_print_logo( 'responsive' , 'left' ); ?>
							<?php do_action( 'movedo_grve_responsive_logo_after' ); ?>
								<div class="grve-header-elements-wrapper grve-position-right">
								<?php do_action( 'movedo_grve_responsive_header_elements_first' ); ?>
								<!-- Hidden Menu & Side Area Button -->
								<?php
									if ( 'disabled' != $movedo_grve_main_menu || movedo_grve_check_header_elements_visibility_any() ){
										movedo_grve_print_header_hiddenarea_button();
									}
								?>
								<?php movedo_grve_print_login_responsive_button(); ?>
								<?php movedo_grve_print_cart_responsive_link(); ?>
								<?php
									$movedo_grve_responsive_sidearea_button = movedo_grve_option( 'responsive_sidearea_button_visibility', 'yes');
									if ( 'yes' == $movedo_grve_responsive_sidearea_button ) {
										movedo_grve_print_header_sidearea_button( $movedo_grve_sidearea_data );
									}
								?>
								<?php movedo_grve_print_header_safebutton(); ?>
								<!-- End Hidden Menu & Side Area Button -->
								<?php do_action( 'movedo_grve_responsive_header_elements_last' ); ?>
								</div>
							</div>
						</div>
					</div>
					<!-- End Responsive Header -->
				</div>

				<!-- Movedo Sticky Header -->
			<?php
				if ( 'side' != $movedo_grve_header_mode && 'movedo' == $movedo_grve_header_sticky_type ) {

				// Movedo Sticky Menu Classes
				$movedo_grve_movedo_sticky_menu_classes = array();

				$movedo_grve_movedo_sticky_menu_classes[] = 'grve-horizontal-menu';
				$movedo_grve_movedo_sticky_menu_classes[] = 'grve-position-' . $movedo_grve_menu_align;
				$movedo_grve_movedo_sticky_menu_classes[] = 'grve-main-menu';
				if( 'none' != $movedo_grve_menu_arrows ) {
					$movedo_grve_movedo_sticky_menu_classes[] = 'grve-' . $movedo_grve_menu_arrows;
				}
				if ( 'hidden' != $movedo_grve_menu_type ){
					$movedo_grve_movedo_sticky_menu_classes[] = 'grve-menu-type-' . $movedo_grve_menu_type;
				}

				$movedo_grve_movedo_sticky_menu_class_string = implode( ' ', $movedo_grve_movedo_sticky_menu_classes );

			?>
				<div id="grve-movedo-sticky-header" class="grve-fullwidth">
					<div class="grve-wrapper clearfix">
						<div class="grve-container">

						<?php movedo_grve_print_logo( 'movedo-sticky' , 'left' ); ?>
						<div class="grve-header-elements-wrapper grve-position-right">
							<?php movedo_grve_print_header_elements(); ?>
							<?php movedo_grve_print_header_sidearea_button( $movedo_grve_sidearea_data ); ?>
							<?php movedo_grve_print_header_safebutton(); ?>
						</div>
						<?php
							if ( 'hidden' != $movedo_grve_menu_type && $movedo_grve_main_menu != 'disabled' ) {
						?>
							<!-- Main Menu -->
							<nav id="grve-movedo-sticky-menu" class="<?php echo esc_attr( $movedo_grve_movedo_sticky_menu_class_string ); ?>">
								<div class="grve-wrapper">
									<?php movedo_grve_header_nav( $movedo_grve_main_menu ); ?>
								</div>
							</nav>
							<!-- End Main Menu -->
						<?php
							}
						?>

						</div>
					</div>

				</div>
			<?php
				}
			?>
				<!-- End Movedo Sticky Header -->

			</header>
			<!-- END HEADER -->
			<?php do_action( 'movedo_grve_header_after' ); ?>

			<?php
				//FEATURE Header Above
				if( 'above' == $movedo_grve_header_position ) {
					movedo_grve_print_header_feature();
				}

//Omit closing PHP tag to avoid accidental whitespace output errors.
