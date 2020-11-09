<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = lang('Add');
            if(isset($plan['id'])&&!empty($plan['id'])) 
            {  
				$form_type = lang('edit');
			}
            ?>
			<h4 class="modal-title"><?php echo $plan; ?> <?=lang('annual_incentive_plans')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example'); echo form_open_multipart('annual_incentive_plans/add', $attributes); 
			if(isset($plan['id'])&&!empty($plan['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $plan['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('annual_incentive_plans')?> <span class="text-danger">*</span></label>
					<input type="text" name="plan" class="form-control" value="<?php echo isset($plan['plan'])?$plan['plan']:''; ?>" required>
				</div>

				<div class="form-group">
					<?php 
						$active_selected = "selected";
						$inactive_selected = "";
							if(isset($plan['status'])&&$plan['status']==0)
							{
								$active_selected = "";
								$inactive_selected = "selected";
							}
					 ?>
					<select class="select2-option form-control" name="status" required> 								 
						<option value="1" <?php echo $active_selected;  ?> ><?=lang('active')?></option>
						<option value="0" <?php echo $inactive_selected;  ?> ><?=lang('in_active')?></option>
					</select>
				</div>

				<div class="submit-section">
					<button class="btn btn-primary submit-btn"><?=lang('submit')?></button>
				</div>
			</div>
		</form>
	</div>
</div>