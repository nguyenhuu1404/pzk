<?php
class PzkSGStoreFormatJson extends PzkSGStoreFormat {
	public function set($key, $value) {
		$value = json_encode($value);
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = NULL) {
		return json_decode($this->storage->get($key, $timeout), true);
	}
}