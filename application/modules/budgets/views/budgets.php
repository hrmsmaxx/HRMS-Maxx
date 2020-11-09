<div class="content container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?php echo lang('budgets');?></h4>
		</div>
	</div>
  <?php $this->load->view('sub_menus');?>
          <div class="card-box">
          <div class="row">
            <div class="col-sm-12 text-right m-b-30">
              <a class="btn btn-primary rounded" href="<?php echo base_url(); ?>budgets/add_budgets"><i class="fa fa-plus"></i> <?=lang('add_budget')?></a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                  <thead>
                    <tr>
                      <th><?=lang('budget_no')?></th>
                      <th><?=lang('budget_title')?></th>
                      <th><?=lang('budget_type')?></th>
                      <!-- <th>Project Name</th>
                      <th>Category Name</th>
                      <th>SubCategory Name</th> -->
                      <th><?=lang('start_date')?></th>
                      <th><?=lang('end_date')?></th>
                      <th><?=lang('total_revenue')?></th>
                      <th><?=lang('total_expenses')?></th>
                      <th><?=lang('tax_amount')?></th>
                      <th><?=lang('budget_amount')?></th>
                      <th class="text-right"><?=lang('action')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; foreach($budgets as $budget){ 
                      if($budget['project_id'] != 0){
                        $project = $this->db->get_where('projects',array('project_id'=>$budget['project_id']))->row_array();
                        $project_name = $project['project_title'];
                      }else{
                        $project_name = '-';
                      }

                      if(($budget['category_id'] != 0) && ($budget['sub_cat_id'] != 0)){
                        $category = $this->db->get_where('budget_category',array('cat_id'=>$budget['category_id']))->row_array();
                        $subcategory = $this->db->get_where('budget_subcategory',array('sub_id'=>$budget['sub_cat_id']))->row_array();
                        $category_name = $category['category_name'];
                        $subcategory_name = $subcategory['sub_category'];
                      }else{
                        $category_name = '-';
                        $subcategory_name = '-';
                      }

                      ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td style="text-align: center;"><?php echo $budget['budget_title']; ?></td>
                        <!-- <td><?php echo $project_name; ?></td>
                        <td><?php echo $category_name; ?></td>
                        <td><?php echo $subcategory_name; ?></td> -->
                        <td style="text-align: center;"><?php echo ucfirst($budget['budget_type']); ?></td>
                        <td style="text-align: center;"><?php echo date('d M Y',strtotime($budget['budget_start_date'])); ?></td>
                        <td style="text-align: center;"><?php echo date('d M Y',strtotime($budget['budget_end_date'])); ?></td>
                        <td style="text-align: center;"><?php echo $budget['overall_revenues']; ?></td>
                        <td style="text-align: center;"><?php echo $budget['overall_expenses']; ?></td>
                        <td style="text-align: center;"><?php echo $budget['tax_amount']; ?></td>
                        <td style="text-align: center;"><?php echo $budget['budget_amount']; ?></td>
                        <td class="text-right">
                          <div class="dropdown">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                            <ul class="dropdown-menu pull-right">
                              <li><a href="<?php echo base_url(); ?>budgets/edit_budgets/<?php echo $budget['budget_id']; ?>"><i class="fa fa-pencil m-r-5"></i> <?=lang('edit')?></a></li>
                              <li><a href="#" data-toggle="modal" data-target="#delete_budget<?php echo $budget['budget_id']; ?>"><i class="fa fa-trash-o m-r-5"></i> <?=lang('delete')?></a></li>
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

                 <?php foreach($budgets as $budget){ ?>
                    <div id="delete_budget<?php echo $budget['budget_id']; ?>" class="modal custom-modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content modal-md">
                          <div class="modal-header">
                            <h4 class="modal-title"><?=lang('delete_budget')?>( <?php echo $budget['budget_title']; ?> )</h4>
                          </div>
                          <form method="post" action="<?php echo base_url(); ?>budgets/delete_budget/<?php echo $budget['budget_id']; ?>">
                            <div class="modal-body">
                              <p><?=lang('are_you_sure_want_to_delete')?></p>
                              <div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
                                <button type="submit" class="btn btn-danger"><?=lang('delete')?></button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                <?php } ?>