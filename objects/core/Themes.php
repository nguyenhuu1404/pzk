<?php
class PzkCoreThemes extends PzkObjectLightWeight {
	
	public $id = 'themes';
	public $table = 'pzk_themes';
	
	public function init() {
		
		
		$this->initRoute();
		
		if($this->isAdminRoute()) {
			return true;
		}
		
		$this->initThemes();
		
	}
	
	public function initThemes() {
		$request = pzk_element('request');
		$allThemes 	= array();
		
		$themes = $this->getThemesOnToday();
		
		$default = '';
		if($themes)
		foreach($themes as $theme) {
			$allThemes[] = $theme['name'];
			if($theme['default']) {
				$default = $theme['name'];
			}
		}
		$request->setThemes($allThemes);
		$request->setDefaultTheme($default);
	}
	
	public function getThemesOnToday() {
		$today		= date('Y-m-d');
		$themes		=_db()->useCache(1800)->select("name, `default`")
			->from($this->table)
			->lteStartDate($today)
			->gteEndDate($today)
			->whereStatus(ENABLED)
			->orderBy('startDate desc');
		$themes		=	$themes->result();
		return $themes;
	}
	
	public function themes($name = ''){
		
		$themes = pzk_request()->getThemes();
		
		if(in_array($name, $themes)){
			
			return true;
		}
		return false;
	}
	
	public function initRoute() {
		$request = pzk_element('request');
		$this->route = preg_replace('/^[\/]/', '', $request->route);
	}
	
	public function isAdminRoute() {
		return substr($this->route, 0, 5) == 'admin';
	}
}

function pzk_themes($name = ''){
	
	$obj = pzk_element('themes');
	
	return $obj->themes($name);
}