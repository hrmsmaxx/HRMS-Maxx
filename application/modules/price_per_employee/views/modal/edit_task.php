<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			
			<h4 class="modal-title"><?=lang('edit_task')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $task = Item::view_task($id); $attributes = array('class' => 'bs-example form-horizontal','id'=>'itemsEditTask'); echo form_open(base_url().'items/edit_task',$attributes); ?>
			<div class="modal-body">
				<input type="hidden" name="template_id" value="<?=$task->template_id?>">
          		<div class="form-group">
					<label><?=lang('task_name')?> <span class="text-danger">*</span></label>
					
						<input type="text" class="form-control" value="<?=$task->task_name?>" name="task_name">
					
				</div>
				<div class="form-group">
					<label><?=lang('visible_to_client')?></label>
					
						<div class="checkbox">
							<label class="checkbox-custom">
								<input name="visible" <?php if($task->visible == 'Yes'){ echo "checked=\"checked\""; }?> type="checkbox"> <?=lang('yes')?>
							</label>
						</div>
					
				</div>
				<div class="form-group">
					<label><?=lang('estimated_hours')?> <span class="text-danger">*</span></label>
					
						<input type="text" class="form-control" value="<?=$task->estimate_hours?>" name="estimate">
					
				</div>
				<div class="form-group">
					<label><?=lang('description')?> <span class="text-danger">*</span></label>
				
						<textarea name="description" class="form-control ta" ><?=$task->task_desc?></textarea>
					
				</div>
			</div>
			<div class="modal-footer"> <a href="#" class="btn btn-danger" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-success" id="items_edit_task"><?=lang('save_changes')?></button>
			</div>
		</form>
	</div>
</div>