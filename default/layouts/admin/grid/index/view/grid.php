<?php
$controller = pzk_controller();
$request = pzk_request();
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
$records = $data->getItems($keyword, $searchFields);
$countItems = $data->getCountItems($keyword, $searchFields);
$pages = ceil($countItems / $data->getPageSize());
$actions = $data->getActions();
//build data parent
if($listSettingType =='parent') {
	$items = treefy($records);
} else {
	$items = $records;
}
$quickMode = $data->getQuickMode();
$columnDisplay = $data->getColumnDisplay();
$normalMode = true;
if($quickFieldSettings = $data->getQuickFieldSettings()) {
	// nothing
} else {
	$quickFieldSettings = array(
		array(
			'index'	=> 'name',
			'type'	=> 'text',
			'label'	=> 'Tiêu đề'
		)
	);
}


if($quickMode) {
	$listFieldSettings = $quickFieldSettings;
	$colSize = 2;
	$normalMode = false;
	$data->setQuickMode(true);
} else {
	$colSize = 10;
	$normalMode = true;
	$data->setQuickMode(false);
}
?>
<?php if(!pzk_request()->getIsAjax()):?>
<style type="text/css">
h4 {
	font-size: 14px!important;
}
</style>
<div class="row">
	<div id="grid-nav" class="col-sm-2">
	{children [role=nav]}
	</div>
	
	<div id="grid-list" class="col-sm-{colSize}">
		<!-- Show data -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<a class="btn  btn-xs btn-danger" href="/admin_home/index" data-toggle="tooltip" data-placement="top" title="Trang Tổng"><span class="glyphicon glyphicon-dashboard"></span></a>
				<a class="btn  btn-xs btn-primary" href="#" onclick="pzk_list.toggleNavigation(); return false;" data-toggle="tooltip" data-placement="top" title="Thu gọn Bên Trái"><span class="glyphicon glyphicon-indent-right"></span></a>
				<a class="btn  btn-xs btn-primary" href="#" onclick="pzk_list.togglePadding(); return false;" data-toggle="tooltip" data-placement="top" title="Thu gọn dòng"><span class="glyphicon glyphicon-resize-small"></span></a>
				
				<b>{ifprop title}{data.getTitle()}{else}{request.getController()}/{request.getAction()}{/if}</b>
				<a style="margin-left: 5px;" class="btn  btn-xs btn-primary pull-right" href="#" onclick="pzk_list.verify();" data-toggle="tooltip" data-placement="top" title="Kiểm tra"><span class="glyphicon glyphicon-warning-sign"></span></a>
				<a style="margin-left: 5px;" class="btn  btn-xs btn-primary pull-right" href="{url /admin}_{data.getModule()}/changeQuickMode" data-toggle="tooltip" data-placement="top" title="Xem Nhanh"><span class="glyphicon glyphicon-list-alt"></span></a>
				<a style="margin-left: 5px;" class="btn  btn-xs btn-primary pull-right" href="#" onclick="$('#columnDialog').modal('show'); return false;" data-toggle="tooltip" data-placement="top" title="Ẩn / Hiện Cột"><span class="glyphicon glyphicon-th"></span></a>
				<?php if($data->getCheckAdd()) { ?>
					<a style="margin-left: 10px;" class="btn  btn-xs btn-primary pull-right" href="{url /admin}_{data.getModule()}/add"><span class="glyphicon glyphicon-plus"></span> {ifvar normalMode}{data.getAddLabel()}{/if}</a>
				<?php } ?>
				<span class="pull-right">
				{children [role=filter]}
				</span>
				<?php
				//add more menu link
				if($data->getLinks()) {
					foreach($data->getLinks() as $val) {
						
						?>
							<a target="{val[target]}" style="margin-left: 10px;" class="btn  btn-xs btn-primary pull-right " href="{val[href]}">{val[name]}</a>
						<?php
					}
				}
				?>

			</div>
			<table id="admin_table_{data.getId()}" class="table table-hover table-bordered table-striped table-condensed">
				<thead>
				<tr>
					<th><input type="checkbox" id="selecctall"/></th>
					<th>#</th>
					{each $listFieldSettings as $field}
					{? if ($columnDisplay && !@$columnDisplay[$field['index']]) { continue; }?}
					<th>
					<span title="{field[label]}" class="glyphicon glyphicon-remove-circle column-toogle-{field[index]}" style="cursor: pointer;" onclick="pzk_list.toogleDisplay('{field[index]}');"></span>
					{? if ($field['type'] == 'ordering') { ?}
						<span class="glyphicon glyphicon-floppy-disk" style="cursor: pointer;" onclick="pzk_list.saveOrdering('{field[index]}');"></span>
					{? } ?}
					<span class="column-header-{field[index]}">
					{? if ($field['type'] != 'group') { ?}
					<a href="#" onclick="pzk_list.toggleOrderBy('{field[index]}'); return false;">{field[label]}</a>
					{? } else { ?}
						{field[label]}
					{? } ?}
					{? if(@$field['filter']) { ?}
					<?php 
						$filterField = @$field['filter'];
						$filterFieldObj = pzk_obj ( 'core.db.grid.edit.' . $filterField ['type'] );
						foreach ( $filterField as $key => $val ) {
							$filterFieldObj->set ( $key, $val );
						}
						$filterFieldObj->setLayout ( 'admin/grid/index/filter/' . $filterField ['type'] );
						$value = $controller->getFilterSession ()->get ( $filterField ['index'] );
						$filterFieldObj->setValue ( $value );
						$filterFieldObj->display ();
					?>
					{? } ?}
					</span>
					&nbsp;<span class="column-sorter-{field[index]} glyphicon glyphicon-chevron-up" style="cursor: pointer;"></span>
					</th>
					{/each}
					{ifvar normalMode}
					<th>Hành động</th>
					{/if}
				</tr>
				</thead>
				<tbody>
				<tr>
					<td colspan="<?php echo (3 + count($listFieldSettings))?>">
					
					<form class="form-inline">
					{ifvar normalMode}<strong>Số mục: </strong>{/if}
					<select name="pageSize" class="form-control input-sm pageSize" onchange="pzk_list.changePageSize(this.value);">
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
					
					{ifvar normalMode}<strong>Trang: </strong>{/if}
					<?php for ($page = 0; $page < $pages; $page++) {
						if($pages > 10 && ($page < $data->pageNum - 5 || $page > $data->pageNum + 5) && $page != 0 && $page != $pages-1)
							continue;
						if($page == $data->pageNum) { $btn = 'btn-primary'; }
						else { $btn = 'btn-default'; }
					?>
					<a class="btn btn-xs {btn}" href="#" onclick="pzk_list.changePage({page}); return false;">{? echo ($page + 1)?}</a>
					<?php } ?>
					{ifvar normalMode}(<?php echo $countItems. ' bản ghi'; ?>){/if}{ifvar quickMode}<?php echo $countItems . ' rows'; ?>{/if}
					<?php if(count($actions)): ?>
					<div style="float:right;">
					<strong>Hành động: </strong>
				  <select id="gridAction" name="action" class="form-control input-sm">
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
				{each $items as $item}

				<tr id="row-{item[id]}">
					<td><input class="grid_checkbox" type="checkbox" name="grid_check[]" value="{item[id]}" /></td>
					<td style="white-space: nowrap;">{item[id]} | 
					{ifvar normalMode}
					<?php if($data->getCheckEdit()) { ?><a href="{url /admin}_{data.getModule()}/edit/{item[id]}" class="text-center"><span class="glyphicon glyphicon-edit"></span></a><?php } ?>
					{/if}
					</td>
					{? $isOrderingField = false; ?}
					{each $listFieldSettings as $field}
					{? if ($columnDisplay && !@$columnDisplay[$field['index']]) { continue; }?}
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
						$fieldObj->setRow($item);
						$fieldObj->setValue(@$item[$field['index']]);
					?}
						<td <?php if($isOrderingField): ?>style="white-space: nowrap;"<?php endif; ?>><span class="column-{field[index]}">{? $fieldObj->display(); ?}</span></td>
					{/each}
					{ifvar normalMode}
					<td style="white-space: nowrap"><?php if($data->getCheckEdit()) { ?><a href="{url /admin}_{data.getModule()}/edit/{item[id]}" class="text-center"><span class="glyphicon glyphicon-edit"></span></a><?php } ?>
					<?php if($data->getCheckDialog()) { ?><a href="#" onclick="pzk_list.dialog({item[id]}); return false;"><span class="glyphicon glyphicon-info-sign"></span></a><?php } ?>
					<?php if($data->getCheckDel()) { ?><a class="color_delete text-center" href="{url /admin}_{data.getModule()}/del/{item[id]}"><span class="glyphicon glyphicon-remove"></span><?php } ?>
					</td>
					{/if}
				</tr>
				{/each}
				<?php } ?>
				<tr>
					<td colspan="<?php echo (3 + count($listFieldSettings))?>">
					<form class="form-inline">
					{ifvar normalMode}<strong>Số mục: </strong>{/if}
					<select name="pageSize" class="pageSize form-control input-sm" onchange="pzk_list.changePageSize(this.value);">
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

					{ifvar normalMode}<strong>Trang: </strong>{/if}
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
				  <select id="gridAction" name="action" class="form-control input-sm">
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
				<?php if($data->getCheckDel()) { ?>
				<div  id="griddelete" style="margin-left: 10px;" class="btn  btn-sm pull-right btn-danger" >
					<span class="glyphicon glyphicon-remove"></span>{ifvar normalMode} Xóa tất{/if}
				</div>
				<?php } ?>
				<?php if($data->getCheckAdd()) { ?>
				<a class="btn  btn-sm btn-primary pull-right" href="{url /admin}_{data.getModule()}/add"><span class="glyphicon glyphicon-plus"></span> {ifvar normalMode}{data.getAddLabel()}{/if}</a>
				<?php } ?>
				<div>
				{children [role=export]}
				</div>


			</div>
		</div>
	</div>
	{ifvar quickMode}
	<div id="grid-detail" class="col-sm-8">
		
	</div>
	{/if}
