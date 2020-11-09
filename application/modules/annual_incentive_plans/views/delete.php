<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<?php echo form_open(base_url().'annual_incentive_plans/delete'); ?>
				<div class="form-head">
					<h3><?=lang('delete_plan')?></h3>
					<p><?=lang('are_you_sure_want_to_delete')?></p>
				</div>
				<p><?=lang('delete_plan_warning')?></p>				 
				<input type="hidden" name="plan" value="<?php echo isset($id)?$id:''; ?>">
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