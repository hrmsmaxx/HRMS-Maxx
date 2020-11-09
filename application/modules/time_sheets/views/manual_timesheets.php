<?php //echo 'dept<pre>'; print_r($dept_id); exit; 
$dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
?>


            <!-- <div class="page-wrapper"> -->
            	
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title"><?php echo lang('manual_timesheets');?></h4>
						</div>
						<div class="col-sm-4  text-right m-b-20">     
				          <a class="btn back-btn" href="<?php echo base_url().'time_sheets'; ?>"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
			      	</div>
					</div>
					<?php $this->load->view('sub_menus');?>
					<div class="card-box">
					<div class="row">
						<div class="col-sm-8">
						</div>
						<?php  if(($this->tank_auth->user_role($this->tank_auth->get_user_type()) != 'admin')){ ?>
						<div class="col-sm-4 text-right m-b-30">
							<a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_todaywork"><i class="fa fa-plus"></i> <?php echo lang('add_today_work');?></a>
						</div> 
					<?php }  ?>
					</div>
					<?php 
					$all_employees = $this->timesheet_model->get_all_users();
					?>
				<div class="row filter-row">
							<div class="col-md-12 padding-2p search_date">
						<form id="timesheet_search" method="post" action="<?php echo base_url().'time_sheets/manual_timesheets'; ?>">
									<div class="row">
										<div class="col-sm-6 col-md-3 col-xs-6"> 
										<?php $user_type = $this->session->userdata('role_name'); 
											  	if($user_type != 'employee' || $user_type != 'client') { ?>
													<div class="form-group">
														 <select class="select2-option form-control" name="employee_id" id="employee_id">
									                        <optgroup label="">
									                        <option value=""><?php echo lang('select_employee');?></option> 
									                            <?php 
									                            if($user_type=='admin') {
									                            	$branch = explode(',', $this->session->userdata('branch_id'));
								                            		$employee = $this->db->select('*')
								                            				->from('users')
								                            				->where_in('branch_id', $branch)
								                            				->or_where(array('teamlead_id'=>$this->session->userdata('user_id'), 'id'=>$this->session->userdata('user_id')))
								                            				->where(array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))
								                            				->get()
								                            				->result();
									                            } else if($user_type == 'supervisor'){
									                            	if($dept_id != 0) {
									                            		$department = explode(',', $dept_id);
									                            		$branch = explode(',', $this->session->userdata('branch_id'));
									                            		$employee = $this->db->select('*')
									                            				->from('users')
									                            				->where_in('branch_id', $branch)
									                            				->where_in('department_id', $department)
									                            				->or_where(array('teamlead_id'=>$this->session->userdata('user_id'), 'id'=>$this->session->userdata('user_id')))
									                            				->where(array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))
									                            				->get()
									                            				->result();
									                            		
									                            	}
									                            	
									                            } else {
									                            	$employee = $this->db->get_where('users',array('role_id'=>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result();
									                            }


									                            foreach ($employee as $c): 
									                            ?>

									                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
									                            <?php endforeach;  ?>
									                        </optgroup>
									                    </select>
														<label id="employee_id_error" class="error display-none" for="employee_id"><?php echo lang('please_select_an_option');?></label>
													</div>
												<?php } ?>
										</div>
										<div class="col-sm-6 col-md-3 col-xs-6">
											<div class="form-group form-focus">
												<label class="control-label"><?php echo lang('date_from');?></label>
												<div class="cal-icon">
													<input class="form-control floating" id="timesheet_date_from" type="text" data-date-format="dd-mm-yyyy" name="search_from_date" id="search_from_date" value="<?php if($this->session->userdata('search_from_date') !=''){ echo $this->session->userdata('search_from_date');  } ?>" size="16">
													<label id="timesheet_date_from_error" class="error display-none" for="timesheet_date_from"><?php echo lang('from_date_not_empty');?></label>
												</div>
											</div>
										</div>
										<div class="col-sm-6 col-md-3 col-xs-6">
											<div class="form-group form-focus">
												<label class="control-label"><?php echo lang('date_to');?></label>
												<div class="cal-icon">
													<input class="form-control floating" id="timesheet_date_to" type="text" data-date-format="dd-mm-yyyy" name="search_to_date" id="search_to_date" value="<?php if($this->session->userdata('search_to_date') !=''){ echo $this->session->userdata('search_to_date');  } ?>" size="16">
													<label id="timesheet_date_to_error" class="error display-none" for="timesheet_date_to"><?php echo lang('to_date_not_empty');?></label>
												</div>
											</div>
										</div>
										<div class="col-sm-6 col-md-3 col-xs-6">  
										<div class="form-group">
												<button id="timesheet_search_btn" class="btn btn-success form-control" > <?php echo lang('search');?> </button>  
										</div>
										</div> 
									</div>
							 
						</form>
							</div> 
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table m-b-0 datatable">
									<thead>
										<tr>
											<th><?php echo lang('s_no');?></th>
											<th><?php echo lang('employee_name');?></th>
											<th><?php echo lang('date');?></th>
											<th><?php echo lang('project_name');?></th>
											<th><?php echo lang('work_hours');?></th>
											<!-- <th class="text-center">Hours</th> -->
											<th><?php echo lang('work_description');?></th>
											<?php if($this->tank_auth->user_role($this->tank_auth->get_user_type()) != 'admin'){ ?>
												<th class="text-right"><?php echo lang('actions');?></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php if(count($all_timesheet) != 0){ $a = 1; foreach($all_timesheet as $timesheet){ 
											 $user_details= $this->db->get_where('users',array('id'=>$timesheet['user_id']))->row_array();
					                                $account_details= $this->db->get_where('account_details',array('user_id'=>$timesheet['user_id']))->row_array();                    
					                                if(!empty($user_details['designation_id'])){
					                                  $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
					                                  $designation_name = $designation['designation'];
					                                  
					                                }else{
					                                  $designation_name = '-';
					                                }
											?>
										<tr>
											<td><?php echo $a; ?></td>
											<td>
													<div class="user_det_list" style="margin-bottom: 10px;">
										                            <a href="javascript:void(0)"> <img class="avatar" src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
										                            <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
										                            <span class="userrole-info"> <?php echo $designation_name;?></span>
										                            <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
									                          	</div>
											</td>
											<?php $tm_date = date("d-M-Y", strtotime($timesheet['timeline_date']));?>
											<td><?php echo $tm_date; ?></td>
											<td>
												<h2><?php echo $timesheet['project_title']; ?></h2>
											</td>
											<td><?php echo $timesheet['hours']; ?></td>
											<!-- <td class="text-center">7</td> -->
											<td class="col-md-4"><?php echo $timesheet['timeline_desc']; ?></td>
											<?php if($this->tank_auth->user_role($this->tank_auth->get_user_type()) != 'admin'){ ?>
											<td class="text-right" >
												<?php // $today_date = date('Y-m-d'); if($timesheet['timeline_date'] == $today_date){ ?>
												<div class="dropdown">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
													<ul class="dropdown-menu pull-right">
														<li><a href="#" title="Edit" data-toggle="modal" data-target="#edit_todaywork<?php echo $timesheet['time_id']; ?>"><i class="fa fa-pencil m-r-5"></i><?php echo lang('edit');?></a></li>
														<li><a href="#" title="Delete" data-toggle="modal" data-target="#delete_workdetail<?php echo $timesheet['time_id']; ?>"><i class="fa fa-trash-o m-r-5"></i> <?php echo lang('delete');?></a></li>
													</ul>
												</div>
											<?php // }else{ ?>
												<!-- <div class="dropdown">
													<span style="color:red;">Not Allowed</span> -->
													<!-- <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
													<ul class="dropdown-menu pull-right">
														<li><a href="#" title="Edit" data-toggle="modal" data-target="#edit_todaywork<?php //echo $timesheet['time_id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
														<li><a href="#" title="Delete" data-toggle="modal" data-target="#delete_workdetail<?php //echo $timesheet['time_id']; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
													</ul>
												</div> -->
											<?php // } ?>
											</td>
										<?php } ?>
										</tr>
									<?php $a++; } }else{ ?>
										<tr>
											<td colspan="6" style="text-align: center;"><?php echo lang('no_results_found');?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
                </div>
            <!-- </div> -->

            			<div id="add_todaywork" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('add_today_work_details'); ?></h4>
						</div>
						<div class="modal-body">
							<form method="post" id="add_timeline"> 
								<div class="form-group">
									<label><?php echo lang('project'); ?> <span class="text-danger">*</span></label>
									<select class="select form-control" name="project_name" id="project_name">
										<option value="" selected="selected" disabled=""><?php echo lang('choose_project');?></option>
										<?php foreach($projects as $project){ ?>
										<option value="<?php echo $project['project_id']; ?>"><?php echo $project['project_title']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label><?php echo lang('date'); ?> <span class="text-danger">*</span></label>
										<div class=""><input class="form-control TimeSheetDate" type="text" value="<?php echo date('d-m-Y'); ?>" name="timeline_date" id="timeline_date" data-date-format="dd-mm-yyyy"></div>
										<!-- <input type="hidden" name="user_id" value=""> -->
									</div>
									<div class="form-group col-sm-6">
										<label><?php echo lang('hours'); ?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" placeholder="00:00" name="timeline_hours" id="timeline_hours">
										<span class="Error-Hours" style="display: none;color:red"><?php echo lang('hour_error'); ?></span>
										<span class="Error-Hours-Exist" style="display: none;color:red"><?php echo lang('hour_error'); ?> </span>
									</div>
								</div>
								<div class="form-group">
									<label><?php echo lang('description'); ?> <span class="text-danger">*</span></label>
									<textarea rows="4" cols="5" class="form-control" name="timeline_desc" id="timeline_desc"></textarea>
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" id="new_timesheet_btn"><?php echo lang('save'); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php foreach($all_timesheet as $timesheet){ ?>
				<div id="edit_todaywork<?php echo $timesheet['time_id']; ?>" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('description'); ?> </h4>
						</div>
						<div class="modal-body">
							<form method="post" id="edit_timesheet">
								<div class="form-group">
									<label><?php echo lang('project'); ?>  <span class="text-danger">*</span></label>
									<select class="select form-control" name="project_name" id="project_name<?php echo $timesheet['time_id']; ?>">
										<option value="" selected="selected" disabled=""><?php echo lang('choose_project'); ?> </option>
										<?php foreach($projects as $project){ ?>
										<option value="<?php echo $project['project_id']; ?>" <?php if($timesheet['project_id'] == $project['project_id']){ ?> selected="selected" <?php } ?>><?php echo $project['project_title']; ?></option>
										<?php } ?>
									</select>
									<div class="row">
									<div class="col-md-12">
									<label id="project_name_required" class="error display-none" for="project_name"  style="top:0;font-size:15px;"><?php echo lang('please_select_a_project'); ?> </label>
									</div>
									</div>

								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label><?php echo lang('date'); ?>  <span class="text-danger">*</span></label>
										<div class="cal-icon"><input class="form-control" readonly value="<?php echo $timesheet['timeline_date']; ?>" name="timeline_date" id="timeline_date<?php echo $timesheet['time_id']; ?>" type="text" ></div>
										<div class="row">
										<div class="col-md-12">
										<label id="timeline_date_required" class="error display-none" for="timeline_date" style="top:0;font-size:15px;"><?php echo lang('date_is_required'); ?> </label>
										</div>
									    </div>

									</div>
									<div class="form-group col-sm-6">
										<label><?php echo lang('hours'); ?>  <span class="text-danger">*</span></label>
										<input class="form-control workTimelineHour" type="text" value="<?php echo $timesheet['hours']; ?>" name="timeline_hours" id="timeline_hours<?php echo $timesheet['time_id']; ?>">
										<span class="Error-Hours-edit" style="display: none;color:red"><?php echo lang('hour_error'); ?> </span>
										<span class="Error-Hours-Exist-edit" style="display: none;color:red"><?php echo lang('total_hours_overtime'); ?>  </span>
										<div class="row">
										<div class="col-md-12">
										<label id="timeline_hours_error" class="error display-none" for="timeline_hours" style="top:0;font-size:15px;"><?php echo lang('please_enter_valid_format'); ?> </label>
										<label id="timeline_hours_required" class="error display-none" for="timeline_hours"  style="top:0;font-size:15px;"><?php echo lang('hour_is_required'); ?> </label>
										</div>
									     </div>

									</div>
								</div>
								<div class="form-group">
									<label><?php echo lang('description'); ?>  <span class="text-danger">*</span></label>
									<textarea rows="4" cols="5" class="form-control workTimelineDesc" name="timeline_desc" id="timeline_desc<?php echo $timesheet['time_id']; ?>" ><?php echo $timesheet['timeline_desc']; ?></textarea>
									<div class="row">
									<div class="col-md-12">
									<label id="timeline_desc_error" class="error display-none" for="timeline_desc" style="top:0;font-size:15px;"><?php echo lang('description_is_required'); ?> </label>
									</div>
									</div>
								</div>
								<div class="m-t-20 text-center">
									<button type="button" class="btn btn-primary edit_timesheet_btn" id="timesheet_edit_submit" data-editid="<?php echo $timesheet['time_id']; ?>" ><?php echo lang('save_changes'); ?> </button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_workdetail<?php echo $timesheet['time_id']; ?>" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('delete_work_details'); ?> </h4>
						</div>
						<div class="modal-body card-box">
							<p><?php echo lang('are_you_sure_want_to_delete'); ?> </p>
							<div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?> </a>
								<button type="submit" class="btn btn-danger Delete-Timeline" data-timeid="<?php echo $timesheet['time_id']; ?>"><?php echo lang('delete'); ?> </button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
    