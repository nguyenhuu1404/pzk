<?php
pzk_import('core.db.Detail');
class PzkSiteControllerlayoutDesign extends PzkCoreDbDetail {
	public $layout = 'admin/site/controllerlayout/design';
	public function getPositions() {
		$arr = array();
		$item = $this->getItem();
		$positions = _db()->selectNone()->selectId()->selectPosition()->fromSite_layout_position()->whereTheme($item['theme'])->whereLayout($item['name'])->whereStatus('1')->result();
		foreach($positions as $positionItem) {
			$position = pzk_obj('site.controllerlayout.position');
			$position->setItemId($positionItem['id']);	
			$position->setControllerlayout($item);
			$arr[$positionItem['position']] = $position;
		}
		return $arr;
	}
}