<?php
class PzkCoreDbGridAdd extends PzkObject {
	public $layout = 'admin/grid/form/add';
	public function getFormObject() {
		if(!$this->getForm()) {
			$this->setForm(pzk_obj('core.form'));
		}
		return $this->getForm();
	}
}