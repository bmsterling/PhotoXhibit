(function ($) {
	$(document).ready(function(){
		var jQbsg_stylesTextarea = $('#px_stylesTextarea');
		var jQbsg_processStyles = $('#px_processStyles');
		var baseUrl = '<?php echo str_replace( array($_SERVER['HTTP_HOST'], "http://"), "", $this->parentFileUrl);?>';

		jQbsg_processStyles.click(function(){
			
			$.ajax({
				url : baseUrl,
				data : 'option=update_styles&gid='+$('#px_gid').val()+'&styles='+jQbsg_stylesTextarea.val(),
				dataType : 'json',
				type : 'POST',
				success : function(data, textStatus){
					if(data.error == 'error_no_styles'){
						alert('Sorry, but the styles were not passed to the server, please try again.');
					}
					else if(data.error == 'error_no_id'){
						alert('Sorry, but the ID was not passed to the server, please try again.');
					}
					else{
						var href = $('#px_editstylesheet').attr('href') + '&' + new Date().getTime();

						$('#px_editstylesheet').remove();
						var c = document.createElement('link');
						c.id = 'px_editstylesheet';
						c.type = 'text/css';
						c.media = 'screen';
						c.rel = 'stylesheet';
						c.href = href;
						$('head')[0].appendChild(c);
					}
				}				
			});
			return false;
		});
		
		$('#finGallery').height($('#finGallery').height()+100);
	});
})(jQuery);