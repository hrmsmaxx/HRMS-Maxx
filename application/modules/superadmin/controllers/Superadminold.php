<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Superadmin extends MX_Controller {

	function __construct()
	{

		parent::__construct();
	}

	function index()
	{
		$this->subscription_list();
	}

	function subscription_list()
	{
		if($_POST){
			$result = array(
				'plan_name' => $_POST['plan_name'],
				'plan_amount' => $_POST['plan_amount'],
				'plan_type' => $_POST['plan_type'],
				'users_count' => $_POST['no_of_users'],
				'projects_count' => $_POST['no_of_projects'],
				'storage_count' => $_POST['no_of_storage'],
				'support' => $_POST['support']?'1':'0',
				'description' => $_POST['description'],
				'video_voice' => $_POST['voice_video_call']?'1':'0',
				'messages' => $_POST['unlimited_messages']?'1':'0',
			);
			$this->db->insert('subscription_plans',$result);
			$this->session->set_flashdata('tokbox_success', "Plan Added Successfully!");
            redirect('superadmin');

		}else{
			$this->load->module('layouts');
			$this->load->library('template');
			$this->template->title(lang('subscription'));
			$data['page'] = lang('subscription_list');
			$data['monthly_subscription_list'] = $this->db->get_where('subscription_plans',array('plan_type'=>'month'))->result_array();
			$data['yearly_subscription_list'] = $this->db->get_where('subscription_plans',array('plan_type'=>'year'))->result_array();
			$data['subscription_list'] = $this->db->get('subscription_plans')->result_array();
			$this->template
			->set_layout('superadmin')
			->build('subscription_list',isset($data) ? $data : NULL);
		}	
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


	public function edit_plan($plan_id)
	{
		$result = array(
			'plan_name' => $_POST['plan_name'],
			'plan_amount' => $_POST['plan_amount'],
			'plan_type' => $_POST['plan_type'],
			'users_count' => $_POST['no_of_users'],
			'projects_count' => $_POST['no_of_projects'],
			'storage_count' => $_POST['no_of_storage'],
			'support' => $_POST['support']?'1':'0',
			'description' => $_POST['description'],
			'video_voice' => $_POST['voice_video_call']?'1':'0',
			'messages' => $_POST['unlimited_messages']?'1':'0',
		);
		$this->db->where('plan_id',$plan_id);
		$this->db->update('subscription_plans',$result);
		$this->session->set_flashdata('tokbox_success', "Plan Updated Successfully!");
        redirect('superadmin');
	}
}

/* End of file clients.php */