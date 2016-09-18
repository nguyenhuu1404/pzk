<?php
$sortFields = $data->getSortFields();
$filedFilters = $data->getFilterFields();
$searchFields = $data->getSearchFields();
$Searchlabels = $data->getSearchLabels();
//type setting
$listSettingType = $data->getListSettingType();
$listFieldSettings = $data->getListFieldSettings();

$orderBy = $data->getOrderBy();
$pageSize = $data->getPageSize();

$keyword = $data->getKeyword();
$items = $data->getItems($keyword, $searchFields);
$countItems = $data->getCountItems($keyword, $searchFields);
$pages = ceil($countItems / $data->getPageSize());
$actions = $data->getActions();

//build data parent
if($listSettingType =='parent') {
    $items = treefy($items);
}

?>
<?php if(!pzk_request()->getIsAjax()):?>
{children [role=nav]}
<!-- Show data -->
<div class="panel panel-default">
    <div class="panel-heading">
        <b>{data.getTitle()} (<?php echo $countItems. ' bản ghi'; ?>)</b>
    </div>
<table id="admin_table_{data.getId()}" class="table table-hover">
	<thead>
	<tr>
		<th><input type="checkbox" id="selecctall"/></th>
        <th style="background: #6a737b; color: #fff;">#</th>
		{each $listFieldSettings as $field}
		<th style="background: {field[bgcolor]}; color: {field[color]}">
		{? if ($field['type'] == 'ordering') { ?}
			<span class="glyphicon glyphicon-floppy-disk" style="cursor: pointer;" onclick="pzk_list.saveOrdering('{field[index]}');"></span>
		{? } ?}
		{field[label]}
		</th>
		{/each}
		<th colspan="2">Hành động</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="20">
		<form class="form-inline" role="form">
		<strong>Số mục: </strong>
		<select class="pageSize" name="pageSize" class="form-control input-sm" placeholder="Số mục / trang" onchange="pzk_list.changePageSize(this.value);">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="200">200</option>
		  </select>
		  <script type="text/javascript">
			$('#pageSize').val('{pageSize}');
		  </script>
		  
		<strong>Trang: </strong>
		<?php for ($page = 0; $page < $pages; $page++) { 
			if($pages > 10 && ($page < $data->pageNum - 5 || $page > $data->pageNum + 5) && $page != 0 && $page != $pages-1)
				continue;
			if($page == $data->pageNum) { $btn = 'btn-primary'; } 
			else { $btn = 'btn-default'; }
		?>
		<a class="btn btn-xs {btn}" href="#" onclick="pzk_list.changePage({page}); return false;">{? echo ($page + 1)?}</a>
		<?php } ?>
		<?php if(count($actions)): ?>
		<div style="float:right;">
		<strong>Hành động: </strong>
	  <select id="gridAction" name="action" class="form-control input-sm" placeholder="Thao tác">
			<option selected="selected" value="">Thao tác</option>
			{each $actions as $action}
				<option value="{action[value]}">{action[label]}</option>
			{/each}
		</select>
		<div  id="gridaction" style="margin-left: 10px;" class="btn  btn-sm pull-right btn-danger" onclick="pzk_{data.getId()}.performAction()" >
            <span class="glyphicon glyphicon-execute"></span> Thực hiện
        </div>
		</div>
		<?php endif; ?>
		</form>
		</td>
	</tr>
    <?php if($items) {  ?>
	<tr>
		<td colspan="<?= 4 + count($listFieldSettings); ?>">
	<div class="row">
	{each $items as $item}
		<div class="col-md-{data.getColumns()}">
		<div style="background: #6a737b; color: #fff; padding: 5px;">
		<input class="grid_checkbox" type="checkbox" name="grid_check[]" value="{item[id]}" />
        {item[id]}
		</div>
		{? $isOrderingField = false; ?}
		{each $listFieldSettings as $field}
		<div style="background: {field[bgcolor]}; color: {field[color]}; padding: 5px;">
		<strong style="width: 120px; display: inline-block;">{field[label]}: </strong>
		{? 
			$fieldObj = pzk_obj('core.db.grid.field.' . $field['type']); 
			foreach($field as $key => $val) {
				$fieldObj->set($key, $val);
			}
			$fieldObj->setItemId($item['id']);
			if($fieldObj->getType() == 'parent') {
				$fieldObj->setLevel($item['level']);
			}
			if($listSettingType &&  $fieldObj->getType() == 'ordering') {
				$isOrderingField = true;
				$fieldObj->setLevel($item['level']);
			}
			$fieldObj->setValue(@$item[$field['index']]);
		?}
			{? $fieldObj->display(); ?}&nbsp;
		</div>
		{/each}
		<a href="{url /admin}_{data.getModule()}/edit/{item[id]}" class="text-center"><span class="glyphicon glyphicon-edit"></span> Sửa</a>
		<a class="color_delete text-center" href="{url /admin}_{data.getModule()}/del/{item[id]}"><span class="glyphicon glyphicon-remove"></span> Xóa</a>
		<hr />
		</div>
	{/each}
	</div>
		</td>
	</tr>
    <?php } ?>
	<tr>
		<td colspan="20">
		<form class="form-inline" role="form">
		<strong>Số mục: </strong>
		<select class="pageSize" name="pageSize" class="form-control input-sm" placeholder="Số mục / trang" onchange="pzk_list.changePageSize(this.value);">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="200">200</option>
		  </select>
		  <script type="text/javascript">
			$('.pageSize').val('{pageSize}');
		  </script>
		  
		<strong>Trang: </strong>
		<?php for ($page = 0; $page < $pages; $page++) { 
			if($pages > 10 && ($page < $data->pageNum - 5 || $page > $data->pageNum + 5) && $page != 0 && $page != $pages-1)
				continue;
			if($page == $data->pageNum) { $btn = 'btn-primary'; } 
			else { $btn = 'btn-default'; }
		?>
		<a class="btn btn-xs {btn}" href="#" onclick="pzk_list.changePage({page}); return false;">{? echo ($page + 1)?}</a>
		<?php } ?>
		<?php if(count($actions)): ?>
		<div style="float:right;">
		<strong>Hành động: </strong>
	  <select id="gridAction" name="action" class="form-control input-sm" placeholder="Thao tác">
			<option selected="selected" value="">Thao tác</option>
			{each $actions as $action}
				<option value="{action[value]}">{action[label]}</option>
			{/each}
		</select>
		<div  id="gridaction" style="margin-left: 10px;" class="btn  btn-sm pull-right btn-danger" onclick="pzk_{data.getId()}.performAction()" >
            <span class="glyphicon glyphicon-execute"></span> Thực hiện
        </div>
		</div>
		<?php endif; ?>
		</form>
		</td>
	</tr>
	
	</tbody>
