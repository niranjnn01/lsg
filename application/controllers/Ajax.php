<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ajax extends CI_Controller {

	function __construct() {
		
		parent::__construct();
		
		if(ENVIRONMENT_ == 'production') {
			if( ! $this->input->is_ajax_request() ) {
				exit;
			}
		}
		//p('constructor');
	}
	
	
	/**
	 *
	 * Check to see if the currently submitted captcha is valid or not
	 * Accessed via AJAX
	 *
	 */
	public function check_valid_captcha() {
		
		initializeJsonArray();
		$this->load->helper('captcha');
//p('test');
		if( isValidCaptcha() ) {
//p('test2');			
			$this->aJsonOutput['output']['success'] = 1;
			$this->aJsonOutput['output']['page'] = setValidatedCaptcha();
			
		} else {
//p('test3');			
			$this->aJsonOutput['output']['error'] = formatMessage('Your captcha code is incorrect. Enter the new captcha code above.', 'error');
		}
		
		outputJson();
	}

	
	
	/**
	 *
	 * The generic contact me form is submitted to and processed by this function
	 * 
	 * Accessed via AJAX
	 *
	 */
	public function generic_contact_me() {
		
		initializeJsonArray();
		$this->load->helper('captcha');

		if( isValidCaptcha() ) {

			$bEmailSent = true;
			
			// send email
			
			if ( $bEmailSent ) {
                
				$this->aJsonOutput['output']['success'] = 1;
				$this->aJsonOutput['output']['page'] = formatMessage('Your message has been sent', 'success');
                
			} else {
				$this->aJsonOutput['output']['error'] = formatMessage('Your captcha code is incorrect. Enter the new captcha code above.', 'error');
			}
			
		} else {

			$this->aJsonOutput['output']['error'] = formatMessage('Your captcha code is incorrect. Enter the new captcha code above.', 'error');
		}
		
		outputJson();
	}
	
	
	/**
	 *
	 * get a new captcha image.
	 *
	 */
	public function refresh_captcha() {
		
		//p('test 1');
		$CI = & get_instance();
		$CI->load->helper('captcha');
		
		
		//p('test 2');exit;
		destroyCaptcha();
		
		//see if some custom captcha setting was used for the page.
		$aConfig = s('custom_captcha_settings') ? unserialize(s('custom_captcha_settings')) : array();
		$aCaptcha = getCaptcha($aConfig, false);
		
		$CI->output->set_header('Content-type: application/json');
		$CI->load->view('output', array('output' => json_encode(array('captcha' => $aCaptcha['image'])) ));
	}
	
	
	/**
	 *
	 * Get programs, given the topic.
	 *
	 */
	public function get_programs($iTopicId=0) {
		
		initializeJsonArray();
		
		$this->aJsonOutput['output']['page'] .= '<option value="">Select</option>';
		$this->aJsonOutput['output']['page'] .= '<option value="0">Not Applicable</option>';
		
		$this->db->select('P.uid, P.title');
		//$this->db->join('topic_program_map TPM', 'TPM.program_id = P.uid');
		$this->db->where('P.topic_uid', $iTopicId);
		
		if( $aData = $this->db->get('programs P')->result() ) {
			
			foreach($aData AS $oRow) {
				
				$this->aJsonOutput['output']['page'] .= '<option value="'.$oRow->uid.'">'.$oRow->title.'</option>';
			}
		} else {
			$this->aJsonOutput['output']['error_type'] = $this->mcontents['aErrorTypes']['other'];
		}
		
		//p($this->db->last_query());
		
		outputJson();
	}
	

}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */