<?php $item = $data->getItem();
?>
<form role="form" method="post" action="{url /admin_levelaction/delPost}">
    <input type="hidden" name="id" value="{item[id]}" />
    <div class="form-group">
        <label for="name">Bạn có chắc muốn xóa ?</label>
        <input type="text" disabled class="form-control" id="action_type" name="action_type"  value="{item[action_type]}" />
    </div>
    <button type="submit" class="btn btn-primary">Đúng</button>
    <a href="{url /admin_levelaction/index}">Không, quay lại</a>
</form>