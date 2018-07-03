<?php

/*
 *	Helper functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */

 /**
 * Helper function to get array value with fallback
 */
if ( !function_exists( 'movedo_ext_vce_array_value' ) ) {
	function movedo_ext_vce_array_value( $input_array, $id, $fallback = false, $param = false ) {

		if ( $fallback == false ) $fallback = '';
		$output = ( isset($input_array[$id]) && $input_array[$id] !== '' ) ? $input_array[$id] : $fallback;
		if ( !empty($input_array[$id]) && $param ) {
			$output = ( isset($input_array[$id][$param]) && $input_array[$id][$param] !== '' ) ? $input_array[$id][$param] : $fallback;
		}
		return $output;
	}
}

/**
 * Helper function to get custom fields with fallback
 */
if ( !function_exists( 'movedo_ext_vce_post_meta' ) ) {
	function movedo_ext_vce_post_meta( $id, $fallback = false ) {
		global $post;
		$post_id = $post->ID;
		if ( $fallback == false ) $fallback = '';
		$post_meta = get_post_meta( $post_id, $id, true );
		$output = ( $post_meta !== '' ) ? $post_meta : $fallback;
		return $output;
	}
}


function movedo_ext_vce_post_bg_image_container( $options = array() ) {
	if ( function_exists( 'movedo_grve_print_post_bg_image_container' ) ) {
		movedo_grve_print_post_bg_image_container( $options );
	}
}

function movedo_ext_vce_print_post_video_popup() {
	if ( function_exists( 'movedo_grve_print_post_video_popup' ) ) {
		movedo_grve_print_post_video_popup();
	}
}

