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
        <!-- <link href="<?php echo base_url(); ?>assets/css/appsumo.css" rel="stylesheet" type="text/css" /> -->
        <!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/plugins/toastr.min.css">
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
    </head>

    <style type="text/css">
	/*-----------------
    11. Login
-----------------------*/
.m-b-20 {
    margin-bottom:20px;
}
.input-group-addon {
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    color: #fff;
    text-align: center;
    background-color: #1EB53A;
    border: 1px solid #1EB53A;
    border-radius: 4px;
}
.bg-primary {
    background:#d7f3d6;
    color:#333;
}
.m-t-0 {
    margin-top:0 !important;
}
.account-page {
    align-items: center ;
    display: flex;
}
.account-page .main-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    width: 100%;
}
.account-content {
    padding: 40px 0;
}
.account-title {
    font-size:  1.625rem;;
    font-weight: 500;
    margin-bottom: 15px;
    text-align: center;
}
.account-subtitle {
    color: #4c4c4c;
    font-size: 1.125rem;
    margin-bottom: 30px;
    text-align: center;
}
.account-box {
    background-color: #fff;
    border: 1px solid #ededed;
    border-radius: 0.625rem;
    /*box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2);*/
    margin: 0 auto;
    overflow: hidden;
    padding: 30px;
    /*width: 480px;*/
}
.account-logo {
    margin-bottom: 30px;
    text-align: center;
}
.account-box .form-group {
    margin-bottom: 25px;
}
.account-box .account-btn {
    background: #1EB53A;
    border: 0;
    border-radius: 4px;
    color: #fff;
    display: block;
    font-size: 1.375rem;
    padding: 10px 26px;
    width: 100%;
}
.account-box .account-btn:hover,
.account-box .account-btn:focus {
    border: 0;
    opacity: 0.8;
}
.account-box .form-control {
    background-color: #fbfbfb;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    height: 46px;
}
.account-box label {
    color: #1f1f1f;
    /*font-size: 1rem;*/
    font-weight: normal;
}
.account-logo img {
    max-height: 100px;
}
.account-footer {
    text-align: center;
}
.account-footer p {
    margin-bottom: 0;
}
.account-footer p + p {
    margin-top: 5px;
}
.account-footer a {
    color: #1EB53A;
}
.account-footer a:hover {
    color: #1EB53A;
}
.account-box .error {
    color: #f62d51;
    font-size: 0.875rem;
}
.account-box .error > p {
    margin-bottom: 0;
}
.py-5 {
    padding-top:30px;
    padding-bottom: 30px;
}
.m-t-20 {
    margin-top:20px;
}
.account-logo img {
    margin:auto;
    width:150px;
}
.account-logo {
      clear:both; 
}


</style>
    <body class="theme-white account-page">
		<div class="main-wrapper">


<?php

