<div class="modal-dialog">
	<div class="modal-content">
		<!--<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Delete Reporter</h4>
		</div>-->
		
		<div class="modal-body">
		<?php $attributes = array('class' => 'bs-example form-horizontal','method' => 'post');
			echo form_open(base_url().'settings/roles_delete/'.$role_id); ?>
			<div class="form-head">
					<h3><?php echo lang('delete_role');?></h3>
					<p><?php echo lang('this_action_will_delete_role_from_list');?></p>
				</div>
 			<input type="hidden" name="role_id" value="<?=$role_id?>"> 
			<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn continue-btn"><?=lang('delete_button')?></button>
						</div>
						<div class="col-xs-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn cancel-btn"><?=lang('close')?></a>
						</div>
					</div>
				</div>
 		</div>
		<!--<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>-->
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->