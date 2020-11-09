<div class="content">

	<!-- <div class="row">

		<div class="col-xs-4">

			<h4 class="page-title"><?php echo lang('wiki')?></h4>

		</div>

	</div> -->

	<!-- <div class="card-box">

		<ul class="nav nav-tabs nav-tabs-solid page-tabs">

			<li><a href="<?php echo base_url(); ?>tickets">Tickets</a></li>

			<li class="active"><a href="<?php echo base_url(); ?>wiki">WIKI</a></li>

			<li><a href="<?php echo base_url(); ?>supports/e_notices">E-Notice</a></li>

		</ul>

	</div> -->

	<div class="card-box">

	<div class="row">

		<div class="col-sm-8">

			<h4 class="page-title"><?php echo lang('wiki')?></h4>

		</div>

        <div class="col-sm-4 text-right m-b-20">

            <a class="btn add-btn" href="<?=base_url()?>wiki/add/" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('add_wiki')?></a>

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

                                <th><?php echo lang('title')?></th>                                 

                                <th><?php echo lang('description')?></th>

                                <th class="col-options no-sort text-right"><?php echo lang('action')?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php                                      

                                if (!empty($wikis)) 

                                {

                                    $j =1;

                                    foreach ($wikis as $key => $wiki) 

                                    { 
                                        if($wiki->subdomain_id == $this->session->userdata('subdomain_id')){

                                        ?>

                                        <tr>

                                            <td> <?php echo $j; ?> </td>

                                            <td> <?=$wiki->title?> </td> 

                                            <td> <?=$wiki->description?> </td>               

                                            <td class="text-right"> 

                                                <a href="<?=base_url()?>wiki/edit/<?=$wiki->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

                                                    <i class="fa fa-edit"></i>

                                                </a>

                                                <a href="<?=base_url()?>wiki/delete/<?=$wiki->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?php echo lang('delete'); ?>">

                                                    <i class="fa fa-trash-o"></i>

                                                </a>                         

                                            </td>

                                        </tr>

                                        <?php $j++; 

                                    } }

                                } 

                                else

                                { ?>

                                    <tr><?php echo lang('no_records_found')?></tr>

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