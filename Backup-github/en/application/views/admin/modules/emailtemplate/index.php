<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h4 class="page-title m-b-20 m-t-0">Email template</h4>
                </div>               
            </div>
            <?php if($this->session->userdata('message')) {  ?>
            <?php echo $this->session->userdata('message');?>
            <?php } ?> 
            <div class="panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-actions-bar table-striped releasetable m-b-0">
                            <thead>
                                <tr>
                                    <th>Reference ID</th>
                                    <th>Email Title</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php                                
                                
                                if (!empty($list)) {
                                    $sno = 1;
                                    foreach ($list as $row) {                          
                                            ?>
                                            <tr>
                                                <td><?php echo $row['template_type'] ?></td>  
                                                <td> <?php echo $row['template_title'] ?></td>                                                
                                                <td class="text-right">
                                                    <a href="<?php echo base_url('admin/emailtemplate/edit/' . $row['template_id']); ?>" class="on-default view-row table-action-btn" title="Edit"><i class="mdi mdi-pencil text-success"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        
                                   $sno = $sno +1;
                                        }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="11"><p class="text-danger text-center m-b-0">No Records Found</p></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>