<?php
class PzkCoreLoader extends PzkObjectLightWeight{
	public $models;
	public $controllers;

	public function init() {
		$this->models = array();
		$this->controllers = array();
	}

	/**
	 * Lấy đối tượng model 
	 * @param string $model tên model
	 * @return Model
	 */
	public function getModel($model){
		if (!isset($this->models[$model])) {
			$this->models[$model] = $this->createModel($model);
		}
		return $this->models[$model];
	}

	/**
	 * Lấy ra controller
	 * @param string $controller
	 * @return PzkController
	 */
	public function getController($controller) {
		if (!$controller) return false;
		if (!isset($this->controllers[$controller])) {
			$this->controllers[$controller] = $this->createController($controller);
		}
		return $this->controllers[$controller];
	}

	/**
	 * Tạo controller
	 * @param string $controller tên controller
	 * @return PzkController
	 */
	public function createController($controller) {
		require_once _element('system')->path("controllers/$controller.php");
		$className = PzkParser::getClass($controller. 'Controller');
		if (class_exists($className)) return new $className();
		return false;
	}
	
	/**
	 * Tạo model
	 * @param string $model tên model
	 * @return Model
	 */
	public function createModel($model) {
		$names = explode('.', $model);
		$fullNames = array_merge(array(), $names);

		$name = array_pop($names);
		$package = implode('/', $names);

		$className = PzkParser::getClass($fullNames).'Model';

		if (!class_exists($className)) {
			$compileFile = BASE_DIR . '/compile/models/' . PzkParser::getClass($fullNames) . '.php';
			if(COMPILE_MODE && COMPILE_MODEL_MODE) {
				if(PHAR_MODE) {
					require_once 'phar://myapp.phar/compile/models/' . PzkParser::getClass($fullNames) . '.php';
				} else {
					if(file_exists($compileFile)) {
						require_once $compileFile;
					}
				}
				
			} else {
				if(file_exists(BASE_DIR . '/model/' . $package . '/' . ucfirst($name) . '.php')) 
					require_once BASE_DIR . '/model/' . $package . '/' . ucfirst($name) . '.php';
				else
					return null;
			}
		}
		if(class_exists($className))
			return new $className();
		return null;
	}
	
	/**
	 * Import một object
	 * @param string $uri đường dẫn dạng core/db/List
	 */
	public function importObject($uri) {
		if(COMPILE_MODE && COMPILE_OBJECT_MODE) {
			$parts = explode('/', $uri);
			foreach($parts as &$part) $part = ucfirst($part);
			if(PHAR_MODE) {
				require_once 'phar://myapp.phar/compile/objects/Pzk' . implode('', $parts) . '.php';
			} else {
				require_once BASE_DIR . '/compile/objects/Pzk' . implode('', $parts) . '.php';
			}
			
		} else {
			require_once BASE_DIR . '/objects/' . $uri . '.php';
		}
	}
    /**
     * Import một 3rdparty
     * @param string $uri đường dẫn dạng core/db/List
     */
    public function import3rdparty($uri) {
        require_once BASE_DIR . '/3rdparty/' . $uri . '.php';
    }

}

/**
 * Trả về đối tượng PzkCoreLoader
 * @return PzkCoreLoader
 */
function pzk_loader() {
	return pzk_element('loader');
}

/**
 * Lấy đối tượng model
 * @param string $name tên model dưới dạng edu.student
 * @return object
 */
function pzk_model($name, $newInstance = false) {
	if($newInstance) {
		return pzk_loader()->createModel($name);
	}
	return pzk_loader()->getModel($name);
}
/**
 * Import một object theo đường dẫn
 * @param string $object đường dẫn dạng: core.db.List
 */
function pzk_import($object) {
	$object = str_replace('.', '/', $object);
	return pzk_loader()->importObject($object);
}
?>