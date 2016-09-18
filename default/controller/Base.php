<?php
class PzkBaseController extends PzkController {
	public $masterStructure = 'demo';
	public $masterPosition = 'left';
	public $grid = false;
	public function indexAction() {
		$this->viewGrid($this->grid);
	}
}