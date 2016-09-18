<?php
/**
 * Hàm này Tách và xóa khoảng trắng các kết quả sau khi tách: 
 * @example <code>
 *  	$str = 'first, second, last';<br />
 *  	$pieces = explodetrim(',', $str);<br />
 *  	echo $pieces[0]; // 'first'<br />
 *  	echo $pieces[1]; // 'second'<br />
 *  </code>
 * @param String $delim Chuỗi phân cách để tách chuỗi
 * @param String $str Chuỗi cần phân tách và xóa khoảng trắng<br />
 * Chuỗi này có dạng: 'first, second, last,...'
 * @return Array mảng các chuỗi được tách bởi chuỗi phân cách
 */
function explodetrim($delim, $str) {
	$arr = explode($delim, $str);
	foreach($arr as $i => $e) {
		$arr[$i] = trim($e);
	}
	return $arr;
}

/**
 * Lấy Giá trị nhỏ nhất của một cột trong mảng
 * @param Array $array mảng các dòng
 * @param String $field cột cần lấy min
 * @return mixed kết quả
 */
function min_array($array, $field) {
	$arr = array();
	foreach($array as $row) {
		$arr[] = $row[$field];
	}
	return min($arr);
}

/**
 * Lấy Giá trị lớn nhất của một cột trong mảng
 * @param Array $array mảng các dòng
 * @param String $field cột cần lấy max
 * @return mixed kết quả
 */
function max_array($array, $field) {
	$arr = array();
	foreach($array as $row) {
		$arr[] = $row[$field];
	}
	return max($arr);
}

/**
 * Đếm số lần xuất hiện của một giá trị trong mảng
 * @param Array $arr mảng các giá trị
 * @param mixed $value giá trị trong mảng
 * @return number số lần xuất hiện
 */
function count_array($arr, $value) {
	$total = 0;
	foreach($arr as $v) {
		if($v == $value) {
			$total++;
		}
	}
	return $total;
}
/**
 * Trộn các mảng vào thành một mảng
 * @return array mảng sau khi được trộn
 */
function merge_array() {
	$result = array();
	$arrays = func_get_args();
	foreach($arrays as $array) {
		if(is_array($array)) {
			foreach($array as $key => $value) {
				$result[$key] = $value;
			}
		}
	}
	return $result;
}

/**
 * Phân tích selector thành dạng mảng
 * @param string $selector dữ liệu dạng input[name=abc][type!=text]
 * @return array mảng các dữ liệu đã được phân tích
 */
function pzk_parse_selector($selector) {
	$pattern = '/^([\w\.\d]+)?((\[[^\]]+\])*)?$/';
	$subPattern = '/\[([^=\^\$\*\!\<]+)(=|\^=|\$=|\*=|\!=|\<\>)([^\]]+)\]/';
	if (preg_match($pattern, $selector, $match)) {
		preg_match_all($subPattern, $match[2], $matches);
		$attrs = array();

		$tagName = $match[1];
		if ($tagName) {
			$attrs['tagName'] = $tagName;
		}
		$attrs['attrs'] = array();
		for($i = 0; $i < count($matches[1]); $i++) {
			$attrs['attrs'][] = array('comparator' => $matches[2][$i], 'name' => $matches[1][$i], 'value' => $matches[3][$i]);
		}
			
		return $attrs;
	}
}