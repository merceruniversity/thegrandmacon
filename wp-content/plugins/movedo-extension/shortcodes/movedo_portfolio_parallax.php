<?php
/**
 * Portfolio Parallax Shortcode
 */

if( !function_exists( 'movedo_ext_vce_portfolio_parallax_shortcode' ) ) {

	function movedo_ext_vce_portfolio_parallax_shortcode( $atts, $content ) {

		$output = $el_class = $data_string = $auto_excerpt = '';

		extract(
			shortcode_atts(
				array(
					'portfolio_categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'image_mode' => 'landscape-medium',
					'portfolio_link_type' => 'item',
					'heading_tag' => 'h3',
					'heading' => 'h5',
					'custom_font_family' => '',
					'read_more_title' => 'Read More',
					'content_bg' => 'white',
					'disable_pagination' => '',
					'hide_like' => '',
					'posts_per_page' => '12',
					'order_by' => 'date',
					'order' => 'DESC',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$portfolio_parallax_classes = array( 'grve-element', 'grve-portfolio-movedo-style' );
		if ( !empty ( $el_class ) ) {
			$portfolio_parallax_classes[] = $el_class;
		}
		if ( 'loop' == $image_mode ) {
			$portfolio_parallax_classes[] = 'grve-loop-mode';
		}
		$portfolio_parallax_class_string = implode( ' ', $portfolio_parallax_classes );

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
				'post_type' => 'portfolio',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $posts_per_page,
				'orderby' => $order_by,
				'order' => $order,
			);
			$portfolio_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'portfolio',
				'post_status'=>'publish',
				'paged' => $paged,
				'portfolio_category' => $portfolio_cat,
				'posts_per_page' => $posts_per_page,
				'post__not_in' => $exclude_ids,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$image_mode_size = movedo_ext_vce_get_image_size( $image_mode );
		$image_html = movedo_ext_vce_get_fallback_image( $image_mode_size );

		$query = new WP_Query( $args );

		ob_start();

		if ( $query->have_posts() ) :

?>
		<div class="<?php echo esc_attr( $portfolio_parallax_class_string ); ?>" style="<?php echo $style; ?>">

<?php
		$index = 0;
		while ( $query->have_posts() ) : $query->the_post();

			$post_id = get_the_ID();

			if ( 'loop' == $image_mode ) {
				$index++;
				$image_mode_size = movedo_ext_vce_get_image_size( 'loop', $index );
				$image_html = movedo_ext_vce_get_fallback_image( $image_mode_size );
			}

			$title_classes = array( 'grve-title', 'grve-heading-color' );
			$title_classes[]  = 'grve-' . $heading;
			if ( !empty( $custom_font_family ) ) {
				$title_classes[]  = 'grve-' . $custom_font_family;
			}
			$title_class_string = implode( ' ', $title_classes );

			$link_target = "_self";
			$link_class = "";
			if ( 'custom-link' == $portfolio_link_type ) {
				$link_mode = get_post_meta( $post_id, '_movedo_grve_portfolio_link_mode', true );
				if ( '' == $link_mode )	{
					$link_url = get_permalink( $post_id );
				} else  {
					$link_url = get_post_meta( $post_id, '_movedo_grve_portfolio_link_url', true );
					$new_window = get_post_meta( $post_id, '_movedo_grve_portfolio_link_new_window', true );
					if( !empty( $new_window ) ) {
						$link_target = '_blank';
					}
					$link_class = get_post_meta( $post_id, '_movedo_grve_portfolio_link_extra_class', true );
				}
			} else if ( 'no-link' == $portfolio_link_type ) {
				$link_url = "";
			} else {
				$link_url = get_permalink( $post_id );
			}

?>
			<div class="grve-portfolio-item grve-paraller-wrapper">
				<?php if( 'yes' != $hide_like && function_exists( 'movedo_grve_social_like' ) ) { ?>
					<?php movedo_grve_social_like( 'portfolio', 'icon'); ?>
				<?php } ?>
				<div class="grve-media grve-image-hover">
					<?php if ( !empty( $link_url ) ) { ?>
					<a class="grve-item-url <?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"></a>
					<div class="grve-bg-dark grve-hover-overlay grve-opacity-20"></div>
					<?php } ?>
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail( $image_mode_size ); ?>
					<?php } else { ?>
						<?php echo $image_html; ?>
					<?php } ?>
				</div>
				<div class="grve-content grve-box-item grve-bg-<?php echo esc_attr( $content_bg ); ?> grve-paraller" data-limit="1x">
					<?php the_title( '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">', '</' . tag_escape( $heading_tag ) . '>' ); ?>
					<div class="grve-description"><?php echo movedo_ext_vce_excerpt( '15' ); ?></div>
					<?php if ( !empty( $read_more_title ) && !empty( $link_url ) ) { ?>
					<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="grve-read-more grve-link-text  <?php echo esc_attr( $link_class ); ?>"><?php echo esc_html( $read_more_title ); ?></a>
					<?php } ?>
				</div>
			</div>
<?php
		endwhile;
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
					'prev_text'	=> '<i class="grve-icon-arrow-left"></i>',
					'next_text'	=> '<i class="grve-icon-arrow-right"></i>',
					'add_args' => false,
				 ));
				 echo '</div>';
			}
		}
