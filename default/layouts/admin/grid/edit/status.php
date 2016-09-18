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
			<option value="0">Chưa kích hoạt</option>
			<option value="1">Đã kích hoạt</option>
		</select>
	</div>
</div>
<script>
	$('#{data.getIndex()}{rand}').val('{data.getValue()}');
  </script>