<?php
/**
 * Product Shortcode
 */

if( !function_exists( 'movedo_ext_vce_products_shortcode' ) ) {

	function movedo_ext_vce_products_shortcode( $attr, $content ) {

		$product_row_start = $allow_filter = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'text_style' => 'none',
					'align' => 'left',
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'product_mode' => 'grid',
					'carousel_layout' => 'layout-1',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'columns_large_screen' => '3',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'grid_image_mode' => 'landscape',
					'carousel_image_mode' => 'landscape',
					'product_filter' => '',
					'filter_style' => 'simple',
					'filter_shape' => 'square',
					'filter_color' => 'primary-1',
					'product_filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
					'item_gutter' => 'yes',
					'gutter_size' => '30',
					'item_spinner' => 'no',
					'items_per_page' => '4',
					'items_tablet_landscape' => '3',
					'items_tablet_portrait' => '3',
					'items_mobile' => '1',
					'items_to_show' => '12',
					'product_title_heading_tag' => 'h3',
					'product_title_heading' => 'h3',
					'second_image_effect' => 'yes',
					'zoom_effect' => 'none',
					'grayscale_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
					'slideshow_speed' => '3000',
					'auto_play' => 'yes',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'carousel_pagination' => 'no',
					'carousel_pagination_speed' => '400',
					'animation' => 'grve-zoom-in',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$attr
			)
		);

		$product_classes = array( 'grve-element' );
		$data_string = '';

		switch( $product_mode ) {
			case 'carousel':
				$data_string .= ' data-items="' . esc_attr( $items_per_page ) . '"';
				$data_string .= ' data-items-tablet-landscape="' . esc_attr( $items_tablet_landscape ) . '"';
				$data_string .= ' data-items-tablet-portrait="' . esc_attr( $items_tablet_portrait ) . '"';
				$data_string .= ' data-items-mobile="' . esc_attr( $items_mobile ) . '"';
				$data_string .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
				$data_string .= ' data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
				$data_string .= ' data-slider-pause="' . esc_attr( $pause_hover ) . '"';
				$data_string .= ' data-pagination-speed="' . esc_attr( $carousel_pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				array_push( $product_classes, 'grve-carousel' );
				array_push( $product_classes, 'grve-' . $carousel_layout );

				if ( 'yes' == $item_gutter ) {
					array_push( $product_classes, 'grve-with-gap' );
				}
				$disable_pagination = 'yes';
				break;
			case 'grid':
			default:
				$product_row_start = '<div class="grve-isotope-container">';

				$data_string = ' data-spinner="' . esc_attr( $item_spinner ) . '" data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $product_classes, 'grve-with-gap' );
				}
				array_push( $product_classes, 'grve-product' );
				array_push( $product_classes, 'grve-isotope' );
				$allow_filter = 'yes';
				break;
		}

		$isotope_inner_item_classes = array( 'grve-isotope-item-inner', 'grve-hover-item' );

		if ( !empty( $animation ) ) {
			array_push( $isotope_inner_item_classes, $animation);
		}

		$isotope_inner_item_class_string = implode( ' ', $isotope_inner_item_classes );

		// Image Effect
		$image_effect_classes = array( 'grve-image-hover' );
		if ( 'none' != $zoom_effect ) {
			array_push( $image_effect_classes, 'grve-zoom-' . $zoom_effect );
		}
		if ( 'none' != $grayscale_effect ) {
			array_push( $image_effect_classes, 'grve-' . $grayscale_effect );
		}
		$image_effect_class_string = implode( ' ', $image_effect_classes );

		if ( !empty ( $el_class ) ) {
			array_push( $product_classes, $el_class);
		}
		$product_class_string = implode( ' ', $product_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$product_cat = "";
		$product_category_ids = array();

		if( ! empty( $categories ) ) {
			$product_category_ids = explode( ",", $categories );
			foreach ( $product_category_ids as $category_id ) {
				$category_term = get_term( $category_id, 'product_cat' );
				if ( isset( $category_term) ) {
					$product_cat = $product_cat.$category_term->slug . ', ';
				}
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
				'post_type' => 'product',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
			$product_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'product',
				'post_status'=>'publish',
				'paged' => $paged,
				'product_cat' => $product_cat,
				'post__not_in' => $exclude_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$query = new WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) :
		?>
			<div class="<?php echo esc_attr( $product_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>
		<?php

		if ( 'yes' == $product_filter && 'yes' == $allow_filter ) {

			$filter_classes = array( 'grve-filter' );

			array_push( $filter_classes, 'grve-filter-style-' . $filter_style );
			array_push( $filter_classes, 'grve-align-' . $product_filter_align);
			array_push( $filter_classes, 'grve-link-text');

			if ( 'button' == $filter_style ) {
				array_push( $filter_classes, 'grve-link-text');
				array_push( $filter_classes, 'grve-filter-shape-' . $filter_shape );
				array_push( $filter_classes, 'grve-filter-color-' . $filter_color );
			}

			$filter_class_string = implode( ' ', $filter_classes );

			$category_prefix = '.product_cat-';
			$category_filter_list = array();
			$category_filter_array = array();
			$all_string =  apply_filters( 'movedo_grve_vce_product_string_all_categories', esc_html__( 'All', 'movedo-extension' ) );
			$category_filter_string = '<li data-filter="*" class="selected"><span>' . esc_html( $all_string ) . '</span></li>';
			$category_filter_add = false;
			while ( $query->have_posts() ) : $query->the_post();

				if ( $product_categories = get_the_terms( get_the_ID(), 'product_cat' ) ) {

					foreach($product_categories as $category_term){
						$category_filter_add = false;
						if ( !in_array($category_term->term_id, $category_filter_list) ) {
							if( ! empty( $product_category_ids ) ) {
								if ( in_array($category_term->term_id, $product_category_ids) ) {
									$category_filter_add = true;
								}
							} else {
								$category_filter_add = true;
							}
							if ( $category_filter_add ) {
								$category_filter_list[] = $category_term->term_id;
								if ( 'title' == $filter_order_by ) {
									$category_filter_array[$category_term->name] = $category_term;
								} elseif ( 'slug' == $filter_order_by )  {
									$category_filter_array[$category_term->slug] = $category_term;
								} else {
									$category_filter_array[$category_term->term_id] = $category_term;
								}
							}
						}
					}
				}

			endwhile;


			if ( count( $category_filter_array ) > 1 ) {
				if ( '' != $filter_order_by ) {
					if ( 'ASC' == $filter_order ) {
						ksort( $category_filter_array );
					} else {
						krsort( $category_filter_array );
					}
				}
				foreach($category_filter_array as $category_filter){
					$term_class = sanitize_html_class( $category_filter->slug, $category_filter->term_id );
					if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
						$term_class = $category_filter->term_id;
					}
					$category_filter_string .= '<li data-filter="' . $category_prefix . $term_class . '"><span>' . $category_filter->name . '</span></li>';
				}
		?>
				<div class="<?php echo esc_attr( $filter_class_string ); ?>">
					<ul>
						<?php echo $category_filter_string; ?>
					</ul>
				</div>
		<?php
			}
		}
		?>

			<?php echo $product_row_start; ?>

		<?php

		if ( 'carousel' == $product_mode ) {

			//Carousel Navigation
			if( 'layout-2' == $carousel_layout ){
				echo '<div class="grve-carousel-info-wrapper grve-align-' . esc_attr( $align ) . '">';
				echo '  <div class="grve-carousel-info">';
				if( !empty( $title ) ){
					$title_classes = array( 'grve-title' );
					$title_classes[]  = 'grve-' . $heading;
					if ( !empty( $custom_font_family ) ) {
						$title_classes[]  = 'grve-' . $custom_font_family;
					}
					$title_class_string = implode( ' ', $title_classes );
					echo'    <' . tag_escape( $heading_tag ) .' class="' . esc_attr( $title_class_string ) . '">' . $title . '</' . tag_escape( $heading_tag ) .'>';
				}
				if ( !empty( $content ) ) {
					echo '    <p class="grve-description grve-' . esc_attr( $text_style ) . '">' . movedo_ext_vce_unautop( $content ) . '</p>';
				}
				echo '  </div>';
				echo movedo_ext_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
				echo '</div>';
			}
			echo '  <div class="grve-carousel-wrapper">';
			if( 'layout-1' == $carousel_layout ){
				echo movedo_ext_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
			}
?>
			<div class="grve-carousel-element grve-product"<?php echo $data_string; ?>>
<?php
		}

		$product_index = 0;

		while ( $query->have_posts() ) : $query->the_post();
			$image_size = 'movedo-grve-small-rect-horizontal';
			$product_index++;
			$product_extra_class = '';

			if ( 'carousel' != $product_mode ) {
				//Grid - Default
				$product_extra_class = 'grve-isotope-item grve-product-item ';
				$image_size = movedo_ext_vce_get_image_size( $grid_image_mode );
			} else {
				//Carousel
				$image_size = movedo_ext_vce_get_image_size( $carousel_image_mode );
				$product_extra_class = 'grve-product-item';
				echo '<div class="grve-carousel-item">';
			}

			//Second Image Classes
			$image_classes = array();
			$image_classes[] = 'attachment-' . $image_size;
			$image_classes[] = 'size-' . $image_size;
			$image_classes[] = 'grve-product-thumbnail-second';
			$image_class_string = implode( ' ', $image_classes );

			//Second Product Image
			global $product;

			if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
				$attachment_ids = $product->get_gallery_image_ids();
			} else {
				$attachment_ids = $product->get_gallery_attachment_ids();
			}
			$product_thumb_second_id = '';

			if ( $attachment_ids ) {
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if (!$image_link) {
						continue;
					}
					$loop++;
					$product_thumb_second_id = $attachment_id;
					if ($loop == 1) {
						break;
					}
				}
			}

