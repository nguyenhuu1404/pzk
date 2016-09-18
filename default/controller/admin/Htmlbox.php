<?php
class PzkAdminHtmlboxController extends PzkGridAdminController {
	public $title = 'Html box';
	public $table = 'htmlbox';
	public function getJoins() {
		return PzkJoinConstant::gets('creator, modifier', 'htmlbox');
	}
	
	public $selectFields = 'htmlbox.*, creator.name as creatorName, modifier.name as modifiedName';
	public $searchFields = array('name', 'content');
	
	public function getSortFields() {
		return PzkSortConstant::gets('id, name, created, ordering', 'htmlbox');
	}
	
	public function getListFieldSettings() { 
		return array(
			PzkListConstant::get('name', 'htmlbox'),
			PzkListConstant::get('contentText', 'htmlbox'),
			PzkListConstant::get('position', 'htmlbox'),
			PzkListConstant::get('width', 'htmlbox'),
			PzkListConstant::get('height', 'htmlbox'),
			PzkListConstant::get('showname', 'htmlbox'),
			PzkListConstant::get('status', 'htmlbox'),
			PzkListConstant::group('<br />Người tạo<br />Người sửa',
				'creatorName, modifiedName', 'htmlbox'
			),
			PzkListConstant::group('<br />Ngày tạo<br />Ngày sửa',
				'created, modified', 'htmlbox'
			)
		);
	}
	
	public $addFields = 'name, position,width, height,content';
	public $editFields = 'name, position,width, height,content';
	public $logable = true;
	public $logFields = 'name,width,height,position';
	
	
	
	public function getViewFieldSettings() { 
		return array(
			PzkListConstant::get('name', 'htmlbox'),
			PzkListConstant::get('contentText', 'htmlbox'),
			PzkListConstant::get('position', 'htmlbox'),
			PzkListConstant::get('width', 'htmlbox'),
			PzkListConstant::get('height', 'htmlbox'),
			PzkListConstant::get('shownameText', 'htmlbox'),
			PzkListConstant::get('statusText', 'htmlbox'),			
			PzkListConstant::get('creatorName', 'htmlbox'),
			PzkListConstant::get('modifiedName', 'htmlbox'),
			PzkListConstant::get('created', 'htmlbox'),
			PzkListConstant::get('modified', 'htmlbox'),
		);
	}
	public function getParentDetailSettings() { 
		return array(
			PzkParentConstant::get('creator', 'featured'),
			PzkParentConstant::get('modifier', 'featured'),
		);
	}
    public $addLabel = 'Thêm HTML Box';
    public function getAddFieldSettings() { 
		return PzkEditConstant::gets('name[mdsize=4], position[mdsize=2], width[mdsize=2], height[mdsize=2], status[mdsize=2], content', 'htmlbox');
	}
    public function getEditFieldSettings() { 
		return PzkEditConstant::gets('name[mdsize=4], position[mdsize=2], width[mdsize=2], height[mdsize=2], status[mdsize=2], content', 'htmlbox');
	}
	public function getAddValidator() {
		return PzkValidatorConstant::gets(
			array(
				'name' => array(
					'required' => true, 'minlength' => 2, 'maxlength' => 500
				),
				'content' => array(
					'required' => true, 'minlength' => 2, 'maxlength' => 5000
				),
			)
		);
	}
    
    public function getEditValidator() {
		return PzkValidatorConstant::gets(
			array(
				'name' => array(
					'required' => true, 'minlength' => 2, 'maxlength' => 500
				),
				'content' => array(
					'required' => true, 'minlength' => 2, 'maxlength' => 5000
				),
			)
		);
	}
}