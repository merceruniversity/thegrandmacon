<?php
/**
 * Content Slider Shortcode
 */

if( !function_exists( 'movedo_ext_vce_content_slider_shortcode' ) ) {

	function movedo_ext_vce_content_slider_shortcode( $atts, $content ) {

		$output = $el_class = $data_string = $auto_excerpt = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'portfolio_categories' => '',
					'product_categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'post_type' => 'post',
					'parallax' => 'yes',
					'image_mode' => 'landscape',
					'heading_tag' => 'h3',
					'heading' => 'h5',
					'custom_font_family' => '',
					'read_more_title' => 'Read More',
					'slideshow_speed' => '3500',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'auto_play' => 'yes',
					'auto_height' => 'no',
					'hide_author' => '',
					'hide_date' => '',
					'hide_like' => '',
					'posts_per_page' => '4',
					'order_by' => 'date',
					'order' => 'DESC',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );


		$post_type_class = '';
		if ( 'portfolio' == $post_type ) {
			$post_type_class = 'grve-portfolio-slider';
		} elseif ( 'product' == $post_type ) {
			$post_type_class = 'grve-product-slider';
		} else {
			$post_type_class = 'grve-blog-slider';
		}

		$content_slider_classes = array( 'grve-element', 'grve-slider', 'grve-content-slider', 'grve-layout-2', 'grve-paraller-wrapper' );
		if ( !empty ( $el_class ) ) {
			$content_slider_classes[] = $el_class;
		}
		$content_slider_classes[] = $post_type_class;
		$content_slider_class_string = implode( ' ', $content_slider_classes );


		$exclude_ids = array();
		if( !empty( $exclude_posts ) ){
			$exclude_ids = explode( ',', $exclude_posts );
		}
		$include_ids = array();
		if( !empty( $include_posts ) ){
			$include_ids = explode( ',', $include_posts );
		}

		if ( 'portfolio' == $post_type ) {

			$portfolio_cat = "";
			$portfolio_category_ids = array();

			if( ! empty( $portfolio_categories ) ) {
				$portfolio_category_ids = explode( ",", $portfolio_categories );
				foreach ( $portfolio_category_ids as $category_id ) {
					$category_term = get_term( $category_id, 'portfolio_category' );
					if ( isset( $category_term) ) {
						$portfolio_cat = $portfolio_cat.$category_term->slug . ', ';
					}
				}
			}

			if( !empty( $include_posts ) ){
				$args = array(
					'post_type' => 'portfolio',
					'post_status'=>'publish',
					'paged' => 1,
					'post__in' => $include_ids,
					'posts_per_page' => $posts_per_page,
					'orderby' => $order_by,
					'order' => $order,
				);
			} else {
				$args = array(
					'post_type' => 'portfolio',
					'post_status'=>'publish',
					'paged' => 1,
					'portfolio_category' => $portfolio_cat,
					'posts_per_page' => $posts_per_page,
					'post__not_in' => $exclude_ids,
					'orderby' => $order_by,
					'order' => $order,
				);
			}

		} elseif ( 'product' == $post_type ) {
			$product_cat = "";
			$product_category_ids = array();

			if( ! empty( $product_categories ) ) {
				$product_category_ids = explode( ",", $product_categories );
				foreach ( $product_category_ids as $category_id ) {
					$category_term = get_term( $category_id, 'product_cat' );
					if ( isset( $category_term) ) {
						$product_cat = $product_cat.$category_term->slug . ', ';
					}
				}
			}

			if( !empty( $include_posts ) ){
				$args = array(
					'post_type' => 'product',
					'post_status'=>'publish',
					'posts_per_page' => $posts_per_page,
					'post__in' => $include_ids,
					'paged' => 1,
					'orderby' => $order_by,
					'order' => $order,
				);
			} else {
				$args = array(
					'post_type' => 'product',
					'post_status'=>'publish',
					'posts_per_page' => $posts_per_page,
					'post__not_in' => $exclude_ids,
					'product_cat' => $product_cat,
					'paged' => 1,
					'orderby' => $order_by,
					'order' => $order,
				);
			}
		} else {
			if( !empty( $include_posts ) ){
				$args = array(
					'post_type' => 'post',
					'post_status'=>'publish',
					'posts_per_page' => $posts_per_page,
					'post__in' => $include_ids,
					'paged' => 1,
					'ignore_sticky_posts' => 1,
					'orderby' => $order_by,
					'order' => $order,
				);
			} else {
				$args = array(
					'post_type' => 'post',
					'post_status'=>'publish',
					'posts_per_page' => $posts_per_page,
					'cat' => $categories,
					'post__not_in' => $exclude_ids,
					'paged' => 1,
					'ignore_sticky_posts' => 1,
					'orderby' => $order_by,
					'order' => $order,
				);
			}
		}

		$image_mode_size = movedo_ext_vce_get_image_size( $image_mode );

		$wrapper_attributes = array();
		$wrapper_attributes[] = 'class="grve-slider-element grve-add-counter grve-carousel-element"';
		$wrapper_attributes[] = 'data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
		$wrapper_attributes[] = 'data-slider-pause="' . esc_attr( $pause_hover ) . '"';
		$wrapper_attributes[] = 'data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
		$wrapper_attributes[] = 'data-slider-autoheight="' . esc_attr( $auto_height ) . '"';

		$image_html = movedo_ext_vce_get_fallback_image( $image_mode_size );

		$parallax_class = '';
		if ( 'yes' == $parallax ) {
			$parallax_class = 'grve-paraller';
		}

		$title_classes = array( 'grve-title', 'grve-heading-color' );
		$title_classes[]  = 'grve-' . $heading;
		if ( !empty( $custom_font_family ) ) {
			$title_classes[]  = 'grve-' . $custom_font_family;
		}
		$title_class_string = implode( ' ', $title_classes );

		$query = new WP_Query( $args );

		ob_start();

		if ( $query->have_posts() ) :

?>
		<div class="<?php echo esc_attr( $content_slider_class_string ); ?>" style="<?php echo $style; ?>">
			<div class="grve-element grve-carousel-wrapper">
				<?php echo movedo_ext_vce_element_navigation( $navigation_type, $navigation_color ); ?>
				<div <?php echo implode( ' ', $wrapper_attributes ); ?>>

<?php
		while ( $query->have_posts() ) : $query->the_post();
			$post_id = get_the_ID();
?>
					<div class="grve-slider-item">
						<figure>
							<div class="grve-media">
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail( $image_mode_size ); ?>
								<?php } else { ?>
									<?php echo $image_html; ?>
								<?php } ?>
							</div>
						</figure>
						<div class="grve-slider-content grve-box-item grve-bg-white <?php echo esc_attr( $parallax_class ); ?>" data-limit="1x">
							<?php the_title( '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">', '</' . tag_escape( $heading_tag ) . '>' ); ?>
							<?php if( 'post' == $post_type ) { ?>

									<ul class="grve-post-meta">
									<?php if ( 'yes' != $hide_author ) { ?>
											<li class="grve-post-author"><?php the_author(); ?></li>
									<?php } ?>
									<?php if ( 'yes' != $hide_date ) { ?>
										<?php echo movedo_ext_vce_print_list_date(); ?>
									<?php } ?>
									<?php
										if( 'yes' != $hide_like && function_exists( 'movedo_grve_social_like' ) ) {
											movedo_grve_social_like( $post_type );
										}
									?>
									</ul>
									<div class="grve-description"><?php echo movedo_ext_vce_excerpt( '15' ); ?></div>
							<?php } else { ?>
								<div class="grve-description"><?php echo movedo_ext_vce_excerpt( '15' ); ?></div>
							<?php } ?>
							<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="grve-read-more grve-link-text"><?php echo esc_html( $read_more_title ); ?></a>
						</div>
					</div>
