<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_ahead extends CI_Controller {

	public function __construct() {

		parent::__construct();
		
		
		
		
	}
	
	
	public function index() {}
	
	
	
	
	public function country_get() {
		
		$this->load->model('country_model');
	
		$sKey = safeText('term', false, 'get');
		
		$aWhere 	= array();
		$aLike 		= array('C.countryName' => $sKey);
		$aOrderBy 	= array('C.countryName' => 'ASC');
		$aCountries = $this->country_model->getcountries(0,0,$aWhere, $aOrderBy, $aLike);
		
		$aData = array();
		foreach( $aCountries AS $oItem ) {
			
			$aData[] = array(
						
						//'value' => $oItem->id, 
						'id' 	=> $oItem->id,
						'code' 	=> $oItem->countryCode, 
						'label' => $oItem->countryName,
					);
		}
		
		
		$aData = array(
			'output' => json_encode($aData)
		);
		
		
		$this->output->set_header('Content-type: application/json');
        
		$this->mcontents['is_json_response'] = true;
		
		$this->load->view('output', $aData);	
		
	}
	
	
	public function fruit_get() {
		
		$this->load->model('fruit_model');
	
		$sKey = safeText('term', false, 'get');
		
		$aWhere 	= array();
		$aLike 		= array('F.name' => $sKey);
		$aOrderBy 	= array('F.name' => 'ASC');
		$aFruits = $this->fruit_model->getFruits(0,0,$aWhere, array(), array(), $aOrderBy, $aLike);
		
		//p($this->db->last_query());
		
		$aData = array();
		foreach( $aFruits AS $oItem ) {
			
			$aData[] = array(
						
						//'value' => $oItem->id, 
						'id' 	=> $oItem->id, 
						'label' => $oItem->name, 
					);
		}
		
		
		$aData = array(
			'output' => json_encode($aData)
		);
		
		
		$this->output->set_header('Content-type: application/json');
        
		$this->mcontents['is_json_response'] = true;
		
		$this->load->view('output', $aData);	
		
	}
	
	
	
}

/* End of file campaign.php */
/* Location: ./application/controllers/campaign.php */