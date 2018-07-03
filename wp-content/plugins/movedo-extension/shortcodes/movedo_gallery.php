<?php
/**
 * Gallery Shortcode
 */

if( !function_exists( 'movedo_ext_vce_gallery_shortcode' ) ) {

	function movedo_ext_vce_gallery_shortcode( $attr, $content ) {

		$output = $start_block = $end_block = $item_class = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'text_style' => 'none',
					'align' => 'left',
					'ids' => '',
					'gallery_mode' => 'grid',
					'grid_image_mode' => 'square',
					'masonry_image_mode' => '',
					'image_link_mode' => 'popup',
					'image_popup_size' => 'extra-extra-large',
					'carousel_image_mode' => 'landscape',
					'carousel_layout' => 'layout-1',
					'columns_large_screen' => '3',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'image_title_caption' => 'none',
					'image_title_heading_tag' => 'h3',
					'image_title_heading' => 'h3',
					'image_title_custom_font_family' => '',
					'image_hover_style' => 'hover-style-1',
					'image_content_bg_color' => 'white',
					'zoom_effect' => 'none',
					'grayscale_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'items_per_page' => '4',
					'items_tablet_landscape' => '3',
					'items_tablet_portrait' => '3',
					'items_mobile' => '1',
					'slideshow_speed' => '3000',
					'auto_play' => 'yes',
					'loop' => 'yes',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'carousel_pagination' => 'no',
					'carousel_pagination_speed' => '400',
					'animation' => 'grve-zoom-in',
					'margin_bottom' => '',
					'el_class' => '',
					'custom_links' => '',
					'custom_links_target' => '_self',
					'social_email' => '',
					'social_facebook' => '',
					'social_twitter' => '',
					'social_linkedin' => '',
					'social_googleplus' => '',
					'social_reddit' => '',
					'social_pinterest' => '',
					'social_tumblr' => '',
					'gallery_filter' => '',
					'filter_values' => '',
					'filter_style' => 'simple',
					'filter_shape' => 'square',
					'filter_color' => 'primary-1',
					'filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
				),
				$attr
			)
		);

		$attachments = explode( ",", $ids );

		if ( empty( $attachments ) ) {
			return '';
		}

		// Image Effect
		$image_effect_classes = array( 'grve-image-hover' );
		if ( 'none' != $zoom_effect ) {
			array_push( $image_effect_classes, 'grve-zoom-' . $zoom_effect );
		}
		if ( 'none' != $grayscale_effect ) {
			array_push( $image_effect_classes, 'grve-' . $grayscale_effect );
		}
		$image_effect_class_string = implode( ' ', $image_effect_classes );


		//Gallery Classes
		$gallery_classes = array( 'grve-element', 'grve-gallery' , 'grve-isotope' );

		if ( 'custom_link' == $image_link_mode ) {
			$custom_links = vc_value_from_safe( $custom_links );
			$custom_links = explode( ',', $custom_links );
		} elseif ( 'popup' == $image_link_mode ) {
			array_push( $gallery_classes, 'grve-gallery-popup' );
		}

		//Gallery Carousel Classes
		$gallery_carousel_classes = array( 'grve-element', 'grve-carousel' );

		array_push( $gallery_carousel_classes, 'grve-' . $carousel_layout );

		if ( !empty( $el_class ) ) {
			array_push( $gallery_classes, $el_class);
		}

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$data_string = '';

		$allow_filter = 'yes';

		switch( $gallery_mode ) {
			case 'masonry':
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $gallery_classes, 'grve-with-gap' );
				}
				break;
			case 'carousel':
				$data_string .= ' data-items="' . esc_attr( $items_per_page ) . '"';
				$data_string .= ' data-items-tablet-landscape="' . esc_attr( $items_tablet_landscape ) . '"';
				$data_string .= ' data-items-tablet-portrait="' . esc_attr( $items_tablet_portrait ) . '"';
				$data_string .= ' data-items-mobile="' . esc_attr( $items_mobile ) . '"';
				$data_string .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
				$data_string .= ' data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
				$data_string .= ' data-slider-pause="' . esc_attr( $pause_hover ) . '"';
				$data_string .= ' data-pagination-speed="' . esc_attr( $carousel_pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				$data_string .= ' data-slider-loop="' . esc_attr( $loop ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
					array_push( $gallery_carousel_classes, 'grve-with-gap' );
				}
				$allow_filter = 'no';
				break;
			case 'grid':
			default:
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $gallery_classes, 'grve-with-gap' );
				}
				break;
		}
		$gallery_class_string = implode( ' ', $gallery_classes );
		$gallery_carousel_class_string = implode( ' ', $gallery_carousel_classes );

		if ( 'popup' == $image_link_mode ) {

			$has_social = false;
			if ( !empty( $social_email ) ) {
				$data_string .= ' data-social-email="yes"';
				$has_social = true;
			}
			if ( !empty( $social_facebook ) ) {
				$data_string .= ' data-social-facebook="yes"';
				$has_social = true;
			}
			if ( !empty( $social_twitter ) ) {
				$data_string .= ' data-social-twitter="yes"';
				$has_social = true;
			}
			if ( !empty( $social_linkedin ) ) {
				$data_string .= ' data-social-linkedin="yes"';
				$has_social = true;
			}
			if ( !empty( $social_googleplus ) ) {
				$data_string .= ' data-social-googleplus="yes"';
				$has_social = true;
			}
			if ( !empty( $social_reddit ) ) {
				$data_string .= ' data-social-reddit="yes"';
				$has_social = true;
			}
			if ( !empty( $social_pinterest  ) ) {
				$data_string .= ' data-social-pinterest="yes"';
				$has_social = true;
			}
			if ( !empty( $social_tumblr  ) ) {
				$data_string .= ' data-social-tumblr="yes"';
				$has_social = true;
			}
			if ( $has_social ) {
				$data_string .= ' data-social="yes"';
			}
		}

		//Title & Caption Color
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
		} elseif( 'hover-style-4' == $image_hover_style || 'hover-style-5' == $image_hover_style || 'hover-style-7' == $image_hover_style ){
			$text_color = 'inherit';
			if( 'white' == $image_content_bg_color ){
				$title_color = 'black';
			} else {
				$title_color = 'white';
			}
		}


		$title_classes = array( 'grve-title' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		$title_class_string = implode( ' ', $title_classes );

		$image_title_classes = array( 'grve-title' );
		$image_title_classes[]  = 'grve-' . $image_title_heading;
		$image_title_classes[]  = 'grve-text-' . $title_color;
		if ( !empty( $image_title_custom_font_family ) ) {
			$image_title_classes[]  = 'grve-' . $image_title_custom_font_family;
		}
		$image_title_class_string = implode( ' ', $image_title_classes );

		if ( 'carousel' == $gallery_mode ) {
			//Gallery Output ( carousel )

			$image_size = movedo_ext_vce_get_image_size( $carousel_image_mode );

			$output .= '<div class="' . esc_attr( $gallery_carousel_class_string ) . '" style="' . $style . '">';

			if( 'layout-2' == $carousel_layout ){
				$output .= '<div class="grve-carousel-info-wrapper grve-align-' . $align . '">';
				$output .= '  <div class="grve-carousel-info">';
				if( !empty( $title ) ){
					$output .= '    <' . tag_escape( $heading_tag ) .' class="' . esc_attr( $title_class_string ) . '">' . $title . '</' . tag_escape( $heading_tag ) .'>';
				}
				if ( !empty( $content ) ) {
					$output .= '    <p class="grve-description grve-' . esc_attr( $text_style ) . '">' . movedo_ext_vce_unautop( $content ) . '</p>';
				}
				$output .= '  </div>';
				$output .= movedo_ext_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
				$output .= '</div>';
			}
			$output .= '  <div class="grve-carousel-wrapper">';

			//Carousel Navigation Layout 1
			if( 'layout-1' == $carousel_layout ){
				$output .= movedo_ext_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
			}
			if ( 'popup' == $image_link_mode ) {
				$output .= '    <div class="grve-carousel-element grve-gallery-popup ' . esc_attr( $el_class ) . '"' . $data_string . '>';
			} else {
				$output .= '    <div class="grve-carousel-element ' . esc_attr( $el_class ) . '"' . $data_string . '>';
			}
		} else {
			//Gallery Output ( grid / masonry)

			if ( 'masonry' == $gallery_mode ) {
				$image_size = movedo_ext_vce_get_image_size( $masonry_image_mode );
			} else {
				$image_size = movedo_ext_vce_get_image_size( $grid_image_mode );
			}

			$output .= '<div class="' . esc_attr( $gallery_class_string ) . '" style="' . $style . '"' . $data_string . '>';

			if ( 'yes' == $gallery_filter && 'yes' == $allow_filter ) {

				$category_filter_list = array();
				$gallery_categories = array();

				$filter_values = vc_value_from_safe( $filter_values );
				$filter_values = explode( ',', $filter_values );
				$filter_index = 0;

				foreach( $filter_values as $filter_value){
					$image_categories = explode( '|', $filter_value );
					foreach( $image_categories as $image_category ){
						if ( !in_array( $image_category, $category_filter_list ) ) {
							$category_filter_list[] = $image_category;
							$gallery_categories[] = array(
								'term_id' => $filter_index,
								'slug' => sanitize_title_with_dashes( $image_category ),
								'name' => $image_category,
							);
							$filter_index++;
						}
					}
				}

				$filter_classes = array( 'grve-filter' );

				array_push( $filter_classes, 'grve-filter-style-' . $filter_style );
				array_push( $filter_classes, 'grve-align-' . $filter_align);
				array_push( $filter_classes, 'grve-link-text');

				if ( 'button' == $filter_style ) {
					array_push( $filter_classes, 'grve-link-text');
					array_push( $filter_classes, 'grve-filter-shape-' . $filter_shape );
					array_push( $filter_classes, 'grve-filter-color-' . $filter_color );
				}

				$filter_class_string = implode( ' ', $filter_classes );

				$category_prefix = '.gallery-category-';
				$category_filter_array = array();
				$all_string =  apply_filters( 'movedo_grve_vce_gallery_string_all_categories', esc_html__( 'All', 'movedo-extension' ) );
				$category_filter_string = '<li data-filter="*" class="selected"><span>' . esc_html( $all_string ) . '</span></li>';
				$category_filter_add = false;

				foreach($gallery_categories as $category_term){
					if ( 'title' == $filter_order_by ) {
						$filter_by = $category_term['name'];
					} else {
						$filter_by = $category_term['term_id'];
					}
					$category_filter_array[$filter_by] = $category_term;
				}

				if ( count( $category_filter_array ) > 1 ) {
					if ( '' != $filter_order_by ) {
						if ( 'ASC' == $filter_order ) {
							ksort( $category_filter_array );
						} else {
							krsort( $category_filter_array );
						}
					}
					foreach($category_filter_array as $category_filter){
						$category_filter_string .= '<li data-filter="' . $category_prefix . $category_filter['slug'] . '"><span>' . $category_filter['name'] . '</span></li>';
					}
					$output .= '<div class="' . esc_attr( $filter_class_string ) . '">';
					$output .= '<ul>';
					$output .= $category_filter_string;
					$output .= '</ul>';
					$output .= '</div>';
				}
			}


			$output .= '  <div class="grve-isotope-container">';
		}

			$gallery_index = 0;
			$i = -1;
			$image_size_class = '';

			$image_atts = array();

			$image_popup_size_mode = movedo_ext_vce_get_image_size( $image_popup_size );

			foreach ( $attachments as $id ) {

				$gallery_index++;
				$i++;

				if ( 'masonry' == $gallery_mode && empty( $masonry_image_mode ) ) {
					$movedo_ext_masonry_data = movedo_ext_vce_get_masonry_data( $gallery_index, $columns );
					$image_size_class = ' ' . $movedo_ext_masonry_data['class'];
					$image_size = $movedo_ext_masonry_data['image_size'];
				}

				$thumb_src = wp_get_attachment_image_src( $id, $image_size );
				$full_src = wp_get_attachment_image_src( $id, $image_popup_size_mode );
				$image_title = get_post_field( 'post_title', $id );
				$image_caption = get_post_field( 'post_excerpt', $id );

				//Check Title and Caption
				$show_title = $show_caption = $show_title_or_caption = 'no';
				if ( !empty( $image_title ) && 'none' != $image_title_caption && 'caption-only' != $image_title_caption ) {
					$show_title = $show_title_or_caption = 'yes';
				}
				if ( !empty( $image_caption ) && 'none' != $image_title_caption && 'title-only' != $image_title_caption ) {
					$show_caption = $show_title_or_caption = 'yes';
				}

				if( 'no' == $show_title_or_caption ){
					$image_hover_style = 'hover-style-none';
				}

				//Image Content Classes
				$image_content_classes = array( 'grve-content' );
				if ( 'yes' == $show_title_or_caption ) {
					if( 'hover-style-7' == $image_hover_style ){
						array_push( $image_content_classes, 'grve-align-left');
					} else {
						array_push( $image_content_classes, 'grve-align-center');
					}

					if( 'hover-style-4' == $image_hover_style || 'hover-style-5' == $image_hover_style || 'hover-style-7' == $image_hover_style ){
						array_push( $image_content_classes, 'grve-box-item grve-bg-' . $image_content_bg_color );
					}
					if( 'hover-style-6' == $image_hover_style ){
						array_push( $image_content_classes, 'grve-gradient-overlay' );
					}
				}
				$image_content_class_string = implode( ' ', $image_content_classes );

				//Popup Link Data
				$link_data = '';
				if( 'yes' == $show_title ){
					$link_data .= ' data-title="' . esc_attr( $image_title ) . '"';
				}
				if( 'yes' == $show_caption ){
					$link_data .= ' data-desc="' . esc_attr( $image_caption ) . '"';
				}

				if ( 'carousel' == $gallery_mode ) {
					$output .= '<div class="grve-carousel-item grve-hover-item grve-' . esc_attr( $image_hover_style ) . '">';
				} else {

					$image_categories_classes = "";
					if ( 'yes' == $gallery_filter && isset( $filter_values[ $i ] ) && !empty(  $filter_values[ $i ] )  ) {
						$image_categories = explode( '|', $filter_values[ $i ] );
						foreach( $image_categories as $image_category ){
								$image_categories_classes .= " gallery-category-" .sanitize_title_with_dashes( $image_category );
						}
					}
					$output .= '<div class="grve-isotope-item grve-hover-item grve-' . esc_attr( $image_hover_style ) . $image_size_class . $image_categories_classes . '">';
					if ( !empty( $animation ) ) {
						$output .= '<div class="grve-isotope-item-inner ' . esc_attr( $animation ) . '">';
					}
				}

				//Figure
				$output .= '  <figure class="' . esc_attr( $image_effect_class_string ) . '">';

				if ( 'popup' == $image_link_mode ) {
					$output .= '    <a class="grve-item-url" href="' . esc_url( $full_src[0] ) . '" ' . $link_data . '></a>';
				} elseif ( 'custom_link' == $image_link_mode && isset( $custom_links[ $i ] ) && !empty(  $custom_links[ $i ] )  ) {
					$output .= '    <a class="grve-item-url" href="' . esc_url( $custom_links[ $i ] ) . '" target="' . esc_attr( $custom_links_target ) . '" ' . $link_data . '></a>';
				}
				if( 'hover-style-6' != $image_hover_style ){
					$output .= '    <div class="grve-hover-overlay grve-bg-' . esc_attr( $overlay_color ) . ' grve-opacity-' . esc_attr( $overlay_opacity ) . '"></div>';
				}

				$output .= '<div class="grve-media">';
				$output .= wp_get_attachment_image( $id, $image_size , "", $image_atts );
				$output .= '</div>';

				if ( 'hover-style-1' != $image_hover_style && 'yes' == $show_title_or_caption ) {
						$output .= '<figcaption class="' . esc_attr( $image_content_class_string ) . '">';
						if( 'yes' == $show_title ){
							$output .= '<' . tag_escape( $image_title_heading_tag ) .' class="' . esc_attr( $image_title_class_string ) . '">' . wptexturize( $image_title ) . '</' . tag_escape( $image_title_heading_tag ) .'>';
						}
						if( 'hover-style-2' == $image_hover_style && 'yes' == $show_title && 'yes' == $show_caption ){
							$output .= '<div class="grve-line grve-text-' . esc_attr( $text_color ) . '"><span></span></div>';
						}
						if( 'yes' == $show_caption ){
							$output .= '<div class="grve-description grve-text-' . esc_attr( $text_color ) . '">' . wptexturize( $image_caption ) . '</div>';
						}
						$output .= '</figcaption>';
				}

				$output .= '  </figure>';

				//Content Below Image
				if( 'hover-style-1' == $image_hover_style && 'yes' == $show_title_or_caption ){
					$output .= '<div class="' . esc_attr( $image_content_class_string ) . '">';
						if( 'yes' == $show_title ){
							$output .= '<' . tag_escape( $image_title_heading_tag ) .' class="' . esc_attr( $image_title_class_string ) . '">' . wptexturize( $image_title ) . '</' . tag_escape( $image_title_heading_tag ) .'>';
						}
						if( 'yes' == $show_caption ){
							$output .= '<div class="grve-description grve-text-content">' . wptexturize( $image_caption ) . '</div>';
						}
					$output .= '</div>';
				}

				if ( 'carousel' == $gallery_mode ) {
					$output .= '</div>';
				} else {
					if ( !empty( $animation ) ) {
						$output .= '</div>';
					}
					$output .= '</div>';
				}

			}

		if ( 'carousel' == $gallery_mode ) {
			$output .= '	  </div>';
			$output .= '	</div>';
			$output .= '</div>';
		} else {
			$output .= '  </div>';
			$output .= '</div>';
		}

		return $output;

	}
	add_shortcode( 'movedo_gallery', 'movedo_ext_vce_gallery_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_gallery_shortcode_params' ) ) {
	function movedo_ext_vce_gallery_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Gallery", "movedo-extension" ),
			"description" => esc_html__( "Numerous styles, multiple columns for galleries", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-gallery",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type"			=> "attach_images",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> esc_html__( "Attach Images", "movedo-extension" ),
					"param_name"	=> "ids",
					"value" => '',
					"description"	=> esc_html__( "Select your gallery images.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gallery Mode", "movedo-extension" ),
					"param_name" => "gallery_mode",
					"value" => array(
						esc_html__( "Grid", "movedo-extension" ) => 'grid',
						esc_html__( "Masonry", "movedo-extension" ) => 'masonry',
						esc_html__( "Carousel", "movedo-extension" ) => 'carousel',
					),
					"description" => esc_html__( "Select your gallery mode.", "movedo-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grid Image Size", "movedo-extension" ),
					"param_name" => "grid_image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Landscape Medium Crop', 'movedo-extension' ) => 'landscape-medium',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Portrait Medium Crop', 'movedo-extension' ) => 'portrait-medium',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => 'square',
					"description" => esc_html__( "Select your Grid Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Masonry Image Size", "movedo-extension" ),
					"param_name" => "masonry_image_mode",
					'value' => array(
						esc_html__( 'Autocrop', 'movedo-extension' ) => '',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => '',
					"description" => esc_html__( "Select your Masonry Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Image Size", "movedo-extension" ),
					"param_name" => "carousel_image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => 'landscape',
					"description" => esc_html__( "Select your Carousel Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Layout", "movedo-extension" ),
					"param_name" => "carousel_layout",
					"value" => array(
						esc_html__( "Classic", "movedo-extension" ) => 'layout-1',
						esc_html__( "With title and description", "movedo-extension" ) => 'layout-2',
					),
					"description" => 'Select your layout for Carousel Element',
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title here.", "movedo-extension" ),
					"save_always" => true,
					"admin_label" => true,
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Tag", "movedo-extension" ),
					"param_name" => "heading_tag",
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
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Size/Typography", "movedo-extension" ),
					"param_name" => "heading",
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
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Custom Font Family", "movedo-extension" ),
					"param_name" => "custom_font_family",
					"value" => array(
						esc_html__( "Same as Typography", "movedo-extension" ) => '',
						esc_html__( "Custom Font Family 1", "movedo-extension" ) => 'custom-font-1',
						esc_html__( "Custom Font Family 2", "movedo-extension" ) => 'custom-font-2',
						esc_html__( "Custom Font Family 3", "movedo-extension" ) => 'custom-font-3',
						esc_html__( "Custom Font Family 4", "movedo-extension" ) => 'custom-font-4',

					),
					"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo-extension" ),
					"std" => '',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Type your text.", "movedo-extension" ),
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
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
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
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
					"description" => '',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				//Gallery ( grid /masonry )
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Large Screen Columns", "movedo-extension" ),
					"param_name" => "columns_large_screen",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Blog Columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "movedo-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select number of columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4'  ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "movedo-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gutter between images", "movedo-extension" ),
					"param_name" => "item_gutter",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"description" => esc_html__( "Add gutter among images.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "movedo-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				//Gallery ( carousel )
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "movedo-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of images per page", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Tablet Landscape", "movedo-extension" ),
					"param_name" => "items_tablet_landscape",
					"value" => array( '1', '2', '3', '4' ),
					"std" => 3,
					"description" => esc_html__( "Select number of items on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Tablet Portrait", "movedo-extension" ),
					"param_name" => "items_tablet_portrait",
					"value" => array( '1', '2', '3', '4'  ),
					"std" => 3,
					"description" => esc_html__( "Select number of items on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Mobile", "movedo-extension" ),
					"param_name" => "items_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select number of items on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Loop", "movedo-extension" ),
					"param_name" => "loop",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "movedo-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Pause on Hover", "movedo-extension" ),
					"param_name" => "pause_hover",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"std" => "no",
					"description" => esc_html__( "If selected, carousel will be paused on hover", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Type", "movedo-extension" ),
					"param_name" => "navigation_type",
					'value' => array(
						esc_html__( 'Style 1' , 'movedo-extension' ) => '1',
						esc_html__( 'No Navigation' , 'movedo-extension' ) => '0',
					),
					"description" => esc_html__( "Select your Navigation type.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Color", "movedo-extension" ),
					"param_name" => "navigation_color",
					'value' => array(
						esc_html__( 'Dark' , 'movedo-extension' ) => 'dark',
						esc_html__( 'Light' , 'movedo-extension' ) => 'light',
					),
					"description" => esc_html__( "Select the background Navigation color.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Pagination", "movedo-extension" ),
					"param_name" => "carousel_pagination",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => 'no',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"std" => "no",
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Carousel Pagination Speed", "movedo-extension" ),
					"param_name" => "carousel_pagination_speed",
					"value" => '400',
					"description" => esc_html__( "Pagination Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "animation",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Fade In", "movedo-extension" ) => "grve-fade-in",
						esc_html__( "Fade In Up", "movedo-extension" ) => "grve-fade-in-up",
						esc_html__( "Fade In Down", "movedo-extension" ) => "grve-fade-in-down",
						esc_html__( "Fade In Left", "movedo-extension" ) => "grve-fade-in-left",
						esc_html__( "Fade In Right", "movedo-extension" ) => "grve-fade-in-right",
						esc_html__( "Zoom In", "movedo-extension" ) => "grve-zoom-in",
					),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
					"std" => "grve-zoom-in",
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Title & Caption Visibility", "movedo-extension" ),
					"param_name" => "image_title_caption",
					'value' => array(
						esc_html__( 'None' , 'movedo-extension' ) => 'none',
						esc_html__( 'Title and Caption' , 'movedo-extension' ) => 'title-caption',
						esc_html__( 'Title Only' , 'movedo-extension' ) => 'title-only',
						esc_html__( 'Caption Only' , 'movedo-extension' ) => 'caption-only',
					),
					"description" => esc_html__( "Define the visibility for your image title - caption.", "movedo-extension" ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Tag", "movedo-extension" ),
					"param_name" => "image_title_heading_tag",
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
					"dependency" => array( 'element' => "image_title_caption", 'value' => array( 'title-caption', 'title-only' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Title Size/Typography", "movedo-extension" ),
					"param_name" => "image_title_heading",
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
					"description" => esc_html__( "Image Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"dependency" => array( 'element' => "image_title_caption", 'value' => array( 'title-caption', 'title-only' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Title Custom Font Family", "movedo-extension" ),
					"param_name" => "image_title_custom_font_family",
					"value" => array(
						esc_html__( "Same as Typography", "movedo-extension" ) => '',
						esc_html__( "Custom Font Family 1", "movedo-extension" ) => 'custom-font-1',
						esc_html__( "Custom Font Family 2", "movedo-extension" ) => 'custom-font-2',
						esc_html__( "Custom Font Family 3", "movedo-extension" ) => 'custom-font-3',
						esc_html__( "Custom Font Family 4", "movedo-extension" ) => 'custom-font-4',

					),
					"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo-extension" ),
					"std" => '',
					"dependency" => array( 'element' => "image_title_caption", 'value' => array( 'title-caption', 'title-only' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Hovers Style", "movedo-extension" ),
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
					"description" => esc_html__( "Select the hover style for the gallery overview.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_title_caption", 'value' => array( 'title-caption', 'title-only', 'caption-only' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Content Background Color", "movedo-extension" ),
					"param_name" => "image_content_bg_color",
					'value' => array(
						esc_html__( 'White' , 'movedo-extension' ) => 'white',
						esc_html__( 'Black' , 'movedo-extension' ) => 'black',
					),
					"description" => esc_html__( "Select the background color for image content.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_hover_style", 'value' => array( 'hover-style-4', 'hover-style-5', 'hover-style-7' ) ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
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
						esc_html__( "Green", "movedo-extension" ) => 'green',
						esc_html__( "Orange", "movedo-extension" ) => 'orange',
						esc_html__( "Red", "movedo-extension" ) => 'red',
						esc_html__( "Blue", "movedo-extension" ) => 'blue',
						esc_html__( "Aqua", "movedo-extension" ) => 'aqua',
						esc_html__( "Purple", "movedo-extension" ) => 'purple',
					),
					"description" => esc_html__( "Choose the image color overlay.", "movedo-extension" ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "movedo-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
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
					'std' => 'none',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
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
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Image Link Mode", "movedo-extension" ),
					"param_name" => "image_link_mode",
					"value" => array(
						esc_html__( "Image Popup", "movedo-extension" ) => 'popup',
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "Custom Link", "movedo-extension" ) => 'custom_link',
					),
					"description" => esc_html__( "Choose the image link mode.", "movedo-extension" ),
					'std' => 'popup',
					"group" => esc_html__( "Extras", "movedo-extension" ),
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
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"description" => esc_html__( "Select size for your popup image.", "movedo-extension" ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
					"std" => 'extra-extra-large',
				),
				array(
					'type' => 'exploded_textarea_safe',
					'heading' => __( 'Custom links', 'movedo-extension' ),
					'param_name' => 'custom_links',
					'description' => __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'movedo-extension' ),
					'dependency' => array(
						'element' => 'image_link_mode',
						'value' => array( 'custom_link' ),
					),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Custom link target', 'movedo-extension' ),
					'param_name' => 'custom_links_target',
					'description' => __( 'Select where to open custom links.', 'movedo-extension' ),
					'dependency' => array(
						'element' => 'image_link_mode',
						'value' => array( 'custom_link' ),
					),
					"value" => array(
						esc_html__( "Same Window", "movedo-extension" ) => '_self',
						esc_html__( "New Window", "movedo-extension" ) => '_blank',
					),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "E-mail", "movedo-extension" ),
					"param_name" => "social_email",
					"description" => esc_html__( "Share with E-mail", "movedo-extension" ),
					"value" => array( esc_html__( "Show E-mail social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Facebook", "movedo-extension" ),
					"param_name" => "social_facebook",
					"description" => esc_html__( "Share in Facebook", "movedo-extension" ),
					"value" => array( esc_html__( "Show Facebook social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Twitter", "movedo-extension" ),
					"param_name" => "social_twitter",
					"description" => esc_html__( "Share in Twitter", "movedo-extension" ),
					"value" => array( esc_html__( "Show Twitter social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Linkedin", "movedo-extension" ),
					"param_name" => "social_linkedin",
					"description" => esc_html__( "Share in Linkedin", "movedo-extension" ),
					"value" => array( esc_html__( "Show Linkedin social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Google +", "movedo-extension" ),
					"param_name" => "social_googleplus",
					"description" => esc_html__( "Share in Google +", "movedo-extension" ),
					"value" => array( esc_html__( "Show Google + social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "reddit", "movedo-extension" ),
					"param_name" => "social_reddit",
					"description" => esc_html__( "Submit in reddit", "movedo-extension" ),
					"value" => array( esc_html__( "Show reddit social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pinterest", "movedo-extension" ),
					"param_name" => "social_pinterest",
					"description" => esc_html__( "Submit in Pinterest (Featured Image is used as image)", "movedo-extension" ),
					"value" => array( esc_html__( "Show Pinterest social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Tumblr", "movedo-extension" ),
					"param_name" => "social_tumblr",
					"description" => esc_html__( "Submit in Tumblr", "movedo-extension" ),
					"value" => array( esc_html__( "Show Tumblr social share", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Filter", "movedo-extension" ),
					"param_name" => "gallery_filter",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "movedo-extension" ),
					"dependency" => array( 'element' => "gallery_mode", 'value' => array( 'grid', 'masonry' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					'type' => 'exploded_textarea_safe',
					'heading' => __( 'Filter categories', 'movedo-extension' ),
					'param_name' => 'filter_values',
					'description' => __( 'Enter categories for each image (Note: divide categories with |, separate images with linebreaks (Enter)).', 'movedo-extension' ),
					"dependency" => array( 'element' => "gallery_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order By", "movedo-extension" ),
					"param_name" => "filter_order_by",
					"value" => array(
						esc_html__( "Default ( Unordered )", "movedo-extension" ) => '',
						esc_html__( "Title", "movedo-extension" ) => 'title',
					),
					"description" => '',
					"dependency" => array( 'element' => "gallery_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order", "movedo-extension" ),
					"param_name" => "filter_order",
					"value" => array(
						esc_html__( "Ascending", "movedo-extension" ) => 'ASC',
						esc_html__( "Descending", "movedo-extension" ) => 'DESC',
					),
					"dependency" => array( 'element' => "gallery_filter", 'value' => array( 'yes' ) ),
					"description" => '',
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "movedo-extension" ),
					"param_name" => "filter_align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "gallery_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Style", "movedo-extension" ),
					"param_name" => "filter_style",
					"value" => array(
						esc_html__( "Simple", "movedo-extension" ) => 'simple',
						esc_html__( "Button", "movedo-extension" ) => 'button',
						esc_html__( "Classic", "movedo-extension" ) => 'classic',

					),
					"dependency" => array( 'element' => "gallery_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Shape", "movedo-extension" ),
					"param_name" => "filter_shape",
					"value" => array(
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'round',
						esc_html__( "Extra Round", "movedo-extension" ) => 'extra-round',
					),
					"dependency" => array( 'element' => "filter_style", 'value' => array( 'button' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_gallery', 'movedo_ext_vce_gallery_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_gallery_shortcode_params( 'movedo_gallery' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
