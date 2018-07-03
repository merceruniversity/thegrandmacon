<?php
/**
 * The Quote Post Type Template
 */
?>

<?php
if ( is_singular() ) {

	$bg_color = movedo_grve_post_meta( '_movedo_grve_post_quote_bg_color', 'primary-1' );
	$bg_hover_color = movedo_grve_post_meta( '_movedo_grve_post_quote_bg_hover_color', 'black' );
	$bg_opacity = movedo_grve_post_meta( '_movedo_grve_post_quote_bg_opacity', '70' );
	$bg_options = array(
		'bg_color' => $bg_color,
		'bg_hover_color' => $bg_hover_color,
		'bg_opacity' => $bg_opacity,
	);
	$movedo_grve_post_quote_name = movedo_grve_admin_post_meta( $post->ID, '_movedo_grve_post_quote_name' );
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'grve-single-post grve-post-quote' ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<div id="grve-single-quote">
			<div class="grve-container">
				<?php movedo_grve_print_post_bg_image_container( $bg_options ); ?>
				<div class="grve-post-content">
					<div class="grve-post-icon">
						<i class="grve-icon-quote"></i>
						<svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>
					</div>
					<div>
						<?php movedo_grve_print_post_excerpt('quote'); ?>
					</div>
					<?php if ( !empty( $movedo_grve_post_quote_name ) ) { ?>
					<div class="grve-quote-writer"><?php echo wp_kses_post(  $movedo_grve_post_quote_name ); ?></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div id="grve-single-content">
			<?php movedo_grve_print_post_simple_title(); ?>
			<?php movedo_grve_print_post_structured_data(); ?>
			<div itemprop="articleBody">
				<?php the_content(); ?>
			</div>
		</div>
	</article>

<?php
} else {
	$blog_mode = movedo_grve_option( 'blog_mode', 'large' );
	$movedo_grve_post_class = movedo_grve_get_post_class( 'grve-style-2' );

	$bg_color = movedo_grve_post_meta( '_movedo_grve_post_quote_bg_color', 'primary-1' );
	$bg_hover_color = movedo_grve_post_meta( '_movedo_grve_post_quote_bg_hover_color', 'black' );
	$bg_opacity = movedo_grve_post_meta( '_movedo_grve_post_quote_bg_opacity', '70' );
	$bg_options = array(
		'bg_color' => $bg_color,
		'bg_hover_color' => $bg_hover_color,
		'bg_opacity' => $bg_opacity,
	);
	$movedo_grve_post_quote_name = movedo_grve_admin_post_meta( $post->ID, '_movedo_grve_post_quote_name' );


?>

	<!-- Article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( $movedo_grve_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<?php do_action( 'movedo_grve_inner_post_loop_item_before' ); ?>

		<a class="grve-post-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"></a>
		<?php movedo_grve_print_post_bg_image_container( $bg_options ); ?>
		<div class="grve-post-content-wrapper">
			<div class="grve-post-content">
				<div class="grve-post-icon">
					<i class="grve-icon-quote"></i>
					<svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>
				</div>
				<?php do_action( 'movedo_grve_inner_post_loop_item_title_hidden' ); ?>
				<div itemprop="articleBody">
				<?php movedo_grve_print_post_excerpt('quote'); ?>
				</div>
				<?php if ( !empty( $movedo_grve_post_quote_name ) ) { ?>
					<div class="grve-quote-writer"><?php echo wp_kses_post(  $movedo_grve_post_quote_name ); ?></div>
				<?php } ?>
				<?php movedo_grve_print_post_structured_data(); ?>
			</div>
		</div>

		<?php do_action( 'movedo_grve_inner_post_loop_item_after' ); ?>
	</article>
	<!-- End Article -->

<?php
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
