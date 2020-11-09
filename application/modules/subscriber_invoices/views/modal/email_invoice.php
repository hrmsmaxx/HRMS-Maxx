<div class="modal-dialog">
	<div class="modal-content">
		<?php $invoice = Subscriber_invoice::view_by_id($id);
			$subscriber_email = $this->db->get_where('dgt_subscribers',array('subscribers_id' =>$invoice->client))->row_array();

		 ?>
		<div class="modal-header">
			
			<h4 class="modal-title"><?=lang('email_invoice')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'invoiceEmailForm'); echo form_open(base_url().'subscriber_invoices/send_invoice',$attributes); ?>
			<div class="modal-body">
				<input type="hidden" name="invoice" value="<?=$invoice->inv_id?>">
				<div class="form-group">
					<label><?=lang('subject')?> <span class="text-danger">*</span></label>
				
						<input type="text" class="form-control" value="<?php echo App::email_template('invoice_message','subject');?> <?=$invoice->reference_no?>" name="subject">
					
				</div>
				<input type="hidden" name="message" class="hiddenmessage">
				<div class="message" contenteditable="false">
					<?php echo App::email_template('invoice_message','template_body');?>
				</div>
				<div class="form-group">
					<label><?=lang('cc_self')?> ( <span class="it"><?php echo $subscriber_email['subscriber_email'];?></span> )</label>
					
						<label class="switch">
							<input type="checkbox" name="cc_self">
							<span></span>
						</label>
				
				</div>

			</div>
			<div class="modal-footer"> <a href="#" class="btn btn-danger" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="submit btn btn-success" id="invoice_email_template"><?=lang('email_invoice')?></button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$(function(){
		$('.submit').click(function () {
			var mysave = $('.message').html();
			$('.hiddenmessage').val(mysave);
		});
	});
	</script>
</div>