function movedo_ext_vce_starts_with( $haystack, $needle ) {
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function movedo_ext_vce_img_style( $bg_image = '' , $bg_image_size = 'full' ) {
	$style = '';

	if((int)$bg_image > 0 && ($attachment_src = wp_get_attachment_image_src( $bg_image, $bg_image_size )) !== false) {
		$image_url = $attachment_src[0];
		$style .= "background-image: url(" . esc_url( $image_url ) . ");";
	} else {
		$image_url = movedo_ext_vce_get_fallback_image( $bg_image_size ,'url' );
		$style .= "background-image: url(" . esc_url( $image_url ) . ");";
	}
	return ' style="' . $style . '"';
}

function movedo_ext_vce_img_url( $bg_image = '' , $bg_image_size = 'full' ) {
	$image_url = "";
	if((int)$bg_image > 0 && ($attachment_src = wp_get_attachment_image_src( $bg_image, $bg_image_size )) !== false) {
		$image_url = $attachment_src[0];
	}
	return $image_url;
}


 /**
 * Generates a button
 * Used in shortcodes to display a button
 */
function movedo_ext_vce_get_button( $button_options ) {

	$button_text = movedo_ext_vce_array_value( $button_options, 'button_text' );
	$button_link = movedo_ext_vce_array_value( $button_options, 'button_link' );
	$button_type = movedo_ext_vce_array_value( $button_options, 'button_type' );
	$button_size = movedo_ext_vce_array_value( $button_options, 'button_size' );
	$button_color = movedo_ext_vce_array_value( $button_options, 'button_color' );
	$button_hover_color = movedo_ext_vce_array_value( $button_options, 'button_hover_color' );
	$button_line_color = movedo_ext_vce_array_value( $button_options, 'button_line_color' );
	$button_gradient_color_1 = movedo_ext_vce_array_value( $button_options, 'button_gradient_color_1' );
	$button_gradient_color_2 = movedo_ext_vce_array_value( $button_options, 'button_gradient_color_2' );
	$button_shape = movedo_ext_vce_array_value( $button_options, 'button_shape' );
	$button_shadow = movedo_ext_vce_array_value( $button_options, 'button_shadow' );
	$button_extra_class = movedo_ext_vce_array_value( $button_options, 'button_class' );
	$style = movedo_ext_vce_array_value( $button_options, 'style' );

	$btn_add_icon = movedo_ext_vce_array_value( $button_options, 'btn_add_icon' );
	$btn_icon_library = movedo_ext_vce_array_value( $button_options, 'btn_icon_library' );
	$btn_icon_fontawesome = movedo_ext_vce_array_value( $button_options, 'btn_icon_fontawesome' );
	$btn_icon_openiconic = movedo_ext_vce_array_value( $button_options, 'btn_icon_openiconic' );
	$btn_icon_typicons = movedo_ext_vce_array_value( $button_options, 'btn_icon_typicons' );
	$btn_icon_entypo = movedo_ext_vce_array_value( $button_options, 'btn_icon_entypo' );
	$btn_icon_linecons = movedo_ext_vce_array_value( $button_options, 'btn_icon_linecons' );
	$btn_icon_simplelineicons = movedo_ext_vce_array_value( $button_options, 'btn_icon_simplelineicons' );
	$btn_icon_etlineicons = movedo_ext_vce_array_value( $button_options, 'btn_icon_etlineicons' );

	$button_fluid = movedo_ext_vce_array_value( $button_options, 'btn_fluid' );
	$button_fluid_height = movedo_ext_vce_array_value( $button_options, 'btn_fluid_height' );

	$button = "";

	if ( !empty( $button_text) || 'yes' == $btn_add_icon ) {
		$button_classes = array( 'grve-btn' );

		array_push( $button_classes, 'grve-btn-' . $button_size );

		if ( !empty( $button_shadow ) ) {
			array_push( $button_classes, 'grve-shadow-' . $button_shadow );
		}

		if ( 'simple' == $button_type || 'outline' == $button_type ) {
			array_push( $button_classes, 'grve-' . $button_shape );
			array_push( $button_classes, 'grve-bg-' . $button_color );
			array_push( $button_classes, 'grve-bg-hover-' . $button_hover_color );
		}

		if ( 'outline' == $button_type ) {
			array_push( $button_classes, 'grve-btn-line' );
		}

		if ( 'underline' == $button_type ) {
			array_push( $button_classes, 'grve-btn-underline' );
			array_push( $button_classes, 'grve-text-' . $button_color );
			array_push( $button_classes, 'grve-text-hover-' . $button_color );
		}
		if ( 'gradient' == $button_type ) {
			$uid = uniqid();
			array_push( $button_classes, 'grve-btn-gradient' );
			array_push( $button_classes, 'grve-btn-' . $uid );
			array_push( $button_classes, 'grve-' . $button_shape );
			array_push( $button_classes, 'grve-bg-' . $button_hover_color );
			array_push( $button_classes, 'grve-bg-hover-' . $button_hover_color );

			$colors = array();
			if ( function_exists( 'movedo_grve_get_color_array' ) ) {
				$colors = movedo_grve_get_color_array();
			}

			$gradient_color_1 = movedo_ext_vce_array_value( $colors, $button_gradient_color_1, '#000000');
			$gradient_color_2 = movedo_ext_vce_array_value( $colors, $button_gradient_color_2, '#000000');

			$gradient_css = array();
			$gradient_css[] = 'background: ' . esc_attr( $gradient_color_1 );
			$gradient_css[] = 'background: -moz-linear-gradient(left, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
			$gradient_css[] = 'background: -webkit-linear-gradient(left, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';
			$gradient_css[] = 'background: linear-gradient(to right, ' . esc_attr( $gradient_color_1 ) . ' 0%, ' . esc_attr( $gradient_color_2 ) . ' 100%)';

			$button .= '<style type="text/css">';
			$button .= '.grve-btn-gradient.grve-btn-' . $uid . ':before {';
			$button .= implode( ';', $gradient_css ) . ';';
			$button .= '}';
			$button .= '</style>';
		}

		if ( 'yes' == $button_fluid ) {
			array_push( $button_classes, 'grve-fullwidth-btn' );
			array_push( $button_classes, 'grve-fluid-btn-' . $button_fluid_height );
		}

		if ( !empty( $button_extra_class ) ) {
			array_push( $button_classes, $button_extra_class );
		}

		$button_class_string = implode( ' ', $button_classes );

		$button_attributes = movedo_ext_vce_get_link_attributes( $button_link, $button_class_string , $style );

		if( 'yes' == $btn_add_icon ) {
			$icon_class = isset( ${"btn_icon_" . $btn_icon_library} ) ? esc_attr( ${"btn_icon_" . $btn_icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $btn_icon_library );
			}
		}

		$button .= '<a ' . implode( ' ', $button_attributes ) . '>';
		$button .= '<span>';
		if( 'yes' == $btn_add_icon ) {
			$button .= '<i class="' . esc_attr( $icon_class ) . '"></i>';
		}
		$button .= $button_text;
		if ( 'underline' == $button_type ) {
			$button .= '<span class="grve-btn-bottom-line grve-bg-' . esc_attr( $button_line_color ) . '"></span>';
		}
		$button .= '</span>';
		$button .= '</a>';
	}

	return $button;

}

function movedo_ext_vce_has_link( $link = '' ) {

	$has_link = false;

	if ( !empty( $link ) ){
		$link = vc_build_link( $link );
		if ( strlen( $link['url'] ) > 0 ) {
			$has_link = true;
		}
	}
	return $has_link;

}

function movedo_ext_vce_get_link_attributes( $link = '', $class = '', $style = ''  ) {
	$attributes = array();
	$a_href = $a_title = $a_target = $a_rel = '';
	$use_link = false;

	if ( !empty( $link ) ){
		$link = vc_build_link( $link );
		if ( strlen( $link['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
			$a_rel = $link['rel'];
		}
	}

	if ( $use_link ) {
		$attributes[] = 'href="' . esc_url( $a_href ) . '"';
		if ( ! empty( $a_title ) ) {
			$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
		}
		if ( ! empty( $a_target ) ) {
			$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
		}
		if ( ! empty( $a_rel ) ) {
			$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
		}
	} else {
		$attributes[] = 'href="#"';
	}


	if ( ! empty( $class ) ) {
		$attributes[] = 'class="' . esc_attr( $class ) . '"';
	}
	if ( ! empty( $style ) ) {
		$attributes[] = 'style="' . esc_attr( $style ) . '"';
	}

	return $attributes;
}

 /**
 * Print Portfolio Image
 * Used in portfolio to fetch feature image or link
 */
function movedo_ext_vce_print_portfolio_image( $image_size , $mode = '', $atts = array() ) {

	if ( empty( $mode ) && !has_post_thumbnail() ) {
		echo movedo_ext_vce_get_fallback_image( $image_size );
	} else {
		if( function_exists( 'movedo_grve_print_portfolio_image' ) ) {
			movedo_grve_print_portfolio_image( $image_size , $mode, $atts );
		}
	}

}

 /**
 * Fetch Portfolio Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function movedo_ext_vce_get_portfolio_categories() {

	$portfolio_category = array( esc_html__( "All Categories", "movedo-extension" ) => "" );

	$portfolio_cats = get_terms( 'portfolio_category' );
	if ( is_array( $portfolio_cats ) ) {
	  foreach ( $portfolio_cats as $portfolio_cat ) {
		$portfolio_category[$portfolio_cat->name] = $portfolio_cat->term_id;

	  }
	}
	return $portfolio_category;

}

 /**
 * Fetch Portfolio Categories
 * Used in portfolio filter to generate the list of used categories ( front end )
 */
function movedo_ext_vce_get_portfolio_list() {

	$all_string =  apply_filters( 'movedo_grve_vce_portfolio_string_all_categories', esc_html__( 'All', 'movedo-extension' ) );

	$get_portfolio_category = get_categories( array( 'taxonomy' => 'portfolio_category') );
	$portfolio_category_list = array( '0' => $all_string );

	foreach ( $get_portfolio_category as $portfolio_category ) {
		$portfolio_category_list[] = $portfolio_category->cat_name;
	}
	return $portfolio_category_list;

}

 /**
 * Fetch Testimonial Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function movedo_ext_vce_get_testimonial_categories() {
	$testimonial_category = array( esc_html__( "All Categories", "movedo-extension" ) => "" );

	$testimonial_cats = get_terms( 'testimonial_category' );
	if ( is_array( $testimonial_cats ) ) {
	  foreach ( $testimonial_cats as $testimonial_cat ) {
		$testimonial_category[$testimonial_cat->name] = $testimonial_cat->term_id;
	  }
	}
	return $testimonial_category;
}

 /**
 * Fetch Post Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function movedo_ext_vce_get_post_categories() {
	$category = array( esc_html__( "All Categories", "movedo-extension" ) => "" );

	$cats = get_terms( 'category' );
	if ( is_array( $cats ) ) {
	  foreach ( $cats as $cat ) {
		$category[$cat->name] = $cat->term_id;
	  }
	}
	return $category;
}

 /**
 * Fetch Product Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function movedo_ext_vce_get_product_categories() {
	$product_category = array( esc_html__( "All Categories", "movedo-extension" ) => "" );

	$product_cats = get_terms( 'product_cat' );
	if ( is_array( $product_cats ) ) {
	  foreach ( $product_cats as $product_cat ) {
		$product_category[$product_cat->name] = $product_cat->term_id;
	  }
	}
	return $product_category;
}

 /**
 * Fetch Events Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function movedo_ext_vce_get_event_categories() {
	$event_category = array( esc_html__( "All Categories", "movedo-extension" ) => "" );

	$event_cats = get_terms( 'tribe_events_cat' );
	if ( is_array( $event_cats ) ) {
	  foreach ( $event_cats as $event_cat ) {
		$event_category[$event_cat->name] = $event_cat->term_id;
	  }
	}
	return $event_category;
}

 /**
 * Fetch Menus
 * Used in shortcodes to generate the list of menus ( back end )
 */
function movedo_ext_vce_get_menus() {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

	$custom_menus = array( esc_html__( "None", "movedo-extension" ) => "" );
	if ( is_array( $menus ) && ! empty( $menus ) ) {
		foreach ( $menus as $single_menu ) {
			if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->term_id ) ) {
				$custom_menus[ $single_menu->name ] = $single_menu->term_id;
			}
		}
	}
	return $custom_menus;
}



 /**
 * Generates dimension string to concat in attribute style
 */
function movedo_ext_vce_build_dimension( $dimension, $value ) {
	$fixed_dimension = '';

	if( ! empty( $dimension ) &&  ! empty( $value )  ) {
		$fixed_dimension .= $dimension . ': '.(preg_match('/(px|em|\%|pt|cm)$/', $value) ? $value : $value.'px').';';
	}
	return $fixed_dimension;
}

 /**
 * Generates margin-bottom string to concat in attribute style
 */
function movedo_ext_vce_build_margin_bottom_style( $margin_bottom ) {
	$style = '';
	if( $margin_bottom != '' ) {
		$style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom .'px').';';
		$style = esc_attr( $style );
	}
	return $style;
}

 /**
 * Generates padding-top string to concat in attribute style
 */
