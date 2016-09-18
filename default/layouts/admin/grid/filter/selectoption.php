<?php 
$controller = pzk_controller(); 
$compact	= $data->getCompact();
$nocompact	= !$compact;
if($compact) {
	$data->setSelectLabel($data->getLabel());
}
?>
<div  class="form-group col-xs-12">
	{ifvar nocompact}<label>{data.getLabel()}</label><br />{/if}
	<select class="form-control"  id="{data.getIndex()}" name="{data.getIndex()}" onchange="pzk_list.filter('{data.getType()}', '{data.getIndex()}', this.value);" >
		{ifvar nocompact}
		<option value="">Tất cả</option>
		{else}
		<option value="">{data.getLabel()}</option>
		{/if}
		{each $data->getOption() as $key=>$val}
		<option value="{key}">{val}</option>
		{/each}
	</select>
	<script type="text/javascript">
		$('#{data.getIndex()}').val('{data.getValue()}');
    </script>
</div>