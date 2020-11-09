<?php 
$project_details = $this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
?>

<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title"><?=lang('project_gannt_chart');?></h4>
		</div>
		<div class="col-sm-4 text-right m-b-20">			
            <a class="btn back-btn" href="<?=base_url()?>projects"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
        </div>
	</div>
	<!-- Start Project Form -->
	<div class="card-box">
		<div class="contain">

    	<h2>
	    		<?=lang('project_name');?> : <?php echo $project_details['project_title']; ?>
	    	</h2>
	    	<?php if(count($task_list) == 0){  ?><p><?=lang('no_task_found');?></p> <?php }else{ ?>
				
				<!-- <div class="gantt"></div> -->
				<div id="chart_div"></div>
			<?php } ?>
		</div>
	</div>
	<!-- End Project Form -->
</div>