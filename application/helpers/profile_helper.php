<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );


	/**
	 *
	 * This is just an alias-kind-of function for getCurrentProfilePic
	 * 
	 */
	function getCurrentProfilePic_byAccNo($iAccountNo, $sSize='small', $bImageTag=true, $aSettings=array()){
		
		$CI = &get_instance ();
		
		$CI->load->model('user_model');
		
		$oUser = $CI->user_model->getUserBy('account_no', $iAccountNo, 'full');
		
		return getCurrentProfilePic($oUser, $sSize, $bImageTag, $aSettings);
	}
	
	/**
	 * Will return the URL to the current profile picture of the user
	 *
	 * @param unknown_type $iUserId
	 * @return unknown
	 */
	function getCurrentProfilePic($oUser, $sSize='small', $bImageTag=true, $aSettings=array()) {
		
		$CI = &get_instance ();
		
		$aProfilePicType = array_flip(c('profile_pic_upload_type'));
		$sPictureName = '';
		$sUrl = '';
		//$iUserId = $oUser->id;
		$sReturn = '';
	
		$sProifilePicType = $aProfilePicType[$oUser->current_pic];
		
		
		$aDefaultSettings = array(
			'only_url' => !$bImageTag,
			'strict_dimensions' => false, // if true, the image will be placed inside a
										  // container with exact dimensions as specified by $sSize
		);
		$aSettings = array_merge($aDefaultSettings, $aSettings);
	
		// see if the image has to be of strict dimensions.
		// set the settings accordingly.
		if( isset($aSettings['strict_dimensions']) && $aSettings['strict_dimensions'] == true ) {
		  
		  $aDimensions = c('profile_pic_thumbnail_dimensions');
		  $aSettings['width'] 	= $aDimensions[$sSize]['width'];
		  $aSettings['height'] 	= $aDimensions[$sSize]['height'];
		}
		
		
		
		if($sProifilePicType == 'none') {
		
			return getDefaultPic('profile_pic', $sSize, $bImageTag, $aSettings);
			
		} elseif($sProifilePicType == 'facebook') {
			
			return getFbImage($oUser, array('size'=>$sSize), $bImageTag, $aSettings);
		} else {
			
			return getImage('profile_pic', $oUser->profile_image, $sSize, $aSettings);
		}
		
	}

/**
 * get spedific profile image of a user . if it exists
 *
 * @param unknown_type $sType
 * @param unknown_type $oUser
 * @param unknown_type $sSize
 * @param unknown_type $bImageTag
 * @return unknown
 */
function getSpecificProfilePic($sType, $oUser, $sSize='small', $bImageTag=true, $aAttributes=array()){
	
	$CI = &get_instance ();
	$aProfilePicType = array_flip(c('profile_pic_upload_type'));
	
	
	$CI->db->select($sType);
	$CI->db->where('user_id', $oUser->id);
	$oPic = $CI->db->get('profile_pictures')->row();
	
	$aAttributes['only_url'] = !$bImageTag;
	
	return getImage('profile_pic', $oPic->$sType, $sSize, $aAttributes);
	
}

/**
 * Get the profile picture of a user
 *
 * @param object $oUser
 * @param array  {type= small, normal, large, square}
 * @param boolean $bImageTab
 * @return string
 */
function getFbImage($oUser, $aParams=array(), $bImageTab=true, $aSettings = array()) {

	$aDefaultParams = array('size'=> 'small');
	$aParams = array_merge($aDefaultParams, $aParams);
	
	$aParams['type'] = mapImageSizes('facebook', $aParams['size']);
	$sSize = $aParams['size'];
	unset($aParams['size']);// why this step?.. need to write more documentation rakesh!
	
	$sUrl = 'http://graph.facebook.com/'.$oUser->facebook_id.'/picture';
	if($aParams){
		$sUrl .= '?'.http_build_query($aParams);
	}

	// see if the image has to be of strict dimensions.
	// set the settings accordingly.
	if( isset($aSettings['strict_dimensions']) && $aSettings['strict_dimensions'] == true ) {
	
		$aDimensions = c('profile_pic_thumbnail_dimensions');
		$aSettings['width'] 	= $aDimensions[$sSize]['width'];
		$aSettings['height'] 	= $aDimensions[$sSize]['height'];
	}
	
	if($bImageTab){
		
		$aSettings['oncontextmenu'] = 'return false';
		$aSettings['title'] = $oUser->full_name;
		
		return getImageTag($sUrl, $aSettings);
	} else {
		return $sUrl;
	}
}

function hasSetProfilePic($iUserId, $sType){
	
	$CI = &get_instance ();
	
	$CI->db->where('user_id', $iUserId);
	if($oData = $CI->db->get('profile_pictures')->row()){
		if($oData->$sType){
			return $oData->$sType;
		} else {
			return '';
		}
	}
}
/**
 * set the given image as the profile pic.
 * update changes to whereever necessary
 *
 * @param integer $iUserId
 * @param string $sType
 * @param string $sImageName
 */
function setProfilePic($iUserId, $sImageName, $sUploadType){
	
	$CI = &get_instance ();
	$aTypes = c('profile_pic_upload_type');
	$aTypesFlipped = array_flip($aTypes);

	//delete the present picture if its not the default picture
	$CI->db->select('current_pic, url, upload');
	$CI->db->where('user_id', $iUserId);
	$oData = $CI->db->get('profile_pictures')->row();
	if( ($oData->current_pic != $aTypes['none']) ){
		
		if($oData->$aTypesFlipped[$oData->current_pic]) {
			deleteImage('profile_pic', $oData->$aTypesFlipped[$oData->current_pic]);
		}
		
	}
	
	// Delete the profile images which are uploaded by other sources.
	if( $sUploadType == 'url' && $oData->upload){

		//write_log('SET PROF 1 ');
		deleteImage('profile_pic', $oData->upload);
		
	} elseif( $sUploadType == 'upload' && $oData->url){
		
		//write_log('SET PROF 2 ');
		deleteImage('profile_pic', $oData->url);
		
	}
	
	//delete image stored in pending status
		// get account_no | this step can be avoided but much work required
		$oUser = $CI->user_model->getUserBy('id', $iUserId);
		
		$CI->load->helper('custom_upload');
		//remove the picture selected from tables
		deletePendingImage('profile_pic', $sImageName, $oUser->account_no);
		
		//physicall remove the rest of the pictures.
		deletePendingImage('profile_pic', '', $oUser->account_no, true);
	

	
	
	
	//update profile_pictures table
	$CI->db->where('user_id', $iUserId);
	$CI->db->set('current_pic', $aTypes[$sUploadType]);
	
	if( $sUploadType == 'url' || $sUploadType == 'upload'){
		$CI->db->set($sUploadType, $sImageName);
		
	}
	
	if( $sUploadType == 'url' ){
		$CI->db->set('upload', '');
	} elseif( $sUploadType == 'upload' ){
		$CI->db->set('url', '');
	}
	
	$CI->db->update('profile_pictures');
	
	//update users table
	$CI->db->where('id', $iUserId);
	$CI->db->set('profile_image', $sImageName);
	$CI->db->update('users');
}