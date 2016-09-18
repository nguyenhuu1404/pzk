<?php
pzk_import('core.db.List');
class PzkSiteControllerlayoutModuleSamples extends PzkCoreDbList {
	public $table = 'site_module';
	public $layout = 'admin/site/controllerlayout/module/samples';
	public $conditions = '["and", ["module_controller", ""], ["module_action", ""], ["status", "1"]]';
	public $orderBy = 'ordering asc';
}