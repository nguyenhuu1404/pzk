<?php 
class PzkEntityTableModel extends PzkEntityModel {
	public $table = false;
	public function setTable($table) {
		$this->table = $table;
		return $this;
	}
}