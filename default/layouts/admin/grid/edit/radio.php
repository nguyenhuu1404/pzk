{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>
    <?php $options = $data->getOptions(); $val = $data->getValue();?>
    {each $options as $key =>$item}
        <input type="{data.getType()}"
			<?Php if($key == $val){ echo 'checked'; } ?>
			id="{data.getIndex()}{rand}" name="{data.getIndex()}"
			placeholder="{data.getLabel()}" value="{key}" />{item} {/each}
	</div>
</div>