<?php //echo 'session<pre>'; print_r($this->session->userdata()); exit; ?>
<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 

<?php 
$branch_id = $this->session->userdata('branch_id');

$cur = App::currencies(config_item('default_currency')); 

// date_default_timezone_set('Asia/Kolkata');
  $punch_in_date = date('Y-m-d');
  $punch_in_time = date('H:i');
  $punch_in_date_time = date('Y-m-d H:i');


   $strtotime = strtotime($punch_in_date_time);
   $a_year    = date('Y',$strtotime);
   $a_month   = date('m',$strtotime);
   $a_day     = date('d',$strtotime);
   $a_days     = date('d',$strtotime);
   $a_dayss     = date('d',$strtotime);
   $a_cin     = date('H:i',$strtotime);
    if(isset($_POST['attendance_month']) && !empty($_POST['attendance_month']))
    {
      $a_month=$_POST['attendance_month'];
    }

     if(isset($_POST['attendance_year']) && !empty($_POST['attendance_year']))
    {
      $a_year=$_POST['attendance_year'];
    }
   $subdomain_id     = $this->session->userdata('subdomain_id');
   $night_hours = $this->db->get_where('night_hours',array('subdomain_id' =>$subdomain_id ))->row_array();
?>

<div class="content">
  <div class="row"> 
    <div class="col-sm-12  text-right m-b-20">     
      <a class="btn back-btn m-b-10" href="<?=base_url()?>reports"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
    </div>
  </div>
  <section class="panel panel-white">
     <div class="panel-heading">
      <div class="row">
        <div class="col-sm-8">
          <h4 class="page-title m-b-10 m-r-10" style="display: inline-block;"><?=lang('monthly_report')?></h4>
           
        </div>
        <div class="col-sm-4 text-right">
          <a class="btn btn-white m-r-5 m-b-10" href="javascript: void(0);" id="filter_search">
            <i class="fa fa-filter m-r-0"></i>
          </a>
          <div class="btn-group">
            <button class="btn btn-default m-b-10"><?=lang('export')?></button>
            <button class="btn btn-default dropdown-toggle m-b-10" data-toggle="dropdown"><span class="caret"></span>
            </button>
            <ul class="dropdown-menu export" style="left:auto; right:0px !important; min-width: 93px !important">  
              <li>
                <form method="post" action="">
                    <input type="hidden" class="form-control" name = "pdf" value="1">
                    <input type="hidden" class="form-control id_code_excel" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">
                    <input type="hidden" class="form-control department_id_excel" name = "department_id" value="<?php echo (isset($_POST['department_id']) && !empty($_POST['department_id']))?$_POST['department_id']:'';?>">
                    <input type="hidden" class="form-control teamlead_id_excel" name = "teamlead_id" value="<?php echo (isset($_POST['teamlead_id']) && !empty($_POST['teamlead_id']))?$_POST['teamlead_id']:'';?>">
                    <input type="hidden" class="form-control attendance_month_excel" name = "attendance_month" value="<?php echo (isset($a_month) && !empty($a_month))?$a_month:'';?>">
                    <input type="hidden" class="form-control attendance_year_excel" name = "attendance_year" value="<?php echo (isset($a_year) && !empty($a_year))?$a_year:'';?>">
                    <input type="hidden" class="form-control user_id_excel" name = "user_id" value="<?php echo (isset($_POST['user_id']) && !empty($_POST['user_id']))?$_POST['user_id']:'';?>">
                    <button class=" btn  btn-block" type="submit" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-pdf-o"></i></span> <span><?=lang('pdf')?></span></button>
                     <!-- <a href="#" class="pull-right" id="attendance_report_pdf1" type="submit"> -->
                     
                      <!-- </a> -->
                </form>
               
              </li>

             <!--  <li>
                <form method="post" action="">
                    <input type="hidden" class="form-control" name = "excel" value="1">
                    <input type="hidden" class="form-control" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">
                    <input type="hidden" class="form-control" name = "department_id" value="<?php echo (isset($_POST['department_id']) && !empty($_POST['department_id']))?$_POST['department_id']:'';?>">
                    <input type="hidden" class="form-control" name = "teamlead_id" value="<?php echo (isset($_POST['teamlead_id']) && !empty($_POST['teamlead_id']))?$_POST['teamlead_id']:'';?>">
                    <input type="hidden" class="form-control" name = "range" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
                    <input type="hidden" class="form-control" name = "user_id" value="<?php echo (isset($_POST['user_id']) && !empty($_POST['user_id']))?$_POST['user_id']:'';?>">
                    <button class=" btn  btn-block" type="submit" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-pdf-o"></i></span> <span><?=lang('excel')?></span></button>
                    
                </form>
               
              </li> -->
              <li>
                <?php  $report_name = lang('monthly_report');?>
                 <button class="btn  btn-block" onclick="monthly_report_excel('<?php echo $report_name;?>','monthly_report');" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span><span><?=lang('excel')?></span> </button>
              </li>
            </ul>
          </div>
          <?=$this->load->view('report_header');?>
          <?php if($this->uri->segment(3) && count($employees)> 0 ){ ?>
          <a href="<?=base_url()?>reports/employeepdf/<?=$company_id;?>" class="btn btn-primary pull-right">
            <i class="fa fa-file-pdf-o"></i> <?=lang('pdf')?>
          </a>
          <?php } ?>
        </div>
      </div>

    </div>       
   <!--  <div class="panel-heading">

            <?=$this->load->view('report_header');?>

            <?php if($this->uri->segment(3) && count($employees)> 0 ){ ?>
              <a href="<?=base_url()?>reports/employeepdf/<?=$company_id;?>" class="btn btn-primary pull-right"><i class="fa fa-file-pdf-o"></i><?=lang('pdf')?>
              </a>              
            <?php } ?>
             
    </div> -->

    <div class="panel-body">

          

