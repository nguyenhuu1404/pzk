<?php
class PzkDefaultAdminLogController extends PzkGridAdminController {
	public $table = 'pzk_admin_log';
	public $sortFields = array(
		'id asc' => 'ID tăng',
		'id desc' => 'ID giảm',
		'userId asc' => 'UserId tăng',
		'userId desc' => 'UserId giảm',
	);
	
	public $filterFields = array(
			array(
					'index' => 'userId',
					'type' => 'select',
					'label' => 'Người thay đổi',
					'table' => 'admin',
					'show_value' => 'id',
					'show_name' => 'name',
			),
			array(
					'index'=>'admin_controller',
					'type' => 'select',
					'label' => 'Menu',
					'table' => 'admin_menu',
					'show_value' => 'admin_controller',
					'show_name' => 'name'
			)
	);
	
	public $listFieldSettings = array(
        array(
            'index' => 'userId',
            'type' => 'text',
            'label' => 'Mã người dùng'
        ),

		array(
            'index' => 'admin_controller',
            'type' => 'text',
            'label' => 'Mục'
        ),
		array(
            'index' => 'actionType',
            'type' => 'text',
            'label' => 'Hành động'
        ),
		array(
            'index' => 'brief',
            'type' => 'text',
            'label' => 'Mô tả'
        ),
		array(
            'index' => 'created',
            'type' => 'text',
            'label' => 'Ngày'
        )
		
		

	);
	
}
	
?>