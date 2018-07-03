<?php

/*
*	Layout Helper functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

/**
 * Function to fetch sidebar class
 */
function movedo_grve_sidebar_class( $sidebar_view = '' ) {

	if( is_search() ) {
		return '';
	}
	$movedo_grve_sidebar_class = "";
	$movedo_grve_sidebar_extra_content = false;

	if ( 'forum' == $sidebar_view ) {
		$movedo_grve_sidebar_id = movedo_grve_option( 'forum_sidebar' );
		$movedo_grve_sidebar_layout = movedo_grve_option( 'forum_layout', 'none' );
	} else if ( 'shop' == $sidebar_view ) {
		if ( is_shop() ) {
			$movedo_grve_sidebar_id = movedo_grve_post_meta_shop( '_movedo_grve_sidebar', movedo_grve_option( 'page_sidebar' ) );
			$movedo_grve_sidebar_layout = movedo_grve_post_meta_shop( '_movedo_grve_layout', movedo_grve_option( 'page_layout', 'none' ) );
		} else if( is_product() ) {
			$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'product_sidebar' ) );
			$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'product_layout', 'none' ) );
		} else {
			$movedo_grve_sidebar_id = movedo_grve_option( 'product_tax_sidebar' );
			$movedo_grve_sidebar_layout = movedo_grve_option( 'product_tax_layout', 'none' );
		}
	} else if ( 'event' == $sidebar_view ) {
		if ( is_singular( 'tribe_events' ) ) {
			$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'event_sidebar' ) );
			$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'event_layout', 'none' ) );
		} else {
			$movedo_grve_sidebar_id = movedo_grve_option( 'event_tax_sidebar' );
			$movedo_grve_sidebar_layout = movedo_grve_option( 'event_tax_layout', 'none' );
		}
	} else if ( is_singular() ) {
		if ( is_singular( 'post' ) ) {
			$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'post_sidebar' ) );
			$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'post_layout', 'none' ) );
		} else if ( is_singular( 'portfolio' ) ) {
			$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'portfolio_sidebar' ) );
			$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'portfolio_layout', 'none' ) );
			$movedo_grve_sidebar_extra_content = movedo_grve_check_portfolio_details();
			if( $movedo_grve_sidebar_extra_content && 'none' == $movedo_grve_sidebar_layout ) {
				$movedo_grve_sidebar_layout = 'right';
			}
		} else {
			$movedo_grve_sidebar_id = movedo_grve_post_meta( '_movedo_grve_sidebar', movedo_grve_option( 'page_sidebar' ) );
			$movedo_grve_sidebar_layout = movedo_grve_post_meta( '_movedo_grve_layout', movedo_grve_option( 'page_layout', 'none' ) );
		}
	} else {
		$movedo_grve_sidebar_id = movedo_grve_option( 'blog_sidebar' );
		$movedo_grve_sidebar_layout = movedo_grve_option( 'blog_layout', 'none' );
	}

	if ( 'none' != $movedo_grve_sidebar_layout && ( is_active_sidebar( $movedo_grve_sidebar_id ) || $movedo_grve_sidebar_extra_content ) ) {

		if ( 'right' == $movedo_grve_sidebar_layout ) {
			$movedo_grve_sidebar_class = 'grve-right-sidebar';
		} else if ( 'left' == $movedo_grve_sidebar_layout ) {
			$movedo_grve_sidebar_class = 'grve-left-sidebar';
		}

	}

	if( !empty( $movedo_grve_sidebar_class ) ) {
		global $movedo_grve_options;
		$movedo_grve_options['has_sidebar'] = "1";
	}

	return $movedo_grve_sidebar_class;

}


/**
 * Navigation Bar
 */

