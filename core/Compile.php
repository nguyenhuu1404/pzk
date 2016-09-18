<?php
function copyGlob($pattern, $dir = 'compile/objects') {
	$files = glob($pattern);
	foreach($files as $file) {
		$parts = explode('/', $file);
		array_shift($parts);
		foreach($parts as $index => $part) {
			$parts[$index] = ucfirst($parts[$index]);
		}
		$fileTarget = $dir . '/Pzk' . implode('', $parts);
		if(!file_exists($fileTarget) || (filemtime(utf8_decode($file)) > filemtime(utf8_decode($fileTarget))))
			copy($file, $fileTarget);
		//echo $file . '<br />';
		//require_once $fileTarget;
	}
}
function compileObjects() {
	copyGlob('objects/*.php');
	copyGlob('objects/*/*.php');
	copyGlob('objects/*/*/*.php');
	copyGlob('objects/*/*/*/*.php');
	copyGlob('objects/*/*/*/*/*.php');
	copyGlob('objects/*/*/*/*/*/*.php');
	copyGlob('objects/*/*/*/*/*/*/*.php');
	copyGlob('objects/*/*/*/*/*/*/*/*.php');
}
function compileControllers() {
	
	compileControllerGlob('default/controller/*.php');
	compileControllerGlob('default/controller/*/*.php');
	compileControllerGlob('default/controller/*/*/*.php');
	compileControllerGlob('default/controller/*/*/*/*.php');
	
	compileControllerGlob('app/*/controller/*.php');
	compileControllerGlob('app/*/controller/*/*.php');
	compileControllerGlob('app/*/controller/*/*/*.php');
	compileControllerGlob('app/*/controller/*/*/*/*.php');
	
	compileControllerGlob('app/*/*/controller/*.php');
	compileControllerGlob('app/*/*/controller/*/*.php');
	compileControllerGlob('app/*/*/controller/*/*/*.php');
	compileControllerGlob('app/*/*/controller/*/*/*/*.php');
	compileControllerGlob('themes/*/controller/*.php');
	compileControllerGlob('themes/*/controller/*/*.php');
	compileControllerGlob('themes/*/controller/*/*/*.php');
	compileControllerGlob('themes/*/controller/*/*/*/*.php');
}

function compileControllerGlob($pattern) {
	$files = glob($pattern);
	foreach($files as $file) {
		compileControllerFile($file);
	}
}

