<?php
/**
* Single Image Shortcode
*/

if( !function_exists( 'movedo_ext_vce_single_image_shortcode' ) ) {

	function movedo_ext_vce_single_image_shortcode( $attr, $content ) {

		$output = $data = $retina_data = $el_class = $image_srcset = '' ;

		extract(
			shortcode_atts(
				array(
					'image' => '',
					'image_mode' => '',
					'retina_image' => '',
					'image_type' => 'image',
					'ids' => '',
					'image_popup_size' => 'extra-extra-large',
					'image_popup_title_caption' => 'none',
					'image_full_column' => 'no',
					'image_column_space' => '100',
					'align' => 'center',
					'title_heading_tag' => 'h3',
					'title_heading' => 'h3',
					'title_custom_font_family' => '',
					'custom_title' => '',
					'custom_caption' => '',
					'image_hover_style' => 'hover-style-1',
					'image_shape' => 'square',
					'zoom_effect' => 'in',
					'grayscale_effect' => 'none',
					'content_bg_color' => 'white',
					'overlay_color' => 'dark',
					'overlay_opacity' => '60',
					'shadow' => '',
					'link' => '',
					'link_class' => '',
					'video_link' => '',
					'animation' => '',
					'clipping_animation' => 'grve-clipping-up',
					'clipping_animation_colors' => 'dark',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$attr
			)
		);

		$has_link = movedo_ext_vce_has_link( $link );
		$link_attributes = movedo_ext_vce_get_link_attributes( $link, $link_class );

		$single_image_classes = array( 'grve-element', 'grve-image' );

		if ( !empty( $animation ) ) {
			if( 'grve-clipping-animation' == $animation ) {
				array_push( $single_image_classes, $clipping_animation);
				if( 'grve-colored-clipping-up' == $clipping_animation || 'grve-colored-clipping-down' == $clipping_animation || 'grve-colored-clipping-left' == $clipping_animation || 'grve-colored-clipping-right' == $clipping_animation ) {
					array_push( $single_image_classes, 'grve-colored-clipping');
					$data .= ' data-clipping-color="' . esc_attr( $clipping_animation_colors ) . '"';
				}
			} else {
				array_push( $single_image_classes, 'grve-animated-item' );
				array_push( $single_image_classes, 'grve-duration-' . $animation_duration );
			}
			array_push( $single_image_classes, $animation);
			$data .= ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if( 'none' != $grayscale_effect ){
			array_push( $single_image_classes, 'grve-' . $grayscale_effect);
		}
		if ( !empty( $el_class ) ) {
			array_push( $single_image_classes, $el_class);
		}

		if ( 'image-caption' == $image_type || 'image-popup-caption' == $image_type ) {
			//array_push( $single_image_classes, 'grve-align-center');
		} else {
			array_push( $single_image_classes, 'grve-align-' . $align );
		}
		if( 'image-caption' == $image_type || 'image-popup-caption' == $image_type  ) {
			array_push( $single_image_classes, 'grve-hover-item' );
			array_push( $single_image_classes, 'grve-' . $image_hover_style );
			array_push( $single_image_classes, 'grve-full-image' );
		}
		if ( 'yes' == $image_full_column ) {
			array_push( $single_image_classes, 'grve-full-image' );
			array_push( $single_image_classes, 'grve-image-space-' . $image_column_space );
		}

		$single_image_classes_string = implode( ' ', $single_image_classes );

		$image_classes = array();

		if( 'image-caption' != $image_type && 'image-popup-caption' != $image_type  ) {
			if ( 'square' != $image_shape ) {
				$image_classes[] = 'grve-' . $image_shape;
			}
		}

		$image_mode_size = movedo_ext_vce_get_image_size( $image_mode );
		$image_classes[] = 'attachment-' . $image_mode_size;
		$image_classes[] = 'size-' . $image_mode_size;

		$image_class_string = implode( ' ', $image_classes );

		// Image Wrapper
		$image_wrapper_classes = array('grve-image-wrapper');

		if( !empty ( $shadow ) ){
			$image_wrapper_classes[] = 'grve-shadow-' . $shadow;
			$image_wrapper_classes[] = 'grve-with-shadow';
		}

		$image_wrapper_class_string = implode( ' ', $image_wrapper_classes );


		if( 'image-caption' == $image_type || 'image-popup-caption' == $image_type  ) {
			$image_class_string = '';
		}

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $single_image_classes_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= '  <div class="' . esc_attr( $image_wrapper_class_string ) . '">';


		//Image Title & Caption Color
		$text_color = 'white';
		$title_color = 'white';
		if( 'hover-style-1' == $image_hover_style ){
			$text_color = 'inherit';
			$title_color = 'inherit';
		} elseif( 'hover-style-2' == $image_hover_style || 'hover-style-3' == $image_hover_style ){
			if( 'light' == $overlay_color ) {
				$text_color = 'content';
				$title_color = 'black';
			}
		}
		if( 'hover-style-4' == $image_hover_style || 'hover-style-5' == $image_hover_style || 'hover-style-7' == $image_hover_style ){
			$text_color = 'inherit';
			if( 'white' == $content_bg_color ){
				$title_color = 'black';
			} else {
				$title_color = 'white';
			}
		}

		$image_content_classes = array( 'grve-content' );
		if ( !empty( $custom_title ) || !empty( $custom_caption ) ) {
			if( 'hover-style-7' == $image_hover_style ){
				array_push( $image_content_classes, 'grve-align-left');
			} else {
				array_push( $image_content_classes, 'grve-align-center');
			}
			if( 'hover-style-4' == $image_hover_style || 'hover-style-5' == $image_hover_style || 'hover-style-7' == $image_hover_style ){
				array_push( $image_content_classes, 'grve-box-item grve-bg-' . $content_bg_color );
			}
			if( 'hover-style-6' == $image_hover_style ){
				array_push( $image_content_classes, 'grve-gradient-overlay' );
			}
		}
		$image_content_class_string = implode( ' ', $image_content_classes );

		$image_popup_size_mode = movedo_ext_vce_get_image_size( $image_popup_size );

		if ( !empty( $image ) ) {
			$id = preg_replace('/[^\d]/', '', $image);
			$thumb_src = wp_get_attachment_image_src( $id, $image_mode_size );
			$thumb_url = $thumb_src[0];
			$image_srcset = '';
			$full_src = wp_get_attachment_image_src( $id, $image_popup_size_mode );
			$full_url = $full_src[0];

			if ( !empty( $retina_image ) && empty( $image_mode ) ) {
				$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
				$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
				$retina_url = $img_retina_src[0];
				$image_srcset = $thumb_url . ' 1x,' . $retina_url . ' 2x';
				$image_html = wp_get_attachment_image( $id, $image_mode_size , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
			} else {
				$image_html = wp_get_attachment_image( $id, $image_mode_size , "", array( 'class' => $image_class_string ) );
			}
		} else {
			$full_url = movedo_ext_vce_get_fallback_image( $image_popup_size_mode, 'url' );
			$image_html = movedo_ext_vce_get_fallback_image( $image_mode_size, "", array( 'class' => $image_class_string ) );
		}
		if ( 'image-popup' == $image_type ) {
			$image_title = get_post_field( 'post_title', $id );
			$image_caption = get_post_field( 'post_excerpt', $id );
			$data = "";
			if ( !empty( $image_title ) && 'none' != $image_popup_title_caption && 'caption-only' != $image_popup_title_caption ) {
				$data .= ' data-title="' . esc_attr( $image_title ) . '"';
			}
			if ( !empty( $image_caption ) && 'none' != $image_popup_title_caption && 'title-only' != $image_popup_title_caption ) {
				$data .= ' data-desc="' . esc_attr( $image_caption ) . '"';
			}
			$output .= '<a class="grve-image-popup" href="' . esc_url( $full_url ) . '"' . $data . '>';
			$output .= $image_html;
			$output .= '</a>';
		} else if ( 'gallery-popup' == $image_type ) {
			$output .= '<div class="grve-gallery-popup">';

			$attachments = explode( ",", $ids );
			if ( !empty( $ids ) && !empty( $attachments ) ) {
				$first_image_data = "";
				$first_image_url = "#";
				$index = 0;

				$gallery_links = "";
				$gallery_links .= '<div class="grve-hidden">';
				foreach ( $attachments as $id ) {
					$full_src = wp_get_attachment_image_src( $id, $image_popup_size_mode );
					$full_url = $full_src[0];
					$image_title = get_post_field( 'post_title', $id );
					$image_caption = get_post_field( 'post_excerpt', $id );

					$data = "";
					if ( !empty( $image_title ) && 'none' != $image_popup_title_caption && 'caption-only' != $image_popup_title_caption ) {
						$data .= ' data-title="' . esc_attr( $image_title ) . '"';
					}
					if ( !empty( $image_caption ) && 'none' != $image_popup_title_caption && 'title-only' != $image_popup_title_caption ) {
						$data .= ' data-desc="' . esc_attr( $image_caption ) . '"';
					}
					if ( 0 == $index ) {
						$first_image_data = $data;
						$first_image_url= $full_url;
					} else {
						$gallery_links .= '<a href="' . esc_url( $full_url ) . '"' . $data . '"></a>';
					}
					$index ++;
				}
				$gallery_links .= '</div>';

				$output .= '<a href="' . esc_url( $first_image_url ) . '"' . $first_image_data . '>';
				$output .= $image_html;
				$output .= '</a>';
				$output .= $gallery_links;
			} else {
				$output .= $image_html;
			}

			$output .= '</div>';
		} else if ( 'image-link' == $image_type ) {
			$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
			$output .= $image_html;
			$output .= '</a>';
		} else if ( 'image-video-popup' == $image_type ) {
			if ( !empty( $video_link ) ) {
				$output .= '<div class="grve-media grve-paraller-wrapper">';
				$output .= '	<a class="grve-video-popup grve-video-icon grve-icon-video grve-box-item grve-bg-white grve-paraller" href="' . esc_url( $video_link ) . '"></a>';
				$output .= $image_html;
				$output .= '</div>';
			} else {
				$output .= '<div class="grve-media">';
				$output .= $image_html;
				$output .= '</div>';
			}
		} else if ( 'image-caption' == $image_type || 'image-popup-caption' == $image_type ) {

			$title_classes = array( 'grve-title' );
			$title_classes[]  = 'grve-' . $title_heading;
			$title_classes[]  = 'grve-text-' . $title_color;
			if ( !empty( $title_custom_font_family ) ) {
				$title_classes[]  = 'grve-' . $title_custom_font_family;
			}
			$title_class_string = implode( ' ', $title_classes );

			if ( 'hover-style-1' == $image_hover_style ) {
				$output .= '<figure class="grve-image-hover grve-media grve-zoom-' . esc_attr( $zoom_effect ) . '">';
				if ( 'image-caption' == $image_type && $has_link ) {
					$output .= '<a class="grve-item-url ' . esc_attr( $link_class ) . '" ' . implode( ' ', $link_attributes ) . '></a>';
				} elseif ( 'image-popup-caption' == $image_type ) {
					$data = "";
					if ( !empty( $custom_title ) && 'none' != $image_popup_title_caption && 'caption-only' != $image_popup_title_caption ) {
						$data .= ' data-title="' . esc_attr( $custom_title ) . '"';
					}
					if ( !empty( $custom_caption ) && 'none' != $image_popup_title_caption && 'title-only' != $image_popup_title_caption ) {
						$data .= ' data-desc="' . esc_attr( $custom_caption ) . '"';
					}
					$output .= '<a class="grve-item-url grve-image-popup" href="' . esc_url( $full_url ) . '"' . $data . '></a>';
				}
				$output .= '<div class="grve-bg-' . esc_attr( $overlay_color ) . ' grve-hover-overlay  grve-opacity-' . esc_attr( $overlay_opacity )  . '"></div>';
				$output .= $image_html;
				$output .= '<figcaption></figcaption>';
				$output .= '</figure>';
				if ( !empty( $custom_title ) || !empty( $custom_caption ) ) {
					$output .= '<div class="' . esc_attr( $image_content_class_string ) . '">';
					if ( !empty( $custom_title ) ) {
						$output .= '<' . tag_escape( $title_heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . esc_html( $custom_title ) . '</' . tag_escape( $title_heading_tag ) . '>';
					}
					if ( !empty( $custom_caption ) ) {
						$output .= '<span class="grve-description grve-link-text grve-text-content">' . wp_kses_post( $custom_caption ) . '</span>';
					}
					$output .= '</div>';
				}
			} else {
				$output .= '<figure class="grve-image-hover grve-media grve-zoom-' . esc_attr( $zoom_effect ) . '">';
				if ( 'image-caption' == $image_type && $has_link ) {
					$output .= '<a class="grve-item-url" ' . implode( ' ', $link_attributes ) . '></a>';
				} elseif ( 'image-popup-caption' == $image_type ) {
					$output .= '<a class="grve-item-url grve-image-popup" href="' . esc_url( $full_url ) . '"></a>';
				}
				$output .= '<div class="grve-bg-' . esc_attr( $overlay_color ) . ' grve-hover-overlay  grve-opacity-' . esc_attr( $overlay_opacity )  . '"></div>';
				$output .= $image_html;
				if ( !empty( $custom_title ) || !empty( $custom_caption ) ) {
					$output .= '<figcaption class="' . esc_attr( $image_content_class_string ) . '">';
					if ( !empty( $custom_title ) ) {
						$output .= '<' . tag_escape( $title_heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . esc_html( $custom_title ) . '</' . tag_escape( $title_heading_tag ) . '>';
					}
					if ( 'hover-style-2' == $image_hover_style && !empty( $custom_title ) && !empty( $custom_caption ) ) {
						$output .= '<div class="grve-line grve-text-' . esc_attr( $text_color ) . '"><span></span></div>';
					}
					if ( !empty( $custom_caption ) ) {
						$output .= '<span class="grve-description grve-link-text grve-text-' . esc_attr( $text_color ) . '">' . wp_kses_post( $custom_caption ) . '</span>';
					}
					$output .= '</figcaption>';
				} else {
					$output .= '<figcaption></figcaption>';
				}
				$output .= '</figure>';
			}

		} else {
			$output .= $image_html;
		}

		$output .= '   </div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode( 'movedo_single_image', 'movedo_ext_vce_single_image_shortcode' );

}

/**
* Add shortcode to Visual Composer
*/

if( !function_exists( 'movedo_ext_vce_single_image_shortcode_params' ) ) {
	function movedo_ext_vce_single_image_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Single Image", "movedo-extension" ),
			"description" => esc_html__( "Image or Video popup in various uses", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-single-image",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Type", "movedo-extension" ),
					"param_name" => "image_type",
					"value" => array(
						esc_html__( "Image", "movedo-extension" ) => 'image',
						esc_html__( "Image Link", "movedo-extension" ) => 'image-link',
						esc_html__( "Image Popup", "movedo-extension" ) => 'image-popup',
						esc_html__( "Image Video Popup", "movedo-extension" ) => 'image-video-popup',
						esc_html__( "Image With Caption", "movedo-extension" ) => 'image-caption',
						esc_html__( "Image Popup With Caption", "movedo-extension" ) => 'image-popup-caption',
						esc_html__( "Image Gallery Popup", "movedo-extension" ) => 'gallery-popup',
					),
					"description" => esc_html__( "Select your image type.", "movedo-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "image_mode",
					'value' => array(
						esc_html__( 'Full ( Custom )', 'movedo-extension' ) => '',
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Extra Extra Large )', 'movedo-extension' ) => 'extra-extra-large',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
						esc_html__( 'Thumbnail', 'movedo-extension' ) => 'thumbnail',
					),
					'std' => '',
					"description" => esc_html__( "Select your Image Size.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Popup Size", "movedo-extension" ),
					"param_name" => "image_popup_size",
					'value' => array(
						esc_html__( 'Large' , 'movedo-extension' ) => 'large',
						esc_html__( 'Extra Extra Large' , 'movedo-extension' ) => 'extra-extra-large',
						esc_html__( 'Full' , 'movedo-extension' ) => 'full',
					),
					"std" => 'extra-extra-large',
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-popup', 'image-popup-caption', 'gallery-popup' ) ),
					"description" => esc_html__( "Select size for your popup image.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Popup Title & Caption Visibility", "movedo-extension" ),
					"param_name" => "image_popup_title_caption",
					'value' => array(
						esc_html__( 'None' , 'movedo-extension' ) => 'none',
						esc_html__( 'Title and Caption' , 'movedo-extension' ) => 'title-caption',
						esc_html__( 'Title Only' , 'movedo-extension' ) => 'title-only',
						esc_html__( 'Caption Only' , 'movedo-extension' ) => 'caption-only',
					),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-popup', 'image-popup-caption', 'gallery-popup' ) ),
					"description" => esc_html__( "Define the visibility for your popup image title - caption.", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "movedo-extension" ),
					"param_name" => "image",
					"value" => '',
					"description" => esc_html__( "Select an image.", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Retina Image", "movedo-extension" ),
					"param_name" => "retina_image",
					"value" => '',
					"description" => esc_html__( "Select a 2x image.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_mode", 'value' => array( '' ) ),
				),
				array(
					"type"			=> "attach_images",
					"class"			=> "",
					"heading"		=> esc_html__( "Attach Images", "movedo-extension" ),
					"param_name"	=> "ids",
					"value" => '',
					"description"	=> esc_html__( "Select your gallery images.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'gallery-popup' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Image Fill Column Space", "movedo-extension" ),
					"param_name" => "image_full_column",
					"value" => array( esc_html__( "If selected, image will fill the column space", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image', 'image-link', 'image-popup', 'image-video-popup', 'gallery-popup' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Column Space", "movedo-extension" ),
					"param_name" => "image_column_space",
					"value" => array(
						esc_html__( "100%", "movedo-extension" ) => '100',
						esc_html__( "125%", "movedo-extension" ) => '125',
						esc_html__( "150%", "movedo-extension" ) => '150',
						esc_html__( "175%", "movedo-extension" ) => '175',
						esc_html__( "200%", "movedo-extension" ) => '200',
						esc_html__( "225%", "movedo-extension" ) => '225',
						esc_html__( "250%", "movedo-extension" ) => '250',
					),
					"dependency" => array( 'element' => "image_full_column", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Alignment", "movedo-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image', 'image-link', 'image-popup', 'image-video-popup' , 'gallery-popup') ),
					"std" => 'center',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image shape", "movedo-extension" ),
					"param_name" => "image_shape",
					"value" => array(
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'extra-round',
						esc_html__( "Circle", "movedo-extension" ) => 'circle',
					),
					"description" => '',
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image', 'image-link', 'image-popup', 'image-video-popup' , 'gallery-popup') ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grayscale Effect", "movedo-extension" ),
					"param_name" => "grayscale_effect",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "Grayscale Image", "movedo-extension" ) => 'grayscale-image',
						esc_html__( "Colored on Hover", "movedo-extension" ) => 'grayscale-image-hover',
					),
					"description" => esc_html__( "Choose the grayscale effect.", "movedo-extension" ),
					'std' => 'none',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shadow", "movedo-extension" ),
					"param_name" => "shadow",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => '',
						esc_html__( "Small", "movedo-extension" ) => 'small',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Large", "movedo-extension" ) => 'large',
					),
					"description" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "movedo-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type video URL e.g Vimeo/YouTube.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-video-popup') ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "movedo-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-link', 'image-caption' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Link Class", "movedo-extension" ),
					"param_name" => "link_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-link', 'image-caption' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "animation",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Fade In", "movedo-extension" ) => "grve-fade-in",
						esc_html__( "Fade In Up", "movedo-extension" ) => "grve-fade-in-up",
						esc_html__( "Fade In Up Big", "movedo-extension" ) => "grve-fade-in-up-big",
						esc_html__( "Fade In Down", "movedo-extension" ) => "grve-fade-in-down",
						esc_html__( "Fade In Down Big", "movedo-extension" ) => "grve-fade-in-down-big",
						esc_html__( "Fade In Left", "movedo-extension" ) => "grve-fade-in-left",
						esc_html__( "Fade In Left Big", "movedo-extension" ) => "grve-fade-in-left-big",
						esc_html__( "Fade In Right", "movedo-extension" ) => "grve-fade-in-right",
						esc_html__( "Fade In Right Big", "movedo-extension" ) => "grve-fade-in-right-big",
						esc_html__( "Zoom In", "movedo-extension" ) => "grve-zoom-in",
						esc_html__( "Clipping Animation", "movedo-extension" ) => "grve-clipping-animation",
					),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "clipping_animation",
					"value" => array(
						esc_html__( "Clipping Up", "movedo-extension" ) => "grve-clipping-up",
						esc_html__( "Clipping Down", "movedo-extension" ) => "grve-clipping-down",
						esc_html__( "Clipping Left", "movedo-extension" ) => "grve-clipping-left",
						esc_html__( "Clipping Right", "movedo-extension" ) => "grve-clipping-right",
						esc_html__( "Colored Clipping Up", "movedo-extension" ) => "grve-colored-clipping-up",
						esc_html__( "Colored Clipping Down", "movedo-extension" ) => "grve-colored-clipping-down",
						esc_html__( "Colored Clipping Left", "movedo-extension" ) => "grve-colored-clipping-left",
						esc_html__( "Colored Clipping Right", "movedo-extension" ) => "grve-colored-clipping-right",
					),
					"dependency" => array( 'element' => "animation", 'value' => array( 'grve-clipping-animation' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Clipping Color", "movedo-extension" ),
					"param_name" => "clipping_animation_colors",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Dark", "movedo-extension" ) => 'dark',
						esc_html__( "Light", "movedo-extension" ) => 'light',
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
					"description" => esc_html__( "Select clipping color", "movedo-extension" ),
					"dependency" => array( 'element' => "clipping_animation", 'value' => array( 'grve-colored-clipping-up', 'grve-colored-clipping-down', 'grve-colored-clipping-left', 'grve-colored-clipping-right' ) ),
				),
				movedo_ext_vce_add_animation_delay(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation Duration", "movedo-extension"),
					"param_name" => "animation_duration",
					"value" => array(
						esc_html__( "Very Fast", "movedo-extension" ) => "very-fast",
						esc_html__( "Fast", "movedo-extension" ) => "fast",
						esc_html__( "Normal", "movedo-extension" ) => "normal",
						esc_html__( "Slow", "movedo-extension" ) => "slow",
						esc_html__( "Very Slow", "movedo-extension" ) => "very-slow",
					),
					"std" => 'normal',
					"description" => esc_html__("Select the duration for your animated element.", 'movedo-extension' ),
					"dependency" => array( 'element' => "animation", 'value_not_equal_to' => array( 'grve-clipping-animation' ) ),
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Tag", "movedo-extension" ),
					"param_name" => "title_heading_tag",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "div", "movedo-extension" ) => 'div',
					),
					"description" => esc_html__( "Title Tag for SEO", "movedo-extension" ),
					"std" => 'h3',
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Size/Typography", "movedo-extension" ),
					"param_name" => "title_heading",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "Leader Text", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "movedo-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "movedo-extension" ) => 'small-text',
						esc_html__( "Link Text", "movedo-extension" ) => 'link-text',
					),
					"description" => esc_html__( "Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Custom Font Family", "movedo-extension" ),
					"param_name" => "title_custom_font_family",
					"value" => array(
						esc_html__( "Same as Typography", "movedo-extension" ) => '',
						esc_html__( "Custom Font Family 1", "movedo-extension" ) => 'custom-font-1',
						esc_html__( "Custom Font Family 2", "movedo-extension" ) => 'custom-font-2',
						esc_html__( "Custom Font Family 3", "movedo-extension" ) => 'custom-font-3',
						esc_html__( "Custom Font Family 4", "movedo-extension" ) => 'custom-font-4',

					),
					"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo-extension" ),
					"std" => '',
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "custom_title",
					"value" => "",
					"description" => esc_html__( "Enter your title.", "movedo-extension" ),
					"admin_label" => true,
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Caption", "movedo-extension" ),
					"param_name" => "custom_caption",
					"value" => "",
					"description" => esc_html__( "Enter your caption.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Style - Hovers", "movedo-extension" ),
					"param_name" => "image_hover_style",
					'value' => array(
						esc_html__( 'Content Below Image' , 'movedo-extension' ) => 'hover-style-1',
						esc_html__( 'Top Down Animated Content' , 'movedo-extension' ) => 'hover-style-2',
						esc_html__( 'Left Right Animated Content' , 'movedo-extension' ) => 'hover-style-3',
						esc_html__( 'Static Box Content' , 'movedo-extension' ) => 'hover-style-4',
						esc_html__( 'Animated Box Content' , 'movedo-extension' ) => 'hover-style-5',
						esc_html__( 'Gradient Overlay' , 'movedo-extension' ) => 'hover-style-6',
						esc_html__( 'Animated Right Corner Box Content' , 'movedo-extension' ) => 'hover-style-7',
					),
					"description" => esc_html__( "Select the hover style for the image.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Content Background Color", "movedo-extension" ),
					"param_name" => "content_bg_color",
					'value' => array(
						esc_html__( 'White' , 'movedo-extension' ) => 'white',
						esc_html__( 'Black' , 'movedo-extension' ) => 'black',
					),
					"description" => esc_html__( "Select the background color for image item content.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_hover_style", 'value' => array( 'hover-style-4', 'hover-style-5', 'hover-style-7' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Zoom Effect", "movedo-extension" ),
					"param_name" => "zoom_effect",
					"value" => array(
						esc_html__( "Zoom In", "movedo-extension" ) => 'in',
						esc_html__( "Zoom Out", "movedo-extension" ) => 'out',
						esc_html__( "None", "movedo-extension" ) => 'none',
					),
					"description" => esc_html__( "Choose the image zoom effect.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Color", "movedo-extension" ),
					"param_name" => "overlay_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Dark", "movedo-extension" ) => 'dark',
						esc_html__( "Light", "movedo-extension" ) => 'light',
						esc_html__( "Primary 1", "movedo-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "movedo-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "movedo-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "movedo-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "movedo-extension" ) => 'primary-5',
						esc_html__( "Primary 6", "movedo-extension" ) => 'primary-6',
					),
					"description" => esc_html__( "Choose the image color overlay.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_hover_style", 'value' => array( 'hover-style-1', 'hover-style-2', 'hover-style-3', 'hover-style-4', 'hover-style-5', 'hover-style-7' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "movedo-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 80,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_hover_style", 'value' => array( 'hover-style-1', 'hover-style-2', 'hover-style-3', 'hover-style-4', 'hover-style-5', 'hover-style-7' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_single_image', 'movedo_ext_vce_single_image_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_single_image_shortcode_params( 'movedo_single_image' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
