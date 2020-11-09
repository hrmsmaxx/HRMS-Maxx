<link rel="stylesheet" href="<?=base_url()?>assets/css/app.css" type="text/css" />
<style type="text/css">
  .pure-table td, .pure-table th {
    border-bottom: 1px solid #cbcbcb;
    border-width: 0 0 0 1px;
    margin: 0;
    overflow: visible;
    padding: .5em 1em;
}
.pure-table .table td {
    vertical-align: middle !important;
}
</style>
<?php 
ini_set('memory_limit', '-1');
$cur = App::currencies(config_item('default_currency')); 
$customer = ($client > 0) ? Client::view_by_id($client) : array();
$report_by = (isset($report_by)) ? $report_by : 'all';
?>


<div class="rep-container">
  <div class="page-header text-center">
  <h3 class="reports-headerspacing"><b><?=lang('department_workday_report')?></b></h3>
  <?php if($client != NULL){ ?>
  <h5><span><?=lang('client_name')?>:</span>&nbsp;<?=$customer->company_name?>&nbsp;</h5>
  <?php } ?>
</div>

<?php 
$branch_id = $this->session->userdata('branch_id');

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
$subdomain_id     = $this->session->userdata('subdomain_id');

if($branch_id != '') {
    $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
}
$record = $this->db->select('ad.*')
                ->from('attendance_details ad')
                ->join('users u', 'u.id=ad.user_id')
                ->where(array('a_month'=>$a_month,'a_year'=>$a_year, 'ad.subdomain_id'=> $subdomain_id))
                ->get()
                ->result_array();

/*$where     = array('subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
// $this->db->select('month_days,month_days_in_out');
$record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();*/

$user_id = array();   
if(!empty($_POST['department_id']) || !empty($_POST['range']))
{               
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
    $from_date1 = date("M-d-Y", $start_time);       
    $to_date1 = date("M-d-Y", $end_date);
    $col_count = $later->diff($earlier)->format("%a");
       
    if(empty($user_id)){
       // echo "<pre>";   print_r($_POST); exit;
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
                    ->where(array('a_month >='=>$start_month, 'a_month <='=>$end_month, 'a_year >='=>$start_year,'a_year <='=>$end_year, 'ad.subdomain_id'=> $subdomain_id))
                    ->get()
                    ->result_array();
      // echo "<pre>";   print_r($all_users); exit;
       if(!empty($all_users)){
        foreach ($all_users as $key => $value) {

          $user_ids[] = $value['user_id'];
          
        }
        $user_id = $user_ids;
      }
    }
     
  }

} else{                
      if(!empty($record)){
          foreach ($record as $key => $value) {
            $user_id[] = $value['user_id'];
          }
    }
    $from_date1 = date("M-d-Y");       
      $to_date1 = date("M-d-Y");
}
  $users_id =  array_unique($user_id);
