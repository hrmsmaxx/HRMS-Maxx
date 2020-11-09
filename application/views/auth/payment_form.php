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
        $(document).ready(function(){
            $(document).on("change","#no_of_month",function() {
                var no_of_month  = $(this).val();
               var per_month = $('#per_month_amount').val();
               var total_amount = no_of_month * per_month;
               $('#sub_amount').val(total_amount);
              var paypal_url =  $('#paypal_url').val();
              var url = paypal_url+'/'+no_of_month+'/'+total_amount;
               $('#paypal_url_button').attr('href',url);
            });
        });
        $(document).ready(function(){
            $('#card-expiry-year').next().text('');
            $(document).on("blur","#card-expiry-year",function(){
                $('#card-expiry-year').next().text('');
                var d = new Date();
                var n = d.getFullYear();
                var k = $('#card-expiry-year').val();
                if(k<n){
                    $('#card-expiry-year').next().text('Your card\'s expiration month is invalid.').css("color", "red");
                }
            })
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
                            $plan_details = $this->db->get_where('subscription_plans',array('plan_id' =>$subscriber_details['plan_id']))->row_array(); 
                            if($plan_details['plan_type']=='month'){
                                $no_month = 6;
                            }
                            if($plan_details['plan_type']=='year'){
                                $no_month = 12;
                            }
                         
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
                                    
                                    <input type="hidden" name="sub_type_id" class="form-control" value="<?php echo $sub_type_id; ?>" />
                                    <input type="hidden" name="company_id" class="form-control" value="<?php echo $subscriber_id; ?>" />
                                    <input type="hidden" name="sub_currency" class="form-control" value="<?php echo $subscriber_details['currency']; ?>" />
                                    <input type="hidden" name="base_url"  id="paypal_url" class="form-control" value="<?php echo base_url(); ?>auth/paypal_pay/<?php echo $subscriber_id; ?>" />
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                   <select name="no_of_month" class="form-control" required id="no_of_month" data-id="<?php echo $subscriber_id;?>"> 
                                       <option value="1"><?php echo "1 month"?></option>
                                       <option value="2"><?php echo "2 months"?></option>
                                       <option value="3"><?php echo "3 months"?></option>
                                       <option value="4"><?php echo "4 months"?></option>
                                       <option value="5"><?php echo "5 months"?></option>
                                       <option value="6" <?php echo ($plan_details['plan_type']=='month')?'selected':'';?>><?php echo "6 months"?></option>
                                       <?php if($plan_details['plan_type']=='year'){
                                            $per_month =  $subscriber_details['amount']/12;
                                        ?>

                                       <option value="7"><?php echo "7 months"?></option>
                                       <option value="8"><?php echo "8 months"?></option>
                                       <option value="9"><?php echo "9 months"?></option>
                                       <option value="10"><?php echo "10 months"?></option>
                                       <option value="11"><?php echo "11 months"?></option>
                                       <option value="12" <?php echo ($plan_details['plan_type']=='year')?'selected':'';?>><?php echo "12 months"?></option>

                                       <?php }else{
                                        $per_month =  $subscriber_details['amount']/6;
                                       } ?>
                                   </select>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="sub_amount" id="sub_amount" class="form-control" value="<?php echo $subscriber_details['amount']; ?>" required readonly/>
                                    <input type="hidden" id="per_month_amount" name="per_month_amount" class="form-control" value="<?php echo $per_month; ?>" readonly/>
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
                                            <label for="card-expiry-year"></label>
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

        <a href="<?php echo base_url(); ?>auth/paypal_pay/<?php echo $subscriber_id.'/'.$no_month.'/'.$per_month*$no_month; ?>" id="paypal_url_button" class="btn btn-success pull-right btn-lg" style="margin-right:10px;" type="submit">Paypal</a>

        

    </div>
    </div>
</div> 

</body>
</html>