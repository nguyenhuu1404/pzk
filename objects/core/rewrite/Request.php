<?php
class PzkCoreRewriteRequest extends PzkObjectLightweight{
	/**
	 * Là tên của trường trong đối tượng pzk_request(). Trường này được đem ra so sánh
	 * @var string
	 */
	public $matcher = 'route'; // 
	
	/**
	 * Mẫu để so sánh
	 * @var string
	 */
	public $pattern = '';
	/**
	 * Giá trị trả về cuối cùng
	 * @var string
	 */
	public $route = false; // target
	
	/**
	 * Phương thức so sánh, có mấy kiều: preg_match, equal, strpos
	 * @var string
	 */
	public $matchMethod = 'preg_match'; // equal, strpos
	
	/**
	 * Phương thức thay thế trong route, kiểu: preg_replace, str_replace
	 * @var string
	 */
	public $replaceMethod = 'preg_replace';
	
	/**
	 * Thay thế toàn bộ
	 * @var boolean
	 */
	public $replaceFullTarget = false;
	
	/**
	 * Thay thế vào đối tượng pzk_request(). viết dạng var1, var2
	 * @var string
	 */
	public $queryParams = false;
	/**
	 * Bổ sung giá trị mặc định vào pzk_request(). Viết dạng chuỗi json
	 * @var json string
	 */
	public $defaultQueryParams = false;
	/**
	 * Gán giá trị theo url cho các đối tượng
	 * @var string
	 */
	public $elementParams = false;
	/**
	 * Giá trị mặc định cho các đối tượng
	 * @var string
	 */
	public $defaultElementParams = false;
	
	public $language	= false;
	public function init() {
		$request = pzk_element('request');
		$matcher = $this->matcher; 
		$matchSource = $request->$matcher;
		if($this->isEqualMatchMethod()) {
			if ($matchSource == $this->pattern) {
				$this->bindDefaultQueryParams();
				$this->bindDefaultElementParams();
				
				
				if($this->route) {
					$request->route = $this->route;
				}
				if($this->language == 'true') {
					$language = pzk_session()->getLanguage();
					if($language == 'vn' || $language == '') {
						require_once BASE_DIR .'/themes/songngu/language/vn.php';
					} else if($language == 'ev'){
						require_once BASE_DIR .'/themes/songngu/language/ev.php';
					} else {
						require_once BASE_DIR .'/themes/songngu/language/en.php';
					}
				}
			}
		} elseif ($this->isRegexMatchMethod()) {
			
			$this->reformatPattern();
			if(preg_match('/'.$this->pattern.'/is', $matchSource, $matches)) {
				$this->bindDefaultQueryParams();
				$this->bindQueryParams($matches);
				
				
				$this->bindDefaultElementParams();
				$this->bindElementParams($matches);
				
				
				if($this->route) {
					$this->matchRouteToRequest($matches);
				}
			}
		}
	}
	
	public function reformatPattern() {
		$this->pattern = preg_replace('/\[\*([\w][\w\d]*)\*\]/', '?P<$1>', $this->pattern);
		$this->pattern = str_replace('&lt;', '<', str_replace('&gt;', '>', $this->pattern));
	}
	public function build($queryParams) {
	}
	
	public function isEqualMatchMethod() {
		return $this->matchMethod == 'equal';
	}
	
	public function isRegexMatchMethod() {
		return $this->matchMethod == 'preg_match';
	}
	
	public function bindDefaultQueryParams() {
		if($this->defaultQueryParams) {
			$request = pzk_request();
			$params = is_array($this->defaultQueryParams) ? $this->defaultQueryParams : json_decode($this->defaultQueryParams, true);
			$request->query = array_merge($request->query, $params);
		}
	}
	
	public function bindQueryParams($matches) {
		if($this->queryParams) {
			$request = pzk_request();
			$keys = explode(',', $this->queryParams);
			foreach($keys as $key) {
				$key = trim($key);
				if(isset($matches[$key]) && $matches[$key])
					$request->query[$key] = isset($matches[$key])?$matches[$key]: null;
			}
		}
	}
	
	public function bindDefaultElementParams() {
		if($this->defaultElementParams) {
			$params = is_array($this->defaultElementParams)? $this->defaultElementParams : json_decode($this->defaultElementParams, true);
			foreach($params as $param => $value) {
				$parts = explode('.', $param);
				$element = $parts[0];
				$attr = $parts[1];
				if($e = pzk_element($element)) {
					$e->$attr = $value;
				}
			}
		}
	}
	
	public function bindElementParams($matches) {
		if($this->elementParams) {
			$keys = explode(',', $this->elementParams);
			foreach($keys as $key) {
				$key = trim($key);
				$parts = explode('.', $key);
				$element = $parts[0];
				$attr = $parts[1];
				if(isset($matches[str_replace('.', '_', $key)]) && $value = $matches[str_replace('.', '_', $key)]) {
					if($e = pzk_element($element)) {
						$e->$attr = $value;
					}
				}
			}
		}
	}
	
	public function matchRouteToRequest($matches) {
		$request 		= pzk_request();
		$route 			= $this->route;
		foreach($matches as $index => $value) {
			$route 			= str_replace('$' . $index, $value, $route);
		}
		$request->route = $route;
	}
}