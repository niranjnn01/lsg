<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	
	public function __construct(){
	
		parent::__construct();
		/*
		$this->mcontents = array();
		$this->merror['error'] = '';
		$this->mcontents['load_css'] = array();
		$this->mcontents['load_js'] = array();
		*/
	}
	
	public function index() {
		
		$this->authentication->logout();
		
		$aOnlineVia = c('online_via');
		
		if(s('ONLINE_VIA') == $aOnlineVia['facebook']){
			
			redirect($this->facebook->getLogoutUrl(array(
										'next' => c('base_url')
									)));
			
		} else {
			
			redirect(c('default_controller'));	
		}
	}
	
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */