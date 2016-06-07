$(document).ready(function(){
	
	
	
	$('#search').click(function(event){
		
		var sUri = 	'report/basic?' + 
					'age_from=' + $('#age_from').val() + 
					'&age_to=' + $('#age_to').val() + 
					'&gender=' + $('#gender').val() + 
					'&experience=' + $('#years_of_experience').val() + 
					'&nationality='+ $('#country_code_hidden').val() + 
					'&qualification=' + encodeURI( $('#qualification').val() ) +
					'&order_by=' + $('#order_by').val() + 
					'&direction=' + $('#direction').val()
					
		
		//alert( sUri );
		gotoPage( sUri );
		
		event.stopPropagation();
		event.preventDefault();
	});
	


});

