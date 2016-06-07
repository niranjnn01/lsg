
$(document).ready(function() {


	
	function search(event){
		
		var sUri = 	'fruit?' + 
					'fruit_name=' + $('#name').val() + 
					'&category=' + $('#category').val() +
					'&yielding_season=' + $('#yielding_season').val()
					
		
		gotoPage( sUri );
		
		event.stopPropagation();
		event.preventDefault();
	}
	
	// search fruits list when clicking on search button
	$('#search').click( search );
	
	// search fruits list when pressing enter on the search form
	$('#name').on('keypress', function (event){
		
		if( event.which == 13 ) {
			search(event);
		}
	});
	

});

