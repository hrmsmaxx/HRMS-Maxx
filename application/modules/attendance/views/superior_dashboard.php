<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 
  <?php 

  date_default_timezone_set('Asia/Kolkata');
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
  ?>

<div class="content container-fluid">
    <div class="row">
            <div class="col-sm-7">
              <h4 class="page-title"><?php echo lang('attendance_closing_dashbord')?></h4>
            </div>
            
         
          <div class="col-sm-5  text-right m-b-20">     
              <a class="btn back-btn" href="<?=base_url()?>attendance/team_attendance"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
          </div>
    </div>
          

          <?php 
              $s_year = '2019';
              $select_y = date('Y');

              $s_month = date('m');
              $e_year = date('Y');



             ?>

          <!-- Search Filter -->
          <div class="row filter-row">
            <form method="post" action="" class="filter-form" >
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
                            if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){  
                              $employee = $this->db->get_where('users',array('role_id' =>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result();
                            }else{
                              $department_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                              //echo 'det<pre>'; print_r($department_id); exit;
                              //$employee = $this->db->get_where('users',array('department_id'=> $department_id,'role_id' =>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result();
                                $multi_dept_id = explode(',', $department_id);
                                $dept_users= $this->db->select('*')
                                            ->from('users')
                                            ->where_in('department_id', $multi_dept_id)
                                            ->where(array('role_id' =>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))
                                            ->get()
                                            ->result();
                                }
                            foreach ($employee as $c){
                              $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                              if($dept_id !=0){   
                               if($this->tank_auth->user_role($c->user_type) != 'manager' && $this->tank_auth->user_role($c->user_type) != 'superior'){ ?>
                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
                                
                            <?php  } }
                              if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){  
                            ?>

                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
                            <?php }
                          }  ?>
                        </optgroup>
                    </select>
                </div>
              </div>

              <?php
               if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){  
               $departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("deptname", "asc")->get('departments')->result(); ?>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label><?=lang('office')?></label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <?php $teamlead_id = $this->db->where(array('role_id' =>3,'activated'=>1,'banned'=>0,'is_teamlead'=>'yes','subdomain_id'=>$this->session->userdata('subdomain_id'))) -> get('users')->result(); ?>
              <div class="col-md-3">
                <div class="form-group">
                  <label><?=lang('employees_boss')?></label>
                  <select class="select2-option form-control" name="teamlead_id" id="teamlead_id" >
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
            <?php } ?>
              <div class="col-md-3">
                <div class="form-group">
                  <label><?=lang('rangeof_time')?></label>
                  <input type="text" name="range" id="reportrange" class="pull-right form-control" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <span></span> <b class="caret"></b>
                </div>
              </div>
          
         
          <div class="col-md-3">  
             <label class="d-block">&nbsp;</label>
             <button type="submit" class="btn btn-success btn-block"><?php echo lang('search');?></button> 
          </div>
        </div>
      </form>

          </div>
          
          <!-- /Search Filter -->
          
          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table id="table-attendance_records" class="table table-striped custom-table m-b-0 AppendDataTables">
                  <thead>
                    <tr>
                      <!-- <th>#</th> -->
                      <th><?php echo lang('date')?></th>   
                      <th><?php echo lang('employee')?> </th>                             
                      <th><?php echo lang('status')?> </th>                             
                    </tr>
                  </thead>
                 <tbody>
        <?php 
         $user_id = array();
        if(!empty($_POST['id_code']) || !empty($_POST['user_id']) || !empty($_POST['department_id']) || !empty($_POST['teamlead_id']) || !empty($_POST['range']))
                { 
                    
                 
                  if(isset($_POST['id_code']) && !empty($_POST['id_code'])){

                    $users= $this->db->get_where('users',array('id_code'=>$_POST['id_code']))->row_array();
 
                    if(!empty($users)){
                      // $user_id[] = $users['id'];
                      if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){ 
                            $user_id[] = $users['id'];
                          }
                          $superior_dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                          $user_dept_id= $this->tank_auth->get_department($users['id']);
                          if($superior_dept_id == $user_dept_id){
                            //$dept_users= $this->db->get_where('users',array('id'=>$users['id'],'department_id'=>$user_dept_id))->row_array();
                            $multi_dept_id = explode(',', $user_dept_id);
                            $dept_users= $this->db->select('*')
                                        ->from('users')
                                        ->where('id', $users['id'])
                                        ->where_in('department_id', $multi_dept_id)
                                        ->get()
                                        ->row_array();

                            if(!empty($dept_users)){
                             if($this->tank_auth->user_role($dept_users['user_type']) != 'manager' && $this->tank_auth->user_role($dept_users['user_type']) != 'superior'){ 

                                $user_id[] = $users['id'];
                              }
                            }
                          }
                    }else{
                      $user_id ='';
                    }

                  } 

                  if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
                      if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){ 
                            $user_id[] = $_POST['user_id'];
                          }
                          $superior_dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                          $user_dept_id= $this->tank_auth->get_department($_POST['user_id']);
                          if($superior_dept_id == $user_dept_id){
                            //$dept_users= $this->db->get_where('users',array('id'=>$_POST['user_id'],'department_id'=>$user_dept_id,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                            $multi_dept_id = explode(',', $user_dept_id);
                            $dept_users= $this->db->select('*')
                                        ->from('users')
                                        ->where('id', $users['id'])
                                        ->where_in('department_id', $multi_dept_id)
                                        ->get()
                                        ->row_array();
                            if(!empty($dept_users)){
                             if($this->tank_auth->user_role($dept_users['user_type']) != 'manager' && $this->tank_auth->user_role($dept_users['user_type']) != 'superior'){ 

                                $user_id[] = $_POST['user_id'];
                              }
                            }
                          }
                  }
                  if(isset($_POST['department_id']) && !empty($_POST['department_id'])){
                    //$dept_users= $this->db->get_where('users',array('department_id'=>$_POST['department_id'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
                     $deptid = $_POST['department_id'];
                    $dept_users= $this->db->select('*')
                            ->from('dgt_users')
                            ->where('subdomain_id', $this->session->userdata('subdomain_id'))
                            ->where("FIND_IN_SET('$deptid',department_id) !=", 0)
                            ->get()
                            ->result_array();

                    if(!empty($dept_users)){
                      foreach ($dept_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }
                  if(isset($_POST['teamlead_id']) && !empty($_POST['teamlead_id'])){
                    $team_users= $this->db->get_where('users',array('teamlead_id'=>$_POST['teamlead_id'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
                    if(!empty($team_users)){
                      foreach ($team_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }

                  if(isset($_POST['range']) && !empty($_POST['range'])){
                   
                    $date_range = explode('-', $_POST['range']);
                    $start_date = $date_range[0];
                    $end_date = $date_range[1];
                    $start_time=strtotime($start_date);
                    $start_day=date("d",$start_time);
                    $start_month=date("m",$start_time);
                    $start_year=date("Y",$start_time);
                    $end_date=strtotime($end_date);
                    $end_day=date("d",$end_date);
                    $end_month=date("m",$end_date);
                    $end_year=date("Y",$end_date);
                   
                    $from_date = date("Y-m-d", $start_time);       
                      $to_date = date("Y-m-d", $end_date);
                      $earlier = new DateTime($from_date);
                      $later = new DateTime($to_date);

                      $col_count = $later->diff($earlier)->format("%a");
                       
                    if(empty($user_id)){
                       // echo "<pre>";   print_r($_POST); exit;
                      // $all_users = $this->db->get_where('users',array('role_id !='=>2,'role_id !='=>1,'activated'=>1,'banned'=>0))->result_array();
                      $this->db->where('a_month >=', $start_month);
                      $this->db->where('a_month <=', $end_month);
                      $this->db->where('a_year >=', $start_year);
                      $this->db->where('a_year <=', $end_year);
                      $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
                      $all_users =  $this->db->get('attendance_details')->result_array();
                      // echo "<pre>";   print_r($all_users); exit;
                       if(!empty($all_users)){
                        foreach ($all_users as $key => $value) {
                          if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){ 
                            $user_ids[] = $value['user_id'];
                          }
                          $superior_dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                          $user_dept_id= $this->tank_auth->get_department($value['user_id']);
                          if($superior_dept_id == $user_dept_id){
                            //$dept_users= $this->db->get_where('users',array('id'=>$value['user_id'],'department_id'=>$user_dept_id))->row_array();
                            if(!empty($dept_users)){
                             if($this->tank_auth->user_role($dept_users['user_type']) != 'manager' && $this->tank_auth->user_role($dept_users['user_type']) != 'superior'){ 

                                $user_ids[] = $value['user_id'];
                              }
                            }
                          }                          
                        }
                        $user_id = $user_ids;
                      }
                    }
                     
                  } 
              } else{  
                $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                if($dept_id !=0){                   
                  //$dept_users= $this->db->get_where('users',array('department_id'=>$dept_id,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();

                   $multi_dept_id = explode(',', $dept_id);
                    $dept_users= $this->db->select('*')
                            ->from('dgt_users')
                            ->where('subdomain_id', $this->session->userdata('subdomain_id'))
                            ->where_in('department_id', '$multi_dept_id')
                            ->get()
                            ->result_array();

                  if(!empty($dept_users)){
                    foreach ($dept_users as $key => $value) {
                      if($this->tank_auth->user_role($value['user_type']) != 'manager' && $this->tank_auth->user_role($value['user_type']) != 'superior'){ 
                        $user_id[] = $value['id'];

                      }
                    }
                  }
                }    
                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){  
                  $where     = array('subdomain_id'=>$this->session->userdata('subdomain_id'),'a_month'=>$a_month,'a_year'=>$a_year);
                   // $this->db->select('month_days,month_days_in_out');
                  $record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();       
                 if(!empty($record)){
                  foreach ($record as $key => $value) {
                    $user_id[] = $value['user_id'];
                  }
                }
              }
            }
              $user_id =  array_unique($user_id);

                     // echo "<pre>";   print_r($user_id); exit;

                   foreach ($user_id as $key => $value) {

                    if($value !=1){
                    
                  $user_id = $value;

$user_details= $this->db->get_where('users',array('id'=>$user_id))->row_array();
$account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();
                      ?>
             
              
             <?php

                    if(isset($_POST['attendance_month']) && !empty($_POST['attendance_month']))
                    {
                      $a_month=$_POST['attendance_month'];
                    }

                     if(isset($_POST['attendance_year']) && !empty($_POST['attendance_year']))
                    {
                      $a_year=$_POST['attendance_year'];
                    }


                    
                     
                     // print_r($_POST['range']); exit;
                    if(isset($_POST['range']) && !empty($_POST['range'])){
                      $this->db->select('month_days,month_days_in_out');
                      $this->db->where('user_id', $user_id);
                      $this->db->where('a_month ', $start_month);
                      // $this->db->where('a_month <=', $end_month);
                      // $this->db->where('a_year >=', $start_year);
                      $this->db->where('a_year ', $start_year);
                      $results =  $this->db->get('attendance_details')->result_array();

                    } else{
                      $a_year    = date('Y');
                      $a_month   = date('m');

                     $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                     $this->db->select('month_days,month_days_in_out');
                     $results  = $this->db->get_where('dgt_attendance_details',$where)->result_array();
                     
                    }
                   
                     
                     $sno=1;
                     // echo "<pre>";print_r($results); 
                     foreach ($results as $rows) {

                          $list=array();
                          if(isset($_POST['range']) && !empty($_POST['range'])){
                            $number = $col_count;
                            $start_val = 0;
                          }else{
                            $month = $a_month;
                            $year = $a_year;

                            $number = $a_day;
                            // $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $start_val = $a_day;

                          }
                          $week_off = 0;
                          $actually_worked = 0;
                          $absent = 0;
                          for($d=$start_val; $d<=$number; $d++)
                           {
                            if(isset($_POST['range']) && !empty($_POST['range'])){
                                  $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                                } else{
                                   $time=mktime(12, 0, 0, $month, $d, $year);     
                              

                                }

                              // if (date('m', $time)==$month)       
                                  $date=date('d M Y', $time);
                                  $new_date=date('d/m/Y', $time);
                                  $schedule_date=date('Y-m-d', $time);
                                  $a_day =date('d', $time);
                                  $a_month =date('m', $time);
                                  $a_year =date('Y', $time);
                                   // echo print_r($schedule_date) ; exit;   
                                  $this->db->select('month_days,month_days_in_out');
                                  $this->db->where('user_id', $user_id);
                                  $this->db->where('a_month ', $a_month);
                                  // $this->db->where('a_month <=', $end_month);
                                  // $this->db->where('a_year >=', $start_year);
                                  $this->db->where('a_year ', $a_year);
                                  $rows =  $this->db->get('attendance_details')->row_array(); 
                                  $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>$schedule_date);
                                  $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
                                  $shift =  $this->db->get_where('shifts',array('id' => $user_schedule['shift_id']))->row_array(); 
                                 if(!empty($user_schedule)){
                                    $total_scheduled_hour = work_hours($user_schedule['schedule_date'].' '.$user_schedule['start_time'],$user_schedule['schedule_date'].' '.$user_schedule['end_time'],$user_schedule['break_time']);

                                    $total_scheduled_minutes = $total_scheduled_hour;                                     
                                    
                                  } else{
                                    $total_scheduled_minutes = 0;
                                  }


                                if(!empty($rows['month_days'])){
     
    
                                  $month_days =  unserialize($rows['month_days']);
                                  $month_days_in_out =  unserialize($rows['month_days_in_out']);
                                  $day = $month_days[$a_day-1];
                                  $day_in_out = $month_days_in_out[$a_day-1];
                                  $latest_inout = end($day_in_out);
                                  //checking the attendance status
                                  if($month_days[$a_day-1]['punch_in'] !=''){
                                  if($month_days[$a_day-1]['closed_status'] !='yes'){
                                 
                                 $k = 1;
                               
                        
                                $user_details= $this->db->get_where('users',array('id'=>$user_id))->row_array();
                                $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();                    
                                if(!empty($user_details['designation_id'])){
                                  $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
                                  $designation_name = $designation['designation'];
                                  
                                }else{
                                  $designation_name = '-';
                                }
                      ?>


                     <tr>
                        <td><?php echo $new_date ;?> <br>
                        <?php echo date('l', $time)?>
                      </td>
                      <td>
                        <div class="user_det_list" style="margin-bottom: 10px;">
                            <a href="javascript:void(0)"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
                            <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
                            <span class="userrole-info"> <?php echo $designation_name;?></span>
                            <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
                          </div>
                           <?php echo !empty($shift['shift_name'])?ucfirst($shift['shift_name']):''?>&nbsp;<?php echo !empty($total_scheduled_minutes)?'('.intdiv($total_scheduled_minutes, 60).'.'. ($total_scheduled_minutes % 60).' hrs)':'';?><br>  
                           <?php

                          $punchin_workcode = '';
                          $punchout_workcode = '';
                            foreach ($month_days_in_out[$a_day-1] as $punch_detail) 
                          {
                             if(isset($punch_detail['punchin_workcode']) && !empty($punch_detail['punchin_workcode'])){
                              $punchin_workcodes = $this->db->get_where('incidents',array('id' => $punch_detail['punchin_workcode']))->row_array();
                             $punchin_workcode= '('.$punchin_workcodes['incident_name'].')';
                            }else{
                              $punchin_workcode = '';
                            }
                            
                             if(isset($punch_detail['punchout_workcode']) && !empty($punch_detail['punchout_workcode'])){
                                $punchout_workcodes=  $this->db->get_where('incidents',array('id' => $punch_detail['punchout_workcode']))->row_array(); 
                                 $punchout_workcode= '('.$punchout_workcodes['incident_name'].')';
                               }else{
                                $punchout_workcode ='';
                               }
                                              

                           echo !empty($punch_detail['punch_in'])?'<i class="fa fa-arrow-right text-success"></i> &nbsp; '.date("g:i a", strtotime($punch_detail['punch_in'])).' '.$punchin_workcode.' &nbsp;|&nbsp ':''; ?><?php echo !empty($punch_detail['punch_out'])?'<i class="fa fa-arrow-left text-danger"></i> &nbsp;  '.date("g:i a", strtotime($punch_detail['punch_out'])):''; ?> <?php echo $punchout_workcode;?> <br>
                         <?php }?>            
                      </td>
                      <td><?php  echo($month_days[$a_day-1]['day_status'] =='closed')?lang('requested'):lang('not_closed');?></td>
                      
                     
                     
                      
                      
                    </tr>
                    <?php } } } } } } } ?>
          
        </tbody>
                </table>
              </div>
                        </div>
                    </div>
                </div>
        <!-- /Page Content -->

       


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