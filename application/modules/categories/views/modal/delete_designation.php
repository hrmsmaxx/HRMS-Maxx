<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<?php $attributes = array('class' => 'bs-example','method' => 'post'); echo form_open(base_url().'all_departments/delete_designation/'.$des_details['id']); ?>
				<div class="form-head">
					<h3><?=lang('delete_designation')?></h3>
					<p><?=lang('are_you_sure_want_to_delete')?></p>
				</div>
				<input type="hidden" name="des_id" value="<?=$des_details['id']?>"> 
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn btn-primary continue-btn"><?=lang('delete')?></button>
						</div>
						<div class="col-xs-6">
							<a class="btn btn-primary cancel-btn" data-dismiss="modal" href="javascript:void(0);"><?=lang('cancel')?></a>
						</div>
					</div>
				</div>
			</form>
 		</div>
	</div>
</div>