if ( !function_exists('movedo_grve_nav_bar') ) {

	function movedo_grve_nav_bar( $post_type = 'post', $mode = '') {

		global $post;

		$has_nav_section = false;

		if ( 'product' == $post_type ) {
			$grve_in_same_term = movedo_grve_option( 'product_nav_same_term' );
			if( $grve_in_same_term ) {
				$grve_in_same_term = true;
			} else {
				$grve_in_same_term = false;
			}
			$prev_post = get_adjacent_post( $grve_in_same_term, '', true, 'product_cat');
			$next_post = get_adjacent_post( $grve_in_same_term, '', false, 'product_cat' );

			if ( movedo_grve_visibility( 'product_nav_visibility', '1' )  && ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) ) {
				$has_nav_section = true;
			}
		} elseif( 'portfolio' == $post_type ) {
			$grve_nav_term = movedo_grve_option( 'portfolio_nav_term', 'none' );
			if( 'none' != $grve_nav_term ) {
				$grve_in_same_term = true;
			} else {
				$grve_in_same_term = false;
				$grve_nav_term = 'portfolio_category';
			}
			$prev_post = get_adjacent_post( $grve_in_same_term, '', true, $grve_nav_term );
			$next_post = get_adjacent_post( $grve_in_same_term, '', false, $grve_nav_term );
			if ( movedo_grve_visibility( 'portfolio_nav_visibility', '1' )  && ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) ) {
				$has_nav_section = true;
			}
		} elseif( 'event' == $post_type && movedo_grve_events_calendar_enabled() ) {
			$prev_post = Tribe__Events__Main::instance()->get_closest_event( $post, 'previous' ) ;
			$next_post = Tribe__Events__Main::instance()->get_closest_event( $post, 'next' ) ;
			if ( movedo_grve_visibility( 'event_nav_visibility', '1' )  && ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) ) {
				$has_nav_section = true;
			}
		} else {
			$grve_in_same_term = movedo_grve_visibility( 'post_nav_same_term', '0' );
			$prev_post = get_adjacent_post( $grve_in_same_term, '', true);
			$next_post = get_adjacent_post( $grve_in_same_term, '', false);
			if ( movedo_grve_visibility( 'post_nav_visibility', '1' )  && ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) ) {
				$has_nav_section = true;
			}
		}


		if ( 'check' == $mode ) {
			return $has_nav_section;
		}

		$grve_backlink = $grve_backlink_url = $grve_backlink_title = '';
		if ( 'portfolio' == $post_type ) {
			$grve_backlink = movedo_grve_post_meta( '_movedo_grve_backlink_id', movedo_grve_option( $post_type . '_backlink_id' ) );
			if( !empty( $grve_backlink ) ) {
				$grve_backlink_url = get_permalink( $grve_backlink );
			}
		} else if ( 'event' == $post_type && movedo_grve_events_calendar_enabled() ) {
			$grve_backlink_url = tribe_get_events_link();
			$grve_backlink_title = tribe_get_event_label_plural();
		}

		if ( $has_nav_section ) {
			if ( 'layout-3' == $mode ) {

		?>
			<?php if ( is_a( $prev_post, 'WP_Post' ) ) { ?>
			<div class="grve-post-bar-item grve-post-navigation">
				<a class="grve-nav-item grve-prev" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<div class="grve-item-icon grve-arrow grve-icon-nav-left"></div>
					<div class="grve-item-content grve-nav-item-wrapper">
						<h6 class="grve-title"><?php echo get_the_title( $prev_post->ID ); ?></h6>
					</div>
				</a>
			</div>
			<?php } ?>
			<?php if ( is_a( $next_post, 'WP_Post' ) ) { ?>
			<div class="grve-post-bar-item grve-post-navigation">
				<a class="grve-nav-item grve-next" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<div class="grve-item-icon grve-arrow grve-icon-nav-right"></div>
					<div class="grve-item-content grve-nav-item-wrapper">
						<h6 class="grve-title"><?php echo get_the_title( $next_post->ID ); ?></h6>
					</div>
				</a>
			</div>
			<?php } ?>
				<?php if ( !empty( $grve_backlink_url ) ) { ?>
				<div class="grve-post-bar-item grve-post-navigation">
					<a class="grve-nav-item grve-float-backlink" href="<?php echo esc_url( $grve_backlink_url ); ?>">
						<div class="grve-item-icon grve-arrow grve-icon-th-large"></div>
						<?php if( !empty( $grve_backlink_title ) ) { ?>
						<div class="grve-item-content grve-nav-item-wrapper">
							<h6 class="grve-title"><?php echo esc_html( $grve_backlink_title ); ?></h6>
						</div>
						<?php } ?>
					</a>
				</div>
				<?php } ?>
		<?php
			} else {
	?>
			<div class="grve-post-bar-item grve-post-navigation">
				<?php if ( is_a( $prev_post, 'WP_Post' ) ) { ?>
				<a class="grve-nav-item grve-prev" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<div class="grve-nav-item-wrapper">
						<div class="grve-arrow grve-icon-nav-left"></div>
						<h6 class="grve-title"><?php echo get_the_title( $prev_post->ID ); ?></h6>
					</div>
				</a>
				<?php } ?>
				<?php if ( !empty( $grve_backlink_url ) ) { ?>
				<a class="grve-backlink" href="<?php echo esc_url( $grve_backlink_url ); ?>">
					<div class="grve-arrow grve-icon-th-large"></div>
				</a>
				<?php } ?>
				<?php if ( is_a( $next_post, 'WP_Post' ) ) { ?>
				<a class="grve-nav-item grve-next" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<div class="grve-nav-item-wrapper">
						<h6 class="grve-title"><?php echo get_the_title( $next_post->ID ); ?></h6>
						<div class="grve-arrow grve-icon-nav-right"></div>
					</div>
				</a>
				<?php } ?>
			</div>
	<?php
			}
		}
	}
}

