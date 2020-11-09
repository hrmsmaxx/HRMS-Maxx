<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<?php $attributes = array('class' => 'bs-example','method' => 'post'); echo form_open(base_url().'asset_categories/delete_sub_category/'.$des_details['sub_id']); ?>
				<div class="form-head">
					<h3><?php echo lang('delete_sub_category'); ?></h3>
					<p><?php echo lang('are_you_sure_want_to_delete'); ?></p>
				</div>
				<input type="hidden" name="sub_id" value="<?=$des_details['sub_id']?>"> 
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn btn-primary continue-btn"><?php echo lang('delete'); ?></button>
						</div>
						<div class="col-xs-6">
							<a class="btn btn-primary cancel-btn" data-dismiss="modal" href="javascript:void(0);"><?php echo lang('cancel'); ?></a>
						</div>
					</div>
				</div>
			</form>
 		</div>
	</div>
</div>