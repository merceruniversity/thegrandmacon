<?php
/**
 * Blog Shortcode
 */

if( !function_exists( 'movedo_ext_vce_blog_shortcode' ) ) {

	function movedo_ext_vce_blog_shortcode( $atts, $content ) {

		$output = $allow_filter = $el_class = $data_string = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'text_style' => 'none',
					'align' => 'left',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'custom_font_family' => '',
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'blog_mode' => 'blog-large',
					'blog_shadow_style' => 'shadow-mode',
					'carousel_layout' => 'layout-1',
					'blog_media_area' => 'yes',
					'blog_image_mode' => 'landscape-large-wide',
					'blog_grid_image_mode' => 'landscape',
					'blog_masonry_image_mode' => 'medium',
					'carousel_image_mode' => 'landscape',
					'post_title_heading_tag' => 'h2',
					'post_title_heading' => 'auto',
					'carousel_style' => '1',
					'carousel_bg_color' => 'black',
					'carousel_bg_opacity' => '40',
					'blog_image_prio' => '',
					'columns_large_screen' => '3',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'auto_excerpt' => '',
					'excerpt_length' => '55',
					'excerpt_more' => '',
					'hide_author' => '',
					'hide_date' => '',
					'hide_comments' => '',
					'hide_like' => '',
					'hide_excerpt' => '',
					'posts_per_page' => '10',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
					'blog_filter' => '',
					'filter_style' => 'simple',
					'filter_shape' => 'square',
					'filter_color' => 'primary-1',
					'blog_filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
					'item_spinner' => 'no',
					'items_per_page' => '4',
					'items_tablet_landscape' => '3',
					'items_tablet_portrait' => '3',
					'items_mobile' => '1',
					'slideshow_speed' => '3000',
					'auto_play' => 'yes',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'carousel_pagination' => 'no',
					'carousel_pagination_speed' => '400',
					'animation' => '',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$blog_classes = array( 'grve-element' );


		switch( $blog_mode ) {

			case 'masonry':
				$data_string .= 'data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry" data-spinner="' . esc_attr( $item_spinner ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				break;
			case 'grid':
				$data_string .= 'data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows" data-spinner="' . esc_attr( $item_spinner ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				break;
			case 'carousel':
				$blog_classes[] = 'grve-carousel';
				$blog_classes[] = 'grve-' . $carousel_layout;
				$blog_classes[] = 'grve-carousel-style-' . $carousel_style ;
				if ( 'yes' == $item_gutter ) {
					$blog_classes[] = 'grve-with-gap';
				}
				break;
			default:
				$data_string .= '';
				break;
		}

		array_push( $blog_classes, movedo_ext_vce_get_blog_class( $blog_mode ) );
		if ( !empty ( $el_class ) ) {
			array_push( $blog_classes, $el_class);
		}

		if ( 'shadow-mode' == $blog_shadow_style && ( 'masonry' == $blog_mode || 'grid' == $blog_mode ) ) {
			array_push( $blog_classes, 'grve-with-shadow' );
		}

		$blog_class_string = implode( ' ', $blog_classes );

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
				'post_type' => 'post',
				'post_status'=>'publish',
				'posts_per_page' => $posts_per_page,
				'post__in' => $include_ids,
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'orderby' => $order_by,
				'order' => $order,
			);
			$blog_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'post',
				'post_status'=>'publish',
				'posts_per_page' => $posts_per_page,
				'post__not_in' => $exclude_ids,
				'cat' => $categories,
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$query = new WP_Query( $args );

		$blog_category_ids = array();

		if( ! empty( $categories ) ) {
			$blog_category_ids = explode( ",", $categories );
		}
		if ( 'carousel' != $blog_mode ) {
			$allow_filter = 'yes';
		}
		$category_prefix = '.category-';

		$image_atts = array();

		ob_start();

		if ( $query->have_posts() ) :

?>
		<div class="<?php echo esc_attr( $blog_class_string ); ?>" style="<?php echo $style; ?>" <?php echo $data_string; ?>>
<?php
		//Category Filter
		if ( 'yes' == $blog_filter && 'yes' == $allow_filter ) {

			$filter_classes = array( 'grve-filter' );

			array_push( $filter_classes, 'grve-filter-style-' . $filter_style );
			array_push( $filter_classes, 'grve-align-' . $blog_filter_align);
			array_push( $filter_classes, 'grve-link-text');

			if ( 'button' == $filter_style ) {
				array_push( $filter_classes, 'grve-link-text');
				array_push( $filter_classes, 'grve-filter-shape-' . $filter_shape );
				array_push( $filter_classes, 'grve-filter-color-' . $filter_color );
			}

			$filter_class_string = implode( ' ', $filter_classes );

			$category_filter_list = array();
			$category_filter_array = array();
			$all_string =  apply_filters( 'movedo_grve_vce_blog_string_all_categories', esc_html__( 'All', 'movedo-extension' ) );
			$category_filter_string = '<li data-filter="*" class="selected"><span>' . $all_string . '</span></li>';
			$category_filter_add = false;
			while ( $query->have_posts() ) : $query->the_post();

				if ( $blog_categories = get_the_terms( get_the_ID(), 'category' ) ) {

					foreach($blog_categories as $category_term){
						$category_filter_add = false;
						if ( !in_array($category_term->term_id, $category_filter_list) ) {
							if( ! empty( $blog_category_ids ) ) {
								if ( in_array($category_term->term_id, $blog_category_ids) ) {
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

		$image_size = 'movedo-grve-small-rect-horizontal';

		if ( 'grid' == $blog_mode || 'blog-small' == $blog_mode ) {
			$blog_image_mode = $blog_grid_image_mode;
		} else if ( 'masonry' == $blog_mode ) {
			$blog_image_mode = $blog_masonry_image_mode;
		}

		if ( 'blog-large' == $blog_mode || 'blog-small' == $blog_mode ) {
?>
			<div class="grve-standard-container">
<?php
		} else if ( 'carousel' == $blog_mode ) {
			$disable_pagination = 'yes';
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

			if( 'square' == $carousel_image_mode ) {
				$image_size = 'movedo-grve-small-square';
			} elseif( 'portrait' == $carousel_image_mode ) {
				$image_size = 'movedo-grve-small-rect-vertical';
			} else {
				$image_size = 'movedo-grve-small-rect-horizontal';
			}

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

			<div class="grve-blog grve-blog-carousel grve-carousel-element"<?php echo $data_string; ?>>
<?php
		} else {
?>
			<div class="grve-isotope-container">
<?php
		}

		$movedo_ext_isotope_start = $movedo_ext_isotope_end = '';
		if ( 'blog-large' != $blog_mode && 'blog-small' != $blog_mode ) {
			if ( !empty( $animation ) ) {
				$movedo_ext_isotope_start = '<div class="grve-blog-item-inner grve-isotope-item-inner ' . esc_attr( $animation ) . '">';
			} else {
				$movedo_ext_isotope_start = '<div class="grve-blog-item-inner grve-isotope-item-inner">';
			}
			$movedo_ext_isotope_end = '</div>';
		} else {
			if ( !empty( $animation ) ) {
				$movedo_ext_isotope_start = '<div class="grve-blog-item-inner grve-isotope-item-inner grve-animated-item ' . esc_attr( $animation ) . '" data-delay="200">';
			} else {
				$movedo_ext_isotope_start = '<div class="grve-blog-item-inner grve-isotope-item-inner">';
			}
			$movedo_ext_isotope_end = '</div>';
		}


		while ( $query->have_posts() ) : $query->the_post();

			$post_format = get_post_format();
			$bg_post_mode = movedo_ext_vce_is_post_bg( $blog_mode, $post_format );

			if ( 'link' == $post_format || 'quote' == $post_format ) {
				$movedo_ext_post_class = movedo_ext_vce_get_post_class( $blog_mode, 'grve-style-2' );
			} else {
				if ( $bg_post_mode ) {
					$movedo_ext_post_class = movedo_ext_vce_get_post_class( $blog_mode, 'grve-style-2' );
				} else {
					$movedo_ext_post_class = movedo_ext_vce_get_post_class( $blog_mode );
				}
			}

			if ( 'carousel' == $blog_mode ) {

				if ( '1' == $carousel_style ) {


?>
				<div class="grve-carousel-item">
					<article <?php post_class( 'grve-post-item' ); ?> itemscope itemType="http://schema.org/BlogPosting">
						<?php
							if ( 'yes' == $blog_media_area ) {
								movedo_ext_vce_print_carousel_media( $carousel_image_mode, $image_atts );
							}
						?>
						<div class="grve-post-content">
							<ul class="grve-post-meta">
								<?php
									if ( 'yes' != $hide_author ) {
										movedo_ext_vce_print_post_author_by( $blog_mode );
									}
									if ( 'yes' != $hide_date ) {
										movedo_ext_vce_print_post_date( 'list' );
									}
									if ( 'yes' != $hide_comments ) {
										movedo_ext_vce_print_post_comments();
									}
									if( 'yes' != $hide_like && function_exists( 'movedo_grve_print_like_counter' ) ) {
										movedo_grve_print_like_counter();
									}
								?>
							</ul>
							<?php movedo_ext_vce_print_post_title( $blog_mode, $post_format, $post_title_heading_tag, $post_title_heading ); ?>
							<?php movedo_ext_vce_print_structured_data(); ?>
							<?php
								if ( 'yes' != $hide_excerpt ) {
									movedo_ext_vce_print_post_excerpt( $blog_mode, $post_format, $auto_excerpt, $excerpt_length, $excerpt_more );
								}
							?>
						</div>
					</article>
				</div>
<?php
				} else {
?>
				<div class="grve-carousel-item">
					<article <?php post_class( 'grve-post-item' ); ?> itemscope itemType="http://schema.org/BlogPosting">
						<?php
							$bg_options = array(
								'bg_color' => $carousel_bg_color,
								'bg_opacity' => $carousel_bg_opacity,
								'mode' => 'image',
								'image_size' => $image_size,
							);
							movedo_ext_vce_post_bg_image_container( $bg_options );
						?>
						<div class="grve-post-content-wrapper">
							<div class="grve-post-content grve-align-center">
								<div class="grve-post-container">
									<?php if ( 'yes' != $hide_date ) { ?>
									<div class="grve-post-date grve-text-light">
										<?php movedo_ext_vce_print_post_date(); ?>
									</div>
									<?php } ?>
									<?php movedo_ext_vce_print_post_title( $blog_mode, $post_format, $post_title_heading_tag, $post_title_heading ); ?>
									<?php movedo_ext_vce_print_structured_data(); ?>
									<ul class="grve-post-meta grve-text-light">
										<?php
											if ( 'yes' != $hide_author ) {
												movedo_ext_vce_print_post_author_by( $blog_mode );
											}
											if ( 'yes' != $hide_comments ) {
												movedo_ext_vce_print_post_comments();
											}
											if( 'yes' != $hide_like && function_exists( 'movedo_grve_print_like_counter' ) ) {
												movedo_grve_print_like_counter();
											}
										?>
									</ul>
								</div>
							</div>
						</div>
					</article>
				</div>
<?php
				}
			} else {
?>
			<article <?php post_class( $movedo_ext_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
				<?php echo $movedo_ext_isotope_start; ?>

					<?php if ( 'link' != $post_format && 'quote' != $post_format ) { ?>
						<?php
							if ( $bg_post_mode ) {
								movedo_ext_vce_print_post_bg_media( $blog_mode, $post_format );
							} else {
								if ( 'yes' == $blog_media_area ) {
									movedo_ext_vce_print_post_feature_media( $blog_mode, $post_format, $blog_image_mode, $blog_image_prio, $image_atts );
								}
							}
						?>
						<div class="grve-post-content-wrapper">
							<div class="grve-post-content">
								<div class="grve-post-header">
									<?php if ( $bg_post_mode &&  'video' == $post_format ) { ?>
									<?php movedo_ext_vce_print_post_video_popup(); ?>
									<?php } ?>
									<?php movedo_ext_vce_print_structured_data(); ?>
									<?php if ( 'yes' != $hide_date || 'yes' != $hide_author || 'yes' != $hide_comments || 'yes' != $hide_like ) { ?>
										<ul class="grve-post-meta">
										<?php
											if ( 'yes' != $hide_author ) {
												movedo_ext_vce_print_post_author_by( $blog_mode );
											}
											if ( 'yes' != $hide_date ) {
												movedo_ext_vce_print_post_date( 'list' );
											}
											if ( 'yes' != $hide_comments ) {
												movedo_ext_vce_print_post_comments();
											}
											if( 'yes' != $hide_like && function_exists( 'movedo_grve_print_like_counter' ) ) {
												movedo_grve_print_like_counter();
											}
										?>
										</ul>
									<?php } ?>
									<?php movedo_ext_vce_print_post_title( $blog_mode, $post_format, $post_title_heading_tag, $post_title_heading ); ?>
								</div>
								<?php movedo_ext_vce_print_post_excerpt( $blog_mode, $post_format, $auto_excerpt, $excerpt_length, $excerpt_more ); ?>
							</div>
						</div>
					<?php
					 } else {
				 	?>
						<?php movedo_ext_vce_print_post_loop( $blog_mode, $post_format, $post_title_heading_tag, $post_title_heading, $auto_excerpt, $excerpt_length, $excerpt_more ); ?>
						<?php movedo_ext_vce_print_structured_data(); ?>
					<?php }?>

				<?php echo $movedo_ext_isotope_end; ?>
			</article>

<?php
			}

		endwhile;
			if ( 'carousel' == $blog_mode ) {
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
	add_shortcode( 'movedo_blog', 'movedo_ext_vce_blog_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_blog_shortcode_params' ) ) {
	function movedo_ext_vce_blog_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Blog", "movedo-extension" ),
			"description" => esc_html__( "Display a Blog element in multiple styles", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-blog",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Blog Mode", "movedo-extension" ),
					"param_name" => "blog_mode",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Large Media', 'movedo-extension' ) => 'blog-large',
						esc_html__( 'Small Media', 'movedo-extension' ) => 'blog-small',
						esc_html__( 'Masonry' , 'movedo-extension' ) => 'masonry',
						esc_html__( 'Grid' , 'movedo-extension' ) => 'grid',
						esc_html__( 'Carousel' , 'movedo-extension' ) => 'carousel',
					),
					"description" => esc_html__( "Select your Blog Mode.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Media Area Visibility", "movedo-extension" ),
					"param_name" => "blog_media_area",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"std" => "yes",
					"description" => esc_html__( "Select if you want to enable/disable media area", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "blog_image_mode",
					'value' => array(
						esc_html__( 'Landscape Large Wide Crop', 'movedo-extension' ) => 'landscape-large-wide',
						esc_html__( 'Landscape Medium Crop', 'movedo-extension' ) => 'landscape-medium',
						esc_html__( 'Resize ( Extra Extra Large )' , 'movedo-extension' ) => 'extra-extra-large',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => '',
					"description" => esc_html__( "Select your Blog Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grid Image Size", "movedo-extension" ),
					"param_name" => "blog_grid_image_mode",
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
					"description" => esc_html__( "Select your Blog Grid Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-small', 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Masonry Image Size", "movedo-extension" ),
					"param_name" => "blog_masonry_image_mode",
					'value' => array(
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => 'medium',
					"description" => esc_html__( "Select your Blog Masonry Image Size.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'masonry' ) ),
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
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Featured Image Priority", "movedo-extension" ),
					"param_name" => "blog_image_prio",
					"description" => esc_html__( "Featured image is displayed instead of media element", "movedo-extension" ),
					"value" => array( esc_html__( "Featured Image Priority", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Large Screen Columns", "movedo-extension" ),
					"param_name" => "columns_large_screen",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Blog Columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "movedo-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Blog Columns.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "movedo-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Auto excerpt", "movedo-extension" ),
					"param_name" => "auto_excerpt",
					"description" => esc_html__( "Adds automatic excerpt to all posts in Large Media style. If auto excerpt is not selected, blog will show all content, a desired 'cut-off' point can be inserted in each post with more quicktag.", "movedo-extension" ),
					"value" => array( esc_html__( "Activate auto excerpt.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gutter between items", "movedo-extension" ),
					"param_name" => "item_gutter",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"description" => esc_html__( "Add gutter among items.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry', 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "movedo-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => 'textfield',
					"heading" => esc_html__( "Excerpt length", "movedo-extension" ),
					"param_name" => "excerpt_length",
					"description" => esc_html__( "Type how many words you want to display in your post excerpts.", "movedo-extension" ),
					"value" => '55',
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry', 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Read more", "movedo-extension" ),
					"param_name" => "excerpt_more",
					"description" => esc_html__( "Adds a read more button after the excerpt or more quicktag", "movedo-extension" ),
					"value" => array( esc_html__( "Add more button", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Posts per Page", "movedo-extension" ),
					"param_name" => "posts_per_page",
					"value" => "10",
					"description" => esc_html__( "Enter how many posts per page you want to display.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "movedo-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Tablet Landscape", "movedo-extension" ),
					"param_name" => "items_tablet_landscape",
					"value" => array( '1', '2', '3', '4' ),
					"std" => 3,
					"description" => esc_html__( "Select number of items on tablet devices, landscape orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Tablet Portrait", "movedo-extension" ),
					"param_name" => "items_tablet_portrait",
					"value" => array( '1', '2', '3', '4'  ),
					"std" => 3,
					"description" => esc_html__( "Select number of items on tablet devices, portrait orientation.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items Mobile", "movedo-extension" ),
					"param_name" => "items_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select number of items on mobile devices.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
					"std" => "",
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				//Navigation
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Layout", "movedo-extension" ),
					"param_name" => "carousel_layout",
					"value" => array(
						esc_html__( "Classic", "movedo-extension" ) => 'layout-1',
						esc_html__( "Top Navigation with Title/Text", "movedo-extension" ) => 'layout-2',
					),
					"description" => 'Select your layout for Carousel Element',
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Carousel Title", "movedo-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your carousel title here.", "movedo-extension" ),
					"save_always" => true,
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Title Tag", "movedo-extension" ),
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
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Title Size/Typography", "movedo-extension" ),
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
					"description" => esc_html__( "Carousel Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
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
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Carousel Text", "movedo-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Type your text.", "movedo-extension" ),
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Text Style", "movedo-extension" ),
					"param_name" => "text_style",
					"value" => array(
						esc_html__( "None", "movedo-extension" ) => '',
						esc_html__( "Leader", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle", "movedo-extension" ) => 'subtitle',
					),
					"description" => 'Select your text style',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Alignment", "movedo-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "carousel_layout", 'value' => array( 'layout-2' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
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
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
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
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
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
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Carousel Pagination Speed", "movedo-extension" ),
					"param_name" => "carousel_pagination_speed",
					"value" => '400',
					"description" => esc_html__( "Pagination Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "movedo-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "movedo-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "movedo-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Navigation", "movedo-extension" ),
				),
				//Titles & Styles
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Blog Style", "movedo-extension" ),
					"param_name" => "blog_shadow_style",
					'value' => array(
						esc_html__( 'With Shadow', 'movedo-extension' ) => 'shadow-mode',
						esc_html__( 'Without Shadow', 'movedo-extension' ) => 'no-shadow-mode',
					),
					"description" => esc_html__( "Select your Blog Style.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Post Title Tag", "movedo-extension" ),
					"param_name" => "post_title_heading_tag",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "div", "movedo-extension" ) => 'div',
					),
					"description" => esc_html__( "Post Title Tag for SEO", "movedo-extension" ),
					"std" => 'h3',
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Post Title Size/Typography", "movedo-extension" ),
					"param_name" => "post_title_heading",
					"value" => array(
						esc_html__( "Auto", "movedo-extension" ) => 'auto',
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
					"description" => esc_html__( "Post Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Style", "movedo-extension" ),
					"param_name" => "carousel_style",
					'value' => array(
						esc_html__( 'Content below image', 'movedo-extension' ) => '1',
						esc_html__( 'Content inside image', 'movedo-extension' ) => '2',
					),
					'std' => '1',
					"description" => esc_html__( "Select your Carousel Style.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'carousel' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Excerpt", "movedo-extension" ),
					"param_name" => "hide_excerpt",
					"description" => esc_html__( "If selected, blog overview will not show excerpt.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Excerpt.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "carousel_style", 'value' => array( '1' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Background Color", "movedo-extension" ),
					"param_name" => "carousel_bg_color",
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
					),
					'std' => 'black',
					"description" => esc_html__( "This affects the Background of the item.", "movedo-extension" ),
					"dependency" => array( 'element' => "carousel_style", 'value' => array( '2' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Background Opacity", "movedo-extension" ),
					"param_name" => "carousel_bg_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 40,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"dependency" => array( 'element' => "carousel_style", 'value' => array( '2' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Loader", "movedo-extension" ),
					"param_name" => "item_spinner",
					"description" => esc_html__( "If selected, this will enable a graphic spinner before load.", "movedo-extension" ),
					"value" => array( esc_html__( "Enable Loader.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'grid', 'masonry' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "movedo-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "movedo-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "movedo-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Author", "movedo-extension" ),
					"param_name" => "hide_author",
					"description" => esc_html__( "If selected, blog overview will not show author.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Author.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Date", "movedo-extension" ),
					"param_name" => "hide_date",
					"description" => esc_html__( "If selected, blog overview will not show date.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Date.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Comments", "movedo-extension" ),
					"param_name" => "hide_comments",
					"description" => esc_html__( "If selected, blog overview will not show comments.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Comments.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Like", "movedo-extension" ),
					"param_name" => "hide_like",
					"description" => esc_html__( "If selected, blog overview will not show like.", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Like.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Filter", "movedo-extension" ),
					"param_name" => "blog_filter",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "movedo-extension" ) . " " . esc_html__( "Enable Blog Filter ( Only for All or Multiple Categories )", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_mode", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
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
					"dependency" => array( 'element' => "blog_filter", 'value' => array( 'yes' ) ),
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
					"dependency" => array( 'element' => "blog_filter", 'value' => array( 'yes' ) ),
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
					"dependency" => array( 'element' => "blog_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Shape", "movedo-extension" ),
					"param_name" => "filter_shape",
					"value" => array(
						esc_html__( "Square", "movedo-extension" ) => 'square',
						esc_html__( "Round", "movedo-extension" ) => 'round',
						esc_html__( "Extra Round", "movedo-extension" ) => 'extra-round',
					),
					"dependency" => array( 'element' => "filter_style", 'value' => array( 'button' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Color", "movedo-extension" ),
					"param_name" => "filter_color",
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
					"dependency" => array( 'element' => "filter_style", 'value' => array( 'button' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),

				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "movedo-extension" ),
					"param_name" => "blog_filter_align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "blog_filter", 'value' => array( 'yes' ) ),
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
					"heading" => esc_html__("Categories", "movedo-extension" ),
					"param_name" => "categories",
					"value" => movedo_ext_vce_get_post_categories(),
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
				// array(
					// "type" => "movedo_ext_taxonomy_tree",
					// "heading" => __("Categories", "movedo-extension" ),
					// "param_name" => "categories",
					// "value" => '',
					// "taxonomy" => 'category',
					// "description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					// "group" => esc_html__( "Categories", "movedo-extension" ),
				// ),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_blog', 'movedo_ext_vce_blog_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_blog_shortcode_params( 'movedo_blog' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
