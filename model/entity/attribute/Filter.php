<?php
class PzkEntityAttributeSetModel extends PzkEntityModel {
	public $table = 'attribute_filter';
	public function getOptions() {
		return _db()->selectAll()->from('attribute_filter_options')->wherefilterId($this->getId())->result('attribute.filter.option');
	}
}