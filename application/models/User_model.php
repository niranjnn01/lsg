<?php
class User_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->aUserStatus = c('user_status');
		$this->aProfilePicUploadType = c('profile_pic_upload_type');
		
	}
	
	
	
	/**
	 * Enter description here...
	 *
	 * @param string $username
	 * @return boolean
	 */
	function isUsernameExists($username){
		$this->db->select('id');
		$this->db->where('username', $username);
		$result	=	$this->db->get ('users');
		$result	=	$result->row();
       	if($result){
       		return $result->id;
       	}
       	return FALSE;
	}
	
	/**
	 * Used during registration to check if a given email id exists
	 *
	 * @param string $email_id
	 * @param integer $user_id
	 * @return boolean
	 */
	function isEmailExists($email_id, $user_id ='') {
		
		if( ! $email_id ) {
			return false;
		}
		
		$this->db->select('id');
		$this->db->where('email_id', $email_id);
		
		if('' != $user_id && 0 < $user_id) {
			
			$this->db->where('id <> ', $user_id, FALSE);
		}
		
		$result	= $this->db->get ('users')->row();
		
		
       	if( $result ) {
			
       		return $result->id;
       	}
		
       	return FALSE;
	}
	
	/**
	 * generate activation code for an account
	 * 
	 * DEPLETED : USER getToken() in common_model
	 *
	 * @return unknown
	 */
