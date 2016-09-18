<?php

function pzk_arr($obj, $field) {
	$rslt = array();
	$arr = get_object_vars($obj);
	foreach($arr as $key => $value) {
		$match = array();
		if (preg_match('/'.$field . '[_-]([\w\d]+)/', $key, $match)){
			$rslt[$match[1]] = $value;
		}
	}
	return $rslt;
}

/**
 * Make a properties string from array or from array to a string of properties
 * @example: a:value_of_a;b:value_of_b;c:value_of_c; will convert to array(a => value_of_a,...)
 * @param {Array or String} $data: data needed for convert
 * @param {Array} $options: instruction for convertion
 */
function pzk_properties($data, $options = array()) {
	$options = array_merge(array(
		'delim' => ';', 
		'assignment' => ':', 
		'mode' => 'str2arr'
		), $options);
		foreach($options as $key => $value) {
			$$key = $value;
		}
		switch($mode) {
			case 'arr2str':
				return '';
				break;
			case 'str2arr':
				$rslt = array();
				$statements = explode($options['delim'], $data);
				foreach($statements as $stm) {
					$stm = trim($stm);
					if ($stm) {
						$pair = explode($options['assignment'], $stm);
						$rslt[trim(@$pair[0])] = trim(@$pair[1]);
					}
				}
				return $rslt;
				break;
		}
		return NULL;
}
?>