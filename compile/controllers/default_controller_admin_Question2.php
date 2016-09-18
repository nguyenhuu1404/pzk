<?php
class PzkDefaultAdminQuestion2Controller extends PzkGridAdminController {
	public $title 		=	'Quản lí câu hỏi';
	public $table 		= 	"questions";
	public $module 		= 	"question2";
	public $logable 	= 	true;
	public $logFields 	= 	'id, name,  request, global, sharedSoftwares, teacherIds, level, classes, categoryIds, trial, questionType, testId, software, check, status, audio, explaination';
	public function getLinks() {
		$currentCategories = ',47,';
		$currentCategoryId = $this->getFilterSession()->getCategoryIds();
		if($currentCategoryId) {
			$currentCategory = _db()->getTableEntity('categories')->load($currentCategoryId);
			if($currentCategory->getId()) {
				$currentCategories = $currentCategory->getParents();
			}
		}
		return array(
			array(
				'name'	=> 	'<span class="glyphicon glyphicon-plus-sign"></span> Thêm Nhanh',
				'href'	=> 	'/admin_question2/add?status=1&hidden_ordering=1&hidden_global=1&hidden_teacherIds=1&hidden_sharedSoftwares=1&hidden_status=1&hidden_request=1&hidden_level=1&level=1&hidden_classes=1&classes=,5,&hidden_trial=1&hidden_questionType=1&questionType=1&hidden_audio=1&hidden_testId=1'
			),
			array(
				'name'	=> 	'<span class="glyphicon glyphicon-plus-sign"></span> Thêm Nhanh theo thư mục',
				'href'	=> 	'/admin_question2/add?status=1&hidden_ordering=1&hidden_global=1&hidden_teacherIds=1&hidden_sharedSoftwares=1&hidden_status=1&hidden_request=1&hidden_level=1&level=1&hidden_classes=1&classes=,5,&hidden_trial=1&hidden_questionType=1&questionType=1&hidden_audio=1&hidden_testId=1&hidden_categoryIds=1&categoryIds=' . $currentCategories
			)
		);
	}
	public $childTables = array(
		array(
			'table'				=>	'answers_question_tn', 
			'referenceField' 	=>	'question_id'
		)
	);
	
