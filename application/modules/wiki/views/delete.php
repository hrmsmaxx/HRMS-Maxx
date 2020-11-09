<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<?php echo form_open(base_url().'wiki/delete'); ?>
				<div class="form-head">
					<h3><?php echo lang('delete_wiki')?></h3>
					<p><?php echo lang('are_you_sure_want_to_delete')?>?</p>
				</div>
				<!-- <p><?=lang('delete_jobtypes_warning')?></p>				  -->
				<input type="hidden" name="id" value="<?php echo isset($id)?$id:''; ?>">
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn continue-btn"><?php echo lang('delete')?></button>
						</div>
						<div class="col-xs-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn cancel-btn"><?php echo lang('cancel')?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>