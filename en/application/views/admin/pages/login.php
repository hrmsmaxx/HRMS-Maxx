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
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
		<link rel="shortcut icon" href="<?php echo $fav ;?>">
		<title><?php echo $this->website_name.' Admin Panel'; ?></title>
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
                <h3 class="text-center"><strong class="text-custom">LOGIN</strong></h3>
            </div> 
            <div class="panel-body">
				<?php if($this->session->userdata('message')) {  ?>
				<div class="alert alert-danger text-center fade in" id="flash_succ_message"><?php echo $this->session->userdata('message');?></div>
				<?php   $this->session->unset_userdata('message'); } ?>
            <div id="fap_info"></div>
            <form action="" id="admin_login" class="m-t-20" method="post" >
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
					<button class="btn btn-primary btn-block text-uppercase" name="submit" type="submit" value="true" id="fap_login">Log In</button>
                </div>
            </form>
            </div>   
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script>
            var BASE_URL = "<?php echo base_url(); ?>";
            var login_error = "<?php echo $this->session->flashdata('login_error'); ?>";
			     $('#admin_login').bootstrapValidator({  
        fields: {        
        	username:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter your Username'
                                       }
                                     }
                                    },
                password:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter your Password'
                                        }
                                      }
                                    }           
		}
        }).on('success.form.bv', function(e) {
          
        var username = $('#username').val();
           var password = $('#password').val();
    $.ajax({
           type:'POST',
           url: BASE_URL+'admin/dashboard/is_valid_login',
           data : {username:username,password:password},
           success:function(response)
           {     
         if(response==1)
         {
             window.location = BASE_URL+'admin';
         }
         else if (response==2)
         {
				location.reload();
         }
           }                
            });
        });  // admin login success function completes here  
        </script>
	</body>
</html>