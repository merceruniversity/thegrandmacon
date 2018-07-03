<?php
/**
 * Order Downloads.
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="woocommerce-order-downloads">
	<?php if ( isset( $show_title ) ) : ?>
		<h3 class="woocommerce-order-downloads__title grve-align-center"><?php esc_html_e( 'Downloads', 'woocommerce' ); ?></h3>
	<?php endif; ?>

	<table class="woocommerce-table woocommerce-table--order-downloads shop_table order_details">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_downloads_columns() as $column_id => $column_name ) : ?>
				<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<?php foreach ( $downloads as $download ) : ?>
			<tr>
				<?php foreach ( wc_get_account_downloads_columns() as $column_id => $column_name ) : ?>
					<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>"><?php
						if ( has_action( 'woocommerce_account_downloads_column_' . $column_id ) ) {
							do_action( 'woocommerce_account_downloads_column_' . $column_id, $download );
						} else {
							switch ( $column_id ) {
								case 'download-product' : ?>
									<a href="<?php echo esc_url( get_permalink( $download['product_id'] ) ); ?>"><?php echo esc_html( $download['product_name'] ); ?></a>
									<?php
								break;
								case 'download-file' : ?>
									<a href="<?php echo esc_url( $download['download_url'] ); ?>" class="woocommerce-MyAccount-downloads-file button alt"><?php echo esc_html( $download['download_name'] ); ?></a>
									<?php
								break;
								case 'download-remaining' :
									echo is_numeric( $download['downloads_remaining'] ) ? esc_html( $download['downloads_remaining'] ) : esc_html__( '&infin;', 'woocommerce' );
								break;
								case 'download-expires' : ?>
									<?php if ( ! empty( $download['access_expires'] ) ) : ?>
										<time datetime="<?php echo date( 'Y-m-d', strtotime( $download['access_expires'] ) ); ?>" title="<?php echo esc_attr( strtotime( $download['access_expires'] ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $download['access_expires'] ) ); ?></time>
									<?php else : ?>
										<?php esc_html_e( 'Never', 'woocommerce' ); ?>
									<?php endif;
								break;
							}
						}
					?></td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</table>
</section>
