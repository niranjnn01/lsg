<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );
/**
 * Atoload this when there is a user involved
 *
 */

 /**
  * This function will do all necessary things to show admin section.
  * 
  **/
function isAdminSection(){
	
	$CI = &get_instance();
	$CI->load->config('admin_config');
	//$CI->mcontents['load_css'][] 	= 'admin.css';	
	
	
	$CI->mcontents['sAdminMenuName'] = 'admin_menu_tree';
	
	
	//$CI->mcontents['load_js'][] 	= 'jquery/jquery.cookie.min.js';	
	$CI->mcontents['load_js'][] 	= 'json2_min.js';
	$CI->mcontents['load_js'][] 	= 'admin_menu.js';
}

 
/**
 * get the default picture of any section
 * 
 * no need to worry about strict_dimensions, because default pics are anyways of correct dimensions.
 * @param string $sSection
 */
function getDefaultPic($sSection, $sSize, $bImageTag=true, $aSettings=array()) {
	
	$sUrl = c($sSection . '_default_pic_url') . c($sSection . '_default_pic') . '_' . $sSize . '.' . c($sSection . '_default_pic_ext');
	
	if($bImageTag){
	  
	  return getImageTag($sUrl, $aSettings);
	  
	} else {
		return $sUrl;
	}
	
}


/**
 *
 * @param unknown_type $bRedirect
 * @param unknown_type $sRedirectTo
 * @return unknown
 */
function isAdminLoggedIn($bRedirect=false, $sRedirectTo=''){
	
	$CI = &get_instance();
	return $CI->authentication->is_admin_logged_in($bRedirect, $sRedirectTo);
}

/**
 *
 * @param unknown_type $bRedirect
 * @param unknown_type $sRedirectTo
 * @return unknown
 */
function isUserLoggedIn($bRedirect=false, $sRedirectTo='welcome', $bReturnObject=false){
	
	$CI = &get_instance();
	return $CI->authentication->is_user_logged_in($bRedirect, $sRedirectTo, $bReturnObject);
}



/**
 *
 * Get all the roles . from the user_roles table
 */
function getAllRoles() {

   $CI = &get_instance();
   
   $aUserRoles = array();
   
   foreach( $CI->db->get('user_roles')->result() AS $oItem ) {
	  
	  $aUserRoles[$oItem->name] = array(
									'id' 			=> $oItem->id,
									'title' 		=> $oItem->title,
									'description' 	=> $oItem->description,
									'weight' 		=> $oItem->weight,
								 );
   }
   
   return $aUserRoles;
}



/**
 * get the roles of a user in an array
 */
function getUserRoles ( $iAccountNo ) {
   
   $CI = &get_instance();
   $aList = array();
   
   $CI->db->where('account_no', $iAccountNo);
   if( $aData = $CI->db->get('user_role_map')->result() ){
	  foreach( $aData AS $oRow ) {
		 $aList[] = $oRow->role;
	  }
   }
   
   return $aList;
}
