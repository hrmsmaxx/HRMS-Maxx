<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = lang('Add');
            if(isset($branch['id'])&&!empty($branch['id'])) 
            {  
				$form_type = lang('edit'); ?> 
     <?php  }
            ?>
			<h4 class="modal-title"><?php echo $form_type; ?> <?php echo lang('branch'); ?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example'); echo form_open_multipart('branches/add', $attributes); 
			if(isset($branch['id'])&&!empty($branch['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $branch['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('branch_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="branch_name" class="form-control" value="<?php echo isset($branch['branch_name'])?$branch['branch_name']:''; ?>" required>
				</div>
				<div class="form-group">
					<label><?=lang('location')?> <span class="text-danger">*</span></label>
					<input type="text" name="location" class="form-control" value="<?php echo isset($branch['location'])?$branch['location']:''; ?>" required>
				</div>

				<div class="form-group">
					<?php 
						$active_selected = "selected";
						$inactive_selected = "";
							if(isset($branch['status'])&&$branch['status']==0)
							{
								$active_selected = "";
								$inactive_selected = "selected";
							}
					 ?>
					 <label><?=lang('status')?> <span class="text-danger">*</span></label>
					<select class="select2-option form-control" name="status" required> 								 
						<option value="1" <?php echo $active_selected;  ?> ><?php echo lang('active');?></option>
						<option value="0" <?php echo $inactive_selected;  ?> ><?php echo lang('in_active');?></option>
					</select>
				</div>

				<div class="submit-section">
					<button class="btn btn-primary submit-btn"><?php echo lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>