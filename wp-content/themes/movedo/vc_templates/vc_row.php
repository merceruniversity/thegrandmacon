<?php

	$output = $out_pattern = $out_overlay = $out_image_bg = $out_video_bg = '';

	extract(
		shortcode_atts(
			array(
				'section_id'      => '',
				'font_color'      => '',
				'heading_color' => '',
				'section_type'      => 'fullwidth-background',
				'columns_gap' => '30',
				'section_full_height' => 'no',
				'equal_column_height' => 'none',
				'desktop_visibility' => '',
				'tablet_visibility' => '',
				'tablet_sm_visibility' => '',
				'mobile_visibility' => '',
				'tablet_landscape_equal_column_height' => '',
				'tablet_portrait_equal_column_height' => '',
				'mobile_equal_column_height' => '',
				'tablet_landscape_full_height' => '',
				'tablet_portrait_full_height' => '',
				'mobile_full_height' => '',
				'bg_color'        => '',
				'bg_gradient_color_1' => 'rgba(3,78,144,0.9)',
				'bg_gradient_color_2' => 'rgba(25,180,215,0.9)',
				'bg_gradient_direction' => '90',
				'bg_type'         => '',
				'bg_image'        => '',
				'bg_image_type'   => 'none',
				'bg_image_size'   => '',
				'bg_image_vertical_position' => 'center',
				'bg_position' => 'center-center',
				'bg_tablet_sm_position' => '',
				'parallax_threshold' => '0.3',
				'pattern_overlay' => '',
				'color_overlay' => '',
				'color_overlay_custom' => 'rgba(255,255,255,0.1)',
				'gradient_overlay_custom_1' => 'rgba(3,78,144,0.9)',
				'gradient_overlay_custom_2' => 'rgba(25,180,215,0.9)',
				'gradient_overlay_direction' => '90',
				'opacity_overlay' => '10',
				'bg_video_effect'   => '',
				'bg_video_parallax_threshold' => '0.3',
				'bg_video_webm' => '',
				'bg_video_mp4' => '',
				'bg_video_ogv' => '',
				'bg_video_loop' => 'yes',
				'bg_video_device' => 'no',
				'bg_video_url' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
				'bg_video_button' => '',
				'bg_video_button_position' => 'center-center',
				'separator_top' => '',
				'separator_top_size' => '90px',
				'separator_top_color' => '#ffffff',
				'separator_bottom' => '',
				'separator_bottom_size' => '90px',
				'separator_bottom_color' => '#ffffff',
				'padding_top_multiplier' => '1x',
				'padding_bottom_multiplier' => '1x',
				'padding_top' => '',
				'padding_bottom' => '',
				'margin_bottom' => '',
				'el_class'        => '',
				'el_wrapper_class' => '',
				'el_id'        => '',
				'css' => '',
				'scroll_section_title' => '',
				'scroll_header_style' => 'dark',
			),
			$atts
		)
	);

	if ( 'image' == $bg_type || 'hosted_video' == $bg_type || 'video' == $bg_type  ) {

		if ( !empty ( $color_overlay ) && 'custom' != $color_overlay && 'gradient' != $color_overlay ) {

			//Overlay Classes
			$overlay_classes = array();
			$overlay_classes[] = 'grve-bg-overlay grve-bg-' . $color_overlay;
			if ( !empty ( $opacity_overlay ) ) {
				$overlay_classes[] = 'grve-opacity-' . $opacity_overlay;
			}
			$overlay_string = implode( ' ', $overlay_classes );
			$out_overlay .= '  <div class="' . esc_attr( $overlay_string ) .'"></div>';
		}

		if ( 'custom' == $color_overlay ) {
			$out_overlay .= '  <div class="grve-bg-overlay" style="background-color:' . esc_attr( $color_overlay_custom ) . '"></div>';
		}

		if ( 'gradient' == $color_overlay ) {
			$out_overlay .= '  <div class="grve-bg-overlay" style="background:' . esc_attr( $gradient_overlay_custom_1 ) . '; background: linear-gradient(' . esc_attr( $gradient_overlay_direction ) . 'deg,' . esc_attr( $gradient_overlay_custom_1 ) . ' 0%,' . esc_attr( $gradient_overlay_custom_2 ) . ' 100%);"></div>';
		}
	}

	// Pattern Overlay
	if ( !empty ( $pattern_overlay ) ) {
		$out_pattern .= '  <div class="grve-pattern"></div>';
	}

	//Background Image Classses
	$bg_image_classes = array( 'grve-bg-image' );

	if( 'horizontal-parallax-lr' == $bg_image_type || 'horizontal-parallax-rl' == $bg_image_type || 'horizontal' == $bg_image_type ){
		$bg_image_classes[] = 'grve-bg-center-' . $bg_image_vertical_position;
	}

	if( '' == $bg_image_type || 'none' == $bg_image_type || 'animated' == $bg_image_type ){
		$bg_image_classes[] = 'grve-bg-' . $bg_position;
		if ( !empty( $bg_tablet_sm_position ) ) {
			$bg_image_classes[] = 'grve-bg-tablet-sm-' . $bg_tablet_sm_position;
		}
	}

	if( $bg_image > 0 ){
		$bg_image_classes[] = 'grve-bg-image-id-' . $bg_image ;
	}

	$bg_image_string = implode( ' ', $bg_image_classes );

	//Background Image
	$img_style = movedo_grve_build_shortcode_img_style( $bg_image ,$bg_image_size );

	if ( 'image' == $bg_type ) {
		$out_image_bg .= '  <div class="' . esc_attr( $bg_image_string ) . '"  ' . $img_style . '></div>';
	}

	if ( ( 'hosted_video' == $bg_type || 'video' == $bg_type ) && !empty ( $bg_image ) ) {
		$out_image_bg .= '  <div class="' . esc_attr( $bg_image_string ) . '"  ' . $img_style . '></div>';
	}

	//Background Video
	if ( 'hosted_video' == $bg_type && ( !empty ( $bg_video_webm ) || !empty ( $bg_video_mp4 ) || !empty ( $bg_video_ogv ) ) ) {

		$has_video_bg = true;
		$video_poster = '';
		if ( wp_is_mobile() ) {
			if ( 'yes' == $bg_video_device ) {
				$video_poster = movedo_grve_vc_shortcode_img_url( $bg_image ,$bg_image_size );
				$muted = 'yes';
				$playsinline = 'yes';
			} else {
				$has_video_bg = false;
			}
		}

		if ( $has_video_bg ) {
			$video_settings = array(
				'preload' => 'auto',
				'autoplay' => 'yes',
				'loop' => $bg_video_loop,
				'muted' => 'yes',
				'poster' => $video_poster,
			);

			$out_video_bg .= '<div class="grve-bg-video grve-html5-bg-video" data-video-device="' . esc_attr( $bg_video_device ) .'">';
			$out_video_bg .=  '<video data-autoplay ' . movedo_grve_print_media_video_settings( $video_settings ) . '>';
			if ( !empty ( $bg_video_webm ) ) {
				$out_video_bg .=  '<source src="' . esc_url( $bg_video_webm ) . '" type="video/webm">';
			}
			if ( !empty ( $bg_video_mp4 ) ) {
				$out_video_bg .=  '<source src="' . esc_url( $bg_video_mp4 ) . '" type="video/mp4">';
			}
			if ( !empty ( $bg_video_ogv ) ) {
				$out_video_bg .=  '<source src="' . esc_url( $bg_video_ogv ) . '" type="video/ogg">';
			}
			$out_video_bg .=  '</video>';
			$out_video_bg .= '</div>';
		}
	}

	//YouTube Video
	$out_video_bg_url = '';
	$has_video_bg = ( 'video' == $bg_type && ! empty( $bg_video_url ) && movedo_grve_extract_youtube_id( $bg_video_url ) );
	if ( $has_video_bg ) {
		wp_enqueue_script( 'youtube-iframe-api' );
		$out_video_bg_url .= '<div class="grve-bg-video grve-yt-bg-video" data-video-bg-url="' . esc_attr( $bg_video_url ) . '"></div>';
		if ( !empty( $bg_video_button ) ) {
			$out_video_bg_url .= '<a class="grve-video-popup grve-bg-video-button-' . esc_attr( $bg_video_button ) . '" href="' . esc_url( $bg_video_url ) . '">';
			$out_video_bg_url .= '<div class="grve-video-icon grve-icon-' . esc_attr( $bg_video_button_position )  . ' grve-icon-video grve-bg-primary-1"></div>';
			$out_video_bg_url .= '</a>';
		}
	}

	//Section Classses
	$section_classes = array( 'grve-section', 'grve-row-section' );

	$section_classes[] = 'grve-' . $section_type ;

	if ( !empty ( $padding_top_multiplier ) && 'custom' != $padding_top_multiplier  ) {
		$section_classes[] = 'grve-padding-top-' . $padding_top_multiplier;
	} else if( 'custom' != $padding_top_multiplier ) {
		$padding_top ="";
	}

	if ( !empty ( $padding_bottom_multiplier ) && 'custom' != $padding_bottom_multiplier ) {
		$section_classes[] = 'grve-padding-bottom-' . $padding_bottom_multiplier;
	} else if( 'custom' != $padding_bottom_multiplier ) {
		$padding_bottom ="";
	}

	if( 'horizontal-parallax-lr' == $bg_image_type || 'horizontal-parallax-rl' == $bg_image_type ){
		$section_classes[] = 'grve-' . $bg_image_type;
		$section_classes[] = 'grve-bg-parallax';
	} else {
		$section_classes[] = 'grve-bg-' . $bg_image_type;
	}

	if ( 'hosted_video' == $bg_type && 'parallax' == $bg_video_effect  ) {
		$section_classes[] = 'grve-bg-parallax';
	}

	if ( !empty ( $heading_color ) ) {
		$section_classes[] = 'grve-headings-' . $heading_color;
	}
	if( 'none' != $equal_column_height ||  'no' != $section_full_height ) {
		$section_classes[] = 'grve-custom-height';
	}
	if( 'none' != $equal_column_height ) {
		$section_classes[] = 'grve-' . $equal_column_height;
	}
	if( 'no' != $section_full_height ) {
		$section_classes[] = 'grve-' . $section_full_height;
		$section_classes[] = 'grve-with-fullheight';
	}
	if( !empty ( $separator_type ) ) {
		$section_classes[] = 'grve-separator-section';
	}
	if ( !empty ( $el_class ) ) {
		$section_classes[] = $el_class;
	}

	if( vc_settings()->get( 'not_responsive_css' ) != '1') {
		if ( !empty( $desktop_visibility ) ) {
			$section_classes[] = 'grve-desktop-row-hide';
		}
		if ( !empty( $tablet_visibility ) ) {
			$section_classes[] = 'grve-tablet-row-hide';
		}
		if ( !empty( $tablet_sm_visibility ) ) {
			$section_classes[] = 'grve-tablet-sm-row-hide';
		}
		if ( !empty( $mobile_visibility ) ) {
			$section_classes[] = 'grve-mobile-row-hide';
		}
	}

	// Full Height Separator
	if( $separator_top_size == '100%' || $separator_bottom_size == '100%' ){
		$section_classes[] = 'grve-separator-fullheight';
	}

	$section_string = implode( ' ', $section_classes );

	$wrapper_attributes = array();

	$wrapper_attributes[] = 'class="' . esc_attr( $section_string ) . '"';

	if ( is_page_template( 'page-templates/template-full-page.php' ) ) {
		$scrolling_lock_anchors = movedo_grve_post_meta( '_movedo_grve_scrolling_lock_anchors', 'yes' );
		if( 'no' == $scrolling_lock_anchors ) {
			$section_uniqid = uniqid('grve-scrolling-section-');
			if ( !empty ( $section_id ) ) {
				$wrapper_attributes[] = 'data-anchor="' . esc_attr( $section_id ) . '"';
			} else {
				$wrapper_attributes[] = 'data-anchor="' . esc_attr( $section_uniqid ) . '"';
			}
		}
		$wrapper_attributes[] = 'data-anchor-tooltip="' . esc_attr( $scroll_section_title ) . '"';
		$wrapper_attributes[] = 'data-header-color="' . esc_attr( $scroll_header_style ) . '"';
	} else {
		if ( !empty ( $section_id ) ) {
			$wrapper_attributes[] = 'id="' . esc_attr( $section_id ) . '"';
		}
	}

	if( 'parallax' == $bg_image_type || 'horizontal-parallax-lr' == $bg_image_type || 'horizontal-parallax-rl' == $bg_image_type ){
		$wrapper_attributes[] = 'data-parallax-threshold="' . esc_attr( $parallax_threshold ) . '"';
	}

	if ( 'hosted_video' == $bg_type && 'parallax' == $bg_video_effect  ) {
		$wrapper_attributes[] = 'data-parallax-threshold="' . esc_attr( $bg_video_parallax_threshold ) . '"';
	}

	if( !empty ($tablet_landscape_full_height) ){
		$wrapper_attributes[] = 'data-tablet-landscape-fullheight="' . esc_attr( $tablet_landscape_full_height ) . '"';
	}

	if( !empty ($tablet_portrait_full_height) ){
		$wrapper_attributes[] = 'data-tablet-portrait-fullheight="' . esc_attr( $tablet_portrait_full_height ) . '"';
	}

	if( !empty ($mobile_full_height) ){
		$wrapper_attributes[] = 'data-mobile-fullheight="' . esc_attr( $mobile_full_height ) . '"';
	}

	if( !empty ($tablet_landscape_equal_column_height) ){
		$wrapper_attributes[] = 'data-tablet-landscape-equal-columns="' . esc_attr( $tablet_landscape_equal_column_height ) . '"';
	}

	if( !empty ($tablet_portrait_equal_column_height) ){
		$wrapper_attributes[] = 'data-tablet-portrait-equal-columns="' . esc_attr( $tablet_portrait_equal_column_height ) . '"';
	}

	if( !empty ($mobile_equal_column_height) ){
		$wrapper_attributes[] = 'data-mobile-equal-columns="' . esc_attr( $mobile_equal_column_height ) . '"';
	}

	if ( 'gradient' != $bg_type ) {
		$bg_gradient_color_1 = $bg_gradient_color_2 = $bg_gradient_direction = "";
	}

	$style = movedo_grve_build_shortcode_style(
		array(
			'bg_color' => $bg_color,
			'bg_gradient_color_1' => $bg_gradient_color_1,
			'bg_gradient_color_2' => $bg_gradient_color_2,
			'bg_gradient_direction' => $bg_gradient_direction,
			'font_color' => $font_color,
			'padding_top' => $padding_top,
			'padding_bottom' => $padding_bottom,
			'margin_bottom' => $margin_bottom,
		)
	);

	if( !empty( $style ) ) {
		$wrapper_attributes[] = $style;
	}

	$row_classes = array( 'grve-row', 'grve-bookmark' );
	if( !empty( $columns_gap ) ) {
		$row_classes[] = 'grve-columns-gap-' . $columns_gap;
	}
	if ( !empty ( $el_wrapper_class ) ) {
		$row_classes[] = $el_wrapper_class;
	}
	$row_css_string = implode( ' ', $row_classes );


	// Top Separators
	$separator_svg_top = movedo_grve_build_separator( $separator_top, $separator_top_color, $separator_top_size );

	// Bottom Separators
	$separator_svg_bottom = movedo_grve_build_separator( $separator_bottom, $separator_bottom_color, $separator_bottom_size );

	//Section Output
	$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
	if( !empty ( $separator_top ) ) {
		$output .= '<div class="grve-separator-top">';
		$output .= $separator_svg_top;
		$output .= '</div>';
	}
	$output .= '<div class="grve-container">';
	$output	.= '<div class="' . esc_attr( $row_css_string ) . '">';
	$output	.= do_shortcode( $content );
	$output	.= '</div>';
	$output	.= '</div>';
	$output .= '<div class="grve-background-wrapper">';
	$output .= $out_video_bg_url;
	$output .= $out_image_bg;
	$output .= $out_video_bg;
	$output .= $out_overlay;
	$output .= $out_pattern;
	$output	.= '</div>';
	if( !empty ( $separator_bottom ) ) {
		$output .= '<div class="grve-separator-bottom">';
		$output .= $separator_svg_bottom;
		$output .= '</div>';
	}
	$output	.= '</div>';

	print $output;

//Omit closing PHP tag to avoid accidental whitespace output errors.
