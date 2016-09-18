{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>
		<textarea class="form-control" id="{data.getIndex()}{rand}"
			name="{data.getIndex()}" placeholder="{data.getLabel()}" rows="6">{data.getValue()}</textarea>
	</div>
</div>