<?php 
class Common_Hook{



	function __construct(){
		
		$this->CI = & get_instance();
	}
	
	
	
	/**
 	*
 	* Populate the aAds array for a page
 	* 
 	*/
	function Common(){
		
		
		$CI = & get_instance();
		
		//p('testing');exit;
		// If commonly used arrays are not already defined in the contructure of controller, then initialize it here
		if( !isset( $CI->mcontents ) ) {
			$CI->mcontents = array();
		}
		if( !isset( $CI->mcontents['load_js'] ) ) {
			$CI->mcontents['load_js'] = array();
		}
		if( !isset( $CI->mcontents['load_css'] ) ) {
			$CI->mcontents['load_css'] = array();
		}
		if( !isset( $CI->merror ) ) {
			$CI->merror['error'] = array();
		}
		
		
		
		// load commonly used config items here,
		// so that we can avoid many function calls throughout the rest of the code.
		$CI->mcontents['c_base_url'] 			= $CI->config->item('base_url');
		$CI->mcontents['c_asset_url'] 			= $CI->config->item('asset_url');
		$CI->mcontents['c_static_image_url'] 	= $CI->config->item('static_image_url');
		$CI->mcontents['c_website_title'] 		= $CI->config->item('website_title');
		$CI->mcontents['c_charset'] 			= $CI->config->item('charset');
		$CI->mcontents['aErrorTypes'] 			= $CI->config->item('error_types');
		
		/*
		p("mcontents");
		p($CI->mcontents);
		exit;
		*/
		
		$CI->mcontents['success_message'] 		= '';
        
        
        // sCurrentMainMenu is used to highlight main menu of website
		$CI->mcontents['sCurrentMainMenu'] 		= ( ! isset( $CI->mcontents['sCurrentMainMenu'] ) ) ?
                                                    'home' :
                                                    $CI->mcontents['sCurrentMainMenu'];
		
		$CI->mcontents['sCurrentMainMenuChild'] = '';
		
		
		// get the regments once here,
		// so that we can avoid many function calls throughout the rest of the code.
		$CI->mcontents['uri_1'] = $CI->uri->rsegment(1);
		$CI->mcontents['uri_2'] = $CI->uri->rsegment(2);
		
		
        
        // AUTOLOAD LIBRARY FOR FACEBOOK
        // doing it here, because we want to controll when we need to load this facebook library.
        // reason being, when running via CLI, we dont want facebook library to load. (just too many errors )
        $CI->mcontents['c_enable_facebook_login'] = $CI->config->item('enable_facebook_login');
        if( ( $CI->mcontents['c_enable_facebook_login'] === true ) && ( ! is_cli() ) ) {
            
            $CI->load->library('facebook');
        }
        
        
        
        //GET DATA FOR LOGIN LOGOUT SECTION
		$CI->mcontents['sLoginUrl'] = '';
        $CI->mcontents['bLoggedIn'] = false;
        
		
		
        
		
		
        /*
		// GET META DATA FOR EACH PAGE
		// skip certain pages
		$aToSkip = array(
						'ajax/check_valid_captcha',
						//'ajax/redeem_countdown_coupon',
						//'ajax/'
		);
		if( !in_array(uri_string(), $aToSkip) ){
			
			getMetaData();
		}
		*/
		
		
		
		
		/**
		 *
		 *
		 * Store the previous uri.
		 *
		 * could be used as an alternative for BACKBUTTON_URI, cancel_button_uri, etc?
		 *
		 * Note : experimental
		 */
		if( $CI->session->userdata('current_uri') ) {
			$CI->session->set_userdata( 'previous_uri', $CI->session->userdata('current_uri') );
		}
		$CI->session->userdata('current_uri', uri_string());
		
		
		
		//load details of the current user who is logged in.
		$CI->mcontents['oCurrUser'] 	= $CI->authentication->is_user_logged_in(false, '', true);
        /*
		$CI->load->library('authentication');
		if($CI->mcontents['iCurrentUser'] = $CI->authentication->is_user_logged_in(false)){
			$CI->mcontents['bLoggedIn']	= true;
			$CI->mcontents['sLogoutUrl'] = c('base_url').'logout';
		} else {
			$CI->mcontents['bLoggedIn'] = false;
            
            // sLoginUrl ---> this is Facebook login url - TO DO: change its name to sFacebookLoginUrl
            $CI->mcontents['sLoginUrl'] = '';
            if( $CI->mcontents['c_enable_facebook_login'] ) {
                
                $CI->mcontents['sLoginUrl'] = $CI->facebook->getLoginUrl(array(
                                        //'redirect_uri'=>'http://localhost/rentinu/inputs.php?c=user&f=handle_fb_login',
                                        'redirect_uri'=>c('base_url').'user/handle_fb_login',
                                        'display'=>'popup',
                                        'scope' => c('db_facebook_app_permissions'),
                                        ));
            }
            
		}
        */
		
		
		
		// load user related config
		$CI->mcontents['aUserStatus'] 	= $CI->config->item('user_status');
		$CI->mcontents['aUserTypes'] 	= $CI->config->item('user_types');
		
		
		
		//User roles
		$CI->mcontents['aAllRoles'] 	= getAllRoles();
		$CI->mcontents['aRoleTitles'] = array();
		foreach($CI->mcontents['aAllRoles'] AS $aItem ) {
			$CI->mcontents['aRoleTitles'][$aItem['id']] = $aItem['title'];
		}
		
		
		
		$CI->mcontents['db_facebook_app_id'] = $CI->config->item('db_facebook_app_id');
		$CI->mcontents['load_js']['data']['db_facebook_app_id'] = $CI->config->item('db_facebook_app_id');
		
		$CI->mcontents['bShowOpenGraphMetaDataInPage'] = TRUE;
		
		// do we need social sharing functionality in this page?
		// set it from the individual functions
		$CI->mcontents['enable_social_buttons'] = false;
		
		
		
        /**
         *
         *
         *
         * The language routines
         */
		/*
		$aLanguages = array(
						'en' => 'English',
						'ml' => 'Malayalam',
					);
		
		
		$cookie_set_language = '';
		if( $CI->input->cookie('language') ) {
			
			$cookie_set_language = $CI->input->cookie('language');
		}
		
		
		$CI->mcontents['sLanguage'] = 'en'; // default
		if ( array_key_exists($cookie_set_language, $aLanguages ) ) {
			
			$CI->mcontents['sLanguage'] = $cookie_set_language;
		}
		
		
		//see if the URL has got anything to say about the language of the page
		if ( array_key_exists( safeText('language', false, 'get'), $aLanguages ) ) {
			
			$CI->mcontents['sLanguage'] = safeText('language', false, 'get');
		}
		
		
		// Set language of the page
        switch( $CI->mcontents['sLanguage'] ) {
            
            case 'ml' :
                //p'here');
                $CI->mcontents['sLanguage_FieldNameSuffix'] = 'ml';
                
                $CI->input->set_cookie('language', 'ml',0);
                //p($CI->input->cookie('language'));
				//exit;
				break;
			
			default :
				$CI->input->set_cookie('language', 'en',0);
                break;
        }
		
		//we will need it anyways - as long as its light weight
		$CI->lang->load('common');
        */
		
		
		/**
		 *
		 * Bread crumbs
		 *
		 */
		
		$CI->mcontents['aBreadCrumbs'] = array(array(
												'uri' =>'home',
												'title' =>'Home',
											));
		
		
		
		/**
		 *
		 * initializing globally used arrays, if not already initialized in controller
		 */
		if( ! isset($CI->mcontents['load_common_css']) ) {
			$CI->mcontents['load_common_css'] = array();
		}
		if( ! isset($CI->mcontents['load_common_js']) ) {
			$CI->mcontents['load_common_js'] = array();
		}
		
	}
}