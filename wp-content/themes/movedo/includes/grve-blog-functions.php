<?php

/*
 *	Blog Helper functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */


 /**
 * Prints excerpt
 */
function movedo_grve_print_post_excerpt( $post_format = 'standard' ) {

	$excerpt_length = movedo_grve_option( 'blog_excerpt_length' );
	$excerpt_more = movedo_grve_option( 'blog_excerpt_more' );


	if ( 'large' != movedo_grve_option( 'blog_mode', 'large' ) ) {
		$excerpt_length = movedo_grve_option( 'blog_excerpt_length_small' );
		$excerpt_auto = '1';
	} else {
		$excerpt_length = movedo_grve_option( 'blog_excerpt_length' );
		$excerpt_auto = movedo_grve_option( 'blog_auto_excerpt' );
	}

	if ( 'link' ==  $post_format || 'quote' ==  $post_format ) {
		$excerpt_more = 0;
		$excerpt_auto = '1';
	}

	if ( '1' == $excerpt_auto ) {
		if ( 'quote' ==  $post_format ) {
			echo movedo_grve_quote_excerpt( $excerpt_length );
		} else {
			echo movedo_grve_excerpt( $excerpt_length, $excerpt_more  );
		}
	} else {
		if ( '1' == $excerpt_more ) {
			the_content( esc_html__( 'read more', 'movedo' ) );
		} else {
			the_content( '' );
		}
	}

}

function movedo_grve_isotope_inner_before() {
	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$blog_animation = movedo_grve_option( 'blog_animation', 'none' );

	$wrapper_attributes = array();

	$classes = array( 'grve-blog-item-inner', 'grve-isotope-item-inner' );
	if ( 'none' != $blog_animation ) {
		if ( 'small' == $blog_mode || 'large' == $blog_mode )  {
			$classes[] = 'grve-animated-item';
		}
		$classes[] = $blog_animation;
	}
	$class_string = implode( ' ', $classes );
	$wrapper_attributes[] = 'class="' . esc_attr( $class_string ) . '"';


	if ( 'none' != $blog_animation ) {
		if ( 'small' == $blog_mode || 'large' == $blog_mode )  {
			$wrapper_attributes[] = 'data-delay="200"';
		}
	}

	echo '<div ' . implode( ' ', $wrapper_attributes ) .'>';
}
function movedo_grve_isotope_inner_after() {
	echo '</div>';
}
add_action( 'movedo_grve_inner_post_loop_item_before', 'movedo_grve_isotope_inner_before' );
add_action( 'movedo_grve_inner_post_loop_item_after', 'movedo_grve_isotope_inner_after' );

function movedo_grve_get_loop_title_heading_tag() {

	$heading = movedo_grve_option( 'blog_heading_tag', 'auto' );
	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );

	if( 'auto' != $heading ) {
		$title_tag = $heading;
	} else {
		$title_tag = 'h3';
		if( 'large' == $blog_mode || 'small' == $blog_mode  ) {
			$title_tag = 'h2';
		}
	}
	return $title_tag;
}

function movedo_grve_get_loop_title_heading() {

	$heading = movedo_grve_option( 'blog_heading', 'auto' );
	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );

	if( 'auto' != $heading ) {
		$heading_class = $heading;
	} else {
		$heading_class = 'h3';
		if( 'large' == $blog_mode || 'small' == $blog_mode  ) {
			$heading_class = 'h2';
		}
	}
	return $heading_class;
}

