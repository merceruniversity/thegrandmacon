<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// Inclue OWL Assets
$this->main->load_owl_assets();

// Generating javascript code tpl
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#mec_skin_'.$this->id.'").mecFullCalendar(
    {
        id: "'.$this->id.'",
        atts: "'.http_build_query(array('atts'=>$this->atts), '', '&').'",
        ajax_url: "'.admin_url('admin-ajax.php', NULL).'",
        sed_method: "'.$this->sed_method.'",
        sf:
        {
            container: "'.($this->sf_status ? '#mec_search_form_'.$this->id : '').'",
        },
        skin: "'.$this->default_view.'",
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);
?>
<div id="mec_skin_<?php echo $this->id; ?>" class="mec-wrap mec-full-calendar-wrap">
    
    <div class="mec-totalcal-box">
        <?php if($this->sf_status): ?>
        <span id="mec_search_form_<?php echo $this->id; ?>">
            <div class="col-md-3">
                <?php echo $this->sf_search_field('month_filter', (isset($this->sf_options['month_filter']) ? $this->sf_options['month_filter'] : array())); ?>
            </div>
            <div class="col-md-5">
                <?php echo $this->sf_search_field('text_search', (isset($this->sf_options['text_search']) ? $this->sf_options['text_search'] : array())); ?>
            </div>
        </span>
        <?php endif; ?>
        <div class="col-md-4">
            <div class="mec-totalcal-view">
                <?php if($this->yearly): ?><span class="mec-totalcal-yearlyview<?php if($this->default_view == 'yearly') echo ' mec-totalcalview-selected'; ?>" data-skin="yearly"><?php _e('Yearly', 'mec'); ?></span><?php endif; ?>
                <?php if($this->monthly): ?><span class="mec-totalcal-monthlyview<?php if($this->default_view == 'monthly') echo ' mec-totalcalview-selected'; ?>" data-skin="monthly"><?php _e('Monthly', 'mec'); ?></span><?php endif; ?>
                <?php if($this->weekly): ?><span class="mec-totalcal-weeklyview<?php if($this->default_view == 'weekly') echo ' mec-totalcalview-selected'; ?>" data-skin="weekly"><?php _e('Weekly', 'mec'); ?></span><?php endif; ?>
                <?php if($this->daily): ?><span class="mec-totalcal-dailyview<?php if($this->default_view == 'daily') echo ' mec-totalcalview-selected'; ?>" data-skin="daily"><?php _e('Daily', 'mec'); ?></span><?php endif; ?>
                <?php if($this->list): ?><span class="mec-totalcal-listview<?php if($this->default_view == 'list') echo ' mec-totalcalview-selected'; ?>" data-skin="list"><?php _e('List', 'mec'); ?></span><?php endif; ?>
            </div>
        </div>
    </div>
    
    <div id="mec_full_calendar_container_<?php echo $this->id; ?>" class="mec-full-calendar-skin-container">
        <?php echo $this->load_skin($this->default_view); ?>
    </div>
    
</div>