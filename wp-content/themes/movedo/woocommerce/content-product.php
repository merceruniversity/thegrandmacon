<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty($product) || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array();

//Second Product Image
if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
	$attachment_ids = $product->get_gallery_image_ids();
} else {
	$attachment_ids = $product->get_gallery_attachment_ids();
}

if ( version_compare( WC_VERSION, '3.3', '<' ) ) {
	$shop_catalog_size = 'shop_catalog';
} else {
	$shop_catalog_size = 'woocommerce_thumbnail';
}
$image_size = apply_filters( 'single_product_archive_thumbnail_size', $shop_catalog_size );

//Second Image Classes
$image_classes = array();
$image_classes[] = 'attachment-' . $image_size;
$image_classes[] = 'size-' . $image_size;
$image_classes[] = 'grve-product-thumbnail-second';
$image_class_string = implode( ' ', $image_classes );

$product_thumb_second_id = '';

if ( $attachment_ids ) {
	$loop = 0;
	foreach ( $attachment_ids as $attachment_id ) {
		$image_link = wp_get_attachment_url( $attachment_id );
		if (!$image_link) {
			continue;
		}
		$loop++;
		$product_thumb_second_id = $attachment_id;
		if ($loop == 1) {
			break;
		}
	}
}

$image_effect = movedo_grve_option( 'product_overview_image_effect', 'second' );
$zoom_effect = movedo_grve_option( 'product_overview_image_zoom_effect', 'none' );

if ( 'second' == $image_effect && !empty( $product_thumb_second_id ) ) {
	$classes[] = 'grve-with-second-image';
}
$classes[] = 'grve-isotope-item';
$classes[] = 'grve-product-item';

$product_title_heading_tag = movedo_grve_option( 'product_overview_heading_tag', 'h4' );
$product_title_heading = movedo_grve_option( 'product_overview_heading', 'h4' );
$overlay_color = movedo_grve_option( 'product_overview_overlay_color', 'light' );
$overlay_opacity = movedo_grve_option( 'product_overview_overlay_opacity', '90' );

//Remove Actions
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' , 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

?>
<div <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="grve-isotope-item-inner grve-hover-item">
		<div class="grve-product-added-icon grve-icon-shop grve-circle"></div>
		<figure class="grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
			<div class="grve-media">
				<div class="grve-add-cart-wrapper">
					<div class="grve-add-cart-button">
						<?php woocommerce_template_loop_add_to_cart(); ?>
					</div>
				</div>
				<a class="grve-item-url" href="<?php echo esc_url( get_permalink() ); ?>"></a>
				<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
					if ( 'second' == $image_effect && !empty( $product_thumb_second_id ) ) {
						echo wp_get_attachment_image( $product_thumb_second_id, $image_size , "", array( 'class' => $image_class_string ) );
					}
				?>
			</div>
			<figcaption class="grve-content grve-align-center">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<<?php echo tag_escape( $product_title_heading_tag ); ?> class="grve-title grve-<?php echo esc_attr( $product_title_heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $product_title_heading_tag ); ?>>
				</a>
				<?php
					/**
					 * woocommerce_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_product_title - 10
					 */
					do_action( 'woocommerce_shop_loop_item_title' );

					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</figcaption>
		</figure>
	</div>

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );

	?>

</div>
