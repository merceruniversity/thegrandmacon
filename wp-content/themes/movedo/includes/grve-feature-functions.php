<?php

/*
*	Feature Helper functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


/**
 * Get Validate Header Style
 */

function movedo_grve_validate_header_style( $movedo_grve_header_style ) {

	$header_styles = array( 'default', 'dark', 'light' );
	if ( !in_array( $movedo_grve_header_style, $header_styles ) ) {
		$movedo_grve_header_style = 'default';
	}
	return $movedo_grve_header_style;

}

/**
 * Get Header Feature Header Section Data
 */

function movedo_grve_get_feature_header_data() {
	global $post;

	$movedo_grve_header_position = 'above';
	if( movedo_grve_is_woo_tax() ) {
		$movedo_grve_header_style = movedo_grve_option( 'product_tax_header_style', 'default' );
		$movedo_grve_header_overlapping = movedo_grve_option( 'product_tax_header_overlapping', 'no' );
	}  elseif ( movedo_grve_events_calendar_is_overview() || is_post_type_archive( 'tribe_events' ) ) {
		$movedo_grve_header_style = movedo_grve_option( 'event_tax_header_style', 'default' );
		$movedo_grve_header_overlapping = movedo_grve_option( 'event_tax_header_overlapping', 'no' );
	} else {
		$movedo_grve_header_style = movedo_grve_option( 'blog_header_style', 'default' );
		$movedo_grve_header_overlapping = movedo_grve_option( 'blog_header_overlapping', 'no' );
	}

	$feature_size = '';

	$movedo_grve_woo_shop = movedo_grve_is_woo_shop();

	if ( is_search() ) {
		$movedo_grve_header_style =  movedo_grve_option( 'search_page_header_style' );
		$movedo_grve_header_overlapping =  movedo_grve_option( 'search_page_header_overlapping' );
	}

	if ( is_singular() || $movedo_grve_woo_shop ) {

		if ( $movedo_grve_woo_shop ) {
			$post_id = wc_get_page_id( 'shop' );
		} else {
			$post_id = $post->ID;
		}
		$post_type = get_post_type( $post_id );

		switch( $post_type ) {
			case 'product':
				$movedo_grve_header_style =  movedo_grve_post_meta( '_movedo_grve_header_style', movedo_grve_option( 'product_header_style' ) );
				$movedo_grve_header_overlapping =  movedo_grve_post_meta( '_movedo_grve_header_overlapping', movedo_grve_option( 'product_header_overlapping' ) );
			break;
			case 'portfolio':
				$movedo_grve_header_style =  movedo_grve_post_meta( '_movedo_grve_header_style', movedo_grve_option( 'portfolio_header_style' ) );
				$movedo_grve_header_overlapping =  movedo_grve_post_meta( '_movedo_grve_header_overlapping', movedo_grve_option( 'portfolio_header_overlapping' ) );
			break;
			case 'post':
				$movedo_grve_header_style =  movedo_grve_post_meta( '_movedo_grve_header_style', movedo_grve_option( 'post_header_style' ) );
				$movedo_grve_header_overlapping =  movedo_grve_post_meta( '_movedo_grve_header_overlapping', movedo_grve_option( 'post_header_overlapping' ) );
			break;
			case 'tribe_events':
				$movedo_grve_header_style =  movedo_grve_post_meta( '_movedo_grve_header_style', movedo_grve_option( 'event_header_style' ) );
				$movedo_grve_header_overlapping =  movedo_grve_post_meta( '_movedo_grve_header_overlapping', movedo_grve_option( 'event_header_overlapping' ) );
			break;
			case 'tribe_organizer':
			case 'tribe_venue':
				$movedo_grve_header_style = 'default';
				$movedo_grve_header_overlapping = 'no';
			break;
			case 'page':
			default:
				if ( $movedo_grve_woo_shop ) {
					$movedo_grve_header_style =  movedo_grve_post_meta_shop( '_movedo_grve_header_style', movedo_grve_option( 'page_header_style' ) );
					$movedo_grve_header_overlapping =  movedo_grve_post_meta_shop( '_movedo_grve_header_overlapping', movedo_grve_option( 'page_header_overlapping' ) );
				} else {
					$movedo_grve_header_style =  movedo_grve_post_meta( '_movedo_grve_header_style', movedo_grve_option( 'page_header_style' ) );
					$movedo_grve_header_overlapping =  movedo_grve_post_meta( '_movedo_grve_header_overlapping', movedo_grve_option( 'page_header_overlapping' ) );
				}
			break;
		}

		//Force Overlapping for Scrolling Full Width Sections Template
		if ( is_page_template( 'page-templates/template-full-page.php' ) ) {
			$movedo_grve_header_overlapping = 'yes';
		} else {

			$feature_section_post_types = movedo_grve_option( 'feature_section_post_types');

			if ( !empty( $feature_section_post_types ) && in_array( $post_type, $feature_section_post_types ) ) {

				$feature_section = get_post_meta( $post_id, '_movedo_grve_feature_section', true );
				$feature_settings = movedo_grve_array_value( $feature_section, 'feature_settings' );
				$feature_element = movedo_grve_array_value( $feature_settings, 'element' );

				if ( !empty( $feature_element ) ) {

					$feature_single_item = movedo_grve_array_value( $feature_section, 'single_item' );
					$movedo_grve_header_position = movedo_grve_array_value( $feature_settings, 'header_position' );
					if ( 'slider' ==  $feature_element ) {

						$slider_items = movedo_grve_array_value( $feature_section, 'slider_items' );
						if ( !empty( $slider_items ) ) {
							$movedo_grve_header_style = isset( $slider_items[0]['header_style'] ) ? $slider_items[0]['header_style'] : 'default';
						}

					}
				}
			}
		}
	}
	if( movedo_grve_is_bbpress() ) {
		$movedo_grve_header_style =  movedo_grve_option( 'forum_header_style' );
		$movedo_grve_header_overlapping =  movedo_grve_option( 'forum_header_overlapping' );
	}

	if( is_404() ) {
		$movedo_grve_header_style =  movedo_grve_option( 'page_404_header_style' );
		$movedo_grve_header_overlapping =  movedo_grve_option( 'page_404_header_overlapping' );
	}

	return array(
		'data_overlap' => $movedo_grve_header_overlapping,
		'data_header_position' => $movedo_grve_header_position,
		'header_style' => movedo_grve_validate_header_style( $movedo_grve_header_style ),
	);

}

