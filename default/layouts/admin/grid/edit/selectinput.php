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
		{ifvar nocompact}<label for="{data.getIndex()}{rand}">{data.getLabel()}</label> {/if}
		<select
			class="form-control" id="{data.getIndex()}{rand}"
			name="{data.getIndex()}">
            <?php
												$table = $data->getTable ();
												$items = _db ()->useCB ()->select ( '*' )->from ( $table )->result ();
												if (isset ( $items [0] ['parent'] )) {
													$items = treefy ( $items );
												}
												?>
			{ifvar compact}
				<option value="">{data.getLabel()}</option>
			{/if}
            {each $items as $val }
            <option value="<?php echo $val[$data->getShow_value()]; ?>"> 
            	<?php if(isset($val['parent'])){ echo str_repeat('&nbsp;&nbsp;', $val['level']); } ?>
            	<?php echo $val[$data->getShow_name()]; ?></option> {/each}

		</select> <input id="<?php echo $data->getHidden().$rand; ?>"
			type="hidden" name="<?php echo $data->getHidden(); ?>"
			value="{data.getValue()}" />
	</div>
</div>
<script>
        $('#{data.getIndex()}{rand}').change(function() {
            var optionSelected = $(this).find("option:selected");
            var textSelected   = optionSelected.text().trim();
            $('#{data.getHidden()}{rand}').val(textSelected);
        });
        $('#{data.getIndex()}{rand}').val('{data.getValue()}');
		$('#{data.getIndex()}{rand}').change();
    </script>