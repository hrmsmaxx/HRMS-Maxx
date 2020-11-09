<div class="content">

   <div class="row">

        <div class="col-sm-8">

            <h4 class="page-title"><?=lang('tickets')?></h4>

        </div>

        

    </div> 

  <?php $this->load->view('sub_menus');?>

	<div class="row">

		<div class="col-sm-8">

			<h4 class="page-title"><?=lang('priority')?></h4>

		</div>

        <div class="col-sm-4 text-right m-b-20">

            <a class="btn add-btn" href="<?=base_url()?>ticket_priority/add/" data-toggle="ajaxModal"><i class="fa fa-plus"></i><?php echo lang('add_priority'); ?></a>

        </div>

	</div>

    <div class="row">

        <!-- Project Tasks -->

        <div class="col-lg-12">

                <div class="table-responsive">

                    <table id="wiki" class="table table-striped custom-table m-b-0 AppendDataTables">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th><?php echo lang('name'); ?></th>                                 

                                <th><?php echo lang('hours'); ?></th>

                                <th class="col-options no-sort text-right"><?=lang('action')?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php                                      

                                if (!empty($priorities)) 

                                {

                                    $j =1;

                                    foreach ($priorities as $key => $priority) 

                                    { 
                                        if($priority->subdomain_id == $this->session->userdata('subdomain_id')){ ?>

                                        <tr>

                                            <td> <?php echo $j; ?> </td>

                                            <td> <?=$priority->priority?> </td> 

                                            <td> <?=$priority->hour?> </td>               

                                            <td class="text-right"> 

                                                <a href="<?=base_url()?>ticket_priority/add/<?=$priority->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

                                                    <i class="fa fa-edit"></i>

                                                </a>

                                                <a href="<?=base_url()?>ticket_priority/delete/<?=$priority->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?php echo lang('delete'); ?>">

                                                    <i class="fa fa-trash-o"></i>

                                                </a>                         

                                            </td>

                                        </tr>

                                        <?php $j++; 

                                    } } 

                                } 

                                else

                                { ?>

                                    <tr><td colspan="4"><?php echo lang('result_not_found'); ?></td></tr>

                                <?php 

                                } ?>

                        </tbody>

                    </table>

                </div>

        </div>

        <!-- End Project Tasks -->

    </div>

</div>