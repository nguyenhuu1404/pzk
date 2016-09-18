{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label> <select
			class="form-control" id="{data.getIndex()}{rand}"
			name="{data.getIndex()}">
            <?php
												$tables = $data->getTables ();
												if (isset ( $tables )) {
													foreach ( $tables as $table ) {
													}
												}
												$parents = _db ()->select ( '*' )->from ( $data->getTable () )->where ( pzk_or ( @$data->getCondition (), '1' ) )->result ();
												if (isset ( $parents [0] ['parent'] )) {
													$parents = buildArr ( $parents, 'parent', 0 );
													echo "<option value='0'>&nbsp;&nbsp;&nbsp;&nbsp;Danh m?c g?c</option>";
												} else {
													echo "<option value='0'>" . pzk_or ( @$data->getSelectLabel (), '--Ch?n m?t m?c--' ) . " </option>";
												}
												?>
			{each $parents as $parent}
			<option value="<?php echo $parent[$data->getShow_value()]; ?>">
				<?php if(isset($parent['parent'])){ echo str_repeat('--', $parent['level']); } ?>
				<?php echo $parent[$data->getShow_name()]; ?>
			</option> {/each}

		</select>
		<script type="text/javascript">
			$('#{data.getIndex()}{rand}').val('{data.getValue()}');
        </script>
	</div>
</div>