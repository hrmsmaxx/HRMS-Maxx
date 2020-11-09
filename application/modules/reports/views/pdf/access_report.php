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
  <h3 class="reports-headerspacing"><b><?=lang('access_report')?></b></h3>
  <?php if($client != NULL){ ?>
  <h5><span><?=lang('client_name')?>:</span>&nbsp;<?=$customer->company_name?>&nbsp;</h5>
  <?php } ?>
</div>

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
   $subdomain_id     = $this->session->userdata('subdomain_id');
   $where     = array('subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
   // $this->db->select('month_days,month_days_in_out');
   $record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();
   ?>

         <table border="0"cellpadding="0" cellspacing="0" height="100%" width="1200px" class="inside-report">
            <thead>
              <tr class="attendance_record" style="background:#cbcbcb">                
                  <th align="left" valign="middle" style="font-weight:bold!important;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('date')?></th>
                  <th align="left" valign="middle" style="font-weight:700;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('employee')?></th>
                  <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('time')?></th>
                 
              </tr>
            </thead>
            <tbody>
				<?php 
         $user_id = array();
        if(!empty($_POST['id_code']) || !empty($_POST['user_id']) || !empty($_POST['department_id']) || !empty($_POST['teamlead_id']) || !empty($_POST['range']))
                { 
                    
                 
                  if(isset($_POST['id_code']) && !empty($_POST['id_code'])){

                    $users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id_code'=>$_POST['id_code']))->row_array();
 
                    if(!empty($users)){
                      $user_id[] = $users['id'];
                    }else{
                      $user_id ='';
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
            }
            $users_id =  array_unique($user_id); 
            $sno=0;
            foreach ($users_id as $key => $value) {

              if($value !=1){                    
                $user_id = $value;                       
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

                    if($branch_id != '') {
                        $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                    }
                    $results = $this->db->select('month_days,month_days_in_out')
                                ->from('attendance_details ad')
                                ->join('users u', 'u.id=ad.user_id')
                                ->where(array('user_id'=>$user_id, 'a_month '=>$a_month, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id,'u.id!='=>$this->session->userdata('user_id')))
                                ->get()
                                ->result_array();

                   /*$where     = array('subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                   $this->db->select('month_days,month_days_in_out');
                   $results  = $this->db->get_where('dgt_attendance_details',$where)->result_array();*/
                   
                  }
                   
                     
                  
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
                            /*$this->db->select('month_days,month_days_in_out');
                            $this->db->where('user_id', $user_id);
                            $this->db->where('a_month ', $a_month);
                            // $this->db->where('a_month <=', $end_month);
                            // $this->db->where('a_year >=', $start_year);
                            $this->db->where('a_year ', $a_year);
                            $this->db->where('subdomain_id', $subdomain_id);
                            $rows =  $this->db->get('attendance_details')->row_array(); */
                            if($branch_id != '') {
                                $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                            }
                            $rows = $this->db->select('month_days,month_days_in_out')
                                        ->from('attendance_details ad')
                                        ->join('users u', 'u.id=ad.user_id')
                                        ->where(array('user_id'=>$user_id, 'a_month '=>$a_month, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id,'u.id!='=>$this->session->userdata('user_id')))
                                        ->get()
                                        ->row_array();

                          if(!empty($rows['month_days'])){


                          $month_days =  unserialize($rows['month_days']);
                          $month_days_in_out =  unserialize($rows['month_days_in_out']);
                          $day = $month_days[$a_day-1];
                          $day_in_out = $month_days_in_out[$a_day-1];
                          $latest_inout = end($day_in_out);
                               
                                 
                                 $k = 1;
                               
                        
                             $user_details= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id'=>$user_id))->row_array();
              $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();                    
              if(!empty($user_details['designation_id'])){
                          $designation = $this->db->get_where('designation',array('subdomain_id'=>$subdomain_id,'id'=>$user_details['designation_id']))->row_array();
                          $designation_name = $designation['designation'];
                          
                        }else{
                          $designation_name = '-';
                        }
                    

                      $production_hour=0;
                                 $break_hour=0;
                                 $k = 1;
                                
                                foreach ($month_days_in_out[$a_day-1] as $punch_detail) 
                                {
                                   if(!empty($punch_detail['punch_in']) )
                                    { ?>
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
                                            <?php echo '-> '.$punch_detail['punch_in'];?>
                                          </td>
                                        </tr>
                                        
                                      </table>
                                    </td> 
                    
                                  </tr>
                                  <?php  $sno++;?>
                                   <?php  }
                                    if(!empty($punch_detail['punch_out'])){?>
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
                                            <?php echo '<- '.$punch_detail['punch_out'];?>
                                          </td>
                                        </tr>
                                        
                                      </table>
                                    </td> 
                    
                                  </tr>
                                  <?php  $sno++;?>
                  <tr class="<?php echo $sno;?>" style="background-color:<?php echo ($sno % 2 == 0)?'#fff':'#eee';?>;font-family:'Open Sans',arial,sans-serif!important;">
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                            <?php echo lang('attendance_time');  ?>
                          </td>
                        </tr>
                        
                      </table>
                    </td>
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                            <?php  $production_hour = time_difference(date('H:i',strtotime($punch_detail['punch_in'])),date('H:i',strtotime($punch_detail['punch_out'])));?>
                      <?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?>
                          </td>
                        </tr>
                        
                      </table>
                    </td>
                    <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tr>
                          <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                            <?php echo '';?>
                          </td>
                        </tr>
                        
                      </table>
                    </td>
                    
                  </tr>

                                  <?php $production_hour = 0;  $sno++;  }
                                     
                                }?>
                     
                      <?php
 }  } } } } ?>
					
				</tbody>
			</table>
    </div>