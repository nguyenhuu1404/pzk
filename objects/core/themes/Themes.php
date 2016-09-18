<?php 
class PzkCoreThemesThemes extends PzkObject{
	public $layout = 'themes/themes';
	public function getThemes(){
		$this->initRoute();
		
		if($this->isAdminRoute()) {
			return null;
		}
		
		$today	= 	date('Y-m-d');
		$themes	=	_db()->select("name")
				->useCache(1800)
				->from("themes")
				->lteStartDate($today)
				->gteEndDate($today)
				->whereStatus(ENABLED);
		$themes =
				$themes->orderBy('startDate asc')->result();
		return($themes);
	}
	
	public function initRoute() {
		$request = pzk_element('request');
		$this->route = preg_replace('/^[\/]/', '', $request->route);
	}
	
	public function isAdminRoute() {
		return substr($this->route, 0, 5) == 'admin';
	}
}
 ?>