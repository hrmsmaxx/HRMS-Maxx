<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Attendance extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model(array( 'App', 'Attendance_model'));
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
    }

    function index()
    {
        if($this->tank_auth->is_logged_in()) {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('employee_management').'-'.config_item('company_name'));
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = lang('employees');
            $data['sub_page']       = lang('attendance');
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();

            $role_id = $this->tank_auth->get_role_id();
            $page = (($role_id==4) || ($role_id==1))?'attendance':'create_attendance';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
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
      $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
      $this->db->select('month_days,month_days_in_out');
      $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

      if(empty($record)){
        $inputs['attendance_month'] =$a_month;
        $inputs['attendance_year'] = $a_year;
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
          
  

          if($record_day[$a_day]['punch_in'] ==''){
            $record_day[$a_day]['punch_in'] = $a_cin;
            $record_day[$a_day]['day'] = 1;
          }
          
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
 
      $this->db->where($where);
      $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
   }

   $this->session->set_flashdata('tokbox_success', 'Punch in successfully saved');
   return redirect('attendance');
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
      $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
      $this->db->select('month_days,month_days_in_out');
      $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
     
      if(empty($record)){
        $inputs['attendance_month'] =$a_month;
        $inputs['attendance_year'] = $a_year;
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
   return redirect('attendance');
   }

   }


   public function attendance_details($user_id,$day,$month,$year)
   {
            $data['user_id'] = $user_id;
            $data['atten_day'] = $day;
            $data['atten_month'] = $month;
            $data['atten_year'] = $year;
             $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
             $this->db->select('month_days,month_days_in_out');
             $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            $this->load->view('modal/attendance', $data);
   }

   public function data_import(){
   
        //upload folder path defined here 

    // $personalinfo = file("PCarretas.dat");
    // echo "<pre>"; print_r($personalinfo); exit;

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
//if successfully uploaded the file 
        else
        {

            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

        $punch_details = file($upload_data['full_path']);

            // echo print_r(); exit; 
//     //load library phpExcel
//             $this->load->library("Excel");


// //here i used microsoft excel 2007
//             $objReader = PHPExcel_IOFactory::createReader('Excel2007');

// //set to read only
//             $objReader->setReadDataOnly(true);
// //load excel file
//             $objPHPExcel = $objReader->load('upload/'.$file_name);
//             $sheetnumber = 0;
            // foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            // {

            //     $s = $sheet->getTitle();    // get the sheet name 

            //     $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
            //     $sheet= strtolower($sheet); 
            //     $objWorksheet = $objPHPExcel->getSheetByName($s);

            //     $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
            //     $sheetnumber++;
                // for($j=1; $j<=$lastRow; $j++)
              foreach ($punch_details as $punch_detail) {
                # code...
                $punchData = preg_split('/\s+/', $punch_detail);
                // $user_id = $punchData[1];
                // $punchDate = $punchData[2];
                // $punchtime = $punchData[3];
                //  echo "<pre>"; print_r($punchData); exit;
                  $params['user_id'] = $punchData[1];
                  $punch_date_time = $punchData[2].' '.$punchData[3];
                  $date_timeam = str_replace('AM', '', $punch_in_date_time);
                  $date_time = str_replace('PM', '', $date_timeam);
                  $params['deviceid'] = $punchData[4];
                  $params['status'] = $punchData[5];
                  $params['verify_code'] = $punchData[6];
                  $params['workcode'] = $punchData[7];
                  $params['punch_in_date_time'] = date('Y-m-d H:i',strtotime($punch_date_time));
                  $params['punch_out_date_time'] = date('Y-m-d H:i',strtotime($punch_date_time));
                  // echo $params['punch_out_date_time']; exit;

                $user_id = $punchData[1];
                ${"user" . $user_id} = $punchData[1];
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
                

                ${"lastuser" . $user_id} = $punchData[1];
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

                                  $a_year    = date('Y',$strtotime);
                                  $a_month   = date('m',$strtotime);
                                  $a_day     = date('d',$strtotime);
                                  $a_cin     = date('H:i',$strtotime);
                                   // echo $strtotime; exit;
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
                                    Attendance_model::attendance($user_id,$inputs);
                                    $this->db->select('month_days,month_days_in_out');
                                    $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                                  }

                                  
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
                                      
                              

                                      if($record_day[$a_day]['punch_in'] ==''){
                                        $record_day[$a_day]['punch_in'] = $a_cin;
                                        $record_day[$a_day]['day'] = 1;
                                      }


                                      if($total_records == 1 && empty($current_day['punch_out'])){
                                        
                                        $current_days = array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'workcode'=>$params['workcode']);
                                        $month_days_in_out_record[$a_day][0] = $current_days;
                                      }else{
                                        
                                        if(!empty($current_day['punch_in']) && !empty($current_day['punch_out']))
                                        {
                                          $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'','deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'workcode'=>$params['workcode']);
                                          $month_days_in_out_record[$a_day] = $current_days;
                                        } 
                                      }
                                      

                                    }
                                  }

                          $datetime = new DateTime();
                          $today= $datetime->format('Y-m-d');
                          $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$params['user_id'],'schedule_date'=>$today))->row_array();

                          $user_details = $this->db->get_where('users',array('id'=>$params['user_id']))->row_array();
                          $employee_details = $this->db->get_where('account_details',array('user_id'=>$params['user_id']))->row_array();
                          
                             if(empty($employee_shifts)){
                                         $today_shifts = $this->db->query('select * from dgt_shifts where group_id !=0 ORDER BY abs(UNIX_TIMESTAMP(CONCAT(CURDATE(), " ",  "'.$a_cin.'")) - UNIX_TIMESTAMP(CONCAT(CURDATE(), " ",  start_time))) limit 1')->row_array();
                                        // echo $this->db->last_query();
                                        // echo print_r($today_shifts); exit;
                                        if(!empty($today_shifts)){
                                    
                                                      $shift_details = array(
                                                      'dept_id' =>  $user_details['department_id'],
                                                      'employee_id' => $params['user_id'],
                                                      'schedule_date' => $today,
                                                      'min_start_time' => $today_shifts['min_start_time'],
                                                      'start_time' => $today_shifts['start_time'],
                                                      'max_start_time' => $today_shifts['max_start_time'],
                                                      'min_end_time' => $today_shifts['min_end_time'],
                                                      'end_time' => $today_shifts['end_time'],
                                                      'max_end_time' => $today_shifts['max_end_time'],
                                                      'break_time' => $today_shifts['break_time'],
                                                      'shift_id' => $today_shifts['id'],
                                                      // 'break_start' => date("H:i", strtotime($_POST['break_start'])),
                                                      // 'break_end' => date("H:i", strtotime($_POST['break_end'])),
                                                      // 'schedule_repeat' => $_POST['repeat_time'],
                                                      'color' => '#1eb53a',
                                                      'end_date' => $today,
                                                      'created_by' => $today_shifts['created_by'],
                                                      'subdomain_id' => $today_shifts['subdomain_id'],
                                                      'published' => $today_shifts['published']

                                                      );
                                                    // echo "<pre>";print_r($shift_details); exit();
                                                  $this->db->insert('shift_scheduling',$shift_details);
                                                     // echo $this->db->last_query(); exit;
                          
                                                  $shift_id =$this->db->insert_id();
                               }
                           }
                                  $this->db->where($where);
                                  $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record),'deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'workcode'=>$params['workcode']));
                               }

                              
                        }else{
                        $this->session->set_flashdata('tokbox_error', lang('user_id_not_found'));
                      }
                    }else{

                      $this->session->set_flashdata('tokbox_error', lang('user_id_or_date_is_missing'));
                    } 
                  }else{
                    echo '  punchout - '.$params['punch_out_date_time'];
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
                            }
                            if($total_records == 1 && empty($current_day['punch_out'])){
                                $month_days_in_out_record[$a_day][0]['punch_out'] = $a_cout;
                                $month_days_in_out_record[$a_day][0]['production'] = $production_hour;
                                $month_days_in_out_record[$a_day][0]['deviceid'] = $params['deviceid'];
                                $month_days_in_out_record[$a_day][0]['status'] = $params['status'];
                                $month_days_in_out_record[$a_day][0]['verify_code'] = $params['verify_code'];
                                $month_days_in_out_record[$a_day][0]['workcode'] = $params['workcode'];
                              }else{
                                  
                                if(!empty($current_day['punch_in']) && empty($current_day['punch_out']))
                                {
                                  
                                   $current_days[$total_records-1]['punch_out'] = $a_cout;
                                   $current_days[$total_records-1]['production'] = $production_hour;
                                   $current_days[$total_records-1]['deviceid'] = $params['deviceid'];
                                   $current_days[$total_records-1]['status'] = $params['status'];
                                   $current_days[$total_records-1]['verify_code'] = $params['verify_code'];
                                   $current_days[$total_records-1]['workcode'] = $params['workcode'];
                                   $month_days_in_out_record[$a_day] = $current_days;
                                } 
                              }
                            
                          }
                          

                          //     echo print_r($current_days)."<pre>";print_r($month_days_in_out_record); 
                          // echo $a_cout;exit;

                          $this->db->where($where);
                          $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record),'deviceid'=>$params['deviceid'],'status'=>$params['status'],'verify_code'=>$params['verify_code'],'workcode'=>$params['workcode']));
                       }
                       

                      }else{
                        $this->session->set_flashdata('tokbox_error', lang('user_id_not_found'));
                      }
                    }else{
                       $this->session->set_flashdata('tokbox_error', lang('user_id_or_date_is_missing'));
                    }

                }
               
                
                // exit;
               

            }
             // exit;
            
        // }
        $this->session->set_flashdata('tokbox_success', lang('attendance_import_successfully'));
            redirect('attendance');

    }
  }else{
    $this->session->set_flashdata('tokbox_error', lang('please_import_data'));
            redirect('attendance');

  }

}



}
