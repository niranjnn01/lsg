$(document).ready(function(){
	$('.type').change(function(){
		
		var val = $(this).val();
		gotoPage("event/previous/"  + val);
	});
});