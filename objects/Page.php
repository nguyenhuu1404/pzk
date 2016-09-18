<?php
class PzkPage extends PzkObject {

	public $title = 'Pzk Page';
	public $layout = 'page';
	public $keywords = '';
	public $description = '';
	public $jsFiles = array(
		'/jquery-1.7.1.min.js', 
		'/components.js'
	);
	public $jsInstances = array();
	public $cssFiles = array();
    public $lessFiles = array();
	public $cssExternals = array();
    public $lessExternals = array();
	public $style = false;
	public $scriptable = false;

	public $boundable = false;
	public $template = false;
	
	/**
	Them duong dan javascript
	Cac duong dan javascript duoc them vao nay se duoc noi vao thanh 1 file javascript chung
	*/
	public function addJs($js) {
		if (!in_array($js, $this->jsFiles)){
			$this->jsFiles[] = $js;
		}
	}

	/**
	Them duong dan khoi tao doi tuong javascript
	*/
	public function addObjJs($obj) {
		$this->addJs('/js/' . $obj . '.js');
	}
	
	/**
		Them mot obj instance javascript khi scriptable = true
	*/
	public function addJsInst($obj) {
		$this->jsInstances[] = $obj;
	}

	public function addCss($link) {
		if (!in_array($link, $this->cssFiles)) {
			$this->cssFiles[] = $link;
		}
	}

    public function addLess($link) {
        if (!in_array($link, $this->lessFiles)) {
            $this->lessFiles[] = $link;
        }
    }
	
	public function addExternalCss($link) {
		if (!in_array($link, $this->cssExternals)) {
			$this->cssExternals[] = $link;
		}
	}

    public function addExternalLess($link) {
        if (!in_array($link, $this->lessExternals)) {
            $this->lessExternals[] = $link;
        }
    }

	public function addObjCss($obj) {
		$css = pzk_app()->getTemplateUri($obj . '.css');
		$this->addCss($css);
	}

    public function addObjLess($obj) {
        $css = pzk_app()->getTemplateUri($obj . '.less');
        $this->addLess($css);
    }

	public function cacheJs() {
		return false;
		$page = pzk_or(@$_REQUEST['page'], 'index');
		$page = str_replace('/', '_', $page);
			
		$fileName = BASE_DIR . '/public/' . pzk_app()->getPathByName() . '_' . $page . '.js';

		if (file_exists($fileName)) {
			$recacheable = false;
			foreach ($this->jsFiles as $file) {
				if (strpos($file, BASE_DIR) === FALSE)
				$jsFile = BASE_DIR . $file;
				else
				$jsFile = $file;
				if (file_exists($jsFile)) {
					if (filemtime($jsFile) > filemtime($fileName)) {
						$recacheable = true;
						break;
					}
				}
			}
			if (!$recacheable)
			return true;
		}

		$content = '';
		foreach ($this->jsFiles as $file) {
			if (file_exists(($jsFile = BASE_DIR . $file))) {
				$content .= "\n" . file_get_contents($jsFile);
			}
		}
		require_once BASE_DIR . '/3rdparty/minify-2.1.5/min/lib/JSMin.php';
		$minContent = JSMin::minify($content);
		file_put_contents($fileName, $minContent);
	}

	public function cacheCss() {
		return false;
		if(@$_REQUEST['showParse']) {
			pre($this->cssFiles);
			pre($this->cssExternals);
		}
		foreach ($this->cssExternals as $file) {
			if (file_exists(($cssFile = BASE_DIR . '/' . $file)) 
					|| file_exists($cssFile = $file)) {
				$filePath = dirname($cssFile) . '/' . basename($cssFile);
				$fileName = BASE_DIR . $filePath;
				if (filemtime($cssFile) > filemtime($fileName)) {
					$content .= "\n" . file_get_contents($cssFile);
					$content = preg_replace("/{$o}tpl ([^{$c}]+){$c}/", 
							'<?php echo _template_path($1);?>', $content);
					file_put_contents($fileName, $content);
				}
				$this->cssExternalFiles[] = $filePath;
			}
		}

		$page = pzk_or(@$_REQUEST['page'], 'index');
		$page = str_replace('/', '_', $page);
		$fileName = BASE_DIR . '/public/' . pzk_app()->getPathByName() . '_' . $page . '.css';
		
		if (file_exists($fileName)) {
			$recacheable = false;
			foreach ($this->cssFiles as $file) {
				
				$cssFile = BASE_DIR .'/'. $file;
				
				if (file_exists($cssFile)) {
					if (filemtime($cssFile) > filemtime($fileName)) {
						$recacheable = true;
						break;
					}
				}
			}
			if (!$recacheable)
				return true;
		}
		
		$content = '';
		foreach ($this->cssFiles as $file) {
			$cssFile = BASE_DIR . '/' . $file;
			if (file_exists($cssFile)) {
				
				$content .= "\n" . file_get_contents($cssFile);
				
				$content = preg_replace("/\{tpl ([^\}]+)\}/", 
							'<?php echo BASE_URL . "/" . pzk_app()->getTemplateUri($1);?>', $content);
				ob_start();
				eval('?>' . $content);
				$content = ob_get_clean();
			}
		}
		$path = BASE_DIR . '/libraries/minify-2.1.5/min/lib';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		//require_once 'Minify/CSS.php';
		//$minContent = Minify_CSS::minify($content);
		file_put_contents($fileName, $content);
	}

	public function finish() {
		$this->cacheCss();
		$this->cacheJs();
	}
	
	public function getTemplatePath($path) {
		$app = pzk_element('app');
		$page = pzk_element('page');
		return BASE_URL . '/design/' . $app->name . '/' . $page->template . '/' . $path;
	}
}

/**
 * Return page object
 *
 * @return PzkPage
 */
function pzk_page() {
	return pzk_element('page');
}
?>