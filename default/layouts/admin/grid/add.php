<script>
tinymceLoaded = false;
function setTinymce() {
	if(tinymceLoaded) return false;
	tinymceLoaded = true;
    tinymce.init({
        selector: "textarea.tinymce",
        forced_root_block : "",
        force_br_newlines : true,
        force_p_newlines : false,
        relative_url: false,
        remove_script_host: false,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen media",
            "insertdatetime media table contextmenu paste textcolor"
        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | styleselect formatselect fontselect fontsizeselect | forecolor backcolor",
        entity_encoding : "raw",
        relative_urls: false,
        external_filemanager_path: "/3rdparty/Filemanager/filemanager/",
        filemanager_title:"Quản lý file upload" ,
        external_plugins: { "filemanager" :"/3rdparty/Filemanager/filemanager/plugin.min.js"},
        height: 250
    });
}

</script>
<?php
	$controller = pzk_controller();
	$addFieldSettings = $controller->getAddFieldSettings();
    $setAddTabs = $controller->getAddFieldSettingTabs();
	$row = pzk_validator()->getEditingData();
    $scriptHolder = pzk_parse('<div id="holder" />');
    if($addFieldSettings && $controller->getFilterFields()) {
    	foreach ($addFieldSettings as $field) {
    		$selectedFilterField = null;
    		foreach($controller->getFilterFields() as $filterField) {
    			if($filterField['index'] == $field['index']) {
    				$selectedFilterField = $filterField;
    				break;
    			}
    		}
    		if($val = pzk_session($controller->table.@$selectedFilterField['type'].@$selectedFilterField['index'])) {
    			$row[$field['index']] = $val;
    		}
    	}
    }
?>
<script type="text/javascript">
$(function() {
	$('#{controller.module}AddForm input[type!=hidden], #{controller.module}AddForm select, #{controller.module}AddForm textarea').first().focus();
	$('#{controller.module}AddForm input, #{controller.module}AddForm select, #{controller.module}AddForm textarea').keydown(function(evt){
		if(evt.ctrlKey && evt.keyCode == 40) {
			evt.preventDefault();
			var next = $(this).parents('.form-group:first').nextAll('.form-group:first').find('input:first, select:first, textarea:first');
			if(next.length) {
				if(next.hasClass('tinymce')) {
					tinyMCE.get(next.prop('id')).focus();
				} else {
					next.focus();
					next.select();
				}
			}
		} else if(evt.ctrlKey && evt.keyCode == 38) {
			evt.preventDefault();
			var prev = $(this).parents('.form-group:first').prevAll('.form-group:first').find('input:first, select:first, textarea:first');
			if(prev.length) {
				if(prev.hasClass('tinymce')) {
					tinyMCE.get(prev.prop('id')).focus();
				} else {
					prev.focus();
					prev.select();
				}
			}
		}
	});
});
</script>
<div class="panel panel-default">
<div class="panel-heading">
    <b><?php echo $controller->addLabel; ?></b>
	<a class="btn  btn-xs btn-primary pull-right" href="{url /admin}_{controller.module}/index"><span class="glyphicon glyphicon-list"></span> Quay lại</a>
</div>
<div class="panel-body borderadmin">
<form id="{controller.module}AddForm" role="form" enctype="multipart/form-data" method="post" action="{url /admin}_{controller.module}/addPost">
  <input type="hidden" name="id" value="" />
    <?php if(!empty($setAddTabs)) { ?>

    <div class="form-group clearfix">
        <ul class="nav nav-tabs" role="tablist" id="myTab">
            <?php
            $i=1;
            foreach($setAddTabs as $val) { ?>
            <li role="presentation" <?php if($i == 1) { echo "class='active'"; }?> ><a href="#tab-{i}" aria-controls="tab-{i}" role="tab" data-toggle="tab">{val[name]}</a></li>
            <?php $i++; } ?>

        </ul>

        <div style="margin-top: 10px;" class="tab-content">
            <?php
            $i=1;
            foreach($setAddTabs as $val) { ?>
                <div role="tabpanel" class="tab-pane <?php if($i == 1) { echo "active"; }?>" id="tab-{i}">
                    <?php foreach($val['listFields'] as $field ) { ?>
    {?
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
	?}
                    <?php } ?>
                </div>
                <?php $i++; } ?>

        </div>


    </div>
    <?php } else { ?>


    {each $addFieldSettings as $field}
    {?
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
	?}
  {/each}


<?php } ?>

  <div class="form-group">
  <button type="submit" class="btn btn-primary" name="<?= BTN_ADD_AND_CLOSE?>" value="1"><span class="glyphicon glyphicon-saved"></span> Thêm</button>
  <button type="submit" class="btn btn-primary" name="<?= BTN_ADD_AND_EDIT?>" value="1"><span class="glyphicon glyphicon-saved"></span> Thêm và sửa</button>
  <button type="submit" class="btn btn-primary" name="<?= BTN_ADD_AND_CONTINUE?>" value="1"><span class="glyphicon glyphicon-saved"></span> Thêm và tạo mới</button>
  <a class="btn btn-default" href="{url /admin}_{controller.module}/index"><span class="glyphicon glyphicon-refresh"></span> Quay lại</a>
  </div>
</form>
</div>
</div>