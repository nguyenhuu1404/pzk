<?php
class PzkEntityAttributeSetGroupAttributeModel extends PzkEntityModel {
	public $table = 'attribute_set_attributes';
	public function getEntity() {
		return _db()->getEntity('attribute.attribute')->load($this->getAttributeId());
	}
}