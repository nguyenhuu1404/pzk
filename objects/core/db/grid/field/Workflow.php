<?php
class PzkCoreDbGridFieldWorkflow extends PzkObject {
	public $layout = 'admin/grid/field/workflow';
	public $rules = array();
	public $states = array();
	public function getRules() {
		if(isset($this->rules[$this->value])) return ($this->rules[$this->value]);
		return array();
	}
	public function getState() {
		if(isset($this->states[$this->value])) return ($this->states[$this->value]);
		return '';
	}
}