/**
 * Prints Header Feature Section Page/Post/Portfolio
 */
function movedo_grve_print_header_feature() {

	//Skip for  Scrolling Full Width Sections Template
	if ( is_page_template( 'page-templates/template-full-page.php' ) ) {
		return false;
	}

	global $post;

	$movedo_grve_woo_shop = movedo_grve_is_woo_shop();

	if ( is_singular() || $movedo_grve_woo_shop ) {

		if ( $movedo_grve_woo_shop ) {
			$post_id = wc_get_page_id( 'shop' );
		} else {
			$post_id = $post->ID;
		}
		$post_type = get_post_type( $post_id );
		$feature_section_post_types = movedo_grve_option( 'feature_section_post_types');
		if ( !empty( $feature_section_post_types ) && in_array( $post_type, $feature_section_post_types ) ) {

			$feature_section = get_post_meta( $post_id, '_movedo_grve_feature_section', true );
			$feature_settings = movedo_grve_array_value( $feature_section, 'feature_settings' );
			$feature_element = movedo_grve_array_value( $feature_settings, 'element' );

			if ( !empty( $feature_element ) ) {

				$feature_single_item = movedo_grve_array_value( $feature_section, 'single_item' );

				switch( $feature_element ) {
					case 'title':
						if ( !empty( $feature_single_item ) ) {
							movedo_grve_print_header_feature_single( $feature_settings, $feature_single_item, 'title' );
						}
						break;
					case 'image':
						if ( !empty( $feature_single_item ) ) {
							movedo_grve_print_header_feature_single( $feature_settings, $feature_single_item, 'image' );
						}
						break;
					case 'video':
						if ( !empty( $feature_single_item ) ) {
							movedo_grve_print_header_feature_single( $feature_settings, $feature_single_item, 'video' );
						}
						break;
					case 'youtube':
						if ( !empty( $feature_single_item ) ) {
							movedo_grve_print_header_feature_single( $feature_settings, $feature_single_item, 'youtube' );
						}
						break;
					case 'slider':
						$slider_items = movedo_grve_array_value( $feature_section, 'slider_items' );
						$slider_settings = movedo_grve_array_value( $feature_section, 'slider_settings' );
						if ( !empty( $slider_items ) ) {
							movedo_grve_print_header_feature_slider( $feature_settings, $slider_items, $slider_settings );
						}
						break;
					case 'map':
						$map_items = movedo_grve_array_value( $feature_section, 'map_items' );
						$map_settings = movedo_grve_array_value( $feature_section, 'map_settings' );
						if ( !empty( $map_items ) ) {
							movedo_grve_print_header_feature_map( $feature_settings, $map_items, $map_settings );
						}
						break;
					case 'revslider':
						$revslider_alias = movedo_grve_array_value( $feature_section, 'revslider_alias' );
						if ( !empty( $revslider_alias ) ) {
							movedo_grve_print_header_feature_revslider( $feature_settings, $revslider_alias, $feature_single_item );
						}
						break;
					default:
						break;

				}
			}
		}
	}
}


/**
 * Prints Overlay Container
 */
function movedo_grve_print_overlay_container( $item ) {

	$pattern_overlay = movedo_grve_array_value( $item, 'pattern_overlay' );
	$color_overlay = movedo_grve_array_value( $item, 'color_overlay', 'dark' );
	$opacity_overlay = movedo_grve_array_value( $item, 'opacity_overlay', '0' );

	if ( 'gradient' == $color_overlay ) {
		$gradient_overlay_custom_1 = movedo_grve_array_value( $item, 'gradient_overlay_custom_1', '#034e90' );
		$gradient_overlay_custom_1_opacity = movedo_grve_array_value( $item, 'gradient_overlay_custom_1_opacity', '0.90' );
		$gradient_overlay_custom_1_rgba = movedo_grve_get_hex2rgba( $gradient_overlay_custom_1 , $gradient_overlay_custom_1_opacity );
		$gradient_overlay_custom_2 = movedo_grve_array_value( $item, 'gradient_overlay_custom_2', '#19b4d7' );
		$gradient_overlay_custom_2_opacity = movedo_grve_array_value( $item, 'gradient_overlay_custom_2_opacity', '0.90' );
		$gradient_overlay_custom_2_rgba = movedo_grve_get_hex2rgba( $gradient_overlay_custom_2 , $gradient_overlay_custom_2_opacity );
		$gradient_overlay_direction  = movedo_grve_array_value( $item, 'gradient_overlay_direction', '90' );
	} else {
		$color_overlay_custom = movedo_grve_array_value( $item, 'color_overlay_custom', '#000000' );
		$color_overlay_custom = movedo_grve_get_color( $color_overlay, $color_overlay_custom );
		$overlay_rgba = movedo_grve_get_hex2rgba( $color_overlay_custom , $opacity_overlay );
	}

	if ( 'default' == $pattern_overlay ) {
		echo '<div class="grve-pattern"></div>';
	}

	$overlay_classes = array('grve-bg-overlay');
	$overlay_string = implode( ' ', $overlay_classes );
	if ( 'gradient' == $color_overlay ) {
		echo '<div class="' . esc_attr( $overlay_string ) . '" style="background:' . esc_attr( $gradient_overlay_custom_1_rgba ) . '; background: linear-gradient(' . esc_attr( $gradient_overlay_direction ) . 'deg,' . esc_attr( $gradient_overlay_custom_1_rgba ) . ' 0%,' . esc_attr( $gradient_overlay_custom_2_rgba ) . ' 100%);"></div>';
	} else {
		if ( '0' != $opacity_overlay && !empty( $opacity_overlay ) ) {
			echo '<div class="' . esc_attr( $overlay_string ) . '" style="background-color:' . esc_attr( $overlay_rgba ) . ';"></div>';
		}
	}

}