function movedo_ext_vce_build_padding_top_style( $padding_top ) {
	$style = '';
	if( $padding_top != '' ) {
		$style .= 'padding-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_top) ? $padding_top : $padding_top.'px').';';
		$style = esc_attr( $style );
	}
	return $style;
}

 /**
 * Generates padding-bottom string to concat in attribute style
 */
function movedo_ext_vce_build_padding_bottom_style( $padding_bottom ) {
	$style = '';
	if( $padding_bottom != '' ) {
		$style .= 'padding-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_bottom) ? $padding_bottom : $padding_bottom.'px').';';
		$style = esc_attr( $style );
	}
	return $style;
}

/**
 * Get CSS Color
 */
function movedo_ext_vce_get_css_color( $prefix, $color ) {
	$rgb_color = preg_match( '/rgba/', $color ) ? preg_replace( array( '/\s+/', '/^rgba\((\d+)\,(\d+)\,(\d+)\,([\d\.]+)\)$/' ), array( '', 'rgb($1,$2,$3)' ), $color ) : $color;
	$string = $prefix . ':' . $rgb_color . ';';
	if ( $rgb_color !== $color ) $string .= $prefix . ':' . $color . ';';
	return $string;
}
function movedo_ext_vce_build_shortcode_style( $item = array() ) {


	$bg_color = movedo_ext_vce_array_value( $item, 'bg_color' );
	$bg_gradient_color_1 = movedo_ext_vce_array_value( $item, 'bg_gradient_color_1' );
	$bg_gradient_color_2 = movedo_ext_vce_array_value( $item, 'bg_gradient_color_2' );
	$bg_gradient_direction = movedo_ext_vce_array_value( $item, 'bg_gradient_direction' );
	$font_color = movedo_ext_vce_array_value( $item, 'font_color' );
	$padding_top = movedo_ext_vce_array_value( $item, 'padding_top');
	$padding_bottom = movedo_ext_vce_array_value( $item, 'padding_bottom' );
	$margin_bottom = movedo_ext_vce_array_value( $item, 'margin_bottom' );
	$position_top = movedo_ext_vce_array_value( $item, 'position_top' );
	$position_bottom = movedo_ext_vce_array_value( $item, 'position_bottom' );
	$position_left = movedo_ext_vce_array_value( $item, 'position_left' );
	$position_right = movedo_ext_vce_array_value( $item, 'position_right' );
	$z_index = movedo_ext_vce_array_value( $item, 'z_index' );

	$style = '';

	if(!empty($bg_color)) {
		$style .= movedo_ext_vce_get_css_color( 'background-color', $bg_color );
	}

	if( !empty($bg_gradient_color_1) && !empty($bg_gradient_color_2) && !empty($bg_gradient_direction) ) {
		$style .= movedo_ext_vce_get_css_color( 'background', $bg_gradient_color_1 );
		$style .= 'background: linear-gradient(' . $bg_gradient_direction. 'deg,' . $bg_gradient_color_1 . ' 0%,' . $bg_gradient_color_2 .' 100%);';
	}

	if( !empty($font_color) ) {
		$style .= movedo_ext_vce_get_css_color( 'color', $font_color );
	}
	if( $padding_top != '' ) {
		$style .= 'padding-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_top) ? $padding_top : $padding_top.'px').';';
	}
	if( $padding_bottom != '' ) {
		$style .= 'padding-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_bottom) ? $padding_bottom : $padding_bottom.'px').';';
	}
	if( $margin_bottom != '' ) {
		$style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom.'px').';';
	}
	if( $position_top != '' ) {
		$style .= 'top: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_top) ? $position_top : $position_top.'px').';';
	}
	if( $position_bottom != '' ) {
		$style .= 'bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_bottom) ? $position_bottom : $position_bottom.'px').';';
	}
	if( $position_left != '' ) {
		$style .= 'left: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_left) ? $position_left : $position_left.'px').';';
	}
	if( $position_right != '' ) {
		$style .= 'right: '.(preg_match('/(px|em|\%|pt|cm)$/', $position_right) ? $position_right : $position_right.'px').';';
	}
	if( $z_index != '' ) {
		$style .= 'z-index:' . $z_index;
	}

	return empty($style) ? $style : ' style="'.$style.'"';
}

 /**
 * Prints blog class depending on the blog style
 */