// if ($use_username) {
$username = array(
	'name'	=> 'username',
	'id'	=> 'subscribe_username',
	'class'	=> 'form-control',
	'value' => set_value('username'),	
);
// }
$email = array(
	'name'	=> 'subscriber_email',
	'id'	=> 'subscriber_email',
	'class'	=> 'form-control',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$fullname = array(
	'name'	=> 'fullname',
	'class'	=> 'form-control',
	'value'	=> set_value('fullname'),
);
$company_name = array(
	'name'	=> 'workspace',
	'id'	=> 'workspace',
	'class'	=> 'form-control',
	'value'	=> set_value('workspace'),
);
$company = array(
	'name'	=> 'company_name',
	'id'	=> 'company_name',
	'class'	=> 'form-control',
	'value'	=> set_value('company_name'),
);
$city = array(
	'name'	=> 'city',
	'id'	=> 'city',
	'class'	=> 'form-control',
	'value'	=> set_value('city'),
);
$country = array(
	'name'	=> 'country',
	'id'	=> 'country',
	'class'	=> 'form-control',
	'value'	=> set_value('country'),
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'subpassword',
	'class'	=> 'form-control',
	'value' => set_value('password')
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'class'	=> 'form-control',
	'value' => set_value('confirm_password')
);
?>

<div class="account-content">
	<div class="container">
		
		<div class="account-box">
	
		<!-- Account Logo -->
		<!-- <div class="account-logo">
			<?php $display = config_item('logo_or_icon'); ?>
			<?php if ($display == 'logo' || $display == 'logo_title') { ?>
			<img src="<?=base_url()?>assets/images/<?=config_item('login_logo')?>" class="<?=($display == 'logo' ? "" : "login-logo")?>">
			<?php } ?>
		</div> -->
        <div class="account-logo text-center">
            <div class="logo1">
            <img src="assets/img/list-logo.png" alt="" class="img-responsive">

        </div>
        
        </div>
		<!-- /Account Logo -->
			<h5 class="account-title">Here you can register your new HRMS Maxx account and apply appsumo codes.</h5>
			<h5 class="account-title">Once registered you can also apply more codes(up to 6 in total) to adjust yor account limits.</h5>

			<h3 class="account-title">Get Started with your LIFETIME Account!</h3>
			<!-- <p class="account-subtitle">Access to our dashboard</p> -->
             <div class="row m-t-20">
           
            <div class="col-lg-7 py-5 ">

			<?php $attributes = array('class' => '', 'id' => 'SubscribeForm','enctype' => 'multipart/form-data','autocomplete'=>'off'); echo form_open($this->uri->uri_string(),$attributes); ?>
				<div class="row">                    
                    <div class="col-md-6">
        				<div class="form-group">
        					<label class="control-label">Full Name <span class="text-danger">*</span></label>
        					<?php echo form_input($fullname); ?>
        					<span class="error"><?php echo form_error($fullname['name']); ?><?php echo isset($errors[$fullname['name']])?$errors[$fullname['name']]:''; ?></span>
        				</div>
                    </div>
                    <div class="col-md-6">
        				<div class="form-group">
        					<label class="control-label">Username<span class="text-danger">*</span></label>
        					<?php echo form_input($username); ?>
        					<!-- <span class="error"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></span> -->
        				</div>
				    </div>
                    
                    <div class="col-md-6">
        				<div class="form-group">
        					<label class="control-label">Email<span class="text-danger">*</span></label>
        					<?php echo form_input($email); ?>
        					<span class="error"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></span>
        				</div>
                    </div>
                    <div class="col-md-6">
        				<div class="form-group">
        					<label class="control-label">Password<span class="text-danger">*</span></label>
        					<?php echo form_password($password); ?>
        					<span class="error"><?php echo form_error($password['name']); ?></span>
        				</div>
                    </div>
                    <div class="col-md-6">
        				<div class="form-group">
        					<label class="control-label">Confirm Password<span class="text-danger">*</span></label>
        					<?php echo form_password($confirm_password); ?>
        					<span class="error"><?php echo form_error($confirm_password['name']); ?></span>

        					<!-- <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
        					<input type="hidden" name="user_count" value="<?php echo $user_count; ?>">
        					<input type="hidden" name="amount" value="<?php echo $amount; ?>">
        					<input type="hidden" name="currency" value="<?php echo $currency; ?>"> -->
        					<input type="hidden" id="valid_appsumo_code" name="appsumo_code" value="<?php echo $currency; ?>">
        				</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">City <span class="text-danger">*</span></label>
                            <?php echo form_input($city); ?>
                            <span class="error"><?php echo form_error($city['name']); ?><?php echo isset($errors[$city['name']])?$errors[$city['name']]:''; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Country<span class="text-danger">*</span></label>
                            <?php echo form_input($country); ?>
                            <span class="error"><?php echo form_error($country['name']); ?><?php echo isset($errors[$country['name']])?$errors[$country['name']]:''; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Company Name<span class="text-danger">*</span></label>
                            <?php echo form_input($company); ?>
                            <span class="error"><?php echo form_error($company['name']); ?><?php echo isset($errors[$company['name']])?$errors[$company['name']]:''; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Workspace<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="workspace" id ="workspace" value="" readonly="readonly">
                            <span class="error"><?php echo form_error($company['name']); ?><?php echo isset($errors[$company['name']])?$errors[$company['name']]:''; ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
    				<div class="g-recaptcha" data-sitekey="6LeatwAVAAAAAKxN5f70jnDGY846TRrAlZAp0VJK"></div>
    				<div class="form-group">
    					<input type="checkbox" name="terms_accept" value="yes" required> <a href="#">Terms & Conditions </a>
    				</div>
        				<div class="form-group">
        					<button type="submit" class="btn account-btn SubscribeBtn" disabled="disabled">Create my LIFETIME account</button>
        				</div>
                    </div>
                </div>
				<div class="account-footer">
					<p><?php echo 'Already have an account ?';?> <a href="<?php echo 'http://localhost/lite-hrmsmaxx/'?>login"><?php echo 'Sign in';?></a></p>
				</div>
			<?php echo form_close(); ?>
		</div>
         <div class="col-lg-5 m-t-20">
                <div class=" panel bg-primary">
                    <div class="panel-body">
                        
                        <h3 class="m-t-0">Stack your codes</h3>
                        <p class="m-b-20">Apply your AppSumo code here :

                        </p>
                         <div class="input-group m-b-20">
                            
                            <input id="appsumo_code" type="text" class="form-control" name="appsumo_code" placeholder="Additional Info">
                            <a href="#" class="input-group-addon btn bg-success btn-success code_validation">Validate code</a>
                          </div>
                         <!--  <h4 class="m-t-0">Your applied codes</h4>
                        <ul class="m-b-20" style="padding-left:20px">
                            <li>No codes applied yet.</li>
                        </ul>
                          <h4 class="m-t-0">Your Listagram Plan :</h4>
                          <p>Apply a code to get your plan.</p> -->
                    </div>
                </div>
            </div>
         </div>
        </div>
	</div>
</div>

</div>


<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>   
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/libs/toastr.min.js"></script>
<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }                	

    $(document).ready(function(){
        // function isPhonePresent() {
        //     console.log($('#create_client_phone').val().length > 0);
        //     return $('#create_client_phone').val().length > 0;
        // }

        // $.validator.addMethod("mobilevalidation",
        // function(value, element) {
        //         return /^(\+\d{1,3}[- ]?)?\d{10}$/.test(value);
        // },
        // "Please enter a valid mobile number."
        // );
        
        // $.validator.addMethod("phonevalidation",
        //     function(value, element) {
        //         return /^(\+\d{1}[- ]?)?\d{6,14}[0-9]$/.test(value);
        //             //return /^\+(?:[0-9] ?){6,14}[0-9]$/.test(value);
        //     },
        // "Please enter a valid phone number."
        // );
        $(document).on('click','.SubscribeBtn',function(){
        var valid_appsumo_code= $('#valid_appsumo_code').val();
        if(valid_appsumo_code ==''){
            toastr.error('Please apply your AppSumo Code!'); 
            return false; 
        }    
        $.validator.addMethod("emailvalidation",
                function(value, element) {
                        return /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/.test(value);
                },
        "Please enter a valid email address."
        );

        $("#SubscribeForm").validate({
            onsubmit: true,
            ignore: [] ,
            rules: {
                // workspace: {
                //     required: true
                // },
                company_name: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },
                fullname: {
                    required: true
                },
                username: {
                    required: true
                },
                subscriber_email: {
                    required: true,
                    emailvalidation: 'emailvalidation'
                },
                password: {
                    required: true,
                    minlength : 6
                },
                confirm_password: {
                    required: true,
                    minlength : 6,
                    equalTo : "#subpassword"
                }
            },
            messages: {
                workspace: {
                    required: "workspace must not be empty"
                },
                company_name: {
                    required: "Company Name must not be empty"
                },
                city: {
                    required: "City must not be empty"
                },
                country: {
                    required: "Country must not be empty"
                },
                fullname: {
                    required: "Fullname must not be empty"
                },
                username: {
                    required: "Username must not be empty"
                },
                subscriber_email: {
                    required: "Email Id is required",
                    emailvalidation: "Please enter a valid email Id"
                },
                password: {
                    required: "Password must not be empty",
                    minlength : "Password required minimum 6 characters"
                },
                confirm_password: {
                    required: "Confirm Password must not be empty",
                    minlength : "Confirm Password required minimum 6 characters",
                    equalTo : "Password Mismatched"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
           });
           });


        $(document).on('change','#company_name',function(){
            var company_name = $(this).val();
            $('#workspace').val(company_name);
            if(company_name != ''){                    
                $.post('<?php echo base_url();?>appsumo/appsumo/check_company_name',{company_name:company_name},function(data){
                    // alert(data);
                    if(data != 0){
                        toastr.error('Already Company Exists!');
                        $('.SubscribeBtn').attr('disabled','disabled');
                        return false;
                    }else{
                        toastr.success('Company Available');
                        $('.SubscribeBtn').removeAttr('disabled');
                    }
                });
            }
        });

        $(document).on('change','#subscriber_email',function(){
            var subscriber_email = $(this).val();
            if(subscriber_email != ''){                    
                $.post('<?php echo base_url();?>appsumo/appsumo/check_subscriberemail',{subscriber_email:subscriber_email},function(data){
                    if(data != 0){
                        toastr.error('Already Email Exists!');
                        $('.SubscribeBtn').attr('disabled','disabled');
                        return false;
                    }else{
                        $('.SubscribeBtn').removeAttr('disabled');
                    }
                });
            }
        });

        $(document).on('change','#subscribe_username',function(){
            var subscribe_username = $(this).val();
            if(subscribe_username != ''){                    
                $.post('<?php echo base_url();?>appsumo/appsumo/check_subscribe_username',{subscribe_username:subscribe_username},function(data){
                    if(data != 0){
                        toastr.error('Already Username Exists!');
                        $('.SubscribeBtn').attr('disabled','disabled');
                        return false;
                    }else{
                        toastr.success('Username Available');
                        $('.SubscribeBtn').removeAttr('disabled');
                    }
                });
            }
        });

             $(document).on('click','.code_validation',function(){
            var appsumo_code = $('#appsumo_code').val();
            if(appsumo_code != ''){                    
                $.post('<?php echo base_url();?>appsumo/appsumo/check_appsumo_code',{appsumo_code:appsumo_code},function(data){
                    // alert(data);
                    if(data != 0){                        
                        toastr.success('Code applied successfully!');   
                        $('.SubscribeBtn').removeAttr('disabled');
                        $('#valid_appsumo_code').val(appsumo_code);
                        $('#appsumo_code').val('');
                    }else{
                      toastr.error('Code does not exist, please try again.');  
                       $('.SubscribeBtn').attr('disabled','disabled');
                        $('#valid_appsumo_code').val('');
                       return false;                    
                    }
                });
            }else{}
        });

        $('#company_name').keyup(function() {
            var company_name = $(this).val();
            $('#workspace').val(company_name);
        });
    });
        
    </script>

        </body>
</html>
<script src='https://www.google.com/recaptcha/api.js'></script>