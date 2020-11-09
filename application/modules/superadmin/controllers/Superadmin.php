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
				'addtional_employee_rate' => $_POST['addtional_employee_rate'],
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

	public function status_change(){
		if($this->input->post()){
			$subscribers_id = $this->input->post('subscribers_id');
			$status = $this->input->post('status');
			$result = array(
					'status' => $status,
				);
			$this->db->where('subscribers_id',$subscribers_id);
			$this->db->update('subscribers',$result);
			echo 'success';die;
		}else{
			echo 'fail';die;
		}
	}

	public function delete_subscription(){
		 ini_set('display_errors', 1); error_reporting(E_ALL);
		if($this->input->post()){
			$subscription_id = $this->input->post('subscription');
			$password = $this->input->post('password');
			$this->db->where('id',2);
			$user = $this->db->get('users')->row_array();
			$hasher = new PasswordHash(
			$this->config->item('phpass_hash_strength', 'tank_auth'),
			$this->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user['password'])) {
				$tables = $this->db->list_tables();
				foreach ($tables as $table)
				{
				        if ($this->db->table_exists($table))
						{
							if($table == 'dgt_subscribers')
							{
								$this->db->where('subscribers_id',$subscription_id);
								$this->db->delete('dgt_subscribers');
								$this->db->where('client',$subscription_id);
								$this->db->delete('dgt_subscriber_invoices');
							}
							else if($table == 'dgt_users')
							{
								$this->db->select('id');
								$this->db->where('subdomain_id',$subscription_id);
								$details = $this->db->get('dgt_users')->result_array();
								$ac_detail = array_column($details,"id");
								$this->db->where_in('user_id', $ac_detail);
								$this->db->delete('dgt_account_details');
								$this->db->where('subdomain_id',$subscription_id);
								$this->db->delete('dgt_users');
							}						
					        else
							{
								if($this->db->field_exists('subdomain_id', $table))
								{
								    $this->db->where('subdomain_id',$subscription_id);
									$this->db->delete($table);
								}
							}
						}
				}
				$this->session->set_flashdata('tokbox_success', "Subscription Deleted Successfully!");
				redirect('superadmin/subscribed_companies');
			}else{
				$this->session->set_flashdata('tokbox_error', "Invalid Password!");
				redirect('superadmin/subscribed_companies');
			}
		}else{
			$this->session->set_flashdata('tokbox_error', "Something went wrong!");
			redirect('superadmin/subscribed_companies');
		}
	}

	public function profile_pic(){
		// echo "<pre>";print_r($this->input->post());die;
		$acc_id = $this->input->post('acc_id');
		// echo $acc_id;die;
		$config['upload_path'] = './assets/avatar/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['remove_spaces'] = TRUE;
		$config['overwrite']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('profile_pic'))
        {
            $this->session->set_flashdata('tokbox_error', $this->upload->display_errors());
			redirect('superadmin/subscribed_companies');
        }
        else
        {
        	$filedata = $this->upload->data();
            $file_name = $filedata['file_name'];
            $data = array('avatar' => $file_name);
            $this->db->where('id',$acc_id);
			$this->db->update('account_details',$data);
			// echo $this->db->last_query();die;
            $this->session->set_flashdata('tokbox_success', "Picture Uploaded Successfully!");
			redirect('superadmin/subscribed_companies');
        }
	}

	public function reset_password(){
		if($this->input->post()){
			$subscribers_id = $this->input->post('subscribers_id');
			$password = $this->input->post('password');
			$confirm_password = $this->input->post('confirm_password');
			if($password == $confirm_password){
				$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$result = array(
					'password' => $hashed_password,
					'decode_password' => $password,
				);
				$this->db->where('subscribers_id',$subscribers_id);
				$this->db->update('subscribers',$result);
				$this->session->set_flashdata('tokbox_success', "Password Reset Successfully!");
				redirect('superadmin/subscribed_companies');
			}else{				
				$this->session->set_flashdata('tokbox_error', "Passwords Mismatch!");
				redirect('superadmin/subscribed_companies');
			}
		}else{
			$this->session->set_flashdata('tokbox_error', "Password Reset Failed!");
			redirect('superadmin/subscribed_companies');
		}
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
			'support' => $_POST['customer_support']?'1':'0',
			'addtional_employee_rate' => $_POST['addtional_employee_rate'],
			'description' => $_POST['description'],
			'video_voice' => $_POST['voice_video_call']?'1':'0',
			'messages' => $_POST['unlimited_messages']?'1':'0',
			'status' => $_POST['status']?'1':'0',
		);
		$this->db->where('plan_id',$plan_id);
		$this->db->update('subscription_plans',$result);
		$this->session->set_flashdata('tokbox_success', "Plan Updated Successfully!");
        redirect('superadmin');
	}
	public function plan_menu_status(){
		if($this->input->post()){
	            $id = $this->input->post('id');
	            $status = $this->input->post('status');
	            if($status ==1){
	            	$result = array('status'=>0);

	            }else{
	            	$result = array('status'=>1);
	            }
	            $this->db->where('id',$id);
				$this->db->update('plan_menus',$result);
				echo $status;
	            die();
	        }
	}
	public function price_per_employee(){
		if($this->input->post()){
            $employee_count = $this->input->post('employee_count');
           
            $this->db->where('employee_count >=',$employee_count);
            $this->db->order_by('employee_count');
            $this->db->limit(1);
			$result = $this->db->get('price_per_employee')->row_array();
			
			echo  json_encode($result) ;
            die();
        }
	}
}

	


/* End of file clients.php */