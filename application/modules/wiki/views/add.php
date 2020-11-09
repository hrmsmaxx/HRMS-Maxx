<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = lang('Add');
            if(isset($wiki['id'])&&!empty($wiki['id'])) 
            {  
				$form_type = lang('edit'); ?> 
     <?php  }
            ?>
			<h4 class="modal-title"><?php echo $form_type; ?> <?php echo lang('wiki')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example'); echo form_open_multipart('wiki/add', $attributes); 
			if(isset($wiki['id'])&&!empty($wiki['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $wiki['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('title')?> <span class="text-danger">*</span></label>
					<input type="text" name="title" class="form-control" value="<?php echo isset($wiki['title'])?$wiki['title']:''; ?>" required>
				</div>
				<div class="form-group">
					<label><?=lang('description')?> <span class="text-danger">*</span></label>
					<textarea name ="description" class="form-control" required><?php echo isset($wiki['description'])?$wiki['description']:''; ?></textarea>
				</div>

				

				<div class="submit-section">
					<button class="btn btn-primary submit-btn"><?php echo lang('submit')?></button>
				</div>
			</div>
		</form>
	</div>
</div>