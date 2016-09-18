<?php 
	if(@$data->getValue() == '' || @$data->getValue() == '1970-01-01' || @$data->getValue() == '1970-01-01 00:00:00' || @$data->getValue() == '0000-00-00 00:00:00') {
		$dateFormated = '(Trống)';
	} else {
		$dateFormated = date($data->getFormat(), strtotime(@$data->value));
	}
	
?>
<?php if($data->getEditable()) { ?>
<span class="inline-edit" id="inline-item-{data.getIndex()}-{data.getItemId()}">
	<span class="inline-text" ondblclick="pzk_list.showInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;">{dateFormated}</span>
	<span class="inline-input" style="display: none;">
		<input class="inline-input-field" type="text" name="{data.getIndex()}" value="{? echo date('m/d/Y H:i', strtotime($data->getValue())) ?}" 
			onblur="pzk_list.inlineFocus=false;" 
			onfocus="pzk_list.inlineFocus=true;"
			onkeyup="event = event||window.event; if(event.which==13) {pzk_list.saveInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;}; "
			/>
		<a href="#" onclick="pzk_list.saveInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;"><span class="glyphicon glyphicon-save"></span></a>
		<a href="#" onclick="pzk_list.cancelInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;"><span class="glyphicon glyphicon-remove"></span></a>
	</span>
</span>
<script type="text/javascript">
	<?php if($data->getDateType() === 'date') { ?>
	$('#inline-item-{data.getIndex()}-{data.getItemId()} .inline-input-field').datepicker({defaultDate: new Date('{data.getValue()}') });
	<?php } else { ?>
	$('#inline-item-{data.getIndex()}-{data.getItemId()} .inline-input-field').datetimepicker({defaultDate: new Date({? echo strtotime($data->getValue())?} * 1000) });
	<?php } ?>
</script>
<?php } else { ?>{dateFormated}<?php } ?>