<?php
class PzkSGStoreFormatSerialize extends PzkSGStore {
	public function set($key, $value) {
		$value = serialize($value);
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = NULL) {
		return unserialize($this->storage->get($key, $timeout));
	}
}