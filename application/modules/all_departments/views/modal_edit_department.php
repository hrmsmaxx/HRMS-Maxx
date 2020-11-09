<!-- Modal Dialog -->
<div class="modal-dialog">
	<!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title"><?=lang('edit_department')?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php
        if (!empty($dept_info)) {
            foreach ($dept_info as $key => $d) { ?>
                <?php
                $attributes = array('class' => 'bs-example');
                echo form_open(base_url().'settings/edit_dept',$attributes); ?>
                    <?php /* 
                        <div class="form-group">
                            <label><?=lang('branch_name')?> <span class="text-danger">*</span></label>
                            <select class="form-control select2-option" name="branch_id" id="branch_id" required>
                                <option value="" disabled><?=lang('select_branch')?></option>
                                <?php
                                if(!empty($branches))   {
                                    foreach ($branches as $branch){ ?>
                                        <option value="<?=$branch->id;?>" <?php if($branch->id == $d->branch_id) { echo 'selected'; } ?>><?=$branch->branch_name;?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div> */ ?>
                    <div class="modal-body">
                        <input type="hidden" name="deptid" value="<?=$d->deptid?>">
                        <div class="form-group">
                            <label><?=lang('department_name')?> <span class="text-danger">*</span></label>
							<input type="text" class="form-control" value="<?=$d->deptname?>" name="deptname">
                        </div>
                        <div class="form-group">
                            <label><?=lang('delete_department')?></label>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" name="delete_dept">
                                    <span></span>
                                </label>
                            </div>
                        </div>
						<div class="submit-section">
							<button type="submit" class="btn btn-primary submit-btn"><?=lang('save_changes')?></button>
						</div>
                    </div>
                </form>
        <?php } } ?>
    </div>
    <!-- /Modal Content -->
</div>
<!-- /Modal Dialog -->