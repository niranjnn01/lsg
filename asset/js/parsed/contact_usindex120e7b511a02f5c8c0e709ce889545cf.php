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
$captcha_container_id =	'captcha_container';
$waiting_gif_text =	'<img class="waiting_gif_image" src="http://localhost/johnson/lsg/asset/img/ajax_loader.gif"/><div class="waiting_gif_text" style="font-size:10px;" >Please wait</div>';
$waiting_gif =	'<img class="waiting_gif_image" src="http://localhost/johnson/lsg/asset/img/ajax_loader.gif"/>';
$tinymce_script_url =	'http://localhost/johnson/lsg/asset/js/tinymce/jscripts/tiny_mce/tiny_mce.js';
$tinymce_theme =	'basic';
$tinymce_theme_advanced_resizing =	'true';
$tinymce_theme_advanced_resizing_use_cookie =	'false';
$tinymce_theme_advanced_statusbar_location =	'bottom';
$tinymce_theme_advanced_toolbar_location =	'top';
$tinymce_theme_advanced_toolbar_align =	'left';
$profile =	'minimal';
$editor =	'tinymce4';
$per_page =	array(0 => 'generic.js',);
$tinymce_button_collection_1 =	'
		theme_advanced_buttons1 : "bold,italic,underline,bullist,numlistlink,|,link,unlink,|justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|,outdent,indent,|,image",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
';
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
/* get a new captcha and replace the existing image */

function refreshCaptcha(){
	//alert('test');
	
	$('#<?php echo $captcha_container_id;?>').block({ message: '<?php echo $waiting_gif_text;?>', css:{width:'60%'} });
	
	$.ajax({
		  type: 'POST',
		  url: "<?php echo $base_url;?>ajax/refresh_captcha",
		  success: function (data){
			//console.log( data.captcha );
			
			$('#captcha_image_id').replaceWith( data.captcha );
			$('#<?php echo $captcha_container_id;?>').unblock();
		  },
		  dataType: "json"
	});	
}


$(document).ready(function (){

/*to be moved to the captcha.js file later on*/
$('#captcha_refresh').click(function (){
//$('#captcha_refresh').livequery('click', function(event) { 

	//alert('test');
	refreshCaptcha();
});

});
/**
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
$("#contactUsForm").validate({
	rules: {
		fname: {required:true},
		email: {required:true, email:true},
		captcha: {required:true},
		message: {required:true},
		contact_us_purpose:{
			required:true,
			min:1,
			}
	},
	messages: {
		contact_us_purpose:{min:"This field is required"}
	},
	submitHandler: function(form) {
		
		var form_temp = form;
		$('#captcha_container').block({
									message: '<?php echo $waiting_gif_text;?>',
									css:{width:'60%'} });
		
		$.ajax({
			type:'post',
			url:'<?php echo $base_url;?>ajax/check_valid_captcha',
			data:{"captcha":form.captcha.value},
			success: function(data){
				$('#captcha_container').unblock();
				if( data.success == 1 ){
					
					clearMessages();
					$('#validated_captcha_code').val(data.page);
					
					//alert( form.validated_captcha_code.value );
					$('#submitting').show();
					form.submit();
				} else {
					
					$('#captcha').val('');
					$('#captcha').focus();
					refreshCaptcha();
					clearMessages();
					$('#c').html(data.error);
					return false;
				}				
			},
			dataType:"json"
		});	
	},
	success: function(label) {
		// set &nbsp; as text for IE
		label.html("&nbsp;").addClass("form_label_success");
		//alert( label.parent().last().html() );
		//alert( label.parent().html() );
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "message")
			error.insertAfter("#error_placement_comment");
		else if (element.attr("name") == "tac")
			error.insertAfter("#error_placement_tac");
		else
			error.insertAfter(element);
	}

});
});



<?php /*
	The "refresh cpatcha" image is made visible by JS.
	so a user will see this option only if JS is enabled
	
	extra files for upload are also diabled and made invisible by js
	
	Again added here for ease
	TO DO : move to a contact_us.js file outside /validation folder
	*/?>
