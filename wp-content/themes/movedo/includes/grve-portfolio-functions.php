<?php

/*
*	Portfolio Helper functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


/**
 * Prints portfolio feature image
 */
function movedo_grve_print_portfolio_feature_image( $image_size = 'large', $second_image_id = "" ) {

	if( empty( $second_image_id ) ) {
		if ( has_post_thumbnail() ) {
?>
		<div class="grve-media clearfix">
			<?php the_post_thumbnail( $image_size ); ?>
		</div>
<?php

		}
	} else {
?>
		<div class="grve-media clearfix">
			<?php echo wp_get_attachment_image( $second_image_id, $image_size ); ?>
		</div>
<?php

	}



}

/**
 * Prints Portfolio socials if used
 */
function movedo_grve_print_portfolio_media() {
	global $post;
	$post_id = $post->ID;

	$portfolio_media = movedo_grve_post_meta( '_movedo_grve_portfolio_media_selection' );
	$portfolio_image_mode = movedo_grve_post_meta( '_movedo_grve_portfolio_media_image_mode' );
	$portfolio_media_fullwidth = movedo_grve_post_meta( '_movedo_grve_portfolio_media_fullwidth' );
	$image_size_slider = 'movedo-grve-large-rect-horizontal';
	if ( 'resize' == $portfolio_image_mode || 'yes' == $portfolio_media_fullwidth ) {
		if( movedo_grve_option( 'has_sidebar' ) ) {
			$image_size_slider = "medium_large";
			if ( 'yes' == $portfolio_media_fullwidth ) {
				$image_size_slider = "large";
			}
		} else {
			$image_size_slider = "movedo-grve-fullscreen";
		}
	}

	switch( $portfolio_media ) {

		case 'slider':
			$slider_items = movedo_grve_post_meta( '_movedo_grve_portfolio_slider_items' );
			movedo_grve_print_gallery_slider( 'slider', $slider_items, $image_size_slider );
			break;
		case 'gallery':
			$slider_items = movedo_grve_post_meta( '_movedo_grve_portfolio_slider_items' );
			movedo_grve_print_gallery_slider( 'gallery', $slider_items, '', 'grve-classic-style' );
			break;
		case 'gallery-vertical':
			$slider_items = movedo_grve_post_meta( '_movedo_grve_portfolio_slider_items' );
			movedo_grve_print_gallery_slider( 'gallery-vertical', $slider_items, $image_size_slider, 'grve-vertical-style' );
			break;
		case 'video':
			movedo_grve_print_portfolio_video();
			break;
		case 'video-html5':
			movedo_grve_print_portfolio_video( 'html5' );
			break;
		case 'video-code':
			movedo_grve_print_portfolio_video( 'code' );
			break;
		case 'none':
			break;
		default:
			if( movedo_grve_option( 'has_sidebar' ) ) {
				$image_size = "medium_large";
				if ( 'yes' == $portfolio_media_fullwidth ) {
					$image_size = "large";
				}
			} else {
				$image_size = "movedo-grve-fullscreen";
			}

			$second_image = movedo_grve_post_meta( '_movedo_grve_second_featured_image' );
			if ( 'second-image' == $portfolio_media ) {
				if( !empty( $second_image ) ) {
					movedo_grve_print_portfolio_feature_image( $image_size, $second_image );
				}
			} else {
				movedo_grve_print_portfolio_feature_image( $image_size );
			}

			break;

	}
}


/**
 * Prints video of the portfolio media
 */
function movedo_grve_print_portfolio_video( $video_mode = '' ) {

	$video_webm = movedo_grve_post_meta( '_movedo_grve_portfolio_video_webm' );
	$video_mp4 = movedo_grve_post_meta( '_movedo_grve_portfolio_video_mp4' );
	$video_ogv = movedo_grve_post_meta( '_movedo_grve_portfolio_video_ogv' );
	$video_poster = movedo_grve_post_meta( '_movedo_grve_portfolio_video_poster' );
	$video_embed = movedo_grve_post_meta( '_movedo_grve_portfolio_video_embed' );

	if( 'code' == $video_mode ) {
		$video_embed = movedo_grve_post_meta( '_movedo_grve_portfolio_video_code' );
	}

	movedo_grve_print_media_video( $video_mode, $video_webm, $video_mp4, $video_ogv, $video_embed, $video_poster );
}

 /**
 * Prints portfolio like counter
 */
function movedo_grve_print_portfolio_like_counter( $counter_color = 'content' ) {

	$post_likes = movedo_grve_option( 'portfolio_social', '', 'grve-likes' );
	if ( !empty( $post_likes  ) ) {
		global $post;
		$post_id = $post->ID;
		$active = movedo_grve_likes( $post_id, 'status' );
		$icon = 'fa fa-heart-o';
		if( 'active' == $active ) {
			$icon = 'fa fa-heart';
		}
?>
		<div class="grve-like-counter grve-link-text grve-text-<?php echo esc_attr( $counter_color ); ?>"><i class="<?php echo esc_attr( $icon ); ?>"></i><span><?php echo movedo_grve_likes( $post_id ); ?></span></div>
<?php
	}

}


