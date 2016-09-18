<?php
class PzkListConstant {
	
	public static $accountName = array(
		'index' => 'accountName',
		'type' => 'text',
		'label' => 'Tài khoản'
	);
	
	public static $accountType = array(
		'index' => 'accountType',
		'type' => 'text',
		'label' => 'Loại tài khoản'
	);
	
	public static $alias = array(
		'index' 		=> 'alias',
		'type' 			=> 'text',
		'label' 		=> 'Alias',
		'link'			=> '/{data.row[alias]}?id='
	);
	
	public static $appName = array(
		'index' => 'appName',
		'type' => 'text',
		'label' => 'Ứng dụng'
	);
	
	public static $briefText = array(
		'index' 		=> 'brief',
		'type' 			=> 'text',
		'label' 		=> 'Mô tả',
		'isRaw'			=> true
	);
	
	public static $campaignName = array(
		'index' 		=> 'campaignName',
		'type' 			=> 'text',
		'label' 		=> '<br />Chiến dịch'
	);
	
	public static $categoryName = array(
		'index' 		=> 'categoryName',
		'type' 			=> 'text',
		'label' 		=> '<br />Danh mục gốc'
	);
	
	
	public static $classes = array(
		'index' 		=> 'classes',
		'type' 			=> 'text',
		'label' 		=> 'Lớp'
	);
	
	public static $click = array(
		'index' 		=> 'click',
		'type' 			=> 'text',
		'label' 		=> 'Số lượt click'
	);
	
	public static $comments = array(
		'index' 	=> 'comments',
		'type' 		=> 'text',
		'label' 	=> 'Lượt bình luận'
	);
	
	public static $comment = array(
		'index' 		=> 'comment',
		'type' 			=> 'text',
		'label' 		=> 'Bình luận'
	);
	
	public static $contentText = array(
		'index' 		=> 'content',
		'type' 			=> 'text',
		'label' 		=> 'Nội dung',
		'isRaw'			=> true
	);
	
	public static $created = array(
		'index' 	=> 'created',
		'type' 		=> 'datetime',
		'label' 	=> 'Ngày tạo',
		'format'	=> 'H:i d/m'
	);
	
	public static $creatorName = array(
		'index' 	=> 'creatorName',
		'type' 		=> 'text',
		'label' 	=> 'Người tạo'
	);
	
	public static $display = array(
		'index' => 'display',
		'type' => 'status',
		'label' => 'Display',
		'icon' 			=> 'star'
	);
	
	public static $displayText = array(
		'index' 		=> 'display',
		'type' 			=> 'text',
		'label' 		=> 'Hiển thị',
		'maps'	=> array(
			'0'				=> 'Có hiển thị',
			'1'				=> 'Không hiển thị'
		)
	);
	
	public static $endDate = array(
		'index' 		=> 'endDate',
		'type' 			=> 'datetime',
		'label' 		=> 'Ngày kết thúc',
		'format'		=> 'd/m'
	);
	
	public static $extotal = array(
		'index' 		=> 'extotal',
		'type' 			=> 'text',
		'label' 		=> 'Số bài tập'
	);
	public static $featured = array(
		'index' 		=> 'featured',
		'type' 			=> 'status',
		'label' 		=> '<br />Nổi bật'
	);
	public static $file = array(
		'index' 		=> 'file',
		'type' 			=> 'text',
		'label' 		=> 'File'
	);
	public static $global = array(
		'index' 		=> 'global',
		'type' 			=> 'status',
		'label' 		=> 'Toàn cục'
	);
	
	public static $group_question = array(
		'index' 		=> 'group_question',
		'type' 			=> 'text',
		'label' 		=> 'Dạng bài tập'
	);
	
	public static $height = array(
		'index' 		=> 'height',
		'type' 			=> 'text',
		'label' 		=> 'Kích thước cao'
	);
	
	
	public static $img = array(
		'index' 		=> 'img',
		'type' 			=> 'image',
		'label' 		=> '<br />Ảnh thumbnail'
	);
	
	public static $image = array(
		'index' 		=> 'image',
		'type' 			=> 'image',
		'label' 		=> 'Ảnh'
	);
	
	public static $import = array(
		'index' 		=> "id",
		'type' 			=> 'link',
		'label' 		=> 'Nhập dữ liệu',
		'link' 			=> '/admin_category/importQuestions/'
	);

	public static $ip = array(
		'index' 		=> 'ip',
		'type' 			=> 'text',
		'label' 		=> 'Địa chỉ IP'
	);
	
	public static $isSort = array(
		'index' 		=> 'isSort',
		'type' 			=> 'status',
		'label' 		=> 'Sort',
		'icon' 			=> 'star'
	);
	
	public static $isSortText = array(
		'index' 		=> 'isSort',
		'type' 			=> 'text',
		'label' 		=> 'Sort',
		'maps'			=> array(
			'0'				=> 'Đã kích hoạt',
			'1'				=> 'Chưa kích hoạt'
		)
	);
	
