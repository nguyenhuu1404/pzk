<?php
class PzkSGStoreCluster extends PzkSGStore {
	public function set($key, $value, $tag = 'normal') {
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = null) {
		return $this->storage->get($key, $timeout);
	}
}