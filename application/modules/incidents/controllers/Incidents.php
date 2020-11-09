<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Incidents extends MX_Controller
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
        // $all_routes = $this->session->userdata('all_routes');
        // foreach($all_routes as $key => $route){
        //     if($route == 'categories'){
        //         $routname = categories;
        //     } 
        // }
        // if(empty($routname)){
        //      $this->session->set_flashdata('message', lang('access_denied'));
        //     redirect('');
        // }
        $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');
        $this->load->helper(array('inflector'));
        $this->applib->set_locale();
        $this->lead_view = (isset($_GET['list'])) ? $this->session->set_userdata('lead_view', $_GET['list']) : 'kanban';
    }

    public function index()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('incident_types').' - '.$this->company_name);           
        $data['page'] = lang('employees');
        $data['sub_page'] = lang('incidents');
        $data['form'] = true;
        $data['datatables'] = true;
        $data['leads_plugin'] = true;
        $data['fuelux'] = true;       
        $data['currencies'] = App::currencies();
        $data['languages'] = App::languages();        
        $data['countries'] = App::countries();
        $incidents = $this->db->select('U.*,AD.name')
                             ->from('incidents U')
                             ->join('incident_types AD','U.type = AD.id')
                             ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))
                             ->get()->result();
         $data['incidents'] = $incidents;
        $this->template
                ->set_layout('users')
                ->build('all_incidents', isset($data) ? $data : null);
    }


    function add_incident(){
        // print_r($_POST); exit();
        if ($_POST) {
            $_POST['created_by'] = $this->session->userdata('user_id');
            $_POST['status'] = isset($_POST['status'])?1:0;
            App::save_data('incidents',$this->input->post());

            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('department_added_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('incident_added_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            // $this->index();
            $this->load->view('modal/add_incident');
        }
    }

    function edit_incident($id = NULL){
       
        if ($_POST) {               
                 // echo print_r($_POST); exit;
            $_POST['limited_time'] = isset($_POST['limited_time'])?1:0;
            $_POST['status'] = isset($_POST['status'])?1:0;
            $this->db->where('id',$_POST['id']) -> update('incidents',$this->input->post());
            $this->session->set_flashdata('tokbox_success', lang('incident_edited_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
            
        }else{
            $data['id'] = $id;
            $data['incidents'] = $this->db ->where(array('id'=>$id)) -> get('incidents') -> result();
            // print_r($data['category_info']); exit();
            $this->load->view('modal_edit_incident',isset($data) ? $data : NULL);
        }
    }
    public function delete_incident()
    {
         if ($this->input->post()) {
               
                // echo "<pre>"; print_r( $_POST); exit;
               
               
                $this->db->where('id',$_POST['id']);
                $this->db->delete('incidents');      
                 // print_r($this->db->last_query()); die();
                $args = array(
                            'user' => User::get_id(),
                            'module' => 'incidents',
                            'module_field_id' => $_POST['id'],
                            'activity' => lang('delete_incidents'),
                            'icon' => 'fa-user',
                            'value1' => $this->input->post('id', true),
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                        );
                App::Log($args);
               $this->session->set_flashdata('tokbox_success', lang('incident_deleted_successfully'));
                redirect('incidents');
                        
        }else {
             // print_r($this->uri->segment(3)); exit;
            $data['id'] = $this->uri->segment(3);
            $this->load->view('modal/delete_incident',$data);

        }
    }


    public function incident_types()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('incident_types').' - '.$this->company_name);           
        $data['page'] = lang('employees');
        $data['sub_page'] = lang('incidents');
        $data['form'] = true;
        $data['datatables'] = true;
        $data['nouislider'] = true;
        $data['leads_plugin'] = true;
        $data['fuelux'] = true;       
        $data['currencies'] = App::currencies();
        $data['languages'] = App::languages();        
        $data['countries'] = App::countries();
        $this->template
                ->set_layout('users')
                ->build('all_incident_types', isset($data) ? $data : null);
    }


    function add_incident_types(){
        if ($_POST) {
            // print_r($_POST); exit;
            $_POST['status'] = isset($_POST['status'])?1:0;
            App::save_data('incident_types',$this->input->post());

            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('department_added_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('incident_type_added_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            // $this->index();
            $this->load->view('modal/add_incident_types');
        }
    }

    function edit_incident_types($id = NULL){
       
        if ($_POST) {
            if(isset($_POST['delete_incident_type']) AND $_POST['delete_incident_type'] == 'on'){
                $this->db->where('id',$_POST['id']) -> delete('incident_types');
                $this->session->set_flashdata('tokbox_error', lang('incident_type_deleted_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $_POST['status'] = isset($_POST['status'])?1:0;
                 // echo print_r($_POST); exit;
                $this->db->where('id',$_POST['id']) -> update('incident_types',$this->input->post());
                $this->session->set_flashdata('tokbox_success', lang('incident_type_edited_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $data['id'] = $id;
            $data['incident_types'] = $this->db ->where(array('id'=>$id)) -> get('incident_types') -> result();
            // print_r($data['category_info']); exit();
            $this->load->view('modal_edit_category',isset($data) ? $data : NULL);
        }
    }
  
    function calendar()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('incident_calendar').'-'.$this->company_name);
        $data['fullcalendar'] = TRUE;
        $data['datepicker'] = TRUE;
        $data['form'] = TRUE;
        $data['page'] = lang('employees');
        $data['sub_page'] = lang('incidents');
        $this->template
        ->set_layout('users')
        ->build('calendar',isset($data) ? $data : NULL);

    }
    function add_event()
    {
        // if(User::is_admin() || User::is_staff()){

        if ($_POST) {

        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        // $this->form_validation->set_rules('event_name', lang('event_name'), 'required');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            Applib::go_to($_SERVER['HTTP_REFERER'],'error',lang('error_in_form'));
        }else{
            $start_date = Applib::date_formatter($this->input->post('start_date', TRUE));
            $end_date = Applib::date_formatter($this->input->post('end_date', TRUE));
                    $data = array(
                        'emp_id'        => $this->input->post('emp_id', TRUE),
                        'incident'      => $this->input->post('incident', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date,
                        'color'         => $this->input->post('color', TRUE),
                        'created_by'    => User::get_id(),
                        'created_date'  => date('Y-m-d H:i:s'),
                        'subdomain_id'  => $this->session->userdata('subdomain_id')
                        );
                    $this->db->insert('calendar_incident', $data);
                    // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('event_added_success'));
                    $this->session->set_flashdata('tokbox_success', lang('incident_added_successfully'));
                    redirect($_SERVER['HTTP_REFERER']);
            }
                } else {
                    $this->load->view('modal/add_event',isset($data) ? $data : NULL);
                }
    // }
}

function edit_incident_cal($id = NULL)
    {
        // if(User::is_admin() || User::is_staff()){

        if ($_POST) {

         $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        // $this->form_validation->set_rules('event_name', lang('event_name'), 'required');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            Applib::go_to($_SERVER['HTTP_REFERER'],'error',lang('error_in_form'));
        }else{
            $id = $this->input->post('id', TRUE);
             $created_by = $this->db->where('id',$id)->get('dgt_calendar_incident')->row()->created_by;
            $start_date = Applib::date_formatter($this->input->post('start_date', TRUE));
            $end_date = Applib::date_formatter($this->input->post('end_date', TRUE));
                    $data = array(
                        'emp_id'    => $this->input->post('emp_id', TRUE),
                        'incident'   => $this->input->post('incident', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date,
                        'color'         => $this->input->post('color', TRUE),
                        // 'created_by'      => $created_by
                        // 'created_date'       => date('Y-m-d H:i:s')
                        );
                    // if(User::is_admin() || (User::is_staff() && $added_by == User::get_id())){
                    //     $this->db->where('id',$id)->update('events', $data);
                    // }
                     if($created_by == User::get_id()){
                        $this->db->where('id',$id)->update('calendar_incident', $data);
                    }

                    // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('event_edited_success'));
                    $this->session->set_flashdata('tokbox_success', lang('incident_edited_success'));
                    redirect($_SERVER['HTTP_REFERER']);
            }
                } else {
                    $data['incidents'] = $this->db->where('id',$id)->get('calendar_incident')->row();
                    $this->load->view('modal/edit_incident_cal',isset($data) ? $data : NULL);
                }
    // }
}


function edit_event($id = NULL)
    {
        // if(User::is_admin() || User::is_staff()){

        if ($_POST) {

        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        // $this->form_validation->set_rules('event_name', lang('event_name'), 'required');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            Applib::go_to($_SERVER['HTTP_REFERER'],'error',lang('error_in_form'));
        }else{
            $id = $this->input->post('id', TRUE);
            $added_by = $this->db->where('id',$id)->get('calendar_incident')->row()->created_by;
            $start_date = Applib::date_formatter($this->input->post('start_date', TRUE));
            $end_date = Applib::date_formatter($this->input->post('end_date', TRUE));
                    $data = array(
                        'emp_id'    => $this->input->post('emp_id', TRUE),
                        'incident'   => $this->input->post('incident', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date,
                        'color'         => $this->input->post('color', TRUE)
                        );
                    // if(User::is_admin() || (User::is_staff() && $added_by == User::get_id())){
                    //     $this->db->where('id',$id)->update('events', $data);
                    // }
                     if($added_by == User::get_id()){
                        $this->db->where('id',$id)->update('calendar_incident', $data);
                    }

                    // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('event_edited_success'));
                    $this->session->set_flashdata('tokbox_success', lang('incident_edited_successfully'));
                    redirect($_SERVER['HTTP_REFERER']);
            }
                } else {
                    $data['event'] = $this->db->where('id',$id)->get('calendar_incident')->row();
                    $this->load->view('modal/edit_event',isset($data) ? $data : NULL);
                }
    // }
}
  function check_incident_name()
    {
        $incident_name = $this->input->post('incident_name');
        $check_incident_name =$this->db->get_where('incidents',array('incident_name'=>$incident_name))->num_rows();
        if($check_incident_name > 0)
        {
            echo "yes";
        }else{
            echo "no";
        }
        exit;
    }
     function check_id_code()
    {
        $id_code = $this->input->post('id_code');
        $check_id_code =$this->db->get_where('incidents',array('id_code'=>$id_code))->num_rows();
        if($check_id_code > 0)
        {
            echo "yes";
        }else{
            echo "no";
        }
        exit;
    }
    function check_auto_id_code()
    {
        $type_id = $this->input->post('type_id');
        $incident_types =$this->db->get_where('dgt_incident_types',array('id'=>$type_id))->row_array();
        $incidents =$this->db->order_by('id_code','DESC')->limit(1)->get_where('dgt_incidents',array('type'=>$type_id))->row_array();
        // echo $type_id.'dsd'. $this->db->last_query(); exit;
        if($incidents == array()){            
            $id_code['id_code'] = $incident_types['number_of_incidents_start'];
            $id_code['status'] = 'not_exceeded';
        }else{
            if($incidents['id_code'] ==  $incident_types['number_of_incidents_end']){
                $id_code['id_code'] = '';
                $id_code['exceeded'];             
            }else{
               $id_code['id_code']=  $incidents['id_code'] + 1;
               $id_code['status'] = 'not_exceeded';
            }
            

        }
        echo json_encode($id_code);
        exit;
    }

}
/* End of file all_departments.php */
