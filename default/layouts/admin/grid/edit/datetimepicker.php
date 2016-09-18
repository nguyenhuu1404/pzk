{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{md-size}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label> <input
			id="{data.getIndex()}{rand}" name="{data.getIndex()}"
			value="{? if ($data->getType() != 'password') { echo @$data->getValue(); } ?}"
			type='text' class="form-control" />
		<script type="text/javascript">

        $(function () {

            $("#{data.getIndex()}{rand}").datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss'
            });
        });
    </script>
	</div>
</div>