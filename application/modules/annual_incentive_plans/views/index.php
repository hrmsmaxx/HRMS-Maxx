<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?=lang('annual_incentive_plans')?></h4>
		</div>
	</div>
    <?php $this->load->view('sub_menus');?>
	<div class="card-box">
	<div class="row">
        <div class="col-sm-12 text-right m-b-30">
            <a href="<?php echo base_url()?>annual_incentive_plans/add/" class="btn add-btn" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?=lang('Add')?> <?=lang('annual_incentive_plans')?></a>
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
                                <th><?=lang('plans')?></th>                                 
                                <th><?=lang('status')?></th>
                                <th class="col-options no-sort text-right"><?=lang('action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                                      
                                if (!empty($plans)) 
                                {
                                    $j =1;
                                    foreach ($plans as $key => $plan) 
                                    { 
                                        $status = lang('active');
                                        if($plan->status==0)
                                        {
                                            $status = lang('in_active');
                                        }
                                        ?>
                                        <tr>
                                            <td> <?php echo $j; ?> </td>
                                            <td> <?=$plan->plan?> </td> 
                                            <td> <?php echo $status; ?> </td>               
                                            <td class="text-right"> 
                                                <a href="<?=base_url()?>annual_incentive_plans/edit/<?=$plan->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>annual_incentive_plans/delete/<?=$plan->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?=lang('delete')?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>                         
                                            </td>
                                        </tr>
                                        <?php $j++; 
                                    } 
                                } 
                                else
                                { ?>
                                    <tr><?=lang('no_results_found')?></tr>
                                <?php 
                                } ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <!-- End Project Tasks -->
    </div>
    </div>
</div>