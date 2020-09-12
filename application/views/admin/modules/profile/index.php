<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title m-b-20 m-t-0">Profile</h4>
                </div>
			</div>
			<?php if($this->session->userdata('message')) {  ?>
			<?php echo $this->session->userdata('message');?>
			<?php } ?>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
							<h4 class="header-title m-t-0 m-b-20">Profile Details</h4>
							<form id="admin_profile" action="<?php echo base_url($theme . '/profile'); ?>" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<div class="row">
										<label class="col-sm-3 control-label">Username</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" disabled value="<?php echo $content['username']; ?>">                                 
										</div>                                        
									</div>
								</div> 
								<div class="form-group">
									<div class="row">
										<label for="name" class="col-sm-3 control-label">Name</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="name" value="<?php echo $content['name']; ?>">                                
										</div>                                        
									</div>                                    
								</div>                                    
								<div class="form-group">
									<div class="row">
										 <label for="email" class="col-sm-3 control-label">Email</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" name="email" value="<?php echo $content['email']; ?>">
										</div>
									</div>
								</div> 
								<div class="form-group">    
									<div class="row">    
										<label class="col-sm-3 control-label">Image</label>
										<div class="col-sm-7">
												<div class="media">
													<div class="media-left">
														<img src="<?php
											if (!empty($content['profile_thumb'])) {
												echo base_url($content['profile_thumb']);
											} else {
												echo base_url('assets/images/avatar.jpg');
											}
											?>" width="100" height="100" class="profile-img" /></div>
													<div class="media-body">
														<div class="uploader"><input type="file" class="form-control" name="admin_profile" id="imageonly"></div>
														<span class="help-block">Recommended image size is 150px x 150px</span>
													</div>
												</div>
										</div>
									</div>
								</div>
								<div class="form-group m-t-20 m-b-0">
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-7">
											<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="panel m-b-0">
						<div class="panel-body">
							<h4 class="header-title m-t-0 m-b-20">Change Password</h4>
							<form id="pass-val" action="<?php echo base_url($theme . '/profile/password'); ?>" method="post">
                                <div class="form-group">
									<div class="row">    
										<label class="col-sm-3 control-label">Old Password</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password">
										</div>
									</div>
								</div>
                                <div class="form-group">
									<div class="row">  
										<label class="col-sm-3 control-label">New Password</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">  
										<label class="col-sm-3 control-label">Confirm Password</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
										</div>
									</div>
                                </div>
								<div class="form-group m-t-20 m-b-0">  
									<div class="row">  
										<label class="col-sm-3 control-label"></label>
										<div class="col-sm-7">
											<button name="form_submits" type="submit" class="btn btn-primary" value="true">Save password</button>
										</div>
									</div>
								</div>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>