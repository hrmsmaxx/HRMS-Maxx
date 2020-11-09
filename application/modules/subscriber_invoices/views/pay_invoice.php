                <?php
                    $invoice_settings = $this->db->get_where('subdomin_invoice_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

                    $invoice_settings = unserialize($invoice_settings['invoice_settings']);

                    $pdf_engine = $invoice_settings['pdf_engine']?$invoice_settings['pdf_engine']:config_item('pdf_engine');
                ?>

                <?php $inv = Subscriber_invoice::view_by_id($id); ?>

                 <?php if($this->session->userdata('user_id') !=2){ ?>
          
    <div class="content">
       <?php  }else{ ?>
              <div class="page-wrapper">
    <div class="content container-fluid">
        <?php } ?>
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="page-title"><?=lang('invoice_pay')?></h4>
                        </div>
                        <div class="col-sm-4  text-right m-b-20">     
                            <a class="btn back-btn" href="<?=base_url()?>subscriber_invoices"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
                        </div>
                    </div>
                <header class="header-fixed clearfix hidden-print">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">

                            <a href="<?=site_url()?>subscriber_invoices/view/<?=$inv->inv_id?>" class="btn btn-sm btn-info">
                                <?=lang('view_invoice')?>
                            </a>


                            
                            <?php if($this->session->userdata('user_id') ==2){ ?>
                                <?php if ($inv->show_client == 'Yes') { ?>
                                    <a class="btn btn-sm btn-success" href="<?=base_url()?>subscriber_invoices/hide/<?=$inv->inv_id?>" data-title="<?=lang('hide_to_client')?>" data-toggle="tooltip" data-placement="bottom" ><i class="fa fa-eye-slash"></i>
                                    </a>
                                <?php } else { ?>
                                    <a class="btn btn-sm btn-danger" href="<?= base_url() ?>subscriber_invoices/show/<?= $inv->inv_id ?>" data-toggle="tooltip" data-placement="bottom" data-title="<?= lang('show_to_client') ?>"><i class="fa fa-eye"></i> <?= lang('show_to_client') ?>
                                    </a>
                                <?php } } ?>                            

                            <?php if (Subscriber_invoice::payment_status($inv->inv_id) != 'fully_paid') { ?>

                                <?php  if ($inv->allow_paypal == 'Yes') { ?>

                                    <a class="btn btn-sm btn-success" href="<?=base_url()?>paypal/pay/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?= lang('via_paypal') ?>">
                                        <?=lang('via_paypal')?>
                                    </a>
                                <?php } if ($inv->allow_2checkout == 'Yes') { ?>

                                    <a class="btn btn-sm btn-success" href="<?=base_url()?>checkout/pay/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?=lang('via_2checkout')?>"><?= lang('via_2checkout') ?></a>

                                <?php } if ($inv->allow_stripe == 'Yes') { ?>


                                    <!-- <button id="customButton" class="btn btn-sm btn-success" ><?=lang('via_stripe')?></button> -->


                                <?php } if ($inv->allow_bitcoin == 'Yes') { ?>
                                    <!-- <a class="btn btn-sm btn-success" href="<?= base_url() ?>bitcoin/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_bitcoin') ?>"><?= lang('via_bitcoin') ?></a> -->
                                <?php } ?>
                                <?php } ?>

                                 <?php if($this->session->userdata('user_id') ==2){ ?>

                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"><?= lang('more_actions') ?><span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                   
                                    <?php if (Subscriber_invoice::get_invoice_subtotal($inv->inv_id) > 0) { ?>

                                       
                                            <li>
                                                <a href="<?=base_url()?>subscriber_invoices/send_invoice/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?= lang('email_invoice') ?>"><?=lang('email_invoice')?></a>
                                            </li>

                                        
                                            <li>
                                                <a href="<?= base_url() ?>subscriber_invoices/remind/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?= lang('send_reminder') ?>"><?=lang('send_reminder')?></a>
                                            </li>
                                        <li><a href="<?=base_url()?>subscriber_invoices/timeline/<?=$inv->inv_id?>">
                                                <?=lang('invoice_history')?></a>
                                        </li>
                                    <?php }  ?>


                                </ul>
                            </div>
                        <?php } ?>
                              <?php if($this->session->userdata('user_id') ==2){ ?>
   
                                <a href="<?=base_url()?>subscriber_invoices/edit/<?=$inv->inv_id?>" class="btn btn-sm btn-success" data-original-title="<?=lang('edit_invoice')?>" data-toggle="tooltip" data-placement="bottom">
                                    <i class="fa fa-pencil"></i>
                                </a>

                            
                                <a href="<?=base_url()?>subscriber_invoices/delete/<?=$inv->inv_id?>" class="btn btn-sm btn-danger" title="<?=lang('delete_invoice')?>" data-toggle="ajaxModal">
                                    <i class="fa fa-trash"></i>
                                </a>

                            <?php } ?>

                        </div>
                        <div class="col-sm-3 m-b-xs pull-right">
                            <?php if ($pdf_engine == 'invoicr') : ?>
                                <a href="<?=base_url()?>fopdf/invoice/<?=$inv->inv_id?>" class="btn btn-sm btn-primary pull-right">
                                    <i class="fa fa-file-pdf-o"></i> <?=lang('pdf')?>
                                </a>
                            <?php elseif ($pdf_engine == 'mpdf') : ?>
                                <a href="<?=base_url()?>subscriber_invoices/pdf/<?=$inv->inv_id?>" class="btn btn-sm btn-primary pull-right">
                                    <i class="fa fa-file-pdf-o"></i> <?= lang('pdf') ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>

<!-- Start -->
<section class="content">

                    <!-- Start create invoice -->
                    <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">


                            <div class="panel-body">


                                <?php
                                $attributes = array('class' => 'bs-example form-horizontal');
                                echo form_open_multipart(base_url().'subscriber_invoices/pay',$attributes);
                                $cur = App::currencies($inv->currency);
                                ?>

                                <input type="hidden" name="invoice" value="<?=$id?>">
                                <input type="hidden" name="currency" value="<?=$cur->code?>">

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('trans_id')?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <?php $this->load->helper('string'); ?>
                                        <input type="text" class="form-control" value="<?=random_string('nozero', 6);?>" name="trans_id" readonly>
                                    </div>
                                </div>
                                <div class="form-group">

        <label class="col-lg-3 control-label"><?=lang('amount')?> (<?=$cur->symbol?>)
        <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
        <input type="text" class="form-control" value="<?=Applib::format_deci(Subscriber_invoice::get_invoice_due_amount($id));?>" name="amount">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('payment_date')?></label>
                                    <div class="col-lg-8">
                                        <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?=strftime(config_item('date_format'), time());?>" name="payment_date" data-date-format="<?=config_item('date_picker_format');?>" >
                                    </div>
                                </div>

                               <!--  <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('payment_method')?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="payment_method" class="form-control">
                                            <?php
                                            foreach (Subscriber_invoice::payment_methods() as $key => $m) { ?>
                                                <option value="<?=$m->method_id?>"><?=$m->method_name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('notes')?></label>
                                    <div class="col-lg-8">
                                        <textarea name="notes" class="form-control ta"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('payment_slip')?></label>
                                    <div class="col-lg-8">
                                        <label class="switch">
                                            <input type="hidden" value="off" name="attach_slip" />
                                            <input type="checkbox" name="attach_slip" id="attach_slip">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div id="attach_field" style="display:none">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><?=lang('attach_file')?></label>

                                        <div class="col-lg-8">
                                            <label class="btn btn-default btn-choose"><?=lang('choose_file')?></label>
                                            <input type="file" class="form-control" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="payment_slip">
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('send_email')?></label>
                                    <div class="col-lg-8">
                                        <label class="switch">
                                            <input type="checkbox" name="send_thank_you">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer"> <a href="<?=base_url()?>subscriber_invoices/view/<?=$id?>" class="btn btn-danger" data-dismiss="modal"><?=lang('close')?></a>
                                    <button type="submit" class="btn btn-success"><?=lang('add_payment')?></button>
                                    </form>



                                </div>
                        </section>
                    </div>


                    <!-- End create invoice -->

			</div>
			</div>

<?php if($inv->allow_stripe == 'Yes'){ ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
<?php } ?>
<!-- end -->
