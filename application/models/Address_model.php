<?php
class Address_model extends CI_Model{

	function __construct(){
		parent::__construct();
	
        $this->load->config('address_config');
		$this->aAddressTypes = c('address_types');
        $this->aPhoneTypes = $this->config->item('phone_type');
        $this->aPhoneTypesFlipped = array_flip($this->aPhoneTypes);
	}
    
	
	
	/**
	 *
	 * Given the uid, get the address and associated contact numbers
	 */
    function getAddressDetails( $iAddressUid , $sType="") {
        
        $oData = (object)array();
        
        switch( $sType ) {
            
            case "business":
                $sAddressTableName  = 'business_address';
                $sPhoneTableName    = 'business_phone_numbers';
                break;
            case "":
                $sAddressTableName  = 'address';
                $sPhoneTableName    = 'phone_numbers';
                break;
        }
        
        
        $this->db->where('uid', $iAddressUid);
        $oData->address_details = $this->db->get( $sAddressTableName )->row();
        
        
        //get office phone number details
        $this->db->where('address_uid', $iAddressUid);
        
        $oData->phone_details = (object)array();
        
        if( $phone_details = $this->db->get( $sPhoneTableName )->result() ) {
            
            //p($oData->phone_details);
            $aRow = array();
            //$oPhone_details->phone_details_raw = array();
            
            $iPhoneItemNo_mobile = 0;
            $iPhoneItemNo_landline = 0;
            
            $oData->phone_details->mobile1 = '';
            $oData->phone_details->mobile2 = '';
            $oData->phone_details->landline1 = '';
            $oData->phone_details->landline2 = '';
            
            foreach( $phone_details AS $iKey => & $oValue) {
                
                $variable = 'iPhoneItemNo_' . $this->aPhoneTypesFlipped[ $oValue->phone_type ];
                
                $$variable ++;
                
                $temp = $this->aPhoneTypesFlipped[$oValue->phone_type] . ($$variable);
                
                $oData->phone_details->$temp =	$oValue->number;
                $oData->phone_details_raw[$temp] = $oValue;
                
            }
            
            //$oData->phone_details_raw = $phone_details;
        }
        
        return $oData;
    }
    
    
    
    function get_contact_numbers() {
        
        $aContactNumbers = array();
        
        $aContactNumbers['mobile1'] 		= safeText('address_mobile1_');
        $aContactNumbers['mobile2'] 		= safeText('address_mobile2_');
        
        $aContactNumbers['landline1'] 		= safeText('address_landline1_');
        $aContactNumbers['landline1_code'] 	= safeText('address_landline1_code_');
        $aContactNumbers['landline2'] 		= safeText('address_landline2_');
        $aContactNumbers['landline2_code'] 	= safeText('address_landline2_code_');
        
        return $aContactNumbers;
    }
    
    
    
    /**
     *
     * Create address from the POST field data.
     */
    function create_address_and_contact_numbers(){
        
        $iAddressUid = 0;
        
        if( isValidAddress() ) {
            
            $aContactNumbers = $this->get_contact_numbers();
            
            
            /**
             *
             * Create address 
             */
            
            $aAddressStatus 		= $this->config->item('address_status');
            
            $aAddressData = array();
            
            $aAddressData['uid']	= $this->common_model->generateUniqueNumber(
                                                                                array('table' => 'address',
                                                                                      'field' => 'uid'));
            
            $aAddressData['address_line1']	= safeText('address_line1_');
            $aAddressData['address_line2']	= safeText('address_line2_');
            $aAddressData['district']		= safeText('district');
            $aAddressData['state']			= 1; // kerala
            $aAddressData['pincode']		= safeText('pincode');
            $aAddressData['status']			= $aAddressStatus['verified'];
            $aAddressData['updated_on'] 	= $aAddressData['created_on']	= date('Y-m-d H:i:s');
            
            //p($aAddressData);exit;
            $this->db->insert('address', $aAddressData);
            
            
            /**
             *
             * Create contact numbers
             */
            
            foreach( $this->aPhoneTypes AS $sKey => $iValue ) {
                for( $i=1; $i<=2; ++$i ) {
                    
                    if( $aContactNumbers[$sKey.$i] ) {
                        
                        $aPhoneData = array();
                        $aPhoneData['address_uid'] 	= $aAddressData['uid'];
                        $aPhoneData['phone_type'] 	= $this->aPhoneTypes[$sKey];
                        $aPhoneData['code'] 		= ($sKey == 'mobile') ? '+91' : '';
                        $aPhoneData['number'] 		= $aContactNumbers[$sKey.$i];
                        $aPhoneData['status'] 		= 1;
                        
                        //insert into table
                        $this->db->insert('phone_numbers', $aPhoneData);
                    }
                }
            }
            
            $iAddressUid = $aAddressData['uid'];
            
        }
        
        
        return $iAddressUid;
    }
    
    

