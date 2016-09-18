<?php
class PzkFilterConstant {
	
	public static $areacodeParent = array(
		'index' 		=> 'parent',
		'type' 			=> 'select',
		'label' 		=> 'Lọc theo địa điểm',
		'table' 		=> 'areacode',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
	);
	public static $subjectCategory = array(
		'index' 		=> 'categoryId',
		'type' 			=> 'select',
		'label' 		=> 'Theo danh mục',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
		'condition'		=> 'parent = \'47\''
	);
	public static $newsCategory = array(
		'index' 		=> 'categoryId',
		'type' 			=> 'select',
		'label' 		=> 'Theo danh mục',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
		'condition'		=> 'router like \'%news%\''
	);
	public static $featuredCategory = array(
		'index' 		=> 'categoryId',
		'type' 			=> 'select',
		'label' 		=> 'Theo danh mục',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
		'condition'		=> 'router like \'%featured%\''
	);
	public static $documentCategory = array(
		'index' 		=> 'categoryId',
		'type' 			=> 'select',
		'label' 		=> 'Theo danh mục',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
		'condition'		=> 'router like \'%document%\''
	);
	public static $campaign = array(
		'index' 		=> 'campaignId',
		'type' 			=> 'select',
		'label' 		=> 'Theo chiến dịch',
		'table' 		=> 'campaign',
		'show_value' 	=> 'id',
		'show_name' 	=> 'campaignName',
	);
	
	public static $status = array(
		'index'=>'status',
		'type' => 'status',
		'label' => 'Status'
	);
	
	public static $featuredId = array(
		'index' => 'featuredId',
		'type' => 'select',
		'label' => 'Theo bài viết',
		'table' => 'featured',
		'show_value' => 'id',
		'show_name' => 'title',
	);
	
	public static $newsId = array(
		'index' => 'newsId',
		'type' => 'select',
		'label' => 'Theo bài viết',
		'table' => 'news',
		'show_value' => 'id',
		'show_name' => 'title',
	);
	
	public static function  get($field, $replace) {
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