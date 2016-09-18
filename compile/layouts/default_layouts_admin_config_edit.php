<?php
$controller = pzk_controller();
$fieldSettings = pzk_request()->getConfig() . 'FieldSettings';
$addFieldSettings = $controller->$fieldSettings;
$row = array();
$storeType = pzk_session()->getStoreType();
if($storeType == 'app') {
	$row = pzk_app_store()->getConfig();
} else {
	$row = pzk_site_store()->getConfig();
}



?>

<div class="panel panel-default">
    <div class="panel-heading">
        <b><?php echo $controller->addLabel; ?></b>
    </div>
    <div class="panel-body borderadmin">
    	<strong>Cấu hình cho: </strong>
    	<select id="storeType" name="storeType" onchange="window.location='<?php echo BASE_REQUEST . '/admin'; ?>_<?php echo isset($controller)?$controller->module: '';?>/changeStoreType?config=<?php echo pzk_request()->getConfig(); ?>&storeType=' + this.value;">
    		<option value="site">Trang web</option>
    		<option value="app">Ứng dụng</option>
    	</select>
    	<script type="text/javascript">
			$('#storeType').val('<?php echo isset($storeType)?$storeType: '';?>');
    	</script>
        <form id="<?php echo isset($controller)?$controller->module: '';?>AddForm" role="form" enctype="multipart/form-data" method="post" action="<?php echo BASE_REQUEST . '/admin'; ?>_<?php echo isset($controller)?$controller->module: '';?>/writePost?config=<?php echo pzk_request()->getConfig(); ?>">
            <input type="hidden" name="id" value="" />

                <?php foreach ( $addFieldSettings as $field ) : ?>
                <?php
                if ($field['type'] == 'text' || $field['type'] == 'date' || $field['type'] == 'email' || $field['type'] == 'password') {
                $fieldObj = pzk_obj('core.db.grid.edit.input');
                } else {
                $fieldObj = pzk_obj('core.db.grid.edit.' . $field['type']);
                }

                foreach($field as $key => $val) {
                $fieldObj->set($key, $val);
                }
                $fieldObj->setValue(@$row[$field['index']]);
                $fieldObj->display();
                ?>
                <?php endforeach; ?>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved"></span> Cập nhật</button>
                <a class="btn btn-default" href="<?php echo BASE_REQUEST . '/admin'; ?>_<?php echo isset($controller)?$controller->module: '';?>/index"><span class="glyphicon glyphicon-refresh"></span> Quay lại</a>
            </div>
        </form>
    </div>
</div>