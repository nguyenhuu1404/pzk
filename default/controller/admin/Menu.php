<?php
class PzkAdminMenuController extends PzkGridAdminController {
    public $addFields = 'name, status, parent, admin_controller, software, thumbnail';
    public $editFields = 'name, status, parent, admin_controller, software, thumbnail';
    public $table = 'pzk_admin_menu';
    public $filterStatus = true;
    public $conditionSoftware = 1;

    public $sortFields = array(
        'id asc' => 'ID tăng',
        'id desc' => 'ID giảm',
        'name asc' => 'Name tăng',
        'name desc' => 'Name giảm',
    	'ordering asc' => 'Thứ tự tăng',
    	'ordering desc' => 'Thứ tự giảm',
    );
    public $searchFields = array('name');
    public $Searchlabels = 'Tên menu';

    public $listSettingType = 'parent';
    public $listFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'parent',
            'label' => 'Tên menu'
        ),

    		array(
    				'index' => 'ordering',
    				'type' => 'ordering',
    				'label' => 'Thứ tự'
    		),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        ),
        array(
            'index' => 'thumbnail',
            'type' => 'image',
            'label' => 'Thumbnail'
        ),
        array(
            'index' => 'shortcut',
            'type' => 'status',
            'label' => 'Home'
        )
    );
	public $logable = true;
	public $logFields = 'name, ordering, status';
    public $addLabel = 'Thêm menu';
    public $addFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên menu',
        ),

        array(
            'index' => 'parent',
            'type' => 'select',
            'label' => 'Menu cha',
            'table' => 'pzk_admin_menu',
            'show_value' => 'id',
            'show_name' => 'name'
        ),
        array(
            'index' => 'admin_controller',
            'type' => 'admin_controller',
            'label' => 'Tên controller'
        ),
        array(
            'index' => 'thumbnail',
            'type' => 'upload',
            'label' => 'Ảnh đại diện',
			'uploadtype'=>'image',
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        )
    );
    public $editFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên menu',
        ),

        array(
            'index' => 'parent',
            'type' => 'select',
            'label' => 'Menu cha',
            'table' => 'pzk_admin_menu',
            'show_value' => 'id',
            'show_name' =>'name'
        ),
        array(
            'index' => 'admin_controller',
            'type' => 'admin_controller',
            'label' => 'Tên controller'
        ),
        array(
            'index' => 'thumbnail',
            'type' => 'upload',
            'label' => 'Ảnh đại diện',
			'uploadtype'=>'image',
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        )
    );
    public $addValidator = array(
        'rules' => array(
            'name' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 50
            )

        ),
        'messages' => array(
            'name' => array(
                'required' => 'Tên menu không được để trống',
                'minlength' => 'Tên menu phải dài 2 ký tự trở lên',
                'maxlength' => 'Tên menu chỉ dài tối đa 50 ký tự'
            )

        )
    );
    public $editValidator = array(
        'rules' => array(
            'name' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 50
            )

        ),
        'messages' => array(
            'name' => array(
                'required' => 'Tên menu không được để trống',
                'minlength' => 'Tên menu phải dài 2 ký tự trở lên',
                'maxlength' => 'Tên menu chỉ dài tối đa 50 ký tự'
            )

        )
    );

}
?>