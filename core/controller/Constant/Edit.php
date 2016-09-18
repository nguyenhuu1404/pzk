<?php
define('EDIT_TYPE_DATEPICKER', 			'datepicker');
define('EDIT_TYPE_DATETIMEPICKER', 		'datetimepicker');
define('EDIT_TYPE_FILE_MANAGER', 		'filemanager');
define('EDIT_TYPE_MULTISELECT', 		'multiselect');
define('EDIT_TYPE_MULTISELECTOPTION', 	'multiselectoption');
define('EDIT_TYPE_SELECT', 				'select');
define('EDIT_TYPE_STATUS', 				'status');
define('EDIT_TYPE_TEXT', 				'text');
define('EDIT_TYPE_TEXT_AREA',			'textarea');
define('EDIT_TYPE_TINYMCE', 			'tinymce');
define('EDIT_TYPE_UPLOAD', 				'upload');
define('EDIT_TYPE_UPLOAD_TYPE_IMAGE', 	'image');
define('EDIT_TYPE_UPLOAD_TYPE_VIDEO', 	'video');
define('EDIT_TYPE_UPLOAD_TYPE_AUDIO', 	'audio');

class PzkEditConstant {
	public static $name = array (
		'index' 		=> 'name', 
		'type' 			=> EDIT_TYPE_TEXT, 
		'label' 		=> 'Tên'
	);
	
	public static $nameOfAreatype = array(
        'index' 		=> 'name',
        'type' 			=> 'text',
        'label' 		=> 'Tên loại địa điểm',
    );
	
	public static $nameOfCategory = array (
			'index' 		=> 'name',
			'type' 			=> EDIT_TYPE_TEXT,
			'label' 		=> 'Tên danh mục'
	);
	
	public static $vn_title = array (
			'index' 		=> 'vn_title',
			'type' 			=> EDIT_TYPE_TEXT,
			'label' 		=> 'Tên danh mục tiếng Việt'
	);
	
	public static $en_title = array (
			'index' 		=> 'en_title',
			'type' 			=> EDIT_TYPE_TEXT,
			'label' 		=> 'Tên danh mục tiếng Anh'
	);
	
	public static $title = array(
		'index' 		=> 'title',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Tên tin tức',
	);
	public static $img = array(
		'index' 		=> 'img',
		'type' 			=> EDIT_TYPE_UPLOAD,
		'uploadtype'	=> EDIT_TYPE_UPLOAD_TYPE_IMAGE,
		'label' 		=> 'Ảnh minh họa ',
	);
	public static $image = array(
		'index' 		=> 'image',
		'type' 			=> EDIT_TYPE_FILE_MANAGER,
		'uploadtype'	=> EDIT_TYPE_UPLOAD_TYPE_IMAGE,
		'label' 		=> 'Ảnh',
	);
	public static $file = array(
		'index' 		=> 'file',
		'type' 			=> EDIT_TYPE_FILE_MANAGER,
		'uploadtype'	=> EDIT_TYPE_UPLOAD_TYPE_IMAGE,
		'label' 		=> 'Chọn File',
	);
	public static $brief = array(
		'index' 		=> 'brief',
		'type' 			=> EDIT_TYPE_TEXT_AREA,
		'label' 		=> 'Mô tả'
	);
	public static $content =  array(
		'index' 		=> 'content',
		'type' 			=> EDIT_TYPE_TINYMCE,
		'label' 		=> 'Nội dung'
	);
	public static $alias =  array(
		'index' 		=> 'alias',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Alias'
	);
	public static $ordering = array(
		'index' 		=> 'ordering',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Thứ tự sắp xếp'
	);
	public static $startDate =  array(
		'index' 		=> 'startDate',
		'type' 			=> EDIT_TYPE_DATEPICKER,
		'label' 		=> 'Ngày bắt đầu'
	);
	public static $endDate = array(
		'index' 		=> 'endDate',
		'type' 			=> EDIT_TYPE_DATEPICKER,
		'label' 		=> 'Ngày kết thúc'
	);
	public static $extotal = array (
		'index' 		=> 'extotal',
		'type' 			=> 'text',
		'label' 		=> 'Số lượng bài tập'
	);
	public static $categoryId = array(
		'index' 		=> 'categoryId',
		'type' 			=> EDIT_TYPE_SELECT,
		'label' 		=> 'Danh mục cha',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name'
	);
	public static $categoryIds = array(
		'index' 		=> 'categoryIds',
		'type' 			=> EDIT_TYPE_MULTISELECT,
		'label' 		=> 'Danh mục cha',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name'
	);
	public static $newsCategoryId = array(
		'index' 		=> 'categoryId',
		'type' 			=> EDIT_TYPE_SELECT,
		'label' 		=> 'Danh mục cha',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
		'condition'		=> 'router like \'%news%\''
	);
	public static $questionCategoryId = array(
		'index' 		=> 'categoryId',
		'type' 			=> EDIT_TYPE_SELECT,
		'label' 		=> 'Danh mục cha',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
		'condition'		=> 'router like \'%ngonngu%\''
	);
	public static $level = array(
		'index' 		=> 'level',
		'type' 			=> 'text',
		'label' 		=> 'Nhóm người dùng'
	);
	public static $meta_keywords = array(
		'index' 		=> 'meta_keywords',
		'type' 			=> EDIT_TYPE_TEXT_AREA,
		'label' 		=> 'Từ khóa liên quan'
	);
	public static $meta_description = array(
		'index' 		=> 'meta_description',
		'type' 			=> EDIT_TYPE_TEXT_AREA,
		'label' 		=> 'Từ khóa mô tả'
	);
	
