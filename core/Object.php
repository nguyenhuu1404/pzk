<?php
/**
 * View object
 *
 */
class PzkObject extends PzkSG {
	public $children;
	public $layout = 'empty';
	public $scriptable = false;
	public $scriptTo = 'head';
	public $cacheable = false;
	
	public $cacher = 'memcache';
	public $cacheScope = 'domainscope';
	public $xml = false;
	public $xpath = '';
	public $json = false;

	/**
	 * cac tham so dung de cache, viet cach nhau boi dau phay
	 */

	public $cacheParams = 'id';

	/**
	 * Cac tham so dung de cho ham toArray, viet cach nhau boi dau phay
	 */
	public $arrayParams = false;
	
	public $excludeParams = false;

	/**
	 * Id cua parent element
	 */
	public $pzkParentId = false;

	/**
	 * Id lon nhat cua element
	 */
	public static $maxId = 0;

	/**
	 * Css lien quan den object, css nay se duoc cache lai
	 */
	public $css = false;

	/**
	 * Css nay khong can cache lai
	 */
	public $cssExternalLink = false;

    public $less = false;
    public $lessExternalLink = false;
	/**
	 * Js lien quan den object, js nay se duoc cache lai
	 */
	public $js = false;

	/**
	 * Js nay khong can cache lai
	 */
	public $jsExternalLink = false;
	
	public static $selectors = array();

	/**
	 * Ham khoi tao mot object voi cac attribute cua no truyen
	 * dang mang
	 * @param $attrs la cac thuoc tinh cua doi tuong
	 */
	public function __construct($attrs) {
		foreach($attrs as $key => $value) $this->$key = $value;
		$this->children = array();
		if (!isset($this->id) || !$this->id) {
			$this->id = 'uniqueId' . self::$maxId;
			self::$maxId++;
		}
		$this->less();
		$this->css();
		$this->javascript();
		if($this->xml) {
			$this->importXml();
		}
		if($this->json) {
			$this->importJson();
		}
	}
	
	public function importXml() {
		if(pzk_element('array')) {
			$file = BASE_DIR . '/' . pzk_app()->getUri('xml/' . $this->xml . '.xml');
			if(file_exists($file)) {
				$content = file_get_contents($file);
				$arr = pzk_array();
				$arr->fromXml($content, $this->xpath);
				$data = $arr->getData();
				$arr->clear();
				foreach($data as $key => $val) {
					$this->$key = $val;
				}
			}
		}
	}
	
	public function importJson() {
		if(pzk_element('array')) {
			$file = BASE_DIR . '/'. pzk_app()->getUri('json/' . $this->json . '.json');
			if(file_exists($file)) {
				$content = file_get_contents($file);
				$arr = pzk_array();
				$arr->fromJson($content);
				$data = $arr->getData();
				$arr->clear();
				foreach($data as $key => $val) {
					$this->$key = $val;
				}
			}
		}
	}

    /**
     * Ham them less cho trang
     */
    public function less() {
        
        if ($this->less != false) {
            if($this->scriptTo) {
                $elem = pzk_element($this->scriptTo);
                if(file_exists('default/skin/'.pzk_app()->getPathByName().'/less/'.$this->less.'.less'))
                	$elem->append(pzk_parse('<html.less src="/default/skin/'
                			.pzk_app()->getPathByName().'/less/'.$this->less.'.less" />'));
                else if(file_exists('default/skin/'.pzk_app()->getPackageByName().'/less/'.$this->less.'.less')) {
                	$elem->append(pzk_parse('<html.less src="/default/skin/'
                			.pzk_app()->getPackageByName().'/less/'.$this->less.'.less" />'));
                }
                	
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<script src="/3rdparty/less.min.js"></script>'));
            } else {
            }

        }
        if ($this->lessExternalLink != false) {
            if($this->scriptTo) {
                $elem = pzk_element($this->scriptTo);
                $elem->append(pzk_parse('<html.less src="'.$this->lessExternalLink.'" />'));
            } else {
                if($page = pzk_page()) {
                    $page->addExternalLess($this->lessExternalLink);
                }
            }

        }

    }


