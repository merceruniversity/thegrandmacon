<?php

/*
 *	Media functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */


 /**
 * Generic function that prints a slider/carousel navigation
 */
function movedo_grve_element_navigation( $navigation_type = 0, $navigation_color = 'dark' ) {

	$output = '';

	if ( 0 != $navigation_type ) {

		switch( $navigation_type ) {

			case '2':
				$icon_nav_prev = 'grve-icon-nav-left';
				$icon_nav_next = 'grve-icon-nav-right';
				break;
			case '3':
				$icon_nav_prev = 'grve-icon-nav-left-small';
				$icon_nav_next = 'grve-icon-nav-right-small';
				break;
			case '4':
				$icon_nav_prev = 'grve-icon-nav-left';
				$icon_nav_next = 'grve-icon-nav-right';
				break;
			default:
				$navigation_type = '1';
				$icon_nav_prev = 'grve-icon-nav-left-small';
				$icon_nav_next = 'grve-icon-nav-right-small';
				break;
		}

		$output .= '<div class="grve-carousel-navigation grve-' . esc_attr( $navigation_color ) . ' grve-navigation-' . esc_attr( $navigation_type ) . '">';
		$output .= '	<div class="grve-carousel-buttons">';
		$output .= '		<div class="grve-carousel-prev">';
		$output .= '			<i class="' . esc_attr( $icon_nav_prev ) . '"></i>';
		$output .= '		</div>';
		$output .= '		<div class="grve-carousel-next">';
		$output .= '			<i class="' . esc_attr( $icon_nav_next ) . '"></i>';
		$output .= '		</div>';
		$output .= '	</div>';
		$output .= '</div>';
	}

	return 	$output;

}

/**
 * Generic function that prints a slider or gallery
 */
