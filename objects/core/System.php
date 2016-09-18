<?php
class PzkCoreSystem extends PzkObjectLightWeight {
	public $boundable = false;
	public $libs = array(); 
	public $bootstrap = 'application';
	public $app = false;
	
	/**
	 * Trả về ứng dụng đang chạy
	 * @return PzkCoreApplication
	 */
	public function getApp() {
		if($this->app) return $this->app;
		$request = pzk_request();
		$application = $request->query['app'];
		$app = PzkParser::parse('app/'. $request->getAppPath() . '/' . $this->bootstrap);
		$this->app = $app;
		return $app;
	}
	
	/**
	 * Trả về đường dẫn theo ứng dụng đang chạy
	 * @param string $path đường dẫn
	 * @return string
	 */
	public static function appPath($path) {
		return 'app/' . pzk_request()->getAppPath() . '/' . $path;
	}
	
	/**
	 * Đường dẫn theo hệ thống
	 * @param unknown $path
	 * @return string
	 */
	public function path($path) {
		return BASE_DIR . '/' . $path;
	}
	
	/**
	 * Shutdown hệ thống kèm theo message
	 * Dùng để thay thế cho hàm die thông thường của php
	 * @param string $message
	 */
	public function halt($message = null) {
		if($db = pzk_element('db')) {
			$db->close();
		}
		if(function_exists('pzk_session')) {
			pzk_session()->saveSession();
		}
		if(function_exists('pzk_stat')) {
			pzk_stat()->saveSession();
		}
		die($message);
	}
	
}
/**
 * Trả về đối tượng hệ thống
 * @return PzkCoreSystem
 */
function pzk_system() {
	return pzk_element('system');
}
?>