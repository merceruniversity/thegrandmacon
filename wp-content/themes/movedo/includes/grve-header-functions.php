<?php

/*
*	Header Helper functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

 /**
 * Print Logo
 */
if ( !function_exists('movedo_grve_print_logo') ) {
	function movedo_grve_print_logo( $mode = 'default', $align = '' ) {

		if ( !empty( $align ) ) {
			$align = 'grve-position-' . $align;
		}
		$movedo_grve_disable_logo = '';
		if ( is_singular() ) {
			$movedo_grve_disable_logo = movedo_grve_post_meta( '_movedo_grve_disable_logo', $movedo_grve_disable_logo );
		} else if( movedo_grve_is_woo_shop() ) {
			$movedo_grve_disable_logo = movedo_grve_post_meta_shop( '_movedo_grve_disable_logo', $movedo_grve_disable_logo );
		}

		if ( 'yes' != $movedo_grve_disable_logo ) {

			$logo_custom_link_url = movedo_grve_option( 'logo_custom_link_url' );
			$logo_link_url = home_url( '/' );
			if( !empty( $logo_custom_link_url ) ) {
				$logo_link_url = $logo_custom_link_url;
			}

			if ( movedo_grve_visibility( 'logo_as_text_enabled' ) ) {
?>
			<!-- Logo As Text-->
			<div class="grve-logo grve-logo-text <?php echo esc_attr( $align ); ?>">
				<a href="<?php echo esc_url( $logo_link_url ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
			</div>
<?php
			} else {
?>
			<!-- Logo -->
			<div class="grve-logo <?php echo esc_attr( $align ); ?>">
				<div class="grve-wrapper">
					<a href="<?php echo esc_url( $logo_link_url ); ?>">
<?php
					switch( $mode ) {
						case 'side':
							movedo_grve_print_logo_data( 'logo_side', 'grve-logo-side' );
						break;
						case 'responsive':
							movedo_grve_print_logo_data( 'logo_responsive', 'grve-logo-responsive'  );
						break;
						case 'movedo-sticky':
							movedo_grve_print_logo_data( 'logo_sticky', 'grve-movedo-sticky');
						break;
						default:
							movedo_grve_print_logo_data( 'logo', 'grve-default');
							movedo_grve_print_logo_data( 'logo_light', 'grve-light');
							movedo_grve_print_logo_data( 'logo_dark', 'grve-dark');
							movedo_grve_print_logo_data( 'logo_sticky', 'grve-sticky');
						break;
					}
?>
					</a>
				</div>
			</div>
			<!-- End Logo -->
<?php
			}
		}
	}
}

 /**
 * Get Logo Data
 */
if ( !function_exists('movedo_grve_print_logo_data') ) {
	function movedo_grve_print_logo_data( $logo_id, $logo_class ) {

		$logo_url = movedo_grve_option( $logo_id, '', 'url' );

		$logo_attributes = array();
		$logo_width = movedo_grve_option( $logo_id, '', 'width' );
		$logo_height = movedo_grve_option( $logo_id, '', 'height' );

		if ( !empty( $logo_width ) && !empty( $logo_height ) ) {
			$logo_attributes[] = 'width="' . esc_attr( $logo_width ) . '"';
			$logo_attributes[] = 'height="' . esc_attr( $logo_height ) . '"';
		}

		if ( !empty( $logo_url ) ) {
			$logo_url = str_replace( array( 'http:', 'https:' ), '', $logo_url );
?>
			<img class="<?php echo esc_attr( $logo_class ); ?>" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo('name') ); ?>" <?php echo implode( ' ', $logo_attributes ); ?>>
<?php
		}

	}
}


 /**
 * Prints correct title/subtitle for all cases
 */
function movedo_grve_header_title() {
	global $post;
	$page_title = $page_description = $page_reversed = '';

	//Shop
	if( movedo_grve_woocommerce_enabled() ) {

		if ( is_shop() && !is_search() ) {
			$post_id = wc_get_page_id( 'shop' );
			$page_title   = get_the_title( $post_id );
			$page_description = get_post_meta( $post_id, '_movedo_grve_description', true );
			return array(
				'title' => $page_title,
				'description' => $page_description,
			);
		} else if( is_product_taxonomy() ) {
			$page_title  = single_term_title("", false);
			$page_description = category_description();
			return array(
				'title' => $page_title,
				'description' => $page_description,
			);
		}
	}

	//Events Calendar Overview Pages
	if ( movedo_grve_events_calendar_is_overview() ) {
		if ( is_tax() ) {
			$page_title = single_term_title("", false);
			$page_description = term_description();
		} else {
			$page_title = tribe_get_events_title("", false);
			$page_description = '';
		}
		return array(
			'title' => $page_title,
			'description' => $page_description,
		);
	}

	//Main Pages
	if ( is_front_page() && is_home() ) {
		// Default homepage
		$page_title = get_bloginfo( 'name' );
		$page_description = get_bloginfo( 'description' );
	} else if ( is_front_page() ) {
		// static homepage
		$page_title = get_bloginfo( 'name' );
		$page_description = get_bloginfo( 'description' );
	} else if ( is_home() ) {
		// blog page
		$page_title = get_bloginfo( 'name' );
		$page_description = get_bloginfo( 'description' );
	} else if( is_search() ) {
		$page_description = esc_html__( 'Search Results for :', 'movedo' );
		$page_title = esc_attr( get_search_query() );
		$page_reversed = 'reversed';
	} else if ( is_singular() ) {
		$post_id = $post->ID;
		$page_title = get_the_title();
		$page_description = get_post_meta( $post_id, '_movedo_grve_description', true );

		 if ( movedo_grve_events_calendar_enabled() && is_singular( 'tribe_events' ) ) {
			$page_description = tribe_events_event_schedule_details( $post_id, '', '' );
			if ( tribe_get_cost() ) {
				$page_description .= '<span class="grve-event-cost">' . tribe_get_cost( null, true ) . '</span>';
			}
		} else if ( movedo_grve_events_calendar_enabled() && is_singular( 'tribe_organizer' ) ) {
			$page_description = movedo_grve_event_organizer_title_meta();
		}

	} else if ( is_archive() ) {
		//Post Categories
		if ( is_category() ) {
			$page_title = single_cat_title("", false);
			$page_description = category_description();
		} else if ( is_tag() ) {
			$page_title = single_tag_title("", false);
			$page_description = tag_description();
		} else if ( is_tax() ) {
			$page_title = single_term_title("", false);
			$page_description = term_description();
		} else if ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			$page_description = esc_html__( "Posts By :", 'movedo' );
			$page_title = $userdata->display_name;
			$page_reversed = 'reversed';
		} else if ( is_day() ) {
			$page_description = esc_html__( "Daily Archives :", 'movedo' );
			$page_title = get_the_time( 'l, F j, Y' );
			$page_reversed = 'reversed';
		} else if ( is_month() ) {
			$page_description = esc_html__( "Monthly Archives :", 'movedo' );
			$page_title = get_the_time( 'F Y' );
			$page_reversed = 'reversed';
		} else if ( is_year() ) {
			$page_description = esc_html__( "Yearly Archives :", 'movedo' );
			$page_title = get_the_time( 'Y' );
			$page_reversed = 'reversed';
		} else if ( is_post_type_archive( 'tribe_events' ) && movedo_grve_events_calendar_enabled() ) {
			$page_title = tribe_get_events_title("", false);
		} else if ( is_post_type_archive() ) {
			$page_title = post_type_archive_title("", false);
		} else {
			$page_title = esc_html__( "Archives", 'movedo' );
		}
	} else {
		$page_title = get_bloginfo( 'name' );
		$page_description = get_bloginfo( 'description' );
	}

	return array(
		'title' => $page_title,
		'description' => $page_description,
		'reversed' => $page_reversed,
	);


}

 /**
 * Check title visibility
 */
if ( !function_exists('movedo_grve_check_title_visibility') ) {
	function movedo_grve_check_title_visibility() {

		$blog_title = movedo_grve_option( 'blog_title', 'sitetitle' );

		if ( is_front_page() && is_home() ) {
			// Default homepage
			if ( 'none' == $blog_title ) {
				return false;
			}
		} elseif ( is_front_page() ) {
			// static homepage
			if ( 'yes' == movedo_grve_post_meta( '_movedo_grve_disable_title' ) || ( movedo_grve_is_woo_shop() && 'yes' == movedo_grve_post_meta_shop( '_movedo_grve_disable_title' ) ) ) {
				return false;
			}
		} elseif ( is_home() ) {
			// blog page
			if ( 'none' == $blog_title ) {
				return false;
			}
		} else {
			if ( ( is_singular() && 'yes' == movedo_grve_post_meta( '_movedo_grve_disable_title' ) ) || ( movedo_grve_is_woo_shop() && 'yes' == movedo_grve_post_meta_shop( '_movedo_grve_disable_title' ) ) ) {
				return false;
			}
		}

		return true;

	}
}

/**
 * Prints side Header Background Image
 */
if ( !function_exists('movedo_grve_print_side_header_bg_image') ) {

	function movedo_grve_print_side_header_bg_image() {

		if ( 'custom' == movedo_grve_option( 'header_side_bg_mode' ) ) {
			$movedo_grve_header_custom_bg = array(
				'bg_mode' => 'custom',
				'bg_image_id' => movedo_grve_option( 'header_side_bg_image', '', 'id' ),
				'bg_position' => movedo_grve_option( 'header_side_bg_position', 'center-center' ),
				'pattern_overlay' => movedo_grve_option( 'header_side_pattern_overlay' ),
				'color_overlay' => movedo_grve_option( 'header_side_color_overlay' ),
				'opacity_overlay' => movedo_grve_option( 'header_side_opacity_overlay' ),
			);
			movedo_grve_print_title_bg_image( $movedo_grve_header_custom_bg );
		}

	}
}

