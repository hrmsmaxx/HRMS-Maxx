<div class="modal-dialog" id="delete_contact">
	<div class="modal-content">
		<div class="modal-body">
			<form method="POST" action="<?php echo base_url(); ?>crm/lead_board_delete">
				<div class="form-head">
					<h3><?=lang('delete_lead_board'); ?></h3>
                    <p><?=lang('are_you_sure_want_to_delete'); ?></p>
				</div>
				
				<input type="hidden" name="task_board_id" value="<?=$task_board_id?>"> 
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn continue-btn" id="submit_delete_contact"><?=lang('delete'); ?></button>
						</div>
						<div class="col-xs-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn cancel-btn"><?=lang('cancel'); ?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>