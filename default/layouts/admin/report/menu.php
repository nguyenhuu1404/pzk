<?php
$controller = pzk_request('controller');
$action = pzk_request('action');
$setting = pzk_controller();
?>

<div class="list-group rightmenu">
    <div class="panel-default">
        <div class="panel-heading"><b>Menu</b></div>
    </div>

    <a class="list-group-item <?php if($action =='index') { echo 'active'; } ?>" href="{url /}{controller}/index">Danh sách</a>

</div>