function movedo_grve_print_title_bg_image( $movedo_grve_page_title = array() ) {

	$image_url = '';
	$bg_mode = movedo_grve_array_value( $movedo_grve_page_title, 'bg_mode', 'color' );

	if ( 'color' != $bg_mode ) {

		$bg_position = movedo_grve_array_value( $movedo_grve_page_title, 'bg_position', 'center-center' );

		$media_id = '0';

		if ( 'featured' == $bg_mode ) {
			$movedo_grve_woo_shop = movedo_grve_is_woo_shop();
			if ( is_singular() || $movedo_grve_woo_shop ) {
				if ( $movedo_grve_woo_shop ) {
					$id = wc_get_page_id( 'shop' );
				} else {
					$id = get_the_ID();
				}
				if( has_post_thumbnail( $id ) ) {
					$media_id = get_post_thumbnail_id( $id );
				}
			}
		} else if ( 'custom' ) {
			$media_id = movedo_grve_array_value( $movedo_grve_page_title, 'bg_image_id' );
		}
		$full_src = wp_get_attachment_image_src( $media_id, 'movedo-grve-fullscreen' );
		$image_url = $full_src[0];

		if( !empty( $image_url ) ) {

			//Adaptive Background URL
			$image_url = movedo_grve_get_adaptive_url( $media_id );

			echo '<div class="grve-background-wrapper">';
			echo '<div class="grve-bg-image grve-bg-' . esc_attr( $bg_position ) . ' grve-bg-image-id-' . esc_attr( $media_id ) . '" style="background-image: url(' . esc_url( $image_url ) . ');"></div>';
			movedo_grve_print_overlay_container( $movedo_grve_page_title );
			echo '</div>';
		}
	}

}

 /**
 * Prints title/subtitle ( Page )
 */
function movedo_grve_print_header_title( $mode = 'page') {
	global $post;

	if ( movedo_grve_check_title_visibility() ) {

        $item_type = str_replace ( '_' , '-', $mode );
		$movedo_grve_page_title_id = 'grve-' . $item_type  . '-title';
		$movedo_grve_page_title = array(
			'height' => movedo_grve_option( $mode . '_title_height' ),
			'min_height' => movedo_grve_option( $mode . '_title_min_height' ),
			'subheading_color' => movedo_grve_option( $mode . '_subheading_color' ),
			'subheading_color_custom' => movedo_grve_option( $mode . '_subheading_color_custom' ),
			'title_color' => movedo_grve_option( $mode . '_title_color' ),
			'title_color_custom' => movedo_grve_option( $mode . '_title_color_custom' ),
			'caption_color' => movedo_grve_option( $mode . '_description_color' ),
			'caption_color_custom' => movedo_grve_option( $mode . '_description_color_custom' ),
			'content_bg_color' => movedo_grve_option( $mode . '_title_content_bg_color' ),
			'content_bg_color_custom' => movedo_grve_option( $mode . '_title_content_bg_color_custom' ),
			'content_position' => movedo_grve_option( $mode . '_title_content_position' ),
			'content_animation' => movedo_grve_option( $mode . '_title_content_animation' ),
			'container_size' => movedo_grve_option( $mode . '_title_container_size' ),
			'content_size' => movedo_grve_option( $mode . '_title_content_size' ),
			'content_alignment' => movedo_grve_option( $mode . '_title_content_alignment' ),
			'bg_mode' => movedo_grve_option( $mode . '_title_bg_mode' ),
			'bg_image_id' => movedo_grve_option( $mode . '_title_bg_image', '', 'id' ),
			'bg_position' => movedo_grve_option( $mode . '_title_bg_position' ),
			'bg_color' => movedo_grve_option( $mode . '_title_bg_color', 'dark' ),
			'bg_color_custom' => movedo_grve_option( $mode . '_title_bg_color_custom' ),
			'pattern_overlay' => movedo_grve_option( $mode . '_title_pattern_overlay' ),
			'color_overlay' => movedo_grve_option( $mode . '_title_color_overlay' ),
			'color_overlay_custom' => movedo_grve_option( $mode . '_title_color_overlay_custom' ),
			'opacity_overlay' => movedo_grve_option( $mode . '_title_opacity_overlay' ),
		);

		$header_data = movedo_grve_header_title();
		$header_title = isset( $header_data['title'] ) ? $header_data['title'] : '';
		$header_description = isset( $header_data['description'] ) ? $header_data['description'] : '';
		$header_reversed = isset( $header_data['reversed'] ) ? $header_data['reversed'] : '';

		if ( 'forum' == $mode && !is_singular() ) {
			$header_title = esc_html__( 'Forums' , 'movedo' );
		}

		$movedo_grve_woo_shop = movedo_grve_is_woo_shop();

		if ( is_singular() || $movedo_grve_woo_shop  ) {
			if ( $movedo_grve_woo_shop ) {
				$post_id = wc_get_page_id( 'shop' );
			} else {
				$post_id = $post->ID;
			}

			$movedo_grve_custom_title_options = get_post_meta( $post_id, '_movedo_grve_custom_title_options', true );
			$movedo_grve_title_style = movedo_grve_option( $mode . '_title_style' );
			$movedo_grve_page_title_custom = movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom', $movedo_grve_title_style );
			if ( 'custom' == $movedo_grve_page_title_custom ) {
				$movedo_grve_page_title = $movedo_grve_custom_title_options;
			} else if ( 'simple' == $movedo_grve_page_title_custom ) {
				return;
			}

		} else if ( is_tag() || is_category() || movedo_grve_is_woo_category() || movedo_grve_is_woo_tag() ) {
			$category_id = get_queried_object_id();
			$movedo_grve_custom_title_options = movedo_grve_get_term_meta( $category_id, '_movedo_grve_custom_title_options' );
			$movedo_grve_page_title_custom = movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom' );
			if ( 'custom' == $movedo_grve_page_title_custom ) {
				$movedo_grve_page_title = $movedo_grve_custom_title_options;
			}
		}

		$movedo_grve_wrapper_title_classes = array( 'grve-page-title' );

		$bg_mode = movedo_grve_array_value( $movedo_grve_page_title, 'bg_mode', 'color' );
		if ( 'color' == $bg_mode ) {
			$movedo_grve_wrapper_title_classes[] = 'grve-with-title';
		} else {
			$movedo_grve_wrapper_title_classes[] = 'grve-with-image';
		}

		$movedo_grve_content_container_classes = array( 'grve-content' );
		$movedo_grve_subheading_classes = array( 'grve-subheading', 'grve-title-categories', 'clearfix' );
		$movedo_grve_title_classes = array( 'grve-title', 'grve-with-line' );
		$movedo_grve_caption_classes = array( 'grve-description', 'clearfix' );
		$movedo_grve_title_meta_classes = array( 'grve-title-meta-content' );
		$movedo_grve_content_classes = array( 'grve-title-content-wrapper' );

		$content_position = movedo_grve_array_value( $movedo_grve_page_title, 'content_position', 'center-center' );
		$content_animation = movedo_grve_array_value( $movedo_grve_page_title, 'content_animation', 'fade-in' );
		$page_title_height = movedo_grve_array_value( $movedo_grve_page_title, 'height', '40' );
		$page_title_min_height = movedo_grve_array_value( $movedo_grve_page_title, 'min_height', '200' );

		$container_size = movedo_grve_array_value( $movedo_grve_page_title, 'container_size' );
		$movedo_grve_content_container_classes[] = 'grve-align-' . $content_position;
		if ( 'large' == $container_size ) {
			$movedo_grve_content_container_classes[] = 'grve-fullwidth';
		}

		if ( is_numeric( $page_title_height ) ) { //Custom Size
			$movedo_grve_wrapper_title_classes[] = 'grve-custom-size';
		} else {
			$movedo_grve_wrapper_title_classes[] = 'grve-' . $page_title_height . '-height';
		}

		$page_title_bg_color = movedo_grve_array_value( $movedo_grve_page_title, 'bg_color', 'dark' );
		if ( 'custom' != $page_title_bg_color ) {
			$movedo_grve_wrapper_title_classes[] = 'grve-bg-' . $page_title_bg_color;
		}

		$page_title_content_bg_color = movedo_grve_array_value( $movedo_grve_page_title, 'content_bg_color', 'none' );
		$content_align = movedo_grve_array_value( $movedo_grve_page_title, 'content_alignment', 'center' );
		$content_size = movedo_grve_array_value( $movedo_grve_page_title, 'content_size', 'large' );
		if ( 'custom' != $page_title_content_bg_color ) {
			$movedo_grve_content_classes[] = 'grve-bg-' . $page_title_content_bg_color;
		}
		$movedo_grve_content_classes[] = 'grve-align-' . $content_align;
		$movedo_grve_content_classes[] = 'grve-content-' . $content_size;

		$page_title_subheading_color = movedo_grve_array_value( $movedo_grve_page_title, 'subheading_color', 'light' );
		if ( 'custom' != $page_title_subheading_color ) {
			$movedo_grve_subheading_classes[] = 'grve-text-' . $page_title_subheading_color;
			$movedo_grve_title_meta_classes[] = 'grve-text-' . $page_title_subheading_color;
		}

		$page_title_color = movedo_grve_array_value( $movedo_grve_page_title, 'title_color', 'light' );
		if ( 'custom' != $page_title_color ) {
			$movedo_grve_title_classes[] = 'grve-text-' . $page_title_color;
		}

		$page_title_caption_color = movedo_grve_array_value( $movedo_grve_page_title, 'caption_color', 'light' );
		if ( 'custom' != $page_title_caption_color ) {
			$movedo_grve_caption_classes[] = 'grve-text-' . $page_title_caption_color;
		}

		$movedo_grve_wrapper_title_classes = implode( ' ', $movedo_grve_wrapper_title_classes );
		$movedo_grve_content_container_classes = implode( ' ', $movedo_grve_content_container_classes );
		$movedo_grve_title_classes = implode( ' ', $movedo_grve_title_classes );
		$movedo_grve_caption_classes = implode( ' ', $movedo_grve_caption_classes );
		$movedo_grve_subheading_classes = implode( ' ', $movedo_grve_subheading_classes );
		$movedo_grve_title_meta_classes = implode( ' ', $movedo_grve_title_meta_classes );
		$movedo_grve_content_classes = implode( ' ', $movedo_grve_content_classes );

		if ( is_numeric( $page_title_height ) ) { //Custom Size
			$movedo_grve_wrapper_style = 'height:' . esc_attr( $page_title_height ) . 'vh; min-height:' . esc_attr( $page_title_min_height ) . 'px;';
		} else {
			$movedo_grve_wrapper_style = 'min-height:' . esc_attr( $page_title_min_height ) . 'px;';
		}

		$title_tag = apply_filters( 'movedo_grve_header_title_tag', 'h1' );
		$description_tag = apply_filters( 'movedo_grve_header_description_tag', 'div' );
?>
	<!-- Page Title -->
	<div id="<?php echo esc_attr( $movedo_grve_page_title_id ); ?>" class="<?php echo esc_attr( $movedo_grve_wrapper_title_classes ); ?>" data-height="<?php echo esc_attr( $page_title_height ); ?>" style="min-height:<?php echo esc_attr( $page_title_min_height ); ?>px;">
		<div class="grve-wrapper clearfix" style="<?php echo esc_attr( $movedo_grve_wrapper_style ); ?>">
			<?php do_action( 'movedo_grve_page_title_top' ); ?>
			<div class="<?php echo esc_attr( $movedo_grve_content_container_classes ); ?>" data-animation="<?php echo esc_attr( $content_animation ); ?>">
				<div class="grve-container">
					<div class="<?php echo esc_attr( $movedo_grve_content_classes ); ?>">
					<?php if ( empty( $header_reversed ) ) { ?>

						<?php if( 'post' == $mode && movedo_grve_visibility( 'post_category_visibility', '1' ) ) { ?>
						<div class="<?php echo esc_attr( $movedo_grve_subheading_classes ); ?>">
							<?php movedo_grve_print_post_title_categories(); ?>
						</div>
						<?php } ?>

						<<?php echo tag_escape( $title_tag ); ?> class="<?php echo esc_attr( $movedo_grve_title_classes ); ?>"><span><?php echo wp_kses_post( $header_title ); ?></span></<?php echo tag_escape( $title_tag ); ?>>
						<?php if ( !empty( $header_description ) ) { ?>
						<<?php echo tag_escape( $description_tag ); ?>  class="<?php echo esc_attr( $movedo_grve_caption_classes ); ?>"><?php echo wp_kses_post( $header_description ); ?></<?php echo tag_escape( $description_tag ); ?> >
						<?php } ?>

						<?php if( 'post' == $mode ) { ?>
							<div class="<?php echo esc_attr( $movedo_grve_title_meta_classes ); ?>">
								<?php movedo_grve_print_post_title_meta(); ?>
							</div>
						<?php } ?>

					<?php } else { ?>
						<?php if ( !empty( $header_description ) ) { ?>
						<<?php echo tag_escape( $description_tag ); ?> class="<?php echo esc_attr( $movedo_grve_caption_classes ); ?>"><?php echo wp_kses_post( $header_description ); ?></<?php echo tag_escape( $description_tag ); ?> >
						<?php } ?>
						<<?php echo tag_escape( $title_tag ); ?> class="<?php echo esc_attr( $movedo_grve_title_classes ); ?>"><span><?php echo wp_kses_post( $header_title ); ?></span></<?php echo tag_escape( $title_tag ); ?>>
					<?php } ?>
					</div>
				</div>
			</div>
			<?php do_action( 'movedo_grve_page_title_bottom' ); ?>
		</div>
		<?php movedo_grve_print_title_bg_image( $movedo_grve_page_title ); ?>
	</div>
	<!-- End Page Title -->
<?php
	}
}

 /**
 * Prints Anchor Menu
 */
