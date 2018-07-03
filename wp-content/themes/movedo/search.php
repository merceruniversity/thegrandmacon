<?php get_header(); ?>


<?php
	movedo_grve_print_header_title('search_page');

	$search_mode = movedo_grve_option( 'search_page_mode', 'masonry' );

	$wrapper_attributes = array();

	if ( 'small' != $search_mode) {

		$columns_large_screen  = movedo_grve_option( 'search_page_columns_large_screen', '3' );
		$columns = movedo_grve_option( 'search_page_columns', '3' );
		$columns_tablet_landscape  = movedo_grve_option( 'search_page_columns_tablet_landscape', '2' );
		$columns_tablet_portrait  = movedo_grve_option( 'search_page_columns_tablet_portrait', '2' );
		$columns_mobile  = movedo_grve_option( 'search_page_columns_mobile', '1' );
		$search_shadow  = movedo_grve_option( 'search_page_shadow_style', 'shadow-mode' );
		if ( 'grid' == $search_mode) {
			$search_mode = 'fitRows';
		}

		$wrapper_attributes[] = 'data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '"';
		$wrapper_attributes[] = 'data-columns="' . esc_attr( $columns ) . '"';
		$wrapper_attributes[] = 'data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '"';
		$wrapper_attributes[] = 'data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '"';
		$wrapper_attributes[] = 'data-columns-mobile="' . esc_attr( $columns_mobile ) . '"';
		$wrapper_attributes[] = 'data-layout="' . esc_attr( $search_mode ) . '"';
		$wrapper_attributes[] = 'data-gutter-size="30"';
		$wrapper_attributes[] = 'data-spinner="no"';

		$search_classes = array( 'grve-blog', 'grve-blog-columns', 'grve-isotope', 'grve-with-gap' );
		if( 'shadow-mode' == $search_shadow ){
			$search_classes[] = 'grve-with-shadow';
		}
	} else {
		$search_classes = array( 'grve-blog', 'grve-blog-small', 'grve-non-isotope' );
	}

	$search_class_string = implode( ' ', $search_classes );
	$wrapper_attributes[] = 'class="' . esc_attr( $search_class_string ) . '"';



?>

<!-- CONTENT -->
<div id="grve-content" class="clearfix">
	<div class="grve-content-wrapper">
		<!-- MAIN CONTENT -->
		<div id="grve-main-content">
			<div class="grve-main-content-wrapper clearfix">

				<div class="grve-section" style="margin-bottom: 0px;">

					<div class="grve-container">
						<!-- ROW -->
						<div class="grve-row">

							<!-- COLUMN 1 -->
							<div class="wpb_column grve-column grve-column-1">
							<?php
								if ( have_posts() ) :
							?>
								<div class="grve-column-wrapper">
									<div <?php echo implode( ' ', $wrapper_attributes ); ?>>
										<?php
											$movedo_grve_post_items = $movedo_grve_page_items = $movedo_grve_portfolio_items = $movedo_grve_other_post_items = 0;
											$movedo_grve_has_post_items = $movedo_grve_has_page_items = $movedo_grve_has_portfolio_items = 0;

											while ( have_posts() ) : the_post();
												$post_type = get_post_type();
												switch( $post_type ) {
													case 'post':
														 $movedo_grve_post_items++;
														 $movedo_grve_has_post_items = 1;
													break;
													case 'page':
														 $movedo_grve_page_items++;
														 $movedo_grve_has_page_items = 1;
													break;
													case 'portfolio':
														 $movedo_grve_portfolio_items++;
														 $movedo_grve_has_portfolio_items = 1;
													break;
													default:
														$movedo_grve_other_post_items++;
													break;
												}
											endwhile;
											$movedo_grve_item_types = $movedo_grve_has_post_items + $movedo_grve_has_page_items + $movedo_grve_has_portfolio_items;

											if ( $movedo_grve_item_types > 1 ) {
										?>
										<div class="grve-filter grve-link-text grve-list-divider grve-align-left">
											<ul>
												<li data-filter="*" class="selected"><?php esc_html_e( "All", 'movedo' ); ?></li>
												<?php if ( $movedo_grve_has_post_items ) { ?>
												<li data-filter=".post"><?php esc_html_e( "Post", 'movedo' ); ?></li>
												<?php } ?>
												<?php if ( $movedo_grve_has_page_items ) { ?>
												<li data-filter=".page"><?php esc_html_e( "Page", 'movedo' ); ?></li>
												<?php } ?>
												<?php if ( $movedo_grve_has_portfolio_items ) { ?>
												<li data-filter=".portfolio"><?php esc_html_e( "Portfolio", 'movedo' ); ?></li>
												<?php } ?>
											</ul>
										</div>
										<?php
											}
											if ( 'small' == $search_mode ) {
												echo '<div class="grve-standard-container">';
												while ( have_posts() ) : the_post();
												get_template_part( 'templates/search', 'small' );
												endwhile;
												echo '</div>';
											} else {
												echo '<div class="grve-isotope-container">';
												while ( have_posts() ) : the_post();
												get_template_part( 'templates/search', 'masonry' );
												endwhile;
												echo '</div>';
											}
											// Previous/next post navigation.
											movedo_grve_paginate_links();
										?>
									</div>
								</div>
								<?php
									else :
										// If no content, include the "No posts found" template.
										get_template_part( 'content', 'none' );
									endif;
								?>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
		<!-- End Content -->
	</div>
</div>
<?php get_footer();

//Omit closing PHP tag to avoid accidental whitespace output errors.
