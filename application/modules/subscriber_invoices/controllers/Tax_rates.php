<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Tax_rates extends MX_Controller {



	function __construct()

	{

		

		parent::__construct();	

		// User::logged_in();



		$this->load->module('layouts');	

		$this->load->library(array('template','form_validation'));

		$this->load->model(array('Subscriber_invoice','App'));



		$this->applib->set_locale();

	}



	function index()

	{		

		$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');

		$this->template->title(lang('tax_rates').' - '.$company_name);

		$data['page'] = lang('invoices');

        $data['sub_page'] = lang('tax_rates');

		$data['datatables'] = TRUE;

		$data['rates'] = Subscriber_invoice::get_tax_rates();



		$this->template

		->set_layout('superadmin')

		->build('rates',isset($data) ? $data : NULL);

	}



	function add(){

		if ($this->input->post()) {



		$this->form_validation->set_rules('tax_rate_name', 'Rate Name', 'required');

		$this->form_validation->set_rules('tax_rate_percent', 'Rate Percent', 'required');



		if ($this->form_validation->run() == FALSE)

		{	

				$_POST = '';

				// Applib::go_to('invoices/tax_rates/','error',lang('error_in_form'));	

				$this->session->set_flashdata('tokbox_error', lang('error_in_form'));

        		redirect('subscriber_invoices/tax_rates/');

		}else{	
				//$_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
				if(Subscriber_invoice::save_tax($this->input->post())){

					// Applib::go_to('invoices/tax_rates/','success',lang('tax_added_successfully'));

					$this->session->set_flashdata('tokbox_success', lang('tax_added_successfully'));

        			redirect('subscriber_invoices/tax_rates/');

				}

			}

		}else{

			$this->load->view('modal/add_rate');

		}

	}



	function edit(){

		if ($this->input->post()) {

		

		$this->form_validation->set_rules('tax_rate_name', 'Rate Name', 'required');

		$this->form_validation->set_rules('tax_rate_percent', 'Rate Percent', 'required');



		if ($this->form_validation->run() == FALSE)

		{	

				$_POST = '';

				// Applib::go_to('invoices/tax_rates','error',lang('error_in_form'));	

				$this->session->set_flashdata('tokbox_error', lang('error_in_form'));

        		redirect('subscriber_invoices/tax_rates');

		}else{	

			$data = array(

				'tax_rate_name' => $this->input->post('tax_rate_name'),

				'tax_rate_percent' => $this->input->post('tax_rate_percent')

				);



			Subscriber_invoice::update_tax($this->input->post('tax_rate_id'),$data);

			// $this->session->set_flashdata('response_status', 'success');

			// $this->session->set_flashdata('message',lang('tax_updated_successfully'));

			$this->session->set_flashdata('tokbox_success', lang('tax_updated_successfully'));

			redirect('subscriber_invoices/tax_rates');

				

			}

		}else{



			$data['id'] = $this->uri->segment(4);

			$this->load->view('modal/edit_rate',$data);

		}

	}



	function delete(){

		if ($this->input->post() ){

		$tax_rate_id = $this->input->post('tax_rate_id', TRUE);



		if(Subscriber_invoice::delete_tax($tax_rate_id)){

				// Applib::go_to('invoices/tax_rates','success',lang('tax_deleted_successfully'));

				$this->session->set_flashdata('tokbox_success', lang('tax_deleted_successfully'));

        		redirect('subscriber_invoices/tax_rates');

		}

		}else{

			$data['tax_rate_id'] = $this->uri->segment(4);

			$this->load->view('modal/delete_tax',$data);

		}

	}





}



/* End of file invoices.php */