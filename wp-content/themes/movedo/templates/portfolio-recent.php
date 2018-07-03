<?php
/*
*	Template Portfolio Recent
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/
?>

<?php $portfolio_nav_bar_layout = movedo_grve_option( 'portfolio_nav_bar_layout', 'layout-1' ); ?>
<?php if ( 'layout-1' == $portfolio_nav_bar_layout || 'layout-3' == $portfolio_nav_bar_layout ) { ?>

	<div class="wpb_column grve-column grve-column-1-3">
		<div class="grve-column-wrapper">
			<article id="grve-portfolio-recent-<?php the_ID(); ?><?php echo uniqid('-'); ?>" class="grve-element grve-hover-item grve-hover-style-6">
				<figure class="grve-image-hover">
					<a class="grve-item-url" href="<?php echo esc_url( get_permalink() ); ?>"></a>
					<div class="grve-media">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php $image_size = 'movedo-grve-small-rect-horizontal'; ?>
							<?php the_post_thumbnail( $image_size ); ?>
						<?php } else { ?>
							<?php $movedo_grve_empty_image_url = get_template_directory_uri() . '/images/empty/movedo-grve-small-rect-horizontal.jpg'; ?>
							<img width="560" height="420" src="<?php echo esc_url( $movedo_grve_empty_image_url ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
						<?php } ?>
					</div>
					<div class="grve-gradient-overlay"></div>
					<figcaption class="grve-content grve-align-center">
						<h3 class="grve-title grve-h6 grve-text-light"><?php the_title(); ?></h3>
					</figcaption>
				</figure>
			</article>
		</div>
	</div>

<?php } else { ?>

	<article id="grve-portfolio-recent-<?php the_ID(); ?><?php echo uniqid('-'); ?>" class="grve-related-item grve-image-hover">

		<a href="<?php echo esc_url( get_permalink() ); ?>">
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

	</article>

<?php } ?>