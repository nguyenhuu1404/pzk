<div style="margin-bottom: 10px; position: relative;" class="well well-sm item">
    <div style="position: absolute; right: 5px; top: 1px; z-index: 1;">
			<a href="#" onclick="$('#form-{data.getId()}').toggle(); return false;"><span class="glyphicon glyphicon-minus"></span></a>
	  </div>
	<div id="form-{data.getId()}">
		<h4>{data.getLabel()}</h4>
		<div class="item">
			<form role="form" onsubmit="pzk_list.updateDataTo(this); return false;">
				<input type="hidden" name="index" value="{data.getIndex()}">
				<?php $addFieldSettings = $data->getData(); ?>
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
				<input style="margin-top: 5px;" class="btn btn-primary" value="Cập nhật" type="submit"/>

			</form>
		</div>
	</div>
</div>
