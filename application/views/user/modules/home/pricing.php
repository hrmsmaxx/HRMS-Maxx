<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.png">
		<title>Pricing | Hrms Maxx</title>
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-datepicker.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-datetimepicker.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/flaticon.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/owl.carousel.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/dragdealer.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css" />
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
	</head>
	<body>
		<div class="inner-wrapper shr-wrapper features-wrapper-page">
		<header class="header shrheader">
			<div class="container-fluid shrhcontainer">
				<div class="custom-navbar-default no-radius navbar navbar-default navbar-affixed-top mb-0" data-spy="affix" data-offset-top="100" >
					<div class="row xs-style vertical-align">
						<div class="col-sm-4 col-xs-6 logo"><a href="<?=base_url()?>"><img class="img img-responsive" src="<?=base_url()?>assets/img/logo6.png" alt="HRMSMaxx" width="150"/></a></div>
						<div class="col-sm-8 col-xs-6">
							<ul class="mainnav">
								<li class="hidden-xs"><a href="<?php echo base_url()?>"  class="call-to-action">Página principal</a></li>
								<li class="visible-xs">
									<a id="nav-expander" class="nav-expander" href="javascript:void(0)" onclick="openNav()">
										<button id="ChangeToggle" type="button" class="navbar-toggle" data-toggle="collapse"
											data-target=".navbar-collapse">
											<div id="navbar-hamburger" class="">
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar no-margin"></span>
											</div>
										</button>
									</a>
								</li>
							</ul>
							<div id="mySidenav" class="menu-full sidenav" style="width: 0px;">
								<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
								<div class="menu-wrapper">
									<div class="row">
										<div class="col-md-8">
											<div class="menu-section1">
												<div class="menu-mobile">
													<ul>
														<!-- 
															<li><a href="#Demo" class="scroll-to hidden" onclick="closeNav()">Demo</a></li>
															
															<li><a href="#features" class="scroll-to hidden" onclick="closeNav()">Features</a></li>
															
															<li><a href="#support" class="scroll-to hidden" onclick="closeNav()">Highlights</a></li> -->
														<li>
															<a href="<?=base_url()?>/home/pricing" class="active center-block">
															<span>Precios</span>
															</a>
														</li>
														<!-- <li>
															<a href="payroll-software" class="center-block">
															<span>Payroll</span>
															</a>
														</li>
														<li>
															<a href="leave-management-software" class="center-block">
															<span>Leave</span>
															</a>
														</li> -->
														<li><a href="<?=base_url()?>" class="" >Página principal</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<section class="features-link-wrapper hidden-xs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="secondary-nav-link text-center">
							<ul class="list-unstyled list-inline">
								<li>
									<a href="pricing.html" class="active center-block">
									<span>Precios</span>
									</a>
								</li>
								<!-- <li>
									<a href="payroll-software" class="center-block">
									<span>Payroll</span>
									</a>
								</li>
								<li>
									<a href="leave-management-software" class="center-block">
									<span>Leave</span>
									</a>
								</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="pad-lg pos-r" style="background:#fff;">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 ">
						<div id="pricing">
							<div class="features-pad pricing-drag-pad">
								<h1 class="text-center">¡Calcula tu plan!
								</h1>
								<p class="text-center">Arrastre la barra para seleccionar la cantidad de empleados activos en tu empresa.
								</p>
								<div class="container">
									<div style="float:right; margin-top:10px; margin-right:10px;">
										<table>
											<tr>
												<td>
													<div id="divMB" style="width:140px; color:#373737; font-weight:bold; font-size:16px;">Plan semestral
													</div>
												</td>
												<td style="width:60px;">
													<div style="margin-top:10px;">
														<div class="material-switch"><input id="my" onclick="UpdatePrice();" checked="true" type="checkbox" /><label for="my" class="label-primary"></label></div>
													</div>
												</td>
												<td>
													<div id="divYB" style="font-weight:bold; font-size:16px; color:#1eb53a;">Plan anual
													</div>
												</td>
											</tr>
										</table>
									</div>
									<div style="clear:both;"></div>
									<div>
										<!-- <div class="text-center">Drag to select the number of active employees</div> -->
										<div class="range-holder">
											<div id="pricing_slider" class="dragdealer">
												<div class="stripe">
													<div class="handle">
														<div class="infobox">
															<div class="titlebar"><span id="emp"></span></div>
															<div class="innerbox">
																<div class="ppm"></div>
																<div id="ppe" class="ppe"></div>
																<div class="annual-price"></div>
															</div>
														</div>
														<div class="square">
															<span class="value"></span>
															<span class="menu-line"></span>
															<span class="menu-line"></span>
															<span class="menu-line"></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card-box">
											<div class="row">
												<div class="col-xs-6" style="border-right:1px solid #dedede;">
													<div style="font-size:28px; font-weight:bold;">Módulos de HRMS Maxx 
													</div>
													<br />
													<table style="width:100%;">
														<tr>
															<td style="padding-top:6px; width:60px;vertical-align:top;">
																<div class="material-switch"><input id="am" checked="true" disabled readonly type="checkbox" /><label for="am" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">
																Todos los módulos base&nbsp;<a href="javascript:void(0);" onclick="$('#divBaseModules').slideToggle(300);"><i style="font-size:16px; color:#373737;" title="Click to see what is included in Base Modules" class="fa fa-plus-circle"></i></a>
																<div style="display:none;" id="divBaseModules">
																	<div style="font-weight:normal;">Tiempo &amp; Asistencia &nbsp;<a href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Timesheet&ui=no', width:'900px;', height:'750px;'});"><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></div>
																	<div style="font-weight:normal;">Turnos y Horarios </div>
																	<div style="font-weight:normal;">Información de Funcionario </div>
																	<div style="font-weight:normal;">Incorporacion &amp; Cese Gestión&nbsp;<a href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Onboarding&ui=no', width:'900px;', height:'750px;'});"><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></div>
																	<div style="font-weight:normal;">de Licencias</div>
																	<div style="font-weight:normal;">Panel de control dinámico </div>
																	<div style="font-weight:normal;">Reportes Avanzados </div>
																	<div style="font-weight:normal;">Documentos. y legajos </div>
																	<div style="font-weight:normal;">Organigrama y Jerarquías </div>
																	<div style="font-weight:normal;">Reportes Avanzados </div>
																	<div style="font-weight:normal;">Calendarios y Eventos &nbsp;<a href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Calendar&ui=no', width:'900px;', height:'750px;'});"><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></div>
																	<div style="font-weight:normal;">Documentos. y legajos </div>
																	<div style="font-weight:normal;">Chat y Videollamadas  </div>
																	<div style="font-weight:normal;">Proyectos </div>
																	<div style="font-weight:normal;">Tareas  </div>
																	<div style="font-weight:normal;">Aplicación Móvil </div>
																</div>
															</td>
															<td style="font-size:18px; font-weight:500; color:#1eb53a;width:60px; text-align:right;vertical-align: top;">
																<div id="mp_Base">$ 2.00</div>
															</td>
														</tr>
														<tr>
															<td colspan="3" style="height:20px;"></td>
														</tr>
														<tr>
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_Payroll" type="checkbox" /><label for="am_Payroll" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Nómina de sueldos&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Payroll&ui=no', width:'900px;', height:'750px;'});" ><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_Payroll"> - </div>
															</td>
														</tr>
														<tr>
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_Recruitment" type="checkbox"  /><label for="am_Recruitment" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Sistema de reclutamiento / seguimiento de candidatos (ATS)&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Recruitment&ui=no', width:'900px;', height:'750px;'});" ><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_Recruitment"> - </div>
															</td>
														</tr>
														<tr>
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_Performance" type="checkbox" /><label for="am_Performance" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Actuación&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Performance&ui=no', width:'900px;', height:'750px;'});" ><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_Performance"> - </div>
															</td>
														</tr>
														<tr class="trMoreAddOnModules" style="display:none;">
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_eSignature" type="checkbox" /><label for="am_eSignature" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Firma electrónica&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=eSignature&ui=no', width:'900px;', height:'750px;'});"><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_eSignature"> - </div>
															</td>
														</tr>
														<tr class="trMoreAddOnModules" style="display:none;">
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_Forms" type="checkbox" /><label for="am_Forms" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Formas&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Forms&ui=no', width:'900px;', height:'750px;'});"><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_Forms"> - </div>
															</td>
														</tr>
														<tr class="trMoreAddOnModules" style="display:none;">
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_HRLetters" type="checkbox" /><label for="am_HRLetters" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Cartas de recursos humanos&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=HRLetters&ui=no', width:'900px;', height:'750px;'});" ><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_HRLetters"> - </div>
															</td>
														</tr>
														<tr class="trMoreAddOnModules" style="display:none;">
															<td style="padding-top:6px; width:60px;">
																<div class="material-switch"><input onclick="ChangeModules();" id="am_Benefits" type="checkbox" /><label for="am_Benefits" class="label-primary"></label></div>
															</td>
															<td style="font-size:18px; font-weight:bold;">Beneficios&nbsp;<a style="font-weight:bold;" href="javascript:void(0);" onclick="$.colorbox({href:'contents.php?page=Features&type=Benefits&ui=no', width:'900px;', height:'750px;'});"><i title="Click for More Information" style="font-size:16px; color:#373737;" class="fa fa-info-circle"></i></a></td>
															<td style="font-size:18px; text-align:right;">
																<div style="font-weight:bold;" id="mp_Benefits"> - </div>
															</td>
														</tr>
														<tr>
															<td colspan="3" style="height:6px;"></td>
														</tr>
														<tr class="trMoreAddOnModulesLink">
															<td colspan="2"><a style="color:#000; font-weight:bold;" href="javascript:void(0);" onclick="MoreAddOnModules();" >+ Más módulos adicionales
																</a>
															</td>
														</tr>
														<tr style="display:none;" class="trLessAddOnModulesLink">
															<td colspan="2"><a style="color:#000; font-weight:bold;" href="javascript:void(0);" onclick="LessAddOnModules();">- Menos módulos adicionales</a></td>
														</tr>
													</table>
												</div>
												<div class="col-xs-6">
													<div style="font-size:28px; font-weight:bold;">Características
													</div>
													<br />
													<table style="width:100%;">
														<tr>
															<td style="width:24px;"><i style="color:#1eb53a;" class="fa fa-check"></i></td>
															<td style="font-weight:bold;">Seguridad SSL</td>
														</tr>
														<tr>
															<td style="width:24px;"><i style="color:#1eb53a;" class="fa fa-check"></i></td>
															<td style="font-weight:bold;">Soporte 24/7</td>
														</tr>
														<tr>
															<td style="width:24px;"><i style="color:#1eb53a;" class="fa fa-check"></i></td>
															<td style="font-weight:bold;" id="ds">Capacidad de almacenamiento</td>
														</tr>
														<tr>
															<td style="width:24px;"><i style="color:#1eb53a;" class="fa fa-check"></i></td>
															<td style="font-weight:bold;">Acceso a todas las integraciones / acceso API</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="text-center" style="margin-top:30px;">
								<h4>¿Precisas ayuda para poder implementarlo? ¿Hay algo que no sabes si es posible hacerlo? </h4>
								<p>Despreocupate, nuestros expertos te ayudarán a resolver tus problemas e inquietudes.</p>
								<a href="#" class="btn btn-success" data-toggle="modal" data-target="#webform"> <b>Quiero saber más  </b>
								</a>
							</div>
						</div>
					</div>
				</div>
		</section>
		<footer class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-3 sm-mb-41">
                  <div class="logo"><a href="<?php echo base_url()?>"><img src="<?=base_url()?>assets/img/logo-white.png" alt="Images"/></a></div>
                  <ul class="social list-inline list-unstyled sm-text-center">
                     <li><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                     <li><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                     <li><a href="#" target="_blank"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
                     <li><a href="#" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                     <li><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                  </ul>
               </div>
               <div class="col-md-3 col-sm-4">
                  <h3>Servicios</h3>
                  <ul>
                     <li><a target="_blank" href="#">Vision General </a></li>
                     <li><a target="_blank" href="#">Pedal de Arranque </a></li>
                     <li><a target="_blank" href="#">Capacitación</a></li>
                     <li><a target="_blank" href="#">Soporte al Cliente </a></li>
                  </ul>
               </div>
               <div class="col-md-3 col-sm-4">
                  <h3>Empresa</h3>
                  <ul>
                     <li><a target="_blank" href="#">Acerca de Empresa</a></li>
                     <li><a target="_blank" href="#">Contacto Carreras </a></li>
                     <li><a target="_blank" href="#">Portafolio</a></li>
                     <li><a target="_blank" href="#">Términos y condiciones </a></li>
                     <li><a target="_blank" href="#">Política de privacidad </a></li>
                  </ul>
               </div>
               <div class="col-md-3 col-sm-4">
                  <div class="">
                     <h3>Latin America Location:</h3>
                     <p>Leyenda Patria 3100, 302,<br />
                        11300, Montevideo, Montevideo<br />
                        Uruguay
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="footer-btm pad-sm text-center">
                     <p>Derechos de autor &copy; 2020 <a href="<?php echo base_url()?>" target="_blank">HRMS Maxx</a>. 
                        Todos los derechos reservados.</p>
                  </div>
               </div>
            </div>
         </div>
      </footer>
		</div>
		<!-- The modal -->
		<div class="modal fade" id="webform" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title text-center" id="modalLabel">Solicitar demostración
						</h4>
					</div>
					<div class="modal-body">
						<div class="shrsection pricingcntr">
							<div id="get-quote" class="">
								<p class="text-center">Complete el siguiente formulario para obtener una mejor cotización asequible</p>
								<div>
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div style="margin:10px;">
												<div class="contact-registration">
													<form id="frm_contact" role="form" autocomplete="off" method="POST" class="RequestDemoFrm">
														<div class="form-group">
															<div class="switch-field">
																<input type="radio" id="radio-one" class="DemoRequest" name="type" value="Demo" checked/>
																<label for="radio-one">Demo</label>
																<input type="radio" id="radio-two" class="DemoRequest" name="type" value="Quote" />
																<label for="radio-two">Cotización</label>
															</div>
															<!--<label class="radio-inline">
																<input type="radio" name="type" value="Demo" checked> Demo
																</label>
																<label class="radio-inline">
																<input type="radio" name="type" value="Quote"> Quote
																</label>-->
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="contactname" placeholder="Nombre completo *"></div>
																<div class="col-md-6 col-sm-6 col-xs-12"><input type="email" class="form-control" name="contactemail" placeholder="E-mail *" value=""></div>
															</div>
														</div>
														<div class="clearfix"></div>
														<div class="form-group">
															<div class="row NotQuote">
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<div class="input-group date m-b-23" data-provide="datepicker">
																		<input type="text" class="form-control mb-0" placeholder="Seleccione su mejor fecha " id="app_date" name="app_date">
																		<div class="input-group-addon">
																			<span class="fa fa-calendar"></span>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<div class="input-group time m-b-23" id="timepicker">
																		<input class="form-control mb-0" placeholder="Hora Disponible"/>
																		
																			<div class="input-group-addon">
																				<span class="fa fa-clock-o"></span>
																			</div>
																		
																	  </div>
																</div>
															</div>
														</div>
														<div class="clearfix"></div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="contactcompanyname" placeholder="Nombre de la empresa"></div>
																<div class="col-md-6 col-sm-6 col-xs-12"><input type="tel" class="form-control" name="contactpincode" placeholder="Cantidad de funcionarios" value="" style="border-color: #cccccc;"></div>
															</div>
														</div>
														<div class="clearfix"></div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-6 col-sm-6 col-xs-12 xs-mb-23">
																	<input type="tel" class="form-control" id="contactphone" name="contactphone" placeholder="Nùmero de Contacto *">
																</div>
																<?php $countries =  $this->db->get('dgt_countries')->result();?>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<select class="select2-option form-control" style="width:100%;" id="contactcountry" name="contactcountry" >
														<option value="" selected="selected">Country</option>										
											<optgroup label="Priority">

												<?php foreach ($countries as $country): 
													if($country->value =='Canada' || $country->value =='United States of America' ){?>

													<option value="<?=$country->value?>"><?=$country->value?></option>
												<?php } endforeach; ?>										
											</optgroup>
											<optgroup label="Other Countries">
												<?php foreach ($countries as $country): if($country->value !='Canada' && $country->value !='United States of America' ){?>
													<option value="<?=$country->value?>"><?=$country->value?></option>
												<?php } endforeach; ?>
											</optgroup>
										</select>
																</div>
															</div>
														</div>
														<div class="clearfix"></div>
														<div class="form-group">
															<div class="textarea-block">
																<textarea class="form-control" id="contactmessage" name="contactmessage" placeholder="Escriba un mensaje si lo desea  " ></textarea>
															</div>
														</div>
														<div class="form-group text-center">
															<button class="call-to-action btn no-radius btn-outline btn-form btn-lg" id="request_btn" type="submit" value="submit">Enviar </button>
															<button type="button" class="btn btn-danger btn-lg no-radius btn-outline" data-dismiss="modal" style="border-radius:30px; padding:12px 32px;">Close</button>
														</div>
														<span id="success_contact" style="color: #29c729;font-size: 19px;border: 1px solid;padding: 13px;border-radius: 10px; display: none;"> We appreciate that you’ve taken the time to write us. We’ll get back to you very soon..!</span>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
            var BASE_URL='<?php echo base_url();?>';
        </script>
		<script src="<?=base_url()?>assets/js/jquery-3.2.1.min.js"></script>
		<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
		<script src="<?=base_url()?>assets/js/moment.min.js"></script>
		<script src="<?=base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>		
		<script src="<?=base_url()?>assets/js/jquery.validate.js"></script>
		<script src="<?=base_url()?>assets/js/modal-video.min.js"></script>
		<script src="<?=base_url()?>assets/js/odometer.js"></script>
		<script src="<?=base_url()?>assets/js/owl.carousel.min.js"></script>
		<script src="<?=base_url()?>assets/js/main.js"></script>
		<script src="<?=base_url()?>assets/js/custom.js"></script>
		<script src="<?=base_url()?>assets/js/bootstrapValidator.min.js"></script>
		<script src="<?=base_url()?>assets/js/admin_validation.js"></script>
		<script src="<?=base_url()?>assets/js/modernizr.min.js"></script>
		<script src="<?=base_url()?>assets/js/dragdealer.js"></script>
		<script src="<?=base_url()?>assets/js/script.js"></script>
		<script src="<?=base_url()?>assets/js/modernizr.min.js"></script>
		<script>
			var iPaymentTerm = 1;
			var dPricePerEmployee = 2.00;
			var dAddOnModulesPrice = 0;
			
			var iSubscriptionFor = 5;
			
			var iAddOnModules = 7;
			var aAddOnModules = Array();
			var aAddOnModules_Type = Array();
			var aAddOnModules_Price = Array();
			var aAddOnModules_Status = Array();
			
			function ChangeModules()
			{
			    
			            aAddOnModules[0] = "Payroll";
			            aAddOnModules_Type[0] = "0";
			            aAddOnModules_Price[0] = "1.0";
			            aAddOnModules_Status[0] = ($("#am_Payroll").prop("checked") == true) ? 1 : 0;
			            aAddOnModules[1] = "Recruitment";
			            aAddOnModules_Type[1] = "0";
			            aAddOnModules_Price[1] = "0.5";
			            aAddOnModules_Status[1] = ($("#am_Recruitment").prop("checked") == true) ? 1 : 0;
			            aAddOnModules[2] = "Performance";
			            aAddOnModules_Type[2] = "0";
			            aAddOnModules_Price[2] = "1.0";
			            aAddOnModules_Status[2] = ($("#am_Performance").prop("checked") == true) ? 1 : 0;
			            aAddOnModules[3] = "eSignature";
			            aAddOnModules_Type[3] = "0";
			            aAddOnModules_Price[3] = "0.25";
			            aAddOnModules_Status[3] = ($("#am_eSignature").prop("checked") == true) ? 1 : 0;
			            aAddOnModules[4] = "Forms";
			            aAddOnModules_Type[4] = "0";
			            aAddOnModules_Price[4] = "0.25";
			            aAddOnModules_Status[4] = ($("#am_Forms").prop("checked") == true) ? 1 : 0;
			            aAddOnModules[5] = "HRLetters";
			            aAddOnModules_Type[5] = "0";
			            aAddOnModules_Price[5] = "0.25";
			            aAddOnModules_Status[5] = ($("#am_HRLetters").prop("checked") == true) ? 1 : 0;
			            aAddOnModules[6] = "Benefits";
			            aAddOnModules_Type[6] = "0";
			            aAddOnModules_Price[6] = "1.0";
			            aAddOnModules_Status[6] = ($("#am_Benefits").prop("checked") == true) ? 1 : 0;
			        
			    for (i=0; i < iAddOnModules; i++)
			    {
			        if (aAddOnModules_Status[i] == 1)
			            $("#mp_" + aAddOnModules[i]).html("$ " + parseFloat(aAddOnModules_Price[i]).toFixed(2));
			        else if (aAddOnModules_Status[i] == 0)
			            $("#mp_" + aAddOnModules[i]).html(" - ");
			    }
			
			    UpdatePrice();
			}
			
			new Dragdealer("pricing_slider", {
			    animationCallback: function (x, y)
			    {
			        var slider_value = ((Math.round(x * 200)));
			        var stripe_width = slider_value + 1;
			        $(".stripe").css("width", "" + stripe_width / 2 + "%");
			
			        iSubscriptionFor = (slider_value+1) * 5;
			        UpdatePrice();
			    }
			});
			
		
			$(document).on('click','#request_btn',function(){

          
            $("#frm_contact").validate({
                ignore: [],
                rules: {
                    
                    contactname: {
                        required: true
                    },
                    contactemail: {
                        required: true
                    },
                    contactphone: {
                        required: true
                    },
                    contactcountry: {
                        required: true
                    }
                    // break_time: {
                    //     required: true
                    // }
                    // repeat_time:{
                    //     required: true
                    // }
                },
                messages: {
                   
                    contactname: {
                        required: 'Please enter a full name'
                    },
                    contactemail: {
                        required: 'Please enter a email'
                    },
                    contactphone: {
                        required: 'Please enter a contact number'
                    },
                    contactcountry: {
                        required: 'Please select country'
                    }
                    // break_time: {
                    //     required: 'Break time is required'
                    // }
                    // repeat_time: {
                    //     required: 'Repeat is required'
                    // }
                },
                submitHandler: function(form) {
                   	 $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>home/contactus_send_mail/", 
				data: $('#frm_contact').serialize(),
				success: function(result){
				    // console.log(result); return false;
					$('#frm_contact')[0].reset();
				  $('#success_contact').css('display','');
				  setTimeout(function(){ 
					$('#success_contact').css('display','none');
				   }, 3500);
			}});
                }
                
               });

            
        });
			
			     
			$(document).on('change','.DemoRequest',function(){
			      var request_demo = $(".DemoRequest:checked").val();
			      if(request_demo == 'Quote'){
			         $('.NotQuote').css('display','none');
			         // $('.RequestDemoFrm').attr('id','');
			         // $('.RequestDemoFrm').attr('id','req_from_demo');
			         // $('#request_btn').removeAttr('disabled');
			      }else{
			         $('.NotQuote').css('display','block');
			         // $('.RequestDemoFrm').attr('id','');
			         // $('.RequestDemoFrm').attr('id','frm_contact');
			         // $('#request_btn').removeAttr('disabled');
			      }
			});
			
		</script>
	</body>
</html>