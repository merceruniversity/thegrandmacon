jQuery(document).ready(function($) {

	"use strict";

	$('.grve-custom-sidebar-item-delete-button').click(function() {
		$(this).parent().remove();
	});

	$('#grve-add-custom-sidebar-item').click(function() {

		$('#grve-sidebar-wrap .button').attr('disabled','disabled').addClass('disabled');
		$('.grve-sidebar-notice').hide();
		$('.grve-sidebar-notice-exists').hide();
		$('.grve-sidebar-spinner').show();

		var sidebarName = $('#grve-custom-sidebar-item-name-new').val();

		if ( '' == $.trim(sidebarName) ) {
			$('.grve-sidebar-notice').show();
			$('.grve-sidebar-spinner').hide();
			$('#grve-sidebar-wrap .button').removeAttr('disabled').removeClass('disabled');
		} else {

			var alreadyExists = false;
			$('#grve-sidebar-wrap .grve-custom-sidebar-item-name').each(function () {
				if( $(this).val() == sidebarName ) {
					alreadyExists = true;
					return false;
				}
			});
			if ( alreadyExists ) {
				$('.grve-sidebar-notice-exists').show();
				$('.grve-sidebar-spinner').hide();
				$('#grve-sidebar-wrap .button').removeAttr('disabled').removeClass('disabled');
			} else {
				$.post( movedo_grve_custom_sidebar_texts.ajaxurl, { action:'movedo_grve_get_custom_sidebar', sidebar_name: sidebarName } , function( sidebarHtml ) {
					$('#grve-custom-sidebar-container').append(sidebarHtml);

					$('.grve-custom-sidebar-item-delete-button.grve-item-new').click(function() {
						$(this).parent().remove();
					}).removeClass('grve-item-new');

					$('#grve-custom-sidebar-item-name-new').val('');
					$('.grve-sidebar-spinner').hide();
					$('#grve-sidebar-wrap .button').removeAttr('disabled').removeClass('disabled');
				});
			}
		}
	});

	$( "#grve-custom-sidebar-container" ).sortable();
	$('.grve-sidebar-saved').delay(4000).slideUp();


});