<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label>
		<textarea class="form-control" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"
			name="<?php echo isset($data)?$data->getIndex(): '';?>" placeholder="<?php echo isset($data)?$data->getLabel(): '';?>" rows="6"><?php echo isset($data)?$data->getValue(): '';?></textarea>
	</div>
</div>