<?php
class PzkCoreDatabaseSchema extends PzkObjectLightWeight {
	public $options = array();
	public function create($table) {
		$this->options['action'] = 'create';
		$this->options['table'] = $table;
		return $this;
	}
	public function select($table) {
		$this->options['action'] = 'select';
		$this->options['table'] = $table;
		return $this;
	}
	public function addField($field) {
		if(isset($this->options['action']) && $this->options['action'] == 'select') {
			$sql = 'ALTER TABLE `'.$this->options['table'].'` ADD ' . $field;
			$this->addCommand($sql);
		} else {
			if(!isset($this->options['fields'])) $this->options['fields'] = array();
			$this->options['fields'][] = $field;
		}
		
		return $this;
	}
	public function addVarchar($name, $length = 255) {
		$str = '`'.$name.'` varchar('.$length.') NOT NULL';
		$this->addField($str);
		return $this;
	}
	public function addTinyint($name){
		$str = '`'.$name.'` tinyint NOT NULL';
		$this->addField($str);
		return $this;
	}
	
	public function addInt($name) {
		$str = '`'.$name.'` int NOT NULL';
		$this->addField($str);
		return $this;
	}
    public function addTime($name) {
        $str = '`'.$name.'` time NOT NULL';
        $this->addField($str);
        return $this;
    }
	public function addFloat($name) {
		$str = '`'.$name.'` float NOT NULL';
		$this->addField($str);
		return $this;
	}
	public function addDate($name) {
		$str = '`'.$name.'` date NOT NULL';
		$this->addField($str);
		return $this;
	}
	public function addDatetime($name) {
		$str = '`'.$name.'` datetime NOT NULL';
		$this->addField($str);
		return $this;
	}
	public function addText($name) {
		$str = '`'.$name.'` text NOT NULL';
		$this->addField($str);
		return $this;
	}
	public function addDouble($name) {
		$str = '`'.$name.'` double NOT NULL';
		$this->addField($str);
		return $this;
	}
	public function drop($field) {
		$sql = 'ALTER TABLE `'.$this->options['table'].'` DROP `'.$field.'`';
		$this->addCommand($sql);
		return $this;
	}
	public function change($field, $newField, $type, $length = NULL) {
		$sql = 'ALTER TABLE `'.$this->options['table'].'` CHANGE `'.$field.'` `'.$newField.'` '.$type . ($length?'('.$length.')':'').' NOT NULL';
		$this->addCommand($sql);
		return $this;
	}
	public function changeInt($field) {
		return $this->change($field, $field, 'int');
	}
	public function changeText($field) {
		return $this->change($field, $field, 'text');
	}
	public function changeDate($field) {
		return $this->change($field, $field, 'date');
	}
	public function changeDatetime($field) {
		return $this->change($field, $field, 'datetime');
	}
	public function changeDouble($field) {
		return $this->change($field, $field, 'double');
	}
	public function changeVarchar($field, $length = '255') {
		return $this->change($field, $field, 'varchar', $length);
	}
	public function rename($field, $newField) {
		$sql = 'ALTER TABLE '.$this->options['table'].' RENAME `'.$field.'` to `'.$newField.'`';
		return $this->addCommand($sql);
	}
	public function addCommand($command) {
		if(!isset($this->options['commands'])) $this->options['commands'] = array();
		$this->options['commands'][] = $command;
		return $this;
	}
	public function execute() {
		if($this->options['action'] == 'create') {
			$sql = 'CREATE TABLE IF NOT EXISTS `'.$this->options['table'].'` (
  `id` int(11) NOT NULL AUTO_INCREMENT,';
			if(isset($this->options['fields']) && $this->options['fields'])
			foreach($this->options['fields'] as $field) {
				$sql .= $field . ',';
			}
			$sql .= 'PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
			_db()->query($sql);
		} else if($this->options['action'] == 'select') {
			if(isset($this->options['commands']) && $this->options['commands'])
			foreach($this->options['commands'] as $command) {
				_db()->query($command);
			}
		}
	}
	public function clear() {
		$this->options = array();
		return $this;
	}
	public function getVersion($table) {
		$row = _db()->select('*')->from('schema_version')->whereSchema_table($table)->result_one();
		return isset($row['schema_version'])?$row['schema_version']: null;
	}
	public function commitVersion($table, $version) {
		$row = _db()->select('*')->from('schema_version')->whereSchema_table($table)->result_one();
		if($row) {
			_db()->update('schema_version')->set(array('schema_version' => $version))->whereId($row['id'])->result();
		} else {
			_db()->insert('schema_version')->fields('schema_table,schema_version')
				->values(array(array('schema_table' => $table, 'schema_version' => $version)))->result();
		}
	}
	public function menu($controller, $name, $parent = 0) {
		$row = _db()->from('admin_menu')->whereAdmin_controller('admin_' . strtolower($controller))->result_one();
		if(!$row) {
			_db()->insert('admin_menu')
				->fields('admin_controller,name,status,parent')
				->values(array(array(
					'admin_controller' => 'admin_' . strtolower($controller), 
					'name' => $name,
					'status' => 1,
					'parent' => $parent
				)))->result();
		}
	}
}

function _dbs() {
	return pzk_element('db_schema')->clear();
}