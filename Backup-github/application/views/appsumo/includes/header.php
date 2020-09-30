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
        <link href="<?php echo base_url(); ?>assets/css/appsumo.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
    </head>

    <style type="text/css">
	/*-----------------
    11. Login
-----------------------*/

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
    width: 480px;
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
</style>
    <body class="theme-white account-page">
		<div class="main-wrapper">