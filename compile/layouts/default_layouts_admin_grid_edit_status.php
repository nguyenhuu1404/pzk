<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label> <select
			class="form-control" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"
			name="<?php echo isset($data)?$data->getIndex(): '';?>">
			<option value="0">Chưa kích hoạt</option>
			<option value="1">Đã kích hoạt</option>
		</select>
	</div>
</div>
<script>
	$('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
  </script>