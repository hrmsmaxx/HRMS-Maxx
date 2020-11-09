<?php 
  $user_id = $this->session->userdata('user_id'); 
  $system_settings = $this->db->get_where('subdomin_system_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    $systems = unserialize(base64_decode($system_settings['system_settings']));
    $time_zone = $systems['timezone']?$systems['timezone']:config_item('timezone');
    // echo  print_r($systems['timezone'] ); exit;
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
   $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
   $this->db->select('month_days,month_days_in_out');
   $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

   $today_work_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-d'));
    $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array(); 
    if(!empty($today_work_hour)){
      $today_work_hours = work_hours($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['break_time']);

      $today_work_minutes = $today_work_hours;

      $today_work_hours = floor($today_work_minutes / 60).' hrs '.($today_work_minutes -   floor($today_work_minutes / 60) * 60).' mins';
      // echo print_r($today_work_hours); exit;
    } else{
      $today_work_hours = 0;
    }
    $dt_min = new DateTime("last saturday"); // Edit
    $dt_min->modify('+1 day'); // Edit
    $dt_max = clone($dt_min);
    $dt_max->modify('+6 days');
    $week_start = $dt_min->format('Y-m-d');
    $week_end = $dt_max->format('Y-m-d');
    $week_work_where     = array('employee_id'=>$user_id,'schedule_date >='=> $week_start,'schedule_date <='=>$week_end);
    $week_work_hour = $this->db->get_where('shift_scheduling',$week_work_where)->result_array(); 
     // echo "<pre>";print_r($week_work_hour); 
    if(!empty($week_work_hour)){
      foreach ($week_work_hour as $key => $value) {
        $week_work_hours = work_hours($value['schedule_date'].' '.$value['start_time'],$value['schedule_date'].' '.$value['end_time'],$value['break_time']);

          // $week_hours = explode(' ', $week_work_hours);
           // echo print_r($week_hours); exit;
        $total_week_minutes +=$week_work_hours;
        // $total_week_minutes +=$week_hours[1];
      }
        // echo $total_week_hours/60;  
         $total_week_hours = floor($total_week_minutes / 60).' hrs '.($total_week_minutes -   floor($total_week_minutes / 60) * 60).' mins';
      // if($total_week_minutes >= 60){
      //   $total_week_minutes
      //   $total_week_hours = $total_week_hours + 
      // }
      
    } else{
      $week_work_hours = 0;
    }
    
    $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
    $last_day_this_month  = date('Y-m-t');
    $month_work_where     = array('employee_id'=>$user_id,'schedule_date >='=> $first_day_this_month,'schedule_date <='=>$last_day_this_month);
    $month_work_hour = $this->db->get_where('shift_scheduling',$month_work_where)->result_array(); 
     // echo $this->db->last_query(); exit();
     // echo "<pre>";print_r($month_work_hour); exit();
      if(!empty($month_work_hour)){
      foreach ($month_work_hour as $key => $value) {
        $month_work_hours = work_hours($value['schedule_date'].' '.$value['start_time'],$value['schedule_date'].' '.$value['end_time'],$value['break_time']);
          //$week_hours = explode(' ', $week_work_hours);
           // echo print_r($week_hours); exit;
        //$total_month_hours +=$week_hours[0];
        //$total_month_minutes +=$week_hours[1];
         $total_month_minutes +=$month_work_hours;
      }
      $total_month_hours = floor($total_month_minutes / 60).' hrs '.($total_month_minutes -   floor($total_month_minutes / 60) * 60).' mins';
      
    } else{
      $week_work_hours = 0;
    }
 
   $punchin_id = 1;
   if(!empty($record['month_days'])){
     
    
      $month_days =  unserialize($record['month_days']);
      $month_days_in_out =  unserialize($record['month_days_in_out']);
     
     $a_day -=1;

     if(!empty($month_days[$a_day])  && !empty($month_days_in_out[$a_day])){  

      $day = $month_days[$a_day];
      $day_in_out = $month_days_in_out[$a_day];


      $latest_inout = end($day_in_out);

    
        if($day['day'] == '' || !empty($latest_inout['punch_out'])){ 
          $punch_in = $day['punch_in'];
          $punch_in_out = $latest_inout['punch_in'];
          $punch_out_in = $latest_inout['punch_out'];
          $punchin_id = 1;
        }else{
           $punch_in = $day['punch_in'];
          $punch_in_out = $latest_inout['punch_in'];
          $punch_out_in = $latest_inout['punch_out'];
          $punchin_id = 0;
        }
     }
         
            
     

     $punchin_time = date("g:i a", strtotime($day['punch_in']));
     $punchout_time = date("g:i a", strtotime($day['punch_out']));
   }

  ?>


  <?php
        $a_dayss -=1;
        $production_hour=0;
        $break_hour=0;

         if(!empty($record['month_days_in_out'])){

         $month_days_in_outss =  unserialize($record['month_days_in_out']);

           $j=1;                        
          foreach ($month_days_in_outss[$a_dayss] as $punch_detailss) 
          {

              if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
              {$day = $a_dayss+1;
                      $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']); 

                 if($j == 1){
                      
                       $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
                      $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
                       // echo $days; exit;
                      $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                       
                    }
                    $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
                    $between_minstartto_start = between_minstartto_start($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']);
                    if($punch_detailss['punch_out'] > $today_work_hour['max_end_time']){
                        $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                    }else{
                        $between_endto_max_end = 0;
                    }
                
                  $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out'])));
              }
                        
               $j++;                           
               
          }
          if($production_hour > 0 && $later_entry_hours>0){
              $production_hour = $production_hour-$end_between;
            } else{
              $production_hour = $production_hour-$start_between-$end_between;
            }
           for ($i=0; $i <count($month_days_in_outss[$a_dayss]) ; $i++) { 

                      if(!empty($month_days_in_outss[$a_dayss][$i]['punch_out']) && $month_days_in_outss[$a_dayss][ $i+1 ]['punch_in'])
                      {
                          
                          $break_hour += time_difference(date('H:i',strtotime($month_days_in_outss[$a_dayss][$i]['punch_out'])),date('H:i',strtotime($month_days_in_outss[$a_dayss][ $i+1 ]['punch_in'])));
                      }

                      
            }
        }
    ?>


<div class="content container-fluid">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-lg-3">
							<div class="dash-widget clearfix card-box">
								<a href="<?php echo base_url()?>all_tasks">
									<span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
									<div class="dash-widget-info m-t-15">
										<span class="dash-widget-text"><?php echo lang('tasks')?></span>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-3">
							<div class="dash-widget clearfix card-box">
								<a href="<?php echo base_url()?>payroll/payslip/<?php echo $this->session->userdata('user_id'); ?>">
									<span class="dash-widget-icon"><i class="fa fa-usd" aria-hidden="true"></i></span>
									<div class="dash-widget-info m-t-15">
										<span class="dash-widget-text"><?php echo lang('payslip')?></span>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-3">
							<div class="dash-widget clearfix card-box">
								<a href="<?php echo base_url()?>leaves">
									<span class="dash-widget-icon"><i class="fa fa-calendar"></i></span>
									<div class="dash-widget-info m-t-15">
										<span class="dash-widget-text"><?php echo lang('leaves')?></span>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-3">
							<div class="dash-widget clearfix card-box">
								<a href="<?php echo base_url()?>tickets">
									<span class="dash-widget-icon"><i class="fa fa-ticket" aria-hidden="true"></i></span>
									<div class="dash-widget-info m-t-15">
										<span class="dash-widget-text"><?php echo lang('tickets')?></span>
									</div>
								</a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5">
							<div class="panel">
								<ul class="nav nav-tabs custom-nav-tab">
									<li class="active">
										<a data-toggle="tab" href="#mark-attendance"><?php echo lang('mark')?> <small><?php echo lang('attendance')?></small></a>
									</li>
									<li>
										<a data-toggle="tab" href="#attendance-overview"><?php echo lang('attendance_overview')?></a>
									</li>
								</ul>
								<div class="panel-body">
									<div class="tab-content p-t-0">
										<div id="mark-attendance" class="tab-pane fade in active">
											<div class="card punch-status">
							                <div class="card-body">
							                  <h5 class="card-title"><?php echo lang('timesheet')?> <small class="text-muted"><?php echo date('d M Y'); ?></small></h5>
							                  <?php 
							                  $user_id = $this->session->userdata('user_id');      
							                  if($punchin_id == 1){ 
							                  
							                  	?>  
							                   <form action="<?php echo base_url(); ?>collaborator/save_punch_details" method="POST" class="form-horizontal">
							                        <?php if(!empty($latest_inout['punch_in'])){?>
                                      <div class="punch-det">
                                        <h6><?php echo lang('punch_in_at'); ?></h6>
                                        <p><?php echo date('l'); ?>, <?php echo date('d M Y',strtotime($punch_in_date)); ?> <?php echo $punchin_time?></p>
                                      </div>
                                    <?php } else{?>
                                      <div class="punch-det">
                                        <h6><?php echo lang('punch_in'); ?> </h6>
                                        <p><?php echo date("D M j h:i:s A");?></p>
                                      </div>
                                    <?php }?>
							                      <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
							                      <input type="hidden" name="punch_in_date_time" id="punch_in_date_time" value="<?php echo $punch_in_date_time; ?>">
							                      <div class="punch-info">
							                        <div class="punch-hours">
							                          <span><?php echo intdiv($production_hour, 60).'.'. ($production_hour % 60);?> <?php echo lang('hrs')?></span>
							                        </div>
							                      </div>
                                    <?php if(!empty($latest_inout['punch_out'])){?>
                                        <div class="punch-det">
                                          <h6><?php echo lang('punch_out_at'); ?></h6>
                                          <p><?php echo date('l'); ?>, <?php echo date('d M Y',strtotime($punch_in_date)); ?> <?php echo $punchout_time?></p>
                                        </div>
                                      <?php } ?>
							                      <div class="punch-btn-section">
							                        <button type="submit" class="btn btn-primary punch-btn"><?php echo lang('punch_in')?></button>
							                      </div>
							                    </form>
							                  <?php }else{ 
							                  	 
							                  	  ?>
							                    <form action="<?php echo base_url(); ?>collaborator/save_punch_details_out" method="POST" class="form-horizontal">
							                      <div class="punch-det">
							                        <h6>Punch In at</h6>
							                        <p><?php echo date('l'); ?>, <?php echo date('d M Y',strtotime($punch_in_date)); ?> <?php echo $punchin_time?></p>
							                      </div>
							                      <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
							                      <input type="hidden" name="punch_out_date_time" id="punch_out_date_time" value="<?php echo $punch_in_date_time; ?>">
							                      <div class="punch-info">
							                        <div class="punch-hours">
							                          <span><?php echo intdiv($production_hour, 60).'.'. ($production_hour % 60);?> <?php echo lang('hrs')?></span>
							                        </div>
							                      </div>
                                    <?php if(!empty($latest_inout['punch_out'])){?>
                                    <div class="punch-det">
                                      <h6><?php echo lang('punch_out_at'); ?></h6>
                                      <p><?php echo date('l'); ?>, <?php echo date('d M Y',strtotime($punch_in_date)); ?> <?php echo $punchout_time?></p>
                                    </div>
                                  <?php } ?>
							                      <div class="punch-btn-section">
							                        <button type="submit" class="btn btn-primary punch-btn"><?php echo lang('punch_out')?></button>
							                      </div>
							                    </form>
							                  <?php } ?>
							                  <div class="statistics">



							                    <div class="row">
							                      <div class="col-md-4 text-center">
							                        <div class="stats-box">
							                          <p><?php echo lang('production')?></p>
							                          <h6><?php echo intdiv($production_hour, 60).'.'. ($production_hour % 60);?>  hrs</h6>
							                        </div>
							                      </div>
							                      <div class="col-md-4 text-center">
							                        <div class="stats-box">
							                          <p><?php echo lang('break')?></p>
							                          <h6><?php echo intdiv($break_hour, 60).'.'. ($break_hour % 60);?> hrs</h6>
							                        </div>
							                      </div>
							                      <div class="col-md-4 text-center">
							                        <div class="stats-box">
							                          <p><?php echo lang('overtime')?></p>
							                          <?php

                                         $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-d'));
                                  $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
                                  if(!empty($user_schedule)){
                                      $total_scheduled_hour = work_hours($user_schedule['schedule_date'].' '.$user_schedule['start_time'],$user_schedule['schedule_date'].' '.$user_schedule['end_time'],$user_schedule['break_time']);

                                      $total_scheduled_minutes = $total_scheduled_hour;                                     
                                      
                                    } else{
                                      $total_scheduled_minutes = 0;
                                    }
                                    
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
                                      }
                                    }else{
                                       $overtime=0;
                                    }
                                  }else{
                                    $overtime = $production_hour;
                                  }
                                    ?>
                                    <h6>

                                  <?php if($overtime > 0){
                                    echo intdiv($overtime, 60).'.'. ($overtime % 60) .'hrs';
                                  }else {                                     
                                    echo "-";
                                 }?>



                                         </h6>
							                        </div>
							                      </div>
							                    </div>
							                  </div>
							                </div>
							              </div>
										</div>
										<div id="attendance-overview" class="tab-pane fade">
											<div class="card att-statistics">
                <div class="card-body">
                  <h5 class="card-title"><?php echo lang('statistics')?></h5>
                  <div class="stats-list">
                    <div class="stats-info">

                      <?php
                            // $maxTime = (8*3600);
                            $maxTime = ($today_work_minutes*60);
                           
                            $today_percentage = (($production_hour*60) / $maxTime) * 100;

                      ?>

                      <p><?php echo lang('today')?> <strong><?php echo intdiv($production_hour, 60).'.'. ($production_hour % 60);?> <small>/ <?php echo $today_work_hours ?></small></strong></p>
                      <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $today_percentage;?>%" aria-valuenow="<?php echo $today_percentage;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>

                    

                    <?php
                        $week_production_hour=0;
                        $month_production_hour=0;

                         if(!empty($record['month_days_in_out'])){

                             $month_days_in_out_week =  unserialize($record['month_days_in_out']);

                              $week_start_date = date("d",strtotime('monday this week'));
                              $week_end_date=date("d",strtotime("friday this week"));

                             for ($week=$week_start_date-1; $week <= $week_end_date ; $week++) { 
                              $w=1;                                         
                              foreach ($month_days_in_out_week[$week] as $punch_detail_week) 
                              {

                                  if(!empty($punch_detail_week['punch_in']) && !empty($punch_detail_week['punch_out']))
                                  {

                                     $days = $week;
                                        $today_work_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-'.$days));
                                        $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                                      if($w == 1){                                       
                                         // print_r($today_work_hour); exit();
                                        $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$days).' '.$punch_detail_week['punch_in']);   
                                       $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$days).' '.$punch_detail_week['punch_in']);     
                                       // echo $days; exit;
                                       $first_punch_in = $punch_detail_week['punch_in'];
                                      $start_between += start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$days).' '.$punch_detail_week['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                                      
                                    }
                                    $end_between += end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$days).' '.$punch_detail_week['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 

                                      $between_minstartto_start = between_minstartto_start($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']);
                                      if($punch_detail_week['punch_out'] > $today_work_hour['max_end_time']){
                                        $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                                      }else{
                                        $between_endto_max_end = 0;
                                      }
                                    
                                      $week_production_hour += time_difference(date('H:i',strtotime($punch_detail_week['punch_in'])),date('H:i',strtotime($punch_detail_week['punch_out'])));


                                  }
                                  $w++;
                              }

                               $week_production_hours = $week_production_hour;
                            $end_betweens = $end_between;
                            $start_betweens = $start_between;
                             if($week_production_hours > 0 && $later_entry_hours>0){
                                  $week_production_hours = $week_production_hours-$end_betweens;
                                } else{
                                  $week_production_hours = $week_production_hours-$start_betweens-$end_betweens;
                                }
                                if($week_production_hours<0){
                                  $week_production_hours = 0;
                                }

                             }
      
                        }
                  
                        $week_production_hour = $week_production_hours;            
                         // $week_maxTime = (40*3600);
                        $week_maxTime = ($total_week_minutes*60);
                         $week_percentage = (($week_production_hour*60) / $week_maxTime) * 100;

                         // $working_hours=working_days(date('n'), date('Y'))*8;
   

                     
                      if(!empty($record['month_days_in_out'])){

                           $month_days_in_out_month =  unserialize($record['month_days_in_out']);

                             $month_start_date = date('01', strtotime(date('Y-m-d')));
                             $month_end_date=date('t', strtotime(date('Y-m-d')));
                             // echo $month_start_date; exit;
                             // $m= 0;
                           for ($month=$month_start_date-1; $month <= $month_end_date-1 ; $month++) { 
                            $m= 1;                                            
                            foreach ($month_days_in_out_month[$month] as $punch_detail_month) 
                            {

                                if(!empty($punch_detail_month['punch_in']) && !empty($punch_detail_month['punch_out']))
                                {
                                    $days = $month+1;
                                        $today_work_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-'.$days));
                                        $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                                      if($m == 1){                                       
                                         // print_r($today_work_hour); exit();
                                        $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$days).' '.$punch_detail_month['punch_in']);   
                                       $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$days).' '.$punch_detail_month['punch_in']);     
                                       // echo $days; exit;
                                       $first_punch_in = $punch_detail_month['punch_in'];
                                      $start_between += start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$days).' '.$punch_detail_month['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                       
                                    }
                                    $end_between += end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$days).' '.$punch_detail_month['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 

                                      $between_minstartto_start = between_minstartto_start($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']);
                                      if($punch_detail_month['punch_out'] > $today_work_hour['max_end_time']){
                                        $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                                      }else{
                                        $between_endto_max_end = 0;
                                      }

                                    $month_production_hour += time_difference(date('H:i',strtotime($punch_detail_month['punch_in'])),date('H:i',strtotime($punch_detail_month['punch_out'])));


                                }
                                $m++;
                            }
                            $month_production_hours = $month_production_hour;
                            $end_betweens = $end_between;
                            $start_betweens = $start_between;
                             if($month_production_hours > 0 && $later_entry_hours>0){
                                  $month_production_hours = $month_production_hours-$end_betweens;
                                } else{
                                  $month_production_hours = $month_production_hours-$start_betweens-$end_betweens;
                                }
                                if($month_production_hours<0){
                                  $month_production_hours = 0;
                                }

                           }
      
                        }
                        $month_production_hour = $month_production_hours;

                         $working_hours= $total_month_minutes;           
                         $month_maxTime = ($working_hours*60);
                         $month_percentage = (($month_production_hour*60) / $month_maxTime) * 100;


                         $remaining_hour=($working_hours)-$month_production_hour;



                           $month_overtimes=($month_production_hour)-($working_hours);
                          if($month_overtimes > 0)
                          {
                            $month_overtime=$month_overtimes;
                          }
                          else
                          {
                            $month_overtime=0;
                          }

                          $overtime_percentage = (($month_overtime*60) / $month_maxTime) * 100;
                          

                        

                      ?>
                    <div class="stats-info">
                      <p><?php echo lang('this_week')?> <strong><?php echo intdiv($week_production_hour, 60).'.'. ($week_production_hour % 60);?> <small>/ <?php echo $total_week_hours;?></small></strong></p>
                      <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $week_percentage;?>%" aria-valuenow="<?php echo $week_percentage;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="stats-info">
                      <p><?php echo lang('this_month')?> <strong><?php echo intdiv($month_production_hour, 60).'.'. ($month_production_hour % 60);?> <small>/ <?php echo $total_month_hours;?></small></strong></p>
                      <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $month_percentage;?>%" aria-valuenow="<?php echo $month_percentage;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="stats-info">
                      <p><?php echo lang('remaining_hours')?> <strong><?php echo intdiv($remaining_hour, 60).'.'. ($remaining_hour % 60);?> <small>/ <?php echo $total_month_hours;?></small></strong></p>
                      <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $month_percentage;?>%" aria-valuenow="<?php echo $month_percentage;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="stats-info">
                      <p><?php echo lang('overtime')?> <strong><?php echo intdiv($month_overtime, 60).'.'. ($month_overtime % 60);?> hrs</strong></p>
                      <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $overtime_percentage;?>%" aria-valuenow="<?php echo $overtime_percentage;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="panel panel-table equal-panel">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo lang('my_tasks')?></h3>
								</div>
								<div class="panel-body">
								<div class="drop-scroll">
									<div class="table-responsive">	
										
										<table class="table table-striped custom-table m-b-0">
											<thead>
												<tr>
													<th><?php echo lang('task')?></th>
													<th><?php echo lang('end_date')?> </th>
													<th><?php echo lang('status')?></th>
													<th><?php echo lang('progress')?></th>
													<th class="text-right"><?php echo lang('action')?></th>
												</tr>
											</thead>
											<tbody>
												<?php 

												$user_id = $this->session->userdata('user_id');
												$all_projects = $this->db->select('*')
											         ->from('dgt_assign_projects')
											         ->where('assigned_user', $user_id)
											         ->get()->result_array();


												
												foreach ($all_projects as $key => $projects) {
												$pro_id = $projects['project_assigned'];
												
												$task_details = $this->db->select('*')
											         			->from('dgt_tasks')
											         			->where('project', $pro_id)
											         			->get()->result_array();
											    //echo 'task<pre>'; print_r($task_details); exit;
												foreach ($task_details as $key => $task) {
												$task_percentage = (100 / 100) * $task['task_progress'];


												?>
												<tr>
													<td>
														<h2><a href="tasks.html"><?php echo $task['task_name']?></a></h2>
														<small class="block text-ellipsis">
															<span class="text-muted"><?php echo $task['description']?></span>
														</small>
													</td>
													<td><?php echo $task['due_date']?></td>
													<td>
														<div class="btn btn-white btn-sm rounded dropdown-toggle">
																<?php if($task['task_progress'] == 100) { ?>
																<i class="fa fa-dot-circle-o text-success" style="color:#55ce63;"></i> <?php echo lang('completed')?>
																<?php } else if($task['task_progress'] > 0 && $task['task_progress'] < 100) { ?>
																<i class="fa fa-dot-circle-o text-success" style="color:#ff9b44;"></i> <?php echo lang('in_progress')?>
																<?php } else if($task['task_progress'] == 0) { ?>
															    <i class="fa fa-dot-circle-o text-success" style="color:#f62d51;"></i> <?php echo lang('not_started')?>
																
																<?php } ?>
															</div>
													</td>
													<td>
														<div class="progress progress-xs progress-striped">
															<div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="<?php echo $task_percentage?>%" style="width: <?php echo $task_percentage?>%"></div>
														</div>
													</td>
													<td class="text-right">
														<div class="dropdown">
															<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
															<ul class="dropdown-menu pull-right">
																<li><a href="<?php echo base_url()?>all_tasks/view/<?php echo $task['project']?>" title="Edit"><i class="fa fa-pencil m-r-5"></i> <?php echo lang('edit')?></a></li>
																<li><a href="#" title="Delete" data-toggle="modal" onclick="delete_task(<?php echo $task['t_id'];?>)"  ><i class="fa fa-trash-o m-r-5"></i> <?php echo lang('delete')?></a></li>
															</ul>
														</div>
													</td>
												</tr>
												
											 <?php } } ?>
											</tbody>
										</table>
									</div>
									</div>
								</div>
								<div class="panel-footer">
									<a href="<?php echo base_url()?>all_tasks" class="text-primary"><?php echo lang('view_all_tasks')?></a>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-table">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo lang('my_projects')?></h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">	
										<table class="table table-striped custom-table m-b-0">
											<thead>
												<tr>
													<th><?php echo lang('project_name')?></th>
													<th><?php echo lang('end_date')?> </th>
													<th><?php echo lang('status')?></th>
													<th><?php echo lang('progress')?></th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$user_id = $this->session->userdata('user_id');
												$all_projects = $this->db->select('*')
											         ->from('dgt_assign_projects')
											         ->where('assigned_user', $user_id)
											         ->get()->result_array();
												

												foreach ($all_projects as $key => $projects) {

													 $pro = $projects['project_assigned'];
													 $project_details = $this->db->select('*')
											         			->from('dgt_projects')
											         			->where('project_id', $pro)
											         			->get()->result_array();	
												foreach ($project_details as $key => $details) {
												$task_percentage = (100 / 100) * $details['progress'];
                                                //echo 'deta<pre>';print_r($project_details); exit;
																																
												
												?>
												<tr>
													<td>
														<h2><a href="project-view.html"><?php echo $details['project_title']?></a></h2>
														<small class="block text-ellipsis">
															<?php 
															$completed_task_count = $this->db->get_where('tasks',array('project'=>$details['project_id'],'task_progress'=>'100'))->result_array();
															$open_task_count = $this->db->get_where('tasks',array('project'=>$details['project_id'],'task_progress !='=>'100'))->result_array(); 
															?>
															<span class="text-xs"><?php echo count($open_task_count)?></span> <span class="text-muted"><?php echo lang('open_tasks')?>, </span>
															<span class="text-xs"><?php echo count($completed_task_count)?></span> <span class="text-muted"><?php echo lang('tasks_completed')?></span>
														</small>
													</td>
													<td><?php echo date('d M Y ', strtotime($details['due_date']))?></td>
													<td>
														<div class="btn btn-white btn-sm rounded dropdown-toggle">
																<?php if($details['progress'] == 100) { ?>
																<i class="fa fa-dot-circle-o text-success" style="color:#55ce63;"></i> <?php echo lang('completed')?>
																<?php } elseif($details['progress'] > 0 && $task['task_progress'] < 100) { ?>
																<i class="fa fa-dot-circle-o text-success" style="color:#ff9b44;"></i><?php echo lang('in_progress')?>
																<?php } elseif($details['progress'] == 0) { ?>
															    <i class="fa fa-dot-circle-o text-success" style="color:#f62d51;"></i> <?php echo lang('not_started')?>
																
																<?php } ?>
															</div>
													</td>
												
													<td>
														<div class="progress progress-xs progress-striped">
															<div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="<?php echo $task_percentage?>%" style="width: <?php echo $task_percentage?>%"></div>
														</div>
													</td>
												</tr>
												
												
												<?php } } ?>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="panel-footer">
									<a href="<?php echo base_url()?>projects" class="text-primary"><?php echo lang('view_all_projects')?></a>
								</div>
							</div>
						</div>
					</div>
            <div class="row">
            <div class="col-md-6">
              <div class="panel panel-table">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo lang('wiki')?></h3>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <?php 
                    $Wiki = $this->db->select("*")
                           ->from('dgt_wiki')
                           ->where('subdomain_id',$this->session->userdata('subdomain_id'))
                           ->order_by('id',desc)
                           ->limit(7)
                           ->get()->result_array();

                          
                    ?>
                    <table class="table table-striped custom-table m-b-0">
                      <thead>
                        <tr>                          
                          <th class="col-md-3"><b><?php echo lang('title')?></b></th>
                          <th class="col-md-3"><b><?php echo lang('description')?></b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        foreach($Wiki as $Wiki_details) { ?>
                        
                        <tr>
                          <td><?php echo $Wiki_details['title']?></td>
                          <td><?php echo $Wiki_details['description']?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer">
                  <a href="<?php echo base_url()?>wiki" class="text-primary"><?php echo lang('view_all_Wiki')?></a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="panel panel-table">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo lang('notice_board')?></h3>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped custom-table m-b-0">
                      <thead>
                        <tr>
                          <th class="col-md-3"><b><?php echo lang('title')?></b></th>
                          <th class="col-md-3"><b><?php echo lang('description')?></b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $this->db->limit(7);
                        $this->db->order_by('id',asc);
                        $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
                        $notice_boards = $this->db->get('notice_board')->result_array(); 
                        foreach($notice_boards as $notice_board){
                        ?>
                        <tr>
                          <td><?php echo $notice_board['title']?></td>
                          <td><?php echo $notice_board['description']?></td>
                          
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer">
                  <a href="<?php echo base_url()?>notice_board" class="text-primary"><?php echo lang('view_all_notice_boards')?></a>
                </div>
              </div>
            </div>
          </div>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo lang('my_calendar')?></h3>
								</div>
								<div class="panel-body">
									<div id="calendar"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="themes">
						<div class="themes-icon"><i class="fa fa-cog"></i></div>
						<div class="themes-body">
							<ul id="theme-change" class="theme-colors">
								<li><a href="../orange/index.html"><span class="theme-orange"></span></a></li>
								<li><a href="../purple/index.html"><span class="theme-purple"></span></a></li> 
								<li><a href="../blue/index.html"><span class="theme-blue"></span></a></li>
								<li><a href="../maroon/index.html"><span class="theme-maroon"></span></a></li>
								<li><a href="../light/index.html"><span class="theme-light"></span></a></li> 
								<li><a href="../dark/index.html"><span class="theme-dark"></span></a></li> 
								<li><a href="../rtl/index.html"><span class="theme-rtl">RTL</span></a></li>
							</ul>
						</div>
					</div> -->
				</div>
						
			

			<!---- Modal -->
			<div  class="modal custom-modal fade" role="dialog" id="delete_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="assigned_task" method="post" action="<?php echo base_url();?>all_tasks/delete_task">
					<div class="form-head">
						<h3><?php echo lang('delete_task')?></h3>
						<p><?php echo lang('are_you_sure_want_to_delete')?></p>
					</div>
					<input type="text" name="delete_project" id="project" value="<?=$project_id['project_id']?>">
					<input type="text" name="delete_task" id="delete_task_id" >
					<div class="modal-btn delete-action">
						<div class="row">
							<div class="col-xs-6">
								<button type="submit" class="btn continue-btn"><?php echo lang('delete')?></button>
							</div>
							<div class="col-xs-6">
								<a href="javascript:void(0);" data-dismiss="modal" class="btn cancel-btn"><?php echo lang('cancel')?></a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>