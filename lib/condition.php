<?php
/**
 * Lấy kết quả đầu tiên có giá trị khác trống
 *
 * @return mixed Một tham số có giá trị
 */
function pzk_or() {
	foreach(func_get_args() as $var) {
		if (!!$var) return $var;
	}
}

/**
 * Lấy kết quả cuối cùng nếu các kết quả khác trống
 *
 * @return mixed Kết quả cuối cùng
 */
function pzk_and() {
	$rslt = false;
	foreach(func_get_args() as $var) {
		$rslt = $var;
		if (!$var) return FALSE;
	}
	return $rslt;
}
