<?php

class PzkCoreApplication extends PzkObjectLightWeight {

	/**
	 * Tên ứng dụng
	 * @var string
	 */
    public $name = false;
    public $libraries = array();
    public $controller = false;
	
    /**
     * Chạy controller
     */
	public function run() {
		$request = pzk_element('request');
		$controller = $request->getController('Home');
		$action =  $request->getAction('index');
		$controllerObject = $this->_getController($controller);
		if(!$controllerObject) pzk_system()->halt('No controller ' .$controller);
		pzk_global()->setController($controllerObject);
		if(method_exists($controllerObject, $action . 'Action')) {
			$method = new ReflectionMethod($controllerObject, $action . 'Action');
			$params = $method->getParameters();
			$paramsArray = array();
			foreach($params as $index => $param) {
				$paramValue = pzk_request()->getSegment(3+$index);
				$paramsArray[] = $paramValue;
			}
			call_user_func_array(array($controllerObject, $action . 'Action'), $paramsArray);
		}
		else {
			pzk_system()->halt('No route ' . $action);
		}
	}
	
	/**
	 * Trả về instance của controller
	 * @param string $controller tên controller, dạng user, hoặc admin_user
	 * @return PzkController
	 */
	public function _getController($controller) {
		if(CACHE_MODE && pzk_controllercache()->get($controller. 'path')) {
			$path = pzk_controllercache()->get($controller. 'path');
			$class = pzk_controllercache()->get($controller.'class');
			require_once $path;
			return new $class();
		}
		$parts = explode('_', $controller);
		$parts[count($parts)-1] = ucfirst($parts[count($parts)-1]);
		
		$fileName = null;
		
		// tim kiem controller trong themes
		$themes = pzk_request()->getThemes();
		if($themes) {
			
			foreach($themes as $theme) {
				if(file_exists(BASE_DIR . '/' . ($tmp = 'themes/' . $theme. '/controller/' . implode('/', $parts) . '.php'))) {
					$fileName = $tmp;
					break;
				}
			}
		}
		
		// tim kiem controller trong app
		if(!$fileName)
			$fileName = $this->getUri('controller/' . implode('/', $parts) . '.php');
		
		if(!file_exists(BASE_DIR . '/' . $fileName)){
			// tim kiem controller trong package
			$fileName = $this->getPackageUri('controller/' . implode('/', $parts) . '.php');
			if(!file_exists(BASE_DIR . '/' . $fileName)) {
				
				// tim kiem controller trong default
				$fileName = 'default/controller/' . implode('/', $parts) . '.php';
				if(!file_exists(BASE_DIR . '/' . $fileName)){
					echo 'File ' . $fileName . ' không tồn tại <br />';
					return null;
				}
			}
		}
		$fileNameCompiled = str_replace('/', '_', $fileName);
		$controllerClass = PzkParser::getClass( $parts ) . 'Controller';
		$controllerClassCompiled = str_replace('.php', '', $fileNameCompiled);
		$parts2 = explode('_', $controllerClassCompiled);
		if(@$parts2[1] == 'controller') {
			array_splice($parts2, 1, 1);
		} else if(@$parts2[2] == 'controller') {
			array_splice($parts2, 2, 1);
		} else if(@$parts2[3] == 'controller') {
			array_splice($parts2, 3, 1);
		}
		
		// compile controller (always)
		$controllerClassCompiled = PzkParser::getClass($parts2) . 'Controller';
		if(!file_exists(BASE_DIR . '/compile/controllers/' . $fileNameCompiled)  || (filemtime(BASE_DIR . '/compile/controllers/' . $fileNameCompiled) < filemtime((BASE_DIR .  '/' . $fileName )))) {
			$fileContent = file_get_contents(BASE_DIR . '/' . $fileName);
			$fileContentReplaced = str_replace($controllerClass, $controllerClassCompiled, $fileContent);
			file_put_contents('compile/controllers/' . $fileNameCompiled, $fileContentReplaced);
		}
		if(CACHE_MODE) {
			pzk_controllercache()->set($controller.'path', BASE_DIR . '/compile/controllers/' . $fileNameCompiled);
			pzk_controllercache()->set($controller.'class', $controllerClassCompiled);
		}
		
		// ket qua
		require_once BASE_DIR . '/compile/controllers/' . $fileNameCompiled;
		return new $controllerClassCompiled();

	}
	
	/**
	 * 
	 * @param unknown $controller
	 * @param unknown $package
	 * @return multitype:string
	 */
	public function generateController($controller, $package) {
		$parts = explode('_', $controller);
		$parts[count($parts)-1] = ucfirst($parts[count($parts)-1]);
		if(file_exists(BASE_DIR . '/' . ($tmp = $package . '/controller/' . implode('/', $parts) . '.php'))) {
			$fileName = $tmp;
			$fileNameCompiled = str_replace('/', '_', $fileName);
			$controllerClass = PzkParser::getClass( $parts ) . 'Controller';
			$controllerClassCompiled = str_replace('.php', '', $fileNameCompiled);
			$parts2 = explode('_', $controllerClassCompiled);
			if(@$parts2[1] == 'controller') {
				array_splice($parts2, 1, 1);
			} else if(@$parts2[2] == 'controller') {
				array_splice($parts2, 2, 1);
			} else if(@$parts2[3] == 'controller') {
				array_splice($parts2, 3, 1);
			}
			$controllerClassCompiled = PzkParser::getClass($parts2) . 'Controller';
			if(!file_exists(BASE_DIR . '/compile/controllers/' . $fileNameCompiled) || (filemtime(BASE_DIR . '/compile/controllers/' . $fileNameCompiled) < filemtime((BASE_DIR .  '/' . $fileName )))) {
				$fileContent = file_get_contents(BASE_DIR . '/' . $fileName);
				$fileContentReplaced = str_replace($controllerClass, $controllerClassCompiled, $fileContent);
				file_put_contents('compile/controllers/' . $fileNameCompiled, $fileContentReplaced);
			}
			
			//die($fileNameCompiled);
			
			return array(
				'filePath' 	=> BASE_DIR . '/compile/controllers/' . $fileNameCompiled,
				'className'	=> $controllerClassCompiled
			);
		} else {
			die('No controller ' . $controller . ' found in ' . $package . '!');
		}
	}
	
