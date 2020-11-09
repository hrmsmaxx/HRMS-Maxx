<style>
#excel_table {
  
  border-collapse: collapse;
  width: 100%;
}

#excel_table td, #excel_table th {
  border: 1px solid #3a3a3a;
  padding: 8px;
}

/*#excel_table tr:nth-child(even){background-color: #f2f2f2;}

#excel_table tr:hover {background-color: #ddd;}*/

#excel_table th {
  padding-top: 12px;
  padding-bottom: 12px;
 
}
</style>
<?php date_default_timezone_set('Asia/Kolkata');
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
 
              <?php 
          $user_id = array();
        if(!empty($_POST['user_id']) || !empty($_POST['range']))
                { 
                    
                 
                 

                  if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
                    $user_id[] = $_POST['user_id'];
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
                      $this->db->where('subdomain_id', $subdomain_id);
                      $all_users =  $this->db->get('attendance_details')->result_array();
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
            }?>

            <table style="vertical-align: middle !important;text-align: center; border-collapse: collapse;width: 100%; padding: 8px;">

             
              <tr style="background-color:#c6e0b3">                
                <td><?php echo lang('since_date');?></td>
                <td style="text-align: left;"><?php echo (isset($from_date) && !empty($from_date))?$from_date.'- 00:00:00':$a_year.'-'.$a_month.'-'.'01'.'-00:00:00';?></td>
                 <td><?php echo lang('to_date');?></td>
                <td style="text-align: left;"><?php echo (isset($to_date) && !empty($to_date))?$to_date.'- 23:59:59':$a_year.'-'.$a_month.'-'.$a_day.'-'.date('H:i').':00';?></td>
              </tr>
             
            </table>
            <table id="excel_table" class="" style="vertical-align: middle !important;text-align: center; border-collapse: collapse;width: 100%;border: 1px solid #3a3a3a; padding: 8px;">
           <!--  <thead>
              
            </thead> -->
            <tbody>
              <tr class="" style="vertical-align: middle !important;background-color:#24b23c">
                <th><?php echo lang('s_no');?></th>
                      <th><?php echo lang('employee_name');?></th>
                      <th><?php echo lang('date');?></th>
                      <th><?php echo lang('project_name');?></th>
                      <th><?php echo lang('work_hours');?></th>
                      <!-- <th class="text-center">Hours</th> -->
                      <th><?php echo lang('work_description');?></th>
                      <th><?php echo lang('project_to_day');?></th>
              
              </tr>   
            
                  <?php    $user_id = array();
                         if(!empty($_POST['user_id'])  || !empty($_POST['range']))
                        { 
                          // print_r($_POST); exit();
                         
                          if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
                            $user_id[] = $_POST['user_id'];
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
                             $dept_users= $this->db->get_where('users',array('department_id'=>$dept_id,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
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

                      } ?>
                  <?php 
                  $projects = $this->db->get_where('projects',array('subdomain_id' => $this->session->userdata('subdomain_id')))->result_array();
                  // echo "<pre>";print_r($projects); exit;
                  
                         
                                if(isset($_POST['range']) && !empty($_POST['range'])){
                                  $number = $col_count;
                                  $start_val = 0;
                                  $month = $start_month;
                                  $year = $start_year;
                                  $sno = 1;
                                
                                    $production_hours = 0;                                  
                                           $production_hour = 0;   
                                        foreach ($results as $rows) {
                        $shist_assigned= 0;
                        $production_hours = 0;                                  
                                           $production_hour = 0;   
                                          foreach ($projects as $key => $project) {
                                             for($d=$start_val; $d<=$number; $d++)
                                 {
                                    $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                                         
                                    // if (date('m', $time)==$month)       
                                        $date=date('d M Y', $time);
                                        $schedule_date=date('Y-m-d', $time);
                                        $a_day =date('d', $time);

                                        $a_day -=1;
                                        $shist_assigned= 0;
                                            $scheduling_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
                                            $shift_scheduling = $this->db->get_where('shift_scheduling',$scheduling_where)->row_array();
                                            // $sno = 1;
                                            if(!empty($shift_scheduling)){
                                            if(!empty($rows['month_days_in_out'])){

                                               $month_days_in_outs =  unserialize($rows['month_days_in_out']);

                                                $i =1;   

                                                 $j=1;         
                                                 $production_hour = 0;         
                            foreach ($month_days_in_outs[$a_day] as $punch_detailss) 
                            {

                              
                               if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
                                {
                                  if(isset($punch_detailss['project_id'])){
                                    if($punch_detailss['project_id'] == $project['project_id']){
                                      // $sno ++;
                                      $shist_assigned = 1;
                                      $day = $a_day+1;
                                  
                                        $today_work_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
                                        $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                                          // echo $day.'' .print_r($today_work_hour); exit;
                                        if($today_work_hour['free_shift'] == 1 ){
                                            if($today_work_hour['start_time'] == '00:00:00'){
                                                $later_entry_hours = 0;
                                            }else{
                                              $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
                                            }
                                           
                                        }else{
                                           $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
                                           // echo $days; exit;
                                          $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                                          $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
                                        }
                                        $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
                                      
                                        if($punch_detailss['punch_out'] > $today_work_hour['max_end_time']){
                                            $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                                        }else{
                                            $between_endto_max_end = 0;
                                        }    
                                        // }                    
                                       $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
                                    }
                                  }
                                     // echo $production_hour; exit;                    
                                }                              

                                 $j++;
                            } 
                            if($production_hour > 0 && $later_entry_hours>0){
                                    $production_hour = $production_hour-$end_between;
                                  } else{
                                    $production_hour = $production_hour-$start_between-$end_between;
                                  }
                                            
                                            }
                                        
                                            $user_details= $this->db->get_where('users',array('id'=>$rows['user_id']))->row_array();
                                          $account_details= $this->db->get_where('account_details',array('user_id'=>$rows['user_id']))->row_array();                    
                                          if(!empty($user_details['designation_id'])){
                                            $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
                                            $designation_name = $designation['designation'];
                                            
                                          }else{
                                            $designation_name = '-';
                                          }
                                            ?>
                                            <?php if($shist_assigned == 1){ ?>
                                              <tr style="vertical-align: middle !important;">

                                              <td style="vertical-align: middle !important;text-align: center;"><?php echo $sno++;?></td>
                                               <td style="vertical-align: middle !important;text-align: center;" >
                                                 
                                                  <b><?php echo ucfirst(user::displayName($user_details['id']));?></b><br>   
                                                  <b> <?php echo $designation_name;?> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"";?></b>
                                                </td>                    
                                              <td style="vertical-align: middle !important;text-align: center;"> <?php echo $schedule_date;?></td>
                                              <td style="vertical-align: middle !important;text-align: center;">
                                                <h2><?php echo $project['project_title']; ?></h2>
                                              </td>
                                              <td style="vertical-align: middle !important;text-align: center;"><?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?> </td>
                                              <!-- <td class="text-center">7</td> -->
                                              <td style="vertical-align: middle !important;text-align: center;" class="col-md-4"><?php echo date('l', $time); ?></td>
                                              <?php $production_hours += $production_hour; ?>
                                              <td style="vertical-align: middle !important;text-align: center;" class="col-md-4"><?php echo !empty($production_hours)?intdiv($production_hours, 60).'.'. ($production_hours % 60).' hrs':'-';?></td>
                                              
                                          </tr>

                                          <?php }
                                            }
                                          }

                                    } 
                                      } 
                                }else{

                                  $month = $a_month;
                                  $year = $a_year;

                                  // $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                                  $number = date('d');
                                  $sno = 1;
                                
                                           $production_hours = 0;                                 
                                           $production_hour = 0;                                  

                                        foreach ($results as $rows) {
                        $shist_assigned= 0;
                         $production_hours = 0; 
                         $production_hour = 0; 
                                          foreach ($projects as $key => $project) {
                                            for($d=1; $d<=$number; $d++)
                                  {
                                      $time=mktime(12, 0, 0, $month, $d, $year);          
                                      if (date('m', $time)==$month)       
                                          $date=date('d M Y', $time);
                                          $schedule_date=date('Y-m-d', $time);
                                          $a_day =date('d', $time);

                                          $a_day -=1;   
                                          $shist_assigned= 0;
                                            $scheduling_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
                                            $shift_scheduling = $this->db->get_where('shift_scheduling',$scheduling_where)->row_array();
                                            // $sno = 1;
                                            if(!empty($shift_scheduling)){
                                            if(!empty($rows['month_days_in_out'])){

                                               $month_days_in_outs =  unserialize($rows['month_days_in_out']);

                                                $i =1;   

                                                 $j=1;         
                                                 $production_hour = 0;         
                            foreach ($month_days_in_outs[$a_day] as $punch_detailss) 
                            {

                              
                               if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
                                {
                                  if(isset($punch_detailss['project_id'])){
                                    if($punch_detailss['project_id'] == $project['project_id']){
                                      // $sno ++;
                                      $shist_assigned = 1;
                                      $day = $a_day+1;
                                  
                                        $today_work_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
                                        $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                                          // echo $day.'' .print_r($today_work_hour); exit;
                                        if($today_work_hour['free_shift'] == 1 ){
                                            if($today_work_hour['start_time'] == '00:00:00'){
                                                $later_entry_hours = 0;
                                            }else{
                                              $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
                                            }
                                          
                                           
                                         
                                           
                                        }else{
                                           $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
                                           // echo $days; exit;
                                          $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                                          $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
                                        }
                                        $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
                                      
                                        if($punch_detailss['punch_out'] > $today_work_hour['max_end_time']){
                                            $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                                        }else{
                                            $between_endto_max_end = 0;
                                        }    
                                        // }                    
                                       $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
                                    }
                                  }
                                     // echo $production_hour; exit;                    
                                }                              

                                 $j++;
                            } 
                            if($production_hour > 0 && $later_entry_hours>0){
                                    $production_hour = $production_hour-$end_between;
                                  } else{
                                    $production_hour = $production_hour-$start_between-$end_between;
                                  }
                                            
                                            }
                                        
                                            $user_details= $this->db->get_where('users',array('id'=>$rows['user_id']))->row_array();
                                          $account_details= $this->db->get_where('account_details',array('user_id'=>$rows['user_id']))->row_array();                    
                                          if(!empty($user_details['designation_id'])){
                                            $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
                                            $designation_name = $designation['designation'];
                                            
                                          }else{
                                            $designation_name = '-';
                                          }
                                            ?>
                                            <?php if($shist_assigned == 1){ ?>
                                              <tr style="vertical-align: middle !important;">

                                                <td style="vertical-align: middle !important;text-align: center;"><?php echo $sno++;?></td>
                                                <td style="vertical-align: middle !important;text-align: center;">
                                                 
                                                  <b><?php echo ucfirst(user::displayName($user_details['id']));?></b><br>   
                                                  <b> <?php echo $designation_name;?> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"";?></b>
                                                </td>                    
                                                <td style="vertical-align: middle !important;text-align: center;"> <?php echo $schedule_date;?></td>
                                                <td style="vertical-align: middle !important;text-align: center;">
                                                  <h2><?php echo $project['project_title']; ?></h2>
                                                </td>
                                                <td style="vertical-align: middle !important;text-align: center;"><?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?> </td>
                                              <!-- <td class="text-center">7</td> -->
                                                <td style="vertical-align: middle !important;text-align: center;" class="col-md-4"><?php echo date('l', $time); ?></td>
                                                <?php $production_hours += $production_hour; ?>
                                                <td style="vertical-align: middle !important;text-align: center;" class="col-md-4"><?php echo !empty($production_hours)?intdiv($production_hours, 60).'.'. ($production_hours % 60).' hrs':'-';?></td>
                                              
                                            </tr>

                                          <?php 
                                        }
                                          }
                                        }


                                    } 
                                  
                                  }
                                }
                               
                                ?>
        </tbody>
      </table>