<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends CI_Controller {

public function __construct(){

	parent::__construct();
	
		$this->mcontents = array();
		$this->merror['error'] = '';
		$this->mcontents['load_css'] = array();
		$this->mcontents['load_js'] = array();
		
		isAdminLoggedIn(true);
		
		$this->load->config('location_config');
		
		$this->mcontents['hierarchy'] 			= $this->config->item('hierarchy');
		$this->mcontents['hierarchy_flipped'] 	= array_flip($this->mcontents['hierarchy']);
		$this->mcontents['hierarchy_title'] 	= $this->config->item('hierarchy_title');
		$this->mcontents['hierarchy_tables'] 	= $this->config->item('hierarchy_tables');
		
		$this->load->model('location_model');
		$this->load->helper('location');
		$this->aParentData = array();
		
	}
	
	public function index()
	{
		
		
	}


		
	function add($sType='', $iParentId=0){
		

		$this->authentication->is_admin_logged_in (true);
	
		isAdminSection();
			
		$aParentDetails = _getParentDetails($sType);
		
		if(!$iParentId){
			
			$iParentId = s('previous_parent_id') ? s('previous_parent_id') : 0;
		}
		$this->mcontents['aParentHistory'] = _findParentHistory($aParentDetails['name'], $iParentId);
		
		
		if( !array_key_exists($sType, $this->mcontents['hierarchy']) ) {
			
			
			sf('error_message', 'Invalid Type');
			redirect('location/listing');
		}
		
		$this->mcontents['iTypeNo'] = $this->mcontents['hierarchy'][$sType];
		$this->mcontents['sType'] 	= $sType;
		$this->mcontents['iParentId'] 	= $this->mcontents['aParentHistory'][$aParentDetails['name']];

		
		$sTypeTable = $this->mcontents['hierarchy_tables'][$this->mcontents['iTypeNo']];
		
		if(isset($_POST) && !empty($_POST)) {
			
			$this->_validate_add($sType);
			
			if( $this->form_validation->run() !== false ) {
				
				$aData = $this->_get_form_data($sType);
				
				ss('aPreviousData', $aData);
				
				
				// we have allowed multiple comma separated values
				
				$aData1 = explode(',', $aData['new_item']);
				
				
				ss('previous_parent_id', $aData[$aParentDetails['name']]);
				
				foreach($aData1 AS $sName ){
					if($sName = safeText($sName, false, '', true)){
						
						$this->db->set('name', $sName);
						$this->db->set($aParentDetails['name'].'_id', $aData[ $aParentDetails['name'] ]);
						$this->db->insert($sTypeTable);
						
						//p($this->db->last_query());
					}
				}
				
				sf('success_message', ucfirst($sType) . ' has been added.');
				redirect('location/add/' . $sType. '/'.$iParentId);
				
			}
		}
		
		$iParentDepth = $this->mcontents['iTypeNo'];
		$this->load->model('common_model');
		
		
		
		/**
		 *
		 * Populate the dropdown menu's with data on country, state, district etc
		 * 
		 */
		$this->mcontents['aParents'] = getParentDropDowns($aParentDetails['name'], $iParentId);
		//p($this->mcontents['aParents']);
		$this->mcontents['sLocationsDropDowns']  = $this->load->view('location_dropdowns_view', $this->mcontents, true);
		
		/* - to delete later on if there are no errors
		 *
		 * 
		$this->mcontents['aParents'] = array();
		$i= 1;
		foreach( array_reverse($this->mcontents['aParentHistory']) AS $sKey => $iValue ){
			
			$aWhere = array();

			if($this->mcontents['hierarchy'][$sKey] >= 2) {
				
				$aParentDetails = _getParentDetails($sKey);
				if($sKey != $sType){
					$aWhere[ $aParentDetails['name'] . '_id' ] = $this->mcontents['aParentHistory'][$aParentDetails['name']];
				}
			}
			
			$sParentTable = $this->mcontents['hierarchy_tables'][ $this->mcontents['hierarchy'][$sKey] ];
			$this->mcontents['aParents']['aParent' . $i] = $this->common_model->getDropDownArray(array(
																	'table' => $sParentTable,
																	'id_field' => 'id',
																	'aWhere' => $aWhere,
															));
			++$i;
		}
		
		*/
		
		$this->mcontents['aPreviousData'] = s('aPreviousData');
		$this->mcontents['load_js'][] = 'location.js';
		$this->mcontents['load_css'][] = 'forms/create_location.css';
		
		loadAdminTemplate('location/add', $this->mcontents);
	}
	
	/**
	 * Validation rules for all
	 */
	
	function _validate_add($sType) {
	
		switch($sType) {
			case 'state':
				$this->form_validation->set_rules('country','Country', 'required');
				$this->form_validation->set_rules('new_item','Country Name', 'required');
				break;
			case 'district':
				$this->form_validation->set_rules('country','Country', 'required');
				$this->form_validation->set_rules('state','State', 'required');
				$this->form_validation->set_rules('new_item','District Name', 'required');
				break;
			case 'city':
				$this->form_validation->set_rules('country','Country', 'required');
				$this->form_validation->set_rules('state','State', 'required');
				$this->form_validation->set_rules('district','District', 'required');
				$this->form_validation->set_rules('new_item','City Name', 'required');
				break;
			case 'village':
				$this->form_validation->set_rules('country','Country', 'required');
				$this->form_validation->set_rules('state','State', 'required');
				$this->form_validation->set_rules('district','District', 'required');
				$this->form_validation->set_rules('city','City', 'required');
				$this->form_validation->set_rules('new_item','Village Name', 'required');
				break;
		}
	}
	
	
	function _get_form_data($sType){
		
		//$aParentDetails = _getParentDetails( $sType );
	
		$aData = array();
		
		//p($this->mcontents['hierarchy_flipped']);
		
		for($i=1; $i < $this->mcontents['hierarchy'][$sType]; ++$i) {
			$aData[$this->mcontents['hierarchy_flipped'][$i]] = safeText($this->mcontents['hierarchy_flipped'][$i]);	
		}
		
		$aData['new_item'] = safeText('new_item');
		
		/*
		if($aParentDetails['id']) {
			$aData[$aParentDetails['name'] . '_id'] = $aParentDetails['id'];
		}
		*/
		
		return $aData;
	}




	/**
	 * 
	 * handles the listing of the taluks
	 */
	public function listing($iCountryId=0, $iStateId=0, $iDistrictId=0, $iOffset=0){
		
		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		
		isAdminSection();
		
		
		/**
		 * Look at the URI and determine
		 * the type of data we are going to display, and reset the different 'inputs' if required
		 */
		$this->mcontents['sType'] = $this->mcontents['hierarchy_flipped'][1];
		$this->mcontents['iType'] = 1;
		
		if( !$iCountryId || !is_numeric($iCountryId) ){
			$iCountryId = 0;
		} else {
			$this->mcontents['sType'] = $this->mcontents['hierarchy_flipped'][2];
			$this->mcontents['iType'] = 2;
		}
		if( !$iStateId || !is_numeric($iStateId) ){
			$iStateId = 0;
		} else {
			$this->mcontents['sType'] = $this->mcontents['hierarchy_flipped'][3];
			$this->mcontents['iType'] = 3;
		}
		if( !$iDistrictId || !is_numeric($iDistrictId) ){
			$iDistrictId = 0;
		} else {
			$this->mcontents['sType'] = $this->mcontents['hierarchy_flipped'][4];
			$this->mcontents['iType'] = 4;
		}
		
		

		
		$iLimit = c('location_per_page');
		/*
		echo $iCountryId .'<br/>';
		echo $iStateId.'<br/>';
		echo $iDistrictId.'<br/>';
		echo $iLimit.'<br/>';
		echo $iOffset.'<br/>';
		*/
		$this->mcontents['iTotal'] = $this->_getListingResult($iCountryId, $iStateId, $iDistrictId, 0, $iOffset, true);
		$this->mcontents['aData'] = $this->_getListingResult($iCountryId, $iStateId, $iDistrictId, $iLimit, $iOffset);
		
		
		/* Pagination - Start*/
		$this->load->library('pagination');
		
		$this->aPaginationConfiguration 				= array();
		$this->aPaginationConfiguration['uri_segment'] 	= 6;
		$this->aPaginationConfiguration['base_url'] 	= c('base_url').'location/listing/'.$iCountryId.'/'.$iStateId.'/'.$iDistrictId.'/';
		$this->aPaginationConfiguration['total_rows'] 	= $this->mcontents['iTotal'];
		$this->aPaginationConfiguration['per_page'] 	= $iLimit;
		$this->aPaginationConfiguration['offset'] 		= $iOffset;
		$this->pagination->customizePagination();
		$this->mcontents['iOffset'] = $iOffset;
		$this->mcontents['load_css'][] = 'pagination.css';
		$this->pagination->initialize($this->aPaginationConfiguration);
		$this->mcontents['sPagination'] = $this->pagination->create_links();
		/* Pagination - End*/
		

		$this->mcontents['iCountryId'] 	= $iCountryId;
		$this->mcontents['iStateId'] 	= $iStateId;
		$this->mcontents['iDistrictId'] = $iDistrictId;
		
		
		$this->mcontents['aStates'] = $this->mcontents['aDistricts'] = $this->mcontents['aCities'] = array();
		$this->mcontents['aStates'] = array();
		
		$this->load->model('common_model');
		for( $i=1; $i < count($this->mcontents['hierarchy_flipped']); ++$i ) {
			
			//p($this->mcontents['hierarchy']);exit;
			
			$sUpperCase = ucfirst($this->mcontents['hierarchy_flipped'][$i]);
			
			$iId = 'i' . $sUpperCase . 'Id';
			//p($$iId);
			//if($$iId) {
				
				$aConfig = array(
							'table' 	=> $this->mcontents['hierarchy_tables'][$i],
							'id_field' 	=> 'id'
						);
				if($i>=2) {
					
					$aParentDetails = _getParentDetails( $this->mcontents['hierarchy_flipped'][$i] );
					$Parent_id_variable = 'i'. ucfirst($aParentDetails['name']) . 'Id';
					
					$aConfig['aWhere'][$this->mcontents['hierarchy_flipped'][$i-1] . '_id'] = $$Parent_id_variable;
				}
				
				$this->mcontents['a'.$sUpperCase.'s'] 	= $this->common_model->getDropDownArray($aConfig);
				
				//p($i);
				//p($aConfig);exit;
			//}
		}

		
		//p( $this->mcontents['aData'] );
		$this->mcontents['page_heading'] 	= ucfirst('Location Listing');
		$this->mcontents['page_title'] 		= getTitle( $this->mcontents['page_heading'] );
		
		$this->mcontents['load_css'][] = 'grid.css';
		$this->mcontents['load_js'][] = 'admin/location_listing.js';
		loadAdminTemplate('location/listing', $this->mcontents);
	}
	
	
	
	function _getListingResult($iCountryId, $iStateId, $iDistrictId, $iLimit, $iOffset, $bCount=false){
		
		$sTable = 'countries C';
		$sSelect = 'C.name country_name, C.id country_id ';
		$aWhere = array();
		$aJoin 	= array();
		
		if($iCountryId){
			
			$sTable = 'states S';
			$sSelect .= ', S.name state_name, S.id state_id';
			$aWhere['country_id'] = $iCountryId;
			$aJoin['countries C'] = 'S.country_id = C.id';
			
		}
		if($iStateId){
			
			$sTable = 'districts D';
			$sSelect .= ', D.name district_name, D.id district_id';
			$aWhere['state_id'] = $iStateId;
			
			$aJoin['states S'] = 'S.id = D.state_id';
		}
		if($iDistrictId){
			$sSelect .= ', CT.name city_name, CT.id city_id';
			$sTable = 'cities CT';
			$aWhere['district_id'] = $iDistrictId;
			
			$aJoin['districts D'] = 'D.id = CT.district_id';
		}

		$aJoin = array_reverse($aJoin);
		
		$this->db->select($sSelect);
		$this->db->where($aWhere);
		if($aJoin){
			foreach($aJoin AS $sKey=>$sValue){
				$this->db->join($sKey, $sValue);
			}
		}
		
		$this->db->from($sTable);
		
		if( $iLimit ){
			
			$this->db->limit( $iLimit, $iOffset);
		}
		
		if($bCount){
			
			$oQuery = $this->db->get();
			//p($this->db->last_query());
			
			$iCount = count( $oQuery->result() );
			
			return $iCount;
		
		} else {
			return $this->db->get()->result();
		}
		
	}
	
	
	
	/**
	 * 
	 * delete a Location
	 */
	public function delete($sType='', $iId=0)
	{

		$sFuntionName = '';
		if($sType == 'thaluk'){
			
			$sFuntionName = 'getSingleThaluk';
		}
		
		
		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		
		if(  $this->location_model->$sFuntionName($iId) ){
			
			$this->db->where('id', $iLocationId);
			$this->db->set('status', $this->aLocationStatus['deleted']);
			$this->db->update('locations');
			
			
			sf('success_message', 'The Location has been delelted');
			redirect('location');
			
		} else {
			sf('error_message', 'The requested Location does not exist.');
			redirect('location');
		}
		
	}
	
	/**
	 * Used via AJAX
	 * 
	 */
	function get_sub_locations($sType='', $iId=0){
		
		initializeJsonArray();
		
		//$this->aJsonOutput['output']['page'] .= '<option value="0">Select</option>';
		$iType = $this->mcontents['hierarchy'][$sType];
		
		$aParentDetails = _getParentDetails( $sType );
		
		if($sType) {
			
			$this->db->select( 'id, name' );
			$this->db->where( $aParentDetails['name'] . '_id', $iId );
			$aData = $this->db->get( $this->mcontents['hierarchy_tables'][$iType] )->result();
			
			$this->aJsonOutput['output']['page'] .= '<option value="0">Select</option>';
			
			if($aData){
				
				
				foreach($aData AS $oRow) {
					
					$this->aJsonOutput['output']['page'] .= '<option value="'.$oRow->id.'">'.$oRow->name.'</option>';
				}
			}
		}
		outputJson();
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */