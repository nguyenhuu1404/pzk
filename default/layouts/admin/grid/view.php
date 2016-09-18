{? $item = $data->getItem();
$listSettingType = $data->getListSettingType();
$fieldSettings = $data->getFieldSettings();
$grid = $data->getChildGrid();
$detail = $data->getParentDetail();
$childrenGridSettings = $data->getChildrenGridSettings();
$parentDetailSettings = $data->getParentDetailSettings();
$gridIndex = $data->getGridIndex();
?}
	{? if(!$data->getIsChildModule()): ?}
	<h1 class="text-center">{item[name]}{item[title]}</h1>
	<div class="navbar-collapse collapse navbar-default">
	<ul class="nav navbar-nav">
		<li><a class="label label-info" href="/admin_{data.getModule()}/index">Quay lại</a></li>
		<li><a class="label label-warning" href="/admin_{data.getModule()}/edit/{data.getItemId()}">Sửa</a></li>
		<li class="{? if(!$gridIndex) echo 'active';?}"><a href="/admin_{data.getModule()}/view/{data.getItemId()}">Chi tiết</a></li>
	{ifvar childrenGridSettings}
	{each $childrenGridSettings as $gridFieldSettings}
		{? if($gridFieldSettings['index'] == $gridIndex){ $active = 'active'; } else { $active = ''; } ?}
		<li class="{active}"><a class="{active}" href="/admin_{data.getModule()}/view/{data.getItemId()}/{gridFieldSettings[index]}">{gridFieldSettings[label]}</a></li>
	{/each}
	{/if}
	{ifvar parentDetailSettings}
	{each $parentDetailSettings as $detailSettings}
		{? if($detailSettings['index'] == $gridIndex){ $active = 'active'; } else { $active = ''; } ?}
		<li class="{active}"><a class="{active}" href="/admin_{data.getModule()}/view/{data.getItemId()}/{detailSettings[index]}">{detailSettings[label]}</a></li>
	{/each}
	{/if}
	</ul>
	</div>
	{?	endif; ?}
	<br />

{ifvar detail}
	{? 
		$detail->setItemId($item[$detail->getReferenceField()]);
		$detail->display();
		
		?}
{else}
{ifvar grid}
	{? $grid->display(); ?}
{else}

{ifvar fieldSettings}
<div class="jumbotron">
{each $fieldSettings as $field}
	<div class="container">
		<div class="row">
			<div class="col-xs-2"><strong>{field[label]}</strong></div>
			<div class="col-xs-10">
		{?					
							$fieldObj = pzk_obj('core.db.grid.field.' . $field['type']);
							foreach($field as $key => $val) {
								$fieldObj->set($key, $val);
							}
							$fieldObj->setItemId($item['id']);
							if($fieldObj->getType() == 'parent') {
								$fieldObj->setLevel(@$item['level']);
							}
							if($listSettingType &&  $fieldObj->getType() == 'ordering') {
								$isOrderingField = true;
								$fieldObj->setLevel(@$item['level']);
							}
							$fieldObj->setRow($item);
							$fieldObj->setValue(@$item[$field['index']]);
							$fieldObj->display();
						?}
			</div>
		</div>
	</div>
{/each}
</div>
{else}
	{each $item as $val}
		{val}<br />
	{/each}
{/if}
{/if}
{/if}