					
<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<h4 class="page-title m-b-0"><?php echo lang('recruiting_process');?></h4>
			<ul class="breadcrumb m-b-30 p-l-0" style="background:none; border:none;">
				<li><a href="<?php echo base_url(); ?>"><?php echo lang('home');?></a></li>
				<li><a href="<?php echo base_url(); ?>jobs/dashboard"><?php echo lang('recruiting_process');?></a></li>
				<li><?php echo lang('candidates_list');?></li>
			</ul>
		</div>
	</div>
	  <?php $this->load->view('sub_menus');?>
	<!--Canditates List-->
	<div class="card-box">

		<div class="row">
			<div class="col-sm-5 col-5">
				<h4 class="page-title"><?php echo lang('candidates_list');?></h4>
			</div>
			<div class="col-sm-7 col-7 text-right m-b-30">
				<a href="<?php echo base_url(); ?>jobs/add_candidates" class="btn add-btn"> <?php echo lang('add_candidates');?></a>

				<a href="<?php echo base_url(); ?>jobs/candidates_board" class="btn add-btn m-r-5"> <?php echo lang('board_view');?></a>

			</div>
		</div>
		<div class="table-responsive">
			<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo lang('name');?></th>
						<th><?php echo lang('mobile_number');?> </th>
						<th><?php echo lang('email')?></th>
						
						<th><?php echo lang('created_date')?></th>
						
						<th class="text-center"><?php echo lang('action')?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i=1;
					foreach($candidates_list as $list){
						?>
						<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo $list->first_name.' '.$list->last_name;?></td>
						<td><?php echo $list->phone_number;?></td>
						<td><?php echo $list->email?></td>
						<td><?php echo date('d-m-Y',strtotime($list->created_at));?></td>
						
						<td class="text-center">
							<a href="<?php echo site_url('jobs/add_candidates/'.$list->id); ?>" class="btn btn-sm btn-success"><i class="fa fa-edit "></i> </a>
							<a href="<?php echo site_url('jobs/delete_candidate/'.$list->id)?>" class="btn btn-sm btn-danger" data-toggle="ajaxModal"><i class="fa fa-trash-o"></i></a>
						</td>
					</tr>
						<?php 
					} ?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>

	<!--/Canditates List-->