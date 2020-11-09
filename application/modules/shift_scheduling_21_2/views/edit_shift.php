<?php $departments = $this->db->order_by("deptname", "asc")->get('departments')->result(); ?>
<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title m-b-0">Employees Management</h4>
			<ul class="breadcrumb m-b-20 p-l-0" style="background:none; border:none;">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li><a href="<?php echo base_url(); ?>">Employees</a></li>
				<li><a href="<?php echo base_url(); ?>shift_scheduling">Shift Schedule</a></li>
				<li class="active">Edit Shift</li>
			</ul>
		</div>
		<div class="col-sm-4  text-right m-b-20">     
	          <a class="btn back-btn" href="<?=base_url()?>shift_scheduling/shift_list"><i class="fa fa-chevron-left"></i> Back</a>
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
					<h6 class="panel-title">Edit Shift</h6>
				</div>
				<div class="panel-body">
					<form method="POST" id="scheduleAddForm" action="<?php echo base_url().'shift_scheduling/edit_shift'?>">
						<div class="row">
							<div class="col-md-12">
								<?php if(isset($shift_details) && !empty($shift_details)){?>
																
										<input class="form-control" type="hidden" value="<?=$shift_details['id']?>" name="id" />								

									<?php } ?>
								<div class="form-group">
									<label>Shift Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="shift_name" id="shift_name" value="<?php echo (isset($shift_details['shift_name']) && !empty($shift_details['shift_name']))?$shift_details['shift_name']:'';?>" >
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Min Start Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="min_start_time" id="min_start_time" value="<?php if(isset($shift_details) && ($shift_details['min_start_time'] == '00:00:00')){
													echo '';
												} else { echo (isset($shift_details) && !empty($shift_details['min_start_time']))?$shift_details['min_start_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Start Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="start_time" id="start_time" value="<?php  if(isset($shift_details) && ($shift_details['start_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['start_time']))?$shift_details['start_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Max Start Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="max_start_time" id="max_start_time" value="<?php  if(isset($shift_details) && ($shift_details['max_start_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['max_start_time']))?$shift_details['max_start_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>
										</div>
									</div>
																	
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Min End Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="min_end_time" id="min_end_time" value="<?php if(isset($shift_details) && ($shift_details['min_end_time'] == '00:00:00')){
													echo '';
												} else { echo (isset($shift_details) && !empty($shift_details['min_end_time']))?$shift_details['min_end_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>End Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="end_time" id="end_time" value="<?php if(isset($shift_details) && ($shift_details['end_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['end_time']))?$shift_details['end_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>												
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Max End Time <span class="text-danger">*</span></label>
											<div class='input-group date time_picker'>
												<input type="text" class="form-control" name="max_end_time" id="max_end_time" value="<?php if(isset($shift_details) && ($shift_details['max_end_time'] == '00:00:00')){
													echo '';
												} else {  echo (isset($shift_details) && !empty($shift_details['max_end_time']))?$shift_details['max_end_time']:"";}?>">
												<span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>
											</div>											
										</div>
									</div>
									
								</div>
								<div class="form-group">
									<label>Break Time </label>
									<div class='input-group'>
										<input type="text" class="form-control" name="break_time" id="break_time" value="<?php if(isset($shift_details) && ($shift_details['break_time'] == '00:00:00')){
											echo '';
										} else {  echo (isset($shift_details) && !empty($shift_details['break_time']))?$shift_details['break_time']:"";}?>">
										
									</div>											
								</div>	
								<div class="form-group">
									<div class="checkbox">
									  <label><input type="checkbox"  name="recurring_shift" id="recurring_shift" value="1" <?php echo (isset($shift_details['recurring_shift']) && ($shift_details['recurring_shift'] ==1))?"checked":"";?>>Recurring Shift</label>
									</div>
								</div>
								<!--  -->	
								<div id="recurring" class="<?php echo (isset($shift_details['recurring_shift']) && ($shift_details['recurring_shift'] ==1))?"":"hide";?>">
								<div class="form-group">
									<label>Repeat Every</label>
									<select class="select form-control recurring" name="repeat_week" id="repeat_week">
										<option value="1" <?php echo ($shift_details['repeat_week'] ==1)?"selected":"";?>>1</option>
										<option value="2" <?php echo ($shift_details['repeat_week'] ==2)?"selected":"";?>>2</option>
										<option value="3" <?php echo ($shift_details['repeat_week'] ==3)?"selected":"";?>>3</option>
										<option value="4" <?php echo ($shift_details['repeat_week'] ==4)?"selected":"";?>>4</option>
									</select>
									<label>Week(s)</label>
								</div>		
								<?php $weekdays = explode(',',$shift_details['week_days']);?>
								<div class="form-group wday-box">
									<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="monday" class="days recurring" <?php echo in_array('monday', $weekdays)?"checked":"" ;?>><span class="checkmark">M</span></label>
    
   
							      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="tuesday" class="days recurring" <?php echo in_array('tuesday', $weekdays)?"checked":"" ;?>><span class="checkmark">T</span></label>
								   
							      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="wednesday" class="days recurring" <?php echo in_array('wednesday', $weekdays)?"checked":"" ;?>><span class="checkmark">W</span></label>
								   
							      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="thursday" class="days recurring" <?php echo in_array('thursday', $weekdays)?"checked":"" ;?>><span class="checkmark">T</span></label>
								    
							      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="friday" class="days recurring" <?php echo in_array('friday', $weekdays)?"checked":"" ;?>><span class="checkmark">F</span></label>
								   
							      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="saturday" class="days recurring" <?php echo in_array('saturday', $weekdays)?"checked":"" ;?>><span class="checkmark">S</span></label>
								  
							      	<label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="sunday" class="days recurring" <?php echo in_array('sunday', $weekdays)?"checked":"" ;?>><span class="checkmark">S</span></label>
								</div>	
								<div class="form-group">
									<label>End on <span class="text-danger">*</span></label>
									<div class="cal-icon">
										<input class="datepicker-schedule form-control" name="end_date" id="end_date" data-date-format="dd-mm-yyyy" value="<?php echo (isset($shift_details['end_date']) && ($shift_details['end_date'] =='0000-00-00'))?'':$shift_details['end_date'];;?>" placeholder="DD/MM/YYYY">
									</div>
								</div>	
								<div class="form-group">
									<div class="checkbox">
									  <label><input type="checkbox"  name="indefinite" id="indefinite" value="1" <?php echo ($shift_details['indefinite'] =='1')?"checked":"";?>>Indefinite</label>
									</div>
								</div>
								<div class="form-group week_days">
									
									
								</div>
								</div>													
								<div class="form-group">
									<label>Add a tag </label>
									<input class="form-control" type="text" data-role="tagsinput" name="tag" id="tag" value="<?php echo (isset($shift_details) && !empty($shift_details['tag']))?$shift_details['tag']:"";?>" />
								</div>
								<div class="form-group">
									<label>Add a note</label>
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
                                        <label class="d-block">Publish</label>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="contact_status" name="publish" class="check" <?php echo ($shift_details['published'] == 1)?"checked":"";?> value="1">
                                            <label for="contact_status" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
								<div class="submit-section">
									<a href="<?php echo base_url(); ?>shift_scheduling/shift_list" class="btn btn-danger submit-btn m-b-5" type="submit">Cancel</a>
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