<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label>
		<div style="float: left; width: 100%;" class="item">
			<textarea id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" class="tinymce"
				name="<?php echo isset($data)?$data->getIndex(): '';?>"><?php echo isset($data)?$data->getValue(): '';?></textarea>
		</div>
	</div>
</div>