	public static $keywords = array(
			'index' 		=> 'meta_keywords',
			'type' 			=> EDIT_TYPE_TEXT_AREA,
			'label' 		=> 'Từ khóa liên quan'
	);
	public static $description = array(
			'index' 		=> 'meta_description',
			'type' 			=> EDIT_TYPE_TEXT_AREA,
			'label' 		=> 'Từ khóa mô tả'
	);
	public static $campaignId = array(
		'index' 		=> 'campaignId',
		'type' 			=> EDIT_TYPE_SELECT,
		'label' 		=> 'Chiến dịch',
		'table' 		=> 'campaign',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name'
	);
	public static $status = array(
		'index' 		=> 'status',
		'type' 			=> EDIT_TYPE_STATUS,
		'label' 		=> 'Trạng thái'
	);
	public static $published = array(
		'index' 		=> 'published',
		'type' 			=> EDIT_TYPE_DATETIMEPICKER,
		'label' 		=> 'Ngày xuất bản'
	);
	public static $accountId = array(
		'index' 		=> 'accountId',
		'type' 			=> EDIT_TYPE_SELECT,
		'table'			=> 'social_account',
		'show_value'	=> 'id',
		'show_name'		=> 'name',
		'label' 		=> 'Profile'
	);
	public static $router = array (
		'index' 		=> 'router',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Đường dẫn gốc'
	);
	public static $isSort = array (
		'index' 		=> 'isSort',
		'type' 			=> EDIT_TYPE_STATUS,
		'label' 		=> 'Sắp xếp'
	);
	public static $display = array(
		'index' 		=> 'display',
		'type' 			=> EDIT_TYPE_STATUS,
		'label' 		=> 'Display',
	);
	public static $parent = array (
		'index' 		=> 'parent',
		'type' 			=> EDIT_TYPE_SELECT,
		'table' 		=> 'categories',
		'label' 		=> 'Danh mục cha',
		'show_name' 	=> 'name',
		'show_value' 	=> 'id'
	);
	public static $parentOfAreacode = array (
		'index' 		=> 'parent',
		'type' 			=> 'select',
		'table' 		=> 'areacode',
		'label' 		=> 'Địa phận',
		'show_name' 	=> 'name',
		'show_value' 	=> 'id'
	);
	public static $parentOfAreatype = array (
		'index' 		=> 'parent',
		'type' 			=> 'select',
		'table' 		=> 'areatype',
		'label' 		=> 'Loại địa điểm cha',
		'show_name' 	=> 'name',
		'show_value' 	=> 'id'
	);
	public static $parentOfCategory = array(
		'index' 		=> 'parent',
		'type' 			=> 'select',
		'label' 		=> 'Lọc theo danh mục',
		'table' 		=> 'categories',
		'show_value' 	=> 'id',
		'show_name' 	=> 'name',
	);
	public static $question_types = array (
		'index' 		=> 'question_types',
		'type' 			=> EDIT_TYPE_MULTISELECT,
		'table' 		=> 'questiontype',
		'label' 		=> 'Chọn dạng bài tập',
		'show_name' 	=> 'name',
		'show_value' 	=> 'id'
	);
	
