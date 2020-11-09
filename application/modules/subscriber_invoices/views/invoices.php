  <?php
    $invoice_settings = $this->db->get_where('subdomin_invoice_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

    $invoice_settings = unserialize($invoice_settings['invoice_settings']);

    $pdf_engine = $invoice_settings['pdf_engine']?$invoice_settings['pdf_engine']:config_item('pdf_engine');
?>

  <?php if($this->session->userdata('user_id') !=2){ ?>
          
    <div class="content">
       <?php  }else{ ?>
              <div class="page-wrapper" style="padding-top:35px"> 
    <div class="content container-fluid">
        <?php } ?>
	
	<!-- <div class="card-box"> -->
	<div class="row">
		<div class="col-sm-4 col-xs-3">
			<h4 class="page-title"><?=lang('invoices')?></h4>
		</div>
		<div class="col-sm-8 col-xs-9 text-right m-b-20">
			<?php if($this->session->userdata('user_id') ==2){ ?>
			<a href="<?=base_url()?>subscriber_invoices/add" class="btn btn-primary rounded float-right"><i class="fa fa-plus"></i> <?=lang('create_invoice')?></a>
		<?php } ?>
			<div class="btn-group float-right mr-2">
				<button class="btn btn-light">
				  <?php
				  $view = isset($_GET['view']) ? $_GET['view'] : NULL;
				  switch ($view) {
					case 'paid':
					  echo lang('paid');
					  break;
					case 'unpaid':
					  echo lang('not_paid');
					  break;
					case 'partially_paid':
					  echo lang('partially_paid');
					  break;
					case 'recurring':
					  echo lang('recurring');
					  break;

					default:
					  echo lang('filter');
					  break;
				  }
				  ?></button>
				 <button class="btn btn-light dropdown-toggle dropdown" data-toggle="dropdown"><span class="caret"></span></button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li class="dropdown-item"><a class="text-dark" href="<?=base_url()?>subscriber_invoices?view=paid"><?=lang('paid')?></a></li>
					<li class="dropdown-item"><a class="text-dark"  href="<?=base_url()?>subscriber_invoices?view=unpaid"><?=lang('not_paid')?></a></li>
					<li class="dropdown-item"><a class="text-dark"  href="<?=base_url()?>subscriber_invoices?view=partially_paid"><?=lang('partially_paid')?></a></li>
					<li class="dropdown-item"><a class="text-dark"  href="<?=base_url()?>subscriber_invoices?view=recurring"><?=lang('recurring')?></a></li>
					<li class="dropdown-item"><a class="text-dark"  href="<?=base_url()?>subscriber_invoices"><?=lang('all_invoices')?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="row filter-row">
						<div class="col-sm-3 col-xs-6">  
							<div class="form-group form-focus focused">
								<label class="control-label"><?=lang('from')?></label>
								<div class="cal-icon">
									<input class="form-control floating datetimepicker" id="invoice_date_from" type="text"></div>
									<label id="invoice_date_from_error" class="error display-none" for="invoice_date_from"><?=lang('from_date_not_empty')?></label>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6">  
							<div class="form-group form-focus focused">
								<label class="control-label"><?=lang('to')?></label>
								<div class="cal-icon">
									<input class="form-control floating datetimepicker" id="invoice_date_to" type="text"></div>
									<label id="invoice_date_to_error" class="error display-none" for="invoice_date_to"><?=lang('to_date_not_empty')?></label>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6"> 
							<div class="form-group form-focus select-focus">
								<label class="control-label"><?=lang('status')?></label>
								<select class="floating form-control" id="invoices_status" name="invoices_status"> 
									<option value="" selected="selected"><?=lang('all_invoices')?></option>
									<option value="paid"><?=lang('paid')?></option>
									<option value="Not"><?=lang('not_paid')?></option>
									<option value="Partial"><?=lang('partially_paid')?></option>
									<option value="Recurring"><?=lang('recurring')?></option>
								</select> 
								<label id="invoices_status_error" class="error display-none" for="invoices_status"><?=lang('please_select_a_status')?></label>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6">  
							<a href="javascript:void(0)" class="btn btn-success btn-block" id="tableinvoices_btn"> <?=lang('search')?> </a>  
						</div>     
                    </div>
</div>
</div>
<div class="card">
		<div class="card-body">
	<div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
		<table id="table-invoices" class="table table-striped custom-table m-b-0">
			<thead>
				<tr>
					<th style="width:5px; display:none;"></th>
					<th style="width:5px; display:none;"></th>
					<th style="width:5px; display:none;"></th>
					<th class=""><?=lang('invoice')?></th>
					<th class=""><?=lang('company_name')?></th>
					<th class=""><?=lang('status')?></th>
					<th class="col-date"><?=lang('due_date')?></th>
					<th class="col-currency"><?=lang('amount')?></th>
					<th class="col-currency"><?=lang('due_amount')?></th>
					<th class="text-center"><?=lang('action')?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($invoices as $key => &$inv) {
					// if($inv->subdomain_id == $this->session->userdata('subdomain_id')){
				$status = strtolower($inv->status);
				switch ($status) {
					case 'paid': $label2 = 'success';  break;
					case 'partially_paid': $label2 = 'warning'; break;
					case 'unpaid': $label2 = 'danger'; break;
					case 'cancelled': $label2 = 'primary'; break;
				}
				?>
				<tr class="<?=($inv->status == 'Cancelled') ? 'text-danger' : '';?>">
					<td style="display:none;"><?=$inv->inv_id?></td>
					<td style="display:none;"><?php echo date('m/d/Y',strtotime($inv->due_date)); ?></td>
					<td style="display:none;"><?php
						$status1 = explode('_', $status);
						$status1 = current($status1);
					 echo ucfirst($status1); ?></td>
					<td><a class="text-info" href="<?=base_url()?>subscriber_invoices/view/<?=$inv->inv_id?>">
							<?=$inv->reference_no?>
						</a></td>
					<td>
						<?php echo Subscriber_client::view_by_id($inv->client)->company_name; ?>
					</td>
					<td>
						<span class="label label-<?=$label2?>"><?=lang($status)?> <?php if($inv->emailed == 'Yes') { ?><i class="fa fa-envelope-o"></i><?php } ?></span>
						<?php if ($inv->recurring == 'Yes') { ?>
						<span class="label label-primary"><i class="fa fa-retweet"></i></span>
						<?php } ?>
					</td>
					<td><?=strftime(config_item('date_format'), strtotime($inv->due_date))?></td>
					<td class="col-currency">
						<?=Applib::format_currency($inv->currency, Subscriber_invoice::get_invoice_subtotal($inv->inv_id))?>
					</td>
					<td class="col-currency">
						<?=Applib::format_currency($inv->currency, Subscriber_invoice::get_invoice_due_amount($inv->inv_id));?>
					</td>
					<td class="text-center">
						<div class="dropdown">
							<a data-toggle="dropdown" class="action-icon text-dark" href="#"><i class="fa fa-ellipsis-v"></i></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li class="dropdown-item">
									<a class="text-dark" href="<?=base_url()?>subscriber_invoices/view/<?=$inv->inv_id?>">
										<?=lang('preview_invoice')?>
									</a>
								</li>
								<?php if($this->session->userdata('user_id') ==2){ ?>
								<li class="dropdown-item">
									<a class="text-dark" href="<?=base_url()?>subscriber_invoices/edit/<?=$inv->inv_id?>">
										<?=lang('edit_invoice')?>
									</a>
								</li>
								<?php }?>
								<li class="dropdown-item">
									<a class="text-dark" href="<?=base_url()?>subscriber_invoices/timeline/<?=$inv->inv_id?>">
										<?=lang('invoice_history')?>
									</a>
								</li>
								<!-- <li>
									<a href="<?=base_url()?>subscriber_invoices/send_invoice/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?=lang('email_invoice')?>">
										<?=lang('email_invoice')?>
									</a>
								</li>
								
								<li>
									<a href="<?=base_url()?>subscriber_invoices/remind/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?=lang('send_reminder')?>">
										<?=lang('send_reminder')?>
									</a>
								</li> -->
								<?php if($pdf_engine == 'invoicr') : ?>
								<li class="dropdown-item">
									<a class="text-dark" href="<?=base_url()?>fopdf/invoice/<?=$inv->inv_id?>"><?=lang('pdf')?></a>
								</li>
								<?php elseif($pdf_engine == 'mpdf') : ?>
								<li class="dropdown-item">
									<a class="text-dark" href="<?=base_url()?>subscriber_invoices/pdf/<?=$inv->inv_id?>"><?=lang('pdf')?></a>
								</li>
								<?php endif; ?>
								<?php if($this->session->userdata('user_id') ==2){ ?>
								<li class="dropdown-item">
									<a class="text-dark" href="<?= base_url() ?>subscriber_invoices/delete/<?= $inv->inv_id ?>" data-toggle="ajaxModal">
										<?=lang('delete_invoice')?>
									</a>
								</li>
								<?php }?>
								<!-- <li>
									<a data-invid="<?= $inv->inv_id ?>" data-target="#clone_invoice<?= $inv->inv_id ?>" data-toggle="modal">
										Clone Invoice
									</a>
								</li> -->
							</ul>
						</div>
					</td>
				</tr>
				<?php 
				// }
				 } ?>
			</tbody>
		</table>
		</div>
		</div>
	</div>
	</div>
	</div>
	<!-- </div> -->
	</div>
</div>
<?php foreach($invoices as $invoice){ 
	// if($invoice->subdomain_id == $this->session->userdata('subdomain_id')){
	?>

<div class="modal fade" id="clone_invoice<?= $invoice->inv_id ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><?=lang('clone_invoice')?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5><?=lang('do_you_clone_invoice')?>(<?= $invoice->reference_no ?>)?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('no')?></button>
        <button class="btn btn-primary clone_invoice_btn" data-invoice="<?= $invoice->inv_id ?>"><?=lang('yes')?></button>
      </div>
    </div>
  </div>
</div>
<?php
// }
 } ?>