	/**
	 * 
	 * @param unknown $controller
	 * @return NULL|string
	 */
	public function getControllerRealPath($controller) {
		$parts = explode('_', $controller);
		$parts[count($parts)-1] = ucfirst($parts[count($parts)-1]);
		$fileName = BASE_DIR . '/' . $this->getUri('controller/' . implode('/', $parts) . '.php');
		if(!file_exists($fileName)){
			$fileName = BASE_DIR . '/' . $this->getPackageUri('controller/' . implode('/', $parts) . '.php');
			if(!file_exists($fileName)) {
				$fileName = BASE_DIR . '/default/controller/' . implode('/', $parts) . '.php';
				if(!file_exists($fileName)){
					return null;
				}
			}
		}
		return $fileName;
	}

	/**
	 * Trả về đường dẫn theo ứng dụng
	 * @param string $path đường dẫn, dạng application
	 * @return string đường dẫn trả về, dạng app/ptnn/application
	 */
    public function getUri($path) {
        return 'app/' . $this->getPathByName() . '/' . $path;
    }

    /**
     * Trả về đường dẫn của page
     * @param string $page tên page, dạng index,user/info
     * @return string đường dẫn dạng app/ptnn/pages/index
     */
    public function getPageUri($page) {
		$page = preg_replace('/^\//', '', $page);
        return $this->getUri('pages/' . $page);
    }
    
    /**
     * Trả về đường dẫn theo ứng dụng
     * @param string $path đường dẫn, dạng application
     * @return string đường dẫn trả về, dạng app/ptnn/application
     */
    public function getPackageUri($path) {
    	return 'app/' . $this->getPackageByName() . '/' . $path;
    }
    
    /**
     * Trả về đường dẫn của page
     * @param string $page tên page, dạng index,user/info
     * @return string đường dẫn dạng app/ptnn/pages/index
     */
    public function getPackagePageUri($page) {
    	$page = preg_replace('/^\//', '', $page);
    	return $this->getPackageUri('pages/' . $page);
    }
    
    /**
     * Kiểm tra xem có tồn tại uri không
     * @param unknown $path
     * @return boolean
     */
    public function existsUri($path) {
    	return file_exists(BASE_DIR. '/'. $this->getUri($path) . '.php');
    }
    
    /**
     * Có tồn tại page không
     * @param unknown $path
     * @return boolean
     */
    public function existsPageUri($path) {
    	return file_exists(BASE_DIR. '/'. $this->getPageUri($path) . '.php');
    }
    
    /**
     * Lấy đường dẫn của ứng dụng theo tên
     * @return unknown|mixed
     */
    public function getPathByName() {
    	static $path;
    	if($path) return $path;
    	$path = str_replace('_', '/', $this->name);
    	return $path;
    }
    
    /**
     * Lấy đường dẫn của gói theo tên
     * @return unknown|string
     */
    public function getPackageByName() {
    	static $package;
    	if($package) return $package;
    	$packages = explode('_', $this->name);
    	array_pop($packages);
    	$package = implode('/', $packages);
    	return $package;
    }
    
    /**
     * Lấy đường dẫn của trang theo tên
     * @return unknown|string
     */
    public function getSiteByName() {
    	static $site;
    	if($site) return $site;
    	$site = $this->getPathByName() . '/' . pzk_request()->getSoftwareId();
    	return $site;
    }

}
/**
 * Return application element
 *
 * @return PzkCoreApplication
 */
function pzk_app() {
	return pzk_element('app');
}

/**
 * Trả về controller đang chạy
 * @return PzkController
 */
function pzk_controller() {
	return pzk_global()->getController();
}

/**
 * Trả về admin controller đang chạy
 * @return PzkAdminController
 */
function pzk_admin_controller() {
	return pzk_global()->getController();
}
/**
 * Trả về grid admin controller đang chạy
 * @return PzkGridAdminController
 */
function pzk_grid_admin_controller() {
	return pzk_global()->getController();
}

/**
 * Import controller trong package đã 
 * @param String $package gói
 * @param String $controller tên controller
 * @return String tên class
 */
function pzk_import_controller ($package, $controller) {
	$arr = pzk_app()->generateController($controller, $package);
	require_once $arr['filePath'];
	return $arr['className'];
}

if(!is_dir(BASE_DIR . '/compile/controllers')) {
	mkdir(BASE_DIR . '/compile/controllers');
}

?>