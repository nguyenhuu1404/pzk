<?php
pzk_import('core.db.Detail');
class PzkCoreDbGridEdit extends PzkCoreDbDetail {
	public $layout = 'admin/grid/form/edit';
	public function getFormObject() {
		if(!$this->getForm()) {
			$this->setForm(pzk_obj('core.form'));
		}
		return $this->getForm();
	}
}