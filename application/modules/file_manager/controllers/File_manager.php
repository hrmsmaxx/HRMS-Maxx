<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class File_manager extends MX_Controller
{
    public function __construct()
    {   
        parent::__construct();
        User::logged_in();

        $this->load->library(array('form_validation'));
        $this->load->model(array('App', 'Lead'));
        // if (!User::is_admin()) {
        //     $this->session->set_flashdata('message', lang('access_denied'));
        //     redirect('');
        // }
        $this->load->helper(array('inflector'));
        $this->applib->set_locale();
        $this->lead_view = (isset($_GET['list'])) ? $this->session->set_userdata('lead_view', $_GET['list']) : 'kanban';
    }

    public function index()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');
        $this->template->title(lang('file_manager').' - '.$this->company_name);
        $data['page'] = lang('file_manager');
        $data['form'] = true;
        $data['datatables'] = true;
        $data['currencies'] = App::currencies();
        $data['languages'] = App::languages();         
        $this->template
                ->set_layout('users')
                ->build('file_manager', isset($data) ? $data : null);
    }

    public function project_files(){
        $project_id = $this->input->post('project_id');
        if($project_id != 0){
            $project_files =$this->db->query("SELECT tf.* FROM dgt_tasks AS t JOIN  dgt_task_files AS tf ON tf.task=t.t_id  WHERE t.project='".$project_id."' ORDER BY tf.date_posted ASC")->result_array();
        }else{
            $project_files = $this->db->query("SELECT tf.* FROM dgt_tasks AS t JOIN  dgt_task_files AS tf ON tf.task=t.t_id  ORDER BY tf.date_posted ASC")->result_array();
        }
        echo json_encode($project_files); exit;
    }

    public function task_file_delete($file_id){
        if ($this->input->post()) {
           $this->db->where('file_id',$file_id);
           $this->db->delete('task_files');
           $this->session->set_flashdata('tokbox_success', 'File Deleted Successfully!');
           redirect('file_manager');
        }else{
            $data['file_id'] = (!empty($file_id))?$file_id:0;

            $this->load->view('modal/task_file_delete',$data); 
        }
    }

    
}