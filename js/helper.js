$(document).foundation(
{
	equalizer: {
		equalize_on_stack: true
	}
});

// retina support
if ((window.devicePixelRatio === undefined?1:window.devicePixelRatio) > 1) document.cookie = 'HTTP_IS_RETINA=1;path=/';

/*
$(function()
{
	$('form :input').each(function(index)
	{		
		if ($(this).attr('type') == 'text' && $(this).attr('name').search(/email/i) !== -1) $(this).attr('autocorrect', 'off');
	});
});
*/

// address state switch
function switchStateField(countryId, stateUSId, stateOtherId)
{
	if ($('#' + countryId).val() == 'US')
	{
		$('#' + stateUSId).removeClass().addClass('required');
		$('#' + stateUSId).val('');
		$('#' + stateUSId).show();
		$('#' + stateOtherId).hide();
	}
	else
	{
		$('#' + stateUSId).removeClass();
		$('#' + stateOtherId).val('');
		$('#' + stateUSId).hide();
		$('#' + stateOtherId).show();
	}
}

// reservation calendars
$(function()
{
	if ($('#checkInDt').length && $('#checkOutDt').length)
	{
	    $('#checkInDt').datepicker({
			defaultDate: '+1d',
			minDate: '+1d',
			onClose: function(selectedDate)
			{
				if (selectedDate)
				{
					var nextDayDate = $(this).datepicker('getDate', '+3d');
					nextDayDate.setDate(nextDayDate.getDate() + 3);
					$('#checkOutDt').datepicker('option', 'minDate', nextDayDate);
				}
			}
		});
	
		$('#checkOutDt').datepicker({
			defaultDate: '+1d',
			minDate: '+1d'
		});
	}
});