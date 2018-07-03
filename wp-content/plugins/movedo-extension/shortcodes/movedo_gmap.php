<?php
/**
 * Google Map Shortcode
 */

if( !function_exists( 'movedo_ext_vce_gmap_shortcode' ) ) {

	function movedo_ext_vce_gmap_shortcode( $atts, $content ) {
		$output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'map_lat' => '51.516221',
					'map_lng' => '-0.136986',
					'map_height' => '280',
					'map_marker' => '',
					'map_marker_type' => '',
					'map_marker_bg_color' => 'primary-1',
					'map_zoom' => 14,
					'map_disable_style' => 'no',
					'margin_bottom' => '',
					'el_class' => '',
					'map_mode' => '',
					'map_points' => '',
				),
				$atts
			)
		);

		wp_enqueue_script( 'movedo-grve-maps-script');

		$gmap_classes = array( 'grve-element', 'grve-map' );

		if ( !empty ( $el_class ) ) {
			array_push( $gmap_classes, $el_class );
		}
		$gmap_class_string = implode( ' ', $gmap_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		if ( empty( $map_marker_type ) ) {
			if ( empty( $map_marker ) ) {
				$map_marker = get_template_directory_uri() . '/images/markers/markers.png';
			} else {
				$id = preg_replace('/[^\d]/', '', $map_marker);
				$full_src = wp_get_attachment_image_src( $id, 'full' );
				$map_marker = $full_src[0];
			}
			$point_type = $map_marker_type = 'image';
			$point_bg_color = '';
		} else {
			$map_marker = get_template_directory_uri() . '/images/markers/transparent.png';
			$point_type = $map_marker_type;
			$point_bg_color = $map_marker_bg_color;
		}
		$map_marker = str_replace( array( 'http:', 'https:' ), '', $map_marker );

		$map_title = '';
		$values = (array) vc_param_group_parse_atts( $map_points );

		if ( !empty( $map_mode ) && !empty( $values )  ) {
			$map_lat = movedo_ext_vce_array_value( $values[0], 'lat', '51.516221' );
			$map_lng = movedo_ext_vce_array_value( $values[0], 'lng', '-0.136986' );
		}

		$data_map = 'data-lat="' . esc_attr( $map_lat ) . '" data-lng="' . esc_attr( $map_lng ) . '" data-zoom="' . esc_attr( $map_zoom ) . '" data-disable-style="' . esc_attr( $map_disable_style ) . '"';
		$output .= '<div class="grve-map-wrapper">';
		$output .= '  <div class="' . esc_attr( $gmap_class_string ) . '" ' . $data_map . ' style="' . $style . movedo_ext_vce_build_dimension( 'height', $map_height ) . '"></div>';

		if ( empty( $map_mode ) ) {

			$map_point_attributes = array();
			$map_point_attributes[] = 'data-point-lat="' . esc_attr( $map_lat ) . '"';
			$map_point_attributes[] = 'data-point-lng="' . esc_attr( $map_lng ) . '"';
			$map_point_attributes[] = 'data-point-title="' . esc_attr( $map_title ) . '"';
			$map_point_attributes[] = 'data-point-type="' . esc_attr( $point_type ) . '"';
			if( 'image' != $point_type ) {
				$map_point_attributes[] = 'data-point-bg-color="' . esc_attr( $point_bg_color ) . '"';
			}
			$output .= '  <div style="display:none" class="grve-map-point" data-point-marker="' . esc_attr( $map_marker ) . '" ' . implode( ' ', $map_point_attributes ) . '></div>';
		} else {
			if( !empty( $values ) ) {
				foreach ( $values as $k => $v ) {

					$point_lat = isset( $v['lat'] ) ? $v['lat'] : '51.516221';
					$point_lng = isset( $v['lng'] ) ? $v['lng'] : '-0.136986';
					$point_marker = isset( $v['marker'] ) ? $v['marker'] : '';
					$point_title = isset( $v['title'] ) ? $v['title'] : '';
					$point_infotext = isset( $v['infotext'] ) ? $v['infotext'] : '';
					$point_infotext_open = isset( $v['infotext_open'] ) ? $v['infotext_open'] : 'no';
					$point_link_text = isset( $v['link_text'] ) ? $v['link_text'] : '';
					$point_link = isset( $v['link'] ) ? $v['link'] : '';
					$point_link_class = isset( $v['link_class'] ) ? 'grve-infotext-link ' . $v['link_class'] : 'grve-infotext-link';

					if ( empty( $point_marker ) ) {
						$point_marker = $map_marker;
						$point_type = $map_marker_type;
						$point_bg_color = $map_marker_bg_color;
					} else {
						$id = preg_replace('/[^\d]/', '', $point_marker);
						$full_src = wp_get_attachment_image_src( $id, 'full' );
						$point_marker = $full_src[0];
						$point_marker = str_replace( array( 'http:', 'https:' ), '', $point_marker );
						$point_type = 'image';
						$point_bg_color = '';
					}

					$map_point_attributes = array();
					$map_point_attributes[] = 'data-point-lat="' . esc_attr( $point_lat ) . '"';
					$map_point_attributes[] = 'data-point-lng="' . esc_attr( $point_lng ) . '"';
					$map_point_attributes[] = 'data-point-title="' . esc_attr( $point_title ) . '"';
					$map_point_attributes[] = 'data-point-type="' . esc_attr( $point_type ) . '"';
					if( 'image' != $point_type ) {
						$map_point_attributes[] = 'data-point-bg-color="' . esc_attr( $point_bg_color ) . '"';
					}

					$output .= '<div style="display:none" class="grve-map-point" data-point-marker="' . esc_attr( $point_marker ) . '" ' . implode( ' ', $map_point_attributes ) . '>';
					if ( !empty( $point_title ) || !empty( $point_infotext ) || !empty( $point_link_text ) ) {
						$output .= '<div class="grve-map-infotext">';
						if ( !empty( $point_title ) ) {
							$output .= '<h6 class="grve-infotext-title">' . esc_html( $point_title ) . '</h6>';
						}
						if ( !empty( $point_infotext ) ) {
							$output .= '<p class="grve-infotext-description">' . wp_kses_post( $point_infotext ) . '</p>';
						}
						if ( !empty( $point_link_text ) && movedo_ext_vce_has_link ( $point_link ) ) {
							$link_attributes = movedo_ext_vce_get_link_attributes( $point_link, $point_link_class );
							$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
							$output .= esc_html( $point_link_text );
							$output .= '</a>';
						}
						$output .= '</div>';
					}
					$output .= '</div>';
				}
			}
		}
		$output .= '</div>';


		return $output;
	}
	add_shortcode( 'movedo_gmap', 'movedo_ext_vce_gmap_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_gmap_shortcode_params' ) ) {
	function movedo_ext_vce_gmap_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Google Map", "movedo-extension" ),
			"description" => esc_html__( "Freely place your Google Map", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-gmap",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Map Zoom", "movedo-extension" ),
					"param_name" => "map_zoom",
					"value" => array( 1, 2, 3 ,4, 5, 6, 7, 8 ,9 ,10 ,11 ,12, 13, 14, 15, 16, 17, 18, 19 ),
					"std" => 14,
					"description" => esc_html__( "Zoom of the map.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Height", "movedo-extension" ),
					"param_name" => "map_height",
					"value" => "280",
					"description" => esc_html__( "Type map height.", "movedo-extension" ),
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
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Map Mode", "movedo-extension" ),
					"param_name" => "map_mode",
					"value" => array(
						esc_html__( "Single Marker", "movedo-extension" ) => '',
						esc_html__( "Multiple Markers", "movedo-extension" ) => 'multiple',
					),
					"description" => esc_html__( "Select if you want to disable custom map style.", "movedo-extension" ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Global Marker Type", "movedo-extension" ),
					"param_name" => "map_marker_type",
					"value" => array(
						esc_html__( "Image", "movedo-extension" ) => '',
						esc_html__( "Pulse Dot Icon", "movedo-extension" ) => 'pulse-dot',
						esc_html__( "Dot Icon", "movedo-extension" ) => 'dot',
					),
					"description" => esc_html__( "Select the type of your marker.", "movedo-extension" ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Global Custom marker", "movedo-extension" ),
					"param_name" => "map_marker",
					"value" => '',
					"description" => esc_html__( "Select an icon for the custom marker.", "movedo-extension" ),
					"dependency" => array( 'element' => "map_marker_type", 'value' => array( '' ) ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background Color", "movedo-extension" ),
					"param_name" => "map_marker_bg_color",
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
					"description" => esc_html__( "Background color of the marker.", "movedo-extension" ),
					'std' => 'primary-1',
					"dependency" => array( 'element' => "map_marker_type", 'value_not_equal_to' => array( '' ) ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Latitude", "movedo-extension" ),
					"param_name" => "map_lat",
					"value" => "51.516221",
					"description" => esc_html__( "Type map Latitude.", "movedo-extension" ),
					"dependency" => array( 'element' => "map_mode", 'value' => array( '' ) ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Longtitude", "movedo-extension" ),
					"param_name" => "map_lng",
					"value" => "-0.136986",
					"description" => esc_html__( "Type map Longtitude.", "movedo-extension" ),
					"dependency" => array( 'element' => "map_mode", 'value' => array( '' ) ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
				array(
					'type' => 'param_group',
					'param_name' => 'map_points',
					'heading' => esc_html__( "Map Points", "movedo-extension" ),
					"description" => esc_html__( "Configure your map points.", "movedo-extension" ),
					'value' => urlencode( json_encode( array(
						array(
							'title' => 'Point 1',
							'lat' => '51.516221',
							'lng' => '-0.136986',
						),
					) ) ),
					'params' => array(
						array(
							"type" => "textfield",
							"heading" => esc_html__( "Title", "movedo-extension" ),
							"param_name" => "title",
							"value" => "",
							"description" => esc_html__( "Enter your point title.", "movedo-extension" ),
							"admin_label" => true,
						),
						array(
							"type" => "attach_image",
							"heading" => esc_html__( "Marker", "movedo-extension" ),
							"param_name" => "marker",
							"value" => '',
							"description" => esc_html__( "Select an icon for your point marker. Note: if empty global marker will be used instead.", "movedo-extension" ),
						),
						array(
							'type' => 'textfield',
							'value' => '51.516221',
							'heading' => 'Latitude',
							'param_name' => 'lat',
						),
						array(
							'type' => 'textfield',
							'value' => '-0.136986',
							'heading' => 'Longitude',
							'param_name' => 'lng',
						),
						array(
							"type" => "textarea",
							"heading" => esc_html__( "Info Text", "movedo-extension" ),
							"param_name" => "infotext",
							"value" => "",
							"description" => esc_html__( "Enter your info text.", "movedo-extension" ),
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__( "Open Info Text Onload", "movedo-extension" ),
							"param_name" => "infotext_open",
							"value" => array(
								esc_html__( "No", "movedo-extension" ) => 'no',
								esc_html__( "Yes", "movedo-extension" ) => 'yes',
							),
							"description" => esc_html__( "Select if you want to open info text on load.", "movedo-extension" ),
						),
						array(
							"type" => "textfield",
							"heading" => esc_html__( "Link Text", "movedo-extension" ),
							"param_name" => "link_text",
							"value" => "",
							"description" => esc_html__( "Enter your link text.", "movedo-extension" ),
						),
						array(
							"type" => "vc_link",
							"heading" => esc_html__( "Link", "movedo-extension" ),
							"param_name" => "link",
							"value" => "",
							"description" => esc_html__( "Enter your link.", "movedo-extension" ),
						),
						array(
							"type" => "textfield",
							"heading" => esc_html__( "Link Class", "movedo-extension" ),
							"param_name" => "link_class",
							"value" => "",
							"description" => esc_html__( "Enter your link class.", "movedo-extension" ),
						),
					),
					"dependency" => array( 'element' => "map_mode", 'value' => array( 'multiple' ) ),
					"group" => esc_html__( "Map Points", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_gmap', 'movedo_ext_vce_gmap_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_gmap_shortcode_params( 'movedo_gmap' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
