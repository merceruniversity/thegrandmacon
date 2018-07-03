<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

$grve_product_image_effect = movedo_grve_option( 'product_image_effect', 'none' );

//Classes Images
$product_images_classes = array( 'images' );
if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
	$lighbox_enabled = get_option( 'woocommerce_enable_lightbox', '' );
} else {
	$lighbox_enabled = 'no';
}
if ( 'yes' != $lighbox_enabled && 'popup' == movedo_grve_option( 'product_gallery_mode', 'popup' ) ) {
	$product_images_classes[] = 'grve-gallery-popup';
}
$product_images_class_string = implode( ' ', $product_images_classes );

//Classes Product Image
$product_image_classes = array( 'grve-product-image', 'woocommerce-product-gallery__image'  );
if ( 'zoom' == $grve_product_image_effect ) {
	$product_image_classes[] = 'easyzoom';
} elseif( 'parallax' == $grve_product_image_effect ) {
	$product_image_classes[] = 'grve-product-parallax-image';
}
$product_image_class_string = implode( ' ', $product_image_classes );

if ( version_compare( WC_VERSION, '3.3', '<' ) ) {
	$shop_single_size = 'shop_single' ;
} else {
	$shop_single_size = 'woocommerce_single' ;
}

?>
<div id="grve-product-feature-image" class="<?php echo esc_attr( $product_images_class_string ); ?>">
	<div class="<?php echo esc_attr( $product_image_class_string ); ?>">
		<?php
			if ( has_post_thumbnail() ) {

				$custom_image_id = movedo_grve_post_meta( '_movedo_grve_area_image_id' );
				if( $custom_image_id ) {
					$image_title 	= esc_attr( get_the_title( $custom_image_id  ) );
					$image_caption 	= get_post( $custom_image_id  )->post_excerpt;
					$image_link  	= wp_get_attachment_url( $custom_image_id  );
					$image_size = apply_filters( 'single_product_large_thumbnail_size', $shop_single_size );
					$image_class = "wp-post-image attachment-". $image_size . " size-" . $image_size;

					if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
						$attributes = array(
							'alt'	=> $image_title,
							'class' => $image_class,
						);
					} else {
						$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
						$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						$attributes = array(
							'alt'	=> $image_title,
							'class' => $image_class,
							'data-large_image'        => $full_size_image[0],
							'data-large_image_width'  => $full_size_image[1],
							'data-large_image_height' => $full_size_image[2],
						);
					}

					$image	= wp_get_attachment_image( $custom_image_id , $image_size , "", $attributes );
				} else {

					$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
					$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
					$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );

					if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
						$attributes = array(
							'alt'	=> $image_title,
						);
					} else {
						$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
						$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						$attributes = array(
							'alt'	=> $image_title,
							'data-large_image'        => $full_size_image[0],
							'data-large_image_width'  => $full_size_image[1],
							'data-large_image_height' => $full_size_image[2],
						);
					}

					$image	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', $shop_single_size ), $attributes );
				}

				if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
					$attachment_ids = $product->get_gallery_image_ids();
				} else {
					$attachment_ids = $product->get_gallery_attachment_ids();
				}

				$attachment_count = count( $attachment_ids );

				if ( $attachment_count > 0 ) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}

				//Check Title and Caption
				$image_title_caption = movedo_grve_option( 'product_gallery_title_caption', 'none' );
				$product_image_title = $product_image_caption = '';
				if ( !empty( $image_title ) && 'none' != $image_title_caption && 'caption-only' != $image_title_caption ) {
					$product_image_title = $image_title;
				}
				if ( !empty( $image_caption ) && 'none' != $image_title_caption && 'title-only' != $image_title_caption ) {
					$product_image_caption = $image_caption;
				}

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="woocommerce-main-image zoom" data-title="%s" data-desc="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $product_image_title, $product_image_caption, $image ), $post->ID );

			} else {

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="woocommerce-main-image zoom"><img class="wp-post-image" src="%s" data-large_image="%s" alt="%s" /></a>', wc_placeholder_img_src(), wc_placeholder_img_src(), wc_placeholder_img_src(), esc_html__( 'Placeholder', 'woocommerce' ) ), $post->ID );

			}
		?>
	</div>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
