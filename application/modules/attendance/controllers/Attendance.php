<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Attendance extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model(array( 'App', 'Attendance_model','Users'));
        /*if (!User::is_admin()) {
            $this->session->set_flashdata('message', lang('access_denied'));
            redirect('');
        }*/
        $all_routes = $this->session->userdata('all_routes');
        foreach($all_routes as $key => $route){
            if($route == 'attendance'){
                $routname = attendance;
            } 
        }
        // if(empty($routname)){
        //     $this->session->set_flashdata('message', lang('access_denied'));
        //    redirect('');
       // }
        App::module_access('menu_attendance');
        $this->load->helper(array('inflector'));
        $this->applib->set_locale();
        date_default_timezone_set($this->session->userdata('timezone'));
    }

    function index()
    {   
        if($this->tank_auth->is_logged_in()) {
          $data = array();
          if($this->input->post()){
            
            $params = $this->input->post();
            $params['subdomain_id'] = $this->session->userdata('subdomain_id');    
            $data['subdomain_id'] = $this->session->userdata('subdomain_id');      

            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
              // echo "<pre>"; print_r($params); exit;
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
            $data['username']      = $params['username'];
            $data['id_code']            = isset($params['id_code'])?$params['id_code']:"";
            $data['employee_email']     = isset($params['employee_email'])?$params['employee_email']:"";
            $data['department_id']      = isset($params['department_id'])?$params['department_id']:"";
            $data['manully_made']       = isset($params['manully_made'])?$params['manully_made']:"";
            $params['branch_id'] = $this->session->userdata('branch_id'); 

            //manager and superior login
            if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
              $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
              if($dept_id !=0){
                 $params['dept_id'] = $dept_id;
              }
            }
            // $data['current_page']       = 1;
            $attendance_list = Attendance_model::attendance_list($params); 

            // echo "<pre>"; print_r($data['manully_made']); exit;

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  
            
          } else{
            
           
            $params = array();
             $data = array();
            // $params['page'] = 1;     

            $params['subdomain_id'] = $this->session->userdata('subdomain_id');      
            $data['subdomain_id'] = $this->session->userdata('subdomain_id');      
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
           
            $data['current_page']     = $params['page'];
            $params['branch_id'] = $this->session->userdata('branch_id'); 
            //manager and superior login
            // echo $this->session->userdata('is_teamlead'); exit;
            if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
              $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
              if($dept_id !=0){
                 $params['dept_id'] = $dept_id;
              }  
            }
            $attendance_list = Attendance_model::attendance_list($params); 

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  
           
          }
          $manually_record = $this->uri->segment(3);
          if($manually_record == 'yes'){
            $data['manully_made'] ='yes';
          } 
           // echo '<pre>';print_r($data['manully_made']); exit();

          $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['sub_page']       = lang('attendance');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();
            // echo $this->tank_auth->user_role($this->tank_auth->get_user_type()); exit;

            $role_id = $this->tank_auth->get_role_id();
            $page = (($role_id==4) || ($role_id==1))?'attendance':'create_attendance';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
        }else{
         redirect('');
        }
    }

    function team_attendance()
    {
        if($this->tank_auth->is_logged_in()) {
          $data = array();
          if($this->input->post()){
            
            $params = $this->input->post();
            $params['subdomain_id'] = $this->session->userdata('subdomain_id');      
            $data['subdomain_id'] = $this->session->userdata('subdomain_id');  
            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
              // echo "<pre>"; print_r($params); exit;
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
            $data['username']      = $params['username'];
            $data['id_code']            = isset($params['id_code'])?$params['id_code']:"";
            $data['employee_email']     = isset($params['employee_email'])?$params['employee_email']:"";
            $data['department_id']      = isset($params['department_id'])?$params['department_id']:"";
            $data['manully_made']       = isset($params['manully_made'])?$params['manully_made']:"";
            $params['branch_id'] = $this->session->userdata('branch_id'); 
            //manager and superior login
            if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
            $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
            if($dept_id !=0){
               $params['dept_id'] = $dept_id;
            } 
          }
            // $data['current_page']       = 1;
            $attendance_list = Attendance_model::attendance_list($params); 

            // echo "<pre>"; print_r($data['manully_made']); exit;

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  
            
          } else{
            
           
            $params = array();
             $data = array();
            $params['subdomain_id'] = $this->session->userdata('subdomain_id');      
            $data['subdomain_id'] = $this->session->userdata('subdomain_id');  
            // $params['page'] = 1;           
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
           
            $data['current_page']     = $params['page'];

            $params['branch_id'] = $this->session->userdata('branch_id'); 
            //manager and superior login
            if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
            $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
            if($dept_id !=0){
               $params['dept_id'] = $dept_id;
            } 
          }
            $attendance_list = Attendance_model::attendance_list($params); 

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  
           
          }
          $manually_record = $this->uri->segment(3);
          if($manually_record == 'yes'){
            $data['manully_made'] ='yes';
          } 
           // echo '<pre>';print_r($data['manully_made']); exit();

          $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['sub_page']       = lang('attendance');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();

            $role_id = $this->tank_auth->get_role_id();
             // $page = (($role_id==4) || ($role_id==1))?'attendance':'create_attendance';
            $this->template
                  ->set_layout('users')
                  ->build('attendance',isset($data) ? $data : NULL);
        }else{
         redirect('');
        }
    }

    function details($user_id)
    {
        if($this->tank_auth->is_logged_in()) {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $user_id;

            $role_id = $this->tank_auth->get_role_id();
            $page = 'attendance_details';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
          }else{
           redirect('');
          }
    }

    function get_list(){
      if($_POST){
         $user_id = $_POST['user_id'];
         $date = date("Y-m-d", strtotime($_POST['date']));
         $attendance_list = Attendance_model::get_list($user_id, $date);
         $records = array();
         $length = count($attendance_list);
         $total_hours = 0;
         for($i = 0; $i < $length; ++$i) {
           $row = array();
           $row['fullname'] = $attendance_list[$i]->fullname;
           $row['punch_in_date_time'] = $attendance_list[$i]->punch_in_date_time;
           $row['punch_in_note'] = $attendance_list[$i]->punch_in_note;
           $row['punch_in_address'] = $attendance_list[$i]->in_address;
           $row['punch_out_date_time'] = $attendance_list[$i]->punch_out_date_time;
           $row['punch_out_note'] = $attendance_list[$i]->punch_out_note;
           $row['punch_out_address'] = $attendance_list[$i]->out_address;
           $row['cal_hours'] = $attendance_list[$i]->cal_hours;
           $total_hours += $attendance_list[$i]->cal_hours;

             $row['total_hours'] = '--';
             $j = $i+1;
             $user_id = !empty($attendance_list[$j]->user_id)?($attendance_list[$j]->user_id):'';
             if ((($attendance_list[$i]->user_id) !== $user_id) ||  empty($user_id)) {
               $row['total_hours'] = $total_hours;
               $total_hours = 0;
             }
           $records[] = $row;
         }
         echo json_encode($records);
         exit;
      }
    }

    public function attendance_list()
    {
      
      if($this->input->post()){
      
        $params = $this->input->post();
        $params['subdomain_id'] = $this->session->userdata('subdomain_id');   
        $month = $params['attendance_month'];
        $year  = $params['attendance_year'];
        $last_day = $year.'-'.$month.'-1';
       
        $records = array();
        $records['current_page']     = $params['page'];
        $attendance_list = Attendance_model::attendance_list($params); 

        $records['attendance_list']  =  $attendance_list[1];
        $records['total_page']       =  $attendance_list[0];
        $records['last_day']         = date('t',strtotime($last_day));  
        echo json_encode($records);
        exit;
      }
    }

    public function employee_shift_per_day()
    {
      
      if($this->input->post()){
      
        $params = $this->input->post();

        $user_id = $params['user_id'];
        $day = $params['attendance_day'];
        $month = $params['attendance_month'];
        $year  = $params['attendance_year'];
        $punch_in  = $params['punch_in'];
        $punch_out  = $params['punch_out'];
        $schedule_date = $year.'-'.$month.'-'.$day;
        $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>$schedule_date);
        $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
        if(!empty($user_schedule)){
            $total_scheduled_hour = work_hours($user_schedule['schedule_date'].' '.$user_schedule['start_time'],$user_schedule['schedule_date'].' '.$user_schedule['end_time'],$user_schedule['break_time']);

            $total_scheduled_minutes = $total_scheduled_hour;                                     
            
          } else{
            $total_scheduled_minutes = 0;
          }
          // production_hour
          if(!empty($punch_in) && !empty($punch_out)){
            $production_hour = time_difference(date('H:i',strtotime($punch_in)),date('H:i',strtotime($punch_out)));
          }
              
          // overtimes                    
           if($user_schedule['accept_extras'] == 1){
            $overtimes=($production_hour)-($total_scheduled_minutes);
            if($overtimes > 0)
            {
              $overtime=$overtimes;
            }
            else
            {
              if($production_hour >= $total_scheduled_minutes){
                  $production_hour_achived=  $production_hour_achived;
              }else{
                  $production_hour_achived=  0;
              }
              $overtime=0;
            }
          } else{

            if($production_hour >= $total_scheduled_minutes){
              $production_hour_achived=  $production_hour_achived;
            }else{
              $production_hour_achived=  0;
            }
            $overtime=0;
          }

          // later_entry_hours

          if(!empty($punch_in))
          {
             $later_entry_hours = later_entry_minutes($user_schedule['schedule_date'].' '.$user_schedule['max_start_time'],$schedule_date.' '.$punch_in);
          } else {
            $later_entry_hours = 0;
          }

          // Missing worke

          $missing_work=($total_scheduled_minutes)-($production_hour);
                              // echo $missing_work; exit;
          if($missing_work > 0)
          {
            $missing_work=$missing_work;
           
          }
          else
          {
            $missing_work=0;
            
          }
          $records = array();
          $records['schedule_date']  =  $schedule_date;
          $records['overtimes']  =  $overtime;
          $records['production_hour_achived']  =  $production_hour_achived;
          $records['later_entry_hours']  =  $later_entry_hours;
          $records['missing_work']  =  $missing_work;
        //   $user_schedule['total_scheduled_minutes'] =  $total_scheduled_minutes;
        // $records = array();
        // $attendance_list = Attendance_model::attendance_list($params); 

        // $records['total_scheduled_minutes']  =  $attendance_list[1];
          echo json_encode($records);
          exit;
        }
    }

    public function save_punch_details(){

      if($this->input->post()){


       $params = $this->input->post();
       if(!empty($params['punch_in_date_time'])){

          $strtotime = strtotime(date('Y-m-d H:i'));
          $user_id   = $params['user_id'];

          $a_year    = date('Y',$strtotime);
          $a_month   = date('m',$strtotime);
          $a_day     = date('d',$strtotime);
          $a_cin     = date('H:i',$strtotime);
          $schedule_date = $a_year.'-'.$a_month.'-'.$a_day;
          $subdomain_id       = $this->session->userdata('subdomain_id');
          $where     = array('subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
          $this->db->select('month_days,month_days_in_out');
          $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

          if(empty($record)){
            $inputs['attendance_month'] =$a_month;
            $inputs['attendance_year'] = $a_year;
            $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
            Attendance_model::attendance($user_id,$inputs);
            $this->db->select('month_days,month_days_in_out');
            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
          }
          
          if(!empty($record['month_days'])){
            $record_day = unserialize($record['month_days']);
            $month_days_in_out_record = unserialize($record['month_days_in_out']);
            // echo "<pre>";print_r($month_days_in_out_record);die;
            $a_day -=1;
            
             if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){

              $current_days = $month_days_in_out_record[$a_day];
              $total_records = count($current_days);
              $current_day = end($current_days);
              
      

              if($record_day[$a_day]['punch_in'] ==''){
                $record_day[$a_day]['punch_in'] = $a_cin;
                $record_day[$a_day]['day'] = 1;
              }
              // echo "<pre>";print_r($record_day); exit;
              $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$schedule_date.'" AND ((start_time <= "'.$a_cin.'" and end_time >="'.$a_cin.'") or (start_time >= "'.$a_cin.'")) limit 1')->row_array();
              // echo "<pre>";print_r($today_work_hour); exit;
              if($total_records == 1 && empty($current_day['punch_out'])){
                
                $current_days = array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'');
                $month_days_in_out_record[$a_day][0] = $current_days;
              }else{
                
                if(!empty($current_day['punch_in']) && !empty($current_day['punch_out']))
                {
                  $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'');
                  $month_days_in_out_record[$a_day] = $current_days;
                } 
              }
              

            }
          }
          // echo "<pre>";print_r($record_day);die;
          $this->db->where($where);
          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
       }

       $this->session->set_flashdata('tokbox_success', 'Punch in successfully saved');
       return redirect($_SERVER['HTTP_REFERER']);
       }

    }

   public function save_punch_details_out(){

       if($this->input->post()){

       $params = $this->input->post();

       if(!empty($params['punch_out_date_time'])){

          $strtotime = strtotime(date('Y-m-d H:i'));
          $user_id   = $params['user_id'];

          $a_year    = date('Y',$strtotime);
          $a_month   = date('m',$strtotime);
          $a_day     = date('d',$strtotime);
          $a_cout     = date('H:i',$strtotime);
          $subdomain_id       = $this->session->userdata('subdomain_id');
          $where     = array('subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
          $this->db->select('month_days,month_days_in_out');
          $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
         
          if(empty($record)){
            $inputs['attendance_month'] =$a_month;
            $inputs['attendance_year'] = $a_year;
            $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
            Attendance_model::attendance($user_id,$inputs);
            $this->db->select('month_days,month_days_in_out');
            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
          }
          
          if(!empty($record['month_days'])){
             
            $record_day = unserialize($record['month_days']);
            $month_days_in_out_record = unserialize($record['month_days_in_out']);
             
              $a_day -=1;
              
              $current_days = $month_days_in_out_record[$a_day];
              $total_records = count($current_days);
              $current_day = end($current_days);

          
            if(!empty($record_day[$a_day])){
                $record_day[$a_day]['punch_out'] = $a_cout;
                $record_day[$a_day]['day'] = 1;
            }
            if($total_records == 1 && empty($current_day['punch_out'])){
               
                $month_days_in_out_record[$a_day][0]['punch_out'] = $a_cout;
              }else{
                  
                if(!empty($current_day['punch_in']) && empty($current_day['punch_out']))
                {
                  
                   $current_days[$total_records-1]['punch_out'] = $a_cout;
                   $month_days_in_out_record[$a_day] = $current_days;
                } 
              }
            
          }
          
          $this->db->where($where);
          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
       }
       $this->session->set_flashdata('tokbox_success', 'Punch out successfully saved');
       // $this->session->set_flashdata('message', 'Punch out successfully saved.');
       return redirect($_SERVER['HTTP_REFERER']);
       }

    }


    public function attendance_details($user_id,$day,$month,$year)
    {
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['user_id'] = $user_id;
            $data['atten_day'] = $day;
            $data['atten_month'] = $month;
            $data['atten_year'] = $year;
             $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
             $this->db->select('month_days,month_days_in_out');
             $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            $this->load->view('modal/attendance', $data);
    }

    public function edit_attendance($user_id,$day,$month,$year,$key,$punch,$workcode=null)
    {

    
       $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['user_id'] = $user_id;
            $data['atten_day'] = $day;
            $data['atten_month'] = $month;
            $data['atten_year'] = $year;
            $data['key'] = $key;
            //punch_in or punch_out
            $data['punch'] = $punch;
            $data['workcode'] = $workcode;
             $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
             $this->db->select('month_days,month_days_in_out');
             $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            $this->load->view('modal/edit_attendance_modal', $data);
        
            
    }
    public function edit_attendance_time()
    {

      if($_POST){
           // print_r($_POST); exit();

        if(!empty($_POST['punch_time'])){
          $user_id   = $_POST['user_id'];
          $a_year    = $_POST['year'];
          $a_month   = $_POST['month'];
          $a_day     = $_POST['day'];
          $a_cin     = date("H:i", strtotime($_POST['punch_time']));
          $key       = $_POST['key'];
          $punch       = $_POST['punch'];
          $workcode       = $_POST['workcode'];
          $description       = $_POST['description'];
           // echo $strtotime; exit;
          $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
          $this->db->select('month_days,month_days_in_out');
          $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            // echo print_r($record ); exit();
          if($_POST['punch'] == 'punch_in'){   

            if(!empty($record['month_days'])){
              $record_day = unserialize($record['month_days']);
              $month_days_in_out_record = unserialize($record['month_days_in_out']);

              
               // echo print_r($record_day[$a_day] ); 
               
               // echo print_r($month_days_in_out_record[$a_day]);
               // exit; 
              
                 if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
                  $current_days = $month_days_in_out_record[$a_day];
                  $total_records = count($current_days);
                  $current_day = end($current_days);
                  $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$date.'" AND ((start_time <= "'.$a_cin.'" and end_time >="'.$a_cin.'") or (start_time >= "'.$a_cin.'")) limit 1')->row_array();
             
                  if(!empty($today_work_hour)){
                    $project_id = $today_work_hour['project_id'];
                    $scheduling_id = $today_work_hour['id'];
                  }else{
                    $project_id ='';
                    $scheduling_id ='';
                  }
                  
                  if($key == 0 && $punch == 'punch_in'){
                     $record_day[$a_day]['punch_in'] = $a_cin;
                     $record_day[$a_day]['punchin_workcode'] = $workcode;
                     $record_day[$a_day]['punch_in_description'] = $description;
                     $record_day[$a_day]['punch_in_manually_made'] = 'yes';
                     $record_day[$a_day]['scheduling_id'] = $scheduling_id;
                      $record_day[$a_day]['project_id'] = $project_id;

                  }
                  $month_days_in_out_record[$a_day][$key][$punch] =$a_cin;
                  $month_days_in_out_record[$a_day][$key]['punchin_workcode'] =$workcode;
                  $month_days_in_out_record[$a_day][$key]['punch_in_description'] =$description;
                  $month_days_in_out_record[$a_day][$key]['punch_in_manually_made'] ='yes';
                  $month_days_in_out_record[$a_day][$key]['scheduling_id'] =$scheduling_id;
                  $month_days_in_out_record[$a_day][$key]['project_id'] =$project_id;

                  
                  

                }
            }           

          } else {
            if(!empty($record['month_days'])){
              $record_day = unserialize($record['month_days']);
              $month_days_in_out_record = unserialize($record['month_days_in_out']);

              
               // echo print_r($record_day[$a_day] ); 
               
               // echo print_r($month_days_in_out_record[$a_day]);
               // exit; 
              
                 if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
                  $current_days = $month_days_in_out_record[$a_day];
                  $total_records = count($current_days);
                  $current_day = end($current_days);
                  $key_count = $key +1;
                  if($total_records == $key_count && $punch == 'punch_out'){
                     $record_day[$a_day]['punch_out'] = $a_cin;
                     $record_day[$a_day]['punchout_workcode'] = $workcode;
                     $record_day[$a_day]['punch_out_description'] = $description;
                     $record_day[$a_day]['punch_out_manually_made'] = 'yes';
                  }
                  $month_days_in_out_record[$a_day][$key][$punch] =$a_cin;
                  $month_days_in_out_record[$a_day][$key]['punchout_workcode'] =$workcode;
                  $month_days_in_out_record[$a_day][$key]['punch_out_description'] =$description;
                  $month_days_in_out_record[$a_day][$key]['punch_out_manually_made'] ='yes';

                   // echo print_r($month_days_in_out_record[$a_day]);
                // exit; 
                  

                }
            } 
          }   

          $this->db->where($where);
            $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));      

            $this->session->set_flashdata('tokbox_success', lang('attendance_edited_successfully'));
             redirect($_SERVER['HTTP_REFERER']);               
                                    
        } else {
           $this->session->set_flashdata('tokbox_error', lang('punch_time_should_not_empty'));

        }

      }             
    }
    public function add_attendance_modal($user_id,$day,$month,$year,$punch)
    {

    
       $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['user_id'] = $user_id;
            $data['atten_day'] = $day;
            $data['atten_month'] = $month;
            $data['atten_year'] = $year;
            $data['punch'] = $punch;
             $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
             $this->db->select('month_days,month_days_in_out');
             $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            $this->load->view('modal/add_attendance_modal', $data);            
    }

    public function add_attendance_time(){
      if($this->input->post()){

       $params = $this->input->post();
       // print_r($params); exit;
       if(!empty($params['punch_time'])){
         // $strtotime = strtotime(date('Y-m-d H:i'));
          $user_id   = $params['user_id'];

          $a_year    =  $params['year'];
          $a_month   =  $params['month'];
          $a_day     =  $params['day'];
          $a_cin     =  date("H:i", strtotime($params['punch_time']));
          $a_cout     =  date("H:i", strtotime($params['punch_time']));
          $workcode     =  $params['workcode'];
          $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
          $this->db->select('month_days,month_days_in_out');
          $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

        if($params['punch'] =='punch_in'){

          if(empty($record)){
            $inputs['attendance_month'] =$a_month;
            $inputs['attendance_year'] = $a_year;
            $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
            Attendance_model::attendance($user_id,$inputs);
            $this->db->select('month_days,month_days_in_out');
            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
          }

          
          if(!empty($record['month_days'])){
            $record_day = unserialize($record['month_days']);
            $month_days_in_out_record = unserialize($record['month_days_in_out']);

            
            
             if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
              $current_days = $month_days_in_out_record[$a_day];
              $total_records = count($current_days);
              $current_day = end($current_days);
              $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$date.'" AND ((start_time <= "'.$a_cin.'" and end_time >="'.$a_cin.'") or (start_time >= "'.$a_cin.'")) limit 1')->row_array();
             
              if(!empty($today_work_hour)){
                $project_id = $today_work_hour['project_id'];
                $scheduling_id = $today_work_hour['id'];
              }else{
                $project_id ='';
                $scheduling_id ='';
              }
      

              if($record_day[$a_day]['punch_in'] ==''){
                $record_day[$a_day]['punch_in'] = $a_cin;
                $record_day[$a_day]['punchin_workcode'] = $workcode;
                $record_day[$a_day]['punch_in_manually_made'] = 'yes';
                $record_day[$a_day]['day'] = 1;
                $record_day[$a_day]['scheduling_id'] = $scheduling_id;
                $record_day[$a_day]['project_id'] = $project_id;
              }
              if($total_records == 1 && empty($current_day['punch_out'])){
                
                $current_days = array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','punchin_workcode'=>$workcode,'punch_in_manually_made'=>'yes','scheduling_id'=>$scheduling_id,'project_id'=>$project_id);
                $month_days_in_out_record[$a_day][0] = $current_days;
              }else{
                
                if(!empty($current_day['punch_in']) && !empty($current_day['punch_out']))
                {
                  $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','punchin_workcode'=>$workcode,'punch_in_manually_made'=>'yes','scheduling_id'=>$scheduling_id,'project_id'=>$project_id);
                  $month_days_in_out_record[$a_day] = $current_days;
                } 
              }
              

            }
          }
          
         

          $this->db->where($where);
          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
          $this->session->set_flashdata('tokbox_success', lang('attendance_added_successfully'));
        }
         if($params['punch'] =='punch_out'){
          if(empty($record)){
            $inputs['attendance_month'] =$a_month;
            $inputs['attendance_year'] = $a_year;
            $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
            Attendance_model::attendance($user_id,$inputs);
            $this->db->select('month_days,month_days_in_out');
            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
          }
          
          if(!empty($record['month_days'])){
             // $a_dayss -=1;
            $production_hour=0;
           if(!empty($record['month_days_in_out'])){

             $month_days_in_outss =  unserialize($record['month_days_in_out']);
     // echo "<pre>";print_r($month_days_in_outss); exit;
                               
              foreach ($month_days_in_outss[$a_day] as $punch_detailss) 
              {

                  if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
                  {
                                        
                       $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
                       // echo $production_hour; exit;

                        
                  }
              }
            }
             
            $record_day = unserialize($record['month_days']);
            $month_days_in_out_record = unserialize($record['month_days_in_out']);
             
              // $a_day -=1;
              
              $current_days = $month_days_in_out_record[$a_day];
              $total_records = count($current_days);
              $current_day = end($current_days);

          
            if(!empty($record_day[$a_day])){
                $record_day[$a_day]['punch_out'] = $a_cout;
                $record_day[$a_day]['production'] = $production_hour;
                $record_day[$a_day]['punchout_workcode'] = $workcode;
                $record_day[$a_day]['punch_out_manually_made'] = 'yes';
                $record_day[$a_day]['day'] = 1;
            }
            if($total_records == 1 && empty($current_day['punch_out'])){
               
                $month_days_in_out_record[$a_day][0]['punch_out'] = $a_cout;
                $month_days_in_out_record[$a_day][0]['punchout_workcode'] = $workcode;
                $month_days_in_out_record[$a_day][0]['punch_out_manually_made'] = 'yes';
                $month_days_in_out_record[$a_day][0]['production'] = $production_hour;
              }else{
                  
                if(!empty($current_day['punch_in']) && empty($current_day['punch_out']))
                {
                  
                   $current_days[$total_records-1]['punch_out'] = $a_cout;
                   $current_days[$total_records-1]['punchout_workcode'] = $workcode;
                   $current_days[$total_records-1]['punch_out_manually_made'] = 'yes';
                   $current_days[$total_records-1]['production'] = $production_hour;
                   $month_days_in_out_record[$a_day] = $current_days;
                } 
              }
            
          }
          

             // echo print_r($current_days)."<pre>";print_r($month_days_in_out_record); exit;

          $this->db->where($where);
          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
        }
       } else{
          $this->session->set_flashdata('tokbox_success', 'Something went wrong');
       }    
        redirect($_SERVER['HTTP_REFERER']); 
       }
    }
    public function update_day_status(){
    // echo "<pre>";print_r($_POST); exit;
      $user_id   = $_POST['user_id'];
      $a_year    = $_POST['year'];
      $a_month   = $_POST['month'];
      $a_day     = $_POST['day'];
      $day_status     = $_POST['day_status'];
      $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
      $this->db->select('month_days,month_days_in_out');
      $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
         
      if(!empty($record['month_days'])){
        $record_day = unserialize($record['month_days']);
        $a_day -=1;
        if(!empty($record_day[$a_day])){
             
          $record_day[$a_day]['day_status'] = $day_status;
          $record_day[$a_day]['superior_id'] = $this->session->userdata('user_id');

          $this->db->where($where);
          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day)));
          $department_id= $this->tank_auth->get_department($user_id);

          $employees = $this->db->get_where('users',array('department_id'=> $department_id,'activated'=>1,'banned'=>0))->result();
          foreach ($employees as $employee) {
            if($this->tank_auth->user_role($employee->user_type) == 'manager'){
              $data = array(
                'module' => 'attendance/manager_dashboard',
                'module_field_id' => $user_id,
                'user' => $employee->id,
                'activity' => lang('attendance_closing_for').' '.ucfirst(User::displayName($user_id)),
                'icon' => 'fa-edit',
                'value1' => User::displayName($user_id),
                'value2' => '',
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                );
            App::Log($data);
            }
          }
          

          $this->session->set_flashdata('tokbox_success', lang('day_status_updated_successfully'));
          redirect($_SERVER['HTTP_REFERER']);           
        }
      }          
    }

    public function update_day_closed(){
    // echo "<pre>";print_r($_POST); exit;
      $user_id   = $_POST['user_id'];
      $a_year    = $_POST['year'];
      $a_month   = $_POST['month'];
      $a_day     = $_POST['day'];
      $day     = $_POST['day'];
      $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
      $this->db->select('month_days,month_days_in_out');
      $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
         
      if(!empty($record['month_days'])){
        $record_day = unserialize($record['month_days']);
        $a_day -=1;
        if(!empty($record_day[$a_day])){             
          
          $record_day[$a_day]['closed_status'] = 'yes';

          $this->db->where($where);
          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day)));

          //notification    
          $page = (($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') || ($role_id==1))?'attendance':'attendance/team_attendance';
          if($record_day[$a_day]['superior_id'] !=''){
              $data = array(
                'module' => $page,
                'module_field_id' => $user_id,
                'user' => $record_day[$a_day]['superior_id'],
                'activity' => $day.'/'.$a_month.'/'.$a_year.' '.ucfirst(User::displayName($user_id)).' '.lang('attendance_closed').' by '.ucfirst(User::displayName($this->session->userdata('user_id'))),
                'icon' => 'fa-edit',
                'value1' => User::displayName($user_id),
                'value2' => '',
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                );
            App::Log($data);

          }else {
             $department_id= $this->tank_auth->get_department($user_id);

            $employees = $this->db->get_where('users',array('department_id'=> $department_id,'activated'=>1,'banned'=>0))->result();
            foreach ($employees as $employee) {
              if($this->tank_auth->user_role($employee->user_type) == 'supervisor'){
                $data = array(
                  'module' => 'attendance/team_attendance',
                  'module_field_id' => $user_id,
                  'user' => $employee->id,
                  'activity' => $a_day.'/'.$a_month.'/'.$a_year.' '.ucfirst(User::displayName($user_id)).' '.lang('attendance_closed').' by '.ucfirst(User::displayName($this->session->userdata('user_id'))),
                  'icon' => 'fa-edit',
                  'value1' => User::displayName($user_id),
                  'value2' => '',
                  'subdomain_id' =>$this->session->userdata('subdomain_id'),
                  );
              App::Log($data);
              }
            }
          }

         
          

          $this->session->set_flashdata('tokbox_success', lang('day_closed_successfully'));
          redirect($_SERVER['HTTP_REFERER']);           
        }
      }          
    }

    function attendance_records()
    {
        if($this->tank_auth->is_logged_in()) {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['sub_page']       = lang('attendance');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();

            $role_id = $this->tank_auth->get_role_id();
            $page = (($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') || ($role_id==1) || ($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'))?'attendance_records':'create_attendance';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
          }else{
           redirect('');
          }
    }
    function superior_dashboard()
    {
        if($this->tank_auth->is_logged_in()) {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['sub_page']       = lang('attendance');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['role']       = $this->tank_auth->get_role_id();
            $data['userid']    = $this->tank_auth->get_user_id();

            $role_id = $this->tank_auth->get_role_id();
            $page = (($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor') || ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'))?'superior_dashboard':'attendance';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
          }else{
           redirect('');
          }
    }

     function manager_dashboard()
    {
        if($this->tank_auth->is_logged_in()) {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['sub_page']       = lang('attendance');
            $data['datatables'] = TRUE;
            $data['datepicker'] = TRUE;    
            $data['role']       = $this->tank_auth->get_role_id();
            $data['userid']    = $this->tank_auth->get_user_id();

            $role_id = $this->tank_auth->get_role_id();
            $page = (($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'manager') || ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'))?'manager_dashboard':'';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
          }else{
           redirect('');
          }
    }
    public function data_import(){
   
       

      if(file_exists($_FILES['data_import']['tmp_name']) || is_uploaded_file($_FILES['data_import']['tmp_name'])) {
       // echo print_r($_FILES); exit;
        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);
    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {

            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error);
            redirect('attendance');
        }
// //if successfully uploaded the file 
        else
        {

            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $punch_details = file($upload_data['full_path']);
            // $punch_details = file('http://localhost/ramiro_hrms/upload/dennis_puch_11_03_2020.DAT');

           $exist_date = array();
           $exist_user = array();
            foreach ($punch_details as $punch_detail) {
                $punchData = preg_split('/\s+/', $punch_detail);
                $users_by_id_code = $this->db->get_where('users',array('id_code'=>$punchData[1],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); 
                // echo print_r($users_by_id_code); exit;
                if(!empty($users_by_id_code)){
                  $params['user_id'] = $users_by_id_code['id'];
                  $punch_date_time = $punchData[2].' '.$punchData[3];
                  $params['punch_in_date_time'] = date('Y-m-d H:i',strtotime($punch_date_time));
                  $puchdate  = strtotime($params['punch_in_date_time']);
                  $puch_date  = date('d-m-Y',$puchdate);
                  $punch_dayss     = date('d',$puchdate);
                  $punch_month     = date('m',$puchdate);
                  $punch_year     = date('Y',$puchdate);

                  $punch_where     = array('user_id'=>$params['user_id'],'a_month'=>$punch_month,'a_year'=>$punch_year);
                  $this->db->select('month_days,month_days_in_out');
                  $att_record  = $this->db->get_where('dgt_attendance_details',$punch_where)->row_array();                       
                   if(!empty($att_record['month_days'])){
                    $record_days = unserialize($att_record['month_days']);
                    $month_days_in_out_records = unserialize($att_record['month_days_in_out']);

                    $punch_dayss -=1;
                     // echo print_r($record_day[$a_day] ); 
                     
                    
                    
                     if(!empty($record_days[$punch_dayss]) && !empty($month_days_in_out_records[$punch_dayss])){              

                      if($record_days[$punch_dayss]['punch_in'] !=''){
                     //     echo print_r($record_days[$punch_dayss]);
                     // exit; 
                        $exist_date[] = $puch_date;
                        $exist_user[] = $params['user_id'];
                        

                      }else{
                          $not_exist_user[] = $params['user_id'];
                           $not_exist_date[] = $puch_date;
                      }                           
                    }
                  }

                }
            }
                      //  echo "<pre>";print_r(array_unique($not_exist_user)); 
                      //  echo "<pre>";print_r(array_unique($exist_user)); 
                      //  echo "<pre>";print_r(array_unique($not_exist_date)); 
                      // echo "<pre>";print_r(array_unique($exist_date)); exit;
              $today_work_hour = array();
              $log_msg = '';
              $n = 0;
              foreach ($punch_details as $punch_detail) {
                $n++;
                # code...
                $punchData = preg_split('/\s+/', $punch_detail);
                // $user_id = $punchData[1];
                // $punchDate = $punchData[2];
                // $punchtime = $punchData[3];
                //  echo "<pre>"; print_r($punchData); exit;
                  
                  $users_by_id_code = $this->db->get_where('users',array('id_code'=>$punchData[1],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); 
                  // echo print_r($users_by_id_code); exit;
                  if(!empty($users_by_id_code)){
                  $params['user_id'] = $users_by_id_code['id'];
                  $punch_date_time = $punchData[2].' '.$punchData[3];
                  $date_timeam = str_replace('AM', '', $punch_in_date_time);
                  $date_time = str_replace('PM', '', $date_timeam);
                  $params['deviceid'] = $punchData[4];
                  $params['status'] = $punchData[5];
                  $params['verify_code'] = $punchData[6];
                  $params['workcode'] = $punchData[7];
                  $params['punch_in_date_time'] = date('Y-m-d H:i',strtotime($punch_date_time));
                  $params['punch_out_date_time'] = date('Y-m-d H:i',strtotime($punch_date_time));
                  $puchdate  = strtotime($params['punch_in_date_time']);
                  $puch_date  = date('d-m-Y',$puchdate);
                 
                   // echo "<pre>";print_r(array_unique($exist_date)); exit;
                 
                 
                  if (in_array($puch_date, array_unique($exist_date)) && in_array($params['user_id'], array_unique($exist_user))){
                      // echo 'suc'; 
                  }else{
// echo 'fal'; exit;
                    $attendance_device = array(
                        'user_id' =>  $params['user_id'],
                        'id_code' => $punchData[1],
                        'date' => $punchData[2],
                        'time' => $punchData[3],
                        'incident_id' => $punchData[7],
                        'device_record' => $punchData[4],
                        'edited_by' => $this->session->userdata('user_id'),
                        'edited_date' => date('Y-m-d H:i:s')

                        );
                      // echo "<pre>";print_r($shift_details); exit();
                    $this->db->insert('attendance_device',$attendance_device);
                       // echo $this->db->last_query(); exit;
                            
                                                   
                  $user_id = $params['user_id'];
                  ${"user" . $user_id} = $params['user_id'];
                  ${"punch_in_date_time_" . $user_id} = $punch_date_time;

                  if(${"punch_" . $user_id} == ""){
                      ${"punch_" . $user_id} = "IN";
                  }

                  
                  ${"punch_in_date_" . $user_id} = $punch_date_time;
                  ${"punch_in_date_" . $user_id} = str_replace('PM', '', ${"punch_in_date_" . $user_id});
                  ${"punch_in_date_" . $user_id} = date("Y-m-d", strtotime(${"punch_in_date_" . $user_id}));

                  if(${"user" . $user_id} == ${"lastuser" . $user_id}) {
                    //if(${"last_punch_in_date_" . $user_id} == ${"punch_in_date_" . $user_id}) {
                    if(${"punch_" . $user_id} == "IN"){
                      ${"punch_" . $user_id} = "OUT";
                    }else{
                      ${"punch_" . $user_id} = "IN";
                    }
                    //}else{
                      //${"punch_" . $user_id} = "IN";
                   // }
                  }
                  ${"last_punch_in_date_" . $user_id} = ${"punch_in_date_" . $user_id};
                  

                  ${"lastuser" . $user_id} = $params['user_id'];
                  // if(${"punch_" . $user_id} == "IN"){ 
                  //   echo 'punch_in - '.$params['punch_in_date_time'];
                  // }else{
                  //   echo '  punchout - '.$params['punch_out_date_time'];
                  // }
                   if(${"punch_" . $user_id} == "IN"){
                      
                       // echo 'punch_in - '.$params['punch_in_date_time'];
                      // echo "<pre>"; print_r($params); exit;

                      if($params['user_id'] != '' && $params['punch_in_date_time'] != '')
                      {                  
                          
                          $result = $this->db->get_where('users',array('id'=>$user_id))->num_rows();      
                          // $result_email = $this->db->get_where('users',array('email'=>$email))->result_array();      
                          // echo "<pre>";  count($result_email); exit;
                          if($result != 0){
                              // echo "sdfsd"; exit;
                              // if(count($result_email) == 0){
                                  // echo "hi"; exit;
                                  // $params = $this->input->post();
                                 if(!empty($params['punch_in_date_time'])){

                                    $strtotime = strtotime($params['punch_in_date_time']);
                                    $user_id   = $params['user_id'];
                                    $date    =  date('Y-m-d',$strtotime);
                                    $a_year    = date('Y',$strtotime);
                                    $a_month   = date('m',$strtotime);
                                    $a_day     = date('d',$strtotime);
                                    $a_cin     = date('H:i',$strtotime);
                                    $subdomain_id       = $this->session->userdata('subdomain_id');
                                    $where     = array('subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                                    $this->db->select('month_days,month_days_in_out');
                                    $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

                                    if(empty($record)){
                                      $inputs['attendance_month'] =$a_month;
                                      $inputs['attendance_year'] = $a_year;
                                      $inputs['deviceid'] = $params['deviceid'];
                                      $inputs['status'] = $params['status'];
                                      $inputs['verify_code'] = $params['verify_code'];
                                      $inputs['workcode'] = $params['workcode'];
                                      $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
                                      Attendance_model::attendance($user_id,$inputs);
                                      $this->db->select('month_days,month_days_in_out');
                                      $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                                    }

                                    // if(!empty($record['month_days'])){
                                    //   $record_day = unserialize($record['month_days']);
                                    //   $month_days_in_out_record = unserialize($record['month_days_in_out']);

                                    //                                        // echo print_r($record_day[$a_day] ); 
                                       
                                    //    // echo print_r($month_days_in_out_record[$a_day]);
                                    //    // exit; 
                                      
                                       
                                    // }
                                   

                            // $datetime = new DateTime();
                            // $today= $datetime->format('Y-m-d');
                            // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$params['user_id'],'schedule_date'=>$date))->row_array();
                            //  echo $this->db->last_query();
                            // echo'<pre>'; print_r($employee_shifts); exit;

                            // $user_details = $this->db->get_where('users',array('id'=>$params['user_id']))->row_array();
                            // $employee_details = $this->db->get_where('account_details',array('user_id'=>$params['user_id']))->row_array();
                           
                           //     if(!empty($employee_shifts)){
                           //           $is_automatic =  $this->db->get_where('shifts',array('id'=>$employee_shifts['shift_id']))->row_array();

                           //            if($is_automatic['group_id'] !=0){
                                        
                           //               if($record_day[$a_day-1]['punch_in'] ==''){
                                          
                           //                 $this->db->delete('shift_scheduling',array('employee_id'=>$params['user_id'],'schedule_date'=>$date));
                                            
                           //                 $today_shifts = $this->db->query('select * from dgt_shifts where group_id ="'.$is_automatic['group_id'].'" ORDER BY abs(UNIX_TIMESTAMP(CONCAT(CURDATE(), " ",  "'.$a_cin.'")) - UNIX_TIMESTAMP(CONCAT(CURDATE(), " ",  start_time))) limit 1')->row_array();

                           //                 // echo $this->db->last_query();
                           //                 //  echo'<pre>'; print_r($today_shifts); exit;
                           //                 // }
                           //                if(!empty($today_shifts)){
                                      
                           //                              $shift_details = array(
                           //                              'dept_id' =>  $user_details['department_id'],
                           //                              'employee_id' => $params['user_id'],
                           //                              'schedule_date' => $date,
                           //                              'min_start_time' => $today_shifts['min_start_time'],
                           //                              'start_time' => $today_shifts['start_time'],
                           //                              'max_start_time' => $today_shifts['max_start_time'],
                           //                              'min_end_time' => $today_shifts['min_end_time'],
                           //                              'end_time' => $today_shifts['end_time'],
                           //                              'max_end_time' => $today_shifts['max_end_time'],
                           //                              'break_time' => $today_shifts['break_time'],
                           //                              'shift_id' => $today_shifts['id'],
                           //                              'accept_extras' => 1,
                           //                              // 'break_start' => date("H:i", strtotime($_POST['break_start'])),
                           //                              // 'break_end' => date("H:i", strtotime($_POST['break_end'])),
                           //                              // 'schedule_repeat' => $_POST['repeat_time'],
                           //                              'color' => '#1eb53a',
                           //                              'end_date' => $date,
                           //                              'created_by' => $today_shifts['created_by'],
                           //                              'subdomain_id' => $this->session->userdata('subdomain_id'),
                           //                              'published' => $today_shifts['published']

                           //                              );
                           //                            // echo "<pre>";print_r($shift_details); exit();
                           //                          $this->db->insert('shift_scheduling',$shift_details);
                           //                              // echo $this->db->last_query(); exit;
                            
                           //                          $shift_id =$this->db->insert_id();
                           //            }
                           //       }
                           //   }
                           // }

                            if(!empty($record['month_days'])){
                                      $record_day = unserialize($record['month_days']);
                                      $month_days_in_out_record = unserialize($record['month_days_in_out']);

                                      $a_day -=1;
                                       // echo print_r($record_day[$a_day] ); 
                                       
                                       // echo print_r($month_days_in_out_record[$a_day]);
                                       // exit; 
                                      
                                       if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
                                        $current_days = $month_days_in_out_record[$a_day];
                                        $total_records = count($current_days);
                                        $current_day = end($current_days);
                                        
                                         $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$date.'" AND ((start_time <= "'.$a_cin.'" and end_time >="'.$a_cin.'") or (start_time >= "'.$a_cin.'")) limit 1')->row_array();
             
                                        if(!empty($today_work_hour)){
                                          $project_id = $today_work_hour['project_id'];
                                          $scheduling_id = $today_work_hour['id'];
                                        }else{
                                          $project_id ='';
                                          $scheduling_id ='';
                                        }

                                        if($record_day[$a_day]['punch_in'] ==''){
                                          $record_day[$a_day]['punch_in'] = $a_cin;
                                          $record_day[$a_day]['punchin_workcode'] = $params['workcode'];
                                          $record_day[$a_day]['day'] = 1;
                                          $record_day[$a_day]['scheduling_id'] = $scheduling_id;
                                          $record_day[$a_day]['project_id'] = $project_id;
                                        }


                                        if($total_records == 1 && empty($current_day['punch_out'])){
                                          
                                          $current_days = array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'punchin_workcode'=>$params['workcode'],'scheduling_id'=>$scheduling_id,'project_id'=>$project_id);
                                          $month_days_in_out_record[$a_day][0] = $current_days;
                                        }else{
                                          
                                          if(!empty($current_day['punch_in']) && !empty($current_day['punch_out']))
                                          {
                                            $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'punchin_workcode'=>$params['workcode'],'scheduling_id'=>$scheduling_id,'project_id'=>$project_id);
                                            $month_days_in_out_record[$a_day] = $current_days;
                                          } 
                                        }
                                        

                                      }
                                    }

                                    $this->db->where($where);
                                    $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record),'deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'workcode'=>$params['workcode']));

                                      $data = array(
                                        'module' => 'employees',
                                        'module_field_id' => $params['user_id'],
                                        'user' => $this->session->userdata('user_id'),
                                        'activity' => 'Attendance details updated',
                                        'icon' => 'fa-plus',
                                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                          // 'value1' => $cur.' '.$this->input->post('shift_name')
                                          );
                                        App::Log($data);
                                        // print_r($data).'<br/>';
                                        $log_msg .= $n.'. Attendance details imported.'.PHP_EOL;
                                 }

                                
                          }else{
                          $data = array(
                            'module' => 'employees',
                            'module_field_id' => $params['user_id'],
                            'user' => $this->session->userdata('user_id'),
                            'activity' => 'User id not found',
                            'icon' => 'fa-plus',
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                              // 'value1' => $cur.' '.$this->input->post('shift_name')
                              );
                          App::Log($data);
                          // print_r($data).'<br/>';
                          $log_msg .= $n.'. User id not found.'.PHP_EOL;
                          $this->session->set_flashdata('tokbox_error', lang('user_id_not_found'));
                        }
                      }else{
                        $data = array(
                            'module' => 'employees',
                            'module_field_id' => $params['user_id'],
                            'user' => $this->session->userdata('user_id'),
                            'activity' => 'User id or Date is Missing',
                            'icon' => 'fa-plus',
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                              // 'value1' => $cur.' '.$this->input->post('shift_name')
                              );
                          App::Log($data);
                          // print_r($data).'<br/>';
                          $log_msg .= $n.'. User id or Date is Missing.'.PHP_EOL;
                        $this->session->set_flashdata('tokbox_error', lang('user_id_or_date_is_missing'));
                      } 
                    }else{
                      // echo '  punchout - '.$params['punch_out_date_time'];
                       if($params['user_id'] != '' && $params['punch_out_date_time'] != '')
                      {                  
                          
                          $result = $this->db->get_where('users',array('id'=>$user_id))->num_rows();      
                          // $result_email = $this->db->get_where('users',array('email'=>$email))->result_array();      
                          // echo "<pre>";  count($result_email); exit;
                        if($result != 0){
                          if(!empty($params['punch_out_date_time'])){

                            $strtotime = strtotime($params['punch_out_date_time']);
                            $user_id   = $params['user_id'];

                            $a_year    = date('Y',$strtotime);
                            $a_month   = date('m',$strtotime);
                            $a_day     = date('d',$strtotime);
                            $a_dayss     = date('d',$strtotime);
                            $a_cout     = date('H:i',$strtotime);
                            // echo $a_cout; exit;
                            $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                            $this->db->select('month_days,month_days_in_out');
                            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                           
                            
                           
                            

                            if(empty($record)){
                              $inputs['attendance_month'] =$a_month;
                              $inputs['attendance_year'] = $a_year;
                              $inputs['deviceid'] = $params['deviceid'];
                              $inputs['status'] = $params['status'];
                              $inputs['verify_code'] = $params['verify_code'];
                              $inputs['workcode'] = $params['workcode'];
                              $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
                              Attendance_model::attendance($user_id,$inputs);
                              $this->db->select('month_days,month_days_in_out');
                              $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                            }
                            
                            if(!empty($record['month_days'])){
                               $a_dayss -=1;
                              $production_hour=0;
                             if(!empty($record['month_days_in_out'])){

                               $month_days_in_outss =  unserialize($record['month_days_in_out']);
                       // echo "<pre>";print_r($month_days_in_outss); exit;
                                                 
                                foreach ($month_days_in_outss[$a_dayss] as $punch_detailss) 
                                {

                                    if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
                                    {
                                                          
                                         $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
                                         // echo $production_hour; exit;

                                          
                                    }
                                }
                              }
                               
                              $record_day = unserialize($record['month_days']);
                              $month_days_in_out_record = unserialize($record['month_days_in_out']);
                               
                                $a_day -=1;
                                
                                $current_days = $month_days_in_out_record[$a_day];
                                $total_records = count($current_days);
                                $current_day = end($current_days);

                            
                              if(!empty($record_day[$a_day])){
                                  $record_day[$a_day]['punch_out'] = $a_cout;
                                  $record_day[$a_day]['production'] = $production_hour;
                                  $record_day[$a_day]['day'] = 1;
                                  $record_day[$a_day]['punchout_workcode'] = $params['workcode'];
                              }
                              if($total_records == 1 && empty($current_day['punch_out'])){
                                  $month_days_in_out_record[$a_day][0]['punch_out'] = $a_cout;
                                  $month_days_in_out_record[$a_day][0]['production'] = $production_hour;
                                  $month_days_in_out_record[$a_day][0]['deviceid'] = $params['deviceid'];
                                  $month_days_in_out_record[$a_day][0]['status'] = $params['status'];
                                  $month_days_in_out_record[$a_day][0]['verify_code'] = $params['verify_code'];
                                  $month_days_in_out_record[$a_day][0]['punchout_workcode'] = $params['workcode'];
                                }else{
                                    
                                  if(!empty($current_day['punch_in']) && empty($current_day['punch_out']))
                                  {
                                    
                                     $current_days[$total_records-1]['punch_out'] = $a_cout;
                                     $current_days[$total_records-1]['production'] = $production_hour;
                                     $current_days[$total_records-1]['deviceid'] = $params['deviceid'];
                                     $current_days[$total_records-1]['status'] = $params['status'];
                                     $current_days[$total_records-1]['verify_code'] = $params['verify_code'];
                                     $current_days[$total_records-1]['punchout_workcode'] = $params['workcode'];
                                     $month_days_in_out_record[$a_day] = $current_days;
                                  } 
                                }
                              
                            }
                            

                            //     echo print_r($current_days)."<pre>";print_r($month_days_in_out_record); 
                            // echo $a_cout;exit;

                            $this->db->where($where);
                            $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record),'deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'workcode'=>$params['workcode']));

                            $data = array(
                            'module' => 'employees',
                            'module_field_id' => $params['user_id'],
                            'user' => $this->session->userdata('user_id'),
                            'activity' => 'Attendance details updated',
                            'icon' => 'fa-plus',
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                              // 'value1' => $cur.' '.$this->input->post('shift_name')
                              );
                            App::Log($data);
                            // print_r($data).'<br/>';
                            $log_msg .= $n.'. Attendance details imported.'.PHP_EOL;
                         }
                         

                        }else{
                            $data = array(
                            'module' => 'employees',
                            'module_field_id' => $params['user_id'],
                            'user' => $this->session->userdata('user_id'),
                            'activity' => 'User id not found',
                            'icon' => 'fa-plus',
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                              // 'value1' => $cur.' '.$this->input->post('shift_name')
                              );
                          App::Log($data);
                          // print_r($data).'<br/>';
                          $log_msg .= $n.'. User id not found.'.PHP_EOL;
                          $this->session->set_flashdata('tokbox_error', lang('user_id_not_found'));
                        }
                      }else{
                          $data = array(
                            'module' => 'employees',
                            'module_field_id' => $params['user_id'],
                            'user' => $this->session->userdata('user_id'),
                            'activity' => 'User id or Date is Missing',
                            'icon' => 'fa-plus',
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                              // 'value1' => $cur.' '.$this->input->post('shift_name')
                              );
                          App::Log($data);
                          // print_r($data).'<br/>';
                          $log_msg .= $n.'. User id or Date is Missing.'.PHP_EOL;
                         $this->session->set_flashdata('tokbox_error', lang('user_id_or_date_is_missing'));
                      }

                  }
               
                }
                // else{
                //   // $this->session->set_flashdata('tokbox_error', $puch_date.' '.lang('already_had_records'));
                // }
                // exit;
               } else {
                // $this->session->set_flashdata('tokbox_error', $punchData[1].' '.lang('this_id_code_is_wrong'));
               }


            }

             // exit;
            
        // }
            
            $dates = array_unique($exist_date);
             // echo "<pre>"; print_r($exist_date); exit;
            $more_days = count($dates) -1;
            if(count($dates) == 1){              // echo '1'; exit;
                  $data = array(
                  'module' => 'employees',
                  'module_field_id' => $params['user_id'],
                  'user' => $this->session->userdata('user_id'),
                  'activity' => $dates[0].' '.lang('already_had_records'),
                  'icon' => 'fa-plus',
                  'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                    );
                App::Log($data);
                // print_r($data).'<br/>';
                $log_msg .= $n.'. '.$dates[0].' '.lang('already_had_records').PHP_EOL;
                 $this->session->set_flashdata('tokbox_success', $dates[0].' '.lang('already_had_records'));
                
            } elseif (count($dates) > 1) {
                $data = array(
                  'module' => 'employees',
                  'module_field_id' => $params['user_id'],
                  'user' => $this->session->userdata('user_id'),
                  'activity' => $dates[0].' & '.$more_days .' '.lang('more_days_already_had_records'),
                  'icon' => 'fa-plus',
                  'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                    );
                App::Log($data);
                // print_r($data).'<br/>';
                $log_msg .= $n.'. '.$dates[0].' & '.$more_days .' '.lang('more_days_already_had_records').PHP_EOL;
                $this->session->set_flashdata('tokbox_success', $dates[0].' & '.$more_days .' '.lang('more_days_already_had_records'));
            }else{
                
                 $this->session->set_flashdata('tokbox_success', lang('attendance_import_successfully'));
                 
            }
             if($log_msg !='')
              {
                  $file_names = 'attendence_log_msg.txt';
                  $file_path = 'assets/uploads/'.$file_names;
                  $handle = fopen($file_path, "w");
                  fwrite($handle, $log_msg);
                  fclose($handle);

                  $this->_log_email($file_path);

                  // $this->load->helper('download');
                  // ob_end_clean();
                  // force_download($file_names, file_get_contents($file_path));
              }
            redirect($_SERVER['HTTP_REFERER']);
        // $this->session->set_flashdata('tokbox_success', lang('attendance_import_successfully'));
           

        }
      }else{
        $this->session->set_flashdata('tokbox_error', lang('please_import_data'));
                redirect($_SERVER['HTTP_REFERER']);

      }
    }

    function _log_email($file_path){

      $general_settings = $this->db->get_where('subdomin_general_settings',array('user_id'=>$this->session->userdata('user_id'),'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
      $general = unserialize($general_settings['general_settings']);

      $company_name = $general['company_name']?$general['company_name']:config_item('company_name');
      $company_email = $general['company_email']?$general['company_email']:config_item('company_email');
      $company_import_email = $general['company_import_email']?$general['company_import_email']:$company_email;

        $message = App::email_template('email_log','template_body');
        $subject = App::email_template('email_log','subject');

        $logo_link = create_email_logo();

        $message = str_replace("{INVOICE_LOGO}",$logo_link,$message);

        $message = str_replace("{SITE_URL}",base_url().'auth/login',$message);

        $message = str_replace("{SITE_NAME}",$company_name,$message);

        $params['recipient'] = $company_import_email;

        $params['subject'] = $subject;
        $params['message'] = $message;

        $params['attached_file'] = base_url().$file_path;

        modules::run('fomailer/send_email',$params);

    }

    function employees(){
      $this->db->select('US.id as user_id,AD.fullname');
      $this->db->from('users US');
      $this->db->join('dgt_account_details AD','US.id = AD.user_id');
      $this->db->where(array('role_id'=>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')));
      // $this->db->order_by("AD.fullname", "asc");
      $records = $this->db->get()->result_array();
      echo json_encode($records);
      die();        
    }

    function incidents(){
      $incidents = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("id", "asc")->get('incidents')->result_array();
      echo json_encode($incidents);
      die();
    }

    public function add_attendance_records(){
      if($this->input->post()){
         $params = $this->input->post();
        $user_schedule = $this->input->post('user_id');
         // echo"<pre>"; print_r($params); exit;
        if (count($user_schedule) > 0) {
          $today_work_hour = array();
          for($i = 0; $i< count($user_schedule); $i++)
          {
            if(!empty($params['punch_time'][$i])){
              $strtotime = strtotime(date($params['punch_date'][$i]));
              $user_id   = $params['user_id'][$i];
              $a_year    =  date("Y", $strtotime);              
              $a_month   =  date("m", $strtotime);        
              $a_day     =  date("d", $strtotime);
              $a_cin     =  date("H:i", strtotime($params['punch_time'][$i]));
              $a_cout     =  date("H:i", strtotime($params['punch_time'][$i]));
              $workcode     =  $params['workcode'][$i];
              $date = $a_year.'-'.$a_month.'-'.$a_day;
              $subdomain_id       = $this->session->userdata('subdomain_id');
              $where     = array('subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
              $this->db->select('month_days,month_days_in_out');
              $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
              
              if($params['punch'][$i] =='punch_in'){

                if(empty($record)){
                  $inputs['attendance_month'] =$a_month;
                  $inputs['attendance_year'] = $a_year;
                  $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');                  
                  Attendance_model::attendance($user_id,$inputs);
                  $this->db->select('month_days,month_days_in_out');
                  $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                }

                
                if(!empty($record['month_days'])){
                  $record_day = unserialize($record['month_days']);
                  $month_days_in_out_record = unserialize($record['month_days_in_out']);

                  $a_day -=1;
                  
                   if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
                    $current_days = $month_days_in_out_record[$a_day];
                    $total_records = count($current_days);
                    $current_day = end($current_days);
                    
                     $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$date.'" AND ((start_time <= "'.$a_cin.'" and end_time >="'.$a_cin.'") or (start_time >= "'.$a_cin.'")) limit 1')->row_array();
             
                    if(!empty($today_work_hour)){
                      $project_id = $today_work_hour['project_id'];
                      $scheduling_id = $today_work_hour['id'];
                    }else{
                      $project_id ='';
                      $scheduling_id ='';
                    }

                    if($record_day[$a_day]['punch_in'] ==''){                              
                      $record_day[$a_day]['punch_in'] = $a_cin;
                      $record_day[$a_day]['punchin_workcode'] = $workcode;
                      $record_day[$a_day]['punch_in_manually_made'] = 'yes';
                      $record_day[$a_day]['day'] = 1;                      
                      $record_day[$a_day]['scheduling_id'] = $scheduling_id;
                      $record_day[$a_day]['project_id'] = $project_id;
                    }
                    if($total_records == 1 && empty($current_day['punch_out'])){
                      
                      $current_days = array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','punchin_workcode'=>$workcode,'punch_in_manually_made'=>'yes','scheduling_id'=>$scheduling_id,'project_id'=>$project_id);
                      $month_days_in_out_record[$a_day][0] = $current_days;
                    }else{
                      
                      if(!empty($current_day['punch_in']) && !empty($current_day['punch_out']))
                      {
                        $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','punchin_workcode'=>$workcode,'punch_in_manually_made'=>'yes','scheduling_id'=>$scheduling_id,'project_id'=>$project_id);
                        $month_days_in_out_record[$a_day] = $current_days;
                      } 
                    }
                    

                  }
                }
                


               

               

                $this->db->where($where);
                $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
                $this->session->set_flashdata('tokbox_success', lang('attendance_added_successfully'));
              }
              if($params['punch'][$i] =='punch_out'){

                if(empty($record)){
                  $inputs['attendance_month'] =$a_month;
                  $inputs['attendance_year'] = $a_year;
                  $inputs['subdomain_id'] = $this->session->userdata('subdomain_id');
                  Attendance_model::attendance($user_id,$inputs);
                  $this->db->select('month_days,month_days_in_out');
                  $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                }
                
                if(!empty($record['month_days'])){
                   $a_day -=1;

                  $production_hour=0;
                  if(!empty($record['month_days_in_out'])){

                   $month_days_in_outss =  unserialize($record['month_days_in_out']);
            // echo "<pre>";print_r($month_days_in_outss); exit;
                                     
                    foreach ($month_days_in_outss[$a_day] as $punch_detailss) 
                    {

                        if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
                        {
                                              
                             $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
                             // echo $production_hour; exit;

                              
                        }
                    }
                  }
                   
                  $record_day = unserialize($record['month_days']);
                  $month_days_in_out_record = unserialize($record['month_days_in_out']);
                   
                    // $a_day -=1;
                    
                    $current_days = $month_days_in_out_record[$a_day];
                    $total_records = count($current_days);
                    $current_day = end($current_days);

                
                  if(!empty($record_day[$a_day])){
                      $record_day[$a_day]['punch_out'] = $a_cout;
                      $record_day[$a_day]['production'] = $production_hour;
                      $record_day[$a_day]['punchout_workcode'] = $workcode;
                      $record_day[$a_day]['punch_out_manually_made'] = 'yes';
                      $record_day[$a_day]['day'] = 1;
                  }
                  if($total_records == 1 && empty($current_day['punch_out'])){
                     
                      $month_days_in_out_record[$a_day][0]['punch_out'] = $a_cout;
                      $month_days_in_out_record[$a_day][0]['punchout_workcode'] = $workcode;
                      $month_days_in_out_record[$a_day][0]['punch_out_manually_made'] = 'yes';
                      $month_days_in_out_record[$a_day][0]['production'] = $production_hour;
                    }else{
                        
                      if(!empty($current_day['punch_in']) && empty($current_day['punch_out']))
                      {
                        
                         $current_days[$total_records-1]['punch_out'] = $a_cout;
                         $current_days[$total_records-1]['punchout_workcode'] = $workcode;
                         $current_days[$total_records-1]['punch_out_manually_made'] = 'yes';
                         $current_days[$total_records-1]['production'] = $production_hour;
                         $month_days_in_out_record[$a_day] = $current_days;
                      } 
                    }
                  
                }
                

                   // echo print_r($current_days)."<pre>";print_r($month_days_in_out_record); exit;

                $this->db->where($where);
                $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
              }
              $this->session->set_flashdata('tokbox_success', lang('attendance_added_successfully'));
            } else{
              $this->session->set_flashdata('tokbox_success', 'Something went wrong');
           }    
             
          }
        }
         redirect($_SERVER['HTTP_REFERER']);
      }
    }
}
