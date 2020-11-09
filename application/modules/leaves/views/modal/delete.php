<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger">
			<button type="button" class="close" data-dismiss="modal">&times;</button> 
			<h4 class="modal-title"> <?php echo lang('delete_leave');?> </h4>
		</div>
		<?php echo form_open(base_url().'leaves/delete'); ?>
			<div class="modal-body">
				<p><?php echo lang('are_you_sure_want_delete_this_leave_request');?></p>
				<input type="hidden" name="req_leave_tbl_id" value="<?=$req_leave_tbl_id?>"> 
				<input type="text" name="reason" id="reason" placeholder="Reason" class="form-control" required>
			</div>
			<div class="modal-footer"> 
				<button type="submit" class="btn btn-danger"> <?php echo lang('delete');?>  </button>
				<a href="#" class="btn btn-default" data-dismiss="modal"> <?php echo lang('close');?> </a>
			</div>
 		</form>
	</div>
</div>