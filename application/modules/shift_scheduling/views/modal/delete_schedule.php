<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<?php echo form_open(base_url().'shift_scheduling/delete_schedule'); ?>
				<div class="form-head">
					<h3><?=lang('delete_schedule')?></h3>
					<p><?=lang('sure_delete')?></p>
				</div>				
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="hidden" name="schedule_date" value="<?php echo $schedule_date?>">
				<input type="hidden" name="delete_type" value="<?php echo $delete_type?>">
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn continue-btn"><?=lang('delete')?></button>
						</div>
						<div class="col-xs-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn cancel-btn"><?=lang('cancel')?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>