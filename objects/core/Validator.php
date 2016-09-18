<?php
class PzkCoreValidator extends PzkObjectLightWeight {
	/**
	 * Check xem chuỗi có trống không
	 * @param string $str
	 * @return boolean
	 */
	public function required($str) {
		return !!trim($str);
	}
	/**
	 * Check xem chuỗi có phải email không
	 * @param string $str
	 * @return boolean
	 */
	public function email($str) {
		if (filter_var($str, FILTER_VALIDATE_EMAIL)) { 
			return true; 
		} else {
			return false;
		}
	}
	/**
	 * Check xme chuỗi có phải url không
	 * @param string $str
	 * @return boolean
	 */
	public function url($str) {
		if (filter_var($str, FILTER_VALIDATE_URL)) { 
			return true; 
		} else {
			return false;
		}
	}
	/**
	 * Check xem chuỗi có phải ngày tháng không
	 * @param string $str
	 * @return boolean
	 */
	public function dateNormal($str) {
		return (strlen($str) == 10) && (strtotime($str) != NULL);
	}
	public function dateISO($str) {
	}
	/**
	 * Check xem chuỗi có phải số không
	 * @param unknown $str
	 * @return boolean
	 */
	public function number($str) {
		if (filter_var($str, FILTER_VALIDATE_FLOAT)) { 
			return true; 
		} else {
			return false;
		}
	}
	/**
	 * Check xem chuỗi có phải số nguyên không
	 * @param string $str
	 * @return boolean
	 */
	public function digits($str) {
		if (filter_var($str, FILTER_VALIDATE_INT)) { 
			return true; 
		} else {
			return false;
		}
	}
	public function creditcard($str) {
	}
	/**
	 * Check xem chuỗi có độ dài tối đa không
	 * @param string $str
	 * @param int $len
	 * @return boolean
	 */
	public function maxlength($str, $len) {
		return strlen($str) <= $len;
	}
	/**
	 * Check xem chuỗi có độ dài tối thiểu không
	 * @param string $str
	 * @param string $len
	 * @return boolean
	 */
	public function minlength($str, $len) {
		return strlen($str) >= $len;
	}
	/**
	 * Check độ dài của chuỗi có nằm trong khoảng (min, max) không
	 * @param string $str
	 * @param int $min
	 * @param int $max
	 * @return boolean
	 */
	public function rangeLength($str, $min, $max) {
		return (strlen($str) >= $min) && (strlen($str) <= $max);
	}
	/**
	 * Check giá trị có nhỏ hơn max không
	 * @param number $str
	 * @param number $max
	 * @return boolean
	 */
	public function max($str, $max) {
		return $str <= $max;
	}
	/**
	 * Check giá trị có nhỏ hơn min không
	 * @param number $str
	 * @param number $min
	 * @return boolean
	 */
	public function min($str, $min) {
		return $str >= $min;
	}
	/**
	 * Check giá trị có nằm trong khoảng (min, max) không
	 * @param number $str
	 * @param number $min
	 * @param number $max
	 * @return boolean
	 */
	public function range($str, $min, $max) {
		return $str >= $min && $str <= $max;
	}
	/**
	 * Check chuỗi có bằng chuỗi cho trước không
	 * @param string $str
	 * @param string $value
	 * @return boolean
	 */
	public function equalTo($str, $value) {
		return $str == $value;
	}
	/**
	 * Validate dữ liệu dựa vào các tùy chọn validate
	 * @param array $data
	 * @param array $options
	 * @return array|boolean
	 */
	public function validate($data, $options) {
		$result = array();
		foreach($options['rules'] as $field => $validators) {
			foreach($validators as $validator => $validatorParams) {
				if(!$this->isValid(isset($data[$field])?$data[$field]: null, $validator, $validatorParams)) {
					$result[$field][$validator] = $options['messages'][$field][$validator];
				}
			}
		}
		if(count($result)) return $result;
		return true;
	}
	/**
	 * Kiểm tra giá trị có phù hợp với mục cần validate không
	 * @param string $value
	 * @param string $validator: required, email, number, digits, min, max, minlength, maxlength,...
	 * @param array $params: các tham số cho các hàm validator
	 */
	public function isValid($value, $validator, $params = NULL) {
		if(is_array($params)) {
			return $this->$validator($value, isset($params[0])?$params[0]: null, isset($params[1])?$params[1]: null, isset($params[2])?$params[2]: null);
		} else {
			return $this->$validator($value, isset($params)?$params: NULL);
		}
	}
	/**
	 * Lưu giá trị cho form nhập
	 * @param mixed $data
	 */
	public function setEditingData($data) {
		pzk_session('editingData', $data);
	}
	/**
	 * Lấy ra giá trị cho form nhập
	 * @return mixed
	 */
	public function getEditingData() {
		$data = pzk_session('editingData');
		pzk_session('editingData', false);
		return $data;
	}
}
/**
 * 
 * @return PzkCoreValidator
 */
function pzk_validator() {
	return pzk_element('validator');
}
/**
 * Validate dữ liệu
 * @param array $data dữ liệu
 * @param array $options dạng jqueryvalidation
 * @return array|boolean
 */
function pzk_validate($data, $options) {
	return pzk_validator()->validate($data, $options);
}