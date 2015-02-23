// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------

// mIu nameSpace to avoid conflict.
miu = {
	markdownTitle: function(markItUp, char) {
		heading = '';
		n = jQuery.trim(markItUp.selection||markItUp.placeHolder).length;
		for(i = 0; i < n; i++) {
			heading += char;
		}
		return '\n'+heading;
	}
}

jQuery(document).ready(function(){
	jQuery('textarea.markdown, textarea.markdown_extra, textarea.markdown_extra_with_smartypants, textarea.markdown_with_purifier').each(function(){
		Symphony.MarkItUp.field = jQuery(this).closest('.field').attr('id').substring(6);
		jQuery(this).markItUp({
			nameSpace:          'markdown', // Useful to prevent multi-instances CSS conflict
			onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
			markupSet: Symphony.MarkItUp.buttons.filter(
					function(value){
						return Symphony.MarkItUp.fields[Symphony.MarkItUp.field].indexOf(value.name) !== -1;
					}
				)
		});
	});
});