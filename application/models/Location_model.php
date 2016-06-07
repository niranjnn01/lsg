<?php
class Location_model extends CI_Model{

	function __construct(){
		parent::__construct();
		

	}
	
	
	function getLocation($aWhere=array(), $iLimit=0, $iOffset=0){
	
		if($iLimit){
			$this->db->limit($iLimit, $iOffset);
		}
	
		if($aWhere){
			$this->db->where($aWhere);
		}
		
		$this->db->select('V.*, 
							T.name thaluk_name, 
							D.name district_name, 
							D.id district_id, 
							S.name state_name, 
							S.id state_id');

		$this->db->join('thaluks T', 'T.id = V.thaluk_id');
		$this->db->join('districts D', 'D.id = T.district_id');
		$this->db->join('states S', 'S.id = D.state_id');
		$aData = $this->db->get('villages V')->result();
		
			//p( $this->db->last_query() );
		return $aData;
	}
	
	
	/**
	 *
	 * get the details of a single district, given the id
	 */
	function getDistrictDetails($iDistrictId) {
		
		$this->db->where('id', $iDistrictId);
		$oData = $this->db->get('districts')->row();
		
		return $oData;
		
	}
	
	/**
	 *
	 * get the details of a single place, given the id
	 */
	function getPlaceDetails($iPlaceId) {
		
		$this->db->where('id', $iPlaceId);
		$oData = $this->db->get('places')->row();
		
		return $oData;
		
	}
	
}