<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// Get layout path
$render_path = $this->get_render_path();

// Generate Events
ob_start();
include $render_path;
$date_events = ob_get_clean();

// Generating javascript code tpl
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#mec_skin_'.$this->id.'").mecWeeklyProgram(
    {
        id: "'.$this->id.'",
        ajax_url: "'.admin_url('admin-ajax.php', NULL).'",
        sed_method: "'.$this->sed_method.'",
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);

$styling = $this->main->get_styling();
$event_colorskin = (isset($styling['mec_colorskin']) || isset($styling['color'])) ? 'colorskin-custom' : '';
?>
<div id="mec_skin_<?php echo $this->id; ?>" class="mec-timetable-wrap mec-wrap <?php echo $event_colorskin . ' ' . $this->html_class; ?>">
    <?php echo $date_events; ?>
</div>
<?php /** Append JS codes for full-calendar skin **/ if(isset($this->atts['append_js_codes']) and $this->atts['append_js_codes']) echo $javascript;