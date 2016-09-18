<div style="margin-bottom: 10px; position: relative;" class="well well-sm item">
	<div style="position: absolute; right: 5px; top: 1px; z-index: 1;">
		<a href="#" onclick="$('#form-{data.getId()}').toggle(); return false;"><span class="glyphicon glyphicon-minus"></span></a>
	</div>
	<div id="form-{data.getId()}">
		<h4>{data.getLabel()}</h4>
		<div class="item">
			<form role="form" onsubmit="pzk_list.updateMutiSelect(this, '{data.getIndex()}', '{data.getType()}'); return false;">
			<div class="form-group">
			<label for="{item[index]}">{data.getNameField()}</label><br />
			<select class="form-control" id="{data.getIndex()}" name="{data.getIndex()}[]" multiple="multiple" size="10">
				<option value="" >{data.getSelectLabel()}</option>
				<?php
				$parents = _db()->select('*')->from($data->getTable())->where(pzk_or(@$data->getCondition(), '1'))->result();
				if(isset($parents[0]['parent'])) {
					$parents = treefy($parents);
				}
				?>
				{each $parents as $parent}
				<option value="<?php echo $parent[$data->getShow_value()]; ?>" >
					<?php if(isset($parent['parent'])){ echo str_repeat('-', $parent['level']); } ?>
					<?php echo $parent[$data->getShow_name()]; ?>
				</option>
				{/each}

			</select>
			</div>
			<input style="margin-top: 5px;" class="btn btn-primary" id="updatecate" value="Cập nhật" type="submit"/>
			</form>
		</div>
	</div>
</div>

