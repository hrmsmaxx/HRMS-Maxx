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
            <a class="btn add-btn" href="<?=base_url()?>punch_groups/add/" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('create_group');?></a>
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
                                <th><?php echo lang('punch_group_name')?></th>                                 
                                <th><?php echo lang('location_name')?></th>                                 
                                <th><?php echo lang('employees')?></th>
                                <th class="col-options no-sort text-right"><?=lang('action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                                      
                                if (!empty($punch_groups)) 
                                {
                                    $j =1;
                                    foreach ($punch_groups as $key => $group) 
                                    { 
                                            $location_name = $this->db->get_where('locations',array('id'=>$group->location))->row()->location_name;
                                            $employees= explode(',', $group->employee_id);
                                        ?>
                                        <tr>
                                            <td> <?php echo lang($j); ?> </td>
                                            <td> <?php echo $group->punch_group_name; ?> </td>
                                            <td> <?php echo $location_name;?> </td> 
                                            <td class="text-muted">
                                                <ul class="team-members">
                                                    <?php foreach ($employees as $key => $value) { ?>
                                                    <li>
                                                        <a>
                                                            <img src="<?php echo User::avatar_url($value); ?>" class="" data-toggle="tooltip" data-title="<?=User::displayName($value); ?>" data-placement="top">
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                            <td class="text-right"> 
                                                <a href="<?=base_url()?>punch_groups/add/<?=$group->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>punch_groups/delete/<?=$group->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?=lang('delete');?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>                         
                                            </td>
                                        </tr>
                                        <?php $j++; 
                                    } 
                                } 
                                else
                                { ?>
                                    <tr><td colspan="5"><?php echo lang('no_results_found');?></td></tr>
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