<?php
class PzkAdminSchemaController extends PzkGridAdminController {
    public $table = 'schema_version';
	public $listFieldSettings = array(
        array(
            'index' => 'schema_table',
            'type' => 'text',
            'label' => 'Bảng'
        ),
        array(
            'index' => 'schema_version',
            'type' => 'text',
            'label' => 'Phiên bản'
        )
    );
	//search fields co type la text
    public $searchFields = array('schema_table');
    public $Searchlabels = 'Bảng';
	public $sortFields = array(
        'schema_table asc' => 'Tên bảng tăng',
        'schema_table desc' => 'Tên bảng giảm',
    );
	public $menuLinks = array(
        array(
            'name' => 'Cài đặt',
            'href' => '/install.php'
        )
    );
}