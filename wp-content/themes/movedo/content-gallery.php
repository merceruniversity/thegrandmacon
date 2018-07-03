<?php
/**
 * The Gallery Post Type Template
 */
?>

<?php
if ( is_singular() ) {
	$movedo_grve_disable_media = movedo_grve_post_meta( '_movedo_grve_disable_media' );
	$slider_items = movedo_grve_post_meta( '_movedo_grve_post_slider_items' );
	$gallery_mode = movedo_grve_post_meta( '_movedo_grve_post_type_gallery_mode', 'gallery' );
	$gallery_image_mode = movedo_grve_post_meta( '_movedo_grve_post_type_gallery_image_mode' );
	$image_size_slider = 'movedo-grve-large-rect-horizontal';
	if ( 'resize' == $gallery_image_mode ) {
		if( movedo_grve_option( 'has_sidebar' ) ) {
			$image_size_slider = "medium_large";
		} else {
			$image_size_slider = "large";
		}
	}
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('grve-single-post'); ?> itemscope itemType="http://schema.org/BlogPosting">
<?php
		if ( !empty( $slider_items ) && 'yes' != $movedo_grve_disable_media ) {
?>
			<div id="grve-single-media">
				<div class="grve-container">
					<?php movedo_grve_print_gallery_slider( $gallery_mode, $slider_items, $image_size_slider  ); ?>
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
	$movedo_grve_post_class = movedo_grve_get_post_class();
?>

	<!-- Article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( $movedo_grve_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<?php do_action( 'movedo_grve_inner_post_loop_item_before' ); ?>
		<?php movedo_grve_print_post_feature_media( 'gallery' ); ?>
		<div class="grve-post-content-wrapper">
			<div class="grve-post-content">
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
