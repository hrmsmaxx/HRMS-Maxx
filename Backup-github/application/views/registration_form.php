

<?php
	$query = $this->db->query("select * from system_settings WHERE status = 1");
	$result = $query->result_array();
	$this->website_name = '';
	 $fav=base_url().'assets/images/favicon.png';
	if(!empty($result))
	{
	foreach($result as $data){
	if($data['key'] == 'website_name'){
	$this->website_name = $data['value'];
	}
		if($data['key'] == 'favicon'){
			 $favicon = $data['value'];
	}
	}
	}
	if(!empty($favicon))
	{
	$fav = base_url().'uploads/logo/'.$favicon;
	}
?>
<!DOCTYPE html>
<html>
<?php
//if (isset($this->session->userdata['logged_in'])) {
//header("location:".base_url()."registration/user_login_process");
//}
?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
		<link rel="shortcut icon" href="<?php echo $fav ;?>">
		<title> Registration Form</title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
    </head>
    <body>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
                <h3 class="text-center"><strong class="text-custom">Registration Form</strong></h3>
            </div> 
            <div class="panel-body">
				
				<div class="error_msg" ><?php echo validation_errors();?></div>
				
            <div id="fap_info"></div>
           <?php echo form_open(base_url().'registration/new_user_registration');?>
                <div class="form-group form-focus">
									<label class="control-label">Workspace</label>
									<input class="form-control " type="text" name= "username">
									<div class='error_msg'>
										<?php if (isset($message_display)) {
											echo $message_display;
										} ?>
									</div>
								</div>
								<!--<div class="form-group form-focus">
									<label class="control-label">workspace</label>
									<input class="form-control " type="text" name= "workspace">
									<div class='error_msg'>
										<?php if (isset($message_display)) {
											echo $message_display;
										} ?>
									</div>
								</div>-->
								<div class="form-group form-focus">
									<label class="control-label">Email</label>
									<input class="form-control " type="email" name="email_value">
								</div>
								<div class="form-group form-focus">
									<label class="control-label">Password</label>
									<input class="form-control " type="password" name = "password">
								</div>
							<!--	<div class="form-group form-focus">
									<label class="control-label">Repeat Password</label>
									<input class="form-control " type="text" name="r_password" >
								</div>-->
								
                            	<div class="form-group text-center m-t-40">
                                	<input class="btn btn-primary btn-block text-uppercase" type="submit" value="Sign Up " name="submit"/>
                					<!--<button class="btn btn-primary btn-block text-uppercase" name="submit" type="submit" value="true" id="fap_login">Log In</button>-->
                                </div>
                                
                             <?php echo form_close(); ?>
                             <div class="form-group form-focus">
							    	<a href="<?php echo base_url().'registration';?>">Already have an account</a>
                            	</div>
						           
            </div>   
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
       	</body>
</html>