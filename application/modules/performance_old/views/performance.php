<div class="content container-fluid">

	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title">Performance Configuration</h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="card-box">
				<ul class="nav nav-tabs nav-tabs-bottom">
					<li class="active"><a href="#okr_tab" data-toggle="tab">OKRs</a></li>
					<li><a href="#kpi_tab" data-toggle="tab">KPI</a></li>
					<li><a href="#smart_goals_tab" data-toggle="tab">Smart Goals</a></li>
					<li><a href="#compentency_tab" data-toggle="tab">Compentencies or BARS</a></li>
				</ul>

				<div class="tab-content">
				
					<!-- OKR Config -->
					<div class="tab-pane active" id="okr_tab">
						<div class="row">
							<div class="col-md-6">
								<form action="<?php echo base_url()?>performance/add_okr" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label>OKRs Description</label> 
										<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id')?>">
										<textarea rows="4" cols="5" class="form-control" name="okr_description" value=""></textarea>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" type="submit">Save</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /OKR Config -->
					
					<!-- KPI Config -->
					<div class="tab-pane" id="kpi_tab">
						KPI Content here
					</div>
					<!-- /KPI Config -->
					
					<!-- Smart Goal Config -->
					<div class="tab-pane" id="smart_goals_tab">
						<h4 class="m-b-20">Smart Goals Configuration</h4>
						<form>
							<div class="form-group">
								<label>Choose Your Rating Scale</label>
								<div class="radio_input" id="rating_scale_select">
									<label class="radio-inline custom_radio">
										<input type="radio" name="rating_scale" value="rating_1_5" checked>1 - 5 <span class="checkmark"></span>
									</label>
									<label class="radio-inline custom_radio">
										<input type="radio" name="rating_scale" value="rating_1_10">1 - 10 <span class="checkmark"></span>
									</label>
									<label class="radio-inline custom_radio">
										<input type="radio" name="rating_scale" value="custom_rating">Custom <span class="checkmark"></span>
									</label> 
								</div>
							</div>
							
							<!-- 5 Ratings Content -->
							<div class="form-group" id="5ratings_cont" style="display: none;">
								<label>Rating Scale Definition</label>
									<div class="table-responsive">
									<table class="table">
										<tbody>
											<tr>
												<td> 1 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 1">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 2 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 2">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 3 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 3">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 4 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 4">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 5 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 5">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- /5 Ratings Content -->
							
							<!-- 10 Ratings Content -->
							<div class="form-group" id="10ratings_cont" style="display: none;">
								<label>Rating Scale Definition</label>
									<div class="table-responsive">
									<table class="table">
										<tbody>
											<tr>
												<td> 1 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 1">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 2 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 2">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 3 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 3">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 4 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 4">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 5 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 5">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 6 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 6">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 7 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 7">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 8 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 8">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 9 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 9">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
											<tr>
												<td> 10 </td>
												<td>
													<input type="text" class="form-control" placeholder="Short word to describe rating of 10">
												</td>
												<td>
													<textarea rows="3" class="form-control" placeholder="Descriptive Rating Definition"></textarea>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- 10 Ratings Content -->
							
							<!-- Custom Ratings Content -->
							<div class="form-group" id="custom_rating_cont" style="display: none;">
								<label>Custom Rating Count</label>
								<div class="form-group">
									<input type="text" class="form-control" id="custom_rating_input" name="custom_rating_count" value="" placeholder="20" style="width: 160px;">
								</div>
								<label>Rating Scale Definition</label>
								<div class="table-responsive">
									<table class="table">
										<tbody class="custom-value">
										</tbody>
									</table>
								</div>
							</div>
							<!-- /Custom Ratings Content -->
							
							<div class="submit-section">
								<button class="btn btn-primary submit-btn" type="submit">Save</button>
							</div>
						</form>
					</div>
					<!-- /Smart Goal Config -->
					
					<!-- Compentency Config -->
					<div class="tab-pane" id="compentency_tab">
						Compentency content here
					</div>
					<!-- /Compentency Config -->
					
				</div>
			</div>
		</div>
	</div>
</div>