	public static $position = array(
		'index' 		=> 'position',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Vị trí'
	);
	
	public static $url = array(
		'index' 		=> 'url',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Liên kết đích'
	);
	
	public static $width = array(
		'index' 		=> 'width',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Kích thước dài'
	);
	public static $height = array(
		'index' 		=> 'height',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Kích thước cao'
	);
	public static $videoUrl = array(
		'index' 		=> 'url',
		'type' 			=> EDIT_TYPE_UPLOAD,
		'uploadtype'	=> EDIT_TYPE_UPLOAD_TYPE_VIDEO,
		'label' 		=> 'Chọn Video',
	);
	
	public static $group_question = array(
		'index' 		=> 'group_question',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Dạng bài tập'
	);
	public static $question_type = array(
		'index' 		=> 'question_type',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Code'
	);

	public static $recommend = array(
		'index' 		=> 'recommend',
		'type' 			=> 'tinymce',
		'label' 		=> 'Nhập đoạn dịch'
	);
	
	public static $request = array(
		'index' 		=> 'request',
		'type' 			=> EDIT_TYPE_TEXT,
		'label' 		=> 'Yêu cầu'
	);
	
	public static $classes = array(
		'index' 		=> 'classes',
		'type' 			=> EDIT_TYPE_MULTISELECTOPTION,
		'label' 		=> 'Chọn lớp',
		'option' 		=> array(
			CLASS3 			=> "Lớp 3",
			CLASS4 			=> "Lớp 4",
			CLASS5 			=> "Lớp 5"
		)
	);
	
	public static $sharedSoftwares = array(
		'index' 		=> 'sharedSoftwares',
		'type' 			=> EDIT_TYPE_MULTISELECTOPTION,
		'label' 		=> 'Chia sẻ',
		'option' 		=> array(
			'1' 			=> "Full Look",
			'2' 			=> "IQ, EQ, CQ",
			'3' 			=> "Luyện viết văn",
			'4' 			=> "Trang chủ",
			'6' 			=> "Olympic",
			'7' 			=> "Thi tài",
			'8' 			=> "Thi tài Next Nobels",
		)
	);
	
	public static $target = array(
		'index' 		=> 'target',
		'type' 			=> 'selectoption',
		'label' 		=> 'Đích',
		'option' 		=> array(
			'_blank' 			=> "Blank",
			'static' 			=> "Cố định"
		)
	);
	
	public static $typeOfDocument = array (
			'index' 		=> 'type',
			'type' 			=> 'selectoption',
			'label'			=> 'Loại tài liệu',
			'option'		=> array(
				'document'		=>	'Tài liệu',
				'vocabulary'	=>	'Từ vựng'
			)
	);
	
	public static $trial = array(
		'index' 		=> 'trial',
		'type' 			=> EDIT_TYPE_STATUS,
		'label' 		=> 'Dùng thử'
	);
	
	public static $typeOfAreacode = array (
		'index' 		=> 'type',
		'type' 			=> 'select',
		'table' 		=> 'areatype',
		'label' 		=> 'Loại địa điểm',
		'show_name' 	=> 'name',
		'show_value' 	=> 'name'
	);
	
	public static $global = array(
		'index' 		=> 'global',
		'type' 			=> EDIT_TYPE_STATUS,
		'label' 		=> 'Toàn cục',
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