/**
 * Check Portfolio details if used
 */

function movedo_grve_check_portfolio_details() {
	global $post;
	$post_id = $post->ID;

	$grve_portfolio_details = movedo_grve_post_meta( '_movedo_grve_details', '' );
	$portfolio_fields = get_the_terms( $post_id, 'portfolio_field' );
	if ( !empty( $grve_portfolio_details ) || ! empty( $portfolio_fields ) ) {
		return true;
	}
	return false;

}

/**
 * Prints Portfolio details
 */
if ( !function_exists('movedo_grve_print_portfolio_details') ) {
	function movedo_grve_print_portfolio_details() {
		global $post;
		$post_id = $post->ID;

		$heading_tag = movedo_grve_option( 'portfolio_details_heading_tag', 'div' );
		$grve_portfolio_details_title = movedo_grve_post_meta( '_movedo_grve_details_title', movedo_grve_option( 'portfolio_details_text' ) );
		$grve_portfolio_details = movedo_grve_post_meta( '_movedo_grve_details', '' );
		$portfolio_fields = get_the_terms( $post_id, 'portfolio_field' );

		$link_text = movedo_grve_post_meta( '_movedo_grve_details_link_text', movedo_grve_option( 'portfolio_details_link_text' ) );
		$link_url = movedo_grve_post_meta( '_movedo_grve_details_link_url' );
		$link_new_window = movedo_grve_post_meta( '_movedo_grve_details_link_new_window' );
		$link_extra_class = movedo_grve_post_meta( '_movedo_grve_details_link_extra_class' );

		$grve_portfolio_details_classes = array( 'grve-portfolio-description', 'grve-border' );
		if( empty( $link_url ) && !empty( $portfolio_fields ) ){
			array_push( $grve_portfolio_details_classes,  'grve-margin-bottom-1x' );
		}
		$grve_portfolio_details_class_string = implode( ' ', $grve_portfolio_details_classes );

		$link_classes = array( 'grve-portfolio-details-btn', 'grve-btn' );
		if( !empty( $link_extra_class ) ){
			array_push( $link_classes,  $link_extra_class );
		}
		if ( ! empty( $portfolio_fields ) ) {
			array_push( $link_classes,  'grve-margin-bottom-2x' );
		}
		$link_class_string = implode( ' ', $link_classes );

	?>

		<!-- Portfolio Info -->
		<div class="grve-portfolio-info grve-border">
			<?php
			if ( !empty( $grve_portfolio_details ) ) {
			?>
			<!-- Portfolio Description -->
			<div class="<?php echo esc_attr( $grve_portfolio_details_class_string ); ?>">
				<<?php echo tag_escape( $heading_tag ); ?> class="grve-h5"><?php echo wp_kses_post( $grve_portfolio_details_title ); ?></<?php echo tag_escape( $heading_tag ); ?>>
				<p><?php echo do_shortcode( wp_kses_post( $grve_portfolio_details ) ) ?></p>
				<?php
					// Portfolio Link
					if( !empty( $link_url )  ) {
						$link_target = "_self";
						if( !empty( $link_new_window )  ) {
							$link_target = "_blank";
						}
					?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="<?php echo esc_attr( $link_class_string ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_text ); ?></a>
					<?php
					}
					?>
			</div>
			<!-- End Portfolio Description -->
			<?php
			}
			?>
			<?php
			if ( ! empty( $portfolio_fields ) ) {
			?>
			<!-- Fields -->
			<ul class="grve-portfolio-fields grve-border">
				<?php
					foreach( $portfolio_fields as $field ) {
						echo '<li class="grve-fields-title grve-heading-color">';
						if ( !empty( $field->description ) ) {
							echo '<span class="grve-fields-description grve-small-text">' . wp_kses_post( $field->description ) . '</span>';
						}
						echo '<span class="grve-link-text">' . esc_html( $field->name ) . '</span>';
						echo '</li>';
					}
				?>
			</ul>
			<!-- End Fields -->
			<?php
			}
			?>
		</div>
		<!-- End Portfolio Info -->
	<?php

	}
}

/**
 * Prints Portfolio Recents items. ( Classic Layout )
 */
function movedo_grve_print_recent_portfolio_items_classic() {

	$exclude_ids = array( get_the_ID() );
	$args = array(
		'post_type' => 'portfolio',
		'post_status'=>'publish',
		'post__not_in' => $exclude_ids ,
		'posts_per_page' => 3,
		'paged' => 1,
	);


	$query = new WP_Query( $args );

	$grve_portfolio_recent_title = movedo_grve_option( 'portfolio_recent_title' );

	if ( $query->have_posts() ) {
?>

	<!-- Related -->
	<div id="grve-portfolio-related" class="grve-related grve-singular-section grve-fullwidth-background clearfix" style="margin-bottom: 5.000rem;">
		<div class="grve-container">
			<div class="grve-wrapper">
				<?php if( !empty( $grve_portfolio_recent_title ) ) { ?>
				<div class="grve-related-title grve-h4"><?php echo esc_html( $grve_portfolio_recent_title); ?></div>
				<?php } ?>
				<div class="grve-row grve-columns-gap-30">
				<?php
					if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
						get_template_part( 'templates/portfolio', 'recent' );
					endwhile;
					else :
					endif;
				?>
				</div>
			</div>
		</div>
	</div>
	<!-- End Related -->
<?php
		wp_reset_postdata();
	}
}

