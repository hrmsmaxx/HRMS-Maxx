<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Notebook extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		User::logged_in();
		$this->load->module('layouts');	

		$this->load->library(array('template','form_validation'));
		$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');

		$this->template->title(lang('notes').' - '.$this->company_name);
		$this->load->model(array('Note','App'));
		//App::module_access('menu_notes');
		$this->applib->set_locale();
		
	}

	function index()
	{		 
		
		$data['page'] = lang('notes');
		$data['notes_app'] = TRUE;
		// $data['notes'] = json_encode(Note::get_notes(User::get_id()));		 
		$this->template
			->set_layout('users')
			->build('notes',isset($data) ? $data : NULL);
	
	}
}

/* End of file project_home.php */