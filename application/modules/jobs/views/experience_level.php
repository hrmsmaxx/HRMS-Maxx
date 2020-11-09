<div class="content">
	<div class="row">
		<div class="col-xs-4">
			<h4 class="page-title"><?=lang('experience_level')?></h4>
		</div>
	</div>
    <?php $this->load->view('sub_menus');?>
    
	<div class="card-box">
	<div class="row">
		<div class="col-sm-8">
		</div>
        <div class="col-sm-4 text-right m-b-20">
            <a class="btn add-btn" href="<?=base_url()?>jobs/add_experience" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?=
            lang('add_experience_level')?></a>
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
                                <th><?=lang('experience')?></th>                                 
                                <th><?php echo lang('status');?></th>
                                <th class="col-options no-sort text-right"><?=lang('action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                                       
                               
                                    $j =1;
                                    foreach ($experience_levels as $key => $exp_level) 
                                    { 
                                        $status = lang('active');
                                        if($exp_level->status==0)
                                        {
                                            $status = lang('inactive');
                                        }
                                        ?>
                                        <tr>
                                            <td> <?php echo $j; ?> </td>
                                            <td> <?=$exp_level->experience_level?> </td> 
                                            <td> <?php echo $status; ?> </td>               
                                            <td class="text-right"> 
                                                <a href="<?=base_url()?>jobs/add_experience/<?=$exp_level->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>jobs/delete_experience/<?=$exp_level->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?=lang('delete')?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>                         
                                            </td>
                                        </tr>
                                        <?php $j++; 
                                    } 
                            
                                ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <!-- End Project Tasks -->
    </div>
    </div>
</div>