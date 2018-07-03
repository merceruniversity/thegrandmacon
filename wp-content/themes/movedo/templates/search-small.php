<?php
/*
*	Template Search Small Media
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/
?>

<?php
	$title_tag = movedo_grve_option( 'search_page_heading_tag', 'h4' );
	$title_class = movedo_grve_option( 'search_page_heading', 'h4' );
	$excerpt_length = movedo_grve_option( 'search_page_excerpt_length_small' );
	$excerpt_more = movedo_grve_option( 'search_page_excerpt_more' );
	$search_page_show_image = movedo_grve_option( 'search_page_show_image', 'yes' );

	if ( 'yes' == $search_page_show_image ) {
		$search_image_mode = movedo_grve_option( 'search_image_mode', 'landscape' );
		$image_size = movedo_grve_get_image_size( $search_image_mode );
	}

?>

<article id="grve-search-<?php the_ID(); ?><?php echo uniqid('-'); ?>" <?php post_class( 'grve-blog-item grve-small-post grve-non-isotope-item' ); ?>>
	<div class="grve-blog-item-inner grve-non-isotope-item-inner">
	<?php if ( 'yes' == $search_page_show_image && has_post_thumbnail() ) { ?>
		<div class="grve-media grve-image-hover clearfix">
			<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( $image_size ); ?></a>
		</div>
	<?php } ?>
		<div class="grve-post-content-wrapper">
			<div class="grve-post-content">
				<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-text-hover-primary-1 grve-' . esc_attr( $title_class ) . '">', '</' . tag_escape( $title_tag ) . '></a>' ); ?>
				<div itemprop="articleBody">
					<?php echo movedo_grve_excerpt( $excerpt_length, $excerpt_more  ); ?>
				</div>
			</div>
		</div>
	</div>
</article>