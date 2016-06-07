
var stop_flag = 0;
var count = 0;
$(document).ready(function(){
	
	$('#start').click(function (event) {
		//alert('start');
		batch_assist();
		event.preventDefault();
	});
	
	$('#stop').click(function (event) {
		//alert('stop');
		//alert(stop_flag);
		stop_flag = 1;
		
		
		
		event.preventDefault();
		
	});
	
});




function batch_assist(){
	
	// ping the URL, wait for reply
	$('#counter').html((count+1));
	$.ajax({
		  type: 'POST',
		  url: "<?php echo $base_url;?>developer/cli",
		  success: function (data){
			
			if(data.success == 0) {
				
				if( data.page == 'stop' ) {
					$('#result').append(
						$('<li>').append("STOPPED BY SERVER !! : <span style='color:red;'>" + data.message + "</span>")
					);
					
				} else {
					$('#result').append(
						$('<li>').append(data.error)
					);	
				}
				
				
			} else if( data.success == 1 ) {
			
				$('#result').append(
					$('<li>').append(data.page)
				);
			
				if( stop_flag != 1  ) {
					//alert('continuing');
					
					batch_assist();
				} else {
					$('#result').append(
						$('<li>').append("STOPPED BY CLIENT !!")
					);	
				}
			
			}
			
		  },
		  dataType: "json"
	});	
	
}