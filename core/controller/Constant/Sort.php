<?php
class PzkSortConstant {
	public static $id = '{replace}.id';
	public static $idLabel = 'ID';
	
	public static $title = '{replace}.title';
	public static $titleLabel = 'Tiêu đề';
	
	public static $name = '{replace}.name';
	public static $nameLabel = 'Tên';
	
	public static $level = '{replace}.level';
	public static $levelLabel = 'Tên';
	
	public static $categoryId = '{replace}.categoryId';
	public static $categoryIdLabel = 'Danh mục gốc';
	
	public static $ordering = '{replace}.ordering';
	public static $orderingLabel = 'Thứ tự';

	
	public static $created = '{replace}.created';
	public static $createdLabel = 'Ngày tạo';
	
	public static $visited = '{replace}.visited';
	public static $visitedLabel = 'Ngày ghé thăm';
	
	public static $likes = '{replace}.likes';
	public static $likesLabel = 'Lượt thích';
	
	public static function  get($field, $replace) {
		$dom = pzk_parse_selector($field);
		$tagName = $dom['tagName'];
		$result = self::$$tagName;
		foreach ($dom['attrs'] as $attr) {
			$result[$attr['name']] = $attr['value'];
		}
		$result = str_replace('{replace}', $replace, $result);
		return $result;
	}
	
	public static function  gets($fields, $replace) {
		if(is_string($fields))
		$fields = explodetrim(',', $fields);
		$result = array();
		foreach($fields as $field) {
			$fieldLabel = $field. 'Label';
			$result[self::get($field, $replace) . ' asc'] = self::$$fieldLabel . ' tăng';
			$result[self::get($field, $replace) . ' desc'] = self::$$fieldLabel . ' giảm';
		}
		return $result;
	}
}
?>