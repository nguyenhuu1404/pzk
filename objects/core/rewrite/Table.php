<?php
class PzkCoreRewriteTable extends PzkObjectLightweight{
	public $table = 'catalog_category';
	public $field = 'alias';
	public $routeField = 'code';
	public $action = '';
	public static $matched = false;
	public function init() {
		if(self::$matched) return true;
		$request = pzk_request();
		
		if($request->isAdminRoute()) {
			return true;
		}
		
		$route = pzk_request()->getStrippedSlashRoute();
		
		if($route) {
			$item = $this->getItem($route);
			
			if($item) {
				self::$matched = true;
				
				$request->routeTable = $this->table;
				$request->routeData = $item;
				if($this->routeField && isset($item[$this->routeField]) && $item[$this->routeField]) {
					// replace request route
					$request->route = '/' .$item[$this->routeField] . '/' . $item['id'];
				} else if($this->action) {
					// replace request route
					$request->route = '/' .$this->action . '/' . $item['id'];
				}
			}
		}
	}
	
	public function getItem($route) {
		return _db()->useCB()->useCache(3600)->select('*')->from($this->table)->where(array($this->field, $route))->result_one();
	}
}