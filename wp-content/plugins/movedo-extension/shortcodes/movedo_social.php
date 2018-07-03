<?php
/**
 * Social Share Shortcode
 */

if( !function_exists( 'movedo_ext_vce_social_shortcode' ) ) {

	function movedo_ext_vce_social_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'social_email' => '',
					'social_facebook' => '',
					'social_twitter' => '',
					'social_linkedin' => '',
					'social_googleplus' => '',
					'social_reddit' => '',
					'social_pinterest' => '',
					'social_tumblr' => '',
					'likes' => '',
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

		$movedo_ext_permalink = get_permalink();
		$movedo_ext_title = get_the_title();
		$page_email_string = 'mailto:?subject=' . $movedo_ext_title . '&body=' . $movedo_ext_title . ': ' . $movedo_ext_permalink;

		$image_size = 'large';
		if ( has_post_thumbnail() ) {
			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			$attachment_src = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
			$movedo_ext_image_url = $attachment_src[0];
		} else {
			$movedo_ext_image_url = get_template_directory_uri() . '/images/empty/' . $image_size . '.jpg';
		}

		ob_start();

		?>
			<div class="<?php echo esc_attr( $social_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>
				<ul>
					<?php if ( !empty( $social_email  ) ) { ?>
					<li><a href="<?php echo esc_url( $page_email_string ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-email"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-envelope"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_facebook ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-facebook"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-facebook"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_twitter ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-twitter"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-twitter"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_linkedin ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-linkedin"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-linkedin"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_googleplus ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-googleplus"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-google-plus"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_reddit ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-reddit"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-reddit"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_pinterest  ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-pinterest" data-pin-img="<?php echo esc_url( $movedo_ext_image_url ); ?>" ><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-pinterest"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_tumblr  ) ) { ?>
					<li><a href="<?php echo esc_url( $movedo_ext_permalink ); ?>" title="<?php echo esc_attr( $movedo_ext_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-tumblr"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-tumblr"></i></a></li>
					<?php } ?>

					<?php if ( !empty( $likes ) && function_exists( 'movedo_grve_likes' ) ) {
						global $post;
						$post_id = $post->ID;
					?>
					<li><a href="#" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-like-counter-link" data-post-id="<?php echo esc_attr( $post_id ); ?>"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-heart"></i><span class="grve-like-counter"><?php echo movedo_grve_likes( $post_id, 'number' ); ?></span></a></li>
					<?php } ?>

				</ul>
			</div>
		<?php

		return ob_get_clean();

	}
	add_shortcode( 'movedo_social', 'movedo_ext_vce_social_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_social_shortcode_params' ) ) {
	function movedo_ext_vce_social_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Social Share", "movedo-extension" ),
			"description" => esc_html__( "Place your preferred social", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-social",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "E-mail", "movedo-extension" ),
					"param_name" => "social_email",
					"description" => esc_html__( "Share with E-mail", "movedo-extension" ),
					"value" => array( esc_html__( "Show E-mail social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Facebook", "movedo-extension" ),
					"param_name" => "social_facebook",
					"description" => esc_html__( "Share in Facebook", "movedo-extension" ),
					"value" => array( esc_html__( "Show Facebook social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Twitter", "movedo-extension" ),
					"param_name" => "social_twitter",
					"description" => esc_html__( "Share in Twitter", "movedo-extension" ),
					"value" => array( esc_html__( "Show Twitter social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Linkedin", "movedo-extension" ),
					"param_name" => "social_linkedin",
					"description" => esc_html__( "Share in Linkedin", "movedo-extension" ),
					"value" => array( esc_html__( "Show Linkedin social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Google +", "movedo-extension" ),
					"param_name" => "social_googleplus",
					"description" => esc_html__( "Share in Google +", "movedo-extension" ),
					"value" => array( esc_html__( "Show Google + social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "reddit", "movedo-extension" ),
					"param_name" => "social_reddit",
					"description" => esc_html__( "Submit in reddit", "movedo-extension" ),
					"value" => array( esc_html__( "Show reddit social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pinterest", "movedo-extension" ),
					"param_name" => "social_pinterest",
					"description" => esc_html__( "Submit in Pinterest (Featured Image is used as image)", "movedo-extension" ),
					"value" => array( esc_html__( "Show Pinterest social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Tumblr", "movedo-extension" ),
					"param_name" => "social_tumblr",
					"description" => esc_html__( "Submit in Tumblr", "movedo-extension" ),
					"value" => array( esc_html__( "Show Tumblr social share", "movedo-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "(Greatives) Likes", "movedo-extension" ),
					"param_name" => "likes",
					"description" => esc_html__( "(Greatives) Likes", "movedo-extension" ),
					"value" => array( esc_html__( "Show (Greatives) Likes", "movedo-extension" ) => 'yes' ),
				),
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
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_social', 'movedo_ext_vce_social_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_social_shortcode_params( 'movedo_social' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
