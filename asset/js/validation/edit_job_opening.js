$(document).ready(function(){
	
$('#assign_job_seeker').on('click', function (event) {
	
	var job_seeker_uid = $('#job_seeker_assignment').val();
	var job_opening_uid = $('#job_opening_uid').val();
	
	if( ! job_seeker_uid ){
		$('#employment_error_container').html("specify a job seeker UID");
		
	} else if( ! job_opening_uid ) {
		
		$('#employment_error_container').html("specify a job opening UID");
	} else {
		
		$('#employment_error_container').html("");
		
		var url = "<?php echo $base_url;?>job_opening/create_employment/" + job_opening_uid + "/" + job_seeker_uid;
		//alert(url);
		
		$.ajax({
			  type: 'POST',
			  url: url,
			  data:{
					  "start_date" 	: 	$('#start_date').val(),
					  "expiry_date" : 	$('#expiry_date').val(),
				  },
			  success: function (data){
				
				if(data.error != '') {
					
					$('#employment_error_container').html(data.error);
					
				} else if( data.success == 1 ) {
					
					$('#employment_error_container').html("");
					window.location = window.location.href;
					
				}
				
			  },
			  dataType: "json"
		});
		
		event.preventDefault();
		event.stopPropagation();
	}
	
	
});
	
	
$('.end_employment').on('click', function (event) {
	
	
	if( confirm("Are you sure you want to end this employment?") ) {
	
	
		
		var job_opening_uid = $(this).attr('id');
		
		if( ! job_seeker_uid ){
			
			$('#employment_error_container').html("specify a job seeker UID");
			
		} else {
			
			var url = "<?php echo $base_url;?>employment/change_status/closed/" + job_opening_uid;
			//alert(url);
			
			$.ajax({
				type: 'POST',
				url: url,
				success: function (data){
				  
				  if(data.error != '') {
					  
					  $('#employment_error_container').html(data.error);
					  
				  } else if( data.success == 1 ) {
					  
					  window.location = window.location.href;
					  
				  }
				  
				},
				dataType: "json"
			});	
		}
		
	}
	
	
	event.preventDefault();
	event.stopPropagation();
	
});
	
	
	
	
});