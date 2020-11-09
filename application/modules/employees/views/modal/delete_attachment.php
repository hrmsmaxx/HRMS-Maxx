

<div class="modal-dialog" id="delete_contact">
	<div class="modal-content">
		<div class="modal-body">
			<form method="POST" action="<?php echo base_url(); ?>employees/delete_attachment">
				<div class="form-head">
					<h3><?php echo lang('delete_attachment');?></h3>
                    <p><?php echo lang('are_you_sure_want_to_delete');?>?</p>
				</div>
				
				<input type="hidden" name="id" value="<?php echo $id;?>" id="id">
				<input type="hidden" name="user_id" value="<?php echo $user_id;?>" id="id">
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn continue-btn" id="submit_delete_contact"><?php echo lang('delete');?></button>
						</div>
						<div class="col-xs-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn cancel-btn"><?php echo lang('cancel');?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>