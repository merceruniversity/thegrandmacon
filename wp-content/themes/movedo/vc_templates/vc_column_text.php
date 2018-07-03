<?php

	extract(
		shortcode_atts(
			array(
				'text_style' => '',
				'animation' => '',
				'animation_delay' => '200',
				'animation_duration' => 'normal',
				'el_class' => '',
				'el_id' => '',
				'css' => '',
			),
			$atts
		)
	);

	$text_classes = array( 'grve-element', 'grve-text' );
	$css_custom = movedo_grve_vc_shortcode_custom_css_class( $css, '' );

	if ( !empty( $text_style ) ) {
		$text_classes[] = 'grve-' . $text_style;
	}
	if ( !empty( $el_class ) ) {
		$text_classes[] = $el_class;
	}
	if ( !empty( $css_custom ) ) {
		$text_classes[] = $css_custom;
	}
	if ( !empty( $animation ) ) {
		$text_classes[] = 'grve-animated-item';
		$text_classes[] = $animation;
		$text_classes[] = 'grve-duration-' . $animation_duration;
	}
	$text_class_string = implode( ' ', $text_classes );

	$wrapper_attributes = array();
	$wrapper_attributes[] = 'class="' . esc_attr( $text_class_string ) . '"';
	if ( !empty( $animation ) ) {
		$wrapper_attributes[] = 'data-delay="' . esc_attr( $animation_delay ) . '"';
	}

	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}

	$content = wpautop(preg_replace('/<\/?p\>/', "\n", $content)."\n");

	echo '<div ' . implode( ' ', $wrapper_attributes ) . '>
			' . do_shortcode( shortcode_unautop( $content ) ) . '
		</div>
	';

//Omit closing PHP tag to avoid accidental whitespace output errors.
