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

		<title>Employee Self-Service - ESS Management System</title>
	
		<meta name="description" content="Newhrms provides Employee Self-Service portal, By using this system employee can submit personal information, apply for leave and much more.">		

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker.min.css" />

		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" />

		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/flaticon.css" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" />

        <!--[if lt IE 9]>

			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>

			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>

        <![endif]-->

        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>

    </head>

    <body>

        <div class="inner-wrapper shr-wrapper features-wrapper-page">

            <header class="header shrheader">

                <div class="container-fluid shrhcontainer">

                <div class="custom-navbar-default no-radius navbar navbar-default navbar-affixed-top mb-0" data-spy="affix" data-offset-top="100" >

                    <div class="row xs-style vertical-align">

                        <div class="col-sm-4 col-xs-6 logo"><a href="<?php echo base_url();?>"><img class="img img-responsive" src="<?php echo base_url();?>assets/images/logo.png" alt="Dreamguy's Technologies" /></a></div>

                        <div class="col-sm-8 col-xs-6">

                            <ul class="mainnav">

<!--                            <li class="hidden-xs"><a href="#Demo" class="scroll-to">Demo</a></li>

                           <li class="hidden-xs"><a href="#features" class="btn-border scroll-to">Features</a></li>

                           <li class="hidden-xs"><a href="<?php echo base_url();?>" class="scroll-to">Highlights</a></li> -->

                           <li class="hidden-xs"><a href="<?php echo base_url();?>"  class="call-to-action">Back to Home</a></li>

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

                                          <ul class="" id="">
