<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	 public function __construct(){    
    parent::__construct();
    error_reporting(0);
    $this->load->model('admin_panel_model');    


    $this->data['theme'] = 'admin';
    $this->data['module'] = 'dashboard';
    

     }


      public function index()
	{      
		$this->data['page'] = 'index';
		$this->data['demo'] = $this->db->where('type','Demo')->get('contactus')->num_rows();
		$this->data['quote'] = $this->db->where('type','Quote')->get('contactus')->num_rows();
		$this->data['sales'] = $this->db->where('payment_status',1)->get('sales')->num_rows();        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}

	public function is_valid_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');    
		$result = $this->admin_panel_model->is_valid_login($username,$password);   
		if(!empty($result))
		{        		 
			$this->session->set_userdata('id',$result['ADMINID']);  
			$this->session->set_userdata('SESSION_USER_ID',$result['ADMINID']);  
			$this->session->set_userdata('user_role',$result['user_role']);   
			$site_name = $this->admin_panel_model->site_name();          
			$this->session->set_userdata('sitename',$site_name['value']);
			echo 1;
		}
	 else 
		{ 
			echo 2;
			$this->session->set_flashdata('message','wrong login credantiales.');
		}
	}


	public function logout() 
	{
        if (!empty($this->session->userdata['id'])) 
            {
	            $this->session->unset_userdata('id');
	            $this->session->unset_userdata('user_role');
	            $this->session->unset_userdata('SESSION_USER_ID');
            }
        redirect(base_url($this->data['theme']));
    }

}
