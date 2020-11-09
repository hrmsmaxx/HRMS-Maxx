<?php $departments = $this->db->order_by("deptname", "asc")->get('departments')->result(); ?>
<?php
	 if(isset($employee_details) && !empty($employee_details)){
 		$shifts = $this->db->where('published',1)->where('recurring_shift',0)->order_by("id", "asc")->get('shifts')->result();
 	}else{
 		$shifts = $this->db->where('published',1)->order_by("id", "asc")->get('shifts')->result();
 	}
 ?>
<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title m-b-0">Employees Management</h4>
			<ul class="breadcrumb m-b-20 p-l-0" style="background:none; border:none;">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li><a href="<?php echo base_url(); ?>">Employees</a></li>
				<li><a href="<?php echo base_url(); ?>shift_scheduling">Shift Schedule</a></li>
				<li class="active">Daily Schedule</li>
			</ul>
		</div>
		<div class="col-sm-4  text-right m-b-20">     
	          <a class="btn back-btn" href="<?=base_url()?>shift_scheduling"><i class="fa fa-chevron-left"></i> Back</a>
	      </div>
	</div>
	<!-- <div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li ><a href="<?php echo base_url(); ?>shift_scheduling">Daily Schedule</a></li>
			<li class="active"><a href="<?php echo base_url(); ?>shift_scheduling/add_schedule"><?php echo lang('add_schedule');?></a></li></ul>
		</div> -->
	<div class="row">
		<div class="col-lg-8">
			<!-- Add Schedule -->
			<div class="panel">
				<div class="panel-heading">
					<h6 class="panel-title">Add Schedule</h6>
				</div>
				<div class="panel-body">
					<form method="POST" id="employeeScheduleAddForm" action="<?php echo base_url().'shift_scheduling/add_schedule'?>">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">

									<?php if(isset($employee_details) && !empty($employee_details)){?>
										<input class="form-control" type="hidden" value="<?=$employee_details['deptid']?>" name="department" />								
										<input class="form-control" type="hidden" value="<?=$employee_details['id']?>" name="employee[]" />								
										<input class="form-control" type="hidden" value="<?=$schedule_date?>" name="schedule_date" />								
										<input class="form-control" type="hidden" value="0" name="single_insert" />								

									<?php } else{ ?>
										<input class="form-control" type="hidden" value="0" name="multiple_insert" />	
									<?php } ?>
									<label>Department <span class="text-danger">*</span></label>
									<select class="select event-from-time form-control" name="department" id="department" <?php echo (isset($employee_details['deptname']))?"disabled":""?>>
										<option value="" selected disabled>Department</option>
										<?php
										if(!empty($departments))	{
										foreach ($departments as $department){ ?>
										<option value="<?=$department->deptid?>" <?php echo (isset($employee_details['deptname']) && ($employee_details['deptid'] == $department->deptid))?"selected":""?>><?=$department->deptname?></option>
										<?php } ?>
										<?php } ?>s
									</select>
								</div>
								<div class="form-group">
									<label>Employee Name <span class="text-danger">*</span></label>
									<select class="select2-option event-from-time form-control" multiple="multiple"  style="width:100%;"  name="employee[]" id="employee"  <?php echo (isset($employee_details['fullname']))?"disabled":""?>> 
										<?php if(isset($employee_details['id']) && (!empty($employee_details['id'] ))){ ?>
											<option value="<?=$employee_details['id']?>" selected><?=ucfirst(User::displayName($employee_details['id']))?></option>
									<?php } ?>
										
										
									</select>											
								</div>
								<div class="form-group">
									<label>Color </label>
									<input type="color" class="form-control" name="color" value="#1EB53A">
								</div>
								<div class="form-group">
									<label>Date <span class="text-danger">*</span></label>
									<div class="cal-icon">
										<input class="datepicker-schedule form-control" name="schedule_date" id="schedule_date" data-date-format="dd-mm-yyyy" value="<?php echo (isset($schedule_date) && !empty($schedule_date))?$schedule_date:date('d-m-Y');?>" >
									</div>
								</div>
								<div class="form-group">
                                    <label>Shifts <span class="text-danger">*</span></label>
									<select class="select event-from-time form-control" name="shift_id" id="shift_id">
										<option value="" selected disabled>Shifts</option>
										<?php
										if(!empty($shifts))	{
											$j =1;
										foreach ($shifts as $shift){ ?>
										<option value="<?=$shift->id?>" ><?php echo $shift->shift_name;?></option>
										<?php $j++; } ?>
										<?php } ?>
									</select>
                                </div>
								<div class="row shift_details hide">
									<div class="col-md-4">
										<div class="form-group">
											<label>Min Start Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="min_start_time" id="min_start_time" value="" readonly>									
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Start Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="start_time" id="start_time" value="" readonly>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Max Start Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="max_start_time" id="max_start_time" value="" readonly>
												
											</div>
										</div>
									</div>																	
								</div>
								<div class="row shift_details hide">
									<div class="col-md-4">
										<div class="form-group">
											<label>Min End Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="min_end_time" id="min_end_time" value="" readonly>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>End Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input  type="text" class="form-control" name="end_time" id="end_time" value="" readonly>												
											</div>												
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Max End Time <span class="text-danger">*</span></label>
											<div class='input-group '>
												<input type="text" class="form-control" name="max_end_time" id="max_end_time" value="" readonly>
												
											</div>											
										</div>
									</div>
									
								</div>
								<div class="form-group shift_details hide">
									<label>Break Time </label>
									<div class='input-group'>
										<input type="text" class="form-control" name="break_time" id="break_time" value="" readonly>
										
									</div>											
								</div>	
								<div class="form-group shift_details ">
										<div class="checkbox">
										  
										</div>
								</div>
								<div class="form-group shift_details repeat_week hide">
									<label>Repeat Every Week(s)</label>
									<div class='input-group'>
										<input type="text" class="form-control" name="repeat_week" id="repeat_week" value="" readonly>
									</div>	
									
								</div>	
								<div class="form-group wday-box">
									
								</div>	
								<div class="form-group add_end_date hide">
									<label>End on <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="end_date" id="end_date" value="" readonly>									
								</div>	
								<div class="form-group shift_details hide">
									<div class="checkbox indefinite_checkbox">
									 
									</div>
								</div>
								<div class="form-group">
                                    <label class="d-block">Accept Extra Hours</label>
                                    <div class="status-toggle">
                                        <input type="checkbox" id="accept_extras" name="accept_extras" class="check" value="1" checked>
                                        <label for="accept_extras" class="checktoggle">checkbox</label>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="d-block">Publish</label>
                                    <div class="status-toggle">
                                        <input type="checkbox" id="contact_status" name="publish" class="check" value="1" checked>
                                        <label for="contact_status" class="checktoggle">checkbox</label>
                                    </div>
                                </div>
								<div class="submit-section">
									<a href="<?php echo base_url(); ?>shift_scheduling" class="btn btn-danger submit-btn m-b-5" type="submit">Cancel</a>
									<button class="btn btn-primary submit-btn m-b-5" id="submit_shift_scheduling_add" type="submit">Save</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>