{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label> <input
			type="{data.getType()}" class="form-control"
			id="{data.getIndex()}{rand}" name="{data.getIndex()}"
			placeholder="{data.getLabel()}"
			value="{? if ($data->getType() != 'password') { 
			if($data->getType() == 'date') {
				echo date('Y-m-d', strtotime(@$data->getValue()));
			} else {
				echo @$data->getValue();
			}
			 
			
			} ?}" />
	</div>
</div>