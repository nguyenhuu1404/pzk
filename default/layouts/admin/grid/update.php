<div style="border: 1px solid #cccccc; padding: 15px;">
    <h4>Cập nhật plugin</h4>
<form  method="post" enctype="multipart/form-data" action="{url /admin}_{data.getModule()}/updatePost">
    <div class="form-group">
        <label for="filename">Chọn plugin(file zip)</label>
        <input id="filename" type="file" name="filename">
    </div>
    <input class="btn btn-default btn-primary" type="submit" value="Cập nhật">
</form>
</div>