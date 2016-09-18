<?php
class PzkAdminControllerController extends PzkGridAdminController {
	public $table = 'site_controller';
	public $addFields = 'name,table,joins, selectFields, listSettingType, listFieldSettings, filterFields, searchLabels, searchFields, sortFields, addFields, addLabel, addFieldSettings, addValidator, editFields, editFieldSettings, editValidator, menuLinks, moduleDetail, filterCreator, childTables';
	public $editFields = 'name,table,joins, selectFields, listSettingType, listFieldSettings, filterFields, searchLabels, searchFields, sortFields, addFields, addLabel, addFieldSettings, addValidator, editFields, editFieldSettings, editValidator, menuLinks, moduleDetail, filterCreator, childTables';
	public $sortFields = array(
		'id asc' => 'ID tăng',
		'id desc' => 'ID giảm',
		'name asc' => 'Tên tăng',
		'name desc' => 'Tên giảm'
	);
	public $listFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tiêu đề'
        ),
		array(
            'index' => 'table',
            'type' => 'text',
            'label' => 'Bảng'
        )
	);
    public $addLabel = 'Thêm controller';
    public $addFieldSettings = array(
		array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên Controller',
        ),
		array(
            'index' => 'table',
            'type' => 'text',
            'label' => 'Bảng'
        ),
		array(
            'index' => 'joins',
            'type' => 'json',
            'label' => 'Nối bảng'
        ),
        array(
            'index' => 'selectFields',
            'type' => 'text',
            'label' => 'Các trường cần chọn'
        ),
		
        array(
            'index' => 'listSettingType',
            'type' => 'text',
            'label' => 'Hiển thị kiểu cây'
        ),
		array(
            'index' => 'listFieldSettings',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Các trường cần hiển thị'
        ),
		array(
            'index' => 'filterFields',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Các trường cần lọc'
        ),
		array(
            'index' => 'searchLabels',
            'type' => 'text',
            'label' => 'Nhãn tìm kiếm'
        ),
		array(
            'index' => 'searchFields',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Các trường cần tìm kiếm'
        ),
		array(
            'index' => 'sortFields',
            'type' => 'json',
			'isArray' => false,
            'label' => 'Các trường cần sắp xếp'
        ),
		array(
            'index' => 'addFields',
            'type' => 'text',
            'label' => 'Các trường thêm bản ghi'
        ),
		array(
            'index' => 'addLabel',
            'type' => 'text',
            'label' => 'Nhãn nút thêm'
        ),
		array(
            'index' => 'addFieldSettings',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Cấu hình các trường form thêm'
        ),
		array(
            'index' => 'addValidator',
            'type' => 'json',
			'isArray' => false,
            'label' => 'Cấu hình add validator'
        ),
		array(
            'index' => 'editFields',
            'type' => 'text',
            'label' => 'Các trường sửa bản ghi'
        ),
		array(
            'index' => 'editFieldSettings',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Cấu hình các trường form sửa'
        ),
		array(
            'index' => 'editValidator',
            'type' => 'json',
			'isArray' => false,
            'label' => 'Cấu hình edit validator'
        ),
		array(
            'index' => 'menuLinks',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Danh sách các menu'
        ),
		array(
            'index' => 'moduleDetail',
            'type' => 'text',
            'label' => 'Module chi tiết'
        ),
		array(
            'index' => 'filterCreator',
            'type' => 'status',
            'label' => 'Chỉ hiện người tạo'
        ),
		array(
            'index' => 'childTables',
            'type' => 'text',
            'label' => 'Các bảng con'
        ),
    );
    public $editFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên Controller',
        ),
		array(
            'index' => 'table',
            'type' => 'text',
            'label' => 'Bảng'
        ),
		array(
            'index' => 'joins',
            'type' => 'json',
            'label' => 'Nối bảng'
        ),
        array(
            'index' => 'selectFields',
            'type' => 'text',
            'label' => 'Các trường cần chọn'
        ),
		
        array(
            'index' => 'listSettingType',
            'type' => 'text',
            'label' => 'Hiển thị kiểu cây'
        ),
		array(
            'index' => 'listFieldSettings',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Các trường cần hiển thị'
        ),
		array(
            'index' => 'filterFields',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Các trường cần lọc'
        ),
		array(
            'index' => 'searchLabels',
            'type' => 'text',
            'label' => 'Nhãn tìm kiếm'
        ),
		array(
            'index' => 'searchFields',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Các trường cần tìm kiếm'
        ),
		array(
            'index' => 'sortFields',
            'type' => 'json',
			'isArray' => false,
            'label' => 'Các trường cần sắp xếp'
        ),
		array(
            'index' => 'addFields',
            'type' => 'text',
            'label' => 'Các trường thêm bản ghi'
        ),
		array(
            'index' => 'addLabel',
            'type' => 'text',
            'label' => 'Nhãn nút thêm'
        ),
		array(
            'index' => 'addFieldSettings',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Cấu hình các trường form thêm'
        ),
		array(
            'index' => 'addValidator',
            'type' => 'json',
			'isArray' => false,
            'label' => 'Cấu hình add validator'
        ),
		array(
            'index' => 'editFields',
            'type' => 'text',
            'label' => 'Các trường sửa bản ghi'
        ),
		array(
            'index' => 'editFieldSettings',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Cấu hình các trường form sửa'
        ),
		array(
            'index' => 'editValidator',
            'type' => 'json',
			'isArray' => false,
            'label' => 'Cấu hình edit validator'
        ),
		array(
            'index' => 'menuLinks',
            'type' => 'json',
			'isArray' => true,
            'label' => 'Danh sách các menu'
        ),
		array(
            'index' => 'moduleDetail',
            'type' => 'text',
            'label' => 'Module chi tiết'
        ),
		array(
            'index' => 'filterCreator',
            'type' => 'status',
            'label' => 'Chỉ hiện người tạo'
        ),
		array(
            'index' => 'childTables',
            'type' => 'text',
            'label' => 'Các bảng con'
        )
    );
}