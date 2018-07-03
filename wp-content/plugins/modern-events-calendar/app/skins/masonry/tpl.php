<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// Get layout path
$render_path = $this->get_render_path();

ob_start();
include $render_path;
$items_html = ob_get_clean();

// Inclue Isotope Assets
$this->main->load_isotope_assets();

// Generating javascript code tpl
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#mec_skin_'.$this->id.'").mecMasonryView(
    {
        id: "'.$this->id.'",
        start_date: "'.$this->start_date.'",
        end_date: "'.$this->end_date.'",
		offset: "'.$this->next_offset.'",
        atts: "'.http_build_query(array('atts'=>$this->atts), '', '&').'",
        ajax_url: "'.admin_url('admin-ajax.php?lang=ru', NULL).'",
        sed_method: "'.$this->sed_method.'",
        sf:
        {
            container: "'.($this->sf_status ? '#mec_search_form_'.$this->id : '').'"
        }
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);
?>
<div class="mec-wrap mec-skin-masonry-container <?php echo $this->html_class; ?>" id="mec_skin_<?php echo $this->id; ?>">

    <?php if(trim($this->filter_by)) echo $this->filter_by(); ?>

    <?php if($this->found): ?>
    <div class="mec-events-masonry-wrap" id="mec_skin_events_<?php echo $this->id; ?>">
        <?php echo $items_html; ?>
    </div>
    <div class="mec-skin-masonry-no-events-container mec-util-hidden" id="mec_skin_no_events_<?php echo $this->id; ?>">
        <?php _e('No event found!', 'mec'); ?>
    </div>
    <?php else: ?>
    <div class="mec-skin-masonry-events-container" id="mec_skin_events_<?php echo $this->id; ?>">
        <?php _e('No event found!', 'mec'); ?>
    </div>
    <?php endif; ?>
    
</div>
<?php /** Append JS codes for full-calendar skin **/ if(isset($this->atts['append_js_codes']) and $this->atts['append_js_codes']) echo $javascript;