    function update_address_and_contact_numbers( $oItem ) {
        
        $aContactNumbers = $this->get_contact_numbers();
        
        //p( $oItem );
		
        /**
         *
         * Create address 
         */
        
        $aAddressStatus 		= $this->config->item('address_status');
        
        $aAddressData = array();
        
        $aAddressData['address_line1']	= safeText('address_line1_');
        $aAddressData['address_line2']	= safeText('address_line2_');
        //$aAddressData['district']			= safeText('district');
		$aAddressData['city']			= safeText('address_city_');; // kerala
        $aAddressData['state']			= safeText('address_state_');; // kerala
        $aAddressData['pincode']		= safeText('address_pincode_');
        $aAddressData['status']			= $aAddressStatus['verified'];
        $aAddressData['updated_on'] 	= date('Y-m-d H:i:s');
        
        //p($aAddressData);exit;
        
		$iAddressUid = $oItem->address_details->uid;
		
        $this->db->where('uid', $iAddressUid);
        $this->db->update('address', $aAddressData);
        
        
        
        //update contat numbers
        $aPhoneType = $this->config->item('phone_type');
        
        foreach( $this->aPhoneTypes AS $sKey => $iValue ) {
            for( $i=1; $i<=2; ++$i ) {
                $temp = $sKey.$i;
                if( isset($aContactNumbers[$temp]) ) {
                    
                    $aPhoneData = array();
                    $aPhoneData['address_uid'] 	= $iAddressUid;
                    $aPhoneData['phone_type'] 	= $this->aPhoneTypes[$sKey];
                    $aPhoneData['code'] 		= ($sKey == 'mobile') ? '+91' : '';
                    $aPhoneData['number'] 		= $aContactNumbers[$temp];
                    $aPhoneData['status'] 		= 1;
                    
                    if( isset( $oItem->phone_details_raw[$temp] ) ) {
                        
                        $this->db->where('id', $oItem->phone_details_raw[$temp]->id);
                        $this->db->update('phone_numbers', $aPhoneData);
                    } else {
                        $this->db->insert('phone_numbers', $aPhoneData);
                    }
                    
                }
            }
        }
        
    }
	
	
	
	/**
	 *
	 * Get address and contact numbers into a single object
	 */
	function get_address_and_contact_numbers( $iAddressUid ) {
		
		
		$oData = (object)array();
		
		$this->db->select('
							A.*,
							CI.name city_name,
							S.name state_name,
							CO.name country_name
						');
		$this->db->where('uid', $iAddressUid );
		
		
		$this->db->join('cities CI', 'A.city = CI.id');
		$this->db->join('states S', 'CI.state_id = S.id');
		$this->db->join('countries CO', 'S.country_id = CO.id');
		$oData->address_details = $this->db->get('address A')->row();
		
		
		$this->load->config('address_config');
		
		$aPhoneTypes = $this->config->item('phone_type');
		$aPhoneTypesFlipped = array_flip($aPhoneTypes);
		
		
		//get office phone number details
		$this->db->where('address_uid', $iAddressUid );
		
		$aContactFields = array(
								'mobile1' 	=> '',
								'mobile2' 	=> '',
								'landline1' => '',
								'landline2' => ''
							);
		$oData->phone_details = (object)$aContactFields;
		$oData->phone_details_raw = $aContactFields;
		
		
		if( $phone_details = $this->db->get('phone_numbers')->result() ) {
			
			//p($oData->phone_details);
			$aRow = array();
			
			
			$iPhoneItemNo_mobile = 0;
			$iPhoneItemNo_landline = 0;
			/*
			$oData->phone_details->mobile1 = '';
			$oData->phone_details->mobile2 = '';
			$oData->phone_details->landline1 = '';
			$oData->phone_details->landline2 = '';
			*/
			foreach( $phone_details AS $iKey => & $oValue) {
				
				$variable = 'iPhoneItemNo_' . $aPhoneTypesFlipped[ $oValue->phone_type ];
				
				$$variable ++;
				
				$temp = $aPhoneTypesFlipped[$oValue->phone_type] . ($$variable);
				
				$oData->phone_details->$temp =	$oValue->number;
				$oData->phone_details_raw[$temp] = $oValue;
				
			}
			
			//$oData->phone_details_raw = $phone_details;
		}
		
		return $oData;
	}
	
	
	

	/**
	 *
	 * routines to do after creating an address
	 */
	function post_address_create_routines($sEntityName, $sEntityValue, $iAddressUid, $oEntity=NULL) {
		
		switch( $sEntityName ) {
			
			case 'user' :
				
				if( $sEntityValue ) {
					
					$this->db->set('address_uid', $iAddressUid);
					$this->db->where('account_no', $sEntityValue);
					$this->db->update('users');
					
				} else {
					$this->address_model->deleteAddress_Phone($iAddressUid);
					$this->merror[] = 'There was a problem during post create routines. Address not created!';
				}
				break;
			
			case 'office' :
				break;
		}
	}
	
    
    /**
     *
     * Given an address id, delete the address and related phone number
     */
    function deleteAddress_Phone( $iAddressUid ){
        
        $this->db->where('uid', $iAddressUid);
        $this->db->delete('address');
        
        $this->db->where('address_uid', $iAddressUid);
        $this->db->delete('phone_numbers');
    }


	function _validate_contact_info() {
		
		$this->form_validation->set_rules('address_of', 'Address of', 'trim');
		$this->form_validation->set_rules('title', 'Title', 'trim');
		$this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim');
		$this->form_validation->set_rules('address_line2', 'Address Line 2', 'trim');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('pincode', 'Pincode', 'trim');
		$this->form_validation->set_rules('mobile1', 'Mobile 1', 'trim');
		$this->form_validation->set_rules('mobile2', 'Mobile 2', 'trim');
		$this->form_validation->set_rules('landline1', 'Land line 1', 'trim');
		$this->form_validation->set_rules('landline2', 'Land line 2', 'trim');
		
		
	}
    
    
}