{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label> <select
			style="height: 120px;" multiple="multiple" class="form-control"
			id="{data.getIndex()}{rand}" name="{data.getIndex()}[]" size="10">
        <?php
								$options = $data->getOption ();
								
								?>
        {each $options as $key => $option}
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
        </option> {/each}

		</select>
	</div>
</div>