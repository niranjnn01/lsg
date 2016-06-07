<?php header("Content-type: text/javascript");$base_path =	'C:/wamp/www/base/';
$base_url =	'http://localhost/base/';
$js_url =	'http://localhost/base/asset/js/';
$password_min_length =	'6';
$contact_us_max_length =	'500';
$static_image_url =	'http://localhost/base/asset/img/';
$error_types =	array('not_logged_in' => '1','validation' => '2','other' => '3',);
$css_image_url =	'http://localhost/base/asset/css/themes/misty/css/img/';
$waiting_img =	'ajax_loader.gif';
$waiting_gif =	'<img class="waiting_gif_image" src="http://localhost/base/asset/img/ajax_loader.gif"/>';
$waiting_txt =	'Please wait';
$waiting_gif_text =	'<img class="waiting_gif_image" src="http://localhost/base/asset/img/ajax_loader.gif"/><div class="waiting_gif_text" style="font-size:10px;" >Please wait</div>';
$excerpt_character_length =	'200';
$asset_url =	'http://localhost/base/asset/';
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
});/**
 * jQuery Validation Plugin 1.8.1
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
 * http://docs.jquery.com/Plugins/Validation
 *
 * Copyright (c) 2006 - 2011 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
(function(a){a.extend(a.fn,{validate:function(b){if(!this.length){b&&b.debug&&window.console&&console.warn("nothing selected, can't validate, returning nothing");return}var c=a.data(this[0],"validator");if(c){return c}c=new a.validator(b,this[0]);a.data(this[0],"validator",c);if(c.settings.onsubmit){this.find("input, button").filter(".cancel").click(function(){c.cancelSubmit=true});if(c.settings.submitHandler){this.find("input, button").filter(":submit").click(function(){c.submitButton=this})}this.submit(function(b){function d(){if(c.settings.submitHandler){if(c.submitButton){var b=a("<input type='hidden'/>").attr("name",c.submitButton.name).val(c.submitButton.value).appendTo(c.currentForm)}c.settings.submitHandler.call(c,c.currentForm);if(c.submitButton){b.remove()}return false}return true}if(c.settings.debug)b.preventDefault();if(c.settings.beforeValidation){c.settings.beforeValidation.call(c,c.currentForm)}if(c.cancelSubmit){c.cancelSubmit=false;return d()}if(c.form()){if(c.pendingRequest){c.formSubmitted=true;return false}return d()}else{c.focusInvalid();return false}})}return c},valid:function(){if(a(this[0]).is("form")){return this.validate().form()}else{var b=true;var c=a(this[0].form).validate();this.each(function(){b&=c.element(this)});return b}},removeAttrs:function(b){var c={},d=this;a.each(b.split(/\s/),function(a,b){c[b]=d.attr(b);d.removeAttr(b)});return c},rules:function(b,c){var d=this[0];if(b){var e=a.data(d.form,"validator").settings;var f=e.rules;var g=a.validator.staticRules(d);switch(b){case"add":a.extend(g,a.validator.normalizeRule(c));f[d.name]=g;if(c.messages)e.messages[d.name]=a.extend(e.messages[d.name],c.messages);break;case"remove":if(!c){delete f[d.name];return g}var h={};a.each(c.split(/\s/),function(a,b){h[b]=g[b];delete g[b]});return h}}var i=a.validator.normalizeRules(a.extend({},a.validator.metadataRules(d),a.validator.classRules(d),a.validator.attributeRules(d),a.validator.staticRules(d)),d);if(i.required){var j=i.required;delete i.required;i=a.extend({required:j},i)}return i}});a.extend(a.expr[":"],{blank:function(b){return!a.trim(""+b.value)},filled:function(b){return!!a.trim(""+b.value)},unchecked:function(a){return!a.checked}});a.validator=function(b,c){this.settings=a.extend(true,{},a.validator.defaults,b);this.currentForm=c;this.init()};a.validator.format=function(b,c){if(arguments.length==1)return function(){var c=a.makeArray(arguments);c.unshift(b);return a.validator.format.apply(this,c)};if(arguments.length>2&&c.constructor!=Array){c=a.makeArray(arguments).slice(1)}if(c.constructor!=Array){c=[c]}a.each(c,function(a,c){b=b.replace(new RegExp("\\{"+a+"\\}","g"),c)});return b};a.extend(a.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"form_label_error",validClass:"form_label_success",errorElement:"span",focusInvalid:true,errorContainer:a([]),errorLabelContainer:a([]),onsubmit:true,ignore:[],ignoreTitle:false,onfocusin:function(a){this.lastActive=a;if(this.settings.focusCleanup&&!this.blockFocusCleanup){this.settings.unhighlight&&this.settings.unhighlight.call(this,a,this.settings.errorClass,this.settings.validClass);this.addWrapper(this.errorsFor(a)).hide()}},onfocusout:function(a){if(!this.checkable(a)&&(a.name in this.submitted||!this.optional(a))){this.element(a)}},onkeyup:function(a){if(a.name in this.submitted||a==this.lastElement){this.element(a)}},onclick:function(a){if(a.name in this.submitted)this.element(a);else if(a.parentNode.name in this.submitted)this.element(a.parentNode)},highlight:function(b,c,d){if(b.type==="radio"){this.findByName(b.name).addClass(c).removeClass(d)}else{a(b).addClass(c).removeClass(d)}},unhighlight:function(b,c,d){if(b.type==="radio"){this.findByName(b.name).removeClass(c).addClass(d)}else{a(b).removeClass(c).addClass(d)}}},setDefaults:function(b){a.extend(a.validator.defaults,b)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date (ISO).",number:"Please enter a valid number.",digits:"Please enter only digits.",creditcard:"Please enter a valid credit card number.",equalTo:"Please enter the same value again.",accept:"Please enter a value with a valid extension.",maxlength:a.validator.format("Please enter no more than {0} characters."),minlength:a.validator.format("Please enter at least {0} characters."),rangelength:a.validator.format("Please enter a value between {0} and {1} characters long."),range:a.validator.format("Please enter a value between {0} and {1}."),max:a.validator.format("Please enter a value less than or equal to {0}."),min:a.validator.format("Please enter a value greater than or equal to {0}.")},autoCreateRanges:false,prototype:{init:function(){function d(b){var c=a.data(this[0].form,"validator"),d="on"+b.type.replace(/^validate/,"");c.settings[d]&&c.settings[d].call(c,this[0])}this.labelContainer=a(this.settings.errorLabelContainer);this.errorContext=this.labelContainer.length&&this.labelContainer||a(this.currentForm);this.containers=a(this.settings.errorContainer).add(this.settings.errorLabelContainer);this.submitted={};this.valueCache={};this.pendingRequest=0;this.pending={};this.invalid={};this.reset();var b=this.groups={};a.each(this.settings.groups,function(c,d){a.each(d.split(/\s/),function(a,d){b[d]=c})});var c=this.settings.rules;a.each(c,function(b,d){c[b]=a.validator.normalizeRule(d)});a(this.currentForm).validateDelegate(":text, :password, :file, select, textarea","focusin focusout keyup",d).validateDelegate(":radio, :checkbox, select, option","click",d);if(this.settings.invalidHandler)a(this.currentForm).bind("invalid-form.validate",this.settings.invalidHandler)},form:function(){this.checkForm();a.extend(this.submitted,this.errorMap);this.invalid=a.extend({},this.errorMap);if(!this.valid())a(this.currentForm).triggerHandler("invalid-form",[this]);this.showErrors();return this.valid()},checkForm:function(){this.prepareForm();for(var a=0,b=this.currentElements=this.elements();b[a];a++){this.check(b[a])}return this.valid()},element:function(b){b=this.clean(b);this.lastElement=b;this.prepareElement(b);this.currentElements=a(b);var c=this.check(b);if(c){delete this.invalid[b.name]}else{this.invalid[b.name]=true}if(!this.numberOfInvalids()){this.toHide=this.toHide.add(this.containers)}this.showErrors();return c},showErrors:function(b){if(b){a.extend(this.errorMap,b);this.errorList=[];for(var c in b){this.errorList.push({message:b[c],element:this.findByName(c)[0]})}this.successList=a.grep(this.successList,function(a){return!(a.name in b)})}this.settings.showErrors?this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){if(a.fn.resetForm)a(this.currentForm).resetForm();this.submitted={};this.prepareForm();this.hideErrors();this.elements().removeClass(this.settings.errorClass)},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(a){var b=0;for(var c in a)b++;return b},hideErrors:function(){this.addWrapper(this.toHide).hide()},valid:function(){return this.size()==0},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid){try{a(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").focus().trigger("focusin")}catch(b){}}},findLastActive:function(){var b=this.lastActive;return b&&a.grep(this.errorList,function(a){return a.element.name==b.name}).length==1&&b},elements:function(){var b=this,c={};return a(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function(){!this.name&&b.settings.debug&&window.console&&console.error("%o has no name assigned",this);if(this.name in c||!b.objectLength(a(this).rules()))return false;c[this.name]=true;return true})},clean:function(b){return a(b)[0]},errors:function(){return a(this.settings.errorElement+"."+this.settings.errorClass,this.errorContext)},reset:function(){this.successList=[];this.errorList=[];this.errorMap={};this.toShow=a([]);this.toHide=a([]);this.currentElements=a([])},prepareForm:function(){this.reset();this.toHide=this.errors().add(this.containers)},prepareElement:function(a){this.reset();this.toHide=this.errorsFor(a)},check:function(b){b=this.clean(b);if(this.checkable(b)){b=this.findByName(b.name).not(this.settings.ignore)[0]}var c=a(b).rules();var d=false;for(var e in c){var f={method:e,parameters:c[e]};try{var g=a.validator.methods[e].call(this,b.value.replace(/\r/g,""),b,f.parameters);if(g=="dependency-mismatch"){d=true;continue}d=false;if(g=="pending"){this.toHide=this.toHide.not(this.errorsFor(b));return}if(!g){this.formatAndAdd(b,f);return false}}catch(h){this.settings.debug&&window.console&&console.log("exception occured when checking element "+b.id+", check the '"+f.method+"' method",h);throw h}}if(d)return;if(this.objectLength(c))this.successList.push(b);return true},customMetaMessage:function(b,c){if(!a.metadata)return;var d=this.settings.meta?a(b).metadata()[this.settings.meta]:a(b).metadata();return d&&d.messages&&d.messages[c]},customMessage:function(a,b){var c=this.settings.messages[a];return c&&(c.constructor==String?c:c[b])},findDefined:function(){for(var a=0;a<arguments.length;a++){if(arguments[a]!==undefined)return arguments[a]}return undefined},defaultMessage:function(b,c){return this.findDefined(this.customMessage(b.name,c),this.customMetaMessage(b,c),!this.settings.ignoreTitle&&b.title||undefined,a.validator.messages[c],"<strong>Warning: No message defined for "+b.name+"</strong>")},formatAndAdd:function(a,b){var c=this.defaultMessage(a,b.method),d=/\$?\{(\d+)\}/g;if(typeof c=="function"){c=c.call(this,b.parameters,a)}else if(d.test(c)){c=jQuery.format(c.replace(d,"{$1}"),b.parameters)}this.errorList.push({message:c,element:a});this.errorMap[a.name]=c;this.submitted[a.name]=c},addWrapper:function(a){if(this.settings.wrapper)a=a.add(a.parent(this.settings.wrapper));return a},defaultShowErrors:function(){for(var a=0;this.errorList[a];a++){var b=this.errorList[a];this.settings.highlight&&this.settings.highlight.call(this,b.element,this.settings.errorClass,this.settings.validClass);this.showLabel(b.element,b.message)}if(this.errorList.length){this.toShow=this.toShow.add(this.containers)}if(this.settings.success){for(var a=0;this.successList[a];a++){this.showLabel(this.successList[a])}}if(this.settings.unhighlight){for(var a=0,c=this.validElements();c[a];a++){this.settings.unhighlight.call(this,c[a],this.settings.errorClass,this.settings.validClass)}}this.toHide=this.toHide.not(this.toShow);this.hideErrors();this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return a(this.errorList).map(function(){return this.element})},showLabel:function(b,c){var d=this.errorsFor(b);if(d.length){d.removeClass().addClass(this.settings.errorClass);d.attr("generated")&&d.html(c)}else{d=a("<"+this.settings.errorElement+"/>").attr({"for":this.idOrName(b),generated:true}).addClass(this.settings.errorClass).html(c||"");if(this.settings.wrapper){d=d.hide().show().wrap("<"+this.settings.wrapper+"/>").parent()}if(!this.labelContainer.append(d).length)this.settings.errorPlacement?this.settings.errorPlacement(d,a(b)):d.insertAfter(b)}if(!c&&this.settings.success){d.text("");typeof this.settings.success=="string"?d.addClass(this.settings.success):this.settings.success(d)}this.toShow=this.toShow.add(d)},errorsFor:function(b){var c=this.idOrName(b);return this.errors().filter(function(){return a(this).attr("for")==c})},idOrName:function(a){return this.groups[a.name]||(this.checkable(a)?a.name:a.id||a.name)},checkable:function(a){return/radio|checkbox/i.test(a.type)},findByName:function(b){var c=this.currentForm;return a(document.getElementsByName(b)).map(function(a,d){return d.form==c&&d.name==b&&d||null})},getLength:function(b,c){switch(c.nodeName.toLowerCase()){case"select":return a("option:selected",c).length;case"input":if(this.checkable(c))return this.findByName(c.name).filter(":checked").length}return b.length},depend:function(a,b){return this.dependTypes[typeof a]?this.dependTypes[typeof a](a,b):true},dependTypes:{"boolean":function(a,b){return a},string:function(b,c){return!!a(b,c.form).length},"function":function(a,b){return a(b)}},optional:function(b){return!a.validator.methods.required.call(this,a.trim(b.value),b)&&"dependency-mismatch"},startRequest:function(a){if(!this.pending[a.name]){this.pendingRequest++;this.pending[a.name]=true}},stopRequest:function(b,c){this.pendingRequest--;if(this.pendingRequest<0)this.pendingRequest=0;delete this.pending[b.name];if(c&&this.pendingRequest==0&&this.formSubmitted&&this.form()){a(this.currentForm).submit();this.formSubmitted=false}else if(!c&&this.pendingRequest==0&&this.formSubmitted){a(this.currentForm).triggerHandler("invalid-form",[this]);this.formSubmitted=false}},previousValue:function(b){return a.data(b,"previousValue")||a.data(b,"previousValue",{old:null,valid:true,message:this.defaultMessage(b,"remote")})}},classRuleSettings:{required:{required:true},email:{email:true},url:{url:true},date:{date:true},dateISO:{dateISO:true},dateDE:{dateDE:true},number:{number:true},numberDE:{numberDE:true},digits:{digits:true},creditcard:{creditcard:true}},addClassRules:function(b,c){b.constructor==String?this.classRuleSettings[b]=c:a.extend(this.classRuleSettings,b)},classRules:function(b){var c={};var d=a(b).attr("class");d&&a.each(d.split(" "),function(){if(this in a.validator.classRuleSettings){a.extend(c,a.validator.classRuleSettings[this])}});return c},attributeRules:function(b){var c={};var d=a(b);for(var e in a.validator.methods){var f=d.attr(e);if(f){c[e]=f}}if(c.maxlength&&/-1|2147483647|524288/.test(c.maxlength)){delete c.maxlength}return c},metadataRules:function(b){if(!a.metadata)return{};var c=a.data(b.form,"validator").settings.meta;return c?a(b).metadata()[c]:a(b).metadata()},staticRules:function(b){var c={};var d=a.data(b.form,"validator");if(d.settings.rules){c=a.validator.normalizeRule(d.settings.rules[b.name])||{}}return c},normalizeRules:function(b,c){a.each(b,function(d,e){if(e===false){delete b[d];return}if(e.param||e.depends){var f=true;switch(typeof e.depends){case"string":f=!!a(e.depends,c.form).length;break;case"function":f=e.depends.call(c,c);break}if(f){b[d]=e.param!==undefined?e.param:true}else{delete b[d]}}});a.each(b,function(d,e){b[d]=a.isFunction(e)?e(c):e});a.each(["minlength","maxlength","min","max"],function(){if(b[this]){b[this]=Number(b[this])}});a.each(["rangelength","range"],function(){if(b[this]){b[this]=[Number(b[this][0]),Number(b[this][1])]}});if(a.validator.autoCreateRanges){if(b.min&&b.max){b.range=[b.min,b.max];delete b.min;delete b.max}if(b.minlength&&b.maxlength){b.rangelength=[b.minlength,b.maxlength];delete b.minlength;delete b.maxlength}}if(b.messages){delete b.messages}return b},normalizeRule:function(b){if(typeof b=="string"){var c={};a.each(b.split(/\s/),function(){c[this]=true});b=c}return b},addMethod:function(b,c,d){a.validator.methods[b]=c;a.validator.messages[b]=d!=undefined?d:a.validator.messages[b];if(c.length<3){a.validator.addClassRules(b,a.validator.normalizeRule(b))}},methods:{required:function(b,c,d){if(!this.depend(d,c))return"dependency-mismatch";switch(c.nodeName.toLowerCase()){case"select":var e=a(c).val();return e&&e.length>0;case"input":if(this.checkable(c))return this.getLength(b,c)>0;default:return a.trim(b).length>0}},remote:function(b,c,d){if(this.optional(c))return"dependency-mismatch";var e=this.previousValue(c);if(!this.settings.messages[c.name])this.settings.messages[c.name]={};e.originalMessage=this.settings.messages[c.name].remote;this.settings.messages[c.name].remote=e.message;d=typeof d=="string"&&{url:d}||d;if(this.pending[c.name]){return"pending"}if(e.old===b){return e.valid}e.old=b;var f=this;this.startRequest(c);var g={};g[c.name]=b;a.ajax(a.extend(true,{url:d,mode:"abort",port:"validate"+c.name,dataType:"json",data:g,success:function(d){f.settings.messages[c.name].remote=e.originalMessage;var g=d===true;if(g){var h=f.formSubmitted;f.prepareElement(c);f.formSubmitted=h;f.successList.push(c);f.showErrors()}else{var i={};var j=d||f.defaultMessage(c,"remote");i[c.name]=e.message=a.isFunction(j)?j(b):j;f.showErrors(i)}e.valid=g;f.stopRequest(c,g)}},d));return"pending"},minlength:function(b,c,d){return this.optional(c)||this.getLength(a.trim(b),c)>=d},maxlength:function(b,c,d){return this.optional(c)||this.getLength(a.trim(b),c)<=d},rangelength:function(b,c,d){var e=this.getLength(a.trim(b),c);return this.optional(c)||e>=d[0]&&e<=d[1]},min:function(a,b,c){return this.optional(b)||a>=c},max:function(a,b,c){return this.optional(b)||a<=c},range:function(a,b,c){return this.optional(b)||a>=c[0]&&a<=c[1]},email:function(a,b){return this.optional(b)||/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(a)},url:function(a,b){return this.optional(b)||/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(a)},date:function(a,b){return this.optional(b)||!/Invalid|NaN/.test(new Date(a))},dateISO:function(a,b){return this.optional(b)||/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(a)},number:function(a,b){return this.optional(b)||/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(a)},digits:function(a,b){return this.optional(b)||/^\d+$/.test(a)},creditcard:function(a,b){if(this.optional(b))return"dependency-mismatch";if(/[^0-9-]+/.test(a))return false;var c=0,d=0,e=false;a=a.replace(/\D/g,"");for(var f=a.length-1;f>=0;f--){var g=a.charAt(f);var d=parseInt(g,10);if(e){if((d*=2)>9)d-=9}c+=d;e=!e}return c%10==0},accept:function(a,b,c){c=typeof c=="string"?c.replace(/,/g,"|"):"png|jpe?g|gif";return this.optional(b)||a.match(new RegExp(".("+c+")$","i"))},equalTo:function(b,c,d){var e=a(d).unbind(".validate-equalTo").bind("blur.validate-equalTo",function(){a(c).valid()});return b==e.val()}}});a.format=a.validator.format})(jQuery);(function(a){var b={};if(a.ajaxPrefilter){a.ajaxPrefilter(function(a,c,d){var e=a.port;if(a.mode=="abort"){if(b[e]){b[e].abort()}b[e]=d}})}else{var c=a.ajax;a.ajax=function(d){var e=("mode"in d?d:a.ajaxSettings).mode,f=("port"in d?d:a.ajaxSettings).port;if(e=="abort"){if(b[f]){b[f].abort()}return b[f]=c.apply(this,arguments)}return c.apply(this,arguments)}}})(jQuery);(function(a){if(!jQuery.event.special.focusin&&!jQuery.event.special.focusout&&document.addEventListener){a.each({focus:"focusin",blur:"focusout"},function(b,c){function d(b){b=a.event.fix(b);b.type=c;return a.event.handle.call(this,b)}a.event.special[c]={setup:function(){this.addEventListener(b,d,true)},teardown:function(){this.removeEventListener(b,d,true)},handler:function(b){arguments[0]=a.event.fix(b);arguments[0].type=c;return a.event.handle.apply(this,arguments)}}})}a.extend(a.fn,{validateDelegate:function(b,c,d){return this.bind(c,function(c){var e=a(c.target);if(e.is(b)){return d.apply(e,arguments)}})}})})(jQuery);$(function(){$.validator.setDefaults({errorClass:"form_label_error",validClass:"form_label_success",beforeValidation:function(){if(typeof tinyMCE!="undefined"){tinyMCE.triggerSave()}}})});$(document).ready(function(){
	
$("#contactpurposeCreateForm").validate({
	rules: {
		title: {required:true},
		email: {required:true, email:true},
		reciever_name: {required:true},
		email_template_id: {required:true,min:1},
		success_message: {required:true},
		status: {required:true}
	},
	messages:{
		email_template_id: {min:"This field is required."},
	},
	success: function(label) {
		// set &nbsp; as text for IE
		label.html("&nbsp;").addClass("form_label_success");		
	},
	errorPlacement: function(error, element) {
			error.insertAfter(element);
	}

});
});



$(document).ready(function() {
    
    $('.panel-group .panel-collapse').on('hidden.bs.collapse', function () {
       $(this).prev().find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
    })    
    $('.panel-group .panel-collapse').on('shown.bs.collapse', function () {
        
       $(this).prev().find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
    })
    

    
});
