<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?php echo lang('employee_management'); ?></h4>
		</div>
	</div>
	<div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li><a href="<?php echo base_url(); ?>employees">Employee Biodata</a></li>
			<li><a href="<?php echo base_url(); ?>attendance">Time & Attendance</a></li>
			<li><a href="<?php echo base_url(); ?>leaves">Leave Management</a></li>
			<li><a href="<?php echo base_url(); ?>payroll">Payroll Management</a></li>
			<li><a href="<?php echo base_url(); ?>performance">Performance Management</a></li>
			<li  class="active"><a href="<?php echo base_url(); ?>employees/request_approval">Request & Approval</a></li>
		</ul>
	</div>
	
	<div class="card-box">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title"><?php echo lang('request_approval'); ?></h4>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0 datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Created Date</th>
								<th class="text-center">Status</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>30 Dec 2019</td>
								<td class="text-center">
									<div class="dropdown action-label">
										<a class="btn btn-white btn-sm rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-dot-circle-o text-success"></i> Approved <i class="caret"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="fa fa-dot-circle-o text-danger"></i> Pending</a></li>
											<li><a href="#"><i class="fa fa-dot-circle-o text-success"></i> Approved</a></li>
											<li><a href="#"><i class="fa fa-dot-circle-o text-info"></i> Returned</a></li>
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