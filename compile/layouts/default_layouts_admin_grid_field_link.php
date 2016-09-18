<?php if($data->getTarget() == 'dialog'): ?>
	<a href="<?php echo isset($data)?$data->getLink(): '';?><?php echo isset($data)?$data->getItemId(): '';?>" onclick="pzk_list.dialog(<?php echo isset($data)?$data->getItemId(): '';?>, '<?php eval('?>'.PzkParser::parseTemplate($data->getLink(), $data) . '<?php '); ?>'); return false;"><?php echo isset($data)?$data->getLabel(): '';?></a>
<?php else:?>
	<a href="<?php echo isset($data)?$data->getLink(): '';?><?php echo isset($data)?$data->getItemId(): '';?>" <?php if($data->getOnclick()):?>onclick="<?php eval('?>'.PzkParser::parseTemplate($data->getOnclick(), $data) . '<?php '); ?>; return false;"<?php endif;?>><?php echo isset($data)?$data->getLabel(): '';?></a>
<?php endif; ?>