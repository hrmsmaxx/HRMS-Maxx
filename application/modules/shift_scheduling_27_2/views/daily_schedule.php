<?php $departments = $this->db->order_by("deptname", "asc")->get('departments')->result(); ?>
<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title m-b-0">Employees Management</h4>
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
					<label class="control-label">Employee</label>
					<input type="text" class="form-control floating" name="username" id="username" value="<?php echo(isset($username))?$username:""?>">
					<label id="username_error" class="error display-none" for="username">Please enter the employee name</label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 col-md-3">
				<div class="form-group form-focus select-focus m-b-5" style="width:100%;">
					<label class="control-label">Department</label>
					<select class="select floating form-control" id="department_id" name="department_id" style="padding: 14px 9px 0px;">
						<option value="" selected="selected">All Departments</option>
						<?php if(!empty($departments)){ ?>
						<?php foreach ($departments as $department) { ?>
						<option value="<?php echo $department->deptid; ?>" <?php echo (isset($department_id) && $department_id == $department->deptid)?"selected":""?>><?php echo $department->deptname; ?></option>
						<?php  } ?>
						<?php } ?>
					</select>
					<label id="department_id_error" class="error display-none" for="department_id">Please select the department</label>
				
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 col-md-3">
				<div class="form-group form-focus m-b-5">
					<label class="control-label">Date</label>
					<input type="text" class="form-control floating date_range" id="schedule_date" name="schedule_date" value="<?php echo (isset($schedule_date))?$schedule_date:"";?>" autocomplete="off">
					<label id="schedule_date_error" class="error display-none" for="schedule_date">Please select the date</label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 col-md-2">
				<div class="form-group form-focus select-focus m-b-5" style="width:100%;">
					<label class="control-label">View by week or month</label>
					<select class="floating form-control" style="padding: 14px 9px 0px;" name="week" id="week">
						<option value="" selected="selected">Select</option>
						<option value="week" <?php echo (isset($week) && $week == 'week')?"selected":"";?>>Week</option>
						<option value="month" <?php echo (isset($week) && $week == 'month')?"selected":"";?>>Month</option>
					</select>
					<label id="week_error" class="error display-none" for="week">Please select the week or month</label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-6 col-md-2">  
				<!-- <a href="javascript:void(0)" id="employee_search_btn" onclick="filter_next_page(1)" class="btn btn-success btn-block btn-searchEmployee btn-circle"> Search </a>  -->

				<button id="shif_schedule_search_btn" class="btn btn-success btn-block btn-searchEmployee btn-circle" > Search </button>   
			</div>
		</form>
		</div>
	</div>
	<div class="card-box">
		<div class="row">
			<div class="col-sm-5">
				<h4 class="page-title">Daily Schedule</h4>
			</div>
			<div class="col-sm-7 text-right m-b-30">
				<a href="<?php echo base_url(); ?>shift_scheduling/add_schedule" class="btn add-btn"> Asign Shifts</a>
				<a href="<?php echo base_url(); ?>shift_scheduling/shift_list" class="btn add-btn m-r-5">Shifts</a>				
			</div>
		</div>
		<!-- /Page Title -->
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0" id="policies_table">
						<thead>
							<tr>
								<th><b>Scheduled Shift</b></th>

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
										echo'<th><b>'.date('D d', strtotime('+'.$i.' days', strtotime($schedules_date[0]))).'</b></th>';
								 	}else if(isset($week) && !empty($week)){
								 		if($week == 'week'){
								 			echo'<th><b>'.date('D d', strtotime('+'.$i.' days', strtotime($week_start))).'</b></th>';
								 		} else{
								 			echo'<th><b>'.date('D d', strtotime('+'.$i.' days', strtotime($first_day_this_month))).'</b></th>';
								 		}
								 	}else{
								 		echo'<th><b>'.date('D d', strtotime('+'.$i.' days', time())).'</b></th>';
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
                            			$employee_shifts = $this->db->get('shift_scheduling')->row_array();
                            				   // echo'<pre>';print_r($employee_shift);
                            				   // echo $this->db->last_query(); exit;
									 	// $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$shift['employee_id'],'schedule_date'=>$new_date))->row_array();
							// foreach ($employee_shift as $employee_shifts) { 
									     

                            if(!empty($employee_shifts)){
								?>
									<td>
										
									<div class="user-add-shedule-list">
										<h2>
											<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule/<?php echo $employee_shifts['id'];?>/<?php echo $employee_shifts['schedule_date'];?>" style="border:2px dashed <?php echo(!empty($employee_shifts['color']))?$employee_shifts['color']:"#1EB53A"?>" >
											<span class="username-info text-success m-b-10"><?php echo date("g:i a", strtotime($employee_shifts['start_time']));
?> - <?php echo date("g:i a", strtotime($employee_shifts['end_time']));

?> ( <?php echo differnceTime($employee_shifts['schedule_date'].' '.$employee_shifts['start_time'],$employee_shifts['schedule_date'].' '.$employee_shifts['end_time'],$employee_shifts['break_time']);?>)</span>
											<span class="userrole-info"><?php echo $shift['designation'].' - ' .config_item('company_name');?></span>
											</a>
										</h2>
									</div>
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
<!-- <div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title">Employees Management</h4>
		</div>
	</div>
	<div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li class="active"><a href="<?php echo base_url(); ?>shift_scheduling">Daily Schedule</a></li>
			<li><a href="<?php echo base_url(); ?>shift_scheduling/add_schedule"><?php echo lang('add_schedule');?></a></li>
		</ul>
	</div>
	<div class="card-box">
	<div class="row">
		<div class="col-sm-5 col-5">
			<h4 class="page-title">Daily Schedule</h4>
		</div>
		<div class="col-sm-7 col-7 text-right m-b-30">
			<a href="<?php echo base_url(); ?>shift_scheduling/view_schedule" class="btn add-btn"> View Schedule</a>
		</div>						
	</div>
	<!-- /Page Title -->
<!-- <div class="row">
	<div class="col-md-12">
		<table class="table table-striped custom-table m-b-0" id="policies_table">
			<thead>
				<tr>
					<th><b>Scheduled Shift</b></th>
					<th><b>Mon  </b></th>
					<th><b>Tue</b></th>
					<th><b>Wed </b></th>
					<th><b>Thu </b></th>
					<th><b>Fri </b></th>
					<th><b>Sat </b></th>
					<th><b>Sun </b></th>
					
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<div class="user_det_list">
						<a href="http://localhost/ramiro_hrms/employees/profile_view/315">
							<img class="avatar" src="http://localhost/ramiro_hrms/assets/avatar/default_avatar.jpg">
						</a>
						<h2>
							<a href="http://localhost/ramiro_hrms/employees/profile_view/315">
								<span class="username-info">Guru</span>
							</a> <span class="userrole-info">8 Hrs</span>
						</h2>
					</div>
				</td>	
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>	
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>	
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>	
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>
				<td>
					<div class="user-schdule-list user_det_list">
						<h2>
							<a href="<?php echo base_url(); ?>shift_scheduling/edit_schedule">
								<span class="username-info text-success m-b-10">9 am - 5 pm ( 8 hours )</span>
							 <span class="userrole-info">CEO - Dreams</span></a>
						</h2>
					</div>
				</td>	
	
			</tr>
				
			</tbody>
		</table>
	</div>
	</div>
	</div> -->
<!-- <div class="card-box m-b-0">
	<div class="row">
		<div class="col-xs-12 message_notifcation" ></div>
		<div class="col-xs-4">
			<h4 class="page-title">Employees</h4>
		</div>
		<div class="col-sm-8 col-9 text-right m-b-20">
			<a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_new_user"><i class="fa fa-plus"></i> Add Employee</a>
			<div class="view-icons">
				<a href="javascript:void(0)" onclick="changeviews(this,'grid')" class="viewby grid-view btn btn-link"><i class="fa fa-th"></i></a>
				<a href="javascript:void(0)" onclick="changeviews(this,'list')" class="viewby list-view btn btn-link active"><i class="fa fa-bars"></i></a>
			</div>
		</div>
	</div>	
	
	<div class="row filter-row">
		<div class="col-sm-6 col-xs-12 col-md-2">  
			<div class="form-group form-focus">
				<label class="control-label">Employee ID</label>
				<input type="text" class="form-control floating" id="employee_id" name="employee_id">
				<label id="employee_id_error" class="error display-none" for="employee_id">Employee Id must not empty</label>
			</div>
		</div>
	
		<div class="col-sm-6 col-xs-12 col-md-2">  
			<div class="form-group form-focus">
				<label class="control-label">Full Name</label>
				<input type="text" class="form-control floating" id="username" name="username">
				<label id="employee_name_error" class="error display-none" for="username">Full Name must not empty</label>
			</div>
		</div>
	
		<div class="col-sm-6 col-xs-12 col-md-2">  
			<div class="form-group form-focus">
				<label class="control-label">Email</label>
				<input type="text" class="form-control floating" id="employee_email" name="employee_email">
				<label id="employee_email_error" class="error display-none" for="employee_email">Email Field must not empty</label>
			</div>
		</div>
	
		<div class="col-sm-6 col-xs-12 col-md-3"> 
			<div class="form-group form-focus select-focus" style="width:100%;">
				<label class="control-label">Department</label>
				<select class="select floating form-control" id="department_id" name="department_id" style="padding: 14px 9px 0px;"> 
					<option value="" selected="selected">All Departments</option>
					<?php if(!empty($departments)){ ?>
					<?php foreach ($departments as $department) { ?>
					<option value="<?php echo $department->deptid; ?>"><?php echo $department->deptname; ?></option>
					<?php  } ?>
					<?php } ?>
				</select>
			</div>
		</div>
	
		<div class="col-sm-6 col-xs-6 col-md-3">  
			<a href="javascript:void(0)" id="employee_search_btn" onclick="filter_next_page(1)" class="btn btn-success btn-block btn-searchEmployee btn-circle"> Search </a>  
		</div>  
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div id="employees_details" data-view="list"></div>
		</div>
	</div>
	</div> -->
<!-- <div id="add_new_user" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Employee</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<?php $attributes = array('id' => 'employeeAddForm'); echo form_open(base_url().'auth/register_user',$attributes); ?>
					<p class="text-danger"><?php echo $this->session->flashdata('form_errors'); ?></p>
					<input type="hidden" name="r_url" value="<?=base_url()?>employees">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?=lang('full_name')?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" value="<?=set_value('fullname')?>" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_name')?>" name="fullname" autocomplete="off">
							</div>
						</div>
	
						<div class="col-sm-6">
							<div class="form-group">
								<label><?=lang('username')?> <span class="text-danger">*</span> <span id="already_username" style="display: none;color:red;">Already Registered Username</span></label>
								<input type="text" name="username" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_username')?>" id="check_username" value="<?=set_value('username')?>" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Gender</label><span class="text-danger">*</span>
								<select class="select2-option form-control" name="gender" style="width:100%;">
									<option value="" selected disabled>Gender</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?=lang('email')?> <span class="text-danger">*</span> <span id="already_email" style="display: none;color:red;">Already Registered Email</span></label>
								<input type="email" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_email')?>" name="email" id="checkuser_email" value="<?=set_value('email')?>" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label><?=lang('password')?> <span class="text-danger">*</span></label>
								<input type="password" placeholder="<?=lang('password')?>" value="<?=set_value('password')?>" name="password" id="password" class="form-control" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">  
							<div class="form-group">
								<label><?=lang('confirm_password')?> <span class="text-danger">*</span></label>
								<input type="password" placeholder="<?=lang('confirm_password')?>" value="<?=set_value('confirm_password')?>" name="confirm_password"  class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label><?=lang('phone')?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control telephone" value="<?=set_value('phone')?>" id="add_employee_phone" name="phone" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_phone')?>" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Address</label>  <a href="javascript:void(0)" class="office_address">Head Office</a>
								<input type="text" class="form-control" name="address" id="address" value="<?php echo $employee_details['address'];?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>City</label>
								<input type="text" class="form-control" name="city" id="city" value="<?php echo $employee_details['city'];?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>State/Province</label>
								<input type="text" class="form-control" name="state" id="state" value="<?php echo $employee_details['state'];?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Postal or Zip Code</label>
								<input type="text" class="form-control" name="pincode" id="pincode" value="<?php echo $employee_details['pincode'];?>">
							</div>
						</div>					
						<div class="col-sm-6">  
							<div class="form-group">
								<label>Start Date<span class="text-danger">*</span></label>
								<input class="form-control" readonly size="16" type="text" value="" name="emp_doj" id="emp_doj" data-date-format="yyyy-mm-dd" >
							</div>
						</div>
					</div>
	
					<?php 
		$departments = $this->db->order_by("deptname", "asc")->get('departments')->result();
		$mydefault = current($departments);
		$deptid   = (!empty($mydefault->deptid))?$mydefault->deptid:'-';
		$deptname = (!empty($mydefault->deptname))?$mydefault->deptname:lang('department_name');
		$records = array();
		if($deptid!='-'){
			$this->db->select('id,designation');
			$this->db->from('designation');
			$this->db->where('department_id', $deptid);
			$records = $this->db->get()->result_array();
		}
		?>	
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label><?=lang('department')?> <span class="text-danger">*</span></label>
									<input type="hidden" name="role" value="3">	
									<select class="select2-option" style="width:100%;" name="department_name" id="department_name">
										<option value="" selected disabled>Department</option>
										<?php
		if(!empty($departments))	{
		foreach ($departments as $department){ ?>
										<option value="<?=$department->deptid?>"><?=$department->deptname?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group">
									<label>Position <span class="text-danger">*</span></label>
									<select class="form-control" style="width:100%;" name="designations" id="designations">
										<option value="" selected disabled>Position</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Reporting to </label>
									<select class="form-control" style="width:100%;" name="reporting_to" id="reporting_to">
										<option value="" disabled="disabled" selected="">Reporter's Name</option>
									</select>
								</div>
							</div>
	
							<div class="col-sm-6">
								<div class="form-group">
									<label><?=lang('user_type')?> <span class="text-danger">*</span></label>
									<select class="select2-option" style="width:100%;" name="user_type" id="user_type">
										<option value="" selected disabled>User Type</option>
										<?php
		$user_type = $this->db->order_by('role','asc')->get('roles')->result();
		if(!empty($user_type))	{
		foreach ($user_type as $type){ ?>
										<option value="<?=$type->r_id?>"><?=$type->role?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
	
						<div class="submit-section">
							<button class="btn btn-primary submit-btn" id="register_btn">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
	
	</div> -->