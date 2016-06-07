<?php header("Content-type: text/javascript");$base_path =	'C:/wamp/www/johnson/lsg/';
$base_url =	'http://localhost/johnson/lsg/';
$js_url =	'http://localhost/johnson/lsg/asset/js/';
$password_min_length =	'6';
$contact_us_max_length =	'500';
$static_image_url =	'http://localhost/johnson/lsg/asset/img/';
$error_types =	array('not_logged_in' => '1','validation' => '2','other' => '3',);
$css_image_url =	'http://localhost/johnson/lsg/asset/css/themes/misty/css/img/';
$waiting_img =	'ajax_loader.gif';
$waiting_gif =	'<img class="waiting_gif_image" src="http://localhost/johnson/lsg/asset/img/ajax_loader.gif"/>';
$waiting_txt =	'Please wait';
$waiting_gif_text =	'<img class="waiting_gif_image" src="http://localhost/johnson/lsg/asset/img/ajax_loader.gif"/><div class="waiting_gif_text" style="font-size:10px;" >Please wait</div>';
$excerpt_character_length =	'200';
$asset_url =	'http://localhost/johnson/lsg/asset/';
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
var JSON;JSON||(JSON={}),function(){"use strict";var v="number",a="function",l="object",c="string";function f(n){return n<10?"0"+n:n}function quote(n){return escapable.lastIndex=0,escapable.test(n)?'"'+n.replace(escapable,function(n){var t=meta[n];return typeof t==c?t:"\\u"+("0000"+n.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+n+'"'}function str(n,t){var o="null",f,e,u,h,s=gap,r,i=t[n];i&&typeof i==l&&typeof i.toJSON==a&&(i=i.toJSON(n)),typeof rep==a&&(i=rep.call(t,n,i));switch(typeof i){case c:return quote(i);case v:return isFinite(i)?String(i):o;case"boolean":case o:return String(i);case l:if(!i)return o;if(gap+=indent,r=[],Object.prototype.toString.apply(i)==="[object Array]"){for(h=i.length,f=0;f<h;f+=1)r[f]=str(f,i)||o;return u=r.length===0?"[]":gap?"[\n"+gap+r.join(",\n"+gap)+"\n"+s+"]":"["+r.join(",")+"]",gap=s,u}if(rep&&typeof rep==l)for(h=rep.length,f=0;f<h;f+=1)typeof rep[f]==c&&(e=rep[f],u=str(e,i),u&&r.push(quote(e)+(gap?": ":":")+u));else for(e in i)Object.prototype.hasOwnProperty.call(i,e)&&(u=str(e,i),u&&r.push(quote(e)+(gap?": ":":")+u));return u=r.length===0?"{}":gap?"{\n"+gap+r.join(",\n"+gap)+"\n"+s+"}":"{"+r.join(",")+"}",gap=s,u}}typeof Date.prototype.toJSON!=a&&(Date.prototype.toJSON=function(){var t=this;return isFinite(t.valueOf())?t.getUTCFullYear()+"-"+f(t.getUTCMonth()+1)+"-"+f(t.getUTCDate())+"T"+f(t.getUTCHours())+":"+f(t.getUTCMinutes())+":"+f(t.getUTCSeconds())+"Z":null},String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(){return this.valueOf()});var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},rep;typeof JSON.stringify!=a&&(JSON.stringify=function(n,t,i){var r;if(gap="",indent="",typeof i==v)for(r=0;r<i;r+=1)indent+=" ";else typeof i==c&&(indent=i);if(rep=t,t&&typeof t!=a&&(typeof t!=l||typeof t.length!=v))throw new Error("JSON.stringify");return str("",{"":n})}),typeof JSON.parse!=a&&(JSON.parse=function(text,reviver){function walk(n,t){var r,u,i=n[t];if(i&&typeof i==l)for(r in i)Object.prototype.hasOwnProperty.call(i,r)&&(u=walk(i,r),u!==undefined?i[r]=u:delete i[r]);return reviver.call(n,t,i)}var j;if(text=String(text),cx.lastIndex=0,cx.test(text)&&(text=text.replace(cx,function(n){return"\\u"+("0000"+n.charCodeAt(0).toString(16)).slice(-4)})),/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return j=eval("("+text+")"),typeof reviver=="function"?walk({"":j},""):j;throw new SyntaxError("JSON.parse");})}();jQuery(document).ready(function(){
/*
	var adminMenuStatus = {};
	
	function makeAdminMenuStatus(){
	
		$('.accordion-toggle').each(function(index, element){
			++index;
			var status;
			//alert($(this).attr('class'));
			if( $(this).hasClass('collapsed') ){
				//alert('collapsed');
				adminMenuStatus[index] = '0';
			} else {
				//alert('other');
				adminMenuStatus[index] = '1';
			}
			
		});
		alert(JSON.stringify(adminMenuStatus));
	}
	makeAdminMenuStatus();
	
	
	
	$('.accordion-heading').click(function() {
		
		//if($(this).next().toggle()){
		alert('test');
			makeAdminMenuStatus();
			$.removeCookie('admin_menu_status');
			$.cookie('admin_menu_status', JSON.stringify(adminMenuStatus) , {raw:true, json:false, path: '/' });
			//alert();
			
		//}
	});
	*/
});

$(document).ready(function() {
    
    $('.panel-group .panel-collapse').on('hidden.bs.collapse', function () {
       $(this).prev().find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
    })    
    $('.panel-group .panel-collapse').on('shown.bs.collapse', function () {
        
       $(this).prev().find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
    })
    

    
});