?>
  <div class="page-header text-center m-t-0 border-none " style="align-items: center;" >
        <h3><b><?=lang('department')?></b> - <span class="text-success"><?php echo (isset($_POST['department_id']) && !empty($_POST['department_id']))?ucfirst(user::GetDepartmentNameById($_POST['department_id'])):lang('all');?></span></h3>
        <h5><span><?=lang('from')?></span>&nbsp;<?php echo $from_date1;?>&nbsp;<span><?=lang('to')?></span>&nbsp;<?php echo $to_date1;?></h5>
      </div>
  <table id="table-late_arrival_report" border="0"cellpadding="0" cellspacing="0" height="100%" width="1200px" class="inside-report">
    <thead>
      <tr class="attendance_record" style="background-color:#cbcbcb;">                
          <th align="left" valign="middle" style="font-weight:bold!important;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('workday')?></th>
          <th align="left" valign="middle" style="font-weight:700;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('faulty_employees')?></th>
          <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('work_time')?></th>
          <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('late_arrivals')?></th>
          <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('missing_work')?></th>
         
      </tr>
    </thead>
    <tbody>
 
   <?php foreach ($users_id as $key => $value) {
                    
      $user_id = $value;

      $user_details= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id'=>$user_id))->row_array();
      $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();
      if(!empty($user_details['designation_id'])){
        $designation = $this->db->get_where('designation',array('subdomain_id'=>$subdomain_id,'id'=>$user_details['designation_id']))->row_array();
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
       
       // print_r($_POST['range']); exit;
      if(isset($_POST['range']) && !empty($_POST['range'])){
        /*$this->db->select('month_days,month_days_in_out');
        $this->db->where('user_id', $user_id);
        $this->db->where('a_month ', $start_month);
        // $this->db->where('a_month <=', $end_month);
        // $this->db->where('a_year >=', $start_year);
        $this->db->where('a_year ', $start_year);
        $this->db->where('subdomain_id', $subdomain_id);
        $results =  $this->db->get('attendance_details')->result_array();*/

        if($branch_id != '') {
            $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
        }
        $results = $this->db->select('month_days,month_days_in_out')
                    ->from('attendance_details ad')
                    ->join('users u', 'u.id=ad.user_id')
                    ->where(array('user_id'=>$user_id, 'a_month '=>$start_month, 'a_year '=>$start_year,'ad.subdomain_id'=> $subdomain_id))
                    ->get()
                    ->result_array();

      } else{
        $a_year    = date('Y');
        $a_month   = date('m');

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
       /*$this->db->select('month_days,month_days_in_out');
       $results  = $this->db->get_where('dgt_attendance_details',$where)->result_array();*/
       
      }                    
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
                
                $sno=0;
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
                  /*$this->db->select('month_days,month_days_in_out');
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
                  $shift =  $this->db->get_where('shifts',array('id' => $user_schedule['shift_id']))->row_array(); 
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
                      $shift_id[] = $value['shift_id']; 
                      # code...
                    }
                    $total_scheduled_minutes = $scheduled_minutes;
                   
                  }


                  if(!empty($rows['month_days'])){

                      $month_days =  unserialize($rows['month_days']);
                      $month_days_in_out =  unserialize($rows['month_days_in_out']);
                      $day = $month_days[$a_day-1];
                      $day_in_out = $month_days_in_out[$a_day-1];
                      $latest_inout = end($day_in_out);
                      if(isset($day['punchin_workcode']) && !empty($day['punchin_workcode'])){
                         $punchin_workcodes =  $this->db->get_where('incidents',array('subdomain_id'=>$subdomain_id,'id' => $day['punchin_workcode']))->row_array();
                         $punchin_workcode= '('.$punchin_workcodes['incident_name'].')';
                      }else{
                        $punchin_workcode ='';
                      }
                      if(isset($day['punchout_workcode']) && !empty($day['punchout_workcode'])){
                        $punchout_workcodes=  $this->db->get_where('incidents',array('subdomain_id'=>$subdomain_id,'id' => $day['punchout_workcode']))->row_array(); 
                         $punchout_workcode= '('.$punchout_workcodes['incident_name'].')';
                       }else{
                        $punchout_workcode ='';
                       }
                       $production_hour=0;
                       $break_hour=0;
                       $k = 1;
                      foreach ($month_days_in_out[$a_day-1] as $punch_detail) 
                      {

                          if(!empty($punch_detail['punch_in']) && !empty($punch_detail['punch_out']))
                          {
                              $days = $a_day;
                            // $today_work_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-'.$days));
                            //   $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                              $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$schedule_date.'" AND ((start_time <= "'.$punch_detail['punch_in'].'" and end_time >="'.$punch_detail['punch_in'].'") or (start_time >= "'.$punch_detail['punch_in'].'")) limit 1')->row_array();
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
                            

                              $production_hour += time_difference(date('H:i',strtotime($punch_detail['punch_in'])),date('H:i',strtotime($punch_detail['punch_out'])));
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
                                              
                      $missing_work=($total_scheduled_minutes)-($production_hour);
                      // echo $missing_work; exit;
                      if($missing_work > 0)
                      {
                        $missing_work=$missing_work;                                 
                      }
                      else
                      {
                        $missing_work=0;
                        
                      }?>


                 
           
                  <?php
                  if(!empty($user_schedule))
                  {                              
                    if(!empty($day['punch_in']))
                    {
                       $later_entry_hours = later_entry_hours($user_schedule['schedule_date'].' '.$user_schedule['max_start_time'],$schedule_date.' '.$day['punch_in']);
                       
                       
                    } else {
                      $later_entry_hours = '-';                              
                    }?>
                    <tr class="<?php echo $sno;?>" style="background-color:<?php echo ($sno % 2 == 0)?'#fff':'#eee';?>;font-family:'Open Sans',arial,sans-serif!important;">
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;color:#333333;">
                          <?php echo $new_date ;?>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" style="text-transform:capitalize;font-size:14px;color:#333;">
                           <?php echo date('l', $time)?>
                          </td>
                        </tr>
                      </table>
                        
                    </td>
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;color:#333333;">
                            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                              <tr>
                                <td width="40px" style="min-width: 40px">
                                   <img class="avatar" style="background-color: transparent;border-radius: 30px;display: inline-block;font-weight: 500;height: 38px;line-height: 38px;overflow: hidden;text-align: center;text-decoration: none;text-transform: uppercase;vertical-align: middle;width: 38px;position: relative;" src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>">
                                </td>
                                <td>
                                  <h2 style="display: inline-block;font-size: inherit;font-weight: 400;margin: 0;padding: 0;vertical-align: middle;"><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span></h2>
                                    <span class="userrole-info"> <?php echo $designation_name;?></span>
                                    <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span>
                                </td>
                              </tr>                              
                            </table>
                          </td>
                        </tr>
                      </table>  
                    </td>
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                           <?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?>
                          </td>
                        </tr>
                        
                      </table>
                    </td>
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                           <?php echo $later_entry_hours;?>
                          </td>
                        </tr>
                        
                      </table>
                    </td>
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                           <?php echo !empty($missing_work)?intdiv($missing_work, 60).'.'. ($missing_work % 60).' hrs':'-';?>
                          </td>
                        </tr>
                        
                      </table>
                    </td>
                  </tr>
                <?php }?>
                
              <?php 
              }
          $sno++;}  
        } 
      } ?>              
		</tbody>
	</table>
</div>