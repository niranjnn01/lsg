<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Uploadify Settings
|--------------------------------------------------------------------------
|
|
*/

$CI = & get_instance();

$config['uploadify_default_settings'] = 	array (

	'uploadify_swf'             => $CI->config->config['base_url'].'asset_new/swf/uploadify/uploadify.swf',
	'uploadify_cancelImg'       => $CI->config->config['static_image_url'] . 'cancel.png',
	'uploadify_uploadLimit'  => 1, //The maximum number of files you are allowed to upload.  
	'uploadify_fileDesc'        => '',
	'uploadify_expressInstall'  => 'expressInstall.swf'
);