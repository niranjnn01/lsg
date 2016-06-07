<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {

	public function __construct(){

		parent::__construct();
        
		$this->load->config('contact_us');

		/*
		$this->mcontents['aContactUsPurpose'] 			= c('contact_us_purpose');
		$this->mcontents['aContactUsPurposeTitle'] 		= c('contact_us_purpose_title');
		$this->mcontents['aContactUsPurposeEmail'] 		= c('contact_us_purpose_email');
		$this->mcontents['aContactUsPurposeFlipped'] 	= array_flip($this->mcontents['aContactUsPurpose']);
		
		*/
        $this->mcontents['aPurposeStatus'] = $this->config->item('contact_us_purpose_status');
        
        $this->mcontents['sCurrentMainMenu']    = 'contact_us';
	}
	
	
	
	public function index() {
		
		$this->mcontents['iPurpose'] = 0;
		$this->mcontents['sPurpose'] = safeText( 'purpose', false, 'get');
		$this->mcontents['page_title'] 		= 'Contact Us';
		
        //get the purpose from the url if possible.
        
        $this->load->model('contact_us_model');
        if( ! $oPurposeDetails = $this->contact_us_model->getPurposeBy('seo_name', $this->mcontents['sPurpose']) ) {
            $this->mcontents['sPurpose'] = '';
        } else {
            $this->mcontents['iPurpose'] = $oPurposeDetails->uid;
        }
        
		
        // get the purposes list from DB
        $this->load->model('common_model');
        $aConfig = array(
                        'table'         => 'contact_us_purposes',
                        'id_field'      => 'uid',
                        'title_field'   => 'title',
                        'aOrderBy'      => array('uid' => 'ASC'),
                    );
        $this->mcontents['aContactUsPurpose'] = $this->common_model->getDropDownArray($aConfig);
        
        //p($this->mcontents['aContactUsPurpose']);
        
        
		$this->load->helper('captcha');
		$this->mcontents['aCaptcha'] = getCaptcha();

		//p($this->mcontents['aCaptcha']);
		
		ss('form_token', rand(10, 100));
		$this->mcontents['form_token'] = s('form_token');
		
		//$this->mcontents['load_css'][] = 'captcha/captcha.css';
		$this->mcontents['load_css'][] = 'contact_us.css';
		//$this->mcontents['load_css'][] = 'forms/contact_us.css';
		
		$this->mcontents['load_js'][] = 'captcha.js';
		$this->mcontents['load_js'][] = 'jquery/jquery.validate.min.js';
		//$this->mcontents['load_js'][] = 'jquery/jquery.validate.unmin.js';
		$this->mcontents['load_js'][] = 'validation/contact_us.js';
		$this->mcontents['load_js'][] = 'jquery/jquery.blockui.js';
		$this->mcontents['load_js']['data']['waiting_gif_text'] = c('waiting_gif_text');
		$this->mcontents['load_js']['data']['waiting_gif'] = c('waiting_gif');
		
		//$this->mcontents['aContactUsPurposeTitle'] = array(0=> 'Select') + $this->mcontents['aContactUsPurposeTitle'];

		
		// get the text editor
		requireTextEditor(array('profile' => 'minimal'));



		$this->mcontents['iDefaultPurpose'] = 0;
		if( set_value('contact_us_purpose') ) {
			$this->mcontents['iDefaultPurpose'] = set_value('contact_us_purpose');
		} elseif ( $this->mcontents['iPurpose'] ) {
			$this->mcontents['iDefaultPurpose'] = $this->mcontents['iPurpose'];
		}
		
		$this->mcontents['sCurrentMainMenu'] = 'contact_us';
		
        
        //populate the form from previous attempt . if any data available
        
        $this->mcontents['first_name']  = s('contact_us_first_name');
        $this->mcontents['last_name']   = s('contact_us_last_name');
        $this->mcontents['company']     = s('contact_us_company');
        $this->mcontents['email']       = s('contact_us_email');
        $this->mcontents['phone']       = s('contact_us_phone');
        $this->mcontents['message']     = s('contact_us_message');
        
        us('contact_us_first_name');
        us('contact_us_last_name');
        us('contact_us_company');
        us('contact_us_email');
        us('contact_us_phone');
        us('contact_us_message');
        
		
		loadTemplate('contact_us');
	}
	
	
	public function submit($form_token = '') {
	
		
		//if accessed without a valid form token, then redirect to contact_us page.
		//this will prevent direct access to the page, generating a upload size error.
		if(s('form_token') != $form_token){
	
			redirect('contact_us');
		}else {
			//unset the token
			us('form_token');
		}
	
		if( isset($_POST) && !empty($_POST) ) {
			
			$this->form_validation->set_message('is_natural_no_zero', 'The Purpose field is required');
			$this->form_validation->set_rules('fname', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lname', 'Last Name', 'trim');
			$this->form_validation->set_rules('company', 'Organization', 'trim');
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|trim');
			$this->form_validation->set_rules('phone', 'Your Phone', 'trim');
			$this->form_validation->set_rules('contact_us_purpose', 'Purpose', 'required|is_natural_no_zero');
			$this->form_validation->set_rules('message', 'Comments', 'trim|required');
			$this->form_validation->set_rules('captcha', 'Captcha', 'required');
			
			
			if( $this->form_validation->run() !== false ) {

				$this->load->helper('captcha');
				if( isValidatedCaptcha() ) {
					
                    // get the purposes list from DB
                    $this->load->model('common_model');
                    $aConfig = array(
                                    'table'         => 'contact_us_purposes',
                                    'id_field'      => 'uid',
                                    'title_field'   => 'title'
                                );
                    $this->mcontents['aContactUsPurpose'] = $this->common_model->getDropDownArray($aConfig);
                    
                    $iContactUsPurpose = safeHtml('contact_us_purpose') ? safeHtml('contact_us_purpose') : 1;
                    
                    $this->load->model('contact_us_model');
                    if( ! $oPurposeDetails = $this->contact_us_model->getPurposeBy('uid', $iContactUsPurpose) ) {
                        
                        $this->merror['error'][] = 'The purpose selected is invalid';
                    }
                    //p($oPurposeDetails);exit;
                    
					
					
					
					
				
					
					// Upload the file if any.
					$this->load->helper('custom_upload');
					
					$aUploadData = array();
					$sAttachementPath = '';
					
					//Check if upload has happened via uploadify
					
					if( safeText('post_uploadify_file_name') ) {
						
						//uploadify has done its job.
						$sAttachementPath = $this->config->item('contact_us_upload_path') . safeText('post_uploadify_file_name');
						
					} else {
						
						//check if uploadify did not work for some reason, and fell back to default file upload
						
						if( isset($_FILES) && ! empty($_FILES) && $_FILES['contact_us_file']['error'] != 4 ) {
							
							//give the script more time to execute. since we are allowing upload of upto 25 MB
							//set_time_limit(300); // 5 mins extra, cuz we are having upto 25 MB file upload.
							
							if ( ( $_FILES['contact_us_file']['error'] == 0 ) ) {
								
								//$this->load->helper('custom_upload');
								$aUploadData = uploadFile('file', 'contact_us', 'contact_us_file');
								
								$sAttachementPath = $this->config->item('contact_us_upload_path') . $aUploadData['file_name'];
								
							} else {
								
								$this->merror['error'] = 'There was some problem with file upload. Please try again';
							}
						}
						
					}
					
					
						if( empty( $this->merror['error'] ) ) {
							
							//So far... no errors. proceed
							
							//$iContactUsPurpose = safeHtml('contact_us_purpose') ? safeHtml('contact_us_purpose') : 1;
							
							$aEmailData = array(
								'receiver_name' => $oPurposeDetails->reciever_name,
								'name' 			=> safeText('fname') . ' ' . safeText('lname'),
								'email' 		=> safeText('email'),
								'telephone' 	=> safeText('phone'),
								'company' 		=> safeText('company'),
								'message' 		=> safeHtml('message'),
								'purpose_title' => $oPurposeDetails->title,
							);
							
							
							$sTemplateName = $oPurposeDetails->email_template_name;
							
							$this->load->helper('custom_mail');
							//p($oPurposeDetails);
							//USING PHPMAILER TO SEND EMAIL
							$aSettings = array(
								'to' 			=> array( $oPurposeDetails->email => $oPurposeDetails->reciever_name ),
								'from_email' 	=> $aEmailData['email'],
								'from_name'		=> $aEmailData['name'],
								'cc' 			=> array(),
								'reply_to' 		=> array($aEmailData['email'] => $aEmailData['name']), // email_id => name pairs
								'bcc' 			=> array(),
								'email_contents' => $aEmailData, // placeholder keywords to be replaced with this data
								'template_name' => $sTemplateName, //name of template to be used
								'attachment' 	=> $sAttachementPath,
								//'preview' 		=> true,
                                
							);
							
                            
                            
							//p($aSettings);exit;
							//p( sendMail_PHPMailer($aSettings) );exit;
							
							
							
							// routines to do when contacted for a particular purpose.
							//$this->_handle_purpose( $oPurposeDetails->uid );
							
							
                            
                            /*
                            // Send the email as a background process -
                            // unfortunately, this WILL NOT WORK on a shared hosting
                            
                            
							//save the email to DB.
                            
                            $aEmailSentStatus   = $this->config->item('email_sent_status');
                            $aEmailSendPriority = $this->config->item('email_send_priority');
                          
                            $this->db->set('settings', serialize($aSettings));
                            $this->db->set('priority', $aEmailSendPriority['normal']);
                            $this->db->set('sent_status', $aEmailSentStatus['not_sent']);
                            $this->db->set('created_on', date('Y-m-d H:i:s'));
                            
                            $this->db->insert('emails_to_send');
                            $iId = $this->db->insert_id();
                            
                            
                            $this->load->helper('cli');
                            $sBasePath = $this->config->item('base_path');
                            $sCommand = $sBasePath . "index.php cli send_mail " . $iId;
                            
                            
                            // For production environment, do not log the output. because you wont be able to run multiple processes.
                            // every process will be waiting for the first process to release the log file.
                            $sLogDestination = $sBasePath . APPPATH . 'logs/send_mails/log.log';
                            //$sLogDestination = '';
                            
                            
                            $sIniLocation = $sBasePath . 'send_email_php.ini';
                            runInBackground($sCommand, $sLogDestination, $sIniLocation, true);
                            
                            
                            
                            //get appropriate message to display - depending on purpose of contact
                            $aMessages = c('contact_us_purpose_success_message');
							$sSuccessMessage = $aMessages[$iContactUsPurpose];
                            
                            sf('success_message', $sSuccessMessage);
                            redirect('contact_us');
                            */
                            
							
							// if there is an attachment, then send it using another script
							// presence of a non empty $sAttachementPath indicates a successfull upload
							if( $sAttachementPath ) {
								
								// save the email to DB. and let another script handle its sending
								
								$aEmailSentStatus   = $this->config->item('email_sent_status');
								$aEmailSendPriority = $this->config->item('email_send_priority');
							  
								$this->db->set('settings', serialize($aSettings));
								$this->db->set('priority', $aEmailSendPriority['normal']);
								$this->db->set('sent_status', $aEmailSentStatus['not_sent']);
								$this->db->set('created_on', date('Y-m-d H:i:s'));
								
								$this->db->insert('emails_to_send');
								$iId = $this->db->insert_id();
								
								
								
								// call another script to send the email
								$ch = curl_init();
								
								// set URL and other appropriate options
								curl_setopt($ch, CURLOPT_URL, $this->mcontents['c_base_url'] .
																"contact_us/send_email_in_table/" .
																$iId . '/ox2im7g4l8al');
								
								curl_setopt($ch, CURLOPT_HEADER, false);
								curl_exec($ch);
								curl_close($ch);
								
								sf('success_message', $oPurposeDetails->success_message);
								redirect('contact_us');
								
								
							} else {
								
								// OLD CODE, which would directly attempt to send emails
								
								if( !sendMail_PHPMailer($aSettings) ) {
									
									$this->merror['error'][] = "There was some problem. Please try back later.";
									
								} else {
									
									//$aMessages = c('contact_us_purpose_success_message');
									//$sSuccessMessage = ;
									
									sf('success_message', $oPurposeDetails->success_message);
									redirect('contact_us');
								}
								
							}
							
							
                            
							
                            
						} else {
	
							//there was some error.
							
						}
					
					
				} else {
					$this->merror['error'][] = 'Your captcha code is incorrect. Please try again.';
				}
					
			} else {
				$this->merror['error'] = validation_errors();
			}
	
		}
		
		$iPurpose = set_value('contact_us_purpose');
		
		
		$sPupose = $iPurpose ? $oPurposeDetails->seo_name : '';
		
		
		if( !empty( $this->merror['error'] ) ) {
		
            //save form data to session
            ss('contact_us_first_name', set_value('fname'));
            ss('contact_us_last_name', set_value('lname'));
            ss('contact_us_company', set_value('company'));
            ss('contact_us_email', set_value('email'));
            ss('contact_us_phone', set_value('phone'));
            ss('contact_us_message', set_value('message'));
        	
            //p(s('contact_us_first_name'));exit;
            
			sf('error_message', combineMessages($this->merror['error']));
			redirect( 'contact_us' . ( $sPupose ? '?purpose=' . $sPupose : '' ) );
			
		} else {
			
			//should not reach here.
			redirect('contact_us');
		}
	}
	

	/**
	 *
	 * This script will get accessed in two ways.
	 * 1. when a contact us form is submitted, this code will be called via CURL
	 * 2. an hourly running cron job will run this script every hour to send any unsent emails.
	 * 
	 */
	function send_email_in_table ( $iId=0, $sKey='' ) {
		
		
		if( $oItem = $this->db->get('emails_to_send')->row() && 'ox2im7g4l8al' == $sKey ) {
			
			$this->load->model('contact_us_model');
			$this->contact_us_model->send_mail_from_db( $iId );
			
			/*
			//set the execution time to 5 minutes.
			ini_set('max_execution_time', 300);
			
			
		log_message('info', 'SEND MAIL - Started Running');
		//echo date('Y-m-d H:i:s') . " -- Started running...\n";
		
		$iMailId = safeText($iId, false, '', true);
		
		$aEmailSentStatus   = $this->config->item('email_sent_status');
		$aEmailSendPriority = $this->config->item('email_send_priority');
		
		

			
			$this->db->trans_start();
			
				$this->db->where('id', $iMailId);
				$this->db->where('sent_status', $aEmailSentStatus['not_sent']);
				
				
				if( $oRow = $this->db->get('emails_to_send')->row() ) {
					
						
						// update status of email in DB as "sending"
						// update the no: of attempts
						
						$this->db->set('sent_status', $aEmailSentStatus['sending']);
						$this->db->set('attempts', 'attempts+1');
						$this->db->where('id', $iMailId);
						$this->db->update('emails_to_send');
						
					
				}
			
			$this->db->trans_complete();
		
		
			$this->load->helper('custom_mail');
			
			$aSettings = unserialize( $oRow->settings );
			
			

			
			//set_time_limit(0); // without this, i am facing a time out error?
			
			//echo date('Y-m-d H:i:s') . " -- MAX_EXEC_TIME - " . ini_get('max_execution_time') . "\n";
			//log_message('info', 'SEND MAIL - MAX_EXEC_TIME - ' . ini_get('max_execution_time') );
			
			//echo date('Y-m-d H:i:s') . " -- processing mail to send...\n";
			//log_message('info', 'SEND MAIL - processing mail to send...');
			
			sendMail_PHPMailer($aSettings);
			
			if( empty( $CI->$this->merror['error'] ) ) {
				
				//echo date('Y-m-d H:i:s') . " -- mail sent successfully... \n";
				log_message('info', 'SEND MAIL - mail sent successfully');

				//echo date('Y-m-d H:i:s') . " -- deleting mail... \n";
				//log_message('info', 'SEND MAIL - deleting mail...');
				
				$this->db->set('sent_status', $aEmailSentStatus['sent']);
				$this->db->set('sent_on', date('Y-m-d H:i:s'));
				$this->db->where('id', $iMailId);
				$this->db->update('emails_to_send');
				
				
				// we are not deleting anything here. it will be handled by the cleanup routine.
				
				//echo date('Y-m-d H:i:s') . " -- done... \n";
			} else {
				
				log_message('info', 'SEND MAIL - mail sent FAILED');
				log_message('info', p($CI->$this->merror['error'], true));
				
				// change back the status of the email.
				$this->db->set('sent_status', $aEmailSentStatus['not_sent']);
				$this->db->set('error', $CI->$this->merror['error']);
				$this->db->where('id', $iMailId);
				$this->db->update('emails_to_send');
				
			}
			
			*/
			
		} else {
			
			redirect('home');
		}
	}
	
	
	/**
	 *
	 * routines to do when contacted for a particular purpose.
	 * 
	 */
	function _handle_purpose( $iContactUsPurpose ) {
		
		// handle purpose here if required.
		
	}
    
    
    /**
     *
     * Create a new purpose for contact us form
     * 
     */
    function purpose_listing( $iStatus=0, $iOffset=0 ) {
        
		$this->authentication->is_admin_logged_in(true);
		
		isAdminSection();
        
        $aWhere = $aOrderBy = array();
        
        $this->load->model('contact_us_model');
        
        $iLimit = 10;
		$this->mcontents['iTotal'] = count( $this->contact_us_model->getPurposes(0, 0, $aWhere, $aOrderBy) );
		$this->mcontents['aData'] = $this->contact_us_model->getPurposes($iLimit, $iOffset, $aWhere, $aOrderBy);
			
		
		/* Pagination */
		$this->load->library('pagination');
		$this->aPaginationConfiguration = array();
		$this->aPaginationConfiguration['base_url'] 	= c('base_url').'contact_us/purpose_listing/'.$iStatus;
		$this->aPaginationConfiguration['total_rows'] 	= $this->mcontents['iTotal'];
		$this->aPaginationConfiguration['per_page'] 	= $iLimit;
		$this->aPaginationConfiguration['uri_segment'] 	= 4;
		$this->pagination->customizePagination();
		$this->mcontents['iOffset'] 					= $iOffset;
		//$this->mcontents['load_css'][] 					= 'pagination.css';
		$this->pagination->initialize($this->aPaginationConfiguration);
		$this->mcontents['sPagination'] 				= $this->pagination->create_links();
		/* Pagination - End*/
        
        //$this->mcontents['load_css'][]  = 'grid.css';
        $this->mcontents['load_js'][]   = 'jquery/jquery.blockui.js';
        $this->mcontents['load_js'][]   = 'validation/contact_us/purpose_listing.js';
        
		$this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Contact Purposes';
            
        loadAdminTemplate('contact_us/purpose_listing', $this->mcontents);
    }
    
    
    /**
     *
     * Create a new purpose for contact us form
     * 
     */
    function add_purpose() {
        
        
		$this->authentication->is_admin_logged_in(true);
		
		isAdminSection();
        
        $this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Add contact us purpose';
        
		if( isset($_POST) && !empty($_POST) ) {
			
            $this->form_validation->set_message('greater_than', 'This field is required');
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('reciever_name', 'Reciever Name', 'required|trim');
			$this->form_validation->set_rules('email_template_id', 'Email Template', 'required|greater_than[0]');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('success_message', 'Success Message', 'required|trim');
			
			if( $this->form_validation->run() !== false ) {
                
                $this->db->where('id', safeText('email_template_id'));
                if( ! $this->db->get('email_templates')->row() ) {
                    
                    $this->merror['error'][] = 'invalid template';
                }
                
                
                if( empty($this->merror['error']) ) {
                    
                    $aData = array(
                                'title'                 => safeText('title'),
                                'email_template_id'     => safeText('email_template_id'),
                                'description'           => safeText('description'),
                                'email'                 => safeText('email'),
                                'reciever_name'         => safeText('reciever_name'),
                                'status'                => safeText('status'),
                                'success_message'       => safeText('success_message'),
                            );
                    $this->db->insert('contact_us_purposes', $aData);
                    
                    sf('success_message', 'New contact us purpose has been created.');
                    redirect('contact_us/add_purpose');
                }

            }
        }
        
        // get the email templates drop down
        $this->mcontents['aEmailTemplates'] = $this->_get_email_templates_dropdown();
        
        
        //$this->mcontents['load_css'][]  = 'form.css';
        //$this->mcontents['load_css'][]  = 'forms/contact_us/add_purpose.css';
        $this->mcontents['load_js'][]   = 'jquery/jquery.validate.min.js';
        $this->mcontents['load_js'][]   = 'validation/contact_us/add_purpose.js';
        
        
        
        loadAdminTemplate('contact_us/add_purpose');
        
        
    }
    
    
    // get the email templates drop down
    function _get_email_templates_dropdown() {
        
        $this->load->model('common_model');
        $aConfig = array(
                        'table'         => 'email_templates',
                        'id_field'      => 'id',
                        'title_field'   => 'title',
                        'aWhere'        => array(
                            'id <> ' => 1,
                        ),
                        'aOrderBy'        => array(
                            'title' => 'ASC',
                        )
                    );
        return $this->common_model->getDropDownArray($aConfig);
    }
    
    
    /**
     *
     * Create a new purpose for contact us form
     * 
     */
    function edit_purpose($iPurporseId) {
        
        
		$this->authentication->is_admin_logged_in(true);
		
        $this->load->model('contact_us_model');
        
        $iPurporseId = safeText($iPurporseId, false, '', true);
		if( !$this->mcontents['oPurpose'] = $this->contact_us_model->getPurposeBy('uid', $iPurporseId) ) {
			
			sf('error_message', 'The contact us purpose does not exist!');
			redirect('contact_us/purpose_listing');
		}
        
        
		isAdminSection();
        
        
        $this->mcontents['page_heading'] = $this->mcontents['page_title'] = 'Edit contact us purpose';
        
		if( isset($_POST) && !empty($_POST) ) {
			
            if( $iPurporseId != 1 ) {
                $this->form_validation->set_rules('title', 'Title', 'required|trim');
            }
			
            $this->form_validation->set_message('greater_than', 'This field is required');
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('reciever_name', 'Reciever Name', 'required|trim');
			$this->form_validation->set_rules('email_template_id', 'Email Template', 'required|greater_than[0]');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('success_message', 'Success Message', 'required|trim');
			
			if( $this->form_validation->run() !== false ) {
                
                $this->db->where('id', safeText('email_template_id'));
                if( ! $this->db->get('email_templates')->row() ) {
                    
                    $this->merror['error'][] = 'invalid template';
                }
                
                
                if( empty($this->merror['error']) ) {
                    
                    $aData = array(
                                
                                'description'       => safeText('description'),
                                'email'             => safeText('email'),
                                'reciever_name'             => safeText('reciever_name'),
                                'email_template_id' => safeText('email_template_id'),
                                'status'            => safeText('status'),
                                'success_message'   => safeText('success_message'),
                            );
                    //dont let the general purpose be changed. if the name has to be changed, change from the DB directly
                    if( $iPurporseId != 1 ) {
                        $aData['title'] = safeText('title');
                    }
                    //p($aData);exit;
                    $this->db->where('uid', $this->mcontents['oPurpose']->uid);
                    $this->db->update('contact_us_purposes', $aData);
                    
                    sf('success_message', 'The contact us purpose has been updated.');
                    redirect('contact_us/purpose_listing');
                }
                

            }
        }
        
        // get the email templates drop down
        $this->mcontents['aEmailTemplates'] = $this->_get_email_templates_dropdown();
        
        //$this->mcontents['load_css'][]  = 'form.css';
        //$this->mcontents['load_css'][]  = 'forms/contact_us/add_purpose.css';
        $this->mcontents['load_js'][]   = 'jquery/jquery.validate.min.js';
        $this->mcontents['load_js'][]   = 'validation/contact_us/add_purpose.js';
        
        
        
        loadAdminTemplate('contact_us/edit_purpose');
        
        
    }
    
	
	/**
	 *
	 * Uploadify will upload to this function
	 * 
	 */
	function upload_file () {
		
		initializeJsonArray();
		
		//$this->load->helper('flash');
		
		//if( $iAccountNo = isValidFlashSessionToken('contact_us') ) {
			
			$this->load->helper('custom_upload');
			
			$aUploadData = uploadFile('file', 'contact_us', 'contact_us_file');
			
			//addPendingImage('resource', $aUploadData['file_name'], $iAccountNo, false, '', $aUploadData);
			
			$this->aJsonOutput['output']['file_name'] 			= $aUploadData['file_name'];
			$this->aJsonOutput['output']['client_file_name'] 	= $aUploadData['raw_client_name'];
			
		//} else {
			
			
			//$this->aJsonOutput['output']['error'] 		= formatMessage('User not logged in', 'error');
			//$this->aJsonOutput['output']['error_type'] 	= $this->mcontents['aErrorTypes']['not_logged_in'];
			//$this->aJsonOutput['output']['message'] 	= 'we are here!!';
		//}
		
		outputJson();
	}
	
	
	
	/**
	 *
	 * when a file upload is cancelled, this function is called to do the clean up
	 * 
	 */
	function cancel_upload() {
		
		
		
	}
	
    /**
     *
     * Delete a purpose
     * cannot the purpose with id 1.
     * 
     **/
    function delete_purpose( $iUid, $sClass='' ) {
        
		initializeJsonArray();
		
        $iUid = safeText($iUid, false, '', true);
        
		if( isAdminLoggedIn() ) {
			
            //p($iUid);
            if( $iUid != 1 ) {
                
                $this->db->where('uid', $iUid);
                $this->db->delete('contact_us_purposes');
                
                $this->aJsonOutput['output']['success'] = formatMessage('The purpose has been deleted', 'success');
                
            } else {
                
                $this->aJsonOutput['output']['error'] = formatMessage('The "general" purpose cannot be deleted', 'error');
            }
			
			
		} else {
			
			$this->aJsonOutput['output']['error_type'] = $this->aErrorTypes['not_logged_in'];
			$this->aJsonOutput['output']['error'] = 'Not logged In';
			
		}
		$this->aJsonOutput['output']['c'] = $sClass;
		outputJson();
    }
    
	

	
}

/* End of file contact_us.php */
/* Location: ./application/controllers/contact_us.php */