<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    
	<title>Payment Success | <?php echo config_item('company_name'); ?>  </title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />   
    <link rel="stylesheet" href="<?=base_url()?>assets/css/plugins/toastr.min.css" type="text/css"> 

    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" />
    <script src="<?=base_url()?>assets/js/libs/toastr.min.js"></script>
    <script>
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

    </script>
    <style>
  .success-page img {
      width:80%;
      margin:0 auto;
  }
  .success-page h2 {
  text-align:center;margin-top:0;
  }
  .success-page p {
  font-size:22px;color:#777777;
  }
  .success-page .wizard-btn a {
  font-size:18px;padding:10px 20px; margin-top:20px;margin-bottom:30px;
  }
  </style>
	
</head>
<body>
    <!-- Begin page content -->
    <div class="container">
        <div class="success-page">
        <div class="row">
            <!-- <div class="col-sm-4"></div> -->
            <div class="col-sm-12">
            <img class="img-responsive" src="<?php echo base_url(); ?>assets/img/payment-sucess.png" alt="">
            <h2>Your payment is successful</h2>
            <p class="text-center">Thankyou for your payment.</p>
            <div class="wizard-btn text-center">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mysModal">Register Success!</button>
            </div>
            
            
            
            <?php $subdomain_details = $this->db->get_where('subscribers',array('subscribers_id'=>$insertID))->row_array(); ?>
            
            <div class="modal fade" id="mysModal" role="dialog">
                <div class="modal-dialog">
        			<div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Sub Domain </h4>
                        </div>
                        <div class="modal-body">
                            
                            <div class="alert alert-success">
                                Sub Domain subscribed successfully.
                            </div>
                            <ul class="domain-info">
                                <li>
                                    <span class="title">Domain Name:</span>
                                    <span class="text" id="domain" ><?php echo 'https://'.$subdomain_details['workspace'].'.hrmsmaxx.com/login'; ?></span>
                                    <input type="hidden" class="sub_domain" value="<?php echo 'https://'.$subdomain_details['workspace'].'.hrmsmaxx.com/login'; ?>">
                                </li>
                                <li>
                                    <span class="title">Username:</span>
                                    <span class="text" id="username"><?php echo $subdomain_details['username']; ?></span>
                                </li>
                                <li>
                                    <span class="title">Password:</span>
                                    <span class="text" id="password"><?php echo $subdomain_details['decode_password']; ?></span>
                                </li>
                            </ul>
                          
                        </div>
                        <div class="modal-footer">
                         <a href="<?php echo 'https://'.$subdomain_details['workspace'].'.hrmsmaxx.com/login'; ?>" class="btn btn-default" id = "sudomain_login">Login</a>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        </div>
        </div>
    </div>
  </body>
  <script>
  $(document).ready(function(){
    //   $('#sudomain_login').click(function(){
			 //    	var domain = $('.sub_domain').val();
				//      window.location.href='https://'+domain+'/login';
				// });
				});
      
  </script>
</html>
