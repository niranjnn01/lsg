$(document).ready(function(){
	
	$('#video_category').change(function(event){
		
		gotoPage('gallery/videos/' + $(this).val());
	});

});

