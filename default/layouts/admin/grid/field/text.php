{ifprop isRaw}
	{data.getValue()}
{else}
<span class="inline-edit" id="inline-item-{data.getIndex()}-{data.getItemId()}">
	<span class="inline-text" ondblclick="pzk_list.showInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;">
		<?php
		$value = $data->getValue();
		if($value == '') $value = '(Trống)';
		if(isset($data->maps)) {
			if(isset($data->maps[$data->value])) {
				$value = $data->maps[$value];
			}
		}
		if(@$data->link): ?>
		<a target="{data.getTarget()}" <?php if(@$data->getCtrlLink()): ?>class="ctrl-click" data-ctrlLink="<?php eval('?>'.PzkParser::parseTemplate($data->getCtrlLink(), $data) . '<?php '); ?>{data.getItemId()}"<?php endif;?> href="<?php eval('?>'.PzkParser::parseTemplate($data->getLink(), $data) . '<?php '); ?>{data.getItemId()}">{value}</a>
		<?php else:?>
		{value}
		<?php endif;?>
		<?php if(0):?>
		<!--a class="hidden-input" href="#" onclick="pzk_list.showInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;"><span class="glyphicon glyphicon-edit"></span></a-->
		<?php endif;?>
	</span>
	<span class="inline-input" style="display: none;">
		<input class="inline-input-field" type="text" name="{data.getIndex()}" value="{? echo html_escape($data->getValue()) ?}" 
			onblur="pzk_list.inlineFocus=false;" 
			onfocus="pzk_list.inlineFocus=true;"
			onkeyup="event = event||window.event; if(event.which==13) {pzk_list.saveInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;}; "
			/>
		<a href="#" onclick="pzk_list.saveInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;"><span class="glyphicon glyphicon-save"></span></a>
		<a href="#" onclick="pzk_list.cancelInlineEdit('{data.getIndex()}', {data.getItemId()}); return false;"><span class="glyphicon glyphicon-remove"></span></a>
	</span>
</span>
{/if}