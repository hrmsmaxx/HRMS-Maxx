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
		<div class="row">
			<div class="col-sm-5">
				<h4 class="page-title">Shift List</h4>
			</div>
			<div class="col-sm-7 text-right m-b-30">
				<a href="<?php echo base_url(); ?>shift_scheduling/add_schedule" class="btn add-btn">Assign Shifts</a>
				<a href="<?php echo base_url(); ?>shift_scheduling/add_shift" class="btn add-btn m-r-5">Add Shift</a>				
			</div>
		</div>
		<!-- /Page Title -->
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0" id="shifts">
						<thead>
							<tr>
								<th><b>#</b></th>							
								<th><b>Shift Name</b></th>							
								<th><b>Min Start Time</b></th>							
								<th><b>Start time</b></th>							
								<th><b>Max Start time</b></th>							
								<th><b>Min End Time</b></th>							
								<th><b>End Time</b></th>							
								<th><b>Max End Time</b></th>							
								<th><b>Break Time</b></th>						
								<th><b>Note</b></th>						
								<th><b>Status</b></th>						
								<th><b>Actions</b></th>						
								
							</tr>
						</thead>
						<tbody>
						<?php 
						if (count($shifts) > 0) {
							$i=1;
							foreach ($shifts as $shift) { ?>
								<td><?php echo $i ;?></td>
								<td><?php echo $shift['shift_name'];?></td>
								<td><?php echo date('h:i:s a', strtotime($shift['min_start_time']));?></td>
								<td><?php echo date('h:i:s a', strtotime($shift['start_time']));?></td>
								<td><?php echo date('h:i:s a', strtotime($shift['max_start_time']));?></td>
								<td><?php echo date('h:i:s a', strtotime($shift['min_end_time']));?></td>
								<td><?php echo date('h:i:s a', strtotime($shift['end_time']));?></td>
								<td><?php echo date('h:i:s a', strtotime($shift['max_end_time']));?></td>
								<td><?php echo $shift['break_time'].' mins';?></td>
								<td><?php echo $shift['tag'];?></td>
								<td><?php echo ($shift['published'] == 1)?'Active':'In-active';?></td>
								<td class="text-right">									
			                        <div class="dropdown">
										<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#">
											<i class="fa fa-ellipsis-v"></i>
										</a>
			                          <ul class="dropdown-menu pull-right">
			                            <?php if (User::is_admin()) { ?>

			                            <li><a href="<?=base_url()?>shift_scheduling/edit_shift/<?=$shift['id']?>"><?=lang('edit_shift')?></a></li>
			                            <li><a href="<?=base_url()?>shift_scheduling/delete_shift/<?=$shift['id']?>" data-toggle="ajaxModal" title="<?=lang('delete_shift')?>"><?=lang('delete_shift')?></a></li>
			                                
			                            <?php } ?>

			                          </ul>
			                        </div>
								</td>
							</tr>
							<?php $i++; } 
						} else{ ?>
							<tr>
								<td colspan="10">No Records Found</td>
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