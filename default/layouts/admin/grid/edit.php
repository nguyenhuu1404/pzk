<script>
TinymceInitted = false;
function setTinymce() {
	if(TinymceInitted) return false;
	TinymceInitted = true;
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

$item = $data->getItem();
$row = pzk_validator()->getEditingData();
if($row) {
	$item = array_merge($item, $row);
}
$row = $item;

$editFieldSettings = $controller->getEditFieldSettings();
$setEditTabs = $controller->getEditFieldSettingTabs();
?>
<div class="panel panel-default">
<div class="panel-heading">
    <b><?php echo pzk_or($controller->editLabel, 'Cập nhật'); ?></b>
	<a class="btn  btn-xs btn-primary pull-right" href="{url /admin}_{controller.module}/index"><span class="glyphicon glyphicon-list"></span> Quay lại</a>
</div>
<div class="panel-body borderadmin">
<form role="form" method="post" enctype="multipart/form-data"  action="{url /admin}_{controller.module}/editPost">
  <input type="hidden" name="id" value="{item[id]}" />
   <?php if($setEditTabs) { ?>
       <div class="form-group clearfix">
           <ul class="nav nav-tabs" role="tablist" id="myTab">
               <?php
               $i=1;
               foreach($setEditTabs as $val) { ?>
                   <li role="presentation" <?php if($i == 1) { echo "class='active'"; }?> ><a href="#{val[name]}" aria-controls="{val[name]}" role="tab" data-toggle="tab">{val[name]}</a></li>
                   <?php $i++; } ?>

           </ul>

           <div class="tab-content">
               <?php
               $i=1;
               foreach($setEditTabs as $val) { ?>
                   <div role="tabpanel" class="tab-pane <?php if($i == 1) { echo "active"; }?>" id="{val[name]}">
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
    <?php }else { ?>

  {each $editFieldSettings as $field}
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

  <button type="submit" name="<?= BTN_EDIT_AND_CLOSE?>" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-saved"></span> Sửa</button>
  <button type="submit" name="<?= BTN_EDIT_AND_CONTINUE?>" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-saved"></span> Sửa và tiếp tục</button>
  <button type="submit" name="<?= BTN_EDIT_AND_DETAIL?>" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-saved"></span> Sửa và xem chi tiết</button>
  <a class="btn btn-default" href="{url /admin}_{controller.module}/index"><span class="glyphicon glyphicon-refresh"></span> Quay lại</a>
</form>
</div>
</div>