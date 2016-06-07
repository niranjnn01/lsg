<?php
class Profile_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	

	/**
	 *
	 * Get all information required to show a user profile
	 *
	 * @param integer $iAccountNo
	 * 
	 */
	function getUserProfile_1($by = 'account_no', $sValue) {
		
		$sField = 'U.account_no';
		if($by == 'username'){
			$sField = 'U.username';
		}
		
		$this->db->select("
			U.*,
			CONCAT_WS(' ', U.first_name, U.middle_name, U.last_name ) full_name,
			PP.current_pic
			", false);
		$this->db->join('profile_pictures PP', 'PP.user_id = U.id', 'left');
		$this->db->where($sField, $sValue);
		
		$oUser = $this->db->get('users U')->row();
		
		
		return $oUser;
	}
	
	
	/**
	 *
	 * Get all information required to show a user profile
	 *
	 * @param integer $iAccountNo
	 *
	 *
	 *  USE FUNCTION getUserProfile_1 INSTEAD. THIS FUNCTION WILL BE PHASED OUT SOON
	 * 
	 */
	function getUserProfile($iAccountNo) {
		
		
		/**
		 * USE FUNCTION getUserProfile_1 INSTEAD. THIS FUNCTION WILL BE PHASED OUT SOON
		 */
		
		$this->db->select("
			U.*,
			CONCAT_WS(' ', U.first_name, U.middle_name, U.last_name ) full_name,
			PP.current_pic
			", false);
		$this->db->join('profile_pictures PP', 'PP.user_id = U.id', 'left');
		$this->db->where('U.account_no', $iAccountNo);
		
		$oUser = $this->db->get('users U')->row();
		
		
		/**
		 * USE FUNCTION getUserProfile_1 INSTEAD. THIS FUNCTION WILL BE PHASED OUT SOON
		 */
		
		return $oUser;
	}
	
	
}