<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// Get layout path
$render_path = $this->get_render_path();

ob_start();
include $render_path;
$items_html = ob_get_clean();

// Inclue OWL Assets
$this->main->load_owl_assets();

// Generating javascript code tpl
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#mec_skin_'.$this->id.'").mecSliderView(
    {
        id: "'.$this->id.'",
        start_date: "'.$this->start_date.'",
        atts: "'.http_build_query(array('atts'=>$this->atts), '', '&').'",
        autoplay: "'.$this->autoplay.'",
        ajax_url: "'.admin_url('admin-ajax.php', NULL).'",
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);
?>
<div class="mec-wrap mec-skin-slider-container<?php echo $this->html_class; ?>" id="mec_skin_<?php echo $this->id; ?>">
    
    <?php if($this->found): ?>
    <div class="mec-skin-slider-events-container" id="mec_skin_events_<?php echo $this->id; ?>">
        <?php echo $items_html; ?>
    </div>
    <?php else: ?>
    <div class="mec-skin-slider-events-container" id="mec_skin_events_<?php echo $this->id; ?>">
        <?php _e('No event found!', 'mec'); ?>
    </div>
    <?php endif; ?>
    
</div>