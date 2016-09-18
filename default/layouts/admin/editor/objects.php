<?php 
$package = trim(pzk_request('package'), '/');
if($package) {
	$objects = glob('objects/' . trim($package, '/') . '/*.*');
	$dirs = dir_dirs('objects/' . trim($package, '/'));
	$upPackage = trim(preg_replace('/[^\/]*$/', '', $package), '/');
}else {
	$objects = glob('objects/*.*');
	$dirs = dir_dirs('objects');
}

?>
<strong>{package}</strong>
<table class="table">
<?php if($package): ?>
	<tr><td><a href="/admin_editor?package={upPackage}">..</a></td></tr>
<?php endif; ?>
{each $dirs as $dir}
<tr><td>
<?php if($package): ?>
	<a href="/admin_editor?package={package}/{dir}">{dir}</a><br />
<?php else: ?>
	<a href="/admin_editor?package={dir}">{dir}</a><br />
<?php endif; ?>
</td></tr>
{/each}
</table>
<table class="table">
{each $objects as $object}
	<?php preg_match('/objects\/(.*)\.php/', $object, $match);
	$parts = explode('/', $match[1]);
	$fileName = array_pop($parts);
	?>
	<tr>
	<td style="color: green;">{fileName}</td>
	<td><a href="/admin_editor/edit?object={match[1]}&type=object"><img src="/default/images/icon/object.gif" style="width: 24px; height: 24px;" /></a></td>
	<td><a href="/admin_editor/edit?object={match[1]}&type=layout"><img src="/default/images/icon/layout.png" style="width: 24px; height: 24px;" /></a></td>
	<td><a href="/admin_editor/edit?object={match[1]}&type=js"><img src="/default/images/icon/js.png" style="width: 24px; height: 24px;" /></a></td>
	<td><a href="/admin_editor/edit?object={match[1]}&type=css"><img src="/default/images/icon/css.png" style="width: 24px; height: 24px;" /></a></td>
	</tr>
{/each}
<tr>
	<td colspan="5">
		<a href="/admin_editor/edit?type=config&package={package}">Cấu hình</a><br />
	</td>
	<td colspan="5">
	<?php if($package): ?>
	<a href="/admin_editor/add?package={package}">Tạo mới</a><br />
	<?php else: ?>
		<a href="/admin_editor/add?package=">Tạo mới</a><br />
	<?php endif; ?>
	</td>
</tr>
</table>