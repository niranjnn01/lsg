<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );


/**
 *
 * used to check if a user is logged in when interacting with flash contents
 * 
 * a token is issued against user logged state
 *
 * @return string
 * 
 */
function setFlashSessionToken($iAccountNo, $sPurpose='') {
	
	$CI = &get_instance();
	
	//encrypt the string with the key
	$sToken = str_shuffle( 'Youareinsafehandsnow' . str_shuffle(time() . $iAccountNo) );
	
	
	$CI->db->where('account_no', $iAccountNo);
	$CI->db->where('purpose', $sPurpose);
	$CI->db->delete('flash_upload_helper');
	//log_message('error', 'UNUSUAL 1');

	
	$CI->db->set('account_no', $iAccountNo);
	$CI->db->set('token', $sToken);
	$CI->db->set('purpose', $sPurpose);
	$CI->db->set('set_on', time());
	$CI->db->insert('flash_upload_helper');

	
	
	return $sToken;
}


/**
 *
 * Check if a token issued against user logged in is valid | takes data frm post
 *
 * @param string $sToken
 * @return boolean
 * 
 */
function isValidFlashSessionToken($sPurpose='', $bReturnRow = false ) {

	
	$CI = &get_instance();
	
	$return = 0;

//p( $_POST );
	//write_log('FLASH SESSION VALID 1');
	$sToken 	= safeText('uploadify_session_token');
	$iAccountNo = safeText('uploadify_user_acc_no');

    log_message('ERROR', $sToken);
    log_message('ERROR', $iAccountNo);
	//p($sToken);
	//p($iAccountNo);
	
	if( ! empty( $sToken ) && !empty($iAccountNo) ) {
	//write_log('FLASH SESSION VALID 2');	
		$CI->db->where('account_no', $iAccountNo);
		$CI->db->where('token', $sToken);
		$CI->db->where('purpose', $sPurpose);
		$CI->db->where('set_on > ', (time() - $CI->config->item('sess_expiration')));
		
		if($oData = $CI->db->get('flash_upload_helper')->row()) {
			//write_log('FLASH SESSION VALID 3');
			
			if($bReturnRow){
				$return = $oData;
			} else {
				$return = $iAccountNo;
			}
				

		}
		//p( $CI->db->last_query() );
	}
	
	return $return;
}

function unsetFlashSessionToken($iAccountNo, $sPurpose){
	
	$CI->db->where('account_no', $iAccountNo);
	$CI->db->where('purpose', $sPurpose);
	$CI->db->delete('flash_upload_helper');	
}