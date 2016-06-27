<?php header("Content-type: text/javascript");$base_path =	'C:/wamp/www/lsg/';
$base_url =	'http://localhost/lsg/';
$js_url =	'http://localhost/lsg/asset/js/';
$password_min_length =	'6';
$contact_us_max_length =	'500';
$static_image_url =	'http://localhost/lsg/asset/img/';
$error_types =	array('not_logged_in' => '1','validation' => '2','other' => '3',);
$css_image_url =	'http://localhost/lsg/asset/css/themes/misty/css/img/';
$waiting_img =	'ajax_loader.gif';
$waiting_gif =	'<img class="waiting_gif_image" src="http://localhost/lsg/asset/img/ajax_loader.gif"/>';
$waiting_txt =	'Please wait';
$waiting_gif_text =	'<img class="waiting_gif_image" src="http://localhost/lsg/asset/img/ajax_loader.gif"/><div class="waiting_gif_text" style="font-size:10px;" >Please wait</div>';
$excerpt_character_length =	'200';
$asset_url =	'http://localhost/lsg/asset/';
$db_facebook_app_id =	'';
 ?>function gotoPage(uri) {
	window.location = "<?php echo $base_url;?>" + uri;  
}
 
<?php /* Clear any success/failure messages */?>
function clearMessages() {
	
	$('.error_msg').remove();
	$('.success_msg').remove();
	$('.info_msg').remove();
}
<?php /* highlight any success/failure messages in the page*/?>
function highlightMessages(){
	//alert('test');
	//$('.success_message').fadeOut('slow');$('.success_message').fadeIn('slow');
	
}

function resizeIframe(obj) {
  obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}



<?php 
/**
 * Used when admin section, when the admin clicks on the edit/ delete button in the grid of contents
 */
?>
function takeAction(action, destination_uri, text){

	
	if(action == 'edit'){
		
		gotoPage( destination_uri );
	} else if (action == 'delete'){
		if ( confirm(text) ){
			gotoPage( destination_uri );
		}
	}
	return false;
}


function bs_hide(selector){
	
	$( selector ).addClass('hide');
}

function bs_show(selector){
	$( selector ).removeClass('hide');
}
