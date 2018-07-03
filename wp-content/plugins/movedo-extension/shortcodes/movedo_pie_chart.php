<?php
/**
 * Pie Chart Shortcode
 */

if( !function_exists( 'movedo_ext_vce_pie_chart_shortcode' ) ) {

	function movedo_ext_vce_pie_chart_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'pie_chart_val' => '50',
					'pie_chart_prefix' => '',
					'pie_chart_suffix' => '',
					'pie_chart_line_size' => '6',
					'pie_chart_val_color' => '',
					'pie_chart_color' => '',
					'pie_active_color' => '',
					'pie_chart_size' => 'medium',
					'pie_line_style' => 'square',
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'pie_chart_text' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);


		$pie_chart_classes = array( 'grve-element' );
		array_push( $pie_chart_classes, 'grve-pie-chart' );
		if ( !empty( $animation ) ) {
			array_push( $pie_chart_classes, 'grve-animated-item' );
			array_push( $pie_chart_classes, $animation);
			array_push( $pie_chart_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty ( $el_class ) ) {
			array_push( $pie_chart_classes, $el_class);
		}
		array_push( $pie_chart_classes, 'grve-' . $pie_chart_size );
		$pie_chart_class_string = implode( ' ', $pie_chart_classes );

		$title_classes = array( 'grve-chart-title' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		$title_class_string = implode( ' ', $title_classes );


		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );


		$output .= '<div class="' . esc_attr( $pie_chart_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= '  <div class="grve-chart-number" data-percent="' . esc_attr( $pie_chart_val ) . '" data-pie-active-color="' . esc_attr( $pie_active_color ) . '" data-pie-color="' . esc_attr( $pie_chart_color ) . '" data-pie-line-cap="' . esc_attr( $pie_line_style ) . '" data-pie-size="' . esc_attr( $pie_chart_size ) . '" data-pie-line-size="' . esc_attr( $pie_chart_line_size ) . '">';
		$output .= '    <span class="grve-counter" style="color:' . esc_attr( $pie_chart_val_color ) . '">' . $pie_chart_prefix . $pie_chart_val . $pie_chart_suffix . '</span>';
		$output .= '  </div>';
			if ( !empty( $title ) ) {
				$output .= '	  <' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
			}
			if ( !empty( $pie_chart_text ) ) {
				$output .= '      <p>' . $pie_chart_text. '</p>';
			}
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'movedo_pie_chart', 'movedo_ext_vce_pie_chart_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_pie_chart_shortcode_params' ) ) {
	function movedo_ext_vce_pie_chart_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Pie Chart", "movedo-extension" ),
			"description" => esc_html__( "Add a counter with icon and title", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-pie-chart",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Pie Chart Value", "movedo-extension" ),
					"param_name" => "pie_chart_val",
					"value" => "50",
					"description" => esc_html__( "Enter the pie chart value number.", "movedo-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Value Prefix", "movedo-extension" ),
					"param_name" => "pie_chart_prefix",
					"value" => "",
					"description" => esc_html__( "Enter value prefix.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Value Suffix", "movedo-extension" ),
					"param_name" => "pie_chart_suffix",
					"value" => "",
					"description" => esc_html__( "Enter value suffix.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pie Chart Size", "movedo-extension" ),
					"param_name" => "pie_chart_size",
					"value" => array(
						esc_html__( "Small", "movedo-extension" ) => 'small',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Large", "movedo-extension" ) => 'large',
					),
					"description" => esc_html__( "Select pie chart size.", "movedo-extension" ),
					"std" => 'medium',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Pie Chart Line Size", "movedo-extension" ),
					"param_name" => "pie_chart_line_size",
					"value" => "6",
					"description" => esc_html__( "Enter pie chart line size.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pie Chart Style", "movedo-extension" ),
					"param_name" => "pie_line_style",
					"value" => array(
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'round',
					),
					"description" => esc_html__( "Set the pie chart shape style", "movedo-extension" ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( "Pie Chart Value Color", "movedo-extension" ),
					'param_name' => 'pie_chart_val_color',
					'description' => esc_html__( "Select the value color for your pie", "movedo-extension" ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( "Pie Chart Active Color", "movedo-extension" ),
					'param_name' => 'pie_active_color',
					'description' => esc_html__( "Select the active color for your pie", "movedo-extension" ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( "Pie Chart Base Color", "movedo-extension" ),
					'param_name' => 'pie_chart_color',
					'description' => esc_html__( "Select the base color for your pie", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__( "Enter pie chart title", "movedo-extension" ),
					"admin_label" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "pie_chart_text",
					"value" => "",
					"description" => esc_html__( "Type your text", "movedo-extension" ),
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
	vc_lean_map( 'movedo_pie_chart', 'movedo_ext_vce_pie_chart_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_pie_chart_shortcode_params( 'movedo_pie_chart' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
