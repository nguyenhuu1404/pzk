<?php
class PzkCoreRequest extends PzkObjectLightWeightSG {
	/**
	 * Đường dẫn URL, chỉ chứa đường dẫn không có ?query=...
	 * @var String
	 */
	public $url;
	/**
	 * Phương thức: là POST, GET,...
	 * @var String
	 */
	public $method;
	/**
	 * Giao thức là http, https,...
	 * @var String
	 */
	public $protocol;
	/**
	 * Host là tên miền như ptnn.vn, qlhs.vn
	 * @var String
	 */
	public $host;
	/**
	 * Cổng kết nối, mặc định là 80
	 * @var unknown
	 */
	public $port;
	/**
	 * Đường dẫn đầy đủ
	 * @var String
	 */
	public $uri;
	/**
	 * Các biến get
	 * @var Array
	 */
	public $query;
	/**
	 * Các options là các biến đằng sau dấu #
	 * @var Array
	 */
	public $options;
	
	/**
	 * (non-PHPdoc)
	 * @see PzkObjectLightWeightSG::init()
	 */
	public function init() {
		$this->parse_full_path();
	}
	
	private function parse_full_path()
	{
		$s = &$_SERVER;
		$ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
		$sp = strtolower($s['SERVER_PROTOCOL']);
		
		$protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
		$this->protocol = $protocol;
		
		$port = $s['SERVER_PORT'];
		$this->port = $port;
		$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
		$this->resovledPort = $port;
		$host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
		$this->host = $host;
		$host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
		$uri = $protocol . '://' . $host . $s['REQUEST_URI'];
		$this->uri = $uri;
		$segments = explode('?', $uri, 2);
		$url = $segments[0];
		$this->url = $url;
		$route_uri = $s['REQUEST_URI'];
		$segments2 = explode('?', $route_uri, 2);
		$full_route = $segments2[0];
		$this->full_route = $full_route;
		$segments3 = explode(STARTUP_SCRIPT, $full_route, 2);
		$this->route = isset($segments3[1])?$segments3[1]: $segments3[0];
		$this->stripped_slash_route = preg_replace('/^[\/]/', '', $this->route);
		$this->query = $_REQUEST;
		$this->method = $_SERVER['REQUEST_METHOD'];
		return $url;
	}
	
	/**
	 * Kiểm tra xem phương thức là gì
	 * $method = get|post|put|delete|head|options|ajax|ssl|flash|mobile
	 * @param String $method Phương thức cần kiểm tra
	 * @return boolean
	 */
	public function is($method) {
		return ($this->method == $method);
	}
	
	/**
	*	Kiểm tra xem phương thức có phải là phương thức POST không
	*	@return boolean
	*/
	public function isPost() {
		return $this->is('POST') || $this->is('post');
	}
	
	/**
	*	Kiểm tra xem phương thức có phải là phương thức GET không
	*	@return boolean
	*/
	public function isGet() {
		return $this->is('GET') || $this->is('get');
	}
	
	/**
	 * Xây dựng đường dẫn dựa vào route và query
	 * @example pzk_request()->build('home/category', array('id' => 1)); <br />
	 * Tạo ra đường dẫn http://example.com/home/category?id=1
	 * @param String $route như home/category
	 * @param Array $query mảng các biến get
	 * @param string $options mảng các options
	 * @return string đường dẫn
	 */
	public function build($route, $query = false, $options = false) {
		return BASE_REQUEST . '/' . $route . ($query ? '?' . http_build_query($query) : '') . ($options ? '#' . http_build_query($options) : '');
	}
	
	/**
	 * Xây dựng đường dẫn dựa vào đường dẫn hiện thời
	 * @example Đường dẫn hiện thời là: http://example.com/home/category?page=3<br /> 
	 * pzk_request()->buildCurrent(array('page' => 5)); <br />
	 * Tạo ra đường dẫn http://example.com/home/category?page=5
	 * @param string $query
	 * @param string $options
	 * @return string
	 */
	public function buildCurrent($query = false, $options = false) {
		$route = preg_replace('/^\//', '', $this->route);
		return $this->build($route, $query, $options);
	}
	
