<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-t-0 m-b-20">Dashboard</h4>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-sm-6"> 
					<a href="<?php echo base_url().'admin/gigs'; ?>">
						<div class="dash-widget">
							<i class="mdi mdi-account-box text-custom"></i>
							<h2 class="m-0 text-dark counter font-600"><?php echo $demo;?></h2>
							<div class="text-muted m-t-5">Total Request Demo</div>
						</div>
					</a>    
				</div>
				<div class="col-lg-3 col-sm-6">
					<a href="<?php echo base_url().'admin/user'; ?>">
						<div class="dash-widget">
							<i class="mdi mdi-account-box text-custom"></i>
							<h2 class="m-0 text-dark counter font-600"><?php echo $quote;?></h2>
							<div class="text-muted m-t-5">Total Request Quote</div>
						</div>
					</a>     
				</div>
				<div class="col-lg-3 col-sm-6">
					<a href="<?php echo base_url().'admin/orders'; ?>">
						<div class="dash-widget">
							<i class="mdi mdi-store text-custom"></i>
							<h2 class="m-0 text-dark counter font-600"><?php echo $sales;?></h2>
							<div class="text-muted m-t-5">Total Sales</div>
						</div>
					</a>    
				</div>
				
			</div>
			
			
		</div>
	</div>