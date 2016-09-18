<?php
class PzkAdminSiteLayoutController extends PzkGridAdminController {
    public $addFields = 'name, theme, software, sharedSoftwares, global';
    public $editFields = 'name, theme, software, sharedSoftwares, global';
    public $table = 'site_layout';
    public $filterStatus = true;
	public $logable = true;
	public $logFields = 'name, theme';
    public $sortFields = array(
        'id asc' => 'ID tăng',
        'id desc' => 'ID giảm',
        'name asc' => 'Tên tăng',
        'name desc' => 'Tên giảm',
    );
    public $searchFields = array('site_layout.name');
    public $Searchlabels = 'Tên Bố cục';
    public $listFieldSettings = array(
        array(
            'index' => 'theme',
            'type' => 'text',
            'label' => 'Giao diện'
        ),
		array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên trang'
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
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên trang web',
        ),
		array(
            'index' => 'theme',
            'type' => 'select',
            'label' => 'Giao diện',
			'table'			=> 'themes',
			'show_value'	=> 'name',
			'show_name'		=> 'name'
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
            'label' => 'Tên trang web',
        ),
		array(
            'index' => 'theme',
            'type' => 'select',
            'label' => 'Giao diện',
			'table'			=> 'themes',
			'show_value'	=> 'name',
			'show_name'		=> 'name'
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