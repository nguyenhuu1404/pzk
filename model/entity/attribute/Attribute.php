<?php
class PzkEntityAttributeAttributeModel extends PzkEntityModel {
	public $table = 'attribute_attribute';
	public function getFilters() {
		return _db()->selectAll()->from('attribute_filter')->whereAtributeId($this->getId())->result('attribute.filter');
	}
}