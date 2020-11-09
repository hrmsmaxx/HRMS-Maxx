<!-- Page Content  -->
                <div class="content container-fluid">
					<div class="row">
						<div class="col-xs-8">
							<h4 class="page-title"><?=lang('companies')?></h4>
						</div>
						<div class="col-sm-4 text-right m-b-20">			
				            <a class="btn back-btn" href="<?=base_url()?>companies"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
				        </div>
					</div>
					<div class="card-box">
					<!-- Page Title -->
					<div class="row">
						<div class="col-sm-12 text-right m-b-30">
							<a class="btn btn-primary rounded pull-right" href="<?=base_url()?>companies/create" data-toggle="ajaxModal" title="<?=lang('new_company')?>" data-placement="bottom">
								<i class="fa fa-plus"></i> <?=lang('new_company')?>
							</a>
							<div class="view-icons">
								<a href="<?php echo base_url(); ?>companies" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
								<a href="<?php echo base_url(); ?>companies/grid_companies" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
							</div>
						</div>
					</div>
					<!-- /Page Title -->
					
					<!-- Search Filter -->
					<div class="row filter-row">
						<form method="POST" action="<?php echo base_url()?>companies/grid_companies">
							<div class="col-lg-4 col-sm-6">  
								<div class="form-group form-focus">
									<label class="control-label"><?php echo lang('company');?></label>
									<input type="text" id="client_name_edit" name="client_name" class="form-control floating">
									<label id="client_name_error" class="error display-none" for="client_name"><?php echo lang('company_should_not_be_empty');?></label>
								</div>
							</div>
							<!-- <div class="col-lg-4 col-sm-6">  
								<div class="form-group form-focus">
									<label class="control-label">Email</label>
									<input type="text" id="client_email_edit" name="client_email" class="form-control floating">
									<label id="client_email_error" class="error display-none" for="client_email">Email field Shouldn't be empty</label>
								</div>
							</div> -->
							<div class="col-lg-4 col-sm-6">  
								<button type="submit" class="btn btn-success form-control p-0" id="client_search_grid"><?php echo lang('search');?></button>
								<!-- <a href="javascript:void(0)" id="client_search_grid" class="btn btn-success btn-block form-control" > <?php //echo lang('search');?> </a>   -->
							</div>
						</form>     
                    </div>
					<!-- Search Filter -->
					</div>
					
					<div class="row staff-grid-row">
						<?php
						if (!empty($companies)) {
						foreach ($companies as $client) { 

							if($client->subdomain_id == $this->session->userdata('subdomain_id')){
						$client_due = Client::due_amount($client->co_id);
						?>
							<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3 AllGridCompanies">
								<div class="profile-widget">
									<div class="profile-img">
										<a  href="<?php echo base_url(); ?>companies/view/<?php echo $client->co_id; ?>" class="avatar"><?php echo strtoupper($client->company_name[0]); ?></a>
										<span name="email_company" style="display: none;"><?php echo $client->company_email; ?></span>
									</div>
									<div class="dropdown profile-action">
										<a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="fa fa-ellipsis-v"></i></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="<?php echo base_url()?>companies/edit/<?=$client->co_id?>" data-toggle="ajaxModal" data-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> <?php echo lang('edit');?></a></li>
											<li><a href="<?php echo base_url()?>companies/delete/<?=$client->co_id?>" data-toggle="ajaxModal" data-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> <?php echo lang('delete');?></a></li>
										</ul>
									</div>
									<h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="<?php echo base_url(); ?>companies/view/<?php echo $client->co_id; ?>"><?=($client->company_name != NULL) ? $client->company_name : '...'; ?></a></h4>
									<h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="<?php echo base_url(); ?>companies/view/<?php echo $client->co_id; ?>"></a></h5>
									<!-- <div class="small text-muted">-</div> -->
									<a href="<?=base_url()?>companies/view/<?=$client->co_id?>" class="btn btn-white btn-sm m-t-10"><?php echo lang('view_profile');?></a>
								</div>
							</div>
						<?php } } } ?>
					</div>
                </div>
				<!-- /Page Content