
<?php 
// echo"<pre>"; print_r($this->session->all_userdata()); exit;
	$departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("deptname", "asc")->get('departments')->result();
	$projects = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("project_id", "asc")->get('projects')->result();
	// if($this->session->userdata('branch_id') =='' && $this->session->userdata('role_name') ==''){		
	// 	$branches = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("branch_name", "asc")->get('branches')->result();
	// }else{
	// 	$branch_id = explode(',',$this->session->userdata('branch_id'));

	// 	$branches = $this->db->where_in('id',$branch_id)->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("branch_name", "asc")->get('branches')->result();
	// }
 ?>
<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title m-b-0"><?php echo lang('employee_management');?></h4>
			<ul class="breadcrumb m-b-20 p-l-0" style="background:none; border:none;">
				<li><a href="<?php echo base_url(); ?>"><?php echo lang('home');?></a></li>
				<li><a href="<?php echo base_url(); ?>"><?php echo lang('employees');?></a></li>
				<li><a href="<?php echo base_url(); ?>shift_scheduling"><?php echo lang('shift_scheduling');?></a></li>
				<li class="active"><?php echo lang('add_shift');?></li>
			</ul>
		</div>
		<div class="col-sm-4  text-right m-b-20">     
	          <a class="btn back-btn" href="<?=base_url()?>shift_scheduling/shift_list"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
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
					<h6 class="panel-title"><?php echo lang('add_shift');?></h6>
				</div>
				<div class="panel-body">
					<form method="POST" id="scheduleAddForm" action="<?php echo base_url().'shift_scheduling/add_shift'?>" >
						<div class="row">
							<div class="col-md-12">	

								<div class="form-group">
									<label><?php echo lang('shift_name');?> <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="shift_name" id="shift_name">
								</div>


										<!-- <div class="form-group">
											 <label><?php echo lang('branches');?> <span class="text-danger">*</span></label>
											<select class="select event-from-time form-control" name="branch_id" id="branch_id" required="required">
												<option value="" selected disabled><?php echo lang('branch');?></option>
												<?php
												if(!empty($branches))	{
												foreach ($branches as $branches){ ?>
												<option value="<?php echo $branches->id;?>" ><?php echo $branches->branch_name;?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div> -->
									
								
								<div class="form-group">
									<label><?php echo lang('start_date');?><span class="text-danger">*</span></label>
									<div class="cal-icon">
										<input class="start_date-schedule form-control " name="start_date" id="start_date" data-date-format="dd-mm-yyyy" value="" placeholder="DD/MM/YYYY"  data-date-start-date="0d">
									</div>
								</div>	
								<div class="row">
									<div class="col-md-4">
										<div class="form-group" >
											<label><?php echo lang('min_start_time');?> <span class="text-danger">*</span></label>
										 	<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="min_start_time" id="min_start_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('start_time');?> <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="start_time" id="start_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('max_start_time');?><span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="max_start_time" id="max_start_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>												
										</div>
									</div>									
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('min_end_time');?><span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="min_end_time" id="min_end_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>	
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('end_time');?><span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="end_time" id="end_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('max_end_time');?> <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="max_end_time" id="max_end_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									
								</div>		
								
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('break_time');?> (<?php echo lang('in_minutes');?>) <span class="text-danger">*</span></label>
											<div class='input-group'>
												<input type="text" class="form-control only-numeric" name="break_time" id="break_time">
												<span class="error" style="color: red; display: none"><?php echo lang('numbers_only_allowed');?></span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('break_start_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="break_start" id="break_start">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('break_end_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="break_end" id="break_end">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">									
										<div class="form-group">
											 <label><?php echo lang('project_id');?> <span class="text-danger">*</span></label>
											<select class="select event-from-time form-control" name="project_id" id="project_id">
												<option value="" selected disabled><?php echo lang('project');?></option>
												<?php
												if(!empty($projects))	{
												foreach ($projects as $project){ ?>
												<option value="<?php echo $project->project_id;?>" ><?php echo $project->project_code;?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>		
								</div>		
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<div class="checkbox">
											  <label><input type="checkbox"  name="free_shift" id="free_shift" value="1"><?php echo lang('free_shift');?></label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox"  name="recurring_shift" id="recurring_shift" value="1"><?php echo lang('recurring_shift');?></label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox"  name="cyclic_shift" id="cyclic_shift" value="1"><?php echo lang('cyclic_shift');?></label>
											</div>
											<span class="shift_error" style="color: red; display: none"><?php echo lang('please_select_any_shift');?></span>
										</div>
									</div>
									<div class="col-md-4 hide free_shift_hours">
										<div class="form-group">
											<label><?php echo lang('work_time');?> (<?php echo lang('in_hours');?>) <span class="text-danger">*</span></label>
											<div class='input-group'>
												<input type="text" class="form-control " name="work_hours" id="work_hours" value="" placeholder="08:30">
											</div>
										</div>
									</div>
								</div>
								<div class="row hide free_shift_hours">
									<div class="col-md-4">
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('range_start_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control other_type" name="range_start_time" id="range_start_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('range_end_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control other_type" name="range_end_time" id="range_end_time">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
								</div>
							
								<div class="form-group hide total_cyclic_days">
									<label><?php echo lang('no_of_days_in_cycle');?><span class="text-danger">*</span></label>
									<input class="form-control only-numeric_cyclic"  type="text" name="no_of_days_in_cycle"  id="total_cyclic_days" />
									<span class="error_cyclic" style="color: red; display: none"><?php echo lang('numbers_only_allowed');?></span>
									<span class="days_in_cycle_error" style="color: red; display: none"><?php echo lang('please_enter_total_days');?></span>
								</div>
								
								<div id="recurring" class="hide">
									<div class="form-group">
										<!-- <label><?php echo lang('repeat_every');?></label>
										<select class="select form-control recurring" name="repeat_week" id="repeat_week">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select> -->
										<label><?php echo lang('week');?>(s)<span class="text-danger">*</span></label>
									</div>		

									<div class="form-group wday-box">
										<label class="checkbox-inline "><input type="checkbox" name="week_days[]" value="monday" class="days recurring recurring_days"><span class="checkmark">M</span></label>
	    
	   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="tuesday" class="days recurring recurring_days"><span class="checkmark">T</span></label>
									   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="wednesday" class="days recurring recurring_days"><span class="checkmark">W</span></label>
									   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="thursday" class="days recurring recurring_days"><span class="checkmark">T</span></label>
									    
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="friday" class="days recurring recurring_days"><span class="checkmark">F</span></label>
									   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="saturday" class="days recurring recurring_days"><span class="checkmark">S</span></label>
									  
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="sunday" class="days recurring recurring_days"><span class="checkmark">S</span></label>

									</div>
									<span class="week_days_error" style="color: red; display: none"><?php echo lang('please_select_the_days');?></span>
									
									
									<div class="form-group week_days">
										
										
									</div>
								
								</div>

								<div class="form-group wday-box cyclic_days">
										
								</div>
								<span class="cyclic_days_error" style="color: red; display: none"><?php echo lang('please_select_the_days');?></span>
								
								<div class="form-group indefinite">
									<div class="checkbox">
									  <label><input type="checkbox"  name="indefinite" id="indefinite" value="1"><?php echo lang('indefinite');?></label>
									</div>
								</div>

								<div class="form-group recurring_end_date">
									<label><?php echo lang('end_on');?> <span class="text-danger">*</span></label>
									<div class="cal-icon">
										<input class="datepicker-schedule form-control" name="end_date" id="end_date" data-date-format="dd-mm-yyyy" value="" placeholder="DD/MM/YYYY" data-date-start-date="0d">
									</div>
								</div>	
								
								<div class="form-group">
									<label><?php echo lang('add_a_tag');?> </label>
									<input class="form-control" type="text" data-role="tagsinput" name="tag" id="tag" />
								</div>
								
								<div class="form-group">
									<label><?php echo lang('add_a_note');?></label>
									<textarea class="form-control" rows="4" name="note" id="note"></textarea>
								</div>
								<!-- <div class="form-group">
									<label>Publish</label>
									<div class="material-switch">
										<input id="someSwitch" class="form-control" name="publish" type="checkbox"/ checked value="1">
										<label for="someSwitch" class="label-warning"></label>
									</div>
								</div> -->
								<div class="form-group">
                                        <label class="d-block"><?php echo lang('publish');?></label>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="contact_status" name="publish" class="check" value="1" checked>
                                            <label for="contact_status" class="checktoggle"><?php echo lang('checkbox');?></label>
                                        </div>
                                    </div>
								<div class="submit-section">
									<a href="<?php echo base_url(); ?>shift_scheduling/shift_list" class="btn btn-danger submit-btn m-b-5" type="submit">Cancel</a>
									<button class="btn btn-primary submit-btn m-b-5" id="submit_scheduling_add" type="submit"><?php echo lang('save');?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>