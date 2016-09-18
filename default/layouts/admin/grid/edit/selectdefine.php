{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
$compact	= $data->getCompact();
$nocompact	= !$compact;
if($compact) {
	$data->setSelectLabel($data->getLabel());
}
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		{ifvar nocompact}<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>{/if}
		<div style="float: left; width: 100%;" class="item">
			<select class="form-control" id="{data.getIndex()}{rand}"
				name="{data.getIndex()}">
				{ifvar compact}<option value="">{data.getLabel()}</option>{/if}
                <?php $options = json_decode($data->getOptions());?>
                {each $options as $key=>$val}
                <option value="{key}">{val}</option> {/each}
			</select>
		</div>
	</div>
</div>
<script type="text/javascript">
		$('#{data.getIndex()}{rand}').val('{data.getValue()}');
    </script>