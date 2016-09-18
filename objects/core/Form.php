<?php
class PzkCoreForm extends PzkObject {
	public $layout = 'admin/form/form';
	public $method = 'post';
	public $action = '';
	public $rules = array();
	public $messages = array();
	public $fieldSettings = array();
	public $item = array();
	public $actions = array();
}