/**
 * Prints Background Image Container
 */
function movedo_grve_print_bg_image_container( $item ) {

	$bg_position = movedo_grve_array_value( $item, 'bg_position', 'center-center' );
	$bg_tablet_sm_position = movedo_grve_array_value( $item, 'bg_tablet_sm_position' );

	$bg_image_id = movedo_grve_array_value( $item, 'bg_image_id' );
	$bg_image_size = movedo_grve_array_value( $item, 'bg_image_size' );

	$full_src = wp_get_attachment_image_src( $bg_image_id, 'movedo-grve-fullscreen' );
	$image_url = $full_src[0];
	if( !empty( $image_url ) ) {

		//Adaptive Background URL

		if ( empty ( $bg_image_size ) ) {
			$bg_image_size = movedo_grve_option( 'feature_section_bg_size' );
		}

		$image_url = movedo_grve_get_adaptive_url( $bg_image_id, $bg_image_size );

		$bg_image_classes = array( 'grve-bg-image' );
		$bg_image_classes[] = 'grve-bg-' . $bg_position;
		if ( !empty( $bg_tablet_sm_position ) ) {
			$bg_image_classes[] = 'grve-bg-tablet-sm-' . $bg_tablet_sm_position;
		}
		$bg_image_classes[] = 'grve-bg-image-id-' . $bg_image_id;

		$bg_image_classes_string = implode( ' ', $bg_image_classes );

		echo '<div class="' . esc_attr( $bg_image_classes_string ) . '" style="background-image: url(' . esc_url( $image_url ) . ');"></div>';
	}

}


/**
 * Prints Background Video Container
 */
function movedo_grve_print_bg_video_container( $item ) {

	$bg_video_webm = movedo_grve_array_value( $item, 'video_webm' );
	$bg_video_mp4 = movedo_grve_array_value( $item, 'video_mp4' );
	$bg_video_ogv = movedo_grve_array_value( $item, 'video_ogv' );
	$bg_video_poster = movedo_grve_array_value( $item, 'video_poster', 'no' );
	$bg_video_device = movedo_grve_array_value( $item, 'video_device', 'no' );
	$bg_image_id = movedo_grve_array_value( $item, 'bg_image_id' );

	$loop = movedo_grve_array_value( $item, 'video_loop', 'yes' );
	$muted = movedo_grve_array_value( $item, 'video_muted', 'yes' );

	$full_src = wp_get_attachment_image_src( $bg_image_id, 'movedo-grve-fullscreen' );
	$image_url = esc_url( $full_src[0] );

	$video_poster = $playsinline = '';

	if ( !empty( $image_url ) && 'yes' == $bg_video_poster ) {
		$video_poster = $image_url;
	}
	if ( wp_is_mobile() ) {
		if ( 'yes' == $bg_video_device ) {
			if( !empty( $image_url ) ) {
				$video_poster = $image_url;
			}
			$muted = 'yes';
			$playsinline = 'yes';
		} else {
			return;
		}
	}

	$video_settings = array(
		'preload' => 'auto',
		'autoplay' => 'yes',
		'loop' => $loop,
		'muted' => $muted,
		'poster' => $video_poster,
		'playsinline' => $playsinline,
	);
	$video_settings = apply_filters( 'movedo_grve_feature_video_settings', $video_settings );


	if ( !empty ( $bg_video_webm ) || !empty ( $bg_video_mp4 ) || !empty ( $bg_video_ogv ) ) {
?>
		<div class="grve-bg-video grve-html5-bg-video" data-video-device="<?php echo esc_attr( $bg_video_device ); ?>">
			<video <?php echo movedo_grve_print_media_video_settings( $video_settings );?>>
			<?php if ( !empty ( $bg_video_webm ) ) { ?>
				<source src="<?php echo esc_url( $bg_video_webm ); ?>" type="video/webm">
			<?php } ?>
			<?php if ( !empty ( $bg_video_mp4 ) ) { ?>
				<source src="<?php echo esc_url( $bg_video_mp4 ); ?>" type="video/mp4">
			<?php } ?>
			<?php if ( !empty ( $bg_video_ogv ) ) { ?>
				<source src="<?php echo esc_url( $bg_video_ogv ); ?>" type="video/ogg">
			<?php } ?>
			</video>
		</div>
<?php
	}

}

/**
 * Prints Background YouTube Container
 */
function movedo_grve_print_bg_youtube_container( $item ) {
	$video_url = movedo_grve_array_value( $item, 'video_url' );
	$video_start = movedo_grve_array_value( $item, 'video_start' );
	$video_end = movedo_grve_array_value( $item, 'video_end' );
	$has_video_bg = ( ! empty( $video_url ) && movedo_grve_extract_youtube_id( $video_url ) );
	if ( $has_video_bg ) {
		wp_enqueue_script( 'youtube-iframe-api' );
		$wrapper_attributes = array();
		$wrapper_attributes[] = 'data-video-bg-url="' . esc_attr( $video_url ) . '"';
		if ( !empty( $video_start ) ) {
			$wrapper_attributes[] = 'data-video-start="' . esc_attr( $video_start ) . '"';
		}
		if ( !empty( $video_end ) ) {
			$wrapper_attributes[] = 'data-video-end="' . esc_attr( $video_end ) . '"';
		}
		$wrapper_attributes[] = 'class="grve-bg-video grve-yt-bg-video"';
?>		<div <?php echo implode( ' ', $wrapper_attributes ); ?>></div>
<?php
	}
}

