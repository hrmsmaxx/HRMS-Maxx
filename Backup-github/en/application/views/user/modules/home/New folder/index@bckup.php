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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
         <link rel="shortcut icon" href="<?php echo $fav ;?>">
        <title><?php echo $this->website_name; ?></title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/transition.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal-video.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" />
        <style>
			.header ul.mainnav{ display:none;}
			.hrms-contact-form .textarea-block{ margin:0;}
			#hrms-contact-box{ margin:30px auto 0; width:80%;}
        </style>

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
                <div class="container shrhcontainer">
                    <div class="row">
                        <div class="col-sm-4 logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url().$website_logo_front; ?>" alt="Dreamguy's Technologies" /></a></div>
                        <div class="col-sm-8">
                            <ul class="mainnav">
                                <li><a href="#features" class=" scroll-to">Features</a></li>
                                <li><a href="#">Pricing</a></li>
                                <li><a href="#">Demo</a></li>
                                <li><a href="<?php echo base_url();?>blog">Blog</a></li>
								<li><a href="#">Let's Talk</a></li>
                            </ul>
                                  
                            <nav class="nav-custom hidden">
                                <div class="row ">
                                    <div class="col-md-4 ">
                                        <div class="trending-wrapper">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <a class="trend-app-btn color-blue" href="javascript:;">Download App</a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a class="trend-app-btn"  href="javascript:;">Get a Quote</a>
                                                </div>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8 center-block no-float">
                                                    <div class="bg-pattern">
                                                        <img class="img img-responsive pad-md" src="<?php echo base_url();?>assets/images/iphone-ax1-big-width.png" />
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-md-offset-1">
                                        <ul class="list-unstyled main-menu">
                                            <li class="text-right"><a href="javascript:;" id="nav-close">X</a></li>
                                            <li><a href="javascript:;" >Home</a>
                                            </li>
                                            <li><a href="javascript:;">About Us</a>
                                                <ul class="list-unstyled sub-nav-block md-mt-23 list-inline" data-index="0" style="display: none;">
                                                    <li class="sub-nav"><a href="javascript:;"><h4>Our Profile</h4></a></li>
                                                    <li class="sub-nav"><a href="javascript:;"><h4>Our Team</h4></a></li>
                                                    <li class="sub-nav"><a href="javascript:;"><h4>Our Awards</h4></a></li>
                                                </ul>                                               
                                            </li>
                                            <li><a href="javascript:;">Contact Us</a>
                                                <ul class="list-unstyled sub-nav-block md-mt-23" data-index="0" style="display: none;">
                                                    <li class="sub-nav"><a href="javascript:;">Our Locations</a></li>
                                                    <li class="sub-nav"><a href="javascript:;">Our Branches</a></li>
                                                    <li class="sub-nav"><a href="javascript:;">Our Head Office</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="javascript:;">Blog</a></li>
                                            <li><a href="javascript:;">Careers</a></li>
                                        </ul>                                        
                                    </div>                                    
                                </div>

                            </nav>                            
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 shrhleft">
                            <div class="bannermonitor pad-xl">
                            <div class="banner-contents">
                            <h1>Are you happy?</h1>
                            <h2>by using third party tool, its time to change into your own simplied HR Solution</h2>
                            <p>A complete packaged solution for all your needs, developed elegantly all the required modules for HR management, employee management and client management. Its focused on HR management, but still employees can take complete advantage of the text/voice/video chat functions, its a complete solution for your small office business.</p>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-6 buybtn"><a href="#get-quote" class="scroll-to">Buy Now</a></div>
                                <div class="col-xs-6 col-sm-4 col-md-6 demobtn"><a class="js-modal-btn" data-video-id="98spgfSPX-c"><span class="playicon"></span> Watch Video</a></div>
                            </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 shrhright">
                            <figure class="itemHeader__screens">
                                <img class="itemHeader__screen itemHeader__screen--1" src="<?php echo base_url();?>assets/images/shr-landing/screen-1.png" alt="Clean ui react interface screenshot" />
                                <img class="itemHeader__screen itemHeader__screen--2" src="<?php echo base_url();?>assets/images/shr-landing/screen-2.png" alt="Clean ui react interface screenshot" />
                                <img class="itemHeader__screen itemHeader__screen--3" src="<?php echo base_url();?>assets/images/shr-landing/screen-3.png" alt="Clean ui react interface screenshot" />
                            </figure>

                        </div>
                    </div>
                </div>
            </header>



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
                                    <p>Scale the employee’sactivities in one stop solution and derive the effective measure in the daily work. Effective measure in the daily work.</p>
                                </div>
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/employees-tab-img.jpg" alt="Employees - NewHRMS Dashboard" /></div>
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
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/payroll-tab-img.jpg" alt="Attendance - NewHRMS Dashboard" /></div>
                            </div>
                        </div>
                        <!-- Tab 2 -->
                        
                        <!-- Tab 3 -->
                        <div role="tabpanel" class="tab-pane" id="task">
                        	<div class="row">
                            	<div class="col-md-4">
                                	<h2>Task</h2>
                                    <h3>Managing employees projects and relavent tasks are key for your office</h3>
                                    <p>We provide a complete project/task solution for your office needs, with this you will be able to manage your employees projects/tasks and what they do daily.</p>
                                </div>
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/task-tab-img.jpg" alt="Task - NewHRMS Dashboard" /></div>
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
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/payroll-tab-img.jpg" alt="Payroll - NewHRMS Dashboard" /></div>
                            </div> 
                        </div>
                        <!-- Tab 4 -->
                        
                        <!-- Tab 5 -->
                        <div role="tabpanel" class="tab-pane" id="projects">
                            <div class="row">
                            	<div class="col-md-4">
                                	<h2>Projects</h2>
                                    <h3>Managing employees projects and relavent tasks are key for your office</h3>
                                    <p>Projects are linked with clients as well, so what employee does on tasks/projects directly reflects on the clients billing, its the effective way todo.</p>
                                </div>
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/projects-tab-img.jpg" alt="Projects - NewHRMS Dashboard" /></div>
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
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/event-tab-img.jpg" alt="Events - NewHRMS Dashboard" /></div>
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
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/clients-tab-img.jpg" alt="Clients - NewHRMS Dashboard" /></div>
                            </div> 
                        </div>
                        <!-- Tab 7 -->
                        
                        <!-- Tab 8 -->
                        <div role="tabpanel" class="tab-pane" id="chat">
                            <div class="row">
                            	<div class="col-md-4">
                                	<h2>Chat</h2>
                                    <h3>Text/voice/video chat are key tools</h3>
                                    <p>With a massive amount of tools online, its a must to keep the employees interacted with each other where ever they are, we help to achieve that.</p>
                                </div>
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/chat-tab-img.jpg" alt="Chat - NewHRMS Dashboard" /></div>
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
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/accounts-tab-img.jpg" alt="Accounts - NewHRMS Dashboard" /></div>
                            </div> 
                        </div>
                        <!-- Tab 9 -->
                        
                        <!-- Tab 10 -->
                        <div role="tabpanel" class="tab-pane" id="settings">
                            <div class="row">
                            	<div class="col-md-4">
                                	<h2>Settings</h2>
                                    <h3>You can tweek it how you like it to be</h3>
                                    <p>Our tools are more sophisticated that you will be able to customise it based on your needs, each and every modules with access control is somethin you'll love.</p>
                                </div>
                                <div class="col-md-8 text-right"><img src="<?php echo base_url();?>assets/images/shr-landing/settings-tab-img.jpg" alt="Settings - NewHRMS Dashboard" /></div>
                            </div> 
                        </div>
                        <!-- Tab 10 -->
                  </div>
            </div>
            
        </div>
    </div><!--shrsection-->

    <div class="shrsection pad-lg panel-screenshots">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-5">
                	<h2>Smart Dashboard</h2>
                    <p>Managing a small office and becoming an Entreprenour is not a simple task, but the journey is now begun, you need all the necessary tools to manage your office effectively.</p>
                    <p>With our smart dashboard option, you can swipe away all the things happening in your office in a single instant, now you'll be able to effectively manage your office</p>
                </div>
                <div class="col-sm-12 visible-sm visible-xs">
                	<img class="img img-responsive" src="<?php echo base_url();?>assets/images/smart-dashboard.png" alt="Smart Dashboard" />
                </div>
                <div class="col-md-6 col-md-offset-1 hidden-sm hidden-xs">
                            <div class="animate-grid-inner md-margin">
                                <div class="animate-grid-wrapper">
                                    <div class="animate-expanding-images">
                                        <div class="animate-expanding-images-inner hidden-xs">
                                            <img class="img img-responsive animate-frame-image" src="<?php echo base_url();?>assets/images/shr-landing/part-1.png" alt="admin panel" />
                                        </div>
                                        <div class="animate-side-images">
                                            <a style="" data-wow-delay="0.4s" class="animate-side-image-link">
                                                <div data-bottom="transform:translate3d(60%,25%,0)" data--150-bottom="transform:translate3d(0,0,0)"  class="scrollpoint sp-effect5 animate-side-image animate-side-image-1 animate-lazy-image animate-side-image-inner skrollable skrollable-after" style="background-image: url('<?php echo base_url();?>assets/images/shr-landing/part-2.png'); transform: translate3d(0px, 0px, 0px);"></div>
                                                <span class="align-one span-right visible-xs">Personalized Customer Support</span>
                                            </a>
                                            <a  data-wow-delay="0.4s" class="animate-side-image-link">
                                                <div data-100-bottom="transform:translate3d(60%,-25%,0)" data--50-bottom="transform:translate3d(0,0,0)" class="scrollpoint sp-effect5 animate-side-image animate-side-image-2 animate-lazy-image animate-side-image-inner skrollable skrollable-between" style="background-image: url('<?php echo base_url();?>assets/images/shr-landing/part-3.png'); transform: translate3d(12.6%, -4.5%, 0px);"></div>
                                                <span class="align-two span-left visible-xs">Trade with MT4</span>
                                            </a>
                                            <div class="clearfix visible-xs"></div>
                                            <a  data-wow-delay="0.4s" class="animate-side-image-link">
                                                <div data-bottom="transform:translate3d(-60%,25%,0)" data--150-bottom="transform:translate3d(0,0,0)" class="scrollpoint sp-effect5 animate-side-image animate-side-image-3 animate-lazy-image animate-side-image-inner skrollable skrollable-after" style="transform: translate3d(0px, 0px, 0px); background-image: url('<?php echo base_url();?>assets/images/shr-landing/part-4.png');"></div>
                                                <span class="align-three span-right visible-xs">Low Costs</span>
                                            </a>
                                            <a  data-wow-delay="0.4s" class="animate-side-image-link">
                                                <div data-bottom="transform:translate3d(-60%,25%,0)" data--150-bottom="transform:translate3d(0,0,0)" class="scrollpoint sp-effect5 animate-side-image animate-side-image-4 animate-lazy-image animate-side-image-inner skrollable skrollable-after" style="transform: translate3d(0px, 0px, 0px); background-image: url('<?php echo base_url();?>assets/images/shr-landing/part-5.png');"></div>
                                                <span class="align-three span-right visible-xs">Low Costs</span>
                                            </a>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div><!--shrgrey-->
    
    
    <div class="shrsection hlightsection pad-lg">
    	<div class="container">
        	<h1 class="text-center">Special Highlights</h1>
            <div class="row">
            	<div class="col-md-4 col-sm-6 col-xs-6 hlightbox">
                	<p class="text-center"><img src="<?php echo base_url();?>assets/images/icon-grid-1.png" /></p>
                    <p>Complete solution with mobile applications (Android/iOS)</p>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 hlightbox">
                	<p class="text-center"><img src="<?php echo base_url();?>assets/images/icon-grid-2.png" /></p>
                    <p>Responsive tool to be viewed in all devices</p>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 hlightbox">
                	<p class="text-center"><img src="<?php echo base_url();?>assets/images/icon-grid-3.png" /></p>
                    <p>Customizable solution with module access control</p>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 hlightbox">
                	<p class="text-center"><img src="<?php echo base_url();?>assets/images/icon-grid-4.png" /></p>
                    <p>Tasks/Projects from employees to clients</p>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 hlightbox">
                	<p class="text-center"><img src="<?php echo base_url();?>assets/images/icon-grid-5.png" /></p>
                    <p>Smart dashboard for effective reporting</p>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 hlightbox">
                	<p class="text-center"><img src="<?php echo base_url();?>assets/images/icon-grid-6.png" /></p>
                    <p>Text/Voice/Video chat to engage employees</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="shrsection shrorange pad-mini">
            <div class="container">
                <div class="row">
				<div class="col-sm-7 col-md-6 col-lg-5">
					<div class="web-app-blk">
						<h2>Are you Looking for a Web App version?</h2>
						<p>This is a Cross-platform, suitable for all Mobile platfrom like iOS, Android, Blackberry, Hybrid etc., Its included part of the package. We will customize and install it for you.</p>
						<a href="#get-quote" class="btn no-radius btn-outline btn-form scroll-to">Buy Now</a>
					</div>
				</div>
                    <div class="col-sm-5 col-md-6 col-lg-7">
                        <div class="web-app-img">
                            <img class="img img-responsive center-block" src="<?php echo base_url();?>assets/images/smarthr-landing/web-app-img.png" />
                        </div>

                    </div>
                </div>
            </div>
    </div>
    
    <div class="shrsection pricingcntr pad-lg">
    	<div id="get-quote" class="container">
        	<h1  class="text-center">Request Demo</h1>
            <p class="text-center">Please fill out the below form to get a best affordable quote</p>
            
            <div id="hrms-contact-box">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="hrms-contact-form">
                            <div class="contact-registration">
                                <form id="frm_contact" role="form" action="" autocomplete="off" method="POST">
                                    <div class="form-group">
                                    	<div class="switch-field">
                                            <input type="radio" id="radio-one" name="type" value="Demo" checked/>
                                            <label for="radio-one">Demo</label>
                                            <input type="radio" id="radio-two" name="type" value="Quote" />
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
                                    	<div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control" name="contactcompanyname" placeholder="Company name *"></div>
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
                                            <textarea class="form-control" id="contactmessage" name="contactmessage" placeholder="Write Your Message Here *" ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn no-radius btn-outline btn-form btn-lg" type="submit" value="submit">Submit</button>
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
                        <div class="col-md-3">
                            <div class="logo"><a href="https://dreamguys.co.in/" target="_blank"><img src="<?php echo base_url();?>assets/images/logo-white.png" /></a></div>
                            <ul class="social list-inline list-unstyled">
                                <li><a target="_blank" href="https://www.facebook.com/dreamguystech/"><i aria-hidden="true" class="fa fa-facebook"></i></a></li>
                                <li><a target="_blank" href="https://twitter.com/dreamguystech"><i aria-hidden="true" class="fa fa-twitter"></i></a></li>
                                <li><a target="_blank" href="https://www.linkedin.com/company/dreamguy's-technologies/"><i aria-hidden="true" class="fa fa-linkedin"></i></a></li>
                                <li><a target="_blank" href="https://plus.google.com/116124463035966526652"><i aria-hidden="true" class="fa fa-google-plus"></i></a></li>                   
                                <li><a target="_blank" href="https://www.youtube.com/channel/UCNi1cF0PYvQIg3uvxLrd3yA"><i aria-hidden="true" class="fa fa-youtube-play"></i></a></li>
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
                                Dagenham, UK</p>

                            <h3>India Location</h3>
                            <p>22, Sri Kanchi Nagar,<br />
                                Cheranmanagar,<br />
                                Coimbatore, India</p>

                            <h3>Malaysia Location</h3>
                            <p>Selangor,<br />
                                Malaysia 43300</p>
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
                                                        <div class="col-md-6 col-sm-6 col-xs-12"><input type="tel" class="form-control" name="price" placeholder="Price" readonly="" value="999" style="border-color: #cccccc;"></div>
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
                                                        <button class="btn no-radius btn-outline btn-form btn-lg" type="submit" value="submit">Pay with Paypal</button>
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
        <script src="<?php echo base_url();?>assets/js/waypoints.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/enquire.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/skrollr.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/wow.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/slick.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/admin_validation.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-modal-video.min.js"></script>
        <script type="text/javascript">
			
            enquire.register("screen and (min-width: 768px)", {

                match: function () {
                    var s = skrollr.init({
                        edgeStrategy: 'set',
                        easing: {
                            WTF: Math.random,
                            inverted: function (p) {
                                return 1 - p;
                            }
                        }
                    });
                },

                unmatch: function () {
                    var s = skrollr.destroy();
                },

                deferSetup: true,

            });
			
			var wow = new WOW({
                boxClass: 'animate', // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 100, // distance to the element when triggering the animation (default is 0)
                mobile: false        // trigger animations on mobile devices (true is default)
            });
            wow.init();
			
			$('.solutions-slick').slick({
            autoplay: true,
            arrows: false,
            dots: true,
            infinite: true,
            autoPlay: true,
            slidesToShow: 5,
            autoplaySpeed: 3000,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 910,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });


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
	
		//Scroll-Anchor
		$(document).ready(function () {
			
			$(".js-modal-btn").modalVideo({channel:'youtube'});
			
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
					$('#frm_contact')[0].reset();
				  $('#success_contact').css('display','');
				  setTimeout(function(){ 
					$('#success_contact').css('display','none');
				   }, 3500);
			}});
					 return false;
					}
				 
			});
		});
  
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
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