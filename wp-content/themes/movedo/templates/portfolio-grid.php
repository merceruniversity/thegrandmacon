<?php
/*
*	Template Portfolio Grid
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/
?>

<article id="grve-portfolio-item-<?php the_ID(); ?><?php echo uniqid('-'); ?>" <?php post_class( 'grve-portfolio-item grve-isotope-item' ); ?>>
	<div class="grve-isotope-item-inner grve-hover-item grve-hover-style-1 grve-zoom-none">
		<figure class="grve-image-hover grve-media grve-zoom-none">
			<a class="grve-item-url" href="<?php echo esc_url( get_permalink() ); ?>"></a>
			<?php movedo_grve_print_portfolio_image( 'movedo-grve-small-square' ); ?>
			<figcaption></figcaption>
		</figure>
		<div class="grve-content grve-align-center">
			<h3 class="grve-title grve-text-inherit grve-h5"><?php the_title(); ?></h3>
		</div>
	</div>
</article>