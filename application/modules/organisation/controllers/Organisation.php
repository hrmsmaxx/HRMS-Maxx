<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organisation extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		User::logged_in();

		$this->load->module('layouts');	
		$this->load->library(array('template','form_validation'));
		$this->template->title('time_sheets');
		$this->load->model(array('App'));

		$this->applib->set_locale();
		$this->load->helper('date');
	}

	function index()
	{
	    
	   // echo "hi";  exit;
		$this->load->module('layouts');

		$this->load->library('template');

		$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');

		$this->template->title(lang('organisation').' - '.$company_name);
		 

		// $this->template->title(lang('users').' - '.config_item('company_name'));
		$data['page'] = lang('all_policies');
		$data['sub_page'] = lang('organisation');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['chart_details'] = $this->db->get_where('dgt_org_chart',array('chart_id'=>1))->row_array();
		$this->template

			 ->set_layout('users')

			 ->build('organisation',isset($data) ? $data : NULL);
	}


	public function chart_update()
	{
		$updated_chart = $this->input->post('updated_chart');
		$res = array(
			'chart_position' => $updated_chart
		);
		$this->db->where('chart_id',1);
		$this->db->update('dgt_org_chart',$res);
		echo "success"; exit;
	}

	
}

/* End of file projects.php */