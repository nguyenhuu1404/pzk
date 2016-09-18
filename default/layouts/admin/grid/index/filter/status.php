<?php $rand = rand(0, 100000);
$controller = pzk_controller();
?>
<span class="hidden">{data.label}</span>
<select id="{data.index}-{rand}"
	name="{data.index}"
	onchange="pzk_list.filter('{data.type}', '{data.index}', this.value);">
	<option value="">All</option>
	<option value="1">Yes</option>
	<option value="0">No</option>

</select>
<script type="text/javascript">
	<?php $status = $controller->getFilterSession()->get($data->index); ?>
	$('#{data.index}-{rand}').val('{status}');
</script>