	public static $level = array(
		'index' => 'level',
		'type' => 'text',
		'label' => 'Tên quyền'
	);
	
	public static $likes = array(
		'index' 		=> 'likes',
		'type' 			=> 'text',
		'label' 		=> 'Lượt thích'
	);
	
	
	
	public static $meta_description = array(
		'index' 		=> 'meta_description',
		'type' 			=> 'text',
		'label' 		=> 'Meta Description'
	);
	
	public static $meta_keywords = array(
		'index' 		=> 'meta_keywords',
		'type' 			=> 'text',
		'label' 		=> 'Meta Keywords'
	);
	
	public static  $modified = array(
		'index' 		=> 'modified',
		'type' 			=> 'datetime',
		'label' 		=> 'Ngày sửa',
		'format'		=> 'H:i d/m'
	);
	
	public static $modifiedName = array(
		'index' 		=> 'modifiedName',
		'type' 			=> 'text',
		'label' 		=> 'Người sửa'
	);
	
	public static $name = array(
		'index' 		=> 'name',
		'type' 			=> 'text',
		'label' 		=> 'Tên',
		'link'			=> '/admin_{replace}/view/',
		'ctrlLink'		=> '/admin_{replace}/edit/'
	);
	
	public static $nameOfAreacode = array(
		'index' 		=> 'name',
		'type' 			=> 'text',
		'label' 		=> 'Tên địa điểm'
	);
	
	public static $nameOfAreatype = array(
        'index' 		=> 'name',
        'type' 			=> 'parent',
        'label' 		=> 'Loại địa điểm'
    );
	
	public static $nameOfBackup = array(
        'index' => 'name',
        'type' => 'text',
        'label' => 'Backup'
    );
	
	public static $nameOfCate = array(
		'index' 		=> 'name',
		'type' 			=> 'parent',
		'label' 		=> 'Tên',
		'link'			=> '/admin_{replace}/view/',
		'ctrlLink'		=> '/admin_{replace}/edit/'
	);
	
	public static $nameOfCategory = array(
		'index' 		=> 'name',
		'type' 			=> 'text',
		'label' 		=> 'Tên danh mục'
	);
	
	public static $vn_title = array(
		'index' 		=> 'vn_title',
		'type' 			=> 'text',
		'label' 		=> 'Danh mục tiếng Việt'
	);
	
	public static $en_title = array(
		'index' 		=> 'en_title',
		'type' 			=> 'text',
		'label' 		=> 'Danh mục tiếng Anh'
	);
	
	public static $nameOfNews = array(
		'index' 		=> 'name',
		'type' 			=> 'text',
		'label' 		=> 'Tin tức'
	);
	
	public static $nameOfCommon = array(
		'index' 		=> 'name',
		'type' 			=> 'text',
		'label' 		=> 'Tên',
		'link'			=> '/admin_{replace}/view/',
		'ctrlLink'		=> '/admin_{replace}/edit/'
	);
	
	
	
	public static $ordering = array(
		'index' 		=> 'ordering',
		'type' 			=> 'ordering',
		'label' 		=> '<br />Thứ tự'
	);
	
	public static $orderingText = array(
		'index' 		=> 'ordering',
		'type' 			=> 'text',
		'label' 		=> 'Thứ tự'
	);

	public static $position = array(
		'index' 		=> 'position',
		'type' 			=> 'text',
		'label' 		=> 'Vị trí'
	);
	
	public static $published = array(
		'index' 		=> 'published',
		'type' 			=> 'datetime',
		'format' 		=> 'd/m/Y H:i',
		'label' 		=> 'Ngày gửi'
	);
	
	public static $question_type = array(
		'index' 		=> 'question_type',
		'type' 			=> 'text',
		'label' 		=> 'Code'
	);
	
	public static $question_types = array(
		'index' 		=> 'question_types',
		'type' 			=> 'nameid',
		'table' 		=> 'questiontype',
		'showField' 	=> 'name',
		'findField' 	=> 'id',
		'label' 		=> 'Loại câu hỏi'
	);
	
	public static $router = array(
			'index' 	=> 'router',
			'type' 		=> 'text',
			'label' 	=> 'Đường dẫn'
	);
	
	public static $showname = array(
			'index' 		=> 'showname',
			'type' 			=> 'status',
			'label' 		=> 'Hiển thị tiêu đề'
	);
	
	public static $startDate = array(
		'index' 		=> 'startDate',
		'type' 			=> 'datetime',
		'label' 		=> 'Ngày bắt đầu',
		'format'		=> 'd/m'
	);
	
	public static $sharedSoftwares = array(
			'index' 		=> 'sharedSoftwares',
			'type' 			=> 'text',
			'label' 		=> 'Chia sẻ'
	);
	
