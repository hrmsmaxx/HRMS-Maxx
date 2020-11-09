<?php if (config_item('timezone')) { date_default_timezone_set(config_item('timezone')); } ?>
<!DOCTYPE html>
<html lang="<?=lang('lang_code')?>" class="app">
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="<?=config_item('site_author')?>">
	<meta name="keyword" content="<?=config_item('site_desc')?>">
	
	<title><?php echo $template['title'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	 <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>superadmin_assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/bootstrap.min.css">


		<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datepicker/datepicker.css"/>

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/plugins/toastr.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/feathericon.min.css">

        <!-- Select2 CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/select2.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/style.css">

	
	<?php 
	$family = 'Lato';
	$font = config_item('system_font');
	switch ($font) {
		case "open_sans": $family="Open Sans";  echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext,greek-ext,cyrillic-ext' rel='stylesheet' type='text/css'>"; break;
		case "open_sans_condensed": $family="Open Sans Condensed";  echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "roboto": $family="Roboto";  echo "<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "roboto_condensed": $family="Roboto Condensed";  echo "<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "ubuntu": $family="Ubuntu";  echo "<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "lato": $family="Lato";  echo "<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "oxygen": $family="Oxygen";  echo "<link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "pt_sans": $family="PT Sans";  echo "<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "source_sans": $family="Source Sans Pro";  echo "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "montserrat": $family="Montserrat";  echo "<link href='https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "fira_sans": $family="Fira Sans";  echo "<link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700' rel='stylesheet' type='text/css'>"; break;
		case "circularstd": $family="CircularStd"; break;
	}
	?>
	
	<style>
		#pie-chart{
			min-height: 250px;
		}
		.morris-hover{position:absolute;z-index:1000;}
		.morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}
		.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
		.morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}
		body { font-family: '<?=$family?>'; }
	</style>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132757834-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-132757834-1');
	</script>

	<!--[if lt IE 9]>
	<script src="js/ie/html5shiv.js"></script>
	<script src="js/ie/respond.min.js"></script>
	<script src="js/ie/excanvas.js"></script>
	<![endif]-->

