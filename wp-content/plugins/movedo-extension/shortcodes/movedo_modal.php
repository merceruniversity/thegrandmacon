<?php
/**
 * Modal Shortcode
 */

if( !function_exists( 'movedo_ext_vce_modal_shortcode' ) ) {

	function movedo_ext_vce_modal_shortcode( $attr, $content ) {

		$output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'modal_id' => '',
					'modal_mode' => 'full',
					'content_bg_color' => 'white',
					'font_color'      => '',
					'heading_color' => '',
					'content_size' => 'large',
					'el_class' => '',
				),
				$attr
			)
		);

		$modal_classes = array( 'grve-modal-element', 'mfp-hide' );
		if( !empty( $el_class ) ) {
			$modal_classes[] = $el_class;
		}


		if ( 'dialog' == $modal_mode ) {
			$modal_classes[] = 'grve-modal-dialog';
			$modal_classes[] = 'grve-bg-' . $content_bg_color;
			$modal_classes[] = 'grve-drop-shadow';
			$modal_classes[] = 'grve-content-' . $content_size;
			if ( !empty ( $heading_color ) ) {
				$modal_classes[] = 'grve-headings-' . $heading_color;
			}
		}
		$modal_classes_string = implode( ' ', $modal_classes );

		$wrapper_attributes = array();
		$wrapper_attributes[] = 'class="' . esc_attr( $modal_classes_string ) . '"';
		$wrapper_attributes[] = 'id="' . esc_attr( $modal_id ) . '"';

		$style = movedo_ext_vce_build_shortcode_style(
			array(
				'font_color' => $font_color,
			)
		);
		if( !empty( $style ) ) {
			$wrapper_attributes[] = $style;
		}

		ob_start();

		?>
			<div <?php echo implode( ' ', $wrapper_attributes ); ?>>
				<div class="grve-section">
					<div class="grve-container">
						<div class="grve-row grve-columns-gap-30">
							<div class="grve-column grve-column-1">
							<?php
								if ( !empty( $content ) ) {
									echo do_shortcode( $content );
								}
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		return ob_get_clean();

	}
	add_shortcode( 'movedo_modal', 'movedo_ext_vce_modal_shortcode' );

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_movedo_modal extends WPBakeryShortCodesContainer {
    }
}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_modal_shortcode_params' ) ) {
	function movedo_ext_vce_modal_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Modal", "movedo-extension" ),
			"description" => esc_html__( "Add a modal with elements", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon" => "icon-wpb-grve-modal",
			"category" => esc_html__( "Content", "js_composer" ),
			"content_element" => true,
			"controls" => "full",
			"show_settings_on_create" => true,
			"as_parent" => array('except' => 'vc_tta_section,movedo_modal'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Modal ID", "movedo-extension" ),
					"param_name" => "modal_id",
					"admin_label" => true,
					"description" => esc_html__( "Enter a unique id to trigger the modal from a link or button. In your link use class: grve-modal-popup and href: # following the Modal ID.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Modal Mode", "movedo-extension" ),
					"param_name" => "modal_mode",
					"value" => array(
						esc_html__( "Full", "movedo-extension" ) => 'full',
						esc_html__( "Dialog", "movedo-extension" ) => 'dialog',
					),
					"description" => esc_html__( "Select your modal mode.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Content Size", "movedo-extension" ),
					"param_name" => "content_size",
					"value" => array(
						esc_html__( "Large", "movedo-extension" ) => 'large',
						esc_html__( "Medium", "movedo-extension" ) => 'medium',
						esc_html__( "Small", "movedo-extension" ) => 'small',
					),
					"description" => esc_html__( "Select the content size of your modal.", "movedo-extension" ),
					"dependency" => array( 'element' => "modal_mode", 'value' => array( 'dialog' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Background Color", "movedo-extension" ),
					"param_name" => "content_bg_color",
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
					"description" => esc_html__( "Background color of the modal dialog.", "movedo-extension" ),
					"dependency" => array( 'element' => "modal_mode", 'value' => array( 'dialog' ) ),
					'std' => 'white',
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__( "Font Color", "movedo-extension" ),
					"param_name" => "font_color",
					"description" => esc_html__("Select font color", 'movedo-extension' ),
					"dependency" => array( 'element' => "modal_mode", 'value' => array( 'dialog' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Heading Color", "movedo-extension" ),
					"param_name" => "heading_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Default", "movedo-extension" ) => '',
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
					"description" => esc_html__( "Heading color of the modal dialog.", "movedo-extension" ),
					"dependency" => array( 'element' => "modal_mode", 'value' => array( 'dialog' ) ),
					'std' => '',
				),
				movedo_ext_vce_add_el_class(),
			),
			"js_view" => 'VcColumnView',
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_modal', 'movedo_ext_vce_modal_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_modal_shortcode_params( 'movedo_modal' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