function movedo_grve_print_anchor_menu( $mode = 'page') {

	$item_type = str_replace ( '_' , '-', $mode );
	$movedo_grve_anchor_id = 'grve-' . $item_type  . '-anchor';

	if ( movedo_grve_is_woo_shop() ) {
		$anchor_nav_menu = movedo_grve_post_meta_shop( '_movedo_grve_anchor_navigation_menu' );
	} else {
		$anchor_nav_menu = movedo_grve_post_meta( '_movedo_grve_anchor_navigation_menu' );
	}

	if ( !empty( $anchor_nav_menu ) ) {

		$movedo_grve_anchor_fullwidth = movedo_grve_option( $mode . '_anchor_menu_fullwidth' );
		$movedo_grve_anchor_alignment = movedo_grve_option( $mode . '_anchor_menu_alignment', 'left' );

		$movedo_grve_anchor_classes = array( 'grve-anchor-menu' );
		if ( '1' == $movedo_grve_anchor_fullwidth ) {
			$movedo_grve_anchor_classes[] = ' grve-fullwidth';
		}
		$movedo_grve_anchor_classes[] = 'grve-align-' . $movedo_grve_anchor_alignment ;
		$movedo_grve_anchor_classes = implode( ' ', $movedo_grve_anchor_classes );
?>
		<!-- ANCHOR MENU -->
		<div id="<?php echo esc_attr( $movedo_grve_anchor_id ); ?>" class="<?php echo esc_attr( $movedo_grve_anchor_classes ); ?>">
			<div class="grve-wrapper grve-anchor-wrapper">
				<div class="grve-container">
					<a href="#grve-responsive-anchor" class="grve-toggle-hiddenarea grve-anchor-btn"><i class="grve-icon-menu"></i></a>
					<?php
					wp_nav_menu(
						array(
							'menu' => $anchor_nav_menu, /* menu id */
							'container' => false, /* no container */
							'walker' => new Movedo_Grve_Simple_Navigation_Walker(),
						)
					);
					?>
				</div>
			</div>
		</div>
		<!-- END ANCHOR MENU -->
<?php
	}
}


/**
 * Prints Responsive Anchor Menu
 */
function movedo_grve_print_responsive_anchor_menu() {

	$anchor_nav_menu = "";
	if ( is_singular() ) {
		$anchor_nav_menu = movedo_grve_post_meta( '_movedo_grve_anchor_navigation_menu' );
	} else if ( movedo_grve_is_woo_shop() ) {
		$anchor_nav_menu = movedo_grve_post_meta_shop( '_movedo_grve_anchor_navigation_menu' );
	}

	if ( !empty( $anchor_nav_menu ) ) {

?>
	<nav id="grve-responsive-anchor" class="grve-hidden-area grve-small-width grve-toggle-menu grve-align-left">
		<div class="grve-hiddenarea-wrapper">
			<!-- Close Button -->
			<div class="grve-close-btn-wrapper">
				<div class="grve-close-btn"><i class="grve-icon-close"></i></div>
			</div>
			<!-- End Close Button -->
			<div class="grve-hiddenarea-content">
				<div id="grve-responsive-anchor-menu-wrapper" class="grve-menu-wrapper">
					<?php
					wp_nav_menu(
						array(
							'menu' => $anchor_nav_menu, /* menu id */
							'menu_class' => 'grve-menu', /* menu class */
							'container' => false,
							'link_before' => '<span class="grve-item">',
							'link_after' => '</span>',
							'walker' => new Movedo_Grve_Main_Navigation_Walker(),
						)
					);
					?>
				</div>
			</div>
		</div>
	</nav>
<?php
	}

}

 /**
 * Prints header breadcrumbs
 */
function movedo_grve_print_header_breadcrumbs( $mode = 'page') {

	$movedo_grve_disable_breadcrumbs = 'yes';

	if( movedo_grve_visibility( $mode . '_breadcrumbs_enabled' ) ) {
		$movedo_grve_disable_breadcrumbs = 'no';
		if ( is_singular() ) {
			$movedo_grve_disable_breadcrumbs = movedo_grve_post_meta( '_movedo_grve_disable_breadcrumbs', $movedo_grve_disable_breadcrumbs );
		} else if( movedo_grve_is_woo_shop() ) {
			$movedo_grve_disable_breadcrumbs = movedo_grve_post_meta_shop( '_movedo_grve_disable_breadcrumbs', $movedo_grve_disable_breadcrumbs );
		}
	}

	if ( 'yes' != $movedo_grve_disable_breadcrumbs  ) {

		$item_type = str_replace ( '_' , '-', $mode );
		$movedo_grve_breadcrumbs_id = 'grve-' . $item_type  . '-breadcrumbs';
		$movedo_grve_breadcrumbs_fullwidth = movedo_grve_option( $mode . '_breadcrumbs_fullwidth' );
		$movedo_grve_breadcrumbs_alignment = movedo_grve_option( $mode . '_breadcrumbs_alignment', 'left' );

		$movedo_grve_breadcrumbs_classes = array( 'grve-breadcrumbs', 'clearfix' );
		if ( '1' == $movedo_grve_breadcrumbs_fullwidth ) {
			$movedo_grve_breadcrumbs_classes[] = ' grve-fullwidth';
		}
		$movedo_grve_breadcrumbs_classes[] = 'grve-align-' . $movedo_grve_breadcrumbs_alignment ;
		$movedo_grve_breadcrumbs_classes = implode( ' ', $movedo_grve_breadcrumbs_classes );
?>
	<div id="<?php echo esc_attr( $movedo_grve_breadcrumbs_id ); ?>" class="<?php echo esc_attr( $movedo_grve_breadcrumbs_classes ); ?>">
		<div class="grve-breadcrumbs-wrapper">
			<div class="grve-container">
				<?php movedo_grve_print_breadcrumbs(); ?>
			</div>
		</div>
	</div>
<?php
	}
}

/**
 * Prints header top bar text
 */
function movedo_grve_print_header_top_bar_text( $text ) {
	if ( !empty( $text ) ) {
?>
		<li class="grve-topbar-item"><p><?php echo do_shortcode( $text ); ?></p></li>
<?php
	}
}

/**
 * Prints header top bar navigation
 */