/**
 * Prints Bottom Separator Container
 */
function movedo_grve_print_bottom_seperator_container( $feature_settings ) {
	$separator_bottom = movedo_grve_array_value( $feature_settings, 'separator_bottom' );
	$separator_bottom_color = movedo_grve_array_value( $feature_settings, 'separator_bottom_color' );
	$separator_bottom_size = movedo_grve_array_value( $feature_settings, 'separator_bottom_size' );

	if( !empty ( $separator_bottom ) ) {
		echo '<div class="grve-separator-bottom">';
		echo movedo_grve_build_separator( $separator_bottom, $separator_bottom_color, $separator_bottom_size );
		echo '</div>';
	}
}

/**
 * Get Feature Section data
 */
function movedo_grve_get_feature_data( $feature_settings, $item_type, $item_effect = '', $el_class = '' ) {


	$wrapper_attributes = array();
	$style = "";

	//Background Color
	$bg_color = movedo_grve_array_value( $feature_settings, 'bg_color', 'dark' );

	if ( 'gradient' == $bg_color ) {
		$bg_gradient_color_1  = movedo_grve_array_value( $feature_settings, 'bg_gradient_color_1', '#034e90' );
		$bg_gradient_color_1_rgba = movedo_grve_get_hex2rgba( $bg_gradient_color_1 , 1 );
		$bg_gradient_color_2  = movedo_grve_array_value( $feature_settings, 'bg_gradient_color_2', '#19b4d7' );
		$bg_gradient_color_2_rgba = movedo_grve_get_hex2rgba( $bg_gradient_color_2 , 1 );
		$bg_gradient_direction  = movedo_grve_array_value( $feature_settings, 'bg_gradient_direction', '90' );
	} else {
		$bg_color_custom = movedo_grve_array_value( $feature_settings, 'bg_color_custom', '#000000' );
		$bg_color_custom = movedo_grve_get_color( $bg_color, $bg_color_custom );
	}

	//Data and Style
	if( 'revslider' != $item_type ) {
		$feature_size = movedo_grve_array_value( $feature_settings, 'size' );
		$feature_height = movedo_grve_array_value( $feature_settings, 'height', '60' );
		$feature_min_height = movedo_grve_array_value( $feature_settings, 'min_height', '200' );
		if ( 'gradient' == $bg_color ) {
			$style .= movedo_grve_get_css_color( 'background', $bg_gradient_color_1_rgba );
			$style .= 'background: linear-gradient(' . $bg_gradient_direction . 'deg,' . $bg_gradient_color_1_rgba . ' 0%,' . $bg_gradient_color_2_rgba .' 100%);';
		} else {
			$style .= 'background-color: ' . esc_attr( $bg_color_custom ) . ';';
		}
		if ( !empty($feature_size) ) {
			if ( empty( $feature_height ) ) {
				$feature_height = "60";
			}
			$style .= 'min-height:' . esc_attr( $feature_min_height ) . 'px;';
			$wrapper_attributes[] = 'data-height="' . esc_attr( $feature_height ) . '"';
		}
		$wrapper_attributes[] = 'style="'. esc_attr( $style ) . '"';
	}

	//Classes
	$feature_item_classes = array( 'grve-with-' . $item_type  );

	if( 'revslider' != $item_type ) {
		if ( empty( $feature_size ) ) {
			$feature_item_classes[] = 'grve-fullscreen';
		} else {
			if ( is_numeric( $feature_height ) ) { //Custom Size
				$feature_item_classes[] = 'grve-custom-size';
			} else {
				$feature_item_classes[] = 'grve-' . $feature_height . '-height';
			}
		}

		if ( !empty( $item_effect ) ) {
			$feature_item_classes[] = 'grve-bg-' . $item_effect;
		}
	}

	$separator_bottom = movedo_grve_array_value( $feature_settings, 'separator_bottom' );
	$separator_bottom_size = movedo_grve_array_value( $feature_settings, 'separator_bottom_size' );

	if ( !empty( $separator_bottom ) && '100%' ==  $separator_bottom_size ) {
		$feature_item_classes[] = 'grve-separator-fullheight';
	}

	if ( !empty ( $el_class ) ) {
		$feature_item_classes[] = $el_class;
	}
	$feature_item_class_string = implode( ' ', $feature_item_classes );

	//Add Classes
	$wrapper_attributes[] = 'class="' . esc_attr( $feature_item_class_string ) . '"';

	return $wrapper_attributes;
}

/**
 * Get Feature Section data
 */
function movedo_grve_get_feature_height( $feature_settings ) {

	//Data and Style
	$feature_style_height = '';

	$feature_size = movedo_grve_array_value( $feature_settings, 'size' );
	$feature_height = movedo_grve_array_value( $feature_settings, 'height', '60' );
	$feature_min_height = movedo_grve_array_value( $feature_settings, 'min_height', '200' );
	if ( !empty($feature_size) ) {
		if ( is_numeric( $feature_height ) ) { //Custom Size
			$feature_style_height = 'style="height:' . esc_attr( $feature_height ) . 'vh; min-height:' . esc_attr( $feature_min_height ) . 'px;"';
		} else {
			$feature_style_height = 'style="min-height:' . esc_attr( $feature_min_height ) . 'px;"';
		}
	}
	return $feature_style_height;
}


/**
 * Prints Header Section Feature Single Item
 */
