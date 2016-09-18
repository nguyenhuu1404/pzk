<?php
class PzkParentConstant {
	public static $creator = array(
		'index'	=> 'creator',
		'table'	=> 'admin',
		'title'	=> 'Người tạo',
		'label'	=> 'Người tạo',
		'referenceField'	=> 'creatorId',
		'fieldSettings' => array(
			array(
			'index' => 'name',
			'type' => 'text',
			'label' => 'Tên người tạo'
			)
		)
	
	);
	public static $modifier = array(
		'index'	=> 'modifier',
		'table'	=> 'admin',
		'title'	=> 'Người sửa',
		'label'	=> 'Người sửa',
		'referenceField'	=> 'modifiedId',
		'fieldSettings' => array(
			array(
			'index' => 'name',
			'type' => 'text',
			'label' => 'Tên người sửa'
			)
		)
	
	);
	
	public static $category = array(
		'index'	=> 'category',
		'table'	=> 'categories',
		'module'	=> 'category',
		'selectFields'	=> '*',
		'title'	=> 'Danh mục',
		'label'	=> 'Danh mục',
		'referenceField'	=> 'categoryId',
		'fieldSettings' => false
	);
	
	public static $parent = array(
		'index'	=> 'category',
		'table'	=> 'categories',
		'module'	=> 'category',
		'selectFields'	=> '*',
		'title'	=> 'Danh mục',
		'label'	=> 'Danh mục',
		'referenceField'	=> 'parent',
		'fieldSettings' => false
	);
	
	public static function  get($field, $replace, $fieldSettings = false) {
		$dom = pzk_parse_selector($field);
		$tagName = $dom['tagName'];
		$result = self::$$tagName;
		foreach ($dom['attrs'] as $attr) {
			$result[$attr['name']] = $attr['value'];
		}
		foreach($result as $key => $val) {
			if(is_string($val))
				$result[$key] = str_replace('{replace}', $replace, $val);
		}
		if($fieldSettings) {
			$result['fieldSettings'] = $fieldSettings;
		}
		return $result;
	}
	
	public static function  gets($fields, $replace) {
		if(is_string($fields))
		$fields = explodetrim(',', $fields);
		$result = array();
		foreach($fields as $field) {
			$result[] = self::get($field, $replace);
		}
		return $result;
	}
}
?>