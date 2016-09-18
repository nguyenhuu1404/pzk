<?php
pzk_import('core.db.Detail');
class PzkSiteControllerlayoutPosition extends PzkCoreDbDetail {
	public $table = 'site_layout_position';
	public $layout = 'admin/site/controllerlayout/position';
	public function getModules() {
		$controllerlayout = $this->getControllerlayout();
		$arr = array();
		$item = $this->getItem();
		$modules = _db()->selectNone()->selectId()->fromSite_module()->whereModule_theme($item['theme'])->wherePosition($item['position'])->whereModule_layout($item['layout'])->whereModule_controller($controllerlayout['controller_name'])->whereModule_action($controllerlayout['action_name'])->whereStatus('1')->orderBy('ordering asc')->result();
		foreach($modules as $moduleItem) {
			$module = pzk_obj('site.controllerlayout.module');
			$module->setItemId($moduleItem['id']);	
			$module->setControllerlayout($controllerlayout);
			$arr[] = $module;
		}
		return $arr;
	}
}