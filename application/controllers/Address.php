<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * All contact information (address, phone number etc) related process should be handled in this single location
 *
 */
class Address extends CI_Controller {

	public function __construct() {

		parent::__construct();
		
		$this->load->config('address_config');
		$this->load->model('address_model');
		
		$this->mcontents['aAddressOf'] 		= $this->config->item('address_of');
		$this->mcontents['aAddressStatus'] 	= $this->config->item('address_status');
		
		$this->load->model('common_model');//used in more than one place in the controller
	}
	
	/**
	 *
	 * FUCKKKKKKKKKKKKKKKK!!!!!!!!!!!!!
	 *
	 * make separate functions for getting address of user and that of office.!!!!
	 *
	 * WASTEEDT TIME WITHOUT PLANNING!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 *
	 *
	 */
	
	
	
	
	/**
	 *
	 * Manage a contact information.
	 * Both address and phone number
	 *
	 * 
	 * 9-9-2014 : It was decided, to have a single path for both creating and editing address and phone numbers.
	 * after creating/ updating an address, the corresponding mappings can be done on a case by case basis - ie, for users, or office etc etc
	 * 
	 * @param string $sEntityName Name of the entity for which we are creating address for eg: "user", "office" etc
	 * @param string $sEntityValue value of the entity, if any
	 */
	function create ( $sEntityName = '', $sEntityValue = '' ) {
		
		
		//sanitize the input
		$this->mcontents['sEntityName'] 	= $sEntityName = safeText($sEntityName, false, '', true);
		$this->mcontents['sEntityValue'] 	= $sEntityValue = safeText($sEntityValue, false, '', true);
		
		
		// only logged in user can access this page
		// change made on 9-9-2014 - means this section is accessed via admin side.
		// 9-9-2014 - $oUser = $this->authentication->is_user_logged_in (true, 'user/login', true);
		// 9-9-2014 - $this->mcontents['bIsAdmin'] = $this->authentication->is_admin_logged_in (true, 'user/login', true);
		//$this->authentication->is_admin_logged_in (true);
		
		hasAccess(array('admin', 'staff', 'user'));
		
		
		//check if we know how to handle the address once it is created.
		if( ! array_key_exists( $sEntityName, $this->mcontents['aAddressOf'] ) ){
			
			sf('error_message', 'Unidentified Entity');
			redirect('admin');
		}
		
		
		//initialize entity object
		$oEntity = (object) array();
		
		
		//check if an address is already created for this entity
		switch( $sEntityName ) {
			
			case 'user':
				
				//var_dump($sEntityName);
				//var_dump(is_numeric($sEntityName));
				$sEntityFieldName = is_numeric($sEntityValue)? 'account_no' : 'username';
				
				$this->load->model('user_model');
				if( ! $oEntity = $this->user_model->getUserBy($sEntityFieldName, $sEntityValue) ){
					
					//p( $this->db->last_query() );exit;
					
					sf('error_message', 'This user does not exist');
					redirect('admin');
				}
				if( ! is_null($oEntity->address_uid) ) {
					sf('error_message', 'This user already has an address');
					redirect('admin');
				}
				
				$sEntityValue = $oEntity->account_no;// we have to make sure the $sEntityValue in the case of "user" is the account_no of user
				
				break;
			
			case 'office':
				
				//$sEntityValue = office_uid - make sure of this !!!
				break;
		}
		
		
		// The possibility of a redirect is over get the necessary files for admin section, set title etc
		isAdminSection();
		
		$this->mcontents['page_title'] = $this->mcontents['page_heading'] 	= 'Create Address';
		
		
		
		if (!empty($_POST) && isset($_POST)) {
			
			$this->address_model->_validate_contact_info();
			
			$bProceed = true;
			
			if( $this->form_validation->run() !== false && $bProceed ) {
				
				$aContactNumbers = array();
				
				
				//make sure atleast one contact information is given
				$aContactNumbers['mobile1'] 		= safeText('mobile1');
				$aContactNumbers['mobile2'] 		= safeText('mobile2');
				
				$aContactNumbers['landline1'] 		= safeText('landline1');
				$aContactNumbers['landline1_code'] 	= safeText('landline1_code');
				$aContactNumbers['landline2'] 		= safeText('landline2');
				$aContactNumbers['landline2_code'] 	= safeText('landline2_code');
				
				if( !$aContactNumbers['mobile1']
					&& !$aContactNumbers['mobile2']
					&& !$aContactNumbers['landline1']
					&& !$aContactNumbers['landline2'] ) {
					
					$bProceed = false;
					$this->mcontentserror['error'][] = 'Give atleast one contact number';
				}
				
				
				if( $bProceed ) {
					
					
					$post_data = array();
					
					$post_data['uid']	= $this->common_model->generateUniqueNumber(
																						array('table' => 'address',
																							  'field' => 'uid'));
					$post_data['address_line1']	= safeText('address_line1');
					$post_data['address_line2']	= safeText('address_line2');
					$post_data['city']			= safeText('city');
					$post_data['state']			= safeText('state');
					$post_data['pincode']		= safeText('pincode');
					$post_data['status']		= $this->mcontents['aAddressStatus']['verified'];
					$post_data['updated_on'] 	= $post_data['created_on']	= date('Y-m-d H:i:s');
					
					
					$this->db->insert('address', $post_data);
					
					
					//get the contact numbers
					
					$aPhoneType = $this->config->item('phone_type');
					
					foreach( $aPhoneType AS $sKey => $iValue ) {
						for( $i=1; $i<=2; ++$i ) {
							
							if( $aContactNumbers[$sKey.$i] ) {
								
								$aPhoneData = array();
								$aPhoneData['address_uid'] 	= $post_data['uid'];
								$aPhoneData['phone_type'] 	= $aPhoneType[$sKey];
								$aPhoneData['code'] 		= ($sKey == 'mobile') ? '+91' : '';
								$aPhoneData['number'] 		= $aContactNumbers[$sKey.$i];
								$aPhoneData['status'] 		= 1;
								
								//insert into table
								$this->db->insert('phone_numbers', $aPhoneData);
							}
						}
					}
					
					
					
					//do the post-create routines for this particular entity
					$this->address_model->post_address_create_routines($sEntityName, $sEntityValue, $post_data['uid'], $oEntity);
					
					
					sf('success_message', 'Address has been created');
					redirect( 'address/edit/'.$post_data['uid'] . '/' . $sEntityName . '/' . $sEntityValue );
				}
			}
		}
		
		

		$aConfig = array(
					'table' => 'cities',
					'aWhere' => array('state_id' => 1),
				);
		
		$this->mcontents['aCities'] = $this->common_model->getDropDownArray( $aConfig );
		
		
		
		loadAdminTemplate('address/create');
	}
	
	
	