	public $listFieldSettings = array(
		array(
			'index' 	=> 'translated',
			'type' 		=> 'text',
			'label' 	=> 'Đã dịch',
			'icon'		=> 'ok',
			'maps'		=> array(
				0		=> 'chưa dịch',
				1		=> 'đã dịch'
			),
			'filter'		=> array(
				'index'		=>	'translated',
				'type' 		=> 	'status',
				'label' 	=> 	'Đã dịch'
			),
		),
		array(
			'index' 	=> 'hasImage',
			'type' 		=> 'text',
			'label' 	=> 'Hình ảnh',
			'icon'		=> 'ok',
			'maps'		=> array(
				0		=> 'Không',
				1		=> 'Có'
			),
			'filter'		=> array(
				'index'		=>	'hasImage',
				'type' 		=> 	'status',
				'label' 	=> 	'Hình ảnh'
			),
		),
		array(
			'index'		=> 'groupOfInfor',
			'type'		=> 'group',
			'label'		=> 'Câu hỏi',
			'delimiter'	=> '<hr />',
			'fields'	=> array(
				array(
					'index' 	=> 'name',
					'type' 		=> 'text',
					'label' 	=> 'Câu hỏi',
					'link'		=> '/admin_question2/detail/'
				),	
				array(
					'index' 	=> 'name_vn',
					'type' 		=> 'text',
					'label' 	=> 'Dịch câu hỏi',
				),	
				array(
					'index' 	=> 'answerTranslation',
					'type' 		=> 'text',
					'label' 	=> 'Dịch câu trả lời'
				),
				array(
					'index' 	=> 'explaination',
					'type' 		=> 'text',
					'label' 	=> 'Lý giải'
				),
			)
		),
		
		array(
			'index' 	=> 'questionDetail',
			'type' 		=> 'link',
			'target'	=> 'dialog',
			'label' 	=> 'Chi tiết',
			'link'		=> '/admin_question2/detailFull/{data.getItemId()}'
		),
		array(
			'label' 	=> "Đề thi",
			'index' 	=> "testId",
			'type' 		=> "nameid",
			'table' 	=> 'tests',
			'findField' => 'id',
			'showField' => 'name',
		),
		array(
			'index' 	=> 'categoryIds',
			'type' 		=> 'nameid',
			'table' 	=> 'categories',
			'findField' => 'id',
			'showField' => 'name',
			'label' 	=> 'Dạng bài tập',
			
		),
		array(
			'index' 	=> 'creatorId',
			'type' 		=> 'nameid',
			'table' 	=> 'admin',
			'findField' => 'id',
			'showField' => 'name',
			'label' 	=> 'người tạo',
			'filter'	=> array(
				'index' 		=> 'creatorId',
				'type' 			=> 'select',
				'label' 		=> 'Người tạo',
				'table' 		=> 'admin',
				'show_value' 	=> 'id',
				'show_name' 	=> 'name'
			)
		),
		array(
			'label' 	=> "Người chấm",
			'index' 	=> "teacherIds",
			'type' 		=> "nameid",
			'table' 	=> 'admin',
			'findField' => 'id',
			'showField' => 'name',
		),
		array(
			'index' 	=> 'created',
			'type' 		=> 'datetime',
			'label' 	=> 'Ngày tạo'
		),
		array(
			'index' 	=> 'classes',
			'type' 		=> 'ordering',
			'label' 	=> 'Lớp',
			'filter'	=> 	array(
				'index' 		=> 'classes',
				'type' 			=> 'selectoption',
				'label' 		=> 'Chọn lớp',
				'option' 		=> array(
					CLASS3 			=> "Lớp 3",
					CLASS4 			=> "Lớp 4",
					CLASS5 			=> "Lớp 5"
				),
				'like' 			=> true
			),
		),
		array(
			'index' 	=> 'ordering',
			'type' 		=> 'ordering',
			'label' 	=> 'Thứ tự'
		),
		array(
			'index' 	=> 'level',
			'type' 		=> 'ordering',
			'label' 	=> 'Độ khó'
		),
		 array(
			'index' 	=> 'global',
			'type' 		=> 'status',
			'label' 	=> 'Global',
			'icon'		=> 'record',
			'filter'	=> array(
				'index'		=>	'global',
				'type' 		=> 	'status',
				'label' 	=> 	'Global'
			),
		),
		 array(
			'index' 	=> 'trial',
			'type' 		=> 'status',
			'label' 	=> 'Dùng thử',
			'icon'		=> 'record',
			'filter'	=> array(
				'index'		=>	'trial',
				'type' 		=> 	'status',
				'label' 	=> 	'Dùng thử'
			),
		),
		 array(
			'index' 	=> 'status',
			'type' 		=> 'status',
			'label' 	=> 'Trạng thái',
			'filter'	=> array(
				'index'		=>	'status',
				'type' 		=> 	'status',
				'label' 	=> 	'Trạng thái'
			)
		),
		array(
			'index' 	=> 'lock',
			'type' 		=> 'status',
			'label' 	=> 'Khóa',
			'icon'		=> 'record',
			'filter'	=> array(
				'index'		=>	'lock',
				'type' 		=> 	'status',
				'label' 	=> 	'Khóa'
			)
		),
		 array(
			'index' 	=> 'check',
			'type' 		=> 'status',
			'label' 	=> 'Đã kiểm tra',
			'icon'		=> 'ok',
			'filter'		=> array(
				'index'		=>'check',
				'type' 		=> 'status',
				'label' 	=> 'Đã kiểm tra'
			),
		),
		array(
			'index' 	=> 'deleted',
			'type' 		=> 'status',
			'label' 	=> 'Đã xóa',
			'icon'		=> 'trash',
			'filter'	=> array(
				'index'		=>	'deleted',
				'type' 		=> 	'status',
				'label' 	=> 	'Đã xóa'
			)
		),
			
	);
	//search fields co type la text
    public $searchFields = array('name', 'id');
    public $searchlabels = 'Tên';
	
