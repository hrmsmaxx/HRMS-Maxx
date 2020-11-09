
    
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Subscription</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Subscription</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
						
						<!--Monthly Yearly Switch-->
							<div class="switch switch--horizontal">
								<input id="radio-a" type="radio" name="first-switch" checked="checked" onclick="show1();"/>
								<label for="radio-a">Monthly</label>
								<input id="radio-b" type="radio" name="first-switch" onclick="show2();"/>
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
											<a href="#" class="btn btn-primary btn-block">Subscribe Now </a>
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
											<a href="#" class="btn btn-primary btn-block">Subscribe Now </a>
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
											<a href="#" class="btn btn-primary btn-block">Subscribe Now </a>
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
											<a href="#" class="btn btn-primary btn-block">Subscribe Now </a>
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
											<a href="#" class="btn btn-primary btn-block">Subscribe Now </a>
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
											<a href="#" class="btn btn-primary btn-block">Subscribe Now </a>
											<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
										</div>
									</div>
								</div>
							</div>
							<!--Card3 -->
						</div>
					</div>
					
					<!--Plan Details Table-->
					<div class="row">
						<div  class="col-md-12">
							<div class="card">
								<div class="card-body">
								<h3 class="card-title text-left">Plan Transactions</h3>
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th scope="col">Plan Details</th>
													<th scope="col">Users</th>
													<th scope="col">Plan Duration</th>
													<th scope="col">Start Date</th>
													<th scope="col">End Date</th>
													<th scope="col">Amount</th>
													<th scope="col" class="text-center">Update Plan</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th>Starter Plan</th>
													<td>30 Users</td>
													<td>1 Month</td>
													<td>19 Apr 2019</td>
													<td>19 May 2019</td>
													<td>$200.00</td>
													<td class="text-center">
														<a href="#" class="btn btn-primary">Change Plan</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/Plan Details Table-->
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		