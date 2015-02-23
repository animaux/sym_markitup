(function($) {

	$(document).ready(function(){
		var $formatters = $( "select[name*='formatter']" );

		$formatters.each(function(){
			var $this = $(this);
			if ( $this.val() != 'none' ){
				var fieldPrefix = $this.attr('name').substring(0,$this.attr('name').lastIndexOf('['));
				var fieldID = $this.closest('li').find('input[name="'+fieldPrefix+'[id]"]').val();
				var $select = $("<select name='"+fieldPrefix+"[markitup][]' multiple='multiple'></select>");
				for (var i = 0; i < Symphony.MarkItUp.buttons.length; i++) {
					var name = Symphony.MarkItUp.buttons[i]['name'];
					if (typeof name !== 'undefined'){
						$option = $('<option value="'+name+'">' + name + '</option>');
						if (typeof(Symphony.MarkItUp.fields[fieldID]) == 'undefined' || Symphony.MarkItUp.fields[fieldID].indexOf(name) !== -1){
							$option.prop('selected','selected');
						}
						$select.append($option);
					}
				};
				$label = $('<label class="column">Formatter Options</label>');
				$label.append($select);

				$this.parent('label').after($label);

				var $fieldInstance = $this.closest('li.instance');

				var currentHeight = parseInt($fieldInstance.css('max-height'), 10);
				$fieldInstance.css('max-height', (currentHeight + $label.outerHeight()) + "px");
			}
		});

	});

})(jQuery);