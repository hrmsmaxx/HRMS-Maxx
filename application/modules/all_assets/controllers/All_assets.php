<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class All_assets extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->library(array('form_validation'));
        $this->load->model(array('Client', 'App', 'Lead'));
        // if (!User::is_admin()) {
        //     $this->session->set_flashdata('message', lang('access_denied'));
        //     redirect('');
        // }
        $all_routes = $this->session->userdata('all_routes');
        foreach($all_routes as $key => $route){
            if($route == 'all_assets'){
                $routname = all_assets;
            } 
        }
        if(empty($routname)){
             $this->session->set_flashdata('message', lang('access_denied'));
            redirect('');
        }
        $this->load->helper(array('inflector'));
        $this->applib->set_locale();
        $this->lead_view = (isset($_GET['list'])) ? $this->session->set_userdata('lead_view', $_GET['list']) : 'kanban';
    }

    public function index()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('all_assets').' - '.config_item('company_name'));
        $data['page'] = lang('all_assets');
        $data['form'] = true;
        $data['datatables'] = true;
        $data['categories'] = $this->db->get_where('asset_category',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();

        $data['form'] = true;

        $data['datatables'] = true;

        $user_assets = $this->db->select('*')

                                     ->from('user_assets U')

                                     ->join('asset_category AD','U.category = AD.cat_id','LEFT')

                                     ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))

                                     ->get()->result_array();

        $data['all_assets'] = $user_assets;
        $this->template
                ->set_layout('users')
                ->build('all_assets', isset($data) ? $data : null);
    }

    public function add()
    {
        if($_POST)
        {
            $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
            $this->db->insert('user_assets',$this->input->post());
            $this->session->set_flashdata('tokbox_success', 'Asset Added Successfully');
            redirect('all_assets');
        }
    }
    public function edit($id)
    {
        if($_POST)
        {
            $this->db->where('assets_id',$id);
            $this->db->update('user_assets',$this->input->post());
            $this->session->set_flashdata('tokbox_success', 'Asset Updated Successfully');
            redirect('all_assets');
        }
    }

    public function delete($id)
    {
        $this->db->where('assets_id',$id);
        $this->db->delete('user_assets');
        $this->session->set_flashdata('tokbox_success', 'Asset deleted Successfully');
        redirect('all_assets');
    }
}
/* End of file all_assets.php */