function movedo_grve_loop_post_title( $class = "grve-post-title" ) {
	$title_tag = movedo_grve_get_loop_title_heading_tag();
	$title_class = movedo_grve_get_loop_title_heading();
	the_title( '<' . tag_escape( $title_tag ) . ' class="' . esc_attr( $class ). ' grve-' . esc_attr( $title_class ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '>' );
}
function movedo_grve_loop_post_title_link() {
	$title_tag = movedo_grve_get_loop_title_heading_tag();
	$title_class = movedo_grve_get_loop_title_heading();
	the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-post-title-hover grve-' . esc_attr( $title_class ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
}
function movedo_grve_loop_post_title_hidden() {
	$title_tag = movedo_grve_get_loop_title_heading_tag();
	the_title( '<' . tag_escape( $title_tag ) . ' class="grve-hidden" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '>' );
}


add_action( 'movedo_grve_inner_post_loop_item_title', 'movedo_grve_loop_post_title' );
add_action( 'movedo_grve_inner_post_loop_item_title_link', 'movedo_grve_loop_post_title_link' );
add_action( 'movedo_grve_inner_post_loop_item_title_hidden', 'movedo_grve_loop_post_title_hidden' );

 /**
 * Prints Single Post Title
 */
function movedo_grve_print_post_simple_title() {
	global $post;
	if ( movedo_grve_check_title_visibility() ) {

		$post_id = $post->ID;
		$movedo_grve_custom_title_options = get_post_meta( $post_id, '_movedo_grve_custom_title_options', true );

		$movedo_grve_title_style = movedo_grve_option( 'post_title_style' );
		$movedo_grve_page_title_custom = movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom', $movedo_grve_title_style );
		if ( 'simple' == $movedo_grve_page_title_custom ) {
			echo '<div class="grve-post-title-wrapper grve-margin-bottom-1x">';
			echo '<div class="grve-container">';
			the_title( '<h1 class="grve-single-simple-title" itemprop="name headline">', '</h1>' );
			movedo_grve_print_post_title_meta( 'simple' );
			echo '</div>';
			echo '</div>';
		} else {
			the_title( '<h2 class="grve-hidden" itemprop="name headline">', '</h2>' );
		}
	} else {
		the_title( '<h2 class="grve-hidden" itemprop="name headline">', '</h2>' );
	}
}


/**
 * Gets Blog Class
 */
function movedo_grve_get_blog_class() {

	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$blog_shadow_style = movedo_grve_option( 'blog_shadow_style', 'shadow-mode' );
	switch( $blog_mode ) {

		case 'small':
			$movedo_grve_blog_mode_class = 'grve-blog grve-blog-small grve-non-isotope';
			break;
		case 'masonry':
			$movedo_grve_blog_mode_class = 'grve-blog grve-blog-columns grve-blog-masonry grve-isotope grve-with-gap';
			break;
		case 'grid':
			$movedo_grve_blog_mode_class = 'grve-blog grve-blog-columns grve-blog-grid grve-isotope grve-with-gap';
			break;
		case 'large':
		default:
			$movedo_grve_blog_mode_class = 'grve-blog grve-blog-large grve-non-isotope';
			break;
	}

	if ( 'shadow-mode' == $blog_shadow_style && ( 'masonry' == $blog_mode || 'grid' == $blog_mode ) ) {
		$movedo_grve_blog_mode_class .= ' grve-with-shadow';
	}

	return $movedo_grve_blog_mode_class;

}
/**
 * Gets post class
 */
function movedo_grve_get_post_class( $extra_class = '' ) {

	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$post_classes = array( 'grve-blog-item' );
	if ( !empty( $extra_class ) ){
		$post_classes[] = $extra_class;
	}

	switch( $blog_mode ) {

		case 'small':
			$post_classes[] = 'grve-small-post';
			$post_classes[] = 'grve-non-isotope-item';
			break;

		case 'masonry':
		case 'grid':
			$post_classes[] = 'grve-isotope-item';
			break;
		default:
			$post_classes[] = 'grve-big-post';
			$post_classes[] = 'grve-non-isotope-item';
			break;
	}

	return implode( ' ', $post_classes );

}

/**
 * Prints post item data
 */
function movedo_grve_print_blog_data() {

	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$columns_large_screen = movedo_grve_option( 'blog_columns_large_screen', '3' );
	$columns = movedo_grve_option( 'blog_columns', '3' );
	$columns_tablet_landscape  = movedo_grve_option( 'blog_columns_tablet_landscape', '2' );
	$columns_tablet_portrait  = movedo_grve_option( 'blog_columns_tablet_portrait', '2' );
	$columns_mobile  = movedo_grve_option( 'blog_columns_mobile', '1' );
	$item_spinner  = movedo_grve_option( 'blog_item_spinner', 'no' );
	$gutter = movedo_grve_option( 'blog_gutter', 'yes' );
	$gutter_size = movedo_grve_option( 'blog_gutter_size', '30' );
	if( 'yes' != $gutter ) {
		$gutter_size = 0;
	}


	switch( $blog_mode ) {

		case 'masonry':
			echo 'data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry" data-spinner="' . esc_attr( $item_spinner ) . '" data-gutter-size="' . esc_attr( $gutter_size ) . '"';
			break;
		case 'grid':
			echo 'data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows" data-spinner="' . esc_attr( $item_spinner ) . '" data-gutter-size="' . esc_attr( $gutter_size ) . '"';
			break;
		default:
			break;
	}

}

 /**
 * Prints post feature media
 */
function movedo_grve_print_post_feature_media( $post_type ) {

	if ( !movedo_grve_visibility( 'blog_media_area', '1' ) ){
		return;
	}
	$blog_image_prio = movedo_grve_option( 'blog_image_prio', 'no' );
	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );

	if ( 'yes' == $blog_image_prio && has_post_thumbnail() ) {
		movedo_grve_print_post_feature_image();
	} else {

		switch( $post_type ) {
			case 'audio':
				movedo_grve_print_post_audio();
				break;
			case 'video':
				movedo_grve_print_post_video();
				break;
			case 'gallery':
				$slider_items = movedo_grve_post_meta( '_movedo_grve_post_slider_items' );
				switch( $blog_mode ) {
					case 'large':
						$image_size = 'movedo-grve-large-rect-horizontal';
						break;
					default:
						$image_size  = 'movedo-grve-small-rect-horizontal';
						break;
				}
				if ( !empty( $slider_items ) ) {
					movedo_grve_print_gallery_slider( 'blog-slider', $slider_items, $image_size );
				}
				break;
			default:
				movedo_grve_print_post_feature_image();
				break;
		}
	}

}


function movedo_grve_get_blog_image_atts() {

	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$columns_large_screen = movedo_grve_option( 'blog_columns_large_screen', '5' );
	$columns = movedo_grve_option( 'blog_columns', '4' );
	$columns_tablet_landscape  = movedo_grve_option( 'blog_columns_tablet_landscape', '4' );
	$columns_tablet_portrait  = movedo_grve_option( 'blog_columns_tablet_portrait', '2' );
	$columns_mobile  = movedo_grve_option( 'blog_columns_mobile', '1' );

	$image_atts = array();

	switch( $blog_mode ) {

		case 'masonry':
		case 'grid':
				$image_atts['data-gutter-size'] = 15;
				$image_atts['data-columns-large-screen'] = $columns_large_screen;
				$image_atts['data-columns'] = $columns;
				$image_atts['data-columns-tablet-landscape'] = $columns_tablet_landscape;
				$image_atts['data-columns-tablet-portrait'] = $columns_tablet_portrait;
				$image_atts['data-columns-mobile'] = $columns_mobile;
			break;
		default:
			break;
	}

	return $image_atts;

}

 /**
 * Prints post feature image
 */
function movedo_grve_print_post_feature_image() {

	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$blog_image_mode = movedo_grve_option( 'blog_image_mode', 'landscape-large-wide' );
	$blog_grid_image_mode = movedo_grve_option( 'blog_grid_image_mode', 'landscape' );
	$blog_masonry_image_mode = movedo_grve_option( 'blog_masonry_image_mode', 'medium' );

	if ( 'grid' == $blog_mode || 'small' == $blog_mode ) {
		$blog_image_mode = $blog_grid_image_mode;
	} else if ( 'masonry' == $blog_mode ) {
		$blog_image_mode = $blog_masonry_image_mode;
	}

	$image_size = movedo_grve_get_image_size( $blog_image_mode );

	$image_href = get_permalink();

	if ( has_post_thumbnail() ) {
	$image_atts = movedo_grve_get_blog_image_atts();
?>
	<div class="grve-media clearfix">
		<a href="<?php echo esc_url( $image_href ); ?>"><?php the_post_thumbnail( $image_size, $image_atts ); ?></a>
	</div>
<?php
	}

}

 /**
 * Prints post meta area
 */
if ( !function_exists('movedo_grve_print_post_meta_top') ) {
	function movedo_grve_print_post_meta_top() {
?>
			<div class="grve-post-header">
				<ul class="grve-post-meta">
					<?php movedo_grve_print_post_author_by( 'list'); ?>
					<?php movedo_grve_print_post_date( 'list' ); ?>
					<?php movedo_grve_print_post_loop_comments(); ?>
					<?php movedo_grve_print_like_counter_overview(); ?>
				</ul>
				<?php do_action( 'movedo_grve_inner_post_loop_item_title_link' ); ?>
			</div>
<?php

	}
}


/**
 * Prints Post Tags
 */
function movedo_grve_print_post_tags() {
	global $post;
	$post_id = $post->ID;
?>
	<?php if ( movedo_grve_visibility( 'post_tag_visibility', '1' ) ) { ?>

		<div class="grve-single-post-tags grve-margin-top-3x">
			<?php the_tags('<ul class="grve-tags grve-link-text grve-border"><li>','</li><li>','</li></ul>'); ?>
		</div>

	<?php } ?>

<?php
}


 /**
 * Prints Post Title Categories
 */
function movedo_grve_print_post_title_categories( $post_id = null) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$post_terms = wp_get_object_terms( $post_id, 'category', array( 'fields' => 'ids' ) );
	if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
		$term_ids = implode( ',' , $post_terms );
		echo '<ul class="grve-categories">';
		echo wp_list_categories( 'title_li=&style=list&echo=0&hierarchical=0&taxonomy=category&include=' . $term_ids );
		echo '</ul>';
	}
}

 /**
 * Prints Post Title Categories Simple
 */
