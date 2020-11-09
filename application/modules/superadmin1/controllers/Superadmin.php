<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Superadmin extends MX_Controller {

	function __construct()
	{

		parent::__construct();
			
		// $this->load->model(array('App','Superadmin','Client'));
		
		
	}

	function index()
	{

		$this->subscription_list();
		
	// $this->load->module('layouts');
	// $this->load->library('template');
	// $this->template->title(lang('subscription'));
	// $data['page'] = lang('subscription');
	// $this->template
	// ->set_layout('superadmin')
	// ->build('subscription',isset($data) ? $data : NULL);
	}

	function subscription_list()
	{
		
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('subscription'));
	$data['page'] = lang('subscription_list');
	$this->template
	->set_layout('superadmin')
	->build('subscription_list',isset($data) ? $data : NULL);
	}
	function subscribed_companies()
	{
		
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('subscribed_companies'));
	$data['page'] = lang('subscribed_companies');
	$this->template
	->set_layout('superadmin')
	->build('subscribed_companies',isset($data) ? $data : NULL);
	}
}

/* End of file clients.php */