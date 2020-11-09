
<?php $all_reports = $this->db->get('favourite_reports')->result_array();?>
<div class="btn-group">

              <button class="btn btn-default"><?=lang('reports')?></button>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>
              <ul class="dropdown-menu report-fav" style="width: 280px; left:auto; right:0px !important;">
              <?php foreach ($all_reports as $reports){ ?>
                
              
              <li><a href="<?php echo base_url()."reports/view/".$reports['report_name'];?>"><?php echo lang($reports['lang']);?></a><a href="" data-toggle="tooltip" title="<?php echo ($reports['status'] == 1)?lang('dislike'):lang('favourite');?>" class="pull-right favourite_reports" data-id="<?php echo $reports['id'];?>" data-status="<?php echo $reports['status'];?>"><i style="color: green;" class="fa fa-heart<?php echo ($reports['status'] == 1)?"":"-o";?>" aria-hidden="true"></i></a></li>
              <?php } ?>
              </ul>
              </div>

              <?php if(!$this->uri->segment(3)){ ?>
              <div class="btn-group">

              <button class="btn btn-default"><?=lang('year')?></button>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>

              <ul class="dropdown-menu">
              <?php
                      $max = date('Y');
                      $min = $max - 3;
                      foreach (range($min, $max) as $year) { ?>
                    <li><a href="<?=base_url()?>reports?setyear=<?=$year?>"><?=$year?></a></li>
              <?php }
              ?>
                        
              </ul>

              </div>
              <?php } ?>