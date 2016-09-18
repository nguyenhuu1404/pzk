<?php if($data->getSwitchType() == 'bootstrap') : ?>
<input id="switch-<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($data)?$data->getItemId(): '';?>" type="checkbox" <?php if ( $data->getValue() ) : ?>checked="checked"<?php endif; ?> data-size="mini" /><script type="text/javascript">jQuery('#switch-<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($data)?$data->getItemId(): '';?>').bootstrapSwitch({onSwitchChange: function(evt,state) { <?php echo $data->onEvent('changeStatus');?>({id: <?php echo isset($data)?$data->getItemId(): '';?>, status: state}); }})</script>
<?php else: ?>
	<?php if($data->getValue() == '1') : ?>
		<span class="glyphicon glyphicon-<?php echo pzk_or(@$data->getIcon(), 'star'); ?>" style="color: blue; font-size: 120%; cursor: pointer;" onclick="pzk_list.changeStatus('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>, this);"></span>
	<?php else: ?>
		<span class="glyphicon glyphicon-<?php echo pzk_or(@$data->getIcon(), 'star'); ?>" style="color: black; font-size: 100%; cursor: pointer;" onclick="pzk_list.changeStatus('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>, this);"></span>
	<?php endif; ?>
<?php endif; ?>
