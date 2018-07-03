<?php
/** @var Movedo_Vc_Templates $controller */
/** @var array $templates */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

?>
<div class="vc_ui-templates-content grve-templates-content">

	<div class="grve-template-filters">
		<ul>
			<?php
				foreach( $filters as $filter_slug => $filter_name ) {
					echo '<li data-filter="' . esc_attr( $filter_slug ) . '">' . esc_html( $filter_name ) . ' <span class="grve-count">0</span></li>';
				}
			?>
		</ul>
	</div>

	<div id="grve-template-item-grid" class="vc_column vc_col-sm-12">

		<div class="vc_ui-template-list vc_templates-list-movedo_templates vc_ui-list-bar" data-vc-action="collapseAll">

		<?php
			$index = -1;
			foreach ( $templates as $key => $template ) :
			$index++;
		?>

			<div class="grve-template-item vc_ui-template vc_templates-template-type-movedo_templates <?php echo esc_attr( $template['custom_class'] ); ?>"
				data-template_id="<?php echo esc_attr( $index ); ?>"
				data-template_name="<?php echo esc_attr( $template['name'] ); ?>"
				data-category="movedo_templates"
				data-template_type="movedo_templates"
				data-vc-content=".vc_ui-template-content">
				<div class="grve-template-item-inner">
					<button type="button" class="grve-template-load-button vc_ui-list-bar-item-trigger" data-template-handler="" data-vc-ui-element="template-title">
						<div class="grve-template-image-wrapper">
							<img src="<?php echo esc_url( $template['image_path'] ); ?>" alt="<?php echo esc_attr( $template['name'] ); ?>">
						</div>
						<div class="grve-template-content">
							<div class="grve-template-label">
								<?php echo esc_html( $template['name'] ); ?>
							</div>
							<div class="grve-template-button"><?php esc_html_e( 'Add', 'movedo-extension' ); ?></div>
						</div>
					</button>

					<div class="vc_ui-template-content" data-js-content></div>
				</div>
			</div>

		<?php endforeach ?>
		</div>
	</div>
</div>
<script type="text/javascript">
(function($) {
	$('.grve-template-filters ul > li').each(function(){
		if($(this).attr('data-filter') == '*') {
			$(this).find('.grve-count').html( $('#grve-template-item-grid .grve-template-item').length );
		} else {
			$(this).find('.grve-count').html( $('#grve-template-item-grid .grve-template-item.' + $(this).attr('data-filter') ).length );
		}
	});
	$('.grve-template-filters li[data-filter="*"]').addClass('active').trigger('click');
	$('.grve-template-filters li').click(function(){
		$('.grve-template-filters li').removeClass('active');
		$(this).addClass('active');
		var $filter = $(this).attr('data-filter');
		$('#grve-template-item-grid .grve-template-item').hide();
		if( $filter != '*' ){
			$('#grve-template-item-grid .grve-template-item.' + $filter ).fadeIn('1000');
		} else {
			$('#grve-template-item-grid .grve-template-item').fadeIn('1000');
		}
	});
})(jQuery);
</script>
