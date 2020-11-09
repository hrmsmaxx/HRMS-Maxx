<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger">
			<button type="button" class="close" data-dismiss="modal">&times;</button> 
			<h4 class="modal-title"><?php echo lang('delete_holiday');?></h4>
		</div>
		<?php echo form_open(base_url().'holidays/delete'); ?>
			<div class="modal-body">
				<p><?php echo lang('this_action_will_delete_holiday_from_list');?></p>
				<input type="hidden" name="holiday_tbl_id" value="<?=$holiday_id?>"> 
			</div>
			<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
			</div>
		</form>
	</div>
</div>