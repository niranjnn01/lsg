<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct() {

		parent::__construct();
		
		/*
		$this->mcontents = array();
		$this->merror['error'] = '';
		$this->mcontents['load_css'] = array();
		$this->mcontents['load_js'] = array();
		*/
		
		$this->load->model('user_model');
		
		$this->aUserStatus 		= $this->config->item('user_status');
		$this->aUserTypes 		= $this->config->item('user_types');
		$this->aErrorTypes 		= $this->config->item('error_types');

		$this->aGenders = c('genders');
		$this->mcontents['aGendersFlipped'] = array_flip($this->aGenders);
		$this->mcontents['sCurrentMainMenu'] = 'user';
        
        
        $this->mcontents['sCurrentMainMenu']    = 'users';
        
	}

	public function index() {
		
		if( $this->authentication->is_user_logged_in (true, 'user/login') ){
			$this->home();
		}
	}
	
	
	function login () {
		//p('test ');exit;
		//$this->load->library('facebook');
		
		$this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Login';
		
		//var_dump($this->authentication->is_user_logged_in());
		
		if(!$this->authentication->is_user_logged_in()) {
			
		    if (!empty($_POST)) {
		
		    	
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				$this->form_validation->set_rules('password','Password', 'trim|required');
				if ($this->form_validation->run() == TRUE) { 
					$post_data['username'] 	= safeText('username');
					$post_data['password']	= $this->authentication->encryptPassword(safeText ('password')); 
					$login_details			= $this->authentication->process_login ($post_data);
					
					
					if('' == $login_details['error']) {

						if( @$login_details['message'] ) {
							
							sf('success_message', $login_details['message']);
						}
						
						
						// See if the user needs to be redirected to a previous page he was seeying
						// redirect the users to the link which they were trying to access
						
						if( $post_login_redirect = s('post_login_redirect') ) {
				
							us('post_login_redirect');
							redirect($post_login_redirect);
							
						} else {
							
							if($this->authentication->is_admin_logged_in()){
								
								redirect('admin');
								
							} else {
								
								redirect('home');
							}
							
						}
						
					}else{
					 	$this->merror['error']	=	$login_details['error'];
					}
				}
		    }
			
		} else {
			
			redirect('home');
		}
		
		
		$this->mcontents['load_js'][] 	= 'jquery/jquery.validate.min.js';
        $this->mcontents['load_js'][] = 'validation/login.js';
		
		loadTemplate('user/login');
	}

	
	function create() {
		
		$this->authentication->is_admin_logged_in(true);
		
		isAdminSection();
		
		
		$this->mcontents['page_title'] 		= 'Create new user';
		$this->mcontents['page_heading'] 	= 'Create new user';
		
		if ( isset($_POST) && !empty($_POST)) {
			
			$this->_validate_create_user();
			
			if ($this->form_validation->run() == TRUE) {
				
				//$iUserType = safeText('user_type');
				
				//just a doube check
				//$iUserType = ( $this->aUserTypes['admin'] != $iUserType ) ? $iUserType : $this->aUserTypes['user'];
				$iUserType = $this->aUserTypes['user'];
				
				$post_data['first_name']	= safeText('first_name');
				$post_data['middle_name']	= safeText('middle_name');
				$post_data['last_name']		= safeText('last_name');
				$post_data['email_id']		= safeText('email_id');
				$post_data['username']		= strtolower( safeText('username') );
				$post_data['birthday']		= safeText('dob') ? safeText('dob') : NULL;
	    		$post_data['status']		= $this->aUserStatus['active'];
	    		$post_data['joined_on']		= date('Y-m-d H:i:s');
	    		$post_data['account_no']	= $this->authentication->generateAccountNumber();
	    		$post_data['type']			= $iUserType;
	    		$post_data['gender']		= safeText('gender');
	    		
				$post_data['password']		= $this->authentication->encryptPassword(str_shuffle($post_data['username']));
				$temp_password 				= substr($post_data['password'], 0, 8);
				$post_data['password']		= $this->authentication->encryptPassword($temp_password);
				
				if ( $this->user_model->isUsernameExists($post_data['username']) ) {
					$error	= TRUE;
					$this->merror['error'][] = "Username Exist";
				}
				if ( $this->user_model->isEmailExists($post_data['email_id']) ) {
					
					$error	= TRUE;
					$this->merror['error'][] = "Email Exist";
				}
				
				$aRoles = array_trim( safeText('user_roles') );
				
				
				
				//get those roles, for which there can be only a single person assigned.
				$aSingleAssignableRoles = array();
				
				$this->db->where_in('name', array(
												  'president',
												  'secretary',
												  'executive-director',
												  'finance-director',
											));
				foreach( $this->db->get('user_roles')->result() AS $oItem ) {
					
					$aSingleAssignableRoles[] = $oItem->id;
				}
				
				if( $aTempArray = array_intersect($aRoles, $aSingleAssignableRoles) ) {
					foreach($aTempArray as $iRole) {
						$this->merror['error'][] = 'The role "'
						. $this->mcontents['aRoleTitles'][$iRole]
						. '" is already assigned to another user. Remove this role from that user before assigning it to a new user.';
					}
				}
				
				//p($this->merror['error']);exit;
				
				
				if( ! $this->merror['error'] ) {
					
				
				//write_log('SIGNUP 8');
				$this->db->set ($post_data);
				$this->db->insert ('users');
				
				if( $oUser = $this->user_model->getUserBy('id', $this->db->insert_id()) ) {
					
					$this->load->model('account_model');
					
					$iUserId = $oUser->id;//to be removed later and use from object alone
					
					//Assign default profile image for user
					$this->account_model->createProfilePicture($oUser);
					
					//ss('registratiion_email_id', $post_data['email_id']);
					
					//assign roles to this user
					$this->_createRoles($aRoles, $post_data['account_no']);
					
					
					// email password to user
					// $account_activation_code = $this->common_model->generateToken('account_activation', $iUserId, $iLength=0);
					$arr_email['receiver_name']			= $post_data['first_name'].' '.$post_data['last_name'];
					$arr_email['username']				= $post_data['username'];
					$arr_email['temporary_password']	= $temp_password;
					$arr_email['help_url']				= site_url('help');
					$arr_email['login_url']				= site_url('user/login');
					
					
					/*
					$this->load->helper('custom_mail');
					$aSettings = array(
						'to' 				=> array($post_data['email_id']=>$arr_email['receiver_name']), // email_id => name pairs
						'from_email' 		=> c('accounts_email_id'),
						'from_name'			=> c('accounts_email_from'),
						'reply_to' 			=> array(c('no_reply_email_id') => c('accounts_email_from')), // email_id => name pairs
						'email_contents' 	=> $arr_email, // placeholder keywords to be replaced with this data
						'template_name' 	=> 'account_created', //name of template to be used
						//'preview'			=> true
					);
					
					//p(sendMail_PHPMailer($aSettings));exit;
					
					if( sendMail_PHPMailer($aSettings) ) {
						
						$this->session->set_flashdata ('success_message', 'User has been created');
						
						// Send welcome message
						$this->load->model('maintenance_model');
						$this->maintenance_model->getSingleSetting('db_welcome_msg');
						$aWelcomeEmail['receiver_name'] = $arr_email['receiver_name'];
						$aWelcomeEmail['welcome_text'] 	= $this->maintenance_model->getSingleSetting('db_signup_welcome_msg');
						
						$aSettings = array(
							'to' 				=> array($post_data['email_id']=>$arr_email['receiver_name']), // email_id => name pairs
							'from_email' 		=> c('accounts_email_id'),
							'from_name'			=> c('accounts_email_from'),
							'reply_to' 			=> array(c('accounts_email_id') => c('accounts_email_from')), // email_id => name pairs
							'email_contents' 	=> $aWelcomeEmail, // placeholder keywords to be replaced with this data
							'template_name' 	=> 'welcome', //name of template to be used
						);
						
						sendMail_PHPMailer($aSettings);
						
					} else {
						
						$this->session->set_flashdata ('info_message', 'Confirmation mail is not sent');
					}
					*/
					$this->session->set_flashdata ('success_message', 'User has been created');
					redirect('user/create');
				}
				}
			}
		}
		
		
		$this->mcontents['load_js'][] 	= "jquery/jquery.validate.min.js";
		$this->mcontents['load_js'][] 	= "validation/create_user.js";
		
		$this->mcontents['load_js'][] = 'jquery/jquery.datepicker.min.js';
		$this->mcontents['load_js'][] = 'datepicker/signup.js';
		
		//$this->mcontents['load_css'][] = 'jquery-ui-1.8.16.custom.css';
		//$this->mcontents['load_css'][] = 'form.css';
		//$this->mcontents['load_css'][] = 'forms/create_user.css';
		
		$this->load->helper('date');
		$this->mcontents['load_js']['data']['minYear'] = minusFrom(date('Y-m-d H:i:s'), c('user_max_age'), "years", 'Y');
		$this->mcontents['load_js']['data']['maxYear'] = minusFrom(date('Y-m-d H:i:s'), c('user_min_age'), "years", 'Y');
		$this->mcontents['load_js']['data']['minDate'] = minusFrom(date('Y-m-d H:i:s'), c('user_max_age'), "years", 'Y-m-d');
		$this->mcontents['load_js']['data']['maxDate'] = minusFrom(date('Y-m-d H:i:s'), c('user_min_age'), "years", 'Y-m-d');
		
		$this->mcontents['aGenders'] 	= $this->aGenders;
		
		
		$this->mcontents['aUserTypesTitle'] = array(0=>'Select') + $this->config->item('user_types_title');
		unset($this->mcontents['aUserTypesTitle'][1]); // we dont want to create another admin user
		
		
		$this->mcontents['aUserRolesTitles'] 	= $this->config->item('user_roles_title');
		
		ss('BACKBUTTON_URI', 'user/listing');
		
		loadAdminTemplate('user/create');
		
	}
	
	
	/**
	 * The signup form is displayed
	 *
	 */
	function signup() {
		
		//echo "test";exit;
		//redirect('home');
		$this->load->library('facebook');
        
		/*
		if($this->authentication->is_user_logged_in ()){
			//redirect('home');
		}
		*/
		//$oFbUserData = (object) $this->facebook->request('get', '/me?fields=id,email,first_name,middle_name,last_name,gender,birthday');
		//var_dump($oFbUserData);
		//var_dump($this->facebook->is_authenticated());
		//exit;
		/*
		if ($this->facebook->is_authenticated())
		{
			// User logged in, get user details
			$oFbUserData = (object) $this->facebook->request('get', '/me?fields=id,email,first_name,middle_name,last_name,gender,birthday');
			
			var_dump($user);
			if (!isset($user->error)){
				if($oSystemUserData = $this->user_model->getUserBy('facebook_id', $user['id'])){
					if($this->authentication->makeLogin($user['id'], 'facebook_id')){
						redirect('home');
					} else {
						sf('error_message', 'There was some problem. Could not log you in.');
						redirect('home');
					}	
				}
				$this->mcontents['fb_user'] 	= $user;
				$this->mcontents['email'] 		= $user->email;
				$this->mcontents['first_name'] 	= $user->first_name;
				$this->mcontents['middle_name'] = $user->middle_name;
				$this->mcontents['last_name'] 	= $user->last_name;
				$this->mcontents['gender']		= ('male' == $user->gender) ?  2 : 1;
				$this->mcontents['dob']			= $user->birthday;
			}else{
				$this->merror['error'] = $user->error;
			}
		}
		*/
		$this->mcontents['page_heading'] 	= 'Sign Up';
		$this->mcontents['page_title'] 		= 'Sign Up';
		
		$this->load->helper('captcha');
		
		$error	= FALSE;
		if (!empty($_POST) && isset($_POST)) {

			$this->_validate_signup();
			
			if (TRUE == $this->form_validation->run()) {
				
				//write_log('SIGNUP 4');
				$post_data['first_name']	= safeText('first_name');
				$post_data['middle_name']	= safeText('middle_name');
				$post_data['last_name']		= safeText('last_name');
				$post_data['email_id']		= safeText('email_id');
				$post_data['username']		= strtolower( safeText('username') );
				$post_data['birthday']		= safeText('dob');
	    		$post_data['password']		= $this->authentication->encryptPassword(safeText('password'));
	    		$post_data['status']		= $this->aUserStatus['pending'];
	    		$post_data['password']		= md5 (safeText('password'));
	    		$post_data['joined_on']		= date('Y-m-d H:i:s');
	    		$post_data['account_no']	= $this->authentication->generateAccountNumber();
	    		$post_data['type']			= $this->aUserTypes['user'];
	    		$post_data['gender']		= safeText('gender');
	    		
				if ($this->user_model->isUsernameExists($post_data['username'])){
					$error	= TRUE;
					$this->merror['error'] = "Username Exist";
				}
				if ($this->user_model->isEmailExists($post_data['email_id'])){
					$error	= TRUE;
					$this->merror['error'] = "Email Exist";
				}

				$aData = $this->_is_valid_dob($post_data['birthday']);
				if (!$aData['validity']){
					$error	= TRUE;
					$this->merror['error'] = $aData['message'];
				}
				
				function _is_valid_dob($sBirthDay){
					
				}
				
				if(!$error) {
					
					$this->db->set ($post_data);
			       	$this->db->insert ('users');
					
					if( $iUserId = $this->db->insert_id() ) {
						
						$oUser = $this->user_model->getUserBy('id', $iUserId);
						
						$this->load->model('common_model');
						$this->load->model('account_model');

						//Assign default profile image for user
						$this->account_model->createProfilePicture($oUser);
					
						//setProfilePic(s('USERID'), $aUploadData['file_name'], 'facebook' );
						ss('registratiion_email_id', $post_data['email_id']);
						
						//Send confirmation email to user
						$account_activation_code 		= $this->common_model->generateToken('account_activation', $iUserId, $iLength=0);
						$arr_email['receiver_name']				= $post_data['first_name'].' '.$post_data['last_name'];
						$arr_email['activation_url']	= site_url('user/account_activation/'.$account_activation_code);
						$arr_email['help_url']			= site_url('help');
						
						
						$this->load->helper('custom_mail');
						
						$aSettings = array(
							'to' 				=> array($post_data['email_id']=>$arr_email['receiver_name']), // email_id => name pairs
							'from_email' 		=> c('accounts_email_id'),
							'from_name'			=> c('accounts_email_from'),
							'reply_to' 			=> array(c('no_reply_email_id') => c('accounts_email_from')), // email_id => name pairs
							'email_contents' 	=> $arr_email, // placeholder keywords to be replaced with this data
							'template_name' 	=> 'registration_activation_link', //name of template to be used
							//'preview'			=> TRUE,
						);
						
						
						if( sendMail_PHPMailer($aSettings) ){
							//$this->session->set_flashdata ('success_message', 'Congratulation !. Your Registration is completed');
						}else{
							$this->session->set_flashdata ('info_message', 'Confirmation mail is not sent');
						}
						
						redirect('user/post_signup');
						
					} else {
						$this->merror['error']         = "unable_processing_message";
					}
				}
			}
		}
		
		
		$this->mcontents['load_js'][] 	= "jquery/jquery.validate.min.js";
		$this->mcontents['load_js'][] 	= "validation/signup.js";
		
		$this->mcontents['load_js'][] = 'jquery/jquery.datepicker.min.js';
		$this->mcontents['load_js'][] = 'datepicker/signup.js';
		$this->mcontents['load_js']['data']['password_min_length'] = c('password_min_length');
		
		$this->load->helper('date');
		$this->mcontents['load_js']['data']['minYear'] = minusFrom(date('Y-m-d H:i:s'), c('user_max_age'), "years", 'Y');
		$this->mcontents['load_js']['data']['maxYear'] = minusFrom(date('Y-m-d H:i:s'), c('user_min_age'), "years", 'Y');
		$this->mcontents['load_js']['data']['minDate'] = minusFrom(date('Y-m-d H:i:s'), c('user_max_age'), "years", 'Y-m-d');
		$this->mcontents['load_js']['data']['maxDate'] = minusFrom(date('Y-m-d H:i:s'), c('user_min_age'), "years", 'Y-m-d');
		
		
		$this->mcontents['load_css'][] = 'jquery-ui-1.8.16.custom.css';
		//	$this->mcontents['load_css'][] = 'form.css';
		//$this->mcontents['load_css'][] = 'forms/signup.css';
		
		$this->mcontents['aGenders'] 	= array(0=>'Select') + array_flip($this->aGenders);
		$this->mcontents['aCaptcha'] 	= getCaptcha();
		loadTemplate('user/signup', $this->mcontents);
	}
	
	
	/**
	 * redirected here after signup
	 *
	 */
	function post_signup() {
		
		$this->mcontents['page_title'] 		= 'Confirm your email-id';
		$this->mcontents['page_heading'] 	= 'Confirm your email-id';
		
		$this->load->language('signup');
		
		if( !$sEmail = s('registratiion_email_id') ) {
			redirect('home');
		}
		
		$this->mcontents['sConfirmEmailText'] 	= t('confirm_email_text', array($sEmail));;
		
		us('registratiion_email_id');
		
		loadTemplate('user/post_signup', $this->mcontents);
	}
	
	
	/**
	 *
	 * Activate the a user account when they click on the confirmation link in the email
	 *
	 */
	function account_activation($account_act_code='') {
		
		if( $this->authentication->is_user_logged_in() ) {
			
			redirect('home');
		}
		
		$this->mcontents['title']			= 'Account Activation';
		$this->mcontents['page_heading']	= 'Account Activation';
		
		if( !$account_act_code ) {
			
			redirect('home');
		}
		
		$this->load->model('common_model');
		$aResult = $this->common_model->isValidToken($account_act_code, 'account_activation');
		$aTokenStatus = c('token_status');

		if( $aResult['status'] != $aTokenStatus['valid'] ) {

			//find the reason why this token is not valid
			if( $aResult['status'] == $aTokenStatus['invalid'] ) {

				sf('error_message', 'Invalid Link. Please contact out support team');
			} elseif($aResult['status'] == $aTokenStatus['expired']) {

				sf('error_message', 'This link has expired. Click <a class="highlight1" href="'.c('base_url').'user/resend_account_activation/'.$account_act_code.'">here</a> to get another confirmation email');
			}
			
			redirect('home');
			
		} else {
			
			//activate the account
			if(true === $this->account_model->activateAccount($aResult['oToken']->user_id)){
				
				//delete the token
				$this->common_model->deleteToken($aResult['oToken']->id);
				
				
				if(!$this->authentication->makeLogin($aResult['oToken']->user_id)){
					
					sf('error_message', 'You could not be logged in. Please contact out admin');
				} else {
					
					// Send welcome message
					$this->load->model('maintenance_model');
					$this->maintenance_model->getSingleSetting('db_welcome_msg');
					$aWelcomeEmail['receiver_name'] = s('FULL_NAME');
					$aWelcomeEmail['welcome_text'] 	= $this->maintenance_model->getSingleSetting('db_signup_welcome_msg');
					
					$aSettings = array(
						'to' 				=> array(s('EMAIL') => s('FULL_NAME')), // email_id => name pairs
						'from_email' 		=> c('accounts_email_id'),
						'from_name'			=> c('accounts_email_from'),
						'reply_to' 			=> array(c('accounts_email_id') => c('accounts_email_from')), // email_id => name pairs
						'email_contents' 	=> $aWelcomeEmail, // placeholder keywords to be replaced with this data
						'template_name' 	=> 'welcome', //name of template to be used
						//'preview'			=> true
					);
					
					$this->load->helper('custom_mail');
					sendMail_PHPMailer($aSettings);
					
					sf('success_message', 'Account has been activated. Welcome to '.$this->mcontents['c_website_title']);
				}
				
			} else {
				sf('error_message', 'Could not activate!!');
			}

			
			redirect('home');
		}
	}
	
	
	function resend_link($sToken){
		
		//see if the token is an expired one
		$aResult = $this->common_model->isValidToken($sToken, 'account_activation');
		$aTokenStatus = c('token_status');
		
		if($aResult['status'] == $aTokenStatus['expired']){
			
		}
		
		redirect('home');
			//get the user and the purpose of the token
				//send the email
		
	}
	
	
	/**
	 * 
	 * resend account activation url to email and redirect to home page
	 * 
	 * WHy not write a common function to resend validation urls for different purposes??
	 *
	 */
	function resend_account_activation($sToken) {
		
		//see if the token is an expired one
		$aResult = $this->common_model->isValidToken($sToken, 'account_activation');
		$aTokenStatus = c('token_status');
		
		if($aResult['status'] == $aTokenStatus['expired']){
		
			$oToken = $aResult['oToken'];
			$oUser = $this->user_model->getUserBy('id', $oToken->user_id);
			//confirmation email to user
			$account_activation_code = $this->common_model->generateToken('account_activation', $oUser->id);
			$arr_email['name']				= $oUser->first_name . ' ' . $oUser->last_name;
			$arr_email['activation_url']	= site_url('user/account_activation/'.$account_activation_code);
			$arr_email['help_url']			= site_url('help');
			
			
			$this->load->helper('custom_mail');
			if(sendMail($oUser->email_id, $arr_email, 'registration_activation_link')){
				$this->session->set_flashdata ('success_message', 'Please Check your email now.');
			}else{
				$this->session->set_flashdata ('info_message', 'Confirmation mail is not sent');
			}
		}
		
		redirect('home');
	}
	
	
	function _validate_create_user() {

		$this->form_validation->set_rules ('first_name','First Name', 'trim|required');
		$this->form_validation->set_rules ('middle_name','Middle Name', 'trim');
		$this->form_validation->set_rules ('last_name','Last Name', 'trim');
	    $this->form_validation->set_rules ('email_id','Email', 'trim|valid_email');
	    $this->form_validation->set_rules ('username','Username', c('username_validation_rules'));
		$this->form_validation->set_rules ('dob','Date of Birth', 'trim');
		$this->form_validation->set_rules ('gender','Gender', 'trim');
		$this->form_validation->set_rules ('user_type','User Type', 'trim');
		$this->form_validation->set_rules ('user_roles','User Roles', '');
		
	}
	
	
	function _validate_signup(){

		$this->form_validation->set_rules ('first_name','First Name', 'trim|required');
		$this->form_validation->set_rules ('middle_name','Middle Name', 'trim');
		$this->form_validation->set_rules ('last_name','Last Name', 'trim|required');
	    $this->form_validation->set_rules ('email_id','Email', 'trim|required|valid_email');
	    $this->form_validation->set_rules ('username','Username', c('username_validation_rules'));
		$this->form_validation->set_rules ('password','Password', c('password_validation_rules'));
		$this->form_validation->set_rules ('password_again','Repeat Password', c('password_again_validation_rules'));
		$this->form_validation->set_rules ('dob','Date of Birth', 'trim');
		$this->form_validation->set_rules ('gender','Gender', 'trim|required');
	}
	
	
	/**
	 * Home page of user
	 *
	 */
	function home(){
		
		redirect('home');
	}
	
	
	/**
	 * Check availability of username and password 
	 * 
	 * accessed via ajax
	 *
	 * @param unknown_type $sType
	 */
	function checkavailability($sType='', $sValue='') {
		
		
		$aJasonData = array(
						'status'=>0,
						'output'=>'',
						'type' => $sType
						);
		$sOutput = true;
		
		
		if( ($sType == 'username' || $sType == 'email_id') ) {
			
			//if (!empty($_POST) && isset($_POST)) {
				$sLabel = '';
				//$sValue = '';
				if($sType == 'username'){
					
					$sLabel = 'Username';
					$sValue = safeText('username', false, 'get');
				} else {
					$sLabel = 'Email Id';
					$sValue = urldecode( safeText('email_id', false, 'get') );
				}
				
				// CHECK FOR VALID USERNAME HERE!!!??
				
				
				$this->db->where($sType, $sValue);
				$query = $this->db->get('users');
				if($query->row()){
					
					$sOutput = 'This '.$sLabel.' has been taken';
					
				} else {
					
					$sOutput = true;
				}				
			//}
			//$sOutput = $this->db->last_query();
		}
		
		$this->load->view('output', array('output'=>json_encode($sOutput)));
		
	}

	
	/**
	 * browser will redirect here after every fb login
	 * 
	 * @todo need to give an option to redirect to where the user came from.
	 *
	 */
	function handle_fb_login() {
		$this->load->library('facebook');		
		
		if(!$this->facebook->is_authenticated()){
			redirect('user/login');
		}
		
		$oFbUserData = (object) $this->facebook->request('get', '/me?fields=id,email,first_name,middle_name,last_name,gender,birthday,age_range');
		
		if(!isset($oFbUserData->email) || (isset($oFbUserData->email) && '' != $oFbUserData->email)){
			sf('error_message', "You hav'nt allowed email permission on facebook.");
		}
		
		
//		$user_profile = $this->facebook->api('/me');

		//p('AFTER');
		
		//$oFbUserData = (object)$user_profile;
		
		if($oSystemUserData = $this->user_model->getUserBy('facebook_id', $oFbUserData->id)){
			
			if($oSystemUserData->status == $this->aUserStatus['closed']){
				
				//reactivate the account
				$this->account_model->activateAccount($oSystemUserData->id);
				sf('success_message', 'Good To have you back!!');
				
			} elseif($oSystemUserData->status == $this->aUserStatus['blocked']){
				
					sf('error_message', "Your account is blocked. \nPlease use the Contact Us page to contact the Administrator");
					redirect('home');
					
			}
			
			//proceed with login
			if($this->authentication->makeLogin($oSystemUserData->facebook_id, 'facebook_id')){
				redirect('home');
			} else {
				sf('error_message', 'There was some problem. Could not log you in.');
				redirect('home');
			}			
			
		} else {
				//consider this as a first time login 
				//proceed with registration, mail sending, and login
				if(!$oSystemUserData = $this->user_model->getUserBy('email_id', $oFbUserData->email)) {
					
					$this->load->helper('custom_upload');
			       	$sUrl = getFbImage((object)array('facebook_id' => $oFbUserData->id), array('type'=>'large'), false);
			       	$aImageData = urlUpload('image', 'profile_pic', $sUrl);
			       				
					//registration
					$aUserData['facebook_id'] 	= $oFbUserData->id;
					$aUserData['email_id'] 		= $oFbUserData->email;
					$aUserData['account_no'] 	= $this->authentication->generateAccountNumber();
					$aUserData['type'] 			= $this->aUserTypes['user'];
					$aUserData['status'] 		= $this->aUserStatus['active'];
					$aUserData['joined_on'] 	= date('Y-m-d');
					$aUserData['first_name'] 	= isset($oFbUserData->first_name) ? $oFbUserData->first_name : '';
					$aUserData['middle_name'] 	= isset($oFbUserData->middle_name) ? $oFbUserData->middle_name : '';
					$aUserData['last_name'] 	= isset($oFbUserData->last_name) ? $oFbUserData->last_name : '';
					$aUserData['gender'] 		= $this->aGenders[$oFbUserData->gender];
					$aUserData['profile_image'] = $aImageData['file_name'];
					
					if(isset($oFbUserData->birthday) && '' != $oFbUserData->birthday){
						$aBirthday 	= explode('/', $oFbUserData->birthday); // mm/dd/yyyy
						$aUserData['birthday'] 		= $aBirthday[2].'-'.$aBirthday[0].'-'.$aBirthday[1];
					}
					$this->db->set ($aUserData);
			       	$this->db->insert ('users');

			       	$iUserId = $this->db->insert_id();
			       	
			       	
			       	//Login
			       	$this->authentication->makeLogin($oFbUserData->id, 'facebook_id');
			       	
			       	$this->account_model->activateAccount($iUserId);
			       	
//			       	update the profile pictures page
//			       	$aUploadType = c('profile_pic_upload_type');
//			       	$aProfilePicData = array(
//			       		'user_id' => $iUserId,
//			       		'current_pic' => $aUploadType['facebook'],
//			       		'facebook' => $aImageData['file_name'],
//			       	);


					/*$this->load->model('maintenance_model');
					$this->maintenance_model->getSingleSetting('db_welcome_msg');
			       	$aWelcomeEmail['receiver_name'] = $aUserData['first_name'];
			       	$aWelcomeEmail['welcome_text'] 	= $this->maintenance_model->getSingleSetting('db_signup_welcome_msg');
					*/
					$aSettings = array(
						'to' 				=> array($oFbUserData->email=>$aUserData['first_name']), // email_id => name pairs
						'from_email' 		=> c('accounts_email_id'),
						'from_name'			=> c('accounts_email_from'),
						'reply_to' 			=> array(c('accounts_email_id') => c('accounts_email_from')), // email_id => name pairs
						'email_contents' 	=> $aWelcomeEmail, // placeholder keywords to be replaced with this data
						'template_name' 	=> 'welcome', //name of template to be used
						//'preview'			=> true
					);
					
					//p(sendMail_PHPMailer($aSettings));exit;
					$this->load->helper('custom_mail');
					sendMail_PHPMailer($aSettings);
					
					$this->session->set_flashdata ('success_message', 'Welcome to '.$this->mcontents['c_website_title']);
					
			       	redirect('home');
					
				} else {
					echo '3';exit;
					sf('error_message', 'We already have an account associated with the email id '.$oFbUserData->email);
					redirect('home');
				}
				//$aFBUserData['facebook_id'] = 
		}
		
	}

	/**
	 *
	 *
	 * Before listing users, this page is displayed. for easy access to users of different roles
	 */
	function listing_home () {
		
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		$this->mcontents['page_title'] =  $this->mcontents['page_heading']	= 'Users by Roles';
		
		$this->_requireUserRolesDropdown();
		
		loadAdminTemplate('user/listing_home', $this->mcontents);
	}
	
	
	/**
	 * manage user from admin section
	 *
	 */
	function listing($iStatus=0, $iGender=0, $iUserRole=0, $iOffset=0) {

	
		$this->authentication->is_admin_logged_in (true);
		
		isAdminSection();
		$this->mcontents['uri_string'] = $this->uri->uri_string();
		$this->mcontents['load_js']['data']['uri_string'] = $this->mcontents['uri_string'];
		
		ss('BACKBUTTON_URI', $this->mcontents['uri_string']);
		ss('redirect_to', $this->mcontents['uri_string']); // used only related to the profile section
		
		$this->mcontents['page_title'] 		= 'Users';
		$this->mcontents['page_heading']	= 'Users';

		$this->load->helper('date');
		
		$aWhere = array();
		
		if($iStatus) {
			$aWhere['U.status'] = $iStatus;
		}
		if($iGender) {
			$aWhere['U.gender'] = $iGender;
		}
		
		if($iUserRole ) {
			$aWhere['URM.role'] = $iUserRole;
		}
		
		//exclude the admin
		$aWhere['U.type <>'] = $this->aUserTypes['admin'];
		
		
		$this->mcontents['iTotal'] = count($this->user_model->getUsers(0, 0, $aWhere));
		
		$this->mcontents['iPerPage'] = c('users_per_page');
		$this->mcontents['aData'] = $this->user_model->getUsers($this->mcontents['iPerPage'], $iOffset, $aWhere);
		
		/* Pagination */
		$this->load->library('pagination');
		$this->aPaginationConfiguration = array();
		$this->aPaginationConfiguration['base_url'] 	= c('base_url').'user/listing/'.$iStatus.'/'.$iGender.'/'.$iUserRole;
		$this->aPaginationConfiguration['total_rows'] 	= $this->mcontents['iTotal'];
		$this->aPaginationConfiguration['per_page'] 	= $this->mcontents['iPerPage'];
		$this->aPaginationConfiguration['uri_segment'] 	= 6;
		$this->pagination->customizePagination();
		$this->mcontents['iOffset'] = $iOffset;
		//$this->mcontents['load_css'][] = 'pagination.css';
		$this->pagination->initialize($this->aPaginationConfiguration);
		$this->mcontents['sPagination'] = $this->pagination->create_links();
		/* Pagination - End*/
		
		
		//$this->mcontents['load_css'][] 	= 'grid.css';
		//$this->mcontents['load_css'][] 	= 'admin/user_list.css';
		//$this->mcontents['load_js'][] 	= 'grid.js';
		$this->mcontents['load_js'][] 	= 'admin/user_listing.js';
		$this->mcontents['load_js'][] 	= 'jquery/jquery.blockui.js';
		$this->mcontents['load_js'][] 	= 'jquery/jquery.blockui.js';
		
		$this->mcontents['aMonths'] 			= numbersTill(0, 1, 12);
		$this->mcontents['aYears'] 				= numbersTill(0, 2011, 2015);
		$this->mcontents['iStatus'] 			= $iStatus;
		$this->mcontents['iUserRole'] 			= $iUserRole;
		$this->mcontents['iGender'] 			= $iGender;
		$this->mcontents['aUserStatus'] 		= array(0=>"All") + array_flip($this->aUserStatus);
		$this->mcontents['aGenders'] 			= array(0=>"Both") + array_flip($this->aGenders);
		
		//p( $this->mcontents['aAllRoles'] );
		
		
		$this->_requireUserRolesDropdown();
		
		loadAdminTemplate('user/listing', $this->mcontents);
		
	}
	
	
	
	/**
	 *
	 * make user roles array,  to use in a drop down
	 */
	function _requireUserRolesDropdown() {
		
		//p($this->mcontents['aAllRoles']);
		
		$this->mcontents['aAllUserRoles'][0] = 'All';
		foreach( $this->mcontents['aAllRoles'] AS $sName => $aItem ) {
			
			$this->mcontents['aAllUserRoles'][ $aItem['id'] ] = $aItem['title'];
		}
	}
		
	
	
	
	/**
	 * set user details 
	 * via AJAX
	 *
	 */
	function set($iAccountNo=0, $item='', $value='', $id='') {
		
		initializeJsonArray();
		if(isAdminLoggedIn()){
			
			if($oUser = $this->user_model->getUserBy('account_no', $iAccountNo)){
				
				switch ($item) {
					
					case 'status':
						if(in_array($value, $this->aUserStatus)){
							$this->db->where('account_no', $iAccountNo);
							$this->db->set('status', $value);
							$this->db->update('users');							
						}
						break;
					case 'mem':
						break;

				}
				$this->aJsonOutput['output']['id'] = $id;
				
			}
		} else {
			$this->aJsonOutput['output']['error_type'] = $this->aErrorTypes['not_logged_in'];
			$this->aJsonOutput['output']['error'] = '0';
		}
		outputJson();
	}
	
	
	function subscribe($sType="newsletter") {
		
		initializeJsonArray();
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		
		if($this->form_validation->run() !== false){
			
			$this->db->where('email', safeText($this->input->post('email')));
			if(!$this->db->get('newsletters')->row()){
				$this->db->set('email', safeText($this->input->post('email')));
				$this->db->insert('newsletters');								
			}
			$this->aJsonOutput['output']['success'] = formatMessage('you have been added to our subscription list. Please check your email', 'success');
		} else {
			$this->aJsonOutput['output']['error'] = formatMessage('Please enter a valid email id');
		}
		
		outputJson();
		
	}
	
	
	/**
	 *
	 * Permanently delete a user from the system
	 * accessed via AJAX
	 *
	 * TO DO : MERGE this functionality WITH THE "take_action" function in this controller
	 * 
	 */
	function perm_delete($iUserId=0, $sClass='') {
		
		initializeJsonArray();
		
		if(isAdminLoggedIn()){
			
			$oUser = $this->user_model->getUserBy('id', $iUserId);
			$this->account_model->closeAccount($oUser->id);
			
			
			$this->account_model->permanent_delete_routines($oUser);
			
			$this->db->where('id', $iUserId);
			$this->db->delete('users');
			$this->aJsonOutput['output']['success'] = 'The user has been deleted';
		} else {
			
			setPostLoginRedirect('user/listing');
			$this->aJsonOutput['output']['error_type'] = $this->aErrorTypes['not_logged_in'];
			$this->aJsonOutput['output']['error'] = 'Not logged In';
			
		}
		$this->aJsonOutput['output']['c'] = $sClass;
		outputJson();
	}
	

	/**
	 * Close the account of a user.
	 * 
	 * accessed via AJAX. ONLY by the admin user
	 */
	function take_action($sPurpose='', $iUserId=0, $sClass='') {
		
		$sCurrentUrl = urldecode( safeText('current_url', false, 'get') );
		$sCurrentUrl = $sCurrentUrl ? $sCurrentUrl : 'user/listing';
		
		if( !in_array( $sPurpose, array('close_account', 'logout') ) ) {
			redirect($sCurrentUrl);
		}
		
		initializeJsonArray();
		
		
		if( isAdminLoggedIn() ){
			
			if((s('USERID') != $iUserId)) {
		
				$oUser = $this->user_model->getUserBy('id', $iUserId);
				
				switch($sPurpose) {
					case 'close_account':
						
						$this->account_model->closeAccount($oUser->id);
						
						$this->aJsonOutput['output']['success'] = 'The account has been closed';						
						break;
					case 'logout':
						
						$this->authentication->logout_from_db($oUser->id);
						
						$this->aJsonOutput['output']['success'] = 'The user has been logged out';
						break;
				}
				
			} else {
				sf('Cannot close admin account!');
				redirect($sCurrentUrl);
			}
			
		} else {
			
			setPostLoginRedirect($sCurrentUrl);
			$this->aJsonOutput['output']['error_type'] = $this->aErrorTypes['not_logged_in'];
			$this->aJsonOutput['output']['error'] = 'Not logged In';
			
		}
		$this->aJsonOutput['output']['c'] = $sClass;
		outputJson();
	}
	
	/**
	 *
	 * edit user details like email, status roles etc
	 * 
	 */
	function edit($iAccountNo=0) {
		
		
		$this->authentication->is_admin_logged_in(true);
		
		if( !$this->mcontents['oUser'] = $this->user_model->getUserBy('account_no', $iAccountNo) ) {
			
			sf('error_message', 'Invalid user');
			redirect('user/listing');
			
		}
		
		isAdminSection();
		
		$this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Edit User';
		$this->mcontents['aExistingRoles'] = getUserRoles( $this->mcontents['oUser']->account_no );
		
		if ( isset($_POST) && !empty($_POST)) {
			
			
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			//$this->form_validation->set_rules('user_roles','User Roles', '');
			if ($this->form_validation->run() == TRUE) {
				
				$aData = array(
							'email_id' => safeText('email_id'),
							'status' => safeText('status'),
							'gender' => safeText('gender'),
						);
				
				$this->db->where('account_no', $iAccountNo);
				$this->db->update('users', $aData);
				
				//update roles.
				$aRoles 			= array_trim( safeText('user_roles') );
				
				$aDeletedRoles 	= array_diff($this->mcontents['aExistingRoles'], $aRoles);
				$aNewRoles 		= array_diff($aRoles, $this->mcontents['aExistingRoles']);

				
				//echo 'EXISTING : ';p( $this->mcontents['aExistingRoles']);
				//echo 'DELETED : ';p( $aDeletedRoles );
				//echo 'NEW : ';p( $aNewRoles );
				
				//p($aNewRoles);
				$this->_createRoles($aNewRoles, $this->mcontents['oUser']->account_no);
				$this->_deleteRoles($aDeletedRoles, $this->mcontents['oUser']->account_no);
				
				sf('success_message', 'The user data has been updated');
				redirect('user/edit/'.$iAccountNo);
				
			}
		}
		
		//p($this->mcontents['aExistingRoles']);
		
		$this->mcontents['aUserRolesTitles'] 	= $this->config->item('user_roles_title');
		$this->mcontents['iTotalNumRoles'] 		= count( $this->mcontents['aUserRolesTitles'] );
		$this->mcontents['aUserStatusFlipped'] 	= array_flip( $this->config->item('user_status') );
		$this->mcontents['iAccountNo'] 			= $iAccountNo;
		
		loadAdminTemplate('user/edit');
	}
	
	
	function _createRoles( $aRoles=array(), $iAccountNo ) {
		
		if( $aRoles ) {
			
		}
		foreach( $aRoles AS $iRole ) {
			
			$this->db->set('role', $iRole);
			$this->db->set('account_no', $iAccountNo);
			$this->db->insert('user_role_map');
			
		}
	}
	
	function _deleteRoles( $aRoles=array(), $iAccountNo ) {
		
		if( $aRoles ) {
			
		}
		foreach( $aRoles AS $iRole ) {
			
			$this->db->where('role', $iRole);
			$this->db->where('account_no', $iAccountNo);
			$this->db->delete('user_role_map');
			
		}
	}
	
	
	function list_program_management_team(){
		
		$this->authentication->is_admin_logged_in(true);
		
		isAdminSection();
		
		$this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Program Management Team';
		
		
		$this->mcontents['aData'] = $this->db->get('program_management_team')->result();
		
		$this->mcontents['load_js'][] = 'admin/program_management_team_listing.js';
		
		loadAdminTemplate('user/list_program_management_team');
	}
	
	
	
	function remove_program_management_team_memmber($sUserName='', $sClass='') {
		
		initializeJsonArray();
		
		if(isAdminLoggedIn()){
			
			
			$this->db->where('username', $sUserName);
			$this->db->delete('program_management_team');
			
			$this->aJsonOutput['output']['message'] = 'The user has been removed from project management team';
			
		} else {
			
			setPostLoginRedirect('user/list_program_management_team');
			$this->aJsonOutput['output']['error_type'] = $this->aErrorTypes['not_logged_in'];
			$this->aJsonOutput['output']['error'] = 'Not logged In';
			
		}
		$this->aJsonOutput['output']['c'] = $sClass;
		outputJson();
	}
	
	
	
	// add a program management team member
	function add_pmt_memmber () {
		
		$this->authentication->is_admin_logged_in(true);
		isAdminSection();
		
		$this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Add a user to Program Management Team';
		
		
		if (!empty($_POST) && isset($_POST)) {

			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			
			if (TRUE == $this->form_validation->run()) {
				
				$sUsername = safeText('username');
				
				
				if( !$oUser = $this->user_model->getUserBy('username', $sUsername) ) {
					
					$this->merror['error'][] = 'User does not exist';
				}
				
				if( ! $this->merror['error'] ) {
					
					$this->db->where('username', $sUsername);
					if( ! $this->db->get('program_management_team')->row() ) {
						
						
						$this->db->set('username', $sUsername);
						$this->db->insert('program_management_team');
						
						sf('success_message', 'User has been added to program management team');
						redirect('user/list_program_management_team');
						
					} else {
						$this->merror['error'][] = 'User is already in program management team';
					}
				}
				
			}
		}
		
		//$this->mcontents['aData'] = $this->db->get('program_management_team')->result();
		
		//$this->mcontents['load_js'][] = 'admin/program_management_team_listing.js';
		
		loadAdminTemplate('user/add_pmt_member');
		
	}
	
	function write_to_me_submit () {
		
		initializeJsonArray();
		$this->load->helper('captcha');

		if( isValidCaptcha() ) {
			
			//send mail routines here
			$this->aJsonOutput['output']['success'] = 'Your message has been sent to USERNAME_HERE. He/She will get back to you at the earliest.';
			
			
		} else {

			$this->aJsonOutput['output']['error'] = formatMessage('Your captcha code is incorrect. Enter the new captcha code above.', 'error');
		}
		
		outputJson();
		
	}
    
    
    

	/**
     *
	 * Create a payment
	 */
	public function support_profile($iAccountNo=0) {
		
        
		hasAccess(array('admin', 'staff'));
		
		isAdminSection();
		
        $this->mcontents['oUser'] = $this->user_model->getUserBy('account_no', $iAccountNo);
        
        $this->mcontents['page_heading'] = $this->mcontents['page_title'] 	= 'Support Profile - ' . $this->mcontents['oUser']->full_name;
        
        //p($this->mcontents['oUser']);
        
        //check if the user is an active one
        if( ! $this->mcontents['oUser'] || $this->mcontents['oUser']->status != 1 )  {
            
            sf('error_message', 'User does not exist');
            redirect('user/listing');
        }
        
        
        //get profile
        $this->db->where('account_no', $iAccountNo);
        $this->db->where('status', 1);
        if( ! $this->mcontents['oSupportProfile'] = $this->db->get('support_user_commitments')->row()) {
            
            //if no profile existed for a user, create one now
            $this->mcontents['oSupportProfile'] = (object)$this->user_model->createSupportProfile($iAccountNo);
        }
        
        //p($this->mcontents['oSupportProfile']);
        //p($this->mcontents['oSupportProfile']);
        
		if ( isset($_POST) && !empty($_POST)) {
            
            $post_data = array();
            $bProceed = true;
            
			$this->form_validation->set_rules('committed_amount', 'Committed Amount', 'trim|required');
			$this->form_validation->set_rules('payment_interval','Payment Interval', 'trim|required');
			$this->form_validation->set_rules('installment_amount','Installment Amount', 'trim|required');
			
			if ($this->form_validation->run() == TRUE) { 
				
				if( $bProceed ) {
					
					
					$post_data['amount'] 				= safeText('committed_amount');
					$post_data['payment_interval'] 		= safeText('payment_interval');
					$post_data['installment_amount'] 	= safeText('installment_amount');
					
					//p($post_data);exit;
					
					$this->db->where('uid', $this->mcontents['oSupportProfile']->uid);
					$this->db->update('support_user_commitments', $post_data);
					
					sf('success_message', 'The support profile has been updated');
					redirect('user/support_profile/' . $iAccountNo);
				}
			}
        }
        
        $this->mcontents['load_js'][] 	= 'jquery/jquery.validate.min.js';
        $this->mcontents['load_js'][]   = 'validation/support/support_profile.js';
		
		loadAdminTemplate('user/support_profile');
	}
    
    
    
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */