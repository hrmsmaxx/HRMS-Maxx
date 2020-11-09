<?php $departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("deptname", "asc")->get('departments')->result(); ?>
<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title m-b-10"><?php echo lang('employee_management');?></h4>
			<!-- <ul class="breadcrumb m-b-30 p-l-0" style="background:none; border:none;">
				<li><a href="#">Home</a></li>
				<li><a href="#">Employees</a></li>
				<li><a href="#">Shift Schedule</a></li>
				<li class="active">Daily Schedule</li>
			</ul> -->
		</div>
	</div>
	<?php $this->load->view('sub_menus');?>
	
	<div class="card-box">
		<div class="row filter-row">
			<form id="timesheet_search" method="post" action="<?php echo base_url().'shift_scheduling/'; ?>">
			<div class="col-sm-6 col-xs-12 col-md-2">
				<div class="form-group form-focus m-b-5">
					<label class="control-label"><?php echo lang('employee');?></label>
					<input type="text" class="form-control floating" name="username" id="username" value="<?php echo(isset($username))?$username:""?>">
					<label id="username_error" class="error display-none" for="username"><?php echo lang('please_enter_the_employee_name');?></label>
				</div>
			</div>
			<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') { ?>
			<div class="col-sm-6 col-xs-12 col-md-3">
				<div class="form-group form-focus select-focus m-b-5" style="width:100%;">
					<label class="control-label"><?php echo lang('department');?></label>
					<select class="select floating form-control" id="department_id" name="department_id" style="padding: 14px 9px 0px;">
						<option value="" selected="selected"><?php echo lang('all_departments');?></option>
						<?php if(!empty($departments)){ ?>
						<?php foreach ($departments as $department) { ?>
						<option value="<?php echo $department->deptid; ?>" <?php echo (isset($department_id) && $department_id == $department->deptid)?"selected":""?>><?php echo $department->deptname; ?></option>
						<?php  } ?>
						<?php } ?>
					</select>
					<label id="department_id_error" class="error display-none" for="department_id"><?php echo lang('please_select_the_department');?></label>
				
				</div>
			</div>
		<?php } ?>
			<div class="col-sm-6 col-xs-12 col-md-3">
				<div class="form-group form-focus m-b-5">
					<label class="control-label"><?php echo lang('date');?></label>
					<input type="text" class="form-control floating date_range" id="schedule_date" name="schedule_date" value="<?php echo (isset($schedule_date))?$schedule_date:"";?>" autocomplete="off">
					<label id="schedule_date_error" class="error display-none" for="schedule_date"><?php echo lang('please_select_the_date');?></label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 col-md-2">
				<div class="form-group form-focus select-focus m-b-5" style="width:100%;">
					<!-- <label class="control-label"><?php echo lang('please_select_the_date');?><?php echo lang('view_by_week_or_month');?></label> -->
					<select class="floating form-control" style="padding: 14px 9px 0px;" name="week" id="week">
						<option value="" selected="selected"><?php echo lang('select');?></option>
						<option value="week" <?php echo (isset($week) && $week == 'week')?"selected":"";?>><?php echo lang('week');?></option>
						<option value="month" <?php echo (isset($week) && $week == 'month')?"selected":"";?>><?php echo lang('month');?></option>
					</select>
					<label id="week_error" class="error display-none" for="week"><?php echo lang('month');?></label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-6 col-xs-12 col-md-2">  
				<!-- <a href="javascript:void(0)" id="employee_search_btn" onclick="filter_next_page(1)" class="btn btn-success btn-block btn-searchEmployee btn-circle"> Search </a>  -->

				<button id="shif_schedule_search_btn" class="btn btn-success btn-block btn-searchEmployee btn-circle" ><?php echo lang('search');?></button>   
			</div>
		</form>
		</div>
	</div>
	<div class="card-box">
		<div class="row">	
			<div class="col-sm-5">
				<h4 class="page-title"><?php echo lang('daily_schedule');?></h4>
			</div>
			<div class="col-sm-7 text-right m-b-30">
				<a href="<?php echo base_url(); ?>shift_scheduling/add_schedule" class="btn add-btn"><i class="fa fa-plus"></i><?php echo lang('asign_shift');?></a>
				<a href="<?php echo base_url(); ?>shift_scheduling/shift_list" class="btn add-btn m-r-5"><?php echo lang('shifts');?></a>		
				<!-- <a href="<?php echo base_url(); ?>shift_scheduling/schedule_group" class="btn add-btn m-r-5"><?php echo lang('rotary_schedule_groups');?></a> -->
				<a href="#" class="btn add-btn m-r-5" data-toggle="modal" data-target="#add_night_hours"><i class="fa fa-plus"></i> <?php echo lang('night_hours')?></a>		
			</div>
		</div>
		<!-- /Page Title -->
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0" id="policies_table">
						<thead>
							<tr>
								<th><b><?php echo lang('scheduled_shift');?></b></th>

								<?php
									if(isset($schedule_date) && !empty($schedule_date)){
                            		$schedules_date = explode('-', $schedule_date);
                        			$from_date = date("Y-m-d", strtotime($schedules_date[0]));       
       								$to_date = date("Y-m-d", strtotime($schedules_date[1]));
        							$earlier = new DateTime($from_date);
									$later = new DateTime($to_date);

        							$col_count = $later->diff($earlier)->format("%a");
                            					
            //                 					$to_date = date("Y-m-d", $your_to_date);
            //                 					$this->db->where('schedule_date >=', $from_date);
												// $this->db->where('schedule_date <=', $to_date);
                            			}else if(isset($week) && !empty($week)){
                            				if($week == 'week'){
                            					$dt_min = new DateTime("last saturday"); // Edit
											$dt_min->modify('+1 day'); // Edit
											$dt_max = clone($dt_min);
											$dt_max->modify('+6 days');
											$week_start = $dt_min->format('Y/m/d');
											$week_end = $dt_max->format('Y/m/d');
											// echo 'This Week ('.$dt_min->format('m/d/Y').'-'.$dt_max->format('m/d/Y').')'; 
												$col_count = 6;
                            				} else{

                            					$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
												$last_day_this_month  = date('Y-m-t');
												$month_start = new DateTime($first_day_this_month);
												$month_end = new DateTime($last_day_this_month);

			        							$col_count = $month_end->diff($month_start)->format("%a");

                            				}
                            				
                            			}
                            			 else{
                            			 	$datetime = new DateTime(date());
					                        $start_date =  $datetime->format('d');
                            				// $col_count = date('t') - $start_date ;
                            				$col_count = 30 ;

					                        // $currentDayOfMonth=date('j');
					                        // $datetime = new DateTime($_POST['schedule_date']);
					                        // $start_date =  $datetime->format('d');
                            			}
                            			
								 for ($i=0; $i <=$col_count ; $i++) { 
								 	if(isset($schedule_date) && !empty($schedule_date)){
										echo'<th><b>'.lang(date('M', strtotime('+'.$i.' days', strtotime($schedules_date[0])))).' '.lang(date('D', strtotime('+'.$i.' days', strtotime($schedules_date[0])))).' '.lang(date('d', strtotime('+'.$i.' days', strtotime($schedules_date[0])))).'</b></th>';
								 	}else if(isset($week) && !empty($week)){
								 		if($week == 'week'){
								 			echo'<th><b>'.lang(date('M', strtotime('+'.$i.' days', strtotime($week_start)))).' '.lang(date('D', strtotime('+'.$i.' days', strtotime($week_start)))).' '.lang(date('d', strtotime('+'.$i.' days', strtotime($week_start)))).'</b></th>';
								 			// echo'<th><b>'.date('M D d', strtotime('+'.$i.' days', strtotime($week_start))).'</b></th>';
								 		} else{
								 			// echo'<th><b>'.date('M D d', strtotime('+'.$i.' days', strtotime($first_day_this_month))).'</b></th>';
								 			echo'<th><b>'.lang(date('M', strtotime('+'.$i.' days', strtotime($first_day_this_month)))).' '.lang(date('D', strtotime('+'.$i.' days', strtotime($first_day_this_month)))).' '.lang(date('d', strtotime('+'.$i.' days', strtotime($first_day_this_month)))).'</b></th>';
								 		}
								 	}else{
								 		// echo'<th><b>'.date('M D d', strtotime('+'.$i.' days', time())).'</b></th>';
								 		echo'<th><b>'.lang(date('M', strtotime('+'.$i.' days', time()))).' '.lang(date('D', strtotime('+'.$i.' days', time()))).' '.lang(date('d', strtotime('+'.$i.' days', time()))).'</b></th>';
								 	}
									
								} ?>
								
							</tr>
						</thead>
						<tbody>
						<?php 
						if (count($shift_scheduling) > 0) {
							foreach ($shift_scheduling as $shift) {

							$employee_shift = $this->db->get_where('shift_scheduling',array('employee_id'=>$shift['employee_id']))->result_array();
							 ?>
							<tr>
								<td>
									<div class="user_det_list">
										<a href="<?php echo base_url(); ?>employees/profile_view/<?php echo $shift['employee_id'];?>">
										<img class="avatar" src="<?php echo user::avatar_url($shift['employee_id'])?>">
										</a>
										<h2>
											<a href="<?php echo base_url(); ?>employees/profile_view/<?php echo $shift['employee_id'];?>">
											<span class="username-info"><?php echo user::displayName($shift['employee_id'])?></span>
											 <span class="userrole-info"> <?php echo $shift['designation'];?></span>
								                    <span class="username-info"> <?php echo !empty($shift['id_code'])?$shift['id_code']:"-";?></span></h2>
											</a>
											 <!-- <span class="userrole-info">8 Hrs</span> -->
										</h2>
									</div>
								</td>
								<?php 
								// if (count($employee_shift) > 0) {
								if(isset($schedule_date) && !empty($schedule_date)){
                            		$schedules_date = explode('-', $schedule_date);
                        			$from_date = date("Y-m-d", strtotime($schedules_date[0]));       
       								$to_date = date("Y-m-d", strtotime($schedules_date[1]));
        							$earlier = new DateTime($from_date);
									$later = new DateTime($to_date);

        							$col_count = $later->diff($earlier)->format("%a");
                            					
            //                 					$to_date = date("Y-m-d", $your_to_date);
            //                 					$this->db->where('schedule_date >=', $from_date);
												// $this->db->where('schedule_date <=', $to_date);
                            			}else if(isset($week) && !empty($week)){
                            				if($week == 'week'){
                            					$dt_min = new DateTime("last saturday"); // Edit
											$dt_min->modify('+1 day'); // Edit
											$dt_max = clone($dt_min);
											$dt_max->modify('+6 days');
											$week_start = $dt_min->format('Y/m/d');
											$week_end = $dt_max->format('Y/m/d');
											// echo 'This Week ('.$dt_min->format('m/d/Y').'-'.$dt_max->format('m/d/Y').')'; 
												$col_count = 6;
                            				} else{

                            					$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
												$last_day_this_month  = date('Y-m-t');
												$month_start = new DateTime($first_day_this_month);
												$month_end = new DateTime($last_day_this_month);

			        							$col_count = $month_end->diff($month_start)->format("%a");

                            				}
                            				
                            			}
                            			 else{
                            			 	$datetime = new DateTime(date());
					                        $start_date =  $datetime->format('d');
                            				// $col_count = date('t') - $start_date ;
                            				$col_count = 30 ;
                            			}
                            			
									 for ($i=0; $i <=$col_count ; $i++) { 
									 	if(isset($schedule_date) && !empty($schedule_date)){
									 		$your_from_date = strtotime('+'.$i.' days', strtotime($schedules_date[0]));
									 		$your_to_date = strtotime('+'.$i.' days', strtotime($schedules_date[1]));

									 	}else if(isset($week) && !empty($week)){
									 		if($week == 'week'){
                            					$week_from_date = strtotime('+'.$i.' days', strtotime($week_start));
									 		$week_to_date = strtotime('+'.$i.' days', strtotime($week_end));
											// // echo 'This Week ('.$dt_min->format('m/d/Y').'-'.$dt_max->format('m/d/Y').')'; 
												
                            				} else{

                            					$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
												$last_day_this_month  = date('Y-m-t');
												$month_from_date = strtotime('+'.$i.' days', strtotime($first_day_this_month));
									 		$month_to_date = strtotime('+'.$i.' days', strtotime($last_day_this_month));

                            				}
                            				
									 	}else{
									 	 $your_date = strtotime('+'.$i.' days', time());
									 	 $new_date = date("Y-m-d", $your_date);

									 	}
                            
                            			$this->db->where('employee_id',$shift['employee_id']);

                            			if(isset($schedule_date) && !empty($schedule_date)){
                            					
                            					$from_date = date("Y-m-d", $your_from_date);
                            					$to_date = date("Y-m-d", $your_to_date);
                            					$this->db->where('schedule_date', $from_date);
												// $this->db->where('schedule_date <=', $to_date);
                            			} elseif(isset($week) && !empty($week)){
                            				if($week == 'week'){
                            					$from_date = date("Y-m-d", $week_from_date);
                            					$to_date = date("Y-m-d", $week_to_date);
                            					$this->db->where('schedule_date', $from_date);
												// $this->db->where('schedule_date <=', $to_date);
                            				}else{
                            					$from_date = date("Y-m-d", $month_from_date);
                            					$to_date = date("Y-m-d", $month_to_date);
                            					$this->db->where('schedule_date', $from_date);
												// $this->db->where('schedule_date <=', $to_date);
                            				}

                            			} else {                            				
                            					$this->db->where('schedule_date',$new_date);
                            			}
                            			$employee_shifts = $this->db->get('shift_scheduling')->result_array();

                            				   // echo'<pre>';print_r($employee_shift);
                            				   // echo $this->db->last_query(); exit;
									 	// $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$shift['employee_id'],'schedule_date'=>$new_date))->row_array();
							// foreach ($employee_shift as $employee_shifts) { 
									     

                            if(!empty($employee_shifts)){
                            	
								?>
									<td>
										<?php foreach ($employee_shifts as $employee_shift) {
											$shift_name = $this->db->get_where('shifts',array('id'=>$employee_shift['shift_id']))->row()->shift_name;
										?>
									<div class="user-add-shedule-list">
										<h2 style="background: <?php echo($employee_shift['published'] == 1 && !empty($employee_shift['color']))?$employee_shift['color']:""?>">
											<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule/<?php echo $employee_shift['id'];?>/<?php echo $employee_shift['schedule_date'];?>" style="border:2px dashed <?php echo(!empty($employee_shift['color']))?$employee_shift['color']:"#1EB53A"?>" >
											<span class="username-info text-success m-b-10"><?php echo ($employee_shift['start_time'] !='00:00:00')?date("g:i a", strtotime($employee_shift['start_time'])).' -':'';
?><?php echo ($employee_shift['end_time'] !='00:00:00')?date("g:i a", strtotime($employee_shift['end_time'])):'';

?> ( <?php echo $employee_shift['work_hours'];?>)</span>
											<span class="userrole-info"><?php echo $shift_name.' - ' .config_item('company_name');?></span>
											</a>
										</h2>
									</div>
								<?php } ?>
								</td>
								<?php } else { ?> 
									<td>
									<div class="user-add-shedule-list">
										<a href="<?php echo base_url(); ?>shift_scheduling/add_schedule/<?php echo $shift['employee_id'];?>/<?php echo $new_date;?>">
										<span><i class="fa fa-plus"></i></span>
										</a>
									</div>
								</td>
								<?php }
							// }
							}
								 // } ?>
									
								<!-- <td>
									<div class="user-add-shedule-list">
										<a href="<?php echo base_url(); ?>shift_scheduling/add_schedule">
										<span><i class="fa fa-plus"></i></span>
										</a>
									</div>
								</td> -->
								
								
							</tr>
							<?php } 
						} else{ ?>
							<tr>
								<td colspan="57">No Records Found</td>
							</tr>
						<?php } ?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $night_hours = $this->db->get_where('night_hours',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
<div id="add_night_hours" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('add_night_hours');?></h4>
						</div>
						
						<div class="modal-body">
							<form method="post" id="" action="<?php echo base_url().'shift_scheduling/add_night_hours'; ?>"> 
								<?php if(!empty($night_hours)){?>
									<input type="hidden" class="form-control " name="id" value="<?php echo $night_hours['id'];?>">
								<?php }?>
						
								<div class="form-group">
									<label><?php echo lang('from');?> <span class="text-danger">*</span></label>
									<div class='input-group date time_picker col-md-6 col-xs-6'>
										<input type="text" class="form-control " name="start_time" id="start_time" required="required" value="<?php echo (!empty($night_hours))?$night_hours['start_time']:'';?>">
										<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
									</div>											
								</div>
								<div class="form-group">
									<label><?php echo lang('to');?> <span class="text-danger">*</span></label>
									<div class='input-group date time_picker col-md-6 col-xs-6'>
										<input type="text" class="form-control " name="end_time" id="end_time" required="required" value="<?php echo (!empty($night_hours))?$night_hours['end_time']:'';?>"> 
										<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
									</div>											
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" id=""><?php echo lang('submit');?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>