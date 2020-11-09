<div class="content">

	<div class="row">

		<div class="col-sm-12">

			<h4 class="page-title"><?php echo lang('departments')?></h4>

		</div>

	</div>

    <?php $this->load->view('sub_menus');?>

	<div class="card-box">

	<div class="row">

		<div class="col-sm-8">

		</div>

        <div class="col-sm-4 text-right m-b-20">

            <a class="btn add-btn" href="<?=base_url()?>all_departments/departments/" data-toggle="ajaxModal"><i class="fa fa-plus"></i><?php echo lang('add_department')?></a>

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
                                <th><?php echo lang('id_code')?></th>
                                
                                <th><?php echo lang('department_name')?></th>
                                
                                <!-- <th><?php //echo lang('branch_name')?></th> -->

                                <th><?php echo lang('positions')?></th>

                                <th class="col-options no-sort text-right"><?php echo lang('action')?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php 
                            $subdomain_id = $this->session->userdata('subdomain_id');

                            if($this->session->userdata('role_name')=='admin' && $this->session->userdata('branch_id') != '') {
                                $branch_id = $this->session->userdata('branch_id');
                                $subdomain_id = $this->session->userdata('subdomain_id');
                                $departments = $this->db->query("SELECT * FROM `dgt_departments` WHERE find_in_set(`branch_id`, '$branch_id') AND `subdomain_id`='".$subdomain_id."' ")->result();
                            } else {
                                $departments = $this -> db -> get_where('departments',array('subdomain_id'=>$subdomain_id)) -> result();
                            }

                            if (!empty($departments)) {

                                $j =1;

                                foreach ($departments as $key => $d) { ?>

                            <tr>

								<td>

                                    <?php echo $j; ?>

                                </td>
                                <td>

                                    <?php echo $d->id_code; ?>

                                </td>
                               
                                <td>

                                    <?=$d->deptname?>

                                </td>

                                <?php /* <td>
                                    <?php $branch_name =  $this->db->get_where('branches', array('id'=>$d->branch_id, 'subdomain_id'=>$subdomain_id))->row();

                                    echo $branch_name->branch_name;
                                    ?>
                                </td> */ ?>

                                <td>

                                	<?php $all_des = $this->db->order_by('designation')->get_where('designation',array('department_id'=>$d->deptid))->result_array(); 

                                		if(count($all_des) != 0)

                                		{

                                			foreach($all_des as $des){

                                                $grade_details = $this->db->get_where('grades',array('grade_id'=>$des['grade']))->row_array();

                                	?>

										<div><?php echo $des['designation']; ?></div>

									<?php } }else{ ?>

										<div>-</div>

									<?php } ?>



                                </td>

                                <td class="text-right">

									<a href="<?php echo base_url(); ?>all_departments/view_designation/<?=$d->deptid?>" class="btn btn-info btn-xs">

										<?php echo lang('position');?>

									</a>

                                    <a href="<?=base_url()?>all_departments/edit_dept/<?=$d->deptid?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">

                                        <i class="fa fa-edit"></i>

                                    </a>

                                   <!--  <a href="<?=base_url()?>items/delete_task/<?=$task->template_id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal">

                                        <i class="fa fa-trash-o"></i>

                                    </a> -->

                                </td>

                            </tr>

                            <?php $j++; } } else{ ?>

                                <tr><?php echo lang('no_results_found');?></tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

        </div>

        <!-- End Project Tasks -->

    </div>

    </div>

</div>