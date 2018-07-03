<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;


if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
	$attachment_ids = $product->get_gallery_image_ids();
} else {
	$attachment_ids = $product->get_gallery_attachment_ids();
}


//Classes
$product_gallery_classes = array( 'thumbnails' );

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	//$product_gallery_classes[] = 'columns-' . $columns;

	$product_gallery_class_string = implode( ' ', $product_gallery_classes );
	
	if ( version_compare( WC_VERSION, '3.3', '<' ) ) {
		$shop_thumbnail_size = 'shop_thumbnail' ;
	} else {
		$shop_thumbnail_size = 'woocommerce_thumbnail' ;
	}	

	?>
	<div class="<?php echo esc_attr( $product_gallery_class_string ); ?>">
		<div class="grve-thumbnails-wrapper">
			<div class="grve-thumbnails-inner">
	<?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image_title 	= esc_attr( get_the_title( $attachment_id ) );
			$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

			$image       = wp_get_attachment_image( $attachment_id, $shop_thumbnail_size, 0, $attr = array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );

			//Check Title and Caption
			$image_title_caption = movedo_grve_option( 'product_gallery_title_caption', 'none' );
			$product_image_title = $product_image_caption = '';
			if ( !empty( $image_title ) && 'none' != $image_title_caption && 'caption-only' != $image_title_caption ) {
				$product_image_title = $image_title;
			}
			if ( !empty( $image_caption ) && 'none' != $image_title_caption && 'title-only' != $image_title_caption ) {
				$product_image_caption = $image_caption;
			}

			$image_class = esc_attr( implode( ' ', $classes ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="grve-thumb-item"><a href="%s" class="%s" data-title="%s" data-desc="%s" data-rel="prettyPhoto[product-gallery]">%s</a></div>', $image_link, $image_class, $product_image_title, $product_image_caption, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

	?>
			</div>
		</div>
	</div>
	<?php
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
