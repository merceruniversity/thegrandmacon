<?php
/**
 * Social Links Shortcode
 */

if( !function_exists( 'movedo_ext_vce_social_links_shortcode' ) ) {

	function movedo_ext_vce_social_links_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'animation' => '',
					'align' => 'left',
					'icon_size' => 'medium',
					'icon_shape' => 'no-shape',
					'shape_type' => 'simple',
					'icon_color' => 'primary-1',
					'shape_color' => 'primary-1',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);


		$social_classes = array( 'grve-element', 'grve-social', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $social_classes, 'grve-animated-item' );
			array_push( $social_classes, $animation);
			array_push( $social_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $social_classes, $el_class);
		}
		$social_class_string = implode( ' ', $social_classes );

		$social_shape_classes = array();

		array_push( $social_shape_classes, 'grve-' . $icon_size );
		array_push( $social_shape_classes, 'grve-' . $icon_shape );

		if ( 'no-shape' != $icon_shape ) {
			array_push( $social_shape_classes, 'grve-with-shape' );
			array_push( $social_shape_classes, 'grve-' . $shape_type );
			if ( 'outline' != $shape_type ) {
				array_push( $social_shape_classes, 'grve-bg-' . $shape_color );
			} else {
				array_push( $social_shape_classes, 'grve-text-' . $shape_color );
				array_push( $social_shape_classes, 'grve-text-hover-' . $shape_color );
			}
		}

		$social_shape_class_string = implode( ' ', $social_shape_classes );


		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );
		global $movedo_grve_social_list_extended;
		ob_start();

		if ( isset( $movedo_grve_social_list_extended ) ) {

		?>
			<div class="<?php echo esc_attr( $social_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>
				<ul>
				<?php
				foreach ( $movedo_grve_social_list_extended as $social_item ) {

					$social_item_url = movedo_ext_vce_array_value( $atts, $social_item['url'] );

					if ( ! empty( $social_item_url ) ) {

						if ( 'skype' == $social_item['id'] ) {
				?>
							<li>
								<a href="<?php echo esc_url( $social_item_url, array( 'skype', 'http', 'https' ) ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?>">
									<i class="grve-text-<?php echo esc_attr( $icon_color ); ?> <?php echo esc_attr( $social_item['class'] ); ?>"></i>
								</a>
							</li>
				<?php
						} else {
				?>
							<li>
								<a href="<?php echo esc_url( $social_item_url ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?>" target="_blank">
									<i class="grve-text-<?php echo esc_attr( $icon_color ); ?> <?php echo esc_attr( $social_item['class'] ); ?>"></i>
								</a>
							</li>
				<?php
						}
					}
				}
				?>
				</ul>
			</div>
		<?php
		}

		return ob_get_clean();

	}
	add_shortcode( 'movedo_social_links', 'movedo_ext_vce_social_links_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_social_links_shortcode_params' ) ) {
	function movedo_ext_vce_social_links_shortcode_params( $tag ) {

		$movedo_ext_vce_social_links_shortcode_params = array_merge(
			array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon size", "movedo-extension" ),
					"param_name" => "icon_size",
					"value" => array(
						esc_html__( "Large", "movedo-extension" ) => 'large',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Small", "movedo-extension" ) => 'small',
						esc_html__( "Extra Small", "movedo-extension" ) => 'extra-small',
					),
					"std" => 'medium',
					"description" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Color", "movedo-extension" ),
					"param_name" => "icon_color",
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
					"description" => esc_html__( "Color of the social icon.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon shape", "movedo-extension" ),
					"param_name" => "icon_shape",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'no-shape',
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'round',
						esc_html__( "Circle", "movedo-extension" ) => 'circle',
					),
					"description" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shape Color", "movedo-extension" ),
					"param_name" => "shape_color",
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
					"description" => esc_html__( "Color of the shape.", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shape type", "movedo-extension" ),
					"param_name" => "shape_type",
					"value" => array(
						esc_html__( "Simple", "movedo-extension" ) => 'simple',
						esc_html__( "Outline", "movedo-extension" ) => 'outline',
					),
					"description" => esc_html__( "Select shape type.", "movedo-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				movedo_ext_vce_add_align(),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
			),
			movedo_ext_vce_get_social_links_params()
		);

		return array(
			"name" => esc_html__( "Social Links", "movedo-extension" ),
			"description" => esc_html__( "Add social networking links.", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-social",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $movedo_ext_vce_social_links_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_social_links', 'movedo_ext_vce_social_links_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_social_links_shortcode_params( 'movedo_social_links' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
