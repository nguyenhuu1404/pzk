<?php
class pzkAdminRewriteController extends pzkGridAdminController {
    public $table = 'url_rewrite';
    public $listFieldSettings = array(
        array(
            'index' => 'alias',
            'type' => 'text',
            'label' => 'Alias'
        ),
        array(
            'index' => 'path',
            'type' => 'text',
            'label' => 'Path'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'status'
        )
    );
    public $searchFields = array('alias', 'path');
    public $Searchlabels = 'Alias, Path';
    //sort by
    public $sortFields = array(
        'id asc' => 'ID tăng',
        'id desc' => 'ID giảm',
		'alias asc' => 'Alias tăng',
        'alias desc' => 'Alias giảm',
        'path asc' => 'Path tăng',
        'path desc' => 'Path giảm',
    );
    //add table
    public $addFields = 'alias, path, status';
    public $addLabel = 'Thêm Rewrite';
    
    public $addFieldSettings = array(
        array(
            'index' => 'alias',
            'type' => 'text',
            'label' => 'Alias'
        ),
        array(
            'index' => 'path',
            'type' => 'text',
            'label' => 'Path'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái',
            'options' => array(
                '0' => 'Không hoạt động',
                '1' => 'Hoạt động'
            ),
            'actions' => array(
                '0' => 'mở',
                '1' => 'dừng'
            )
        )
    );
    public $editFields = 'alias, path, status';
    public $editFieldSettings = array(
        array(
            'index' => 'alias',
            'type' => 'text',
            'label' => 'Alias'
        ),
        array(
            'index' => 'path',
            'type' => 'text',
            'label' => 'Path'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái',
            'options' => array(
                '0' => 'Không hoạt động',
                '1' => 'Hoạt động'
            ),
            'actions' => array(
                '0' => 'mở',
                '1' => 'dừng'
            )
        )
    );
}
