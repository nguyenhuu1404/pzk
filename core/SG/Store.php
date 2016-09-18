<?php
class PzkSGStore extends PzkSG{
	public $storage;
	public function __construct($storage) {
		$this->storage = $storage;
	}
	
	public function clear(){
		$this->storage->clear();
	}
	
	public function has($key) {
		return $this->storage->has($key);
	}
	public function del($key) {
		return $this->storage->del($key);
	}
	
	public function get($key, $timeout = null) {
		return $this->storage->get($key, $timeout);
	}
	public function set($key, $val) {
		return $this->storage->set($key, $val);
	}
}