function movedo_grve_print_header_top_bar_nav( $position = 'left' ) {
?>
	<li class="grve-topbar-item">
		<nav class="grve-top-bar-menu grve-small-text grve-list-divider">
			<?php
				if( 'left' == $position ) {
					movedo_grve_top_left_nav();
				} else {
					movedo_grve_top_right_nav();
				}
			?>
		</nav>
	</li>
<?php
}

/**
 * Prints header top bar search icon
 */
function movedo_grve_print_header_top_bar_search( $position = 'left' ) {
?>
	<li class="grve-topbar-item"><a href="#grve-search-modal" class="grve-icon-search grve-toggle-modal"></a></li>
<?php
}

/**
 * Prints header top bar form icon
 */
function movedo_grve_print_header_top_bar_form( $position = 'left' ) {

	if( 'left' == $position ) {
		$modal_id = '#grve-top-left-form-modal';
	} else {
		$modal_id = '#grve-top-right-form-modal';
	}
?>
	<li class="grve-topbar-item"><a href="<?php echo esc_attr( $modal_id ); ?>" class="grve-icon-envelope grve-toggle-modal"></a></li>
<?php

}

/**
 * Prints header top bar socials
 */
function movedo_grve_print_header_top_bar_socials( $options ) {

	$social_options = movedo_grve_option('social_options');
	if ( !empty( $options ) && !empty( $social_options ) ) {
		?>
			<li class="grve-topbar-item">
				<ul class="grve-social">
		<?php
		foreach ( $social_options as $key => $value ) {
			if ( isset( $options[$key] ) && 1 == $options[$key] && $value ) {
				if ( 'skype' == $key ) {
					echo '<li><a href="' . esc_url( $value, array( 'skype', 'http', 'https' ) ) . '" class="fa fa-' . esc_attr( $key ) . '"></a></li>';
				} else {
					echo '<li><a href="' . esc_url( $value ) . '" target="_blank" class="fa fa-' . esc_attr( $key ) . '"></a></li>';
				}
			}
		}
		?>
				</ul>
			</li>
		<?php
	}

}

/**
 * Prints header top bar language selector
 */
function movedo_grve_print_header_top_bar_language_selector() {

	//start language selector output buffer
    ob_start();

	$languages = '';

	//Polylang
	if( function_exists( 'pll_the_languages' ) ) {
		$languages = pll_the_languages( array( 'raw'=>1 ) );

		$lang_option_current = $lang_options = '';

		foreach ( $languages as $l ) {

			if ( !$l['current_lang'] ) {
				$lang_options .= '<li>';
				$lang_options .= '<a href="' . esc_url( $l['url'] ) . '" class="grve-language-item">';
				$lang_options .= '<img src="' . esc_url( $l['flag'] ) . '" alt="' . esc_attr( $l['name'] ) . '"/>';
				$lang_options .= esc_html( $l['name'] );
				$lang_options .= '</a>';
				$lang_options .= '</li>';
			} else {
				$lang_option_current .= '<a href="#" class="grve-language-item">';
				$lang_option_current .= '<img src="' . esc_url( $l['flag'] ) . '" alt="' . esc_attr( $l['name'] ) . '"/>';
				$lang_option_current .= esc_html( $l['name'] );
				$lang_option_current .= '</a>';
			}
		}

	}

	//WPML
	if ( defined( 'ICL_SITEPRESS_VERSION' ) && defined( 'ICL_LANGUAGE_CODE' ) ) {

		$languages = icl_get_languages( 'skip_missing=0' );
		if ( ! empty( $languages ) ) {

			$lang_option_current = $lang_options = '';

			foreach ( $languages as $l ) {

				if ( !$l['active'] ) {
					$lang_options .= '<li>';
					$lang_options .= '<a href="' . esc_url( $l['url'] ) . '" class="grve-language-item">';
					$lang_options .= '<img src="' . esc_url( $l['country_flag_url'] ) . '" alt="' . esc_attr( $l['language_code'] ) . '"/>';
					$lang_options .= esc_html( $l['native_name'] );
					$lang_options .= '</a>';
					$lang_options .= '</li>';
				} else {
					$lang_option_current .= '<a href="#" class="grve-language-item">';
					$lang_option_current .= '<img src="' . esc_url( $l['country_flag_url'] ) . '" alt="' . esc_attr( $l['language_code'] ) . '"/>';
					$lang_option_current .= esc_html( $l['native_name'] );
					$lang_option_current .= '</a>';
				}
			}
		}
	}
	if ( ! empty( $languages ) ) {

?>
	<li class="grve-topbar-item">
		<ul class="grve-language grve-small-text">
			<li>
				<?php echo wp_kses_post( $lang_option_current ); ?>
				<ul>
					<?php echo wp_kses_post( $lang_options ); ?>
				</ul>
			</li>
		</ul>
	</li>
<?php
	}
	//store the language selector buffer and clean
	$movedo_grve_lang_selector_out = ob_get_clean();
	echo apply_filters( 'movedo_grve_header_top_bar_language_selector', $movedo_grve_lang_selector_out );
}

/**
 * Prints header top bar login
 */
function movedo_grve_print_header_top_bar_login() {
	$login_custom_link_url = movedo_grve_option( 'login_custom_link_url' );
	$login_mode = movedo_grve_option( 'login_mode', 'modal' );
	if ( 'custom-link' == $login_mode ) {
?>
	<li class="grve-topbar-item"><a href="<?php echo esc_url( $login_custom_link_url ); ?>" class="grve-icon-user"></a></li>
<?php
	} else {
?>
	<li class="grve-topbar-item"><a href="#grve-login-modal" class="grve-icon-user grve-toggle-modal"></a></li>
<?php
	}
}


/**
 * Prints header top bar
 */
