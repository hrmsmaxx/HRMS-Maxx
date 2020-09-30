

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
		<title>Features</title>
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
                                <li class="hidden-xs"><a href="<?php echo base_url();?>" class="call-to-action">Back to Home</a></li>
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
                                                    <li><a href="<?php echo base_url();?>" onclick="closeNav()">Demo</a></li>
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
			

            <section id="about" class="pad-lg pos-r ">
                    <div class="container-fluid">
                      <div class="row">
                          <div class="col-sm-12 text-center">
                            <h2>Employee/ Attendance/ Leaves/Holiday/Timesheet</h2>
                          </div>
                      </div>
                      <div class="row vertical-align">
                        <div class="col-sm-12">


                            
                          <div class="owl-carousel features-carousel owl-theme features-custom-style">   


                                <div class="item"> 
                                  <div class="row vertical-align">
                                      <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                          <div class="features-blk-slide">
                                              
                                <div class="img-box shadow-lg">
                                      <div class="box-loader"> <span></span>
                                        <span></span>
                                        <span></span>
                                      </div>
                                      <img class="img-center" src="<?php echo base_url();?>assets/images/employ-banner-img.png" alt="">
                                    </div>
                                                
                                          </div>
                                        </div>
                                        
                        <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                            <div class="section-title mb-3">
                              <div class="title-effect">
                                <div class="bar bar-top"></div>
                                <div class="bar bar-right"></div>
                                <div class="bar bar-bottom"></div>
                                <div class="bar bar-left"></div>
                              </div>
                              <h3>Employee Management</h3>
                              <h2>Growth of every employee is the evident success of the organization.</h2>
                            </div>
                            <p class="text-black lead">Scale the employee's activities in one-stop solution and derive the effective measure in the daily work. Effective measure in daily work.</p>
                            <p class="text-black lead">Employees can be easily manageable. Each Individual data of employees will be archived in the server. Easy access to the All employees data with one touch option.</p>
                          </div>

                                  </div>
                                </div>



                                <div class="item"> 
                                    <div class="row vertical-align">
                                        <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                            <div class="features-blk-slide">
                                                
                                  <div class="img-box shadow-lg">
                                        <div class="box-loader"> <span></span>
                                          <span></span>
                                          <span></span>
                                        </div>
                                        <img class="img-center" src="<?php echo base_url();?>assets/images/attendance-slide-img.png" alt="">
                                      </div>
                                                  
                                            </div>
                                          </div>
                                          
                          <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                              <div class="section-title mb-3">
                                <div class="title-effect">
                                  <div class="bar bar-top"></div>
                                  <div class="bar bar-right"></div>
                                  <div class="bar bar-bottom"></div>
                                  <div class="bar bar-left"></div>
                                </div>
                                <h3>Attendance</h3>
                                <h2>Managing attendance is an immediate requirement for small offices.</h2>
                              </div>
                              <p class="text-black lead">Effectively managing attendance solution for your small offices will drastically improve the productivity of your office, we give the necessary tools to manage the attendance effectively.</p>
                              
                            </div>
  
                                    </div>
                                  </div>




                                  <div class="item"> 
                                      <div class="row vertical-align">
                                          <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                              <div class="features-blk-slide">
                                                  
                                    <div class="img-box shadow-lg">
                                          <div class="box-loader"> <span></span>
                                            <span></span>
                                            <span></span>
                                          </div>
                                          <img class="img-center" src="<?php echo base_url();?>assets/images/leave-slider-img.png" alt="">
                                        </div>
                                                    
                                              </div>
                                            </div>
                                            
                            <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                                <div class="section-title mb-3">
                                  <div class="title-effect">
                                    <div class="bar bar-top"></div>
                                    <div class="bar bar-right"></div>
                                    <div class="bar bar-bottom"></div>
                                    <div class="bar bar-left"></div>
                                  </div>
                                  <h3>Leave management</h3>
                                  <h2>Leave management is a critical HR process. Employees need to request time off from work, and supervisors approve or deny the leave based on the company policies and various laws.</h2>
                                </div>
                                <p class="text-black lead">Automating the leave management process will help to get rid of tedious HR activities. New HRMS helps organizations to speed up growth while reducing time and costs.</p>
                                <p class="text-black lead">Approve/Reject the leave with a single push.</p>
                                
                              </div>
    
                                      </div>
                                    </div>
                                    

                                    <div class="item"> 
                                        <div class="row vertical-align">
                                            <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                                <div class="features-blk-slide">
                                                    
                                      <div class="img-box shadow-lg">
                                            <div class="box-loader"> <span></span>
                                              <span></span>
                                              <span></span>
                                            </div>
                                            <img class="img-center" src="<?php echo base_url();?>assets/images/holiday-banner.png" alt="">
                                          </div>
                                                      
                                                </div>
                                              </div>
                                              
                              <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                                  <div class="section-title mb-3">
                                    <div class="title-effect">
                                      <div class="bar bar-top"></div>
                                      <div class="bar bar-right"></div>
                                      <div class="bar bar-bottom"></div>
                                      <div class="bar bar-left"></div>
                                    </div>
                                    <h3>Holiday Management</h3>
                                  </div>
                                  <p class="text-black lead">Holiday management can be a constant thorn in HR’s side. But if you nail your holiday process, you’ll be rewarded with happier employees, fewer disruptions, and a more focused and effective management team.
                                      An employer can add new holidays based on the region and national holiday.</p>
                                  
                                </div>
      
                                        </div>
                                      </div>
                                      

                                      <div class="item"> 
                                          <div class="row vertical-align">
                                              <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                                  <div class="features-blk-slide">
                                                      
                                        <div class="img-box shadow-lg">
                                              <div class="box-loader"> <span></span>
                                                <span></span>
                                                <span></span>
                                              </div>
                                              <img class="img-center" src="<?php echo base_url();?>assets/images/timesheet.png" alt="">
                                            </div>
                                                        
                                                  </div>
                                                </div>
                                                
                                <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                                    <div class="section-title mb-3">
                                      <div class="title-effect">
                                        <div class="bar bar-top"></div>
                                        <div class="bar bar-right"></div>
                                        <div class="bar bar-bottom"></div>
                                        <div class="bar bar-left"></div>
                                      </div>
                                      <h3>TimeSheet </h3>
                                    </div>
                                    <p class="text-black lead">A timesheet is a record of the amount of time an employee has spent at work, on a particular job, project or working for a specific client. This information could be recorded in a cloud system such as our Timesheet module.</p>
                                    <p class="text-black lead">By keeping track of the time an employee starts and finishes work, as well as any breaks they have taken, a timesheet can be used to calculate the employee’s pay for the day, week or month.</p>

                                  </div>
        
                                          </div>
                                        </div>                                      


				  
                        </div>  



                        </div>
                      </div>
                    </div>
                  </section>


                  <section id="about" class="pad-lg pos-r bg-grey">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                              <h2>Project/ Task/Payroll/ Reports</h2>
                            </div>
                        </div>
                      <div class="row vertical-align">
                        <div class="col-sm-12">
                            <div class="owl-carousel features-carousel owl-theme features-custom-style reverse-grid">   
                                  <div class="item"> 

                                    <div class="row vertical-align">

                                                 
                        <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                            <div class="features-blk-slide">
                                
                  <div class="img-box shadow-lg">
                        <div class="box-loader"> <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <img class="img-center" src="<?php echo base_url();?>assets/images/projects.png" alt="">
                      </div>
                            </div>


                          </div>

                                        <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content">
                                          <div class="section-title mb-3">
                                            <div class="title-effect">
                                              <div class="bar bar-top"></div>
                                              <div class="bar bar-right"></div>
                                              <div class="bar bar-bottom"></div>
                                              <div class="bar bar-left"></div>
                                            </div>
                                            <h3>Project Management</h3>
                                            <h2>Managing employees projects and relevant tasks are key for your office.</h2>
                                          </div>
                                          <p class="text-black lead">Projects are linked with clients as well, so what employee does on tasks/projects directly reflects on the clients billing, it's an effective way to do. Create, Track and Monitor projects in real time.</p>
                                          
                                        </div>
                           
                                    </div>
                                  </div>					   
                                  <div class="item"> 

                                    <div class="row vertical-align">

                                              
                            <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                            <div class="features-blk-slide">
                                
                  <div class="img-box shadow-lg">
                        <div class="box-loader"> <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <img class="img-center" src="<?php echo base_url();?>assets/images/task.png" alt="">
                      </div>
                            </div>


                          </div>


                                    <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                          <div class="section-title mb-3">
                                            <div class="title-effect">
                                              <div class="bar bar-top"></div>
                                              <div class="bar bar-right"></div>
                                              <div class="bar bar-bottom"></div>
                                              <div class="bar bar-left"></div>
                                            </div>
                                            <h3>Task Management</h3>
                                          </div>
                                          <p class="text-black lead">The smallest identifiable and essential piece of a job that serves as a unit of work, and as a means of differentiating between the various components of a project. Small stones to achieve project deadlines.</p>
                                          
                                        </div>
                             
                                  </div>		
                                </div>			   
                                  <div class="item"> 

                                    <div class="row vertical-align">

                                               
                                        <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                            <div class="features-blk-slide">
                                
                  <div class="img-box shadow-lg">
                        <div class="box-loader"> <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <img class="img-center" src="<?php echo base_url();?>assets/images/payroll.png" alt="">
                      </div>
                            </div>


                          </div>

                          <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                          <div class="section-title mb-3">
                                            <div class="title-effect">
                                              <div class="bar bar-top"></div>
                                              <div class="bar bar-right"></div>
                                              <div class="bar bar-bottom"></div>
                                              <div class="bar bar-left"></div>
                                            </div>
                                            <h3>Payroll</h3>
                                          </div>
                                          <p class="text-black lead">Payroll in the sense of "money paid to employees" plays a major role in a company for several reasons.
                                              Calculate salary in minutes and transfer it to employees' bank accounts directly from Paybooks.</p>

                                              <p class="text-black lead">It is an automated bulk salary slip generator, printing and sends slip by email featured software. Specially designed for maintaining staff/employee salary records register data in a proper manner at one place and print or email slip in PDF format at one click.</p>
                                          
                                        </div>
                             
                                    </div>
                                  </div>				   
                                  <div class="item"> 

                                    <div class="row vertical-align">

                                                  
                                        <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                            <div class="features-blk-slide">
                                
                  <div class="img-box shadow-lg">
                        <div class="box-loader"> <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <img class="img-center" src="<?php echo base_url();?>assets/images/report.png" alt="">
                      </div>
                            </div>


                          </div>

                          <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                          <div class="section-title mb-3">
                                            <div class="title-effect">
                                              <div class="bar bar-top"></div>
                                              <div class="bar bar-right"></div>
                                              <div class="bar bar-bottom"></div>
                                              <div class="bar bar-left"></div>
                                            </div>
                                            <h3>Reports</h3>
                                          </div>
                                          <p class="text-black lead">Business reports are a type of assignment in which you analyse a situation (either a real situation or a case study) and apply business theories to produce a range of suggestions for improvement.</p>
                                          <p class="text-black lead">Track your yearly, monthly and weekly revenue report in a flow.</p>


                                        </div>
                          
                                    </div>
                                  </div>
                          </div> 

                        </div>
                      </div>

                    </div>  
                  </section>            
                  


                  <section id="about" class="pad-lg pos-r ">
                      <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                              <h2>CRM/Accounts & Invoice/ Estimate</h2>
                            </div>
                        </div>
                        <div class="row vertical-align">
                          <div class="col-sm-12">
  
  
                              
                            <div class="owl-carousel features-carousel owl-theme features-custom-style">   
  
  
                                  <div class="item"> 
                                    <div class="row vertical-align">
                                        <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                            <div class="features-blk-slide">
                                                
                                  <div class="img-box shadow-lg">
                                        <div class="box-loader"> <span></span>
                                          <span></span>
                                          <span></span>
                                        </div>
                                        <img class="img-center" src="<?php echo base_url();?>assets/images/crm.png" alt="">
                                      </div>
                                                  
                                            </div>
                                          </div>
                                          
                          <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                              <div class="section-title mb-3">
                                <div class="title-effect">
                                  <div class="bar bar-top"></div>
                                  <div class="bar bar-right"></div>
                                  <div class="bar bar-bottom"></div>
                                  <div class="bar bar-left"></div>
                                </div>
                                <h3>CRM</h3>
                                <h2>Reporting your productivity to your clients is the key.</h2>
                              </div>
                              <p class="text-black lead">For every successful business, reporting your productivity of your employees to your clients is the key to success, now its made easy.</p>
                              <p class="text-black lead">Business who may eventually become a client. lead also refers to the data that identifies an entity as a potential buyer of a product or service. Manage Business, communication and assign staff for the project. Create ETA or deadlines and stick to the time.</p>
                              <p class="text-black lead">Business is the only asset to the business. So manage the leads on the go.</p>
                            </div>
  
                                    </div>
                                  </div>
  
  
  
                                  <div class="item"> 
                                      <div class="row vertical-align">
                                          <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                              <div class="features-blk-slide">
                                                  
                                    <div class="img-box shadow-lg">
                                          <div class="box-loader"> <span></span>
                                            <span></span>
                                            <span></span>
                                          </div>
                                          <img class="img-center" src="<?php echo base_url();?>assets/images/invoice.png" alt="">
                                        </div>
                                                    
                                              </div>
                                            </div>
                                            
                            <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                                <div class="section-title mb-3">
                                  <div class="title-effect">
                                    <div class="bar bar-top"></div>
                                    <div class="bar bar-right"></div>
                                    <div class="bar bar-bottom"></div>
                                    <div class="bar bar-left"></div>
                                  </div>
                                  <h3>Accounts & Invoice</h3>
                                </div>
                                <p class="text-black lead">All your accounts solution is managed in a single location including payroll of employees to client invoices and quotes, everything is now linked.</p>
                                <p class="text-black lead">Invoice for Even a small business. Create and send invoices and estimates, track time and expenses and accept online payments. Customise invoice format, and tax according to your business in invoice settings.</p>


                              </div>
    
                                      </div>
                                    </div>
  
  
  
  
                                    <div class="item"> 
                                        <div class="row vertical-align">
                                            <div class="col-lg-6 col-md-12 image-column features-slide features-left-blk">
                                                <div class="features-blk-slide">
                                                    
                                      <div class="img-box shadow-lg">
                                            <div class="box-loader"> <span></span>
                                              <span></span>
                                              <span></span>
                                            </div>
                                            <img class="img-center" src="<?php echo base_url();?>assets/images/estimate.png" alt="">
                                          </div>
                                                      
                                                </div>
                                              </div>
                                              
                              <div class="col-lg-6 col-md-12 md-mt-5 ml-auto features-grid-content">
                                  <div class="section-title mb-3">
                                    <div class="title-effect">
                                      <div class="bar bar-top"></div>
                                      <div class="bar bar-right"></div>
                                      <div class="bar bar-bottom"></div>
                                      <div class="bar bar-left"></div>
                                    </div>
                                    <h3>Estimate</h3>
                                  </div>
                                  <p class="text-black lead">An estimate is a document that you give to a customer, showing how much you expect to charge them for goods or services you're going to supply.</p>
                                  
                                </div>
      
                                        </div>
                                      </div>
            
                          </div>  
  
  
  
                          </div>
                        </div>
                      </div>
                    </section>
  
  
                    <section id="about" class="pad-lg pos-r bg-grey">
                      <div class="container-fluid">
                          <div class="row">
                              <div class="col-sm-12 text-center">
                                <h2>Settings/ Chats/ Assets</h2>
                              </div>
                          </div>
                        <div class="row vertical-align">
                          <div class="col-sm-12">
                              <div class="owl-carousel features-carousel owl-theme features-custom-style reverse-grid">   
                                    <div class="item"> 
  
                                      <div class="row vertical-align">

                                                      
                                          <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                              <div class="features-blk-slide">
                                  
                    <div class="img-box shadow-lg">
                          <div class="box-loader"> <span></span>
                            <span></span>
                            <span></span>
                          </div>
                          <img class="img-center" src="<?php echo base_url();?>assets/images/settings.png" alt="">
                        </div>
                              </div>
  
  
                            </div>

                            <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                            <div class="section-title mb-3">
                                              <div class="title-effect">
                                                <div class="bar bar-top"></div>
                                                <div class="bar bar-right"></div>
                                                <div class="bar bar-bottom"></div>
                                                <div class="bar bar-left"></div>
                                              </div>
                                              <h3>Settings</h3>
                                              <h2>You can tweak it how you like it to be</h2>
                                            </div>
                                            <p class="text-black lead">Our tools are more sophisticated that you will be able to customise it based on your needs, each and every module with access control is something you'll love.</p>
                                            
                                          </div>
                          
                                      </div>
                                    </div>					   
                                    <div class="item"> 
  
                                      <div class="row vertical-align">   

                                          <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                                              <div class="features-blk-slide">
                                                  
                                    <div class="img-box shadow-lg">
                                          <div class="box-loader"> <span></span>
                                            <span></span>
                                            <span></span>
                                          </div>
                                          <img class="img-center" src="<?php echo base_url();?>assets/images/chats.png" alt="">
                                        </div>
                                              </div>
                  
                  
                                            </div>
                                            <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                            <div class="section-title mb-3">
                                              <div class="title-effect">
                                                <div class="bar bar-top"></div>
                                                <div class="bar bar-right"></div>
                                                <div class="bar bar-bottom"></div>
                                                <div class="bar bar-left"></div>
                                              </div>
                                              <h3>Chatting within the product.</h3>
                                              <h2>Text/voice/video chat are key tools</h2>
                                            </div>
                                            <p class="text-black lead">With a massive amount of tools online, it's a must to keep the employees interacted with each other wherever they are, we help to achieve that.</p>
                                            
                                          </div>
                                     
                                      </div>
                                    </div>					   
                                    <div class="item"> 
  
                                      <div class="row vertical-align">

                                          <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                                              <div class="features-blk-slide">
                                                  
                                    <div class="img-box shadow-lg">
                                          <div class="box-loader"> <span></span>
                                            <span></span>
                                            <span></span>
                                          </div>
                                          <img class="img-center" src="<?php echo base_url();?>assets/images/assets.png" alt="">
                                        </div>
                                              </div>
                  
                  
                                            </div>

                                            <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                            <div class="section-title mb-3">
                                              <div class="title-effect">
                                                <div class="bar bar-top"></div>
                                                <div class="bar bar-right"></div>
                                                <div class="bar bar-bottom"></div>
                                                <div class="bar bar-left"></div>
                                              </div>
                                              <h3>Assets</h3>
                                            </div>
                                            <p class="text-black lead">You may choose to provide your employee with free use of your assets like accommodation, company cars or Vehicle. 'Free use' means that you allow your employees to use the asset without giving them ownership of it. </p>
  
                                          </div>
                                        
                                      </div>
                                    </div>				   
                                    <div class="item"> 
  
                                      <div class="row vertical-align">        

                                          <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 image-column features-slide features-left-blk">
                                              <div class="features-blk-slide">
                                                  
                                    <div class="img-box shadow-lg">
                                          <div class="box-loader"> <span></span>
                                            <span></span>
                                            <span></span>
                                          </div>
                                          <img class="img-center" src="<?php echo base_url();?>assets/images/highlight-features.png" alt="">
                                        </div>
                                              </div>
                  
                  
                                            </div>

                                            <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 md-mt-5 ml-auto features-grid-content ">
                                            <div class="section-title mb-3">
                                              <div class="title-effect">
                                                <div class="bar bar-top"></div>
                                                <div class="bar bar-right"></div>
                                                <div class="bar bar-bottom"></div>
                                                <div class="bar bar-left"></div>
                                              </div>
                                              <h3>Highlight Feature</h3>
                                              <h2>Facial Recognition</h2>
                                            </div>
                                            <p class="text-black lead">Biometric Time and Attendance System is a time clock that tracks some unique physical characteristics of each employee when they clock in or out. In which we are using face recognition as a Unique ID.
                                                In-App Face recognition which employee can enrol their own attendance. The app is available in both Android and iOS</p>
                                          </div>
                                
                                      </div>
                                    </div>
                            </div> 
  
                          </div>
                        </div>
  
                          
                        </div>
                    </section>                     
                  
      <footer class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-3 sm-mb-41">
                  <div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo-white-footer.png" /></a></div>
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
		
		
		<script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/main.js"></script>
		<script src="<?php echo base_url();?>assets/js/custom.js"></script>
		

			
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

       	</body>
</html>