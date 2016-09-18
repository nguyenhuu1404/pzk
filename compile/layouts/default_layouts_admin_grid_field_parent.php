<?php
$tab = '|&nbsp;&nbsp;&nbsp;&nbsp;';

$data->setValue(rtrim(str_repeat($tab, $data->getLevel()), '&nbsp;').'__'.$data->getValue());
?>
<?php if ( isset($data->isRaw) && $data->isRaw ) : ?>
	<?php echo isset($data)?$data->getValue(): '';?>
<?php else: ?>
<span class="inline-edit" id="inline-item-<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($data)?$data->getItemId(): '';?>">
	<span class="inline-text" ondblclick="pzk_list.showInlineEdit('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>); return false;">
		<?php
		$value = $data->getValue();
		if($value == '') $value = '(Trống)';
		if(isset($data->maps)) {
			if(isset($data->maps[$data->value])) {
				$value = $data->maps[$value];
			}
		}
		if(@$data->link): ?>
		<a target="<?php echo isset($data)?$data->getTarget(): '';?>" href="<?php eval('?>'.PzkParser::parseTemplate($data->getLink(), $data) . '<?php '); ?><?php echo isset($data)?$data->getItemId(): '';?>"><?php echo isset($value)?$value: '';?></a>
		<?php else:?>
		<?php echo isset($value)?$value: '';?>
		<?php endif;?>
		<?php if(0):?>
		<!--a class="hidden-input" href="#" onclick="pzk_list.showInlineEdit('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>); return false;"><span class="glyphicon glyphicon-edit"></span></a-->
		<?php endif;?>
	</span>
	<span class="inline-input" style="display: none;">
		<input class="inline-input-field" type="text" name="<?php echo isset($data)?$data->getIndex(): '';?>" value="<?php echo html_escape($data->getValue()) ?>" 
			onblur="pzk_list.inlineFocus=false;" 
			onfocus="pzk_list.inlineFocus=true;"
			onkeyup="event = event||window.event; if(event.which==13) {pzk_list.saveInlineEdit('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>); return false;}; "
			/>
		<a href="#" onclick="pzk_list.saveInlineEdit('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>); return false;"><span class="glyphicon glyphicon-save"></span></a>
		<a href="#" onclick="pzk_list.cancelInlineEdit('<?php echo isset($data)?$data->getIndex(): '';?>', <?php echo isset($data)?$data->getItemId(): '';?>); return false;"><span class="glyphicon glyphicon-remove"></span></a>
	</span>
</span>
<?php endif; ?>