function movedo_grve_print_header_top_bar() {

	if ( movedo_grve_visibility( 'top_bar_enabled' ) ) {
		if ( ( is_singular() && 'yes' == movedo_grve_post_meta( '_movedo_grve_disable_top_bar' ) ) || ( movedo_grve_is_woo_shop() && 'yes' == movedo_grve_post_meta_shop( '_movedo_grve_disable_top_bar' ) ) ) {
			return;
		}

		$section_type = movedo_grve_option( 'top_bar_section_type', 'fullwidth-background' );
		$header_mode = movedo_grve_option( 'header_mode', 'default' );
		$header_sticky_enable = movedo_grve_option( 'header_sticky_enabled', 0 );
		$header_sticky_devices_enabled = movedo_grve_option( 'header_sticky_devices_enabled', 0 );
		$top_bar_class = array('');
		if( 'fullwidth-element' == $section_type ) {
			$top_bar_class[] = 'grve-fullwidth';
		}
		if( $header_sticky_enable && 'side' != $header_mode ) {
			$top_bar_class[] = 'grve-sticky-topbar';
		}
		if( $header_sticky_devices_enabled ) {
			$top_bar_class[] = 'grve-device-sticky-topbar';
		}
		$top_bar_classes = implode( ' ', $top_bar_class );
?>

		<!-- Top Bar -->
		<div id="grve-top-bar" class="<?php echo esc_attr( $top_bar_classes ); ?>">
			<div class="grve-top-bar-wrapper grve-wrapper clearfix">
				<div class="grve-container">

					<?php
					if ( movedo_grve_visibility( 'top_bar_left_enabled' ) ) {
					?>
					<ul class="grve-bar-content grve-left-side">
						<?php

							//Top Left First Item Hook
							do_action( 'movedo_grve_header_top_bar_left_first_item' );

							//Top Left Options
							$top_bar_left_options = movedo_grve_option('top_bar_left_options');

							if ( !empty( $top_bar_left_options ) ) {
								foreach ( $top_bar_left_options as $key => $value ) {
									if( !empty( $value ) && '0' != $value ) {

										switch( $key ) {
											case 'menu':
												movedo_grve_print_header_top_bar_nav( 'left' );
											break;
											case 'search':
												movedo_grve_print_header_top_bar_search( 'left' );
											break;
											case 'form':
												movedo_grve_print_header_top_bar_form( 'left' );
											break;
											case 'text':
												$movedo_grve_left_text = movedo_grve_option('top_bar_left_text');
												movedo_grve_print_header_top_bar_text( $movedo_grve_left_text );
											break;
											case 'language':
												movedo_grve_print_header_top_bar_language_selector();
											break;
											case 'login':
												movedo_grve_print_header_top_bar_login();
											break;
											case 'social':
												$top_bar_left_social_options = movedo_grve_option('top_bar_left_social_options');
												movedo_grve_print_header_top_bar_socials( $top_bar_left_social_options);
											break;
											default:
											break;
										}
									}
								}
							}

							//Top Left Last Item Hook
							do_action( 'movedo_grve_header_top_bar_left_last_item' );

						?>
					</ul>
					<?php
						}
					?>

					<?php
					if ( movedo_grve_visibility( 'top_bar_right_enabled' ) ) {
					?>
					<ul class="grve-bar-content grve-right-side">
						<?php

							//Top Right First Item Hook
							do_action( 'movedo_grve_header_top_bar_right_first_item' );

							//Top Right Options
							$top_bar_right_options = movedo_grve_option('top_bar_right_options');
							if ( !empty( $top_bar_right_options ) ) {
								foreach ( $top_bar_right_options as $key => $value ) {
									if( !empty( $value ) && '0' != $value ) {

										switch( $key ) {
											case 'menu':
												movedo_grve_print_header_top_bar_nav( 'right' );
											break;
											case 'search':
												movedo_grve_print_header_top_bar_search( 'right' );
											break;
											case 'form':
												movedo_grve_print_header_top_bar_form( 'right' );
											break;
											case 'text':
												$movedo_grve_right_text = movedo_grve_option('top_bar_right_text');
												movedo_grve_print_header_top_bar_text( $movedo_grve_right_text );
											break;
											case 'language':
												movedo_grve_print_header_top_bar_language_selector();
											break;
											case 'login':
												movedo_grve_print_header_top_bar_login();
											break;
											case 'social':
												$top_bar_right_social_options = movedo_grve_option('top_bar_right_social_options');
												movedo_grve_print_header_top_bar_socials( $top_bar_right_social_options );
											break;
											default:
											break;
										}
									}
								}
							}

							//Top Right Last Item Hook
							do_action( 'movedo_grve_header_top_bar_right_last_item' );

						?>


					</ul>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		<!-- End Top Bar -->
<?php

	}
}

/**
 * Prints check header elements visibility
 */
function movedo_grve_check_header_elements_visibility_any() {

	if ( !movedo_grve_visibility( 'header_menu_options_enabled' ) ) {
		return false;
	}

	$header_menu_options = movedo_grve_option('header_menu_options');
	if ( !empty( $header_menu_options ) ) {
		foreach ( $header_menu_options as $key => $value ) {
			if( !empty( $value ) && '0' != $value && movedo_grve_check_header_elements_visibility( $key ) ) {
				return true;
			}
		}
	}
	return false;
}

function movedo_grve_check_header_elements_visibility( $item = 'none' ) {

	$visibility = false;

	if ( movedo_grve_visibility( 'header_menu_options_enabled' ) ) {

		if ( is_singular() ) {
			$movedo_grve_disable_menu_items = movedo_grve_post_meta( '_movedo_grve_disable_menu_items' );
			if ( 'yes' == movedo_grve_array_value( $movedo_grve_disable_menu_items, $item  ) ) {
				return false;
			}
		}
		if ( movedo_grve_is_woo_shop() ) {
			$movedo_grve_disable_menu_items = movedo_grve_post_meta_shop( '_movedo_grve_disable_menu_items' );
			if ( 'yes' == movedo_grve_array_value( $movedo_grve_disable_menu_items, $item  ) ) {
				return false;
			}
		}

		$header_menu_options = movedo_grve_option('header_menu_options');
		if ( !empty( $header_menu_options ) ) {
			if ( isset( $header_menu_options[ $item ] ) && !empty( $header_menu_options[ $item ] ) && '0' != $header_menu_options[ $item ] ) {
				$visibility = true;
			}
		}

	}

	return $visibility;
}

/**
 * Prints header Safe Button
 */
function movedo_grve_print_header_safebutton( $mode = '') {

	//Disable if Scrolling Section
	if ( is_page_template( 'page-templates/template-full-page.php' ) ) {
		return;
	}

	$movedo_area_id = movedo_grve_option('header_safebutton_area');
	if ( is_singular() ) {
		$movedo_area_id = movedo_grve_post_meta( '_movedo_grve_safe_button_area', $movedo_area_id );
	}
	if( movedo_grve_is_woo_shop() ) {
		$movedo_area_id = movedo_grve_post_meta_shop( '_movedo_grve_safe_button_area', $movedo_area_id );
	}
	if ( !empty( $movedo_area_id ) && 'none' != $movedo_area_id ) {
	?>
			<?php if ( empty( $mode ) ) { ?>
			<!-- Safe Button -->

			<div class="grve-header-elements grve-safe-button-element grve-position-left">
				<div class="grve-wrapper">
					<ul>
			<?php } ?>
						<li class="grve-header-element">
							<a href="#grve-toggle-menu" class="grve-safe-button">
								<span class="grve-item">
								<?php
									ob_start();
								?>
									<svg class="grve-safe-btn-icon" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
										<g>
											<rect class="grve-btn-point-1" x="12" y="12" width="8" height="8" />
											<rect class="grve-btn-point-2" x="28" y="12" width="8" height="8" />
											<rect class="grve-btn-point-3" x="44" y="12" width="8" height="8" />
											<rect class="grve-btn-point-4" x="12" y="28" width="8" height="8" />
											<rect class="grve-btn-point-5" x="28" y="28" width="8" height="8" />
											<rect class="grve-btn-point-6" x="44" y="28" width="8" height="8" />
											<rect class="grve-btn-point-7" x="12" y="44" width="8" height="8" />
											<rect class="grve-btn-point-8" x="28" y="44" width="8" height="8" />
											<rect class="grve-btn-point-9" x="44" y="44" width="8" height="8" />

										</g>
									</svg>
								<?php
									$movedo_grve_safe_btn_icon = ob_get_clean();
									echo apply_filters( 'movedo_grve_safe_btn_icon', $movedo_grve_safe_btn_icon );
								?>
								</span>
							</a>
						</li>
			<?php if ( empty( $mode ) ) { ?>
					</ul>
				</div>
			</div>
			<!-- End Safe Button -->
			<?php } ?>
	<?php
	}
}


/**
 * Prints header elements e.g: social, language selector, search
 */
function movedo_grve_print_header_elements( $movedo_grve_sidearea_data = '') {

	if ( movedo_grve_check_header_elements_visibility_any() ) {

		$header_menu_options = movedo_grve_option('header_menu_options');
		$movedo_grve_header_mode = movedo_grve_option( 'header_mode', 'default' );

		$align = '';
		if ( 'side' != $movedo_grve_header_mode ) {
			$align = 'grve-position-left';
		}

?>
		<!-- Header Elements -->
		<div class="grve-header-elements <?php echo esc_attr( $align ); ?>">
			<div class="grve-wrapper">
				<ul>
<?php

			if ( !empty( $movedo_grve_sidearea_data ) ) {
				movedo_grve_print_header_sidearea_button( $movedo_grve_sidearea_data, 'list' );
				movedo_grve_print_header_safebutton( 'list' );
			}
			$header_menu_social_mode = movedo_grve_option('header_menu_social_mode', 'modal');
			do_action( 'movedo_grve_header_elements_first_item' );

			if ( !empty( $header_menu_options ) ) {
				foreach ( $header_menu_options as $key => $value ) {
					if( !empty( $value ) && '0' != $value && movedo_grve_check_header_elements_visibility( $key ) ) {
						if ( 'search' == $key ) {
						?>
							<li class="grve-header-element"><a href="#grve-search-modal" class="grve-toggle-modal"><span class="grve-item"><i class="grve-icon-search"></i></span></a></li>
						<?php
						} else if ( 'language' == $key ) {
						?>
							<li class="grve-header-element"><a href="#grve-language-modal" class="grve-toggle-modal"><span class="grve-item"><i class="grve-icon-globe"></i></span></a></li>
						<?php
						} else if ( 'login' == $key ) {
							$login_custom_link_url = movedo_grve_option( 'login_custom_link_url' );
							$login_mode = movedo_grve_option( 'login_mode', 'modal' );
							if ( 'custom-link' == $login_mode ) {
						?>
							<li class="grve-header-element"><a href="<?php echo esc_url( $login_custom_link_url ); ?>"><span class="grve-item"><i class="grve-icon-user"></i></span></a></li>
						<?php
							} else {
						?>
							<li class="grve-header-element"><a href="#grve-login-modal" class="grve-toggle-modal"><span class="grve-item"><i class="grve-icon-user"></i></span></a></li>
						<?php
							}
						} else if ( 'form' == $key ) {
						?>
							<li class="grve-header-element"><a href="#grve-menu-form-modal" class="grve-toggle-modal"><span class="grve-item"><i class="grve-icon-envelope"></i></span></a></li>
						<?php
						} else if ( 'cart' == $key && movedo_grve_woocommerce_enabled() ) {
							global $woocommerce;
						?>
							<li class="grve-header-element">
								<a href="#grve-cart-area" class="grve-toggle-hiddenarea">
									<span class="grve-item">
										<i class="grve-icon-shop"></i>
									</span>
								</a>
								<span class="grve-purchased-items"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
							</li>
						<?php
						} else if ( 'social' == $key ) {
							$header_social_options = movedo_grve_option('header_menu_social_options');
							$social_options = movedo_grve_option('social_options');
							if( 'modal' == $header_menu_social_mode ) {
						?>
							<li class="grve-header-element"><a href="#grve-socials-modal" class="grve-toggle-modal"><span class="grve-item"><i class="grve-icon-socials"></i></span></a></li>
						<?php
							} else {

								if ( !empty( $header_social_options ) && !empty( $social_options ) ) {

									foreach ( $social_options as $key => $value ) {
										if ( isset( $header_social_options[$key] ) && 1 == $header_social_options[$key] && $value ) {
											if ( 'skype' == $key ) {
												echo '<li class="grve-header-element"><a href="' . esc_url( $value, array( 'skype', 'http', 'https' ) ) . '"><span class="grve-item"><i class="fa fa-' . esc_attr( $key ) . '"></i></span></a></li>';
											} else {
												echo '<li class="grve-header-element"><a href="' . esc_url( $value ) . '" target="_blank"><span class="grve-item"><i class="fa fa-' . esc_attr( $key ) . '"></i></span></a></li>';
											}
										}
									}

								}

							}
						}
					}
				}
			}

			do_action( 'movedo_grve_header_elements_last_item' );
?>
				</ul>
			</div>
		</div>
		<!-- End Header Elements -->
<?php
	}

}


/**
 * Check header Text Visibility
 */
function movedo_grve_header_text_visibility() {
	if ( is_singular() ) {
		if ( 'yes' == movedo_grve_post_meta( '_movedo_grve_disable_header_text' ) ) {
			return false;
		}
	}
	if ( movedo_grve_is_woo_shop() ) {
		if ( 'yes' == movedo_grve_post_meta_shop( '_movedo_grve_disable_header_text' ) ) {
			return false;
		}
	}
	return true;
}

/**
 * Prints header Text
 */
function movedo_grve_print_header_text() {

	$header_menu_text_element = movedo_grve_option('header_menu_text_element');

	if ( movedo_grve_header_text_visibility() && !empty( $header_menu_text_element ) ) {
	?>
		<div class="grve-header-elements grve-header-text-element grve-position-left">
			<div class="grve-wrapper">
				<div class="grve-item">
					<?php echo do_shortcode( $header_menu_text_element ); ?>
				</div>
			</div>
		</div>
	<?php
	}
}


/**
 * Prints header elements e.g: social, language selector, search
 */
function movedo_grve_print_header_elements_responsive() {

	if ( movedo_grve_check_header_elements_visibility_any() ) {
		$header_menu_options = movedo_grve_option('header_menu_options');
		$header_menu_text_element = movedo_grve_option('header_menu_text_element');

		do_action( 'movedo_grve_header_elements_responsive_first_item' );

		foreach ( $header_menu_options as $key => $value ) {
			if( !empty( $value ) && '0' != $value && movedo_grve_check_header_elements_visibility( $key ) ) {
				if ( 'search' == $key ) {
				?>
					<div class="grve-header-responsive-elements">
						<div class="grve-wrapper">
							<div class="grve-widget">
								<?php get_search_form(); ?>
							</div>
						</div>
					</div>
				<?php
				} else if ( 'language' == $key ) {
				?>
					<div class="grve-header-responsive-elements">
						<div class="grve-wrapper">
							<?php movedo_grve_print_language_modal_selector(); ?>
						</div>
					</div>
				<?php
				} else if ( 'form' == $key ) {
				?>
					<div class="grve-header-responsive-elements">
						<div class="grve-wrapper">
							<div class="grve-newsletter">
								<?php movedo_grve_print_contact_form( 'header_menu_form' ); ?>
							</div>
						</div>
					</div>
				<?php
				} else if ( 'social' == $key ) {
					$header_social_options = movedo_grve_option('header_menu_social_options');
					$social_options = movedo_grve_option('social_options');
					if ( !empty( $header_social_options ) && !empty( $social_options ) ) {
?>
						<!-- Responsive social Header Elements -->
						<div class="grve-header-responsive-elements">
							<div class="grve-wrapper">
								<ul>
<?php
									foreach ( $social_options as $key => $value ) {
										if ( isset( $header_social_options[$key] ) && 1 == $header_social_options[$key] && $value ) {
											if ( 'skype' == $key ) {
												echo '<li class="grve-header-responsive-element"><a href="' . esc_url( $value, array( 'skype', 'http', 'https' ) ) . '"><span class="grve-item"><i class="fa fa-' . esc_attr( $key ) . '"></i></span></a></li>';
											} else {
												echo '<li class="grve-header-responsive-element"><a href="' . esc_url( $value ) . '" target="_blank"><span class="grve-item"><i class="fa fa-' . esc_attr( $key ) . '"></i></span></a></li>';
											}
										}
									}
?>
								</ul>
							</div>
						</div>
						<!-- End Social Header Elements -->
<?php
					}
				}
			}
		}

		if ( movedo_grve_header_text_visibility() && !empty( $header_menu_text_element ) ) {
		?>
			<div class="grve-header-responsive-elements">
				<div class="grve-wrapper">
						<?php echo do_shortcode( $header_menu_text_element ); ?>
				</div>
			</div>
		<?php
		}

		do_action( 'movedo_grve_header_elements_responsive_last_item' );
	}

}



/**
 * Prints Form modals
 */
function movedo_grve_print_contact_form( $option = 'header_menu_form' ) {

	if ( movedo_grve_is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		$contact_form_id = movedo_grve_option( $option );
		if ( !empty( $contact_form_id ) ) {
			echo do_shortcode('[contact-form-7 id="' . esc_attr( $contact_form_id ) . '"]');
		}
	}

}

function movedo_grve_print_gravity_form( $option = 'header_menu_gravity_form' ) {

	if ( movedo_grve_is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
		$contact_form_id = movedo_grve_option( $option );
		if ( !empty( $contact_form_id ) ) {
			echo do_shortcode('[gravityform id="' . esc_attr( $contact_form_id ) . '" title="false" description="false" ajax="true"]');
		}
	}

}

function movedo_grve_print_form_modals() {
	$movedo_grve_close_cursor_color = movedo_grve_option( 'modal_cursor_color_color', 'dark' );
	$movedo_grve_left_type_form = movedo_grve_option( 'top_bar_left_type_form', 'contact-form' );
	$movedo_grve_right_type_form = movedo_grve_option( 'top_bar_right_type_form', 'contact-form' );
	$movedo_grve_header_menu_type_form = movedo_grve_option( 'header_menu_type_form', 'contact-form' );


?>
		<div id="grve-top-left-form-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
			<div class="grve-modal-wrapper">
				<div class="grve-modal-content">
					<div class="grve-modal-form">
						<div class="grve-modal-item">
							<?php
								if( 'gravity-form' == $movedo_grve_left_type_form ) {
									movedo_grve_print_gravity_form( 'top_bar_left_gravity_form' );
								} else {
									movedo_grve_print_contact_form( 'top_bar_left_form' );
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="grve-top-right-form-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
			<div class="grve-modal-wrapper">
				<div class="grve-modal-content">
					<div class="grve-modal-form">
						<div class="grve-modal-item">
							<?php
								if( 'gravity-form' == $movedo_grve_right_type_form ) {
									movedo_grve_print_gravity_form( 'top_bar_right_gravity_form' );
								} else {
									movedo_grve_print_contact_form( 'top_bar_right_form' );
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="grve-menu-form-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
			<div class="grve-modal-wrapper">
				<div class="grve-modal-content">
					<div class="grve-modal-form">
						<div class="grve-modal-item">
							<?php
								if( 'gravity-form' == $movedo_grve_header_menu_type_form ) {
									movedo_grve_print_gravity_form( 'header_menu_gravity_form' );
								} else {
									movedo_grve_print_contact_form( 'header_menu_form' );
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
}

/**
 * Prints Search modal
 */
function movedo_grve_print_search_modal() {

		$movedo_grve_close_cursor_color = movedo_grve_option( 'modal_cursor_color_color', 'dark' );
		$form = '';
?>
		<div id="grve-search-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
			<div class="grve-modal-wrapper">
				<div class="grve-modal-content">
					<div class="grve-modal-item">
						<?php echo movedo_grve_modal_wpsearch( $form ); ?>
					</div>
				</div>
			</div>
		</div>
<?php

}

/**
 * Prints header language selector
 * WPML/Polylang is required
 * Can be used to add custom php code for other translation flags.
 */
if( !function_exists( 'movedo_grve_print_language_modal_selector' ) ) {
	function movedo_grve_print_language_modal_selector() {

		//start language selector output buffer
		ob_start();
?>
		<ul class="grve-language">
<?php
		//Polylang
		if( function_exists( 'pll_the_languages' ) ) {
			$languages = pll_the_languages( array( 'raw'=>1 ) );
			if ( ! empty( $languages ) ) {
				foreach ( $languages as $l ) {
					echo '<li>';
					if ( !$l['current_lang'] ) {
						echo '<a href="' . esc_url( $l['url'] ) . '" class="grve-link-text">';
					} else {
						echo '<a href="#" class="grve-link-text active">';
					}
					echo esc_html( $l['name'] );

					echo '</a></li>';
				}
			}
		}

		//WPML
		if ( defined( 'ICL_SITEPRESS_VERSION' ) && defined( 'ICL_LANGUAGE_CODE' ) ) {
			$languages = icl_get_languages( 'skip_missing=0' );
			if ( ! empty( $languages ) ) {
				foreach ( $languages as $l ) {
					echo '<li>';
					if ( !$l['active'] ) {
						echo '<a href="' . esc_url( $l['url'] ) . '" class="grve-link-text">';
					} else {
						echo '<a href="#" class="grve-link-text active">';
					}
					echo esc_html( $l['native_name'] );

					echo '</a></li>';
				}
			}
		}
?>
		</ul>
<?php
		//store the language selector buffer and clean
		$movedo_grve_lang_selector_out = ob_get_clean();
		echo apply_filters( 'movedo_grve_language_modal_selector', $movedo_grve_lang_selector_out );
	}
}

function movedo_grve_print_language_modal() {
	$movedo_grve_close_cursor_color = movedo_grve_option( 'modal_cursor_color_color', 'dark' );
?>
	<div id="grve-language-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
		<div class="grve-modal-wrapper">
			<div class="grve-modal-content">
				<div class="grve-modal-item">
					<?php movedo_grve_print_language_modal_selector(); ?>
				</div>
			</div>
		</div>
	</div>
<?php

}

function movedo_grve_print_login_modal() {
	$movedo_grve_close_cursor_color = movedo_grve_option( 'modal_cursor_color_color', 'dark' );
	$movedo_login_mode = movedo_grve_option( 'login_mode', 'modal' );
	if ( 'modal' == $movedo_login_mode ) {
?>
	<div id="grve-login-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
		<div class="grve-modal-wrapper">
			<div class="grve-modal-content">
				<div class="grve-modal-item">
					<?php get_template_part( 'templates/modal', 'login' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php
	}

}

/**
 * Prints header login responsive button
 */
function movedo_grve_print_login_responsive_button() {

	if( movedo_grve_check_header_elements_visibility( 'login' ) ) {
?>
		<div class="grve-header-elements grve-position-left">
			<div class="grve-wrapper">
				<ul>
					<li class="grve-header-element">
					<?php
						$login_custom_link_url = movedo_grve_option( 'login_custom_link_url' );
						$login_mode = movedo_grve_option( 'login_mode', 'modal' );
						if ( 'custom-link' == $login_mode ) {
					?>
						<a href="<?php echo esc_url( $login_custom_link_url ); ?>">
							<span class="grve-item"><i class="grve-icon-user"></i></span>
						</a>
					<?php
						} else {
					?>
						<a href="#grve-login-modal" class="grve-toggle-modal">
							<span class="grve-item"><i class="grve-icon-user"></i></span>
						</a>
					<?php
						}
					?>
					</li>
				</ul>
			</div>
		</div>
<?php

	}
}

function movedo_grve_print_social_modal() {

	$header_menu_options = movedo_grve_option('header_menu_options');
	$header_menu_social_mode = movedo_grve_option('header_menu_social_mode', 'modal');
	$show_social_modal = false;
	$movedo_grve_close_cursor_color = movedo_grve_option( 'modal_cursor_color_color', 'dark' );

	if ( !empty( $header_menu_options ) ) {
		if ( isset( $header_menu_options['social'] ) && !empty( $header_menu_options['social'] ) && '0' != $header_menu_options['social'] ) {
			if( 'modal' == $header_menu_social_mode ) {
				$show_social_modal = true;
			}
		}
	}


	if( $show_social_modal ) {

?>
	<div id="grve-socials-modal" class="grve-modal grve-<?php echo esc_attr( $movedo_grve_close_cursor_color ); ?>-cursor">
		<div class="grve-modal-wrapper">
			<div class="grve-modal-content grve-align-center">
				<div class="grve-modal-item">
		<?php
				$header_social_options = movedo_grve_option('header_menu_social_options');
				$social_options = movedo_grve_option('social_options');

					if ( !empty( $header_social_options ) && !empty( $social_options ) ) {
		?>
					<ul class="grve-social">
		<?php

						foreach ( $social_options as $key => $value ) {
							if ( isset( $header_social_options[$key] ) && 1 == $header_social_options[$key] && $value ) {
								if ( 'skype' == $key ) {
									echo '<li><a href="' . esc_url( $value, array( 'skype', 'http', 'https' ) ) . '" class="fa fa-' . esc_attr( $key ) . '"></a></li>';
								} else {
									echo '<li><a href="' . esc_url( $value ) . '" target="_blank" class="fa fa-' . esc_attr( $key ) . '"></a></li>';
								}
							}
						}
		?>
					</ul>
		<?php
					}

		?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
}

/**
 * Gets side area data
 */
function movedo_grve_get_sidearea_data() {

	$movedo_grve_sidebar_visibility = 'no';
	$movedo_grve_sidebar_id = '';

	if ( ! is_singular() ) {
		//Overview Pages
		if( movedo_grve_woocommerce_enabled() && is_woocommerce() ) {
			if ( is_shop() && !is_search() ) {
				$movedo_grve_sidebar_visibility =  movedo_grve_post_meta_shop( '_movedo_grve_sidearea_visibility', movedo_grve_option( 'page_sidearea_visibility' ) );
				$movedo_grve_sidebar_id = movedo_grve_post_meta_shop( '_movedo_grve_sidearea_sidebar', movedo_grve_option( 'page_sidearea_sidebar' ) );
			} else {
				$movedo_grve_sidebar_visibility = movedo_grve_option( 'product_tax_sidearea_visibility' );
				$movedo_grve_sidebar_id = movedo_grve_option( 'product_tax_sidearea_sidebar' );
			}
		} elseif ( movedo_grve_events_calendar_is_overview() ) {
				$movedo_grve_sidebar_visibility = movedo_grve_option( 'event_tax_sidearea_visibility' );
				$movedo_grve_sidebar_id = movedo_grve_option( 'event_tax_sidearea_sidebar' );
		} else {
			$movedo_grve_sidebar_visibility = movedo_grve_option( 'blog_sidearea_visibility' );
			$movedo_grve_sidebar_id = movedo_grve_option( 'blog_sidearea_sidebar' );
		}
	} else {

		global $post;
		$post_id = $post->ID;
		$post_type = get_post_type( $post_id );

		switch( $post_type ) {
			case 'product':
				$movedo_grve_sidebar_visibility =  movedo_grve_post_meta( '_movedo_grve_sidearea_visibility', movedo_grve_option( 'product_sidearea_visibility' ) );
				$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidearea_sidebar', movedo_grve_option( 'product_sidearea_sidebar' ) );
			break;
			case 'portfolio':
				$movedo_grve_sidebar_visibility =  movedo_grve_post_meta( '_movedo_grve_sidearea_visibility', movedo_grve_option( 'portfolio_sidearea_visibility' ) );
				$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidearea_sidebar', movedo_grve_option( 'portfolio_sidearea_sidebar' ) );
			break;
			case 'post':
				$movedo_grve_sidebar_visibility =  movedo_grve_post_meta( '_movedo_grve_sidearea_visibility', movedo_grve_option( 'post_sidearea_visibility' ) );
				$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidearea_sidebar', movedo_grve_option( 'post_sidearea_sidebar' ) );
			break;
			case 'tribe_events':
				$movedo_grve_sidebar_visibility =  movedo_grve_post_meta( '_movedo_grve_sidearea_visibility', movedo_grve_option( 'event_sidearea_visibility' ) );
				$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidearea_sidebar', movedo_grve_option( 'event_sidearea_sidebar' ) );
			break;
			case 'page':
			default:
				$movedo_grve_sidebar_visibility =  movedo_grve_post_meta( '_movedo_grve_sidearea_visibility', movedo_grve_option( 'page_sidearea_visibility' ) );
				$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidearea_sidebar', movedo_grve_option( 'page_sidearea_sidebar' ) );
			break;
		}
	}

	if( movedo_grve_is_bbpress() ) {
		$movedo_grve_sidebar_visibility = movedo_grve_option( 'forum_sidearea_visibility' );
		$movedo_grve_sidebar_id = movedo_grve_option( 'forum_sidearea_sidebar' );
	}

	return array(
		'visibility' => $movedo_grve_sidebar_visibility,
		'sidebar' => $movedo_grve_sidebar_id,
	);
}

/**
 * Prints header side area toggle button
 */
function movedo_grve_print_header_sidearea_button( $sidearea_data, $mode = '' ) {

	$movedo_grve_sidebar_visibility = $sidearea_data['visibility'];
	$movedo_grve_sidebar_id = $sidearea_data['sidebar'];

	if ( 'yes' == $movedo_grve_sidebar_visibility ) {
		if ( 'list' == $mode ) {
?>
		<li class="grve-header-element">
			<a href="#grve-sidearea" class="grve-sidearea-btn grve-toggle-hiddenarea">
				<span class="grve-item"><i class="grve-icon-safebutton"></i></span>
			</a>
		</li>
<?php
		} else {
?>
		<div class="grve-header-elements grve-position-left">
			<div class="grve-wrapper">
				<ul>
					<li class="grve-header-element">
						<a href="#grve-sidearea" class="grve-sidearea-btn grve-toggle-hiddenarea">
							<span class="grve-item"><i class="grve-icon-safebutton"></i></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
<?php
		}
	}
}

/**
 * Prints header hidden area toggle button
 */
function movedo_grve_print_header_hiddenarea_button() {
	$movedo_grve_responsive_menu_selection = movedo_grve_option( 'menu_responsive_toggle_selection', 'icon' );
	$movedo_grve_responsive_menu_text = movedo_grve_option( 'menu_responsive_toggle_text');
?>
	<div class="grve-hidden-menu-btn grve-position-right">
		<div class="grve-header-element">
			<a href="#grve-hidden-menu" class="grve-toggle-hiddenarea">
				<?php if ( 'icon' == $movedo_grve_responsive_menu_selection ) { ?>
				<span class="grve-item">
					<i class="grve-icon-menu"></i>
				</span>
				<?php } else { ?>
				<span class="grve-item grve-with-text">
					<span class="grve-label">
						<?php echo esc_html( $movedo_grve_responsive_menu_text ); ?>
					</span>
				</span>
				<?php } ?>
			</a>
		</div>
	</div>
<?php

}

/**
 * Prints Side Area
 */
function movedo_grve_print_side_area( $sidearea_data ) {

	$movedo_grve_sidebar_visibility = $sidearea_data['visibility'];
	$movedo_grve_sidebar_id = $sidearea_data['sidebar'];

	if ( 'yes' == $movedo_grve_sidebar_visibility ) {
?>
	<aside id="grve-sidearea" class="grve-hidden-area">
		<div class="grve-hiddenarea-wrapper">
			<!-- Close Button -->
			<div class="grve-close-btn-wrapper">
				<div class="grve-close-btn"><i class="grve-icon-close"></i></div>
			</div>
			<!-- End Close Button -->
			<div class="grve-hiddenarea-content">
				<?php
					if( is_active_sidebar( $movedo_grve_sidebar_id ) ) {
						dynamic_sidebar( $movedo_grve_sidebar_id );
					} else {
						if( current_user_can( 'administrator' ) ) {
							echo esc_html__( 'No widgets found in Side Area!', 'movedo'  ) . "<br/>" .
							"<a href='" . esc_url( admin_url() ) . "widgets.php'>" .
							esc_html__( "Activate Widgets", 'movedo' ) .
							"</a>";
						}
					}
				?>
			</div>

		</div>
	</aside>
<?php
	}
}

/**
 * Prints Shop Cart Responsive link
 */
function movedo_grve_print_cart_responsive_link() {

	if ( movedo_grve_woocommerce_enabled() && movedo_grve_check_header_elements_visibility( 'cart' ) ) {

		global $woocommerce;

		if ( function_exists( 'wc_get_cart_url' ) ) {
			$get_cart_url = wc_get_cart_url();
		} else {
			$get_cart_url = WC()->cart->get_cart_url();
		}
?>
		<div class="grve-header-elements grve-position-right">
			<div class="grve-wrapper">
				<ul>
					<li class="grve-header-element">
						<a href="<?php echo esc_url( $get_cart_url ); ?>">
							<span class="grve-item">
								<i class="grve-icon-shop"></i>
							</span>
						</a>
						<span class="grve-purchased-items"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
					</li>
				</ul>
			</div>
		</div>

<?php

	}
}

/**
 * Prints Shop Cart
 */
function movedo_grve_print_cart_area() {

	if ( movedo_grve_woocommerce_enabled() && movedo_grve_check_header_elements_visibility( 'cart' ) ) {

?>

		<div id="grve-cart-area" class="grve-hidden-area">
			<div class="grve-hiddenarea-wrapper">
				<!-- Close Button -->
				<div class="grve-close-btn-wrapper">
					<div class="grve-close-btn"><i class="grve-icon-close"></i></div>
				</div>
				<!-- End Close Button -->
				<div class="grve-hiddenarea-content">
					<div class="grve-shopping-cart-content"></div>
				</div>
			</div>
		</div>

<?php
	}

}

/**
 * Prints Hidden Menu
 */
function movedo_grve_print_hidden_menu() {

	$movedo_grve_hidden_menu_classes = array('grve-hidden-area');
	$movedo_grve_menu_open_type = movedo_grve_option( 'menu_responsive_open_type', 'toggle' );
	$movedo_grve_menu_width = movedo_grve_option( 'menu_responsive_width', 'small' );
	$movedo_grve_menu_align = movedo_grve_option( 'menu_responsive_align', 'left' );
	$movedo_grve_hidden_menu_classes[] = 'grve-' . $movedo_grve_menu_width . '-width';
	$movedo_grve_hidden_menu_classes[] = 'grve-' . $movedo_grve_menu_open_type . '-menu';
	$movedo_grve_hidden_menu_classes[] = 'grve-align-' . $movedo_grve_menu_align;
	$movedo_grve_hidden_menu_classes = implode( ' ', $movedo_grve_hidden_menu_classes );

	$movedo_grve_menu_text = movedo_grve_option( 'menu_responsive_text' );
?>
	<nav id="grve-hidden-menu" class="<?php echo esc_attr( $movedo_grve_hidden_menu_classes ); ?>">
		<div class="grve-hiddenarea-wrapper">
			<!-- Close Button -->
			<div class="grve-close-btn-wrapper">
				<div class="grve-close-btn"><i class="grve-icon-close"></i></div>
			</div>
			<!-- End Close Button -->
			<div class="grve-hiddenarea-content">
				<?php
					$movedo_grve_responsive_menu = movedo_grve_get_responsive_nav();
					if ( 'disabled' != $movedo_grve_responsive_menu && ( !empty( $movedo_grve_responsive_menu ) || has_nav_menu( 'movedo_responsive_nav' ) ) ) {
				?>
				<div id="grve-responsive-menu-wrapper" class="grve-menu-wrapper">
					<?php movedo_grve_responsive_nav( $movedo_grve_responsive_menu ); ?>
				</div>
				<?php
						$hidden_wrapper_id = 'grve-responsive-hidden-menu-wrapper';
					} else {
						$hidden_wrapper_id = 'grve-hidden-menu-wrapper';
					}
				?>

				<div id="<?php echo esc_attr( $hidden_wrapper_id ); ?>" class="grve-menu-wrapper">
					<?php
						$movedo_grve_main_menu = movedo_grve_get_header_nav();
						if ( 'disabled' != $movedo_grve_main_menu ) {
							movedo_grve_header_nav( $movedo_grve_main_menu );
						}
					?>
				</div>

				<?php if ( !empty( $movedo_grve_menu_text ) ) { ?>
				<div class="grve-hidden-menu-text">
					<?php echo do_shortcode( $movedo_grve_menu_text ); ?>
				</div>
				<?php } ?>
				<?php movedo_grve_print_header_elements_responsive(); ?>
			</div>

		</div>
	</nav>
<?php

}

function movedo_grve_print_item_nav_link( $post_id,  $direction, $title = '' ) {

	$icon_class = 'arrow-right';
	if ( 'prev' == $direction ) {
		$icon_class = 'arrow-left';
	}
?>
	<li><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="grve-icon-<?php echo esc_attr( $icon_class ); ?>" title="<?php echo esc_attr($title); ?>"></a></li>
<?php
}


/**
 * Check Theme Loader Visibility
 */
function movedo_grve_check_theme_loader_visibility() {

	$movedo_grve_theme_loader = '';

	if ( is_singular() ) {
		$movedo_grve_theme_loader = movedo_grve_post_meta( '_movedo_grve_theme_loader' );
	}
	if ( movedo_grve_is_woo_shop() ) {
		$movedo_grve_theme_loader = movedo_grve_post_meta_shop( '_movedo_grve_theme_loader' );
	}

	if( empty( $movedo_grve_theme_loader ) ) {
		return movedo_grve_visibility( 'theme_loader' );
	} else {
		if ( 'yes' == $movedo_grve_theme_loader ) {
			return true;
		} else {
			return false;
		}
	}

}


/**
 * Prints Theme Loader
 */
function movedo_grve_print_theme_loader() {
	$page_transition = movedo_grve_option('page_transition');
	$show_spinner = movedo_grve_option('show_spinner');

	$movedo_grve_loader_classes = array();
	if( 'none' != $page_transition ) {
		$movedo_grve_loader_classes[] = 'grve-page-transition';
		$movedo_grve_loader_classes[] = 'grve-' . $page_transition . '-transition';
	}

	$movedo_grve_loader_classes = implode( ' ', $movedo_grve_loader_classes );

	if ( movedo_grve_check_theme_loader_visibility() ) {
?>
	<!-- LOADER -->
	<div id="grve-loader-overflow" class="<?php echo esc_attr( $movedo_grve_loader_classes ); ?>">
		<?php if( '0' != $show_spinner ) { ?>
		<div class="grve-spinner"></div>
		<?php } ?>
	</div>
<?php
	}
}

/**
 * Prints Safe Button Area
 */
function movedo_grve_print_safebutton_area() {

	//Disable if Scrolling Section
	if ( is_page_template( 'page-templates/template-full-page.php' ) ) {
		return;
	}

	$movedo_area_id = movedo_grve_option('header_safebutton_area');
	if ( is_singular() ) {
		$movedo_area_id = movedo_grve_post_meta( '_movedo_grve_safe_button_area', $movedo_area_id );
	}
	if( movedo_grve_is_woo_shop() ) {
		$movedo_area_id = movedo_grve_post_meta_shop( '_movedo_grve_safe_button_area', $movedo_area_id );
	}
	if ( !empty( $movedo_area_id ) && 'none' != $movedo_area_id ) {
		$movedo_content = get_post_field( 'post_content', $movedo_area_id );

		$movedo_safebutton_layers = movedo_grve_option( 'safebutton_layers', 3 );
		$movedo_safebutton_image_id = movedo_grve_option( 'safebutton_image', '', 'id' );

		$layer_1_color = movedo_grve_option( 'safebutton_layer_1_color', "#0652FD" );
		$layer_2_color = movedo_grve_option( 'safebutton_layer_2_color', "#000000" );
		$layer_3_color = movedo_grve_option( 'safebutton_layer_3_color', "#ffffff" );
		$movedo_data_mask_colors = $layer_1_color . "," . $layer_2_color . "," . $layer_3_color;



?>
	<div id="grve-safebutton-area">
		<?php movedo_grve_print_logo( 'movedo-sticky' , 'left' ); ?>
		<div class="grve-close-button-wrapper grve-position-right">
			<a href="#" class="grve-close-button"><span class="grve-item"><i class="grve-icon-close"></i></span></a>
		</div>
		<div class="grve-safebutton-wrapper">
			<?php echo apply_filters( 'movedo_grve_the_content', $movedo_content ); ?>
		</div>
	</div>
	<div class="grve-mask-wrapper" data-layers="<?php echo esc_attr( $movedo_safebutton_layers ); ?>" data-mask-colors="<?php echo esc_attr( $movedo_data_mask_colors ); ?>">
	<?php
		if( !empty( $movedo_safebutton_image_id ) ) {
			echo '<div class="grve-safebutton-logo">' . wp_get_attachment_image( $movedo_safebutton_image_id, 'full' ) . '</div>';
		}
	?>
	</div>
<?php
	}

}

function movedo_grve_safebutton_area_css() {

	//Disable if Scrolling Section
	if ( is_page_template( 'page-templates/template-full-page.php' ) ) {
		return;
	}

	$movedo_area_id = movedo_grve_option('header_safebutton_area');
	if ( is_singular() ) {
		$movedo_area_id = movedo_grve_post_meta( '_movedo_grve_safe_button_area', $movedo_area_id );
	}
	if( movedo_grve_is_woo_shop() ) {
		$movedo_area_id = movedo_grve_post_meta_shop( '_movedo_grve_safe_button_area', $movedo_area_id );
	}
	if ( !empty( $movedo_area_id ) && 'none' != $movedo_area_id ) {
		$custom_css_code = get_post_meta( $movedo_area_id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $custom_css_code ) ) {
			$custom_css_code = strip_tags( $custom_css_code );
			wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $custom_css_code ) );
		}
	}
}

function movedo_grve_bottom_bar_area_css() {
	$movedo_area_id = movedo_grve_option('bottom_bar_area');
	if ( is_singular() ) {
		$movedo_area_id = movedo_grve_post_meta( '_movedo_grve_bottom_bar_area', $movedo_area_id );
	}
	if( movedo_grve_is_woo_shop() ) {
		$movedo_area_id = movedo_grve_post_meta_shop( '_movedo_grve_bottom_bar_area', $movedo_area_id );
	}
	if ( !empty( $movedo_area_id ) && 'none' != $movedo_area_id ) {
		$custom_css_code = get_post_meta( $movedo_area_id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $custom_css_code ) ) {
			$custom_css_code = strip_tags( $custom_css_code );
			wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $custom_css_code ) );
		}
	}
}

function movedo_grve_shop_css() {
	$movedo_shop_id = '';
	if ( movedo_grve_woocommerce_enabled() && is_shop() ) {
		$movedo_shop_id = wc_get_page_id( 'shop' );
	}
	if ( !empty( $movedo_shop_id ) ) {
		$custom_css_code = get_post_meta( $movedo_shop_id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $custom_css_code ) ) {
			$custom_css_code = strip_tags( $custom_css_code );
			wp_add_inline_style( 'movedo-grve-custom-style', movedo_grve_compress_css( $custom_css_code ) );
		}
	}
}

/**
 * Prints Tracking code
 */
add_action('wp_head', 'movedo_grve_print_tracking_code');
if ( !function_exists('movedo_grve_print_tracking_code') ) {

	function movedo_grve_print_tracking_code() {
		$tracking_code = movedo_grve_option( 'tracking_code' );
		if ( !empty( $tracking_code ) ) {
			echo "" . $tracking_code;
		}
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
