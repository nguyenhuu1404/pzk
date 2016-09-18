{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label> <select
			style="height: 250px;" multiple="multiple" class="form-control"
			id="{data.getIndex()}{rand}" name="{data.getIndex()}[]" size="10">
        <?php
								$parents = _db ()->select ( '*' )->from ( $data->getTable () )->result ();
								if (isset ( $parents [0] ['parent'] )) {
									$parents = treefy ( $parents, 'parent', 0 );
									echo "<option value='0'>&nbsp;&nbsp;&nbsp;&nbsp;Danh mục gốc</option>";
								} else {
									echo "<option value='0'>Danh mục gốc</option>";
								}
								?>
        {each $parents as $parent}
        <?php
								$selected = '';
								$trimIds = trim ( $data->getValue (), ',' );
								$arrIds = explode ( ',', $trimIds );
								if (in_array ( $parent [$data->getShow_value ()], $arrIds )) {
									$selected = 'selected="selected"';
								}
								?>
        <option <?php echo $selected; ?>
				value="<?php echo $parent[$data->getShow_value()]; ?>">
            <?php if(isset($parent['parent'])){ echo str_repeat('--', $parent['level']); } ?>
            <?php echo $parent[$data->getShow_name()]; ?>
        </option> {/each}

		</select>
	</div>
</div>