function movedo_grve_print_header_feature_single( $feature_settings, $item, $item_type  ) {

	if( 'image' == $item_type ) {
		$item_effect = movedo_grve_array_value( $item, 'image_effect' );
	} elseif( 'video' == $item_type ) {
		$item_effect = movedo_grve_array_value( $item, 'video_effect' );
	} else {
		$item_effect = '';
	}

	$el_class = movedo_grve_array_value( $item, 'el_class' );

	$feature_data = movedo_grve_get_feature_data( $feature_settings, $item_type, $item_effect, $el_class );

?>
	<div id="grve-feature-section" <?php echo implode( ' ', $feature_data ); ?>>
		<div class="grve-wrapper clearfix" <?php echo movedo_grve_get_feature_height( $feature_settings ); ?>>
			<?php movedo_grve_print_header_feature_content( $feature_settings, $item, $item_type ); ?>
		</div>
		<div class="grve-background-wrapper">
		<?php
			if( 'image' == $item_type || 'video' == $item_type || 'youtube' == $item_type ) {
				movedo_grve_print_bg_image_container( $item );
			}
			if( 'video' == $item_type ) {
				movedo_grve_print_bg_video_container( $item );
			}
			if( 'youtube' == $item_type ) {
				movedo_grve_print_bg_youtube_container( $item );
			}
			movedo_grve_print_overlay_container( $item  );
		?>
		</div>
		<?php movedo_grve_print_bottom_seperator_container( $feature_settings ); ?>
	</div>
<?php
}

/**
 * Prints Feature Slider
 */
function movedo_grve_print_header_feature_slider( $feature_settings, $slider_items, $slider_settings ) {

	$slider_speed = movedo_grve_array_value( $slider_settings, 'slideshow_speed', '3500' );
	$slider_pause = movedo_grve_array_value( $slider_settings, 'slider_pause', 'no' );
	$slider_transition = movedo_grve_array_value( $slider_settings, 'transition', 'slide' );
	$slider_dir_nav = movedo_grve_array_value( $slider_settings, 'direction_nav', '1' );
	$slider_effect = movedo_grve_array_value( $slider_settings, 'slider_effect', '' );
	$slider_pagination = movedo_grve_array_value( $slider_settings, 'pagination', 'yes' );

	$feature_data = movedo_grve_get_feature_data( $feature_settings, 'slider', $slider_effect  );

	$movedo_grve_header_style = isset( $slider_items[0]['header_style'] ) ? $slider_items[0]['header_style'] : 'default';

?>
	<div id="grve-feature-section" <?php echo implode( ' ', $feature_data ); ?>>

		<?php echo movedo_grve_element_navigation( $slider_dir_nav, $movedo_grve_header_style ); ?>

		<div id="grve-feature-slider" data-slider-speed="<?php echo esc_attr( $slider_speed ); ?>" data-pagination="<?php echo esc_attr( $slider_pagination ); ?>" data-slider-pause="<?php echo esc_attr( $slider_pause ); ?>" data-slider-transition="<?php echo esc_attr( $slider_transition ); ?>">

<?php

			foreach ( $slider_items as $item ) {

				$header_style = movedo_grve_array_value( $item, 'header_style', 'default' );
				$movedo_grve_header_style = movedo_grve_validate_header_style( $header_style );

				$slide_type = movedo_grve_array_value( $item, 'type' );
				$slide_post_id = movedo_grve_array_value( $item, 'post_id' );
				if( 'post' == $slide_type &&  !empty( $slide_post_id ) ) {
					if( has_post_thumbnail( $slide_post_id ) && empty( $item['bg_image_id'] ) ) {
						$item['bg_image_id'] = get_post_thumbnail_id( $slide_post_id );
					}
				}

				$el_class = movedo_grve_array_value( $item, 'el_class' );
				$el_id = movedo_grve_array_value( $item, 'id', uniqid() );

?>
				<div class="grve-slider-item grve-slider-item-id-<?php echo esc_attr( $el_id ); ?> <?php echo esc_attr( $el_class ); ?>" data-header-color="<?php echo esc_attr( $movedo_grve_header_style ); ?>">
					<div class="grve-wrapper clearfix" <?php echo movedo_grve_get_feature_height( $feature_settings ); ?>>
						<?php movedo_grve_print_header_feature_content( $feature_settings, $item ); ?>
					</div>
					<div class="grve-background-wrapper">
					<?php
						movedo_grve_print_bg_image_container( $item );
						movedo_grve_print_overlay_container( $item  );
					?>
					</div>
				</div>
<?php
			}
?>
		</div>
		<?php movedo_grve_print_bottom_seperator_container( $feature_settings ); ?>
	</div>
<?php

}

/**
 * Prints Header Feature Map
 */
function movedo_grve_print_header_feature_map( $feature_settings, $map_items, $map_settings ) {

	wp_enqueue_script( 'movedo-grve-maps-script');

	$feature_data = movedo_grve_get_feature_data( $feature_settings, 'map' );
	$map_marker_type = movedo_grve_array_value( $map_settings, 'marker_type' );
	$map_marker_bg_color = movedo_grve_array_value( $map_settings, 'marker_bg_color', 'primary-1' );
	if ( empty( $map_marker_type ) ) {
		$map_marker = movedo_grve_array_value( $map_settings, 'marker', get_template_directory_uri() . '/images/markers/markers.png' );
		$point_type = 'image';
		$point_bg_color = '';
	} else {
		$map_marker = get_template_directory_uri() . '/images/markers/transparent.png';
		$point_type = $map_marker_type;
		$point_bg_color = $map_marker_bg_color;
	}
	

	$map_zoom = movedo_grve_array_value( $map_settings, 'zoom', 14 );
	$map_disable_style = movedo_grve_array_value( $map_settings, 'disable_style', 'no' );

	$map_lat = movedo_grve_array_value( $map_items[0], 'lat', '51.516221' );
	$map_lng = movedo_grve_array_value( $map_items[0], 'lng', '-0.136986' );
	
	$map_attributes = array();
	$map_attributes[] = 'data-lat="' . esc_attr( $map_lat ) . '"';
	$map_attributes[] = 'data-lng="' . esc_attr( $map_lng ) . '"';
	$map_attributes[] = 'data-zoom="' . esc_attr( $map_zoom ) . '"';
	$map_attributes[] = 'data-disable-style="' . esc_attr( $map_disable_style ) . '"';

?>
	<div id="grve-feature-section" <?php echo implode( ' ', $feature_data ); ?>>
		<div class="grve-map grve-wrapper clearfix" <?php echo movedo_grve_get_feature_height( $feature_settings ); ?> <?php echo implode( ' ', $map_attributes ); ?>></div>
		<?php
			foreach ( $map_items as $map_item ) {
				movedo_grve_print_feature_map_point( $map_item, $map_marker, $point_type, $point_bg_color );
			}
		?>
		<?php movedo_grve_print_bottom_seperator_container( $feature_settings ); ?>
	</div>
<?php
}

