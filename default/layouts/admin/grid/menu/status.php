<div style="margin-bottom: 10px; position: relative;" class="well well-sm item">
	<div style="position: absolute; right: 5px; top: 1px; z-index: 1;">
		<a href="#" onclick="$('#form-{data.getId()}').toggle(); return false;"><span class="glyphicon glyphicon-minus"></span></a>
	</div>
	<div id="form-{data.getId()}">
		<h4>{data.getLabel()}</h4>
		<div class="item">
			<form role="form" onsubmit="pzk_list.updateSelect(this, '{data.getIndex()}', '{data.getType()}'); return false;">
				<div class="form-group">
				<label for="{item[index]}">{data.getNameField()}</label><br />
				<select class="form-control" id="{data.getIndex()}" name="{data.getIndex()}">
					<option value="" >{data.getSelectLabel()}</option>
					<option value="1">{data.getEnabledLabel()}</option>
					<option value="0">{data.getDisabledLabel()}</option>
				</select>
				</div>
				<input style="margin-top: 5px;" class="btn btn-primary" id="updatecate" value="Cập nhật" type="submit"/>
				
			</form>
		</div>
	</div>
</div>
