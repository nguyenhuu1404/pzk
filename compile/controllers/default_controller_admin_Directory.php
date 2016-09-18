<?php
class PzkDefaultAdminDirectoryController extends PzkBackendController {
	public function indexAction() {
		$directory = $this->parse('admin/directory/index');
		$directory->setParentId(pzk_request()->getSegment(3));
		$this->render($directory);
	}
}