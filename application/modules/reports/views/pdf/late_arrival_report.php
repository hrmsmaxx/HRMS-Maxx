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
  <h3 class="reports-headerspacing"><b><?=lang('late_arrival_report')?></b></h3>
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
   ?>

         <table id="table-late_arrival_report" border="0"cellpadding="0" cellspacing="0" height="100%" width="1200px" class="inside-report">
            <thead>
              <tr class="attendance_record" style="background-color:#cbcbcb;">                
                  <th align="left" valign="middle" style="font-weight:bold!important;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('employee')?></th>
                  <th align="left" valign="middle" style="font-weight:700;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('late_arrivals')?></th>
                  <th align="left" valign="middle" style="font-weight:900;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;font-size:16px;"><?=lang('accumulated_time')?></th>
                 
              </tr>
            </thead>
            <tbody>
				<?php 
         $user_id = array();
        if(!empty($_POST['range']))
                { 
                    
                 
                  
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
                    $where     = array('ad.subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
                    if($branch_id != '') {
                        $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                    }
                    $record = $this->db->select('ad.*')
                                ->from('attendance_details ad')
                                ->join('users u', 'u.id=ad.user_id')
                                ->where($where)
                                ->get()
                                ->result_array();

                  /*$where     = array('subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
                  $record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();  */           
                  if(!empty($record)){
                    foreach ($record as $key => $value) {
                    $user_id[] = $value['user_id'];
                  }
                }
            }
            $users_id =  array_unique($user_id);

            // echo "<pre>";   print_r($user_id);             
            $later_entry_hours = 0;
            $user_absent = array();
            $user_time = array();
           $sno=0;
            foreach ($users_id as $key => $value) {
              if($value !=1){                    
                $user_id = $value;
                $user_details= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id'=>$user_id))->row_array();
                $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();
                          
                if(isset($_POST['range']) && !empty($_POST['range'])){                            
                  $month_start = $start_month ;
                  $month_end =  $end_month;
                  $a_year = $start_year;

                }else{
                  $month_start = 1;
                  $month_end =date('m');
                  $a_year    = date('Y');
                }
                for ($m=$month_start; $m <=$month_end ; $m++) {
                  if(isset($_POST['range']) && !empty($_POST['range'])){
                    $number = $col_count;
                      
                  }else{
                    $number = cal_days_in_month(CAL_GREGORIAN, $m, $a_year);
                  }

                  /*$this->db->select('month_days,month_days_in_out');
                  $this->db->where('user_id', $user_id);
                  $this->db->where('a_month ', $m);
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
                                ->where(array('user_id'=>$user_id, 'a_month '=>$m, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id))
                                ->get()
                                ->row_array();

                  for($d=0; $d<=$number; $d++)
                  {
                    if(isset($_POST['range']) && !empty($_POST['range'])){
                      $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                    } else{
                       $time= $time=mktime(12, 0, 0, $m, $d+1, $a_year);       
                    }
                    
                  // if (date('m', $time)==$month)       
                    $date=date('d M Y', $time);
                    $new_date=date('d/m/Y', $time);
                    $schedule_date=date('Y-m-d', $time);
                    $a_day =date('d', $time);
                    $a_month =date('m', $time);
                    $a_year =date('Y', $time);
                     // echo $schedule_date. '<br>'; 
                   
                    $user_schedule_where     = array('subdomain_id'=>$subdomain_id,'employee_id'=>$user_id,'schedule_date'=>$schedule_date);
                    $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
                    // echo $this->db->last_query();
                    
                    if(!empty($rows['month_days'])){

                      $month_days =  unserialize($rows['month_days']);
                      $month_days_in_out =  unserialize($rows['month_days_in_out']);
                      $day = $month_days[$a_day-1];
                      $day_in_out = $month_days_in_out[$a_day-1];
                      $latest_inout = end($day_in_out);                             
                       
                      if(!empty($user_schedule)){
                       

                     if(!empty($day['punch_in'])){    
                                            
                          $later_entry_hours = later_entry_minutes($user_schedule['schedule_date'].' '.$user_schedule['max_start_time'],$user_schedule['schedule_date'].' '.$day['punch_in']);
                          if($later_entry_hours > 0){
                            $user_absent[$user_id][] = $user_id;
                            $user_time[$user_id][] = $later_entry_hours ; 
                          }
                        
                        }  
                         
                      } 
                    }  
                  } 
                }

                if(isset($user_absent[$user_id])){
              $user_details= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id'=>$user_id))->row_array();
              $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();                    
              if(!empty($user_details['designation_id'])){
                $designation = $this->db->get_where('designation',array('subdomain_id'=>$subdomain_id,'id'=>$user_details['designation_id']))->row_array();
                $designation_name = $designation['designation'];
                
              }else{
                $designation_name = '-';
              }?>
              <tr class="<?php echo $sno;?>" style="background-color:<?php echo ($sno % 2 == 0)?'#fff':'#eee';?>;font-family:'Open Sans',arial,sans-serif!important;">
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
                        <?php echo count($user_absent[$user_id]); ?>
                      </td>
                    </tr>
                    
                  </table>
                </td>
                 <td align="left" valign="middle" style="font-weight:400;padding:10px 8px 10px 8px;border:2px solid #9c9c9c;">
                  <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tr>
                      <td align="left" style="font-family:'Open Sans',arial,sans-serif!important;font-size:14px;">
                        <?php echo !empty(array_sum($user_time[$user_id]))?intdiv(array_sum($user_time[$user_id]), 60).'.'. (array_sum($user_time[$user_id]) % 60):''
                ?>
                      </td>
                    </tr>
                    
                  </table>
                </td>
                
              </tr>


              <?php  $sno++;
            }
              // echo'<pre>';print_r($user_absent);   exit;           
               } 
            }
          // echo'<pre>';print_r($user_absent);
         ?>

             
				</tbody>
			</table>
    </div>