function movedo_grve_print_gallery_slider( $gallery_mode, $slider_items , $image_size_slider = 'movedo-grve-large-rect-horizontal', $extra_class = "") {

	if ( empty( $slider_items ) ) {
		return;
	}
	
	$image_link_mode = "";

	$image_size_gallery_thumb = 'movedo-grve-small-rect-horizontal';
	if( 'gallery-vertical' == $gallery_mode ) {
		$image_size_gallery_thumb = $image_size_slider;
	}

	if ( 'gallery' == $gallery_mode || '' == $gallery_mode ) {

		$columns_large_screen = 3;
		$columns = 3;
		$columns_tablet_landscape  = 2;
		$columns_tablet_portrait  = 2;
		$columns_mobile  = 1;
		$gutter_size = 30;
		if ( is_singular( 'portfolio' ) ) {
			$portfolio_media_fullwidth = movedo_grve_post_meta( '_movedo_grve_portfolio_media_fullwidth' );
			if ( 'yes' == $portfolio_media_fullwidth ) {
				$columns_large_screen = 4;
				$columns = 4;
			}
			$image_link_mode = movedo_grve_post_meta( '_movedo_grve_portfolio_media_image_link_mode' );
		}

		$wrapper_attributes = array();

		$gallery_classes = array( 'grve-gallery' , 'grve-isotope', 'grve-with-gap' );
		if( empty( $image_link_mode ) ){
			$gallery_classes[] = 'grve-gallery-popup';
		}
		$gallery_class_string = implode( ' ', $gallery_classes );

		$wrapper_attributes[] = 'class="' . esc_attr( $gallery_class_string ) . '"';
		$wrapper_attributes[] = 'data-gutter-size="' . esc_attr( $gutter_size ) . '"';
		$wrapper_attributes[] = 'data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '"';
		$wrapper_attributes[] = 'data-columns="' . esc_attr( $columns ) . '"';
		$wrapper_attributes[] = 'data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '"';
		$wrapper_attributes[] = 'data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '"';
		$wrapper_attributes[] = 'data-columns-mobile="' . esc_attr( $columns_mobile ) . '"';
		$wrapper_attributes[] = 'data-layout="fitRows"';
?>
		<div <?php echo implode( ' ', $wrapper_attributes ); ?>>
			<div class="grve-isotope-container">
<?php

		foreach ( $slider_items as $slider_item ) {

			$media_id = $slider_item['id'];
			$full_src = wp_get_attachment_image_src( $media_id, 'movedo-grve-fullscreen' );
			$image_full_url = $full_src[0];

			$caption = get_post_field( 'post_excerpt', $media_id );
			$figcaption = '';
			if	( !empty( $caption ) ) {
				$figcaption = wptexturize( $caption );
			}
?>
				<div class="grve-isotope-item grve-hover-item grve-hover-style-none">
					<div class="grve-isotope-item-inner">
					<?php if( empty( $image_link_mode ) ){ ?>
						<figure class="grve-image-hover grve-zoom-none">
							<a class="grve-item-url" data-title="<?php echo esc_attr( $figcaption ); ?>" href="<?php echo esc_url( $image_full_url ); ?>"></a>
							<div class="grve-hover-overlay grve-bg-light grve-opacity-30"></div>
							<div class="grve-media">
								<?php echo wp_get_attachment_image( $media_id, $image_size_gallery_thumb ); ?>
							</div>
						</figure>
					<?php } else { ?>
						<figure class="grve-zoom-none">
							<div class="grve-media">
								<?php echo wp_get_attachment_image( $media_id, $image_size_gallery_thumb ); ?>
							</div>
						</figure>					
					<?php } ?>
					</div>
				</div>
<?php

		}
?>
			</div>
		</div>
<?php


	} elseif ( 'gallery-vertical' == $gallery_mode ) {
	
		if ( is_singular( 'portfolio' ) ) {
			$image_link_mode = movedo_grve_post_meta( '_movedo_grve_portfolio_media_image_link_mode' );
		}
?>
		<div class="grve-media">
			<ul class="grve-post-gallery grve-post-gallery-popup <?php echo esc_attr( $extra_class ); ?>">
<?php

		foreach ( $slider_items as $slider_item ) {

			$media_id = $slider_item['id'];
			$full_src = wp_get_attachment_image_src( $media_id, 'movedo-grve-fullscreen' );
			$image_full_url = $full_src[0];

			$caption = get_post_field( 'post_excerpt', $media_id );
			$figcaption = '';
			if	( !empty( $caption ) ) {
				$figcaption = wptexturize( $caption );
			}
			
			if( empty( $image_link_mode ) ){
				echo '<li class="grve-image-hover">';
				echo '<a data-title="' . esc_attr( $figcaption ) . '" href="' . esc_url( $image_full_url ) . '">';
				echo wp_get_attachment_image( $media_id, $image_size_gallery_thumb );
				echo '</a>';
				echo '</li>';
			} else {
				echo '<li>';
				echo wp_get_attachment_image( $media_id, $image_size_gallery_thumb );
				echo '</li>';
			}
			
		}
?>
			</ul>
		</div>
<?php

	} else {

		$slider_settings = array();
		if ( is_singular( 'post' ) || is_singular( 'portfolio' ) ) {
			if ( is_singular( 'post' ) ) {
				$slider_settings = movedo_grve_post_meta( '_movedo_grve_post_slider_settings' );
			} else {
				$slider_settings = movedo_grve_post_meta( '_movedo_grve_portfolio_slider_settings' );
			}
		}
		$slider_speed = movedo_grve_array_value( $slider_settings, 'slideshow_speed', '2500' );
		$slider_dir_nav = movedo_grve_array_value( $slider_settings, 'direction_nav', '1' );
		$slider_dir_nav_color = movedo_grve_array_value( $slider_settings, 'direction_nav_color', 'dark' );

		$image_atts = array();
		if( 'blog-slider' == $gallery_mode ) {
			$image_atts = movedo_grve_get_blog_image_atts();
		}

?>
		<div class="grve-media clearfix">
			<div class="grve-element grve-slider grve-layout-1">
				<div class="grve-carousel-wrapper grve-<?php echo esc_attr( $slider_dir_nav_color ); ?>">
					<?php echo movedo_grve_element_navigation( $slider_dir_nav, $slider_dir_nav_color ); ?>
					<div class="grve-slider-element " data-slider-speed="<?php echo esc_attr( $slider_speed ); ?>" data-slider-pause="yes" data-slider-autoheight="no">
<?php
						foreach ( $slider_items as $slider_item ) {
							$media_id = $slider_item['id'];
							echo '<div class="grve-slider-item">';
							echo wp_get_attachment_image( $media_id, $image_size_slider, '', $image_atts );
							echo '</div>';

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
 * Generic function that prints video settings ( HTML5 )
 */

if ( !function_exists( 'movedo_grve_print_media_video_settings' ) ) {
	function movedo_grve_print_media_video_settings( $video_settings ) {
		$video_attr = '';

		if ( !empty( $video_settings ) ) {

			$video_poster = movedo_grve_array_value( $video_settings, 'poster' );
			$video_preload = movedo_grve_array_value( $video_settings, 'preload', 'metadata' );

			if( 'yes' == movedo_grve_array_value( $video_settings, 'controls' ) ) {
				$video_attr .= ' controls';
			}
			if( 'yes' == movedo_grve_array_value( $video_settings, 'loop' ) ) {
				$video_attr .= ' loop="loop"';
			}
			if( 'yes' ==  movedo_grve_array_value( $video_settings, 'muted' ) ) {
				$video_attr .= ' muted="muted"';
			}
			if( 'yes' == movedo_grve_array_value( $video_settings, 'autoplay' ) ) {
				$video_attr .= ' autoplay="autoplay"';
			}
			if( 'yes' == movedo_grve_array_value( $video_settings, 'playsinline' ) ) {
				$video_attr .= ' playsinline';
			}
			if( !empty( $video_poster ) ) {
				$video_attr .= ' poster="' . esc_url( $video_poster ) . '"';
			}
			$video_attr .= ' preload="' . esc_attr( $video_preload ) . '"';

		}
		return $video_attr;
	}
}

/**
 * Generic function that prints a video ( Embed or HTML5 )
 */
function movedo_grve_print_media_video( $video_mode, $video_webm, $video_mp4, $video_ogv, $video_embed, $video_poster = '' ) {
	global $wp_embed;
	$video_output = '';

	if( empty( $video_mode ) ) {
		if ( !empty( $video_embed ) ) {
			$video_output .= '<div class="grve-media">';
			$video_output .= $wp_embed->run_shortcode( '[embed]' . $video_embed . '[/embed]' );
			$video_output .= '</div>';
		}

	} elseif( 'code' == $video_mode ) {
		if ( !empty( $video_embed ) ) {
			$video_output .= '<div class="grve-media">' . $video_embed . '</div>';
		}
	} else {

		if ( !empty( $video_webm ) || !empty( $video_mp4 ) || !empty( $video_ogv ) ) {

			$video_settings = array(
				'controls' => 'yes',
				'poster' => $video_poster,
			);
			$video_settings = apply_filters( 'movedo_grve_media_video_settings', $video_settings );

			$video_output .= '<div class="grve-media">';
			$video_output .= '  <video ' . movedo_grve_print_media_video_settings( $video_settings ) . ' >';

			if ( !empty( $video_webm ) ) {
				$video_output .= '<source src="' . esc_url( $video_webm ) . '" type="video/webm">';
			}
			if ( !empty( $video_mp4 ) ) {
				$video_output .= '<source src="' . esc_url( $video_mp4 ) . '" type="video/mp4">';
			}
			if ( !empty( $video_ogv ) ) {
				$video_output .= '<source src="' . esc_url( $video_ogv ) . '" type="video/ogg">';
			}
			$video_output .='  </video>';
			$video_output .= '</div>';

		}
	}

	echo  $video_output;

}

function movedo_grve_get_image_size( $image_mode = 'large' ) {

	switch( $image_mode ) {
		case 'thumbnail':
			$image_size = 'thumbnail';
		break;
		case 'medium':
			$image_size = 'medium';
		break;
		case 'medium_large':
			$image_size = 'medium_large';
		break;
		case 'large':
			$image_size = 'large';
		break;
		case 'square':
			$image_size = 'movedo-grve-small-square';
		break;
		case 'landscape':
			$image_size = 'movedo-grve-small-rect-horizontal';
		break;
		case 'landscape-medium':
			$image_size = 'movedo-grve-medium-rect-horizontal';
		break;
		case 'portrait':
			$image_size = 'movedo-grve-small-rect-vertical';
		break;
		case 'portrait-medium':
			$image_size = 'movedo-grve-medium-rect-vertical';
		break;
		case 'landscape-large-wide':
			$image_size = 'movedo-grve-large-rect-horizontal';
		break;
		case 'fullscreen':
		case 'extra-extra-large':
			$image_size = 'movedo-grve-fullscreen';
		break;
		case 'full':
			$image_size = 'full';
		break;
		default:
			$image_size = 'large';
		break;
	}

	return $image_size;

}

function movedo_grve_get_fallback_image_attr( $size = 'movedo-grve-small-rect-horizontal' ) {

	$image_atts = array();

	switch( $size ) {
		case 'thumbnail':
			$image_atts['width'] = "150";
			$image_atts['height'] = "150";
		break;
		case 'medium':
			$image_atts['width'] = "300";
			$image_atts['height'] = "300";
		break;
		case 'large':
			$image_atts['width'] = "1024";
			$image_atts['height'] = "768";
		break;
		case 'movedo-grve-small-square':
			$image_atts['width'] = "560";
			$image_atts['height'] = "560";
		break;
		case 'movedo-grve-medium-square':
			$image_atts['width'] = "900";
			$image_atts['height'] = "900";
		break;
		case 'movedo-grve-small-rect-horizontal':
			$image_atts['width'] = "560";
			$image_atts['height'] = "420";
		break;
		case 'movedo-grve-medium-rect-horizontal':
			$image_atts['width'] = "900";
			$image_atts['height'] = "675";
		break;
		case 'movedo-grve-small-rect-vertical':
			$image_atts['width'] = "560";
			$image_atts['height'] = "745";
		break;
		case 'movedo-grve-medium-rect-vertical':
			$image_atts['width'] = "840";
			$image_atts['height'] = "1120";
		break;
		case 'movedo-grve-fullscreen':
		default:
			$size = 'full';
			$image_atts['width'] = "1920";
			$image_atts['height'] = "1080";
		break;
	}
	$placeholder_mode = movedo_grve_option( 'placeholder_mode', 'dummy' );
	$placeholder_mode =  apply_filters( 'movedo_grve_placeholder_mode', $placeholder_mode );
	switch( $placeholder_mode ) {
		case 'placehold':
			$image_atts['url'] = 'https://placehold.it/' . $image_atts['width'] . 'x' . $image_atts['height'];
		break;
		case 'unsplash':
			$image_atts['url'] = 'https://source.unsplash.com/category/people/' . $image_atts['width'] . 'x' . $image_atts['height'] . '?sig=' . uniqid();
		break;
		case 'dummy':
		default:
			$image_atts['url'] =  get_template_directory_uri() . '/images/empty/' . $size . '.jpg';
		break;
	}
	$image_atts['class'] = 'attachment-' . $size . ' size-' . $size ;
	$image_atts['alt'] = "Dummy Image";

	return $image_atts;

}

function movedo_grve_get_fallback_image( $size = 'movedo-grve-small-rect-horizontal', $mode = '' ) {
	$html = '';
	$image_atts = movedo_grve_get_fallback_image_attr( $size );
	if( 'url' == $mode ) {
		$html = $image_atts['url'];
	} else {
		$html = '<img class="' . esc_attr( $image_atts['class'] ) . '" alt="' . esc_attr( $image_atts['alt'] ) . '" src="' . esc_url( $image_atts['url'] ) . '" width="' . esc_attr( $image_atts['width'] ) . '" height="' . esc_attr( $image_atts['height'] ) . '">';
	}
	return $html;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
