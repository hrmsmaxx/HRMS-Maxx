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
								<label for="radio-a">Semestral</label>
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
							<input type="radio" class="CurrencySelect" id="radio-one" name="switch-one" value="yes" checked/>
							<label for="radio-one">USD $</label>
							<input type="radio" class="CurrencySelect" id="radio-two" name="switch-one" value="no" />
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
										<?php 
							            $this->db->order_by('employee_count','DESC');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();?>
										<div class="slidecontainer">
											<div class="slider1">
												<input type="range" min="0" max="<?php echo $result['employee_count']?>" value="0" class="slider" id="min-slider">
												<input type="hidden" value="0" id="monthly_plans_users">
												<input type="hidden" value="0" id="yearly_plans_users">
												<input type="hidden" value="<?php echo base_url(); ?>" id="baseurl">
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

							<?php 
							
							if(count($monthly_plans) != 0){
								$f = 1;
								
								foreach($monthly_plans as $month_plan){
									if($month_plan['plan_id'] == 1){
										$this->db->where('employee_count >=',$month_plan['users_count']);
							            $this->db->order_by('employee_count');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();
										$employee_per_amount = $result['plan1'];
										$plan_amount = $result['plan1'] * $month_plan['users_count'];
										$semester_amount = $plan_amount * 6;
									}else if($month_plan['plan_id'] == 3){										
										$this->db->where('employee_count >=',$month_plan['users_count']);
							            $this->db->order_by('employee_count');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();
										$employee_per_amount = $result['plan2'];
										$plan_amount = $result['plan2'] * $month_plan['users_count'];
										$semester_amount = $plan_amount * 6;
									}else if($month_plan['plan_id'] == 4){
										$this->db->where('employee_count >=',$month_plan['users_count']);
							            $this->db->order_by('employee_count');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();
										$employee_per_amount = $result['plan3'];
										$plan_amount = $result['plan3'] * $month_plan['users_count'];
										$semester_amount = $plan_amount * 6;
									}
								 ?>
									<!--Card1 -->
							<div class="col-md-4">
								<div class="card">
									<div  class="card-body img-bg-card">
										<h2 class="card-title text-center"><?php echo ucfirst($month_plan['plan_name']); ?></h2>
										<hr class="hr-text" data-content="&">
										<h2 class="text-center"><span class="plan-amount"><span class="Plan-Currency">$</span><span class="per_employee<?php echo $f; ?>"><?php echo $employee_per_amount; ?></span></span></h2>
										<h2 class="text-center"><span class="plan-amount"><span class="Plan-Currency">$</span><span class="plan_amount<?php echo $f; ?>"><?php echo $plan_amount; ?></span></span></h2>
										<h2 class="text-center"><span class="plan-amount"><span class="Plan-Currency">$</span><span class="PlaAmu<?php echo $f; ?>"><?php echo $semester_amount; ?></span></span></h2>
										<p class="plan-vali"> per Semestral</p>
										 
										<div class="box">
											<div class="arrow-top">
												<ul>
													<li><b><span class="text-dark mr-1 Plan-Users<?php echo $f; ?>"><?php echo $month_plan['users_count']; ?></span></b> Employees</li>
													<li><b><span class="text-dark mr-1"><?php echo $month_plan['projects_count']; ?></span></b> Projects</li>
														<input type="hidden" value="<?php echo $month_plan['addtional_employee_rate']; ?>" id="AddEmpRate<?php echo $f; ?>">
														<input type="hidden" value="<?php echo $semester_amount; ?>" id="defaultPlanamount<?php echo $f; ?>">
														<input type="hidden" value="<?php echo $month_plan['plan_id']; ?>" id="defaultPlanid<?php echo $f; ?>">
													<?php if($month_plan['messages'] == '1'){ ?>
														<li> Unlimited Messages</li>
													<?php } ?>
													<?php if($month_plan['support'] == '1'){ ?>
														<li> 24/7 Customer Support</li>
													<?php } ?>
													<?php if($month_plan['video_voice'] == '1'){ ?>
														<li> Voice and Video Call</li>
													<?php } ?>
													<li><?php echo $month_plan['description']; ?></li>
												</ul>
											</div>
											<div class="plan-content-box">
											</div>
										</div>
										<div class="sub-btn text-center">
											<a href="<?php echo base_url(); ?>auth/subscribers_register/<?php echo $month_plan['plan_id'].'/'.$month_plan['users_count'].'/'.$semester_amount.'/usd' ?>" class="btn btn-primary btn-block" id="SubBtn<?php echo $f; ?>">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card1 -->


							<?php $f++;	}

							} ?>


							
						</div>
						
						
						<div class="row plan-card hide" id="div2">

							<?php if(count($yearly_plans) != 0){ $e = 4;

								foreach($yearly_plans as $yr_plan){ 

									if($yr_plan['plan_id'] == 5){
										$this->db->where('employee_count >=',$yr_plan['users_count']);
							            $this->db->order_by('employee_count');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();
										$per_employee = $result['plan1'];
										$plan_amount = $result['plan1'] * $yr_plan['users_count'];
										$yearly_amount = $plan_amount * 12;
									}else if($yr_plan['plan_id'] == 6){										
										$this->db->where('employee_count >=',$yr_plan['users_count']);
							            $this->db->order_by('employee_count');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();
										$per_employee = $result['plan2'];
										$plan_amount = $result['plan2'] * $yr_plan['users_count'];
										$yearly_amount = $plan_amount * 12;
									}else if($yr_plan['plan_id'] == 7){
										$this->db->where('employee_count >=',$yr_plan['users_count']);
							            $this->db->order_by('employee_count');
							            $this->db->limit(1);
										$result = $this->db->get('price_per_employee')->row_array();
										$per_employee = $result['plan3'];
										$plan_amount = $result['plan3'] * $yr_plan['users_count'];
										$yearly_amount = $plan_amount * 12;
									}
									?>
									<!--Card1 -->
									<div class="col-md-4">
										<div class="card">
											<div  class="card-body img-bg-card">
												<h2 class="card-title text-center"><?php echo ucfirst($yr_plan['plan_name']); ?></h2>
												<hr class="hr-text" data-content="&">
												<h2 class="text-center"><span class="plan-amount"><span class="Plan-Currency">$</span><span class="per_employee<?php echo $e; ?>"><?php echo $per_employee; ?></span></span></h2>
												<p class="plan-vali"> price per employee/mo</p>
												<h2 class="text-center"><span class="plan-amount"><span class="Plan-Currency">$</span><span class="plan_amount<?php echo $e; ?>"><?php echo $plan_amount; ?></span></span></h2>												
												<p class="plan-vali"> price per month</p>
												<h2 class="text-center"><span class="plan-amount"><span class="Plan-Currency">$</span><span class="PlaAmu<?php echo $e; ?>"><?php echo $yearly_amount; ?></span></span></h2>
												<p class="plan-vali"> per Year</p>
												 
												<div class="box">
													<div class="arrow-top">
														<ul>
															<li><b><span class="text-dark mr-1 Plan-Users<?php echo $e; ?>"><?php echo $yr_plan['users_count']; ?></span></b> Employees</li>
															<li><b><span class="text-dark mr-1"><?php echo $yr_plan['projects_count']; ?></span></b> Projects</li>
															<input type="hidden" value="<?php echo $yr_plan['addtional_employee_rate']; ?>" id="AddEmpRate<?php echo $e; ?>">
															<input type="hidden" value="<?php echo $yearly_amount; ?>" id="defaultPlanamount<?php echo $e; ?>">
															<input type="hidden" value="<?php echo $yr_plan['plan_id']; ?>" id="defaultPlanid<?php echo $e; ?>">
															<?php if($yr_plan['messages'] == '1'){ ?>
																	<li> Unlimited Messages</li>
																<?php } ?>
																<?php if($yr_plan['support'] == '1'){ ?>
																	<li> 24/7 Customer Support</li>
																<?php } ?>
																<?php if($yr_plan['video_voice'] == '1'){ ?>
																	<li> Voice and Video Call</li>
																<?php } ?>
															<li><?php echo $yr_plan['description']; ?></li>
														</ul>
													</div>
													<div class="plan-content-box">
													</div>
												</div>
												<div class="sub-btn text-center">
													<a href="<?php echo base_url(); ?>auth/subscribers_register/<?php echo $yr_plan['plan_id'].'/'.$yr_plan['users_count'].'/'.$yearly_amount.'/usd' ?>" class="btn btn-primary btn-block" id="SubBtn<?php echo $e; ?>">Subscribe Now </a>
													<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
												</div>
											</div>
										</div>
									</div>
									<!--Card1 -->

							<?php $e++;	}

							} ?>

							
							
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
				employee_count = min_slider.value;
				$('#monthly_plans_users').val(employee_count);
				$('#yearly_plans_users').val(employee_count);
				// $( ".Plan-Users1" ).each(function( index ) {
					 $.post('<?=base_url()?>superadmin/price_per_employee',{employee_count:employee_count},function(data){
       				var datas = JSON.parse(data);
       				
       				var plan1 =  employee_count * datas.plan1;
       				var plan2 =  employee_count * datas.plan2;
       				var plan3 =  employee_count * datas.plan3;
					// if(min_slider.value > $( ".Plan-Users1" ).text()){
						// var r = (min_slider.value - $( ".Plan-Users1" ).text());
						// var amt = (parseInt(r * $('#AddEmpRate1').val()) + parseInt($('#defaultPlanamount1').val()));
						var amt = ((plan1.toFixed(1))*6).toFixed(1);						
						$('.per_employee1').text('');
						$('.plan_amount1').text('');
						$('.PlaAmu1').text('');
						$('.per_employee1').text(datas.plan1);
						$('.plan_amount1').text(plan1.toFixed(1));
						$('.PlaAmu1').text(amt);
						$('.Plan-Users1').text(employee_count);
						var cc = 'usd';
						if($('.CurrencySelect:checked').val() == 'yes'){
							cc = 'usd';
						}else{
							cc = 'eur';
						}
						var atag = $('#baseurl').val()+'auth/subscribers_register/'+$('#defaultPlanid1').val()+'/'+min_slider.value+'/'+amt+'/'+cc;
						$('#SubBtn1').attr('href','');
						$('#SubBtn1').attr('href',atag);
						// alert(atag);
					// }
					// if(min_slider.value > $( ".Plan-Users2" ).text()){
						// var r1 = (min_slider.value - $( ".Plan-Users2" ).text());
						// var amt1 = (parseInt(r1 * $('#AddEmpRate2').val()) + parseInt($('#defaultPlanamount2').val()));
						var amt1 = ((plan2.toFixed(1))*6).toFixed(1);
						$('.per_employee2').text('');
						$('.plan_amount2').text('');
						$('.PlaAmu2').text('');
						$('.per_employee2').text(datas.plan2);
						$('.plan_amount2').text(plan2.toFixed(1));
						$('.PlaAmu2').text(amt1);
						$('.Plan-Users2').text(employee_count);
						var cc1 = 'usd';
						if($('.CurrencySelect:checked').val() == 'yes'){
							cc1 = 'usd';
						}else{
							cc1 = 'eur';
						}
						var atag1 = $('#baseurl').val()+'auth/subscribers_register/'+$('#defaultPlanid2').val()+'/'+min_slider.value+'/'+amt1+'/'+cc1;
						$('#SubBtn2').attr('href','');
						$('#SubBtn2').attr('href',atag1);
					// }
					// if(min_slider.value > $( ".Plan-Users3" ).text()){
						// var r2 = (min_slider.value - $( ".Plan-Users3" ).text());
						// var amt2 = (parseInt(r2 * $('#AddEmpRate3').val()) + parseInt($('#defaultPlanamount3').val()));
						var amt2 = ((plan3.toFixed(1))*6).toFixed(1);
						$('.per_employee3').text('');
						$('.plan_amount3').text('');
						$('.PlaAmu3').text('');
						$('.per_employee3').text(datas.plan3);
						$('.plan_amount3').text(plan3.toFixed(1));
						$('.PlaAmu3').text(amt2);
						$('.Plan-Users3').text(employee_count);
						var cc2 = 'usd';
						if($('.CurrencySelect:checked').val() == 'yes'){
							cc2 = 'usd';
						}else{
							cc2 = 'eur';
						}
						var atag2 = $('#baseurl').val()+'auth/subscribers_register/'+$('#defaultPlanid3').val()+'/'+min_slider.value+'/'+amt2+'/'+cc2;
						$('#SubBtn3').attr('href','');
						$('#SubBtn3').attr('href',atag2);
					// }



					// if(min_slider.value > $( ".Plan-Users4" ).text()){
						// var r3 = (min_slider.value - $( ".Plan-Users4" ).text());
						// var amt3 = (parseInt(r3 * $('#AddEmpRate4').val()) + parseInt($('#defaultPlanamount4').val()));
						var amt3 = ((plan1.toFixed(1))*12).toFixed(1);
						$('.per_employee4').text('');
						$('.plan_amount4').text('');
						$('.PlaAmu4').text('');
						$('.per_employee4').text(datas.plan1);						
						$('.plan_amount4').text(plan1.toFixed(1));						
						$('.PlaAmu4').text(amt3);						
						$('.Plan-Users4').text(employee_count);
						var cc3 = 'usd';
						if($('.CurrencySelect:checked').val() == 'yes'){
							cc3 = 'usd';
						}else{
							cc3 = 'eur';
						}
						var atag3 = $('#baseurl').val()+'auth/subscribers_register/'+$('#defaultPlanid4').val()+'/'+min_slider.value+'/'+amt3+'/'+cc3;
						$('#SubBtn4').attr('href','');
						$('#SubBtn4').attr('href',atag3);

					// }
					// if(min_slider.value > $( ".Plan-Users5" ).text()){
						// var r4 = (min_slider.value - $( ".Plan-Users5" ).text());
						// var amt4 = (parseInt(r4 * $('#AddEmpRate5').val()) + parseInt($('#defaultPlanamount5').val()));
						var amt4 = ((plan2.toFixed(1))*12).toFixed(1);
						$('.per_employee5').text('');
						$('.plan_amount5').text('');
						$('.PlaAmu5').text('');
						$('.per_employee5').text(datas.plan2);						
						$('.plan_amount5').text(plan2.toFixed(1));	
						$('.PlaAmu5').text(amt4);
						$('.Plan-Users5').text(employee_count);
						var cc4 = 'usd';
						if($('.CurrencySelect:checked').val() == 'yes'){
							cc4 = 'usd';
						}else{
							cc4 = 'eur';
						}
						var atag4 = $('#baseurl').val()+'auth/subscribers_register/'+$('#defaultPlanid5').val()+'/'+min_slider.value+'/'+amt4+'/'+cc4;
						$('#SubBtn5').attr('href','');
						$('#SubBtn5').attr('href',atag4);
					// }
					// if(min_slider.value > $( ".Plan-Users6" ).text()){
						// var r5 = (min_slider.value - $( ".Plan-Users6" ).text());
						// var amt5 = (parseInt(r5 * $('#AddEmpRate6').val()) + parseInt($('#defaultPlanamount6').val()));
						var amt5 = ((plan3.toFixed(1))*12).toFixed(1);
						$('.per_employee6').text('');
						$('.plan_amount6').text('');
						$('.PlaAmu6').text('');
						$('.per_employee6').text(datas.plan3);						
						$('.plan_amount6').text(plan3.toFixed(1));	
						$('.PlaAmu6').text(amt5);
						$('.Plan-Users6').text(employee_count);

						var cc5 = 'usd';
						if($('.CurrencySelect:checked').val() == 'yes'){
							cc5 = 'usd';
						}else{
							cc5 = 'eur';
						}
						var atag5 = $('#baseurl').val()+'auth/subscribers_register/'+$('#defaultPlanid6').val()+'/'+min_slider.value+'/'+amt5+'/'+cc5;
						$('#SubBtn6').attr('href','');
						$('#SubBtn6').attr('href',atag5);
					// }
					});
				  // $(this).text('€');
				// });
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
			  var user_count = $('#yearly_plans_users').val();
			  $('#min-slider').val(user_count);
			  $('#min-output').text(user_count);
			}
			function show1(){
			  document.getElementById('div1').style.display = 'flex';
			  document.getElementById('div2').style.display = 'none';
			  var user_count = $('#monthly_plans_users').val();
			  $('#min-slider').val(user_count);
			  $('#min-output').text(user_count);
			}

		</script>



		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on("change",".CurrencySelect",function() {
					// alert($(this).val());
					var select_currency = $(this).val();
					if(select_currency == 'no')
					{
						$( ".Plan-Currency" ).each(function( index ) {
						  $(this).text('€');
						});
					}else{
						$( ".Plan-Currency" ).each(function( index ) {
						  $(this).text('$');
						});
					}
				});
			});

		</script>





    </body>
</html>