<?php
		endwhile;
?>
				</div>
			</div>
		</div>
<?php
		else :
		endif;

		wp_reset_postdata();

		return ob_get_clean();


	}
	add_shortcode( 'movedo_content_slider', 'movedo_ext_vce_content_slider_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_content_slider_shortcode_params' ) ) {
	function movedo_ext_vce_content_slider_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Slider with Content", "movedo-extension" ),
			"description" => esc_html__( "Display a slider with content", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-content-slider",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Post Type", "movedo-extension" ),
					"param_name" => "post_type",
					'value' => array(
						esc_html__( 'Post', 'movedo-extension' ) => 'post',
						esc_html__( 'Portfolio', 'movedo-extension' ) => 'portfolio',
						esc_html__( 'Product', 'movedo-extension' ) => 'product',
					),
					"description" => esc_html__( "Select the post type.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Number of Posts", "movedo-extension" ),
					"param_name" => "posts_per_page",
					"value" => array( '2','3','4','5','6','7','8' ),
					"description" => esc_html__( "Enter how many posts you want to display.", "movedo-extension" ),
					"std" => "4",
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h5" ),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
					),
					"std" => "landscape",
					"description" => esc_html__( "Select your Image size.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Title", "movedo-extension" ),
					"param_name" => "read_more_title",
					"value" => "",
					"description" => esc_html__( "Enter the title for your link.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Parallax", "movedo-extension" ),
					"param_name" => "parallax",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
				),
				movedo_ext_vce_add_slideshow_speed(),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "movedo-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, slider will be paused on hover", "movedo-extension" ) => 'yes' ),
				),
				movedo_ext_vce_add_auto_height(),
				movedo_ext_vce_add_navigation_type(),
				movedo_ext_vce_add_navigation_color(),
				movedo_ext_vce_add_order_by(),
				movedo_ext_vce_add_order(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Author", "movedo-extension" ),
					"param_name" => "hide_author",
					"description" => esc_html__( "If selected, blog overview will not show author.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Author.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "post_type", 'value' => array( 'post' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Date", "movedo-extension" ),
					"param_name" => "hide_date",
					"description" => esc_html__( "If selected, blog overview will not show date.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Date.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "post_type", 'value' => array( 'post' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Like", "movedo-extension" ),
					"param_name" => "hide_like",
					"description" => esc_html__( "If selected, blog overview will not show like.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Like.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "post_type", 'value' => array( 'post' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Exclude Posts", "movedo-extension" ),
					"param_name" => "exclude_posts",
					"value" => '',
					"description" => esc_html__( "Type the post ids you want to exclude separated by comma ( , ).", "movedo-extension" ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "movedo_ext_multi_checkbox",
					"heading" => esc_html__( "Categories", "movedo-extension" ),
					"param_name" => "categories",
					"value" => movedo_ext_vce_get_post_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					"dependency" => array( 'element' => "post_type", 'value' => array( 'post' ) ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "movedo_ext_multi_checkbox",
					"heading" => __("Portfolio Categories", "movedo-extension" ),
					"param_name" => "portfolio_categories",
					"value" => movedo_ext_vce_get_portfolio_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					"dependency" => array( 'element' => "post_type", 'value' => array( 'portfolio' ) ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "movedo_ext_multi_checkbox",
					"heading" => __("Product Categories", "movedo-extension" ),
					"param_name" => "product_categories",
					"value" => movedo_ext_vce_get_product_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					"dependency" => array( 'element' => "post_type", 'value' => array( 'product' ) ),
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
	vc_lean_map( 'movedo_content_slider', 'movedo_ext_vce_content_slider_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_content_slider_shortcode_params( 'movedo_content_slider' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
