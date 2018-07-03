jQuery(document).ready(function($) {

	"use strict";

	$('.grve-import-clear-selection').click(function(e) {
		e.preventDefault();
		$(this).closest( ".grve-importer-content" ).find('.grve-single-selector option:selected').prop("selected", false);
	});

	$('.grve-import-dummy-data').click(function(e) {
		e.preventDefault();
		var confirmText = grve_import_texts.confirmation_text;
		var dummySingularElement = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-singular');
		if( dummySingularElement.length ) {
			confirmText = grve_import_texts.confirmation_text_singular;
		}
		var grveConfirm = confirm( confirmText );
		if ( grveConfirm == true ) {

			$('#grve-import-output-info').hide().html('');
			$('#grve-import-output-container').hide().html('');

			$('.grve-import-dummy-data').attr('disabled','disabled').addClass('disabled');
			$('.grve-admin-dummy-item').hide();
			$('#grve-import-loading').show();
			$('#grve-import-countdown').show();

			//Show Loader
			$('#grve-importer-loader').show();

			var startTime = new Date();
			$('#grve-import-countdown').countdown('destroy');
			$('#grve-import-countdown').countdown({since: startTime, format: 'MS'});

			var dummyID = $(this).data('dummy-id');

			var dummySinglePages = false,
				dummyContent  = false,
				dummyOptions  = false,
				dummyWidgets  = false,
				dummySingular  = false,
				dummyDemoImages = false,
				dummySinglePages = '',
				dummySinglePosts = '',
				dummySinglePortfolios = '',
				dummySingleAreas = '',
				dummySingleProducts = '';

			var dummyNonce = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-dummy-nonce').val();

			if( dummySingularElement.length ) {
				dummySingular = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-singular').val();
				dummySinglePages = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-single-pages').val();
				dummySinglePosts = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-single-posts').val();
				dummySinglePortfolios = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-single-portfolios').val();
				dummySingleProducts = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-single-products').val();
				dummySingleAreas = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-single-areas').val();
				dummyDemoImages = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-single-demo-images').is(':checked');
			} else {
				dummyContent = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-dummy-content').is(':checked');
				dummyOptions = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-theme-options').is(':checked');
				dummyWidgets = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-widgets').is(':checked');
				if( $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-full-demo-images').length ) {
					dummyDemoImages = $(this).closest( ".grve-admin-dummy-item" ).find('.grve-admin-dummy-option-full-demo-images').is(':checked');
				}
			}

			$.post(
				ajaxurl, {
					action:'movedo_import_demo_data',
					grve_import_data: dummyID,
					grve_import_content: dummyContent,
					grve_import_options: dummyOptions,
					grve_import_widgets: dummyWidgets,
					grve_import_single_pages: dummySinglePages,
					grve_import_single_posts: dummySinglePosts,
					grve_import_single_portfolios: dummySinglePortfolios,
					grve_import_single_products: dummySingleProducts,
					grve_import_single_areas: dummySingleAreas,
					grve_import_singular: dummySingular,
					grve_import_demo_images: dummyDemoImages,
					nonce: dummyNonce
				},
				function( response ) {
					$('#grve-import-countdown').countdown('pause');
					$('#grve-import-loading').hide();
					if ( '-1' != response ) {
						if(response.changed){
							if(!response.errors){
								$( "#grve-import-finish-form" ).submit();
							} else {
								$('#grve-import-output-info').show().append(response.info);
								$('#grve-import-output-container').show().append(response.output);
								$('.grve-import-dummy-data').removeAttr('disabled').removeClass('disabled');
							}
						} else {
							$('#grve-import-countdown').hide();
							$('#grve-import-output-info').show().append(response.info);
							$('.grve-admin-dummy-item').show();
							$('.grve-import-dummy-data').removeAttr('disabled').removeClass('disabled');
						}
					}
				}
			);
		}

	});

});