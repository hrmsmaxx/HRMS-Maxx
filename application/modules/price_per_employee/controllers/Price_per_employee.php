<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Price_per_employee extends MX_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->module('layouts');
			// User::logged_in();
		$this->load->library(array('template','form_validation'));

		$this->load->model(array('Price_per_employees','App'));
// 		App::module_access('menu_items');
		$this->applib->set_locale();

	}



	function index()

	{

		$this->list_items();

	}



	function list_items()

	{

	$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

    $theme_settings = unserialize($theme_settings['theme_settings']);

    $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');

	$this->template->title(lang('item_lookups').' - '.$this->company_name);

	$data['page'] = lang('price_per_employee');

    $data['sub_page'] = lang('items');

	$data['datatables'] = TRUE;

	$data['price_per_employee'] = Price_per_employees::list_items();

	$this->template

	->set_layout('superadmin')

	->build('templates',isset($data) ? $data : NULL);

	}



	function add_item()

	{

		if ($this->input->post()) {

			$this->form_validation->set_rules('plan1', 'Plan 1', 'required');

			$this->form_validation->set_rules('plan2', 'Plan 2', 'required');

			$this->form_validation->set_rules('plan3', 'Plan 3', 'required');

			$this->form_validation->set_rules('employee_count', 'Employee Count', 'required');

			if ($this->form_validation->run() == FALSE)

			{
				$this->session->set_flashdata('tokbox_error', lang('operation_failed'));

				redirect($this->input->post('r_url'));

			}else{		

				App::save_data('price_per_employee',$this->input->post());
				$this->session->set_flashdata('tokbox_success', lang('price_per_employee_added_successfully'));
				redirect('price_per_employee');
			}

		}

	}

	
	function edit_item()

	{

		if ($this->input->post()) {

			$this->form_validation->set_rules('plan1', 'Plan 1', 'required');

			$this->form_validation->set_rules('plan2', 'Plan 2', 'required');

			$this->form_validation->set_rules('plan3', 'Plan 3', 'required');

			$this->form_validation->set_rules('employee_count', 'Employee Count', 'required');

			if ($this->form_validation->run() == FALSE)

			{
				$this->session->set_flashdata('tokbox_error', lang('operation_failed'));

				redirect($this->input->post('r_url'));

			}else{	

				$url = $this->input->post('r_url');

				unset($_POST['r_url']);

				App::update('price_per_employee',array('id' => $this->input->post('id')),$this->input->post()); 

				$this->session->set_flashdata('tokbox_success', lang('price_per_employee_edited_successfully'));

				redirect($url);

			}

		}

	}

	
	function delete_item(){

		if ($this->input->post() ){

			$id = $this->input->post('id', TRUE);

			App::delete('price_per_employee',array('id' => $id));

			$this->session->set_flashdata('tokbox_error', lang('item_deleted_successfully'));

			redirect($this->input->post('r_url'));

		}		

	}

}



/* End of file items.php */