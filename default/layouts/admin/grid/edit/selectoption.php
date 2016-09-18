{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>
		<div class="item">
			<select class="form-control" id="{data.getIndex()}{rand}"
				name="{data.getIndex()}">
				<option>Tất cả</option> {each $data->getOption() as $key=>$val}
				<option value="{key}">{val}</option> {/each}
			</select>
		</div>
	</div>
</div>
<script type="text/javascript">
		$('#{data.getIndex()}{rand}').val('{data.getValue()}');
    </script>