function movedo_grve_print_post_title_categories_simple( $post_id = null) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$post_terms = wp_get_object_terms( $post_id, 'category', array( 'fields' => 'ids' ) );
	if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
		echo '<li class="grve-post-categories">';
		esc_html_e( 'in', 'movedo' );
		echo ' ';
		the_category( ', ' );
		echo '</li>';
	}
}


 /**
 * Prints Post Title Meta
 */

function movedo_grve_print_post_title_meta( $mode = "") {

$meta_class = "grve-post-meta";
if ( 'simple' == $mode ) {
	$meta_class .= " grve-link-text";
}
?>
	<ul class="<?php echo esc_attr( $meta_class ); ?>">
		<?php movedo_grve_print_post_author_by( 'list'); ?>
		<?php movedo_grve_print_post_date( 'list'); ?>
		<?php movedo_grve_print_post_loop_comments(); ?>
		<?php movedo_grve_print_like_counter_overview( 'single' ); ?>
		<?php if ( 'simple' == $mode && movedo_grve_visibility( 'post_category_visibility', '1' ) ) { ?>
		<?php movedo_grve_print_post_title_categories_simple(); ?>
		<?php } ?>
	</ul>
<?php
}

 /**
 * Prints Post Title Meta
 */

function movedo_grve_print_feature_post_title_meta( $post_id = null ) {

	if( $post_id ) {
		$post_author_id = get_post_field( 'post_author', $post_id );
		$userdata = get_userdata( $post_author_id );
		$post_comments_number = get_comments_number( $post_id );
		$post_likes = movedo_grve_option( 'post_social', '', 'grve-likes' );

?>
	<div class="grve-title-meta">
		<ul class="grve-post-meta grve-link-text">
			<li class="grve-post-author"><i class="grve-icon-user"></i>
				<span><?php echo esc_html( $userdata->display_name ); ?></span>
			</li>
			<li class="grve-post-date"><i class="grve-icon-date"></i>
				<time datetime="<?php echo esc_attr( get_the_date( 'c', $post_id  ) ); ?>"><?php echo esc_html( get_the_date( '', $post_id  ) ); ?></time>
			</li>
			<li class="grve-post-comments"><i class="grve-icon-comment"></i>
				<span><?php echo esc_html( $post_comments_number ); ?></span>
			</li>
			<?php if ( !empty( $post_likes  ) ) { ?>
			<li class="grve-like-counter <?php echo movedo_grve_likes( $post_id, 'status' ); ?>">
				<span><?php echo movedo_grve_likes( $post_id ); ?></span>
			</li>
			<?php } ?>
		</ul>
	</div>
<?php
	}
}


 /**
 * Prints post author by
 */