</div>

	
<!-- Modal -->
<div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Chi tiết</h4>
      </div>
      <div class="modal-body">
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="columnDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ẩn hiện các cột</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="/admin_{data.getModule()}/columnDisplay">
		  <div class="form-group row">
		  
		  {each $listFieldSettings as $field}
			  {? 
			  $checked = 'checked';
			  if ($columnDisplay && !@$columnDisplay[$field['index']]) { $checked = ''; }?}
			<div class="col-sm-12">
				<label>
				  <input {checked} name="columnDisplay[{field[index]}]" value="1" type="checkbox"> {field[label]}
				</label>
			</div>
		  {/each}
		  </div>
		  <button type="submit" class="btn btn-default">Submit</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!-- js check all -->
<?php else: ?>
<tr>
		<td colspan="<?php echo (3 + count($listFieldSettings))?>">
		<form class="form-inline" role="form">
		{ifvar normalMode}<strong>Số mục: </strong>{/if}
		<select name="pageSize" class="pageSize form-control input-sm" onchange="pzk_list.changePageSize(this.value);">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="200">200</option>
		  </select>

		{ifvar normalMode}<strong>Trang: </strong>{/if}
		<?php for ($page = 0; $page < $pages; $page++) {
			if($pages > 10 && ($page < $data->pageNum - 5 || $page > $data->pageNum + 5) && $page != 0 && $page != $pages-1)
				continue;
			if($page == $data->pageNum) { $btn = 'btn-primary'; }
			else { $btn = 'btn-default'; }
		?>
		<a class="btn btn-xs {btn}" href="#" onclick="pzk_list.changePage({page}); return false;">{? echo ($page + 1)?}</a>
		<?php } ?>
		{ifvar normalMode}(<?php echo $countItems. ' bản ghi'; ?>){/if}{ifvar quickMode}<?php echo $countItems . ' rows'; ?>{/if}
		<?php if(count($actions)): ?>
		<div style="float:right;">
		<strong>Hành động: </strong>
	  <select id="gridAction" name="action" class="form-control input-sm">
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
	{each $items as $item}

	<tr id="row-{item[id]}">
		<td><input class="grid_checkbox" type="checkbox" name="grid_check[]" value="{item[id]}" /></td>
        <td>{item[id]}</td>
		{? $isOrderingField = false; ?}
		{each $listFieldSettings as $field}
		{? if ($columnDisplay && !@$columnDisplay[$field['index']]) { continue; }?}
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
			$fieldObj->setRow($item);
			$fieldObj->setValue(@$item[$field['index']]);
		?}
			<td <?php if($isOrderingField): ?>style="white-space: nowrap;"<?php endif; ?>><span class="column-{field[index]}">{? $fieldObj->display(); ?}</span></td>
		{/each}
		{ifvar normalMode}
		<td style="white-space: nowrap">
		<?php if($data->getCheckEdit()) { ?>
			<a href="{url /admin}_{data.getModule()}/edit/{item[id]}" class="text-center"><span class="glyphicon glyphicon-edit"></span></a>
			<?php } ?>
			<?php if($data->getCheckDialog()) { ?>
			<a href="#" onclick="pzk_list.dialog({item[id]}); return false;"><span class="glyphicon glyphicon-info-sign"></span></a>
			<?php } ?>
			<?php if($data->getCheckDel()) { ?>
			<a class="color_delete text-center" href="{url /admin}_{data.getModule()}/del/{item[id]}"><span class="glyphicon glyphicon-remove"></span>
			<?php } ?>
			</td>
		{/if}
		
	</tr>
	{/each}
    <?php } ?>
	<tr>
		<td colspan="<?php echo (3 + count($listFieldSettings))?>">
		<form class="form-inline" role="form">
		{ifvar normalMode}<strong>Số mục: </strong>{/if}
		<select name="pageSize" class="pageSize form-control input-sm" onchange="pzk_list.changePageSize(this.value);">
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

		{ifvar normalMode}<strong>Trang: </strong>{/if}
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
	  <select id="gridAction" name="action" class="form-control input-sm">
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