<?php
$keyword = pzk_session('admin_level_actionKeyword');

$adminLevelId = pzk_session('alaadminLevelId');
if($adminLevelId) {
    $data->conditions .= " and admin_level_id like '%$adminLevelId%'";
}

$adminController = pzk_session('alaadminController');
if($adminController) {
    $data->conditions .= " and admin_action like '%$adminController%'";
}



$pageSize = pzk_session('admin_level_actionPageSize');

if($pageSize) {
    $data->pageSize = $pageSize;
}
$data->pageNum = pzk_request('page');

$items = $data->getItems($keyword, array('action_type'));
$countItems = $data->getCountItems($keyword, array('action_type'));
$pages = ceil($countItems / $data->pageSize);



$level = _db()->select('level,id')->from('pzk_admin_level')->result();
if (!function_exists('getLevelName')) {
    function getLevelName($item, $level) {
        foreach($level as $val) {
            if($val['id'] == $item) {
                return $val['level'];
            }
        }
    }
}
$menu = _db()->select('*')->from('pzk_admin_menu')->result();
if (!function_exists('getMenu')) {
    function getMenu($item, $menu) {
        foreach($menu as $val) {
            if($val['admin_controller'] == $item) {
                return $val['name'];
            }
        }
    }
}
$menuTree = treefy($menu);
?>

<div class="well">
    <form role="search" action="{url /admin_levelaction/searchPost}">
        <div class="row">
            <div class="form-group col-xs-2">
                <label for="keyword">Action cho phép</label><br />
                <input class="form-control input-sm" type="text" name="keyword" id="keyword"  placeholder="Action" value="{keyword}" />
            </div>

            <div class="form-group col-xs-3">
                <label for="categoryId">Chọn level</label><br />
                <select id="adminLevelId" name="adminLevelId" class="form-control input-sm" placeholder="Danh mục" onchange="window.location='{url /admin_levelaction/changeAdminLevelId}?adminLevelId=' + this.value;">
                    <option value="">-- Tất cả --</option>
                    {each $level as $val}
                    <option value="{val[id]}">{val[level]}</option>
                    {/each}
                </select>
                <script type="text/javascript">
                    $('#adminLevelId').val('{adminLevelId}');
                </script>
            </div>

            <div class="form-group col-xs-3">
                <label for="categoryId">Chọn menu</label><br />
                <select id="adminController" name="adminController" class="form-control input-sm" placeholder="Danh mục" onchange="window.location='{url /admin_levelaction/changeAdminController}?adminController=' + this.value;">
                    <option value="">-- Tất cả --</option>
                    {each $menuTree as $cat}
                    <option value="{cat[admin_controller]}"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $cat['level']);?>{cat[name]}</option>
                    {/each}
                </select>
                <script type="text/javascript">
                    $('#adminController').val('{adminController}');
                </script>
            </div>

            <div class="form-group col-xs-1">
                <label>&nbsp;</label> <br />
                <button type="submit" name ="submit_action" class="btn btn-primary btn-sm" value="<?=ACTION_SEARCH?>"><span class="glyphicon glyphicon-search"></span> Search</button>
            </div>
            <div class="form-group col-xs-1">
                <label>&nbsp;</label> <br />
                <button type="submit" name =submit_action class="btn btn-default btn-sm" value="<?=ACTION_RESET?>"><span class="glyphicon glyphicon-refresh"></span>Reset</button>
            </div>
        </div>
    </form>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Danh sách các quyền theo controller action
        <div  id="griddelete" style="margin-left: 10px; margin-top: -5px;" class="btn  btn-sm pull-right btn-danger">
            <span class="glyphicon glyphicon-remove"></span> Xóa tất
        </div>
            <a class="btn btn-primary btn-xs pull-right" role="button" href="{url /admin_levelaction/add}"><span class="glyphicon glyphicon-circle-arrow-right"></span> Thêm quyền</a>
    </div>
    <table class="table">
        <tr>
            <th><input type="checkbox" id="selecctall"/></th>
            <th>#</th>
            <th>Tên level</th>
            <th>Tên menu</th>
            <th>Action cho phép</th>
            <th>Status</th>
            <th>Ngày tạo</th>

            <th colspan="2">Action</th>
        </tr>
        {each $items as $item}
        <?php
            $levelName = getLevelName($item['admin_level_id'], $level);
            $menuName = getMenu($item['admin_action'], $menu);
        ?>
        <tr>
            <td><input class="grid_checkbox" type="checkbox" name="grid_check[]" value="{item[id]}" /></td>
            <td>{item[id]}</td>
            <td>{levelName}</td>
            <td>{menuName}</td>
            <td>{item[action_type]}</td>
            <td>
                <?php  if($item['status'] == '1') { ?>
                <span class="glyphicon glyphicon-star" style="color: blue; font-size: 120%; cursor: pointer;" onclick="window.location='onChangeStatus?field=status&id={item[id]}'"></span>
                <?php } else { ?>
                <span class="glyphicon glyphicon-star" style="color: black; font-size: 100%; cursor: pointer;" onclick="window.location='onChangeStatus?field=status&id={item[id]}'"></span>
                <?php } ?>
            </td>
            <td><?php echo date('d/m/y H:i', strtotime($item['created'])); ?></td>
            <td width="7%">
                <a class="color_delete text-center" onclick="return confirm_delete('Do you want delete this record?')" title="Xóa" href="{url /admin_levelaction/del}/{item[id]}"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
        {/each}
    </table>
</div>


<div class="clearfix pull-right">
    <form class="form-inline" role="form">
        <strong>Số mục: </strong>
        <select id="pageSize" name="pageSize" class="form-control" placeholder="Số mục / trang" onchange="window.location='{url /admin_levelaction/changePageSize}?pageSize=' + this.value;">
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
        <?php
        for ($page = 0; $page < $pages; $page++):?>
            <?php
            if($page == $data->pageNum) {
                $btn = 'btn-primary';
            } else {
                $btn = 'btn-default';
            }
            ?>
            <a class="btn {btn}" href="{url /admin_levelaction/index}?page={page}">{? echo ($page + 1)?}</a>
        <?php endfor; ?>
    </form>

</div>