?>
<?php
		else :
		endif;

		wp_reset_postdata();

		return ob_get_clean();


	}
	add_shortcode( 'movedo_portfolio_parallax', 'movedo_ext_vce_portfolio_parallax_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_portfolio_parallax_shortcode_params' ) ) {
	function movedo_ext_vce_portfolio_parallax_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Portfolio Parallax", "movedo-extension" ),
			"description" => esc_html__( "Display a parallax portfolio", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-portfolio-parallax",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Number of Posts", "movedo-extension" ),
					"param_name" => "posts_per_page",
					"value" => "12",
					"description" => esc_html__( "Enter how many posts you want to display.", "movedo-extension" ),
				),
				movedo_ext_vce_get_heading_tag( "h3" ),
				movedo_ext_vce_get_heading( "h5" ),
				movedo_ext_vce_get_custom_font_family(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Size", "movedo-extension" ),
					"param_name" => "image_mode",
					'value' => array(
						esc_html__( 'Landscape Medium Crop', 'movedo-extension' ) => 'landscape-medium',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Loop Crop', 'movedo-extension' ) => 'loop',
					),
					"description" => esc_html__( "Select your Image size.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Title", "movedo-extension" ),
					"param_name" => "read_more_title",
					"value" => "Read More",
					"description" => esc_html__( "Enter the title for your link.", "movedo-extension" ),
					"save_always" => true,
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Content Background", "movedo-extension" ),
					"param_name" => "content_bg",
					"description" => esc_html__( "Selected background color for your content.", "movedo-extension" ),
					"value" => array(
						esc_html__( "White", "movedo-extension" ) => 'white',
						esc_html__( "Black", "movedo-extension" ) => 'black',
						esc_html__( "None", "movedo-extension" ) => 'none',
					),
				),
				movedo_ext_vce_add_order_by(),
				movedo_ext_vce_add_order(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Link Type", "movedo-extension" ),
					"param_name" => "portfolio_link_type",
					'value' => array(
						esc_html__( 'Classic Portfolio' , 'movedo-extension' ) => 'item',
						esc_html__( 'Custom Link' , 'movedo-extension' ) => 'custom-link',
						esc_html__( 'No Link' , 'movedo-extension' ) => 'no-link',
					),
					"description" => esc_html__( "Select the link type of your portfolio items.", "movedo-extension" ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "movedo-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "movedo-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Like", "movedo-extension" ),
					"param_name" => "hide_like",
					"description" => esc_html__( "If selected, portfolio likes will be hidden", "movedo-extension" ),
					"value" => array( esc_html__( "Hide Like.", "movedo-extension" ) => 'yes' ),
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
					"heading" => __("Portfolio Categories", "movedo-extension" ),
					"param_name" => "portfolio_categories",
					"value" => movedo_ext_vce_get_portfolio_categories(),
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
	vc_lean_map( 'movedo_portfolio_parallax', 'movedo_ext_vce_portfolio_parallax_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_portfolio_parallax_shortcode_params( 'movedo_portfolio_parallax' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
