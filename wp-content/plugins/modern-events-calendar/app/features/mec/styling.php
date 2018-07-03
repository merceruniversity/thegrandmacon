<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$styling = $this->main->get_styling();
$fonts = include MEC::import('app.features.mec.webfonts.webfonts', true, true);

$google_fonts = array();
$google_fonts['none'] = array(
	'label'=>esc_html__('Default Font', 'mec'),
	'variants'=>array('regular'),
	'subsets'=>array(),
	'category'=>'',
    'value'=>'',
);

if(is_array($fonts))
{
	foreach($fonts['items'] as $font)
    {
        $google_fonts[$font['family']] = array(
            'label'=>$font['family'],
            'variants'=>$font['variants'],
            'subsets'=>$font['subsets'],
            'category'=>$font['category'],
        );
    }
}
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

                <li class="wns-be-group-menu-li">
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

            <li class="wns-be-group-menu-li active">
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
                <h2><?php _e('Styling Option', 'mec'); ?></h2>
                <div class="mec-container">
                    <form id="mec_styling_form">
                        <?php /*<!-- <p>
                            <input type="text" class="wp-color-picker-field" id="mec_settings_color" name="mec[styling][color]" value="<?php echo (isset($styling['color']) ? $styling['color'] : ''); ?>" data-default-color="" />
                        </p>
                        <p>
                            <input type="text" class="up-text wpsa-url" id="mec_settings_upload" name="mec[styling][upload]" value="<?php echo (isset($styling['upload']) ? $styling['upload'] : ''); ?>"/>
                            <input type="button" class="button wpsa-browse" value="Upload" />
                        </p>
                        <p>
                        </p>
                        <p>
                            <input type="text" id="mec_settings_text" name="mec[styling][text]" value="<?php echo ((isset($styling['text']) and trim($styling['text']) != '') ? $styling['text'] : ''); ?>" />
                        </p> -->
                        <!-- <input type="text" class="wp-color-picker-field" id="mec_settings_color" name="mec[styling][color]" value="<?php echo (isset($styling['color']) ? $styling['color'] : ''); ?>" data-default-color="" /> -->*/ ?>

                        <!-- Colorskin -->
                        <h4 class="mec-form-subtitle"><?php esc_html_e('Color Skin', 'mec' ); ?></h4>
                        <div class="mec-form-row">
                            <div class="mec-col-3">
                                <p><?php esc_html_e('Predefined Color Skin', 'mec' ); ?></p>
                            </div>
                            <div class="mec-col-6">
                                <ul class="mec-image-select-wrap">
                                    <?php
                                    $colorskins = array(
                                        '#40d9f1'=>'mec-colorskin-1',
                                        '#0093d0'=>'mec-colorskin-2',
                                        '#e53f51'=>'mec-colorskin-3',
                                        '#f1c40f'=>'mec-colorskin-4',
                                        '#e64883'=>'mec-colorskin-5',
                                        '#45ab48'=>'mec-colorskin-6',
                                        '#9661ab'=>'mec-colorskin-7',
                                        '#0aad80'=>'mec-colorskin-8',
                                        '#0ab1f0'=>'mec-colorskin-9',
                                        '#ff5a00'=>'mec-colorskin-10',
                                        '#c3512f'=>'mec-colorskin-11',
                                        '#55606e'=>'mec-colorskin-12',
                                        '#fe8178'=>'mec-colorskin-13',
                                        '#7c6853'=>'mec-colorskin-14',
                                        '#bed431'=>'mec-colorskin-15',
                                        '#2d5c88'=>'mec-colorskin-16',
                                        '#77da55'=>'mec-colorskin-17',
                                        '#2997ab'=>'mec-colorskin-18',
                                        '#734854'=>'mec-colorskin-19',
                                        '#a81010'=>'mec-colorskin-20',
                                        '#4ccfad'=>'mec-colorskin-21',
                                        '#3a609f'=>'mec-colorskin-22'
                                        );

                                        foreach($colorskins as $colorskin=>$values): ?>
                                        <li class="mec-image-select">
                                            <label for="<?php echo $values; ?>">
                                                <input type="radio" id="<?php echo $values; ?>" name="mec[styling][mec_colorskin]" value="<?php echo $colorskin; ?>" <?php if(isset($styling['mec_colorskin']) && ($styling['mec_colorskin'] == $colorskin)) echo 'checked="checked"'; ?>>
                                                <span class="<?php echo $values; ?>"></span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="mec-form-row">
                            <div class="mec-col-3">
                                <p><?php esc_html_e('Custom Color Skin', 'mec' ); ?></p>
                            </div>
                            <div class="mec-col-6">
                                <input type="text" class="wp-color-picker-field" id="mec_settings_color" name="mec[styling][color]" value="<?php echo (isset($styling['color']) ? $styling['color'] : ''); ?>" data-default-color="" />
                            </div>
                        </div>

                        <!-- Typography -->
                        <h4 class="mec-form-subtitle"><?php esc_html_e('Typography', 'mec' ); ?></h4>
                        <div class="mec-form-row">
                            <label class="mec-col-3" for="mec_h_fontfamily"><?php _e('Heading (Events Title) Font Family', 'mec'); ?></label>
                            <div class="mec-col-4">

                                <select class="mec-p-fontfamily" name="mec[styling][mec_h_fontfamily]" id="mec_h_fontfamily">
                                    <?php
                                    foreach($google_fonts as $google_font)
                                    {
                                        $variants = '';
                                        foreach($google_font['variants'] as $key=>$variant)
                                        {
                                            $variants .= $variant;
                                            if(next($google_font['variants']) == true) $variants .= ",";
                                        }

                                        $value = (isset($google_font['value']) ? $google_font['value'] : '['. $google_font['label'] .','. $variants .']');
                                        if($value == '['.__('Default Font', 'mec').',regular]') $value = '';
                                        ?>
                                        <option value="<?php echo $value; ?>" <?php if(isset($styling['mec_h_fontfamily']) and ($styling['mec_h_fontfamily'] == $value)) echo 'selected="selected"'; ?>><?php echo $google_font['label']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="mec-form-row">
                            <label class="mec-col-3" for="mec_p_fontfamily"><?php _e('Paragraph Font Family', 'mec'); ?></label>
                            <div class="mec-col-4">

                                <select class="mec-p-fontfamily" name="mec[styling][mec_p_fontfamily]" id="mec_p_fontfamily">
                                    <?php
                                    foreach($google_fonts as $google_font)
                                    {
                                        $variants = '';
                                        foreach($google_font['variants'] as $key=>$variant)
                                        {
                                            $variants .= $variant;
                                            if(next($google_font['variants']) == true) $variants .= ",";
                                        }
                                        
                                        $value = (isset($google_font['value']) ? $google_font['value'] : '['. $google_font['label'] .','. $variants .']');
                                        if($value == '['.__('Default Font', 'mec').',regular]') $value = '';
                                        ?>
                                        <option value="<?php echo $value; ?>" <?php if(isset($styling['mec_p_fontfamily'] ) && ($styling['mec_p_fontfamily'] == $value ) ) echo 'selected'; ?>><?php echo $google_font['label']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <!-- Container Width -->
                        <h4 class="mec-form-subtitle"><?php esc_html_e('Container Width', 'mec' ); ?></h4>                    
                        <div class="mec-form-row">
                            <label class="mec-col-3" for="mec_styling_container_normal_width"><?php _e('Desktop Normal Screens', 'mec'); ?></label>
                            <div class="mec-col-4">
                                <input type="text" id="mec_styling_container_normal_width" name="mec[styling][container_normal_width]" value="<?php echo ((isset($styling['container_normal_width']) and trim($styling['container_normal_width']) != '') ? $styling['container_normal_width'] : ''); ?>" />
                                <a class="mec-tooltip" title="<?php esc_attr_e("You can enter your theme container size in this field", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                            </div>
                        </div>
                        <div class="mec-form-row">
                            <label class="mec-col-3" for="mec_styling_container_large_width"><?php _e('Desktop Large Screens', 'mec'); ?></label>
                            <div class="mec-col-4">
                                <input type="text" id="mec_styling_container_large_width" name="mec[styling][container_large_width]" value="<?php echo ((isset($styling['container_large_width']) and trim($styling['container_large_width']) != '') ? $styling['container_large_width'] : ''); ?>" />
                                <a class="mec-tooltip" title="<?php esc_attr_e("You can enter your theme container size in this field", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                            </div>
                        </div>


                        <div class="mec-form-row">
                            <?php wp_nonce_field('mec_options_form'); ?>
                            <button  style="display: none;" id="mec_styling_form_button" class="button button-primary mec-button-primary" type="submit"><?php _e('Save Changes', 'mec'); ?></button>
                        </div>
                    </form>
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
        jQuery("#mec_styling_form_button").trigger('click');
    });
});
(function($)
{
	'use strict';
	$(document).ready(function()
    {
        //Initiate Color Picker
        $('.wp-color-picker-field').wpColorPicker();
    });
    
	$('.wpsa-browse').click(function(e)
    {
		e.preventDefault();
		var image = wp.media({
			title: 'Upload',
			multiple: false
		}).open()
		.on('select', function(e)
        {
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			$('#mec_settings_upload').val(image_url);
		});
	});
    
})(jQuery);

jQuery("#mec_styling_form").on('submit', function(event)
{
	event.preventDefault();

    // Add loading Class to the button
    jQuery(".dpr-save-btn").addClass('loading').text("<?php echo esc_js(esc_attr__('Saved', 'mec')); ?>");
    jQuery('<div class="wns-saved-settings"><?php echo esc_js(esc_attr__('Settings Saved!', 'mec')); ?></div>').insertBefore('#wns-be-content');

    var styling = jQuery("#mec_styling_form").serialize();

    jQuery.ajax(
    {
    	type: "POST",
    	url: ajaxurl,
    	data: "action=mec_save_styling&"+styling,
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