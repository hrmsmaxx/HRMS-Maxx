<div class="content">

	<div class="row">

		<div class="col-sm-12">

			<h4 class="page-title"><?php echo lang('sales');?></h4>

		</div>

	</div>

	

	<?php $this->load->view('sub_menus');?>

	<div class="card-box">

		<ul class="nav nav-tabs nav-tabs-bottom page-sub-tabs">

			<!-- <li class="active"><a href="#task_templates" data-toggle="tab"><?=lang('project_tasks')?></a></li> -->

			<li class="active"><a href="#invoice_templates" data-toggle="tab"><?=lang('invoice_items')?></a></li>

		</ul>

	<div class="tab-content">

		<div class="tab-pane " id="task_templates">

				<div class="row">

					<div class="col-sm-4">

						<h3><?=lang('project_tasks')?></h3>

					</div>

					<div class="col-sm-8 text-right m-b-30">

						<a href="<?=base_url()?>items/save_task" class="btn btn-success pull-right m-r-10"><i class="fa fa-plus"></i> <?=lang('add_task')?></a>

					</div>

				</div>

				<div class="table-responsive">

					<table id="table-templates-1" class="table table-striped table-bordered AppendDataTables">

						<thead>

							<tr>

								<th><?=lang('task_name')?></th>

								<th><?=lang('visible')?> </th>

								<th><?=lang('estimated_hours')?> </th>

								<th class="col-options no-sort text-right"><?=lang('action')?></th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($project_tasks as $key => $task) { ?>

							<tr>

								<td>

									<a class="text-muted" href="#" data-original-title="<?=$task->task_desc?>" data-toggle="tooltip" data-placement="right"><?=$task->task_name?></a>

								</td>

								<td><?=$task->visible?></td>

								<td><strong><?=$task->estimate_hours?> <?=lang('hours')?></strong></td>

								<td class="text-right">

									<a href="<?=base_url()?>items/edit_task/<?=$task->template_id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

										<i class="fa fa-edit"></i>

									</a>

									<a href="<?=base_url()?>items/delete_task/<?=$task->template_id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal">

										<i class="fa fa-trash-o"></i>

									</a>

								</td>

							</tr>

							<?php } ?>

						</tbody>

					</table>

				</div>

		</div>

		

		<div class="tab-pane active" id="invoice_templates">

				<div class="row">

					<div class="col-sm-4">

						<h3><?=lang('invoice_items')?> </h3>

					</div>

					<div class="col-sm-8 text-right m-b-30">

						<a href="<?=base_url()?>items/add_item" class="btn btn-success pull-right m-r-10" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?=lang('new_item')?></a>

					</div>

				</div>

				<div class="table-responsive">

					<table id="table-templates-2" class="table table-striped table-bordered AppendDataTables">

						<thead>

							<tr>

								<th><?=lang('item_name')?></th>

								<th><?=lang('unit_price')?> </th>

								<th><?=lang('qty')?> </th>

								<th class="col-options no-sort text-right"><?=lang('action')?></th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($invoice_items as $key => $item) { 
									if($item->subdomain_id == $this->session->userdata('subdomain_id')){

								?>

							<tr>

								<td>

									<a class="text-muted" href="#" data-original-title="<?=$item->item_desc?>" data-toggle="tooltip" data-placement="left" title = "">

										<?=$item->item_name?>

									</a>

								</td>

								<td><?=Applib::format_currency(config_item('default_currency'), $item->unit_cost)?></td>

								<td><?=$item->quantity?></td>

								<td class="text-right">

									<a href="<?=base_url()?>items/edit_item/<?=$item->item_id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

										<i class="fa fa-edit"></i>

									</a>

									<a href="<?=base_url()?>items/delete_item/<?=$item->item_id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal">

										<i class="fa fa-trash-o"></i>

									</a>

								</td>

							</tr>

							<?php }  } ?>

						</tbody>

					</table>

				</div>

		</div>

	</div>

	</div>

</div>