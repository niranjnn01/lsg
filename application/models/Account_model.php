<?php
class Account_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->aUserStatus = c('user_status');
		$this->aProfilePicUploadType = c('profile_pic_upload_type');
		$this->aAddressTypes = c('address_types');
	}
	
	/**
	 * Activate a given users account
	 * 
	 * perform all the routines/ checks required for making an account active
	 *
	 */
	function activateAccount($iUserId){
		
		//set the status of user as active
		$this->db->set('status', $this->aUserStatus['active']);
		$this->db->where('id', $iUserId);
		$this->db->update('users');
		
		/* avoid this step. use account no as the input of the function*/
		$oUser = $this->user_model->getUserBy('id', $iUserId);
		
		//PROFILE PICTURE
		$this->createProfilePicture($oUser);

		return true;
	}
	
	/**
	 * create profile picture if not already existing. (entry will be there if it was a previously closed account)
	 * its a seaparate function because its used when creating a user account by administarator
	 *
	 */
	function createProfilePicture($oUser){
		
		$this->db->where('user_id', $oUser->id);
		if( !$this->db->get('profile_pictures')->row() ) {
			
			$aProfilePic = array(
				'user_id' 			=> $oUser->id,
				'current_pic' 		=> $oUser->facebook_id ? $this->aProfilePicUploadType['facebook'] : $this->aProfilePicUploadType['none'],
				'last_updated_on' 	=> date('Y-m-d H:i:s'),
				'account_no' 		=> $oUser->account_no,
			);
			$this->db->insert('profile_pictures', $aProfilePic);
			
		}	
		
	}
	
	/**
	 * Close a given users account
	 * To be moved to the account model when we create one.
	 *
	 * @param unknown_type $iUserId
	 */
	function closeAccount($iUserId) {
		
		$oUser = $this->user_model->getUserBy('id', $iUserId);
		//p('here 2');exit;
		//logout the user
			$this->authentication->logout_from_db($iUserId); //this way, only the DB entry is cleared and session Data is kept intact
															 //this will help prevent the admin from being logged out, when he
															 // is closing another account.
		
		
		//set user status as closed
			$this->db->where('id', $iUserId);
			$this->db->set('status', $this->aUserStatus['closed']);
			$this->db->update('users');
		
		
		//Deal with the profile picture
		
			$this->db->where('user_id', $iUserId);
			$oData = $this->db->get('profile_pictures')->row();
		
			//delete pending images
			$this->load->helper('custom_upload');
			deletePendingImage('profile_pic', '', $oUser->account_no, true);
			
			//delete any old images which are left over
			deleteImage('profile_pic', $oData->upload);
			deleteImage('profile_pic', $oData->url);
			
			//set default picture
			$aProfilePic = array(
				'current_pic' => $this->aProfilePicUploadType['none'],
				'url' => '',
				'upload' => '',
				'last_updated_on' => date('Y-m-d H:i:s'),
			);
			$this->db->where('user_id', $iUserId);
			$this->db->update('profile_pictures', $aProfilePic);
			
			
		//empty record in user_address_map
			//$this->db->where('account_no', $oUser->account_no);
			//$this->db->delete('user_address_map');
			
			
		//delete any tokens
			$this->db->where('user_id', $iUserId);
			$this->db->delete('tokens');
			
		//delete any user roles	
			$this->db->where('account_no', $oUser->account_no);
			$this->db->delete('user_role_map');
			
			
		// IMPORTANT : Any other site specific stuff should be handled separately in a separate function.
		// deleteSiteSpecificUserData is used now
		
		$this->deleteSiteSpecificUserData($oUser);
		
		
		
		ss('account_deleted', 'YES');
		
	}
	
	/**
	 * Site specific user data that needs to be deleted on the event of either
	 * 1. closing of account by user
	 * 2. permanently deleting a user by admin.
	 * 
	 */
	function deleteSiteSpecificUserData($oUser) {
		
		//delete the user's association with programs
		$this->db->set('program_director', 0);
		$this->db->where('program_director', $oUser->account_no);
		$this->db->update('programs');
		
		//delete the user's association with campaigns
		$this->db->set('campaigner', 0);
		$this->db->where('campaigner', $oUser->account_no);
		$this->db->update('campaigns');
		
		//delete the user's association with campaigns
		$this->db->set('project_manager', 0);
		$this->db->where('project_manager', $oUser->account_no);
		$this->db->update('projects');
		
	}
	
	
	/**
	 * Stuff to do when permanently deleting a user from the system
	 *
	 *
	 */
	function permanent_delete_routines($oUser) {
		
		//Delete the profile picture table entry
		//(the profile picture will be taken care of by the closeAccount function)
		
		$this->db->where('account_no', $oUser->account_no);
		$this->db->delete('profile_pictures');
		
		
		// IMPORTANT : Any other site specific stuff should be handled separately in a separate function.
		// deleteSiteSpecificUserData is used now
		
		$this->deleteSiteSpecificUserData($oUser);
	}
	
	/**
	 * Check if the user has got a username and passord set.
	 * (Users logging in from facebook/ twitter wont have a username/password with the system)
	 */
	function hasUserNamePassword($iId, $sField = 'id'){
		
		$this->db->select('username, password');
		$this->db->where($sField, $iId);
		$oUser = $this->db->get('users')->row();
		
		if($oUser->username && $oUser->password){
			return true;
		} else {
			return false;
		}
	}
	

		
}