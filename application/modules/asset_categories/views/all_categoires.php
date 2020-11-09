<div class="content">

	<div class="row">

		<div class="col-sm-12">

			<h4 class="page-title"><?=lang('categories')?></h4>

		</div>

	</div>	

  <?php $this->load->view('sub_menus');?>

          <div class="card-box">

	<div class="card-box">

		<div class="row">

			<div class="col-sm-12 text-right m-b-20">

				<a class="btn add-btn" href="<?=base_url()?>asset_categories/categoiress" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('add_categoires'); ?></a>

			</div>

		</div>

		<div class="row">

			<!-- Project Tasks -->

			<div class="col-lg-12">

					<div class="table-responsive">

						<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">

							<thead>

								<tr>

									<th>#</th>

									<th><?php echo lang('cat_name'); ?></th>

									<th><?php echo lang('sub_category_name'); ?></th>

									<th class="col-options no-sort text-right"><?=lang('action')?></th>

								</tr>

							</thead>

							<tbody>

								<?php 

								$categories = $this -> db -> get_where('asset_category',array('subdomain_id'=>$this->session->userdata('subdomain_id'))) -> result();

								if (!empty($categories)) {

									$j =1;

									foreach ($categories as $key => $d) { ?>

								<tr>

									<td>

										<?php echo $j; ?>

									</td>

									<td>

										<?=$d->category_name?>

									</td>

									<td>

										<?php $all_des = $this->db->get_where('asset_subcategory',array('cat_id'=>$d->cat_id))->result_array(); 

											if(count($all_des) != 0)

											{

												foreach($all_des as $des){

										?>

											<div><?php echo $des['sub_category']; ?></div>

										<?php } }else{ ?>

											<div>-</div>

										<?php } ?>



									</td>

									<td class="text-right">

										<a href="<?php echo base_url(); ?>asset_categories/view_sub_categories/<?=$d->cat_id?>" class="btn btn-info btn-xs">

											<?php echo lang('sub_category'); ?>

										</a>

										<a href="<?=base_url()?>asset_categories/edit_categories/<?=$d->cat_id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

											<i class="fa fa-edit"></i>

										</a>

										</a>

									</td>

								</tr>

								<?php $j++; } } else{ ?>

									<tr><td colspan="4"><?php echo lang('no_results_found'); ?></td></tr>

								<?php } ?>

							</tbody>

						</table>

					</div>

			</div>

			<!-- End Project Tasks -->

		</div>

	</div>

</div>