function movedo_grve_print_post_author_by( $mode = '') {

	if ( movedo_grve_visibility( 'blog_author_visibility', '1' ) ) {

		if( 'list' == $mode ) {
			echo '<li class="grve-post-author">';
			echo '<span>' . get_the_author_link() . '</span>';
			echo '</li>';
		} else {
			echo '<div class="grve-post-author">';
			echo '<span>' . get_the_author_link() . '</span>';
			echo '</div>';
		}
	}
}



 /**
 * Prints like counter for overview pages
 */
function movedo_grve_print_like_counter_overview( $mode = '' ) {

	if( movedo_grve_visibility( 'blog_like_visibility', '1' ) ) {
		movedo_grve_print_like_counter( $mode );
	}

}

 /**
 * Prints like counter
 */
function movedo_grve_print_like_counter( $mode = '' ) {

	$post_likes = movedo_grve_option( 'post_social', '', 'grve-likes' );
	if ( !empty( $post_likes  ) ) {
		global $post;
		$post_id = $post->ID;
		if ( 'single' == $mode ) {
?>
		<li class="grve-like-counter <?php echo movedo_grve_likes( $post_id, 'status' ); ?>"><span><?php echo movedo_grve_likes( $post_id ); ?></span></li>
<?php
		} else {
?>
		<li class="grve-like-counter <?php echo movedo_grve_likes( $post_id, 'status' ); ?>"><span><?php echo movedo_grve_likes( $post_id ); ?></span></li>
<?php
		}
	}

}

/**
 * Prints post date
 */
