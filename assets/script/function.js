jQuery(document).ready(function($){
	var _custom_media = true,
	_orig_send_attachment = wp.media.editor.send.attachment;

	$(".nitea-category-image_uploader .button").click(function(e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var $button = $(this);
		var $parent = $(this).parents('.nitea-category-image_uploader');

		_custom_media = true;
		wp.media.editor.send.attachment = function(props, attachment){
			if ( _custom_media ) {
				$parent.find('.nitea-category-image_input').val(attachment.url);
				$parent.find('.nitea-category-image_current-image').attr('src',attachment.url);
				$parent.find('.nitea-category-image_info-text').html("En ny bild är vald - Glöm ej att spara");
				$parent.find('.button').val("Byt bild");
			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}
		wp.media.editor.open($button);
		return false;
	});
	$(".add_media").on("click", function(){
		_custom_media = false;
	});
});