//	function generateAccountActivationCode ($sPool=''){
//		
//	    $code_unique = false;
//	    $aData = getColumnData('users', 'account_activation_code');
//	    do{
//            $act_code = random_string ('numeric', c('account_activation_code_length'), $sPool);
//	    } while (!in_array($act_code, $aData));
//
//	    return $act_code;
//	}
	
	/**
	 * get details of a single user by
	 * 	1. id
	 * 	2. account_no
	 * 	3. facebook_id
	 * 	4. email_id
	 *
	 */
	function getUserBy($sFieldName, $sValue, $sInformationType = 'basic', $aWhere=array()){
		
		//p($aWhere);
		
		if( $sInformationType == 'basic' ){
			
			/* Standard User Informations from a single table */
			$this->db->select('
				U.*, 
				CONCAT_WS(" ", U.first_name, U.middle_name, U.last_name ) full_name,
				((date_format(now(),\'%Y\') - date_format(U.birthday,\'%Y\')) - (date_format(now(),\'00-%m-%d\') < date_format(U.birthday,\'00-%m-%d\'))) AS age,
			', false);	
			
		} elseif( $sInformationType == 'full' ){
		
			/* Additional Information by joining multiple tables */	
			$this->db->select('
							  U.*,
							  CONCAT_WS(" ", U.first_name, U.middle_name, U.last_name ) full_name,
							  PP.current_pic', false);
			$this->db->join('profile_pictures PP', 'PP.user_id = U.id', 'left');
			
		} elseif( $sInformationType == 'supporter_profile' ){
		
			//$this->load->config('support_config');
			/* Additional Information by joining multiple tables */	
			$this->db->select('
							  U.*,
							  CONCAT_WS(" ", U.first_name, U.middle_name, U.last_name ) full_name,
							  SUC.amount committed_amount,
							  SUC.excempt_from_commitment,
							  PP.current_pic');
			$this->db->join('profile_pictures PP', 'PP.user_id = U.id', 'left');
			$this->db->join('support_user_commitment SUC', 'SUC.account_no = U.account_no', 'left');
			
		}
		
		$this->db->where('U.'.$sFieldName, $sValue);
		
		if($aWhere){
			$this->db->where($aWhere);
		}
		
		$oUser = $this->db->get('users U')->row();

		return $oUser;
		
	}
	
	/**
	 * Stuff the needs to be done before logout
	 *
	 */
	function logout_routines($iUserId=0){
		
	}
	
	/**
	 * Stuff the needs to be done after login
	 *
	 */		
	function login_routines($iUserId=0){
		
	}
	
	/**
	 * get a list of users
	 *
	 * @param unknown_type $iLimit
	 * @param unknown_type $iOffset
	 * @param unknown_type $aWhere
	 * @return unknown
	 */
	function getUsers( $iLimit=0, $iOffset=0, $aWhere=array(), $aWhereIn=array(), $aWhereNotIn=array() ) {
		
		$sSelect = '
					U.*,
					CONCAT_WS(" ", U.first_name, , U.middle_name, U.last_name ) full_name,
					PP.current_pic';
					
					/*
		if( isset( $aWhere['URM.role'] ) ) {
			$sSelect .= ',UR.title role_title';
		}
		*/
					
		$this->db->select($sSelect, false);
		$this->db->join('profile_pictures PP', 'PP.user_id = U.id');
		
		if($iLimit || $iOffset) {
			$this->db->limit($iLimit, $iOffset);
		}
		
		if($aWhere) {
			$this->db->where($aWhere, false);
		}
		
		if($aWhereIn) {
			
			foreach( $aWhereIn AS $sKey => $aValues ) {
				
				$this->db->where_in($sKey, $aValues);
			}
			
		}
		
		if($aWhereNotIn) {
			
			foreach( $aWhereNotIn AS $sKey => $aValues ) {
				
				$this->db->where_not_in($sKey, $aValues);
			}
			
		}
		
		if( isset( $aWhere['URM.role'] ) ) {
			$this->db->join('user_role_map URM', 'URM.account_no = U.account_no');
		}
		
		return $this->db->get('users U')->result();
	}
    
    
    

	
	/**
     *
	 * get a list of users, to be used in the support section.
	 *
	 * The data will have an extra field, indicating if the user is a supporter or not 
	 */
	function getUsers_Support( $iLimit=0, $iOffset=0, $aWhere=array() ) {
		
        
        $this->load->config('support_config');
        
		$this->db->select('
			U.*,
			CONCAT_WS(" ", U.first_name, , U.middle_name, U.last_name ) full_name,
			PP.current_pic,
            IF(SUC.amount > '.c('supporter_commitent_min_limit').', 1, 0) is_supporter',
            false);
		$this->db->join('profile_pictures PP', 'PP.user_id = U.id');
		$this->db->join('support_user_commitments SUC', 'SUC.account_no = U.account_no', 'LEFT');
		
		if($iLimit || $iOffset) {
			$this->db->limit($iLimit, $iOffset);
		}
		
		if($aWhere) {
			$this->db->where($aWhere, false);
		}
		return $this->db->get('users U')->result();
	}
    
    

	/**
	 *
	 * get the roles of a user
	 * 
	 */
	function getUserRoles( $oUser ) {
		
		$this->db->select('URM.*, UR.title');
		
		$this->db->where('account_no', $oUser->account_no);
		$this->db->join('user_roles UR', 'URM.role = UR.id');
		$this->db->order_by('UR.weight', 'ASC');
		
		return $this->db->get('user_role_map URM')->result();
	}

	
    
    /**
     *
     * Create a dummy record in the "support_user_commitments" table
     */
    function createSupportProfile($iAccountNo){
        
        
        $this->load->model('common_model');
        $aData['uid'] = $this->common_model->generateUniqueNumber(
                                                array('table' => 'support_user_commitments',
                                                      'field' => 'uid'));
        $aData['account_no']        = $iAccountNo;
        $aData['amount']            = 0;
        $aData['payment_interval']  = 0;
        $aData['status']            = 1;
        $aData['created_on'] = $aData['updated_on'] = date('Y-m-d H:i:s');
        
        $this->db->insert('support_user_commitments', $aData);
        
        return $aData;
    }
	
	
	function getUsersByRole($sRole, $iLimit=0, $iOffset=0, $aWhere=array(), $aWhereIn=array(), $aWhereNotIn=array() ) {
		
		
		//$aUserRoles = $this->config->item('user_roles');
		
		
		$this->db->select('
						  U.id,
						  U.username,
						  U.account_no,
						  U.facebook_url,
						  U.twitter_url,
						  U.blog_url,
						  CONCAT_WS(" ", U.first_name, U.middle_name, U.last_name ) full_name,
						  U.profile_image,
						  PP.current_pic,
						  UR.name role_name,
						  UR.title role_title
						  ', false);
		

		if($aWhereNotIn) {
			
			foreach( $aWhereNotIn AS $sKey => $aValues ) {
				
				$this->db->where_not_in($sKey, $aValues);
			}
			
		}
		
		/*
		p($this->mcontents['aAllRoles']);
		p($sRole);
		exit;
		*/
		
		//$this->db->order_by('UR.weight', 'ASC');
		$this->db->join('profile_pictures PP', 'PP.user_id = U.id', 'left');
		$this->db->join('user_role_map URM', 'URM.account_no = U.account_no');
		$this->db->join('user_roles UR', 'UR.id = URM.role');
		$this->db->where('URM.role', $this->mcontents['aAllRoles'][$sRole]['id']);
		$aData = $this->db->get('users U')->result();
		
		return $aData;
	}
	
	
}