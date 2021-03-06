<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Common Settings
|--------------------------------------------------------------------------
|
|
*/

include('./../master_config.php');


define('DS',DIRECTORY_SEPARATOR); // defined here because 3rd party code like tinymce for eg, will need to include only one file for knowing the config 
					// TO DO : maintain a separate config file for 3rd party code use alone.

$CI = & get_instance();
$config['base_url']	        = $CI->config->config['base_url'];  // has got a trailing slash
$config['base_path'] 	    = substr(BASEPATH, 0, -7);          // has got a trailing slash

$config['asset_path'] 	    = $config['base_path'].'asset/';
$config['asset_url'] 	    = $config['base_url'].'asset/';

$config['font_path'] 	    = $config['asset_path'].'fonts/';


$config['current_theme']    = 'misty';
$config['current_theme_path_segment'] = 'css/' . ($config['current_theme'] ? 'themes/' . $config['current_theme'].'/css/' : '');

$config['asset_js_folder_name'] = 'js';
$config['asset_img_folder_name'] = 'img';

$config['js_url']	        = $config['base_url'].'asset/'.$config['asset_js_folder_name'].'/';

$config['css_url']          = $config['base_url'].'asset/css/' . ( $config['current_theme'] ? 'themes/' . $config['current_theme'].'/css/' : '' );
$config['css_image_url']	= $config['css_url'] . $config['asset_img_folder_name'].'/';
$config['css_path']         = $config['base_path'].'asset/css/' . ( $config['current_theme'] ? 'themes/' . $config['current_theme'].'/css/' : '' );
$config['css_parsed_path'] 	= $config['css_path'].'parsed/';
$config['css_parsed_url'] 	= $config['css_url'] . 'parsed/';

$config['js_path'] 			= $config['base_path'].'asset/'.$config['asset_js_folder_name'].'/';
$config['js_parsed_path'] 	= $config['js_path'].'parsed/'; 
$config['js_parsed_url'] 	= $config['js_url'].'parsed/';




$config['contact_us_max_length'] = 500;
$config['contact_us_to_name'] = 'Administrator';

//'.$config["asset_js_folder_name"].'

$config['default_js_files'] = array(
                            );

$config['default_js_files_admin'] 		= array();
$config['default_js_files_user'] 		= array();

$config['config_variables_for_js_file'] = array(
											'base_path', 
											'base_url', 
											'js_url', 
											'password_min_length', 
											'contact_us_max_length', 
											'static_image_url',
											'error_types',
											'css_image_url',
											'waiting_img',
                                            'waiting_gif',
											'waiting_txt',
                                            'waiting_gif_text',
                                            'excerpt_character_length',
                                            'asset_url'
										);
										
                                        
/**
 *
 * File paths are relative to the asset_path
 */
$config['default_css_files'] = array(
    
                            'style.css',
                            'css_helper.css',
                            //'common/css/social_media.css',
                        );

                        
$config['default_css_files_admin'] 		= array();
$config['default_css_files_user'] 		= array();



/**
 *
 * Common Assets
 *
 * The file path should be relative to the value in "asset_path" config variable
 * 
 */

$config['common_asset_files_css'] = array(
                        );

$config['common_asset_files_js'] = array(
                                    'common/js/common.js',
                        );




$config['config_variables_for_css_file'] = array(
											'base_path', 
											'base_url', 
											'password_min_length', 
											'contact_us_max_length', 
											'static_image_url',
											'css_image_url',
											'captcha_img_height',
										);

$config['get_image_default_settings'] = array (
	'only_url' 			=> false,
	'container_size' 	=> 0,
	'show_adjust' 		=> true,
	'align_dim' 		=> 'height',
	'attributes' 		=> array()
);

// The types of errors in the system . | used in ajax requests now.
$config['error_types'] = array(
	'not_logged_in' => 1,
	'validation' => 2,
	'other' => 3,
);

$config['user_action_time'] = 300; 	// Avg time taken by a user to perform an action.
									// currently used as captcha expiration time.	

$config['login_uri_segment'] = 'user/login';

$config['enable_facebook_login'] = false;
$config['facebook_redirect_url'] = $config['base_url'] . 'facebook_redirect';


/*
|--------------------------------------------------------------------------
| Image Settings
|--------------------------------------------------------------------------
|
|
*/

$config['static_image_url']		= $config['asset_url'].$config['asset_img_folder_name'].'/';
$config['static_image_path']	= $config['asset_path'].$config['asset_img_folder_name'].DS;




/*
|--------------------------------------------------------------------------
| Website Settings
|--------------------------------------------------------------------------
|
*/
$config['website_domain_name']		= 'domain-name.com';
$config['website_title']			= 'Website Title';
$config['copyright_text']			= '';
$config['website_official_name']	= '';
$config['logo_image_name']          = 'logo.jpg';


