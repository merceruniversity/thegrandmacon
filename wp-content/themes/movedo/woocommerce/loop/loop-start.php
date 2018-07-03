<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
?>
<?php

global $woocommerce_loop;
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

$columns_large_screen = $woocommerce_loop['columns'];
$columns = $woocommerce_loop['columns'];
$columns_tablet_landscape = '2';
$columns_tablet_portrait = '2';
$columns_mobile = '1';
if( isset( $woocommerce_loop['name'] ) ) {
	if( 'up-sells' == $woocommerce_loop['name'] || 'related' == $woocommerce_loop['name'] || 'cross-sells' == $woocommerce_loop['name'] ) {
		$columns_tablet_landscape = $columns;
		$columns_tablet_portrait = $columns;
	}
}


$wrapper_attributes = array();

$wrapper_attributes[] = 'data-gutter-size="30"';
$wrapper_attributes[] = 'data-layout="fitRows"';
$wrapper_attributes[] = 'data-spiner="no"';

$wrapper_attributes[] = 'data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '"';
$wrapper_attributes[] = 'data-columns="' . esc_attr( $columns ) . '"';
$wrapper_attributes[] = 'data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '"';
$wrapper_attributes[] = 'data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '"';
$wrapper_attributes[] = 'data-columns-mobile="' . esc_attr( $columns_mobile ) . '"';


?>
<div class="clear"></div>
<div class="grve-element grve-with-gap grve-product grve-isotope" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<div class="grve-product-container grve-isotope-container">
