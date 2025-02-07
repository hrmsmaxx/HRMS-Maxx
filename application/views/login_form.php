

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

//header("location:". base_url()."registration/user_login_process");
//} 
?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    	<link rel="shortcut icon" href="<?php echo $fav ;?>">
		<title><?php echo $this->website_name.' Sub Domain'; ?></title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
    </head>
    <body>
    	<?php
		if (isset($logout_message)) {
		echo "<div class='message'>";
		echo $logout_message;
		echo "</div>";
		}
		?>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
                <h3 class="text-center"><strong class="text-custom">LOGIN</strong></h3>
            </div> 
            <div class="panel-body">
                <div class="error_msg" ><?php echo validation_errors();?></div>
				<?php if(isset($error_message)) {  ?>
				<div class="alert alert-danger text-center fade in" id="flash_succ_message"><?php echo $error_message;?></div>
				<?php   } ?>
            <div id="fap_info"></div>
           <?php echo form_open(base_url().'registration/user_login_process'); ?>
                <div class="form-group">
				    <label>Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
				    <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                </div>
                <span id="login_error_msg" class="error_msg"></span>
                <div class="form-group text-center m-t-40">
                	<input class="btn btn-primary btn-block text-uppercase" type="submit" value=" Login " name="submit"/>
					<!--<button class="btn btn-primary btn-block text-uppercase" name="submit" type="submit" value="true" id="fap_login">Log In</button>-->
                </div>
           <?php echo form_close(); ?>
           <a href="<?php echo base_url() ?>registration/user_registration_show">To SignUp Click Here</a>
            </div>   
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        
	</body>
</html>