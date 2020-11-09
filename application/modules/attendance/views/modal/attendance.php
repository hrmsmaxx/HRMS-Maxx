  <!-- Attendance Modal -->
				
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('attendance_of').' '.ucfirst(User::displayName($user_id)).' dated '.date('d/m/Y',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day));?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="card punch-status">
											<div class="card-body">
												<h5 class="card-title"><?php echo lang('timesheet');?> <small class="text-muted"><?php echo date('d M Y',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day));?></small></h5>


												<?php

												   $a_day     = $atten_day;
												   $a_days     = $atten_day;
												   $a_dayss     = $atten_day;




												if(!empty($record['month_days'])){
     
    												  $month_days =  unserialize($record['month_days']);
												      $month_days_in_out =  unserialize($record['month_days_in_out']);
												     /*echo "<pre>";
												     print_r($month_days);
												     print_r($month_days_in_out);
												     exit;*/
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

												        //checking is closed by manager
												        $day_status = ($day['closed_status'] =='yes')?'yes':'no';
												        $day_status_class = ($day['closed_status'] =='yes')?'hide':'';
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
											              {
											              	$day = $a_dayss+1;
										                   $today_work_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-'.$day));
										                    $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
										                    // echo $day.'' .print_r($today_work_hour); 
										                    if($j == 1){
                      
										                       $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
										                      $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
										                       // echo $days; exit;
										                      $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
										                       
										                    }
										                    $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
										                  
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

												<div class="punch-det">
													<h6>Punch In at</h6>
													<?php
													if(!empty($punch_in))
													{
														echo'<p>'.date('l',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)).', '.date('d M Y',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)).' '. date("g:i a", strtotime($punch_in)).'</p>';
													}
													?>
												</div>
												<div class="punch-info">
													<div class="punch-hours">
														<span><?php echo intdiv($production_hour, 60).'.'. ($production_hour % 60);?> hrs</span>
													</div>
												</div>
												<div class="punch-det">
													<h6>Punch Out at</h6>
													<?php
													if(!empty($punch_out_in))
													{
														echo'<p>'.date('l',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)).', '.date('d M Y',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)).' '.date("g:i a", strtotime($punch_out_in)).'</p>';
													}
													?>
													
												</div>

												
												<div class="statistics">
													<div class="row">
														<div class="col-md-4 text-center">
															<div class="stats-box">
																<p><?php echo lang('production');?></p>
																<h6><?php echo intdiv($production_hour, 60).'.'. ($production_hour % 60);?> hrs</h6>
															</div>
														</div>
														<div class="col-md-4 text-center">
															<div class="stats-box">
																<p><?php echo lang('break');?></p>
																<h6><?php echo intdiv($break_hour, 60).'.'. ($break_hour % 60);?> hrs</h6>
															</div>
														</div>
														<div class="col-md-4 text-center">
															<div class="stats-box">
																<p><?php echo lang('overtime');?></p>
																<?php
																 $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-d',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)));
								                                  $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array();
							                                   		 $all_user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->result_array(); 

								                                  if(!empty($user_schedule)){
								                                  	 foreach ($all_user_schedule as $value) {
															            $work_hours = hours_to_mins($value['work_hours']);
            															$total_scheduled_minutes += $work_hours;
															            # code...
															          }
								                                      
								                                    } else{
								                                      $total_scheduled_minutes = 0;
								                                    }
                                    								if($user_schedule['accept_extras'] == 1){
							                           					$overtimes=($production_hour)-($total_scheduled_minutes);
										                          // $overtimes=9-($production_hour+$break_hour);
											                          if($overtimes > 0)
											                          {
											                            $overtime=$overtimes;
											                          }
											                          else
											                          {
											                            $overtime=0;
											                          }
											                      	}
										                          	else{
											                          	$overtime=0;
										                          	}
										                          ?>
										                          <h6>
										                          	<?php if($user_schedule['accept_extras'] == 0){
                        echo "-";
                      }else {
                         echo intdiv($overtime, 60).'.'. ($overtime % 60) .'hrs';
                      }?>

										                          	</h6>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="card recent-activity">
											<div class="card-body">
												<h5 class="card-title text-center"><?php echo lang('activity');?></h5>
												<ul class="timeline m-t-30">
													<?php
								                    $a_days -=1;

								                     if(!empty($record['month_days_in_out'])){

								                     $month_days_in_outs =  unserialize($record['month_days_in_out']);

								                      $i =1;                 
								                      foreach ($month_days_in_outs[$a_days] as $key => $punch_details) 
								                      {



								                        if(!empty($punch_details['punch_in']))
								                        {
								                        	 $punch_in_workcode = $this->db->get_where('dgt_incidents',array('id'=>$punch_details['punchin_workcode']))->row_array(); 
								                        	 	if(!empty($punch_in_workcode)){
								                        	 		$incident = 'with incidence: "'.$punch_in_workcode['incident_name'].'".';
								                        	 	}else{
								                        	 		$incident= '';
								                        	 	}
								                        	 	if(isset($punch_details['punchin_workcode'])){
								                        	 		$punch_details['punchin_workcode'] = $punch_details['punchin_workcode'];
								                        	 	}else{
								                        	 		$punch_details['punchin_workcode'] = 0;
								                        	 	}
								                        	 	if($i == 1){
								                        	 	?>
								                        	 	 
								                        	 	<li class="timeline-line"></li>
								                        	 	<?php }
								                          echo'<li class="timeline-item">
														       <div class="timeline-badge"><a href="#"></a></div>
														       <div class="timeline-panel">
														         <div class="timeline-heading">
														            <a class="pull-left text-success m-r-10" href=""><i class="fa fa-arrow-right" aria-hidden="true"></i></a>Record '.$incident.' associated with '.$punch_details['status'].' -
														          <a class="pull-right text-success '.$day_status_class.'" href="'.base_url().'attendance/edit_attendance/'.$user_id.'/'.$a_days.'/'.$atten_month.'/'.$atten_year.'/'.$key.'/punch_in/'.$punch_details['punchin_workcode'].'"  data-toggle="ajaxModal"><i class="fa fa-pencil"></i></a>

														         </div>
														         <div class="timeline-content">
														          <p><b>'.date('d/m/Y',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)).' '.date("g:i a", strtotime($punch_details['punch_in'])).'</b></p>
														           
														         </div>
														       
														       </div>
														     </li>';
														     $find_punch = 'punch_out';
								                        }
								                        if(!empty($punch_details['punch_out']))
								                        {

								                        	$punch_out_workcode = $this->db->get_where('dgt_incidents',array('id'=>$punch_details['punchout_workcode']))->row_array(); 
								                        	 	if(!empty($punch_out_workcode)){
								                        	 		$incident = 'with incidence: "'.$punch_out_workcode['incident_name'].'".';
								                        	 	}else{
								                        	 		$incident= '';
								                        	 	}
								                        	 	if(isset($punch_details['punchout_workcode'])){
								                        	 		$punch_details['punchout_workcode'] = $punch_details['punchout_workcode'];
								                        	 	}else{
								                        	 		$punch_details['punchout_workcode'] = 0;
								                        	 	}
								                           echo'<li class="timeline-item">
											       <div class="timeline-badge"><a href="#"></a></div>
											       <div class="timeline-panel">
											         <div class="timeline-heading">
											          <a class="pull-left text-danger m-r-10" href=""><i class="fa fa-arrow-left" aria-hidden="true"></i></a>Record '.$incident.' associated with '.$punch_details['status'].' -
											         <a class="pull-right text-success '.$day_status_class.'" href="'.base_url().'attendance/edit_attendance/'.$user_id.'/'.$a_days.'/'.$atten_month.'/'.$atten_year.'/'.$key.'/punch_out/'.$punch_details['punchout_workcode'].'"  data-toggle="ajaxModal"><i class="fa fa-pencil"></i></a>
											         </div>
											         <div class="timeline-content">
											          <p><b>'.date('d/m/Y',strtotime($atten_year.'-'.$atten_month.'-'.$atten_day)).' '.date("g:i a", strtotime($punch_details['punch_out'])).'</b></p>
											           
											         </div>
											       
											       </div>
											     </li>';
														$find_punch = 'punch_in';
								                       }
								                       $i++;
								                      }

								                    }

								                    if(empty($find_punch)){
								                    	$find_punch = 'punch_in';
								                    }
								                  
								                     ?>
												</ul> 


												 <!-- <ul class="timeline m-t-30">
											     <li class="timeline-line"></li>
											     <li class="timeline-item">
											       <div class="timeline-badge"><a href="#"></a></div>
											       <div class="timeline-panel">
											         <div class="timeline-heading">
											            <a class="pull-left text-danger m-r-10" href=""><i class="fa fa-arrow-right" aria-hidden="true"></i></a>Minor Update
											          <a class="pull-right text-success" href=""><i class="fa fa-pencil"></i></a>
											         </div>
											         <div class="timeline-content">
											          <p><b>added line 205 to 207 for <i>timeline date</i></b></p>
											           
											         </div>
											       
											       </div>
											     </li>
											     <li class="timeline-item">
											       <div class="timeline-badge"><a href="#"></a></div>
											       <div class="timeline-panel">
											         <div class="timeline-heading">
											          <a class="pull-left text-success m-r-10" href=""><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
											           Minor Update
											         <a class="pull-right text-success" href=""><i class="fa fa-pencil"></i></a>
											         </div>
											         <div class="timeline-content">
											          <p><b>added line 205 to 207 for <i>timeline date</i></b></p>
											           
											         </div>
											       
											       </div>
											     </li>
											 </ul> -->
											 <?php if($day_status !='yes'){?>
											 <div class="text-center"><a class="btn brand-btn m-t-30 text-white" href="<?php echo base_url().'attendance/add_attendance_modal/'.$user_id.'/'.$a_days.'/'.$atten_month.'/'.$atten_year.'/'.$find_punch; ?>" data-toggle="ajaxModal" ><i class="fa fa-plus"></i> <?php echo lang('add_record');?></a></div>
											<?php }?>
											 <form  action="<?php echo base_url(); ?>attendance/update_day_status" method="POST" class="form-horizontal">
											 	<input type="hidden" name="user_id" value="<?php echo $user_id?>">
						                        <input type="hidden" name="day" value="<?php echo $atten_day?>">
						                        <input type="hidden" name="month" value="<?php echo $atten_month?>">
						                        <input type="hidden" name="year" value="<?php echo $atten_year?>">
											 <div class="row">
												  <div class="col-md-12">
													  <div class="form-group">
														  <label><?php echo lang('status_of_the_day');?></label>
														  <select class="form-control" name="day_status" <?php echo($day_status =='yes')?'disabled':'';?> data-toggle="tooltip" title="<?php echo($day_status =='yes')?lang('closed_by_manager'):'';?>">
														  <option value="pending" <?php echo ($month_days[$a_day]['day_status']=='pending')?'selected':''?>><?php echo lang('pending');?> </option>
														  <option value="closed" <?php echo ($month_days[$a_day]['day_status']=='closed')?'selected':''?>><?php echo lang('closed');?></option>
														  </select>
													  </div>
												  </div>
											 </div>
											 <div class="row">
												  <div class="col-md-12">
													  <!-- <a href="#" type="submit" class="btn btn-primary pull-right m-l-10"><?php echo lang('save');?></a> -->
													  <button type="submit" class="btn btn-primary pull-right m-l-10 <?php echo($day_status =='yes')?'hide':'';?>" ><?=lang('save_changes')?></button>
													  <a href="#" class="btn btn-danger pull-left" type="button" data-dismiss="modal" aria-label="Close"><?php echo lang('cancel');?></a>
												  </div>
											 </div>
											 </form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			
				<!-- /Attendance Modal -->



