<?php
class PzkCompiler {
	public $source = '';
	public $target = '';
	public function compile() {
		
	}
	
	public function compileDir($dir) {
		for($i = 0; $i < 16; $i++) {
			$subDir = str_repeat('/*', $i);
			$pattern = $dir . $subDir . '/*.php';
			$files = glob($pattern);
			foreach($files as $file) {
				$this->setSource($file);
				$this->compile();
			}
		}
		
	}
	
	public function setSource($source) {
		$this->source = $source;
		return $this;
	}
	public function setTarget($target) {
		$this->target = $target;
		return $this;
	}
}

class PzkPageCompiler extends PzkCompiler {
	public $target = 'compile/pages/';
	public function compile() {
		$file = $this->source;
		$fileName = $this->_getFileName($file);
		if(!$this->isCompiled($file)) {
			
			try {
				$content = '';
				ob_start();
				require $file;
				$content = ob_get_contents();
				ob_end_clean();
				$content = str_replace('&', '&amp;', $content);
				
				$pageDom = new DOMDocument('1.0', 'utf-8');
				$pageDom->preserveWhiteSpace = false;
				$pageDom->formatOutput = true;
				$pageDom->loadXML($content);
				$fileContent = $this->compileNode($pageDom->documentElement);
				file_put_contents($fileName, '<'.'?php '. $fileContent);
				echo 'File <a href="#">' . $file . '</a> compiled successfully!<br />';
			} catch(Exception $ex) {
				echo 'Error at: ' . $file . '<br />' . $ex->getMessage() .'<br />';
			}
			
		} else {
			echo 'File <a href="#">' . $file . '</a> already compiled!<br />';
		}
	}
	private $_fileNames = array();
	private function _getFileName($file) {
		return (isset($this->_fileNames[$file])) ? $this->_fileNames[$file] : $this->_fileNames[$file] = $this->target . str_replace('/', '_', $file);
	}
	
	public function isCompiled($file) {
		$fileName = $this->_getFileName($file);
		return file_exists($fileName) && (filemtime($file) <= filemtime($fileName));
	}
	
	public function compileNode($node, &$index = 0) {
		$content = '';
		$name = $node->nodeName;

		// xet xem co phai html tag binh thuong khong
		if (PzkParser::isHtmlTag($name)) {
			$name = 'HtmlTag';
		}
		$names = explode('.', $name);
		$fullNames = array_merge(array(), $names);

		$name = array_pop($names);
		$package = implode('/', $names);

		$className = PzkParser::getClass($fullNames);
		$content .= "require_once BASE_DIR . '/compile/objects/$className.php';\r\n";
		// lay cac thuoc tinh
		$attrs = array();
		foreach ($node->attributes as $attr) {
			$attrs[$attr->nodeName] = $attr->nodeValue;
		}
		//$attrs['tagName'] = $node->nodeName;
		//$attrs['package'] = $package;
		$attrs['className'] = $className;
		$attrs['fullNames'] = $fullNames;
		$attrs = var_export($attrs, true);
		$content .= '$obj'.$index.' = new ' . $className . '('. $attrs . ');' ."\r\n";
		$content .= 'pzk_element($obj'.$index.'->id, $obj'.$index.');'. "\r\n";
		$oldIndex = $index;
		$index++;
		$content .= '$obj'.$oldIndex.'->init();' ."\r\n";
		foreach($node->childNodes as $childNode) {
			if ($childNode->nodeType == XML_ELEMENT_NODE) {
				$childIndex = $index;
				$content .= $this->compileNode($childNode, $index);
				$content .= '$obj'.$oldIndex.'->append($obj'.$childIndex.');' ."\r\n";
			} else if ($childNode->nodeType == XML_TEXT_NODE || $childNode->nodeType == XML_CDATA_SECTION_NODE) {
				if (trim($childNode->nodeValue)) {
					$attrs = array();
					//$attrs['tagName'] = 'textLabel';
					//$attrs['package'] = '';
					$attrs['className'] = 'PzkTextLabel';
					$attrs['fullNames'] = array('TextLabel');
					$attrs['value'] = trim($childNode->nodeValue);
					$attrs = var_export($attrs, true);
					$content .= '$obj'.$index.' = new PzkTextLabel('. $attrs . ');' ."\r\n";
					$content .= '$obj'.$index.'->init();' ."\r\n";
					$content .= '$obj'.$index.'->finish();' ."\r\n";
					$content .= '$obj'.$oldIndex.'->append($obj'.$index.');' ."\r\n";
					$index++;
				}
				// neu la mot cdata node
			}
		}
		$content .= '$obj'.$oldIndex.'->finish();' ."\r\n";
		return $content;
	}
}

class PzkObjectCompiler extends PzkCompiler {
	public $target = 'compile/objects/';
	public function compile() {
		$file = $this->source;
		$parts = explode('/', $file);
		array_shift($parts);
		foreach($parts as $index => $part) {
			$parts[$index] = ucfirst($parts[$index]);
		}
		$fileName = $this->target . 'Pzk' . implode('', $parts);
		if(!file_exists($fileName) || (filemtime(utf8_decode($file)) > filemtime(utf8_decode($fileName)))) {
			copy($file, $fileName);
			echo 'File <a href="#">' . $file . '</a> compiled successfully!<br />';
		} else {
			echo 'File <a href="#">' . $file . '</a> already compiled!<br />';
		}
	}
}

class PzkModelCompiler extends PzkObjectCompiler {
	public $target = 'compile/models/';
}

class PzkControllerCompiler extends PzkCompiler {
	public $target = 'compile/controller/';
	public function compile() {
		$file = $this->source;
		$fileName = $this->target . str_replace('/', '_', $file);
		if(!file_exists($fileName) || (filemtime(utf8_decode($file)) > filemtime(utf8_decode($fileName)))) {
			copy($file, $fileName);
			echo 'File <a href="#">' . $file . '</a> compiled successfully!<br />';
		} else {
			echo 'File <a href="#">' . $file . '</a> already compiled!<br />';
		}
	}
}