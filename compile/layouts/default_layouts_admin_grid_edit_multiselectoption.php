<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label> <select
			style="height: 120px;" multiple="multiple" class="form-control"
			id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" name="<?php echo isset($data)?$data->getIndex(): '';?>[]" size="10">
        <?php
								$options = $data->getOption ();
								
								?>
        <?php foreach ( $options as $key => $option ) : ?>
        <?php
								$selected = '';
								$trimIds = trim ( $data->getValue (), ',' );
								$arrIds = explode ( ',', $trimIds );
								if (in_array ( $key, $arrIds )) {
									$selected = 'selected="selected"';
								}
								?>
        <option <?php echo $selected; ?> value="<?php echo $key; ?>">
            <?php echo $option; ?>
        </option> <?php endforeach; ?>

		</select>
	</div>
</div>