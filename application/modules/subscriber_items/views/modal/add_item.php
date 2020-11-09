<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			
			<h4 class="modal-title"><?=lang('new_item')?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'itemsAddItem'); echo form_open(base_url().'subscriber_items/add_item',$attributes); ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('item_name')?> <span class="text-danger">*</span></label>
					
						<input type="text" class="form-control" placeholder="<?=lang('item_name')?>" name="item_name" required>
				
				</div>
				<div class="form-group">
					<label><?=lang('item_description')?> <span class="text-danger">*</span></label>
					
						<textarea class="form-control ta" name="item_desc" placeholder="<?=lang('item_description')?>" required></textarea>
					
				</div>
				<div class="form-group">
					<label><?=lang('quantity')?> <span class="text-danger">*</span></label>
					
						<input type="text" class="form-control" placeholder="2" name="quantity" required="required">
					
				</div>
				<div class="form-group">
					<label><?=lang('unit_price')?> <span class="text-danger">*</span></label>
					
						<input type="text" class="form-control" placeholder="350.00" name="unit_cost" required="required">
				
				</div>
				<div class="form-group">
					<label><?=lang('tax_rate')?> <span class="text-danger">*</span></label>
					
						<select name="item_tax_rate" class="form-control m-b" required="required">
							<option value=""><?=lang('none')?></option>
							<?php foreach ($rates as $key => $tax) { ?>
							<option value="<?=$tax->tax_rate_percent?>"><?=$tax->tax_rate_name?></option>
							<?php } ?>
                        </select>
					
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-close" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-success" id="items_add_item"><?=lang('add_item')?></button>
			</div>
		</form>
	</div>
</div>