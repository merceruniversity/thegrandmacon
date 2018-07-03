<?php
/**
 * Instagram Shortcode
 */

if( !function_exists( 'movedo_ext_vce_instagram_shortcode' ) ) {

	function movedo_ext_vce_instagram_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'access_token' => '',
					'user_id' => '',
					'username' => '',
					'limit' => '9',
					'image_size' => 'large',
					'columns_large_screen' => '3',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'order_by' => 'none',
					'order' => 'ASC',
					'target' => '_blank',
					'cache' => 'yes',
					'align' => 'left',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);


		$instagram_classes = array( 'grve-element', 'grve-widget', 'grve-instagram-feed', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $instagram_classes, 'grve-animated-item' );
			array_push( $instagram_classes, $animation);
			array_push( $instagram_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $instagram_classes, $el_class);
		}
		$instagram_class_string = implode( ' ', $instagram_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );


		switch( $image_size ) {
			case 'medium':
				$image_width = "320";
				$image_height = "320";
				break;
			case 'large':
				$image_width = "640";
				$image_height = "640";
				break;
			case 'thumbnail':
			default:
				$image_width = "150";
				$image_height = "150";
				break;
		}

		$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
		if ( 'yes' == $item_gutter ) {
			$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
		}

		$instagram_classes = array( 'grve-element', 'grve-gallery' , 'grve-isotope' );
		if ( 'yes' == $item_gutter ) {
			array_push( $instagram_classes, 'grve-with-gap' );
		}
		$instagram_class_string = implode( ' ', $instagram_classes );


		ob_start();

		?>

			<?php
			if ( !empty( $username ) ) {
				$media_array = array();
				if( function_exists( 'movedo_grve_get_instagram_array' ) ) {
					$cache_val = 0;
					if( 'yes' == $cache ) {
						$cache_val = 1;
					}
					$media_array = movedo_grve_get_instagram_array( $username, $limit, $order_by, $order, $cache_val, $access_token, $user_id );
				}
				$output = '';

				if ( is_wp_error( $media_array ) ) {

				   echo wp_kses_post( $media_array->get_error_message() );

				} else {

				?>
				<div class="<?php echo esc_attr( $instagram_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>
					<div class="grve-isotope-container">
				<?php
					if ( !empty( $media_array ) ) {
						foreach ( $media_array as $item ) {
							$image_url = $item[ $image_size ]['url'];
							if ( !isset( $image_url ) ) {
								$image_url = $item[ 'thumbnail' ]['url'];
							}

				?>
						<div class="grve-isotope-item grve-hover-item grve-hover-style-none">
							<div class="grve-isotope-item-inner <?php echo esc_attr( $animation ); ?>">
								<figure class="grve-image-hover grve-zoom-none">
									<a class="grve-item-url" href="<?php echo esc_url( $item['link'] ); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
									<div class="grve-media">
										<img width="<?php echo esc_attr( $image_width ); ?>" height="<?php echo esc_attr( $image_height ); ?>" src="<?php echo esc_url( $image_url ); ?>"  alt="<?php echo esc_attr( $item['description'] ); ?>" title="<?php echo esc_attr( $item['description'] ); ?>"/>
									</div>
								</figure>
							</div>
						</div>
				<?php
						}
					}
				?>
					</div>
				</div>
				<?php
				}
			}

		return ob_get_clean();

	}
	add_shortcode( 'movedo_instagram', 'movedo_ext_vce_instagram_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_instagram_shortcode_params' ) ) {
	function movedo_ext_vce_instagram_shortcode_params( $tag ) {

		$access_token_url = "https://greatives.eu/instagram-feed/";

		return array(
			"name" => esc_html__( "Instagram Feed", "movedo-extension" ),
			"description" => esc_html__( "Display images from your instagram account", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-instagram",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Access Token", "movedo-extension" ),
					"param_name" => "access_token",
					"value" => "",
					"description" => esc_html__( "Enter your instagram Access Token.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "User ID", "movedo-extension" ),
					"param_name" => "user_id",
					"value" => "",
					"description" => esc_html__( "Enter your instagram User ID.", "movedo-extension" ). '<br><a href="' . esc_url( $access_token_url ) .'" target="_blank">' . esc_html__( 'Get Access Token and User ID', 'movedo-extension' ) . '</a>',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Username", "movedo-extension" ),
					"param_name" => "username",
					"value" => "",
					"description" => esc_html__( "Enter your instagram username.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "image_size",
					"value" => array(
						esc_html__( "Thumbnail ( 150x150 )", "movedo-extension" ) => 'thumbnail',
						esc_html__( "Medium ( 320x320 )", "movedo-extension" ) => 'medium',
						esc_html__( "Large ( 640x640 )", "movedo-extension" ) => 'large',
					),
					"std" => 'large',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Large Screen Columns", "movedo-extension" ),
					"param_name" => "columns_large_screen",
					"value" => array( '2', '3', '4', '5', '6', '7', '8', '9', '10' ),
					"std" => 3,
					"description" => esc_html__( "Select number of columns for large screens.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "movedo-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5', '6', '7', '8', '9', '10' ),
					"std" => 3,
					"description" => esc_html__( "Select number of columns.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4', '5', '6', '7', '8', '9', '10' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4', '5', '6', '7', '8', '9', '10' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "movedo-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "movedo-extension" ),
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

				array(
					"type" => "textfield",
					"heading" => esc_html__( "Number of Images", "movedo-extension" ),
					"param_name" => "limit",
					"value" => "9",
					"description" => esc_html__( "Enter number of images.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Order By", "movedo-extension" ),
					"param_name" => "order_by",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "Recent", "movedo-extension" ) => 'datetime',
						esc_html__( "Likes", "movedo-extension" ) => 'likes',
						esc_html__( "Comments", "movedo-extension" ) => 'comments',
					),
					"std" => 'none',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Order", "movedo-extension" ),
					"param_name" => "order",
					"value" => array(
						esc_html__( "Ascending", "movedo-extension" ) => 'ASC',
						esc_html__( "Descending", "movedo-extension" ) => 'DESC',
					),
					"std" => 'ASC',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Link Target", "movedo-extension" ),
					"param_name" => "target",
					"value" => array(
						esc_html__( "New Page", "movedo-extension" ) => '_blank',
						esc_html__( "Same Page", "movedo-extension" ) => '_self',
					),
					"std" => '_blank',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Caching", "movedo-extension" ),
					"param_name" => "cache",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"description" => esc_html__( "Note: Select caching if you want to test your configuration. It is recommended to leave caching enabled to increase performance. Caching timeout is 60 minutes.", "movedo-extension" ),
					"std" => 'yes',
				),
				movedo_ext_vce_add_align(),
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
	vc_lean_map( 'movedo_instagram', 'movedo_ext_vce_instagram_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_instagram_shortcode_params( 'movedo_instagram' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
