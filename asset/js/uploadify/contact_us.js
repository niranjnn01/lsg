$(document).ready(function(){
	$('#file_upload').uploadify({
		'swf'      		: '<?php echo $uploadify_swf;?>',
		'uploader'      : '<?php echo $base_url;?>contact_us/upload_file',
		'cancelImg'   : '<?php echo $uploadify_cancelImg;?>',
		'auto'       	: true,
		'fileTypeExts' 	: '<?php echo $uploadify_sFileExt;?>',
		'fileTypeDesc'    : '<?php echo $uploadify_fileDesc?>',
		'fileObjName' : 'contact_us_file',
		'uploadLimit'	: '<?php echo $uploadify_uploadLimit;?>',
		'wmode'       : 'transparent',
		'buttonText'  : 'Browse',
		'formData'  : {
			'uploadify_session_token':'<?php echo $uploadify_session_token;?>',
			'uploadify_user_acc_no':'<?php echo $uploadify_user_acc_no;?>',
			},
		'onUploadSuccess'  : function(file, data, response) {

			//alert(response);

			var jsonResponse = jQuery.parseJSON(data);
			
			if(jsonResponse.error == '') {
			
				$('#file_upload_section').hide();
				$('#upload_success').show();
				
				$('#upload_success').html( jsonResponse.client_file_name + '<a href="#" class="m-l-20 cancel_contact_us_upload">cancel</a>' );
				
				$('#post_uploadify_file_name').val(jsonResponse.file_name);
				
			} else {
				
				if(jsonResponse.error_type == <?php echo $error_types['not_logged_in'];?>){
					
					gotoPage('user/login');
				} else {
					$('#file_upload').after(jsonResponse.error);
				}
				
				//alert('There was some error');
			}
		}

	});
	
	
	$('.cancel_contact_us_upload').livequery('click', function(event) {
		
		event.preventDefault();
		
		$.ajax({
			url: '<?php echo $base_url, "contact_us/cancel_upload";?>',
		});
		
		$('#file_upload_section').show();
		$('#upload_success').html('').hide();
		
		$('#post_uploadify_file_name').val('');
		
	});
	
});
