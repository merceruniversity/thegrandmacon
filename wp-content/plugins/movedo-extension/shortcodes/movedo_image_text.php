<?php
/**
 * Image Text Shortcode
 */

if( !function_exists( 'movedo_ext_vce_image_text_shortcode' ) ) {

	function movedo_ext_vce_image_text_shortcode( $atts, $content ) {

		$output = $output_image = $data = $retina_data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'layout' => '1',
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'image_mode' => '',
					'image' => '',
					'retina_image' => '',
					'image_shape' => 'square',
					'image_text_align' => 'left',
					'content_align' => 'left',
					'image_popup_size' => 'extra-extra-large',
					'video_popup' => '',
					'video_link' => '',
					'read_more_title' => '',
					'read_more_link' => '',
					'read_more_class' => '',
					'content_bg' => 'none',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$title_classes = array( 'grve-title', 'grve-heading-color' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		$title_class_string = implode( ' ', $title_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$image_text_classes = array( 'grve-element', 'grve-image-text' );

		if ( !empty( $animation ) ) {
			array_push( $image_text_classes, 'grve-animated-item' );
			array_push( $image_text_classes, $animation);
			array_push( $image_text_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $image_text_classes, $el_class);
		}

		array_push( $image_text_classes, 'grve-layout-' . $layout );
		array_push( $image_text_classes, 'grve-align-' . $image_text_align );

		if ( '2' == $layout ) {
			array_push( $image_text_classes, 'grve-paraller-wrapper' );
		}

		$image_text_class_string = implode( ' ', $image_text_classes );

		$image_position = 'left';
		$content_position = 'right';
		if( 'right' == $image_text_align ) {
			$image_position = 'right';
			$content_position = 'left';
		}

		$image_classes = array();

		if ( 'square' != $image_shape ) {
			$image_classes[] = 'grve-' . $image_shape;
		}

		$image_mode_size = movedo_ext_vce_get_image_size( $image_mode );
		$image_classes[] = 'attachment-' . $image_mode_size;
		$image_classes[] = 'size-' . $image_mode_size;

		$image_class_string = implode( ' ', $image_classes );

		$image_popup_size_mode = movedo_ext_vce_get_image_size( $image_popup_size );

		$output .= '<div class="' . esc_attr( $image_text_class_string ) . '" style="' . $style . '"' . $data . '>';

		if ( !empty( $image ) ) {
			$img_id = preg_replace('/[^\d]/', '', $image);
			$img_src = wp_get_attachment_image_src( $img_id, 'full' );
			$thumb_url = $img_src[0];
			$full_src = wp_get_attachment_image_src( $img_id, $image_popup_size_mode );
			$full_url = $full_src[0];
			$image_dimensions = 'width="' . $img_src[1] . '" height="' . $img_src[2] . '"';
			$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			$image_srcset = '';

			if ( !empty( $retina_image ) && empty( $image_mode ) ) {
				$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
				$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
				$retina_data = ' data-at2x="' . esc_attr( $img_retina_src[0] ) . '"';
				$retina_url = $img_retina_src[0];
				$image_srcset = $thumb_url . ' 1x,' . $retina_url . ' 2x';
				$image_html = wp_get_attachment_image( $img_id, $image_mode_size , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
			} else {
				$image_html = wp_get_attachment_image( $img_id, $image_mode_size , "", array( 'class' => $image_class_string ) );
			}

		} else {
			$image_html = movedo_ext_vce_get_fallback_image( $image_mode_size, "", array( 'class' => $image_class_string ) );
		}


		if ( 'yes' == $video_popup && !empty( $video_link ) ) {
			$output_image .= '<div class="grve-image grve-position-' . esc_attr( $image_position ) . '">';
			$output_image .= '<a class="grve-video-popup grve-video-icon grve-icon-video grve-box-item grve-bg-white grve-paraller" href="' . esc_url( $video_link ) . '"></a>';
			$output_image .= $image_html;
			$output_image .= '</div>';
		} else if ( 'image' == $video_popup ) {
			$output_image .= '<div class="grve-image grve-position-' . esc_attr( $image_position ) . '">';
			$output_image .= '<a class="grve-image-popup grve-item-url" href="' . esc_url( $full_url ) . '"></a>';
			$output_image .= $image_html;
			$output_image .= '</div>';
		} else {
			$output_image .= '<div class="grve-image grve-position-' . esc_attr( $image_position ) . '">';
			$output_image .= $image_html;
			$output_image .= '</div>';
		}

		$output .= $output_image;

		if ( '2' == $layout ) {
			$output .= '  <div class="grve-content grve-bg-' . esc_attr( $content_bg ) . ' grve-box-item grve-paraller grve-align-' . esc_attr( $content_align ) . '" data-limit="1x">';
		} else {
			$output .= '  <div class="grve-content grve-position-' . esc_attr( $content_position ) . ' grve-align-' . esc_attr( $content_align ) . '">';
		}
		if ( !empty( $title ) ) {
		$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
		}
		if ( !empty( $content ) ) {
		$output .= '  <p class="grve-description">' . do_shortcode( $content ) . '</p>';
		}

		if ( !empty( $read_more_title ) && movedo_ext_vce_has_link( $read_more_link ) ) {
			$link_class_string = 'grve-link-text grve-read-more ' . esc_attr( $read_more_class );
			$link_attributes = movedo_ext_vce_get_link_attributes( $read_more_link, $link_class_string );
			$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
			$output .= $read_more_title ;
			$output .= '</a>';
		}

		$output .= '  </div>';
		$output .= '</div>';


		return $output;
	}
	add_shortcode( 'movedo_image_text', 'movedo_ext_vce_image_text_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_image_text_shortcode_params' ) ) {
	function movedo_ext_vce_image_text_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Image Text", "movedo-extension" ),
			"description" => esc_html__( "Combine image or video with text and button", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-image-text",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "image_mode",
					'value' => array(
						esc_html__( 'Full ( Custom )', 'movedo-extension' ) => '',
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
					),
					'std' => '',
					"description" => esc_html__( "Select your Image Size.", "movedo-extension" ),
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
					"type" => 'dropdown',
					"heading" => esc_html__( "Layout", "movedo-extension" ),
					"param_name" => "layout",
					"description" => esc_html__( "Selected your Layout.", "movedo-extension" ),
					"value" => array(
						esc_html__( "Classic", "movedo-extension" ) => '1',
						esc_html__( "Movedo", "movedo-extension" ) => '2',
					),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Image Position", "movedo-extension" ),
					"param_name" => "image_text_align",
					"description" => esc_html__( "Set the position of your image", "movedo-extension" ),
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
					),
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
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Popup", "movedo-extension" ),
					"param_name" => "video_popup",
					"description" => esc_html__( "If selected, a popup will appear on click.", "movedo-extension" ),
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Video", "movedo-extension" ) => 'yes',
						esc_html__( "Image", "movedo-extension" ) => 'image',
					),
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
					"dependency" => array( 'element' => "video_popup", 'value' => array( 'image' )),
					"description" => esc_html__( "Select size for your popup image.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "movedo-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type video URL e.g Vimeo/YouTube.", "movedo-extension" ),
					"dependency" => array( 'element' => "video_popup", 'value' => array( 'yes' )),
				),
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
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Enter your text.", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Content Alignment", "movedo-extension" ),
					"param_name" => "content_align",
					"description" => esc_html__( "Set the alignment of your content", "movedo-extension" ),
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
					),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Content Background", "movedo-extension" ),
					"param_name" => "content_bg",
					"description" => esc_html__( "Selected background color for your image text content.", "movedo-extension" ),
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Black", "movedo-extension" ) => 'black',
					),
					"dependency" => array( 'element' => "layout", 'value' => '2' ),
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
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_image_text', 'movedo_ext_vce_image_text_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_image_text_shortcode_params( 'movedo_image_text' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
