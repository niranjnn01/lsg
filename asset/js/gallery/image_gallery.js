$(document).ready(function(){
	
	$('#picture_category').change(function(event){
		
		gotoPage('gallery/pictures/' + $(this).val());
	});

});

