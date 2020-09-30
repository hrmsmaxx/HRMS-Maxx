<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					<?php if($this->session->flashdata('message')) { ?>
					<?php echo $this->session->userdata('message'); ?>
					<?php } ?>
                    <h4 class="page-title m-b-20 m-t-0">Smtp Config</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card-box">
						<form class="form-horizontal" id="form_emailsetting" action="" method="POST" enctype="multipart/form-data">
							<div id="email_settings" class="tab-pane active">
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Host</label>
									<div class="col-sm-9">
										<input  type="text" id="smtp_host" name="smtp_host" value="<?php if (isset($smtp_host)) echo $smtp_host;?>" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Port</label>
									<div class="col-sm-9">
										<input type="text" id="smtp_port" name="smtp_port" value="<?php if (isset($smtp_port)) echo $smtp_port;?>" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP User</label>
									<div class="col-sm-9">
										<input type="text" id="smtp_user" name="smtp_user" value="<?php if (isset($smtp_user)) echo $smtp_user;?>" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Password</label>
									<div class="col-sm-9">
										<input type="text" id="smtp_pass" name="smtp_pass" value="<?php if (isset($smtp_pass)) echo $smtp_pass;?>" class="form-control" >
									</div>
								</div>
							</div>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
							</div>
						</form>
					</div>
                </div>
			</div>
		</div>
		
 