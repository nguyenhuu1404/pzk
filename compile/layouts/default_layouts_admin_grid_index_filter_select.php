<span class="hidden"><?php echo isset($data)?$data->getLabel(): '';?></span>
<select id="<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($rand)?$rand: '';?>" name="{data->getIndex()}" onchange="pzk_list.filter('{data->getType()}', '<?php echo isset($data)?$data->getIndex(): '';?>', this.value);">
	<?php
$parents = _db ()->select ( '*' )->from ( $data->getTable() )->where(pzk_or($data->getCondition(), '1'))->result ();
	if (isset ( $parents [0] ['parent'] )) {
		$parents = treefy ( $parents, 'parent', 0 );
		echo "<option value='' >--Tất cả</option>";
	} else {
		echo "<option value=''>Tất cả</option>";
	}
	?>
	<?php if($data->getNotAccept() == '1'):?>
		<option value='0'>(Trống)</option>
	<?php endif;?>
	<?php foreach ( $parents as $parent ) : ?>
	<option value="<?php echo $parent[$data->getShow_value()]; ?>"><?php if(isset($parent['parent'])){ echo str_repeat('--', @$parent['level']); } ?>
		<?php echo $parent[$data->getShow_name()]; ?>
	</option> <?php endforeach; ?>
</select>
<script type="text/javascript">
	$('#<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
</script>