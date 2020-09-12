<div class="content-page">
    <div class="content">	
        <div class="container">
		<?php if($this->session->userdata('message')) {  ?>
		               <?php echo $this->session->userdata('message');?>
			<?php } ?>
			<div class="row">
				<div class="col-sm-12">
					<form class="form-horizontal" action="<?php echo base_url().'admin/paypal_settings/' ?>" method="post">
						<!-- <div class="card-box">
							<div class="form-group">
								<label class="col-sm-3 control-label">Paypal Option</label>
								<div class="col-sm-9">
									<div class="radio radio-inline">
										<input id="sandbox" name="developement" <?php if($list['developement']=='sandbox'){ echo "checked"; } ?> value="sandbox" type="radio">
										<label for="sandbox"> Sandbox </label>
									</div>
									<div class="radio radio-inline">
										<input id="livepaypal" name="developement"  <?php if($list['developement']=='live'){ echo "checked"; } ?> value='live' type="radio">
										<label for="livepaypal"> Live </label>
									</div>
								</div>
							</div>
						</div> -->
					<div class="card-box">
						<a href="https://www.codexworld.com/how-to/configure-paypal-sandbox-auto-return-payment-data-transfer/" class="pull-right btn btn-primary btn-xs m-b-20" target="_blank">How to Create Paypal Configuration?</a>
						<h4 class="m-t-0 header-title m-b-20"><b>Sandbox</b></h4>
						<div class="clearfix"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Paypal Email</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="sandbox_email" value="<?php if(!empty($list['sandbox_email'])){ echo $list['sandbox_email']; } ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Paypal Password</label>
								<div class="col-sm-9">
									<input class="form-control" type="password" name='sandbox_password' value="<?php if(!empty($list['sandbox_password'])){ echo $list['sandbox_password']; } ?>">
								</div>
							</div>
						   
							<div class="line">
								<hr/>
							</div>
							<h4 class="m-t-0 header-title m-b-20"><b>Live Paypal</b></h4>
							<div class="form-group">
								<label class="col-sm-3 control-label">Paypal User</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="email" value="<?php if(!empty($list['email'])){ echo $list['email']; } ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Paypal Password</label>
								<div class="col-sm-9">
									<input class="form-control" type="password" name="password" value="<?php if(!empty($list['password'])){ echo $list['password']; } ?>">
								</div>
							</div>
							<div class="text-center m-t-30">
							   <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>