</table>
    <div class="panel-footer item">
        <div  id="griddelete" style="margin-left: 10px;" class="btn  btn-sm pull-right btn-danger" >
            <span class="glyphicon glyphicon-remove"></span> Xóa tất
        </div>
        {children [role=export]}
        <a class="btn  btn-sm btn-primary pull-right" href="{url /admin}_{data.getModule()}/add"><span class="glyphicon glyphicon-plus"></span> {data.getAddLabel()}</a>
    </div>
</div>
<!-- js check all--->
<?php else: ?>
<tr>
		<td colspan="20">
		<form class="form-inline" role="form">
		<strong>Số mục: </strong>
		<select class="pageSize" name="pageSize" class="form-control input-sm" placeholder="Số mục / trang" onchange="pzk_list.changePageSize(this.value);">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="200">200</option>
		  </select>
		  
		<strong>Trang: </strong>
		<?php for ($page = 0; $page < $pages; $page++) { 
			if($pages > 10 && ($page < $data->pageNum - 5 || $page > $data->pageNum + 5) && $page != 0 && $page != $pages-1)
				continue;
			if($page == $data->pageNum) { $btn = 'btn-primary'; } 
			else { $btn = 'btn-default'; }
		?>
		<a class="btn btn-xs {btn}" href="#" onclick="pzk_list.changePage({page}); return false;">{? echo ($page + 1)?}</a>
		<?php } ?>
		<?php if(count($actions)): ?>
		<div style="float:right;">
		<strong>Hành động: </strong>
	  <select id="gridAction" name="action" class="form-control input-sm" placeholder="Thao tác">
			<option selected="selected" value="">Thao tác</option>
			{each $actions as $action}
				<option value="{action[value]}">{action[label]}</option>
			{/each}
		</select>
		<div  id="gridaction" style="margin-left: 10px; background: #6a737b; color: #fff;" class="btn  btn-sm pull-right btn-danger" onclick="pzk_{data.getId()}.performAction()" >
            <span class="glyphicon glyphicon-execute"></span> Thực hiện
        </div>
		</div>
		<?php endif; ?>
		</form>
		</td>
	</tr>
    <?php if($items) {  ?>
	<tr>
		<td colspan="<?= 4 + count($listFieldSettings); ?>">
	<div class="row">
	{each $items as $item}
		<div class="col-md-{data.getColumns()}">
		<div style="background: #6a737b; color: #fff; padding: 5px;">
		<input class="grid_checkbox" type="checkbox" name="grid_check[]" value="{item[id]}" />
        {item[id]}
		</div>
		{? $isOrderingField = false; ?}
		{each $listFieldSettings as $field}
		<div style="background: {field[bgcolor]}; color: {field[color]}; padding: 5px;">
		<strong style="width: 120px; display: inline-block;">{field[label]}: </strong>
		{? 
			$fieldObj = pzk_obj('core.db.grid.field.' . $field['type']); 
			foreach($field as $key => $val) {
				$fieldObj->set($key, $val);
			}
			$fieldObj->setItemId($item['id']);
			if($fieldObj->getType() == 'parent') {
				$fieldObj->setLevel($item['level']);
			}
			if($listSettingType &&  $fieldObj->getType() == 'ordering') {
				$isOrderingField = true;
				$fieldObj->setLevel($item['level']);
			}
			$fieldObj->setValue(@$item[$field['index']]);
		?}
			{? $fieldObj->display(); ?}&nbsp;
		</div>
		{/each}
		<div style="">
		<a href="{url /admin}_{data.getModule()}/edit/{item[id]}" class="text-center"><span class="glyphicon glyphicon-edit"></span> Sửa</a>
		<a class="color_delete text-center" href="{url /admin}_{data.getModule()}/del/{item[id]}"><span class="glyphicon glyphicon-remove"></span> Xóa</a>
		</div>
		<hr />
		</div>
	{/each}
	</div>
		</td>
	</tr>
    <?php } ?>
	<tr>
		<td colspan="20">
		<form class="form-inline" role="form">
		<strong>Số mục: </strong>
		<select class="pageSize" name="pageSize" class="form-control input-sm" placeholder="Số mục / trang" onchange="pzk_list.changePageSize(this.value);">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="200">200</option>
		  </select>
		  <script type="text/javascript">
			$('.pageSize').val('{pageSize}');
		  </script>
		  
		<strong>Trang: </strong>
		<?php for ($page = 0; $page < $pages; $page++) { 
			if($pages > 10 && ($page < $data->pageNum - 5 || $page > $data->pageNum + 5) && $page != 0 && $page != $pages-1)
				continue;
			if($page == $data->pageNum) { $btn = 'btn-primary'; } 
			else { $btn = 'btn-default'; }
		?>
		<a class="btn btn-xs {btn}" href="#" onclick="pzk_list.changePage({page}); return false;">{? echo ($page + 1)?}</a>
		<?php } ?>
		<?php if(count($actions)): ?>
		<div style="float:right;">
		<strong>Hành động: </strong>
	  <select id="gridAction" name="action" class="form-control input-sm" placeholder="Thao tác">
			<option selected="selected" value="">Thao tác</option>
			{each $actions as $action}
				<option value="{action[value]}">{action[label]}</option>
			{/each}
		</select>
		<div  id="gridaction" style="margin-left: 10px;" class="btn  btn-sm pull-right btn-danger" onclick="pzk_{data.getId()}.performAction()" >
            <span class="glyphicon glyphicon-execute"></span> Thực hiện
        </div>
		</div>
		<?php endif; ?>
		</form>
		</td>
	</tr>
<?php endif;?>