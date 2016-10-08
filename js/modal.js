function modalAlert(id, title, msg, redirect)
{
	if (!$('#' + id).length) $('body').append('<div class="reveal-modal tiny" id="' + id + '" data-reveal><h2>' + title + '</h2><p class="lead">' + msg + '</p><a class="close-reveal-modal" aria-label="Close">&#215;</a></div>');	
	
	if (redirect) $(document).on('closed.fndtn.reveal', '[data-reveal]', function() { $(location).attr('href', redirect); });
	
	$('#' + id).foundation('reveal', 'open');
}

function modalImage(id, title, img)
{
	if (!$('#' + id).length) $('body').append('<div id="' + id + '"><div class="modalBody"><img src="' + img + '"></div></div>');
		
	$('#' + id).dialog(
	{
		modal: true,
		autoOpen: true,
		resizable: false,
		draggable: false,
		width: 'auto',
		show:
		{
			effect: 'fade',
	        duration: 500
		},
		hide:
		{
			effect: 'fade',
			duration: 500
		},
		title: title,
		open: function()
		{
			$('.ui-dialog-titlebar-close .ui-button-text').html('<i class="fa fa-times"></i>');
		    $('.ui-dialog-content').dialog('option', 'position', 'center');
		}
	});
}

function modalSubscribe(id)
{
	$('#' + id).foundation('reveal', 'open');
	$(document).on('closed.fndtn.reveal', '[data-reveal]', function()
	{
		var expirationDt = new Date(new Date().getTime() + 24*60*60*1000);
		document.cookie = 'SUBSCRIBE_MODAL=1; expires=' + expirationDt + '; path=/';
	});
}