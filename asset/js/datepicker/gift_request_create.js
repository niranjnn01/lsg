$(document).ready(function(){
$( ".datepicker" ).datepicker(
	{ 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
        minDate: 0,
        maxDate: '+30Y',
		yearRange: $('#datepicker_from').val() + ':' + $('#datepicker_to').val()
	}
);
});

