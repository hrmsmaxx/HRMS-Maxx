<div class="content container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?=lang('all_assets')?></h4>
		</div>
	</div>
	<?php $this->load->view('sub_menus');?>	
	<!-- <div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li class="active"><a href="<?php echo base_url(); ?>all_assets">Asset Assignment</a></li>
			<li><a href="<?php echo base_url(); ?>logistics/stocks">Stock (Store)</a></li>
			<li><a href="<?php echo base_url(); ?>logistics/procurement">Procurement</a></li>
			<li><a href="<?php echo base_url(); ?>logistics/suppliers">Suppliers</a></li>
		</ul>
	</div> -->
					<div class="card-box">
					<div class="row">
						<div class="col-xs-8">
							<h4 class="page-title"><?=lang('all_assets')?></h4>
						</div>
						<div class="col-xs-4 text-right m-b-30">
							<a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#add_asset"><i class="fa fa-plus"></i> <?=lang('add_assets')?></a>
						</div>
					</div>
					<div class="row filter-row">
						<div class="col-lg-4 col-sm-6">  
							<div class="form-group form-focus">
								<!-- <label class="control-label">Category</label>							 -->
								<select name="category" class="form-control" id="category_name">
									<option value=""><?=lang('choose_category')?></option>
									<?php foreach($categories as $category){ ?>
										<option value="<?php echo $category['category_name']; ?>"><?php echo $category['category_name']; ?></option>
									<?php } ?>
									<!-- <option value="2">Category 2</option>
									<option value="3">Category 3</option> -->
								</select>
								<label id="category_name_error" class="error display-none" for="category_name"><?=lang('cat_not_empty')?></label>
							</div>
						</div>
						
						<div class="col-lg-4 col-sm-6 m-b-20">  
							<a href="javascript:void(0)" id="asset_search" class="btn btn-success btn-block form-control" > <?=lang('search')?> </a>  
						</div>     
                    </div>
					<!-- <div class="row filter-row">
						<div class="col-sm-3 col-xs-6">  
							<div class="form-group form-focus">
								<label class="control-label">Employee Name</label>
								<input type="text" class="form-control floating" />
							</div>
						</div>
						<div class="col-sm-3 col-xs-6"> 
							<div class="form-group form-focus select-focus">
								<label class="control-label">Status</label>
								<select class="select floating"> 
									<option value=""> -- Select -- </option>
									<option value="0"> Pending </option>
									<option value="1"> Approved </option>
									<option value="2"> Returned </option>
								</select>
							</div>
						</div>
						<div class="col-sm-4 col-xs-12">  
						   <div class="row">  
							   <div class="col-sm-6 col-xs-6">  
									<div class="form-group form-focus">
										<label class="control-label">From</label>
										<div class="cal-icon"><input class="form-control floating datetimepicker" type="text"></div>
									</div>
								</div>
							   <div class="col-sm-6 col-xs-6">  
									<div class="form-group form-focus">
										<label class="control-label">To</label>
										<div class="cal-icon"><input class="form-control floating datetimepicker" type="text"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-xs-6">  
							<a href="#" class="btn btn-success btn-block"> Search </a>  
						</div>     
                    </div> -->
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="table-assets" class="table table-striped custom-table m-b-0 datatable">
									<thead>
										<tr>
											<th>#</th>
											<th><?=lang('asset_user')?></th>
											<th><?=lang('asset_name')?></th>
											<th><?=lang('asset_id')?></th>
											<th><?=lang('cat_name')?></th>
											<th><?=lang('purchase_date')?></th>
											<th><?=lang('warranty_end')?></th>
											<th><?=lang('amount')?></th>
											<th class="text-center"><?=lang('status')?></th>
											<th class="text-center"><?=lang('action')?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach($all_assets as $assets){ 
											$user_det = $this->db->get_where('account_details',array('user_id'=>$assets['asset_user']))->row_array();
											$user_details= $this->db->get_where('users',array('id'=>$assets['asset_user']))->row_array();
											if(!empty($user_details['designation_id'])){
							                      $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
							                      $designation_name = $designation['designation'];
							                      
							                    }else{
							                      $designation_name = '-';
							                    }
											?>
										<tr>
											<td><?php echo $i; ?></td>
											<td>
												<div class="user_det_list">
								                    <a href="<?php echo base_url().'employees/profile_view/'.$assets['asset_user'];?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $user_det['avatar']?>"></a>
								                    <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
								                    <span class="userrole-info"> <?php echo $designation_name;?></span>
								                    <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
								                  </div>
								            </td>
											<td>
												<strong><?php echo $assets['asset_name']; ?></strong>
											</td>
											<td><?php echo $assets['reference_id']; ?></td>
											<td><?php echo !empty($assets['category_name'])?$assets['category_name']:'-';?></td>
											<td><?php echo date('d M Y',strtotime($assets['purchase_date'])); ?></td>

											<td><?php echo date('d M Y',strtotime($assets['warranty_date'])); ?></td>
											<td><?php echo $assets['assets_value']; ?></td>
											<?php  if($assets['status'] ==1){
												$status = lang('approved');
												$class ="text-success";
											} elseif ($assets['status'] ==2) {
												$status = lang('returned');
												$class ="text-info";
											}else{
												$status = lang('pending');
												$class ="text-danger";
											} ?>
											<td class="text-center">
												<div class="dropdown action-label">
													<a class="btn btn-white btn-sm rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-dot-circle-o <?php echo $class;?>"></i> <?php echo ' '.$status;?>  <i class="caret"></i>
													</a>
													<ul class="dropdown-menu pull-right">
														<li><a href="#"><i class="fa fa-dot-circle-o text-danger"></i> <?=lang('pending')?></a></li>
														<li><a href="#"><i class="fa fa-dot-circle-o text-success"></i> <?=lang('approved')?></a></li>
														<li><a href="#"><i class="fa fa-dot-circle-o text-info"></i> <?=lang('returned')?></a></li>
													</ul>
												</div>
											</td>
											<td class="text-center">
												<div class="dropdown">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
													<ul class="dropdown-menu pull-right">
														<li><a href="#" title="<?=lang('edit')?>" data-toggle="modal" data-target="#edit_asset<?php echo $assets['assets_id']; ?>"><i class="fa fa-pencil m-r-5"></i> <?=lang('edit')?></a></li>
														<li><a href="#" title="<?=lang('delete')?>" data-toggle="modal" data-target="#delete_asset<?php echo $assets['assets_id']; ?>"><i class="fa fa-trash-o m-r-5"></i> <?=lang('delete')?></a></li>
													</ul>
												</div>
											</td>
										</tr>
										<?php $i++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
                </div>
                
			<div id="add_asset" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?=lang('add_asset')?></h4>
						</div>
						<div class="modal-body">
							<form id="add_asset_form" method="post" action="<?php echo base_url(); ?>all_assets/add" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('asset_name')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="asset_name" id="asset_name" placeholder="<?=lang('asset_name')?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('asset_id')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" style="cursor: not-allowed;font-weight: 600;" name="reference_id" id="reference_id" value="<?php echo '#AST-'.rand(10,100000); ?>" readonly >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('category')?></label>
												<select name="category" class="form-control" id="asset_category">
													<option value="" disabled selected><?=lang('choose_category')?></option>
													<?php foreach($categories as $category){ ?>
														<option value="<?php echo $category['cat_id']; ?>"><?php echo $category['category_name']; ?></option>
													<?php } ?>
													<!-- <option value="2">Category 2</option>
													<option value="3">Category 3</option> -->
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group SUbCategorY">
												<label><?=lang('sub_category')?></label>
												<select name="sub_category" class="form-control" id="sub_category">
													<option value="" disabled selected><?=lang('choose_sub_category')?></option>
												</select>
											</div>
										</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('purchase_date')?><span class="text-danger">*</span></label>
											<input class="form-control datetimepicker" type="text" id="purchase_date" name="purchase_date" placeholder="<?=lang('purchase_date')?>" data-date-format='yyyy-mm-dd'>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('purchase_from')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="purchase_from" id="purchase_from" placeholder="<?=lang('purchase_from')?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('manufacturer')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" id="manufacture" name="manufacture" placeholder="<?=lang('manufacturer')?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('model')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="model" id="model" placeholder="<?=lang('model_name')?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('serial_number')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="serial_number" id="serial_number" placeholder="<?=lang('serial_number')?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('supplier')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="supplier" id="supplier" placeholder="<?=lang('supplier_name')?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('condition')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="asset_condition" id="asset_condition" placeholder="<?=lang('asset_condition')?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('warranty')?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" placeholder="<?=lang('warranty_date')?>" id="warranty_date" name="warranty_date" data-date-format='yyyy-mm-dd'>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('value')?><span class="text-danger">*</span></label>
											<input placeholder="$1800" class="form-control" type="text" name="assets_value" id="assets_value">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?=lang('asset_user')?><span class="text-danger">*</span></label>
											<select class="select2-option" style="width:100%;" name="asset_user" id="asset_user">
													<option value="" selected disabled><?=lang('users')?></option>
													<?php $all_users = $this->db->select('*')
																		         ->from('users U')
																		         ->join('account_details AD','U.id = AD.user_id')
																		         ->where('U.role_id',3)
																		         ->where('U.activated',1)
																		         ->where('U.banned',0)
																		         ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))
																		         ->get()->result_array();
															foreach ($all_users as $users) {
													?>
													<option value="<?php echo $users['user_id']; ?>"><?php echo $users['fullname']; ?></option>
												<?php } ?>
											</select>
											</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('image')?><span class="text-danger"></span></label>
											<input class="form-control" type="file" name="image" id="image">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('barcode')?><span class="text-danger"></span></label>
											<input placeholder="<?=lang('barcode')?>" class="form-control" type="text" name="barcode" id="barcode">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('qr_code')?><span class="text-danger"></span></label>
											<input placeholder="<?=lang('qr_code')?>" class="form-control" type="text" name="QR_code" id="QR_code">
										</div>
									</div>									
									
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('status')?><span class="text-danger">*</span></label>
											<select class="select2-option" style="width:100%;" name="status" id="status">
												<option value="" selected disabled><?=lang('status')?></option>
												<option value="pending"><?=lang('pending')?></option>
												<option value="approved"><?=lang('approved')?></option>
												<option value="retuned"><?=lang('retuned')?></option>
												<!-- <option value="damaged">Damaged</option> -->
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label><?=lang('description')?><span class="text-danger">*</span></label>
											<textarea class="form-control" name="description" id="description"></textarea>
										</div>
									</div>
									
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" id="add_btn_asset"><?=lang('add_asset')?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php foreach($all_assets as $asse){ ?>
			<div id="delete_asset<?php echo $asse['assets_id']; ?>" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('delete_asset')?></h4>
						</div>
							<div class="modal-body card-box">
								<p><?php echo lang('are_you_sure_want_to_delete'); ?></p>
								<div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
									<a href="<?php echo base_url(); ?>all_assets/delete/<?php echo $asse['assets_id']; ?>"  class="btn btn-danger"><?php echo lang('delete'); ?></a>
								</div>
							</div>
					</div>
				</div>
			</div>
			<div id="edit_asset<?php echo $asse['assets_id']; ?>" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><? echo lang('edit_asset'); ?></h4>
						</div>
						<div class="modal-body">
							<form id="edit_assets_form" method="POST" action="<?php echo base_url(); ?>all_assets/edit/<?php echo $asse['assets_id']; ?>" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><? echo lang('asset_name'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="asset_name" id="asset_name" placeholder="<? echo lang('asset_name'); ?>" value="<?php echo $asse['asset_name']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><? echo lang('asset_id'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" style="cursor: not-allowed;font-weight: 600;" name="reference_id" id="reference_id" value="<?php echo $asse['reference_id']; ?>" readonly >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('category')?></label>
												<select name="category" class="form-control" id="edit_asset_category">		
													<?php foreach($categories as $category){ ?>
														<option value="<?php echo $category['cat_id']; ?>" <?php echo ($asse['category'] == $category['cat_id'])?'selected':'';?>><?php echo $category['category_name']; ?></option>
													<?php } ?>
													<!-- <option value="2">Category 2</option>
													<option value="3">Category 3</option> -->
												</select>
											</div>
										</div>
										<?php $subcat = $this->db->get_where('asset_subcategory',array('sub_id'=>$asse['sub_category']))->row_array();

										 ?>
										<div class="col-md-6">
											<div class="form-group SUbCategorY">
												<label><?=lang('sub_category')?></label>
												<select name="sub_category" class="form-control" id="edit_sub_category">
													<option value="<?php echo $subcat['sub_id']; ?>" selected><?php echo $subcat['sub_category']; ?></option>
												</select>
											</div>
										</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('purchase_date'); ?><span class="text-danger">*</span></label>
											<input class="form-control datetimepicker" type="text" id="purchase_date" name="purchase_date" placeholder="<?php echo lang('purchase_date'); ?>" data-date-format='yyyy-mm-dd' value="<?php echo $asse['purchase_date']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('purchase_from'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="purchase_from" id="purchase_from" placeholder="<?php echo lang('purchase_from'); ?>" value="<?php echo $asse['purchase_from']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('manufacturer'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" id="manufacture" name="manufacture" placeholder="<?php echo lang('manufacturer'); ?>" value="<?php echo $asse['manufacture']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('model'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="model" id="model" placeholder="<?php echo lang('model_name'); ?>" value="<?php echo $asse['model']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('serial_number'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="serial_number" id="serial_number" placeholder="<?php echo lang('serial_number'); ?>" value="<?php echo $asse['serial_number']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('supplier'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="supplier" id="supplier" placeholder="<?php echo lang('supplier_name'); ?>" value="<?php echo $asse['supplier']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('condition'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="asset_condition" id="asset_condition" placeholder="<?php echo lang('asset_condition'); ?>" value="<?php echo $asse['asset_condition']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('warranty'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" placeholder="<?php echo lang('warranty_date'); ?>" id="warranty_date" name="warranty_date" data-date-format='yyyy-mm-dd' value="<?php echo $asse['warranty_date']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('value'); ?><span class="text-danger">*</span></label>
											<input placeholder="1800" class="form-control" type="text" name="assets_value" id="assets_value" value="<?php echo $asse['assets_value']; ?>">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php echo lang('asset_user'); ?><span class="text-danger">*</span></label>
											<select class="select2-option" style="width:100%;" name="asset_user" id="asset_user">
													<option value="" selected disabled><?php echo lang('users'); ?></option>
													<?php $all_users = $this->db->select('*')
																		         ->from('users U')
																		         ->join('account_details AD','U.id = AD.user_id')
																		         ->where('U.role_id',3)
																		         ->where('U.activated',1)
																		         ->where('U.banned',0)
																		         ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))
																		         ->get()->result_array();
															foreach ($all_users as $users) {
													?>
													<option value="<?php echo $users['user_id']; ?>" <?php if($asse['asset_user'] == $users['user_id']){ ?> selected <?php } ?> ><?php echo $users['fullname']; ?></option>
												<?php } ?>
											</select>
											</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('image'); ?> <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="image" id="image_edit" >
                                        <input class="form-control" type="hidden" name="avatar"  id= "image_edit" value="<?php echo $asse['image'];?>">
                                        <?php  if(!empty($asse['image'])){ ?>
                                        <img class="rounded-circle" alt="" src="<?php echo base_url()?>assets/uploads/<?php echo $asse['image'];?>">
                                        <?php  } ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('barcode'); ?><span class="text-danger"></span></label>
											<input placeholder="<?php echo lang('barcode'); ?>" class="form-control" type="text" name="barcode" id="barcode" value="<?php echo $asse['barcode']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('qr_code'); ?><span class="text-danger"></span></label>
											<input placeholder="<?php echo lang('qr_code'); ?>" class="form-control" type="text" name="QR_code" id="QR_code" value="<?php echo $asse['QR_code']; ?>">
										</div>
									</div>	
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('status'); ?> <?=$asse['status']?><span class="text-danger">*</span></label>
											<select class="select2-option" style="width:100%;" name="status" id="status">
												<option value="" selected disabled><?php echo lang('status'); ?></option>
												<option value="pending" <?php if($asse['status'] !=1 && $asse['status'] !=2){ ?> selected <?php } ?>><?php echo lang('pending'); ?></option>
												<option value="approved" <?php if($asse['status'] == 1){ ?> selected <?php } ?>><?php echo lang('approved'); ?></option>
												<option value="deployed" <?php if($asse['status'] == 2){ ?> selected <?php } ?>><?php echo lang('deployed'); ?></option>
												<!-- <option value="damaged" <?php if($asse['status'] == 'damaged'){ ?> selected <?php } ?>>Damaged</option> -->
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label><?php echo lang('description'); ?><span class="text-danger">*</span></label>
											<textarea class="form-control" name="description" id="description"><?php echo $asse['description']; ?></textarea>
										</div>
									</div>
									
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" id="edit_btn_asset"><?php echo lang('update_asset'); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>