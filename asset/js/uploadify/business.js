$(document).ready(function(){
	$('#file_upload').uploadify({
		'swf'      		: '<?php echo $uploadify_swf;?>',
		'uploader'      : '<?php echo $base_url;?>green_page/upload_file',
		'cancelImg'   : '<?php echo $uploadify_cancelImg;?>',
		'auto'       	: true,
		'fileTypeExts' 	: '<?php echo $uploadify_sFileExt;?>',
		'fileTypeDesc'    : '<?php echo $uploadify_fileDesc?>',
		'fileObjName' : 'business',
		'uploadLimit'	: '<?php echo $uploadify_uploadLimit;?>',
		'wmode'       : 'transparent',
		'buttonText'  : 'Browse',
		'debug'  : false,
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
				
				$('#upload_success').html( jsonResponse.client_file_name + '' );
				
				//$('.cancel_picture_upload').show();
                var img = $('<img id="upload_preview">'); //Equivalent: $(document.createElement('img'))
                img.attr('src', name_to_thumbnail_link('business', jsonResponse.file_name, 'small'));
                $('#preview_cnt').html(img);
                
				
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
	

    
	/**
	 *
	 * we wont be giving the option to cancel the upload. - 10-10-2013
	 * 
	$('.cancel_picture_upload').click( function(event) {
		
		event.preventDefault();
		
		$('#file_upload').uploadify('settings','uploadLimit','<?php echo ($uploadify_uploadLimit + 1);?>');
		
		$.ajax({
			url: '<?php echo $base_url, "products/cancel_upload";?>',
		});
		
		
		$('#file_upload_section').show();
		$('#upload_success').html('').hide();
		
		$('#post_uploadify_file_name').val('');
		
	});
	*/
	
	
});
    //name_to_thumbnail('business', '7489_tiny.jpg', 'small')
    function name_to_thumbnail_link(section, file_name, size) {
        
        var section_links = {business : base_url + 'uploads/business/'};
                                    
        
        var aPieces = file_name.split('.');
        return section_links[section] + aPieces[0] + '_' + size + '.' + aPieces[1];
        
    }