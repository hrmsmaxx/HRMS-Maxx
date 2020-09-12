<?php


    $query = $this->db->query("select * from system_settings WHERE status = 1");

    $result = $query->result_array();

    $this->website_name = '';
    $website_logo_front ='assets/img/logo.png';

  

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

    if($data['key'] == 'logo_front'){
             $website_logo_front =  $data['value'];
    }

    
    }

    }

    if(!empty($favicon))

    {

    $fav = base_url().'uploads/logo/'.$favicon;

    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="description" content="Build your better workplace with NewHRMS.  It is one of the best HR Management Software which build for any type of businesses in India. NewHRMS is an effective solution for Payroll Management, Employee, Attendance, Project, Client Management and all in one builded software.">
        <meta name="keywords" content="human resource management software, hrms, human resource management system, hr software india, hr software for small business, hr software for startups, top 10 hr software in india, performance management software, cloud hr software">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
         <link rel="shortcut icon" href="<?php echo $fav ;?>">
		<title>Top HR Management Solution in India | Best HR Software | NewHRMS</title>
		
		
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />
		<link href="<?php echo base_url();?>assets/css/modal-video.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/odometer-theme-minimal.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/flaticon.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" />
	  
        <!-- <style>
			.header ul.mainnav{ display:none;}
			.hrms-contact-form .textarea-block{ margin:0;}
			#hrms-contact-box{ margin:30px auto 0; width:80%;}
        </style> -->

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132757834-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-132757834-1');
        </script>

    </head>

    <body>

	<div class="inner-wrapper shr-wrapper">
         <header class="header shrheader">
            <div class="container-fluid shrhcontainer">
               <div class="custom-navbar-default no-radius navbar navbar-default navbar-affixed-top mb-0" data-spy="affix" data-offset-top="100" >
                  <div class="row xs-style vertical-align">
                     <div class="col-sm-4 col-xs-6 logo"><a href="<?php echo base_url();?>"><img class="img img-responsive" src="<?php echo base_url();?>assets/images/logo.png" alt="Dreamguy's Technologies" /></a></div>
                     <div class="col-sm-8 col-xs-6">
                        <ul class="mainnav">
                           <li class="hidden-xs"><a href="#Demo" class="scroll-to">Demo</a></li>
                           <li class="hidden-xs"><a href="#features" class="btn-border scroll-to">Features</a></li>
                           <li class="hidden-xs"><a href="#support" class="scroll-to">Highlights</a></li>
                           <li class="hidden"><a href="#pricing" class="btn-border scroll-to">Pricing</a></li>
                           <li class="hidden-xs"><a href="javascript:;" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" class="call-to-action">Become a partner</a></li>
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
                                             <li><a href="#Demo" class="scroll-to" onclick="closeNav()">Demo</a></li>
                                             <li class="hidden-xs"><a href="#features" class="scroll-to" onclick="closeNav()">Features</a></li>
                                             <li><a href="#support" class="scroll-to" onclick="closeNav()">Highlights</a></li>
                                             <li><a href="#pricing" class="scroll-to" onclick="closeNav()">Pricing</a></li>
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
         <section class="banner-blk home-page">
            <div class="container-fluid">
               <div class="row vertical-align">
                  <div class="col-md-6 col-md-push-6 shrhleft">
                     <div class="owl-carousel features-carousel owl-theme features-custom-style">
                        <div class="item">
                           <div class="image-column features-slide features-left-blk">
                              <div class="features-blk-slide">
                                 <div class="img-box shadow-lg">
                                    <div class="box-loader"> <span></span>
                                       <span></span>
                                       <span></span>
                                    </div>
                                    <img class="img-center" src="<?php echo base_url();?>assets/images/banner-slide-1.jpg" srcset="<?php echo base_url();?>assets/images/banner-slide-1.jpg" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="item">
                           <div class="image-column features-slide features-left-blk">
                              <div class="features-blk-slide">
                                 <div class="img-box shadow-lg">
                                    <div class="box-loader"> <span></span>
                                       <span></span>
                                       <span></span>
                                    </div>
                                    <img class="img-center" src="<?php echo base_url();?>assets/images/banner-slide-2.jpg" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="item">
                           <div class="image-column features-slide features-left-blk">
                              <div class="features-blk-slide">
                                 <div class="img-box shadow-lg">
                                    <div class="box-loader"> <span></span>
                                       <span></span>
                                       <span></span>
                                    </div>
                                    <img class="img-center" src="<?php echo base_url();?>assets/images/banner-slide-3.jpg" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-md-pull-6 shrhright hidden-xs">
                     <div class="bannermonitor pad-xl pad-sm sm-text-center">
                        <div class="banner-contents">
                           <h1 class="title-anim">A Complete HR Solution for Startups.</h1>
                           <p class="title-anim">A NewHRMS carved with complete HR Care. The User-friendly UI design is easily understandable and customizable according to the business. Each Moduled designed with powerful technology. This HR Software has different modules such as Employee Management, Payroll Management, Performance Management and Client management. The custom fit design will satisfy your needs, makes your workplace a smart and hassle.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <svg class="wave-animation" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none">
               <defs>
                  <path id="gentle-wave" d="M-160 44c30 0 
                     58-18 88-18s
                     58 18 88 18 
                     58-18 88-18 
                     58 18 88 18
                     v44h-352z"></path>
               </defs>
               <g class="wave-bg">
                  <use xlink:href="#gentle-wave" x="50" y="0" fill="rgba(255,255,255,0.2)"></use>
                  <use xlink:href="#gentle-wave" x="50" y="3" fill="rgba(255,255,255,0.2)"></use>
                  <use xlink:href="#gentle-wave" x="50" y="6" fill="#ffffff"></use>
               </g>
            </svg>
         </section>
         <section class="video-section " id="Demo">
            <div class="container">
               <h2 class="text-center">Watch our real-time work flow</h2>
               <!--Video Box-->
               <div class="video-box">
                  <div class="title">NEW</br>HRMS</div>
                  <a class="js-modal-btn play-btn lightbox-image overlay-box" data-video-id="GIiH2I23FiY"><span class="fa fa-play"><i class="ripple"></i></span></a>
                  <div class="side-image">
                     <img src="<?php echo base_url();?>assets/images/newhrms-landing/video-watching-men.png" alt="">
                  </div>
               </div>
            </div>
         </section>
         <section class="newhrms-features pad-lg xs-mt-5 hidden" id="Features">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tittle text-center">
                        <h2>Automated and Simplified Tool</h2>
                     </div>
                  </div>
                  <div class="col-lg-12 features-slide">
                     <div class="owl-carousel features-carousel owl-theme">
                        <div class="item">
                           <div class="features-blk-slide">
                              <div class="row">
                                 <div class="col-sm-4">
                                    <h2>Employees</h2>
                                    <h3>Growth of every employee is evident success of the organization</h3>
                                    <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                                 </div>
                                 <div class="col-sm-8">
                                    <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/employees-tab-img.jpg" alt="Employees - NewHRMS Dashboard" />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Attendance</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/payroll-tab-img.jpg" alt="Attendance - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Task</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/task-tab-img.jpg" alt="Task - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Payroll</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/payroll-tab-img.jpg" alt="Payroll - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Projects</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/projects-tab-img.jpg" alt="Projects - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Events</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/event-tab-img.jpg" alt="Events - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Events</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/event-tab-img.jpg" alt="Events - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Clients</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/clients-tab-img.jpg" alt="Clients - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Chat</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/chat-tab-img.jpg" alt="Chat - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Accounts</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/accounts-tab-img.jpg" alt="Accounts - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                        <div class="features-blk-slide">
                           <div class="row">
                              <div class="col-sm-4">
                                 <h2>Settings</h2>
                                 <h3>Growth of every employee is evident success of the organization</h3>
                                 <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                              </div>
                              <div class="col-sm-8">
                                 <img class="img img-responsive" src="<?php echo base_url();?>assets/images/newhrms-landing/settings-tab-img.jpg" alt="Settings - NewHRMS Dashboard" />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <div class="shrsection pad-lg featurestab">
            <div class="container" id="features">
               <h2 class="text-center">Automated and Simplified Tool</h2>
               <div>
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active"><a href="#employees" aria-controls="employees" role="tab" data-toggle="tab">Employees</a></li>
                     <li role="presentation"><a href="#attendance" aria-controls="attendance" role="tab" data-toggle="tab">Attendance</a></li>
                     <li role="presentation"><a href="#task" aria-controls="task" role="tab" data-toggle="tab">Task</a></li>
                     <li role="presentation"><a href="#payroll" aria-controls="payroll" role="tab" data-toggle="tab">Payroll</a></li>
                     <li role="presentation"><a href="#projects" aria-controls="projects" role="tab" data-toggle="tab">Projects</a></li>
                     <li role="presentation"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Events</a></li>
                     <li role="presentation"><a href="#clients" aria-controls="clients" role="tab" data-toggle="tab">Clients</a></li>
                     <li role="presentation"><a href="#chat" aria-controls="chat" role="tab" data-toggle="tab">Chat</a></li>
                     <li role="presentation"><a href="#accounts" aria-controls="accounts" role="tab" data-toggle="tab">Accounts</a></li>
                     <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <!-- Tab 1 -->
                     <div role="tabpanel" class="tab-pane active" id="employees">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Employees</h2>
                              <h3>Growth of every employee is evident success of the organization</h3>
                              <p>Scale the employee’s activities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/employees-tab-img.jpg" alt="Employees - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 1 -->
                     <!-- Tab 2 --> 
                     <div role="tabpanel" class="tab-pane" id="attendance">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Attendance</h2>
                              <h3>Managing the attendance is a immediate requirement for small offices</h3>
                              <p>Effectively managing the attendance solution for your small offices will drastically improve the productivity of your office, we give necessary tools to manage the attendance effectively.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/payroll-tab-img.jpg" alt="Attendance - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 2 -->
                     <!-- Tab 3 -->
                     <div role="tabpanel" class="tab-pane" id="task">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Task</h2>
                              <h3>Managing employees projects and relevant tasks are key for your office</h3>
                              <p>We provide a complete project/task solution for your office needs, with this you will be able to manage your employees projects/tasks and what they do daily.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/task-tab-img.jpg" alt="Task - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 3 -->
                     <!-- Tab 4 -->
                     <div role="tabpanel" class="tab-pane" id="payroll">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Payroll</h2>
                              <h3>You dont need a seperate person to manage your Payroll anymore</h3>
                              <p>Managing payroll is a tedious task and you need a seperate person to manage this every month, but with our solution you just need our tools.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/payroll-tab-img.jpg" alt="Payroll - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 4 -->
                     <!-- Tab 5 -->
                     <div role="tabpanel" class="tab-pane" id="projects">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Projects</h2>
                              <h3>Managing employees projects and relevant tasks are key for your office</h3>
                              <p>Projects are linked with clients as well, so what employee does on tasks/projects directly reflects on the clients billing, its the effective way to do.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/projects-tab-img.jpg" alt="Projects - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 5 -->
                     <!-- Tab 6 -->
                     <div role="tabpanel" class="tab-pane" id="events">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Events</h2>
                              <h3>You can manage your office events in a single place</h3>
                              <p>You wont notice how much time even small events inside your office takes from you, with our latest tools you'll feel free when you use it.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/event-tab-img.jpg" alt="Events - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 6 -->
                     <!-- Tab 7 -->
                     <div role="tabpanel" class="tab-pane" id="clients">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Clients</h2>
                              <h3>Reporting your productivity to your clients is the key</h3>
                              <p>For every successfull business, reporting your productivity of your employees to your clients is the key to success, now its made easy.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/clients-tab-img.jpg" alt="Clients - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 7 -->
                     <!-- Tab 8 -->
                     <div role="tabpanel" class="tab-pane" id="chat">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Chat</h2>
                              <h3>Text/voice/video chat are key tools</h3>
                              <p>With a massive amount of tools online, it is must to keep the employees to interact with each other wherever they are, we help to achieve.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/chat-tab-img.jpg" alt="Chat - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 8 -->
                     <!-- Tab 9 -->
                     <div role="tabpanel" class="tab-pane" id="accounts">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Accounts</h2>
                              <h3>Managing accounts on a single location</h3>
                              <p>All your accounts solution is managed in a single location including payroll of employees to client invoices and quotes, everything is now linked.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/accounts-tab-img.jpg" alt="Accounts - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 9 -->
                     <!-- Tab 10 -->
                     <div role="tabpanel" class="tab-pane" id="settings">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Settings</h2>
                              <h3>You can tweek it how you like it to be</h3>
                              <p>Our tools are more sophisticated that you will be able to customise it based on your needs, each and every modules with access control is something you'll love.</p>
                           </div>
                           <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/newhrms-landing/settings-tab-img.jpg" alt="Settings - NewHRMS Dashboard" /></div>
                        </div>
                     </div>
                     <!-- Tab 10 -->
                  </div>
               </div>
               <a href="<?php echo base_url(); ?>feature/" class="call-to-action center-block-hardcode text-center w-140">View More</a>
            </div>
         </div>
         <!--shrsection-->          
         <div class="shrsection hlightsection p-b-95 sm-mt-50 xs-mt-5" id="support">
            <div class="container">
               <h2 class="text-center">Special Highlights</h2>
               <div class="row">
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="services-box">
                        <div class="icon">
                           <img src="<?php echo base_url();?>assets/images/newhrms-landing/features-icons-new-hrms/icon-grid-1.png" />
                        </div>
                        <p>Complete solution with mobile applications (Android/iOS)</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="services-box">
                        <div class="icon">
                           <img src="<?php echo base_url();?>assets/images/newhrms-landing/features-icons-new-hrms/icon-grid-2.png" />
                        </div>
                        <p>Responsive tool to be viewed<br> in all devices</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="services-box">
                        <div class="icon">
                           <img src="<?php echo base_url();?>assets/images/newhrms-landing/features-icons-new-hrms/icon-grid-3.png" />
                        </div>
                        <p>Customizable solution with module <br>access control</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="services-box">
                        <div class="icon">
                           <img src="<?php echo base_url();?>assets/images/newhrms-landing/features-icons-new-hrms/icon-grid-4.png" />
                        </div>
                        <p>Tasks/Projects from employees<br> to clients</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="services-box">
                        <div class="icon">
                           <img src="<?php echo base_url();?>assets/images/newhrms-landing/features-icons-new-hrms/icon-grid-5.png" />
                        </div>
                        <p>Smart dashboard for effective <br>reporting</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="services-box">
                        <div class="icon">
                           <img src="<?php echo base_url();?>assets/images/newhrms-landing/features-icons-new-hrms/icon-grid-6.png" />
                        </div>
                        <p>Text/Voice/Video chat and Face Recognition to engage employees</p>
                     </div>
                  </div>
               </div>
               <a href="<?php echo base_url(); ?>feature/" class="visible-xs call-to-action center-block-hardcode text-center w-140">View More</a>
            </div>
         </div>
         <section id="app-download-area">
            <div class="app-download-bg bg-2"></div>
            <div class="container">
               <div class="row">
                  <!--start section heading-->
                  <div class="col-lg-5 col-md-5">
                     <div class="section-heading">
                        <h5>Choose Your Device Platform</h5>
                        <h2>Ionic and React Native Mobile App Template</h2>
                     </div>
                  </div>
                  <!--end section heading-->
                  <div class="col-lg-7 col-md-7">
                     <div class="screenshot-contain">
                        <img class="mobile-light-left" src="<?php echo base_url();?>assets/images/light.png" alt="light">
                        <img class="mob-mocup img-fluid hidden-xs" src="<?php echo base_url();?>assets/images/screenshot-mob.png" alt="screenshot-mob">
                        <img class="mobile-light-right" src="<?php echo base_url();?>assets/images/light.png" alt="light-right">
                        <div class="screenshot-carousel owl-carousel owl-theme">
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen1.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen2.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen5.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen4.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen3.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen5.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen2.png" alt="app">
                           </div>
                           <div class="screenshot-item">
                              <img src="<?php echo base_url();?>assets/images/screen3.png" alt="app">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="app-downlod-review two">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-6 col-md-7">
                        <div class="row">
                           <div class="col-lg-6 text-center">
                              
                        <div class="download-btns two">
                           <a class="bg" href="https://codecanyon.net/item/smarthr-hr-management-system-ionic-mobile-app-template/23198266?_ga=2.55779758.484536156.1563163488-1716885999.1561638381" target="_blank"> App Store</a>
                        </div>
                              <div class="app-reviews">
                                 <div class="rating-details">
                                    <p class="m-0"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section class="pricing-area pad-lg pricing-plans hidden" id="pricing">
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <div class="section-title text-center">
                        <h2 class="pb-0">Pricing Table</h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12 col-md-12 text-center">
                     <div id="pricing-basis-options" class="btn-group btn-group-toggle mt-5" data-toggle="buttons"><label class="btn btn-secondary active"><input type="radio" name="pricing-basis" value="monthly" checked="checked"> Dollars </label> <label class="btn btn-secondary"><input type="radio" name="pricing-basis" value="yearly"> Rupees</label></div>
                     <div class="tab-slider-container">
                        <div id="monthly" class="tab-slider-body" style="display: block;">
                           <div class="row row-eq-height">
                              <div class="col-lg-3 col-md-6 col-sm-6 pricing-plan row-eq-height">
                                 <div class="pricingTable xs-my-5">
                                    <div class="pricingTable-header">
                                       <h3 class="title">Team</h3>
                                       <div class="pricing-details"><span class="pricing-value"><span class="odometer price" data-monthly="299" data-yearly="20488">299</span></span></div>
                                    </div>
                                    <ul class="pricing-content">
                                       <li>Website</li>
                                       <li>Price + VAT</li>
                                       <li>Installation Charges Apply</li>
                                       <li>15 days Free Support</li>
                                       <li>You cannot list it as your own application</li>
                                    </ul>
                                    <a data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" class="btn btn-theme">Buy Now</a>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 pricing-plan row-eq-height">
                                 <div class="pricingTable xs-my-5">
                                    <div class="pricingTable-header">
                                       <h3 class="title">Startup</h3>
                                       <div class="pricing-details"><span class="pricing-value"><span class="odometer price" data-monthly="499" data-yearly="34193">499</span></span></div>
                                    </div>
                                    <ul class="pricing-content">
                                       <li>A website with iOS or Android</li>
                                       <li>Price + VAT</li>
                                       <li>Installation Charges Apply</li>
                                       <li>30 days of free Support</li>
                                       <li>You cannot list it as your own application</li>
                                    </ul>
                                    <a data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" class="btn btn-theme">Buy Now</a>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 pricing-plan row-eq-height">
                                 <div class="pricingTable xs-my-5 md-mt-50">
                                    <div class="pricingTable-header">
                                       <h3 class="title">Company</h3>
                                       <div class="pricing-details"><span class="pricing-value"><span class="odometer price" data-monthly="699" data-yearly="47897">699</span></span></div>
                                    </div>
                                    <ul class="pricing-content">
                                       <li>A website with iOS & Android</li>
                                       <li>Price + VAT</li>
                                       <li>Installation Charges Apply</li>
                                       <li>60 days of free Support</li>
                                       <li>You cannot list it as your own application</li>
                                    </ul>
                                    <a href="#" class="btn btn-theme">Buy Now</a>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 offset-sm-2 offset-lg-0 offset-md-3 pricing-plan row-eq-height">
                                 <div class="pricingTable md-mt-50">
                                    <div class="pricingTable-header">
                                       <h3 class="title">Enterprise</h3>
                                       <div class="pricing-details"><span class="pricing-value"><span class="odometer price" data-monthly="999" data-yearly="68454">999</span></span></div>
                                    </div>
                                    <ul class="pricing-content">
                                       <li>Website, iOS & Android with <br class="visible-sm">source code</li>
                                       <li>Price + VAT</li>
                                       <li>No Installation Charges</li>
                                       <li>90 days of free Support</li>
                                       <li>You can list it as your own application</li>
                                    </ul>
                                    <a href="#" class="btn btn-theme">Buy Now</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </section>
      <!-- Integrations -->
      <section class="section integration-bubbles pad-lg">
         <div class="bg-animation">
            <img class="zoom-fade" src="<?php echo base_url();?>assets/images/pattern-bg.png" alt="" />
         </div>
         <div class="container overflow-hidden">
            <div class="row align-items-center vertical-align">
               <div class="col-md-6">
                  <div class="bubbles-wrapper hidden-xs">
                     <div class="animations m-0">
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-md"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /></div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xxl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-lg"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-md"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-lg"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-md"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-lg"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xxl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /></div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-md"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-md"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xxl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /></div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-lg"><img src="<?php echo base_url();?>assets/images/1.png" alt="" class="img-responsive" /> </div>
                        <div class="bubble bg-contrast rounded-circle p-2 icon-circle icon-like-xl"><img src="<?php echo base_url();?>assets/images/4.png" alt="" class="img-responsive" /> </div>
                     </div>
                  </div>
                  <img class="img img-responsive" src="<?php echo base_url();?>assets/images/customer-review.png" />
               </div>
               <div class="col-md-6">
                  <div class="section-heading">
                     <h2 class="">Our Clients Testimonials!!!</h2>
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
                              <img class="img img-responsive mr-14" src="<?php echo base_url();?>assets/images/client-img.png" />
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
                              <img class="img img-responsive mr-14" src="<?php echo base_url();?>assets/images/client-img-2.png" />
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
                              <img class="img img-responsive mr-14" src="<?php echo base_url();?>assets/images/client-img-3.png" />
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
                              <img class="img img-responsive mr-14" src="<?php echo base_url();?>assets/images/client-img-4.png" />
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
                              <img class="img img-responsive mr-14" src="<?php echo base_url();?>assets/images/client-img-5.png" />
                              <div class="media-body mt-3">
                                 <h3>Subham Agarwal</h3>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!-- Left and right controls -->
                  <a class="left carousel-control shadow-lg" href="#myCarousel" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"><img src="<?php echo base_url();?>assets/images/arrow-left.png" /></span>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control shadow-lg" href="#myCarousel" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"><img src="<?php echo base_url();?>assets/images/arrow-right.png" /></span>
                  <span class="sr-only">Next</span>
                  </a>
               </div>
            </div>
         </div>
      </section>
      <div class="shrsection pricingcntr pad-lg bg-grey">
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
      <footer class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-3 sm-mb-41">
                  <div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo-white.png" /></a></div>
                  <ul class="social list-inline list-unstyled sm-text-center">
                      <li><a href="https://www.linkedin.com/company/dreamguy's-technologies/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                      <li><a href="https://twitter.com/dreamguystech" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                      <li><a href="https://join.skype.com/invite/KqfsfMbmDu9a" target="_blank"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
                      <li><a href="https://www.youtube.com/channel/UCNi1cF0PYvQIg3uvxLrd3yA" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                     <li><a href="https://www.facebook.com/dreamguystech/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
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
                     Dagenham, UK<br />
                     Ph: 020 8638 8690
                  </p>
                  <h3>India Location</h3>
                  <p>22, Sri Kanchi Nagar,<br />
                     Cheranmanagar,<br />
                     Coimbatore, India<br />
                     Ph: +91 9003477876
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


         <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Fill in the details for Paypal payment</h4>
        </div>
        <div class="modal-body">
                                                  <div class="hrms-contact-form">
                                            <div class="contact-registration">
                                                <form id="buynow_form" role="form" action="<?php echo base_url();?>payment" method="POST" autocomplete="off">
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="name" placeholder="Full name"></div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12"><input type="email" class="form-control" name="email" placeholder="E-mail" value=""></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="companyname" placeholder="Company name"></div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12"><input type="tel" class="form-control" name="price" placeholder="Price" value=""></div>
                                                    </div> 
                                                    <div class="clearfix"></div>                                                 
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12 xs-mb-23">
                                                            <input type="tel" class="form-control" id="phoneno" name="phoneno" placeholder="Contact Number *">
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control" id="country" name="country">
                                                                <option value="">Country *</option>
                                                                <option value="India">India</option>
                                                                <option value="USA">USA</option>
                                                                <option value="Malaysia">Malaysia</option>
                                                                <option value="UK">UK</option>
                                                                <option value="Canada">Canada</option>
                                                            </select>                                                           
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group text-center">
                                                        <button class="btn no-radius btn-outline btn-form btn-lg" type="submit" value="submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
        </div>
      </div>
      
    </div>
  </div>

        <script type="text/javascript">
            var BASE_URL='<?php echo base_url();?>';
        </script>

        <script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/modal-video.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/odometer.js"></script>
		<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/main.js"></script>
        <script src="<?php echo base_url();?>assets/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/admin_validation.js"></script>
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

// $(document).ready(function(){
//     $(document).on('change','.DemoRequest',function(){
//         var request_demo = $(".DemoRequest:checked").val();
//         if(request_demo == 'Quote'){
//             $('.NotQuote').css('display','none');
            
//         }else{
//             $('.NotQuote').css('display','block');
//         }
//     }); 
// });


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
<!--End of Tawk.to Script-->
    </body>
</html>