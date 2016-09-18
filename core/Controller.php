<?php

class PzkController extends PzkSG{
	public $masterStructure 	= 'masterStructure';
	public $masterPage 			= false;
	public $masterPosition 		= 'left';
	
	public $subMasterPage 		= false;
	public $subMasterPosition	= false;
	
	public $xml 				= true;
	public $json 				= true;
	public $varexport 			= true;
	
	public function __construct() {
		$this->loadPropertiesFromXml();
		$this->loadPropertiesFromJson();
		$this->loadPropertiesFromPhp();
		
	}
	public function loadPropertiesFromXml() {
		if($this->getXml()) {
			$file = strtolower(pzk_app()->getUri('xml/' . str_replace('_', '/', pzk_request()->getController()) . '/' . pzk_request()->getAction()) . '.xml');
			if(file_exists(BASE_DIR . '/' . $file)) {
				$arr = pzk_array();
				$arr->fromXml(file_get_contents($file));
				$arr = $arr->getData();
				foreach($arr as $key => $val) {
					$this->set($key, $val);
				}
			}
		}
	}
	public function loadPropertiesFromJson() {
		if($this->getJson()) {
			$file = strtolower(pzk_app()->getUri('json/' . str_replace('_', '/', pzk_request()->getController()) . '/' . pzk_request()->getAction()) . '.json');
			if(file_exists(BASE_DIR . '/' . $file)) {
				$content = file_get_contents($file);
				$arr = json_decode($content, true);
				foreach ($arr as $key => $val) {
					$this->set($key, $val);
				}
			}
		}
	}
	
	public function loadPropertiesFromPhp() {
		if($this->getVarexport()) {
			$file = strtolower(pzk_app()->getUri('var/' . str_replace('_', '/', pzk_request()->getController()) . '/' . pzk_request()->getAction()) . '.php');
			if(file_exists(BASE_DIR . '/' . $file)) {
				$content = file_get_contents($file);
				$arr = array();
				eval('$arr = ' . $content . ';');
				foreach ($arr as $key => $val) {
					$this->set($key, $val);
				}
			}
		}
	}
	
	public function loadLayout() {
		$controller = strtolower(pzk_request('controller'));
		$action = pzk_request('action');
		$theme = pzk_request('defaultTheme');
		$controller_layout = _db()->selectAll()->fromSite_controller_layout()
			->whereStatus('1')->whereController_name($controller)
			->whereAction_name($action)
			->where(array('in', 'theme', array("'$theme'", "''")))
			->result_one();
		if($controller_layout) {
			$layout = $controller_layout['name'];
			$base_controller = @$controller_layout['base_controller'];
			$base_action = @$controller_layout['base_action'];
			$base_theme = @$controller_layout['base_theme'];
			$masterPage = $this->parse($layout);
			$modules = _db()->selectAll()->fromSite_module()
				->whereStatus('1')->whereModule_controller($controller)
				->where(array('in', 'module_controller', array("'$controller'", "'$base_controller'")))
				->where(array('in', 'module_action', array("'$action'", "'$base_action'")))
				->where(array('in', 'module_theme', array("'$theme'", "'$base_theme'")))
				->whereModule_layout($layout)->orderBy('ordering asc')
				->result();
			foreach($modules as $module) {
				$position = pzk_element($module['position']);
				if($position) {
					$position->append($this->parse($module['code']));
				}
			}
			$this->setPage($masterPage);
		}
	}
	public function parse($uri) {
		if($uri instanceof PzkObject) return $uri;
		if(strpos($uri, '<') !==false) return pzk_parse($uri);
		$themes = pzk_request()->getThemes();
		
		if($themes) {
			foreach($themes as $theme) {
				$themeUri = str_replace('app/', 'themes/' . $theme . '/', pzk_app()->getPageUri($uri));
				
				if(file_exists($file = BASE_DIR . '/' . $themeUri . '.php'))
					return pzk_parse($themeUri);
			}
			
			foreach($themes as $theme) {
				$themeUri = 'themes/' . $theme . '/pages/'.$uri;
				if(file_exists($file = BASE_DIR . '/' . $themeUri . '.php'))
					return pzk_parse($themeUri);
				
			}
		}
		
		if($themes) {
			foreach($themes as $theme) {
				$themeUri = pzk_app()->getPageUri($theme . '/' . $uri);
				if(file_exists($file = BASE_DIR . '/' . $themeUri . '.php'))
					return pzk_parse($themeUri);
				
				
			}
		}
		
		
		// app page
		if(file_exists($file = BASE_DIR . '/' . pzk_app()->getPageUri($uri) . '.php'))
			return pzk_parse(pzk_app()->getPageUri($uri));	
		
		
		// package
		if($themes) {
			// package theme folder
			foreach($themes as $theme) {
				$themeUri = pzk_app()->getPackagePageUri($theme . '/' . $uri);
				if(file_exists($file = BASE_DIR . '/' . $themeUri . '.php'))
					return pzk_parse($themeUri);
				
			}
			
			// themes folder
			foreach($themes as $theme) {
				$themeUri = str_replace('app/', 'themes/' . $theme . '/', pzk_app()->getPackagePageUri($uri));
					if(file_exists($file = BASE_DIR . '/' . $themeUri . '.php'))
						return pzk_parse($themeUri);
				
			}
		}
		
		// default
		if(file_exists($file = BASE_DIR . '/' . pzk_app()->getPackagePageUri($uri) . '.php'))
			return pzk_parse(pzk_app()->getPackagePageUri($uri));
		
		return pzk_parse('default/pages/' . $uri);
	}
	