	public static $software = array(
			'index' 		=> 'software',
			'type' 			=> 'text',
			'label' 		=> 'Phần mềm'
	);
	
	
	public static $status = array(
		'index' 		=> 'status',
		'type' 			=> 'status',
		'label' 		=> '<br />Trạng thái'
	);
	
	public static $statusText = array(
		'index' 		=> 'status',
		'type' 			=> 'text',
		'label' 		=> 'Trạng thái',
		'maps'			=> array(
							'0'	=> 'Đã kích hoạt',
							'1'	=> 'Chưa kích hoạt'
		)
	);
	
	public static $title = array(
		'index' 		=> 'title',
		'type' 			=> 'text',
		'label' 		=> 'Tieu de',
		'link'			=> '/admin_{replace}/view/',
		'ctrlLink'		=> '/admin_{replace}/edit/'
	);
	
	public static $trial = array(
		'index' 		=> 'trial',
		'type' 			=> 'status',
		'label' 		=> 'Dùng thử',
		'link'			=> '/admin_{replace}/view/',
		'ctrlLink'		=> '/admin_{replace}/edit/'
	);
	
	public static $typeOfApp = array(
		'index' 		=> 'type',
		'type' 			=> 'text',
		'label' 		=> 'Loại ứng dụng'
	);
	
	public static $typeOfAreacode = array(
		'index' 		=> 'type',
		'type' 			=> 'text',
		'label' 		=> 'Loại địa điểm'
	);
	
	public static $username = array(
		'index' 		=> 'username',
		'type' 			=> 'text',
		'label' 		=> 'Tên đăng nhập',
		'link'			=> '/admin_{replace}/view/{data.row[userId]}/',
		'ctrlLink'		=> '/admin_{replace}/edit/{data.row[userId]}/'
	);
	
	public static $url = array(
		'index' 		=> 'url',
		'type' 			=> 'text',
		'label' 		=> 'Liên kết đích'
	);
	
	public static $urlOfBackup = array(
        'index' 		=> 'url',
        'type' 			=> 'link',
        'label' 		=> 'Download',
		'link'			=> '/admin_backup/download/'
    );
	
	public static $views = array(
		'index' 		=> 'views',
		'type' 			=> 'text',
		'label' 		=> 'Lượt Xem'
	);
	
	public static $videoUrl = array(
		'index' => 'url',
		'type' => 'video',
		'label' => 'Video'
	);
	
	public static $visited = array(
		'index'	=> 'visited',
		'label'	=> 'Thời gian ghé thăm',
		'type'	=> 'datetime',
		'format'	=> 'd/m/Y H:i:s'
	);
	
	public static $width = array(
		'index' => 'width',
		'type' => 'text',
		'label' => 'Kích thước dài'
	);
	
	public static $groupIndex = 0;
	public static function group($label, $fields, $replace){
		self::$groupIndex++;
			$result  = 
			array(
				'index'			=> 'none' . self::$groupIndex,
				'type'			=> 'group',
				'label'			=> $label,
				'delimiter'		=> '<br />',
				'fields'		=> array(
					
				)
			);
			$fields = explodetrim(',', $fields);
			foreach($fields as $field) {
				if($field)
					$result['fields'][] = self::get($field, $replace);
			}
		return $result;
			
	}
	
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

class PzkGridConstant {
	
	public static $comments = array(
		'index'			=> 'comments',
		'title'			=> 'Bình luận',
		'label'			=> 'Bình luận',
		'table'			=> '{replace}_comment',
		'parentField'	=> '{replace}Id',
		'addLabel'		=> 'Thêm bình luận',
		'quickMode'		=> false,
		'module'		=> '{replace}_comment',
	);
	
	public static $visitors = array(
		'index'			=> 'visitors',
		'title'			=> 'Người ghé thăm',
		'label'			=> 'Người ghé thăm',
		'table'			=> '{replace}_visitor',
		'addLabel'		=> 'Thêm người ghé thăm',
		'quickMode'		=> false,
		'module'		=> 'visitor',
		'parentField'	=> '{replace}Id',
	);
	
	public static $social_schedules = array(
		'index'			=> 'social_schedules',
		'title'			=> 'Lịch đăng facebook',
		'label'			=> 'Lịch đăng facebook',
		'table'			=> 'social_schedule',
		'addLabel'		=> 'Thêm lịch đăng',
		'quickMode'		=> false,
		'module'		=> 'socialschedule',
		'parentField'	=> '{replace}Id',
		'fields' 		=> 'social_schedule.*, {replace}.title as name, social_app.name as appName,
		social_app.type as type, social_account.name as accountName, social_account.type as accountType',
		'filterStatus' 	=> true,
		'orderBy'		=> 'social_schedule.id desc',
		'searchFields' 	=> array('name'),
		'Searchlabels' 	=> 'Tên ứng dụng',
	);
	
	public static function  get($field, $replace, $params = array()) {
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
		foreach($params as $key => $val) {
			$result[$key] = $val;
		}
		return $result;
	}
}
?>