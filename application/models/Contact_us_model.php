<?php
class Contact_us_model extends CI_Model{

	function __construct(){
		parent::__construct();
		
		$this->load->config('contact_us');
		$this->aPurposeStatus = $this->config->item('contact_us_purpose_status');
	}

	
	/**
	 *
	 * Get a single purpose
	 * 
	 */
	function getPurposeBy($sField='uid', $sValue, $aWhere=array() ) {
		
		$sField = 'CUP.'.$sField;
        
        $aWhere[$sField] = $sValue;
        
		$this->db->select('
						  CUP.*,
						  ET.title email_template_title,
						  ET.name email_template_name,
						  ET.subject email_template_subject,
						  ET.body email_template_body,
						  ');
		
        if( $aWhere ) {
            $this->db->where($aWhere);
        }
		
		$this->db->join('email_templates ET', 'ET.id = CUP.email_template_id');
		$query = $this->db->get('contact_us_purposes CUP');
        
		//p($this->db->last_query());
        
		return $query->row();
	}
	
	
	/**
	 * get a list of purposes
	 *
	 * @param unknown_type $iLimit
	 * @param unknown_type $iOffset
	 * @param unknown_type $aWhere
	 * @return unknown
	 */
	function getPurposes( $iLimit=0, $iOffset=0, $aWhere=array(), $aOrderBy=array() ) {
		
		$this->db->select('CUP.*, ET.title email_template_title');
		
		if($iLimit || $iOffset){
			$this->db->limit($iLimit, $iOffset);
		}
		
		if($aWhere){
			$this->db->where($aWhere, false);
		}
		
		if($aOrderBy){
			foreach($aOrderBy AS $key=>$value){
				$this->db->order_by($key, $value);
			}
		}
        
		$this->db->join('email_templates ET', 'ET.id = CUP.email_template_id');
		
		//p($this->db->last_query());
		return $this->db->get('contact_us_purposes CUP')->result();
	}
	
	/**
	 *
	 * attempt to send an email from the emails_to_send table
	 * 
	 */
    function send_mail_from_db( $iMailId=0 ) {
		
		$iMailId = safeText($iMailId, false, '', true);
		
		$this->db->where('id', $iMailId);
		
		if( $oItem = $this->db->get('emails_to_send')->row() ) {
			
			//set the execution time to 5 minutes.
			ini_set('max_execution_time', 300);
			
			
			//log_message('info', 'SEND MAIL - Started Running');
			//echo date('Y-m-d H:i:s') . " -- Started running...\n";
		
			//$iMailId = safeText($iId, false, '', true);
		
			$aEmailSentStatus   = $this->config->item('email_sent_status');
			$aEmailSendPriority = $this->config->item('email_send_priority');
		
		

			
			$this->db->trans_start();
			
				$this->db->where('id', $iMailId);
				$this->db->where('sent_status', $aEmailSentStatus['not_sent']); // this is important, because mails can be in the "sending" status as well
				
				
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
			
			
			sendMail_PHPMailer($aSettings);
			
			if( empty( $CI->$this->merror['error'] ) ) {
				
				//log_message('info', 'SEND MAIL - mail sent successfully');
				
				$this->db->trans_start();
				$this->db->set('sent_status', $aEmailSentStatus['sent']);
				$this->db->set('sent_on', date('Y-m-d H:i:s'));
				$this->db->where('id', $iMailId);
				$this->db->update('emails_to_send');
				$this->db->trans_complete();
				
				// we are NOT DELETING anything here. it will be handled by the cleanup routine.
				
			} else {
				
				//log_message('info', 'SEND MAIL - mail sent FAILED');
				//log_message('info', p($CI->$this->merror['error'], true));
				
				// change back the status of the email to "not_sent".
				$this->db->trans_start();
				$this->db->set('sent_status', $aEmailSentStatus['not_sent']);
				$this->db->set('error', $CI->$this->merror['error']);
				$this->db->where('id', $iMailId);
				$this->db->update('emails_to_send');
				$this->db->trans_complete();
				
			}
			
		}
		
	}
	
	
	/**
	 *
	 * Delete a mail which is in the emails_to_send table
	 * 
	 */
	function delete_mail( $iMailId ) {
		
		$this->db->where('id', $iMailId)->row();
		
		if( $oRow = $this->db->get('emails_to_send')->row() ) {
			
			// delete the associated file
			$aSettings = unserialize($oRow->settings);
			unlink( $aSettings['attachment'] );
			
			// delete the table entry
			$this->db->where('id', $iMailId);
			$this->db->delete('emails_to_send');
		}
	}
	
	
	/**
	 *
	 * if there are any files in the contact_us upload folder, which are not present in the mails_to_send table,
	 * then delete them
	 *
	 * TAKE CAUTION TO NO DELETE THE index.html file!!
	 * 
	 */
	function delete_stray_files() {
		
		
		
		
		
	}
	
}