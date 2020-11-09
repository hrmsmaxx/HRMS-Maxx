<?php
$i = Subscriber_invoice::view_by_id($id);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger">
			
			<h4 class="modal-title"><?=lang('cancel')?> <?=lang('invoice')?> #<?=$i->reference_no?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php echo form_open(base_url().'subscriber_invoices/cancel'); ?>
			<div class="modal-body">
				<p><?=lang('invoice')?> <?=$i->reference_no?> <?=lang('will_marked_as_cancelled')?></p>
				<input type="hidden" name="id" value="<?=$id?>">
			</div>
			<div class="modal-footer"> <a href="#" class="btn btn-danger" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-danger"><?=lang('cancelled')?></button>
			</div>
		</form>
	</div>
</div>