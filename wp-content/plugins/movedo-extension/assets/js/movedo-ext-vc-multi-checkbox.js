
(function ($) {

	$('.grve-checkbox-input-item-all').click(function() {
		var $this = $(this);
		var $checkboxes_input = $this.closest( ".grve-multi-checkbox-container" ).find('.wpb-checkboxes');
		var $tree_checkboxes = $this.closest( ".grve-multi-checkbox-container" ).find('.grve-checkbox-input-item');
		if ( $this.is(':checked') ) {
			$tree_checkboxes.removeAttr('checked');
			$tree_checkboxes.attr('disabled','disabled');
			$checkboxes_input.val('');
		} else {
			$tree_checkboxes.removeAttr('disabled');
		}
	});

	$( '.grve-checkbox-input-item-all' ).each(function( index ) {
	  var $this = $(this);
	  var $tree_checkboxes = $this.closest( ".grve-multi-checkbox-container" ).find('.grve-checkbox-input-item');
	  if ( $this.is(':checked') ) {
		$tree_checkboxes.attr('disabled','disabled');
	  }
	});

	$('.grve-checkbox-input-item').click(function() {
	
		var $this = $(this);
		var $all_checkbox = $this.closest( ".grve-multi-checkbox-container" ).find('.grve-checkbox-input-item-all');
		$all_checkbox.removeAttr('checked');

		var $checkboxes_input = $this.closest( ".grve-multi-checkbox-container" ).find('.wpb-checkboxes');
		var arrayValues = $checkboxes_input.val().split(',');

		if ( $this.is(':checked') ) {
			arrayValues.push($this.val());
			var emptyKey = arrayValues.indexOf("");
			if ( emptyKey > -1 ) {
				arrayValues.splice( emptyKey, 1 );
			}
		} else {
			var foundKey = arrayValues.indexOf( $this.val() );
			if ( foundKey > -1 ) {
				arrayValues.splice( foundKey, 1 );
			}
		}
		$checkboxes_input.val( arrayValues.join(',') );
	});


})(jQuery);