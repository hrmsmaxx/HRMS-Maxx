<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/>
  <?php 

  $system_settings = $this->db->get_where('subdomin_system_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    $systems = unserialize(base64_decode($system_settings['system_settings']));
    $time_zone = $systems['timezone']?$systems['timezone']:config_item('timezone');
  date_default_timezone_set($time_zone);
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
            <div class="col-sm-3">
              <h4 class="page-title"><?php echo lang('attendance_records')?></h4>
            </div>
            
          <div class="col-sm-4">
           <a class="btn add-btn show-modal" href="#" data-toggle="modal" data-target="#add_attendance_records"><i class="fa fa-plus"></i> <?php echo lang('add_attendance_records'); ?></a>
          </div>
          <div class="col-sm-5  text-right m-b-20">     
              <a class="btn back-btn" href="<?=base_url()?>attendance/"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
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
            <form method="post" action="">
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group ">
                  <label><?=lang('employees_code')?></label>
                  <input type="text" class="form-control" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                  <label><?=lang('employees')?></label>
                  <select class="select2-option form-control" name="user_id" id="user_name">
                        <optgroup label="">
                        <option value=""><?php echo lang('select_employee');?></option> 
                            <?php 
                            $employee = $this->db->get_where('users',array('role_id'=>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result();


                            foreach ($employee as $c): 
                            ?>

                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
                            <?php endforeach;  ?>
                        </optgroup>
                    </select>
                </div>
              </div>
              <?php $departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("deptname", "asc")->get('departments')->result(); ?>
              <div class="col-md-3 col-sm-3 col-xs-6">
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
         

              <div class="col-md-3 col-sm-3 col-xs-6">  
                <div class="form-group">
                  <label><?=lang('year')?></label>
                  <select class="select2-option form-control" id="attendance_year" name="attendance_year"> 
                    <option value="" selected="selected" disabled><?=lang('select_year'); ?></option>
                    <?php for($k =$e_year;$k>=$s_year;$k--){ 
                      $sele2='';
                       if(isset($_POST['attendance_year']) && !empty($_POST['attendance_year']))
                      {
                        if($_POST['attendance_year']==$k)
                        {
                          $sele2='selected';
                        }
                      }

                      ?>
                    <option value="<?php echo $k; ?>" <?php echo $sele2;?> ><?php echo $k; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group ">
                  <label><?=lang('turn')?></label>
                  <input type="text" class="form-control" name = "turn" value="">
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                  <label><?=lang('rangeof_time')?></label>
                  <input type="text" name="range" id="reportrange" class="pull-right form-control" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <span></span> <b class="caret"></b>
                </div>
              </div>
             
              <div class="col-md-3 col-sm-3 col-xs-6">  
                <label class="d-block">&nbsp;</label>
                 <button type="submit" class="btn btn-success btn-block"><?php echo lang('search');?></button> 
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
                      <th>#</th>
                      <th><?php echo lang('employee_code')?> </th>
                      <th><?php echo lang('name')?></th>
                      <th><?php echo lang('date')?></th>
                      <th><?php echo lang('hour')?></th>
                      <th><?php echo lang('incident')?></th>
                      <th><?php echo lang('shift')?></th>
                      <th><?php echo lang('device_details')?></th>
                      <th><?php echo lang('record_manually_made')?></th>
                      <th><?php echo lang('action')?></th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    // if(isset($_POST['attendance_month']) && !empty($_POST['attendance_month']))
                    // {
                    //   $a_month=$_POST['attendance_month'];
                    // }

                    //  if(isset($_POST['attendance_year']) && !empty($_POST['attendance_year']))
                    // {
                    //   $a_year=$_POST['attendance_year'];
                    // }
                  $user_id = array();
                 if(!empty($_POST['id_code']) || !empty($_POST['user_id']) || !empty($_POST['department_id']) || !empty($_POST['attendance_year']) || !empty($_POST['range']))
                { 
                  // print_r($_POST); exit();
                  if(isset($_POST['id_code']) && !empty($_POST['id_code'])){
                    $users= $this->db->get_where('users',array('id_code'=>$_POST['id_code'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                    if(!empty($users)){
                      $user_id[] = $users['id'];
                    }else{
                      $user_id =array();
                    }
                  } 
                  if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
                    $user_id[] = $_POST['user_id'];
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
                    // echo $dept_users;die;
                    if(!empty($dept_users)){
                      foreach ($dept_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }
                  if(isset($_POST['attendance_year']) && !empty($_POST['attendance_year'])){
                    $team_users= $this->db->get_where('attendance_details',array('a_year'=>$_POST['attendance_year'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
                    $a_year = $_POST['attendance_year'];
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
                      // $all_users = $this->db->get_where('users',array('role_id !='=>2,'role_id !='=>1,'activated'=>1,'banned'=>0))->result_array();
                      $this->db->where('a_month >=', $start_month);
                      $this->db->where('a_month <=', $end_month);
                      $this->db->where('a_year >=', $start_year);
                      $this->db->where('a_year <=', $end_year);
                      $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
                      $all_users =  $this->db->get('attendance_details')->result_array();
                        // echo $this->db->last_query();  exit;
                       if(!empty($all_users)){
                        foreach ($all_users as $key => $value) {
                          $user_id[] = $value['user_id'];
                        }
                      }
                    }
                  } 
                  $user_ids =  array_unique($user_id);
                 
                   
                    $this->db->where_in('user_id', $user_ids);
                    $this->db->where('a_month',$start_month);
                    $this->db->where('a_year',$start_year);
                    $this->db->select('user_id,month_days,month_days_in_out');
                    $results  = $this->db->get('dgt_attendance_details')->result_array();
                     // echo $this->db->last_query(); 
                     // echo '<pre>';print_r($results); exit;
                } else{

                  $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                  if($dept_id !=0){                   
                     //$dept_users= $this->db->get_where('users',array('department_id'=>$dept_id,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
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
                      $user_ids =  array_unique($user_id);
                 
                   
                    $this->db->where_in('user_id', $user_ids);     
                    $this->db->where('a_month',$a_month);
                    $this->db->where('a_year',$a_year);               
                    $this->db->select('user_id,month_days,month_days_in_out');
                    $results  = $this->db->get('dgt_attendance_details')->result_array();
                  }     
                  if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){  
                    $where     = array('a_month'=>$a_month,'a_year'=>$a_year,'subdomain_id'=>$this->session->userdata('subdomain_id'));
                     $this->db->select('user_id,month_days,month_days_in_out');
                     $results  = $this->db->get_where('dgt_attendance_details',$where)->result_array();
                }

                   

              }

                     // echo '<pre>';print_r($_POST['range']); exit();
                     
                     
                     $sno=1;
                     
                   

                          $list=array();
                          //  if(isset($_POST['range']) && !empty($_POST['range'])){
                          //   $number = $col_count;
                          //   $start_val = 0;
                          // }else{
                          //   $month = $a_month;
                          //   $year = $a_year;

                          //   $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                          //   $start_val = 1;

                          // }

                         // $month = $a_month;
                         //    $year = $a_year;
                           // echo  $day; exit();
                           if(isset($_POST['range']) && !empty($_POST['range'])){
                            $number = $col_count;
                            $start_val = 0;
                            $month = $start_month;
                            $year = $start_year;

                           for($d=$start_val; $d<=$number; $d++)
                           {
                            $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                                   
                              // if (date('m', $time)==$month)       
                                  $date=date('d M Y', $time);
                                  $schedule_date=date('Y-m-d', $time);
                                  $a_day =date('d', $time);

                                   $a_day -=1;

                                    foreach ($results as $rows) {

                                   

                                     if(!empty($rows['month_days_in_out'])){

                                     $month_days_in_outs =  unserialize($rows['month_days_in_out']);

                                      $i =1;   

                                       // foreach ($month_days_in_outs[$a_day] as $key => $punch_details) 
                                      // {
                                      $total_records = count($month_days_in_outs[$a_day]);
                                      $key = $total_records-1;
                                        $latest_inout = end($month_days_in_outs[$a_day]);
                                        $punch_date = $a_day+1;
                                        if(!empty($latest_inout['punch_in']) || !empty($latest_inout['punch_out'])){
                                           // if($punch_date == 11){ 

                                           
                                     // echo '<pre>'; print_r($latest_inout). '<br>';
                                     //  echo '<pre>';print_r($punch_details);exit;
                                         // echo '<pre>';print_r($punch_details); 
                                        ?>
                                          <tr>
                                            <td><?php echo $sno++;?></td>
                                            <td><?php $user = $this->db->get_where('users',array('id'=>$rows['user_id']))->row_array();  echo $user['id_code'];?></td>
                                            <td><?php echo ucfirst(user::displayName($rows['user_id']));?></td>
                                            <td><?php echo date($punch_date.'/'.$month.'/'.$year);?></td>
                                          <?php if(!empty($latest_inout['punch_out']))
                                        {
                                           $punch = 'punch_out';
                                           $workcode = isset($latest_inout['punchout_workcode'])?$latest_inout['punchout_workcode']:0;
                                           $manually_made = $latest_inout['punch_out_manually_made'];
                                          ?>
                                          
                                          <td><?php echo  $latest_inout['punch_out'];?></td>
                                           <td><?php $incidents = $this->db->order_by("id", "asc")->get_where('incidents',array('id'=>$latest_inout['punchout_workcode'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); 
                                            echo (!empty($incidents['incident_name']))?$incidents['incident_name']:"-";?></td>
                    
                                          <!-- echo $a_day.' '.$punch_details['punch_in'].$rows['user_id'].'<br>'; -->
                                       <?php  } else{
                                        $punch = 'punch_in';
                                        $workcode = isset($latest_inout['punchin_workcode'])?$latest_inout['punchin_workcode']:0;
                                        $manually_made = $latest_inout['punch_in_manually_made'];
                                        ?>
                                        <td><?php echo $latest_inout['punch_in'];?></td>
                                        <td><?php $incidents = $this->db->order_by("id", "asc")->get_where('incidents',array('id'=>$latest_inout['punchin_workcode'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); 
                                            echo (!empty($incidents['incident_name']))?$incidents['incident_name']:"";?></td>
                                      <?php }

                                        
                                        

                                        ?>
                                   
                                    <td><?php $shift_scheduling = $this->db->get_where('shift_scheduling',array('employee_id'=>$rows['user_id'],'subdomain_id'=>$this->session->userdata('subdomain_id'),'schedule_date'=>date($year.'-'.$month.'-'.$punch_date)))->row_array(); 
                                    if(!empty($shift_scheduling)){
                                       $shift = $this->db->get_where('shifts',array('id'=>$shift_scheduling['shift_id']))->row_array(); 
                                    } else{
                                      $shift['shift_name']= '';
                                    }
                                   
                                    echo (!empty($shift['shift_name']))?$shift['shift_name']:"";?></td>
                                    <td><?php echo $latest_inout['deviceid'];?></td>
                                    <td><?php echo (isset($manually_made) && $manually_made=='yes')?'Yes':'No';?></td>  
                                    <td><a class="pull-right text-success" href="<?php echo base_url().'attendance/edit_attendance/'.$rows['user_id'].'/'.$a_day.'/'.$month.'/'.$year.'/'.$key.'/'.$punch.'/'.$workcode?>"  data-toggle="ajaxModal"><i class="fa fa-pencil"></i></a>
                                    </td>

                                     <?php 
                                   // } 
                                        }
                                        
                                     
                                          
                                       
                                       
                                    
                                    // }
                                    }

                                  }?>
                                  

                                <?php  } 
                           }else{

                             $month = $a_month;
                          $year = $a_year;

                          $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                          $number = date('d');
                              for($d=$number; $d>=1; $d--)
                           {
                              $time=mktime(12, 0, 0, $month, $d, $year);          
                              if (date('m', $time)==$month)       
                                  $date=date('d M Y', $time);
                                  $schedule_date=date('Y-m-d', $time);
                                  $a_day =date('d', $time);

                                   $a_day -=1;

                                    foreach ($results as $rows) {

                                   

                                     if(!empty($rows['month_days_in_out'])){

                                     $month_days_in_outs =  unserialize($rows['month_days_in_out']);

                                      $i =1;   

                                       // foreach ($month_days_in_outs[$a_day] as $key => $punch_details) 
                                      // {
                                      $total_records = count($month_days_in_outs[$a_day]);
                                      $key = $total_records-1;
                                        $latest_inout = end($month_days_in_outs[$a_day]);
                                        $punch_date = $a_day+1;
                                        if(!empty($latest_inout['punch_in']) || !empty($latest_inout['punch_out'])){
                                           // if($punch_date == 11){ 

                                           
                                     // echo '<pre>'; print_r($latest_inout). '<br>';
                                     //  echo '<pre>';print_r($punch_details);exit;
                                         // echo '<pre>';print_r($punch_details); 
                                        ?>
                                          <tr>
                                            <td><?php echo $sno++;?></td>
                                            <td><?php $user = $this->db->get_where('users',array('id'=>$rows['user_id']))->row_array();  echo $user['id_code'];?></td>
                                            <td><?php echo ucfirst(user::displayName($rows['user_id']));?></td>
                                            <td><?php echo date($punch_date.'/'.$month.'/'.$year);?></td>
                                          <?php if(!empty($latest_inout['punch_out']))
                                        {
                                           $punch = 'punch_out';
                                           $workcode = isset($latest_inout['punchout_workcode'])?$latest_inout['punchout_workcode']:0;
                                           $manually_made = $latest_inout['punch_out_manually_made'];
                                          ?>
                                          
                                          <td><?php echo  $latest_inout['punch_out'];?></td>
                                           <td><?php $incidents = $this->db->order_by("id", "asc")->get_where('incidents',array('id'=>$latest_inout['punchout_workcode'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); 
                                            echo (!empty($incidents['incident_name']))?$incidents['incident_name']:"-";?></td>
                    
                                          <!-- echo $a_day.' '.$punch_details['punch_in'].$rows['user_id'].'<br>'; -->
                                       <?php  } else{
                                        $punch = 'punch_in';
                                        $workcode = isset($latest_inout['punchin_workcode'])?$latest_inout['punchin_workcode']:0;
                                        $manually_made = $latest_inout['punch_in_manually_made'];
                                        ?>
                                        <td><?php echo $latest_inout['punch_in'];?></td>
                                        <td><?php $incidents = $this->db->order_by("id", "asc")->get_where('incidents',array('id'=>$latest_inout['punchin_workcode'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); 
                                            echo (!empty($incidents['incident_name']))?$incidents['incident_name']:"";?></td>
                                      <?php }

                                        
                                        

                                        ?>
                                   
                                    <td><?php $shift_scheduling = $this->db->get_where('shift_scheduling',array('employee_id'=>$rows['user_id'],'schedule_date'=>date($year.'-'.$month.'-'.$punch_date)))->row_array(); 
                                    if(!empty($shift_scheduling)){
                                       $shift = $this->db->get_where('shifts',array('id'=>$shift_scheduling['shift_id']))->row_array(); 
                                    } else{
                                      $shift['shift_name']= '';
                                    }
                                   
                                    echo (!empty($shift['shift_name']))?$shift['shift_name']:"";?></td>
                                    <td><?php echo $latest_inout['deviceid'];?></td>
                                    <td><?php echo (isset($manually_made) && $manually_made=='yes')?'Yes':'No';?></td>  
                                    <td><a class="pull-right text-success" href="<?php echo base_url().'attendance/edit_attendance/'.$rows['user_id'].'/'.$a_day.'/'.$month.'/'.$year.'/'.$key.'/'.$punch.'/'.$workcode?>"  data-toggle="ajaxModal"><i class="fa fa-pencil"></i></a>
                                    </td>

                                     <?php 
                                   // } 
                                        }
                                        
                                     
                                          
                                       
                                       
                                    
                                    // }
                                    }

                                  }?>
                                  

                                <?php  } 
                           }
                            ?>
                          

                  </tbody>
                </table>
              </div>
                        </div>
                    </div>
                </div>
        <!-- /Page Content -->

        <!-- Family Info Modal -->
        <div id="add_attendance_records" class="modal custom-modal fade" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('add_attendance_records');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post" id="add_attendance" action="<?php echo base_url(); ?>attendance/add_attendance_records">
                  <div class="form-scroll">
                    <div class="card-box AllAttendanceRecords">
                     
                      <div class="AttendanceRecords">
                        <h3 class="card-title"><?php echo lang('add_attendance_records');?> </h3>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label><?php echo lang('employees');?> <span class="text-danger">*</span></label>
                              <select class=" form-control" name="user_id[]" id="user_name">
                        <optgroup label="">
                        <option value=""><?php echo lang('select_employee');?></option> 
                            <?php 
                            $employee = $this->db->get_where('users',array('role_id'=>3,'activated'=>1,'banned'=>0 ,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result();


                            foreach ($employee as $c): 
                            ?>

                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo ucfirst(User::displayName($c->id));?></option>
                            <?php endforeach;  ?>
                        </optgroup>
                    </select>
                            </div>
                          </div>
                           <div class="col-md-6">
                            <div class="form-group">
                              <label><?php echo lang('date')?> <span class="text-danger">*</span></label>
                              <input class="form-control punch_date" type="text" name="punch_date[]" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label><?php echo lang('punch');?> <span class="text-danger">*</span></label>
                              <select class=" form-control" name="punch[]" id="punch">
                                <option value="" selected="selected" disabled="disabled"><?php echo lang('select_punch');?></option>
                                <option value="punch_in"><?php echo lang('punch_in');?></option>
                                <option value="punch_out"><?php echo lang('punch_out');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label><?php echo lang('time');?> <span class="text-danger">*</span></label>
                              <input class="form-control  time_picker" type="text" name="punch_time[]" >
                            </div>
                          </div>
                          <?php $incidents = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("id", "asc")->get('incidents')->result(); ?>
                          <div class="col-md-6">
                            <div class="form-group">
                            <label><?php echo lang('incidents');?> </label>                            
                            <select class="select form-control"  name="workcode[]" id="workcode">
                                <option value="" selected><?php echo lang('select_incidents');?></option>
                                <?php
                                if(!empty($incidents)) {
                                foreach ($incidents as $incident){ ?>
                                <option value="<?=$incident->id?>"><?php echo Ucfirst($incident->incident_name)?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                          </div>   
                          </div>
                        </div>
                      </div>
                      <div class="add-more">
                        <a href="#" id="add_more_attendance"><i class="fa fa-plus-circle"></i> <?php echo lang('add_more'); ?></a>
                      </div>
                    </div>
                  </div>
                  <div class="submit-section">
                    <button class="btn btn-primary submit-btn"><?php echo lang('submit'); ?></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /Family Info Modal -->


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