/*
|--------------------------------------------------------------------------
| Upload Settings
|--------------------------------------------------------------------------
|
*/

$config['contact_us_upload_path'] 	= $config['base_path'].'uploads'.DS.'contact_us'.DS;
$config['contact_us_upload_url'] 	= $config['base_url'].'uploads/contact_us/';
$config['contact_us_allowed_types'] = '';

$config['contact_us_upload_settings'] = array(

	'upload_path'		=> $config['contact_us_upload_path'],
	'allowed_types'		=> 'tgz|zip|rar|doc|pdf|gif|png|jpg|jpeg|docx|bmp|xlsx',
	'types_description'	=> 'Image Files', //will appear in the drop-down box for "file types" field in the "select files" window
	'file_name'			=> '',
	'overwrite'			=> false,
	'max_size'			=> 51200, //50MB
	'max_filename'		=> 0,
	'encrypt_name'		=> false,
	'remove_spaces'		=> true,
	'keep_original'		=> true,
	'append_real_name'	=> true
);


/*
|--------------------------------------------------------------------------
| Email Settings
|--------------------------------------------------------------------------
|
|
*/
$config['email_template_default_variables'] = array(

	'website_name' 		=> $config['website_title'],
	'copyright_text' 	=> $config['copyright_text'],
	'website_url' 		=> $config['base_url'],
    'email_logo_url'    => $config['static_image_url'] . $config['logo_image_name'],
);

$config['no_reply_email_id']    = 'noreply@' . $config['website_domain_name'];
$config['no_reply_email_from']  = 'No Reply';
$config['accounts_email_id']    = 'account@' . $config['website_domain_name']; // username/ password recovery emails are sent from this email id
$config['accounts_email_from']  = 'Accounts - ' . $config['website_title'];


$config['subscription_email_from']  = 'Email Subscription';



/**
 *
 * SMTP CREDENTIALS
 * 
 */
$config['smtp_host']        =   $master_config['email'][ENVIRONMENT_]['smtp_host'];
$config['smtp_port']        =   $master_config['email'][ENVIRONMENT_]['smtp_port'];
$config['smtp_username']    =	$master_config['email'][ENVIRONMENT_]['smtp_username'];
$config['smtp_password']    =   $master_config['email'][ENVIRONMENT_]['smtp_password'];
$config['smtp_auth']        =   $master_config['email'][ENVIRONMENT_]['smtp_auth'];
$config['smtp_secure']      =   $master_config['email'][ENVIRONMENT_]['smtp_secure'];

$config['mailer']    =   'smtp'; // Method to send mail: ("mail", "sendmail", or "smtp").


/**
 *
 * ------------------------------------------------------------------------------------------
 * 
 */





//mail sent status - used when sending emails as a background process
$config['email_sent_status'] = array(
                                'sent'      => 1,
                                'not_sent'  => 2,
                                'failed'    => 3,
                                'sending'   => 4,
                            );
$config['email_send_priority'] = array(
                                'high'      => 1,
                                'normal'    => 5,
                            );


/* Move the following 3 to the DB settings*/
$config['twitter_page_link']        = '';
$config['facebook_page_link']       = '';
$config['google_site_verification'] = '';



/*
|--------------------------------------------------------------------------
| Tabbed Display Settings
|--------------------------------------------------------------------------
|
|
*/

$config['tabbed_display_settings'] = array(

	'content_type' 	=> '',
	'current_tab' 	=> 0,
);


/*
|--------------------------------------------------------------------------
| Other Settings
|--------------------------------------------------------------------------
|
|
*/

$config['waiting_img']      = 'ajax_loader.gif';
$config['waiting_txt']      = 'Please wait';
$config['waiting_gif']      = '<img class="waiting_gif_image" src="'.$config['static_image_url'] . $config['waiting_img'] .'"/>'; // this can be avoided? maybe not. maybe its used in case where only an image is required?
$config['waiting_gif_text'] = $config['waiting_gif'] . '<div class="waiting_gif_text" style="font-size:10px;" >'.$config['waiting_txt'].'</div>';


$config['settings_location'] = array(
                                    'config'    => 1,
                                    'table'     => 2,
                                );
$config['dropdown_defaults'] = array(
									'table' 		        => '',
									'id_field' 		        => 'id',
									'title_field' 	        => 'name',
									'default_text' 	        => 'Select',//show in the unselected state
									'default_value'         => 0,//value in the unselected state
									'aWhere'                => array(),
                                    'show_default_value'    => TRUE // whether we need to show the default option or not
								);

//Images to preload
$config['preload_images'] = array(
	'checked.gif', 
	'unchecked.gif',
	$config['waiting_img'],
);




################################################# SITE SPECIFIC SECTIONS ####################################################

$config['excerpt_character_length'] = 200;
