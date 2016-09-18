<span class="hidden">{data.getLabel()}</span>
<select id="{data.getIndex()}-{rand}" name="{data->getIndex()}" onchange="pzk_list.filter('{data->getType()}', '{data.getIndex()}', this.value);">
	<?php
$parents = _db ()->select ( '*' )->from ( $data->getTable() )->where(pzk_or($data->getCondition(), '1'))->result ();
	if (isset ( $parents [0] ['parent'] )) {
		$parents = treefy ( $parents, 'parent', 0 );
		echo "<option value='' >--Tất cả</option>";
	} else {
		echo "<option value=''>Tất cả</option>";
	}
	?>
	<?php if($data->getNotAccept() == '1'):?>
		<option value='0'>(Trống)</option>
	<?php endif;?>
	{each $parents as $parent}
	<option value="<?php echo $parent[$data->getShow_value()]; ?>"><?php if(isset($parent['parent'])){ echo str_repeat('--', @$parent['level']); } ?>
		<?php echo $parent[$data->getShow_name()]; ?>
	</option> {/each}
</select>
<script type="text/javascript">
	$('#{data.getIndex()}-{rand}').val('{data.getValue()}');
</script>