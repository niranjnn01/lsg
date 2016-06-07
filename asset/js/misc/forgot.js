  $(document).ready(function(){
  
$('input[name="forgot"]').bind('click', function (eventObj){

	$('input[name="forgot"]').attr('disabled', 'disabled');

	var link = '';
	$('#forgot_form_container').block({
										  message: '<?php echo $waiting_gif_text;?>',
										  css: { width:'60%', backgroundColor: '#FFF'} })
	$.post(
	'<?php echo $base_url;?>' + 'account/forgot/' + $(this).attr('id'),
	{},
	function(data){
		$('#forgot_form_container').unblock();
		$('#forgot_form_container').html(data.page);
		//alert('output');
	},
	'json'
	);
	
});
  	
  		

  	

  });
	
  