<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title"><?php echo lang('holiday');?></h4>
		</div>
		<div class="col-sm-4 text-right m-b-20">			
            <a class="btn back-btn" href="<?=base_url()?>holidays/"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
        </div>
	</div>
   <div class="card-box">
   <div class="row">
	   <div class="col-md-6 col-md-offset-3">
			<h4 class="page-title"><?php echo lang('create_holiday');?></h4>
			<?php $attributes = array('class' => 'bs-example','id'=> 'employeeCreateHoliday'); echo form_open(base_url().'holidays/add',$attributes); ?> 
				<div class="form-group">
					<label><?php echo lang('holiday_title');?><span class="text-danger">*</span></label>
					<input type="text" class="form-control" value="" name="holiday_title">
				</div>
				<div class="form-group">
					<label><?php echo lang('holiday_date');?> <span class="text-danger">*</span></label>
					<input class="datepicker-input form-control" readonly size="16" type="text"  value="" name="holiday_date" data-date-format="dd-mm-yyyy" > 
					
				</div>
				<div class="form-group">
					<label><?php echo lang('holiday_description');?> <span class="text-danger">*</span></label>
					<textarea class="form-control" name="holiday_description"></textarea>
				</div>
				<div class="m-t-20 text-center">
					<button class="btn btn-primary" id="employee_create_holiday"><?php echo lang('create_holiday');?></button>
					<a href="<?php echo base_url().'holidays';?>" >
						<button class="btn btn-danger" type="button"> <?php echo lang('cancel');?> </button>
					</a>
				</div>
			</form>
	   </div>
   </div>
   </div>
</div>