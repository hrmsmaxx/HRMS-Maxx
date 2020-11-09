<?php $departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("deptname", "asc")->get('departments')->result();
	
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
				<li><a href="<?php echo base_url(); ?>"><?php echo lang('employess');?></a></li>
				<li><a href="<?php echo base_url(); ?>"><?php echo lang('shift_scheduling');?></a></li>
				<li class="active"><?php echo lang('edit_shift');?></li>
			</ul>
		</div>
		<div class="col-sm-4  text-right m-b-20">     
	          <a class="btn back-btn" href="<?=base_url()?>shift_scheduling/shift_list"><i class="fa fa-chevron-left"></i><?php echo lang('back');?></a>
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
					<h6 class="panel-title"><?php echo lang('edit_shift');?></h6>
				</div>
				<div class="panel-body">
					<form method="POST" id="scheduleAddForm" action="<?php echo base_url().'shift_scheduling/edit_shift'?>">
						<div class="row">
							<div class="col-md-12">
								<?php if(isset($shift_details) && !empty($shift_details)){?>
																
										<input class="form-control" type="hidden" value="<?=$shift_details['id']?>" name="id" />								

									<?php } ?>
								<div class="form-group">
									<label><?php echo lang('shift_name');?> <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="shift_name" id="shift_name" value="<?php echo (isset($shift_details['shift_name']) && !empty($shift_details['shift_name']))?$shift_details['shift_name']:'';?>" >
								</div>		
								<!-- <div class="form-group">
									 <label><?php echo lang('branches');?> <span class="text-danger">*</span></label>
									<select class="select event-from-time form-control" name="branch_id" id="branch_id" required="required">
										<option value="" selected disabled><?php echo lang('branch');?></option>
										<?php
										if(!empty($branches))	{
										foreach ($branches as $branches){ ?>
										<option value="<?php echo $branches->id;?>" <?php echo (isset($shift_details['branch_id']) && ($shift_details['branch_id'] == $branches->id))?'selected':'';?>><?php echo $branches->branch_name;?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>		 -->				
								<div class="form-group">
									<label><?php echo lang('start_date');?> <span class="text-danger">*</span></label>
									<div class="cal-icon">
										<input class="datepicker-schedule form-control" name="start_date" id="start_date" data-date-format="dd-mm-yyyy" value="<?php echo (isset($shift_details['start_date']) && ($shift_details['start_date'] =='0000-00-00'))?'':date('d-m-Y',strtotime($shift_details['start_date']));?>" placeholder="DD/MM/YYYY">
									</div>
								</div>	
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('min_start_time');?><span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="min_start_time" id="min_start_time" value="<?php if(isset($shift_details) && ($shift_details['min_start_time'] == '00:00:00')){
													echo '';
												} else { echo (isset($shift_details) && !empty($shift_details['min_start_time']))?$shift_details['min_start_time']:"";}?>" <?php echo ($shift_details['free_shift'] ==1 )?"disabled":"";?>>
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('start_time');?> <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="start_time" id="start_time" value="<?php  if(isset($shift_details) && ($shift_details['start_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['start_time']))?$shift_details['start_time']:"";}?>" <?php echo ($shift_details['free_shift'] ==1 )?"disabled":"";?>>
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('max_start_time');?> <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="max_start_time" id="max_start_time" value="<?php  if(isset($shift_details) && ($shift_details['max_start_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['max_start_time']))?$shift_details['max_start_time']:"";}?>" <?php echo ($shift_details['free_shift'] ==1 )?"disabled":"";?>>
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
												<input type="text" class="form-control free_type" name="min_end_time" id="min_end_time" value="<?php if(isset($shift_details) && ($shift_details['min_end_time'] == '00:00:00')){
													echo '';
												} else { echo (isset($shift_details) && !empty($shift_details['min_end_time']))?$shift_details['min_end_time']:"";}?>" <?php echo ($shift_details['free_shift'] ==1 )?"disabled":"";?>>
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('end_time');?><span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="end_time" id="end_time" value="<?php if(isset($shift_details) && ($shift_details['end_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['end_time']))?$shift_details['end_time']:"";}?>" <?php echo ($shift_details['free_shift'] ==1 )?"disabled":"";?>>
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>												
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('max_end_time');?> <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control free_type" name="max_end_time" id="max_end_time" value="<?php if(isset($shift_details) && ($shift_details['max_end_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['max_end_time']))?$shift_details['max_end_time']:"";}?>" <?php echo ($shift_details['free_shift'] ==1 )?"disabled":"";?>>
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									
								</div>
									
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('break_time');?> <span class="text-danger">*</span></label>
											<div class='input-group'>
												<input type="text" class="form-control" name="break_time" id="break_time" value="<?php if(isset($shift_details) && ($shift_details['break_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['break_time']))?$shift_details['break_time']:"";}?>">
												
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('break_start_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="break_start" id="break_start" value="<?php if(isset($shift_details) && ($shift_details['break_start'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['break_start']))?$shift_details['break_start']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('break_end_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="break_end" id="break_end" value="<?php if(isset($shift_details) && ($shift_details['break_end'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['break_end']))?$shift_details['break_end']:"";}?>">
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
												<option value="<?php echo $project->project_id;?>" <?php echo (isset($shift_details['project_id']) && ($shift_details['project_id'] == $project->project_id))?"selected":""?> ><?php echo $project->project_code;?></option>
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
											  <label><input type="checkbox"  name="free_shift" id="free_shift" value="1" <?php echo (isset($shift_details['free_shift']) && ($shift_details['free_shift'] ==1))?"checked":"";?>><?php echo lang('free_shift');?></label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox"  name="recurring_shift" id="recurring_shift" value="1" <?php echo (isset($shift_details['recurring_shift']) && ($shift_details['recurring_shift'] ==1))?"checked":"";?>><?php echo lang('recurring_shift');?></label>
											</div>
											<div class="checkbox ">
											  <label><input type="checkbox"  name="cyclic_shift" id="cyclic_shift" value="1" <?php echo (isset($shift_details['cyclic_shift']) && ($shift_details['cyclic_shift'] ==1))?"checked":"";?>><?php echo lang('cyclic_shift');?></label>
											</div>
											<span class="shift_error" style="color: red; display: none"><?php echo lang('please_select_any_shift');?></span>
										</div>
									</div>
									<div class="col-md-4 <?php echo (isset($shift_details['free_shift']) && ($shift_details['free_shift'] ==1 ))?"":"hide";?> free_shift_hours">
										<div class="form-group">
											<label><?php echo lang('work_time');?> (<?php echo lang('in_hours');?>) <span class="text-danger">*</span></label>
											<div class='input-group'>
												<input type="text" class="form-control " name="work_hours" id="work_hours" value="<?php echo $shift_details['work_hours'] ?>" <?php echo ($shift_details['free_shift'] !=1 )?"disabled":"";?>>
											</div>
										</div>
									</div>
								</div>	
								<div class="row <?php echo (isset($shift_details['free_shift']) && ($shift_details['free_shift'] ==1 ))?"":"hide";?> free_shift_hours">
									<div class="col-md-4">
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('range_start_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control other_type" name="range_start_time" id="range_start_time" value="<?php if(isset($shift_details) && ($shift_details['start_time'] == '00:00:00')){
													echo '';
												} else { echo (isset($shift_details) && !empty($shift_details['start_time']))?$shift_details['start_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('range_end_time');?> </label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control other_type" name="range_end_time" id="range_end_time" value="<?php if(isset($shift_details) && ($shift_details['end_time'] == '00:00:00')){
													echo '';
												} else { echo (isset($shift_details) && !empty($shift_details['end_time']))?$shift_details['end_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
								</div>
								<div id="recurring" class="<?php echo ($shift_details['recurring_shift'] ==1 || $shift_details['free_shift'] ==1)?"":"hide";?>">
									<div class="form-group">										
										<label><?php echo lang('week');?>(s)</label>
									</div>		
									<?php $weekdays = explode(',',$shift_details['week_days']);?>
									<div class="form-group wday-box">
										<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="monday" class="days recurring recurring_days" <?php echo in_array('monday', $weekdays)?"checked":"" ;?>><span class="checkmark">M</span></label>
	    
	   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="tuesday" class="days recurring recurring_days" <?php echo in_array('tuesday', $weekdays)?"checked":"" ;?>><span class="checkmark">T</span></label>
									   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="wednesday" class="days recurring recurring_days" <?php echo in_array('wednesday', $weekdays)?"checked":"" ;?>><span class="checkmark">W</span></label>
									   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="thursday" class="days recurring recurring_days" <?php echo in_array('thursday', $weekdays)?"checked":"" ;?>><span class="checkmark">T</span></label>
									    
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="friday" class="days recurring recurring_days" <?php echo in_array('friday', $weekdays)?"checked":"" ;?>><span class="checkmark">F</span></label>
									   
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="saturday" class="days recurring recurring_days" <?php echo in_array('saturday', $weekdays)?"checked":"" ;?>><span class="checkmark">S</span></label>
									  
								      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="sunday" class="days recurring recurring_days" <?php echo in_array('sunday', $weekdays)?"checked":"" ;?>><span class="checkmark">S</span></label>
									</div>	
									<span class="week_days_error" style="color: red; display: none"><?php echo lang('please_select_the_days');?></span>
									
									<div class="form-group week_days">
										
										
									</div>
								</div>
								<div class="form-group indefinite <?php echo ($shift_details['recurring_shift'] ==1 || $shift_details['free_shift'] ==1)?"":"hide";?>">
										<div class="checkbox">
										  <label><input type="checkbox"  name="indefinite" id="indefinite" value="1" <?php echo ($shift_details['indefinite'] =='1')?"checked":"";?>><?php echo lang('indefinite');?></label>
										</div>
									</div>
								<div class="form-group recurring_end_date <?php echo ($shift_details['cyclic_shift'] ==1)?"hide":""?>">
									<label><?php echo lang('end_on');?> <span class="text-danger">*</span></label>
									<div class="cal-icon">
										<input class="datepicker-schedule form-control" name="end_date" id="end_date" data-date-format="dd-mm-yyyy" value="<?php echo (isset($shift_details['end_date']) && ($shift_details['end_date'] =='0000-00-00'))?'':date('d-m-Y',strtotime($shift_details['end_date']));?>" placeholder="DD/MM/YYYY"  <?php echo ($shift_details['indefinite'] =='1')?"disabled":"";?>>
									</div>
								</div>	
								
								<div class="form-group total_cyclic_days <?php echo ($shift_details['cyclic_shift'] ==1)?"":"hide"?>">
									<label><?php echo lang('no_of_days_in_cycle');?> </label>
									<input class="form-control only-numeric" type="text" name="no_of_days_in_cycle" id="total_cyclic_days" value="<?php echo (!empty($shift_details['no_of_days_in_cycle']))?$shift_details['no_of_days_in_cycle']:'';?>" />
									<span class="error" style="color: red; display: none"><?php echo lang('numbers_only_allowed');?></span>
									<span class="days_in_cycle_error" style="color: red; display: none"><?php echo lang('please_enter_total_days');?></span>
								</div>	
								<div class="form-group wday-box cyclic_days">
									<?php
									  if($shift_details['cyclic_shift'] ==1){
									for ($i=1; $i < $shift_details['no_of_days_in_cycle']+1; $i++) { ?>
										
											<label class="checkbox-inline "><input type="checkbox" name="workdays[]" value="<?php echo $i;?>" class="days recurring cyclic_days_vali" <?php echo ($shift_details['workday'] >= $i)?"checked":""?> onclick="return false;"><span class="checkmark"><?php echo $i;?></span></label>	
										
										
									<?php } } ?>
								</div>
								<span class="cyclic_days_error" style="color: red; display: none"><?php echo lang('please_select_the_days');?></span>
															
								<div class="form-group">
									<label><?php echo lang('add_a_tag');?> </label>
									<input class="form-control" type="text" data-role="tagsinput" name="tag" id="tag" value="<?php echo (isset($shift_details) && !empty($shift_details['tag']))?$shift_details['tag']:"";?>" />
								</div>
								<div class="form-group">
									<label><?php echo lang('add_a_note');?></label>
									<textarea class="form-control" rows="4" name="note" id="note"><?php echo (isset($shift_details) && !empty($shift_details['note']))?$shift_details['note']:"";?></textarea>
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
                                            <input type="checkbox" id="contact_status" name="publish" class="check" <?php echo ($shift_details['published'] == 1)?"checked":"";?> value="1">
                                            <label for="contact_status" class="checktoggle"><?php echo lang('checkbox');?></label>
                                        </div>
                                    </div>
								<div class="submit-section">
									<a href="<?php echo base_url(); ?>shift_scheduling/shift_list" class="btn btn-danger submit-btn m-b-5" type="submit"><?php echo lang('cancel');?></a>
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