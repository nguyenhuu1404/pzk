<?php
//[Add level]
class PzkAdminAdminlevelController extends PzkGridAdminController {
    public $addFields = 'level, status';
    public $editFields = 'level, status';
    public $table = 'pzk_admin_level';
    public $childTable = array(
        array(
            'table' => 'pzk_admin_level_action',
            'findField' => 'admin_level_id'
        )
    );
    public function getSortFields() {
		return PzkSortConstant::gets('id, level', 'admin_level');
	}
    public $searchFields = array('level');
    public function getListFieldSettings () {
		return PzkListConstant::gets('level, status', 'admin_level');
	}

    public $logable = true;
    public $logFields = 'level, status';
    public $addLabel = 'Thêm nhóm người dùng';
	
	public function getAddFieldSettings() { 
		return PzkEditConstant::gets('level[mdsize=3], status[mdsize=3]', 'admin_level');
	}
    public function getEditFieldSettings() { 
		return PzkEditConstant::gets('level[mdsize=3], status[mdsize=3]', 'admin_level');
	}
    public function getAddValidator() {
		return PzkValidatorConstant::gets(
			array(
				'level' => array(
					'required' => true, 'minlength' => 2, 'maxlength' => 500
				)
			)
		);
	}
    
    public function getEditValidator() {
		return PzkValidatorConstant::gets(
			array(
				'level' => array(
					'required' => true, 'minlength' => 2, 'maxlength' => 500
				)
			)
		);
	}
	

}