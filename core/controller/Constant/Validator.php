<?php
class PzkValidatorConstant {
	public static $name = 'Tên';
	public static $nameOfCategory = 'Tên danh mục';
	public static $level = 'Tên quyền';
	public static $content = 'Nội dung';
	public static $request = 'Yêu cầu';
	public static $question_type = 'Mã dạng câu hỏi';
	public static $required = '{field} không được để trống';
	public static $minlength = '{field} phải dài {value} ký tự trở lên';
	public static $maxlength = '{field} chỉ dài tối đa {value} ký tự';
	public static function gets($rules) {
		$messages = array();
		foreach($rules as $field => $validators) {
			$validatorMessages = array();
			foreach($validators as $type => $value) {
				$message = str_replace('{field}', self::$$field, self::$$type);
				$message = str_replace('{value}', $value, $message);
				$validatorMessages[$type] = $message;
			}
			$messages[$field] = $validatorMessages;
		}
		return array(
			'rules'		=> $rules,
			'messages'	=> $messages
		);
	}
}

class PzkTableConstant {
	public static function getFields($fieldSettings) {
		$arr = array();
		foreach($fieldSettings as $fieldSetting) {
			if(is_string($fieldSetting)) {
				if(strpos($fieldSetting, ':') === false) {
					$arr[$fieldSetting] = pzk_request($fieldSetting);
				} else {
					$parts = explode('::', $fieldSetting);
					$field = $parts[0];
					$settings = $parts[1];
					$dom = pzk_parse_selector($settings);
					$options = array();
					$func = $dom['tagName'];
					foreach ($dom['attrs'] as $attr) {
						$options[$attr['name']] = $attr['value'];
					}
					$arr[$field]	= self::$func($field, $options);
				}
			}
		}
		return $arr;
	}
	
	public static function get_date($field, $options) {
		return date($options['format']);
	}
	
	public static function get_md5($field, $options) {
		return md5(pzk_request($field));
	}
	
	public static $userFields = array(
		'username', 
		'password::get_md5', 
		'registered::get_date[format=Y-m-d H:i:s]',
		'email',
		'phone',
		'school'
	);
	
	public static function get($table) {
		$tableFields = $table.'Fields';
		return self::getFields(self::$$tableFields);
	}
}
?>