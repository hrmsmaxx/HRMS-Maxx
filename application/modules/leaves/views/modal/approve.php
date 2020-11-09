<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-success">
			<button type="button" class="close" data-dismiss="modal">&times;</button> 
			<h4 class="modal-title"> Approve Leave </h4>
		</div>
		<?php echo form_open(base_url().'leaves/approve'); ?>
			<div class="modal-body">
				<p> Are you sure you want to approve this Leave Request?</p>
				<input type="hidden" name="req_leave_tbl_id" value="<?=$req_leave_tbl_id?>"> 
				<input type="hidden" name="approve" value="<?=$teamlead?>"> 
				<input type="text" name="reason" id="reason" placeholder="Reason" class="form-control" required>
			</div>
			<div class="modal-footer"> 
				 <button type="submit" class="btn btn-success"> Approve </button>
				 <a href="#" class="btn btn-danger" data-dismiss="modal"> Close </a>
			</div>
 		</form>
	</div>
</div>