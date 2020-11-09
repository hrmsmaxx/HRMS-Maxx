
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			
			<h4 class="modal-title"><?=lang('new_tax_rate')?></h4>
			<button type="button" class="close custom-close" data-dismiss="modal">&times;</button> 
		</div>
		<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'taxrateAddForm'); echo form_open(base_url().'subscriber_invoices/tax_rates/add',$attributes); ?>
			<div class="modal-body">
				<div class="form-group">
					<label"><?=lang('tax_rate_name')?> <span class="text-danger">*</span></label>
				
						<input type="text" class="form-control" placeholder="<?=lang('vat')?>" name="tax_rate_name">
					
				</div>
				<div class="form-group">
					<label><?=lang('tax_rate_percent')?> <span class="text-danger">*</span></label>
					
						<input type="text" class="form-control" placeholder="12" name="tax_rate_percent" id="create_taxrate_percent">
						<div class="row">
						<div class="col-md-12">
						<label id="create_taxrate_error" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="tax_rate"><?=lang('percentage_invalid')?></label>
						<label id="create_taxrate_required" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="tax_rate"><?=lang('tax_percentage_required')?></label>
						</div>
						</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger custom-close" data-dismiss="modal"><?=lang('close')?></a> 
				<button type="submit" class="btn btn-success" id="taxrate_add_submit"><?=lang('save_changes')?></button>
			</div>
		</form>
	</div>
</div>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" type="text/javascript"></script> -->
<!-- <script>
	$(function() {
		$('.money').maskMoney();
	})
</script> -->