	 //filter cho cac truong co type la select
    public $filterFields = array(
		array(
            'index' 		=> 'questionType',
            'type' 			=> 'selectoption',
            'label' 		=> 'Dạng bài',
            'option' 		=> array(
				QUESTION_TYPE_CHOICE 	=> "Trắc nghiệm",
                QUESTION_TYPE_FILL 		=> "Điền đáp án",
                QUESTION_TYPE_FILL_JOIN => "Tự luận điền từ",
				QUESTION_TYPE_TULUAN 	=> "Tự luận"
			)
        ),
        
		array(
			'index' 		=> 'testId',
			'type' 			=> 'select',
			'label' 		=> 'Đề thi',
			'table' 		=> 'tests',
			'show_value' 	=> 'id',
			'show_name' 	=> 'name',
			'like' 			=> true
		),
		
		array(
			'index' 		=> 'categoryIds',
			'type' 			=> 'select',
			'label' 		=> 'Dạng bài tập',
			'table' 		=> 'categories',
			'show_value' 	=> 'id',
			'show_name' 	=> 'name',
			'like' 			=> true,
			'condition'		=> 'router like \'%ngonngu%\' or router like \'%test%\''
		)

    );
	/*
	public $quickFilterFields = array(
		array(
            'index' 		=> 'categoryIds',
            'type' 			=> 'select',
            'label' 		=> 'Dạng bài tập',
            'table' 		=> 'categories',
            'show_value' 	=> 'id',
            'show_name' 	=> 'name',
			'like' 			=> true,
			'condition'		=> 'router like \'%ngonngu%\' or router like \'%test%\''
        ),
		array(
            'index' 		=> 'classes',
            'type' 			=> 'selectoption',
            'label' 		=> 'Chọn lớp',
            'option' 		=> array(
				CLASS3 			=> "Lớp 3",
                CLASS4 			=> "Lớp 4",
                CLASS5 			=> "Lớp 5"
			),
			'like' 			=> true
        ),
		array(
            'index' 		=> 'status',
            'type' 			=> 'selectoption',
            'label' 		=> 'Trạng thái',
            'option' 		=> array(
				QUESTION_ENABLE 	=> "Enabled",
                QUESTION_DISABLE 	=> "Disabled"
			)
        ),
		array(
            'index' 		=> 'check',
            'type' 			=> 'selectoption',
            'label' 		=> 'Kiểm tra',
            'option' 		=> array(
				QUESTION_ENABLE 	=> "Checked",
                QUESTION_DISABLE 	=> "Non-Checked"
			)
        )
	);
	*/
	
