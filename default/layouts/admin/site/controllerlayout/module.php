<?php $item = $data->getItem();
 $controllerlayout = $data->getControllerlayout();
 ?>
<div id="module-area-{item[id]}" class="module-area">
<h3>Module: {item[name]} <span class="glyphicon glyphicon-remove red" onclick="if(confirm('Bạn có chắc muốn xóa?')){ window.location='/admin_site_controllerlayout/moduleDelete/{item[id]}/{controllerlayout[id]}'; }"></span> <span class="glyphicon glyphicon-arrow-up blue" onclick="window.location='/admin_site_controllerlayout/moduleUp/{item[id]}/{controllerlayout[id]}';"></span><span class="glyphicon glyphicon-arrow-down blue" onclick="window.location='/admin_site_controllerlayout/moduleDown/{item[id]}/{controllerlayout[id]}';"></span>
<span class="glyphicon glyphicon-cog blue" onclick="window.location='/admin_site_controllerlayout/moduleConfig/{item[id]}/{controllerlayout[id]}';"></span>
</h3>
<div class="inline-edit inline-edit-item-{item[id]}" rel="{item[id]}"><code><?php echo nl2br (html_escape ($item['code']));?></code></div>
<div class="edit-area">
	<form action="/admin_site_controllerlayout/moduleEdit/{item[id]}/{controllerlayout[id]}" method="post">
	<textarea name="code"><?php echo html_escape($item['code']);?></textarea>
	<button name="btn_submit" class="btn btn-primary">Sửa</button>
	<a href="#" class="btn btn-default" onclick="$('#module-area-{item[id]} .inline-edit').show(); $('#module-area-{item[id]} .edit-area').hide(); return false;">Đóng</a>
	</form>
</div>
</div>
