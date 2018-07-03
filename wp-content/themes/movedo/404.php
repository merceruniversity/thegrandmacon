<?php
if ( movedo_grve_visibility( 'page_404_header' ) ) {
	get_header();
} else {
	get_header( 'basic' );
}

$section_classes = "grve-section grve-custom-height grve-fullheight";
?>

			<div id="grve-content" class="grve-error-404 clearfix">
				<div class="grve-content-wrapper">
					<div id="grve-main-content">
						<div class="grve-main-content-wrapper grve-padding-none clearfix">

							<div class="<?php echo esc_attr( $section_classes); ?>">
								<div class="grve-container">
									<div class="grve-row">
										<div class="wpb_column grve-column grve-column-1">
											<div class="grve-column-wrapper">
												<div class="grve-align-center">

													<div id="grve-content-area">
													<?php
														$movedo_grve_404_search_box = movedo_grve_option('page_404_search');
														$movedo_grve_404_home_button = movedo_grve_option('page_404_home_button');
														echo do_shortcode( movedo_grve_option( 'page_404_content' ) );
													?>
													</div>

													<br/>

													<?php if ( $movedo_grve_404_search_box ) { ?>
													<div class="grve-widget">
														<?php get_search_form(); ?>
													</div>
													<br/>
													<?php } ?>

													<?php if ( $movedo_grve_404_home_button ) { ?>
													<div class="grve-element">
														<a class="grve-btn grve-btn-medium grve-round grve-bg-primary-1 grve-bg-hover-black" target="_self" href="<?php echo esc_url( home_url( '/' ) ); ?>">
															<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
														</a>
													</div>
													<?php } ?>

												</div>

											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

<?php

if ( movedo_grve_visibility( 'page_404_footer' ) ) {
	get_footer();
} else {
	if ( movedo_grve_visibility( 'page_404_header' ) ) {
		get_footer( 'basic-header' );
	} else {
		get_footer( 'basic' );
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