	/**
	 *
	 * Manage a contact information.
	 * Both address and phone number
	 *
	 * 
	 * 9-9-2014 : It was decided, to have a single path for both creating and editing address and phone numbers.
	 * after creating/ updating an address, the corresponding mappings can be done on a case by case basis - ie, for users, or office etc etc
	 * 
	 * @param string $sEntityName Name of the entity for which we are creating address for eg: "user", "office" etc
	 * @param string $sEntityValue value of the entity, if any
	 */
	function edit ( $iAddressUid='', $sEntityName = '', $sEntityValue = '' ) {
		
		
		//sanitize the input
		$this->mcontents['iAddressUid'] 	= $iAddressUid = safeText($iAddressUid, false, '', true);
		$this->mcontents['sEntityName'] 	= $sEntityName = safeText($sEntityName, false, '', true);
		$this->mcontents['sEntityValue'] 	= $sEntityValue = safeText($sEntityValue, false, '', true);
		
		
		// only logged in user can access this page
		// change made on 9-9-2014 - means this section is accessed via admin side.
		// 9-9-2014 - $oUser = $this->authentication->is_user_logged_in (true, 'user/login', true);
		// 9-9-2014 - $this->mcontents['bIsAdmin'] = $this->authentication->is_admin_logged_in (true, 'user/login', true);
		//$this->authentication->is_admin_logged_in (true);
		hasAccess(array('admin', 'staff', 'user'));
		
		
		//check if we know how to handle the address once it is created.
		if( ! array_key_exists( $sEntityName, $this->mcontents['aAddressOf'] ) ){
			
			sf('error_message', 'Unidentified Entity');
			redirect('admin');
		}
		
		
		//initialize entity object
		$oEntity = (object) array();
		
		/*
		//check if an address is already created for this entity
		switch( $sEntityName ) {
			
			case 'user':
				
				$sEntityFieldName = is_numeric($sEntityName)? 'account_no' : 'username';
				
				$this->load->model('user_model');
				if( ! $oEntity = $this->user_model->getUserBy($sEntityFieldName, $sEntityValue) ){
					
					sf('error_message', 'This user does not exist');
					redirect('admin');
				}
				if( ! is_null($oEntity->address_uid) ) {
					sf('error_message', 'This user already has an address');
					redirect('admin');
				}
				
				break;
			
			case 'office':
				break;
		}
		*/
		
		//get address of the entity
		if( ! $this->mcontents['oAddress'] = $this->address_model->get_address_and_contact_numbers($iAddressUid) ) {
			
			switch( $sEntityName ) {
				
				case 'user':
					
					sf('error_message', 'This user already has an address');
					redirect('admin');
					break;
				
				case 'office':
					break;
			}
			
		}
		
		// The possibility of a redirect is over get the necessary files for admin section, set title etc
		isAdminSection();
		
		$this->mcontents['page_title'] = $this->mcontents['page_heading'] 	= 'Edit Address';
		
		
		
		if (!empty($_POST) && isset($_POST)) {
			
			$this->address_model->_validate_contact_info();
			
			$bProceed = true;
			
			if( $this->form_validation->run() !== false && $bProceed ) {
				
				$aContactNumbers = array();
				
				
				//make sure atleast one contact information is given
				$aContactNumbers['mobile1'] 		= safeText('mobile1');
				$aContactNumbers['mobile2'] 		= safeText('mobile2');
				
				$aContactNumbers['landline1'] 		= safeText('landline1');
				$aContactNumbers['landline1_code'] 	= safeText('landline1_code');
				$aContactNumbers['landline2'] 		= safeText('landline2');
				$aContactNumbers['landline2_code'] 	= safeText('landline2_code');
				
				if( !$aContactNumbers['mobile1']
					&& !$aContactNumbers['mobile2']
					&& !$aContactNumbers['landline1']
					&& !$aContactNumbers['landline2'] ) {
					
					$bProceed = false;
					$this->mcontentserror['error'][] = 'Give atleast one contact number';
				}
				
				
				if( $bProceed ) {
					
					
					$post_data = array();
					
					
					$post_data['address_line1']	= safeText('address_line1');
					$post_data['address_line2']	= safeText('address_line2');
					$post_data['city']			= safeText('city');
					$post_data['state']			= safeText('state');
					$post_data['pincode']		= safeText('pincode');
					$post_data['status']		= $this->mcontents['aAddressStatus']['verified'];
					$post_data['updated_on'] 	= $post_data['created_on']	= date('Y-m-d H:i:s');
					
					
					$this->db->where('uid', $iAddressUid);
					$this->db->update('address', $post_data);
					
					
					//get the contact numbers
					
					$aPhoneType = $this->config->item('phone_type');
					
					foreach( $aPhoneType AS $sKey => $iValue ) {
						for( $i=1; $i<=2; ++$i ) {
							
							$temp = $sKey.$i;
							
							if( $aContactNumbers[$temp] ) {
								
								$aPhoneData = array();
								$aPhoneData['address_uid'] 	= $iAddressUid;
								$aPhoneData['phone_type'] 	= $aPhoneType[$sKey];
								$aPhoneData['code'] 		= ($sKey == 'mobile') ? '+91' : '';
								$aPhoneData['number'] 		= $aContactNumbers[$temp];
								$aPhoneData['status'] 		= 1;
								
								
								//insert into table
								$this->db->where('id', $this->mcontents['oAddress']->phone_details_raw[$temp]->id);
								$this->db->update('phone_numbers', $aPhoneData);
							}
						}
					}
					
					
					
					//do the post-create routines for this particular entity
					//$this->address_model->post_address_create_routines($sEntityName, $sEntityValue, $post_data['uid'], $oEntity);
					
					
					sf('success_message', 'Address has been updated');
					redirect( 'address/edit/'.$iAddressUid . '/' . $sEntityName . '/' . $sEntityValue );
				}
			}
		}
		
		

		$aConfig = array(
					'table' => 'cities',
					'aWhere' => array('state_id' => 1),
				);
		
		$this->mcontents['aCities'] = $this->common_model->getDropDownArray( $aConfig );
		
		//p($this->input->get('back_uri_string'));
		$back_uri = $this->input->get('back_uri_string') ? $this->input->get('back_uri_string') : $this->uri->uri_string();
		//p($back_uri);
		ss( 'BACKBUTTON_URI', $back_uri );
		
		
		
		loadAdminTemplate('address/edit');
	}
	
	
	/*
	 *
	 * moved to address mode, because it is now being used in more than 1 controller
	 * 
	function _validate_contact_info() {
		
		$this->form_validation->set_rules('address_of', 'Address of', 'trim');
		$this->form_validation->set_rules('title', 'Title', 'trim');
		$this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim');
		$this->form_validation->set_rules('address_line2', 'Address Line 2', 'trim');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
		$this->form_validation->set_rules('mobile1', 'Mobile 1', 'trim');
		$this->form_validation->set_rules('mobile2', 'Mobile 2', 'trim');
		$this->form_validation->set_rules('landline1', 'Land line 1', 'trim');
		$this->form_validation->set_rules('landline2', 'Land line 2', 'trim');
		
		
	}
	*/
}

/* End of file policy_advocacy.php */
/* Location: ./application/controllers/policy_advocacy.php */