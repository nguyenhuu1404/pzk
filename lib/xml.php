<?php
function pzk_xml_2_array($file) {
	$source = file_get_contents($file);
	$dom = new DOMDocument('1.0', 'utf-8');
	$dom->loadXML($source);
	return pzk_node_2_array($dom->documentElement);
}

function pzk_node_2_array($node) {
	$result = array(
		'attrs' => array(),
		'children' => array(),
		'tagName' => $node->nodeName
	);
	foreach($node->attributes as $attr) {
		$result['attrs'][$attr->nodeName] = $attr->nodeValue;
	}
	foreach($node->childNodes as $childNode) {
		if($childNode->nodeType == XML_ELEMENT_NODE)
		{
			$result['children'][] = pzk_node_2_array($childNode);
		} else if ($childNode->nodeType == XML_TEXT_NODE) {
			if (trim($childNode->nodeValue)) {
				$result['children'][] = array('tagName' => 'label', 'attrs' => array('value' => trim($childNode->nodeValue)));
			}
		} else if ($childNode->nodeType == XML_CDATA_SECTION_NODE) {
			if (trim($childNode->nodeValue)) {
				$result['children'][] = array('tagName' => 'label', 'attrs' => array('value' => trim($childNode->nodeValue)));
			}
		}
	}
	return $result;
}