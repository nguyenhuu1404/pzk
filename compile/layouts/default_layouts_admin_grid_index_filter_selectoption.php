<?php
$rand = rand(0, 100000);
?>
	<span class="hidden"><?php echo isset($data)?$data->getLabel(): '';?></span>
	<select id="<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($rand)?$rand: '';?>" name="<?php echo isset($data)?$data->getIndex(): '';?>" onchange="pzk_list.filter('<?php echo isset($data)?$data->getType(): '';?>', '<?php echo isset($data)?$data->getIndex(): '';?>', this.value);" >
		<option value="">Tất cả</option>
		<?php foreach ( $data->getOption() as $key=>$val ) : ?>
		<option value="<?php echo isset($key)?$key: '';?>"><?php echo isset($val)?$val: '';?></option>
		<?php endforeach; ?>
	</select>
	<script type="text/javascript">
		$('#<?php echo isset($data)?$data->getIndex(): '';?>-<?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
    </script>