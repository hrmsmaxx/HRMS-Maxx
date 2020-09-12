<div class="content-page">

    <div class="content">

        <div class="container">

            <div class="row">

                <div class="col-sm-12">

                    <h4 class="page-title m-b-20 m-t-0">Settings </h4>

                </div>

            </div>

			<?php if($this->session->flashdata('message')) { ?>

			<?php echo $this->session->userdata('message'); ?>

			<?php } ?>

            <div class="row">

                <div class="col-lg-12">

                    <div class="card-box">

						<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">

							<div>

								<ul class="nav nav-tabs navtab-bg nav-justified">

									<li class="active tab"><a href="#general" data-toggle="tab">General</a></li>

									<li class="tab"><a href="#payment_setting" data-toggle="tab">Payments</a></li>

								</ul>

								<div class="tab-content">

									<div id="general" class="tab-pane active">

										<div class="form-group">

											<label class="col-sm-3 control-label">Website Name</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="website_name" name="website_name" placeholder="Dreamguy's Technologies" value="<?php if (isset($website_name)) echo $website_name;?>">

											</div>

										</div>

										

										<div class="form-group">

											<label class="col-sm-3 control-label">Website Logo</label>

											<div class="col-sm-9">

												<div class="media">

													<div class="media-left">

														<?php if (!empty($logo_front)){ ?><img src="<?php echo base_url().$logo_front?>" class="site-logo" /><?php } ?>

													</div>

													<div class="media-body">

														<div class="uploader"><input type="file" id="site_logo" multiple="true"  class="form-control" name="site_logo" placeholder="Select file"></div>

														<span class="help-block small">Recommended image size is <b>150px x 150px</b></span>

													</div>

												</div>

												<div id="img_upload_error" class="text-danger"  style="display:none"><b>Please upload valid image file.</b></div>

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Favicon</label>

											<div class="col-sm-9">

												<div class="media">

													<div class="media-left">

														<?php if (!empty($favicon)){ ?><img src="<?php echo base_url().'uploads/logo/'.$favicon?>" class="fav-icon" /><?php } ?>

													</div>

													<div class="media-body">

														<div class="uploader"><input type="file"  multiple="true"  class="form-control" id="favicon" name="favicon" placeholder="Select file"></div>

														<span class="help-block small">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></span>

														<span class="help-block small">Accepted formats: only png and ico</span>

													</div>

												</div>

												<div id="img_upload_errors" class="text-danger" style="display:none">Please upload valid image file.</div>

											</div>

										</div>

										

									</div>

									

									

									<div id="payment_setting" class="tab-pane">



										<h3 class="text-primary">PayPal</h3>

										<div class="form-group">

											<label class="col-sm-3 control-label">PayPal</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($paypal_option)){

													if($paypal_option==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($paypal_option==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="paypal_option" value="1"> SandBox

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="paypal_option" value="2"> Live

												</label>



											</div>

											<label class="col-sm-3 control-label">PayPal Payment</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($paypal_allow)){

													if($paypal_allow==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($paypal_allow==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="paypal_allow" value="1"> Active

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="paypal_allow" value="2"> Inactive

												</label>



											</div>



										</div>




									</div>







								</div>

							</div>

                           <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>

						</form>

					</div>

                </div>

			</div>

		</div>



		<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

			<div class="modal-dialog"> 

				<div class="modal-content"> 

					<div class="modal-header"> 

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 

						<h4 class="modal-title">Add More Social Media Link</h4> 

					</div> 

					<div class="modal-body"> 

						<div class="row"> 

							<div class="col-md-6"> 

								<div class="form-group"> 

									<label for="field-1" class="control-label">Label Name</label> 

									<input type="text" class="form-control" id="field-1" placeholder="Type here"> 

								</div> 

							</div> 

						 </div> 

						 <div class="row"> 

							<div class="col-md-6"> 

								<div class="form-group"> 

									<label for="field-2" class="control-label">Field Name</label> 

									<input type="text" class="form-control" id="field-2" placeholder="Type here"> 

								</div> 

							</div> 

						</div> 

					</div> 

					<div class="modal-footer"> 

						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 

						<button type="button"  onclick="subitmorefield()" class="btn btn-info">Save</button> 

					</div> 

				</div> 

			</div>

		</div>

 