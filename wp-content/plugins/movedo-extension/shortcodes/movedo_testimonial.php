<?php
/**
 * Testimonial Shortcode
 */

if( !function_exists( 'movedo_ext_vce_testimonial_shortcode' ) ) {

	function movedo_ext_vce_testimonial_shortcode( $attr, $content ) {

		$allow_filter = $class_fullwidth = $slider_data = $output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'testimonial_mode' => 'carousel',
					'movedo_image_mode' => 'portrait',
					'columns_large_screen' => '3',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'items_to_show' => '20',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
					'show_image' => 'no',
					'margin_bottom' => '',
					'slideshow_speed' => '3000',
					'pagination_speed' => '400',
					'carousel_pagination' => 'yes',
					'transition' => 'slide',
					'auto_play' => 'yes',
					'pause_hover' => 'no',
					'auto_height' => 'no',
					'animation' => 'grve-zoom-in',
					'align' => 'left',
					'text_style' => 'none',
					'content_bg' => 'white',
					'el_class' => '',
				),
				$attr
			)
		);

		$testimonial_classes = array( 'grve-element', 'grve-testimonial' );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$data_string = '';

		switch( $testimonial_mode ) {
			case 'masonry':
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $testimonial_classes, 'grve-with-gap' );
				}
				array_push( $testimonial_classes, 'grve-layout-3' );
				array_push( $testimonial_classes, 'grve-isotope' );
				break;
			case 'movedo-style':
				$data_string = ' data-slider-autoplay="' . esc_attr( $auto_play ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '" data-pagination-speed="' . esc_attr( $pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				array_push( $testimonial_classes, 'grve-layout-2' );
				array_push( $testimonial_classes, 'grve-paraller-wrapper' );
				array_push( $testimonial_classes, 'grve-carousel-pagination-1' );
				array_push( $testimonial_classes, 'grve-carousel-element' );
				$disable_pagination = 'yes';
				break;
			case 'carousel':
			default:
				$data_string = ' data-slider-transition="' . esc_attr( $transition ) . '" data-slider-autoplay="' . esc_attr( $auto_play ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '" data-pagination-speed="' . esc_attr( $pagination_speed ) . '" data-slider-autoheight="' . esc_attr( $auto_height ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				array_push( $testimonial_classes, 'grve-carousel-element' );
				array_push( $testimonial_classes, 'grve-layout-1' );
				array_push( $testimonial_classes, 'grve-align-' . $align );
				if ( 'none' != $text_style ) {
					array_push( $testimonial_classes, 'grve-' . $text_style );
				}
				array_push( $testimonial_classes, 'grve-carousel-pagination-1' );
				$disable_pagination = 'yes';
				break;

		}

		if ( !empty ( $el_class ) ) {
			array_push( $testimonial_classes, $el_class);
		}

		$testimonial_class_string = implode( ' ', $testimonial_classes );

		$testimonial_cat = "";

		if ( !empty( $categories ) ) {
			$testimonial_category_list = explode( ",", $categories );
			foreach ( $testimonial_category_list as $testimonial_list ) {
				$testimonial_term = get_term( $testimonial_list, 'testimonial_category' );
				$testimonial_cat = $testimonial_cat.$testimonial_term->slug . ', ';
			}
		}

		$paged = 1;

		if ( 'yes' != $disable_pagination ) {
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			}
		}


		$exclude_ids = array();
		if( !empty( $exclude_posts ) ){
			$exclude_ids = explode( ',', $exclude_posts );
		}

		$include_ids = array();
		if( !empty( $include_posts ) ){
			$include_ids = explode( ',', $include_posts );
			$args = array(
				'post_type' => 'testimonial',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		} else {
			$args = array(
				'post_type' => 'testimonial',
				'post_status'=>'publish',
				'paged' => $paged,
				'testimonial_category' => $testimonial_cat,
				'post__not_in' => $exclude_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$image_size = 'thumbnail';

		$query = new WP_Query( $args );

		ob_start();

		if ( $query->have_posts() ) :

		?>
			<div class="<?php echo esc_attr( $testimonial_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>

				<?php if ( 'masonry' == $testimonial_mode ) { ?>
				<div class="grve-isotope-container">
				<?php } ?>

		<?php
		while ( $query->have_posts() ) : $query->the_post();


		$name =  movedo_ext_vce_post_meta( '_movedo_grve_testimonial_name' );
		$identity =  movedo_ext_vce_post_meta( '_movedo_grve_testimonial_identity' );

		if ( !empty( $name ) && !empty( $identity ) ) {
			$identity = ' - ' . $identity;
		}

			if ( 'carousel' == $testimonial_mode ) {
		?>
				<div class="grve-testimonial-element">
					<?php if ( 'yes' == $show_image && has_post_thumbnail() ) { ?>
							<div class="grve-testimonial-thumb"><?php the_post_thumbnail( $image_size ); ?></div>
					<?php } ?>
					<div class="grve-testimonial-content">
						<?php the_content(); ?>
						<?php if ( !empty( $name ) || !empty( $identity ) ) { ?>
						<div class="grve-small-text grve-heading-color grve-testimonial-name"><?php echo esc_html( $name ); ?><span class="grve-identity"><?php echo esc_html( $identity ); ?></span></div>
						<?php } ?>
					</div>
				</div>
		<?php
			} else if ( 'masonry' == $testimonial_mode ) {

		?>
				<div class="grve-isotope-item grve-testimonial-item">
					<div class="grve-isotope-item-inner <?php echo esc_attr( $animation ); ?>">
						<div class="grve-testimonial-element grve-box-item grve-bg-<?php echo esc_attr( $content_bg ); ?>">
							<div class="grve-testimonial-content">
								<?php the_content(); ?>
							</div>
							<div class="grve-testimonial-author">
								<?php if ( 'yes' == $show_image && has_post_thumbnail() ) { ?>
										<div class="grve-testimonial-thumb"><?php the_post_thumbnail( $image_size ); ?></div>
								<?php } ?>
								<?php if ( !empty( $name ) || !empty( $identity ) ) { ?>
								<div class="grve-small-text grve-heading-color grve-testimonial-name"><?php echo esc_html( $name ); ?><span class="grve-text-primary-1"><?php echo esc_html( $identity ); ?></span></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

		<?php
			} else {
				$image_size = movedo_ext_vce_get_image_size( $movedo_image_mode );
		?>
				<div class="grve-testimonial-element">
					<div class="grve-testimonial-thumb">
					<?php
						if( has_post_thumbnail() ) {
							the_post_thumbnail( $image_size );
						} else {
							echo movedo_ext_vce_get_fallback_image( $image_size );
						}
					?>
					</div>
					<i class="grve-testimonial-icon grve-icon-quote grve-bg-primary-1 grve-paraller" data-limit="2x"></i>
					<div class="grve-testimonial-content grve-box-item grve-bg-<?php echo esc_attr( $content_bg ); ?> grve-paraller" data-limit="1x">
						<?php the_content(); ?>
						<?php if ( !empty( $name ) || !empty( $identity ) ) { ?>
						<div class="grve-small-text grve-heading-color grve-testimonial-name"><?php echo esc_html( $name ); ?><span class="grve-text-primary-1"><?php echo esc_html( $identity ); ?></span></div>
						<?php } ?>
					</div>
				</div>
		<?php
			}

		endwhile;

		?>
				<?php if ( 'masonry' == $testimonial_mode ) { ?>
				</div>
				<?php } ?>
<?php
			if ( 'yes' != $disable_pagination ) {
				$total = $query->max_num_pages;
				$big = 999999999; // need an unlikely integer
				if( $total > 1 )  {
					 echo '<div class="grve-pagination grve-link-text grve-heading-color">';

					 if( get_option('permalink_structure') ) {
						 $format = 'page/%#%/';
					 } else {
						 $format = '&paged=%#%';
					 }
					 echo paginate_links(array(
						'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'		=> $format,
						'current'		=> max( 1, $paged ),
						'total'			=> $total,
						'mid_size'		=> 2,
						'type'			=> 'list',
						'prev_text'	=> '<i class="grve-icon-arrow-left"></i>',
						'next_text'	=> '<i class="grve-icon-arrow-right"></i>',
						'add_args' => false,
					 ));
					 echo '</div>';
				}
			}
?>
			</div>

		<?php
		else :
		endif;
		wp_reset_postdata();

		return ob_get_clean();

	}
	add_shortcode( 'movedo_testimonial', 'movedo_ext_vce_testimonial_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_testimonial_shortcode_params' ) ) {
	function movedo_ext_vce_testimonial_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Testimonial", "movedo-extension" ),
			"description" => esc_html__( "Add a captivating testimonial slider", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-testimonial",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Testimonial Mode", "movedo-extension" ),
					"param_name" => "testimonial_mode",
					"value" => array(
						esc_html__( "Carousel", "movedo-extension" ) => 'carousel',
						esc_html__( "Masonry", "movedo-extension" ) => 'masonry',
						esc_html__( "Movedo Style", "movedo-extension" ) => 'movedo-style',
					),
					"description" => esc_html__( "Select your testimonial type.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Large Screen Columns", "movedo-extension" ),
					"param_name" => "columns_large_screen",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select column on large devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "movedo-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select number of columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "movedo-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
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
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "movedo-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "animation",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Fade In", "movedo-extension" ) => "grve-fade-in",
						esc_html__( "Fade In Up", "movedo-extension" ) => "grve-fade-in-up",
						esc_html__( "Fade In Down", "movedo-extension" ) => "grve-fade-in-down",
						esc_html__( "Fade In Left", "movedo-extension" ) => "grve-fade-in-left",
						esc_html__( "Fade In Right", "movedo-extension" ) => "grve-fade-in-right",
						esc_html__( "Zoom In", "movedo-extension" ) => "grve-zoom-in",
					),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
					"std" => "grve-zoom-in",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Items to show", "movedo-extension" ),
					"param_name" => "items_to_show",
					"value" => '20',
					"description" => esc_html__( "Maximum Testimonial Items to Show", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "movedo-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "movedo-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry' ) ),
				),
				movedo_ext_vce_add_order_by(),
				movedo_ext_vce_add_order(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Testimonial Image Size", "movedo-extension" ),
					"param_name" => "movedo_image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
					),
					'std' => 'portrait',
					"description" => esc_html__( "Select your Testimonial Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'movedo-style' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Show Featured Image", "movedo-extension" ),
					"param_name" => "show_image",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => 'no',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel', 'masonry' ) ),
					"std" => 'no',
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Content Background", "movedo-extension" ),
					"param_name" => "content_bg",
					"description" => esc_html__( "Selected background color for your testimonial content.", "movedo-extension" ),
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Black", "movedo-extension" ) => 'black',
					),
					'std' => 'white',
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'masonry', 'movedo-style' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel', 'movedo-style' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "movedo-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel', 'movedo-style' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Transition", "movedo-extension" ),
					"param_name" => "transition",
					"value" => array(
						esc_html__( "Slide", "movedo-extension" ) => 'slide',
						esc_html__( "Fade", "movedo-extension" ) => 'fade',
					),
					"description" => esc_html__( "Transition Effect.", "movedo-extension" ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "movedo-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, testimonial will be paused on hover", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel', 'movedo-style' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Auto Height", "movedo-extension" ),
					"param_name" => "auto_height",
					"value" => array( esc_html__( "Select if you want smooth auto height", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Pagination", "movedo-extension" ),
					"param_name" => "carousel_pagination",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"std" => "yes",
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel', 'movedo-style' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text Style", "movedo-extension" ),
					"param_name" => "text_style",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => '',
						esc_html__( "Leader", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle", "movedo-extension" ) => 'subtitle',
						esc_html__( "Quote", "movedo-extension" ) => 'quote-text',
					),
					"description" => 'Select your text style',
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Alignment", "movedo-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "testimonial_mode", 'value' => array( 'carousel' ) ),
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Exclude Posts", "movedo-extension" ),
					"param_name" => "exclude_posts",
					"value" => '',
					"description" => esc_html__( "Type the post ids you want to exclude separated by comma ( , ).", "movedo-extension" ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "movedo_ext_multi_checkbox",
					"heading" => __("Testimonial Categories", "movedo-extension" ),
					"param_name" => "categories",
					"value" => movedo_ext_vce_get_testimonial_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Include Specific Posts", "movedo-extension" ),
					"param_name" => "include_posts",
					"value" => '',
					"description" => esc_html__( "Type the specific post ids you want to include separated by comma ( , ). Note: If you define specific post ids, Exclude Posts and Categories will have no effect.", "movedo-extension" ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_testimonial', 'movedo_ext_vce_testimonial_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_testimonial_shortcode_params( 'movedo_testimonial' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
