<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.png">
		<title>Cloud-based Online Attendance Management Software</title>
		<meta name="description" content="Hrms Maxx Provides the best attendance management software, Now you can easily manage your employee attendance efficiency.">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-datepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-datetimepicker.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/flaticon.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/owl.carousel.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css" />
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
						<div class="col-sm-4 col-xs-6 logo"><a href="<?php echo base_url()?>"><img class="img img-responsive" src="<?php echo base_url()?>assets/img/logo6.png" alt="HRMSMaxx" width="150"/></a></div>
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
																<a href="<?=base_url()?>home/core_hr_software" class="center-block">
																<span>Módulo central</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/payroll_software" class="center-block">
																<span>Liquidacion de Nomina</span>
																</a>
															</li>
															<li>
																<a href="<?php echo base_url()?>home/leave_management_software" class=" center-block">
																<span>Gestión de Licencia</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/attendance_management_software" class="active center-block">
																<span>Tiempo y Asistencia</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/employee_self_service_portal" class="center-block">
																<span>Portal de Autoservicio</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/mobile_app" class="center-block">
																<span>Aplicación Mobile</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/ats" class="center-block">
																<span>ATS</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/crm" class="center-block">
																<span>CRM</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/projects" class="center-block">
																<span>Proyectos</span>
																</a>
															</li>
															<li>
																<a href="<?=base_url()?>home/cloud_computing" class="center-block">
																<span>Cloud Computing</span>
																</a>
															</li>
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
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">
                  <h6></h6>
						<div class="secondary-nav-link text-center">
							<ul class="list-unstyled list-inline">
								<li>
										<a href="<?=base_url()?>home/core_hr_software" class="center-block">
										<span>Módulo central</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/payroll_software" class="center-block">
										<span>Liquidacion de Nomina</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url()?>home/leave_management_software" class=" center-block">
										<span>Gestión de Licencia</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/attendance_management_software" class="active center-block">
										<span>Tiempo y Asistencia</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/employee_self_service_portal" class="center-block">
										<span>Portal de Autoservicio</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/mobile_app" class="center-block">
										<span>Aplicación Mobile</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/ats" class="center-block">
										<span>ATS</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/crm" class="center-block">
										<span>CRM</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/projects" class="center-block">
										<span>Proyectos</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url()?>home/cloud_computing" class="center-block">
										<span>Cloud Computing</span>
										</a>
									</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="pad-lg pos-r">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
						<div class="features-pad">
							<div class="img-box shadow-lg">
								<div class="box-loader">
									<span></span>
									<span></span>
									<span></span>
								</div>
								<img class="img-center" src="<?php echo base_url()?>assets/img/banner-slide-5.png" alt="">
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto">
						<div class="features-pad">
							<h1>Software de gestión de asistencia</h1>
							<h1>Controles las asistencias, genere reportes para sus departamentos y analice con estadísticas.</h1>
							<p>Se pierden semanas enteras realizando trabajos monótonos y propensos a errores que son fácilmente automatizables.
								<br>
								Se pierden semanas enteras realizando trabajos monótonos y propensos a errores que son fácilmente automatizables.
								<br>
								Nuestro <a href="<?php echo base_url()?>home/attendance_management_software">sistema de gestión de asistencia</a> es muy eficiente y fácil de manejar.<br>
								Por lo tanto, puede obtener la mejor experiencia cuando el sistema se integra con nuestro software.
							</p>
							<div id="attendance">
								<div class="panel">
									<a data-toggle="collapse" data-parent="#attendance" href="#attendance1" aria-expanded="true">Utiliza diferentes fuentes de alimentacion</a>
									<div id="attendance1" class="collapse in">
										<ol>
											<li>Portal de Autoservicio.</li>
											<li>Nuestra aplicación para dispositivos móviles (utilizando reconocimiento facial o contrasena).
											</li>
											<li>Hardware de terceros (por ejemplo relojes biométricos de ZKTeco).
											</li>
										</ol>
									</div>
								</div>
								<div class="panel">
									<a data-toggle="collapse" data-parent="#attendance" href="#attendance2">Geo marca</a>
									<div id="attendance2" class="collapse">
										<ol>
											<li>Graba las coordenadas de la ubicación donde el usuario haya “marcado” asistencia con nuestra aplicación. 
											</li>
										</ol>
									</div>
								</div>
								<div class="panel">
									<a data-toggle="collapse" data-parent="#attendance" href="#attendance3">Adaptado para todas las complejidades (gestión extensiva de turnos)
									</a>
									<div id="attendance3" class="collapse">
										<ol>
											<li>Asigne reglas o políticas de asignación de turnos y horarios según múltiples factores.
											</li>
											<li>Gestione la complejidad de turnos rotativos o variables según periodos de tiempo o demanda.
											</li>
										</ol>
									</div>
								</div>
								<div class="panel">
									<a data-toggle="collapse" data-parent="#attendance" href="#attendance4">Genera reportes automáticos, complejos y sea notificado.
									</a>
									<div id="attendance4" class="collapse">
										<ol>
											<li>Analice variables complejas cuando trabaja con servicios tercerizados.
											</li>
											<li>Obtenga información de desvíos anormales de comportamiento de la asistencia media.
											</li>
											<li>Reciba alertas según distintas variables configurables.
											</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
					</div>
            </div>
         </div>
		</section>
		<!--Testimonials-->
      <section class="section integration-bubbles pad-lg">
         <div class="container overflow-hidden">
            <div class="row align-items-center vertical-align">
               <div class="col-md-6">
                  <img class="img img-responsive" src="<?php echo base_url()?>assets/img/customer-review.png" alt="Images"/>
               </div>
               <div class="col-md-6">
                  <div class="section-heading">
                     <h2 class="">La plataforma de recursos humanos más completa!!</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="2300">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner shadow-lg">
                     <div class="item active">
                        <span class="custom-font-family">“</span>
                        <p class="para-line m-t-30">Como HR-Talent Acquisition, creo que HRMS Maxx es una de las mejores soluciones de software de recursos humanos disponibles que he encontrado. El nuevo HRMS ha sido una aplicación extremadamente fácil de usar e interactiva.</p>
                        <ul class="list-unstyled custom-center align-items-center">
                           <li class="media flex-column flex-md-row text-center text-md-left">
                              <img class="img img-responsive mr-14" src="<?php echo base_url()?>assets/img/client-img.png" alt="Images"/>
                              <div class="media-body mt-3">
                                 <h3>Uwais Mcgrath</h3>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="item">
                        <span class="custom-font-family">“</span>
                        <p class="para-line m-t-30">Desde el momento en que comencé a usar HRMS Maxx, me sentí más tranquilo. Simplemente tenía sentido. El proceso de implementación no podría haber sido más fácil: no tuve que pasar horas monitoreando a las personas en él. El mejor software de gestión de asistencia.</p>
                        <ul class="list-unstyled custom-center align-items-center">
                           <li class="media flex-column flex-md-row text-center text-md-left">
                              <img class="img img-responsive mr-14" src="<?php echo base_url()?>assets/img/client-img-2.png" alt="Images"/>
                              <div class="media-body mt-3">
                                 <h3>Nicholas Ramos</h3>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="item">
                        <span class="custom-font-family">“</span>
                        <p class="para-line m-t-30">
                           HRMS Maxx es el único software de recursos humanos en línea que es exactamente lo que esperamos para nuestra empresa. ¡Es fácil de usar y un activo real para empleados, gerentes y recursos humanos!
                           ¡La mejor solución de recursos humanos que he usado!
                        </p>
                        <ul class="list-unstyled custom-center align-items-center">
                           <li class="media flex-column flex-md-row text-center text-md-left">
                              <img class="img img-responsive mr-14" src="<?php echo base_url()?>assets/img/client-img-3.png" alt="Images"/>
                              <div class="media-body mt-3">
                                 <h3>Lawrence Jarvis</h3>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="item">
                        <span class="custom-font-family">“</span>
                        <p class="para-line m-t-30">Después de unirnos con HRMS Maxx, la tecnología nunca ha sido un problema para nosotros. Hemos visto un aumento múltiple en la productividad. El producto es tan fácil de usar que incluso los empleados que no tienen experiencia en el procesamiento de la nómina pueden comenzar en apenas unas semanas.</p>
                        <ul class="list-unstyled custom-center align-items-center">
                           <li class="media flex-column flex-md-row text-center text-md-left">
                              <img class="img img-responsive mr-14" src="<?php echo base_url()?>assets/img/client-img-4.png" alt="Images"/>
                              <div class="media-body mt-3">
                                 <h3>Jeanette Serrano</h3>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="item">
                        <span class="custom-font-family">“</span>
                        <p class="para-line m-t-30">
                           HRMS Maxx es un compañero activo en el esfuerzo de hacer que las relaciones de nómina y empleados sean más fáciles y productivas. Su servicio al cliente, su equipo dedicado y sus excelentes características de producto nos hicieron avanzar con ellos y esperamos continuar esta relación como un excelente socio de experiencia de los empleados.
                        </p>
                        <ul class="list-unstyled custom-center align-items-center">
                           <li class="media flex-column flex-md-row text-center text-md-left">
                              <img class="img img-responsive mr-14" src="<?php echo base_url()?>assets/img/client-img-5.png" alt="Images"/>
                              <div class="media-body mt-3">
                                 <h3>Subham Agarwal</h3>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!-- Left and right controls -->
                  <a class="left carousel-control shadow-lg" href="#myCarousel" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"><img src="<?php echo base_url()?>assets/img/arrow-left.png" alt="Image"/></span>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control shadow-lg" href="#myCarousel" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"><img src="<?php echo base_url()?>assets/img/arrow-right.png" alt="Image"/></span>
                  <span class="sr-only">Next</span>
                  </a>
               </div>
            </div>
         </div>
      </section>
      <!--Testimonials-->
      <!--Request Demo-->
      <div class="shrsection pricingcntr pad-lg bg-grey">
         <div id="get-quote" class="container">
            <h1  class="text-center">Solicitar demostración</h1>
            <p class="text-center">Complete el siguiente formulario para obtener una mejor cotización asequible</p>
            <div id="hrms-contact-box">
               <div class="row">
                  <div class="col-sm-12 col-md-12">
                     <div class="hrms-contact-form">
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
													<div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="contactname" placeholder="Nombre completo
														*"></div>
													<div class="col-md-6 col-sm-6 col-xs-12"><input type="email" class="form-control" name="contactemail" placeholder="E-mail *" value=""></div>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="form-group">
												<div class="row NotQuote">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="input-group date m-b-23" data-provide="datepicker">
															<input type="text" class="form-control mb-0" placeholder="Seleccione su mejor fecha " id="app_date" name="demo_date">
															<div class="input-group-addon">
																<span class="fa fa-calendar"></span>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<div class="input-group time m-b-23" id="timepicker">
															<input class="form-control mb-0" placeholder="Hora Disponible" name="demo_time" />
															
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
													<div class="col-md-6 col-sm-6 col-xs-12"><input type="tel" class="form-control" name="contactpincode" placeholder="Cantidad de funcionarios
														" value="" style="border-color: #cccccc;"></div>
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
      <!--Request Demo-->                  
      <footer class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-3 sm-mb-41">
                  <div class="logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>assets/img/logo-white.png" alt="Images"/></a></div>
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
                     <!-- <li><a target="_blank" href="#">Vision General </a></li> -->
                     <li><a target="_blank" href="#">Pedal de Arranque </a></li>
                     <li><a target="_blank" href="#">Capacitación</a></li>
					 <li><a target="_blank" href="#">Soporte al Cliente </a></li>
					 <li><a target="_blank" href="#">Seguridad</a></li>
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
		<script type="text/javascript">
            var BASE_URL='<?php echo base_url();?>';
        </script>
		<script src="<?php echo base_url()?>assets/js/jquery-1.11.0.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>		
		<script src="<?php echo base_url()?>assets/js/moment.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.validate.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/modal-video.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/odometer.js"></script>
		<script src="<?php echo base_url()?>assets/js/owl.carousel.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/main.js"></script>
		<script src="<?php echo base_url()?>assets/js/custom.js"></script>
		<script src="<?php echo base_url()?>assets/js/bootstrapValidator.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/admin_validation.js"></script>
		<script>
			//* Blog Js 
			
			function owl_Carousel(){
			
				if ( $('.features-slide').length ){ 
			
					$('.features-carousel').owlCarousel({
			
					 loop: true,
			
					 margin: 20,
			
					 nav: true,
			
					 items: 1,  
			
					 navText: ["<i class='flaticon-back'></i>","<i class='flaticon-next'></i>"],
			
					 responsive: {
			
						 0: {
			
							 items: 1, 
			
							 margin: 0,
			
						 },
			
						 767: {
			
							 items: 1, 
			
						 },
			
						 1000: {
			
							 items: 1, 
			
						 },
			
						 1199: {
			
							 items: 1, 
			
						 },
			
						 1299: {
			
							 items: 1, 
			
						 },
			
						 1700: {
			
							 items: 1, 
			
						 }
			
					 }
			
					})
			
				};
			
			}; 
			
			/*Function Calls*/ 
			
			owl_Carousel ();  
			
			     
		</script>
		<script>
			function openNav() {
			
			    document.getElementById("mySidenav").style.width = "100%";
			
			}    
			
			function closeNav() {
			
			    $('#mySidenav').css('display','none');
			
			}
			
		</script>
		<script type="text/javascript">
			$(function () {
			
				"use strict";
			
				$.fn.scrollTo = function (options) {
			
			
			
					var settings = {
			
						offset: -77, //an integer allowing you to offset the position by a certain number of pixels. Can be negative or positive
			
						speed: 'slow', //speed at which the scroll animates
			
						override: null, //if you want to override the default way this plugin works, pass in the ID of the element you want to scroll through here
			
						easing: 'linear' //easing equation for the animation. Supports easing plugin as well (http://gsgd.co.uk/sandbox/jquery/easing/)
			
					};
			
			
			
					if (options) {
			
						if (options.override) {
			
							//if they choose to override, make sure the hash is there
			
							options.override = (override('#') != -1) ? options.override : '#' + options.override;
			
						}
			
						$.extend(settings, options);
			
					}
			
			
			
					return this.each(function (i, el) {
			
						$(el).click(function (e) {
			
							var idToLookAt;
			
							if ($(el).attr('href').match(/#/) !== null) {
			
								e.preventDefault();
			
								idToLookAt = (settings.override) ? settings.override : $(el).attr('href'); //see if the user is forcing an ID they want to use
			
								//if the browser supports it, we push the hash into the pushState for better linking later
			
								if (history.pushState) {
			
									history.pushState(null, null, idToLookAt);
			
									$('html,body').stop().animate({
			
										scrollTop: $(idToLookAt).offset().top + settings.offset
			
									}, settings.speed, settings.easing);
			
								} else {
			
									//if the browser doesn't support pushState, we set the hash after the animation, which may cause issues if you use offset
			
									$('html,body').stop().animate({
			
										scrollTop: $(idToLookAt).offset().top + settings.offset
			
									}, settings.speed, settings.easing, function (e) {
			
										//set the hash of the window for better linking
			
										window.location.hash = idToLookAt;
			
									});
			
								}
			
							}
			
						});
			
					});
			
				};
			
			});
			
			
			
			
			
			// Modal video
			
			new ModalVideo('.js-modal-btn', {channel: 'youtube'});
			
			
			
			//Scroll-Anchor
			
			$(document).ready(function () {
			
				
			
			       
			
				function openNav() {
			
			         document.getElementById("mySidenav").style.width = "100%";
			
			       }
			
			       
			
			       function closeNav() {
			
			         
			
			       $('#mySidenav').css({'display' : 'none'});
			
			       }
			
			       
			
			
			
				$('.scroll-to').scrollTo();
			
			});
			
			
			
			
			
			
			
			       //* Blog Js 
			
			       function owl_Carousel(){
			
			        if ( $('.features-slide').length ){ 
			
			            $('.features-carousel').owlCarousel({
			
			                loop: true,
			
			                margin: 20,
			
			                nav: true,
			
			                items: 1,  
			
			                navText: ["<i class='flaticon-back'></i>","<i class='flaticon-next'></i>"],
			
			                responsive: {
			
			                    0: {
			
			                        items: 1, 
			
			                        margin: 0,
			
			                    },
			
			                    767: {
			
			                        items: 1, 
			
			                    },
			
			                    1000: {
			
			                        items: 1, 
			
			                    },
			
			                    1199: {
			
			                        items: 1, 
			
			                    },
			
			                    1299: {
			
			                        items: 1, 
			
			                    },
			
			                    1700: {
			
			                        items: 1, 
			
			                    }
			
			                }
			
			            })
			
			        };
			
			       }; 
			
			       
			
			       
			
			       /*Function Calls*/ 
			
			       owl_Carousel ();  
			
			
			
			
			
			   $(document).on('change','.DemoRequest',function(){
			
					 var request_demo = $(".DemoRequest:checked").val();
			
					 if(request_demo == 'Quote'){
			
						$('.NotQuote').css('display','none');
			
					 }else{
			
						$('.NotQuote').css('display','block');
			
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
			
			
			
			
				var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			
				(function(){
			
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			
				s1.async=true;
			
				s1.src='https://embed.tawk.to/5c1217d67a79fc1bddf0bec2/1daqhl17b';
			
				s1.charset='UTF-8';
			
				s1.setAttribute('crossorigin','*');
			
				s0.parentNode.insertBefore(s1,s0);
			
				})();
			
			
			
		</script>
	</body>
</html>