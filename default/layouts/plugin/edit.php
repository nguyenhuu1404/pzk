<?php
$file = pzk_request('file');
if($file) {
$module = $data->getModule();
$itemId = $data->getItemId();
$url = urlencode($file);
?>
<form action="/admin_{module}/putFile" method="post">
    <input type="hidden" name="file" value="{file}">
    <input type="hidden" name="link" value="admin_{module}/edit/{itemId}?file={url}"/>
    <div class="form-group">
    <textarea name="content" class="item form-control" style="height:500px;"><?php
echo htmlentities(file_get_contents($file));
?></textarea>
        </div>
    <div style="float:left; margin-top: 15px;" class="form-group">
    <input type="submit" class="btn btn-primary" value="Cập nhật">
        </div>
</form>
<?php } ?>