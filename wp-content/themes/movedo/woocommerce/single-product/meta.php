<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$product_get_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;

?>

<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="grve-single-product-meta sku_wrapper"><span class="grve-h6"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?></span> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

	<div class="grve-single-product-meta grve-categories">
	<?php
		if ( function_exists( 'wc_get_product_category_list' ) ) {
			echo wc_get_product_category_list( $product_get_id, ', ', '<span class="posted_in"><span class="grve-h6">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . '</span> ', '</span>' );
		} else {
			$cat_count = 0;
			$cats = get_the_terms( $post->ID, 'product_cat' );
			if ( !empty( $cats ) ) {
				$cat_count = count( $cats );
			}
			echo  $product->get_categories( ', ', '<span class="posted_in"><span class="grve-h6">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . '</span> ', '</span>' );
		}
	?>
	</div>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