/**
 * Prints Portfolio Recents items. ( Movedo Layout )
 */
function movedo_grve_print_recent_portfolio_items_movedo() {

	$exclude_ids = array( get_the_ID() );
	$args = array(
		'post_type' => 'portfolio',
		'post_status'=>'publish',
		'post__not_in' => $exclude_ids ,
		'posts_per_page' => 2,
		'paged' => 1,
	);


	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
?>

	<!-- Related -->
	<div class="grve-post-bar-item grve-post-related">
		<?php
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				get_template_part( 'templates/portfolio', 'recent' );
			endwhile;
			else :
			endif;
		?>
	</div>
	<!-- End Related -->
<?php
		wp_reset_postdata();
	}
}


/**
 * Prints Portfolio Feature Image
 */
function movedo_grve_print_portfolio_image( $image_size = 'movedo-grve-small-square', $mode = '', $atts = array() ) {

	if ( has_post_thumbnail() ) {
		$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$attachment_src = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
		$image_src = $attachment_src[0];
		if ( 'link' == $mode ){
			echo esc_url( $image_src );
		} else {
			if ( 'color' == $mode ){
				$image_src = get_template_directory_uri() . '/images/transparent/' . $image_size . '.png';
?>
				<img src="<?php echo esc_url( $image_src ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr( $attachment_src[1] ); ?>" height="<?php echo esc_attr( $attachment_src[2] ); ?>"/>
<?php
			} else {
				echo wp_get_attachment_image( $post_thumbnail_id, $image_size, '', $atts );
			}

		}
	} else {
		$image_src = get_template_directory_uri() . '/images/empty/' . $image_size . '.jpg';
		if ( 'link' == $mode ){
			echo esc_url( $image_src );
		} else {
			if ( 'color' == $mode ){
				$image_src = get_template_directory_uri() . '/images/transparent/' . $image_size . '.png';
			}
?>
		<img src="<?php echo esc_url( $image_src ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>"/>
<?php
		}
	}

}


/**
 * Prints Navigation Bar
 */
function movedo_grve_print_portfolio_bar() {

	$layout = movedo_grve_option( 'portfolio_nav_bar_layout', 'layout-1' );

	$portfolio_nav_section = $portfolio_social_section = $portfolio_recent_section = false;
	$portfolio_sections = 0;
	if ( movedo_grve_nav_bar( 'portfolio', 'check' ) ) {
		$portfolio_nav_section = true;
		$portfolio_sections++;
	}

	if( movedo_grve_social_bar( 'portfolio', 'check' ) ) {
		$portfolio_social_section = true;
		$portfolio_sections++;
	}
	$grve_disable_portfolio_recent = movedo_grve_post_meta( '_movedo_grve_disable_recent_entries' );
	if ( movedo_grve_visibility( 'portfolio_recents_visibility' ) && 'yes' != $grve_disable_portfolio_recent ) {

		if( 'layout-1' == $layout || 'layout-3' == $layout ) {
			movedo_grve_print_recent_portfolio_items_classic();
		} else {
			$portfolio_recent_section = true;
			$portfolio_sections++;
		}
	}

	if ( $portfolio_nav_section || $portfolio_social_section || $portfolio_recent_section ) {
		// Navigation Bar Classes

		$navigation_bar_classes = array( 'grve-navigation-bar', 'grve-singular-section', 'grve-fullwidth' );

		if( 'layout-3' == $layout ) {
			array_push( $navigation_bar_classes, 'grve-layout-3' );
		} else {
			array_push( $navigation_bar_classes, 'grve-' . $layout );
			array_push( $navigation_bar_classes, 'clearfix' );
			array_push( $navigation_bar_classes, 'grve-nav-columns-' . $portfolio_sections );
		}

		$navigation_bar_class_string = implode( ' ', $navigation_bar_classes );

	?>
			<!-- Navigation Bar -->
			<div id="grve-portfolio-bar" class="<?php echo esc_attr( $navigation_bar_class_string ); ?>">
				<div class="grve-container">
					<div class="grve-bar-wrapper">
						<?php if ( $portfolio_nav_section ) { ?>
						<?php movedo_grve_nav_bar( 'portfolio', $layout ); ?>
						<?php } ?>
						<?php if ( $portfolio_social_section ) { ?>
							<?php movedo_grve_social_bar( 'portfolio', $layout ); ?>
						<?php } ?>
						<?php if ( $portfolio_recent_section ) { ?>
							<?php movedo_grve_print_recent_portfolio_items_movedo(); ?>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- End Navigation Bar -->
	<?php
	}
}



//Omit closing PHP tag to avoid accidental whitespace output errors.
