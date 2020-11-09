
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<?php
	$jtype=array(0=>'unassigned');
	    foreach ($offer_jobtype as $jkey => $jvalue) {
	            $jtype[$jvalue->id]=$jvalue->job_type;                        
	     }
	
	?>
<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<h4 class="page-title m-b-0"><?php echo lang('recruiting_process');?></h4>
			<ul class="breadcrumb m-b-30 p-l-0" style="background:none; border:none;">
				<li><a href="<?php echo base_url(); ?>"><?php echo lang('home');?></a></li>
				<li><a href="<?php echo base_url(); ?>jobs/dashboard"><?php echo lang('recruiting_process');?></a></li>
				<li><?php echo lang('manage_jobs');?></li>
			</ul>
		</div>
	</div>
	  <?php $this->load->view('sub_menus');?>
	
	<div class="row">
		<?php foreach ($jobs as $key => $value) {	//print_r($value);exit();	// foreach starts 
			?>
		<div class="col-md-6">
			<!-- <a class="job-list" href="<?=base_url()?>jobs/jobview/<?=$value->id?>"> -->
			<div class="job-list">
				<div class="job-list-det">
					<div class="job-list-desc">
						<h3 class="job-list-title"><?=ucfirst($value->title);?></h3>
						<h4 class="job-department"><?=ucfirst($jtype[$value->job_type]);?></h4>
					</div>
					<div class="job-type-info">
						<span >
						<a class='job-types' href="<?=base_url()?>jobs/apply/<?=$value->id?>/<?=$value->job_type?>">Apply</a>
						</span>
					</div>
				</div>
				<div class="job-list-footer">
					<ul>
						<!-- <li><i class="fa fa-map-signs"></i> California</li> -->
						<li><i class="fa fa-money"></i> <?=$value->salary;?></li>
						<li><i class="fa fa-clock-o"></i> <?=Jobs::time_elapsed_string($value->created); ?></li>
					</ul>
				</div>
			</div>
			<!-- </a> -->
		</div>
		<?php } // foreach end ?>	 
	</div>
	<div class="card-box">
		<div class="row">
			<div class="col-sm-5 col-5">
				<h4 class="page-title"><?php echo lang('manage_jobs');?></h4>
			</div>
			<div class="col-sm-7 col-7 text-right m-b-30">
				<a href="<?php echo base_url(); ?>jobs/add" class="btn add-btn"><i class="fa fa-plus"></i> <?php echo lang('add_jobs');?></a>
				<a class="btn add-btn m-r-5" data-toggle="modal" data-target="#all_job_header"><?php echo lang('header_image');?></a>

			</div>
		</div>
		<div class="table-responsive">
			<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo lang('job_title');?></th>
						<th><?php echo lang('department');?></th>
						<th><?php echo lang('start_date');?></th>
						<th><?php echo lang('expire_date');?></th>
						<th class="text-center"><?php echo lang('job_types');?></th>
						<th class="text-center"><?php echo lang('status');?></th>
						<th><?php echo lang('applicants');?></th>
						<th class="text-right"><?php echo lang('action')?></th>
						<th><?php echo lang('social_link')?></th>
						
					</tr>
				</thead>
				<tbody>
					<?php 
					$i=1;
					$class_array = array('text-info','text-success','text-danger','text-warning');

					foreach($jobs_list as $key =>$list){?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><a href="<?php echo base_url(); ?>jobs/view_jobs/<?php echo $list->id;?>"><?php echo $list->job_title;?></a></td>
						<td><?php echo $list->deptname;?></td>
						<td><?php echo date('d M Y',strtotime($list->start_date));?></td>
						<td><?php echo date('d M Y',strtotime($list->expired_date));?></td>
						<td class="text-center">

						
							<div class="dropdown action-label">
								<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-dot-circle-o text-danger"></i> <?php echo $list->job_type;?>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<?php 
									$j=0;
									foreach($job_types as $key =>$types){
										
										?>
									<li ><a class="dropdown-item" href="<?php echo site_url('jobs/change_jobtype').'/'.$types->id.'/'.$list->id?>"><i class="fa fa-dot-circle-o <?php echo $class_array[$j]?>"></i> <?php echo $types->job_type;?></a></li>
										<?php 
										if($j==3){
											$j=0;
										}
										$j++;
									}?>
									
								</ul>
							</div>
						</td>
						<td class="text-center">
							<div class="dropdown action-label">
								<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-dot-circle-o text-danger"></i> <?php echo ($list->job_status == 0) ?  lang("open") :  lang("close");?>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a class="dropdown-item" href="<?php echo site_url('jobs/status/0').'/'.$list->id;?>"><i class="fa fa-dot-circle-o text-info"></i> <?php echo lang('open');?></a></li>
									<li><a class="dropdown-item" href="<?php echo site_url('jobs/status/1').'/'.$list->id;?>"><i class="fa fa-dot-circle-o text-success"></i> <?php echo lang('closed')?></a></li>
								</ul>
							</div>
						</td>
						<td><a href="<?php echo base_url(); ?>jobs/applicants/<?php echo $list->id;?>" class="btn btn-sm btn-primary"> <?php if(isset($applications[$list->id])){ echo $applications[$list->id]; }else{ echo 0;}?>  <?php echo lang('candidates')?></a></td>
						<td class="text-right">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="<?php echo base_url(); ?>jobs/edit/<?php echo $list->id;?>" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> <?php echo lang('edit');?></a></li>
									<li><a href="<?php echo site_url('jobs/delete').'/'.$list->id; ?>" class="dropdown-item"data-toggle="ajaxModal"><i class="fa fa-trash-o m-r-5"></i> <?php echo lang('delete');?></a></li>
								</ul>
							</div>
						</td>
					<td>

						  <?php /*
                    $title=urlencode($list->job_title);
                    
                    $summary=urlencode($list->description);
                    $image=urlencode('');
                ?>
							 <a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_blank" href="javascript: void(0)">
                	FB
                </a> */ 

               $url=base_url().'candidates/job_view_user/'.$list->id;
                //$url='https://demo.hrmsmaxx.com/candidates/job_view_user/2';

                ?>

    <a class="fb-share-button" data-href="<?php echo $url;?>" data-layout="button_count"></a> <!--facebook-->
  <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?php echo $list->job_title;?>&url=<?php echo $url;?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i>
</a><!--twitter-->
              <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i>
</a>
              <a href="https://plus.google.com/share?url=<?php echo $url; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus-square" aria-hidden="true"></i>
</a>

						</td> 
					</tr>
				<?php } ?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- all_job_header modal -->
<?php $all_job_header= $this->db->get('all_job_header')->row_array();?>

<div id="all_job_header" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('files_upload');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="job_header" method="POST" action="<?php echo base_url(); ?>jobs/add_header" enctype="multipart/form-data">
									<?php if(!empty( $all_job_header)){?>
										<input class="form-control" type="hidden" name="id"  id= "image_edit" value="<?php echo $all_job_header['id'];?>">
									<?php }?>
									<div class="form-group">
										<label><?php echo lang('description');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="description" value="<?php echo (!empty($all_job_header['description']))?$all_job_header['description']:"";?>" required>
										
									</div>									
									<div class="form-group">
										<label><?php echo lang('upload_files');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="file" name = "image" id="image"  >
										<input class="form-control" type="hidden" name="avatar"  id= "image_edit" value="<?php echo $all_job_header['image'];?>">
                                        <?php  if(!empty($all_job_header['image'])){ ?>
                                        <img class="rounded-circle" alt="" style="width: 300px" src="<?php echo base_url()?>assets/uploads/<?php echo $all_job_header['image'];?>">
                                        <?php  } ?>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="" type="submit"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- all_job_header modal -->