<!-- 
                                             <li><a href="#Demo" class="scroll-to hidden" onclick="closeNav()">Demo</a></li>

                                             <li><a href="#features" class="scroll-to hidden" onclick="closeNav()">Features</a></li>

                                             <li><a href="#support" class="scroll-to hidden" onclick="closeNav()">Highlights</a></li> -->

                                              <li>
                                                <a href="core-hr-software" class="active center-block">
                                                  <span>Core HR</span>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="payroll-software" class="center-block">
                                                  <span>Payroll</span>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="leave-management-software" class="center-block">
                                                  <span>Leave</span>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="attendance-management-software" class="center-block">
                                                  <span>Attendance</span>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="employee-self-service-portal" class="center-block">
                                                  <span>ESS Portal</span>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="mobile-app" class="center-block">
                                                  <span>Mobile</span>
                                                </a>
                                              </li>


                                             <li><a href="<?php echo base_url();?>" class="" >Back to Home</a></li>
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
                        <a href="core-hr-software" class="center-block">
                          <span>Core HR</span>
                        </a>
                      </li>
                      <li>
                        <a href="payroll-software" class="center-block">
                          <span>Payroll</span>
                        </a>
                      </li>
                      <li>
                        <a href="leave-management-software" class="center-block">
                          <span>Leave</span>
                        </a>
                      </li>
                      <li>
                        <a href="attendance-management-software" class="center-block">
                          <span>Attendance</span>
                        </a>
                      </li>
                      <li>
                        <a href="employee-self-service-portal" class="active center-block">
                          <span>ESS Portal</span>
                        </a>
                      </li>
                      <li>
                        <a href="mobile-app" class="center-block">
                          <span>Mobile</span>
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

                    	

                        <div class="col-lg-6 col-md-6 image-column features-slide features-left-blk">

                            <div class="features-pad">

                                <div class="img-box shadow-lg">

                                    <div class="box-loader">

                                    	<span></span>

                                        <span></span>

                                        <span></span>

                                    </div>

                                	<img class="img-center" src="<?php echo base_url();?>assets/images/timesheet.png" alt="">

                                </div>

                            </div>

                        </div>

                        

                        <div class="col-lg-6 col-md-6 md-mt-5 ml-auto">

                        	<div class="features-pad">

                                <h1>ESS Portal</h1>

                                <p>ESS portal increases the motivation and trust whenever improves the access by employees. It is a type of employee portal which insists more online access to get the information about payroll and anything else. It assures transparency, superior quality, better communication, transparency, responsiveness and standardized process. ESS portal engages with the nifty mobile app for the purpose of access from anywhere and anytime.</p>

                                <div id="essportal">

                                	<div class="panel">

                                    	<a data-toggle="collapse" data-parent="#essportal" href="#essportal1" aria-expanded="true">Basic activities</a>

                                        <div id="essportal1" class="collapse in">

                                        	<ol>

                                                <li>Access the personal information.</li>

                                                <li>View the letters and documents.</li>

                                                <li>Follow the forms and policies.</li>

                                                <li>Search the employee data.</li>

                                                <li>Leverage the usage of social networks.</li>

                                            </ol>

                                        </div>

									</div>

                                    <div class="panel">

                                    	<a data-toggle="collapse" data-parent="#essportal" href="#essportal2">Payroll activities through ESS portal</a>

                                        <div id="essportal2" class="collapse">

                                        	<ol>

                                                <li>View the employee payroll data.</li>

                                                <li>Access the inputs of the payroll.</li>

                                                <li>Regulate the tax based updates.</li>

                                            </ol>

                                        </div>

									</div>

                                    <div class="panel">

                                    	<a data-toggle="collapse" data-parent="#essportal" href="#essportal3">Leave process through ESS portal</a>

                                        <div id="essportal3" class="collapse">

                                        	<ol>

                                                <li>Check the holidays along with leave balance.</li>

                                                <li>Manage all the leave related transactions.</li>

                                                <li>Access the leave information of each team.</li>

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

            <section class="section pad-lg bg-grey">

                 <div class="container overflow-hidden">

                    <div class="row align-items-center vertical-align">

                       <div class="col-md-6">

                          <img class="img img-responsive" src="https://res.cloudinary.com/dreamguys/image/upload/v1567583397/newhrms/customer-review_qk7niv.png" />

                       </div>

                       <div class="col-md-6">

                          <div class="section-heading">

                             <h2 class="">Our Client Testimonials!!!</h2>

                          </div>

                       </div>

                    </div>

                    <div class="row">

                       <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="2300">

                          <!-- Wrapper for slides -->

                          <div class="carousel-inner shadow-lg">

                             <div class="item active">

                                <span class="custom-font-family">“</span>

                                <p class="para-line m-t-30">As an HR- Talent Acquisition, I believe New HRMS is one of the best available HR software solution that I 've come across. New HRMS has been an extremely user-friendly and interactive application.</p>

                                <ul class="list-unstyled custom-center align-items-center">

                                   <li class="media flex-column flex-md-row text-center text-md-left">

                                      <img class="img img-responsive mr-14" src="https://res.cloudinary.com/dreamguys/image/upload/v1567583397/newhrms/client-img_kwpqo7.png" />

                                      <div class="media-body mt-3">

                                         <h3>Uwais Mcgrath</h3>

                                      </div>

                                   </li>

                                </ul>

                             </div>

                             <div class="item">

                                <span class="custom-font-family">“</span>

                                <p class="para-line m-t-30">From the moment I started using New HRMS, I felt calmer. It just made sense. The implementation process couldn’t have been easier—I didn’t have to spend hours monitor people on it. Best attendance manage software.</p>

                                <ul class="list-unstyled custom-center align-items-center">

                                   <li class="media flex-column flex-md-row text-center text-md-left">

                                      <img class="img img-responsive mr-14" src="https://res.cloudinary.com/dreamguys/image/upload/v1567583397/newhrms/client-img-2_odqtio.png" />

                                      <div class="media-body mt-3">

                                         <h3>Nicholas Ramos</h3>

                                      </div>

                                   </li>

                                </ul>

                             </div>

                             <div class="item">

                                <span class="custom-font-family">“</span>

                                <p class="para-line m-t-30">New HRMS is the only online HR software which is exactly what we expect for our company. It is user-friendly and a real asset for employees, managers & HR!

                                   The Best HR Solution I have ever used!

                                </p>

                                <ul class="list-unstyled custom-center align-items-center">

                                   <li class="media flex-column flex-md-row text-center text-md-left">

                                      <img class="img img-responsive mr-14" src="https://res.cloudinary.com/dreamguys/image/upload/v1567583397/newhrms/client-img-3_cn1lin.png" />

                                      <div class="media-body mt-3">

                                         <h3>Lawrence Jarvis</h3>

                                      </div>

                                   </li>

                                </ul>

                             </div>

                             <div class="item">

                                <span class="custom-font-family">“</span>

                                <p class="para-line m-t-30">After joining hands with New HRMS, technology has never been an issue for us. We have seen a manifold increase in productivity. The product is so user-friendly that even employees who have no payroll processing experience can get started in hardly a weeks’ time.</p>

                                <ul class="list-unstyled custom-center align-items-center">

                                   <li class="media flex-column flex-md-row text-center text-md-left">

                                      <img class="img img-responsive mr-14" src="https://res.cloudinary.com/dreamguys/image/upload/v1567583397/newhrms/client-img-4_ie7qli.png" />

                                      <div class="media-body mt-3">

                                         <h3>Jeanette Serrano</h3>

                                      </div>

                                   </li>

                                </ul>

                             </div>

                             <div class="item">

                                <span class="custom-font-family">“</span>

                                <p class="para-line m-t-30">New HRMS is an active comrade in the effort of making payroll and employee relationships easier and more productive. Their customer services, dedicated team, and excellent product features made us move forward with them and hope to continue this relationship as the outstanding employee experience partner</p>

                                <ul class="list-unstyled custom-center align-items-center">

                                   <li class="media flex-column flex-md-row text-center text-md-left">

                                      <img class="img img-responsive mr-14" src="https://res.cloudinary.com/dreamguys/image/upload/v1567583397/newhrms/client-img-5_df8jgv.png" />

                                      <div class="media-body mt-3">

                                         <h3>Subham Agarwal</h3>

                                      </div>

                                   </li>

                                </ul>

                             </div>

                          </div>

                          <!-- Left and right controls -->

                          <a class="left carousel-control shadow-lg" href="#myCarousel" data-slide="prev">

                          <span class="carousel-control-prev-icon" aria-hidden="true"><img src="https://res.cloudinary.com/dreamguys/image/upload/v1567583396/newhrms/arrow-left_mc3hqa.png" /></span>

                          <span class="sr-only">Previous</span>

                          </a>

                          <a class="right carousel-control shadow-lg" href="#myCarousel" data-slide="next">

                          <span class="carousel-control-next-icon" aria-hidden="true"><img src="https://res.cloudinary.com/dreamguys/image/upload/v1567583396/newhrms/arrow-right_fmwivd.png" /></span>

                          <span class="sr-only">Next</span>

                          </a>

                       </div>

                    </div>

                 </div>

              </section>

            <!--Testimonials-->

            

            <!--Request Demo-->

            <div class="shrsection pricingcntr pad-lg">

                 <div id="get-quote" class="container">

                    <h1  class="text-center">Request Demo</h1>

                    <p class="text-center">Please fill out the below form to get a best affordable quote</p>

                    <div id="hrms-contact-box">

                       <div class="row">

                          <div class="col-sm-12 col-md-12">

                             <div class="hrms-contact-form">

                                <div class="contact-registration">

                                   <form id="frm_contact" role="form" action="" autocomplete="off" method="POST" class="RequestDemoFrm">

                                      <div class="form-group">

                                         <div class="switch-field">

                                            <input type="radio" id="radio-one" class="DemoRequest" name="type" value="Demo" checked/>

                                            <label for="radio-one">Demo</label>

                                            <input type="radio" id="radio-two" class="DemoRequest" name="type" value="Quote" />

                                            <label for="radio-two">Quote</label>

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

                                            <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="contactname" placeholder="Full name *"></div>

                                            <div class="col-md-6 col-sm-6 col-xs-12"><input type="email" class="form-control" name="contactemail" placeholder="E-mail *" value=""></div>

                                         </div>

                                      </div>

                                      <div class="clearfix"></div>

                                      <div class="form-group">

                                         <div class="row NotQuote">

                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                               <div class="input-group date m-b-23" data-provide="datepicker">

                                                  <input type="text" class="form-control mb-0" placeholder="Choose your date" id="app_date" name="app_date">

                                                  <div class="input-group-addon">

                                                     <span class="fa fa-calendar"></span>

                                                  </div>

                                               </div>

                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                               <select class="form-control" id="timeslot" name="timeslot">

                                                  <option value="">Available Time Slot</option>

                                                  <option value="10-11">10:00am - 11:00am</option>

                                                  <option value="11-12">11:00am - 12:00pm</option>

                                                  <option value="12-1">12:00pm - 01:00pm</option>

                                                  <option value="1-2">01:00pm - 02:00pm</option>

                                                  <option value="2-3">02:00pm - 03:00pm</option>

                                               </select>

                                            </div>

                                         </div>

                                      </div>

                                      <div class="clearfix"></div>

                                      <div class="form-group">

                                         <div class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="contactcompanyname" placeholder="Company name"></div>

                                            <div class="col-md-6 col-sm-6 col-xs-12"><input type="tel" class="form-control" name="contactpincode" placeholder="Pincode" value="" style="border-color: #cccccc;"></div>

                                         </div>

                                      </div>

                                      <div class="clearfix"></div>

                                      <div class="form-group">

                                         <div class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-12 xs-mb-23">

                                               <input type="tel" class="form-control" id="contactphone" name="contactphone" placeholder="Contact Number *">

                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                               <select class="form-control" id="contactcountry" name="contactcountry">

                                                  <option value="">Country *</option>

                                                  <option value="India">India</option>

                                                  <option value="USA">USA</option>

                                                  <option value="Malaysia">Malaysia</option>

                                                  <option value="UK">UK</option>

                                                  <option value="Canada">Canada</option>

                                               </select>

                                            </div>

                                         </div>

                                      </div>

                                      <div class="clearfix"></div>

                                      <div class="form-group">

                                         <div class="textarea-block">

                                            <textarea class="form-control" id="contactmessage" name="contactmessage" placeholder="Write Your Message Here " ></textarea>

                                         </div>

                                      </div>

                                      <div class="form-group text-center">

                                         <button class="call-to-action btn no-radius btn-outline btn-form btn-lg" id="request_btn" type="submit" value="submit">Submit</button>

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

                  <div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo-white.png" /></a></div>

                  <ul class="social list-inline list-unstyled sm-text-center">

                     <li><a href="https://www.facebook.com/dreamguystech/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                     <li><a href="https://twitter.com/dreamguystech" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                     <li><a href="https://www.linkedin.com/company/dreamguy's-technologies/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

                     <li><a href="https://www.youtube.com/channel/UCNi1cF0PYvQIg3uvxLrd3yA" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>

                  </ul>

               </div>

               <div class="col-md-3 col-sm-4">

                   <h3>Services</h3>

                   <ul>

                       <li><a target="_blank" href="https://dreamguys.co.in/web-application-development/">Web App Development</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/mobile-app-development/">Mobile App Development</a></li>      

                       <li><a target="_blank" href="https://dreamguys.co.in/ecommerce-development/">eCommerce Development</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/digital-marketing-services/">Digital Marketing Services</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/crm-development/">CRM Development</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/cms-development/">CMS Development</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/it-services/">IT Services</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/softwarehardware-support/">Software/Hardware Support</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/cloud-based-solution/">Cloud Based Solution</a></li>

                   </ul>

               </div>

               <div class="col-md-3 col-sm-4">

                   <h3>Company</h3>

                   <ul>

                       <li><a target="_blank" href="https://dreamguys.co.in/about-us/">About</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/careers/">Careers</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/portfolio/">Portfolio</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/blog/">Blog</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/contactus/">Contact</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/terms-and-conditions/">Terms &amp; Conditions</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/privacy-policy-dreamguys-technologies/">Privacy Policy</a></li>

                       <li><a target="_blank" href="https://dreamguys.co.in/site-map/">Sitemap</a></li>

                   </ul>

               </div>

               <div class="col-md-3 col-sm-4">

                  <h3>UK Location</h3>

                  <p>Aldborough Road,<br />

                     Dagenham, UK

                  </p>

                  <h3>India Location</h3>

                  <p>22, Sri Kanchi Nagar,<br />

                     Cheranmanagar,<br />

                     Coimbatore, India

                  </p>

                  <h3>Malaysia Location</h3>

                  <p>Selangor,<br />

                     Malaysia 43300

                  </p>

               </div>

            </div>

            <div class="row">

               <div class="col-md-12">

                  <div class="footer-btm pad-sm text-center">

                        <p>Copyright &copy; <?php echo date("Y"); ?> <a href="https://dreamguys.co.in/" target="_blank">Dreamguy's Technologies</a>. All rights reserved.</p>

                  </div>

               </div>

            </div>

         </div>

      </footer>         

        </div>

		
		<script type="text/javascript">

            var BASE_URL='<?php echo base_url();?>';

        </script>



		