function movedo_grve_print_feature_map_point( $map_item, $default_marker, $point_type = 'image', $point_bg_color = ''  ) {

	$map_lat = movedo_grve_array_value( $map_item, 'lat', '51.516221' );
	$map_lng = movedo_grve_array_value( $map_item, 'lng', '-0.136986' );
	$map_marker = movedo_grve_array_value( $map_item, 'marker' );
	if ( !empty( $map_marker ) ) {
		$point_type = 'image';
	} else {
		$map_marker = $default_marker;
	}
	$map_marker = str_replace( array( 'http:', 'https:' ), '', $map_marker );

	$map_title = movedo_grve_array_value( $map_item, 'title' );
	$map_infotext = movedo_grve_array_value( $map_item, 'info_text','' );
	$map_infotext_open = movedo_grve_array_value( $map_item, 'info_text_open', 'no' );

	$button_text = movedo_grve_array_value( $map_item, 'button_text' );
	$button_url = movedo_grve_array_value( $map_item, 'button_url' );
	$button_target = movedo_grve_array_value( $map_item, 'button_target', '_self' );
	$button_class = movedo_grve_array_value( $map_item, 'button_class' );
	
	$map_point_attributes = array();
	$map_point_attributes[] = 'data-point-lat="' . esc_attr( $map_lat ) . '"';
	$map_point_attributes[] = 'data-point-lng="' . esc_attr( $map_lng ) . '"';
	$map_point_attributes[] = 'data-point-title="' . esc_attr( $map_title ) . '"';
	$map_point_attributes[] = 'data-point-open="' . esc_attr( $map_infotext_open ) . '"';
	$map_point_attributes[] = 'data-point-type="' . esc_attr( $point_type ) . '"';
	if( 'image' != $point_type ) {
		$map_point_attributes[] = 'data-point-bg-color="' . esc_attr( $point_bg_color ) . '"';
	}

?>
	<div style="display:none" class="grve-map-point" data-point-marker="<?php echo esc_url( $map_marker ); ?>" <?php echo implode( ' ', $map_point_attributes ); ?>>
		<?php if ( !empty( $map_title ) || !empty( $map_infotext ) || !empty( $button_text ) ) { ?>
		<div class="grve-map-infotext">
			<?php if ( !empty( $map_title ) ) { ?>
			<h6 class="grve-infotext-title"><?php echo esc_html( $map_title ); ?></h6>
			<?php } ?>
			<?php if ( !empty( $map_infotext ) ) { ?>
			<p class="grve-infotext-description"><?php echo wp_kses_post( $map_infotext ); ?></p>
			<?php } ?>
			<?php if ( !empty( $button_text ) ) { ?>
			<a class="grve-infotext-link <?php echo esc_attr( $button_class ); ?>" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_text ); ?></a>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
<?php

}

/**
 * Prints Header Feature Revolution Slider
 */
function movedo_grve_print_header_feature_revslider( $feature_settings, $revslider_alias, $item  ) {

	$el_class = movedo_grve_array_value( $item, 'el_class' );
	$feature_data = movedo_grve_get_feature_data( $feature_settings, 'revslider', '', $el_class );

?>
	<div id="grve-feature-section" <?php echo implode( ' ', $feature_data ); ?>>
		<?php echo do_shortcode( '[rev_slider ' . $revslider_alias . ']' ); ?>
	</div>

<?php
}

/**
 * Prints Header Feature Go to Section ( Bottom Arrow )
 */
if ( !function_exists('movedo_grve_print_feature_go_to_section') ) {
	function movedo_grve_print_feature_go_to_section( $feature_settings, $item ) {

		$arrow_enabled = movedo_grve_array_value( $item, 'arrow_enabled', 'no' );
		$arrow_color = movedo_grve_array_value( $item, 'arrow_color', 'light' );
		$arrow_color_custom = movedo_grve_array_value( $item, 'arrow_color_custom', '#ffffff' );
		$arrow_color_custom = movedo_grve_get_color( $arrow_color, $arrow_color_custom );

		if( 'yes' == $arrow_enabled ) {
	?>
			<div id="grve-goto-section-wrapper">
				<i id="grve-goto-section" class="grve-icon-nav-down" style=" color: <?php echo esc_attr( $arrow_color_custom ); ?>;"></i>
			</div>
	<?php
		}
	}
}

/**
 * Prints Header Feature Content Image
 */
if ( !function_exists('movedo_grve_print_feature_content_image') ) {
	function movedo_grve_print_feature_content_image( $item ) {

		$media_id = movedo_grve_array_value( $item, 'content_image_id', '0' );
		$media_size = movedo_grve_array_value( $item, 'content_image_size', 'medium' );

		if( !empty( $media_id ) ) {
	?>
			<div class="grve-graphic">
				<?php echo wp_get_attachment_image( $media_id, $media_size ); ?>
			</div>
	<?php
		}
	}
}


/**
 * Prints Header Section Feature Content
 */
function movedo_grve_print_header_feature_content( $feature_settings, $item, $mode = ''  ) {

	$feature_size = movedo_grve_array_value( $feature_settings, 'size' );

	$title = movedo_grve_array_value( $item, 'title' );
	$caption = movedo_grve_array_value( $item, 'caption' );
	$subheading = movedo_grve_array_value( $item, 'subheading' );

	$subheading_tag = movedo_grve_array_value( $item, 'subheading_tag', 'div' );
	$title_tag = movedo_grve_array_value( $item, 'title_tag', 'div' );
	$caption_tag = movedo_grve_array_value( $item, 'caption_tag', 'div' );

	$movedo_grve_content_container_classes = array( 'grve-content' );
	$movedo_grve_subheading_classes = array( 'grve-subheading', 'grve-title-categories' );
	$movedo_grve_title_classes = array( 'grve-title' );
	$movedo_grve_caption_classes = array( 'grve-description' );
	$movedo_grve_title_meta_classes = array( 'grve-title-meta-content', 'grve-link-text' );
	$movedo_grve_content_classes = array( 'grve-title-content-wrapper' );


	//Content Container Classes
	$content_position = movedo_grve_array_value( $item, 'content_position', 'center-center' );
	$container_size = movedo_grve_array_value( $item, 'container_size' );
	$movedo_grve_content_container_classes[] = 'grve-align-' . $content_position;
	if ( 'large' == $container_size ) {
		$movedo_grve_content_container_classes[] = 'grve-fullwidth';
	}

	$content_bg_color = movedo_grve_array_value( $item, 'content_bg_color', 'none' );
	$content_align = movedo_grve_array_value( $item, 'content_align', 'center' );
	$content_size = movedo_grve_array_value( $item, 'content_size', 'large' );
	if ( 'custom' != $content_bg_color ) {
		$movedo_grve_content_classes[] = 'grve-bg-' . $content_bg_color;
	}
	$movedo_grve_content_classes[] = 'grve-align-' . $content_align;
	$movedo_grve_content_classes[] = 'grve-content-' . $content_size;


	$subheading_color = movedo_grve_array_value( $item, 'subheading_color', 'light' );
	$title_color = movedo_grve_array_value( $item, 'title_color', 'light' );
	$caption_color = movedo_grve_array_value( $item, 'caption_color', 'light' );

	$subheading_family = movedo_grve_array_value( $item, 'subheading_family' );
	$title_family = movedo_grve_array_value( $item, 'title_family' );
	$caption_family = movedo_grve_array_value( $item, 'caption_family' );

	if ( !empty( $subheading_family ) ) {
		$movedo_grve_subheading_classes[] = 'grve-' . $subheading_family;
	}
	if ( !empty( $title_family ) ) {
		$movedo_grve_title_classes[] = 'grve-' . $title_family;
	}
	if ( !empty( $caption_family ) ) {
		$movedo_grve_caption_classes[] = 'grve-' . $caption_family;
	}

	if ( 'custom' != $subheading_color ) {
		$movedo_grve_subheading_classes[] = 'grve-text-' . $subheading_color;
		$movedo_grve_title_meta_classes[] = 'grve-text-' . $subheading_color;
	}
	if ( 'custom' != $title_color ) {
		$movedo_grve_title_classes[] = 'grve-text-' . $title_color;
	}
	if ( 'custom' != $caption_color ) {
		$movedo_grve_caption_classes[] = 'grve-text-' . $caption_color;
	}

	$movedo_grve_content_container_classes = implode( ' ', $movedo_grve_content_container_classes );
	$movedo_grve_subheading_classes = implode( ' ', $movedo_grve_subheading_classes );
	$movedo_grve_title_classes = implode( ' ', $movedo_grve_title_classes );
	$movedo_grve_caption_classes = implode( ' ', $movedo_grve_caption_classes );
	$movedo_grve_title_meta_classes = implode( ' ', $movedo_grve_title_meta_classes );
	$movedo_grve_content_classes = implode( ' ', $movedo_grve_content_classes );

	$content_animation = movedo_grve_array_value( $item, 'content_animation', 'fade-in' );

	$button = movedo_grve_array_value( $item, 'button' );
	$button2 = movedo_grve_array_value( $item, 'button2' );

	$button_text = movedo_grve_array_value( $button, 'text' );
	$button_text2 = movedo_grve_array_value( $button2, 'text' );

	$slide_type = movedo_grve_array_value( $item, 'type' );
	$slide_post_id = movedo_grve_array_value( $item, 'post_id' );
	if( 'post' == $slide_type &&  !empty( $slide_post_id ) ) {
		$title = get_the_title ( $slide_post_id  );
		$caption = get_post_meta( $slide_post_id, '_movedo_grve_description', true );
		$link_url = get_permalink( $slide_post_id ) ;
	}

?>
	<div class="<?php echo esc_attr( $movedo_grve_content_container_classes ); ?>" data-animation="<?php echo esc_attr( $content_animation ); ?>">
		<div class="grve-container">
			<div class="<?php echo esc_attr( $movedo_grve_content_classes ); ?>">
			<?php if( 'post' == $slide_type &&  !empty( $slide_post_id ) ) { ?>
				<div class="<?php echo esc_attr( $movedo_grve_subheading_classes ); ?>">
					<?php movedo_grve_print_post_title_categories( $slide_post_id ); ?>
				</div>
				<a href="<?php echo esc_url( $link_url ); ?>">
					<<?php echo tag_escape( $title_tag ); ?> class="<?php echo esc_attr( $movedo_grve_title_classes ); ?>"><span><?php echo wp_kses_post( $title ); ?></span></<?php echo tag_escape( $title_tag ); ?>>
				</a>
				<?php if ( !empty( $caption ) ) { ?>
				<<?php echo tag_escape( $caption_tag ); ?> class="<?php echo esc_attr( $movedo_grve_caption_classes ); ?>"><span><?php echo wp_kses_post( $caption ); ?></span></<?php echo tag_escape( $caption_tag ); ?>>
				<?php } ?>
				<div class="<?php echo esc_attr( $movedo_grve_title_meta_classes ); ?>">
				<?php movedo_grve_print_feature_post_title_meta( $slide_post_id ); ?>
				</div>
			<?php } else { ?>
				<?php movedo_grve_print_feature_content_image( $item ); ?>
				<?php if ( !empty( $subheading ) ) { ?>
				<<?php echo tag_escape( $subheading_tag ); ?> class="<?php echo esc_attr( $movedo_grve_subheading_classes ); ?>"><span><?php echo wp_kses_post( $subheading ); ?></span></<?php echo tag_escape( $subheading_tag ); ?>>
				<?php } ?>
				<?php if ( !empty( $title ) ) { ?>
				<<?php echo tag_escape( $title_tag ); ?> class="<?php echo esc_attr( $movedo_grve_title_classes ); ?>"><span><?php echo wp_kses_post( $title ); ?></span></<?php echo tag_escape( $title_tag ); ?>>
				<?php } ?>
				<?php if ( !empty( $caption ) ) { ?>
				<<?php echo tag_escape( $caption_tag ); ?> class="<?php echo esc_attr( $movedo_grve_caption_classes ); ?>"><span><?php echo wp_kses_post( $caption ); ?></span></<?php echo tag_escape( $caption_tag ); ?>>
				<?php } ?>

				<?php
					if( 'title' != $mode && ( !empty( $button_text ) || !empty( $button_text2 ) ) ) {
					$btn1_class = $btn2_class = 'grve-btn-1';
					if ( !empty( $button_text ) && !empty( $button_text2 ) ) {
						$btn2_class = 'grve-btn-2';
					}
				?>
					<div class="grve-button-wrapper">
						<?php movedo_grve_print_feature_button( $button, $btn1_class ); ?>
						<?php movedo_grve_print_feature_button( $button2, $btn2_class ); ?>
					</div>
				<?php
					}
				?>
				<?php movedo_grve_print_feature_go_to_section( $feature_settings, $item ); ?>
			<?php } ?>
			</div>
		</div>
	</div>
<?php
}

/**
 * Prints Header Feature Button
 */
function movedo_grve_print_feature_button( $item, $extra_class = 'grve-btn-1' ) {

	$button_id = movedo_grve_array_value( $item, 'id' );
	$button_text = movedo_grve_array_value( $item, 'text' );
	$button_url = movedo_grve_array_value( $item, 'url' );
	$button_type = movedo_grve_array_value( $item, 'type' );
	$button_size = movedo_grve_array_value( $item, 'size', 'medium' );
	$button_color = movedo_grve_array_value( $item, 'color', 'primary-1' );
	$button_hover_color = movedo_grve_array_value( $item, 'hover_color', 'black' );
	$button_gradient_color_1 = movedo_grve_array_value( $item, 'gradient_1_color', 'primary-1' );
	$button_gradient_color_2 = movedo_grve_array_value( $item, 'gradient_2_color', 'primary-2' );
	$button_shape = movedo_grve_array_value( $item, 'shape', 'square' );
	$button_shadow = movedo_grve_array_value( $item, 'shadow' );
	$button_target = movedo_grve_array_value( $item, 'target', '_self' );
	$button_class = movedo_grve_array_value( $item, 'class' );

	if ( !empty( $button_text ) ) {

		//Button Classes
		$button_classes = array( 'grve-btn' );

		$button_classes[] = $extra_class;
		$button_classes[] = 'grve-btn-' . $button_size;
		$button_classes[] = 'grve-' . $button_shape;
		if ( !empty( $button_shadow ) ) {
			$button_classes[] = 'grve-shadow-' . $button_shadow;
		}
		if ( 'outline' == $button_type ) {
			$button_classes[] = 'grve-btn-line';
		}
		if ( !empty( $button_class ) ) {
			$button_classes[] = $button_class;
		}

		if ( 'gradient' == $button_type ) {
			$uid = $button_id;
			$button_classes[] = 'grve-btn-gradient';
			$button_classes[] = 'grve-btn-' . $uid;
			$button_classes[] = 'grve-bg-' . $button_hover_color;
			$button_classes[] = 'grve-bg-hover-' . $button_hover_color;

			$colors = movedo_grve_get_color_array();

			$gradient_color_1 = movedo_grve_array_value( $colors, $button_gradient_color_1, '#000000');
			$gradient_color_2 = movedo_grve_array_value( $colors, $button_gradient_color_2, '#000000');

			$gradient_css = array();
			$gradient_css[] = 'background-color: ' . esc_attr( $gradient_color_1 );
			$gradient_css[] = 'background-image: -moz-linear-gradient(left, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
			$gradient_css[] = 'background-image: -webkit-linear-gradient(left, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
			$gradient_css[] = 'background-image: linear-gradient(to right, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
?>
			<style type="text/css">
			.grve-btn-gradient.grve-btn-<?php echo esc_attr( $uid ). '.' . $extra_class; ?>:before {
			<?php echo implode( ';', $gradient_css ) . ';'; ?>
			}
			</style>
<?php
		} else {
			$button_classes[] = 'grve-bg-' . $button_color;
			$button_classes[] = 'grve-bg-hover-' . $button_hover_color;
		}

		$button_class_string = implode( ' ', $button_classes );

		if ( !empty( $button_url ) ) {
			$url = $button_url;
			$target = $button_target;
		} else {
			$url = "#";
			$target= "_self";
		}

?>
		<a class="<?php echo esc_attr( $button_class_string ); ?>" href="<?php echo esc_url( $url ); ?>"  target="<?php echo esc_attr( $target ); ?>">
			<span><?php echo esc_html( $button_text ); ?></span>
		</a>
<?php

	}

}

//Omit closing PHP tag to avoid accidental whitespace output errors.
