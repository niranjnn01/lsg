<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
	
	public function __construct(){
		
		 parent::__construct();
		$this->CI = &get_instance();
	}
	
	
    /**
	 * Validate URL format
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 *
	 *
	 * http://stackoverflow.com/questions/161738/what-is-the-best-regular-expression-to-check-if-a-string-is-a-valid-url
	 *
	 *
	 */	
    function valid_url($str) {
		
        $pattern = "/^(https?):\/\/((?:[a-z0-9.-]|%[0-9A-F]{2}){3,})(?::(\d+))?((?:\/(?:[a-z0-9-._~!$&'()*+,;=:@]|%[0-9A-F]{2})*)*)(?:\?((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?(?:#((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?$/i"; // http://www.regexbuddy.com/
		
        if (!preg_match($pattern, $str)){
			
            return FALSE;
        }
		
        return TRUE;
    }
	
}
// End of library class
// Location: system/application/libraries/MY_Form_validation.php