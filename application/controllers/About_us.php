<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class About_us extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->model('sitepage_model');
		$this->mcontents['sCurrentMainMenu']    = 'about_us';
		
	}
	
	
	/**
	 * display the about us page
	 *
	 */
	public function index() {
		
		
		$this->mcontents['page_title'] 	= 'About Us';
		//$this->mcontents['oAssociationsAffiliations'] 	= $this->sitepage_model->getSingleSitepage('associations_affiliations');
		$this->mcontents['oAboutUs'] 					= $this->sitepage_model->getSingleSitepage('about_us');
		$this->mcontents['oHistory'] 					= $this->sitepage_model->getSingleSitepage('history');
		
		//$this->mcontents['load_css'][] 					= 'about_us.css';
		
		loadTemplate('about_us/about_us');
	}
	
    
	
	/**
	 * display the about us page
	 *
	 */
	public function v($sPage='') {
		
		$sPage = safeText($sPage, false, '', true);
		
		
		if( !$this->mcontents['oItem'] 		= $this->sitepage_model->getSingleSitepage($sPage) ) {
			redirect('about_us');
		}
		
		
		$this->mcontents['page_title'] 		= $this->mcontents['oItem']->title;
		$this->mcontents['oHistory'] 	= $this->sitepage_model->getSingleSitepage('history');
		loadTemplate('about_us/v');
	}
	
	

	function _eliminate_duplicate_entry( $aData ) {
		
		// eliminate duplicate entry
		$aTempArray = array();
		foreach( $aData AS $iKey => & $oItem ) {
			
			if( ! in_array($oItem->account_no, $aTempArray) ) {
				
				$aTempArray[] = $oItem->account_no;
				
			} else {
				
				unset( $aData[$iKey] );
			}
		}
		
		return $aData;
	}

}

/* End of file account.php */
/* Location: ./application/controllers/account.php */