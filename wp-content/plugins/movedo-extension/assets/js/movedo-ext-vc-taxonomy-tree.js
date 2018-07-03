
(function ($) {

	$('.grve-tree-input-item-all').click(function() {
		var $this = $(this);
		var $checkboxes_input = $this.closest( ".grve-taxonomy-tree-container" ).find('.wpb-checkboxes');
		var $tree_checkboxes = $this.closest( ".grve-taxonomy-tree-container" ).find('.grve-taxonomy-tree-checklist [type="checkbox"]');
		if ( $this.is(':checked') ) {
			$tree_checkboxes.attr('disabled','disabled');
			$tree_checkboxes.removeAttr('checked');
			$checkboxes_input.val('');
		} else {
			$tree_checkboxes.removeAttr('disabled');
		}
	});

	$( '.grve-tree-input-item-all' ).each(function( index ) {
	  var $this = $(this);
	  var $tree_checkboxes = $this.closest( ".grve-taxonomy-tree-container" ).find('.grve-taxonomy-tree-checklist [type="checkbox"]');
	  if ( $this.is(':checked') ) {
		$tree_checkboxes.attr('disabled','disabled');
	  }
	});

	$('.grve-taxonomy-tree-checklist [type="checkbox"]').click(function() {

		var $this = $(this);
		var $all_checkbox = $this.closest( ".grve-taxonomy-tree-container" ).find('.grve-tree-input-item-all');
		$all_checkbox.removeAttr('checked');

		var $checkboxes_input = $this.closest( ".grve-taxonomy-tree-container" ).find('.wpb-checkboxes');
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