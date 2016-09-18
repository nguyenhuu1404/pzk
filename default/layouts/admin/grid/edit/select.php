{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 	= pzk_or($data->getMdsize(), 12);
$compact	= $data->getCompact();
$nocompact	= !$compact;
if($compact) {
	$data->setSelectLabel($data->getLabel());
}
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		{ifvar nocompact}<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>{/if}<div class="col-xs-12"><select
			class="select2-container form-control select2" id="{data.getIndex()}{rand}"
			name="{data.getIndex()}">
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
			{each $parents as $parent}
			<option value="<?php echo $parent[$data->getShow_value()]; ?>">
				<?php if(isset($parent['parent'])){ echo str_repeat('--', $parent['level']); } ?>
				<?php echo $parent[$data->getShow_name()]; ?>
			</option> {/each}

		</select>
		</div>
		<script type="text/javascript">
			$('#{data.getIndex()}{rand}').val('{data.getValue()}');
			$( "#{data.getIndex()}{rand}" ).select2( { placeholder: "{data.getLabel()}", maximumSelectionSize: 6 } );
        </script>
	</div>
</div>