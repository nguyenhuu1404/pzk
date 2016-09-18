<?php
class PzkSGStoreDriverPhp extends PzkSGStore {
	public function __construct() {
		$this->storage = array();
	}
	
	public function set($key, $value) {
		$this->storage[$key] = $value;
	}
	
	public function get($key, $timeout = NULL) {
		return isset($this->storage[$key])?$this->storage[$key]: null;
	}
	
	public function has($key) {
		return isset($this->storage[$key]);
	}
	
	public function del($key) {
		unset($this->storage[$key]);
	}
	
	public function clear(){
		$this->storage = array();
	}
}