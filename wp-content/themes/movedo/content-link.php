<?php
/**
 * The Link Post Type Template
 */
?>

<?php
if ( is_singular() ) {

	$movedo_grve_link = get_post_meta( get_the_ID(), '_movedo_grve_post_link_url', true );
	$new_window = get_post_meta( get_the_ID(), '_movedo_grve_post_link_new_window', true );

	if( empty( $movedo_grve_link ) ) {
		$movedo_grve_link = get_permalink();
	}

	$movedo_grve_target = '_self';
	if( !empty( $new_window ) ) {
		$movedo_grve_target = '_blank';
	}

	$bg_color = movedo_grve_post_meta( '_movedo_grve_post_link_bg_color', 'primary-1' );
	$bg_hover_color = movedo_grve_post_meta( '_movedo_grve_post_link_bg_hover_color', 'black' );
	$bg_opacity = movedo_grve_post_meta( '_movedo_grve_post_link_bg_opacity', '70' );
	$bg_options = array(
		'bg_color' => $bg_color,
		'bg_hover_color' => $bg_hover_color,
		'bg_opacity' => $bg_opacity,
	);

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'grve-single-post' ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<div id="grve-single-link">
			<div class="grve-container">
				<a href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>" rel="bookmark">
					<?php movedo_grve_print_post_bg_image_container( $bg_options ); ?>
					<div class="grve-post-content">
						<div class="grve-post-icon">
							<i class="grve-icon-link"></i>
							<svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>
						</div>
						<h2 class="grve-post-title grve-text-light grve-h3" itemprop="name headline"><?php the_title(); ?></h2>
						<div class="grve-post-url"><?php echo esc_url( $movedo_grve_link ); ?></div>
					</div>
				</a>
			</div>
		</div>
		<div id="grve-single-content">
			<?php movedo_grve_print_post_simple_title(); ?>
			<?php movedo_grve_print_post_structured_data(); ?>
			<div itemprop="articleBody">
				<?php the_content(); ?>
			</div>
		</div>
	</article>

<?php
} else {

	$movedo_grve_post_class = movedo_grve_get_post_class( 'grve-style-2' );
	$movedo_grve_link = get_post_meta( get_the_ID(), '_movedo_grve_post_link_url', true );
	$new_window = get_post_meta( get_the_ID(), '_movedo_grve_post_link_new_window', true );

	if( empty( $movedo_grve_link ) ) {
		$movedo_grve_link = get_permalink();
	}

	$movedo_grve_target = '_self';
	if( !empty( $new_window ) ) {
		$movedo_grve_target = '_blank';
	}

	$bg_color = movedo_grve_post_meta( '_movedo_grve_post_link_bg_color', 'primary-1' );
	$bg_hover_color = movedo_grve_post_meta( '_movedo_grve_post_link_bg_hover_color', 'black' );
	$bg_opacity = movedo_grve_post_meta( '_movedo_grve_post_link_bg_opacity', '70' );
	$bg_options = array(
		'bg_color' => $bg_color,
		'bg_hover_color' => $bg_hover_color,
		'bg_opacity' => $bg_opacity,
	);

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( $movedo_grve_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
		<?php do_action( 'movedo_grve_inner_post_loop_item_before' ); ?>
		<a class="grve-post-link" href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>" rel="bookmark"></a>
		<?php movedo_grve_print_post_bg_image_container( $bg_options ); ?>
		<div class="grve-post-content-wrapper">
			<div class="grve-post-content">
				<div class="grve-post-icon">
					<i class="grve-icon-link"></i>
					<svg class="grve-animated-circle" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"><circle fill="none" stroke="#ffffff" stroke-width="2" cx="30" cy="30" r="29" transform="rotate(-90 30 30)"/></svg>
				</div>
				<?php movedo_grve_loop_post_title(); ?>
				<?php movedo_grve_print_post_structured_data(); ?>
				<div itemprop="articleBody">
				<?php movedo_grve_print_post_excerpt('link'); ?>
				</div>
				<div class="grve-post-url"><?php echo esc_url( $movedo_grve_link ); ?></div>
			</div>
		</div>
		<?php do_action( 'movedo_grve_inner_post_loop_item_after' ); ?>

	</article>

<?php

}

//Omit closing PHP tag to avoid accidental whitespace output errors.