</head>
<body>
	

			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Subscription</h3>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
						
						<!--Monthly Yearly Switch-->
							<div class="switch switch--horizontal">
								<input id="radio-a" type="radio" name="first-switch" onclick="show1();"/>
								<label for="radio-a">Monthly</label>
								<input id="radio-b" type="radio" name="first-switch" checked="checked" onclick="show2();"/>
								<label for="radio-b">Yearly</label><span class="toggle-outside"><span class="toggle-inside"></span></span>
								
							</div>
							<p class="text-center text-small con-text-plan"><span> *Choose a yearly plan and get one month FREE!</span></p>
						<!--/Monthly Yearly Switch-->
						</div>			
					</div>
					
					<!--Doller Switch-->
					<div class="row text-center">
						<div class="col-sm-12">
						<div class="switch-field text-center">
							<input type="radio" id="radio-one" name="switch-one" value="yes" checked/>
							<label for="radio-one">USD $</label>
							<input type="radio" id="radio-two" name="switch-one" value="no" />
							<label for="radio-two">EUR &#8364;</label>
						</div>
						</div>
					</div>
					<!-- /Doller Switch-->
					<div class="container">
						<div class="row text-center plan-card">
							<div class="col-md-12">
								<div  class="card mb-3">
									<div class="card-body">
										<p>Number of employees in your company</p>

										<div class="slidecontainer">
											<div class="slider1">
												<input type="range" min="0" max="500" value="25" class="slider" id="min-slider">
											</div>
											<br/>
											<button class="btn btn-primary">Employees <span id="min-output"></span></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
					<div id="group1">
						<div class="row plan-card hide" id="div1">
							<!--Card1 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center">Starter Plan</h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount">$49</span></h2>
										<p class="plan-vali"> per month</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1">5</span></b> Employees</li>
													<li><b><span class="text-dark mr-1">5</span></b> Projects</li>
													<li><b><span class="text-dark mr-1">5  GB</span></b> Storage</li>
													<li> Unlimited Messages</li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card1 -->
							
							<!--Card2 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center">Middle Plan</h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount">$160</span></h2>
										<p class="plan-vali"> per month</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1">30</span></b> Employees</li>
													<li><b><span class="text-dark mr-1">50</span></b> Projects</li>
													<li><b><span class="text-dark mr-1">100 GB</span></b> Storage</li>
													<li><b><span class="text-dark mr-1">24/7</span></b> Customer Support</li>
													<li> Unlimited Messages</li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card2 -->
							
							<!--Card3 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center">Premium Plan</h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount">$249</span></h2>
										<p class="plan-vali"> per month</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1">Unlimited</span></b> Employees</li>
													<li><b><span class="text-dark mr-1">Unlimited</span></b> Projects</li>
													<li><b><span class="text-dark mr-1">500 GB</span></b> Storage</li>
													<li><b><span class="text-dark mr-1">24/7</span></b> Customer Support</li>
													<li> Voice and video call</li>
													<li> Unlimited Messages</li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card3 -->
						</div>
						
						
						<div class="row plan-card hide" id="div2">
							<!--Card1 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center">Starter Plan</h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount">$490</span></h2>
										<p class="plan-vali"> per month</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1">5</span></b> Employees</li>
													<li><b><span class="text-dark mr-1">5</span></b> Projects</li>
													<li><b><span class="text-dark mr-1">5  GB</span></b> Storage</li>
													<li> Unlimited Messages</li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card1 -->
							
							<!--Card2 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center">Middle Plan</h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount">$160</span></h2>
										<p class="plan-vali"> per month</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1">30</span></b> Employees</li>
													<li><b><span class="text-dark mr-1">50</span></b> Projects</li>
													<li><b><span class="text-dark mr-1">100 GB</span></b> Storage</li>
													<li><b><span class="text-dark mr-1">24/7</span></b> Customer Support</li>
													<li> Unlimited Messages</li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card2 -->
							
							<!--Card3 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center">Premium Plan</h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount">$240</span></h2>
										<p class="plan-vali"> per month</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1">Unlimited</span></b> Employees</li>
													<li><b><span class="text-dark mr-1">Unlimited</span></b> Projects</li>
													<li><b><span class="text-dark mr-1">500 GB</span></b> Storage</li>
													<li><b><span class="text-dark mr-1">24/7</span></b> Customer Support</li>
													<li> Voice and video call</li>
													<li> Unlimited Messages</li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card3 -->
						</div>
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		
	
        </div>

	<script>
		var locale = '<?=lang('lang_code')?>';
		var base_url = '<?=base_url()?>';
	</script>

	<!-- jQuery -->
        <script src="<?php echo base_url();?>superadmin_assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo base_url();?>superadmin_assets/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>superadmin_assets/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>

		<script src="<?php echo base_url();?>assets/js/datepicker/bootstrap-datepicker.js"></script>

        <script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/datatables/dataTables.bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="<?php echo base_url();?>superadmin_assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Select2 JS -->
		<script src="<?php echo base_url();?>superadmin_assets/js/select2.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="<?php echo base_url();?>superadmin_assets/js/script.js"></script>

		<script src="<?php echo base_url();?>assets/js/libs/toastr.min.js"></script>

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
		<?php //if($this->uri->segment(2) == ''){?>
		<script>
			var min_slider = document.getElementById("min-slider");
			var min_output = document.getElementById("min-output");
			min_output.innerHTML = min_slider.value;

			min_slider.oninput = function()
			{
				min_output.innerHTML = min_slider.value;
			}

		</script>
	<?php //}?>
		<script>
			$(document).ready(function(){
			  document.getElementById('div2').style.display ='flex';
			});
			function show2(){
			  document.getElementById('div2').style.display ='flex';
			   document.getElementById('div1').style.display ='none';
			}
			function show1(){
			  document.getElementById('div1').style.display = 'flex';
			  document.getElementById('div2').style.display = 'none';
			}

		</script>
    </body>
</html>