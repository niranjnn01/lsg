<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemaps extends CI_Controller {

	public function __construct(){
	
		parent::__construct();
		
		
		
		$this->load->model('sitemap_model');
		$this->load->config('sitemap_config');
		
		$this->aSectionDropDown = array(
			'table' 		=> 'sitemap_sections',
			'id_field' 		=> 'id',
			'title_field' 	=> 'title',
			'default_text' 	=> 'None',
			'default_value' => 0,
		);
		$this->aSitemapFrequencies = c('sitemap_frequencies');
		
		$this->mcontents['sCurrentMainMenu'] = 'sitemaps';
        
	}
	
	
	/**
	 *
	 * displays the site page for a guest user
	 *
	 */
	public function index() {
		
		
		$this->mcontents['page_title'] 		= 'Sitemap';
		$this->mcontents['page_heading'] 	= 'Sitemap';
		//$this->mcontents['load_css'][] 	= 'sitemap.css';
		
		$this->mcontents['aSiteMapData'] 	= $this->sitemap_model->getSiteMapData();
		
		loadTemplate('sitemap/index');
	}
	
	
	/**
	 * 
	 * handles the listing of the sitemaps
	 * 
	 */
	public function sections($iOffset=0, $iLimit=0) {
		
		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		
		$this->mcontents['page_title'] 		= getTitle('Sitemap Sections');
		$this->mcontents['page_heading'] 	= 'Sitemap Sections';
		
		
		$this->mcontents['aSitemaps'] = $this->sitemap_model->getSitemapSections(c('sitemap_per_page'), $iOffset);
		
		ss('BACKBUTTON_URI', $this->uri->uri_string());
		
		//$this->mcontents['load_css'][] = 'grid.css';
		//$this->mcontents['load_js'][] = 'grid.js';
		loadAdminTemplate('sitemap/sections', $this->mcontents);
	}

	
	/**
	 * 
	 * handles the listing of the links
	 * 
	 */
	public function links($iSection = 0, $iOffset=0, $iLimit=0) {
		
		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		$this->mcontents['page_title'] 		= 'Links';
		$this->mcontents['page_heading'] 	= 'Links';
		
		$aWhere = array();
		if($iSection){
			$aWhere['SL.section_id'] = $iSection;
		}
		
		$iTotal = count( $this->sitemap_model->getLinks(0, 0, $aWhere) );
		$this->mcontents['aLinks'] = $this->sitemap_model->getLinks(c('rent_per_page'), $iOffset, $aWhere);
		
		/* Pagination */
		$this->load->library('pagination');
		$this->aPaginationConfiguration = array();
		$this->aPaginationConfiguration['base_url'] 	= c('base_url').'sitemaps/links/'.$iSection;
		$this->aPaginationConfiguration['total_rows'] 	= $iTotal;
		$this->aPaginationConfiguration['per_page'] 	= c('sitepage_links_per_page');
		$this->aPaginationConfiguration['uri_segment'] 	= 4;
		$this->pagination->customizePagination();
		$this->mcontents['iOffset'] = $iOffset;
		$this->pagination->initialize($this->aPaginationConfiguration);
		$this->mcontents['sPagination'] = $this->pagination->create_links();
		/* Pagination - End*/
		
		
		$this->load->model('common_model');
		$this->mcontents['aSectionDropDown'] = $this->common_model->getDropDownArray($this->aSectionDropDown);
		
		$this->mcontents['iSection'] = $iSection;
		//$this->mcontents['load_css'][] = 'grid.css';
		//$this->mcontents['load_js'][] = 'grid.js';
		loadAdminTemplate('sitemap/links', $this->mcontents);
	}
	
	
	function _get_form_data_sitemap_add(){

		return array(
			'title' 		=> safeText('title'),
			'desc' 			=> safeText('description'),
			'status' 		=> $this->aSitemapStatus['active'],
			'created_on' 	=> date('Y-m-d H:i:s'),
		);
	}
	
	
	/**
	 * 
	 * Edit a new Sitemap
	 * 
	 */
	public function edit_section($iId) { 
		
		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		$this->mcontents['page_title'] 		= 'Edit Section';
		$this->mcontents['page_heading'] 	= 'Edit Section';
		
		
		if( $this->mcontents['oItem'] = $this->sitemap_model->getSingleSection($iId)) {
		
			if( isset($_POST) && !empty($_POST) ) {
				
				$this->form_validation->set_rules('title','Title', 'required');
				
				if( $this->form_validation->run() !== false ) {
					
					$this->db->set('title', safeText('title'));
					$this->db->where('id', $this->mcontents['oItem']->id);
					$this->db->update('sitemap_sections');
					
					sf('success_message', 'Sitemap has been edited.');
					redirect('sitemaps/edit_section/'.$iId);
					
				}
			}
			
		} else {
			
			sf('error_message', 'The requested sitemap does not exist.');
			redirect('sitemaps/sections');
		}
		
		
		loadAdminTemplate('sitemap/edit_section', $this->mcontents);
	}
	
	
	/**
	 * 
	 * Add a new section
	 * 
	 */
	public function add_section() {

		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		$this->mcontents['page_title'] 		= 'Add New Section';
		$this->mcontents['page_heading'] 	= 'Add New Section';
		
		if( isset($_POST) && !empty($_POST) ){
			
			
			$this->form_validation->set_rules('title','Title', 'required');
		
			if( $this->form_validation->run() !== false ) {

				if( !$this->mcontents['oItem'] = $this->sitemap_model->getSingleSection(safeText('title'))){
					
					$this->db->set('title',  safeText('title'));
					$this->db->insert('sitemap_sections');
					
					
					sf('success_message', 'Sitemap Section has been added.');
					redirect('sitemaps/add_section');
					
				} else {
					sf('error_message', 'Section already exists.');
					redirect('sitemaps/add_section');					
				}
				
			}
		}
		
		ss('BACKBUTTON_URI', 'sitemaps/sections');
		
		loadAdminTemplate('sitemap/add_section', $this->mcontents);
	}
	
	
	/**
	 * 
	 * delete a section
	 * 
	 */
	public function delete_section($iId) {

		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		
		if( $this->mcontents['oItem'] = $this->sitemap_model->getSingleSection($iId) ){
			
			$this->db->where('id', $iId);
			$this->db->delete('sitemap_sections');
			
			$this->db->where('section_id', $iId);
			$this->db->delete('sitemap_links');
			
			sf('success_message', 'The sitemap section has been delelted');
			redirect('sitemaps/sections');
			
		} else {
			sf('error_message', 'The requested sitemap section does not exist.');
			redirect('sitemaps/sections');
		}
		
	}
	
	
	/**
	 * 
	 * Edit a new Sitemap
	 * 
	 */
	public function edit_link($iId) {

		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		$this->mcontents['page_title'] 		= 'Edit Link';
		$this->mcontents['page_heading'] 	= 'Edit Link';
		
		
		if( $this->mcontents['oItem'] = $this->sitemap_model->getSingleLink($iId)) {

			if( isset($_POST) && !empty($_POST) ){
				
				
				$this->_set_rules_add_link();
			
				if( $this->form_validation->run() !== false ) {
	
					$aData = array(
						'title' 			=> safeText('title'),
						'section_id' 		=> safeText('section'),
						'url' 				=> safeText('url'),
						'parent' 			=> safeText('parent'),
						'last_modified_on' 	=> date('Y-m-d H:i:s'),
						'change_frequency' 	=> safeText('change_frequency'),
						'priority' 			=> (float)safeText('priority'),
						);

					$this->db->where('id', $this->mcontents['oItem']->id);
					$this->db->update('sitemap_links', $aData);
					
					//regenerate sitemap
					$this->sitemap_model->generateSitemapXML();
					
					sf('success_message', 'Sitemap Link has been updated.');
					redirect('sitemaps/edit_link/'.$iId);
					
				}
			}
			
		} else {
			
			sf('error_message', 'The requested sitemap link does not exist.');
			redirect('sitemaps/links');
		}
		$alinkParentDropDown = array(
			'table' 		=> 'sitemap_links',
			'id_field' 		=> 'id',
			'title_field' 	=> 'title',
			'default_text' 	=> 'None',
			'default_value' => 0,
			'aWhere' => array(
				'section_id' => $this->mcontents['oItem']->section_id,
				'id <> ' => $this->mcontents['oItem']->id,
				'parent' => 0
			)
		);
		
		$this->load->model('common_model');
		$this->mcontents['aLinkParentDropDown'] = $this->common_model->getDropDownArray($alinkParentDropDown);
		$this->mcontents['aSectionDropDown'] = $this->common_model->getDropDownArray($this->aSectionDropDown);
		$this->mcontents['load_js'][] = 'sitemap.js';
		$this->mcontents['aFrequency'] = array_flip($this->aSitemapFrequencies);
		//$this->mcontents['load_css'][] = 'forms/sitemap.css';
		
		ss('BACKBUTTON_URI', 'sitemaps/links');
		
		loadAdminTemplate('sitemap/edit_link', $this->mcontents);
	}
	
	
	function _set_rules_add_link() {
		
				$this->form_validation->set_message('is_natural_no_zero', 'The Section field is required');
				$this->form_validation->set_rules('title','Title', 'required');
				$this->form_validation->set_rules('url','Url', 'required|prep_url');
				$this->form_validation->set_rules('section','Section', 'required|is_natural_no_zero');
				$this->form_validation->set_rules('parent','Parent', 'integer');
				$this->form_validation->set_rules('change_frequency','Change Frequency', 'required');
				$this->form_validation->set_rules('priority','Priority', 'numeric|less_than[1.1]|greater_than[0.0]');
				
	}
	
	
	/**
	 * 
	 * Add a new Sitemap link
	 * 
	 */
	public function add_link() {

		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		isAdminSection();
		
		$this->mcontents['page_title'] 		= 'Add Link';
		$this->mcontents['page_heading'] 	= 'Add Link';
		
		

		if( isset($_POST) && !empty($_POST) ){
			
			$this->_set_rules_add_link();

		
			if( $this->form_validation->run() !== false ) {

				$aData = array(
					'title' 			=> safeText('title'),
					'section_id' 		=> safeText('section'),
					'url' 				=> safeText('url'),
					'parent' 			=> safeText('parent'),
					'last_modified_on' 	=> date('Y-m-d H:i:s'),
					'change_frequency' 	=> safeText('change_frequency'),
					'priority' 			=> (float)safeText('priority'),
					);
				$this->db->insert('sitemap_links', $aData);
				
				//regenerate sitemap
				$this->sitemap_model->generateSitemapXML();
				
				sf('success_message', 'Sitemap Link has been added.');
				redirect('sitemaps/add_link/');
				
			}
		}
			
		$this->load->model('common_model');
		$this->mcontents['load_css'][] = 'forms/sitemap.css';
		
		$this->mcontents['load_js'][] = 'sitemap.js';
		$this->mcontents['aSectionDropDown'] = $this->common_model->getDropDownArray($this->aSectionDropDown);
		$this->mcontents['aFrequency'] = array_flip($this->aSitemapFrequencies);
		
		ss('BACKBUTTON_URI', 'sitemaps/links');
		loadAdminTemplate('sitemap/add_link', $this->mcontents);
	}
	
	
	/**
	 *
	 * to get parent drop down when a different section is selected
	 * 
	 * Used via Ajax
	 *
	 * @param unknown_type $iSectionId
	 * 
	 */
	function get_link_parents($iSectionId=0) {

		$this->load->model('common_model');
		
		$aLinkParentDropDown = $this->common_model->getDropDownArray(array(
			'table' 		=> 'sitemap_links',
			'id_field' 		=> 'id',
			'title_field' 	=> 'title',
			'default_text' 	=> 'None',
			'default_value' => 0,
			'aWhere' => array(
				'section_id' => $iSectionId,
				'parent' => 0
			)
		));
		$sLinkParentDropDown = form_dropdown('parent', $aLinkParentDropDown, 0, 'id=parent');
		
		$this->load->view('output', array('output' => json_encode(array('page' => $sLinkParentDropDown))));
	}
	
	
	/**
	 * 
	 * delete a link
	 * 
	 */
	public function delete_link($iId) {

		/* Check if admin logged in  */
		$this->authentication->is_admin_logged_in (true);
		
		if( $this->mcontents['oItem'] = $this->sitemap_model->getSingleLink($iId) ) {
			
			$this->db->where('parent', $iId);
			
			if(!$this->db->get('sitemap_links')->row()) {
				
				$this->db->where('id', $iId);
				$this->db->delete('sitemap_links');
				
				//regenerate sitemap
				$this->sitemap_model->generateSitemapXML();
				
				sf('success_message', 'The link has been deleted');
				redirect('sitemaps/links');
				
			} else {
				
				sf('error_message', 'This link cannot be deleted, since it has got child links under it. Please delete the child links first');
				redirect('sitemaps/links');				
			}
			
		} else {
			
			sf('error_message', 'The requested sitemap section does not exist.');
			redirect('sitemaps/links');
		}
		
	}
	
}

/* End of file sitemaps.php */
/* Location: ./application/controllers/sitemaps.php */