<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?php echo lang('sales');?></h4>
		</div>
	</div>
	<?php $this->load->view('sub_menus');?>
	<div class="card-box">
	<div class="row">
		<div class="col-sm-5 col-xs-6">
			<h4 class="page-title"><?=lang('estimates')?></h4>
		</div>
		<div class="col-sm-7 col-xs-6 text-right m-b-30">
			<?php
			if(User::is_admin() || User::perm_allowed(User::get_id(),'add_estimates')) { ?> 
			<a href="<?=base_url()?>estimates/add" class="btn btn-primary rounded pull-right"><i class="fa fa-plus"></i> <?=lang('create_estimate')?></a>
			<?php } ?>
		</div>
	</div>
	
	<div class="row filter-row">
						<div class="col-sm-3 col-xs-6">  
							<div class="form-group form-focus focused">
								<label class="control-label"><?=lang('from')?></label>
								<div class="cal-icon"><input class="form-control floating" type="text" id="estimates_from" name="estimates_from"></div>
								<label id="estimates_from_error" class="error display-none" for="estimates_from"><?=lang('from_date_not_empty')?></label>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6">  
							<div class="form-group form-focus">
								<label class="control-label"><?=lang('to')?></label>
								<div class="cal-icon"><input class="form-control floating" id="estimates_to" name="estimates_to" type="text"></div>
								<label id="estimates_to_error" class="error display-none" for="estimates_to"><?=lang('to_date_not_empty')?></label>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6"> 
							<div class="form-group form-focus select-focus">
								<label class="control-label"><?=lang('status')?></label>
								<select class="floating form-control" id="estimates_status" name="estimates_status"> 
									<option value="" selected="selected"><?=lang('all_status')?></option>
									<option value="Pending"><?=lang('pending')?></option>
									<option value="Accepted"><?=lang('accepted')?></option>
								</select> 
								<label id="estimates_status_error" class="error display-none" for="estimates_status"><?=lang('please_select_a_status')?></label>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6">  
				<a href="javascript:void(0)" class="btn btn-success btn-block" id="search_estimates_btn"> <?=lang('search')?> </a>  
						</div>     
                    </div>

	<div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
		<table id="table-estimates" class="table table-striped custom-table m-b-0">
			<thead>
				<tr>
					<th style="width:5px; display:none;"></th>
					<th style="width:5px; display:none;"></th>
					<th class=""><?=lang('estimate')?></th>
					<th class=""><?=lang('client_name')?></th>
					<!-- <th class=""><?=lang('branch_name')?></th> -->
					<th class=""><?=lang('status')?></th>
					<th class="col-date"><?=lang('due_date')?></th>
					<th class="col-date"><?=lang('created')?></th>
					<th class="col-currency"><?=lang('amount')?></th>
					<th class="text-right"><?=lang('action')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($estimates as $key => $e) {
					$branch = $this->db->select('branch_name')->get_where('branches', array('id'=>$e->branch_id, 'subdomain_id'=>$this->session->userdata('subdomain_id')))->row();

					if($e->subdomain_id == $this->session->userdata('subdomain_id')){
					$label = 'danger';
					if ($e->status == 'Pending'){ $label = "info"; }
					if($e->status == 'Accepted') { $label = "success";  }
				?>
				<tr>
					<td style="display:none;"><?=$e->est_id?></td>
					<td style="display:none;"><?=date('m/d/Y',strtotime($e->due_date));?></td>
					<td>
						<a class="text-info" href="<?=base_url()?>estimates/view/<?=$e->est_id?>">
							<?=$e->reference_no?>
						</a>
					</td>
					<td>
						<?php echo Client::view_by_id($e->client)->company_name; ?>
					</td>
					<!-- <td><?php //echo ($branch)?$branch->branch_name:'-';?></td> -->
					<td><span class="label label-<?=$label?>"><?=lang(strtolower($e->status))?> <?php if($e->emailed == 'Yes') { ?><i class="fa fa-envelope-o"></i><?php } ?></span></td>
					<td><?=strftime(config_item('date_format'), strtotime($e->due_date))?></td>
					<td><?=strftime(config_item('date_format'), strtotime($e->date_saved))?></td>
					<td class="col-currency">
						<?=Applib::format_currency($e->currency, Estimate::due($e->est_id));?>
					</td>
					<td class="text-right">
						<div class="dropdown">
							<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="fa fa-ellipsis-v"></i></a>
							<ul class="dropdown-menu pull-right">
								<?php if(User::is_admin() || User::perm_allowed(User::get_id(),'edit_estimates')) { ?>  
								<li><a href="<?=base_url()?>estimates/edit/<?=$e->est_id?>"><?=lang('edit_estimate')?></a></li>
								<li><a href="<?=base_url()?>estimates/timeline/<?=$e->est_id?>"><?=lang('estimate_history')?></a></li>
								<?php } ?>
								<?php if(User::is_admin() || User::perm_allowed(User::get_id(),'view_all_estimates')) { ?>  
								<li>
								<a href="<?=base_url()?>estimates/email/<?=$e->est_id?>" data-toggle="ajaxModal" 
								title="<?=lang('email_estimate')?>"><?=lang('email_estimate')?></a>
								</li>
								<?php } ?>
								<li>
								<a href="<?=base_url()?>estimates/view/<?=$e->est_id?>"><?=lang('view_estimate')?></a>
								</li>
								<?php if (config_item('pdf_engine') == 'invoicr') : ?>
								<li><a href="<?=base_url()?>fopdf/estimate/<?=$e->est_id?>"><?=lang('pdf')?></a></li>
								<?php elseif(config_item('pdf_engine') == 'mpdf') : ?>
								<li><a href="<?=base_url()?>estimates/pdf/<?=$e->est_id?>"><?=lang('pdf')?></a></li>
								<?php endif; ?>
							</ul>
						</div>
					</td>
				</tr>
				<?php } } ?>
			</tbody>
		</table>
		</div>
		</div>
	</div>
	</div>
</div>