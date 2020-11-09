<div class="content container-fluid">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title"><?=lang('budgets')?></h4>
		</div>
		<div class="col-sm-4  text-right m-b-20">     
              <a class="btn back-btn" href="<?=base_url()?>budgets"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
          </div>
	</div>
				<div class="card-box">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="row">
							<div class="col-md-12">
								<h4 class="page-title"><?=lang('add_budget')?></h4>
							</div>
							
						</div>
					</div>
                </div>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<form method="post" id="add_budget_form" action="<?php echo base_url(); ?>budgets/add_budgets">
							<div class="form-group">
								<label><?=lang('budget_title')?></label>
								<input class="form-control" type="text" name="budget_title" placeholder="<?=lang('budget_title')?>">
							</div>

								<label><?=lang('choose_budget_respect_type')?></label>
							<div class="form-group">
								<label class="radio-inline">
							      <input type="radio" name="budget_type" class="BudgetType" value="project"><?=lang('project')?>
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="budget_type" class="BudgetType" value="category"><?=lang('category')?>
							    </label>
							</div>

							<div class="form-group ProjecTS" style="display: none;">
								<label><?=lang('projects')?></label>
								<select name="projects" class="form-control" id="projects">
									<option value="" disabled selected><?=lang('choose_project')?></option>
									<?php foreach($projects as $project){ 
										if($project['subdomain_id'] == $this->session->userdata('subdomain_id')){
										?>
										<option value="<?php echo $project['project_id']; ?>"><?php echo $project['project_title']; ?></option>
									<?php } } ?>
									<!-- <option value="2">Category 2</option>
									<option value="3">Category 3</option> -->
								</select>
							</div>

							<div class="form-group CategorY" style="display: none;">
								<label><?=lang('category')?></label>
								<select name="category" class="form-control" id="main_category">
									<option value="" disabled selected><?=lang('choose_category')?></option>
									<?php foreach($categories as $category){ 
											if($category['subdomain_id'] == $this->session->userdata('subdomain_id')){
										?>
										<option value="<?php echo $category['cat_id']; ?>"><?php echo $category['category_name']; ?></option>
									<?php } } ?>
									<!-- <option value="2">Category 2</option>
									<option value="3">Category 3</option> -->
								</select>
							</div>
							<div class="form-group SUbCategorY" style="display: none;">
								<label><?=lang('sub_category')?></label>
								<select name="sub_category" class="form-control" id="sub_category">
									<option value="" disabled selected><?=lang('choose_sub_category')?></option>
								</select>
							</div>
							<div class="form-group">
								<label><?=lang('start_date')?></label>
								<div class="cal-icon"><input class="form-control datetimepicker" type="text" name="budget_start_date" placeholder="<?=lang('start_date')?>" data-date-format="dd-mm-yyyy"></div>
							</div>
							<div class="form-group">
								<label><?=lang('end_date')?></label>
								<div class="cal-icon"><input class="form-control datetimepicker" type="text" name="budget_end_date" placeholder="<?=lang('end_date')?>" data-date-format="dd-mm-yyyy"></div>
							</div>

							<div class="form-group">
								<label><?=lang('expected_revenues')?></label>
							</div>
							<div class="AllRevenuesClass">
								<div class="row AlLRevenues">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?=lang('revenue_title')?> <span class="text-danger">*</span></label>
											<input type="text" class="form-control RevenuETitle" value="" placeholder="<?=lang('revenue_title')?>" name="revenue_title[]" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
											<label><?=lang('revenue_amount')?> <span class="text-danger">*</span></label>
											<input type="text" name="revenue_amount[]" placeholder="<?=lang('revenue_amount')?>" value="" class="form-control RevenuEAmount" autocomplete="off" >
										</div>
									</div>
									<div class="col-sm-1">
										<div class="add-more">
											<a class="add_more_revenue" title="<?=lang('add_revenue')?>" style="cursor: pointer;" ><i class="fa fa-plus-circle"></i></a>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label><?=lang('overall_revenues')?> <span class="text-danger"><?=lang('formula_a')?></span></label>
								<input class="form-control" type="text" name="overall_revenues" id="overall_revenues" placeholder="<?=lang('overall_revenues')?>" readonly style="cursor: not-allowed;">
							</div>

							<div class="form-group">
								<label><?=lang('expected_expenses')?></label>
							</div>
							<div class="AllExpensesClass">
								<div class="row AlLExpenses">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?=lang('expenses_title')?> <span class="text-danger">*</span></label>
											<input type="text" class="form-control EXpensesTItle" value="" placeholder="<?=lang('expenses_title')?>" name="expenses_title[]" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
											<label><?=lang('expenses_amount')?> <span class="text-danger">*</span></label>
											<input type="text" name="expenses_amount[]" placeholder="<?=lang('expenses_amount')?>" value="" class="form-control EXpensesAmount" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-1">
										<div class="add-more">
											<a class="add_more_expenses" title="<?=lang('add_expenses')?>" style="cursor: pointer;"><i class="fa fa-plus-circle"></i></a>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label><?=lang('overall_expense')?> <span class="text-danger"><?=lang('formula_b')?></span></label>
								<input class="form-control" type="text" name="overall_expenses" id="overall_expenses" placeholder="<?=lang('overall_expense')?>" readonly style="cursor: not-allowed;">
							</div>


							<div class="form-group">
								<label><?=lang('expected_profit')?> <span class="text-danger"><?=lang('formula_c')?></span> </label>
								<input class="form-control" type="text" name="expected_profit" id="expected_profit" placeholder="<?=lang('expected_profit')?>" readonly style="cursor: not-allowed;">
							</div>

							<div class="form-group">
								<label><?=lang('tax')?> <span class="text-danger"><?=lang('formula_d')?></span></label>
								<input class="form-control" type="text" name="tax_amount" id="tax_amount" placeholder="<?=lang('tax_amount')?>">
							</div>

							<div class="form-group">
								<label><?=lang('budget_amount')?> <span class="text-danger"><?=lang('formula_e')?></span> </label>
								<input class="form-control" type="text" name="budget_amount" id="budget_amount" placeholder="<?=lang('budget_amount')?>" readonly style="cursor: not-allowed;">
							</div>
							<div class="m-t-20 text-center">
								<button class="btn btn-primary btn-lg BudgetAddBtn"><?=lang('submit')?></button>
							</div>
						</form>
					</div>
				</div>
				</div>
            </div>