function movedo_ext_vce_get_blog_class( $movedo_ext_blog_mode = 'blog-large'  ) {

	switch( $movedo_ext_blog_mode ) {

		case 'blog-small':
			$movedo_ext_blog_mode_class = 'grve-blog grve-blog-small grve-non-isotope';
			break;
		case 'masonry':
			$movedo_ext_blog_mode_class = 'grve-blog grve-blog-columns grve-blog-masonry grve-isotope grve-with-gap';
			break;
		case 'grid':
			$movedo_ext_blog_mode_class = 'grve-blog grve-blog-columns grve-blog-grid grve-isotope grve-with-gap';
			break;
		case 'carousel':
			$movedo_ext_blog_mode_class = 'grve-carousel-wrapper';
			break;
		case 'blog-large':
		default:
			$movedo_ext_blog_mode_class = 'grve-blog grve-blog-large grve-non-isotope';
			break;

	}

	return $movedo_ext_blog_mode_class;

}



 function movedo_ext_vce_print_post_loop( $blog_mode, $post_format, $heading_tag, $heading, $auto_excerpt, $excerpt_length, $excerpt_more ) {

	switch( $post_format ) {
		case 'link':
				$bg_color = movedo_ext_vce_post_meta( '_movedo_grve_post_link_bg_color', 'primary-1' );
				$bg_hover_color = movedo_ext_vce_post_meta( '_movedo_grve_post_link_bg_hover_color', 'black' );
				$bg_opacity = movedo_ext_vce_post_meta( '_movedo_grve_post_link_bg_opacity', '70' );
				$bg_options = array(
					'bg_color' => $bg_color,
					'bg_hover_color' => $bg_hover_color,
					'bg_opacity' => $bg_opacity,
				);

				echo '<a class="grve-post-link" ' . movedo_ext_vce_print_post_link( 'link' ) . ' rel="bookmark"></a>';
				movedo_ext_vce_post_bg_image_container( $bg_options );
				echo '<div class="grve-post-content-wrapper">';
				echo '  <div class="grve-post-content">';
				echo '    <div class="grve-post-icon">';
				echo '      <i class="grve-icon-link"></i>';
				echo '      <svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>';
				echo '    </div>';
				movedo_ext_vce_print_post_title( $blog_mode, $post_format, $heading_tag, $heading );
				movedo_ext_vce_print_post_excerpt( $blog_mode, $post_format, $auto_excerpt, $excerpt_length );
				echo '    <div class="grve-post-url">' . movedo_ext_vce_print_post_link( 'link', 'url' ) . '</div>';
				echo '  </div>';
				echo '</div>';
			break;
		case 'quote':

				$bg_color = movedo_ext_vce_post_meta( '_movedo_grve_post_quote_bg_color', 'primary-1' );
				$bg_hover_color = movedo_ext_vce_post_meta( '_movedo_grve_post_quote_bg_hover_color', 'black' );
				$bg_opacity = movedo_ext_vce_post_meta( '_movedo_grve_post_quote_bg_opacity', '70' );
				$bg_options = array(
					'bg_color' => $bg_color,
					'bg_hover_color' => $bg_hover_color,
					'bg_opacity' => $bg_opacity,
				);
				$movedo_grve_post_quote_name = movedo_ext_vce_post_meta( '_movedo_grve_post_quote_name' );

				echo '<a class="grve-post-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark"></a>';
				movedo_ext_vce_post_bg_image_container( $bg_options );
				echo '<div class="grve-post-content-wrapper">';
				echo '  <div class="grve-post-content">';
				echo '    <div class="grve-post-icon">';
				echo '      <i class="grve-icon-quote"></i>';
				echo '      <svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>';
				echo '    </div>';
				movedo_ext_vce_print_post_title( $blog_mode, $post_format, $heading_tag, $heading );
				movedo_ext_vce_print_post_excerpt( $blog_mode, $post_format, $auto_excerpt, $excerpt_length );
				if ( !empty( $movedo_grve_post_quote_name ) ) {
					echo '<div class="grve-quote-writer">' . wp_kses_post(  $movedo_grve_post_quote_name ) . '</div>';
				}
				echo '  </div>';
				echo '</div>';
			break;
		default:
			break;
	}
 }

 /**
 * Prints post title depending on the blog style and post format
 */
