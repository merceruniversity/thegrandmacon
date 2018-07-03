jQuery(document).ready(function($)
{
    // Check validation of grid skin event count
    $('#mec_skin_grid_count').keyup(function()
    {
        var valid = false;
        if($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == '4' || $(this).val() == '6' || $(this).val() == '12')
        {
            valid = true;
        };
        
        if(valid === false)
        {
            $(this).addClass('bootstrap_unvalid');
            $('.mec-tooltiptext').css('visibility','visible');
        }
        else
        {
            $(this).removeClass('bootstrap_unvalid');
            $('.mec-tooltiptext').css('visibility', 'hidden');
        };
    });

    // MEC Accordion
    $('.mec-accordion li').on('click', function()
    {
        var key = $(this).data('key');
        var status = $(this).data('status');

        // Open the accordion
        if(status === 'close')
        {
            $(this).parent().find('ul').hide();

            $('#mec-acc-'+key).show();
            $(this).data('status', 'open');
        }
        // Close the opened accordion
        else
        {
            $('#mec-acc-'+key).hide();
            $(this).data('status', 'close');
        }
    });

    // MEC Select, Deselect, Toggle
    $(".mec-select-deselect-actions li").on('click', function()
    {
        var target = $(this).parent().data('for');
        var action = $(this).data('action');
        
        if(action === 'select-all')
        {
            $(target+' input[type=checkbox]').each(function()
            {
                this.checked = true;
            });
        }
        else if(action === 'deselect-all')
        {
            $(target+' input[type=checkbox]').each(function()
            {
                this.checked = false;
            });
        }
        else if(action === 'toggle')
        {
            $(target+' input[type=checkbox]').each(function()
            {
                this.checked = !this.checked;
            });
        }
    });
    
    // MEC Single Event Display Method Switcher
    $(".mec-sed-methods li").on('click', function()
    {
        var target = $(this).parent().data('for');
        var method = $(this).data('method');
        
        // Set the Method
        $(target).val(method);
        
        // Set the active method
        $(this).parent().find('li').removeClass('active');
        $(this).addClass('active');
    });
    
    // Initialize WP Color Picker
    $('.mec-color-picker').wpColorPicker();
    
    // Initialize MEC Skin Switcher
    $('#mec_skin').on('change', function()
    {
        mec_skin_toggle();
    });
    
    mec_skin_toggle();
    
    $('.mec-switcher').on('click', 'label[for*="mec[settings]"]', function(event) {
        var id = $(this).closest('.mec-switcher').data('id');
        var status = $('#mec_sn_'+id+' .mec-status').val();

        if(status === '1')
        {
            $('#mec_sn_'+id+' .mec-status').val(0);
            $('#mec_sn_'+id).removeClass('mec-enabled').addClass('mec-disabled');
        }
        else
        {
            $('#mec_sn_'+id+' .mec-status').val(1);
            $('#mec_sn_'+id).removeClass('mec-disabled').addClass('mec-enabled');
        }

    });
    
    // MEC Checkbox Toggle (Used in Date Filter Options)
    $('.mec-checkbox-toggle').on('change', function()
    {
        var id = $(this).attr('id');
        $(".mec-checkbox-toggle:not(#"+id+")").attr('checked', false);
    });

});

function mec_skin_toggle()
{
    var skin = jQuery('#mec_skin').val();
    
    jQuery('.mec-skin-options-container').hide();
    jQuery('#mec_'+skin+'_skin_options_container').show();
    
    jQuery('.mec-search-form-options-container').hide();
    jQuery('#mec_'+skin+'_search_form_options_container').show();

    // Show/Hide Filter Options
    if(skin === 'countdown' || skin === 'cover' || skin === 'available_spot')
    {
        jQuery('#mec_meta_box_calendar_filter').hide();
        jQuery('#mec_meta_box_calendar_no_filter').show();
    }
    else
    {
        jQuery('#mec_meta_box_calendar_no_filter').hide();
        jQuery('#mec_meta_box_calendar_filter').show();
    }

    // Show/Hide Search Widget Options
    if(skin === 'countdown' || skin === 'cover' || skin === 'available_spot' || skin === 'masonry' || skin === 'carousel' || skin === 'slider')
    {
        jQuery('#mec_calendar_search_form').hide();
    }
    else
    {
        jQuery('#mec_calendar_search_form').show();
    }
    
    // Show/Hide Ongoing Events
    if(skin === 'list' || skin === 'grid') jQuery('#mec_date_ongoing_filter').show();
    else
    {
        jQuery("#mec_show_only_ongoing_events").attr('checked', false);
        jQuery('#mec_date_ongoing_filter').hide();
    }

    // Show/Hide Expired Events
    if(skin === 'map')
    {
        jQuery("#mec_show_only_past_events").attr('checked', false);
        jQuery('#mec_date_only_past_filter').hide();
    }
    else jQuery('#mec_date_only_past_filter').show();
    
    // Trigger change event of skin style in order to show/hide related fields
    jQuery('#mec_skin_'+skin+'_style').trigger('change');
}

function mec_skin_style_changed(skin, style)
{
    jQuery('.mec-skin-'+skin+'-date-format-container').hide();
    jQuery('#mec_skin_'+skin+'_date_format_'+style+'_container').show();
}

