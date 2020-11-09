<div class="content">
	<div class="row">
		<div class="col-xs-4">
			<h4 class="page-title"><?=lang('geolocation')?></h4>
		</div>
	</div>
    <?php $this->load->view('sub_menus');?>
    
	<div class="card-box">
	<div class="row">
		<div class="col-sm-8">
		</div>
        <div class="col-sm-4 text-right m-b-20">
            <a class="btn add-btn" href="<?=base_url()?>locations/add/" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('create_location');?></a>
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
                                <th><?php echo lang('location_name')?></th>                                 
                                <th><?php echo lang('country')?></th>                                 
                                <th><?php echo lang('state')?></th>
                                <th><?php echo lang('address')?></th>
                                <th class="col-options no-sort text-right"><?=lang('action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                                      
                                if (!empty($locations)) 
                                {
                                    $j =1;
                                    foreach ($locations as $key => $location) 
                                    { 
                                            // $location_name = $this->db->get_where('locations',array('id'=>$group->location))->row()->location_name;
                                        ?>
                                        <tr>
                                            <td> <?php echo lang($j); ?> </td>
                                            <td> <?php echo $location->location_name; ?> </td>
                                            <td> <?php echo $location->country;?> </td> 
                                            <td> <?php echo $location->state; ?> </td> 
                                            <td> <?php echo $location->address; ?> </td> 
                                            <td class="text-right"> 
                                                <a href="<?=base_url()?>locations/add/<?=$location->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>locations/delete/<?=$location->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?=lang('delete');?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>                         
                                            </td>
                                        </tr>
                                        <?php $j++; 
                                    } 
                                } 
                                else
                                { ?>
                                    <tr><td colspan="6"><?php echo lang('no_results_found');?></td></tr>
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