function movedo_ext_vce_print_post_title( $blog_mode, $post_format, $heading_tag, $heading ) {

	$title_tag = $heading_tag;

	if( 'auto' == $heading ) {
		$heading = 'h3';
		if( 'blog-large' == $blog_mode || 'blog-small' == $blog_mode  ) {
			$heading = 'h2';
		}
	}

	if( 'leader' == $blog_mode ) {
		the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-post-title-hover grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
	} else {
		switch( $post_format ) {
			case 'link':
				if( 'carousel' == $blog_mode ) {
					the_title( '<a ' . movedo_ext_vce_print_post_link( 'link' ) . ' rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
				} else {
					if( 'auto' == $heading ) {
						$heading = 'h4';
					}
					the_title( '<' . tag_escape( $title_tag ) . ' class="grve-post-title grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '>' );
				}
				break;
			case 'quote':
				if( 'carousel' == $blog_mode ) {
					the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
				} else {
					the_title( '<' . tag_escape( $title_tag ) . ' class="grve-post-title grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '>' );
				}
				break;
			default:
				 the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-post-title-hover grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
				break;
		}
	}

}

 /**
 * Prints post link
 */
function movedo_ext_vce_print_post_link( $post_format = 'standard', $mode = '' ) {
	global $post;
	$post_id = $post->ID;

	$movedo_ext_link = get_permalink();
	$movedo_ext_target = '_self';

	if ( 'link' == $post_format ) {
		$movedo_ext_link = get_post_meta( $post_id, '_movedo_grve_post_link_url', true );
		$new_window = get_post_meta( $post_id, '_movedo_grve_post_link_new_window', true );

		if( empty( $movedo_ext_link ) ) {
			$movedo_ext_link = get_permalink();
		}

		if( !empty( $new_window ) ) {
			$movedo_ext_target = '_blank';
		}

		if ( 'url' == $mode ) {
			return $movedo_ext_link;
		}
	}

	return 'href="' . esc_url( $movedo_ext_link ) . '" target="' . esc_attr( $movedo_ext_target ) . '"';

}

/**
 * Prints excerpt depending on the blog style and post format
 */
function movedo_ext_vce_print_post_excerpt( $blog_mode, $post_format, $autoexcerpt = '', $excerpt_length = '55', $excerpt_more = '' ) {

	if ( 'link' ==  $post_format || 'quote' ==  $post_format ) {
		$excerpt_more = '';
		$autoexcerpt = '1';
	}

	echo '<div itemprop="articleBody">';
	switch( $blog_mode ) {
		case 'blog-large':
			if ( empty( $autoexcerpt ) ) {
				if ( empty( $excerpt_more ) ) {
					the_content( '' );
				} else {
					global $more;
					$more = 0;
					the_content( movedo_ext_vce_read_more_string() );
				}
			} else {
				if( 'quote' ==  $post_format ) {
					echo movedo_ext_vce_quote_excerpt( $excerpt_length );
				} else {
					echo movedo_ext_vce_excerpt( $excerpt_length, $excerpt_more );
				}
			}
			break;
		default:
			if( 'quote' ==  $post_format ) {
				echo movedo_ext_vce_quote_excerpt( $excerpt_length );
			} else {
				echo movedo_ext_vce_excerpt( $excerpt_length, $excerpt_more );
			}
			break;
	}
	echo '</div>';

}

/**
 * Returns read more link
 */
if ( !function_exists('movedo_ext_vce_read_more') ) {
	function movedo_ext_vce_read_more( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$read_more_string =  apply_filters( 'movedo_grve_vce_string_read_more', esc_html__( 'read more', 'movedo-extension' ) );
		return '<a class="grve-read-more grve-link-text grve-heading-color grve-text-hover-primary-1" href="' . esc_url( get_permalink( $post_id ) ) . '"><span>' . $read_more_string . '</span></a>';
	}
}

/**
 * Returns read more string
 */
if ( !function_exists('movedo_ext_vce_read_more_string') ) {
	function movedo_ext_vce_read_more_string() {
		$read_more_string =  apply_filters( 'movedo_grve_vce_string_read_more', esc_html__( 'read more', 'movedo-extension' ) );
		return $read_more_string;
	}
}

/**
 * Returns excerpt
 */
if ( !function_exists('movedo_ext_vce_excerpt') ) {
	function movedo_ext_vce_excerpt( $limit, $more = "" ) {
		global $post;
		$post_id = $post->ID;
		$excerpt = "";

		if ( has_excerpt( $post_id ) ) {
			if ( 0 != $limit ) {
				$excerpt = $post->post_excerpt;
				$excerpt = apply_filters('the_excerpt', $excerpt);
			}
			if ( 'yes' == $more ) {
				$excerpt .= movedo_ext_vce_read_more( $post_id );
			}
		} else {
			$content = get_the_content('');
			$content = apply_filters('movedo_ext_the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			if ( 0 != $limit ) {
				$excerpt = '<p>' . wp_trim_words( $content, $limit ) . '</p>';
			}
			if ( 'yes' == $more ) {
				$excerpt .= movedo_ext_vce_read_more( $post_id );
			}
		}
		return	$excerpt;
	}
}

if ( !function_exists('movedo_ext_vce_quote_excerpt') ) {
	function movedo_ext_vce_quote_excerpt( $limit ) {
		$excerpt = "";
		if ( 0 != $limit ) {
			$content = movedo_ext_vce_post_meta( '_movedo_grve_post_quote_text' );
			$excerpt = '<p>' . wp_trim_words( $content, $limit ) . '</p>';
		}
		return	$excerpt;
	}
}

/**
 * Prints feature media depending on the blog style and post format
 */
function movedo_ext_vce_print_carousel_media( $carousel_image_mode = '', $attr = array() ) {
	global $post;
	$post_id = $post->ID;
	$image_href = get_permalink();

	if( 'square' == $carousel_image_mode ) {
		$image_size = 'movedo-grve-small-square';
	} elseif( 'portrait' == $carousel_image_mode ) {
		$image_size = 'movedo-grve-small-rect-vertical';
	} else {
		$image_size = 'movedo-grve-small-rect-horizontal';
	}

	$image_src = MOVEDO_EXT_PLUGIN_DIR_URL .'assets/images/empty/' . $image_size . '.jpg';
?>
		<div class="grve-media grve-image-hover">
			<?php if ( has_post_thumbnail( $post_id ) ) { ?>
			<a href="<?php echo esc_url( $image_href ); ?>"><?php the_post_thumbnail( $image_size, $attr ); ?></a>
			<?php } else { ?>
			<a class="grve-no-image" href="<?php echo esc_url( $image_href ); ?>"><img src="<?php echo esc_url( $image_src ); ?>" alt="no image"></a>
			<?php } ?>

		</div>
<?php
}

/**
 * Prints feature media depending on the blog style and post format
 */

function movedo_ext_vce_print_post_bg_media( $blog_mode, $post_format ) {

	$post_style = '';
	if ( '' == $post_format || 'image' == $post_format ) {
		$post_style = movedo_ext_vce_post_meta( '_movedo_grve_post_standard_style' );
		$bg_color = movedo_ext_vce_post_meta( '_movedo_grve_post_standard_bg_color', 'black' );
		$bg_opacity = movedo_ext_vce_post_meta( '_movedo_grve_post_standard_bg_opacity', '70' );
	} else if ( 'video' == $post_format ) {
		$post_style = movedo_ext_vce_post_meta( '_movedo_grve_post_video_style' );
		$bg_color = movedo_ext_vce_post_meta( '_movedo_grve_post_video_bg_color', 'black' );
		$bg_opacity = movedo_ext_vce_post_meta( '_movedo_grve_post_video_bg_opacity', '70' );
	}

	if ( ( 'masonry' == $blog_mode || 'grid' == $blog_mode ) && 'movedo' == $post_style ) {
		$bg_options = array(
			'bg_color' => $bg_color,
			'bg_opacity' => $bg_opacity,
		);
		movedo_ext_vce_post_bg_image_container( $bg_options );
	}

}

function movedo_ext_vce_is_post_bg( $blog_mode, $post_format ) {

	$bg_mode = false;
	$post_style = '';
	if ( '' == $post_format || 'image' == $post_format ) {
		$post_style = movedo_ext_vce_post_meta( '_movedo_grve_post_standard_style' );
	} else if ( 'video' == $post_format ) {
		$post_style = movedo_ext_vce_post_meta( '_movedo_grve_post_video_style' );
	}

	if ( ( 'masonry' == $blog_mode || 'grid' == $blog_mode ) && 'movedo' == $post_style ) {
		$bg_mode = true;
	}

	return $bg_mode;

}

function movedo_ext_vce_print_post_feature_media( $blog_mode = 'blog-large', $post_format, $blog_image_mode, $blog_image_prio, $image_atts = array() ) {
	global $post, $wp_embed;

	$post_id = $post->ID;

	switch( $blog_mode ) {
		case 'blog-small':
		case 'grid':
		case 'masonry':
			$image_size = movedo_ext_vce_get_image_size( $blog_image_mode );
			break;
		case 'blog-large':
		default:
			if ( empty( $blog_image_mode ) ) {
				$image_size = 'movedo-grve-large-rect-horizontal';
			} else {
				$image_size = movedo_ext_vce_get_image_size( $blog_image_mode );
			}

			break;
	}
	$image_href = get_permalink();

	if ( 'leader' == $blog_mode ) {
		if( has_post_thumbnail( $post_id ) ) {
?>
		<div class="grve-media clearfix">
			<a href="<?php echo esc_url( $image_href ); ?>"><?php the_post_thumbnail( $image_size, $image_atts ); ?></a>
		</div>
<?php
		}
		return;
	}

	if ( ( '' == $post_format || 'image' == $post_format || 'yes' == $blog_image_prio ) &&  has_post_thumbnail( $post_id ) ) {
?>
		<div class="grve-media">
			<a class="grve-item-url" href="<?php echo esc_url( $image_href ); ?>"></a>
			<?php the_post_thumbnail( $image_size, $image_atts ); ?>
			<div class="grve-bg-black grve-hover-overlay grve-opacity-10"></div>
		</div>
<?php

	} else if ( 'audio' == $post_format ) {

		$audio_mode = get_post_meta( $post_id, '_movedo_grve_post_type_audio_mode', true );
		$audio_mp3 = get_post_meta( $post_id, '_movedo_grve_post_audio_mp3', true );
		$audio_ogg = get_post_meta( $post_id, '_movedo_grve_post_audio_ogg', true );
		$audio_wav = get_post_meta( $post_id, '_movedo_grve_post_audio_wav', true );
		$audio_embed = get_post_meta( $post_id, '_movedo_grve_post_audio_embed', true );

		if( empty( $audio_mode ) && !empty( $audio_embed ) ) {
			$audio_output = '';
			$audio_output .= '<div class="grve-media">';
			$audio_output .= $audio_embed;
			$audio_output .= '</div>';
			echo $audio_output;
		} else {

			if ( !empty( $audio_mp3 ) || !empty( $audio_ogg ) || !empty( $audio_wav ) ) {

				$audio_output = '[audio ';

				if ( !empty( $audio_mp3 ) ) {
					$audio_output .= 'mp3="'. esc_url( $audio_mp3 ) .'" ';
				}
				if ( !empty( $audio_ogg ) ) {
					$audio_output .= 'ogg="'. esc_url( $audio_ogg ) .'" ';
				}
				if ( !empty( $audio_wav ) ) {
					$audio_output .= 'wav="'. esc_url ( $audio_wav ) .'" ';
				}

				$audio_output .= ']';

				echo '<div class="grve-media">';
				echo  do_shortcode( $audio_output );
				echo '</div>';

			}
		}
	} else if ( 'video' == $post_format ) {

		$video_mode = get_post_meta( $post_id, '_movedo_grve_post_type_video_mode', true );
		$video_embed = get_post_meta( $post_id, '_movedo_grve_post_video_embed', true );

		$video_output = '';

		if( empty( $video_mode ) && !empty( $video_embed ) ) {
			$video_output .= '<div class="grve-media">';
			$video_output .= $wp_embed->run_shortcode( '[embed]' . $video_embed . '[/embed]' );
			$video_output .= '</div>';
		} else {
			$video_webm = get_post_meta( $post_id, '_movedo_grve_post_video_webm', true );
			$video_mp4 = get_post_meta( $post_id, '_movedo_grve_post_video_mp4', true );
			$video_ogv = get_post_meta( $post_id, '_movedo_grve_post_video_ogv', true );
			$video_poster = get_post_meta( $post_id, '_movedo_grve_post_video_poster', true );

			$video_attr = '';
			$video_settings = array(
				'controls' => 'yes',
				'poster' => $video_poster,
			);
			$video_settings = apply_filters( 'movedo_ext_vce_media_video_settings', $video_settings );

			if ( function_exists( 'movedo_grve_print_media_video_settings' ) ) {
				$video_attr = movedo_grve_print_media_video_settings( $video_settings );
			} else {
				$video_attr = ' controls';
			}
			if ( !empty( $video_webm ) || !empty( $video_mp4 ) || !empty( $video_ogv ) ) {
				$video_output .= '<div class="grve-media">';
				$video_output .= '  <video ' . $video_attr . '>';

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
	} else if ( 'gallery' == $post_format ) {

		$slider_items = get_post_meta( $post_id, '_movedo_grve_post_slider_items', true );
		$gallery_mode = 'slider';
		if ( !empty( $slider_items ) ) {
			switch( $blog_mode ) {
				case 'blog-large':
					$image_size = 'movedo-grve-large-rect-horizontal';
				break;
				default:
					$image_size = 'movedo-grve-small-rect-horizontal';
				break;
			}
			movedo_ext_vce_print_gallery_slider( $slider_items, $image_size, $image_atts  );
		}

	}

}

function movedo_ext_vce_element_navigation( $navigation_type = 0, $navigation_color = 'dark', $navigation_element = 'default' ) {

		$output = '';

		if ( 0 != $navigation_type ) {

			$output .= '<div class="grve-carousel-navigation grve-' . esc_attr( $navigation_color ) . ' grve-navigation-' . esc_attr( $navigation_type ) . ' grve-navigation-' . esc_attr( $navigation_element ) . '">';
			$output .= '	<div class="grve-carousel-buttons">';
			$output .= '		<div class="grve-carousel-prev">';
			$output .= '			<i class="grve-icon-nav-left-small"></i>';
			$output .= '		</div>';
			$output .= '		<div class="grve-carousel-next">';
			$output .= '			<i class="grve-icon-nav-right-small"></i>';
			$output .= '		</div>';
			$output .= '	</div>';
			$output .= '</div>';
		}

	return 	$output;

}

 /**
 * Prints Gallery or Slider
 */
function movedo_ext_vce_print_gallery_slider( $slider_items, $image_size_slider, $image_atts = array() ) {

?>
		<div class="grve-media">
			<div class="grve-element grve-slider grve-layout-1">
				<div class="grve-carousel-wrapper">

					<div class="grve-slider-element " data-slider-speed="2500" data-slider-pause="yes" data-slider-autoheight="no">
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

 /**
 * Prints post categories depending on the blog style
 */
function movedo_ext_vce_print_post_categories() {

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

 /**
 * Prints post date
 */
function movedo_ext_vce_print_post_date( $mode = '') {
		$class = "";
		if( 'list' == $mode ) {
			echo '<li class="grve-post-date">';
		} else if ( 'quote' == $mode ) {
			$class = "grve-post-date";
		} else if ( 'default' == $mode ) {
			$class = "grve-post-date grve-text-primary-1";
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

function movedo_ext_vce_print_list_date() {
	global $post;
?>
	<li class="grve-post-date">
		<time datetime="<?php echo mysql2date( 'c', $post->post_date ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
	</li>
<?php
}

 /**
 * Prints post comments
 */
function movedo_ext_vce_print_post_comments() {
?>
	<li class="grve-post-comments"><?php comments_number(); ?></li>
<?php
}

 /**
 * Prints post author avatar
 */
function movedo_ext_vce_print_post_author( $movedo_ext_blog_mode, $post_format ) {
	if ( 'blog-large' == $movedo_ext_blog_mode ) {
		if ( 'quote' != $post_format && 'link' != $post_format ) {
?>
	<div class="grve-post-author">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
	</div>
<?php
		}
	}
}

 /**
 * Prints post author by depending on the blog style
 */
function movedo_ext_vce_print_post_author_by( $movedo_ext_blog_mode = 'blog-large' ) {

?>
		<li class="grve-post-author">
			<span><?php the_author_link(); ?></span>
		</li>
<?php

}

/**
 * Gets post class depending on the blog style
 */
function movedo_ext_vce_get_post_class( $blog_mode = 'blog-large', $extra_class = '' ) {

	$post_classes = array( 'grve-blog-item' );
	if ( !empty( $extra_class ) ){
		array_push( $post_classes, $extra_class );
	}

	switch( $blog_mode ) {

		case 'blog-large':
			array_push( $post_classes, 'grve-big-post' );
			array_push( $post_classes, 'grve-non-isotope-item' );
			break;

		case 'blog-small':
			array_push( $post_classes, 'grve-small-post' );
			array_push( $post_classes, 'grve-non-isotope-item' );
			break;

		case 'masonry':
		case 'grid':
			array_push( $post_classes, 'grve-isotope-item' );
			break;

		default:
			break;

	}

	return implode( ' ', $post_classes );

}

function movedo_ext_vce_get_image_size( $image_mode = 'full', $index = 1 ) {

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
		case 'loop':
			$image_size = "movedo-grve-small-rect-vertical";
			if ( $index % 2  == 0 ) {
				$image_size = "movedo-grve-medium-rect-horizontal";
			}
		break;
		default:
			$image_size = 'full';
		break;
	}

	return $image_size;

}

function movedo_ext_vce_get_fallback_image_attr( $size = 'movedo-grve-small-rect-horizontal', $atts = array() ) {

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
			$image_atts['width'] = "1024";
			$image_atts['height'] = "768";
		break;
	}

	$placeholder_mode = 'dummy';
	if ( function_exists( 'movedo_grve_option' ) ) {
		$placeholder_mode = movedo_grve_option( 'placeholder_mode', 'dummy' );
	}
	$placeholder_mode =  apply_filters( 'movedo_grve_vce_placeholder_mode', $placeholder_mode );
	switch( $placeholder_mode ) {
		case 'placehold':
			$image_atts['url'] = 'https://placehold.it/' . $image_atts['width'] . 'x' . $image_atts['height'];
		break;
		case 'unsplash':
			$image_atts['url'] = 'https://source.unsplash.com/category/people/' . $image_atts['width'] . 'x' . $image_atts['height'] . '?sig=' . uniqid();
		break;
		case 'dummy':
		default:
			$image_atts['url'] =  MOVEDO_EXT_PLUGIN_DIR_URL .'assets/images/empty/' . $size . '.jpg';
		break;
	}
	if( isset( $atts['class'] ) ) {
		$image_atts['class'] = $atts['class'];
	} else {
		$image_atts['class'] = 'attachment-' . $size . ' size-' . $size ;
	}
	$image_atts['alt'] = "Dummy Image";

	return $image_atts;

}

function movedo_ext_vce_get_fallback_image( $size = 'movedo-grve-small-rect-horizontal', $mode = '', $atts = array() ) {
	$html = '';
	$image_atts = movedo_ext_vce_get_fallback_image_attr( $size, $atts );
	if( 'url' == $mode ) {
		$html = $image_atts['url'];
	} else {
		$html = '<img class="' . esc_attr( $image_atts['class'] ) . '" alt="' . esc_attr( $image_atts['alt'] ) . '" src="' . esc_url( $image_atts['url'] ) . '" width="' . esc_attr( $image_atts['width'] ) . '" height="' . esc_attr( $image_atts['height'] ) . '">';
	}
	return $html;
}

function movedo_ext_vce_get_custom_masonry_data( $size = 'square' ) {

	switch( $size ) {
		case 'landscape':
			$image_size_class = "grve-image-landscape";
			$image_size = 'movedo-grve-medium-rect-horizontal';
			break;
		case 'portrait':
			$image_size_class = "grve-image-portrait";
			$image_size = 'movedo-grve-medium-rect-vertical';
			break;
		case 'large-square':
			$image_size_class = "grve-image-large-square";
			$image_size = 'movedo-grve-medium-square';
			break;
		case 'square':
		default:
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
			break;
	}
	return array(
		'class' => $image_size_class,
		'image_size' => $image_size,
	);
}

function movedo_ext_vce_get_masonry_data( $index, $columns ) {

	$image_size_class = "grve-image-square";
	$image_size = 'movedo-grve-small-square';

	if( '2' == $columns ) {

		if ( $index % 1  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 2  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 4  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 5  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 8  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 9  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 10  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 12  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 13  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 15  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 16  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-medium-square';
		}
	}

	if( '3' == $columns ) {

		if ( $index % 4  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 5  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
		if ( $index % 7  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 8  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
		if ( $index % 9  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
		if ( $index % 10  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
	}

	if( '4' == $columns ) {

		if ( $index % 3  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 5  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-square";
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
		if ( $index % 7  == 0 ) {
			$image_size_class = "grve-image-large-square";
			$image_size = 'movedo-grve-medium-square';
		}
		if ( $index % 10  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}
		if ( $index % 14  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'movedo-grve-small-square';
		}

	}

	if( '5' == $columns ) {

		if ( $index % 3  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'movedo-grve-medium-rect-vertical';
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = "movedo-grve-medium-rect-horizontal";
		}
		if ( $index % 9  == 0 ) {
			$image_size_class = "grve-image-large-square";
			$image_size = 'movedo-grve-medium-square';
		}
	}

	return array(
		'class' => $image_size_class,
		'image_size' => $image_size,
	);
}

function movedo_ext_vce_text_to_bool( $value ) {
	if ( 'yes' == $value ) {
		return 'true';
	}
	return 'false';
}

function movedo_ext_vce_unautop( $s ) {
    $s = str_replace("<p>", "", $s);
    $s = str_replace("</p>", "\n\n", $s);
    return $s;
}

function movedo_ext_vce_auto_br( $s ) {
    $s = str_replace("<p>", "", $s);
    $s = str_replace("</p>", "<br>", $s);
    return $s;
}
//Replace all default templates.
add_filter( 'vc_load_default_templates_action', 'movedo_ext_vce_add_custom_templates' );

function movedo_ext_vce_add_custom_templates() {
	$data = array();
	return $data;
}


/**
 * Prints post structured data
 */
function movedo_ext_vce_print_structured_data() {
	if( function_exists( 'movedo_grve_print_post_structured_data' ) ) {
		movedo_grve_print_post_structured_data();
	}
}

/**
 * Custom Content Filters
 */
add_filter( 'movedo_ext_the_content', 'wptexturize'                       );
add_filter( 'movedo_ext_the_content', 'convert_smilies',               20 );
add_filter( 'movedo_ext_the_content', 'wpautop'                           );
add_filter( 'movedo_ext_the_content', 'shortcode_unautop'                 );
add_filter( 'movedo_ext_the_content', 'prepend_attachment'                );
add_filter( 'movedo_ext_the_content', 'wp_make_content_images_responsive' );
add_filter( 'movedo_ext_the_content', 'do_shortcode',                  11 );

//Omit closing PHP tag to avoid accidental whitespace output errors.
