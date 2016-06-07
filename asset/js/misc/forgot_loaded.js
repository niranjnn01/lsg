$(document).ready(function(){
	
  	$('#userRecCancel, #passRecCancel').click(function (){
  		
  		$('input[name="forgot"]').removeAttr('disabled');
  		$('input[name="forgot"]').removeAttr('checked');
  		$('#forgot_form_container').html('&nbsp;<br/><br/><br/><br/><br/>');
  	});
  	
});