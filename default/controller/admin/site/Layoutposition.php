<?php
class PzkAdminSiteLayoutpositionController extends PzkGridAdminController {
    public $addFields = 'layout, theme, position, software, sharedSoftwares, global';
    public $editFields = 'layout, theme, position, software, sharedSoftwares, global';
    public $table = 'site_layout_position';
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
            'index' => 'layout',
            'type' => 'text',
            'label' => 'Layout'
        ),
		array(
            'index' => 'position',
            'type' => 'text',
            'label' => 'Position'
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
	
    public $addLabel = 'Thêm Position';
    public $addFieldSettings = array(
        
		array(
            'index' => 'theme',
            'type' => 'select',
            'label' => 'Giao diện',
			'table'			=> 'themes',
			'show_value'	=> 'name',
			'show_name'		=> 'name'
        ),
		array(
            'index' => 'layout',
            'type' => 'text',
            'label' => 'Layout',
        ),
		array(
            'index' => 'position',
            'type' => 'text',
            'label' => 'Position',
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        )
    );
    public $editFieldSettings = array(
        array(
            'index' => 'theme',
            'type' => 'select',
            'label' => 'Giao diện',
			'table'			=> 'themes',
			'show_value'	=> 'name',
			'show_name'		=> 'name'
        ),
		array(
            'index' => 'layout',
            'type' => 'text',
            'label' => 'Layout',
        ),
		array(
            'index' => 'position',
            'type' => 'text',
            'label' => 'Position',
        ),
		array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        )
    );
    public $addValidator = array(
        'rules' => array(
            'position' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 50
            )

        ),
        'messages' => array(
            'position' => array(
                'required' => 'Tên position không được để trống',
                'minlength' => 'Tên position phải dài 2 ký tự trở lên',
                'maxlength' => 'Tên position chỉ dài tối đa 50 ký tự'
            )

        )
    );
    public $editValidator = array(
        'rules' => array(
            'position' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 50
            )

        ),
        'messages' => array(
            'position' => array(
                'required' => 'Tên position không được để trống',
                'minlength' => 'Tên position phải dài 2 ký tự trở lên',
                'maxlength' => 'Tên position chỉ dài tối đa 50 ký tự'
            )

        )
    );

}
?>