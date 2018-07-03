<?php
/**
 * Team Shortcode
 */

if( !function_exists( 'movedo_ext_vce_team_shortcode' ) ) {

	function movedo_ext_vce_team_shortcode( $attr, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'image' => '',
					'retina_image' => '',
					'image_size' => '',
					'team_layout' => 'layout-1',
					'zoom_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'name' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'identity' => '',
					'content_bg' => 'white',
					'social_facebook' => '',
					'social_twitter' => '',
					'social_linkedin' => '',
					'social_instagram' => '',
					'social_youtube' => '',
					'social_vimeo' => '',
					'email' => '',
					'align' => 'left',
					'link' => '',
					'link_class' => '',
					'animation' => '',
					'animation_delay' => '200',
					'animation_duration' => 'normal',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$attr
			)
		);

		$heading_class = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$heading_class .= ' grve-' . $custom_font_family;
		}

		$image_mode_size = movedo_ext_vce_get_image_size( $image_size );

		//Team Title & Caption Color
		$text_color = 'light';
		if( 'light' == $overlay_color ) {
			$text_color = 'dark';
		}

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		if ( !empty( $image ) ) {
			$id = preg_replace('/[^\d]/', '', $image);
			$thumb_src = wp_get_attachment_image_src( $id, $image_mode_size );
			$thumb_url = $thumb_src[0];
			$image_srcset = '';

			if ( !empty( $retina_image ) && empty( $image_size ) ) {
				$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
				$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
				$retina_url = $img_retina_src[0];
				$image_srcset = $thumb_url . ' 1x,' . $retina_url . ' 2x';
				$image_html = wp_get_attachment_image( $id, $image_mode_size , "", array( 'srcset'=> $image_srcset ) );
			} else {
				$image_html = wp_get_attachment_image( $id, $image_mode_size );
			}
		} else {
			$image_html = movedo_ext_vce_get_fallback_image( $image_mode_size );
		}

		$email_string =  apply_filters( 'movedo_grve_vce_string_email', esc_html__( 'E-mail', 'movedo-extension' ) );

		// Link Classes
		$link_classes = array( 'grve-text-hover-primary-1' );

		if ( 'layout-1' == $team_layout ){
			array_push( $link_classes, 'grve-box-item', 'grve-bg-white', 'grve-circle');
		}

		$link_class_string = implode( ' ', $link_classes );


		$links = '';
		if ( !empty( $social_facebook ) ) {
			$links .= '<li><a href="' . esc_url( $social_facebook ) . '" target="_blank" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-facebook"></i></a></li>';
		}
		if ( !empty( $social_twitter ) ) {
			$links .= '<li><a href="' . esc_url( $social_twitter ) . '" target="_blank" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-twitter"></i></a></li>';
		}
		if ( !empty( $social_linkedin ) ) {
			$links .= '<li><a href="' . esc_url( $social_linkedin ) . '" target="_blank" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-linkedin"></i></a></li>';
		}
		if ( !empty( $social_instagram ) ) {
			$links .= '<li><a href="' . esc_url( $social_instagram ) . '" target="_blank" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-instagram"></i></a></li>';
		}
		if ( !empty( $social_youtube ) ) {
			$links .= '<li><a href="' . esc_url( $social_youtube ) . '" target="_blank" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-youtube"></i></a></li>';
		}
		if ( !empty( $social_vimeo ) ) {
			$links .= '<li><a href="' . esc_url( $social_vimeo ) . '" target="_blank" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-vimeo"></i></a></li>';
		}
		if ( !empty( $email ) ) {
			$links .= '<li><a href="mailto:' . antispambot( $email ) . '" class="' . esc_attr( $link_class_string ) . '"><i class="fa fa-envelope"></i></a></li>';
		}

		$team_classes = array( 'grve-element' );

		array_push( $team_classes, 'grve-' . $team_layout);

		if ( !empty( $animation ) ) {
			array_push( $team_classes, 'grve-animated-item' );
			array_push( $team_classes, $animation);
			array_push( $team_classes, 'grve-duration-' . $animation_duration );
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $team_classes, $el_class);
		}

		if ( 'layout-2' == $team_layout ){
			array_push( $team_classes, 'grve-with-parallax-effect');
			array_push( $team_classes, 'grve-paraller-wrapper');
			array_push( $team_classes, 'grve-align-' . $align );
		}

		$team_class_string = implode( ' ', $team_classes );


		$has_link = movedo_ext_vce_has_link( $link );

		$link_team_class = 'grve-team-url';
		if( !empty( $link_class ) )  {
			$link_team_class .= ' ' . $link_class;
		}
		$link_attributes = movedo_ext_vce_get_link_attributes( $link, $link_class );
		$link_team_attributes = movedo_ext_vce_get_link_attributes( $link, $link_team_class );

		ob_start();

		?>

		<?php
		if ( 'layout-1' == $team_layout ) {
		?>
		<div class="grve-team <?php echo esc_attr( $team_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>
			<figure class="grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
				<?php
					if ( $has_link ) {
						echo '<a ' . implode( ' ', $link_team_attributes ) . '></a>';
					}
				?>
				<div class="grve-team-person">
					<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
					<?php echo $image_html; ?>
				</div>
				<figcaption>
					<ul class="grve-team-social grve-align-center">
						<?php echo $links; ?>
					</ul>
				</figcaption>
			</figure>
			<div class="grve-team-description grve-align-center">
				<?php if ( !empty( $identity ) ) { ?>
				<div class="grve-team-identity grve-link-text"><?php echo $identity; ?></div>
				<?php } ?>
				<?php if ( $has_link ) { ?>
				<a <?php echo implode( ' ', $link_attributes ); ?>>
				<?php } ?>
				<<?php echo tag_escape( $heading_tag ); ?> class="grve-team-name grve-text-hover-primary-1 <?php echo esc_attr( $heading_class ); ?>"><?php echo $name; ?></<?php echo tag_escape( $heading_tag ); ?>>
				<?php if ( $has_link ) { ?>
				</a>
				<?php } ?>
			</div>
		</div>
		<?php
			} else {
		?>
		<div class="grve-team <?php echo esc_attr( $team_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>

			<figure class="grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
				<?php
					if ( $has_link ) {
						echo '<a ' . implode( ' ', $link_team_attributes ) . '></a>';
					}
				?>
				<div class="grve-team-person">
					<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
					<?php echo $image_html; ?>
				</div>
			</figure>
			<div class="grve-team-description grve-align-left grve-box-item grve-bg-<?php echo esc_attr( $content_bg ); ?> grve-paraller" data-limit="1x">
				<?php if ( !empty( $identity ) ) { ?>
				<div class="grve-team-identity grve-link-text"><?php echo $identity; ?></div>
				<?php } ?>
				<?php if ( $has_link ) { ?>
				<a <?php echo implode( ' ', $link_attributes ); ?>>
				<?php } ?>
				<<?php echo tag_escape( $heading_tag ); ?> class="grve-team-name grve-heading-color grve-text-hover-primary-1 <?php echo esc_attr( $heading_class ); ?>"><?php echo $name; ?></<?php echo tag_escape( $heading_tag ); ?>>
				<?php if ( $has_link ) { ?>
				</a>
				<?php } ?>
				<?php if ( !empty( $content ) ) { ?>
				<p><?php echo movedo_ext_vce_unautop( $content ); ?></p>
				<?php } ?>
				<ul class="grve-team-social grve-responsive-team-socials">
					<?php echo $links; ?>
				</ul>
			</div>
			<ul class="grve-team-social grve-align-center">
				<?php echo $links; ?>
			</ul>
		</div>
		<?php
			}
		?>

		<?php

		return ob_get_clean();

	}
	add_shortcode( 'movedo_team', 'movedo_ext_vce_team_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_team_shortcode_params' ) ) {
	function movedo_ext_vce_team_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Team", "movedo-extension" ),
			"description" => esc_html__( "Show your team members", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-team",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "image_size",
					'value' => array(
						esc_html__( 'Full ( Custom )', 'movedo-extension' ) => '',
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					"description" => esc_html__( "Select your Image Size.", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "movedo-extension" ),
					"param_name" => "image",
					"value" => '',
					"description" => esc_html__( "Select an image.", "movedo-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Retina Image", "movedo-extension" ),
					"param_name" => "retina_image",
					"value" => '',
					"description" => esc_html__( "Select a 2x image.", "movedo-extension" ),
					"dependency" => array( 'element' => "image_size", 'value' => array( '' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Team Style", "movedo-extension" ),
					"param_name" => "team_layout",
					"value" => array(
						esc_html__( "Classic Style", "movedo-extension" ) => 'layout-1',
						esc_html__( "Movedo Style", "movedo-extension" ) => 'layout-2',
					),
					"description" => esc_html__( "Style of the team.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Name", "movedo-extension" ),
					"param_name" => "name",
					"value" => "John Smith",
					"description" => esc_html__( "Enter your team name.", "movedo-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h3" ),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Identity", "movedo-extension" ),
					"param_name" => "identity",
					"value" => "",
					"description" => esc_html__( "Enter your team identity/profession e.g: Designer", "movedo-extension" ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Enter your text.", "movedo-extension" ),
					"dependency" => array( 'element' => "team_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Content Background", "movedo-extension" ),
					"param_name" => "content_bg",
					"description" => esc_html__( "Selected background color for your image text content.", "movedo-extension" ),
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Black", "movedo-extension" ) => 'black',
					),
					'std' => 'white',
					"dependency" => array( 'element' => "team_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Align", "movedo-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
					),
					"description" => '',
					"dependency" => array( 'element' => "team_layout", 'value' => array( 'layout-2' ) ),
				),
				movedo_ext_vce_add_animation(),
				movedo_ext_vce_add_animation_delay(),
				movedo_ext_vce_add_animation_duration(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
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
					"group" => esc_html__( "Image Hovers", "movedo-extension" ),
					'std' => 'none',
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
					"group" => esc_html__( "Image Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "movedo-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"group" => esc_html__( "Image Hovers", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Facebook", "movedo-extension" ),
					"param_name" => "social_facebook",
					"value" => "",
					"description" => esc_html__( "Enter facebook URL. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Twitter", "movedo-extension" ),
					"param_name" => "social_twitter",
					"value" => "",
					"description" => esc_html__( "Enter twitter URL. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Linkedin", "movedo-extension" ),
					"param_name" => "social_linkedin",
					"value" => "",
					"description" => esc_html__( "Enter linkedin URL. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Instagram", "movedo-extension" ),
					"param_name" => "social_instagram",
					"value" => "",
					"description" => esc_html__( "Enter instagram URL. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "YouTube", "movedo-extension" ),
					"param_name" => "social_youtube",
					"value" => "",
					"description" => esc_html__( "Enter YouTube URL. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Vimeo", "movedo-extension" ),
					"param_name" => "social_vimeo",
					"value" => "",
					"description" => esc_html__( "Enter Vimeo URL. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Email", "movedo-extension" ),
					"param_name" => "email",
					"value" => "",
					"description" => esc_html__( "Enter your email. Clear input if you don't want to display.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "movedo-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Link Class", "movedo-extension" ),
					"param_name" => "link_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "movedo-extension" ),
					"group" => esc_html__( "Socials & Link", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_team', 'movedo_ext_vce_team_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_team_shortcode_params( 'movedo_team' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
