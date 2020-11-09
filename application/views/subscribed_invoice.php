<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head><title></title></head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=320, target-densitydpi=device-dpi">

    <p><?=strftime("%b %d, %Y", time()); ?> </p>

    <p>Hi  <br> <br>

    	This is to let you know that a new payment has been received: <br><br>



    	CLIENT NAME: <?=$company_name?><br>

    	CLIENT EMAIL: <?=$email?><br>

    	AMOUNT PAID: <?=App::currencies($currency)->symbol;?><?=$amount?><br>

        AMOUNT PAID FOR: <?php echo $month;?><?php echo ' Month'?><br>

    </p>

    	<p>The Payment has been applied to the Invoice Successfully. </p>

		<p>You can view the Invoice <a href="<?php echo 'https://'.$company_name.'.hrmsmaxx.com/';?>">View Invoice</a></p>

		<br>



		------------------------------

 <?php $general_settings = $this->db->get_where('subdomin_general_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
        $general = unserialize($general_settings['general_settings']);
        
        $company_name = $general['company_name']?$general['company_name']:config_item('company_name'); ?>

		<p>Regards </p> <br>
        <p><?php echo $company_name;?></p>

</body>

</html>

