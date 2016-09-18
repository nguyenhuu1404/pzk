<?php
class PzkSGStorePrefix extends PzkSGStore {
	public function set($key, $value) {
		$key = $this->getPrefix(). ucfirst($key);
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = null) {
		$key = $this->getPrefix(). ucfirst($key);
		return $this->storage->get($key, $timeout);
	}
	public function del($key) {
		$key = $this->getPrefix(). ucfirst($key);
		return $this->storage->del($key);
	}
	public $prefix = '';
	public function getPrefix() {
		return $this->prefix;
	}
	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}
}