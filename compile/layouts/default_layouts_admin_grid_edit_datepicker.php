<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 		12);
$mdsize 		= pzk_or($data->getMdsize(), 	12);
?>
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label> <input
			id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" name="<?php echo isset($data)?$data->getIndex(): '';?>"
			value="<?php if ($data->getType() != 'password') { echo @$data->getValue(); } ?>"
			type='text' class="form-control" />
		<script type="text/javascript">
        $(function () {
            $("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
	</div>
</div>