<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {


	public function __construct() {

		parent::__construct();
	
		/*
		$this->mcontents = array();
		$this->merror['error'] = '';
		$this->mcontents['load_css'] = array();
		$this->mcontents['load_js'] = array();
		$this->mcontents['load_js']['data'] = array();
		*/
		
		$this->load->model('user_model');
		$this->load->model('profile_model');
		
		$this->aUserStatus 				= $this->config->item('user_status');
		$this->aUserTypes 				= $this->config->item('user_types');
		$this->aGenders 				= c('genders');
		$this->aProfilePicUploadType 	= c('profile_pic_upload_type');
		$this->aErrorTypes 				= c('error_types');
		
	}

	
	/**
	 *
	 * View a users profile
	 *
	 */
	public function view($input=0) {
		
		$iAccountNo = 0;
		$sUserName = '';
		
		if( is_numeric($input) ) {
			
			$iAccountNo = safeText($input, false, '', true);
			$this->mcontents['oUser'] = $this->profile_model->getUserProfile_1('account_no', $iAccountNo);
			
		} else {
			$sUserName = safeText($input, false, '', true);
			$this->mcontents['oUser'] = $this->profile_model->getUserProfile_1('username', $sUserName);
			
			//p('here');
			//p( $this->mcontents['oUser']->username );
			//exit;
			
		}
		
		//p( $input );
		//p( $this->mcontents['oUser'] );
		//p('here 1');
			//exit;
		
		if( ! $this->mcontents['oUser'] ) {
			
				sf('error_message', 'The requested profile could not be found!');
				redirect('home');
		}
		
        // only some of the users, can access their profiles using a pretty URL.(ex : http://thanal.co.in/shibu)
        // the following list of users should be in sync with the list in the /config/routes.php file
        // we are preventing these users profile to be viewd by the "un-pretty"(profile/view/...) way, because
        // of SEO concerns and to avoid confusion on the part of the user(s)
        $aSpecialUsers = array(
                            'shibu',
                            'jayakumar',
                            'usha',
                            'harish',
                            'daisy',
                            'sridhar',
                            'oommen',
                            'lekshmi',
                            'babychan',
                            'sreedevi',
							'Aswini'
                            //'rakesh',
                        );

        if( in_array($this->mcontents['oUser']->username , $aSpecialUsers) &&
            ($this->uri->segment(1) != $this->mcontents['oUser']->username) ) {
			
            redirect ( $this->mcontents['base_url'] . $this->mcontents['oUser']->username );
        }
        
        
        
		$this->mcontents['aGenders'] 	= array_flip($this->aGenders);
		
		$this->mcontents['page_title'] 		    = $this->mcontents['oUser']->full_name . '\'s profile';
		$this->mcontents['page_heading'] 	    = 'Profile';
		$this->mcontents['sCurrentMainMenu']    = 'profile_view';
		
		
		
		//get the designation/ role of the user
		$this->mcontents['aUserRoles'] = $this->user_model->getUserRoles( $this->mcontents['oUser'] );
		
		//$this->mcontents['aUserRolesTitles'] 	= $this->config->item('user_roles_title');
		
		$this->mcontents['sUserRolesText'] = '';
		foreach( $this->mcontents['aUserRoles'] AS $oItem ) {
			$this->mcontents['sUserRolesText'] .= $oItem->title . ', ';
		}
		$this->mcontents['sUserRolesText'] = rtrim($this->mcontents['sUserRolesText'], ', ');
		$this->mcontents['sUserRolesText'] = $this->mcontents['sUserRolesText'] ?
											$this->mcontents['sUserRolesText'] :
											'';
        
        /**
         *
         * Get the articles written by this user
         */

		$iLimit = 5;
		$iOffset = 0;
		$aWhere = array();
		$aWhere['A.status'] = 1;
		$aWhere['A.created_by'] = $this->mcontents['oUser']->account_no;
		$aOrderBy = array('A.published_on' => 'DESC');
		
        $this->load->model('article_model');
		//$this->mcontents['iTotal'] 			= count($this->article_model->getArticles(0, 0, $aWhere));
		$this->mcontents['aArticles'] 	= $this->article_model->getArticles($iLimit,
																			$iOffset,
																			$aWhere,
																			$aOrderBy);
        
		// pop up
		requirePopup('fancybox2');
		
		$this->mcontents['load_js'][] = 'profile/profile_view.js';
		

		// Have a hidden form in the page
		requireGenericContactForm( $iAccountNo, $this->mcontents['oUser']->full_name );
		$this->mcontents['iAccountNo'] = $iAccountNo;
		
		
        
        
		$this->load->helper('date');
		loadTemplate('profile/view');
	}
	
	
	/**
	 *
	 * Edit a users basic profile
	 *
	 */
	public function edit($iAccountNo=0) {
		
		
		$bIsAdmin = false;

		if( ! $this->authentication->is_user_logged_in(false, '', false) ) {

			if( $this->authentication->is_admin_logged_in(true, 'user/login') ){
				
				$bIsAdmin = true;
			}
			
		} else {
			
			if( $this->authentication->is_admin_logged_in(false) ) {
				
				$bIsAdmin = true;
			}
			
		}
		
		//p('AACC no: ' . $iAccountNo);
		//see if account number is present. else take account number of current user.
		// used when an admin is editing someones profile. i think..
		$iAccountNo = $iAccountNo ? $iAccountNo : s('ACCOUNT_NO');
		
		
		//see if the profile is being edited by its rightful owner, or the admin
		if( s('ACCOUNT_NO') != $iAccountNo ) {
			//p('test');exit;
			if(!$bIsAdmin){
				
				redirect('profile/edit/' . s('ACCOUNT_NO'));
			}
		}
		
		
		$sSection = 'profile_pic';
		
		if(isset($_POST) && !empty($_POST)) {
			
			$this->_validate_profile_edit();
			
			if( $this->form_validation->run() !== false ){
				
				$aData['first_name'] 	= safeText('first_name');
				$aData['middle_name'] 	= safeText('middle_name');
				$aData['last_name'] 	= safeText('last_name');
				$aData['title'] 	    = safeText('title');
				$aData['gender'] 		= safeText('gender');
				$aData['about_me'] 		= safeHtml('about_me');
				$aData['about_me_excerpt']	= safeText('about_me_excerpt');
				$aData['birthday']		= safeText('dob') ? safeText('dob') : NULL;
				$aData['facebook_url']	= safeText('facebook_url');
				$aData['twitter_url']	= safeText('twitter_url');
				$aData['blog_url']	    = safeText('blog_url');
				
				
				$this->load->helper('date');
				$bProceed = true;
				
				if( $aData['birthday'] ) {
					if( !validateDate( $aData['birthday'], 'YYYY-MM-DD') ) {
						$bProceed = false;
					}
				}
				
				
				if( $bProceed ) {
					
					$this->db->where('account_no', $iAccountNo);
					$this->db->update('users', $aData);
					
					
					//update to session.(Check if the admin was editing the user. in that case, need not update to session.)
					$bUpdateSession = false;
					if( s('USERID') == 1 ) {
						
						if( s('ACCOUNT_NO') == $iAccountNo ) {
							$bUpdateSession = true;
						}
						
					} else {
						
						$bUpdateSession = true;
					}
					
					if( $bUpdateSession ) {
						
						ss('FULL_NAME', $aData['first_name'] . " " . $aData['last_name']);
					}
					
					sf('success_message', 'Profile has been updated');
					
					
					//see if admin was editing someones profile.if yes, go back to the listing.
					if( $sRedirect = s('redirect_to') ) {
						
						us('redirect_to');
						redirect($sRedirect);
					} else {
						redirect('profile/edit/' . $iAccountNo);
					}
					
				} else {
					$this->merror['error'] = 'Invalid Date';
				}
			}
		}
		
		
		//load details of the user whose profile is being edited
		$this->mcontents['oUser'] = $this->profile_model->getUserProfile($iAccountNo);
		
		
		// load various informations
		$this->mcontents['page_title'] 					= 'Edit Profile';
		$this->mcontents['page_heading'] 				= 'Edit Profile';
		$this->mcontents['sSection'] 					= $sSection;
		$this->mcontents['aGenders'] 					= $this->aGenders;
		$this->mcontents['aProfilePicTypes'] 			= $this->mcontents['aProfilePicSelect'] = c('profile_pic_upload_type');
		$this->mcontents['profile_default_pic_img_tag'] = getDefaultPic('profile_pic', 'normal');
		//p('AACC no: ' . $iAccountNo);
		$this->mcontents['iAccountNo'] 					= $iAccountNo;

		
		
		//Ajax File Upload functionality
		$this->load->helper('custom_upload');
		requireUploaderFiles($sSection);
		
		
		// Tabbed display of contents
		$aTabbedContents = 	array(
							'Upload' 	=> $this->load->view('profile/upload_via_computer', $this->mcontents, true),
							'Url' 		=> $this->load->view('profile/upload_via_url', $this->mcontents, true),
							);
		if( $this->mcontents['oUser']->facebook_id ) {
			
			$aTabbedContents['Facebook'] = $this->load->view('profile/upload_via_facebook', $this->mcontents, true);
		}
		
		$aTabbedContents['No Picture'] = $this->load->view('profile/upload_default', $this->mcontents, true);
		
		$iSelectedTab = array_search($this->mcontents['oUser']->current_pic, $this->aProfilePicUploadType);
		$iSelectedTab = ($iSelectedTab === false) ? 0 : $iSelectedTab;
		$aTabbedSettings = array('content_type' => 'profile_pic_upload');
		$this->mcontents['sTabbedContent'] = getTabbedDisplay_bootstrap($aTabbedContents, $aTabbedSettings, array('selected' => $iSelectedTab));
		

		//load data that is required inside the JS files
		$this->load->helper('date');
		$this->mcontents['load_js']['data']['minYear'] 					= minusFrom(date('Y-m-d H:i:s'), c('user_max_age'), "years", 'Y');
		$this->mcontents['load_js']['data']['maxYear'] 					= minusFrom(date('Y-m-d H:i:s'), c('user_min_age'), "years", 'Y');
		$this->mcontents['load_js']['data']['minDate'] 					= minusFrom(date('Y-m-d H:i:s'), c('user_max_age'), "years", 'Y-m-d');
		$this->mcontents['load_js']['data']['maxDate'] 					= minusFrom(date('Y-m-d H:i:s'), c('user_min_age'), "years", 'Y-m-d');
		$this->mcontents['load_js']['data']['profile_default_pic_name'] = c('profile_pic_default_pic').'_normal.'.c('profile_pic_default_pic_ext');
		$this->mcontents['load_js']['data']['account_no'] 				= $iAccountNo;
		$this->mcontents['load_js']['data']['user_id'] 					= $this->mcontents['oUser']->id;
		$this->mcontents['load_js']['data']['profile_default_pic_url'] 	= c('profile_pic_default_pic_url');
		
		
		
		// the various JS and CSS files that are required
		
		$this->mcontents['load_js'][] = 'jquery/jquery.livequery.js';
		$this->mcontents['load_js'][] = 'jquery/jquery.blockui.js';
		
		//datepicker
		//$this->mcontents['load_js'][] = 'jquery/jquery.datepicker.min.js';
		$this->mcontents['load_js'][] = 'datepicker/signup.js';
		
		//form validation
		$this->mcontents['load_js'][] = 'jquery/jquery.validate.min.js';
		$this->mcontents['load_js'][] = 'validation/profile_pic_popup.js';
		$this->mcontents['load_js'][] = 'validation/profile_edit.js';
		
		//flash upload
		$this->mcontents['load_js'][] = 'uploadify/uploadify_profile_pic.js';
        
		$this->mcontents['load_js']['data']['iAccountNo'] = $iAccountNo;
        
        // pop up
		requirePopup('fancybox2');
		
		// common functionality
		$this->mcontents['load_js'][] = 'edit_profile.js';
		//$this->mcontents['load_css'][] = 'jquery-ui-1.8.16.custom.css';

		// get the text editor
		requireTextEditor(array('profile' => 'content_editor'));
        //$this->mcontents['load_js'][] = 'text-editor-perpage/generic.js';
        

		loadTemplate('profile/edit', $this->mcontents);
	}
	
	
	function _validate_profile_edit(){
		
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('about_me', 'About Me', 'trim');
		$this->form_validation->set_rules('about_me_excerpt', 'About Me Excerpt', 'trim');
		$this->form_validation->set_rules('dob', 'Birthday', 'trim');
	}
	
	
	
	

	
	
	/**
	 * 
	 * 
	 * This function will display the profile image change functionality in a different window.
	 *
	 */
	function change_profile_pic_std($iAccountNo=0) {
		
		
		$sSection = 'profile_pic';
		
		if( ! $this->mcontents['oUser'] = $this->profile_model->getUserProfile($iAccountNo) ) {
			
			sf('error_message', 'User does not exists');
			redirect('profile/edit/'.$iAccountNo);
		}
		
		
		if( $this->authentication->is_user_logged_in(true) ) {
			
			if(!$this->authentication->is_admin_logged_in()) {
			
				if( ! isOwner('account', $iAccountNo, s('USERID')) ) {
					
					//tried to change someone elses profile pic 
					exit;
					
				}					
			}
		}
		
		$this->mcontents['profile_default_pic_img_tag'] = getDefaultPic('profile_pic', 'small');
		$this->mcontents['iAccountNo'] = $iAccountNo;
		
		
		//Ajax(Flash) File Upload functionality
		$this->load->helper('custom_upload');
		requireUploaderFiles($sSection);
		
		
		// Tabbed display of contents - start
		/*
		$aTabbedContents = 	array(
			array(
				'title' => 'Upload',
				'content' => $this->load->view('profile/upload_via_computer', $this->mcontents, true)
			),
			array(
				'title' => 'Url',
				'content' => $this->load->view('profile/upload_via_url', $this->mcontents, true)
			)
		);
		
		if( $oUser->facebook_id ) {
			
			$aTabbedContents[] = array(
			
				'title' => 'Facebook',
				'content' => $this->load->view('profile/upload_via_facebook', $this->mcontents, true)
			);					
		}
		
		$aTabbedContents[] = array(
			'title' => 'No Picture',
			'content' => $this->load->view('profile/upload_default', $this->mcontents, true)
		);
		
		
		$iSelectedTab 						= array_search($oUser->current_pic, $this->aProfilePicUploadType);
		$iSelectedTab 						= ($iSelectedTab === false) ? 0 : $iSelectedTab;
		$aTabbedSettings 					= array('content_type' => 'profile_pic_upload');
		$this->mcontents['sTabbedContent'] 	= getTabbedDisplay_bootstrap($aTabbedContents, $aTabbedSettings, array('selected' => $iSelectedTab));
		*/
		
		// Tabbed display of contents - end
		
		//load data that is required inside the JS files
		$this->mcontents['load_js']['data']['user_id'] = $this->mcontents['oUser']->id;
		$this->mcontents['load_js']['data']['profile_default_pic_name'] = c('profile_pic_default_pic').'_normal.'.c('profile_pic_default_pic_ext');
		$this->mcontents['load_js']['data']['profile_default_pic_url'] = c('profile_pic_default_pic_url');
		$this->mcontents['load_js']['data']['account_no'] = $iAccountNo;
		
		
		$this->mcontents['load_js'][] = 'jquery/jquery.blockui.js';
		$this->mcontents['load_js'][] = 'jquery/jquery.validate.min.js';
		//$this->mcontents['load_js'][] = 'validation/profile_pic_popup.js';
		$this->mcontents['load_js'][] = 'validation/profile_edit.js';
		$this->mcontents['load_js'][] = 'uploadify/uploadify_profile_pic_std.js';
		//$this->mcontents['load_js'][] = 'iframe_common.js';
		
		$this->mcontents['load_js'][] = 'profile/edit_profile_common.js'; // to 
		$this->mcontents['load_js'][] = 'profile/profile_pic_std_common.js'; // to 
		
		
		// common functionality
		//$this->mcontents['load_js'][] 	= 'profile_pic_iframe.js';
		
		loadTemplate('profile/picture_upload_std/change_profile_pic_std');
	}
	
	

	
	
	/**
	 * Show the contents of the iframe in the pop up
	 * 
	 * @todo remove the js and css that will be loaded by the main controller function (edit)
	 *
	 */
	function change_profile_pic($iAccountNo=0) {
	
		$sSection = 'profile_pic';
		
		if( $oUser = $this->profile_model->getUserProfile($iAccountNo) ) {
			
			if( $this->authentication->is_admin_logged_in() || $this->authentication->is_user_logged_in() ) {
				
				if(!$this->authentication->is_admin_logged_in()){
				
					if( ! isOwner('account', $iAccountNo, s('USERID')) ) {
						
						//tried to change someone elses profile pic 
						exit;
						
					}					
				}
				
				$this->mcontents['oUser'] = $oUser;
				$this->mcontents['profile_default_pic_img_tag'] = getDefaultPic('profile_pic', 'small');
				$this->mcontents['iAccountNo'] = $iAccountNo;
				
				
				//Ajax(Flash) File Upload functionality
				$this->load->helper('custom_upload');
				requireUploaderFiles($sSection);
                
				//requireTabbedContents();
				
				// Tabbed display of contents - start
				$aTabbedContents = 	array(
					array(
						'title' => 'Upload',
						'content' => $this->load->view('profile/upload_via_computer', $this->mcontents, true)
					),
					array(
						'title' => 'Url',
						'content' => $this->load->view('profile/upload_via_url', $this->mcontents, true)
					)
				);
				
				if( $oUser->facebook_id ) {
					
					$aTabbedContents[] = array(
					
						'title' => 'Facebook',
						'content' => $this->load->view('profile/upload_via_facebook', $this->mcontents, true)
					);					
				}
				
				$aTabbedContents[] = array(
					'title' => 'No Picture',
					'content' => $this->load->view('profile/upload_default', $this->mcontents, true)
				);
				
				
				$iSelectedTab 						= array_search($oUser->current_pic, $this->aProfilePicUploadType);
				$iSelectedTab 						= ($iSelectedTab === false) ? 0 : $iSelectedTab;
				$aTabbedSettings 					= array('content_type' => 'profile_pic_upload');
				$this->mcontents['sTabbedContent'] 	= getTabbedDisplay_bootstrap($aTabbedContents, $aTabbedSettings, array('selected' => $iSelectedTab));
				
				
				// Tabbed display of contents - end
				
				//load data that is required inside the JS files
				$this->mcontents['load_js']['data']['user_id'] = $oUser->id;
				$this->mcontents['load_js']['data']['profile_default_pic_name'] = c('profile_pic_default_pic').'_normal.'.c('profile_pic_default_pic_ext');
				$this->mcontents['load_js']['data']['profile_default_pic_url'] = c('profile_pic_default_pic_url');
				$this->mcontents['load_js']['data']['account_no'] = $iAccountNo;
				
				
				$this->mcontents['load_js'][] = 'jquery/jquery.blockui.js';
				$this->mcontents['load_js'][] = 'jquery/jquery.validate.min.js';
				$this->mcontents['load_js'][] = 'validation/profile_pic_popup.js';
				$this->mcontents['load_js'][] = 'validation/profile_edit.js';
				$this->mcontents['load_js'][] = 'uploadify/uploadify_profile_pic.js';
				$this->mcontents['load_js'][] = 'iframe_common.js';
				
				$this->mcontents['load_js'][] = 'edit_profile.js'; // to 
				
				//do not load this
				// 20-9-2014 - following code might not be needed,
				// because in the iframe, we are loading only the specific files
				//$this->mcontents['avoid_js'][] = 'fancybox/jquery.fancybox-1.3.4.pack.js';
				
				// common functionality
				$this->mcontents['load_js'][] 	= 'profile_pic_iframe.js';
				//$this->mcontents['load_css'][] 	= 'jquery-ui-1.8.16.custom.css';
				//$this->mcontents['load_css'][] 	= 'forms/profile_pic_upload.css';
				
				
				$this->load->view('iframe_header', $this->mcontents);				
				$this->load->view('profile/change_profile_pic');
				$this->load->view('iframe_footer');
				
			}
		}
		
	}
	
	
	/**
	 *
	 * accept profile image submitted via ajax
	 * 
	 * and return the new image uploaded, or any errors in uploading
	 *
	 */
	function upload_profile_image($sAddMethod, $iAccountNo=0) {
		
		initializeJsonArray();
	
		if($sAddMethod == 'url') {
			
			if($this->authentication->is_user_logged_in()) {
			
				$this->form_validation->set_rules('url', 'Url', 'required');
				
				if($this->form_validation->run() !== false) {
					
					$this->load->helper('custom_upload');
					if( $aUploadData = urlUpload('image', 'profile_pic', safeText('url') )) {
		
						$iAccountNo = $iAccountNo ? $iAccountNo : s('ACCOUNT_NO');
						
						//Why the following line? Write comments
						ss('uploaded_profile_pic', $aUploadData['file_name']);
						ss('uploaded_profile_pic_type', $sAddMethod);
						
						$this->aJsonOutput['output']['page'] = getImage('profile_pic', $aUploadData['file_name'], 'normal');
						
						addPendingImage('profile_pic', $aUploadData['file_name'], $iAccountNo);
						
					} else {
						
						$this->aJsonOutput['output']['error'] = formatMessage($this->merror['error'],'error');
					}
				} else {
					
					$this->aJsonOutput['output']['error'] = formatMessage('The Url field is required.','error');
				}
			
			} else {
				
				$this->aJsonOutput['output']['error'] = formatMessage('User Not Logged in');
				$this->aJsonOutput['output']['error_type'] = $this->aErrorTypes['not_logged_in'];
			}
			
		} elseif($sAddMethod == 'upload') {
	
			if( isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] != 4 ) {
				
				$this->load->helper('flash');
				
				if( $iAccountNo = isValidFlashSessionToken('profile_pic') ) {
					
					// Thinking purpose of the token is met.. so we can delete this??
					// no.. the user can choose to upload yet another image instead of the present one.
					$this->load->helper('custom_upload');
					
					if( $aUploadData = uploadFile('image', 'profile_pic', 'profile_pic') ) {
						
						//upload has been done
						$this->aJsonOutput['output']['page'] 				= getImage('profile_pic', $aUploadData['file_name'], 'normal', array('class' => 'centralize_h'));
						$this->aJsonOutput['output']['data']['file_name'] 	= $aUploadData['file_name'];
						$this->aJsonOutput['output']['data']['account_no'] 	= $iAccountNo;
						
						addPendingImage('profile_pic', $aUploadData['file_name'], $iAccountNo);
						
					} else {
						
						$this->aJsonOutput['output']['error'] 		= formatMessage($this->merror['error'], 'error');
						$this->aJsonOutput['output']['error_type'] 	= $this->aErrorTypes['validation'];
					}
					
				} else {
					
					$this->aJsonOutput['output']['error'] 		= formatMessage('User not logged in', 'error');
					$this->aJsonOutput['output']['error_type'] 	= $this->aErrorTypes['not_logged_in'];
				}
				
			} else {
				
				$this->aJsonOutput['output']['error'] = formatMessage('No file specified for upload', 'error');
			}
			
		}
	
		outputJson();
	}


	/**
	 *
	 * fetch the image tag of the profile picture. with respect to what type is being requested.
	 * type can be 
	 * 1. facebook
	 * 2. url
	 * 3. uploaded
	 * 4. none
	 * 
	 * accessed via ajax
	 *
	 * @param unknown_type $sType
	 */
	function fetch_profile_pic($iUserId, $sType, $sSize='small') {

		$aOutput['output'] = array('error'=>'', 'page'=>'', 'data'=>array());
		
		if (array_key_exists($sType, $this->aProfilePicUploadType)) {
			
			if($sPic = hasSetProfilePic($iUserId, $sType)) {
				$aOutput['output']['page'] = getImage('profile_pic', $sPic, $sSize);
				$aOutput['output']['data']['upload_type'] = 'url';
			}
		}
		
		$aOutput['output'] = json_encode($aOutput['output']);
		$this->load->view('output', $aOutput);
	}
	
	
	/**
	 *
	 * Set the uploaded picture as the current profile picture.
	 *
	 */
	function set_profile_pic($sProfilePicType='', $iAccountNo='', $sProfilePic='') {
		
		$this->load->helper('image'); // what is the use here?
		
		if( $this->authentication->is_user_logged_in() ) {
			
			$iUserId = 0;
			
			if( $iAccountNo ) {
				$oUser = $this->user_model->getUserBy('account_no', $iAccountNo);
				$iUserId = $oUser->id;
				
			} else {
				
				$iUserId = s('USERID');
				$iAccountNo = s('ACCOUNT_NO');
			}
			
			if( $sProfilePicType == 'facebook' ) {
					
				setProfilePic($iUserId, '', $sProfilePicType);
			} else {
				
				if( empty($sProfilePicType) || empty($sProfilePic) ) {
					
					$sProfilePicType = s('uploaded_profile_pic_type');
					$sProfilePic = s('uploaded_profile_pic');				
				}
				
				if( $sProfilePic && $sProfilePicType ) {
				
					setProfilePic($iUserId, $sProfilePic, $sProfilePicType);
					
					us('uploaded_profile_pic_type');
					us('uploaded_profile_pic');
					
				}
			}
		}
	}
	
	
	/**
	 *
	 * User cancelled the upload of profile pic
	 * 
	 * this functionality is covered in the upload section. but its here too, so that 
	 * attacks can be avoided.
	 * 
	 * a user can upload 1000s of photos and just cancel each, thus flooding the server with images
	 *
	 */
	function profile_pic_cancel($iAccountNo=0) {
		
		if( $this->authentication->is_user_logged_in() ) {
			
            $iAccountNo = $iAccountNo ? $iAccountNo : s('ACCOUNT_NO');
            
			$this->load->helper('custom_upload');
			deletePendingImage('profile_pic', '', $iAccountNo, true);
		}
		
	}
	
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */