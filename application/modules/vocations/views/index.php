<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?=lang('vocations')?></h4>
		</div>
	</div>
    <?php $this->load->view('sub_menus');?>
	<div class="card-box">
	<div class="row">
		<div class="col-sm-8">
		</div>
        <div class="col-sm-4 text-right m-b-20">
            <a class="btn add-btn" href="<?=base_url()?>vocations/add/" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?=lang('add_vocation')?></a>
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
                                <th><?=lang('vocation')?></th>                                 
                                <th><?=lang('status')?></th>
                                <th class="col-options no-sort text-right"><?=lang('action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                                      
                                if (!empty($vocations)) 
                                {
                                    $j =1;
                                    foreach ($vocations as $key => $vocation) 
                                    { 
                                        $status = lang('active');
                                        if($vocation->status==0)
                                        {
                                            $status = lang('in_active');
                                        }
                                        ?>
                                        <tr>
                                            <td> <?php echo $j; ?> </td>
                                            <td> <?=$vocation->vocation?> </td> 
                                            <td> <?php echo $status; ?> </td>               
                                            <td class="text-right"> 
                                                <a href="<?=base_url()?>vocations/edit/<?=$vocation->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>vocations/delete/<?=$vocation->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?=lang('delete')?>">
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