if ( !function_exists('movedo_grve_print_post_date') ) {
	function movedo_grve_print_post_date( $mode = '' ) {
		if ( movedo_grve_visibility( 'blog_date_visibility' ) ) {
			$class = "";
			if( 'list' == $mode ) {
				echo '<li class="grve-post-date">';
			} else if ( 'quote' == $mode ) {
				$class = "grve-post-date grve-small-text grve-circle-arrow";
			} else if ( 'default' == $mode ) {
				$class = "grve-post-date grve-link-text grve-text-primary-1";
			}
			global $post;
	?>
		<time class="<?php echo esc_attr( $class ); ?>" datetime="<?php echo mysql2date( 'c', $post->post_date ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	<?php
			if( 'list' == $mode ) {
				echo '</li>';
			}
		}
	}
}

function movedo_grve_print_post_loop_comments() {
	if ( movedo_grve_visibility( 'blog_comments_visibility' ) ) {
?>
	<li class="grve-post-comments"><span><?php comments_number(); ?></span></li>
	<?php
	}
}

function movedo_grve_print_post_loop_categories() {
	if ( movedo_grve_visibility( 'blog_categories_visibility' ) ) {
		global $post;
		$post_id = $post->ID;
		$post_terms = wp_get_object_terms( $post_id, 'category', array( 'fields' => 'ids' ) );
		if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
			$term_ids = implode( ',' , $post_terms );
			echo '<ul class="grve-categories">';
			echo wp_list_categories( 'title_li=&style=list&echo=0&hierarchical=0&taxonomy=category&include=' . $term_ids );
			echo '</ul>';
		}
	}
}

/**
 * Prints post feature bg image container
 */
function movedo_grve_print_post_bg_image_container( $options ) {

	$bg_color = movedo_grve_array_value( $options, 'bg_color' );
	$bg_hover_color = movedo_grve_array_value( $options, 'bg_hover_color' );
	$bg_opacity = movedo_grve_array_value( $options, 'bg_opacity', '80' );
	$mode = movedo_grve_array_value( $options, 'mode' );
	$overlay = true;

	$link_classes = array();
	$link_classes[] = 'grve-bg-' . $bg_color;
	if( !empty( $bg_hover_color ) ){
		$link_classes[] = 'grve-bg-hover-' . $bg_hover_color;
	}
	$link_classes[] = 'grve-bg-overlay';
	if ( has_post_thumbnail() ) {
		$link_classes[] = 'grve-opacity-' . $bg_opacity;
		if ( 'none' == $bg_opacity || '0' == $bg_opacity ) {
			$overlay = false;
		}
	} else {
		$link_classes[] = 'grve-opacity-100';
	}
	$link_class_string = implode( ' ', $link_classes );

?>
	<div class="grve-media grve-bg-wrapper">
		<?php
			if ( 'image' == $mode ) {
				movedo_grve_print_post_image( $options );
			} else {
				movedo_grve_print_post_bg_image();
			}
		?>
		<?php if( $overlay ) { ?>
		<div class="<?php echo esc_attr( $link_class_string ); ?>"></div>
		<?php } ?>
	</div>
<?php
}

function movedo_grve_print_post_image( $options = array() ) {

	$image_size = movedo_grve_array_value( $options, 'image_size', 'movedo-grve-fullscreen' );

	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $image_size );
	} else {
		$image_src = get_template_directory_uri() . '/images/transparent/' . $image_size . '.png';
?>
		<img class="attachment-<?php echo esc_attr( $image_size ); ?>" src="<?php echo esc_url( $image_src ); ?>" alt="<?php the_title_attribute(); ?>"/>
<?php
	}
}


function movedo_grve_print_post_bg_image( $image_size = 'movedo-grve-fullscreen' ) {
	if ( has_post_thumbnail() ) {
		$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$attachment_src = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
		$image_url = $attachment_src[0];
?>
		<div class="grve-bg-image" style="background-image: url(<?php echo esc_url( $image_url ); ?>);"></div>
<?php
	}
}

/**
 * Prints author avatar
 */
function movedo_grve_print_post_author() {
	global $post;
	$post_id = $post->ID;
	$post_type = get_post_type( $post_id );

	if ( 'page' == $post_type ||  'portfolio' == $post_type  ) {
		return;
	}
?>
	<div class="grve-post-author">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
	</div>
<?php

}

/**
 * Prints audio shortcode of post format audio
 */
