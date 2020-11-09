<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger">
			
			<h4 class="modal-title"><?=lang('delete_item')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button> 
		</div>
		<?php echo form_open(base_url().'subscriber_items/delete_item'); ?>
			<div class="modal-body">
				<p><?=lang('delete_item_warning')?></p>
				<input type="hidden" name="r_url" value="<?=base_url()?>subscriber_items">
				<input type="hidden" name="item" value="<?=$item_id?>">
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-light" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
			</div>
		</form>
	</div>
</div>