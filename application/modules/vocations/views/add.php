<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = lang('Add');
            if(isset($vocation['id'])&&!empty($vocation['id'])) 
            {  
				$form_type = lang('edit'); 
			}
            ?>
			<h4 class="modal-title"><?php echo $vocation['vocation']?$vocation['vocation']:''; ?> <?=lang('vocation')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example'); echo form_open_multipart('vocations/add', $attributes); 
			if(isset($vocation['id'])&&!empty($vocation['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $vocation['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('vocation')?> <span class="text-danger">*</span></label>
					<input type="text" name="vocation" class="form-control" value="<?php echo isset($vocation['vocation'])?$vocation['vocation']:''; ?>" required>
				</div>

				<div class="form-group">
					<?php 
						$active_selected = "selected";
						$inactive_selected = "";
							if(isset($vocation['status'])&&$vocation['status']==0)
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