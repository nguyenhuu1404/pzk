<table class="table">
<tr>
	<td>
	{data.getObject()}
	</td>
	<td>
	<a href="/admin_editor/edit?object={data.getObject()}&type=object"><img src="/default/images/icon/object.gif" /></a>
	</td>
	<td>
		<a href="/admin_editor/edit?object={data.getObject()}&type=layout"><img src="/default/images/icon/layout.png" /></a>
	</td>
	<td>
		<a href="/admin_editor/edit?object={data.getObject()}&type=js"><img src="/default/images/icon/js.png" /></a>
	</td>
	<td>
		<a href="/admin_editor/edit?object={data.getObject()}&type=css"><img src="/default/images/icon/css.png" /></a>
	</td>
</tr>
</table>
<?php
$type = $data->getType();
$content = '';
$obj = pzk_obj(str_replace('/', '.', $data->getObject()));
if($type == 'object') {
	$content = file_get_contents('objects/' . $data->getObject() . '.php');
	$content = html_escape($content);
	$fileName = 'objects/' . $data->getObject() . '.php';
} else if($type == 'layout') {
	$layout = $obj->getLayoutRealPath();
	if(file_exists($layout . '.php')) {
		$content = file_get_contents($layout . '.php');
		$content = html_escape($content);	
	} else {
		$content = '';
	}
	$fileName = $layout . '.php';
} else if($type == 'js') {
	$fileName = strtolower('js/' . $data->getObject() . '.js');
	if(($obj->getScriptable() === 'true' || $obj->getScriptable()) === true && file_exists($fileName)) {
		$content = file_get_contents($fileName);
		$content = html_escape($content);
	} else {
		$content = '';
	}
} else if($type == 'css') {
	$css = $obj->getCssRealPath();
	if(file_exists($css . '.css')) {
		$content = file_get_contents($css . '.css');
		$content = html_escape($content);	
	} else {
		$content = '';
	}
	$fileName = $css . '.css';
} else if($type == 'less') {
	
}
?>
<form method="post" 
	onsubmit="$('#fileContent').val(aceEditor.getValue());"
	action="/admin_editor/save?object={data.getObject()}&type={type}">
<input type="submit" name="btn_submit" value="Lưu" class="btn btn-primary" />
<a href="/admin_editor/index">Quay lại</a>
<br /><br />
{fileName}<br />
<input type="hidden" name="fileName" value="{fileName}" />

<?php if($type == 'layout'): ?>

  <textarea id="content" class="form-control" style="height: 800px" name="content">{content}</textarea>
<?php else: ?>
<textarea id="content" class="form-control" style="height: 800px" name="content">{content}</textarea>
<?php endif; ?>
<input type="hidden" name="fileContent" id="fileContent" />
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("content");
	aceEditor = editor;
    editor.setTheme("ace/theme/monokai");
	<?php if($type == 'js'):?>
	editor.getSession().setMode("ace/mode/javascript");
	<?php elseif($type == 'css'): ?>
	editor.getSession().setMode("ace/mode/css");
	<?php else: ?>
    editor.getSession().setMode("ace/mode/php");
	<?php endif; ?>
	editor.setOption("maxLines", 30);
	editor.setOption("minLines", 10);
</script>
<?php
$xmlPage = '<'.str_replace('/', '.', $data->getObject()).' />';
?>
<div id="customPreview">
	<h2>Preview</h2>
	<textarea id="xmlPage" class="form-control"><?php echo html_escape($xmlPage);?></textarea><br />
	<?php if($type == 'layout'):?>
		<input type="button" value="Design Layout" class="btn btn-primary" onclick="previewLayout();" /> &nbsp;
	<?php endif; ?>
	<input type="button" value="Preview" class="btn btn-primary" onclick="previewXmlPage();" />
	<input type="button" value="Open In New Window" class="btn btn-primary" onclick="previewXmlPage(true);" />
</div>
<iframe id="preview" name="preview" src="about:blank" style="width: 100%; height: 600px">
</iframe>
<script type="text/javascript">
function previewXmlPage(openInNewWindow) {
	var xmlPage = $('#xmlPage').val();
	xmlPage = encodeURI(xmlPage);
	if(openInNewWindow) {
		window.open('/admin_editor/page?xml=' + xmlPage);
	} else {
		$('#preview').attr('src', '/admin_editor/page?xml=' + xmlPage);
	}
}
function previewLayout() {
	var layoutContent = aceEditor.getValue();
	//layoutContent = encodeURI(layoutContent);
	postToIframe({content: layoutContent}, '/admin_editor/layout', 'preview');
}
</script>