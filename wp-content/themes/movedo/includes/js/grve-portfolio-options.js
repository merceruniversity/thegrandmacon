jQuery(document).ready(function($) {

	"use strict";

	$('#grve-portfolio-media-selection').change(function() {

		$('.grve-portfolio-media-item').hide();

		switch($(this).val())
		{
			case "gallery":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-image-link-mode').stop( true, true ).fadeIn(500);
				$('#grve-portfolio-media-slider').stop( true, true ).fadeIn(500);
				$('#grve-slider-container').stop( true, true ).fadeIn(500);
			break;
			case "gallery-vertical":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
				if ( 'no' == $('#grve-portfolio-media-fullwidth').val() ) {
					$('.grve-portfolio-media-image-mode').stop( true, true ).fadeIn(500);
				}
				$('.grve-portfolio-media-image-link-mode').stop( true, true ).fadeIn(500);
				$('#grve-portfolio-media-slider').stop( true, true ).fadeIn(500);
				$('#grve-slider-container').stop( true, true ).fadeIn(500);
			break;
			case "slider":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
				if ( 'no' == $('#grve-portfolio-media-fullwidth').val() ) {
					$('.grve-portfolio-media-image-mode').stop( true, true ).fadeIn(500);
				}
				$('#grve-portfolio-media-slider').stop( true, true ).fadeIn(500);
				$('#grve-portfolio-media-slider-speed').stop( true, true ).fadeIn(500);
				$('#grve-portfolio-media-slider-direction-nav').stop( true, true ).fadeIn(500);
				$('#grve-portfolio-media-slider-direction-nav-color').stop( true, true ).fadeIn(500);
				$('#grve-slider-container').stop( true, true ).fadeIn(500);
			break;
			case "video":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-video-embed').stop( true, true ).fadeIn(500);
			break;
			case "video-html5":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-video-html5').stop( true, true ).fadeIn(500);
			break;
			case "video-code":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-video-code').stop( true, true ).fadeIn(500);
			break;
			case "":
			case "second-image":
				$('.grve-portfolio-media-fullwidth').stop( true, true ).fadeIn(500);
				$('.grve-portfolio-media-margin-bottom').stop( true, true ).fadeIn(500);
			break;
			default:
			break;
		}
	});


	$('#grve-portfolio-media-fullwidth').change(function() {
		switch($(this).val())
		{
			case "yes":
				$('.grve-portfolio-media-image-mode').hide();
			break;
			default:
				if ( 'slider' == $('#grve-portfolio-media-selection').val() || 'gallery-vertical' == $('#grve-portfolio-media-selection').val() ) {
					$('.grve-portfolio-media-image-mode').stop( true, true ).fadeIn(500);
				}
			break;
		}
	});

	$('#grve-portfolio-link-mode').change(function() {
		switch($(this).val())
		{
			case "link":
				$('.grve-portfolio-custom-link-mode').stop( true, true ).fadeIn(500);
			break;
			default:
				$('.grve-portfolio-custom-link-mode').hide();
			break;
		}
	});

	$(window).load(function(){
		$('#grve-portfolio-media-selection').change();
		$('#grve-portfolio-link-mode').change();
	});

});