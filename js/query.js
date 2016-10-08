function query(formId, btnId, action)
{
	var formFeedbackId = '#' + formId + ' .feedback';
	var emptyFieldCount = 0;
	var invalidEmailCount = 0;
	var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	
	$('#' + formId + ' :input').each(function(index)
	{
		if ($(this).hasClass('required'))
		{
			if (($(this).attr('type') == 'text' || $(this).attr('type') == 'textarea') && $.trim($(this).val()) == '')
			{
				$(this).addClass('warning');
				emptyFieldCount ++;
			}
			else $(this).removeClass('warning');
			
			if ($(this).attr('type') == 'checkbox' && !$(this).is(':checked'))
			{
				$('#' + $(this).attr('id') + 'Label').addClass('warning');
				emptyFieldCount ++;
			}
			else $('#' + $(this).attr('id') + 'Label').removeClass('warning');
		}
				
		if ($(this).attr('type') == 'text' && $(this).attr('name').search(/email/i) !== -1 && $.trim($(this).val()) != '')
		{
			if (!emailRegex.test($(this).val()))
			{
				$(this).addClass('warning');
				invalidEmailCount ++;
			}
			else $(this).removeClass('warning');
		}
	});
	
	if (emptyFieldCount != 0)
	{
		$(formFeedbackId).hide();
		$(formFeedbackId).html('<div data-alert class="alert-box warning radius">Please fill in all required fields<a href="#" class="close">&times;</a></div>');
		$(document).foundation('alert', 'reflow');
		$(formFeedbackId).fadeIn(500);
	}
	else if (invalidEmailCount != 0)
	{
		$(formFeedbackId).hide();
		$(formFeedbackId).html('<div data-alert class="alert-box warning radius">Invalid email format<a href="#" class="close">&times;</a></div>');
		$(document).foundation('alert', 'reflow');
		$(formFeedbackId).fadeIn(500);
	}
	else
	{
		if (!$(formFeedbackId).html()) $(formFeedbackId).hide();
		
		$('#' + btnId).attr('disabled', 'disabled');
		$('#' + btnId).addClass('disabled');
		$('#' + btnId + ' .fa-spin').css('visibility', 'visible');

		$.ajax(
		{
			type: 'POST',
			url: '/ajax.php',
			data: 'action=' + action + '&' + $('#' + formId).serialize(),
			dataType: 'json',
			cache: false,
			success: function(data)
			{
				switch (data.result)
				{
					case 0:
						if (data.feedback) $(formFeedbackId).html('<div data-alert class="alert-box warning radius">' + data.feedback + '<a href="#" class="close">&times;</a></div>');
						else $(formFeedbackId).html('<div data-alert class="alert-box warning radius">An error occured - please try again<a href="#" class="close">&times;</a></div>');
						$(document).foundation('alert', 'reflow');
						$(formFeedbackId).fadeIn(500, function()
						{
							if (data.redirect) $(location).attr('href', data.redirect);
						});
						$('#' + btnId + ' .fa-spin').css('visibility', 'hidden');
						$('#' + btnId).removeAttr('disabled');
						$('#' + btnId).removeClass('disabled');
					break;
				
					case 1:
						if (data.feedback) $(formFeedbackId).html('<div data-alert class="alert-box success radius">' + data.feedback + '<a href="#" class="close">&times;</a></div>');
						else $(formFeedbackId).html('<div data-alert class="alert-box success radius">Success<a href="#" class="close">&times;</a></div>');
						$(document).foundation('alert', 'reflow');
						
						if ($('#' + formId).parent().hasClass('reveal-modal'))
						{
							if (data.redirect) $(location).attr('href', data.redirect);
							else if (data.feedback)
							{							
								$('#' + formId.replace('Form', '')).foundation('reveal', 'close');
								$('#' + formId.replace('Form', 'Feedback') + ' .columns').html(data.feedback);
								$('#' + formId.replace('Form', 'Feedback')).foundation('reveal', 'open');
							}
							else $('#' + formId.replace('Form', '')).foundation('reveal', 'close');
						}
						else
						{
							$(formFeedbackId).fadeIn(500, function()
							{
								if (data.redirect) $(location).attr('href', data.redirect);
							});
						}						
						$('#' + btnId + ' .fa-spin').css('visibility', 'hidden');
						$('#' + btnId).removeAttr('disabled');
						$('#' + btnId).removeClass('disabled');
					break;
				}
			},
			error: function()
			{
				$(formFeedbackId).html('<div data-alert class="alert-box alert radius">An error occured - please try again<a href="#" class="close">&times;</a></div>');
				$(document).foundation('alert', 'reflow');
				$(formFeedbackId).fadeIn(500);
				$('#' + btnId + ' .fa-spin').css('visibility', 'hidden');
				$('#' + btnId).removeAttr('disabled');
				$('#' + btnId).removeClass('disabled');
			}
		});
	}
}