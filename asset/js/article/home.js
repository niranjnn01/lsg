$(document).ready(function(){
	$('.type').change(function(){
		
		var val = $(this).val();
		gotoPage("article/index/"  + val);
	});
});