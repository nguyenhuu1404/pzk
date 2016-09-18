<?php $rand = rand(0, 100000);
$controller = pzk_controller();
?>
<span class="hidden"><?php echo isset($data)?$data->label: '';?></span>
<select id="<?php echo isset($data)?$data->index: '';?>-<?php echo isset($rand)?$rand: '';?>"
	name="<?php echo isset($data)?$data->index: '';?>"
	onchange="pzk_list.filter('<?php echo isset($data)?$data->type: '';?>', '<?php echo isset($data)?$data->index: '';?>', this.value);">
	<option value="">All</option>
	<option value="1">Yes</option>
	<option value="0">No</option>

</select>
<script type="text/javascript">
	<?php $status = $controller->getFilterSession()->get($data->index); ?>
	$('#<?php echo isset($data)?$data->index: '';?>-<?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($status)?$status: '';?>');
</script>