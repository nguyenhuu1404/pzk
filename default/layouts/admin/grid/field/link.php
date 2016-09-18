<?php if($data->getTarget() == 'dialog'): ?>
	<a href="{data.getLink()}{data.getItemId()}" onclick="pzk_list.dialog({data.getItemId()}, '<?php eval('?>'.PzkParser::parseTemplate($data->getLink(), $data) . '<?php '); ?>'); return false;">{data.getLabel()}</a>
<?php else:?>
	<a href="{data.getLink()}{data.getItemId()}" <?php if($data->getOnclick()):?>onclick="<?php eval('?>'.PzkParser::parseTemplate($data->getOnclick(), $data) . '<?php '); ?>; return false;"<?php endif;?>>{data.getLabel()}</a>
<?php endif; ?>