<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title">Online Services</h4>
		</div>
	</div>
	
	<!-- Page Menu -->
	<div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li class="active"><a href="<?php echo base_url(); ?>online_services"><?php echo lang('e_visa'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>online_services/emergency_tc"><?php echo lang('emergency_tc'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>online_services/passport_app"><?php echo lang('passport_app'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>online_services/work_permit"><?php echo lang('work_permit'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>online_services/foreign_res_permit"><?php echo lang('foreign_res_permit'); ?></a></li>
		</ul>
	</div>
	<!-- /Page Menu -->
	
	<div class="card-box m-b-0">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title"><?php echo lang('e_visa'); ?></h4>
			</div>
		</div>	

					<!-- Search Filter -->
					<div class="row filter-row">
					   <div class="col-sm-6 col-md-3 col-lg-2">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="control-label">Applicant Name</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-2">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="control-label">Contact No</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-2"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option> -- Select -- </option>
									<option> Pending </option>
									<option> Approved </option>
									<option> Rejected </option>
								</select>
								<label class="control-label">Service Type</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-2"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option> -- Select -- </option>
									<option> Pending </option>
									<option> Approved </option>
									<option> Rejected </option>
								</select>
								<label class="control-label">Status</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-2">  
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option> -- Select -- </option>
									<option>12345</option>
									<option>23456</option>
									<option>34567</option>
								</select>
								<label class="control-label">Passport No</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-2">  
							<a href="#" class="btn btn-success btn-block"> Search </a>  
					   </div>     
                    </div>
					<!-- /Search Filter -->
					

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0 datatable" style="width: 100%;">
						<thead>
							<tr>
								<th>Ref No</th>
								<th>Full Name</th>
								<th>Passport No</th>
								<th>Service Type</th>
								<th>Email ID</th>
								<th>Mobile No</th>
								<th>Applied Date</th>
								<th>Employee Assigned</th>
								<th class="text-center">Status</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="#">#123456</a></td>
								<td>
									<h2 class="table-avatar">
										<a href="#" class="avatar"><img alt="" src="<?php echo base_url(); ?>assets/avatar/default_avatar.jpg"></a>
										<a href="#">Soosairaj <span>Web Developer</span></a>
									</h2>
								</td>
								<td>12245566</td>
								<td>Service Type 1</td>
								<td>soosai.raj@dreamguys.co.in</td>
								<td>9843014641</td>
								<td>30 Dec 2019</td>
								<td>Guru</td>
								<td class="text-center">
									<div class="dropdown action-label">
										<a class="btn btn-white btn-sm rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-dot-circle-o text-success"></i> Approved <i class="caret"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="fa fa-dot-circle-o text-danger"></i> Pending</a></li>
											<li><a href="#"><i class="fa fa-dot-circle-o text-success"></i> Approved</a></li>
											<li><a href="#"><i class="fa fa-dot-circle-o text-info"></i> Rejected</a></li>
										</ul>
									</div>
								</td>
								<td class="text-right">
									<div class="dropdown">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
											<li><a href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>

</div>