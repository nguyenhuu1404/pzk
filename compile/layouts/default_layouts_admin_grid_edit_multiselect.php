<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label> <select
			style="height: 250px;" multiple="multiple" class="form-control"
			id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" name="<?php echo isset($data)?$data->getIndex(): '';?>[]" size="10">
        <?php
								$parents = _db ()->select ( '*' )->from ( $data->getTable () )->result ();
								if (isset ( $parents [0] ['parent'] )) {
									$parents = treefy ( $parents, 'parent', 0 );
									echo "<option value='0'>&nbsp;&nbsp;&nbsp;&nbsp;Danh mục gốc</option>";
								} else {
									echo "<option value='0'>Danh mục gốc</option>";
								}
								?>
        <?php foreach ( $parents as $parent ) : ?>
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
        </option> <?php endforeach; ?>

		</select>
	</div>
</div>