function movedo_grve_print_post_audio() {
	global $wp_embed;

	$audio_mode = movedo_grve_post_meta( '_movedo_grve_post_type_audio_mode' );
	$audio_mp3 = movedo_grve_post_meta( '_movedo_grve_post_audio_mp3' );
	$audio_ogg = movedo_grve_post_meta( '_movedo_grve_post_audio_ogg' );
	$audio_wav = movedo_grve_post_meta( '_movedo_grve_post_audio_wav' );
	$audio_embed = movedo_grve_post_meta( '_movedo_grve_post_audio_embed' );

	$audio_output = '';

	if( empty( $audio_mode ) && !empty( $audio_embed ) ) {
		echo '<div class="grve-media">' . $audio_embed . '</div>';
	} else {
		if ( !empty( $audio_mp3 ) || !empty( $audio_ogg ) || !empty( $audio_wav ) ) {

			$audio_output .= '[audio ';

			if ( !empty( $audio_mp3 ) ) {
				$audio_output .= 'mp3="'. esc_url( $audio_mp3 ) .'" ';
			}
			if ( !empty( $audio_ogg ) ) {
				$audio_output .= 'ogg="'. esc_url( $audio_ogg ) .'" ';
			}
			if ( !empty( $audio_wav ) ) {
				$audio_output .= 'wav="'. esc_url( $audio_wav ) .'" ';
			}

			$audio_output .= ']';

			echo '<div class="grve-media">';
			echo  do_shortcode( $audio_output );
			echo '</div>';
		}
	}

}

/**
 * Prints video of the video post format
 */
function movedo_grve_print_post_video() {

	$video_mode = movedo_grve_post_meta( '_movedo_grve_post_type_video_mode' );
	$video_webm = movedo_grve_post_meta( '_movedo_grve_post_video_webm' );
	$video_mp4 = movedo_grve_post_meta( '_movedo_grve_post_video_mp4' );
	$video_ogv = movedo_grve_post_meta( '_movedo_grve_post_video_ogv' );
	$video_poster = movedo_grve_post_meta( '_movedo_grve_post_video_poster' );
	$video_embed = movedo_grve_post_meta( '_movedo_grve_post_video_embed' );

	movedo_grve_print_media_video( $video_mode, $video_webm, $video_mp4, $video_ogv, $video_embed, $video_poster );
}

/**
 * Prints video popup of the video post format
 */
function movedo_grve_print_post_video_popup() {

	$video_embed = movedo_grve_post_meta( '_movedo_grve_post_video_embed' );
	if( !empty( $video_embed ) ) {
?>
	<a class="grve-vimeo-popup grve-post-icon" href="<?php echo esc_url( $video_embed ); ?>">
		<i class="grve-icon-video"></i>
		<svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>
	</a>
<?php
	}
}


function movedo_grve_get_related_posts( $max_posts = 3) {

	$movedo_grve_tag_ids = array();

	$movedo_grve_tags_list = get_the_tags();
	if ( ! empty( $movedo_grve_tags_list ) ) {
		foreach ( $movedo_grve_tags_list as $tag ) {
			array_push( $movedo_grve_tag_ids, $tag->term_id );
		}
	}
	$exclude_ids = array( get_the_ID() );
	$tag_found = false;

	$query = array();
	if ( ! empty( $movedo_grve_tag_ids ) ) {
		$args = array(
			'tag__in' => $movedo_grve_tag_ids,
			'post__not_in' => $exclude_ids,
			'posts_per_page' => $max_posts,
			'paged' => 1,
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			$tag_found = true;
		}
	}

	wp_reset_postdata();

	if ( $tag_found ) {
		return $query;
	} else {
		return array();
	}
}

/**
 * Prints related posts ( Single Post )
 */
