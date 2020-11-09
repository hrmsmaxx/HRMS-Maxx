<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?=lang('add_designation')?></h4>
		</div>
		<?php $attributes = array('class' => 'bs-example','id'=>'settingsDesignationForm');
        echo form_open_multipart('all_departments/designations', $attributes); ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('all_departments')?> <span class="text-danger">*</span></label>
					<select name="department_id" id="department_id" required="required" class="form-control" >
						<option value="" selected disabled><?=lang('department')?></option>
						<?php
						$departments = $this -> db -> get('departments') -> result();
						if (!empty($departments)) { 
						foreach ($departments as $key => $d) { ?>
						<option value="<?php echo $d->deptid; ?>" <?php if($department_id == $d->deptid){ ?> selected <?php } ?>><?=$d->deptname?></option>
						<?php } }else{ ?>
						<option value=""><?=lang('no_results_found')?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label><?=lang('designation_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="designation" class="form-control" required>
				</div>
				<div class="form-group">
					<label><?=lang('grade')?> <span class="text-danger">*</span></label>
					<select name="grade" id="grade" required="required" class="form-control" >
						<option value="" selected disabled><?=lang('grade')?></option>
						<?php
						$grades = $this -> db -> get('grades') -> result();
						if (!empty($grades)) { 
						foreach ($grades as $key => $d) { ?>
						<option value="<?php echo $d->grade_id; ?>"><?=$d->grade_name?></option>
						<?php } }else{ ?>
						<option value=""><?=lang('no_results_found')?></option>
						<?php } ?>
					</select>
				</div>
				<div class="submit-section">
					<button id="settings_designation_submit" class="btn btn-primary submit-btn"><?=lang('submit')?></button>
				</div>
			</div>
		</form>
	</div>
</div>