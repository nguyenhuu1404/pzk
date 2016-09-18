<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 	= pzk_or($data->getMdsize(), 12);
$compact	= $data->getCompact();
$nocompact	= !$compact;
if($compact) {
	$data->setSelectLabel($data->getLabel());
}
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<?php if ( isset($nocompact) && $nocompact ) : ?><label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label><?php endif; ?><div class="col-xs-12"><select
			class="select2-container form-control select2" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"
			name="<?php echo isset($data)?$data->getIndex(): '';?>">
            <?php
												$parents = _db ()->select ( '*' )->from ( $data->getTable () )->where ( pzk_or ( @$data->getCondition (), '1' ) )->result ();
												if (isset ( $parents [0] ['parent'] )) {
													$parents = treefy ( $parents );
													if($nocompact) {
														echo "<option value='0'>&nbsp;&nbsp;&nbsp;&nbsp;Danh mục gốc</option>";
													} else {
														echo "<option value='0'>" . pzk_or ( @$data->getSelectLabel (), '&nbsp;&nbsp;&nbsp;&nbsp;Danh mục gốc' ) . " </option>";
													}
												} else {
													echo "<option value='0'>" . pzk_or ( @$data->getSelectLabel (), '--Chọn một mục--' ) . " </option>";
												}
												?>
			<?php foreach ( $parents as $parent ) : ?>
			<option value="<?php echo $parent[$data->getShow_value()]; ?>">
				<?php if(isset($parent['parent'])){ echo str_repeat('--', $parent['level']); } ?>
				<?php echo $parent[$data->getShow_name()]; ?>
			</option> <?php endforeach; ?>

		</select>
		</div>
		<script type="text/javascript">
			$('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
			$( "#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" ).select2( { placeholder: "<?php echo isset($data)?$data->getLabel(): '';?>", maximumSelectionSize: 6 } );
        </script>
	</div>
</div>