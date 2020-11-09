<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shift_scheduling extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        User::logged_in();
        // if($this->session->userdata('role_id') != 1){
        //     redirect();
        // }

        $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');
        
        $this->load->helper('security');
        $this->load->model(array('Client','App','Lead','Users'));
        // $this->load->model('Shift_scheduling','shift_scheduling');        
        $this->load->model('Shift_scheduling_model','shift_scheduling');
    }
    function index(){
        $this->active();
    }

    function active()
    {
    $this->load->module('layouts');
    $this->load->library('template');
    $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
    $data['page'] = lang('employees');
    $data['sub_page'] = lang('shift_scheduling');
    $data['datatables'] = TRUE;
    $data['form'] = TRUE;
    $data['country_code'] = TRUE;
    $data['daterangepicker'] = TRUE;    
    $data['datepicker'] = TRUE;      
    $branch_id = $this->session->userdata('branch_id');

    if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
            $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
            
    }
    
    if($_POST){
     // echo "<pre>"; print_r($_POST); exit()   ;
        $data['username']= $_POST['username'];
        $data['department_id']= $_POST['department_id'];
        $data['schedule_date']= $_POST['schedule_date'];
        $data['week']= $_POST['week'];
        // $schedules_date = explode('-', $_POST['schedule_date']);
        
        // echo $diff; exit;
        $this->db->select('S.*,U.id_code,D.designation,A.fullname');
        $this->db->from('shift_scheduling S');
        $this->db->join('users U','U.id = S.employee_id','LEFT');
        $this->db->join('account_details A','A.user_id = U.id','LEFT');
        $this->db->join('designation D','D.id = U.designation_id','LEFT');
        $this->db->where('S.published','1');
        $this->db->where('U.subdomain_id',$this->session->userdata('subdomain_id'));
        if($_POST['username'] !=''){
            $this->db->like('A.fullname', $_POST['username']);
        }

        if($_POST['department_id'] !=''){
            $deptid = $_POST['department_id'];
            $this->db->where("FIND_IN_SET('$deptid',U.department_id) !=", 0);
            //$this->db->where_in($_POST['department_id'],'U.department_id');
        }
        

        $this->db->where('U.id !=',$this->session->userdata('user_id'));
          if($dept_id !=0 && $_SESSION['is_teamlead'] == 'yes'){
            if($dept_id !=0){
                $depart_id = explode(',', $dept_id);
                //$this->db->where_in('U.department_id', $depart_id);
                $this->db->where("U.department_id IN (".$dept_id.")",NULL, false);
               //$this->db->where_in($dept_id,'U.department_id');
            } 

            if($branch_id !=0){
                $branch = explode(',', $branch_id);
                $this->db->where("U.branch_id IN (".$branch_id.")",NULL, false);
                //$this->db->where_in('U.branch_id', $branch);
            } 

            if($_SESSION['is_teamlead'] == 'yes'){
                $this->db->or_where('U.teamlead_id',$this->session->userdata('user_id'));
            }
        } else {
             if($dept_id !=0){
                $depart_id = explode(',', $dept_id);
                //$this->db->where_in('U.department_id', $depart_id);
                $this->db->where("U.department_id IN (".$dept_id.")",NULL, false);
               //$this->db->where_in($dept_id,'U.department_id');
            }

            if($branch_id !=0){
                $branch = explode(',', $branch_id);
                $this->db->where("U.branch_id IN (".$branch_id.")",NULL, false);
                //$this->db->where_in('U.branch_id', $branch);
            } 
 
            if($_SESSION['is_teamlead'] == 'yes'){
                $this->db->or_where('U.teamlead_id',$this->session->userdata('user_id'));
            }
        }
        $this->db->group_by('S.employee_id');
        $data['shift_scheduling'] = $this->db->get()->result_array();
    } else {
        //print_r($dept_id); exit;
        $this->db->select('S.*,U.id_code,D.designation,A.fullname');
        $this->db->from('shift_scheduling S');
        $this->db->join('users U','U.id = S.employee_id','LEFT');
        $this->db->join('account_details A','A.user_id = U.id','LEFT');
        $this->db->join('designation D','D.id = U.designation_id','LEFT');
        
        $this->db->where('S.published','1');
        $this->db->where('U.id !=',$this->session->userdata('user_id'));
        $this->db->where('U.subdomain_id',$this->session->userdata('subdomain_id'));
        if($dept_id !=0 && $_SESSION['is_teamlead'] == 'yes'){
            if($dept_id !=0){
                //echo 'if'; exit;
                //$this->db->where("FIND_IN_SET('$dept_id',U.department_id) !=", 0);
               //$this->db->where("FIND_IN_SET('$dept_id','U.department_id')");
                $depts_id = explode(',', $dept_id);
                //$this->db->where_in('U.department_id', $depts_id);
                $this->db->where("U.department_id IN (".$dept_id.")",NULL, false);
            } 

            if($branch_id !=0){
                $branch = explode(',', $branch_id);
                $this->db->where("U.branch_id IN (".$branch_id.")",NULL, false);
                //$this->db->where_in('U.branch_id', $branch);
            } 

            if($_SESSION['is_teamlead'] == 'yes'){
                $this->db->or_where('U.teamlead_id',$this->session->userdata('user_id'));
            }
        }  else {
             if($dept_id !=0){
                $depts_id = explode(',', $dept_id);
                //$this->db->where_in('U.department_id', $depts_id);
                $this->db->where("U.department_id IN (".$dept_id.")",NULL, false);
                //$this->db->where("FIND_IN_SET('$dept_id',U.department_id) !=", 0);
               //$this->db->where_in('U.department_id', $dept_id);
            }


            if($branch_id !=0){
                //$dj_genres = trim($branch_id, "'");
                $branch = explode(',', $branch_id);
                //print_r(array('$branch_id')); exit;trim($branch, "'")
                //$this->db->where_in('U.branch_id', $branch);
                
                $this->db->where("U.branch_id IN (".$branch_id.")",NULL, false);
            }
            //echo 'sdfsdfs'.$branch_id; exit;
            if($_SESSION['is_teamlead'] == 'yes') {
                $this->db->or_where('U.teamlead_id',$this->session->userdata('user_id'));
            }
        }
       
        $this->db->group_by('S.employee_id');
        $data['shift_scheduling'] = $this->db->get()->result_array();
    }
    // echo "<pre>";print_r($data['shift_scheduling']); exit;
    $this->template
    ->set_layout('users')
    ->build('daily_schedule',isset($data) ? $data : NULL);
    }

    function shift_list()
    {
    $this->load->module('layouts');
    $this->load->library('template');
    $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
    $data['page'] = lang('employees');
    $data['sub_page'] = lang('shift_scheduling');
    $data['datatables'] = TRUE;
    $data['form'] = TRUE;
    $data['country_code'] = TRUE;
    $data['datepicker'] = TRUE;   
    $subdomain_id       = $this->session->userdata('subdomain_id');  
    $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
    // if(!empty($_SESSION['branch_id'])){
    //     $branch_id = explode(',', $_SESSION['branch_id']);
    //     $this->db->where_in('branch_id', $branch_id);
    // }
    $data['shifts'] = $this->db->get('shifts')->result_array(); 
   // echo "<pre>";print_r($data['shifts']); exit();
    $this->template
    ->set_layout('users')
    ->build('shift_list',isset($data) ? $data : NULL);
    }

    function add_shift()
    {
        if($_POST){
                       
            $week_days = isset($_POST['week_days'])?$_POST['week_days']:'';
            if(!empty($week_days)){
                $week_days = implode(',',$week_days);
            }
            $workdays = isset($_POST['workdays'])?$_POST['workdays']:'';
            if(!empty($workdays)){
                $workday = count($_POST['workdays']);
            }
            if($_POST['free_shift'] == 1){
                $_POST['start_time'] = $_POST['range_start_time'];
                $_POST['end_time']   = $_POST['range_end_time'];
            }
                // echo "<pre>";print_r($_POST); exit();
            if(empty($_POST['free_shift'])){
               $work_hours = work_time($_POST['start_date'].' '.$_POST['start_time'],$_POST['start_date'].' '.$_POST['end_time'],$_POST['break_time']);
               $_POST['work_hours'] = $work_hours; 
               // echo "<pre>"; print_r($work_hours); exit;
            }
            // echo "<pre>";print_r($_POST); exit();
            $_POST['start_date'] = isset($_POST['start_date'])?date('Y-m-d',strtotime($_POST['start_date'])):'';
            $_POST['end_date'] = !empty($_POST['end_date'])?date('Y-m-d',strtotime($_POST['end_date'])):'';

            $get_id_code = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by('id_code',DESC)->get('shifts')->row()->id_code;
            $id_code = $get_id_code +1;
            $exist_shift = $this->db->get_where('shifts',array('subdomain_id'=>$this->session->userdata('subdomain_id'),'shift_name'=>$_POST['shift_name']))->num_rows();
            if(empty($exist_shift)){
                $shift_details = array(            
                'shift_name' => $_POST['shift_name'],
                // 'branch_id' => $_POST['branch_id'],
                'id_code' => $id_code,
                'start_date' => $_POST['start_date'],
                'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                'work_hours' => !empty($_POST['work_hours'])?$_POST['work_hours']:0,
                'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
                'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
                'no_of_days_in_cycle' => isset($_POST['no_of_days_in_cycle'])?$_POST['no_of_days_in_cycle']:0,
                'week_days' => $week_days, 
                'workday' => isset($workday)?$workday:0,
                'end_date' =>$_POST['end_date'],
                'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0,
                'tag' => $_POST['tag'],
                'note' => $_POST['note'],
                'created_by' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id'),
                'published' => isset($_POST['publish'])?$_POST['publish']:0

                );
                // echo "<pre>";print_r($shift_details); exit();
                $this->db->insert('shifts',$shift_details);
                // echo $this->db->last_query(); exit;
                $shift_id =$this->db->insert_id();
                $data = array(
                    'module' => 'shift_scheduling',
                    'module_field_id' => $shift_id,
                    'user' => $this->session->userdata('user_id'),
                    'activity' => $_POST['shift_name'].' '.lang('shift_created'),
                    'icon' => 'fa-plus',
                    'value1' => $cur.' '.$this->input->post('shift_name')
                    );
                App::Log($data);
                $this->session->set_flashdata('tokbox_success', lang('shift_created_successfully'));
            }else{
                $this->session->set_flashdata('tokbox_error', lang('shift_already_exist'));
            }
            
        redirect('shift_scheduling/shift_list');
        
    }else{            
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
            $data['page'] = lang('employees');
            $data['sub_page'] = lang('shift_scheduling');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;            
            // $data['daterangepicker'] = TRUE;
            $data['form'] = TRUE;     
            $this->template
            ->set_layout('users')
            ->build('add_shift',isset($data) ? $data : NULL);
        }
    
    }

     function edit_shift()
    {
        if($_POST){

            
                       
           $week_days = isset($_POST['week_days'])?$_POST['week_days']:'';
            if(!empty($week_days)){
                $week_days = implode(',',$week_days);
            }
            $workdays = isset($_POST['workdays'])?$_POST['workdays']:'';
            if(!empty($workdays)){
                $workday = count($_POST['workdays']);
            }
            if(isset($_POST['cyclic_shift'])){
                $no_of_days_in_cycle = isset($_POST['no_of_days_in_cycle'])?$_POST['no_of_days_in_cycle']:0;
            } else{
                $no_of_days_in_cycle = 0;
            }
            if($_POST['free_shift'] == 1){
                $_POST['start_time'] = $_POST['range_start_time'];
                $_POST['end_time']   = $_POST['range_end_time'];
            }
            if(empty($_POST['free_shift'])){
               $work_hours = work_time($_POST['start_date'].' '.$_POST['start_time'],$_POST['start_date'].' '.$_POST['end_time'],$_POST['break_time']);
               $_POST['work_hours'] = $work_hours; 
               // echo "<pre>"; print_r($work_hours); exit;
            }
            // echo "<pre>"; print_r($_POST); exit;  
            $_POST['start_date'] = isset($_POST['start_date'])?date('Y-m-d',strtotime($_POST['start_date'])):'';
            $_POST['end_date'] = !empty($_POST['end_date'])?date('Y-m-d',strtotime($_POST['end_date'])):'';


            $shift_details = array(            
            'shift_name' => $_POST['shift_name'],
            // 'branch_id' => $_POST['branch_id'],
            'start_date' => $_POST['start_date'],
            'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
            'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
            'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
            'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
            'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
            'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
            'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
            'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
            'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
            'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
            'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
            'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
            'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
            'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
            'no_of_days_in_cycle' => $no_of_days_in_cycle,
            'workday' => isset($workday)?$workday:0,
            'week_days' => $week_days,   
            'end_date' =>$_POST['end_date'],
            'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0,
            'tag' => $_POST['tag'],
            'note' => $_POST['note'],
            'created_by' => $this->session->userdata('user_id'),
            'subdomain_id' => $this->session->userdata('subdomain_id'),
            'published' => isset($_POST['publish'])?$_POST['publish']:0

            );
            // echo "<pre>";print_r($shift_details); exit();
            $this->db->where('id',$_POST['id']);
            $this->db->update('shifts',$shift_details);
            $shift_id =$this->db->insert_id();
            //update the shift_scheduling
            $shift_scheduling = array(    

            'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
            'min_start_time' => date("H:i", strtotime($_POST['min_start_time'])),
            'start_time' => date("H:i", strtotime($_POST['start_time'])),
            'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
            'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
            'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
            'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
            'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
            'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
            'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
            'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
            'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
            'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
            'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
            'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
            'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
            'week_days' => $week_days,
            'end_date' =>$_POST['end_date'],
            'subdomain_id' => $this->session->userdata('subdomain_id'),
            'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0
            );
                             // echo "<pre>";print_r($shift_details); exit();
            $this->db->where('shift_id',$_POST['id']);
            $this->db->where('schedule_date >',date('Y-m-d'));
            $this->db->update('shift_scheduling',$shift_scheduling);
            // end update the shift_scheduling
            $data = array(
                'module' => 'shift_scheduling',
                'module_field_id' => $shift_id,
                'user' => $this->session->userdata('user_id'),
                'activity' => 'Updated Shift Scheduled',
                'icon' => 'fa-plus',
                'value1' => $cur.' '.$this->input->post('shift_name')
                );
            App::Log($data);
        $this->session->set_flashdata('tokbox_success', lang('shift_edited_successfully'));
            
            
        redirect('shift_scheduling/shift_list');
        
    }else{            
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
            $data['page'] = lang('employees');
            $data['sub_page'] = lang('shift_scheduling');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;            
            // $data['daterangepicker'] = TRUE;
            $id= $this->uri->segment(3);
            $data['shift_details'] = $this->db->get_where('shifts',array('id'=>$id))->row_array(); 
            $data['form'] = TRUE;     
            $this->template
            ->set_layout('users')
            ->build('edit_shift',isset($data) ? $data : NULL);
        }
    
    }

    function get_shift_by_id(){
        

        if($this->input->post()){
            $id = $this->input->post('id');           
            $record = $this->db->get_where('shifts',array('id'=>$id))->row_array(); 
            if(!empty($record['project_id'])){
                $project = $this->db->get_where('projects',array('project_id'=>$record['project_id']))->row_array();                  
                $project_id = $record['project_id'];
                $project_code = $project['project_code'];
            }else{
                $project_id = '';
                $project_code = '';
            }
            

            $records['start_date'] =($record['start_date'] != '0000-00-00')?date('d-m-Y',strtotime($record['start_date'])):date('d-m-Y',time()) ;            
            $records['min_start_time'] = ($record['min_start_time'] != '00:00:00')?date('h:i a', strtotime($record['min_start_time'])):'';
            $records['start_time'] = ($record['start_time'] != '00:00:00')?date('h:i a', strtotime($record['start_time'])):'';
            $records['max_start_time'] = ($record['max_start_time'] != '00:00:00')?date('h:i a', strtotime($record['max_start_time'])):'';
            $records['min_end_time'] = ($record['min_end_time'] != '00:00:00')?date('h:i a', strtotime($record['min_end_time'])):'';
            $records['end_time'] = ($record['end_time'] != '00:00:00')?date('h:i a', strtotime($record['end_time'])):'';
            $records['max_end_time'] = ($record['min_start_time'] != '00:00:00')?date('h:i a', strtotime($record['min_start_time'])):'';
            $records['break_start'] =($record['break_start'] != '00:00:00')?date('h:i a', strtotime($record['break_start'])):'';
            $records['break_end'] =($record['break_end'] != '00:00:00')?date('h:i a', strtotime($record['break_end'])):'';
            $records['break_time'] = $record['break_time'];
            $records['work_hours'] = $record['work_hours'];
            $records['free_shift'] = $record['free_shift'];
            $records['recurring_shift'] = $record['recurring_shift'];
            $records['cyclic_shift'] = $record['cyclic_shift'];
            $records['no_of_days_in_cycle'] = $record['no_of_days_in_cycle'];
            $records['workday'] = $record['workday'];
            $records['repeat_week'] = $record['repeat_week'];
            $records['week_days'] = $record['week_days'];
            $records['end_date'] =($record['end_date'] != '0000-00-00')?date('d-m-Y',strtotime($record['end_date'])):date('d-m-Y',time()) ;
            $records['indefinite'] = $record['indefinite'];
            $records['project_id'] = $project_id;
            $records['project_code'] = $project_code;
            echo json_encode($records);
            die();
        }
    }
    
    function delete_shift($id = NULL)
    {
        if ($this->input->post()) {

            $id = $this->input->post('id', TRUE);            

            App::delete('activities',array('module'=>'shift_scheduling', 'module_field_id' => $id));
            //delete ticket
            App::delete('shifts',array('id'=>$id));

            // Applib::go_to('tickets','success',lang('ticket_deleted_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('shift_deleted_successfully'));
            redirect('shift_scheduling/shift_list');

        }else{
            $data['id'] = $id;
             // echo  $id; exit;

            $this->load->view('modal/delete_shift',$data);
        }
    }
    function dept_emp(){
        if($this->input->post()){
            $depart_id = $this->input->post('department');

            $this->db->select('US.id as user_id,AD.fullname');
            $this->db->from('users US');
            $this->db->join('dgt_account_details AD','US.id = AD.user_id');
            $this->db->where("FIND_IN_SET('$depart_id',US.department_id) !=", 0);
            $this->db->where('US.subdomain_id', $this->session->userdata('subdomain_id'));
            $this->db->order_by("AD.fullname", "asc");
            $records = $this->db->get()->result_array();
            echo json_encode($records);
            die();
        }
    }

    function add_schedule()
    {
        if($_POST){
            $employees = $_POST['employee'];
                    // echo "<pre>";print_r($_POST); exit();
            if (count($employees) > 0) {
                     
                $exist_schedule_count= 1;
                foreach ($employees as $key => $value) {
                $d = $_POST['week_days'];
                $leaveDay = 0; 
                $weekDays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
                $week_days = isset($_POST['week_days'])?$_POST['week_days']:'';
                if(!empty($week_days)){
                    $week_days = implode(',',$week_days);
                }
                if(isset($_POST['single_insert'])){

                $this->db->where('employee_id',$value);
                $this->db->where('shift_id',$_POST['shift_id']);
                $this->db->where('schedule_date',date('Y-m-d',strtotime($_POST['schedule_date'])));
                $this->db->delete('shift_scheduling');
                       // echo "<pre>";print_r($_POST); exit();
                $_POST['end_date'] = !empty($_POST['end_date'])?date('Y-m-d',strtotime($_POST['end_date'])):'';
                $_POST['schedule_date'] = date('Y-m-d',strtotime($_POST['schedule_date']));
                if(!empty($_POST['indefinite'])){

                    $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                } else {
                    $end_schedulde_date= $_POST['end_date'];
                    $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($_POST['end_date'])));
                }                 
                   // echo $end_schedulde_date; exit();
                  
                
                $begin = new DateTime($_POST['schedule_date']);
                $end = new DateTime($end_schedulde_date);

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);
                 
                 // echo $employee_shifts; exit;
                 // echo "<pre>";
                foreach ($period as $dt) {

                       
                    // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                        
                     // echo $employee_shifts; exit;
                    // if(empty($employee_shifts)){
                        $shift_details = array(
                        'dept_id' => $_POST['department'],
                        'employee_id' => $value,
                        'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                        'schedule_date' => $dt->format("Y-m-d"),
                        'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                        'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                        'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                        'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                        'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                        'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                        'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                        'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                        'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                        'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                        'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
                        'shift_id' => $_POST['shift_id'],
                        'color' => $_POST['color'],
                        'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                        'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                        'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
                        'week_days' => $week_days,
                        'created_by' => $this->session->userdata('user_id'),
                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                        'published' => isset($_POST['publish'])?$_POST['publish']:0

                        );
                         // echo "<pre>";print_r($shift_details); exit();
                        $this->db->insert('shift_scheduling',$shift_details);

                        $shift_id =$this->db->insert_id();
                       
                    // }
                }
                    //  else {
                        
                    //     $exist_date = $_POST['schedule_date'];
                    //     $exist_count += $exist_schedule_count;
                    // }
            } else {                
              
                  // $end_schedulde_date= date('Y-m-d',strtotime('+'.$_POST["repeat_week"].' week', strtotime($_POST['schedule_date'])));
                  if(!empty($_POST['indefinite'])){

                    $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                  } else {

                        $end_schedulde_date= $_POST['end_date'];
                        $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($_POST['end_date'])));
                  }
                 
                   // echo $end_schedulde_date; exit();
                  
                $_POST['end_date'] = !empty($_POST['end_date'])?date('Y-m-d',strtotime($_POST['end_date'])):'';
                // $repeat_time = $_POST['repeat_time'] * 7;
                 // echo $start_date .' '.$maxDays; exit;
                if((isset($_POST["recurring_shift"]) && !empty($_POST["recurring_shift"])) || (isset($_POST["free_shift"]) && !empty($_POST["free_shift"]))) {
                    $this->db->where('employee_id',$value);
                    $this->db->where('shift_id',$_POST['shift_id']);
                    $this->db->where('schedule_date >=',date('Y-m-d',strtotime($_POST['schedule_date'])));
                    if($_POST['indefinite'] != 1 && empty($_POST['cyclic_shift'])){                            
                        $this->db->where('schedule_date <=',date('Y-m-d',strtotime($_POST['end_date'])));
                    }
                    $this->db->delete('shift_scheduling');

                    $begin = new DateTime($_POST['schedule_date']);
                    $end = new DateTime($end_schedulde_date);

                    $interval = DateInterval::createFromDateString('1 day');
                    $period = new DatePeriod($begin, $interval, $end);
                    $k=0;

                   // echo "<pre>";print_r($period); exit;       
                    foreach ($period as $dt) {
                        if(in_array(lcfirst($dt->format("l")), $_POST['week_days'])){
                                // echo $dt->format("l Y-m-d H:i:s\n");
                                // echo "<pre>";print_r($_POST); exit;
                           
                            // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                           
                            
                            // if(empty($employee_shifts)){
                                 $shift_details = array(
                                'dept_id' => $_POST['department'],
                                'employee_id' => $value,
                                'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                                'schedule_date' => $dt->format("Y-m-d"),
                                'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                                'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                                'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                                'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                                'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                                'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                                'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                                'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                                'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                                'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                                'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
                                'shift_id' => $_POST['shift_id'],
                                'color' => isset($_POST['color'])?$_POST['color']:'',
                                'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                                'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                                'week_days' => $week_days,                                    
                                'end_date' =>$_POST['end_date'],
                                'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0,                                       
                                'created_by' => $this->session->userdata('user_id'),
                                'subdomain_id' => $this->session->userdata('subdomain_id'),
                                'published' => isset($_POST['publish'])?$_POST['publish']:0                           

                                );

                                  // echo "<pre>";print_r($shift_details); exit();
                                
                                $this->db->insert('shift_scheduling',$shift_details);
                                
                                $shift_id =$this->db->insert_id();
                            // }
                            // else {
                                
                            //     $exist_date = $_POST['schedule_date'];
                            //     $exist_count += $exist_schedule_count;
                            // }
                        }
                            
                        // echo "<pre>";print_r($shift_details); exit();
                        $k++;

                
                    }
                     
                } else if(isset($_POST["cyclic_shift"]) && !empty($_POST["cyclic_shift"])){
                    $this->db->where('employee_id',$value);
                    $this->db->where('shift_id',$_POST['shift_id']);
                    $this->db->where('schedule_date >=',date('Y-m-d',strtotime($_POST['schedule_date'])));
                    if($_POST['indefinite'] != 1 && empty($_POST['cyclic_shift'])){                            
                        $this->db->where('schedule_date <=',date('Y-m-d',strtotime($_POST['end_date'])));
                    }
                    $this->db->delete('shift_scheduling');
                    $workdays = isset($_POST['workdays'])?$_POST['workdays']:'';
                    if(!empty($workdays)){
                        $workday = count($_POST['workdays']);
                    }
                    if(isset($_POST['cyclic_shift'])){
                        $no_of_days_in_cycle = isset($_POST['no_of_days_in_cycle'])?$_POST['no_of_days_in_cycle']:0;
                    } else{
                        $no_of_days_in_cycle = 0;
                    }
                    $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                     
                       
                        
                    for($i=1; $i<=120; $i++){
                                
                        $workdays = 5;
                        echo $i%$no_of_days_in_cycle;
                        if($i%$no_of_days_in_cycle > $workday || $i%$no_of_days_in_cycle == 0){
                            echo "Leave";
                        }else {
                            
                            $day =$i-1;
                            // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>date('Y-m-d', strtotime('+'.$day.' days', strtotime($_POST['schedule_date'])))))->row_array();                                   
                            // if(empty($employee_shifts)){
                                 $shift_details = array(
                                'dept_id' => $_POST['department'],
                                'employee_id' => $value,
                                'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                                'schedule_date' => date('Y-m-d', strtotime('+'.$day.' days', strtotime($_POST['schedule_date']))),
                                'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                                'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                                'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                                'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                                'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                                'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                                'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                                'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                                'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                                'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                                'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
                                'shift_id' => $_POST['shift_id'],
                                'color' => $_POST['color'],
                                'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                                'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                                'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
                                'no_of_days_in_cycle' => $no_of_days_in_cycle,
                                'workday' => isset($workday)?$workday:0,
                                'week_days' => $week_days,                                    
                                'end_date' =>date('Y-m-d', strtotime('+'.$day.' days', strtotime($_POST['schedule_date']))),
                                'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0,
                                
                                // 'schedule_repeat' => $_POST['repeat_time'],
                                // 'tag' => $_POST['tag'],
                                // 'note' => $_POST['note'],
                                'created_by' => $this->session->userdata('user_id'),
                                'subdomain_id' => $this->session->userdata('subdomain_id'),
                                'published' => isset($_POST['publish'])?$_POST['publish']:0                           

                                );

                                 // echo "<pre>";print_r($shift_details); exit();
                                
                                $this->db->insert('shift_scheduling',$shift_details);
                                $shift_id =$this->db->insert_id();

                            // }
                        }
                                

                    }
                               
                    // else {
                        
                    //     $exist_date = $_POST['schedule_date'];
                    //     $exist_count += $exist_schedule_count;
                    // }
                          
                }else{
                    $this->db->where('employee_id',$value);
                    $this->db->where('shift_id',$_POST['shift_id']);
                    $this->db->where('schedule_date >=',date('Y-m-d',strtotime($_POST['schedule_date'])));
                    if($_POST['indefinite'] != 1 && empty($_POST['cyclic_shift'])){                            
                        $this->db->where('schedule_date <=',date('Y-m-d',strtotime($_POST['end_date'])));
                    }
                    $this->db->delete('shift_scheduling');

                    $begin = new DateTime($_POST['schedule_date']);
                    $end = new DateTime($end_schedulde_date);

                    if(!empty($_POST['indefinite'])){
                           
                        $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                    } else {
                         $end_schedulde_date= $_POST['end_date'];
                            $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($_POST['end_date'])));
                    }
                   // echo "<pre>";print_r($_POST); exit();
                    $interval = DateInterval::createFromDateString('1 day');
                    $period = new DatePeriod($begin, $interval, $end);
                     // echo $employee_shifts; exit;
                     // echo "<pre>";
                    // echo "<pre>";print_r($period); exit();
                    foreach ($period as $dt) {

                       
                        // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                       
                        // if(empty($employee_shifts)){
                             $shift_details = array(
                            'dept_id' => $_POST['department'],
                            'employee_id' => $value,
                            'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                            'schedule_date' => $dt->format("Y-m-d"),
                            'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                            'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                            'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                            'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                            'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                            'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                            'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                            'break_end' =>  !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                            'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                            'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                            'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
                            'shift_id' => $_POST['shift_id'],
                            'color' => $_POST['color'],
                            'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                            'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                            'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
                            'week_days' => $week_days,                                    
                            'created_by' => $this->session->userdata('user_id'),
                            'subdomain_id' => $this->session->userdata('subdomain_id'),
                            'published' => isset($_POST['publish'])?$_POST['publish']:0                           

                            );


                            // echo "<pre>";print_r($shift_details); exit();
                            $this->db->insert('shift_scheduling',$shift_details);
                            $shift_id =$this->db->insert_id();
                            // echo $this->db->last_query(); exit();
                        // }
                    // }else {
                        
                    //     $exist_date = $_POST['schedule_date'];
                    //     $exist_count += $exist_schedule_count;
                    // }
                    // echo "<pre>";print_r($shift_details); exit();
                    // $j++;

                    }
                }
                   
                     // echo $this->db->last_query(); exit();
                   
            }
                $data = array(
                    'module' => 'Shift_scheduling',
                    'module_field_id' => $_POST['shift_id'],
                    'user' => $value,
                    'activity' => 'New Shift Scheduled',
                    'icon' => 'fa-plus',
                    'value1' => $this->input->post('department')
                    );
                App::Log($data);
                $user_details = $this->db->get_where('users',array('id'=>$value))->row_array();
                if(!empty($user_details)){
                        $recipient[] = $user_details['email'];

                }
                        // $exist_schedule_count++;
                }

                    $subject         = "New Shift Schedule";
                $message         = '<div style="height: 7px; background-color: #535353;"></div>
                                        <div style="background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;">
                                            <div style="text-align:center; font-size:24px; font-weight:bold; color:#535353;">New Shift Scheduledt</div>
                                            <div style="border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;">
                                                <p> Hi,</p>
                                                <p>You have a New Shift Scheduled from  '.$_POST["schedule_date"].' </p>                                          
                                                <br> 
                                                
                                                &nbsp;&nbsp;  
                                                OR 
                                                <a style="text-decoration:none; margin-left:15px" href="'.$base_url.'shift_scheduling/"> 
                                                <button style="background: #CCCC00; border-radius: 5px;; cursor:pointer"> Just Login </button> 
                                                </a>
                                                <br>
                                                </big><br><br>Regards<br>The '.$this->company_name.' Team
                                            </div>
                                     </div>';       
                    foreach ($recipient as $key => $u) 
                    {
                        
                        $params['recipient'] = $u;
                        $params['subject'] = '['.$this->company_name.']'.' '.$subject;
                        $params['message'] = $message;
                        $params['attached_file'] = '';
                         // modules::run('fomailer/send_email',$params);
                    }
              
              // echo $exist_count; exit();  
            // if($exist_count == 1){
            //      $this->session->set_flashdata('tokbox_error', 'You have already scheduled this date '.$exist_date);
                
            // } elseif ($exist_count > 1) {
            //     $this->session->set_flashdata('tokbox_success', 'You have already scheduled '.$exist_count.' days');
            // }else{
                
                 $this->session->set_flashdata('tokbox_success', lang('shift_schedule_created_successfully'));
            // }
            
            redirect('shift_scheduling');
            }
        
        }else{       

            if($this->uri->segment(3) !=''){
                $employee_id = $this->uri->segment(3); 
                $this->db->select('D.deptname,D.deptid,A.fullname,U.id');
                $this->db->from('users U');
                $this->db->join('account_details A','A.user_id = U.id','LEFT');
                $this->db->join('departments D','D.deptid = U.department_id','LEFT');
                $this->db->where('U.id',$employee_id);
                $data['employee_details'] = $this->db->get()->row_array();
            }
            if($this->uri->segment(4) !=''){
                $data['schedule_date'] = date("d-m-Y", strtotime($this->uri->segment(4)));
            }
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
            $data['page'] = lang('employees');
            $data['sub_page'] = lang('shift_scheduling');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;            
            // $data['daterangepicker'] = TRUE;
            $data['form'] = TRUE;     
            $this->template
            ->set_layout('users')
            ->build('add_schedule',isset($data) ? $data : NULL);
        }
    
    }
     function view_schedule()
    {
    $this->load->module('layouts');
    $this->load->library('template');
    $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
    $data['page'] = lang('employees');
    $data['sub_page'] = lang('shift_scheduling');
    $data['datatables'] = TRUE;
    $data['form'] = TRUE;
    $data['country_code'] = TRUE;
   
    $this->template
    ->set_layout('users')
    ->build('view_schedule',isset($data) ? $data : NULL);
    }

    function edit_schedule()
    { 
        // echo "<pre>"; print_r($_POST); exit();
        
        if($_POST){
            $employees = $_POST['employee'];
                   
            
            if (count($employees) > 0) {
                     // echo "<pre>";print_r($_POST); exit();
                foreach ($employees as $key => $value) {
                         
                        // echo $this->db->last_query(); exit; 
                    $d = $_POST['week_days'];
                    $week_days = isset($_POST['week_days'])?$_POST['week_days']:'';
                    if(!empty($week_days)){
                        $week_days = implode(',',$week_days);
                    }
                    
                    $_POST['end_date'] = !empty($_POST['end_date'])?date('Y-m-d',strtotime($_POST['end_date'])):'';
                      // $end_schedulde_date= date('Y-m-d',strtotime('+'.$_POST["repeat_week"].' week', strtotime($_POST['schedule_date'])));
                    if(!empty($_POST['indefinite'])){                            
                        $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                    } else {

                        $end_schedulde_date= $_POST['end_date'];
                        $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($_POST['end_date'])));
                    }
                     
                       // echo $end_schedulde_date; exit();
                      
                    $_POST['end_date'] = !empty($_POST['end_date'])?date('Y-m-d',strtotime($_POST['end_date'])):'';
                    // $repeat_time = $_POST['repeat_time'] * 7;
                     // echo $start_date .' '.$maxDays; exit;
                    if((isset($_POST["recurring_shift"]) && !empty($_POST["recurring_shift"])) || (isset($_POST["free_shift"]) && !empty($_POST["free_shift"]))) {

                        $this->db->where('employee_id',$value);
                        $this->db->where('shift_id',$_POST['shift_id']);
                        $this->db->where('schedule_date >=',date('Y-m-d',strtotime($_POST['schedule_date'])));
                        if($_POST['indefinite'] != 1){
                        // echo 1;     exit;                        
                         $this->db->where('schedule_date <=',date('Y-m-d',strtotime($_POST['end_date'])));
                        }
                        $this->db->delete('shift_scheduling'); 
                        $begin = new DateTime($_POST['schedule_date']);
                        $end = new DateTime($end_schedulde_date);

                        $interval = DateInterval::createFromDateString('1 day');
                        $period = new DatePeriod($begin, $interval, $end);
                         // echo "<pre>";print_r($period); exit;
                        foreach ($period as $dt) {
                            if(in_array(lcfirst($dt->format("l")), $_POST['week_days'])){
                                // echo $dt->format("l Y-m-d H:i:s\n");
                                // echo "<pre>";print_r($_POST); exit;
                           
                                // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                                 // echo $employee_shifts; exit;
                                 // echo "<pre>";
                                 
                                // if(empty($employee_shifts)){
                                     $shift_details = array(
                                    'dept_id' => $_POST['department'],
                                    'employee_id' => $value,
                                    'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                                    'schedule_date' => $dt->format("Y-m-d"),
                                    'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                                    'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                                    'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                                    'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                                    'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                                    'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                                    'break_time' => $_POST['break_time'],
                                    'shift_id' => $_POST['shift_id'],
                                    'color' => $_POST['color'],
                                    'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                                    'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                                    'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                                    'week_days' => $week_days,                                    
                                    'end_date' =>$_POST['end_date'],
                                    'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0,
                                    'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                                    'break_end' => !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                                    // 'schedule_repeat' => $_POST['repeat_time'],
                                    // 'tag' => $_POST['tag'],
                                    // 'note' => $_POST['note'],
                                    'created_by' => $this->session->userdata('user_id'),
                                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                                    'published' => isset($_POST['publish'])?$_POST['publish']:0                           

                                    );

                                     //\ echo "<pre>";print_r($shift_details); exit();
                                    
                                    $this->db->insert('shift_scheduling',$shift_details);
                                    $shift_id =$this->db->insert_id();
                                // }
                                // else {
                                    
                                //     $exist_date = $_POST['schedule_date'];
                                //     $exist_count += $exist_schedule_count;
                                // }
                            }
                            
                        // echo "<pre>";print_r($shift_details); exit();
                            $k++;

                
                        }
                     
                    } else if(isset($_POST["cyclic_shift"]) && !empty($_POST["cyclic_shift"])){

                        $this->db->where('employee_id',$value);
                        $this->db->where('shift_id',$_POST['shift_id']);
                        $this->db->where('schedule_date >=',date('Y-m-d',strtotime($_POST['schedule_date'])));
                        if($_POST['indefinite'] != 1 && empty($_POST['cyclic_shift'])){
                        // echo 1;     exit;                        
                         $this->db->where('schedule_date <=',date('Y-m-d',strtotime($_POST['end_date'])));
                        }
                        $this->db->delete('shift_scheduling'); 
                        $workdays = isset($_POST['workdays'])?$_POST['workdays']:'';
                        if(!empty($workdays)){
                            $workday = count($_POST['workdays']);
                        }
                        if(isset($_POST['cyclic_shift'])){
                            $no_of_days_in_cycle = isset($_POST['no_of_days_in_cycle'])?$_POST['no_of_days_in_cycle']:0;
                        } else{
                            $no_of_days_in_cycle = 0;
                        }
                        if($_POST['indefinite'] != 1){

                        }
                        $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));                           
                        
                        for($i=1; $i<=120; $i++){
                                
                            $workdays = 5;
                            echo $i%$no_of_days_in_cycle;
                            if($i%$no_of_days_in_cycle > $workday || $i%$no_of_days_in_cycle == 0){
                                echo "Leave";
                            }else {
                                
                                $day =$i-1;
                                // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>date('Y-m-d', strtotime('+'.$day.' days', strtotime($_POST['schedule_date'])))))->row_array();                                   
                                // if(empty($employee_shifts)){
                                     $shift_details = array(
                                    'dept_id' => $_POST['department'],
                                    'employee_id' => $value,
                                    'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                                    'schedule_date' => date('Y-m-d', strtotime('+'.$day.' days', strtotime($_POST['schedule_date']))),
                                    'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                                    'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                                    'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                                    'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                                    'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                                    'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                                    'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                                    'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                                    'shift_id' => $_POST['shift_id'],
                                    'color' => $_POST['color'],
                                    'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                                    'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                                    'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
                                    'no_of_days_in_cycle' => $no_of_days_in_cycle,
                                    'workday' => isset($workday)?$workday:0,
                                    // 'week_days' => $week_days,                                    
                                    'end_date' =>date('Y-m-d', strtotime('+'.$day.' days', strtotime($_POST['schedule_date']))),
                                    'indefinite' => isset($_POST['indefinite'])?$_POST['indefinite']:0,
                                    'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                                    'break_end' => !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                                    // 'schedule_repeat' => $_POST['repeat_time'],
                                    // 'tag' => $_POST['tag'],
                                    // 'note' => $_POST['note'],
                                    'created_by' => $this->session->userdata('user_id'),
                                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                                    'published' => isset($_POST['publish'])?$_POST['publish']:0                           

                                    );

                                     // echo "<pre>";print_r($shift_details); exit();
                                   

                                    $this->db->insert('shift_scheduling',$shift_details);
                                    $shift_id =$this->db->insert_id();
                                // }
                            }   
                        }
                          
                    }
                    else{

                        $this->db->where('employee_id',$value);
                        $this->db->where('shift_id',$_POST['shift_id']);
                        $this->db->where('schedule_date >=',date('Y-m-d',strtotime($_POST['schedule_date'])));
                        if($_POST['indefinite'] != 1){
                        // echo 1;     exit;                        
                         $this->db->where('schedule_date <=',date('Y-m-d',strtotime($_POST['end_date'])));
                        }
                        $this->db->delete('shift_scheduling'); 
                        if(!empty($_POST['indefinite'])){                               
                            $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                        } else {
                            $end_schedulde_date= $_POST['end_date'];
                            $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($_POST['end_date'])));
                        }
                        $begin = new DateTime($_POST['schedule_date']);
                        $end = new DateTime($end_schedulde_date);

                        $interval = DateInterval::createFromDateString('1 day');
                        $period = new DatePeriod($begin, $interval, $end);

                        // echo pre($period);
                         // echo $employee_shifts; exit;
                         // echo "<pre>";
                        foreach ($period as $dt) {
                               
                           //  $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$value,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                            
                           // if(empty($employee_shifts)){
                                 $shift_details = array(
                                'dept_id' => $_POST['department'],
                                'employee_id' => $value,
                                'project_id' => !empty($_POST['project_id'])?$_POST['project_id']:'',
                                'schedule_date' => $dt->format("Y-m-d"),
                                'min_start_time' => !empty($_POST['min_start_time'])?date("H:i", strtotime($_POST['min_start_time'])):'',
                                'start_time' => !empty($_POST['start_time'])?date("H:i", strtotime($_POST['start_time'])):'',
                                'max_start_time' => !empty($_POST['max_start_time'])?date("H:i", strtotime($_POST['max_start_time'])):'',
                                'min_end_time' => !empty($_POST['min_end_time'])?date("H:i", strtotime($_POST['min_end_time'])):'',
                                'end_time' => !empty($_POST['end_time'])?date("H:i", strtotime($_POST['end_time'])):'',
                                'max_end_time' => !empty($_POST['max_end_time'])?date("H:i", strtotime($_POST['max_end_time'])):'',
                                'shift_id' => $_POST['shift_id'],
                                'color' => $_POST['color'],
                                'accept_extras' => isset($_POST['accept_extras'])?$_POST['accept_extras']:0,
                                'break_time' => isset($_POST['break_time'])?$_POST['break_time']:0,
                                'work_hours' => isset($_POST['work_hours'])?$_POST['work_hours']:0,
                                'free_shift' => isset($_POST['free_shift'])?$_POST['free_shift']:0,
                                'recurring_shift' => isset($_POST['recurring_shift'])?$_POST['recurring_shift']:0,
                                'cyclic_shift' => isset($_POST['cyclic_shift'])?$_POST['cyclic_shift']:0,
                                // 'week_days' => $week_days,
                                'break_start' => !empty($_POST['break_start'])?date("H:i", strtotime($_POST['break_start'])):'',
                                'break_end' => !empty($_POST['break_end'])?date("H:i", strtotime($_POST['break_end'])):'',
                                // 'schedule_repeat' => $_POST['repeat_time'],
                                // 'tag' => $_POST['tag'],
                                // 'note' => $_POST['note'],
                                'created_by' => $this->session->userdata('user_id'),
                                'subdomain_id' => $this->session->userdata('subdomain_id'),
                                'published' => isset($_POST['publish'])?$_POST['publish']:0                           

                                );

                                 // echo "<pre>";print_r($shift_details); exit();
                                
                                $this->db->insert('shift_scheduling',$shift_details);
                                 // echo $this->db->last_query(); exit();
                                $shift_id =$this->db->insert_id();
                            // }
                            // }else {
                                
                            //     $exist_date = $_POST['schedule_date'];
                            //     $exist_count += $exist_schedule_count;
                            // }
                            // 
                            // $j++;

                        }
                    }                        
                }
                $data = array(
                    'module' => 'Shift_scheduling',
                    'module_field_id' => $_POST['shift_id'],
                    'user' => $value,
                    'activity' => 'New Shift Scheduled',
                    'icon' => 'fa-plus',
                    'value1' => $cur.' '.$this->input->post('department')
                    );
                App::Log($data);
                $user_details = $this->db->get_where('users',array('id'=>$value))->row_array();
                if(!empty($user_details)){
                        $recipient[] = $user_details['email'];

                    
                }
                $subject         = "Update Shift Schedule";
                $message         = '<div style="height: 7px; background-color: #535353;"></div>
                                        <div style="background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;">
                                            <div style="text-align:center; font-size:24px; font-weight:bold; color:#535353;">Update Shift Scheduledt</div>
                                            <div style="border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;">
                                                <p> Hi,</p>
                                                <p>You have a Update Shift Scheduled from  '.$_POST["schedule_date"].' </p>                                          
                                                <br> 
                                                
                                                &nbsp;&nbsp;  
                                                OR 
                                                <a style="text-decoration:none; margin-left:15px" href="'.$base_url.'shift_scheduling/"> 
                                                <button style="background: #CCCC00; border-radius: 5px;; cursor:pointer"> Just Login </button> 
                                                </a>
                                                <br>
                                                </big><br><br>Regards<br>The '.$this->company_name.' Team
                                            </div>
                                     </div>';       
                    foreach ($recipient as $key => $u) 
                    {
                        
                        $params['recipient'] = $u;
                        $params['subject'] = '['.$this->company_name.']'.' '.$subject;
                        $params['message'] = $message;
                        $params['attached_file'] = '';
                        // modules::run('fomailer/send_email',$params);
                    }


            }
                
            $this->session->set_flashdata('tokbox_success', lang('shift_schedule_edited_successfully'));
            redirect('shift_scheduling');
        }else{
            
            if($this->uri->segment(3) !=''){
                $shift_id = $this->uri->segment(3); 
                $this->db->select('S.*,D.deptname,D.deptid,A.fullname,U.id as user_id');
                $this->db->from('shift_scheduling S');
                $this->db->join('users U','U.id = S.employee_id','LEFT');
                $this->db->join('account_details A','A.user_id = U.id','LEFT');
                $this->db->join('departments D','D.deptid = U.department_id','LEFT');
                $this->db->where('S.id',$shift_id);
                $data['employee_details'] = $this->db->get()->row_array();
            }
            if($this->uri->segment(4) !=''){
                $data['schedule_date'] = date("d-m-Y", strtotime($this->uri->segment(4)));
            }
            // $data['daterangepicker'] = TRUE;
        // echo "<pre>"; print_r($data['employee_details']); exit();
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('shift_scheduling').' - '.$this->company_name);
        $data['page'] = lang('employees');
        $data['sub_page'] = lang('shift_scheduling');
        $data['datatables'] = TRUE;
        $data['datepicker'] = TRUE;       
        $data['form'] = TRUE;
        $data['country_code'] = TRUE; 
              // echo "<pre>"; print_r($data['employee_details']); exit();
        $this->template
        ->set_layout('users')
        ->build('edit_schedule',isset($data) ? $data : NULL);
        }

        
    }

    function delete_schedule($id = NULL)
    {
        if ($this->input->post()) {

            $id = $this->input->post('id', TRUE);            

           if($_POST['delete_type'] =='single'){               
                App::delete('shift_scheduling',array('employee_id'=>$id,'schedule_date'=>$_POST['schedule_date'])); 
                $data = array(
                    'module' => 'shift_scheduling',
                    'module_field_id' => $id,
                    'user' => $this->session->userdata('user_id'),
                    'activity' => $_POST['schedule_date'].' '.lang('schedule_deleted').' '.lang('to').' '.user::displayName($id),
                    'icon' => 'fa-plus',
                    'value1' => $this->input->post('schedule_date')
                    );
                App::Log($data);
                $message = $_POST['schedule_date'].' '.lang('schedule_deleted_successfully');
                $this->session->set_flashdata('tokbox_success', $message);
            }else{
                App::delete('shift_scheduling',array('employee_id'=>$id,'schedule_date >='=>$_POST['schedule_date'])); 
                $data = array(
                    'module' => 'shift_scheduling',
                    'module_field_id' => $id,
                    'user' => $this->session->userdata('user_id'),
                    'activity' => lang('from').' '.$_POST['schedule_date'].' '.lang('schedule_deleted').' '.lang('to').' '.user::displayName($id),
                    'icon' => 'fa-plus',
                    'value1' => $this->input->post('schedule_date')
                    );
                App::Log($data);
                $message = lang('from').' '.$_POST['schedule_date'].' '.lang('schedule_deleted_successfully');
                $this->session->set_flashdata('tokbox_success', $message);
            }
            
            redirect('shift_scheduling');

        }else{
            $data['id'] = $this->uri->segment(3);
            $data['schedule_date'] = $this->uri->segment(4);
            $data['delete_type'] = $this->uri->segment(5);
             // echo  $id; exit;

            $this->load->view('modal/delete_schedule',$data);
        }
    }

    public function schedule_group()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('shift_scheduling').' - '.$this->company_name);           
        $data['page'] = lang('employees');
        $data['sub_page'] = lang('shift_scheduling');
        $data['form'] = true;
        $data['datatables'] = true;
        $data['leads_plugin'] = true;
        $data['fuelux'] = true;
        $data['list_view'] = $this->session->userdata('lead_view');
        $data['currencies'] = App::currencies();
        $data['languages'] = App::languages();
        $data['leads'] = Lead::all();
        $data['countries'] = App::countries();
        $this->template
                ->set_layout('users')
                ->build('all_schedule_group', isset($data) ? $data : null);
    }

    function add_night_hours(){
        if ($_POST) {
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $_POST['updated_date'] = date('Y-m-d H:i:s');
                $_POST['start_time'] = date("H:i", strtotime($_POST['start_time']));
                $_POST['end_time'] = date("H:i", strtotime($_POST['end_time']));
                 $this->db->where('id',$_POST['id']) -> update('night_hours',$this->input->post());
                $this->session->set_flashdata('tokbox_success', lang('night_hours_updated_Successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
                $_POST['created_date'] = date('Y-m-d H:i:s');
                $_POST['start_time'] = date("H:i", strtotime($_POST['start_time']));
                $_POST['end_time'] = date("H:i", strtotime($_POST['end_time']));

                App::save_data('night_hours',$this->input->post());
                $this->session->set_flashdata('tokbox_success', lang('night_hours_created_Successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
            
        }else{
            // $this->index();
            $this->session->set_flashdata('tokbox_error', lang('please_fill_all_required_filed'));
            // redirect($_SERVER['HTTP_REFERER']);
        }
    }



    function add_schedule_group(){
        if ($_POST) {
            App::save_data('rotary_schedule_group',$this->input->post());

            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('department_added_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('rotary_schedule_group_created'));
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            // $this->index();
            $this->load->view('modal/add_schedule_group');
        }
    }

    function edit_add_schedule_group($id = NULL){
        if ($_POST) {
            if(isset($_POST['delete_group']) AND $_POST['delete_group'] == 'on'){
                $this->db->where('id',$_POST['id']) -> delete('rotary_schedule_group');
                $this->session->set_flashdata('tokbox_error', lang('rotary_schedule_group_deleted'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->where('id',$_POST['id']) -> update('rotary_schedule_group',$this->input->post());
                $this->session->set_flashdata('tokbox_success', lang('rotary_schedule_group_updated'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $data['id'] = $id;
            $data['group_info'] = $this->db ->where(array('id'=>$id)) -> get('rotary_schedule_group') -> result();
            $this->load->view('edit_schedule_group',isset($data) ? $data : NULL);
        }
    }


    /* Dreamguys 25/02/2019 End */

}

/* End of file employees.php */
