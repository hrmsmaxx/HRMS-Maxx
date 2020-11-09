<div class="content">

	<!-- <div class="row">

		<div class="col-xs-4">

			<h4 class="page-title">Employee Management</h4>

		</div>

	</div>

	

	<div class="card-box">

		<ul class="nav nav-tabs nav-tabs-solid page-tabs">

			<li><a href="<?php echo base_url(); ?>organisation">Org Structure</a></li>

			<li><a href="<?php echo base_url(); ?>employees">Employees</a></li>

			<li><a href="<?php echo base_url(); ?>attendance">Time & Attendance</a></li>

			<li><a href="<?php echo base_url(); ?>leaves">Leave</a></li>

			<li><a href="<?php echo base_url(); ?>payroll">Payroll</a></li>

			<li><a href="<?php echo base_url(); ?>resignation">Employees Status</a></li>

			<li><a href="<?php echo base_url(); ?>policies">Policies</a></li>

			<li><a href="<?php echo base_url(); ?>employees/employee_category">Categories</a></li>

			<li><a href="<?php echo base_url(); ?>employees/vacancy">Vacancy</a></li>

			<li class="active"><a href="<?php echo base_url(); ?>notice_board">Notices</a></li>

		</ul>

	</div> -->

	<div class="card-box m-b-0">

	<div class="row">

		<div class="col-sm-8">

			<h4 class="page-title"><?php echo lang('notices')?></h4>

		</div>

        <div class="col-sm-4 text-right m-b-20">

            <a class="btn add-btn" href="<?=base_url()?>notice_board/add/" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('add_notice_board')?></a>

        </div>

	</div>

    <div class="row">

        <!-- Project Tasks -->

        <div class="col-lg-12">

                <div class="table-responsive">

                    <table id="notice_board" class="table table-striped custom-table m-b-0 AppendDataTables">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th><?php echo lang('title')?></th>                                 

                                <th><?php echo lang('description')?></th>

                                <th class="col-options no-sort text-right"><?=lang('action')?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php                                      

                                if (!empty($notice_boards)) 

                                {

                                    $j =1;

                                    foreach ($notice_boards as $key => $notice_board) 

                                    { 
                                        if($notice_board->subdomain_id == $this->session->userdata('subdomain_id')){

                                        ?>

                                        <tr>

                                            <td> <?php echo lang($j); ?> </td>

                                            <td> <?=$notice_board->title?> </td> 

                                            <td> <?=$notice_board->description?> </td>               

                                            <td class="text-right"> 

                                                <a href="<?=base_url()?>notice_board/edit/<?=$notice_board->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

                                                    <i class="fa fa-edit"></i>

                                                </a>

                                                <a href="<?=base_url()?>notice_board/delete/<?=$notice_board->id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="" data-original-title="<?php echo lang('delete'); ?>">

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