	/**
	 * Xây dựng đường dẫn dựa vào controller hiện thời
	 * @example Đường dẫn hiện thời là: http://example.com/home/category?page=3<br /> 
	 * pzk_request()->buildAction('detail', array('id' => 5)); <br />
	 * Tạo ra đường dẫn http://example.com/home/detail?id=5
	 * @param string $action action của đường dẫn mới
	 * @param string $query các biến get
	 * @param string $options
	 * @return string đường dẫn cần tạo
	 */
	public function buildAction($action = false, $query = false, $options = false) {
		$route = $this->get('controller') . '/' . $action;
		return $this->build($route, $query, $options);
	}
	
	/**
	 * Đặt giá trị
	 * @param String $key
	 * @param mixed $value
	 */
	public function set($key, $value) {
		$this->query[$key] = $value;
	}
	
	/**
	 * unset giá trị
	 * @param String $key
	 */
	public function un_set($key) {
		unset($this->query[$key]);
	}
	
	/**
	 * Lấy giá trị ra, nếu ko có thì lấy giá trị mặc định
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($key, $default = NULL) {
		if(isset($this->query[$key])) return $this->query[$key];
		else return $default;
	}
	
	/**
	 * Lấy dữ liệu của url theo phân đoạn
	 * @param int $index vị trí của phân đoạn tính từ 1
	 */
	public function getSegment($index) {
		$parts = null;
		if(isset($this->parts)) {
			$parts = $this->parts;
		} else {
			$parts = explode('/', $this->route);
			$this->parts = $parts;
		}
		
		return isset($parts[$index])?$parts[$index]: null;
	}
	
	/**
	 * Redirect về một url
	 * @param string $url
	 */
	public function redirect($url) {
		if(strpos($url, '://') !== false)
			header('Location: ' . $url);
		else
			header('Location: ' . BASE_REQUEST . '/' . $url);
		if(function_exists('pzk_system'))
			pzk_system()->halt();
	}
	public $is_admin_route = NULL;
	public function isAdminRoute() {
		if($this->is_admin_route === NULL) {
			$this->is_admin_route = substr($this->stripped_slash_route, 0, 5) == 'admin';
		}
		return $this->is_admin_route;
	}
	
	public function getStrippedSlashRoute() {
		return $this->stripped_slash_route;
	}
	
	public function getAppPath() {
		static $path;
		if($path) return $path;
		$path = str_replace('_', '/', $this->getApp());
		return $path;
	}
	
	public function getPackagePath() {
		static $package;
		if($package) return $package;
		$packages = explode('_', $this->getApp());
		array_pop($packages);
		$package = implode('/', $packages);
		return $package;
	}
	public $detector = null;
	public function getDetector() {
		if(!$this->detector) {
			require_once BASE_DIR . '/3rdparty/Mobile-Detect-2.8.22/Mobile_Detect.php';
			$this->detector = new Mobile_Detect();
		}
		return $this->detector;
	}
	public $_isMobileAndTablet = NULL;
	public function isMobileAndTablet() {
		if(NULL === $this->_isMobileAndTablet) {
			return ($this->_isMobileAndTablet = $this->getDetector()->isMobile());
		}
		return $this->_isMobileAndTablet;
	}
	
	public $_isTablet = NULL;
	public function isTablet() {
		if(NULL === $this->_isTablet) {
			return ($this->_isTablet = $this->getDetector()->isTablet());
		}
		return $this->_isTablet;
	}
	
	public $_isMobile = NULL;
	public function isMobile() {
		if(NULL === $this->_isMobile) {
			return ($this->_isMobile = $this->isMobileAndTablet() && !$this->isTablet());
		}
		return $this->_isMobile;
	}
}
/**
 * 
 * @param string $var
 * @param string $value
 * @return PzkCoreRequest|mixed
 */
function pzk_request($var = NULL, $value = NULL) {
	$request = pzk_element('request');
	if($var == NULL) return $request;
	if($value == NULL) return $request->get($var);
	return $request->set($var, $value);
}

/**
 * Redirect về một đường dẫn url
 * @param string $url
 */
function pzk_redirect($url) {
	return pzk_request()->redirect($url);
}