<form method="post" action="" class="filter-form" id="filter_inputs" style="display:none;">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label><?=lang('employees_code')?></label>
              <input type="text" class="form-control" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">          
             
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?=lang('employees')?></label>
              <select class="select2-option form-control" name="user_id" id="user_name">
                    <optgroup label="">
                    <option value=""><?php echo lang('select_employee');?></option> 
                        <?php 
                        if($branch_id != '') {
                            $this->db->where("branch_id IN (".$branch_id.")",NULL, false);
                        }
                        $employee = $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'role_id'=>3,'activated'=>1,'banned'=>0))->result();


                        foreach ($employee as $c): 
                        ?>

                            <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
                        <?php endforeach;  ?>
                    </optgroup>
                </select>
            </div>
          </div>
          <?php $departments = $this->db->order_by("deptname", "asc")->get_where('departments',array('subdomain_id'=>$subdomain_id))->result(); ?>
          <div class="col-md-3">
            <div class="form-group">
              <label><?=lang('department')?></label>
              <select class="select2-option form-control" name="department_id" id="department" >
                    <option value="" selected ><?php echo lang('select_department');?></option>
                    <?php
                    if(!empty($departments))  {
                    foreach ($departments as $department){ ?>
                    <option value="<?=$department->deptid?>" <?php echo (isset($_POST['department_id']) && ($_POST['department_id'] == $department->deptid))?"selected":""?>><?=$department->deptname?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
            </div>
          </div>
          
          <?php 
            if($branch_id != '') {
                $this->db->where("branch_id IN (".$branch_id.")",NULL, false);
            }

          $teamlead_id = $this->db->where(array('subdomain_id'=>$subdomain_id,'role_id'=>3,'activated'=>1,'banned'=>0,'is_teamlead'=>'yes')) -> get('users')->result(); ?>
          <div class="col-md-3">
            <div class="form-group">
              <label><?=lang('employees_boss')?></label>
              <select class="select2-option form-control" name="teamlead_id" >
                    <option value="" selected ><?php echo lang('select_boss');?></option>
                    <?php
                    if(!empty($teamlead_id))  {
                    foreach ($teamlead_id as $teamlead){ ?>
                    <option value="<?=$teamlead->id?>" <?php echo (isset($_POST['teamlead_id']) && ($_POST['teamlead_id'] == $teamlead->id))?"selected":""?>><?php echo User::displayName($teamlead->id);?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
            </div>
          </div>          
          <?php 
              $s_year = '2019';
              $select_y = date('Y');

              $s_month = date('m');
              $e_year = date('Y');
             ?>
          <div class="col-md-3">
            <div class="form-group">
              <label><?=lang('year')?></label>
              <select class="select floating form-control" id="attendance_year" name="attendance_year"> 
                  <option value="" selected="selected" disabled><?php echo lang('select year');?></option>
                  <?php for($k =$e_year;$k>=$s_year;$k--){ ?>
                  <option value="<?php echo $k; ?>" <?php echo (isset($a_year) && ($a_year == $k))?"selected":""?> ><?php echo $k; ?></option>
                  <?php } ?>
                </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?=lang('month')?></label>
              <select class="select floating form-control" id="attendance_month" name="attendance_month">  
                <option value="" selected="selected" disabled><?php echo lang('select_month');?></option>
                <?php 
                  for ($ji=1; $ji <=12 ; $ji++) {  ?>
                  <option value="<?php echo $ji; ?>" <?php echo (isset($a_month) && ($a_month == $ji))?"selected":""?>><?php echo date('F',strtotime($select_y.'-'.$ji)); ?></option>   
                  <?php } ?>
                
              </select>
            </div>
          </div>
         
          <div class="col-md-2">  
            <label class="d-block">&nbsp;</label>
            <button class="btn btn-success btn-md" type="submit"><?=lang('run_report')?></button>
          </div>
        </div>
      </form>



      <div class="table-responsive">
        <table id="table-attendance_reports" class="table table-striped custom-table m-b-0 AppendDataTables">
            <thead>
              <tr class="attendance_record">
                <th><?php echo lang('id_code');?></th>
                <th><?php echo lang('name');?></th>
                <?php
               
                $last_day = $a_year.'-'.$a_month.'-1';
                $last_day = date('t',strtotime($last_day));  
                 for ($ik = 1; $ik <= $last_day; $ik++) {
          $date = $a_year.'-'.$a_month.'-'.$ik; ?>
          <th><?php echo  lang(date('M',strtotime($date))).' '.lang($ik); ?></th>
       <?php  }?>
              <th><?php echo lang('total_worked_days');?></th>
              <th><?php echo lang('total_hours_extras');?></th>
              <th><?php echo lang('total_hours_night');?></th>
              <th><?php echo lang('total_hours_extra_night');?></th>
              </tr>
            </thead>
            <tbody>

              <?php

              
               if(!empty($_POST['id_code']) || !empty($_POST['user_id']) || !empty($_POST['department_id']) || !empty($_POST['teamlead_id']) || !empty($_POST['attendance_month']) || !empty($_POST['attendance_year']))
                { 
                  // print_r($_POST); exit();
                  if(isset($_POST['id_code']) && !empty($_POST['id_code'])){
                    $users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id_code'=>$_POST['id_code']))->row_array();
                    if(!empty($users)){
                      $user_id[] = $users['id'];
                    }else{
                      $user_id[] =array();
                    }
                  } 
                  if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
                    $user_id[] = $_POST['user_id'];
                  }
                  if(isset($_POST['department_id']) && !empty($_POST['department_id'])){
                    //$dept_users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'department_id'=>$_POST['department_id']))->result_array();
                    $dept_id = $_POST['department_id'];
                    $dept_users= $this->db->select('*')
                                ->from('users')
                                ->where('subdomain_id',$subdomain_id)
                                ->where("FIND_IN_SET('$dept_id',department_id) !=", 0)
                                //->where_in('department_id',$_POST['department_id'])
                                ->get()
                                ->result_array();
                    if(!empty($dept_users)){
                      foreach ($dept_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }
                  if(isset($_POST['teamlead_id']) && !empty($_POST['teamlead_id'])){
                    $team_users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'teamlead_id'=>$_POST['teamlead_id']))->result_array();
                    if(!empty($team_users)){
                      foreach ($team_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }
                  if(isset($_POST['attendance_month']) && !empty($_POST['attendance_month'])){
                   
                   
                      
                    if(empty($user_id)){
                      // $all_users = $this->db->get_where('users',array('role_id !='=>2,'role_id !='=>1,'activated'=>1,'banned'=>0))->result_array();
                      /*$this->db->where('a_month >=', $start_month);
                      $this->db->where('a_month <=', $end_month);
                      $this->db->where('a_year >=', $start_year);
                      $this->db->where('a_year <=', $end_year);
                      $this->db->where('subdomain_id', $subdomain_id);
                      $all_users =  $this->db->get('attendance_details')->result_array();*/
                        if($branch_id != '') {
                            $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                        }
                        $all_users = $this->db->select('ad.*')
                                    ->from('attendance_details ad')
                                    ->join('users u', 'u.id=ad.user_id')
                                    ->where(array('a_month'=>$a_month,'a_year'=>$a_year, 'ad.subdomain_id'=> $subdomain_id))
                                    ->get()
                                    ->result_array();

                       if(!empty($all_users)){
                        foreach ($all_users as $key => $value) {
                          $user_id[] = $value['user_id'];
                        }
                      }
                    }
                  }
                }else{
                    if($branch_id != '') {
                      $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                    }  
                $record = $this->db->select('ad.*')
                            ->from('attendance_details ad')
                            ->join('users u', 'u.id=ad.user_id', 'left')
                            ->where(array('ad.subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year))
                            ->get()
                            ->result_array();
                    /*$where     = array('subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
                    $record  = $this->db->get_where('dgt_attendance_details',$where)->result_array(); */             
                  if(!empty($record)){
                    foreach ($record as $key => $value) {
                    $user_id[] = $value['user_id'];
                  }
                }
            }

                $user_id =  array_unique($user_id);
                  // print_r($user_id); exit;
                if(!empty($user_id)){
                  foreach ($user_id as $key => $value) {
                    
                    $user_id = $value;

                    $user_details= $this->db->get_where('users',array('id'=>$user_id))->row_array();
                    $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();
                    if(!empty($user_details['designation_id'])){
                      $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
                      $designation_name = $designation['designation'];
                      
                    }else{
                      $designation_name = '-';
                    }
                    $imgs = '';
                    if($account_details['avatar'] != 'default_avatar.jpg'){
                        $imgs = $account_details['avatar'];
                        
                    }else{
                        $imgs = "default_avatar.jpg";
                    }
                      
                

                  $where     = array('ad.subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                  if($branch_id != '') {
                      $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                  }
                  $results = $this->db->select('month_days,month_days_in_out')
                              ->from('attendance_details ad')
                              ->join('users u', 'u.id=ad.user_id')
                              ->where($where)
                              ->get()
                              ->result_array();
                   
                     $sno=1;
                     $total_scheduled_work =0;
                    $actually_worked = 0;
                    $workday = 0;
                    $absent = 0;
                    $total_production = 0;
                    $total_night_production_hour = 0;
                    $total_extra_night_production_hour = 0;
                    $all_user_schedule = array();
                    $total_scheduled_minutes = 0;
                    $work_hours = 0;
                    $scheduled_minutes = 0;
                    $today_work_hour = array();                    
                          
                      $number = cal_days_in_month(CAL_GREGORIAN, $a_month, $a_year);
                      $start_val = 1;
                      ?>
                         
                          <tr class="attendance_record">
                            <td><?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></td>
                            <td><?php echo ucfirst(user::displayName($value));?></td>
                         <?php $week_off = 0;
                          $total_scheduled_minutes = 0;
                          $total_hours_extras = 0;
                          for($d=$start_val; $d<=$number; $d++)
                           {
                            $time=mktime(12, 0, 0, $a_month, $d, $a_year);  
                            
                            // if(isset($_POST['range']) && !empty($_POST['range'])){
                            //       $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                            //     } else{
                            //        $time=mktime(12, 0, 0, $a_month, $d, $a_year);     
                              

                            //     }

                              // if (date('m', $time)==$month)       
                                  $date=date('d M Y', $time);
                                  $new_date=date('d/m/Y', $time);
                                  $schedule_date=date('Y-m-d', $time);
                                  $a_day =date('d', $time);
                                  $a_month =date('m', $time);
                                  $a_year =date('Y', $time);
                                   // echo print_r($schedule_date) ; exit;   
                                 /* $this->db->select('month_days,month_days_in_out');
                                  $this->db->where('user_id', $user_id);
                                  $this->db->where('a_month ', $a_month);
                                  // $this->db->where('a_month <=', $end_month);
                                  // $this->db->where('a_year >=', $start_year);
                                  $this->db->where('a_year ', $a_year);
                                  $this->db->where('subdomain_id ', $subdomain_id);
                                  $rows =  $this->db->get('attendance_details')->row_array(); */

                                if($branch_id != '') {
                                    $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                                }
                                $rows = $this->db->select('month_days,month_days_in_out')
                                            ->from('attendance_details ad')
                                            ->join('users u', 'u.id=ad.user_id')
                                            ->where(array('user_id'=>$user_id, 'a_month '=>$a_month, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id))
                                            ->get()
                                            ->row_array();

                                  $user_schedule_where     = array('subdomain_id'=>$subdomain_id,'employee_id'=>$user_id,'schedule_date'=>$schedule_date);
                                  $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
                                  $shift =  $this->db->get_where('shifts',array('subdomain_id'=>$subdomain_id,'id' => $user_schedule['shift_id']))->result_array(); 
                                  $all_user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->result_array(); 
                                  if(count($all_user_schedule) == 1){
                                  
                                  
                                    if(!empty($user_schedule)){
                                      $total_scheduled_hour = hours_to_mins($user_schedule['work_hours']);

                                      $total_scheduled_minutes = $total_scheduled_hour;                                     
                                        
                                    } else{
                                      $total_scheduled_minutes = 0;
                                    }
                                  }
                                  if(count($all_user_schedule) > 1){
                                    $scheduled_minutes =0;
                                    foreach ($all_user_schedule as $value) {
                                      $work_hours = hours_to_mins($value['work_hours']);
                                      $scheduled_minutes += $work_hours;   
                                      # code...
                                    }
                                    $total_scheduled_minutes = $scheduled_minutes;
                                    
                                    // echo $this->db->last_query();
                                    // echo print_r($shift); exit;
                                  }

                                if(!empty($rows['month_days'])){
     
    
                                $month_days =  unserialize($rows['month_days']);
                                $month_days_in_out =  unserialize($rows['month_days_in_out']);
                                $day = $month_days[$a_day-1];
                                $day_in_out = $month_days_in_out[$a_day-1];
                                $latest_inout = end($day_in_out);
                                
                                 $production_hour=0;
                                 $night_production_hour=0;
                                 $extra_night_production_hour=0;
                                 $break_hour=0;
                                 $k = 1;
                                foreach ($month_days_in_out[$a_day-1] as $punch_detail) 
                                {

                                    if(!empty($punch_detail['punch_in']) && !empty($punch_detail['punch_out']))
                                    {
                                       $days = $a_day;
                                        // $today_work_where     = array('subdomain_id'=>$subdomain_id,'employee_id'=>$user_id,'schedule_date'=>date('Y-m-'.$days));
                                        // $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                                         $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$schedule_date.'" AND ((start_time <= "'.$punch_detail['punch_in'].'" and end_time >="'.$punch_detail['punch_in'].'") or (start_time >= "'.$punch_detail['punch_in'].'")) limit 1')->row_array();
                                         if(!empty($today_work_hour)){
                                            if($today_work_hour['free_shift'] == 1 ){
                                            $later_entry_hours = 0;
                                          
                                          
                                           
                                          }else{
                                            if($k == 1){                                       
                                               // print_r($today_work_hour); exit();
                                              $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$days).' '.$punch_detail['punch_in']);   
                                              $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$days).' '.$punch_detail['punch_in']);     
                                             // echo $days; exit;
                                              $first_punch_in = $punch_detail['punch_in'];
                                              $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$days).' '.$punch_detail['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                             
                                            }
                                            $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$days).' '.$punch_detail['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 

                                            $between_minstartto_start = between_minstartto_start($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']);
                                            if($punch_detail['punch_out'] > $today_work_hour['max_end_time']){
                                              $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                                            }else{
                                              $between_endto_max_end = 0;
                                            }
                                          }
                                         }
                                     
                                      

                                        $production_hour += time_difference(date('H:i',strtotime($punch_detail['punch_in'])),date('H:i',strtotime($punch_detail['punch_out'])));

                                        if(!empty($night_hours)){
                                            $night_hours_punch_in = night_hours_punch_in($today_work_hour['schedule_date'].' '.$night_hours['start_time'],$today_work_hour['schedule_date'].' '.$night_hours['end_time'],$today_work_hour['schedule_date'].' '.$punch_detail['punch_in']);
                                            $night_hours_punch_out = night_hours_punch_out($today_work_hour['schedule_date'].' '.$night_hours['start_time'],$today_work_hour['schedule_date'].' '.$night_hours['end_time'],$today_work_hour['schedule_date'].' '.$punch_detail['punch_out']);
                                           
                                           if ($night_hours_punch_in =='yes' && $night_hours_punch_out =='yes'){
                                              $night_production_hour += time_difference(date('H:i',strtotime($punch_detail['punch_in'])),date('H:i',strtotime($punch_detail['punch_out'])));
                                           }
                                           if ($night_hours_punch_in =='yes' && $night_hours_punch_out =='no'){
                                              $night_production_hour += time_difference(date('H:i',strtotime($punch_detail['punch_in'])),date('H:i',strtotime($night_hours['end_time'])));
                                           }
                                           if ($night_hours_punch_in =='no' && $night_hours_punch_out =='yes'){
                                              $night_production_hour += time_difference(date('H:i',strtotime($night_hours['start_time'])),date('H:i',strtotime($punch_detail['punch_out'])));
                                              $extra_night_production_hour += time_difference(date('H:i',strtotime($night_hours['start_time'])),date('H:i',strtotime($punch_detail['punch_out'])));

                                           }
 

                                        }
                                    }
                                              
                                  $k++;                              
                                     
                                }
                                 // echo 'between_minstartto_start'.$between_minstartto_start; exit;
                                if($production_hour > 0 && $later_entry_hours>0){
                                  $production_hour = $production_hour-$end_between;
                                } else{
                                  $production_hour = $production_hour-$start_between-$end_between;
                                }
                                if($production_hour<0){
                                  $production_hour = 0;
                                }

                             for ($i=0; $i <count($month_days_in_out[$a_day-1]) ; $i++) { 

                                        if(!empty($month_days_in_out[$a_day-1][$i]['punch_out']) && $month_days_in_out[$a_day-1][ $i+1 ]['punch_in'])
                                        {
                                            
                                            $break_hour += time_difference(date('H:i',strtotime($month_days_in_out[$a_day-1][$i]['punch_out'])),date('H:i',strtotime($month_days_in_out[$a_day-1][ $i+1 ]['punch_in'])));
                                        }

                                        
                              }

                              // $overtimes=($production_hour+$break_hour)-($total_scheduled_minutes);
                              if(!empty($user_schedule)){                                
                                if($user_schedule['accept_extras'] == 1){
                                  $overtimes=($production_hour)-($total_scheduled_minutes);
                                  if($overtimes > 0)
                                  {
                                    $overtime=$overtimes;
                                  }
                                  else
                                  {
                                    $overtime=0;                                  
                                    $extra_night_production_hour=0;
                                  }
                                } else{
                                  $overtime=0;
                                  $extra_night_production_hour=0;
                                }  
                                   
                              }else{
                                $overtime=$production_hour;
                              }            
                              $total_hours_extras +=$overtime;
                    ?> 

                      <?php if(empty($user_schedule))
                      {
                        if(!empty($day['punch_in']))
                        {
                           $total_scheduled_work += $total_scheduled_minutes;
                          $total_production += $production_hour;
                          $total_night_production_hour += $night_production_hour;
                          $total_extra_night_production_hour += $extra_night_production_hour;
                          $actually_worked++;
                       ?>
                       
                       <td><i class="fa fa-check text-success"></i></td>
                       
                       <?php   
                        }
                        else
                        { ?>
                          
                          <td><i class="fa fa-close text-danger"></i></td></td>
                        <?php }?>
                        
                     <?php  }
                      else
                      {
                        $total_scheduled_work += $total_scheduled_minutes;
                        $total_production += $production_hour;
                        $total_night_production_hour += $night_production_hour;
                        $total_extra_night_production_hour += $extra_night_production_hour;
                        $workday++;
                        if(!empty($day['punch_in']))
                        {?>
                           <td><i class="fa fa-check text-success"></i></td> 
                         
                        <?php   $actually_worked++;
                           
                        } else {?>
                          <td><i class="fa fa-close text-danger"></i></td></td>

                          
                       <?php } ?>
                                           
                      <?php  
                      }
                     ?>
                     
                    
                    
                    <?php } } ?>
                    <td><?php echo $actually_worked;?></td>
                    <td><?php echo !empty($total_hours_extras)?intdiv($total_hours_extras, 60).'.'. ($total_hours_extras % 60).''.lang('hrs'):'0'.' '.lang('hrs');?></td>
                    <td><?php echo !empty($total_night_production_hour)?intdiv($total_night_production_hour, 60).'.'. ($total_night_production_hour % 60).''.lang('hrs'):'0'.' '.lang('hrs');?></td>
                    <td><?php echo !empty($total_extra_night_production_hour)?intdiv($total_extra_night_production_hour, 60).'.'. ($total_extra_night_production_hour % 60).''.lang('hrs'):'0'.' '.lang('hrs');?></td>
                    </tr>
                   
                    <?php   
                     // } 
                   } 
                   }  else {?>
            <tr><td ><?php echo lang('no_records_found')?></td>
              
            
            </tr>
          <?php  } ?>
            </tbody>
          </table>
      </div>

      </div>
    </div>
  </section>
</div>



<script>
  // var start = moment().subtract(29, 'days');
  var start = moment();
  var end = moment();

  $('#reportrange').daterangepicker({
    // startDate: start,
    // endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  });
</script>
     