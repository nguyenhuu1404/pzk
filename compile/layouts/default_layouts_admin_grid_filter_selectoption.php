<?php 
$controller = pzk_controller(); 
$compact	= $data->getCompact();
$nocompact	= !$compact;
if($compact) {
	$data->setSelectLabel($data->getLabel());
}
?>
<div  class="form-group col-xs-12">
	<?php if ( isset($nocompact) && $nocompact ) : ?><label><?php echo isset($data)?$data->getLabel(): '';?></label><br /><?php endif; ?>
	<select class="form-control"  id="<?php echo isset($data)?$data->getIndex(): '';?>" name="<?php echo isset($data)?$data->getIndex(): '';?>" onchange="pzk_list.filter('<?php echo isset($data)?$data->getType(): '';?>', '<?php echo isset($data)?$data->getIndex(): '';?>', this.value);" >
		<?php if ( isset($nocompact) && $nocompact ) : ?>
		<option value="">Tất cả</option>
		<?php else: ?>
		<option value=""><?php echo isset($data)?$data->getLabel(): '';?></option>
		<?php endif; ?>
		<?php foreach ( $data->getOption() as $key=>$val ) : ?>
		<option value="<?php echo isset($key)?$key: '';?>"><?php echo isset($val)?$val: '';?></option>
		<?php endforeach; ?>
	</select>
	<script type="text/javascript">
		$('#<?php echo isset($data)?$data->getIndex(): '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
    </script>
</div>