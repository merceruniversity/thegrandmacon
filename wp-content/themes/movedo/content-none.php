<?php
/*
*	Template Content None
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/
?>
<div class="grve-content-none">
	<div class="grve-post-content">
		<?php echo do_shortcode( movedo_grve_option( 'search_page_not_found_text' ) ); ?>
		<div class="grve-widget">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>