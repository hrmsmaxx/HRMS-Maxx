<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 

<div class="content">
	<div class="panel panel-white">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-0"><?php echo lang('device_events_report');?></h4>
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
							<label><?php echo lang('rangeof_time');?></label>
							<div id="reportrange">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?php echo lang('device');?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?php echo lang('event');?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?php echo lang('type_of_event');?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button class="btn btn-success btn-md" type="submit"><?php echo lang('run_report');?></button>
						</div>
					</div>
				</div>
			</form>
			
			<table class="table table-striped custom-table datatable m-b-0 AppendDataTables">
				<thead>
					<tr>
						<th><?php echo lang('date');?></th>
						<th><?php echo lang('time');?></th>
						<th><?php echo lang('device');?></th>
						<th><?php echo lang('event');?></th>
						<th><?php echo lang('message');?></th>
						<th><?php echo lang('finished');?> </th>
						<th><?php echo lang('manual');?> </th>
						<th><?php echo lang('user');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>21/01/2020</td>
						<td>10:48:55</td>
						<td>1- 192.168.1.100</td>
						<td>Attendance log consumption</td>
						<td>34 attendance downloaded</td>
						<td>Yes</td>
						<td>No</td>
						<td>-</td>
					</tr>
					<tr>
						<td>22/01/2020</td>
						<td>10:45:32</td>
						<td>1- 192.168.1.100</td>
						<td>Attendance log consumption</td>
						<td>40 attendance downloaded</td>
						<td>Yes</td>
						<td>No</td>
						<td>-</td>
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