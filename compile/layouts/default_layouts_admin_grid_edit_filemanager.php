<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label>

		<div class="input-append">
			<input onchange="closeModal(this,'#m<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>')"
				class="form-control" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"
				name="<?php echo isset($data)?$data->getIndex(): '';?>" placeholder="<?php echo isset($data)?$data->getLabel(): '';?>" type="text"
				value="<?php if ($data->getType() != 'password') { echo @$data->getValue(); } ?>">
			<button type="button" class="btn btn-primary" data-toggle="modal"
				data-target="#m<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>">Select</button>
		</div>
	</div>


	<div id="m<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" class="modal fade" tabindex="-1"
		role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo isset($data)?$data->getLabel(): '';?></h4>
				</div>
				<iframe width="100%" height="400"
					src="/3rdparty/Filemanager/filemanager/dialog.php?type=0&field_id=<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>&fldr="
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