function compileControllerFile($file) {
	$content = file_get_contents(BASE_DIR . '/' . $file);
	$compileName = str_replace('/', '_', $file);
	file_put_contents(BASE_DIR . '/compile/controller/' . $compileName, $content);
}
function compileModels() {
	$dir = 'compile/models';
	copyGlob('model/*.php', $dir);
	copyGlob('model/*/*.php', $dir);
	copyGlob('model/*/*/*.php', $dir);
	copyGlob('model/*/*/*/*.php', $dir);
	copyGlob('model/*/*/*/*/*.php', $dir);
	copyGlob('model/*/*/*/*/*/*.php', $dir);
	copyGlob('model/*/*/*/*/*/*/*.php', $dir);
	copyGlob('model/*/*/*/*/*/*/*/*.php', $dir);
}
function compileGlob($pattern) {
	$files = glob($pattern);
	foreach($files as $file) {
		compileXmlFile($file);
	}
}
function readNode($node, &$index = 0) {
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
			$content .= readNode($childNode, $index);
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
function compileXmlFile($file, $regenerate = true) {
	// echo $file . '<br />';
	$fileName = 'compile/pages/' . str_replace('/', '_', $file);
	echo $file . '<br />';
	echo $fileName . '<br />';
	if(!file_exists($fileName) || (filemtime($file) > filemtime($fileName))) {
		
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
			$fileContent = readNode($pageDom->documentElement);
			file_put_contents($fileName, '<'.'?php '. $fileContent);	
		} catch(Exception $ex) {
			echo 'Error at: ' . $file . '<br />' . $ex->getMessage() .'<br />';
		}
		
	}
	//require_once $fileName;
}
function compileXmls() {
	compileGlob('system/*.php');
	
	compileGlob('default/pages/*.php');
	compileGlob('default/pages/*/*.php');
	compileGlob('default/pages/*/*/*.php');
	compileGlob('default/pages/*/*/*/*.php');
	
	compileGlob('app/*/application.php');
	compileGlob('app/*/offapplication.php');
	compileGlob('app/*/pages/*.php');
	compileGlob('app/*/pages/*/*.php');
	compileGlob('app/*/pages/*/*/*.php');
	compileGlob('app/*/pages/*/*/*/*.php');
	
	compileGlob('app/*/*/application.php');
	compileGlob('app/*/*/offapplication.php');
	compileGlob('app/*/*/pages/*.php');
	compileGlob('app/*/*/pages/*/*.php');
	compileGlob('app/*/*/pages/*/*/*.php');
	compileGlob('app/*/*/pages/*/*/*/*.php');
	compileGlob('themes/*/pages/*.php');
	compileGlob('themes/*/pages/*/*.php');
	compileGlob('themes/*/pages/*/*/*.php');
	compileGlob('themes/*/pages/*/*/*/*.php');
}
function compileInclude() {
	$lines = file(BASE_DIR.'/include.php');
	$require_onceLength = strlen('require_once') - 1;
	$content = '';
	foreach($lines as $line) {
		echo substr($line, 0, $require_onceLength);
		if(preg_match('/^require_once/', $line) !== false) {
			preg_match('/\'([^\']+)\'/', $line, $match);
			if(isset($match[1])) {
				$fileContent = file_get_contents(BASE_DIR .'/'. $match[1]);
				$fileContent = trim($fileContent);
				if(substr($fileContent, -2) == '?>') {
					$content .= $fileContent . "\r\n";
				} else {
					$content .=  $fileContent . " ?>\r\n";
				}
			}
		}
	}
	file_put_contents(BASE_DIR . '/compile/include.php', $content);
}

function compileLayouts (){
	require_once __DIR__ .'/Parser.php';
	compileLayoutGlob('default/layouts/*.php');
	compileLayoutGlob('default/layouts/*/*.php');
	compileLayoutGlob('default/layouts/*/*/*.php');
	compileLayoutGlob('default/layouts/*/*/*/*.php');
	compileLayoutGlob('default/layouts/*/*/*/*/*.php');
	compileLayoutGlob('default/layouts/*/*/*/*/*/*.php');
	
	compileLayoutGlob('app/*/layouts/*.php');
	compileLayoutGlob('app/*/layouts/*/*.php');
	compileLayoutGlob('app/*/layouts/*/*/*.php');
	compileLayoutGlob('app/*/layouts/*/*/*/*.php');
	compileLayoutGlob('app/*/layouts/*/*/*/*/*.php');
	compileLayoutGlob('app/*/layouts/*/*/*/*/*/*.php');
	
	compileLayoutGlob('app/*/*/layouts/*.php');
	compileLayoutGlob('app/*/*/layouts/*/*.php');
	compileLayoutGlob('app/*/*/layouts/*/*/*.php');
	compileLayoutGlob('app/*/*/layouts/*/*/*/*.php');
	compileLayoutGlob('app/*/*/layouts/*/*/*/*/*.php');
	compileLayoutGlob('themes/*/layouts/*.php');
	compileLayoutGlob('themes/*/layouts/*/*.php');
	compileLayoutGlob('themes/*/layouts/*/*/*.php');
	compileLayoutGlob('themes/*/layouts/*/*/*/*.php');
	compileLayoutGlob('themes/*/layouts/*/*/*/*/*.php');
	compileLayoutGlob('themes/*/layouts/*/*/*/*/*/*.php');
}

function compileLayoutGlob($pattern) {
	$files = glob($pattern);
	foreach($files as $file) {
		$layout = str_replace('.php', '', $file);
		PzkParser::compileLayout($layout);
	}
}
//@mkdir(BASE_DIR . '/compile');
//@mkdir(BASE_DIR . '/compile/objects');
//@mkdir(BASE_DIR . '/compile/pages');
//@mkdir(BASE_DIR . '/compile/models');