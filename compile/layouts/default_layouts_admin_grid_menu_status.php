<div style="margin-bottom: 10px; position: relative;" class="well well-sm item">
	<div style="position: absolute; right: 5px; top: 1px; z-index: 1;">
		<a href="#" onclick="$('#form-<?php echo isset($data)?$data->getId(): '';?>').toggle(); return false;"><span class="glyphicon glyphicon-minus"></span></a>
	</div>
	<div id="form-<?php echo isset($data)?$data->getId(): '';?>">
		<h4><?php echo isset($data)?$data->getLabel(): '';?></h4>
		<div class="item">
			<form role="form" onsubmit="pzk_list.updateSelect(this, '<?php echo isset($data)?$data->getIndex(): '';?>', '<?php echo isset($data)?$data->getType(): '';?>'); return false;">
				<div class="form-group">
				<label for="<?php echo isset($item['index'])?$item['index']: '';?>"><?php echo isset($data)?$data->getNameField(): '';?></label><br />
				<select class="form-control" id="<?php echo isset($data)?$data->getIndex(): '';?>" name="<?php echo isset($data)?$data->getIndex(): '';?>">
					<option value="" ><?php echo isset($data)?$data->getSelectLabel(): '';?></option>
					<option value="1"><?php echo isset($data)?$data->getEnabledLabel(): '';?></option>
					<option value="0"><?php echo isset($data)?$data->getDisabledLabel(): '';?></option>
				</select>
				</div>
				<input style="margin-top: 5px;" class="btn btn-primary" id="updatecate" value="Cập nhật" type="submit"/>
				
			</form>
		</div>
	</div>
</div>
