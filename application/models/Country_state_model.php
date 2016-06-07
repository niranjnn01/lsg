<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Country_state_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	
	
	/**
	 * 
	 * Get details of a country by its id or name
	 * @param mixed $mixed_input
	 * @return array
	 */
	function getCountryDetails( $mixed_input , $bLike=false){
		
		if( is_numeric($mixed_input) ) {
	
			$this->db->where('id',$mixed_input);
		} else {
		
			if($bLike) {
				$this->db->like('name',$mixed_input);
			} else {
				$this->db->where('name',$mixed_input);
			}
			
		}
		
		return $this->db->get('countries')->row();
	
	}
	
	
	function getAllCountries(){
	
	return $this->db->get('countries')->result();
	}

	/**
	 * 
	 * Get details of a state by its id or name
	 * @param mixed $mixed_input
	 * @return array
	 */
	function getStateDetails( $mixed_input , $bLike=false){
		
		if( is_numeric($mixed_input) ) {
	
			$this->db->where('id',$mixed_input);
		} else {
		
			if($bLike) {
				$this->db->like('name',$mixed_input);
			} else {
				$this->db->where('name',$mixed_input);
			}
			
		}
		
		return $this->db->get('states')->row();
	
	}
	
	function getAllStates($iCountryId){
		
		if($iCountryId) {
			
			$this->db->where('country_id', $iCountryId);
			return $this->db->get('states')->result();
		} else {
			
			return array();
		}
	
	}
	
	function add_state($aData) {
	
		if($aData){
		
			$this->db->insert('states', $aData);
			return $this->db->insert_id(); 
		}else{
		
			return 0;
		}
	}
	
}