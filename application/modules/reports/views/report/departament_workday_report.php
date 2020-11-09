<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 

<div class="content">
	<div class="panel panel-white">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-0">Departament Workday Report</h4>
				</div>
				<div class="col-sm-4 text-right">
					<a class="btn btn-white m-r-5" href="javascript: void(0);" id="filter_search">
						<i class="fa fa-filter m-r-0"></i>
					</a>
					<?=$this->load->view('report_header');?>
					<?php if($this->uri->segment(3) && count($employees)> 0 ){ ?>
					<a href="<?=base_url()?>reports/employeepdf/<?=$company_id;?>" class="btn btn-primary pull-right">
						<i class="fa fa-file-pdf-o"></i> <?=lang('pdf')?>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<form class="filter-form" id="filter_inputs" style="display:none;">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Departament</label>
							<select class="select form-control">
								<option>-</option>
								<option>Department 1</option>
								<option>Department 2</option>
							<select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Range of time</label>
							<div id="reportrange">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="d-block">&nbsp;</label>
							<button class="btn btn-success btn-md" type="submit">Run Report</button>
						</div>
					</div>
				</div>
			</form>
			
			
			<div class="page-header text-center m-t-0 border-none">
				<h3>Department - <span class="text-success">All</span></h3>
				<h5><span>From</span>&nbsp;March 01, 2020&nbsp;<span>To</span>&nbsp;March 13, 2020</h5>
			</div>

			<table class="table table-striped custom-table datatable m-b-0">
				<thead>
					<tr>
						<th>Workday</th>
						<th>Work Time</th>
						<th>Late Arrivals</th>
						<th>Missing Work</th>
						<th>Faulty Employee’s</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1 - Workday 1</td>
						<td>11:50</td>
						<td>00:10</td>
						<td>3:10</td>
						<td>Code 3</td>
					</tr>
					<tr>
						<td>1 - Workday 2</td>
						<td>15:00</td>
						<td>00:00</td>
						<td>0:00</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	var start = moment().subtract(29, 'days');
	var end = moment();

	$('#reportrange').daterangepicker({
		startDate: start,
		endDate: end,
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		   'This Month': [moment().startOf('month'), moment().endOf('month')],
		   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		}
	});
</script>