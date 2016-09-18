{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>

		<div class="input-append">
			<input onchange="closeModal(this,'#m{data.getIndex()}{rand}')"
				class="form-control" id="{data.getIndex()}{rand}"
				name="{data.getIndex()}" placeholder="{data.getLabel()}" type="text"
				value="{? if ($data->getType() != 'password') { echo @$data->getValue(); } ?}">
			<button type="button" class="btn btn-primary" data-toggle="modal"
				data-target="#m{data.getIndex()}{rand}">Select</button>
		</div>
	</div>


	<div id="m{data.getIndex()}{rand}" class="modal fade" tabindex="-1"
		role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title">{data.getLabel()}</h4>
				</div>
				<iframe width="100%" height="400"
					src="/3rdparty/Filemanager/filemanager/dialog.php?type=0&field_id={data.getIndex()}{rand}&fldr="
					frameborder="0"
					style="overflow: scroll; overflow-x: hidden; overflow-y: scroll;"></iframe>
			</div>
		</div>
	</div>
	<script>

    function closeModal(that, modalSelector) {
        var url = $(that).val();
        var res = url.replace(BASE_URL, '');
        $(that).val(res);
        $(modalSelector).modal('hide');
    }


</script>
</div>