	//sort by
    public $sortFields = array(
        'id asc' => 'ID tăng',
        'id desc' => 'ID giảm',
		'ordering asc' => 'Thứ tự tăng',
		'ordering desc' => 'Thứ tự giảm',
		'name asc, id desc' => 'Tên tăng, mã giảm',
		'name desc, id asc' => 'Tên tăng, mã tăng',
		'name desc, categoryIds asc' => 'Tên tăng, danh mục tăng',
		'name desc, categoryIds desc' => 'Tên tăng, danh mục giảm',
		'name desc, testId asc' => 'Tên tăng, đề tăng',
		'name desc, testId desc' => 'Tên tăng, danh mục giảm',
    );
	//update data on curent table
	public $updateMenu = true;
    public $updateData = array(
        
		array(
            'index' 		=> 	'lock',
            'type' 			=> 	'status',
            'label' 		=> 	'Cập nhật khóa',
			'selectLabel' 	=>	'Chế độ',
            'nameField'		=>	"Khóa",
        ),
		array(
            'index' => 'categoryIds',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật danh mục',
            'selectLabel' =>'Chọn danh mục',
            'nameField'=>"Danh mục",
            'table' => 'categories',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition'		=> 'router like \'%ngonngu%\' or router like \'%test%\''
        ),
        array(
            'index' => 'testId',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật đề luyện tập lớp 3',
            'selectLabel' =>'Chọn đề',
            'nameField'=>"Đề thi",
            'table' => 'tests',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition' => "(`tests`.`practice` = 1) and (`tests`.`classes` like '%,3,%')"
        ),
		 array(
            'index' => 'testId',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật đề luyện tập lớp 4',
            'selectLabel' =>'Chọn đề',
            'nameField'=>"Đề thi",
            'table' => 'tests',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition' => "(`tests`.`practice` = 1) and (`tests`.`classes` like '%,4,%')"
        ),
		 array(
            'index' => 'testId',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật đề luyện tập lớp 5',
            'selectLabel' =>'Chọn đề',
            'nameField'=>"Đề thi",
            'table' => 'tests',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition' => "(`tests`.`practice` = 1) and (`tests`.`classes` like '%,5,%')"
        ),
		 array(
            'index' => 'testId',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật đề thi lớp 3',
            'selectLabel' =>'Chọn đề',
            'nameField'=>"Đề thi",
            'table' => 'tests',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition' => "(`tests`.`practice` = 0) and (`tests`.`classes` like '%,3,%')"
        ),
		 array(
            'index' => 'testId',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật đề thi lớp 4',
            'selectLabel' =>'Chọn đề',
            'nameField'=>"Đề thi",
            'table' => 'tests',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition' => "(`tests`.`practice` = 0) and (`tests`.`classes` like '%,4,%')"
        ),
		 array(
            'index' => 'testId',
            'type' => 'mutiSelect',
            'label' => 'Cập nhật đề thi lớp 5',
            'selectLabel' =>'Chọn đề',
            'nameField'=>"Đề thi",
            'table' => 'tests',
            'show_value' => 'id',
            'show_name' => 'name',
			'condition' => "(`tests`.`practice` = 0) and (`tests`.`classes` like '%,5,%')"
        )
    );
	// add question
	public $addLabel = "Thêm câu hỏi";
	public $addFields = 'name,  request, global, sharedSoftwares, teacherIds, level, classes, categoryIds, trial, questionType, testId, software, check, status, audio, explaination';
	public $addFieldSettings = array(
		array(
			'index' => 'name',
			'type' => 'tinymce',
			'label' => "Câu hỏi"
		),
		array(
			'index' => 'request',
			'type' => 'tinymce',
			'label' => 'Yêu cầu'
		),
		array(
			'index' => 'level',
			'type' => 'selectoption',
			'option' => array(
				EASY => "Dễ",
                NORMAL => "Bình thường",
                HARD => "Khó",
                VERYHARD => "Rất khó",
                SUPERHARD => "Nâng cao"
			),
			'label' => 'Độ khó',
			'mdsize'	=> 3
		),
		array(
			'index' => 'classes',
			'type' => 'multiselectoption',
			'option' => array(
				CLASS3 => "Lớp 3",
                CLASS4 => "Lớp 4",
                CLASS5 => "Lớp 5",
			),
			'label' => 'Chọn lớp',
			'mdsize'	=> 3
		),
		 array(
			'index' => 'teacherIds',
			'type' => "multiselect",
			'label' => "Chọn người chấm",
			'table' => "admin",
			'show_value' => "id",
			'show_name' => 'name',
			'condition' => "usertype_id = 5"
		),
		 array(
            'index' => 'global',
            'type' => 'status',
            'label' => 'Global',
			'mdsize'	=> 3
        ),
		 array(
            'index' => 'trial',
            'type' => 'status',
            'label' => 'Dùng thử',
			'mdsize'	=> 3
        ),
		array(
			'index' => 'questionType',
			'type' => 'selectoption',
			'option' => array(
				QUESTION_TYPE_CHOICE => "Trắc nghiệm",
                QUESTION_TYPE_FILL => "Điền đáp án",
                QUESTION_TYPE_FILL_JOIN => "Tự luận điền từ",
				QUESTION_TYPE_TULUAN => "Dạng tự luận"
			),
			'label' => 'Câu hỏi dạng',
			'mdsize'	=> 3
		),
		array(
			'index' => 'categoryIds',
			'type' => "multiselect",
			'label' => "Chọn danh mục",
			'table' => "categories",
			'show_value' => "id",
			'show_name' => 'name',
			'condition'		=> 'router like \'%ngonngu%\' or router like \'%test%\'',
			'mdsize'	=> 12
		),
		array(
			'index' => 'testId',
			'type' => "multiselect",
			'label' => "Chọn đề thi",
			'table' => "tests",
			'show_value' => "id",
			'show_name' => 'name',
			'mdsize'	=> 6
		),
		array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái',
			'mdsize'	=> 3
        ),
		array(
            'index' => 'audio',
            'type' 			=> 'filemanager',
			'upload_type'	=> 'audio',
            'label' 		=> 'Bản đọc',
			'mdsize'	=> 3
        ),
		array(
			'index' => 'sharedSoftwares',
			'type' => 'multiselectoption',
			'option' => array(
				1 => "Full Look",
                2 => "IQ, EQ, CQ",
                3 => "Luyện viết văn",
				4 => "Trang chủ",
				6 => "Olympic",
				7 => "Thi tài",
				8 => "Thi tài Next Nobels"
			),
			'label' => 'Chia sẻ'
		)
	);
	
	//edit question
	public $editLabel = "Sửa câu hỏi";
	public $editFields = 'name, teacherIds, global, sharedSoftwares, request, level, classes, categoryIds, trial, questionType, testId, software, check, status, audio, name_vn, answerTranslation, explaination';
	public $editFieldSettings = array(
		array(
			'index' => 'name',
			'type' => 'tinymce',
			'label' => "Câu hỏi"
		),
		array(
			'index' => 'name_vn',
			'type' => 'tinymce',
			'label' => "Câu hỏi (Dịch)"
		),
		array(
			'index' => 'explaination',
			'type' => 'tinymce',
			'label' => "Lý giải"
		),
		array(
			'index' => 'answerTranslation',
			'type' => 'tinymce',
			'label' => "Câu trả lời (Dịch)"
		),
		array(
			'index' => 'request',
			'type' => 'tinymce',
			'label' => 'Yêu cầu'
		),
		array(
			'index' => 'level',
			'type' => 'selectoption',
			'option' => array(
				EASY => "Dễ",
                NORMAL => "Bình thường",
                HARD => "Khó",
                VERYHARD => "Rất khó",
                SUPERHARD => "Nâng cao"
			),
			'label' => 'Độ khó'
		),
		array(
			'index' => 'classes',
			'type' => 'multiselectoption',
			'option' => array(
				CLASS3 => "Lớp 3",
                CLASS4 => "Lớp 4",
                CLASS5 => "Lớp 5",
			),
			'label' => 'Chọn lớp'
		),
		 array(
			'index' => 'teacherIds',
			'type' => "multiselect",
			'label' => "Chọn người chấm",
			'table' => "admin",
			'show_value' => "id",
			'show_name' => 'name',
			'condition' => "usertype_id = 5",
		),
		array(
            'index' => 'global',
            'type' => 'status',
            'label' => 'Global',
            'options' => array(
                '0' => 'Không hoạt động',
                '1' => 'Hoạt động'
            ),
            'actions' => array(
                '0' => 'mở',
                '1' => 'dừng'
            )
        ),
		 array(
            'index' => 'trial',
            'type' => 'status',
            'label' => 'Dùng thử',
            'options' => array(
                '0' => 'Không hoạt động',
                '1' => 'Hoạt động'
            ),
            'actions' => array(
                '0' => 'mở',
                '1' => 'dừng'
            )
        ),
		array(
			'index' => 'questionType',
			'type' => 'selectoption',
			'option' => array(
				QUESTION_TYPE_CHOICE => "Trắc nghiệm",
                QUESTION_TYPE_FILL => "Điền đáp án",
                QUESTION_TYPE_FILL_JOIN => "Tự luận điền từ",
				QUESTION_TYPE_TULUAN => "Dạng tự luận",
			),
			'label' => 'Câu hỏi dạng'
		),
		array(
			'index' => 'categoryIds',
			'type' => "multiselect",
			'label' => "Chọn danh mục",
			'table' => "categories",
			'show_value' => "id",
			'show_name' => 'name',
			'condition'		=> 'router like \'%ngonngu%\' or router like \'%test%\''
		),
		array(
			'index' => 'testId',
			'type' => "multiselect",
			'label' => "Chọn đề thi",
			'table' => "tests",
			'show_value' => "id",
			'show_name' => 'name'
		),
		 array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái',
        ),
		array(
            'index' => 'audio',
            'type' 			=> 'filemanager',
			'upload_type'	=> 'audio',
            'label' 		=> 'Bản đọc'
        ),
		array(
			'index' => 'sharedSoftwares',
			'type' => 'multiselectoption',
			'option' => array(
				1 => "Full Look",
                2 => "IQ, EQ, CQ",
                3 => "Luyện viết văn",
				4 => "Trang chủ",
				6 => "Olympic",
				7 => "Thi tài",
				8 => "Thi tài Next Nobels"
			),
			'label' => 'Chia sẻ'
		)
	);		
    public function add($row) {
        $row['creatorId'] = pzk_session('adminId');
        $row['created'] = date(DATEFORMAT,$_SERVER['REQUEST_TIME']);
        if(isset($row['testId']) && is_array($row['testId'])) {
            $testId = $row['testId'];
            foreach($testId as $item) {
                $quantityTest = _db()->useCB()->select('quantity')->from('tests')->where(array('id', $item))->result_one();
                $quantityQuestion = _db()->useCB()->select('id')->from('questions')->where(array('testId', $item))->result();
                if(count($quantityQuestion) > $quantityTest['quantity']) {
                    pzk_notifier()->addMessage('<div class="color_delete">Đề của bạn đã vượt quá số câu quy định!</div>');
                    $this->redirect('index');
                }
            }
        }

        $entity = _db()->getEntity('table')->setTable($this->table);
        $entity->setData($row);
        $entity->save();
        if($this->logable) {
            $logEntity = _db()->getTableEntity('admin_log');
            $logFields = explodetrim(',', $this->logFields);
            $brief = pzk_session()->getAdminUser() . ' Thêm mới bản ghi: ' . $this->getModule();
            foreach ($logFields as $field) {
                $brief .= '[' . $field . ': ' . @$row[$field] . ']';
            }
            $logEntity->setUserId(pzk_session()->getAdminId());
            $logEntity->setCreated(date('Y-m-d H:i:s'));
            $logEntity->setActionType('add');
            $logEntity->setAdmin_controller('admin_'.$this->getModule());
            $logEntity->setBrief($brief);
            $logEntity->save();
        }

    }

    public function edit($row) {
        $row['modifiedId'] = pzk_session('adminId');
        $row['modified'] = date(DATEFORMAT,$_SERVER['REQUEST_TIME']);
        if(isset($row['testId']) && is_array($row['testId'])) {
            $testId = $row['testId'];
            foreach($testId as $item) {
                $quantityTest = _db()->useCB()->select('quantity')->from('tests')->where(array('id', $item))->result_one();
                $quantityQuestion = _db()->useCB()->select('id')->from('questions')->where(array('testId', $item))->result();
                if(count($quantityQuestion) > $quantityTest['quantity']) {
                    pzk_notifier()->addMessage('Đề của bạn đã vượt quá số câu quy định!', 'warning');
                    $this->redirect('index');
                }
            }
        }

        $entity = _db()->getEntity('table')->setTable($this->table);
        $entity->load(pzk_request('id'));
		$entity->update($row);
        $entity->save();
		if($entity->save() == false) {
			$this->setMessageRedirectIndex('Phải mở khóa thì mới cập nhật được', 'warning');
		}else{
			if($this->logable) {
				$logEntity = _db()->getTableEntity('admin_log');
				$logFields = explodetrim(',', $this->logFields);
				$brief = pzk_session()->getAdminUser() . ' Sửa bản ghi: ' . $this->getModule();
				foreach ($logFields as $field) {
					$brief .= '[' . $field . ': ' . $entity->get($field) . ']';
				}
				$brief .= ' thành ';
				foreach ($logFields as $field) {
					$brief .= '[' . $field . ': ' . @$row[$field] . ']';
				}
				$logEntity->setUserId(pzk_session()->getAdminId());
				$logEntity->setCreated(date('Y-m-d H:i:s'));
				$logEntity->setActionType('edit');
				$logEntity->setAdmin_controller('admin_'.$this->getModule());
				$logEntity->setBrief($brief);
				$logEntity->save();
			}	
		}
    }
	
	public function setMessageRedirectIndex($message, $type) {
		pzk_notifier()->addMessage($message, $type);
        $this->redirect('index');
	}
	function delAction($id){
	
		$question_id = pzk_request()->getSegment(3);
		
		if(pzk_session()->getAdminLevel() === 'Administrator'){
			
			$entity = _db()->getEntity('table')->setTable($this->table);
			$entity->load($question_id);
			$entity->delete();
			if($entity->delete() == false) {
				$this->setMessageRedirectIndex('Phải mở khóa mới xóa được!', 'warning');
			}else {
				if($this->childTables) {
					foreach($this->childTables as $val) {
						_db()->useCB()->delete()->from($val['table'])
						->where(array($val['referenceField'], $question_id))->result();
					}
				}
				$this->setMessageRedirectIndex('Xóa thành công!', 'suscess');
			}
			
		}else{
			$entity = _db()->getEntity('table')->setTable($this->table);
			$entity->load($question_id);
			$entity->delete();
			if($entity->delete() == false) {
				$this->setMessageRedirectIndex('Phải mở khóa mới xóa được!', 'warning');
			}else {
				_db()->useCB()->update($this->table)->set(array('deleted'=>DELETED))
				->where(array('id', $question_id))->result();
			}
			$this->setMessageRedirectIndex('Xóa thành công!', 'suscess');
		}
	}
	
	function detailAction($id) {
		
		$question_id	=	pzk_request()->getSegment(3);
		
		$item	=	pzk_model('AdminQuestion');
		
		$type	=	$item->get_questionType_of_question($question_id);
		
		if($type == QUESTION_TYPE_CHOICE){
		
	        $module = $this->parse('admin/'.pzk_or($this->customModule, $this->module).'/question_answers_tn/answers');
	        $module->setItemId(pzk_request()->getSegment(3));
	        $this->initPage() ->append($module);
	
	        $question	= pzk_element('question_answers');
	
	        $question_answers = pzk_model('AdminQuestion');
	
	        $itemAnswers = $question_answers->get_question_answers_test($question_id);
	
	        $question->setItemAnswers($itemAnswers);
	
	        $this->display();
		}elseif($type == QUESTION_TYPE_FILL || $type == QUESTION_TYPE_FILL_JOIN){
			
			$module = $this->parse('admin/'.pzk_or($this->customModule, $this->module).'/question_answers_tn/answersFill');
			$module->setItemId(pzk_request()->getSegment(3));
			$this->initPage() ->append($module);
				
			$question	= pzk_element('question_answersFill');
				
			$question_answers = pzk_model('AdminQuestion');
				
			$itemAnswers = $question_answers->get_question_answersFill($question_id);
				
			$question->setItemAnswers($itemAnswers);
			
			$this->display();
			
		} elseif($type == QUESTION_TYPE_TULUAN) {
			$module = $this->parse('admin/'.pzk_or($this->customModule, $this->module).'/question_answers_tl/answersTuluan');
			$module->setItemId(pzk_request()->getSegment(3));
			$this->initPage() ->append($module);
			$this->display();
		}
	}
	
	function edit_tnPostAction() {
		
		$row = $this->getEditData();
		
		if(isset($row['content']) && isset($row['status']) && !empty($row['content']) && isset($row['id'])){
			
			if(is_array($row['content'])){
				
				$question_answers	=	pzk_model('AdminQuestion');
				
				$question_answers->del_question_answers($row['id'], 'answers_question_tn');
				
				$status = $row['status'];
				
				$data_answers = array();
				
				foreach( $row['content'] as $key => $content ){
					
					$content = trim($content);
					
					if($key == $status){
						$value = 1;
						$content_full	=	trim($row['content_full']);
						$recommend		= 	trim($row['recommend']);
					}else{
						$value = 0;
						$content_full	=	NULL;
						$recommend		= 	NULL;
					}
					$data_answers[$key] = array(
						'question_id'	=> $row['id'],
						'content'		=> $content,
						'status'		=> $value,
						'content_full'	=> $content_full,
						'recommend'		=> $recommend,
						'content_vn'	=> @$row['content_vn'][$key]
					);
					
					$result	=	$question_answers->question_answers_add($data_answers[$key]);
				}
				if($result !=false){
					
					pzk_notifier()->addMessage('Cập nhật thành công');
					$this->redirect('detail/' . pzk_request('id'));
				}else{
					
					pzk_notifier()->addMessage('<div class="color_delete">Cập nhật không thành công !</div>');
					$this->redirect('detail/' . pzk_request('id'));
				}
			}
		}
	}
	
	function edit_tlPostAction() {
		$question_id = pzk_request('id');
		$row = $this->getEditData();
		$answers = $row['answers'];
		_db()->update('questions')
			->set(array('teacher_answers' => json_encode($answers)))
			->whereId($question_id)->result();
		$this->redirect('detail/' . $question_id);
	}
	
	public function detailFullAction($id) {
		$question_id	=	pzk_request()->getSegment(3);
		
		$item = _db()->selectAll()->fromQuestions()->whereId($question_id)->result_one();
		
		$question_answers = pzk_model('AdminQuestion');

		$itemAnswers = $question_answers->get_question_answers_test($question_id);

		
		$answerIndexes = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
		echo '<div><div class="row"><div class="col-xs-12">';
		echo '<strong><em>'.$item['request'] . '</em></strong><br />';
		echo '<strong>'.$item['name'] . '</strong><br />';
		echo '<ul class="margin-left-10" style="list-style-type: upper-alpha;">';
		$trueAnswer = false;
		$trueAnswerIndex = false;
		foreach($itemAnswers as $index => $answer) {
			echo '<li>' . $answer['content'] . '</li>';
			if($answer['status'] == 1) {
				$trueAnswer 		= $answer;
				$trueAnswerIndex	=	$index;
			}
		}
		echo '</ul>';
		echo '<strong>Đáp án: </strong>' . $answerIndexes[$trueAnswerIndex].'<br />';
		echo $trueAnswer['recommend'];
		echo '</div></div></div>';
	}
	
	function edit_tn20PostAction() {
	
		$row = $this->getEditData();
	
		if(isset($row['content']) && isset($row['content_full'])){
				
			$question_answers	=	pzk_model('AdminQuestion');
				
			$question_answers->del_question_answers($row['id'], 'answers_question_tn');
				
			$data_answers = array(
					'question_id'	=>	$row['id'],
					'content'		=>	trim($row['content']),
					'content_full'	=>	trim($row['content_full']),
					'recommend'		=>	trim($row['recommend']),
                    'status'=>1
			);
				
			$status = $question_answers->check_question_answers($row['id']);
				
			if($status){
	
				$result = 	$question_answers->update_question_answers($data_answers, 'answers_question_tn');
			}else{
	
				$result	=	$question_answers->question_answers_add($data_answers);
			}
			if($result !=false){
					
				pzk_notifier()->addMessage('Cập nhật thành công');
				$this->redirect('detail/' . pzk_request('id'));
			}else{
					
				pzk_notifier()->addMessage('<div class="color_delete">Cập nhật không thành công !</div>');
				$this->redirect('detail/' . pzk_request('id'));
			}
		}
	}

	function getEditData() {
		
		return pzk_request()->getFilterData();
	}
	
	public function verifyAction() {
		$arr = array();
		$ids = pzk_request()->getIds();
		$rows = _db()->selectAll()->from($this->getTable())->inId($ids)->result();
		foreach ($rows as $row) {
			if(!$row['classes']) {
				$arr[] = array(
						'error'		=> true,
						'id'		=> $row['id'],
						'message'	=> 'Chưa phân lớp'
				);
			}
			if(!$row['check']) {
				$arr[] = array(
						'error'		=> true,
						'id'		=> $row['id'],
						'message'	=> 'Chưa kiểm duyệt'
				);
			}
			$answers = _db()->selectAll()->from('answers_question_tn')->whereQuestion_id($row['id'])->result();
			$trueAnswer = null;
			$trueAnswerIndex = -1;
			foreach($answers as $index => $answer) {
				if($answer['status'] == 1) {
					$trueAnswer 		= $answer;
					$trueAnswerIndex	=	$index;
				}
			}
			if($trueAnswer) {
				if(!$trueAnswer['recommend']) {
					$arr[] = array(
							'error'		=> true,
							'id'		=> $row['id'],
							'message'	=> 'Chưa có lý giải'
					);
				}
			} else {
				$arr[] = array(
						'error'		=> true,
						'id'		=> $row['id'],
						'message'	=> 'Chưa chọn đáp án đúng'
				);
			}
			
		}
		echo json_encode($arr);
	}
	
}