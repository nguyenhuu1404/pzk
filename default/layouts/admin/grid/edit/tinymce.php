{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>
		<div style="float: left; width: 100%;" class="item">
			<textarea id="{data.getIndex()}{rand}" class="tinymce"
				name="{data.getIndex()}">{data.getValue()}</textarea>
		</div>
	</div>
</div>
