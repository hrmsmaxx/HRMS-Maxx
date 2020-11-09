<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title"><?=lang('add_categoires')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $attributes = array('class' => 'bs-example','id'=> 'settingsDepartmentForm'); echo form_open_multipart('categories/categoiress', $attributes); ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('category_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="category_name" class="form-control" required>
				</div>
				<div class="submit-section">
					<button class="btn btn-primary submit-btn"><?=lang('submit')?></button>
				</div>
			</div>
		</form>
	</div>
</div>