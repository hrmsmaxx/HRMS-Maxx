<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title"><?php echo lang('add_department')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $attributes = array('class' => 'bs-example','id'=> 'settingsDepartmentForm'); echo form_open_multipart('all_departments/departments', $attributes); ?>
			<div class="modal-body">
				<?php /* <div class="form-group">
					<label><?=lang('branch_name')?> <span class="text-danger">*</span></label>
					<select class="form-control select2-option" name="branch_id" id="branch_id" required>
						<option value="" selected disabled><?=lang('select_branch')?></option>
						<?php
						if(!empty($branches))	{
							foreach ($branches as $branch){ ?>
								<option value="<?=$branch->id;?>"><?=$branch->branch_name;?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div> */ ?>

				<div class="form-group">
					<label><?=lang('department_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="deptname" class="form-control" required>
				</div>
				<div class="submit-section">
					<button class="btn btn-primary submit-btn"><?php echo lang('submit')?></button>
				</div>
			</div>
		</form>
	</div>
</div>