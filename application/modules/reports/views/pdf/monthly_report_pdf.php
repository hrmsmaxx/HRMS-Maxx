<link rel="stylesheet" href="<?=base_url()?>assets/css/app.css" type="text/css" />
<style type="text/css">
  .pure-table td, .pure-table th {
    border-bottom: 1px solid #cbcbcb;
    border-width: 0 0 0 1px;
    margin: 0;
    overflow: visible;
    padding: .5em 1em;
}
.table td {
    vertical-align: middle !important;
}
.table tr th {
    font-weight: 600px;
}
.inside-report + tbody + tr:nth-child(odd) {
 background-color: #fff;
}

.inside-report + tbody + tr:nth-child(even) {
 background-color:#cbcbcb;
}
</style>
<?php 
$branch_id = $this->session->userdata('branch_id');
$subdomain_id     = $this->session->userdata('subdomain_id');
$night_hours = $this->db->get_where('night_hours',array('subdomain_id' =>$subdomain_id ))->row_array();
ini_set('memory_limit', '-1');
$cur = App::currencies(config_item('default_currency')); 
$customer = ($client > 0) ? Client::view_by_id($client) : array();
$report_by = (isset($report_by)) ? $report_by : 'all';
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
?>


<div class="rep-container">
  <div class="page-header text-center">
  <h3 class="reports-headerspacing"><b><?=lang('monthly_report')?></b></h3>
  <?php if($client != NULL){ ?>
  <h5><span><?=lang('client_name')?>:</span>&nbsp;<?=$customer->company_name?>&nbsp;</h5>
  <?php } ?>
</div>


         <table border="0"cellpadding="0" cellspacing="0" height="100%" width="1200px" class="inside-report">" 
            <thead>
              <meta http-equiv="content-type" content="text/html; charset=UTF-8">
              <tr class="attendance_record" style="background-color:#cbcbcb;">                
                  <th align="left" valign="middle" style="font-weight:bold!important;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo lang('id_code');?></th>
                  <th align="left" valign="middle" style="font-weight:700;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo lang('name');?></th>
                  <?php               
                    $last_day = $a_year.'-'.$a_month.'-1';
                    $last_day = date('t',strtotime($last_day));  
                     for ($ik = 1; $ik <= $last_day; $ik++) {
                    $date = $a_year.'-'.$a_month.'-'.$ik; ?>
                    <th align="left" valign="middle" style="font-weight:700;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo  lang(date('M',strtotime($date))).' '.lang($ik); ?></th>
                  <?php  }?>
                  <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo lang('total_worked_days');?></th>
                  <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo lang('total_hours_extras');?></th>
                  <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo lang('total_hours_night');?></th>
                  <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?php echo lang('total_hours_extra_night');?></th>
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
                         
                         <tr style="background-color:<?php echo ($sno % 2 == 0)?'#fff':'#eee';?>;font-family:'Open Sans',arial,sans-serif!important;">
                          <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                          <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                       <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                          <?php echo ucfirst(user::displayName($value));?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                            
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
                         <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;color:#25b932;">
                          <p>&#10004;</p>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                       
                       <?php   
                        }
                        else
                        { ?>
                          
                           <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                              <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                                <tr>
                                  <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;color:#ef0f48;">
                                <p>&#10006;</p>
                                  </td>
                                </tr>
                                
                              </table>
                            </td>
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
                         <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                              <tr>
                                <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;color:#25b932;">
                              <p>&#10004;</p>
                                </td>
                              </tr>
                              
                            </table>
                          </td>
                         
                        <?php   $actually_worked++;
                           
                        } else {?>
                            <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                              <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                                <tr>
                                  <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;color:#ef0f48;">
                               <p>&#10006;</p>
                                  </td>
                                </tr>
                                
                              </table>
                            </td>
                         
                          
                       <?php } ?>
                                           
                      <?php  
                      }
                     ?>
                     
                    
                    
                    <?php } } ?>
                     <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                          <?php echo $actually_worked;?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                      <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                            <?php echo !empty($total_hours_extras)?intdiv($total_hours_extras, 60).'.'. ($total_hours_extras % 60).''.lang('hrs'):'0 '.''.lang('hrs');?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                      <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                            <?php echo !empty($total_night_production_hour)?intdiv($total_night_production_hour, 60).'.'. ($total_night_production_hour % 60).''.lang('hrs'):'0 '.''.lang('hrs');?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                       <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                            <?php echo !empty($total_extra_night_production_hour)?intdiv($total_extra_night_production_hour, 60).'.'. ($total_extra_night_production_hour % 60).''.lang('hrs'):'0 '.''.lang('hrs');?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
                    
                    </tr>
                   
                    <?php   
                     // } 
                   } 
                   }  else {?>
            <tr><td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                          <tr>
                            <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                           <?php echo lang('no_records_found')?>
                            </td>
                          </tr>
                          
                        </table>
                      </td>
              
            
            </tr>
          <?php  } ?>
            </tbody>
          </table>
      </div>






     <!--Empty table--->
      
      <!--/Empty table-->