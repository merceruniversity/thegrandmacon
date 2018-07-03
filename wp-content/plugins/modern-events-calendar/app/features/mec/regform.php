<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$reg_fields = $this->main->get_reg_fields();
?>
<div class="wns-be-container">

    <div class="wns-be-sidebar">

        <ul class="wns-be-group-menu">

            <li class="wns-be-group-menu-li has-sub">
                <a href="<?php echo $this->main->remove_qs_var('tab'); ?>" id="" class="wns-be-group-tab-link-a">
                    <span class="extra-icon">
                        <i class="sl-arrow-down"></i>
                    </span>
                    <i class="mec-sl-settings"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Settings', 'mec'); ?></span>
                </a>
            </li>

            <?php if(isset($this->settings['booking_status']) and $this->settings['booking_status']): ?>

                <li class="wns-be-group-menu-li active">
                    <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-reg-form'); ?>" id="" class="wns-be-group-tab-link-a">
                        <i class="mec-sl-layers"></i> 
                        <span class="wns-be-group-menu-title"><?php _e('Booking Form', 'mec'); ?></span>
                    </a>
                </li>    

                <li class="wns-be-group-menu-li">
                    <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-gateways'); ?>" id="" class="wns-be-group-tab-link-a">
                        <i class="mec-sl-wallet"></i> 
                        <span class="wns-be-group-menu-title"><?php _e('Payment Gateways', 'mec'); ?></span>
                    </a>
                </li>
            <?php endif;?>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-notifications'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-envelope"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Notifications', 'mec'); ?></span>
                </a>
            </li> 

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-styling'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-equalizer"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Styling Options', 'mec'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-customcss'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-wrench"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Custom CSS', 'mec'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-messages'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-bubble"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Messages', 'mec'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-support'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-support"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Support', 'mec'); ?></span>
                </a>
            </li>

        </ul>
    </div>

    <div class="wns-be-main">

        <div id="wns-be-infobar">
            <a href="" id="" class="dpr-btn dpr-save-btn">Save Changes</a>
        </div>

        <div id="wns-be-notification"></div>

        <div id="wns-be-content">
            <div class="wns-be-group-tab">
                <h2><?php _e('Booking Form', 'mec'); ?></h2>
                <div class="mec-container">
                    <form id="mec_reg_fields_form">
                        <div class="mec-form-row" id="mec_reg_form_container">

                            <?php /** Don't remove this hidden field **/ ?>
                            <input type="hidden" name="mec[reg_fields]" value="" />

                            <ul id="mec_reg_form_fields">
                                <?php
                                $i = 0;
                                foreach($reg_fields as $key=>$reg_field)
                                {
                                    if(!is_numeric($key)) continue;
                                    $i = max($i, $key);

                                    if($reg_field['type'] == 'text') echo $this->main->field_text($key, $reg_field);
                                    elseif($reg_field['type'] == 'email') echo $this->main->field_email($key, $reg_field);
                                    elseif($reg_field['type'] == 'tel') echo $this->main->field_tel($key, $reg_field);
                                    elseif($reg_field['type'] == 'textarea') echo $this->main->field_textarea($key, $reg_field);
                                    elseif($reg_field['type'] == 'p') echo $this->main->field_p($key, $reg_field);
                                    elseif($reg_field['type'] == 'checkbox') echo $this->main->field_checkbox($key, $reg_field);
                                    elseif($reg_field['type'] == 'radio') echo $this->main->field_radio($key, $reg_field);
                                    elseif($reg_field['type'] == 'select') echo $this->main->field_select($key, $reg_field);
                                    elseif($reg_field['type'] == 'agreement') echo $this->main->field_agreement($key, $reg_field);
                                }
                                ?>
                            </ul>
                            <div id="mec_reg_form_field_types">
                                <button type="button" class="button" data-type="text"><?php _e('Text', 'mec'); ?></button>
                                <button type="button" class="button" data-type="email"><?php _e('Email', 'mec'); ?></button>
                                <button type="button" class="button" data-type="tel"><?php _e('Tel', 'mec'); ?></button>
                                <button type="button" class="button" data-type="textarea"><?php _e('Textarea', 'mec'); ?></button>
                                <button type="button" class="button" data-type="checkbox"><?php _e('Checkboxes', 'mec'); ?></button>
                                <button type="button" class="button" data-type="radio"><?php _e('Radio Buttons', 'mec'); ?></button>
                                <button type="button" class="button" data-type="select"><?php _e('Dropdown', 'mec'); ?></button>
                                <button type="button" class="button" data-type="agreement"><?php _e('Agreement', 'mec'); ?></button>
                                <button type="button" class="button" data-type="p"><?php _e('Paragraph', 'mec'); ?></button>
                            </div>
                        </div>
                        <div class="mec-form-row">
                            <?php wp_nonce_field('mec_options_form'); ?>
                            <button  style="display: none;" id="mec_reg_fields_form_button" class="button button-primary mec-button-primary" type="submit"><?php _e('Save Changes', 'mec'); ?></button>
                        </div>
                    </form> 
                </div>
                <input type="hidden" id="mec_new_reg_field_key" value="<?php echo $i+1; ?>" />
                <div class="mec-util-hidden">
                    <div id="mec_reg_field_text">
                        <?php echo $this->main->field_text(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_email">
                        <?php echo $this->main->field_email(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_tel">
                        <?php echo $this->main->field_tel(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_textarea">
                        <?php echo $this->main->field_textarea(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_checkbox">
                        <?php echo $this->main->field_checkbox(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_radio">
                        <?php echo $this->main->field_radio(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_select">
                        <?php echo $this->main->field_select(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_agreement">
                        <?php echo $this->main->field_agreement(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_p">
                        <?php echo $this->main->field_p(':i:'); ?>
                    </div>
                    <div id="mec_reg_field_option">
                        <?php echo $this->main->field_option(':fi:', ':i:'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="wns-be-footer">
            <a href="" id="" class="dpr-btn dpr-save-btn">Save Changes</a>
        </div>
    </div>

</div>

<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery(".dpr-save-btn").on('click', function(event) {
            event.preventDefault();
        jQuery("#mec_reg_fields_form_button").trigger('click');
    });
});
jQuery("#mec_reg_fields_form").on('submit', function(event)
{
    event.preventDefault();
    
    // Add loading Class to the button
    jQuery(".dpr-save-btn").addClass('loading').text("<?php echo esc_js(esc_attr__('Saved', 'mec')); ?>");
    jQuery('<div class="wns-saved-settings"><?php echo esc_js(esc_attr__('Settings Saved!', 'mec')); ?></div>').insertBefore('#wns-be-content');

    var fields = jQuery("#mec_reg_fields_form").serialize();
    jQuery.ajax(
    {
        type: "POST",
        url: ajaxurl,
        data: "action=mec_save_reg_form&"+fields,
        success: function(data)
        {
            // Remove the loading Class to the button
            setTimeout(function(){
                jQuery(".dpr-save-btn").removeClass('loading').text("<?php echo esc_js(esc_attr__('Save Changes', 'mec')); ?>");
                jQuery('.wns-saved-settings').remove();
            }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            setTimeout(function(){
                jQuery(".dpr-save-btn").removeClass('loading').text("<?php echo esc_js(esc_attr__('Save Changes', 'mec')); ?>");
                jQuery('.wns-saved-settings').remove();
            }, 1000);
        }
    });
});
</script>