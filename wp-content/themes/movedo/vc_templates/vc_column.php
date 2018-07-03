<?php

	extract(
		shortcode_atts(
			array(
				'width' => '1/1',
				'column_fullheight' => '',
				'shadow' => '',
				'clipping_animation' => '',
				'clipping_animation_colors' => 'dark',
				'animation_delay' => '200',
				'tablet_landscape_column_fullheight' => '',
				'tablet_portrait_column_fullheight' => '',
				'mobile_column_fullheight' => '',
				'font_color' => '',
				'heading_color' => '',
				'vertical_content_position' => 'top',
				'position_top' => '',
				'position_bottom' => '',
				'position_left' => '',
				'position_right' => '',
				'tablet_landscape_column_positions' => '',
				'tablet_portrait_column_positions' => '',
				'mobile_column_positions' => '',
				'z_index' => '',
				'column_effect' => 'none',
				'tablet_landscape_column_effect' => '',
				'tablet_portrait_column_effect' => 'none',
				'mobile_column_effect' => 'none',
				'column_effect_sensitive' => 'low',
				'column_effect_limit' => '1x',
				'column_effect_invert' => 'false',
				'desktop_hide' => '',
				'tablet_width' => '',
				'tablet_sm_width' => '',
				'mobile_width' => '',
				'el_class' => '',
				'el_wrapper_class' => '',
				'el_id' => '',
				'offset' => '',
				'css' => '',
			),
			$atts
		)
	);

	switch( $width ) {
		case '1/12':
			$shortcode_column = '1-12';
			break;
		case '1/6':
			$shortcode_column = '1-6';
			break;
		case '1/4':
			$shortcode_column = '1-4';
			break;
		case '1/3':
			$shortcode_column = '1-3';
			break;
		case '5/12':
			$shortcode_column = '5-12';
			break;
		case '1/2':
			$shortcode_column = '1-2';
			break;
		case '7/12':
			$shortcode_column = '7-12';
			break;
		case '2/3':
		case '4/6':
			$shortcode_column = '2-3';
			break;
		case '3/4':
			$shortcode_column = '3-4';
			break;
		case '5/6':
			$shortcode_column = '5-6';
			break;
		case '11/12':
			$shortcode_column = '11-12';
			break;
		case '1/1':
		default :
			$shortcode_column = '1';
			break;
	}

	$column_classes = array( 'grve-column', 'wpb_column' );
	$column_classes[] = 'grve-column-' . $shortcode_column;

	if ( !empty ( $heading_color ) ) {
		$column_classes[] = 'grve-headings-' . $heading_color;
	}

	$css_custom = movedo_grve_vc_shortcode_custom_css_class( $css, '' );


	if( vc_settings()->get( 'not_responsive_css' ) != '1') {

		if ( !empty( $desktop_hide ) ) {
			$column_classes[] = 'grve-desktop-column-' . $desktop_hide;
		}
		if ( !empty( $tablet_width ) ) {
			$column_classes[] = 'grve-tablet-column-' . $tablet_width;
		}
		if ( !empty( $tablet_sm_width ) ) {
			$column_classes[] = 'grve-tablet-sm-column-' . $tablet_sm_width;
		} else {
			if ( !empty( $tablet_width ) ) {
				$column_classes[] = 'grve-tablet-sm-column-' . $tablet_width;
			}
		}
		if ( !empty( $mobile_width ) ) {
			$column_classes[] = 'grve-mobile-column-' . $mobile_width;
		}
	}

	if ( !empty ( $responsive_class ) ) {
		$column_classes[] = $responsive_class;
	}
	if ( $column_effect != 'none' ) {
		$column_classes[] = 'grve-parallax-effect';
	}

	$data_effect_string = '';

	switch( $column_effect ) {
		case 'vertical-parallax':
			$data_effect_string = ' data-parallax-effect="vertical-parallax" data-sensitive="' . esc_attr( $column_effect_sensitive ) . '" data-limit="' . esc_attr( $column_effect_limit ) . '" data-invert="' . esc_attr( $column_effect_invert ) . '"';
			if ( $tablet_landscape_column_effect == 'none' ) {
				$data_effect_string .= ' data-tablet-landscape-parallax-effect="none"';
			}
			if ( $tablet_portrait_column_effect == 'none' ) {
				$data_effect_string .= ' data-tablet-portrait-parallax-effect="none"';
			}
			if ( $mobile_column_effect == 'none' ) {
				$data_effect_string .= ' data-mobile-parallax-effect="none"';
			}
			break;
		case 'mouse-move-x-y':
			$data_effect_string = ' data-parallax-effect="mouse-move-x-y" data-sensitive="' . esc_attr( $column_effect_sensitive ) . '" data-limit="' . esc_attr( $column_effect_limit ) . '" data-invert="' . esc_attr( $column_effect_invert ) . '"';
			break;
		case 'mouse-move-x':
			$data_effect_string = ' data-parallax-effect="mouse-move-x" data-sensitive="' . esc_attr( $column_effect_sensitive ) . '" data-limit="' . esc_attr( $column_effect_limit ) . '" data-invert="' . esc_attr( $column_effect_invert ) . '"';
			break;
		case 'mouse-move-y':
			$data_effect_string = ' data-parallax-effect="mouse-move-y" data-sensitive="' . esc_attr( $column_effect_sensitive ) . '" data-limit="' . esc_attr( $column_effect_limit ) . '" data-invert="' . esc_attr( $column_effect_invert ) . '"';
			break;
		default:
			$data_effect_string = '';
			break;
	}


	if( $position_top != '' || $position_left != '' || $position_right != '' || $position_bottom != '' ) {
		$column_classes[] = 'grve-custom-position';
	}

	if( $tablet_landscape_column_positions == 'none' ) {
		$column_classes[] = 'grve-tablet-landscape-position-none';
	}

	if( $tablet_portrait_column_positions == 'none' ) {
		$column_classes[] = 'grve-tablet-portrait-position-none';
	}

	if( $mobile_column_positions == 'none' ) {
		$column_classes[] = 'grve-mobile-position-none';
	}

	if( $position_top != '' ) {
		$column_classes[] = 'grve-top-' . $position_top;
	}
	if( $position_left != '' ) {
		$column_classes[] = 'grve-left-' . $position_left;
	}
	if( $position_right != '' ) {
		$column_classes[] = 'grve-right-' . $position_right;
	}
	if( $position_bottom != '' ) {
		$column_classes[] = 'grve-bottom-' . $position_bottom;
	}

	if( !empty( $clipping_animation ) ) {
		$column_classes[] = 'grve-clipping-animation';
		$column_classes[] = 'grve-' . $clipping_animation;
	}
	if( 'colored-clipping-up' == $clipping_animation || 'colored-clipping-down' == $clipping_animation || 'colored-clipping-left' == $clipping_animation || 'colored-clipping-right' == $clipping_animation ) {
		$column_classes[] = 'grve-colored-clipping';
	}

	if ( !empty ( $el_class ) ) {
		$column_classes[] = $el_class;
	}

	$column_string = implode( ' ', $column_classes );

	$data_column_wrapper_string = '';
	$wrapper_attributes = array();
	$wrapper_attributes[] = 'class="' . esc_attr( $column_string ) . '"';

	$style = movedo_grve_build_shortcode_style(
		array(
			'font_color' => $font_color,
			'z_index' => $z_index,
		)
	);

	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}

	if( !empty( $style ) ) {
		$wrapper_attributes[] = $style;
	}

	if( !empty( $clipping_animation ) ) {
		$wrapper_attributes[] = ' data-delay="' . esc_attr( $animation_delay ) . '"';
	}

	if( 'colored-clipping-up' == $clipping_animation || 'colored-clipping-down' == $clipping_animation || 'colored-clipping-left' == $clipping_animation || 'colored-clipping-right' == $clipping_animation ) {
		$wrapper_attributes[] = ' data-clipping-color="' . esc_attr( $clipping_animation_colors ) . '"';
	}

	$column_wrapper_classes = array( 'grve-column-wrapper' );
	if ( !empty( $css_custom ) ) {
		$column_wrapper_classes[] = $css_custom;
	}
	if ( !empty ( $el_wrapper_class ) ) {
		$column_wrapper_classes[] = $el_wrapper_class;
	}

	if ( !empty( $shadow ) ) {
		$column_wrapper_classes[] = 'grve-shadow-' . $shadow;
		$column_wrapper_classes[] = 'grve-with-shadow';
	}

	if ( !empty ( $column_fullheight ) ) {
		$column_wrapper_classes[] = 'grve-with-fullheight';
		$column_wrapper_classes[] = 'grve-column-' . $column_fullheight;
	}

	if( $vertical_content_position != 'top' ) {
		$column_wrapper_classes[] = 'grve-flex grve-flex-position-' . $vertical_content_position;
	}

	if ( !empty ( $tablet_landscape_column_fullheight ) ) {
		$data_column_wrapper_string .= ' data-tablet-landscape-fullheight="' . esc_attr( $tablet_landscape_column_fullheight ) . '"';
	}

	if ( !empty ( $tablet_portrait_column_fullheight ) ) {
		$data_column_wrapper_string .= ' data-tablet-portrait-fullheight="' . esc_attr( $tablet_portrait_column_fullheight ) . '"';
	}

	if ( !empty ( $mobile_column_fullheight ) ) {
		$data_column_wrapper_string .= ' data-mobile-fullheight="' . esc_attr( $mobile_column_fullheight ) . '"';
	}

	$column_wrapper_string = implode( ' ', $column_wrapper_classes );

	//Section Output
	$output = '';
	$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' ' . $data_effect_string . '>';
	$output .= '<div class="' . esc_attr( $column_wrapper_string ) . '" ' . $data_column_wrapper_string . '>';
	if( $vertical_content_position != 'top' ) {
		$output .= '<div class="grve-column-content">';
	}
	$output .= do_shortcode( $content );
	if( $vertical_content_position != 'top' ) {
		$output	.= '</div>';
	}
	$output	.= '</div>';
	$output	.= '</div>';

	print $output;

//Omit closing PHP tag to avoid accidental whitespace output errors.
