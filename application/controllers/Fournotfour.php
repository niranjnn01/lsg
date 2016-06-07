<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Fournotfour extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
	}
	
	
	/**
	 * display the 404 page
	 *
	 */
	public function index() {
		
		loadTemplate('fournotfour');
		
	}

}

/* End of file account.php */
/* Location: ./application/controllers/fournotfour.php */