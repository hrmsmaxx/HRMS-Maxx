<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = 'Add';
            if(isset($priority['id'])&&!empty($priority['id'])) 
            {  
				$form_type = 'Edit'; ?> 
     <?php  }
            ?>
			<h4 class="modal-title"><?php echo $form_type; ?> Priority</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example'); echo form_open_multipart('ticket_priority/add', $attributes); 
			if(isset($priority['id'])&&!empty($priority['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $priority['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('priority_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="priority" class="form-control" value="<?php echo isset($priority['priority'])?$priority['priority']:''; ?>" required placeholder="Priority Name" >
				</div>
				<div class="form-group">
					<label><?=lang('priority_hours')?> <span class="text-danger">*</span></label>
					<input type="text" name="hour" class="form-control" value="<?php echo isset($priority['hour'])?$priority['hour']:''; ?>" required placeholder="Priority Hours">
				</div>

				

				<div class="submit-section">
					<button class="btn btn-primary submit-btn">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>