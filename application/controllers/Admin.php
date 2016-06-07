<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


	public function __construct(){
	
	parent::__construct();
	
		/*
		$this->mcontents = array();
		$this->merror['error'] = '';
		$this->mcontents['load_css'] = array();
		$this->mcontents['load_js'] = array();
		*/
        $this->load->config('admin_config');
		
	}
	
	
	public function index()
	{
		
		if( hasAccess(array('admin', 'staff') ) ) {
		
			$aAssignedUserRoles = s('USER_ROLES');
		
		
			if( $this->session->userdata('USER_TYPE') == 1 ) :
				
				//$this->mcontents['sAdminMenuName'] = 'admin_menu_tree';
				$this->home();
				
			elseif( array_key_exists( $aAllRoles['accounts-officer'] , $aAssignedUserRoles ) ) :
				
				//$this->mcontents['sAdminMenuName'] = 'staff_accountant_menu_tree';
				$this->home_staff_accountant();
				
				
			endif;
			
			
		}
	}
	
	
	/**
	 *
	 * Home page of admin
	 *
	 */
	function home(){
	
		$this->mcontents['page_title'] 		= 'Control Panel';
		$this->mcontents['page_heading'] 	= 'Home';
		
		isAdminSection();
		
		loadAdminTemplate('home', $this->mcontents);
		
	}
	
	/**
	 *
	 * Home page of accountant staff
	 *
	 */
	function home_staff_accountant() {
	
		isAdminSection();
		
		$this->mcontents['page_title'] 		= 'Control Panel';
		$this->mcontents['page_heading'] 	= 'Home';
		
		loadAdminTemplate('home_staff_accountant', $this->mcontents);
		
		
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin/admin.php */