<!--
		

		<script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>

		<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>

		<script src="<?php echo base_url();?>assets/js/main.js"></script>

		<script src="<?php echo base_url();?>assets/js/custom.js"></script>
		
-->
		
		<script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/modal-video.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/odometer.js"></script>

        <script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/main.js"></script>

        <script src="<?php echo base_url();?>assets/js/custom.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/admin_validation.js"></script>
		
        

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

            $('#mySidenav').css({'display','none'});

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

			

			$('#frm_contact').bootstrapValidator().on('submit', function (e) {

                    if (e.isDefaultPrevented()) {

                  // handle the invalid form...

				} else {

				

					 $.ajax({

				type: "POST",

				url: "<?php echo base_url(); ?>home/contactus_send_mail/", 

				data: $('#frm_contact').serialize(),

				success: function(result){

				    console.log(result); return false;

					$('#frm_contact')[0].reset();

				  $('#success_contact').css('display','');

				  setTimeout(function(){ 

					$('#success_contact').css('display','none');

				   }, 3500);

			}});

					 return false;

					}

				 

			});

			$('#req_from_demo').bootstrapValidator().on('submit', function (e) {

                    if (e.isDefaultPrevented()) {

                  // handle the invalid form...

				} else {

				

					 $.ajax({

                			type: "POST",

                			url: "<?php echo base_url(); ?>home/contactus_send_mail/", 

                			data: $('#req_from_demo').serialize(),

                			success: function(result){

                			    console.log(result); return false;

                				$('#req_from_demo')[0].reset();

                			    $('#success_contact').css('display','');

                			    setTimeout(function(){ 

                				  $('#success_contact').css('display','none');

                			    }, 3500);

                		}

					 });

					 return false;

					}

				 

			});

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