    /**
	 * Ham them css cho trang
	 */
	public function css() {
		if ($this->css != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				if(file_exists('default/skin/'.pzk_app()->getPathByName() . '/themes/' . pzk_request()->getDefaultTheme() .'/css/'.$this->css.'.css')) {
					$elem->append(pzk_parse('<html.css src="/default/skin/'.pzk_app()->getPathByName() . '/themes/' . pzk_request()->getDefaultTheme() .'/css/'.$this->css.'.css" />'));
				} else if(file_exists('default/skin/'.pzk_app()->getPathByName().'/css/'.$this->css.'.css')) {
					$elem->append(pzk_parse('<html.css src="/default/skin/'.pzk_app()->getPathByName().'/css/'.$this->css.'.css" />'));
				} else if (file_exists('default/skin/'.pzk_app()->getPackageByName().'/css/'.$this->css.'.css')) {
					$elem->append(pzk_parse('<html.css src="/default/skin/'.pzk_app()->getPackageByName().'/css/'.$this->css.'.css" />'));
				}
			} else {
				if($page = pzk_page())
					$page->addObjCss($this->css);
			}

		}
		if ($this->cssExternalLink != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<html.css src="'.$this->cssExternalLink.'" />'));
			} else {
				if($page = pzk_page()) {
					$page->addExternalCss($this->cssExternalLink);
				}
			}

		}

	}
	
	/**
	 * Add javascript tag for object
	 */
	public function javascript() {
		if ($this->scriptable === true || $this->scriptable === 'true') {
			
			if(isset($this->scriptTo) && $this->scriptTo) {
				$element = pzk_element($this->scriptTo);
				if($element) {
					$element->append(pzk_parse('<html.js src="/js/'.implode('/', $this->fullNames).'.js" />'));
				}
			} else {
				$page =pzk_page();
				if ($page) {
					$page->addObjJs($this->tagName);
				}
			}
		}
		
		if ($this->js != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				if(file_exists('default/skin/'.pzk_app()->getPathByName().'/js/'.$this->js.'.js')) {
					$elem->append(pzk_parse('<html.js src="/default/skin/'.pzk_app()->getPathByName().'/js/'.$this->js.'.js" />'));
				} else if(file_exists('default/skin/'.pzk_app()->getPackageByName().'/js/'.$this->js.'.js')) {
					$elem->append(pzk_parse('<html.js src="/default/skin/'.pzk_app()->getPackageByName().'/js/'.$this->js.'.js" />'));
				}
					
			} else {
				if($page = pzk_page())
					$page->addObjCss($this->css);
			}
			
		}
		if ($this->jsExternalLink != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<html.js src="'.$this->jsExternalLink.'" />'));
			} else {
				if($page = pzk_page()) {
					$page->addExternalCss($this->jsExternalLink);
				}	
			}
			
		}
	}

	/**
	 * Ham nay chay khi doi tuong vua duoc khoi tao,
	 * cac doi tuong con cua no chua duoc khoi tao
	 */
	public function init() {
	}

	/**
	 * Ham nay dung de hien thi doi tuong
	 */
	public function display() {
		$this->script();
		$this->html();
		
	}

	/**
	 * Ham nay tao 1 instance javascript cho doi tuong hien thi
	 */
	public function script() {
		if ($this->scriptable === true || $this->scriptable === 'true') {
			$page = pzk_page();
			if ($page) {
				$page->addJsInst($this->toArray());
			}
		}
	}

	/**
	 * Ham nay tra ve html cua doi tuong can hien thi
	 * Neu request no cache hoac cau hinh cua doi tuong
	 * co cacheable = false thi se ko cache
	 * nguoc lai thi se cache
	 */
	public function html() {
		if (CACHE_MODE && ($this->cacheable === true
		|| $this->cacheable === 'true')) {
			$this->cache();
		} else {
			echo $this->getContent();
		}
		return true;
	}

	/**
	 *	Ham cache lai noi dung hien thi
	 * 	Dua tren cac tham so dua vao de cache
	 * 	Cache nay theo 1 loai cacher nao do:
	 * 	file cache hay memcache hoac db cache, session cache,... 
	 */
	public function cache() {
		$key = $this->hash();
		$store = $this->getCacheStore();
		if (!($content = $store->get($key, 900))) {
			$content = $this->getContent();
			$store->set($key, $content);
		}
		echo $content;
	}
	public $_cacheStore = NULL;
	public function getCacheStore() {
		if(NULL === $this->_cacheStore) {
			$cacher = 'pzk_' . $this->cacher;
			$cacheScope = 'pzk_' . $this->cacheScope;
			$store = $cacheScope($cacher());
			$this->_cacheStore = $store;
		}
		
		return $this->_cacheStore;
	}
	
	public function isCached() {
		$key = $this->hash();
		if($this->getCacheStore()->has($key)) {
			return true;
		}
		return false;
	}

	/**
	 *	Tra ve html cua doi tuong can hien thi
	 * 	truong hop nay la truong hop khi khong co cache
	 */
	public function getContent() {
		$layout = $this->getLayoutRealPath();
		
		$content = PzkParser::parseLayout($layout, $this, true);
		$content = str_replace('src="/', 'src="' . BASE_SKIN_URL . '/', $content);
		$content = str_replace('type="text/css" href="/', 'type="text/css" href="'.BASE_SKIN_URL . '/', $content);
		$content = str_replace('rel="stylesheet" href="/', 'rel="stylesheet" href="'.BASE_SKIN_URL . '/', $content);
		$content = str_replace('property="stylesheet" href="/', 'property="stylesheet" href="'.BASE_SKIN_URL . '/', $content);
		$content = str_replace('href="/', 'href="'. BASE_REQUEST . '/', $content);
		$content = str_replace('action="/', 'action="'. BASE_REQUEST . '/', $content);
		$content = str_replace('url(\'/', 'url(\''. BASE_SKIN_URL . '/', $content);
		return $content;
	}
	
	public function getLayoutRealPath() {
		if(CACHE_MODE && pzk_controllercache()->get($this->layout)) {
			$path = pzk_controllercache()->get($this->layout);
			return $path;
		}
		$layout = null;
		$themes = pzk_request()->getThemes();
		if($themes) {
			
			foreach($themes as $theme) {
				if(!$layout && file_exists(BASE_DIR . '/app/' . pzk_request()->getAppPath() . '/layouts/' . $theme . '/' . $this->layout .'.php' )) {
					$layout = 'app/' . pzk_request()->getAppPath() . '/layouts/' . $theme . '/' . $this->layout;
					break;
				}
			}
			foreach($themes as $theme) {
				if(!$layout && file_exists(BASE_DIR . '/app/' . pzk_request()->getPackagePath() . '/layouts/' . $theme . '/' . $this->layout .'.php' )) {
					$layout = 'app/' . pzk_request()->getPackagePath() . '/layouts/' . $theme . '/' . $this->layout;
					break;
				}
			}
			
			foreach($themes as $theme) {
				if(!$layout && file_exists(BASE_DIR . '/themes/' . $theme . '/' . pzk_request()->getAppPath() . '/layouts/' . $this->layout .'.php' )) {
					$layout = 'themes/' . $theme . '/' . pzk_request()->getAppPath() . '/layouts/' . $this->layout;
					break;
				}
			}
			foreach($themes as $theme) {
				if(!$layout && file_exists(BASE_DIR . '/themes/' . $theme . '/' . pzk_request()->getPackagePath() . '/layouts/' .  $this->layout .'.php' )) {
					$layout = 'themes/' .$theme . '/' . pzk_request()->getPackagePath() . '/layouts/' . $this->layout;
					break;
				}
			}
			
			foreach($themes as $theme) {
				if(!$layout && file_exists(BASE_DIR . '/themes/' . $theme .  '/layouts/' .  $this->layout .'.php' )) {
					$layout = 'themes/' .$theme . '/layouts/' . $this->layout;
					break;
				}
			}
		}
		if(!$layout && file_exists(BASE_DIR . '/app/' . pzk_request()->getAppPath() . '/layouts/'. $this->layout .'.php' )) {
			$layout = 'app/' . pzk_request()->getAppPath() . '/layouts/'. $this->layout;
			
		} else if(!$layout && file_exists(BASE_DIR . '/app/' . pzk_request()->getPackagePath() . '/layouts/'. $this->layout . '.php' )) {
			$layout = 'app/' . pzk_request()->getPackagePath() . '/layouts/'. $this->layout;
		} else if(!$layout){
			$layout = 'default/layouts/'. $this->layout;
		}
		
		if(CACHE_MODE) {
			pzk_controllercache()->set($this->layout, $layout);
		}
		
		return $layout;
	}
	
	public function getCssRealPath() {
		if(CACHE_MODE && pzk_controllercache()->get($this->css)) {
			$path = pzk_controllercache()->get($this->css);
			return $path;
		}
		$css = null;
		$themes = pzk_request()->getThemes();
		if($themes) {
			
			foreach($themes as $theme) {
				if(!$css && file_exists(BASE_DIR . '/default/skin/' . pzk_request()->getAppPath() . '/themes/' . $theme . '/css/' . $this->css .'.css' )) {
					$css = 'default/skin/' . pzk_request()->getAppPath() . '/themes/' . $theme . '/css/' . $this->css;
					break;
				}
			}
			foreach($themes as $theme) {
				if(!$css && file_exists(BASE_DIR . '/default/skin/' . pzk_request()->getPackagePath() . '/themes/' . $theme . '/css/' . $this->css .'.css' )) {
					$css = 'default/skin/' . pzk_request()->getPackagePath() . '/themes/' . $theme . '/css/' . $this->css;
					break;
				}
			}
		}
		if(!$css && file_exists(BASE_DIR . '/default/skin/' . pzk_request()->getAppPath() . '/css/'. $this->css .'.css' )) {
			$css = 'default/skin/' . pzk_request()->getAppPath() . '/css/'. $this->css;
			
		} else if(!$css && file_exists(BASE_DIR . '/default/skin/' . pzk_request()->getPackagePath() . '/css/'. $this->css . '.css' )) {
			$css = 'default/skin/' . pzk_request()->getPackagePath() . '/css/'. $this->css;
		} else if(!$css){
			$css = 'default/skin/css/'. $this->css;
		}
		if(CACHE_MODE) {
			pzk_controllercache()->set($this->css, $css);
		}
		return $css;
	}

	/**
	 * 	Tao key cho doi tuong can hien thi (de cache)
	 */
	public function hash() {
		$cacheParams = explode(',',$this->cacheParams);
		$hash ='';
		foreach($cacheParams as $param) {
			$param = trim($param);
			$hash .= isset($this->$param) ? (is_array($this->$param) ? json_encode($this->$param): $this->$param) : '';
		}
		if(function_exists('pzk_session')) {
			$language = pzk_session()->getLanguage();
			$hash = $hash.$language;
		}
		$hash .= pzk_request()->getSoftware() . '_' . pzk_request()->getSite() . '_' . pzk_request()->isMobile() . '_' . pzk_request()->isTablet();
		return md5($hash);
	}

	/**
	 *	Append mot child object 
	 */
	public function append($obj) {
		$obj->pzkParentId = isset($this->id)?$this->id: null;
		$this->children[] = $obj;
	}
	
	/**
	 * Prepend mot child object
	 */
	public function prepend($obj) {
		$obj->pzkParentId = isset($this->id) ? $this->id : null;
		array_unshift($this->children, $obj);
	}
	
	/**
	 * Insert mot child object vao vi tri index
	 */
	public function insert($obj, $index) {
		$obj->pzkParentId = isset($this->id) ? $this->id : null;
		array_splice($this->children, $index, 0, $obj);
	}
	
	/**
	 * Tra ve vi tri cua doi tuong trong danh sach anh em cua no
	 */
	public function index() {
		if ($parent = $this->getParent()) {
			return array_search($this, $parent->children);
		}
		return -1;
	}
	
	/**
	 * Insert mot doi tuong vao ngay truoc doi tuong
	 */
	public function before(&$obj) {
		if ($parent = $this->getParent()) {
			$parent->insert($obj, $this->index());
		}
	}
	
	/**
	 * Insert mot doi tuong vao ngay sau doi tuong
	 */
	public function after(&$obj) {
		if ($parent = $this->getParent()) {
			$parent->insert($obj, $this->index() + 1);
		}
	}
	
	/**
	 * Lay ra cha cua doi tuong do
	 */
	public function getParent() {
		if ($this->pzkParentId) {
			return pzk_element($this->pzkParentId);
		}
		return NULL;
	}
	
	/**
	 * Lay ra tat ca cac con cua doi tuong theo selector
	 * @param $selector: selector can chon dua theo cau truc
	 * 	tagName[name=value][name=value]
	 */
	public function getChildren($selector = 'all') {
		if ($selector == 'all') return $this->children;
		$rslt = array();
		$attrs = $this->parseSelector($selector);
		foreach($this->children as $child) {
			if ($child->matchAttrs($attrs)) {
				$rslt[] = $child;
			}
		}
		return $rslt;
	}
	
	/**
	 * Tim mot element la con cua doi tuong goc, theo 1 selector
	 */
	public function findElement($selector = 'all') {
		$attrs = $this->parseSelector($selector);
		foreach($this->children as $child) {
			if ($child->matchAttrs($attrs)) {
				return $child;
			} else {
				if ($elem = $child->findElement($selector)) {
					return $elem;
				}
			}
		}
		return null;
	}
	
	/**
	 * Tim cac elements theo selectors
	 */
	public function findElements($selector = 'all') {
		$attrs = $this->parseSelector($selector);
		$result = array();
		foreach($this->children as $child) {
			if ($child->matchSelector($attrs)) {
				$result[] = $child;
			}
			$childElements = $child->findElements($selector);
			foreach($childElements as $elem) {
				$result[] = $elem;
			}
		}
		return $result;
	}
	
	/**
	 * tim parent theo selector
	 */
	public function findParent($selector) {
		if ($parent = $this->getParent()) {
			if($parent->matchSelector($selector)) {
				return $parent;
			}
		}
		return null;
	}
	
	/**
	 * Tim cac parent theo selector
	 */
	public function findParents($selector) {
		$parents = array();
		$cur = $this->getParent();
		while($cur) {
			if ($cur->matchSelector($selector)) {
				$parents[] = $cur;
			}
			$cur = $cur->getParent();
		}
		return $parents;
	}
	
	/**
	 * Hien thi tat ca cac children theo selector
	 */
	public function displayChildren($selector = 'all') {
		$children = $this->getChildren($selector);
		if(is_array($children)) {
			foreach($children as $child) {
				$child->display();
			}
		} else $children->display();
	}
	
	public function matchSelector($selector) {
		$attrs = $this->parseSelector($selector);
		if ($this->matchAttrs($attrs)) {
			return true;
		}
		return false;
	}
	
	/**
	 * khop cac thuoc tinh
	 */
	public function matchAttrs($attrs) {
		foreach($attrs as $key => $attr) {
			if(!isset($attr['comparator'])) continue;
			switch($attr['comparator']) {
				case '=':
					if (isset($this->$key) && $this->$key != $attr['value']) {
						return false;
					}
					break;
				case '!=':
				case '<>':
					if (isset($this->$key) && $this->$key == $attr['value']) {
						return false;
					}
					break;
				case '^=':
					if (isset($this->$key) && strpos($this->$key, $attr['value']) !== 0) {
						return false;
					}
					break;
				case '*=':
					if (isset($this->$key) && strpos($this->$key, $attr['value']) === FALSE) {
						return false;
					}
					break;
			}
		}
		return true;
	}
	
	/**
	 * Parse selector tra ve 1 mang cac dieu kien loc
	 *
	 * @param $selector
	 * @return mang kieu kien
	 */
	function parseSelector($selector) {
		if (isset(self::$selectors[$selector])) return self::$selectors[$selector];
		$pattern = '/^([\w\.\d]+)?((\[[^\]]+\])*)?$/';
		$subPattern = '/\[([^=\^\$\*\!\<]+)(=|\^=|\$=|\*=|\!=|\<\>)([^\]]+)\]/';
		if (preg_match($pattern, $selector, $match)) {
			preg_match_all($subPattern, $match[2], $matches);
			$attrs = array();

			$tagName = $match[1];
			if ($tagName) {
				$attrs['tagName'] = $tagName;
			}

			for($i = 0; $i < count($matches[1]); $i++) {
				$attrs[$matches[1][$i]] = array('comparator' => $matches[2][$i], 'value' => $matches[3][$i]);
			}
			
			self::$selectors[$selector] = $attrs;

			return $attrs;
		}
		self::$selectors[$selector] = array();
		return array();
	}

	/**
	 * Ham nay chay khi tat ca cac child object cua no da duoc khoi tao
	 */
	public function finish() {
	}
	
	/**
	 * Ham nay tra ve array mo ta doi tuong dua theo arrayParams
	 */
	public function toArray() {
		$result = (array)$this;
		unset($result['children']);
		if(isset($this->excludeParams) && $this->excludeParams) {
			$arrayParams = explodetrim(',', $this->excludeParams);
			foreach($arrayParams as $param) {
				$param = trim($param);
				if (isset($this->$param)) {
					unset($result[$param]);
				}
			}
		}
		if(isset($this->arrayParams) && $this->arrayParams) {
			$rs2 = array();
			$arrayParams = explodetrim(', ', $this->arrayParams);
			$arrayParams[] = 'id';
			$arrayParams[] = 'tagName';
			$arrayParams[] = 'package';
			$arrayParams[] = 'className';
			$arrayParams[] = 'fullNames';
			foreach($arrayParams as $param) {
				if (isset($this->$param)) {
					$rs2[$param] = $result[$param];
				}
			}
			return $rs2;
		}
		return $result;
	}
	
	public function translate($text) {
		if(pzk_language()) {
			return pzk_language()->translateText(implode('/', $this->fullNames), $text);
		} else {
			return $text;
		}
	}
	
	public function getProp($prop, $default = null) {
		if(isset($this->$prop)) return $this->$prop;
		return $default;
	}
	
	public function getModel($model) {
		return pzk_loader()->getModel($model);
	}
	
	public $events = array();
	
	public function addEventListener($event, $handler){
		if(!isset($this->events[$event])) {
			$this->events[$event] = array();
		}
		$this->events[$event][] = $handler;
	}
	
	public function onEvent($event) {
		$str = '';
		$rq = pzk_request();
		$controller = $rq->get('controller');
		$BASE_REQUEST = BASE_REQUEST;
		$eventHandlers = isset($this->events[$event]) ? $this->events[$event]: array();
		foreach ($eventHandlers as $handler) {
			$str .= "(function(data) {
			jQuery.ajax({url: '$BASE_REQUEST/$controller/$handler',type: 'post', data:data, success: function(resp) {
				eval(resp);
			}});
		})(data);";
		}
		$str = "(function(data){ {$str} })";
		return $str;
	}
	
	public function __toString() {
		return $this->getContent();
	}
}
