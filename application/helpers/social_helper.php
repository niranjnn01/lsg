<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

function requireSocialButtons( $sType='' ) {
    
    $CI = & get_instance();
    
    switch( $sType ) {
        
        case 'addthis':
            // this will load the js files in the footer
            $CI->mcontents['enable_addthis_social_buttons'] = true;
            
        case 'house':
            // done by me!
            
    }

}

/**
 *
 * This function works along with the requireSocialButtons() function in certain cases
 * 
 */
function  getSocialButtons( $sType='' ) {
    
    $CI = & get_instance();
    
    $sButtons = '';
    
    switch( $sType ) {
        
        case 'addthis':
            
            $sButtons =  '
                <!-- AddThis buttons start -->
                <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a>
                    <a class="addthis_button_google_plusone_share m-r-15"></a>
                    <a class="addthis_button_pinterest_pinit"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                </div>
                <!-- AddThis buttons end -->
            ';
            break;
            
        case 'house':
            // done by me!
            $sButtons = '
            <div class="social_house_cnt">
                <a class="house_fb"> </a>
                <a class="house_tw"> </a>
            </div>
            ';
            
            $CI->mcontents['load_css'][] = 'social.css';
            $CI->mcontents['load_js'][] = 'social/'.$sType.'/buttons.js';
            $CI->mcontents['load_js']['data']['facebook_redirect_url']  = $CI->config->item('facebook_redirect_url');
            $CI->mcontents['load_js']['data']['db_facebook_app_id']     = $CI->config->item('db_facebook_app_id');
            break;
            
    }

    //p($sType);exit;
    //p($sButtons);exit;
    return $sButtons;
}