<?php
$controller = pzk_controller();
$time = $_SERVER['REQUEST_TIME'];
$username = pzk_session('adminUser');
if(!$username) $username = 'ongkien';
$token = md5($time.$username . 'onghuu');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Import dữ liệu</b>
    </div>
    <div class="panel-body borderadmin">
<form enctype="multipart/form-data" method="post" action="/admin_{controller.module}/importPost?token={token}&time={time}">
    <div class="form-group clearfix">
        <label for="{field[index]}">Chọn file(excel)</label>
        <input name="file" type="file"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved"></span> Cập nhật</button>
        <a class="btn btn-default" href="{url /admin}_{controller.module}/index"><span class="glyphicon glyphicon-refresh"></span> Quay lại</a>
    </div>
</form>
</div>
</div>