$(document).ready(function(){
	

	$('#status').on('change', function(event){
		
		if( $(this).val() == <?php echo $aCVStatus['blocked'];?> ) {
			$('#blocked_reason_cnt').show();
		} else {
			$('#blocked_reason_cnt').hide();
		}
	});
	
});