?>

					<article id="product-<?php the_ID(); ?><?php echo uniqid('-'); ?>" <?php post_class( $product_extra_class ); ?>>
						<?php
						if ( 'carousel' == $product_mode ) {
						?><div class="grve-carousel-item grve-hover-item"><?php
						} else {
						?><div class="<?php echo esc_attr( $isotope_inner_item_class_string ); ?>"><?php
						}
						?>
							<div class="grve-product-added-icon grve-icon-shop grve-circle"></div>
							<figure class="<?php echo esc_attr( $image_effect_class_string ); ?>">
								<div class="grve-media">
									<div class="grve-add-cart-wrapper">
										<div class="grve-add-cart-button">
											<?php woocommerce_template_loop_add_to_cart(); ?>
										</div>
									</div>
									<a class="grve-item-url" href="<?php echo esc_url( get_permalink() ); ?>"></a>
									<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
									<?php
										woocommerce_show_product_loop_sale_flash();
										if ( has_post_thumbnail() ) {
											the_post_thumbnail( $image_size );
										} elseif ( wc_placeholder_img_src() ) {
											echo wc_placeholder_img( $image_size );
										}
										if ( 'yes' == $second_image_effect && !empty( $product_thumb_second_id ) ) {
											echo wp_get_attachment_image( $product_thumb_second_id, $image_size , "", array( 'class' => $image_class_string ) );
										}
									?>
								</div>
								<figcaption class="grve-content grve-align-center">
									<a href="<?php echo esc_url( get_permalink() ); ?>">
										<<?php echo tag_escape( $product_title_heading_tag ); ?> class="grve-title grve-<?php echo esc_attr( $product_title_heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $product_title_heading_tag ); ?>>
									</a>
									<?php woocommerce_template_loop_price(); ?>
								</figcaption>
							</figure>
						</div>
					</article>
