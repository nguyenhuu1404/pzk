<?php
class PzkEntityAttributeSetGroupModel extends PzkEntityModel {
	public $table = 'attribute_set_groups';
	public function getAttributes() {
		return _db()->selectAll()->from('attribute_set_attributes')->whereGroupId($this->getId())->result('attribute.set.group.attribute');
	}
}