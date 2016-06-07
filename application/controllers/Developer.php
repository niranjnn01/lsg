<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developer extends CI_Controller {


	function __construct() {
		
		parent::__construct();
		
		
		$this->load->model('common_model');
	}
	
	function google_maps(){
		
		
		$this->load->view('developer/google_maps');
	}
	function password(){
		echo $this->authentication->encryptPassword( 'Sharadini' );
	}
	/*
    
    function seo_rename(){
        
        $this->load->model('common_model');
        
        $this->db->where('title', 'Scrap Dealer');
        foreach( $this->db->get('businesses')->result() AS $oRow ){
            
            $sSeoName = $this->common_model->getSeoName( $oRow->title, $oRow->uid );
            
            $this->db->where('uid', $oRow->uid);
            $this->db->set('seo_name', $sSeoName);
            $this->db->update('businesses');
        }
        
    }
	*/
	
	
	function user_address() {
	
		$iAddressUid = 29441733;
		$this->load->model('address_model');
		p( $this->address_model->get_address_and_contact_numbers($iAddressUid) );
	
	}
	
	function test_dynamic_header() {
		
		$this->common_model->generateHeader_dynamicParts();
		
	}
	
	
	function extractContactPerson(& $aLine) {
		
		$sContactPerson = trim($aLine[1]);
		
		$this->mcontents['business']['contact_person'] = $sContactPerson;
		
		unset($aLine[1]);
	}
	
	function extractAddress(& $aLine) {
		
		//p($aLine);
		$sPlace = trim($aLine[0]);
		unset($aLine[0]);
		
		$sAddressLine1 = implode(", ", $aLine);
		
		$iPlaceId = $this->createPlace($sPlace);
		
		$this->mcontents['business']['address_details']['uid'] = $this->common_model->generateUniqueNumber(
                                                                            array('table' => 'business_address',
                                                                                  'field' => 'uid'));
		$this->mcontents['business']['address_details']['address_line1'] = $sAddressLine1;
		$this->mcontents['business']['address_details']['address_line2'] = '';
		$this->mcontents['business']['address_details']['place'] = $iPlaceId;
		$this->mcontents['business']['address_details']['district'] = 11;
		$this->mcontents['business']['address_details']['state'] = 1;
		$this->mcontents['business']['address_details']['pincode'] = '';
		$this->mcontents['business']['address_details']['status'] = 1;
		$this->mcontents['business']['address_details']['created_on'] = date('Y-m-d H:i:s');
		$this->mcontents['business']['address_details']['updated_on'] = date('Y-m-d H:i:s');
		
		
	}
	
	function createPlace($sPlace){
		
		$this->db->where('name', $sPlace);
		if( $oItem = $this->db->get('places')->row() ) {
			
			//p($oItem);
			return $oItem->id;
		} else {
			
			$this->db->set('name', $sPlace);
			$this->db->set('district_id', 11);
			$this->db->insert('places');
			
			return $this->db->insert_id();
		}
	}
	
	function extractPhone(& $aLine) {
		
		$iCount = count($aLine);
		$iNumber = 0;
		
		for( $i = 1; $i < 3; ++$i ) {
			
			
			$iKey = $iCount - $i;
			
			//p($iKey);
			
			$sType = $this->getPhoneType($aLine[$iKey]);
			//p($aLine);
			//p($sType);
			
			switch( $sType ) {
				
				case 'mobile':
					$this->mcontents['business']['phone_details'][] = array(
						'phone_type' 	=> 1,
						'code' 			=> 91,
						'number' 		=> $aLine[$iKey],
						'status' 		=> 1,
						);
					/*
																		   );[] = 1;
					$this->mcontents['business']['phone_details'][][''] = 91;
					$this->mcontents['business']['phone_details'][][''] = $aLine[$iKey];
					$this->mcontents['business']['phone_details'][][''] = 1;
					*/
					unset( $aLine[$iKey] );
					break;
				case 'land':
					$this->mcontents['business']['phone_details'][] = array(
						'phone_type' 	=> 2,
						'code' 			=> '',
						'number' 		=> $aLine[$iKey],
						'status' 		=> 1,
						);
					/*
					$this->mcontents['business']['phone_details'][]['phone_type'] = 2;
					$this->mcontents['business']['phone_details'][]['code'] = '';
					$this->mcontents['business']['phone_details'][]['number'] = $aLine[$iKey];
					$this->mcontents['business']['phone_details'][]['status'] = 1;
					*/
					unset( $aLine[$iKey] );
					break;
			}
			
			
		}
	}
		
	function getPhoneType($sString) {
		
		
		$sString = trim($sString);
		
		if( is_numeric($sString) && ( (strlen($sString) == 10) || (strlen($sString) == 11) ) ) {
			//mobile
			return 'mobile';
		} else{
			//p($sString);
			if( strpos($sString, '0471') === 0  ) {
				// landline
				return 'land';
			}
		}
		
	}


	
	function initialize_array() {
		
		$this->mcontents['business'] = array(
									'address_details' => array(
															
														),
									'phone_details' => array(
															
														),
										);
	}	
	
	
	
	/**
	 *
	 * Create a new businesss
	 *
	 */
	function create_rag_pickers() {
		
		
		//$this->authentication->is_admin_logged_in(true);
		isAdminSection();
		
		$this->mcontentss['iAccountNo'] = $iAccountNo = s('ACCOUNT_NO');
		

		
		$this->mcontentss['page_heading'] = $this->mcontentss['page_title'] 		= 'Create Business';
		
		
        if ( isset($_POST) && !empty($_POST)) {

			$sData = safeText('description');
			//p($sData);
			
			$aData = explode("\n", $sData);
			
			//p($aData);
			
			$this->initialize_array();
			
			$this->mcontents['aPhoneBusinessMap'] = $this->get_phone_business_map();
			
			foreach($aData AS $aItem) {
				
				$this->initialize_array();
				
				$aLine = explode(',', $aItem);
				
				$this->extractPhone( $aLine );
				
				$this->extractContactPerson( $aLine );
				
				$this->extractAddress( $aLine );
					
					
                    $iBuisnessUid = $this->is_business_exist_ph();
					
				if( false === $iBuisnessUid ) {

					// create address and phone numbers
					
					//$iAddressUid = 0;
					$iAddressUid = $this->create_address_and_contact_numbers();
					//p($this->mcontents['business']);exit;
					$this->mcontents['business']['title'] = 'Rag Picker';
					
                    $iBuisnessUid = $this->common_model->generateUniqueNumber(
                                                                                array('table' => 'businesses',
                                                                                      'field' => 'uid'));
					$this->mcontents['business']['uid'] 			= $iBuisnessUid;
					$this->mcontents['business']['seo_name']		= $this->common_model->getSeoName($this->mcontents['business']['title'], $iBuisnessUid);
					$this->mcontents['business']['updated_on'] 	= $this->mcontents['business']['created_on']	= date('Y-m-d H:i:s');
					$this->mcontents['business']['status']		= 1;
					$this->mcontents['business']['display_image']	= '';
					$this->mcontents['business']['address_uid']	= $iAddressUid;
					$this->mcontents['business']['category']	= 2; // rag pickers
					
					$this->db->insert('businesses', $this->mcontents['business']);
					
				}
                
                //make the mapping between rag categorie
                $this->db->set('business_uid', $iBuisnessUid);
                $this->db->set('category_id', safeText('rag_category')); // this will change with every set of data | Rakesh
                $this->db->insert('rag_picker_category_mapping');
                
                
                $this->update_map( $iBuisnessUid );
                
				/*
				if( ! $this->mcontents['business']['phone_details'] ) {
					p( $this->mcontents['business'] );
				}
				*/
				
			}
            
			//p($this->mcontents['aPhoneBusinessMap']);exit;
            
			//p( $this->mcontents['business'] );
			
		}
		$this->mcontents['page_heading'] = '';
		
		loadAdminTemplate('developer/create_address_and_contact_numbers');
	}
	
	
	function update_map( $iBusinessUid ) {
						
		if( !empty( $this->mcontents['business']['phone_details'] ) ) {
			foreach( $this->mcontents['business']['phone_details'] AS $aPhoneDetail ) {
				if( ! isset( $aPhoneDetail['number'] ) ) {
					$this->mcontents['aPhoneBusinessMap'][$aPhoneDetail['number']] = $iBusinessUid;
				}
			}
		}
	}
	
	function is_business_exist_ph() {
		
		if( $this->mcontents['business']['phone_details'] ) {
			
			foreach( $this->mcontents['business']['phone_details'] AS $aPhoneDetail ) {
				
				if( isset($aPhoneDetail['number']) && !empty($aPhoneDetail['number']) ) {
					
					if( isset( $this->mcontents['aPhoneBusinessMap'][$aPhoneDetail['number']] ) ) {
						
                        return $this->mcontents['aPhoneBusinessMap'][$aPhoneDetail['number']];
						
					}
				}
			}
		}
		
		return false;
	}
	
	
	
	function get_phone_business_map() {
		
		$aData = array();
		$this->db->select('B.uid, P.number');
		$this->db->join('business_address A', 'A.uid = B.address_uid');
		$this->db->join('business_phone_numbers P', 'P.address_uid = A.uid');
		foreach( $this->db->get('businesses B')->result() AS $oRow ) {
			$aData[$oRow->number] = $oRow->uid;
		}
		
		return $aData;
	}
	
	
	
    function create_address_and_contact_numbers(){
        
		$iReturn = 0;
        $aContactNumbers = $this->get_contact_numbers();
        
		//p($this->mcontents['business']);
		
		//unset( $this->mcontents['business']['phone_details'] );
		//p($this->mcontents['business']);
		
		//exit;
		
		/**
         *
         * Create address
         * 
         */
        if( $iAddresdUid = $this->mcontents['business']['address_details']['uid'] ) {
			
			$iReturn = $iAddresdUid;
			
			$this->db->insert('business_address', $this->mcontents['business']['address_details']);
			unset($this->mcontents['business']['address_details']);
			
			
			if( !empty( $this->mcontents['business']['phone_details'] ) ) {
				
				foreach($this->mcontents['business']['phone_details'] AS $aPhoneData){
					
					$aPhoneData['address_uid'] = $iAddresdUid;
					
					$this->db->insert('business_phone_numbers', $aPhoneData);
				}
			}
			
			unset( $this->mcontents['business']['phone_details'] );
		}
		//p($this->mcontents['business']);
		//exit;
		return $iReturn;
		
    }
	
	
	

    function validate_contact_numbers(){
        
        $bReturn = true;
        $aContactNumbers = $this->get_contact_numbers();
        if( !$aContactNumbers['mobile1']
            && !$aContactNumbers['mobile2']
            && !$aContactNumbers['landline1']
            && !$aContactNumbers['landline2'] ) {
            
            $bReturn = false;
            $this->merror['error'][] = 'Give atleast one contact number';
        }
        
        return $bReturn;
    }


    function get_contact_numbers() {
        
        $aContactNumbers = array();
        
        $aContactNumbers['mobile1'] 		= safeText('mobile1');
        $aContactNumbers['mobile2'] 		= safeText('mobile2');
        
        $aContactNumbers['landline1'] 		= safeText('landline1');
        $aContactNumbers['landline1_code'] 	= safeText('landline1_code');
        $aContactNumbers['landline2'] 		= safeText('landline2');
        $aContactNumbers['landline2_code'] 	= safeText('landline2_code');
        
        return $aContactNumbers;
    }
	
	
	public function res_config() {
        
        $this->load->model('resource_model');
        $aData = $this->resource_model->_buildCategoryArrayForWebsite('indian-rice-campaign');
        p($aData);
        /*
        $aResources = array();
        $this->db->where('website', 'indian-rice-campaign');
        $this->db->join('resource_category_website_map RCWM', 'RCWM.category = RC.seo_name');
        
        foreach( $this->db->get('resource_categories RC')->result() AS $oItem ) {
            $aResources = array(
                            'id' => $oItem->id,
                            'title' => $oItem->title,
                        );
        }
        */
        
    }
    
	public function index() {
	
    $this->load->model('common_model');
    foreach( $this->db->get('resource_categories')->result() AS $oItem ){
        
        $this->db->set('seo_name', $this->common_model->getSeoName(strtolower($oItem->title)));
        $this->db->where('id', $oItem->id);
        $this->db->update('resource_categories');
        
        
    }
    
    /*
		$this->load->model('resource_model');
        
        $this->load->model('common_model');
        
        foreach($this->db->get('resources')->result() AS $oResource) {
            
            $this->db->where('uid', $oResource->uid);
            $this->db->set( 'seo_name', $this->common_model->getSeoName($oResource->title, $oResource->uid, 150) );
            $this->db->update( 'resources' );
        }
        */
        
	}
    
    function generate_thumbnail(){
        
        $this->load->model('resource_model');
        $this->resource_model->createResourceThumbnails( 71162745 );
    }
    
	public function url() {
		
		p( c('base_url') );
	}
	
	
	function purge_log( $sLogFile = 'common.html' ) {
		
		purge_log($sLogFile);
	}
    
    function phpinfo() {
        phpinfo();
    }
}

/* End of file developer.php */
/* Location: ./application/controllers/developer.php */