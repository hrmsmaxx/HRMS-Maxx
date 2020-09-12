<?php 
class Request extends CI_Controller{
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'request';
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role'))?$this->session->userdata('user_role'):0;
    }
    public function demo()
    {
        $this->data['page']='demo';
        $this->data['list'] = $this->admin_panel_model->get_demo();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }

     public function quote()
    {
        $this->data['page']='quote';
        $this->data['list'] = $this->admin_panel_model->get_quote();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
   
}
?>