<?php
			if ( 'carousel' == $product_mode ) {
				echo '</div>';
			}

		endwhile;
			if ( 'carousel' == $product_mode ) {
				echo '</div>';
			}
		?>
				</div>
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
						'prev_text'	=> '<i class="grve-icon-nav-left-small"></i>',
						'next_text'	=> '<i class="grve-icon-nav-right-small"></i>',
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
	add_shortcode( 'movedo_products', 'movedo_ext_vce_products_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_products_shortcode_params' ) ) {
	function movedo_ext_vce_products_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Products", "movedo-extension" ),
			"description" => esc_html__( "Display product element in multiple styles", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-product",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Product Mode", "movedo-extension" ),
					"param_name" => "product_mode",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Grid' , 'movedo-extension' ) => 'grid',
						esc_html__( 'Carousel' , 'movedo-extension' ) => 'carousel',
					),
					"description" => esc_html__( "Select your product mode", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Layout", "movedo-extension" ),
					"param_name" => "carousel_layout",
					"value" => array(
						esc_html__( "Classic", "movedo-extension" ) => 'layout-1',
						esc_html__( "With title and description", "movedo-extension" ) => 'layout-2',
					),
					"description" => 'Select your layout for Carousel Element',
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title here.", "movedo-extension" ),
					"save_always" => true,
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Tag", "movedo-extension" ),
					"param_name" => "heading_tag",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "div", "movedo-extension" ) => 'div',
					),
					"description" => esc_html__( "Title Tag for SEO", "movedo-extension" ),
					"std" => 'h3',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title Size/Typography", "movedo-extension" ),
					"param_name" => "heading",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "Leader Text", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "movedo-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "movedo-extension" ) => 'small-text',
						esc_html__( "Link Text", "movedo-extension" ) => 'link-text',
					),
					"description" => esc_html__( "Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Title Custom Font Family", "movedo-extension" ),
					"param_name" => "custom_font_family",
					"value" => array(
						esc_html__( "Same as Typography", "movedo-extension" ) => '',
						esc_html__( "Custom Font Family 1", "movedo-extension" ) => 'custom-font-1',
						esc_html__( "Custom Font Family 2", "movedo-extension" ) => 'custom-font-2',
						esc_html__( "Custom Font Family 3", "movedo-extension" ) => 'custom-font-3',
						esc_html__( "Custom Font Family 4", "movedo-extension" ) => 'custom-font-4',

					),
					"description" => esc_html__( "Select a different font family, defined in Theme Options - Typography Options - Extras - Custom Font Family", "movedo-extension" ),
					"std" => '',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Type your text.", "movedo-extension" ),
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text Style", "movedo-extension" ),
					"param_name" => "text_style",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => '',
						esc_html__( "Leader", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle", "movedo-extension" ) => 'subtitle',
					),
					"description" => 'Select your text style',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
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
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grid Image Size", "movedo-extension" ),
					"param_name" => "grid_image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Landscape Medium Crop', 'movedo-extension' ) => 'landscape-medium',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Portrait Medium Crop', 'movedo-extension' ) => 'portrait-medium',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => 'landscape',
					"description" => esc_html__( "Select your Grid Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Image Size", "movedo-extension" ),
					"param_name" => "carousel_image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
					),
					'std' => 'landscape',
					"description" => esc_html__( "Select your Carousel Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Large Screen Columns", "movedo-extension" ),
					"param_name" => "columns_large_screen",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Products Columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "movedo-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Products Columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "movedo-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "movedo-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of images per page", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Tablet Landscape", "movedo-extension" ),
					"param_name" => "items_tablet_landscape",
					"value" => array( '1', '2', '3', '4' ),
					"std" => 3,
					"description" => esc_html__( "Select number of items on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Tablet Portrait", "movedo-extension" ),
					"param_name" => "items_tablet_portrait",
					"value" => array( '1', '2', '3', '4'  ),
					"std" => 3,
					"description" => esc_html__( "Select number of items on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Mobile", "movedo-extension" ),
					"param_name" => "items_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select number of items on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
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
					"value" => '30',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Items to show", "movedo-extension" ),
					"param_name" => "items_to_show",
					"value" => '12',
					"description" => esc_html__( "Maximum product Items to Show", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "movedo-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Pause on Hover", "movedo-extension" ),
					"param_name" => "pause_hover",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"std" => "no",
					"description" => esc_html__( "If selected, carousel will be paused on hover", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Type", "movedo-extension" ),
					"param_name" => "navigation_type",
					'value' => array(
						esc_html__( 'Style 1' , 'movedo-extension' ) => '1',
						esc_html__( 'No Navigation' , 'movedo-extension' ) => '0',
					),
					"description" => esc_html__( "Select your Navigation type.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Color", "movedo-extension" ),
					"param_name" => "navigation_color",
					'value' => array(
						esc_html__( 'Dark' , 'movedo-extension' ) => 'dark',
						esc_html__( 'Light' , 'movedo-extension' ) => 'light',
					),
					"description" => esc_html__( "Select the background Navigation color.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Pagination", "movedo-extension" ),
					"param_name" => "carousel_pagination",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => 'no',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"std" => "no",
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Carousel Pagination Speed", "movedo-extension" ),
					"param_name" => "carousel_pagination_speed",
					"value" => '400',
					"description" => esc_html__( "Pagination Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'carousel' ) ),
				),
				movedo_ext_vce_add_order_by(),
				movedo_ext_vce_add_order(),
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
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
					"std" => "grve-zoom-in",
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Product Title Tag", "movedo-extension" ),
					"param_name" => "product_title_heading_tag",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "div", "movedo-extension" ) => 'div',
					),
					"description" => esc_html__( "product Title Tag for SEO", "movedo-extension" ),
					"std" => 'h3',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Product Title Size/Typography", "movedo-extension" ),
					"param_name" => "product_title_heading",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "Leader Text", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "movedo-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "movedo-extension" ) => 'small-text',
						esc_html__( "Link Text", "movedo-extension" ) => 'link-text',
					),
					"description" => esc_html__( "product Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Second Image Effect", "movedo-extension" ),
					"param_name" => "second_image_effect",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"description" => esc_html__( "Choose if you want second image effect.", "movedo-extension" ),
					'std' => 'yes',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
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
					'std' => 'none',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grayscale Effect", "movedo-extension" ),
					"param_name" => "grayscale_effect",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => 'none',
						esc_html__( "Grayscale Image", "movedo-extension" ) => 'grayscale-image',
						esc_html__( "Colored on Hover", "movedo-extension" ) => 'grayscale-image-hover',
					),
					"description" => esc_html__( "Choose the grayscale effect.", "movedo-extension" ),
					'std' => 'none',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
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
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Loader", "movedo-extension" ),
					"param_name" => "item_spinner",
					"description" => esc_html__( "If selected, this will enable a graphic spinner before load.", "movedo-extension" ),
					"value" => array( esc_html__( "Enable Loader.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "movedo-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "movedo-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "movedo-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Filter", "movedo-extension" ),
					"param_name" => "product_filter",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "movedo-extension" ) . " " . esc_html__( "Enable product Filter ( Only for All or Multiple Categories )", "movedo-extension" ),
					"dependency" => array( 'element' => "product_mode", 'value' => array( 'grid' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order By", "movedo-extension" ),
					"param_name" => "filter_order_by",
					"value" => array(
						esc_html__( "Default ( Unordered )", "movedo-extension" ) => '',
						esc_html__( "ID", "movedo-extension" ) => 'id',
						esc_html__( "Slug", "movedo-extension" ) => 'slug',
						esc_html__( "Title", "movedo-extension" ) => 'title',
					),
					"description" => '',
					"dependency" => array( 'element' => "product_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order", "movedo-extension" ),
					"param_name" => "filter_order",
					"value" => array(
						esc_html__( "Ascending", "movedo-extension" ) => 'ASC',
						esc_html__( "Descending", "movedo-extension" ) => 'DESC',
					),
					"dependency" => array( 'element' => "product_filter", 'value' => array( 'yes' ) ),
					"description" => '',
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Style", "movedo-extension" ),
					"param_name" => "filter_style",
					"value" => array(
						esc_html__( "Simple", "movedo-extension" ) => 'simple',
						esc_html__( "Button", "movedo-extension" ) => 'button',
						esc_html__( "Classic", "movedo-extension" ) => 'classic',

					),
					"dependency" => array( 'element' => "product_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "movedo-extension" ),
					"param_name" => "product_filter_align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "product_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
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
					"heading" => __("Product Categories", "movedo-extension" ),
					"param_name" => "categories",
					"value" => movedo_ext_vce_get_product_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					"admin_label" => true,
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
	vc_lean_map( 'movedo_products', 'movedo_ext_vce_products_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_products_shortcode_params( 'movedo_products' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
