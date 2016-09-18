<form role="form" method="post" enctype="multipart/form-data"
	action="/admin_editor/addPost">
	<input type="hidden" name="package" value="<?php echo pzk_request('package'); ?>" />
	<div class="form-group clearfix">
		<label for="name">Tên Object</label> <input class="form-control"
			id="name" name="name" />
	</div>
	<button type="submit" name="btn_submit" value="1"
		class="btn btn-primary">
		<span class="glyphicon glyphicon-ok-sign"></span> Tạo
	</button>
</form>