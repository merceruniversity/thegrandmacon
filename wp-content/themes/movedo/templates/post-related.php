<?php
/*
*	Template Post Related
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


$movedo_grve_link = get_permalink();
$movedo_grve_target = '_self';

if ( 'link' == get_post_format() ) {
	$movedo_grve_link = get_post_meta( get_the_ID(), '_movedo_grve_post_link_url', true );
	$new_window = get_post_meta( get_the_ID(), '_movedo_grve_post_link_new_window', true );
	if( empty( $movedo_grve_link ) ) {
		$movedo_grve_link = get_permalink();
	}

	if( !empty( $new_window ) ) {
		$movedo_grve_target = '_blank';
	}
}
?>

<?php $post_nav_bar_layout = movedo_grve_option( 'post_nav_bar_layout', 'layout-1' ); ?>
<?php if ( 'layout-1' == $post_nav_bar_layout || 'layout-3' == $post_nav_bar_layout ) { ?>

	<div class="wpb_column grve-column grve-column-1-3">
		<div class="grve-column-wrapper">
			<article id="grve-post-related-<?php the_ID(); ?><?php echo uniqid('-'); ?>" class="grve-element grve-hover-item grve-hover-style-1">
				<?php if ( has_post_thumbnail() ) { ?>
				<figure class="grve-image-hover">
					<a class="grve-item-url" href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>"></a>
					<div class="grve-media">
					<?php $image_size = 'movedo-grve-small-rect-horizontal'; ?>
					<?php the_post_thumbnail( $image_size ); ?>
					</div>
				</figure>
				<?php } ?>
				<div class="grve-content grve-align-center">
					<a href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>">
						<h3 class="grve-title grve-h6 grve-text-inherit grve-text-hover-primary-1"><?php the_title(); ?></h3>
					</a>
				</div>
			</article>
		</div>
	</div>

<?php } else { ?>

	<div id="grve-post-related-<?php the_ID(); ?><?php echo uniqid('-'); ?>" class="grve-related-item grve-image-hover">

		<a href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>">
			<div class="grve-related-content">
				<h5 class="grve-title grve-text-white"><?php the_title(); ?></h5>
			</div>

		<?php
			if ( has_post_thumbnail() ) {
		?>
			<div class="grve-background-wrapper">
				<?php
					$image_size = 'movedo-grve-small-rect-horizontal';
					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					$attachment_src = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
					$image_src = $attachment_src[0];
				?>
				<div class="grve-bg-image" style="background-image: url(<?php echo esc_url( $image_src ); ?>);"></div>
			</div>
		<?php
			}
		?>
		</a>

	</div>

<?php } ?>