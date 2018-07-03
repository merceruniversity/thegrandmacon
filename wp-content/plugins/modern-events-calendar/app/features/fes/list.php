<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// The Query
$query = new WP_Query(array('post_type'=>$this->PT, 'author'=>get_current_user_id(), 'posts_per_page'=>'-1', 'post_status'=>array('pending', 'draft', 'future', 'publish')));

// Generating javascript code of countdown module
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery(".mec-fes-event-remove").on("click", function(event)
    {
        var id = jQuery(this).data("id");
        var confirmed = jQuery(this).data("confirmed");
        
        if(confirmed == "0")
        {
            jQuery(this).data("confirmed", "1");
            jQuery(this).addClass("mec-fes-waiting");
            jQuery(this).text("'.esc_attr__('Click again to remove!', 'mec').'");
            
            return false;
        }

        // Add loading class to the row
        jQuery("#mec_fes_event_"+id).addClass("loading");
        
        jQuery.ajax(
        {
            type: "POST",
            url: "'.admin_url('admin-ajax.php', NULL).'",
            data: "action=mec_fes_remove&_wpnonce='.wp_create_nonce('mec_fes_remove').'&post_id="+id,
            dataType: "JSON",
            success: function(response)
            {
                if(response.success == "1")
                {
                    // Remove the row
                    jQuery("#mec_fes_event_"+id).remove();
                }
                else
                {
                    // Remove the loading class from the row
                    jQuery("#mec_fes_event_"+id).removeClass("loading");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Remove the loading class from the row
                jQuery("#mec_fes_event_"+id).removeClass("loading");
            }
        });
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);
?>
<div class="mec-fes-list">
    <?php if($query->have_posts()): ?>
    <div class="mec-fes-list-top-actions">
        <a href="<?php echo $this->link_add_event(); ?>"><?php echo __('Add new', 'mec'); ?></a>
    </div>
    <ul>
        <?php while($query->have_posts()): $query->the_post(); ?>
        <li id="mec_fes_event_<?php echo get_the_ID(); ?>">
            <span class="mec-event-title"><a href="<?php echo $this->link_edit_event(get_the_ID()); ?>"><?php the_title(); ?></a></span>
            <span class="mec-fes-event-view"><a href="<?php the_permalink(); ?>"><?php _e('View', 'mec'); ?></a></span>
            <?php if(current_user_can('delete_post', get_the_ID())): ?>
            <span class="mec-fes-event-remove" data-confirmed="0" data-id="<?php echo get_the_ID(); ?>"><?php _e('Remove', 'mec'); ?></span>
            <?php endif; ?>
        </li>
        <?php endwhile; wp_reset_postdata(); // Restore original Post Data ?>
    </ul>
    <?php else: ?>
    <p><?php echo sprintf(__('No events found! %s', 'mec'), '<a href="'.$this->link_add_event().'">'.__('Add new', 'mec').'</a>'); ?></p>
    <?php endif; ?>
</div>