<div class="page-wrapper">
    <div class="content container-fluid">
	<div class="card">
	<div class="card-body">
		<ul class="nav nav-tabs nav-tabs-bottom page-sub-tabs">

			<!-- <li class="active"><a href="#task_templates" data-toggle="tab"><?=lang('project_tasks')?></a></li> -->

			<li class="active"><a href="#invoice_templates" data-toggle="tab"><?=lang('price_per_employee')?></a></li>

		</ul>

	<div class="tab-content">

		<div class="tab-pane active" >

				<div class="row">

					<div class="col-sm-4">

						<h3><?=lang('add_price_per_employee')?> </h3>

					</div>

					<div class="col-sm-8 text-right m-b-30">

						
						<a href="#" class="btn btn-success pull-right m-r-10" data-toggle="modal" data-target="#add_price_per_employee"><i class="fa fa-plus"></i> <?=lang('add_price_per_employee')?></a>

					</div>

				</div>

				<div class="table-responsive">

					<table id="table-templates-3" class="table table-striped table-bordered AppendDataTables">

						<thead>

							<tr>

								<th><?=lang('plan1')?></th>
								<th><?=lang('plan2')?></th>
								<th><?=lang('plan3')?></th>
								<th><?=lang('employee_tier')?> </th>

								<th class="col-options no-sort text-right"><?=lang('action')?></th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($price_per_employee as $key => $item) { ?>

							<tr>

								

								<td><?php echo $item->plan1;?></td>
								<td><?php echo $item->plan2;?></td>
								<td><?php echo $item->plan3;?></td>
								<td><?php echo $item->employee_count;?></td>

								<td class="text-right">

									<a href="#" class="btn btn-success pull-right m-r-10" data-toggle="modal" data-target="#edit_price_per_employee_<?php echo $item->id?>"><i class="fa fa-edit"></i></a>

									<a href="#" class="btn btn-danger pull-right m-r-10" data-toggle="modal" data-target="#delete_price_per_employee_<?php echo $item->id?>">

										<i class="fa fa-trash-o"></i>

									</a>

								</td>

							</tr>

							<?php
							 // }
							   } ?>

						</tbody>

					</table>

				</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>

<!-- Add Plan price Modal -->
<div class="modal custom-modal fade" id="add_price_per_employee" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
			<div class="modal-body " style="padding:0;">
				<h5 class="modal-title text-center mb-3"><?php echo lang('add_price_per_employee');?></h5>
				<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'add_price_per_employees'); echo form_open(base_url().'price_per_employee/add_item',$attributes); ?>
					<div class="modal-body">
						<div class="form-group">
							<label><?=lang('plan1')?> <span class="text-danger">*</span></label>
							
								<input type="number" class="form-control" placeholder="<?=lang('plan1')?>" name="plan1">
						
						</div>
						<div class="form-group">
							<label><?=lang('plan2')?> <span class="text-danger">*</span></label>											
								<input type="number" class="form-control" placeholder="<?=lang('plan2')?>" name="plan2">
							
						</div>
						<div class="form-group">
							<label><?=lang('plan3')?> <span class="text-danger">*</span></label>
							
								<input type="number" class="form-control" placeholder="<?=lang('plan3')?>" name="plan3">
							
						</div>
						<div class="form-group">
							<label><?=lang('employee_tier')?> <span class="text-danger">*</span></label>
							
								<input type="number" class="form-control" placeholder="<?php echo $employee_tier?>" name="employee_count">
						
						</div>
						
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-close" data-dismiss="modal"><?=lang('close')?></a>
						<button type="submit" class="btn btn-success add_price_per_employee" ><?=lang('add_price_per_employee')?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Plan Price Modal -->
<!-- Edit Plan Price Modal -->
<?php foreach ($price_per_employee as $key => $item) { ?>
<div class="modal custom-modal fade" id="edit_price_per_employee_<?php echo $item->id?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
			<div class="modal-body">
				<h5 class="modal-title text-center mb-3"><?php echo lang('edit_price_per_employee');?></h5>
				<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'edit_price_per_employee_'.$item->id); echo form_open(base_url().'price_per_employee/edit_item',$attributes); ?>
				<input type="hidden" name="r_url" value="<?=base_url()?>price_per_employee">
			<input type="hidden" name="id" value="<?=$item->id?>">
					<div class="modal-body">
						<div class="form-group">
							<label><?=lang('plan1')?> <span class="text-danger">*</span></label>
							
								<input type="number" class="form-control" placeholder="<?=lang('plan1')?>" name="plan1" value="<?php echo $item->plan1 ?>" >
						
						</div>
						<div class="form-group">
							<label><?=lang('plan2')?> <span class="text-danger">*</span></label>											
								<input type="number" class="form-control" placeholder="<?=lang('plan2')?>" name="plan2" value="<?php echo $item->plan2 ?>">
							
						</div>
						<div class="form-group">
							<label><?=lang('plan3')?> <span class="text-danger">*</span></label>
							
								<input type="number" class="form-control" placeholder="<?=lang('plan3')?>" name="plan3" value="<?php echo $item->plan3 ?>">
							
						</div>
						<div class="form-group">
							<label><?=lang('employee_tier')?> <span class="text-danger">*</span></label>
							
								<input type="number" class="form-control" placeholder="<?php echo $employee_tier?>" name="employee_count" value="<?php echo $item->employee_count ?>">
						
						</div>
						
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-close" data-dismiss="modal"><?=lang('close')?></a>
						<button type="submit" class="btn btn-success edit_price_per_employee" data-id="<?php echo $item->id; ?>"  id=""><?=lang('edit_price_per_employee')?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!-- /Edit Plan Price Modal -->

<!-- Delete Plan Price Modal -->
<?php foreach ($price_per_employee as $key => $item) { ?>
<div class="modal custom-modal fade" id="delete_price_per_employee_<?php echo $item->id?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
			<div class="modal-body">
				<h5 class="modal-title text-center mb-3"><?php echo lang('delete_price_per_employee');?></h5>
				<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'delete_price_per_employeeItem'); echo form_open(base_url().'price_per_employee/delete_item',$attributes); ?>
				<input type="hidden" name="r_url" value="<?=base_url()?>price_per_employee">
			<input type="hidden" name="id" value="<?=$item->id?>">
					<div class="modal-body">
						<p><?=lang('delete_price_per_employee_warning')?></p>						
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-close" data-dismiss="modal"><?=lang('close')?></a>
						<button type="submit" class="btn btn-danger" id="delete_price_per_employee"><?=lang('delete_button')?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!-- /Delete Plan Price Modal -->