/**
 * Social Like
 */
 if ( !function_exists('movedo_grve_social_like') ) {
	function movedo_grve_social_like( $post_type = 'post', $mode = '') {
		$post_likes = movedo_grve_option( $post_type . '_social', '', 'grve-likes' );
		if ( !empty( $post_likes  ) ) {
			global $post;
			$post_id = $post->ID;
			if ( 'icon' == $mode ) {
?>
			<div class="grve-like-counter grve-link-text"><i class="fa fa-heart-o"></i><span><?php echo movedo_grve_likes( $post_id, 'number' ); ?></span></div>
<?php
			} else {
?>
			<li class="grve-like-counter <?php echo movedo_grve_likes( $post_id, 'status' ); ?>"><span><?php echo movedo_grve_likes( $post_id ); ?></span></li>
<?php
			}
		}
	}
}

/**
 * Social Bar
 */

if ( !function_exists('movedo_grve_social_bar') ) {
	function movedo_grve_social_bar( $post_type = 'post', $mode = '' ) {

		$has_nav_section = false;

		$grve_socials = movedo_grve_option( $post_type . '_social');
		if ( is_array( $grve_socials ) ) {
			$grve_socials = array_filter( $grve_socials );
		} else {
			$grve_socials = '';
		}

		if ( !empty( $grve_socials ) ) {
			$has_nav_section = true;
		}

		if ( 'check' == $mode ) {
			return $has_nav_section;
		}

		if ( $has_nav_section ) {
			global $post;
			$post_id = $post->ID;

			$grve_permalink = get_permalink( $post_id );
			$grve_title = get_the_title( $post_id );
			$grve_email = movedo_grve_option( $post_type . '_social', '', 'email' );
			$grve_facebook = movedo_grve_option( $post_type . '_social', '', 'facebook' );
			$grve_twitter = movedo_grve_option( $post_type . '_social', '', 'twitter' );
			$grve_linkedin = movedo_grve_option( $post_type . '_social', '', 'linkedin' );
			$grve_pinterest= movedo_grve_option( $post_type . '_social', '', 'pinterest' );
			$grve_googleplus= movedo_grve_option( $post_type . '_social', '', 'google-plus' );
			$grve_reddit = movedo_grve_option( $post_type . '_social', '', 'reddit' );
			$grve_tumblr = movedo_grve_option( $post_type . '_social', '', 'tumblr' );
			$grve_likes = movedo_grve_option( $post_type . '_social', '', 'grve-likes' );
			$grve_email_string = 'mailto:?subject=' . $grve_title . '&body=' . $grve_title . ': ' . $grve_permalink;


			if( 'layout-3' == $mode ) {
		?>

			<div class="grve-post-bar-item grve-post-socials">
				<div class="grve-item-icon grve-icon-socials"></div>
				<ul class="grve-item-content grve-bar-socials">
		<?php
			} else {
		?>
			<div class="grve-post-bar-item grve-post-socials">
				<ul class="grve-bar-socials grve-h6">
		<?php
			}
		?>
		<?php
			if( 'layout-1' == $mode ) {
		?>
					<li><?php echo esc_html__( 'Share : ', 'movedo' ); ?></li>
					<?php if ( !empty( $grve_email  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_email_string ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-email"><?php echo esc_html__( 'Email', 'movedo' ); ?></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_facebook  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-facebook">Facebook</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_twitter  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-twitter">Twitter</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_linkedin  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-linkedin">Linkedin</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_googleplus  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-googleplus">Google +</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_pinterest  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" data-pin-img="<?php echo esc_url( movedo_grve_get_thumbnail_url() ); ?>" class="grve-social-share-pinterest">Pinterest</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_reddit ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-reddit">Reddit</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_tumblr ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-tumblr">Tumblr</a></li>
					<?php } ?>
					<?php if ( !empty( $grve_likes  ) ) { ?>
					<li><a href="#" class="grve-like-counter-link <?php echo movedo_grve_likes( $post_id, 'status' ); ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>"><i class="grve-icon-heart-o"></i><span class="grve-like-counter"><?php echo movedo_grve_likes( $post_id, 'number' ); ?></span></a></li>
					<?php } ?>
		<?php
			} else {
		?>
					<?php if ( !empty( $grve_email  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_email_string ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-email"><i class="fa fa-envelope"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_facebook  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-facebook"><i class="fa fa-facebook"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_twitter  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-twitter"><i class="fa fa-twitter"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_linkedin  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-linkedin"><i class="fa fa-linkedin"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_googleplus  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-googleplus"><i class="fa fa-google-plus"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_pinterest  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" data-pin-img="<?php echo esc_url( movedo_grve_get_thumbnail_url() ); ?>" class="grve-social-share-pinterest"><i class="fa fa-pinterest"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_reddit ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-reddit"><i class="fa fa-reddit"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_tumblr ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="grve-social-share-tumblr"><i class="fa fa-tumblr"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $grve_likes  ) ) { ?>
					<li><a href="#" class="grve-like-counter-link <?php echo movedo_grve_likes( $post_id, 'status' ); ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>"><i class="fa fa-heart"></i><span class="grve-like-counter"><?php echo movedo_grve_likes( $post_id, 'number' ); ?></span></a></li>
					<?php } ?>
		<?php
			}
		?>
				</ul>
			</div>
			<!-- End Socials -->
<?php
		}
	}
}

/**
 * Get Thumbnail
 */

if ( !function_exists('movedo_grve_get_thumbnail_url') ) {
	function movedo_grve_get_thumbnail_url( $image_size = 'movedo-grve-small-square' ) {

		if ( has_post_thumbnail() ) {
			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			$attachment_src = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
			$image_src = $attachment_src[0];
		} else {
			$image_src = get_template_directory_uri() . '/images/empty/' . $image_size . '.jpg';
		}
		return $image_src ;
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
