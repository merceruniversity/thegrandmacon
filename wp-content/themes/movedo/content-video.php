<?php
/**
 * The Video Post Type Template
 */
?>

<?php
if ( is_singular() ) {
	$movedo_grve_disable_media = movedo_grve_post_meta( '_movedo_grve_disable_media' );
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'grve-single-post' ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<?php
			if ( 'yes' != $movedo_grve_disable_media ) {
		?>
		<div id="grve-single-media">
			<div class="grve-container">
				<?php movedo_grve_print_post_video(); ?>
			</div>
		</div>
		<?php
			}
		?>
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
	$post_style = movedo_grve_post_meta( '_movedo_grve_post_video_style' );
	$bg_mode = false;

	if ( ( 'masonry' == $blog_mode || 'grid' == $blog_mode ) && 'movedo' == $post_style ) {
		$bg_mode = true;
	}
	if ( $bg_mode ) {
		$movedo_grve_post_class = movedo_grve_get_post_class("grve-style-2");
		$bg_color = movedo_grve_post_meta( '_movedo_grve_post_video_bg_color', 'black' );
		$bg_opacity = movedo_grve_post_meta( '_movedo_grve_post_video_bg_opacity', '70' );
		$bg_options = array(
			'bg_color' => $bg_color,
			'bg_opacity' => $bg_opacity,
		);
	} else {
		$movedo_grve_post_class = movedo_grve_get_post_class();
	}
?>

	<!-- Article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( $movedo_grve_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<?php do_action( 'movedo_grve_inner_post_loop_item_before' ); ?>
		<?php if ( $bg_mode ) { ?>
		<?php movedo_grve_print_post_bg_image_container( $bg_options ); ?>
		<?php } else { ?>
		<?php movedo_grve_print_post_feature_media( 'video' ); ?>
		<?php } ?>
		<div class="grve-post-content-wrapper">
			<div class="grve-post-content">
				<?php if ( $bg_mode ) { ?>
				<?php movedo_grve_print_post_video_popup(); ?>
				<?php } ?>
				<?php movedo_grve_print_post_meta_top(); ?>
				<?php movedo_grve_print_post_structured_data(); ?>
				<div itemprop="articleBody">
					<?php movedo_grve_print_post_excerpt(); ?>
				</div>
			</div>
		</div>
		<?php do_action( 'movedo_grve_inner_post_loop_item_after' ); ?>
	</article>
	<!-- End Article -->

<?php
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
