<?php
/**
 * Media Box Shortcode
 */

if( !function_exists( 'movedo_ext_vce_media_box_shortcode' ) ) {

	function movedo_ext_vce_media_box_shortcode( $atts, $content ) {
		global $wp_embed;
		$output = $data = $retina_data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'media_type' => 'image',
					'image_mode' => '',
					'image' => '',
					'retina_image' => '',
					'zoom_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'video_popup' => '',
					'video_link' => '',
					'map_lat' => '51.516221',
					'map_lng' => '-0.136986',
					'map_height' => '280',
					'map_marker' => '',
					'map_zoom' => 14,
					'map_disable_style' => 'no',
					'title_link' => '',
					'read_more_title' => '',
					'link_class' => '',
					'align' => 'left',
					'add_icon' => '',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-info-circle',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_etlineicons' => 'et-icon-mobile',
					'icon_bg_color' => 'green',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$has_link = movedo_ext_vce_has_link( $title_link );

		if( 'yes' == $add_icon ) {
			$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $icon_library );
			}
		}

		$media_box_classes = array( 'grve-element', 'grve-box', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $media_box_classes, 'grve-animated-item' );
			array_push( $media_box_classes, $animation);
			array_push( $media_box_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $media_box_classes, $el_class);
		}
		$media_box_classe_string = implode( ' ', $media_box_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $media_box_classe_string ) . '" style="' . $style . '"' . $data . '>';


		switch( $media_type ) {
			case 'image':
			case 'image-video-popup':

				$image_mode_size = movedo_ext_vce_get_image_size( $image_mode );

				if ( !empty( $image ) ) {
					$img_id = preg_replace('/[^\d]/', '', $image);
					$img_src = wp_get_attachment_image_src( $img_id, $image_mode_size );
					$img_url = $img_src[0];
					$image_srcset = '';
					if ( !empty( $retina_image ) ) {
						$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
						$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
						$retina_url = $img_retina_src[0];
						$image_srcset = esc_attr( $img_url ) . ' 1x,' . esc_attr( $retina_url ) . ' 2x';
						$image_html = wp_get_attachment_image( $img_id, 'full' , "", array( 'srcset'=> $image_srcset ) );
					} else {
						$image_html = wp_get_attachment_image( $img_id, $image_mode_size );
					}
				} else {
					$image_html = movedo_ext_vce_get_fallback_image( 'medium' );
				}

				if ( 'image-video-popup' == $media_type && !empty( $video_link ) ) {
					$output .= '<a class="grve-video-popup" href="' . esc_url( $video_link ) . '">';
					if( 'yes' == $add_icon ) {
						$output .= '<div class="grve-media-box-icon grve-bg-'. esc_attr( $icon_bg_color ) . '"><i class="'. esc_attr( $icon_class ) . '"></i></div>';
					}
					$output .= '	<figure class="grve-image-hover grve-zoom-' . esc_attr( $zoom_effect ) . '">';
					$output .= '		<div class="grve-media">';
					$output .= '	        <div class="grve-video-icon grve-icon-video grve-bg-primary-1"></div>';
					$output .= '			<div class="grve-bg-' . esc_attr( $overlay_color ) . ' grve-hover-overlay grve-opacity-' . esc_attr( $overlay_opacity ) . '"></div>';
					$output .= $image_html;
					$output .= '		</div>';
					$output .= '	</figure>';
					$output .= '</a>';
				} else {
					if ( $has_link ) {
						$link_attributes = movedo_ext_vce_get_link_attributes( $title_link, $link_class );
						$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
					}
					if( 'yes' == $add_icon ) {
						$output .= '<div class="grve-media-box-icon grve-bg-'. esc_attr( $icon_bg_color ) . '"><i class="'. esc_attr( $icon_class ) . '"></i></div>';
					}
					$output .= '<figure class="grve-image-hover grve-zoom-' . esc_attr( $zoom_effect ) . '">';
					$output .= '	<div class="grve-media">';
					$output .= '		<div class="grve-bg-' . esc_attr( $overlay_color ) . ' grve-hover-overlay grve-opacity-' . esc_attr( $overlay_opacity ) . '"></div>';
					$output .= $image_html;
					$output .= '	</div>';
					$output .= '</figure>';
					if ( $has_link ) {
						$output .= '</a>';
					}
				}
				break;
			case 'video':
				if ( !empty( $video_link ) ) {
					$output .= '<div class="grve-media">';
					$output .= $wp_embed->run_shortcode( '[embed]' . $video_link . '[/embed]' );
					$output .= '</div>';
				}
				break;
			case 'map':
				wp_enqueue_script( 'movedo-grve-maps-script');
				if ( empty( $map_marker ) ) {
					$map_marker = get_template_directory_uri() . '/images/markers/markers.png';
				} else {
					$id = preg_replace('/[^\d]/', '', $map_marker);
					$full_src = wp_get_attachment_image_src( $id, 'full' );
					$map_marker = $full_src[0];
				}
				$map_title = '';

				$data_map = 'data-lat="' . esc_attr( $map_lat ) . '" data-lng="' . esc_attr( $map_lng ) . '" data-zoom="' . esc_attr( $map_zoom ) . '" data-disable-style="' . esc_attr( $map_disable_style ) . '"';
				$output .= '<div class="grve-media">';
				$output .= '  <div class="grve-map" ' . $data_map . ' style="' . $style . movedo_ext_vce_build_dimension( 'height', $map_height ) . '"></div>';
				$output .= '  <div style="display:none" class="grve-map-point" data-point-lat="' . esc_attr( $map_lat ) . '" data-point-lng="' . esc_attr( $map_lng ) . '" data-point-marker="' . esc_attr( $map_marker ) . '" data-point-title="' . esc_attr( $map_title ) . '"></div>';
				$output .= '</div>';
				break;
			default :
				break;
		}


		$output .= '  <div class="grve-box-content">';
		if ( !empty( $title ) ) {

			$title_classes = array( 'grve-box-title' );
			$title_classes[]  = 'grve-' . $heading;
			if ( !empty( $custom_font_family ) ) {
				$title_classes[]  = 'grve-' . $custom_font_family;
			}
			$title_class_string = implode( ' ', $title_classes );

			if ( $has_link ) {
			$link_attributes = movedo_ext_vce_get_link_attributes( $title_link, $link_class );
			$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
			}
			$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
			if ( !empty( $title_link ) ) {
			$output .= '    </a>';
			}
		}

		$output .= '    <p>' . do_shortcode( $content ) . '</p>';
		if ( !empty( $read_more_title ) && $has_link ) {
			$link_class_string = 'grve-link-text grve-read-more';
			if( !empty( $link_class ) )  {
				$link_class_string .= ' ' . $link_class;
			}
			$link_attributes = movedo_ext_vce_get_link_attributes( $title_link, $link_class_string );
			$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
			$output .=  $read_more_title ;
			$output .= '</a>';
		}
		$output .= '  </div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_media_box', 'movedo_ext_vce_media_box_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_media_box_shortcode_params' ) ) {
	function movedo_ext_vce_media_box_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Media Box", "movedo-extension" ),
			"description" => esc_html__( "Image, Video or Map combined with text", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-media-box",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Media type", "movedo-extension" ),
					"param_name" => "media_type",
					"value" => array(
						esc_html__( "Image", "movedo-extension" ) => 'image',
						esc_html__( "Image - Video Popup", "movedo-extension" ) => 'image-video-popup',
						esc_html__( "Video", "movedo-extension" ) => 'video',
						esc_html__( "Map", "movedo-extension" ) => 'map',
					),
					"description" => esc_html__( "Select your media type.", "movedo-extension" ),
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
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "movedo-extension" ),
					"param_name" => "image",
					"value" => '',
					"description" => esc_html__( "Select an image.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
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
					"type" => "dropdown",
					"heading" => esc_html__( "Image Zoom Effect", "movedo-extension" ),
					"param_name" => "zoom_effect",
					"value" => array(
						esc_html__( "Zoom In", "movedo-extension" ) => 'in',
						esc_html__( "Zoom Out", "movedo-extension" ) => 'out',
						esc_html__( "None", "movedo-extension" ) => 'none',
					),
					"description" => esc_html__( "Choose the image zoom effect.", "movedo-extension" ),
					'std' => 'none',
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Color", "movedo-extension" ),
					"param_name" => "overlay_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Light", "movedo-extension" ) => 'light',
						esc_html__( "Dark", "movedo-extension" ) => 'dark',
						esc_html__( "Primary 1", "movedo-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "movedo-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "movedo-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "movedo-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "movedo-extension" ) => 'primary-5',
						esc_html__( "Primary 6", "movedo-extension" ) => 'primary-6',
					),
					"description" => esc_html__( "Choose the image color overlay.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "movedo-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "movedo-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type video URL e.g Vimeo/YouTube.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image-video-popup', 'video' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Latitude", "movedo-extension" ),
					"param_name" => "map_lat",
					"value" => "51.516221",
					"description" => esc_html__( "Type map Latitude.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Longtitude", "movedo-extension" ),
					"param_name" => "map_lng",
					"value" => "-0.136986",
					"description" => esc_html__( "Type map Longtitude.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Map Zoom", "movedo-extension" ),
					"param_name" => "map_zoom",
					"value" => array( 1, 2, 3 ,4, 5, 6, 7, 8 ,9 ,10 ,11 ,12, 13, 14, 15, 16, 17, 18, 19 ),
					"std" => 14,
					"description" => esc_html__( "Zoom of the map.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Height", "movedo-extension" ),
					"param_name" => "map_height",
					"value" => "280",
					"description" => esc_html__( "Type map height.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Disable Custom Style", "movedo-extension" ),
					"param_name" => "map_disable_style",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => 'no',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"description" => esc_html__( "Select if you want to disable custom map style.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Custom marker", "movedo-extension" ),
					"param_name" => "map_marker",
					"value" => '',
					"description" => esc_html__( "Select an icon for custom marker.", "movedo-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title.", "movedo-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Enter your text.", "movedo-extension" ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Title Link", "movedo-extension" ),
					"param_name" => "title_link",
					"value" => "",
					"description" => esc_html__( "Enter title link.", "movedo-extension" ),
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
					"heading" => esc_html__( "Link Class", "movedo-extension" ),
					"param_name" => "link_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "movedo-extension" ),
				),
				movedo_ext_vce_add_align(),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Add icon?", "movedo-extension" ),
					"param_name" => "add_icon",
					"value" => array( esc_html__( "Select if you want to show an icon", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon library', 'movedo-extension' ),
					'value' => array(
						esc_html__( 'Font Awesome', 'movedo-extension' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'movedo-extension' ) => 'openiconic',
						esc_html__( 'Typicons', 'movedo-extension' ) => 'typicons',
						esc_html__( 'Entypo', 'movedo-extension' ) => 'entypo',
						esc_html__( 'Linecons', 'movedo-extension' ) => 'linecons',
						esc_html__( 'Simple Line Icons', 'movedo-extension' ) => 'simplelineicons',
						esc_html__( 'Elegant Line Icons', 'movedo-extension' ) => 'etlineicons',
					),
					'param_name' => 'icon_library',
					'description' => esc_html__( 'Select icon library.', 'movedo-extension' ),
					"dependency" => array( 'element' => "add_icon", 'value' => array( 'yes' ) ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_fontawesome',
					'value' => 'fa fa-info-circle',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_openiconic',
					'value' => 'vc-oi vc-oi-dial',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'openiconic',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_typicons',
					'value' => 'typcn typcn-adjust-brightness',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'typicons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_entypo',
					'value' => 'entypo-icon entypo-icon-note',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'entypo',
						'iconsPerPage' => 300, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'entypo',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_linecons',
					'value' => 'vc_li vc_li-heart',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'linecons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_simplelineicons',
					'value' => 'smp-icon-user',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'simplelineicons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'simplelineicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'movedo-extension' ),
					'param_name' => 'icon_etlineicons',
					'value' => 'et-icon-mobile',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'etlineicons',
						'iconsPerPage' => 100,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'etlineicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'movedo-extension' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background Color", "movedo-extension" ),
					"param_name" => "icon_bg_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
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
						esc_html__( "Black", "movedo-extension" ) => 'black',
						esc_html__( "Grey", "movedo-extension" ) => 'grey',
						esc_html__( "White", "movedo-extension" ) => 'white',
					),
					"description" => esc_html__( "Background color of the box.", "movedo-extension" ),
					"dependency" => array( 'element' => "add_icon", 'value' => array( 'yes' ) ),
					'std' => 'green',
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
	vc_lean_map( 'movedo_media_box', 'movedo_ext_vce_media_box_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_media_box_shortcode_params( 'movedo_media_box' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