$('#captcha_refresh').show();



$('.hide_files input[type="file"]').attr('disabled', 'disabled');
$('.hide_files').hide();/*!
 * jQuery blockUI plugin
 * Version 2.59.0-2013.04.05
 * @requires jQuery v1.7 or later
 *
 * Examples at: http://malsup.com/jquery/block/
 * Copyright (c) 2007-2013 M. Alsup
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Thanks to Amir-Hossein Sobhi for some excellent contributions!
 */

;(function() {
/*jshint eqeqeq:false curly:false latedef:false */
"use strict";

	function setup($) {
		$.fn._fadeIn = $.fn.fadeIn;

		var noOp = $.noop || function() {};

		// this bit is to ensure we don't call setExpression when we shouldn't (with extra muscle to handle
		// retarded userAgent strings on Vista)
		var msie = /MSIE/.test(navigator.userAgent);
		var ie6  = /MSIE 6.0/.test(navigator.userAgent) && ! /MSIE 8.0/.test(navigator.userAgent);
		var mode = document.documentMode || 0;
		var setExpr = $.isFunction( document.createElement('div').style.setExpression );

		// global $ methods for blocking/unblocking the entire page
		$.blockUI   = function(opts) { install(window, opts); };
		$.unblockUI = function(opts) { remove(window, opts); };

		// convenience method for quick growl-like notifications  (http://www.google.com/search?q=growl)
		$.growlUI = function(title, message, timeout, onClose) {
			var $m = $('<div class="growlUI"></div>');
			if (title) $m.append('<h1>'+title+'</h1>');
			if (message) $m.append('<h2>'+message+'</h2>');
			if (timeout === undefined) timeout = 3000;
			$.blockUI({
				message: $m, fadeIn: 700, fadeOut: 1000, centerY: false,
				timeout: timeout, showOverlay: false,
				onUnblock: onClose,
				css: $.blockUI.defaults.growlCSS
			});
		};

		// plugin method for blocking element content
		$.fn.block = function(opts) {
			if ( this[0] === window ) {
				$.blockUI( opts );
				return this;
			}
			var fullOpts = $.extend({}, $.blockUI.defaults, opts || {});
			this.each(function() {
				var $el = $(this);
				if (fullOpts.ignoreIfBlocked && $el.data('blockUI.isBlocked'))
					return;
				$el.unblock({ fadeOut: 0 });
			});

			return this.each(function() {
				if ($.css(this,'position') == 'static') {
					this.style.position = 'relative';
					$(this).data('blockUI.static', true);
				}
				this.style.zoom = 1; // force 'hasLayout' in ie
				install(this, opts);
			});
		};

		// plugin method for unblocking element content
		$.fn.unblock = function(opts) {
			if ( this[0] === window ) {
				$.unblockUI( opts );
				return this;
			}
			return this.each(function() {
				remove(this, opts);
			});
		};

		$.blockUI.version = 2.59; // 2nd generation blocking at no extra cost!

		// override these in your code to change the default behavior and style
		$.blockUI.defaults = {
			// message displayed when blocking (use null for no message)
			message:  '<h1>Please wait...</h1>',

			title: null,		// title string; only used when theme == true
			draggable: true,	// only used when theme == true (requires jquery-ui.js to be loaded)

			theme: false, // set to true to use with jQuery UI themes

			// styles for the message when blocking; if you wish to disable
			// these and use an external stylesheet then do this in your code:
			// $.blockUI.defaults.css = {};
			css: {
				padding:	0,
				margin:		0,
				width:		'30%',
				top:		'40%',
				left:		'35%',
				textAlign:	'center',
				color:		'#000',
				border:		'3px solid #aaa',
				backgroundColor:'#fff',
				cursor:		'wait'
			},

			// minimal style set used when themes are used
			themedCSS: {
				width:	'30%',
				top:	'40%',
				left:	'35%'
			},

			// styles for the overlay
			overlayCSS:  {
				backgroundColor:	'#000',
				opacity:			0.6,
				cursor:				'wait'
			},

			// style to replace wait cursor before unblocking to correct issue
			// of lingering wait cursor
			cursorReset: 'default',

			// styles applied when using $.growlUI
			growlCSS: {
				width:		'350px',
				top:		'10px',
				left:		'',
				right:		'10px',
				border:		'none',
				padding:	'5px',
				opacity:	0.6,
				cursor:		'default',
				color:		'#fff',
				backgroundColor: '#000',
				'-webkit-border-radius':'10px',
				'-moz-border-radius':	'10px',
				'border-radius':		'10px'
			},

			// IE issues: 'about:blank' fails on HTTPS and javascript:false is s-l-o-w
			// (hat tip to Jorge H. N. de Vasconcelos)
			/*jshint scripturl:true */
			iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank',

			// force usage of iframe in non-IE browsers (handy for blocking applets)
			forceIframe: false,

			// z-index for the blocking overlay
			baseZ: 1000,

			// set these to true to have the message automatically centered
			centerX: true, // <-- only effects element blocking (page block controlled via css above)
			centerY: true,

			// allow body element to be stetched in ie6; this makes blocking look better
			// on "short" pages.  disable if you wish to prevent changes to the body height
			allowBodyStretch: true,

			// enable if you want key and mouse events to be disabled for content that is blocked
			bindEvents: true,

			// be default blockUI will supress tab navigation from leaving blocking content
			// (if bindEvents is true)
			constrainTabKey: true,

			// fadeIn time in millis; set to 0 to disable fadeIn on block
			fadeIn:  200,

			// fadeOut time in millis; set to 0 to disable fadeOut on unblock
			fadeOut:  400,

			// time in millis to wait before auto-unblocking; set to 0 to disable auto-unblock
			timeout: 0,

			// disable if you don't want to show the overlay
			showOverlay: true,

			// if true, focus will be placed in the first available input field when
			// page blocking
			focusInput: true,

			// suppresses the use of overlay styles on FF/Linux (due to performance issues with opacity)
			// no longer needed in 2012
			// applyPlatformOpacityRules: true,

			// callback method invoked when fadeIn has completed and blocking message is visible
			onBlock: null,

			// callback method invoked when unblocking has completed; the callback is
			// passed the element that has been unblocked (which is the window object for page
			// blocks) and the options that were passed to the unblock call:
			//	onUnblock(element, options)
			onUnblock: null,

			// callback method invoked when the overlay area is clicked.
			// setting this will turn the cursor to a pointer, otherwise cursor defined in overlayCss will be used.
			onOverlayClick: null,

			// don't ask; if you really must know: http://groups.google.com/group/jquery-en/browse_thread/thread/36640a8730503595/2f6a79a77a78e493#2f6a79a77a78e493
			quirksmodeOffsetHack: 4,

			// class name of the message block
			blockMsgClass: 'blockMsg',

			// if it is already blocked, then ignore it (don't unblock and reblock)
			ignoreIfBlocked: false
		};

		// private data and functions follow...

		var pageBlock = null;
		var pageBlockEls = [];

		function install(el, opts) {
			var css, themedCSS;
			var full = (el == window);
			var msg = (opts && opts.message !== undefined ? opts.message : undefined);
			opts = $.extend({}, $.blockUI.defaults, opts || {});

			if (opts.ignoreIfBlocked && $(el).data('blockUI.isBlocked'))
				return;

			opts.overlayCSS = $.extend({}, $.blockUI.defaults.overlayCSS, opts.overlayCSS || {});
			css = $.extend({}, $.blockUI.defaults.css, opts.css || {});
			if (opts.onOverlayClick)
				opts.overlayCSS.cursor = 'pointer';

			themedCSS = $.extend({}, $.blockUI.defaults.themedCSS, opts.themedCSS || {});
			msg = msg === undefined ? opts.message : msg;

			// remove the current block (if there is one)
			if (full && pageBlock)
				remove(window, {fadeOut:0});

			// if an existing element is being used as the blocking content then we capture
			// its current place in the DOM (and current display style) so we can restore
			// it when we unblock
			if (msg && typeof msg != 'string' && (msg.parentNode || msg.jquery)) {
				var node = msg.jquery ? msg[0] : msg;
				var data = {};
				$(el).data('blockUI.history', data);
				data.el = node;
				data.parent = node.parentNode;
				data.display = node.style.display;
				data.position = node.style.position;
				if (data.parent)
					data.parent.removeChild(node);
			}

			$(el).data('blockUI.onUnblock', opts.onUnblock);
			var z = opts.baseZ;

			// blockUI uses 3 layers for blocking, for simplicity they are all used on every platform;
			// layer1 is the iframe layer which is used to supress bleed through of underlying content
			// layer2 is the overlay layer which has opacity and a wait cursor (by default)
			// layer3 is the message content that is displayed while blocking
			var lyr1, lyr2, lyr3, s;
			if (msie || opts.forceIframe)
				lyr1 = $('<iframe class="blockUI" style="z-index:'+ (z++) +';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="'+opts.iframeSrc+'"></iframe>');
			else
				lyr1 = $('<div class="blockUI" style="display:none"></div>');

			if (opts.theme)
				lyr2 = $('<div class="blockUI blockOverlay ui-widget-overlay" style="z-index:'+ (z++) +';display:none"></div>');
			else
				lyr2 = $('<div class="blockUI blockOverlay" style="z-index:'+ (z++) +';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');

			if (opts.theme && full) {
				s = '<div class="blockUI ' + opts.blockMsgClass + ' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:'+(z+10)+';display:none;position:fixed">';
				if ( opts.title ) {
					s += '<div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(opts.title || '&nbsp;')+'</div>';
				}
				s += '<div class="ui-widget-content ui-dialog-content"></div>';
				s += '</div>';
			}
			else if (opts.theme) {
				s = '<div class="blockUI ' + opts.blockMsgClass + ' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:'+(z+10)+';display:none;position:absolute">';
				if ( opts.title ) {
					s += '<div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(opts.title || '&nbsp;')+'</div>';
				}  
				s += '<div class="ui-widget-content ui-dialog-content"></div>';
				s += '</div>';
			}
			else if (full) {
				s = '<div class="blockUI ' + opts.blockMsgClass + ' blockPage" style="z-index:'+(z+10)+';display:none;position:fixed"></div>';
			}
			else {
				s = '<div class="blockUI ' + opts.blockMsgClass + ' blockElement" style="z-index:'+(z+10)+';display:none;position:absolute"></div>';
			}
			lyr3 = $(s);

			// if we have a message, style it
			if (msg) {
				if (opts.theme) {
					lyr3.css(themedCSS);
					lyr3.addClass('ui-widget-content');
				}
				else
					lyr3.css(css);
			}

			// style the overlay
			if (!opts.theme /*&& (!opts.applyPlatformOpacityRules)*/)
				lyr2.css(opts.overlayCSS);
			lyr2.css('position', full ? 'fixed' : 'absolute');

			// make iframe layer transparent in IE
			if (msie || opts.forceIframe)
				lyr1.css('opacity',0.0);

			//$([lyr1[0],lyr2[0],lyr3[0]]).appendTo(full ? 'body' : el);
			var layers = [lyr1,lyr2,lyr3], $par = full ? $('body') : $(el);
			$.each(layers, function() {
				this.appendTo($par);
			});

			if (opts.theme && opts.draggable && $.fn.draggable) {
				lyr3.draggable({
					handle: '.ui-dialog-titlebar',
					cancel: 'li'
				});
			}

			// ie7 must use absolute positioning in quirks mode and to account for activex issues (when scrolling)
			var expr = setExpr && (!$.support.boxModel || $('object,embed', full ? null : el).length > 0);
			if (ie6 || expr) {
				// give body 100% height
				if (full && opts.allowBodyStretch && $.support.boxModel)
					$('html,body').css('height','100%');

				// fix ie6 issue when blocked element has a border width
				if ((ie6 || !$.support.boxModel) && !full) {
					var t = sz(el,'borderTopWidth'), l = sz(el,'borderLeftWidth');
					var fixT = t ? '(0 - '+t+')' : 0;
					var fixL = l ? '(0 - '+l+')' : 0;
				}

				// simulate fixed position
				$.each(layers, function(i,o) {
					var s = o[0].style;
					s.position = 'absolute';
					if (i < 2) {
						if (full)
							s.setExpression('height','Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.support.boxModel?0:'+opts.quirksmodeOffsetHack+') + "px"');
						else
							s.setExpression('height','this.parentNode.offsetHeight + "px"');
						if (full)
							s.setExpression('width','jQuery.support.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"');
						else
							s.setExpression('width','this.parentNode.offsetWidth + "px"');
						if (fixL) s.setExpression('left', fixL);
						if (fixT) s.setExpression('top', fixT);
					}
					else if (opts.centerY) {
						if (full) s.setExpression('top','(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"');
						s.marginTop = 0;
					}
					else if (!opts.centerY && full) {
						var top = (opts.css && opts.css.top) ? parseInt(opts.css.top, 10) : 0;
						var expression = '((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + '+top+') + "px"';
						s.setExpression('top',expression);
					}
				});
			}

			// show the message
			if (msg) {
				if (opts.theme)
					lyr3.find('.ui-widget-content').append(msg);
				else
					lyr3.append(msg);
				if (msg.jquery || msg.nodeType)
					$(msg).show();
			}

			if ((msie || opts.forceIframe) && opts.showOverlay)
				lyr1.show(); // opacity is zero
			if (opts.fadeIn) {
				var cb = opts.onBlock ? opts.onBlock : noOp;
				var cb1 = (opts.showOverlay && !msg) ? cb : noOp;
				var cb2 = msg ? cb : noOp;
				if (opts.showOverlay)
					lyr2._fadeIn(opts.fadeIn, cb1);
				if (msg)
					lyr3._fadeIn(opts.fadeIn, cb2);
			}
			else {
				if (opts.showOverlay)
					lyr2.show();
				if (msg)
					lyr3.show();
				if (opts.onBlock)
					opts.onBlock();
			}

			// bind key and mouse events
			bind(1, el, opts);

			if (full) {
				pageBlock = lyr3[0];
				pageBlockEls = $(':input:enabled:visible',pageBlock);
				if (opts.focusInput)
					setTimeout(focus, 20);
			}
			else
				center(lyr3[0], opts.centerX, opts.centerY);

			if (opts.timeout) {
				// auto-unblock
				var to = setTimeout(function() {
					if (full)
						$.unblockUI(opts);
					else
						$(el).unblock(opts);
				}, opts.timeout);
				$(el).data('blockUI.timeout', to);
			}
		}

		// remove the block
		function remove(el, opts) {
			var count;
			var full = (el == window);
			var $el = $(el);
			var data = $el.data('blockUI.history');
			var to = $el.data('blockUI.timeout');
			if (to) {
				clearTimeout(to);
				$el.removeData('blockUI.timeout');
			}
			opts = $.extend({}, $.blockUI.defaults, opts || {});
			bind(0, el, opts); // unbind events

			if (opts.onUnblock === null) {
				opts.onUnblock = $el.data('blockUI.onUnblock');
				$el.removeData('blockUI.onUnblock');
			}

			var els;
			if (full) // crazy selector to handle odd field errors in ie6/7
				els = $('body').children().filter('.blockUI').add('body > .blockUI');
			else
				els = $el.find('>.blockUI');

			// fix cursor issue
			if ( opts.cursorReset ) {
				if ( els.length > 1 )
					els[1].style.cursor = opts.cursorReset;
				if ( els.length > 2 )
					els[2].style.cursor = opts.cursorReset;
			}

			if (full)
				pageBlock = pageBlockEls = null;

			if (opts.fadeOut) {
				count = els.length;
				els.fadeOut(opts.fadeOut, function() { 
					if ( --count === 0)
						reset(els,data,opts,el);
				});
			}
			else
				reset(els, data, opts, el);
		}

		// move blocking element back into the DOM where it started
		function reset(els,data,opts,el) {
			var $el = $(el);
			els.each(function(i,o) {
				// remove via DOM calls so we don't lose event handlers
				if (this.parentNode)
					this.parentNode.removeChild(this);
			});

			if (data && data.el) {
				data.el.style.display = data.display;
				data.el.style.position = data.position;
				if (data.parent)
					data.parent.appendChild(data.el);
				$el.removeData('blockUI.history');
			}

			if ($el.data('blockUI.static')) {
				$el.css('position', 'static'); // #22
			}

			if (typeof opts.onUnblock == 'function')
				opts.onUnblock(el,opts);

			// fix issue in Safari 6 where block artifacts remain until reflow
			var body = $(document.body), w = body.width(), cssW = body[0].style.width;
			body.width(w-1).width(w);
			body[0].style.width = cssW;
		}

		// bind/unbind the handler
		function bind(b, el, opts) {
			var full = el == window, $el = $(el);

			// don't bother unbinding if there is nothing to unbind
			if (!b && (full && !pageBlock || !full && !$el.data('blockUI.isBlocked')))
				return;

			$el.data('blockUI.isBlocked', b);

			// don't bind events when overlay is not in use or if bindEvents is false
			if (!full || !opts.bindEvents || (b && !opts.showOverlay))
				return;

			// bind anchors and inputs for mouse and key events
			var events = 'mousedown mouseup keydown keypress keyup touchstart touchend touchmove';
			if (b)
				$(document).bind(events, opts, handler);
			else
				$(document).unbind(events, handler);

		// former impl...
		//		var $e = $('a,:input');
		//		b ? $e.bind(events, opts, handler) : $e.unbind(events, handler);
		}

		// event handler to suppress keyboard/mouse events when blocking
		function handler(e) {
			// allow tab navigation (conditionally)
			if (e.keyCode && e.keyCode == 9) {
				if (pageBlock && e.data.constrainTabKey) {
					var els = pageBlockEls;
					var fwd = !e.shiftKey && e.target === els[els.length-1];
					var back = e.shiftKey && e.target === els[0];
					if (fwd || back) {
						setTimeout(function(){focus(back);},10);
						return false;
					}
				}
			}
			var opts = e.data;
			var target = $(e.target);
			if (target.hasClass('blockOverlay') && opts.onOverlayClick)
				opts.onOverlayClick();

			// allow events within the message content
			if (target.parents('div.' + opts.blockMsgClass).length > 0)
				return true;

			// allow events for content that is not being blocked
			return target.parents().children().filter('div.blockUI').length === 0;
		}

		function focus(back) {
			if (!pageBlockEls)
				return;
			var e = pageBlockEls[back===true ? pageBlockEls.length-1 : 0];
			if (e)
				e.focus();
		}

		function center(el, x, y) {
			var p = el.parentNode, s = el.style;
			var l = ((p.offsetWidth - el.offsetWidth)/2) - sz(p,'borderLeftWidth');
			var t = ((p.offsetHeight - el.offsetHeight)/2) - sz(p,'borderTopWidth');
			if (x) s.left = l > 0 ? (l+'px') : '0';
			if (y) s.top  = t > 0 ? (t+'px') : '0';
		}

		function sz(el, p) {
			return parseInt($.css(el,p),10)||0;
		}

	}


	/*global define:true */
	if (typeof define === 'function' && define.amd && define.amd.jQuery) {
		define(['jquery'], setup);
	} else {
		setup(jQuery);
	}

})();

$(document).ready(function() {

        tinymce.init(
            {
                selector:'textarea.text-editor',
                menubar: false,
                plugins: "table, hr, link, image, preview",
                image_advtab: true,
                image_class_list: [
                        {title: 'None', value: ''},
                        {title: 'Thumbnail', value: 'thumbnail'},
                        ],
                toolbar: "bold italic underline | link unlink |  bullist numlist",
                statusbar: true
            }
        );

});