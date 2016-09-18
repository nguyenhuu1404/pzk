{? $rules = $data->getRules();
	$state = $data->getState();
	$role = pzk_session()->getAdminLevel();
	$controller = pzk_controller();
?}
<select id="{data.getIndex()}-{data.getItemId()}" name="workflow[{data.getIndex()}][{data.getItemId()}]"
onchange="pzk_list.workflow('{data.getIndex()}', {data.getItemId()}, this.value, this);"
>
	<option value="{data.getValue()}">{state}</option>
	{each $rules as $index => $settings}
		{? 
		$roles = explodetrim(',', @$settings['adminLevel']);
		if ($role == 'Administrator' || in_array($role, $roles)) { ?}
		<option value="{index}"> -&gt; {settings[action]}</option>
		{? } ?}
	{/each}
</select>