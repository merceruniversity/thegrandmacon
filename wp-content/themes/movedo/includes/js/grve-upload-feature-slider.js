jQuery(document).ready(function($) {

	"use strict";

	var grveFeatureSliderFrame;
	var grveFeatureSliderContainer = $( "#grve-feature-slider-container" );
	grveFeatureSliderContainer.sortable();

	$('.grve-feature-slider-item-delete-button').click(function() {
		$(this).parent().remove();
	});

	$('.grve-upload-feature-slider-post-button').click(function() {

		var post_ids = $('#grve-upload-feature-slider-post-selection').val();
		if( '' != post_ids ) {
			$.post( movedo_grve_upload_feature_slider_texts.ajaxurl, { action:'movedo_grve_get_admin_feature_slider_media', post_ids: post_ids.toString() } , function( mediaHtml ) {
				grveFeatureSliderContainer.append(mediaHtml);
				$(this).bindFeatureSliderUpdatefunctions();
			});
		}

	});

	$('.grve-upload-feature-slider-button').click(function() {

        if ( grveFeatureSliderFrame ) {
            grveFeatureSliderFrame.open();
            return;
        }

        grveFeatureSliderFrame = wp.media.frames.grveFeatureSliderFrame = wp.media({
            className: 'media-frame grve-media-feature-slider-frame',
            frame: 'select',
            multiple: 'toggle',
            title: movedo_grve_upload_feature_slider_texts.modal_title,
            library: {
                type: 'image'
            },
            button: {
                text:  movedo_grve_upload_feature_slider_texts.modal_button_title
            }

        });
        grveFeatureSliderFrame.on('select', function(){
			var selection = grveFeatureSliderFrame.state().get('selection');
			var ids = selection.pluck('id');

			$('#grve-upload-feature-slider-button-spinner').show();

			$.post( movedo_grve_upload_feature_slider_texts.ajaxurl, { action:'movedo_grve_get_admin_feature_slider_media', attachment_ids: ids.toString() } , function( mediaHtml ) {
				grveFeatureSliderContainer.append(mediaHtml);
				$(this).bindFeatureSliderUpdatefunctions();
			});
        });
        grveFeatureSliderFrame.on('ready', function(){
			$( '.media-modal' ).addClass( 'grve-media-no-sidebar' );
        });


        grveFeatureSliderFrame.open();
    });

	$.fn.bindFeatureSliderUpdatefunctions = function(){
		$('.grve-feature-slider-item-delete-button.grve-item-new').click(function() {
			$(this).parent().remove();
		}).removeClass('grve-item-new');

		$('.grve-item-new .grve-upload-replace-image').bind("click",(function(){
			$(this).bindUploadReplaceImage();
		}));

		$('.grve-item-new .grve-upload-remove-image').bind("click",(function(e){
			$(this).bindUploadRemoveImage(e);
		}));

		$('.grve-open-slider-modal.grve-item-new').bind("click",(function(e){
			e.preventDefault();
			$(this).bindOpenSliderModal();
		})).removeClass('grve-item-new');

		$('.grve-tabs .grve-tab-links a').off("click").on("click", (function(e) {
			$(this).bindTabsMetaboxes(e);
		}));

		$('.grve-dependency-field').off("change").on("change",(function(){
			$(this).bindFieldsDependency();
		}));

		$('.postbox.grve-item-new .handlediv').on('click', function() {
			var p = $(this).parent('.postbox');

			p.removeClass('grve-item-new');
			p.toggleClass('closed');

		});

		$('.grve-slider-item.grve-item-new .wp-color-picker-field').wpColorPicker();


		$('.grve-slider-item.grve-item-new .grve-select-color-extra').change(function() {
			if( 'custom' == $(this).val() ) {
				$(this).parents('.grve-field-items-wrapper').find('.grve-wp-colorpicker').show();
			} else {
				$(this).parents('.grve-field-items-wrapper').find('.grve-wp-colorpicker').hide();
			}
		});

		$('.grve-slider-item.grve-item-new').removeClass('grve-item-new');

		$('#grve-upload-feature-slider-button-spinner').hide();

		$( "[data-dependency]" ).initFieldsDependency();

		$('.grve-admin-label-update').off("change").on("change",(function(){
			$(this).bindFieldsAdminLabelUpdate();
		}));
    }

	if( $('.grve-post-selector-select2').length ) {
		$('.grve-post-selector-select2').select2( {
			placeholder: 'Select a post',
			multiple: true,
			minimumInputLength: 3,
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				data: function (term, page) {
					return {
						q: term,
						action: 'movedo_grve_post_select_lookup',
					};
				},
				results: grveProcessPostSelectDataForSelect2
			},
			initSelection: function(element, callback) {
				var ids=$(element).val();
				if (ids!=="") {
					$.ajax(ajaxurl, {
						data: {
							action: 'movedo_grve_get_post_titles',
							post_ids: ids
						},
						dataType: "json"
					}).done(function(data) {
						var processedData = grveProcessPostSelectDataForSelect2(data);
						callback(processedData.results); });
				}
			},
		});
	}


});

function grveProcessPostSelectDataForSelect2( ajaxData, page, query ) {

	var items=[];
	var newItem=null;

	for (var thisId in ajaxData) {
		newItem = {
			'id': ajaxData[thisId]['id'],
			'text': ajaxData[thisId]['title']
		};
		items.push(newItem);
	}
	return { results: items };
}