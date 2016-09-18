<?php
$item = $data->getItem();
$modules = $data->getModules();
$controllerlayout= $data->getControllerlayout();
?>
<h2>Position: {item[position]}</h2>
<ul class="list-group position-modules" data-position="{item[position]}" id="{item[position]}-modules">
<?php
foreach($modules as $module) { ?>
<li class="list-group-item">
<?php  $module->display(); ?>
</li>
<?php
}?>
<li class="list-group-item">
	<h4>Drop module here!</h4>
</li>
</ul>
<script type="text/javascript">
	//$('#{item[position]}-modules').sortable().disableSelection();
</script>
<form action="/admin_site_controllerlayout/moduleAdd/{controllerlayout[id]}" method="post" id="{item[position]}-add-module">
<h3>Thêm module</h3>
<input type="hidden" name="module_theme" value="{item[theme]}" />
<input type="hidden" name="module_layout" value="{item[layout]}" />
<input type="hidden" name="module_controller" value="{controllerlayout[controller_name]}" />
<input type="hidden" name="module_action" value="{controllerlayout[action_name]}" />
<input type="hidden" name="position" value="{item[position]}" />
<input type="hidden" name="status" value="1" />
<input type="text" name="name" style="width: 100%; height: 30px;" />
<br />
<textarea name="code" style="width: 100%; height: 150px; margin-top: 5px;"></textarea>
<button name="btn_add_module" class="btn btn-primary">Add a module</button>
</form>
<script type="text/javascript">
	$('.edit-area').hide();
	$('.inline-edit').dblclick(function(){
		var $edit = $(this).parent().find('.edit-area');
		var $textarea = $edit.find('textarea');
		var $inline = $(this);
		$edit.show();
		$textarea.width($inline.width());
		$textarea.height($inline.height());
		$inline.hide();
	});
</script>