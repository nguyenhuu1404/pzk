<?php
$rand = rand(0, 100000);
?>
	<span class="hidden">{data.getLabel()}</span>
	<select id="{data.getIndex()}-{rand}" name="{data.getIndex()}" onchange="pzk_list.filter('{data.getType()}', '{data.getIndex()}', this.value);" >
		<option value="">Tất cả</option>
		{each $data->getOption() as $key=>$val}
		<option value="{key}">{val}</option>
		{/each}
	</select>
	<script type="text/javascript">
		$('#{data.getIndex()}-{rand}').val('{data.getValue()}');
    </script>