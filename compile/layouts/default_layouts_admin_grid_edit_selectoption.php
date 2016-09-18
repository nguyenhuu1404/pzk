<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label>
		<div class="item">
			<select class="form-control" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"
				name="<?php echo isset($data)?$data->getIndex(): '';?>">
				<option>Tất cả</option> <?php foreach ( $data->getOption() as $key=>$val ) : ?>
				<option value="<?php echo isset($key)?$key: '';?>"><?php echo isset($val)?$val: '';?></option> <?php endforeach; ?>
			</select>
		</div>
	</div>
</div>
<script type="text/javascript">
		$('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
    </script>