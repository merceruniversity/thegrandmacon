<?php
/**
 * Blog Leader Shortcode
 */

if( !function_exists( 'movedo_ext_vce_blog_leader_shortcode' ) ) {

	function movedo_ext_vce_blog_leader_shortcode( $atts, $content ) {

		$output = $el_class = $data_string = $auto_excerpt = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'blog_leader_style' => '',
					'leader_bg_color' => 'black',
					'leader_bg_opacity' => '70',
					'heading_tag' => 'h2',
					'heading' => 'auto',
					'blog_image_mode' => 'landscape',
					'excerpt_length' => '30',
					'excerpt_more' => '',
					'hide_author' => '',
					'hide_date' => '',
					'hide_comments' => '',
					'hide_like' => '',
					'posts_per_page' => '4',
					'order_by' => 'date',
					'order' => 'DESC',
					'animation' => 'grve-zoom-in',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$blog_mode = 'leader';
		$blog_image_prio = 'yes';

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$blog_classes = array( 'grve-element', 'grve-blog-leader', 'grve-layout-1' );

		if ( !empty ( $el_class ) ) {
			array_push( $blog_classes, $el_class);
		}

		if( 'movedo' == $blog_leader_style ) {
			array_push( $blog_classes, 'grve-movedo-style' );
		}
		array_push( $blog_classes, 'grve-blog-items-' . $posts_per_page );


		$blog_class_string = implode( ' ', $blog_classes );


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
				'post__not_in' => $exclude_ids,
				'cat' => $categories,
				'paged' => 1,
				'ignore_sticky_posts' => 1,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$query = new WP_Query( $args );


		ob_start();

		if ( $query->have_posts() ) :

?>
		<div class="<?php echo esc_attr( $blog_class_string ); ?>" style="<?php echo $style; ?>">
<?php

		$animation_class  = '';
		if ( !empty( $animation ) ) {
			$animation_class = 'grve-animated-item ' . esc_attr( $animation );
		}

		$index = 0;

		$total = $query->post_count;

		while ( $query->have_posts() ) : $query->the_post();


			$post_format = get_post_format();
			$bg_post_mode = movedo_ext_vce_is_post_bg( $blog_mode, $post_format );

			$index++;
			$movedo_ext_post_class = 'grve-blog-item';
			$movedo_leader_class = 'grve-post-leader';

			if( 1 == $index  ) {
				if( 'movedo' == $blog_leader_style && 'primary-1' == $leader_bg_color ) {
					$movedo_leader_class .= ' grve-with-primary-bg';
				}
				if( 1 == $total ) {
					$movedo_leader_class .= ' grve-post-leader-only';
				}
				echo '<div class="' . esc_attr( $movedo_leader_class ) . '">';
			} else if( 2 == $index ) {
				echo '<div class="grve-post-list">';
			}
?>

				<article <?php post_class( $movedo_ext_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
					<div class="grve-blog-item-inner <?php echo esc_attr( $animation_class ); ?>">

							<?php
								if( 1 == $index && 'movedo' == $blog_leader_style ) {
									$bg_options = array(
										'bg_color' => $leader_bg_color,
										'bg_opacity' => $leader_bg_opacity,
									);
									movedo_ext_vce_post_bg_image_container( $bg_options );
								} else {
									movedo_ext_vce_print_post_feature_media( $blog_mode, $post_format, $blog_image_mode, $blog_image_prio );
								}

							?>
							<div class="grve-post-content">
								<div class="grve-post-header">
									<?php if( 1 == $index ) { ?>
										<?php movedo_ext_vce_print_post_title( $blog_mode, $post_format, $heading_tag, $heading ); ?>
										<?php movedo_ext_vce_print_structured_data(); ?>
										<?php if ( 'yes' != $hide_date || 'yes' != $hide_author || 'yes' != $hide_comments || 'yes' != $hide_like ) { ?>
											<ul class="grve-post-meta">
											<?php
												if ( 'yes' != $hide_author ) {
													movedo_ext_vce_print_post_author_by( $blog_mode );
												}
												if ( 'yes' != $hide_date ) {
													movedo_ext_vce_print_post_date('list');
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
									<?php } else { ?>
										<?php movedo_ext_vce_print_post_title( $blog_mode, $post_format, $heading_tag, 'h5' ); ?>
										<?php movedo_ext_vce_print_structured_data(); ?>
										<?php if ( 'yes' != $hide_date ) { ?>
											<ul class="grve-post-meta">
											<?php
												if ( 'yes' != $hide_date ) {
													movedo_ext_vce_print_post_date('list');
												}
											?>
											</ul>
										<?php } ?>
									<?php } ?>

								</div>
								<?php movedo_ext_vce_print_post_excerpt( $blog_mode, $post_format, $auto_excerpt, $excerpt_length, $excerpt_more ); ?>
							</div>

					</div>
				</article>

<?php
		if( 1 == $index ){
			echo '</div>';
		}

		endwhile;

		if( $index > 1 ){
			echo '</div>';
		}
?>
		</div>
<?php
		else :
		endif;

		wp_reset_postdata();

		return ob_get_clean();


	}
	add_shortcode( 'movedo_blog_leader', 'movedo_ext_vce_blog_leader_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_blog_leader_shortcode_params' ) ) {
	function movedo_ext_vce_blog_leader_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Blog Leader", "movedo-extension" ),
			"description" => esc_html__( "Display a Blog element in leader style", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-blog-leader",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Number of Posts", "movedo-extension" ),
					"param_name" => "posts_per_page",
					"value" => array(
						esc_html__( "Leader Only", "movedo-extension" ) => '1',
						esc_html__( "Leader + 2 columns", "movedo-extension" ) => '3',
						esc_html__( "Leader + 3 columns", "movedo-extension" ) => '4',
						esc_html__( "Leader + 4 columns", "movedo-extension" ) => '5',
					),
					"description" => esc_html__( "Enter how many posts you want to display.", "movedo-extension" ),
					"std" => "4",
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Mode", "movedo-extension" ),
					"param_name" => "blog_image_mode",
					'value' => array(
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					"description" => esc_html__( "Select your Blog Image Mode.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Leader Style", "movedo-extension" ),
					"param_name" => "blog_leader_style",
					'value' => array(
						esc_html__( 'Classic', 'movedo-extension' ) => '',
						esc_html__( 'Movedo', 'movedo-extension' ) => 'movedo',
					),
					"description" => esc_html__( "Select your Post Leader Style.", "movedo-extension" ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Leader Background Color", "movedo-extension" ),
					"param_name" => "leader_bg_color",
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
					"dependency" => array( 'element' => "blog_leader_style", 'value' => array( 'movedo' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Leader Background Opacity", "movedo-extension" ),
					"param_name" => "leader_bg_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 70,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"dependency" => array( 'element' => "blog_leader_style", 'value' => array( 'movedo' ) ),
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				//Titles & Styles
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Post Title Tag", "movedo-extension" ),
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
					"description" => esc_html__( "Post Title Tag for SEO", "movedo-extension" ),
					"std" => 'h2',
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Post Title Size/Typography", "movedo-extension" ),
					"param_name" => "heading",
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
					"std" => 'auto',
					"group" => esc_html__( "Titles & Styles", "movedo-extension" ),
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
					"type" => 'textfield',
					"heading" => esc_html__( "Excerpt length", "movedo-extension" ),
					"param_name" => "excerpt_length",
					"description" => esc_html__( "Type how many words you want to display in your post excerpts.", "movedo-extension" ),
					"value" => '30',
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
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
					"std" => "grve-zoom-in",
				),
				movedo_ext_vce_add_order_by(),
				movedo_ext_vce_add_order(),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
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
	vc_lean_map( 'movedo_blog_leader', 'movedo_ext_vce_blog_leader_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_blog_leader_shortcode_params( 'movedo_blog_leader' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
