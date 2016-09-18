<?php
class PzkObjectLightWeightSG extends PzkSG {
	public function __construct($attrs) {
		foreach($attrs as $key => $value) $this->$key = $value;
		$this->children = array();
		if (!isset($this->id)) {
			$this->id = 'uniqueId' . PzkObject::$maxId;
			PzkObject::$maxId++;
		}
	}
	
	public function init() {
	}
	
	public function finish() {
	}
	
	public function display() {
		foreach($this->children as $child) {
			$child->display();
		}
	}
	
	/**
	 *	Append mot child object 
	 */
	public function append($obj) {
		$obj->pzkParentId = isset($this->id) ? $this->id : null;
		$this->children[] = $obj;
	}
}