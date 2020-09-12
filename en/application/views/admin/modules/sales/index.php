<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Sales</h4>
				</div>
			</div>
			<?php if($this->session->userdata('message')) {  ?>
		         <?php echo $this->session->userdata('message');?>
			<?php } ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box m-b-0">
						<div class="table-responsive">
							<table id="data_tables" class="table table-actions-bar table-striped releasetable m-b-0">
								<thead>
									<tr>                                                    
										<th>#</th>
										<th>Date</th>
										<th>Name</th>
										<th>E-mail</th>
										<th>Contact No</th>
										<th>Company Name</th>
										<th>Country</th>
										<th>Transcation Id</th>
										<th>Amount</th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									 
									$i=1;
									foreach($list as $item) {
										
										?>
									<tr>                                                    
										<td><?php echo $i; ?></td>
										<td><?php echo date('d/m/Y',strtotime(str_replace('-', '/', $item['created_at']))); ?></td>
										<td><?php echo $item['name']; ?></td>
										<td><?php echo $item['email']; ?></td>
										<td><?php echo $item['mobileno']; ?></td>
										<td><?php echo $item['companyname']; ?></td>
										<td><?php echo $item['country']; ?></td>
										<td><?php echo $item['txn_id']; ?></td>
										<td>$<?php echo $item['amount']; ?></td>
										
										
										
									</tr>
									<?php $i = $i+1; } ?>
									
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>