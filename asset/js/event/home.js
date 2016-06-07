$(document).ready(function(){
	$('.type').change(function(){
		
		var val = $(this).val();
		gotoPage("event/index/"  + val);
	});
});