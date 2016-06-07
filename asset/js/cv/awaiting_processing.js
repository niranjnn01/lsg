


var interval_id;

function get_cv_processing_status(){
	
	//alert('test 2');
	
	$.ajax({
		  type: 'POST',
		  url: "<?php echo $base_url;?>job_seeker/cv_processing_status/<?php echo $iJobSeekerUid, '/', $iCvUid;?>",
		  success: function (data){
			
			if( ! data.error ) {
				
				if( data.cv_status != 2 ) { // 2 = processing still going on
					
					
					//console.log(window.interval_id);
					clearInterval(window.interval_id); // stop the polling of server
					
					bs_hide('#spinner');
					
					
					if( data.cv_status == 3 ) { // duplicate CV
						if( data.new_user == 1 ) {
						
							// show support contact email address
							$('#result').html(data.page);
						} else {
							//ask user if the current CV can be set as the active CV?
							bs_show('#further_options_make_active');
						}
						
					} else {
						
						if( data.new_user == 1 ) {
						
							// tell the user, that a verification email has been sent to the email id
							// ask to click on it for further action
							$('#result').html(data.page);
						} else {
							//ask user if the current CV can be set as the active CV?
							bs_show('#further_options_make_active');
						}
					}
					
					switch( data.cv_status ) {
						
						case '1' :
							
							$('#result').html(data.page);
							
						case '3' :
							
							
							$('#result').html(data.page);
							bs_show('#further_options');
							break;
							
						
					}
					
					// show option to upload another CV
					$('#upload_another').show();
				}
				
				
				
			} else {
				
				
				$('#spinner').hide();
				$('#error').html(data.error);
				$('#error').show();
			}
		  },
		  dataType: "json"
	});
	
}


$(document).ready(function (){
	
	//alert('test');
	
	
	interval_id = setInterval(get_cv_processing_status, 4000);

});

$(document).ready(function () {
	

	$('#cancel').on('click',function(){
		
		gotoPage('job_seeker/upload_cv');
	});
	
	$('#make-active').on('click',function(){
		
		$('#spinner').show();
		
		$.ajax({
			  type: 'POST',
			  url: "<?php echo $base_url;?>job_seeker/set_cv_active/<?php echo $iJobSeekerUid, '/', $iCvUid, '/', $token;?>",
			  success: function (data){
				
				if( data.success == 1 ) {
					
					$('#result').html(data.page);
					bs_hide('#further_options_make_active');
					
				} else {
					bs_hide('#spinner');
					$('#error').html(data.error);
					bs_show('#error');
				}
			  },
			  dataType: "json"
		});
		
	});
	

});
