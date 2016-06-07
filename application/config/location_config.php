<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Location Settings
|--------------------------------------------------------------------------
|
|
*/

$config['hierarchy'] = array(
                            'country'  => 1,
                            'state'    => 2,
                            'district' => 3,
                            'city'     => 4,
                        );

$config['hierarchy_title'] = array(
                            1 => 'Country',
                            2 => 'State',
                            3 => 'District',
                            4 => 'City',
                        );

$config['hierarchy_tables'] = array(
                            1 => 'countries',
                            2 => 'states',
                            3 => 'districts',
                            4 => 'cities',
                        );

$config['location_per_page'] = 30;
                        
                        

