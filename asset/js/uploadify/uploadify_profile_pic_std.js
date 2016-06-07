$(document).ready(function(){
	$('#file_upload').uploadify({
		'swf'      		: '<?php echo $uploadify_swf;?>',
		'uploader'      : '<?php echo $base_url;?>profile/upload_profile_image/upload',
		'cancelImg'   : '<?php echo $uploadify_cancelImg;?>',
		'auto'       	: true,
		'fileTypeExts' 	: '<?php echo $uploadify_sFileExt;?>',
		'fileTypeDesc'    : '<?php echo $uploadify_fileDesc?>',
		'fileObjName' : 'profile_pic',
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
			
				if(jsonResponse.page != ''){
					<?php //show preview of image?>
					
					//remove any error messages shown previously.
					//$('#profilePicPopupUpload').prev('.error_msg').remove();
					
					$('#preview_cont_upload').html( jsonResponse.page);
					//$('#profile_pic_new_image').html(jsonResponse.page);
					$('.profile_pic_popup_ok').show();
					
					$('.profile_pic_popup_ok').data({
							'file_name' : jsonResponse.data.file_name,
							'account_no' : jsonResponse.data.account_no
					});
					$('#uploadify_btn_cnt').hide();
					//$('#file_upload').uploadifySettings('hideButton', true);
					//alert( $('.profile_pic_popup_ok').data('account_no') );
					
				} else {
					clearPreviewContainers();
					//$.fancybox.close();
				}
				
			} else {
				
				if(jsonResponse.error_type == <?php echo $error_types['not_logged_in'];?>){
					
					gotoPage('user/login');
				} else {
					$('#profilePicPopupUpload').before(jsonResponse.error);
				}
				
				//alert('There was some error');
			}
		}

	});	
});
