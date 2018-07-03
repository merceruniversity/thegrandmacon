<?php
/**
 * Image Text Shortcode
 */

if( !function_exists( 'movedo_ext_vce_split_content_shortcode' ) ) {

	function movedo_ext_vce_split_content_shortcode( $atts, $content ) {

		$output = $out_image_bg = $out_slider_image_bg = $out_video_bg_url = $out_video_bg = $out_media_bg = $data = $style = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'increase_heading' => '100',
					'split_title' => '',
					'split_title_space' => 'small',
					'text_style' => 'none',
					'custom_font_family' => '',
					'color_overlay' => 'black',
					'opacity_overlay' => '70',
					'overlapping_title_color' => 'white',
					'media_type' => 'image',
					'bg_image_size' => '',
					'bg_image' => '',
					'ids' => '',
					'loop' => 'yes',
					'transition' => 'slide',
					'auto_play' => 'yes',
					'slideshow_speed' => '3500',
					'bg_position' => 'center-center',
					'bg_video_url' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
					'bg_video_webm' => '',
					'bg_video_mp4' => '',
					'bg_video_ogv' => '',
					'bg_video_device' => 'no',
					'split_content_align' => 'left',
					'split_content_height' => 'fullscreen',
					'min_height' => '300',
					'read_more_title' => '',
					'read_more_link' => '',
					'read_more_class' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		// Title Classes
		$title_classes = array( 'grve-title', 'grve-align-center', 'grve-heading-color' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		if ( '100' != $increase_heading ){
			$title_classes[]  = 'grve-increase-heading';
			$title_classes[]  = 'grve-heading-' . $increase_heading;
		}
		if ( !empty( $split_title ) ) {
			$title_classes[]  = 'grve-split-title';
			$title_classes[]  = 'grve-split-size-' . $split_title_space;
		}
		$title_class_string = implode( ' ', $title_classes );

		$style .= movedo_ext_vce_build_margin_bottom_style( $margin_bottom );
		if ( !empty( $min_height ) ) {
			$style .= ' min-height:' . esc_attr( $min_height ) . 'px';
		}

		$split_content_classes = array( 'grve-element', 'grve-split-content' );

		if ( !empty( $animation ) ) {
			$split_content_classes[]  = 'grve-animated-item';
			$split_content_classes[]  = $animation;
			$split_content_classes[]  = 'grve-duration-' . $animation_duration;
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			$split_content_classes[]  = $el_class;
		}

		$split_content_classes[]  = 'grve-' . $split_content_height . '-size';
		$split_content_classes[]  = 'grve-media-' . $split_content_align;

		$split_content_class_string = implode( ' ', $split_content_classes );

		// Bg Wrapper Classes
		$bg_image_wrapper_classes = array( 'grve-split-wrapper', 'grve-media-wrapper' );
		$bg_image_wrapper_classes[]  = 'grve-headings-' . $overlapping_title_color;
		$bg_image_wrapper_classes[]  = 'grve-text-' . $overlapping_title_color;
		$bg_image_wrapper_class_string = implode( ' ', $bg_image_wrapper_classes );


		//Background Image Classses
		$bg_image_classes = array( 'grve-bg-image' );

		if( $bg_image > 0 ){
			$bg_image_classes[] = 'grve-bg-image-id-' . $bg_image ;
		}
		$bg_image_classes[] = 'grve-bg-' . $bg_position;

		$bg_image_string = implode( ' ', $bg_image_classes );


		//Background Image
		$img_style = movedo_ext_vce_img_style( $bg_image ,$bg_image_size );

		if ( 'image' == $media_type ) {
			$out_image_bg .= '  <div class="' . esc_attr( $bg_image_string ) . '"  ' . $img_style . '></div>';
		}

		if ( ( 'hosted_video' == $media_type || 'video' == $media_type ) && !empty ( $bg_image ) ) {
			$out_image_bg .= '  <div class="' . esc_attr( $bg_image_string ) . '"  ' . $img_style . '></div>';
		}

		//Background Video
		if ( 'hosted_video' == $media_type && ( !empty ( $bg_video_webm ) || !empty ( $bg_video_mp4 ) || !empty ( $bg_video_ogv ) ) ) {

			$has_video_bg = true;
			$video_poster = '';
			if ( wp_is_mobile() ) {
				if ( 'yes' == $bg_video_device ) {
					$video_poster = movedo_ext_vce_img_url( $bg_image ,$bg_image_size );
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
					'loop' => 'yes',
					'muted' => 'yes',
					'poster' => $video_poster,
				);

				if ( function_exists( 'movedo_grve_print_media_video_settings' ) ) {
					$video_attr = movedo_grve_print_media_video_settings( $video_settings );
				} else {
					$video_attr = ' controls';
				}

				$out_video_bg .= '<div class="grve-bg-video grve-html5-bg-video" data-video-device="' . esc_attr( $bg_video_device ) .'">';
				$out_video_bg .=  '<video data-autoplay ' . $video_attr . '>';
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

		$youtube_id = '';
		if ( function_exists( 'movedo_grve_extract_youtube_id' ) ) {
			$youtube_id = movedo_grve_extract_youtube_id( $bg_video_url );
		}
		$has_video_bg = ( 'video' == $media_type && ! empty( $bg_video_url ) && $youtube_id );
		if ( $has_video_bg ) {
			wp_enqueue_script( 'youtube-iframe-api' );
			$out_video_bg_url .= '<div class="grve-bg-video grve-yt-bg-video" data-video-bg-url="' . esc_attr( $bg_video_url ) . '"></div>';
		}

		// Slider
		if ( 'slider' == $media_type ) {

			$attachments = explode( ",", $ids );
			if ( !empty( $attachments ) ) {

				$slider_data = '';
				$slider_data .= ' data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
				$slider_data .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
				$slider_data .= ' data-slider-loop="' . esc_attr( $loop ) . '"';
				$slider_data .= ' data-slider-transition="' . esc_attr( $transition ) . '"';

				$out_slider_image_bg .= '<div class="grve-slit-content-slider"' . $slider_data . '>';

				foreach ( $attachments as $id ) {
					$slider_img_style = movedo_ext_vce_img_style( $id ,$bg_image_size );
					$out_slider_image_bg .= '  <div class="grve-slider-item">';
					$out_slider_image_bg .= '    <div class="' . esc_attr( $bg_image_string ) . '"  ' . $slider_img_style . '></div>';
					$out_slider_image_bg .= '  </div>';
				}

				$out_slider_image_bg .= '</div>';
			}
		}

		// Media Output
		$out_media_bg .= '<div class="grve-background-wrapper">';
		if ( 'slider' != $media_type ) {
			$out_media_bg .= $out_video_bg_url;
			$out_media_bg .= $out_video_bg;
			$out_media_bg .= $out_image_bg;
		} else {
			$out_media_bg .= $out_slider_image_bg;
		}
		if ( !empty ( $opacity_overlay ) ) {
			$out_media_bg .= '  <div class="grve-bg-overlay grve-bg-' . esc_attr( $color_overlay ) . ' grve-opacity-' . esc_attr( $opacity_overlay ) . '"></div>';
		}
		$out_media_bg .= '</div>';


		// Content
		$out_content = '';
		if ( !empty( $content ) || !empty( $read_more_title ) ) {
			$out_content .= '<div class="grve-content">';
			if ( !empty( $content ) ) {
				$out_content .= '  <p class="grve-description grve-' . esc_attr( $text_style ) . '">' . do_shortcode( $content ) . '</p>';
			}
			if ( !empty( $read_more_title ) && movedo_ext_vce_has_link( $read_more_link ) ) {
				$link_class_string = 'grve-link-text grve-read-more ' . esc_attr( $read_more_class );
				$link_attributes = movedo_ext_vce_get_link_attributes( $read_more_link, $link_class_string );
				$out_content .= '<a ' . implode( ' ', $link_attributes ) . '>';
				$out_content .= $read_more_title ;
				$out_content .= '</a>';
			}
			$out_content .= '</div>';
		}


		$output .= '<div class="' . esc_attr( $split_content_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= '  <div class="' . esc_attr( $bg_image_wrapper_class_string ) . '">';
		$output .= '    <div class="grve-wrapper-inner">';
		if ( !empty( $title ) ) {
		$output .= '      <' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '"><span>' . $title. '</span></' . tag_escape( $heading_tag ) . '>';
		}
		$output .= $out_content;
		$output .= '    </div>';
		$output .= $out_media_bg;
		$output .= '  </div>';
		$output .= '  <div class="grve-split-wrapper grve-content-wrapper">';
		$output .= '    <div class="grve-wrapper-inner">';
		if ( !empty( $title ) ) {
		$output .= '      <div class="' . esc_attr( $title_class_string ) . '"><span>' . $title. '</span></div>';
		}
		$output .= $out_content;
		$output .= '    </div>';
		if ( 'slider' == $media_type ) {
		$output .= '    <div class="grve-slider-dots owl-controls"></div>';
		}
		$output .= '  </div>';
		$output .= '</div>';


		return $output;
	}
	add_shortcode( 'movedo_split_content', 'movedo_ext_vce_split_content_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_split_content_shortcode_params' ) ) {
	function movedo_ext_vce_split_content_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Split Content", "movedo-extension" ),
			"description" => esc_html__( "Combine image or video with text and button", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-split-content",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__( "Enter your title.", "movedo-extension" ),
					"admin_label" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_heading_increase(),
				movedo_ext_vce_get_custom_font_family(),
				movedo_ext_vce_get_split_title(),
				movedo_ext_vce_get_split_title_space(),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Enter your text.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text Style", "movedo-extension" ),
					"param_name" => "text_style",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => '',
						esc_html__( "Leader", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle", "movedo-extension" ) => 'subtitle',
					),
					"description" => 'Select your text style',
				),
				array(
					"type" => 'dropdown',
					'edit_field_class' => 'vc_col-sm-6',
					"heading" => esc_html__( "Split Content Height", "movedo-extension" ),
					"param_name" => "split_content_height",
					"description" => esc_html__( "Select the height of your split content", "movedo-extension" ),
					"value" => array(
						esc_html__( "Fullscreen", "movedo-extension" ) => 'fullscreen',
						esc_html__( "Large", "movedo-extension" ) => 'large',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Small", "movedo-extension" ) => 'small',
					),
				),
				array(
					"type" => "textfield",
					'edit_field_class' => 'vc_col-sm-6',
					"heading" => esc_html__( "Split Content Min Height", "movedo-extension" ),
					"param_name" => "min_height",
					"value" => "300",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Title", "movedo-extension" ),
					"param_name" => "read_more_title",
					"value" => "",
					"description" => esc_html__( "Enter your title for your link.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Link Class", "movedo-extension" ),
					"param_name" => "read_more_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "movedo-extension" ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Read More Link", "movedo-extension" ),
					"param_name" => "read_more_link",
					"value" => "",
					"description" => esc_html__( "Enter read more link.", "movedo-extension" ),
				),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Media Type", "movedo-extension" ),
					"param_name" => "media_type",
					'value' => array(
						esc_html__( 'Image', 'movedo-extension' ) => 'image',
						esc_html__( 'Slider', 'movedo-extension' ) => 'slider',
						esc_html__( 'Hosted Video', 'movedo-extension' ) => 'hosted_video',
						esc_html__( 'YouTube Video', 'movedo-extension' ) => 'video',
					),
					'std' => '',
					"description" => esc_html__( "Select your Media Type.", "movedo-extension" ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "YouTube link", "movedo-extension" ),
					"param_name" => "bg_video_url",
					'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
					"description" => esc_html__( "Add YouTube link.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'video' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("WebM File URL", 'movedo-extension'),
					"param_name" => "bg_video_webm",
					"description" => esc_html__( "Fill WebM and mp4 format for browser compatibility", 'movedo-extension' ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'hosted_video' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "MP4 File URL", 'movedo-extension' ),
					"param_name" => "bg_video_mp4",
					"description" => esc_html__( "Fill mp4 format URL", 'movedo-extension' ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'hosted_video' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "OGV File URL", 'movedo-extension' ),
					"param_name" => "bg_video_ogv",
					"description" => esc_html__( "Fill OGV format URL ( optional )", 'movedo-extension' ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'hosted_video' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Allow on devices", 'movedo-extension' ),
					"param_name" => "bg_video_device",
					"value" => array(
						esc_html__( "No", 'movedo' ) => 'no',
						esc_html__( "Yes", 'movedo' ) => 'yes',

					),
					"std" => 'no',
					"dependency" => array( 'element' => "media_type", 'value' => array( 'hosted_video' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "movedo-extension" ),
					"param_name" => "bg_image",
					"value" => '',
					"description" => esc_html__( "Select an image. Used also as fallback for video.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'hosted_video', 'video' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type"			=> "attach_images",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> esc_html__( "Attach Images", "movedo-extension" ),
					"param_name"	=> "ids",
					"value" => '',
					"description"	=> esc_html__( "Select your slider images.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "bg_image_size",
					'value' => array(
						esc_html__( 'Full ( Custom )', 'movedo-extension' ) => '',
						esc_html__( 'Resize ( Extra Extra Large )', 'movedo-extension' ) => 'extra-extra-large',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
					),
					'std' => '',
					"description" => esc_html__( "Select your Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Loop", "movedo-extension" ),
					"param_name" => "loop",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "movedo-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Transition", "movedo-extension" ),
					"param_name" => "transition",
					"value" => array(
						esc_html__( "Slide", "movedo-extension" ) => 'slide',
						esc_html__( "Fade", "movedo-extension" ) => 'fade',
					),
					"description" => esc_html__( "Transition Effect.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background  Position", 'movedo-extension' ),
					"param_name" => "bg_position",
					"value" => array(
						esc_html__( 'Left Top', 'movedo-extension' ) => 'left-top',
						esc_html__( 'Left Center', 'movedo-extension' ) => 'left-center',
						esc_html__( 'Left Bottom', 'movedo-extension' ) => 'left-bottom',
						esc_html__( 'Center Top', 'movedo-extension' ) => 'center-top',
						esc_html__( 'Center Center', 'movedo-extension' ) => 'center-center',
						esc_html__( 'Center Bottom', 'movedo-extension' ) => 'center-bottom',
						esc_html__( 'Right Top', 'movedo-extension' ) => 'right-top',
						esc_html__( 'Right Center', 'movedo-extension' ) => 'right-center',
						esc_html__( 'Right Bottom', 'movedo-extension' ) => 'right-bottom',
					),
					"description" => esc_html__( "Select position for background image", 'movedo-extension' ),
					"std" => 'center-center',
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'slider' ) ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Media Position", "movedo-extension" ),
					"param_name" => "split_content_align",
					"description" => esc_html__( "Set the position of your media", "movedo-extension" ),
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
					),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Color overlay", "movedo-extension" ),
					"param_name" => "color_overlay",
					'edit_field_class' => 'vc_col-sm-6',
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Black", "movedo-extension" ) => 'black',
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Primary 1", "movedo-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "movedo-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "movedo-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "movedo-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "movedo-extension" ) => 'primary-5',
						esc_html__( "Primary 6", "movedo-extension" ) => 'primary-6',
						esc_html__( "Green", "movedo-extension" ) => 'green',
						esc_html__( "Orange", "movedo-extension" ) => 'orange',
						esc_html__( "Red", "movedo-extension" ) => 'red',
						esc_html__( "Blue", "movedo-extension" ) => 'blue',
						esc_html__( "Aqua", "movedo-extension" ) => 'aqua',
						esc_html__( "Purple", "movedo-extension" ) => 'purple',
						esc_html__( "Grey", "movedo-extension" ) => 'grey',
					),
					'std' => 'black',
					"description" => esc_html__( "A color overlay for the background image.", "movedo-extension" ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Opacity overlay", "movedo-extension" ),
					"param_name" => "opacity_overlay",
					'edit_field_class' => 'vc_col-sm-6',
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 70,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlapping Title Color", "movedo-extension" ),
					"param_name" => "overlapping_title_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Black", "movedo-extension" ) => 'black',
						esc_html__( "Primary 1", "movedo-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "movedo-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "movedo-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "movedo-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "movedo-extension" ) => 'primary-5',
						esc_html__( "Primary 6", "movedo-extension" ) => 'primary-6',
						esc_html__( "Green", "movedo-extension" ) => 'green',
						esc_html__( "Orange", "movedo-extension" ) => 'orange',
						esc_html__( "Red", "movedo-extension" ) => 'red',
						esc_html__( "Blue", "movedo-extension" ) => 'blue',
						esc_html__( "Aqua", "movedo-extension" ) => 'aqua',
						esc_html__( "Purple", "movedo-extension" ) => 'purple',
						esc_html__( "Grey", "movedo-extension" ) => 'grey',
					),
					"description" => esc_html__( "Color of the overlappin title.", "movedo-extension" ),
					"group" => esc_html__( "Media", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_split_content', 'movedo_ext_vce_split_content_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_split_content_shortcode_params( 'movedo_split_content' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