function movedo_grve_print_related_posts( $query = array(), $layout = 'classic') {

	if ( !empty( $query ) ) {
		$grve_related_title_first = movedo_grve_option( 'post_related_title_first' );
		$grve_related_title_second = movedo_grve_option( 'post_related_title_second' );
?>

<?php if ( 'classic' == $layout ) { ?>
	<div id="grve-related-post" class="grve-related grve-margin-top-3x">
		<div class="grve-wrapper">
			<?php if( !empty( $grve_related_title_first ) ||  !empty( $grve_related_title_second ) ) { ?>
			<div class="grve-related-title">
				<?php if( !empty( $grve_related_title_first ) ) { ?>
				<div class="grve-description grve-small-text grve-align-center"><?php echo esc_html( $grve_related_title_first ); ?></div>
				<?php } ?>
				<?php if( !empty( $grve_related_title_second ) ) { ?>
				<div class="grve-title grve-h5 grve-align-center"><?php echo esc_html( $grve_related_title_second ); ?></div>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="grve-row grve-columns-gap-10">
<?php } else { ?>
	<div class="grve-post-bar-item grve-post-related">
<?php }	?>

<?php
	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		get_template_part( 'templates/post', 'related' );
	endwhile;
	else :
	endif;
?>
<?php if ( 'classic' == $layout ) { ?>
			</div>
		</div>
	</div>
<?php } else { ?>
	</div>
<?php }	?>
<?php
	}

	wp_reset_postdata();
}


/**
 * Likes ajax callback ( used in Single Post )
 */
function movedo_grve_likes_callback( $post_id ) {

	$likes = 0;
	$status = "";

	if ( isset( $_POST['grve_likes_id'] ) ) {
		$post_id = $_POST['grve_likes_id'];
		$response = movedo_grve_likes( $post_id, 'update' );
	} else {
		$response = array(
			'status' => $status,
			'likes' => $likes,
		);
	}
	wp_send_json( $response );

	die();
}

add_action( 'wp_ajax_movedo_grve_likes_callback', 'movedo_grve_likes_callback' );
add_action( 'wp_ajax_nopriv_movedo_grve_likes_callback', 'movedo_grve_likes_callback' );

function movedo_grve_likes( $post_id, $action = 'get' ) {

	$status = '';

	if( !is_numeric( $post_id ) ) {
		$likes = 0;
	} else {
		$likes = get_post_meta( $post_id, '_movedo_grve_likes', true );
	}

	if( !$likes || !is_numeric( $likes ) ) {
		$likes = 0;
	}

	if ( 'update' == $action ) {

		if( is_numeric( $post_id ) ) {
			if ( isset( $_COOKIE['_movedo_grve_likes_' . $post_id] ) ) {
				unset( $_COOKIE['_movedo_grve_likes_' . $post_id] );
				setcookie( '_movedo_grve_likes_' . $post_id, "", 1, '/' );
				if( 0 != $likes ) {
					$likes--;
					update_post_meta( $post_id, '_movedo_grve_likes', $likes );
				}

			} else {
				$likes++;
				update_post_meta( $post_id, '_movedo_grve_likes', $likes );
				setcookie('_movedo_grve_likes_' . $post_id, $post_id, time()*20, '/');
				$status = 'active';
			}
		}

		return $response = array(
			'status' => $status,
			'likes' => $likes,
		);

	} elseif ( 'status' == $action ) {
		if( is_numeric( $post_id ) ) {
			if ( isset( $_COOKIE['_movedo_grve_likes_' . $post_id] ) && 0 != $likes) {
				$status = 'active';
			}
		}
		return $status;
	} elseif ( 'number' == $action ) {
		return $likes;
	}

	return movedo_grve_likes_text( $likes );
}

function movedo_grve_likes_text( $number ) {
	if ( $number > 1 ) {
		$output = sprintf( _n( '%s Like', '%s Likes', $number, 'movedo' ), number_format_i18n( $number ) );
	} elseif ( $number == 0 ) {
		$output = esc_html__( 'No Likes', 'movedo' );
	} else { // must be one
		$output = esc_html__( '1 Like', 'movedo'  );
	}
	return apply_filters( 'movedo_grve_likes_text', $output, $number );
}


 /**
 * Prints Navigation Bar ( Post )
 */
if ( !function_exists('movedo_grve_print_post_bar') ) {
	function movedo_grve_print_post_bar() {

		$layout = movedo_grve_option( 'post_nav_bar_layout', 'layout-1' );


		$post_nav_section = $post_social_section = $post_related_section = false;
		$post_sections = 0;
		if ( movedo_grve_nav_bar( 'post', 'check' ) ) {
			$post_nav_section = true;
			$post_sections++;
		}

		if( movedo_grve_social_bar( 'post', 'check' ) ) {
			$post_social_section = true;
			$post_sections++;
		}

		if ( movedo_grve_visibility( 'post_related_visibility' ) ) {

			if( 'layout-2' == $layout ) {
				$related_query = movedo_grve_get_related_posts( 2 );
				if ( !empty( $related_query ) ) {
					$post_related_section = true;
					$post_sections++;
				}
			}
		}

		if ( $post_nav_section || $post_social_section || $post_related_section ) {

			// Navigation Bar Classes
			$navigation_bar_classes = array( 'grve-navigation-bar', 'grve-singular-section', 'grve-fullwidth' );
			if( 'layout-3' == $layout ) {
				array_push( $navigation_bar_classes, 'grve-layout-3' );
			} else {
				array_push( $navigation_bar_classes, 'grve-' . $layout );
				array_push( $navigation_bar_classes, 'clearfix' );
				array_push( $navigation_bar_classes, 'grve-nav-columns-' . $post_sections );
			}

			$navigation_bar_class_string = implode( ' ', $navigation_bar_classes );

?>
			<!-- POST BAR -->
			<div id="grve-post-bar" class="<?php echo esc_attr( $navigation_bar_class_string ); ?>">
				<div class="grve-container">
					<div class="grve-bar-wrapper">
						<?php if ( $post_nav_section ) { ?>
							<?php movedo_grve_nav_bar( 'post', $layout ); ?>
						<?php } ?>
						<?php if ( $post_social_section ) { ?>
							<?php movedo_grve_social_bar( 'post', $layout ); ?>
						<?php } ?>
						<?php if ( $post_related_section ) { ?>
							<?php movedo_grve_print_related_posts( $related_query, 'movedo'); ?>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- END POST BAR -->
<?php
		}
	}
}


 /**
 * Prints About Author ( Post )
 */
 if ( !function_exists('movedo_grve_print_post_about_author') ) {
	function movedo_grve_print_post_about_author() {

	$author_class = 'grve-margin-top-3x grve-padding-top-3x grve-margin-bottom-3x grve-border grve-border-top clearfix';
	if ( movedo_grve_visibility( 'post_tag_visibility', '1' ) || movedo_grve_visibility( 'post_category_visibility', '1' ) ) {
		$author_class = 'grve-margin-top-3x grve-padding-top-3x grve-border grve-border-top clearfix';
	}
	$grve_post_author_info_link_text = movedo_grve_option( 'post_author_info_link_text' );
	$grve_post_author_description = get_the_author_meta( 'user_description' );
?>
	<?php if ( movedo_grve_visibility( 'post_author_visibility' ) && !empty( $grve_post_author_description ) ) { ?>
		<!-- About Author -->
		<div id="grve-about-author" class="<?php echo esc_attr( $author_class ); ?>">
			<div class="grve-author-image">
				<?php echo get_avatar( get_the_author_meta('ID'), 90 ); ?>
			</div>
			<div class="grve-author-info">
				<h2 class="grve-title grve-h5"><?php the_author_link(); ?></h2>
				<p><?php echo get_the_author_meta( 'user_description' ); ?></p>
				<a class="grve-author-read-more grve-hover-underline grve-link-text grve-heading-color grve-heading-hover-color" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php
						if( !empty( $grve_post_author_info_link_text ) ) {
							echo esc_html( $grve_post_author_info_link_text ) . '  ';
						}
						the_author();
					?>
				</a>
			</div>
		</div>
		<!-- End About Author -->
	<?php } ?>
<?php
	}
}

/**
 * Prints post structured data
 */
if ( !function_exists( 'movedo_grve_print_post_structured_data' ) ) {
	function movedo_grve_print_post_structured_data( $args = array() ) {

		if ( has_post_thumbnail() ) {
			$url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full') ;
			$image_url = $url[0];
			$image_width = $url[1];
			$image_height = $url[2];

		} else {
			$image_url = get_template_directory_uri() . '/images/empty/thumbnail.jpg';
			$image_width = 150;
			$image_height = 150;
		}
	?>
		<span class="grve-hidden">
			<span class="grve-structured-data entry-title"><?php the_title(); ?></span>
			<span class="grve-structured-data" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
			   <span itemprop='url' ><?php echo esc_url( $image_url ); ?></span>
			   <span itemprop='height' ><?php echo esc_html( $image_width ); ?></span>
			   <span itemprop='width' ><?php echo esc_html( $image_height ); ?></span>
			</span>
			<?php if ( movedo_grve_visibility( 'blog_author_visibility', '1' ) ) { ?>
			<span class="grve-structured-data vcard author" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span itemprop="name" class="fn"><?php the_author(); ?></span>
			</span>
			<span class="grve-structured-data" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<span itemprop='name'><?php the_author(); ?></span>
				<span itemprop='logo' itemscope itemtype='http://schema.org/ImageObject'>
					<span itemprop='url'><?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?></span>
				</span>
			</span>
			<?php } else { ?>
			<span class="grve-structured-data vcard author" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span itemprop="name" class="fn"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			</span>
			<span class="grve-structured-data" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<span itemprop='name'><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				<span itemprop='logo' itemscope itemtype='http://schema.org/ImageObject'>
					<span itemprop='url'><?php echo esc_url( $image_url ); ?></span>
				</span>
			</span>
			<?php } ?>
			<time class="grve-structured-data date published" itemprop="datePublished" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
			<time class="grve-structured-data date updated" itemprop="dateModified"  datetime="<?php echo get_the_modified_time('c'); ?>"><?php echo get_the_modified_date(); ?></time>
			<span class="grve-structured-data" itemprop="mainEntityOfPage" itemscope itemtype="http://schema.org/WebPage" itemid="<?php echo esc_url( get_permalink() ); ?>"></span>
		</span>
	<?php
	}
}


//Omit closing PHP tag to avoid accidental whitespace output errors.
