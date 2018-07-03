<?php
/*
*	Greatives Category Meta
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

	//Categories
	add_action('category_edit_form_fields','movedo_grve_category_edit_form_fields', 10);
	add_action('post_tag_edit_form_fields','movedo_grve_category_edit_form_fields', 10);
	add_action('product_cat_edit_form_fields','movedo_grve_category_edit_form_fields', 10);
	add_action('product_tag_edit_form_fields','movedo_grve_category_edit_form_fields', 10);
	add_action('edit_term','movedo_grve_save_category_fields', 10, 3);

	function movedo_grve_category_edit_form_fields( $term ) {
		$movedo_grve_term_meta = movedo_grve_get_term_meta( $term->term_id, '_movedo_grve_custom_title_options' );
		movedo_grve_print_category_fields( $movedo_grve_term_meta );
	}

	function movedo_grve_print_category_fields( $movedo_grve_custom_title_options = array() ) {
?>
		<tr class="form-field">
			<td colspan="2">
				<div id="grve-category-title" class="postbox">
<?php

			//Custom Title Option
			movedo_grve_print_admin_option(
				array(
					'type' => 'select',
					'name' => 'movedo_grve_term_meta[custom]',
					'id' => 'grve-category-title-custom',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'custom' ),
					'options' => array(
						'' => esc_html__( '-- Inherit --', 'movedo' ),
						'custom' => esc_html__( 'Custom', 'movedo' ),

					),
					'label' => array(
						"title" => esc_html__( 'Title Options', 'movedo' ),
					),
					'group_id' => 'grve-category-title',
					'highlight' => 'highlight',
				)
			);

			global $movedo_grve_area_height;
			movedo_grve_print_admin_option(
				array(
					'type' => 'select',
					'options' => $movedo_grve_area_height,
					'name' => 'movedo_grve_term_meta[height]',
					'id' => 'grve-category-title-height',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'height', '40' ),
					'label' => array(
						"title" => esc_html__( 'Title Area Height', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'textfield',
					'name' => 'movedo_grve_term_meta[min_height]',
					'id' => 'grve-category-title-min-height',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'min_height', '200' ),
					'label' => array(
						"title" => esc_html__( 'Title Area Minimum Height in px', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select',
					'name' => 'movedo_grve_term_meta[container_size]',
					'id' => 'grve-category-title-container-size',
					'options' => array(
						'' => esc_html__( 'Default', 'movedo' ),
						'large' => esc_html__( 'Large', 'movedo' ),
					),
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'container_size' ),
					'label' => array(
						"title" => esc_html__( 'Container Size', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select-colorpicker',
					'name' => 'movedo_grve_term_meta[bg_color]',
					'id' => 'grve-category-title-bg-color',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_color', 'dark' ),
					'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_color_custom', '#000000' ),
					'label' => array(
						"title" => esc_html__( 'Background Color', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
					'multiple' => 'multi',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'select-colorpicker',
					'name' => 'movedo_grve_term_meta[content_bg_color]',
					'id' => 'grve-category-title-content-bg-color',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_bg_color', 'none' ),
					'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_bg_color_custom', '#ffffff' ),
					'label' => array(
						"title" => esc_html__( 'Content Background Color', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
					'multiple' => 'multi',
					'type_usage' => 'title-content-bg',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'select-colorpicker',
					'name' => 'movedo_grve_term_meta[title_color]',
					'id' => 'grve-category-title-title-color',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'title_color', 'light' ),
					'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'title_color_custom', '#ffffff' ),
					'label' => array(
						"title" => esc_html__( 'Title Color', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
					'multiple' => 'multi',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select-colorpicker',
					'name' => 'movedo_grve_term_meta[caption_color]',
					'id' => 'grve-category-title-caption_color',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'caption_color', 'light' ),
					'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'caption_color_custom', '#ffffff' ),
					'label' => array(
						"title" => esc_html__( 'Description Color', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
					'multiple' => 'multi',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select',
					'name' => 'movedo_grve_term_meta[content_size]',
					'id' => 'grve-category-title-content-size',
					'options' => array(
						'large' => esc_html__( 'Large', 'movedo' ),
						'medium' => esc_html__( 'Medium', 'movedo' ),
						'small' => esc_html__( 'Small', 'movedo' ),
					),
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_size', 'large' ),
					'label' => array(
						"title" => esc_html__( 'Content Size', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select-align',
					'name' => 'movedo_grve_term_meta[content_alignment]',
					'id' => 'grve-category-title-content-alignment',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_alignment', 'center' ),
					'label' => array(
						"title" => esc_html__( 'Content Alignment', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);

			global $movedo_grve_media_bg_position_selection;
			movedo_grve_print_admin_option(
				array(
					'type' => 'select',
					'name' => 'movedo_grve_term_meta[content_position]',
					'id' => 'grve-category-title-content_position',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_position', 'center-center' ),
					'options' => $movedo_grve_media_bg_position_selection,
					'label' => array(
						"title" => esc_html__( 'Content Position', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select-text-animation',
					'name' => 'movedo_grve_term_meta[content_animation]',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'content_animation', 'fade-in' ),
					'label' => esc_html__( 'Content Animation', 'movedo' ),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }
					]',
				)
			);


			movedo_grve_print_admin_option(
				array(
					'type' => 'select',
					'name' => 'movedo_grve_term_meta[bg_mode]',
					'id' => 'grve-category-title-bg-mode',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_mode'),
					'options' => array(
						'' => esc_html__( 'Color Only', 'movedo' ),
						'custom' => esc_html__( 'Custom Image', 'movedo' ),

					),
					'label' => array(
						"title" => esc_html__( 'Background', 'movedo' ),
					),
					'group_id' => 'grve-category-title',
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] }

					]',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'select-image',
					'name' => 'movedo_grve_term_meta[bg_image_id]',
					'id' => 'grve-category-title-bg-image-id',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_image_id'),
					'label' => array(
						"title" => esc_html__( 'Background Image', 'movedo' ),
					),
					'width' => 'fullwidth',
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] },
						{ "id" : "grve-category-title-bg-mode", "values" : ["custom"] }

					]',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'select-bg-position',
					'name' => 'movedo_grve_term_meta[bg_position]',
					'id' => 'grve-category-title-bg-position',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'bg_position', 'center-center'),
					'label' => array(
						"title" => esc_html__( 'Background Position', 'movedo' ),
					),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] },
						{ "id" : "grve-category-title-bg-mode", "values" : ["custom"] }
					]',
				)
			);

			movedo_grve_print_admin_option(
				array(
					'type' => 'select-pattern-overlay',
					'name' => 'movedo_grve_term_meta[pattern_overlay]',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'pattern_overlay'),
					'label' => esc_html__( 'Pattern Overlay', 'movedo' ),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] },
						{ "id" : "grve-category-title-bg-mode", "values" : ["custom"] }
					]',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'select-colorpicker',
					'name' => 'movedo_grve_term_meta[color_overlay]',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'color_overlay', 'dark' ),
					'value2' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'color_overlay_custom', '#000000' ),
					'label' => esc_html__( 'Color Overlay', 'movedo' ),
					'multiple' => 'multi',
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] },
						{ "id" : "grve-category-title-bg-mode", "values" : ["custom"] }
					]',
				)
			);
			movedo_grve_print_admin_option(
				array(
					'type' => 'select-opacity',
					'name' => 'movedo_grve_term_meta[opacity_overlay]',
					'value' => movedo_grve_array_value( $movedo_grve_custom_title_options, 'opacity_overlay', '0' ),
					'label' => esc_html__( 'Opacity Overlay', 'movedo' ),
					'dependency' =>
					'[
						{ "id" : "grve-category-title-custom", "values" : ["custom"] },
						{ "id" : "grve-category-title-bg-mode", "values" : ["custom"] }
					]',
				)
			);
?>
			</div>
		</td>
	</tr>
<?php
	}

	//Save Category Meta
	function movedo_grve_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$custom_meta_tax = array ( 'category', 'post_tag', 'product_cat', 'product_tag' );

		if ( isset( $_POST['movedo_grve_term_meta'] ) && in_array( $taxonomy, $custom_meta_tax ) ) {
			$movedo_grve_term_meta = movedo_grve_get_term_meta( $term_id, '_movedo_grve_custom_title_options' );
			$cat_keys = array_keys( $_POST['movedo_grve_term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset( $_POST['movedo_grve_term_meta'][$key] ) ) {
					$movedo_grve_term_meta[$key] = $_POST['movedo_grve_term_meta'][$key];
				}
			}
			movedo_grve_update_term_meta( $term_id , '_movedo_grve_custom_title_options', $movedo_grve_term_meta );
		}
	}

//Omit closing PHP tag to avoid accidental whitespace output errors.
