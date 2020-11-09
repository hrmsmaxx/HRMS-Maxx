<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Payment Gatway - Stripe</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css" />    

    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" />

    <!-- Stripe JavaScript library -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>    
    
    <script type="text/javascript">
        //set your publishable key
        Stripe.setPublishableKey('pk_test_IfpI8ZF6N0Dhat9kC9P2hAf8');        
        //callback to handle the response from stripe
        function stripeResponseHandler(status, response) {
            if (response.error) {
                //enable the submit button
                $('#payBtn').removeAttr("disabled");
                //display the errors on the form
                // $('#payment-errors').attr('hidden', 'false');
                $('#payment-errors').addClass('alert alert-danger');
                $("#payment-errors").html(response.error.message);
            } else {
                var form$ = $("#paymentFrm");
                //get token id
                var token = response['id'];
                //insert the token into the form
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                //submit form to the server
                form$.get(0).submit();
            }
        }
        $(document).ready(function() {
            //on form submit
            $("#paymentFrm").submit(function(event) {
                //disable the submit button to prevent repeated clicks
                $('#payBtn').attr("disabled", "disabled");
                
                //create single-use token to charge the user
                Stripe.createToken({
                    number: $('#card_num').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-expiry-month').val(),
                    exp_year: $('#card-expiry-year').val()
                }, stripeResponseHandler);
                
                //submit from callback
                return false;
            });
        });
    </script>

      <style>
 .payment-page {
    margin:40px;padding:20px;border:1px solid #ccc;border-radius:5px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
 }
.panel-primary {
    border-color: #fff !important;
}
.panel-heading {
    padding:25px 20px!important;
    margin-bottom:20px;
}
.panel-title {
    font-size:20px;
}
.payment-page .form-control {
    height:50px;
}
.payment-page .panel {
    box-shadow:none!important;
}
.payment-page .submit-btn {
    margin-top:20px;
}
  </style>


	
</head>
<body>

<!-- Bootstrap 4 Navbar  -->

<!-- End Bootstrap 4 Navbar -->



<div class="container">
<div class="payment-page">
	<div class="row">	
        <div class="col-md-6">
            <img class="img-responsive" src="<?php echo base_url(); ?>assets/img/payment.png" alt="">
        </div>
        <div class="col-md-6">          
                 <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title display-td" >Card Details</h3>
                    </div>
                  <div class="panel-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oops!</strong>
                            <?php echo validation_errors() ;?> 
                        </div>  
                    <?php endif ?>
                    <div id="payment-errors"></div>

                    <?php $subscriber_details = $this->db->get_where('subscribers',array('subscribers_id' => $subscriber_id))->row_array(); 
                        // echo "<pre>"; print_r($subscriber_details); exit;
                    ?>
                    <form method="post" id="paymentFrm" enctype="multipart/form-data" action="<?php echo base_url(); ?>auth/payment_check">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $subscriber_details['fullname']; ?>" required readonly>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="email@you.com" value="<?php echo $subscriber_details['subscriber_email']; ?>" required readonly/>
                                    <input type="hidden" name="sub_type" class="form-control" value="<?php echo $sub_type; ?>" />
                                    <input type="hidden" name="sub_amount" class="form-control" value="<?php echo $sub_amount; ?>" />
                                    <input type="hidden" name="sub_type_id" class="form-control" value="<?php echo $sub_type_id; ?>" />
                                    <input type="hidden" name="company_id" class="form-control" value="<?php echo $subscriber_id; ?>" />
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="number" name="card_num" id="card_num" class="form-control" placeholder="Card Number" autocomplete="off" value="<?php echo set_value('card_num'); ?>" required maxlength="16">
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-sm-8">
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" value="<?php echo set_value('exp_month'); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_year" class="form-control" maxlength="4" id="card-expiry-year" placeholder="YYYY" required="" value="<?php echo set_value('exp_year'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control" autocomplete="off" placeholder="CVC" value="<?php echo set_value('cvc'); ?>" required>
                                </div>
                            </div>
                            </div>
                            <div class="row submit-btn">
                                <div class="col-xs-12">
                                    <!-- <button class="btn btn-danger pull-right btn-lg" type="reset">Reset</button> -->
                                    <button class="btn btn-success pull-right btn-lg" style="margin-right:10px;" type="submit">Submit Payment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        

    </div>
    </div>
</div> 

</body>
</html>