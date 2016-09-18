<?php
class PzkAdminSiteModuleController extends PzkGridAdminController {
    public $addFields = 'name, code, module_theme, module_layout, module_controller, module_action, position, software, sharedSoftwares, global, image';
    public $editFields = 'name, code, module_theme, module_layout, module_controller, module_action, position, software, sharedSoftwares, global, image';
    public $table = 'site_module';
    public $filterStatus = true;
	public $logable = true;
	public $logFields = 'name, code, module_theme, module_layout, module_controller, module_action, position, image';
    public $sortFields = array(
        'id asc' => 'ID tăng',
        'id desc' => 'ID giảm',
        'name asc' => 'Tên tăng',
        'name desc' => 'Tên giảm',
    );
    public $searchFields = array('name');
    public $Searchlabels = 'Tên Module';
    public $listFieldSettings = array(
        array(
            'index' => 'image',
            'type' => 'image',
            'label' => 'Ảnh'
        ),
		array(
            'index' => 'module_theme',
            'type' => 'text',
            'label' => 'Theme'
        ),
		array(
            'index' => 'module_controller',
            'type' => 'text',
            'label' => 'Controller'
        ),
		array(
            'index' => 'module_action',
            'type' => 'text',
            'label' => 'Action'
        ),
		array(
            'index' => 'module_layout',
            'type' => 'text',
            'label' => 'Bố cục'
        ),
		array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên module'
        ),
		array(
            'index' => 'position',
            'type' => 'text',
            'label' => 'Vị trí'
        ),
		array(
            'index' => 'ordering',
            'type' => 'text',
            'label' => 'Thứ tự'
        ),
		
		array(
            'index' => 'created',
            'type' => 'datetime',
			'format' => 'd/m/Y H:i',
            'label' => 'Ngày tạo'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        ),
    );
	
    public $addLabel = 'Thêm Bố cục';
    public $addFieldSettings = array(
        array(
            'index' => 'image',
            'type' => 'filemanager',
            'uploadtype'=>'image',
            'label' => 'Ảnh'
        ),
		array(
            'index' => 'module_theme',
            'type' => 'select',
            'label' => 'Theme',
			'table'	=> 'themes',
			'show_name'	=> 'name',
			'show_value'	=> 'name'
        ),
		array(
            'index' => 'module_controller',
            'type' => 'text',
            'label' => 'Controller'
        ),
		array(
            'index' => 'module_action',
            'type' => 'text',
            'label' => 'Action'
        ),
		array(
            'index' => 'module_layout',
            'type' => 'select',
            'label' => 'Bố cục',
			'table'	=> 'site_layout',
			'show_name'	=> 'name',
			'show_value'	=> 'name'
        ),
		array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Module'
        ),
		array(
            'index' => 'code',
            'type' => 'textarea',
            'label' => 'Code'
        ),
		array(
            'index' => 'position',
            'type' => 'text',
            'label' => 'Vị trí'
        ),
    );
    public $editFieldSettings = array(
        array(
            'index' => 'image',
            'type' => 'filemanager',
            'uploadtype'=>'image',
            'label' => 'Ảnh'
        ),
		array(
            'index' => 'module_theme',
            'type' => 'select',
            'label' => 'Theme',
			'table'	=> 'themes',
			'show_name'	=> 'name',
			'show_value'	=> 'name'
        ),
		array(
            'index' => 'module_controller',
            'type' => 'text',
            'label' => 'Controller'
        ),
		array(
            'index' => 'module_action',
            'type' => 'text',
            'label' => 'Action'
        ),
		array(
            'index' => 'module_layout',
            'type' => 'select',
            'label' => 'Bố cục',
			'table'	=> 'site_layout',
			'show_name'	=> 'name',
			'show_value'	=> 'name'
        ),
		array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Module'
        ),
		array(
            'index' => 'code',
            'type' => 'textarea',
            'label' => 'Code'
        ),
		array(
            'index' => 'position',
            'type' => 'text',
            'label' => 'Vị trí'
        ),
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