<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$config['address_of'] = array(
                            'user'      => 1,
                            'office'    => 2,
                        );

$config['address_status'] = array(
                            'verified'      => 1, // read it as "active" status
                            'unverified'    => 2,
                            'inactive'      => 3,
                        );

$config['phone_type'] = array(
                                'mobile'   => 1,
                                'landline' => 2,
                            );
$config['phone_status'] = array(
                                'active'   => 1,
                                'inactive' => 2,
                            );

$config['address_form_default_settings'] = array(
    
        'address_form_settings__bIsStateEditable'       => FALSE,   // is the state editable or not
        'address_form_settings__bIsCountryEditable'     => FALSE,   // is the country editable or not
        'address_form_settings__bShowState'             => TRUE,    // Whether to show state information or not
        'address_form_settings__bShowCountry'           => TRUE,    // Whether to show country information or not
        'address_form_settings__iDefaultState'          => 1,       // 1 - Kerala
        'address_form_settings__iDefaultCountry'        => 81       // 81 - India
    );
