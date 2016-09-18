{? if($data->getSwitchType() == 'bootstrap') : ?}
<input id="switch-{data.getIndex()}-{data.getItemId()}" type="checkbox" {if $data->getValue()}checked="checked"{/if} data-size="mini" /><script type="text/javascript">jQuery('#switch-{data.getIndex()}-{data.getItemId()}').bootstrapSwitch({onSwitchChange: function(evt,state) { {event changeStatus}({id: {data.getItemId()}, status: state}); }})</script>
{else}
	{? if($data->getValue() == '1') : ?}
		<span class="glyphicon glyphicon-{? echo pzk_or(@$data->getIcon(), 'star'); ?}" style="color: blue; font-size: 120%; cursor: pointer;" onclick="pzk_list.changeStatus('{data.getIndex()}', {data.getItemId()}, this);"></span>
	{else}
		<span class="glyphicon glyphicon-{? echo pzk_or(@$data->getIcon(), 'star'); ?}" style="color: black; font-size: 100%; cursor: pointer;" onclick="pzk_list.changeStatus('{data.getIndex()}', {data.getItemId()}, this);"></span>
	{/if}
{/if}