	public function getModel($model) {
		return pzk_loader()->getModel($model);
	}
	
	public function initPage() {
		$page = $this->parse(pzk_or($this->getMasterPage(), $this->getMasterStructure()));
		if($this->getSubMasterPage()) {
			$this->append($this->getSubMasterPage(), $this->getSubMasterPosition());
		}
		$this->setPage($page);
		return $this;
	}
	
	public function append($obj, $position = NULL) {
		$obj = $this->parse($obj);
		if($position){
			pzk_element($position)->append($obj);
		} else {
			pzk_element($this->getMasterPosition())->append($obj);
		}
		return $this;
	}
	
	public function display() {
		if(!$this->getIsPreventingDisplay())
			$this->getPage()->display();
		return $this;
	}
	public function render($page) {
		$this->initPage();
		$this->append($page);
		$this->display();
		return $this;
	}
	public function redirect($action, $query = false) {
		if(strpos($action, 'http') !== false) {
			pzk_request()->redirect($action);
		}
		$parts = explode('/', $action);
		if(!@$parts[1] || is_numeric(@$parts[1])) {
			pzk_request()->redirect(pzk_request()->buildAction($action, $query));
		} else {
			pzk_request()->redirect(pzk_request()->build($action, $query));
		}
	}
	
	public function validate($row, $validator) {
		if(isset($validator) && $validator) {
			$result = pzk_validate($row, $validator);
			if($result !== true) {
				foreach($result as $field => $messages) {
					foreach($messages as $message) {
						pzk_notifier()->addMessage($message, 'warning');
					}
				}
				return false;
			}
		}
		return true;
	}
	
	public $events = array();
	public function fireEvent($event, $data = NULL) {
		$eventHandlers = isset($this->events[$event]) ? $this->events[$event]: array();
		foreach ($eventHandlers as $handler) {
			$tmp = explode('.', $handler);
			$action = 'handle';
			if(isset($tmp[1])) { 
				$action = $tmp[1]; 
			}
			$obj = isset($tmp[0]) ? $tmp[0] : null;
			if($obj == 'this') {
				$h = $this;
			} else {
				$h = pzk_element($obj);
				if(!$h) {
					$h = $this->parse($obj);
				}
			}
			if($h) {
				$h->$action($event, $data);
			}
		}
	}
	
	public function addEventListener($event, $handler){
		if(!isset($this->events[$event])) {
			$this->events[$event] = array();
		}
		$this->events[$event][] = $handler;
	}
	
	public function __call($name, $arguments) {	
		$prefix = substr($name, 0, 3);
		$property = strtolower($name[3]) . substr($name, 4);
		switch ($prefix) {
			case 'get':
				return $this->$property;
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->$property = $arguments[0];
				//Always return this (Even on the set)
				return $this;
		}
		
		$prefix5 = substr($name, 0, 5);
		$property5 = strtolower($name[5]) . substr($name, 6);
		switch ($prefix5) {
			case 'parse':
				return $this->parse(str_replace('_', '/', $property5));
				break;
		}
		
		$prefix6 = substr($name, 0, 6);
		$property6 = strtolower($name[6]) . substr($name, 7);
		switch ($prefix6) {
			case 'append':
				return $this->append(str_replace('_', '/', $property6));
				break;
			case 'render':
				return $this->render(str_replace('_', '/', $property6));
				break;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
	
	public function obj($obj) {
		return pzk_obj($obj);
	}
	
	public function layout() {
		$this->initPage();
	}
	
	public $isPreventingDisplay = false;
	public function preventDisplay() {
		$this->setIsPreventingDisplay(true);
	}
	public function unpreventDisplay() {
		$this->setIsPreventingDisplay(false);
	}
}
