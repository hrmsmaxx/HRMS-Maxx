<div class="content container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title">Logistics</h4>
		</div>
	</div>
	<div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li><a href="<?php echo base_url(); ?>all_assets">Asset Assignment</a></li>
			<li><a href="<?php echo base_url(); ?>logistics/stocks">Stock (Store)</a></li>
			<li class="active"><a href="<?php echo base_url(); ?>logistics/procurement">Procurement</a></li>
			<li><a href="<?php echo base_url(); ?>logistics/suppliers">Suppliers</a></li>
		</ul>
	</div>
	
	<div class="card-box">
		<div class="row">
			<div class="col-sm-4">
				<h4 class="page-title">Procurement</h4>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0 datatable" style="width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Request Type</th>
								<th>Request By</th>
								<th>Approved By</th>
								<th>Qty</th>
								<th>Request Date</th>
								<th class="text-center">Status</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>New System Request</td>
								<td>Personal</td>
								<td>Adam Paul</td>
								<td>John Doe</td>
								<td>1</td>
								<td>31 Dec 2019</td>
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