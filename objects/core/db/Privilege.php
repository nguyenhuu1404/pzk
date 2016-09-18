<?php
class PzkCoreDbPrivilege extends PzkObject {
	public $layout = 'admin/privilege/index';
	
	public function getRoles()	{
		return _db()->selectAll()->fromPzk_Admin_level()->whereStatus(1)->result();
	}
	
	public function	getPrivileges()	{
		return array('index', 'add', 'edit', 'del', 'details');
	}
	
	public function getMenus()	{
		$items = _db()->selectAll()->fromPzk_Admin_menu()->whereStatus(1)->result();
		return $items;
	}
	public function getAllAdminLevelAction(){
		$data = _db()->selectAll()->fromPzk_Admin_level_action()->whereStatus(1)->result();
		return $data;
	}
}