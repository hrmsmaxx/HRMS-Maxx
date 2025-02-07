<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger">
			<button type="button" class="close" data-dismiss="modal">&times;</button> 
			<h4 class="modal-title"><?=lang('delete_invoice')?></h4>
		</div>
		<?php echo form_open(base_url().'invoices/delete'); ?>
			<div class="modal-body">
				<p><?=lang('delete_invoice_warning')?></p>
				<input type="hidden" name="invoice" value="<?=$invoice?>">
			</div>
			<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
			</div>
		</form>
	</div>
</div>